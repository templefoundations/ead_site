<?php

class Ii_course_registration extends Controller
{
	function __construct()
	{
		parent::Controller();
		$session_user = $this->session->userdata('user_id');
		if (empty($session_user))
		{
			redirect(site_url('login'));
		}
		$this->load->library('recaptcha');
	}
	
	function index()
	{
		$data = array(
			'title' 	=> 'Course',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
				$this->config->item('jquery_path').'css/smoothness/jquery-ui.css',
			),
			'js_list'	=> array(
				$this->config->item('jquery_path').'jquery.tools.min.js',
				$this->config->item('jquery_path').'jquery-ui.min.js',
			),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
			
		$form_data = array(
			'courses'		=> $this->get_possible_courses(),
			'file_error' 	=> '',
			'recaptcha_error' => '',
		);
		$this->load->view('ii_course_reg_form', $form_data);
		$this->load->view('footer');
	}
	
	function submit()
	{
		$data = array(
			'title' 	=> 'Course',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
				$this->config->item('jquery_path').'css/smoothness/jquery-ui.css',
			),
			'js_list'	=> array(
				$this->config->item('jquery_path').'jquery.tools.min.js',
				$this->config->item('jquery_path').'jquery-ui.min.js',
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$config['upload_path'] = $this->config->item('appln_forms_path');
		$config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png|bmp';
		$config['file_name'] = 'AF.pdf';
		$this->load->library('upload', $config);
		
		$this->form_validation->set_rules('course_id', 'Course', 'required');
		$this->form_validation->set_rules('desc', 'Description', '');
		$this->form_validation->set_rules('opening_date', 'Opening date', '');
		$this->form_validation->set_rules('closing_date', 'Closing date', '');
		$this->form_validation->set_rules('price', 'Application form Price', 'required|numeric');
		
		// recaptcha validation
		$recaptcha_resp = $this->recaptcha->recaptcha_check_answer(
			$this->config->item('recaptcha_private_key'),
			$_SERVER['REMOTE_ADDR'],
			$this->input->post('recaptcha_challenge_field'),
			$this->input->post('recaptcha_response_field')
		);
		
		$result = true;
		$result = $this->form_validation->run() && $result;
		$result = $this->upload->do_upload('form_file') && $result;
		$result = $recaptcha_resp->is_valid && $result;
		
		if (!$result)
		{
			$this->load->library('course');
			$form_data = array(
				'courses'=>$this->get_possible_courses(),
				'file_error' => $this->upload->display_errors('<div class="error">', '</div>'),
				'recaptcha_error' => $recaptcha_resp->error,
			);
			$this->load->view('html_head',$data);
			$this->load->view('header');
			$this->load->view('ii_course_reg_form', $form_data);
			$this->load->view('footer');
		}
		else
		{
			$this->insert_into_db();
			redirect(site_url('ii_home'));
		}
	}
	
	private function insert_into_db()
	{
		$this->load->model('file_model');
		$this->load->model('registered_course_model');
		$this->load->model('application_form_model');
		
		$file_data = $this->upload->data();
		$file_data['blob_data'] = $this->upload->get_blob_data('form_file');
		$file_data['file_id'] = $this->file_model->insert_into_db($file_data);
		
		$rcrs_data = array();
		$rcrs_data['user_id'] = $this->session->userdata('user_id');
		$rcrs_data['course_id'] = $this->input->post('course_id');
		$rcrs_data['desc'] = $this->input->post('desc');
		$rcrs_data['registered_course_id'] = $this->registered_course_model->insert_into_db($rcrs_data);
		
		$appln_data = array();
		$appln_data['registered_course_id'] = $rcrs_data['registered_course_id'];
		$appln_data['form_file_id'] = $file_data['file_id'];
		$appln_data['valid_flag'] = '0';
		$appln_data['price'] = $this->input->post('price');
		$appln_data['opening_date'] = $this->input->post('opening_date');
		$appln_data['closing_date'] = $this->input->post('closing_date');
		$appln_data['application_form_id'] = $this->application_form_model->insert_into_db($appln_data);
		
		$appln_update_data['form_def_tbl_name'] = $this->config->item('form_def_tbl_prefix').$appln_data['application_form_id'];
		$appln_update_data['form_candidates_tbl_name'] = $this->config->item('form_candidates_tbl_prefix').$appln_data['application_form_id'];
		$this->application_form_model->update_db($appln_update_data, $appln_data['application_form_id']);
		
		$rcrs_update_data['current_application_form_id'] = $appln_data['application_form_id'];
		$this->registered_course_model->update_db($rcrs_update_data,$rcrs_data['registered_course_id']);
	}
	
	private function get_possible_courses()
	{
		$this->load->library('course');
		// get the registered course ids
		$session_user_id = $this->session->userdata('user_id');
		$this->load->database();
		
		$this->db->select('course_id')->from('tbl_registered_course');
		$this->db->where('user_id', $session_user_id);
		$query = $this->db->get();
		$reg_course_ids = array();
		foreach ($query->result() as $row)
		{
			$reg_course_ids[] = $row->course_id;
		}
		
		$this->db->select('tbl_course.course_id')->from('tbl_course');
		$this->db->join('tbl_inst_course', 'tbl_course.course_id=tbl_inst_course.course_id');
		$this->db->where('inst_id', $this->session->userdata('inst_id'));
		$this->db->where_not_in('tbl_course.course_id', $reg_course_ids);
		$query = $this->db->get();
		$possible_courses = array();
		foreach ($query->result() as $row)
		{
			$possible_courses[] = new Course(array('course_id' => $row->course_id));
		}
		return $possible_courses;
	}
	
}
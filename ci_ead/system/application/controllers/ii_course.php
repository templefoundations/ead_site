<?php

class Ii_course extends Controller
{
	private static $PER_PAGE = 10;
	
	function __construct()
	{
		parent::Controller();
		$session_user = $this->session->userdata('user_id');
		if (empty($session_user))
		{
			redirect(site_url('login'));
		}
	}
	
	function index($reg_course_id, $offset=0)
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
		
		$this->load->library('Registered_course');
		$reg_course = new Registered_course(array('reg_course_id'=>$reg_course_id));
		
		$filtered_result = $this->compute_activity_result($reg_course, $offset);
		$course_view_data = array(
			'reg_course_id'	=> $reg_course_id,
			'course_name'	=> $reg_course->get_course()->get_name(),
			'total_candidates'	=> $reg_course->applied_candidates_count(),
			'total_result'	=>count($filtered_result),
			'data'			=>$filtered_result
		);

		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('ii_course/index/'.$reg_course_id);
		$config['total_rows'] = $course_view_data['total_result'];		
		$config['per_page'] = self::$PER_PAGE;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		
		$this->load->view('ii_course_view', $course_view_data);
		
		$this->load->view('footer');
	}
	
	function filter($reg_course_id, $offset=0)
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
		
		$this->load->library('Registered_course');
		$reg_course = new Registered_course(array('reg_course_id'=>$reg_course_id));
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('applied_date_from', '', '');
		$this->form_validation->set_rules('applied_date_to', '', '');
		$this->form_validation->set_rules('age_from', '', '');
		$this->form_validation->set_rules('age_to', '', '');
		$this->form_validation->set_rules('location', '', '');
		$this->form_validation->run();
		
		$filters = array();
		$applied_date_from = $this->input->post('applied_date_from');
		$applied_date_to = $this->input->post('applied_date_to');
		$age_from = $this->input->post('age_from');
		$age_to = $this->input->post('age_to');
		$location = $this->input->post('location');
		if (empty($applied_date_to))
		{
			$applied_date_to = date('Y-m-d', time());
		}
		
		if (!empty($applied_date_from) && !empty($applied_date_to))
		{
			$filters[] = 'applied_date BETWEEN \''.$applied_date_from.'\' AND \''.$applied_date_to.'\'';
		}
		if (!empty($age_from))
		{
			$filters[] = 'DATEDIFF(SYSDATE(),date_of_birth) >= ('.$age_from.'*365)';
		}
		if (!empty($age_to))
		{
			$filters[] = 'DATEDIFF(SYSDATE(),date_of_birth) <= ('.$age_to.'*365)';
		}
		if (!empty($location))
		{
			$filters[] = 'location = \''.$location.'\'';
		}
		
		$filtered_result = $this->compute_activity_result($reg_course, $offset, $filters);
		$course_view_data = array(
			'reg_course_id'	=> $reg_course_id,
			'course_name'	=> $reg_course->get_course()->get_name(),
			'total_candidates'	=> $reg_course->applied_candidates_count(),
			'total_result'	=>count($filtered_result),
			'data'			=>$filtered_result
		);
		
		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('ii_course/filter/'.$reg_course_id);
		$config['total_rows'] = $course_view_data['total_result'];		
		$config['per_page'] = self::$PER_PAGE;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		
		$this->load->view('ii_course_view', $course_view_data);
		
		$this->load->view('footer');
	}
	
	public function download_all($reg_course_id)
	{
		$this->load->library('zip');
		$this->load->library('candidate');
		$this->load->library('Registered_course');
		$reg_course = new Registered_course(array('reg_course_id'=>$reg_course_id));
		$candidates = $reg_course->applied_candidates_list();
		foreach ($candidates as $candidate)
		{
			$filename = 'candidate_' . $candidate->get_id() . '.pdf';
			$pdf_data = $candidate->get_pdf();
			$this->zip->add_data($filename, $pdf_data);
		}
		$this->zip->download('candidates_pdf.zip');
	}
	
	public function download($candidate_id)
	{
		$this->load->helper('download');
		$this->load->library('candidate');
		$cnd = new Candidate(array('candidate_id'=>$candidate_id));
		$data = $cnd->get_pdf();
		$filename = $cnd->get_application_number().'_'.url_title($cnd->get_name()).'.pdf';
		force_download($filename, $data);
	}
	
	public function manage($reg_course_id)
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
		
		$this->load->library('Registered_course');
		$reg_course = new Registered_course(array('reg_course_id'=>$reg_course_id));
		
		$course_manage_data = array(
			'reg_course_id'	=> $reg_course_id,
			'course_name'	=> $reg_course->get_course()->get_name(),
			'file_error' 	=> '',
			'data'			=> $this->compute_manage_data($reg_course),
		);
		$this->load->view('ii_course_manage_view', $course_manage_data);
		
		$this->load->view('footer');
	}
	
	public function manage_submit($reg_course_id)
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
		$this->load->library('registered_course');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$config['upload_path'] = $this->config->item('appln_forms_path');
		$config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png|bmp';
		$config['file_name'] = 'AF.pdf';
		$this->load->library('upload', $config);
		
		$this->form_validation->set_rules('desc', 'Description', '');
		$this->form_validation->set_rules('opening_date', 'Opening date', '');
		$this->form_validation->set_rules('closing_date', 'Closing date', '');
		$this->form_validation->set_rules('price', 'Application form Price', 'required|numeric');
		
		$reg_course = new Registered_course(array('reg_course_id'=>$reg_course_id));
		$file_data = $this->upload->data();
		if (!$this->form_validation->run() || 
			(!empty($file_data['client_name']) && !$this->upload->do_upload('form_file')))
		{
			$this->load->library('Registered_course');
			$this->load->view('html_head',$data);
			$this->load->view('header');
			$course_manage_data = array(
				'reg_course_id'	=> $reg_course_id,
				'course_name'	=> $reg_course->get_course()->get_name(),
				'file_error' 	=> $this->upload->display_errors(),
				'data'			=> $this->compute_manage_data($reg_course),
			);
			$this->load->view('ii_course_manage_view', $course_manage_data);
			$this->load->view('footer');
		}
		else
		{
			$this->update_db($reg_course);
			redirect(site_url('ii_course/index/'.$reg_course_id));
		}
		
	}
	
	private function update_db($reg_course)
	{
		$this->load->model('file_model');
		$this->load->model('registered_course_model');
		$this->load->model('application_form_model');
		
		$file_data = $this->upload->data();
		if (!empty($file_data['client_name']))
		{
			$file_data['file_id'] = $this->file_model->insert_into_db($file_data);
		}
		
		$rcrs_data = array();
		$rcrs_data['desc'] = $this->input->post('desc');
		$this->registered_course_model->update_db($rcrs_data, $reg_course->get_id());
		
		$appln_data = array();
		// New Application form uploaded
		if (!empty($file_data['client_name']))
		{
			$appln_data['registered_course_id'] = $reg_course->get_id();
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
			$this->registered_course_model->update_db($rcrs_update_data,$reg_course->get_id());
		}
		// Update existing application form itself
		else 
		{
			$appln_data['price'] = $this->input->post('price');
			$appln_data['opening_date'] = $this->input->post('opening_date');
			$appln_data['closing_date'] = $this->input->post('closing_date');
			$this->application_form_model->update_db($appln_data, $reg_course->get_application_form_id());
		}
		
	}
	
	private function compute_activity_result($reg_course, $offset=0, $filters=null)
	{
		$result = array();
		$candidates = $reg_course->applied_candidates_list(
			self::$PER_PAGE,
			$offset,
			$filters
		);
		
		$i=0;
		foreach ($candidates as $candidate)
		{
			$result[$i]['candidate_id'] = $candidate->get_id();
			$result[$i]['name'] = $candidate->get_name();
			$result[$i]['father_name'] = $candidate->get_father_name();
			$result[$i]['application_number'] = $candidate->get_application_number();
			$result[$i]['date_of_birth'] = $candidate->get_date_of_birth();
			$result[$i]['email_id'] = $candidate->get_email_id();
			$result[$i]['bill_number'] = $candidate->get_payment()->get_bill_number();
			$result[$i]['location'] = $candidate->get_location();
			$i++;
		}
		return $result;
	}
	
	private function compute_manage_data($reg_course)
	{
		$result = array();
		$appln = $reg_course->get_application_form();
		$result['desc'] = $reg_course->get_desc();
		if ($appln != null)
		{
			$result['opening_date'] = $appln->get_opening_date();
			$result['closing_date'] = $appln->get_closing_date();
			$result['price'] = $appln->get_price();
		}
		else 
		{
			$result['opening_date'] = '';
			$result['closing_date'] = '';
			$result['price'] = '';	
		}
		return $result;
	}
}
<?php

class Online_form extends Controller
{
	public function __construct()
	{
		parent::Controller();
		$this->load->library('recaptcha');
		$this->load->library('email_verification');
	}
	
	public function index($appln_id)
	{
		$data = array(
			'title' 	=> 'Online form',
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
		
		$this->load->library('application_form');
		$appln_form = new Application_form(array('appln_id'=>$appln_id));
		$form_data = array(
			'appln_id'		=> $appln_id,
			'course_name'	=> $appln_form->get_course()->get_name(),
			'inst_name'		=> '',
			'tables'		=> $this->generate_form($appln_form),
			'recaptcha_error' => '',
		);
		$this->load->view('online_form_view', $form_data);
		
		$this->load->view('footer');
	}
	
	public function submit($appln_id)
	{
		$this->load->library('application_form');
		$appln_form = new Application_form(array('appln_id'=>$appln_id));
		$data = array(
			'title' 	=> 'Online form',
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
		
		$config['allowed_types'] = 'jpg|jpeg|png|bmp';
		$this->load->library('upload', $config);
		
		$this->form_validation->set_rules('full_name', 'Full Name', 'required');
		$this->form_validation->set_rules('father_name', 'Father\'s Name', 'required');
		$this->form_validation->set_rules('date_of_birth', 'Date of birth', 'required');
		$this->form_validation->set_rules('cnd_email', 'Email address', 'required|valid_email');
		$this->form_validation->set_rules('location', 'Location', 'required');
		
		$fields = $appln_form->get_fields_except_group('Certificates');
		foreach ($fields as $field)
		{
			$this->form_validation->set_rules($field->get_id(), $field->get_label(), $field->get_validation());
		}
		$result = true;
		
		// No need to verify the input if its the request to just send the vcode to the email
		if ($this->input->post('send_vcode_btn')=="1")
		{
			$this->email_verification->send_vcode();
			$result = false;
		}
		else
		{
			$result = $this->form_validation->run() && $result;
	
			$file_errors = array();
			$fields = $appln_form->get_fields_by_group('Certificates');
			foreach ($fields as $field)
			{
				$result = $this->upload->validate($field->get_id(), false) && $result;
				$file_errors[$field->get_id()] = $this->upload->display_errors('<div class="error">', '</div>');
				$this->upload->clear_errors();
			}
			
			$result = $this->email_verification->verify_email() && $result;
			
			// recaptcha validation
			$recaptcha_resp = $this->recaptcha->recaptcha_check_answer(
				$this->config->item('recaptcha_private_key'),
				$_SERVER['REMOTE_ADDR'],
				$this->input->post('recaptcha_challenge_field'),
				$this->input->post('recaptcha_response_field')
			);
			$result = $recaptcha_resp->is_valid && $result;
		}
		
		if (!$result)
		{
			$this->load->view('html_head',$data);
			$this->load->view('header');
			$form_data = array(
			'appln_id'		=> $appln_id,
			'course_name'	=> $appln_form->get_course()->get_name(),
			'inst_name'		=> '',
			'tables'		=> $this->generate_form($appln_form, isset($file_errors)?$file_errors:null),
			'recaptcha_error' => isset($recaptcha_resp->error) ? $recaptcha_resp->error : '',
			);
			$this->load->view('online_form_view', $form_data);
			$this->load->view('footer');
		}
		else 
		{
			$cnd_id = $this->insert_into_db($appln_form);
			// delete _POST data
			redirect(site_url('payment_site/index/'.$cnd_id));
		}
	}
	
	private function generate_form($appln_form, $file_errors=null)
	{
		$result = array();
		$field_data = array(array());
		$this->load->library('table');
		$tmpl = array (
			'table_open'  => '<table border="0" cellpadding="5" cellspacing="0" width="100%">',
			'cell_start'	=> '<td valign="top">',
			'cell_first_start'	=> '<td class="first_col" valign="top">',
		);
		$this->table->set_template($tmpl);
		
		$groups = array();
		$fields = $appln_form->get_fields();
		foreach ($fields as $field)
		{
			if (array_search($field->get_group_name(), $groups)===false)
				$groups[] = $field->get_group_name();
			$field_data[$field->get_group_name()][] = $field->get_label();
			$field_data[$field->get_group_name()][] = $field->html();
			if ($field->get_type() == Form_field::$FILE)
			{
				$field_data[$field->get_group_name()][] = $file_errors[$field->get_id()];
			}
			else 
			{
				$field_data[$field->get_group_name()][] = form_error($field->get_id());
			}
		}
		foreach ($groups as $group)
		{
			$this->table->set_caption($group);
			$group_data = $field_data[$group];
			$group_data = $this->table->make_columns($group_data, 3);
			$result[] = $this->table->generate($group_data);
			$this->table->clear();
		}
		return $result;
	}
	
	private function insert_into_db($appln_form)
	{
		$this->load->model('candidate_model');
		$this->load->model('file_model');
		$this->load->model('filled_candidate_model');
		
		$cnd_data = array(
			'application_form_id'	=> $appln_form->get_id(),
			'application_number'	=> $appln_form->next_application_number(),
			'name'					=> $this->input->post('full_name'),
			'father_name'			=> $this->input->post('father_name'),
			'date_of_birth'			=> $this->input->post('date_of_birth'),
			'email_id'				=> $this->input->post('cnd_email'),
			'location'				=> $this->input->post('location'),
//			'method_id'				=> 'method1',
			'applied_date'			=> date('Y-m-d', time()),
		);
		$cnd_data['candidate_id'] = $this->candidate_model->insert_into_db($cnd_data);
		
		$filled_data = array(
			'candidate_id'	=> $cnd_data['candidate_id'],
		);
		$fields = $appln_form->get_fields('Certificates');
		$field_prefix = $this->config->item('form_candidates_tbl_field_prefix');
		foreach ($fields as $field)
		{
			if ($field->get_type() == Form_field::$FILE)
			{
				$blob_data = $this->upload->get_blob_data($field->get_id());
				$file_data = $this->upload->data();
				$file_data['blob_data'] = $blob_data;
				$file_data['file_id'] = $this->file_model->insert_into_db($file_data);
				$filled_data[$field_prefix . $field->get_id()] = $file_data['file_id'];
			}
			else 
			{
				$filled_data[$field_prefix . $field->get_id()] = $this->input->post($field->get_id());
			}
		}
		$this->filled_candidate_model->insert_into_db($filled_data, $appln_form->get_id());

		// junk for dummy payment
		$this->db->query("INSERT INTO `tbl_payment` VALUES 
		(NULL , '".$cnd_data['candidate_id']."', NULL , 'credit card', '650', '2011-02-19 00:46:21', '1', 'BILLPSGMSC349451')");
		
		
//		(`payment_id` ,`candidate_id` ,
//`user_id` ,
//`mode` ,
//`amount` ,
//`date_time` ,
//`success_flag` ,
//`bill_number`
//)
		
		return $cnd_data['candidate_id'];
	}
}
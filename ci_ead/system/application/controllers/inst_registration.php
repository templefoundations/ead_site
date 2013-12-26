<?php

class Inst_registration extends Controller
{
	function __construct()
	{
		parent::Controller();
		$this->load->library('recaptcha');
	}
	
	function index()
	{
		$data = array(
			'title' 	=> 'College Registration',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
			),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
			
		$form_data = array(
			'recaptcha_error' => '',
		);
		$this->load->view('inst_reg_form', $form_data);
		$this->load->view('footer');
	}
	
	function submit()
	{
		$data = array(
			'title' 	=> 'Course',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->form_validation->set_rules('contact_name', 'Contact Person Name', 'required');
		$this->form_validation->set_rules('contact_email', 'Contact Email', 'required|valid_email');
		$this->form_validation->set_rules('contact_phone', 'Contact Phone', 'required');
		$this->form_validation->set_rules('inst_name', 'College Name', 'required');
		$this->form_validation->set_rules('inst_address', 'College Address', 'required');
		$this->form_validation->set_rules('inst_city', 'City', 'required');
		$this->form_validation->set_rules('inst_state', 'State', 'required');
		$this->form_validation->set_rules('inst_pincode', 'Pincode', 'required');
		$this->form_validation->set_rules('inst_website_url', 'Website URL', '');
		
		// recaptcha validation
		$recaptcha_resp = $this->recaptcha->recaptcha_check_answer(
			$this->config->item('recaptcha_private_key'),
			$_SERVER['REMOTE_ADDR'],
			$this->input->post('recaptcha_challenge_field'),
			$this->input->post('recaptcha_response_field')
		);
		
		$this->load->view('html_head',$data);
		$this->load->view('header');
		if (!$this->form_validation->run())  // || !$recaptcha_resp->is_valid)
		{
			$form_data = array(
				'recaptcha_error' => $recaptcha_resp->error,
			);
			$this->load->view('inst_reg_form', $form_data);
		}
		else
		{
			$this->insert_into_db();
			$this->load->view('inst_reg_success_view');
		}
		$this->load->view('footer');
	}
	
	private function insert_into_db()
	{
		$this->load->database();
		$inst_reg_data = array(
			'contact_name'	=> $this->input->post('contact_name'),
			'contact_email'	=> $this->input->post('contact_email'),
			'contact_phone_number'	=> $this->input->post('contact_phone'),
			'inst_name'		=> $this->input->post('inst_name'),
			'inst_address'	=> $this->input->post('inst_address'),
			'inst_city'		=> $this->input->post('inst_city'),
			'inst_state'	=> $this->input->post('inst_state'),
			'inst_pincode'	=> $this->input->post('inst_pincode'),
			'inst_website_url'	=> $this->input->post('inst_website_url'),
			'datetime'		=> date('Y-m-d H:i:s'),
		);
		$this->db->insert('ntf_inst_reg', $inst_reg_data);
	}
}
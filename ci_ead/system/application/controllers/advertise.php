<?php

class Advertise extends Controller
{
	function __construct()
	{
		parent::Controller();
		$this->load->library('recaptcha');
	}
	
	function index()
	{
		$data = array(
			'title' 	=> 'Advertise',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
			),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
			
		$form_data = array(
			'recaptcha_error' => '',
		);
		$this->load->view('advertise_form', $form_data);
		$this->load->view('footer');
	}
	
	function submit()
	{
		$data = array(
			'title' 	=> 'Advertise',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->form_validation->set_rules('contact_name', 'Contact Person Name', 'required');
		$this->form_validation->set_rules('contact_email', 'Contact Email', 'required|valid_email');
		$this->form_validation->set_rules('contact_phone', 'Contact Phone', 'required');
		$this->form_validation->set_rules('website_url', 'Website URL', 'required');
		$this->form_validation->set_rules('ad_desc', 'Ad Description', 'required');
		
		// recaptcha validation
		$recaptcha_resp = $this->recaptcha->recaptcha_check_answer(
			$this->config->item('recaptcha_private_key'),
			$_SERVER['REMOTE_ADDR'],
			$this->input->post('recaptcha_challenge_field'),
			$this->input->post('recaptcha_response_field')
		);
		
		$this->load->view('html_head',$data);
		$this->load->view('header');
		if (!$this->form_validation->run() || !$recaptcha_resp->is_valid)
		{
			$form_data = array(
				'recaptcha_error' => $recaptcha_resp->error,
			);
			$this->load->view('advertise_form', $form_data);
		}
		else
		{
			$this->insert_into_db();
			$this->load->view('advertise_success_view');
		}
		$this->load->view('footer');
	}
	
	private function insert_into_db()
	{
		$this->load->database();
		$ad_data = array(
			'contact_name'	=> $this->input->post('contact_name'),
			'contact_email'	=> $this->input->post('contact_email'),
			'contact_phone_number'	=> $this->input->post('contact_phone'),
			'website_url'	=> $this->input->post('website_url'),
			'ad_desc'		=> $this->input->post('ad_desc'),
			'datetime'		=> date('Y-m-d H:i:s'),
		);
		$this->db->insert('ntf_advertise', $ad_data);
	}
}
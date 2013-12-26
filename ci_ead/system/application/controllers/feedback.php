<?php

class Feedback extends Controller
{
	function __construct()
	{
		parent::Controller();
		$this->load->library('recaptcha');
	}
	
	function index()
	{
		$data = array(
			'title' 	=> 'Feedback',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
			),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
			
		$form_data = array(
			'recaptcha_error' => '',
		);
		$this->load->view('feedback_form', $form_data);
		$this->load->view('footer');
	}
	
	function submit()
	{
		$data = array(
			'title' 	=> 'Feedback',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->form_validation->set_rules('contact_name', 'Contact Person Name', 'required');
		$this->form_validation->set_rules('contact_email', 'Contact Email', 'required|valid_email');
		$this->form_validation->set_rules('feedback_about', 'Feedback About', 'required');
		$this->form_validation->set_rules('feedback', 'Feedback', 'required');
		
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
			$this->load->view('feedback_form', $form_data);
		}
		else
		{
			$this->insert_into_db();
			$this->load->view('feedback_success_view');
		}
		$this->load->view('footer');
	}
	
	private function insert_into_db()
	{
		$this->load->database();
		$ad_data = array(
			'contact_name'	=> $this->input->post('contact_name'),
			'contact_email'	=> $this->input->post('contact_email'),
			'feedback_about'=> $this->input->post('feedback_about'),
			'feedback'		=> $this->input->post('feedback'),
			'datetime'		=> date('Y-m-d H:i:s'),
		);
		$this->db->insert('ntf_feedback', $ad_data);
	}
}
<?php

class Email_verification extends Controller
{
	public function __construct()
	{
		parent::Controller();
	}
	
	public function index()
	{
		$data = array(
			'title' 	=> 'Email Verification',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
			),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		
		$this->load->view('email_verification_form');
		
		$this->load->view('footer');
	}
	
	public function submit()
	{
		$data = array(
			'title' 	=> 'Email Verification',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
			),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->form_validation->set_rules('email_id', 'Email Address', 'required|valid_email|callback_send_vcode');
		if ($this->input->post('verify_btn')=="1")
		{
			$this->form_validation->set_rules('vcode', 'Verification code', 'required|callback_verify_code');
		}
		
		if (!$this->form_validation->run())
		{
			$this->load->view('email_verification_form');
		}
		else {
			redirect(site_url('index/home'));
		}
		
		$this->load->view('footer');
	}
	
	public function send_vcode($email_id)
	{
		$this->form_validation->set_message('send_vcode', 'Cannot send email to the given email address');
		return mail($email_id, "Email Verification", substr(md5($email_id), 0, 5));
	}
	
	public function verify_code($vcode)
	{
		$this->form_validation->set_message('send_vcode', 'Verification code doesnt match the code sent to the email address');
		$email_id = $this->input->post('email_id');
		if (substr(md5($email_id),0,5) == $vcode) {
			return true;
		}
		return false;
	}
}
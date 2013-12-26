<?php

class Login extends Controller
{
	public function __construct()
	{
		parent::Controller();
	}
	
	public function index()
	{
		$data = array(
			'title' 	=> 'Login',
			'css_list' 	=> array($this->config->item('css_path').'style.css'),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('required', '%s required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('username', 'Username', 'required|callback_login_check');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('login_view');
		}
		else
		{
			redirect(site_url('ii_home'));
		}
		
		$this->load->view('footer');
	}
	
	function login_check($username)
	{
		$this->load->model('user_model');
		$this->load->helper('email');
		$this->form_validation->set_message('login_check', 'Username and Password do not match');
		
		if (valid_email($username))
		{
			$login_data = array('email' => $username);
		}
		else
		{
			$login_data = array('username' => $username);
		}
		$login_data['password'] = $this->input->post('password');
		// username and password check
		$userdata = $this->user_model->get_data($login_data);
		if ($userdata != null)
		{
			$sessiondata = array(
				'user_id'	=> $userdata['user_id'],
				'username'	=> $userdata['username'],
				'email_id'	=> $userdata['email_id'],
				'inst_id'	=> $userdata['inst_id'],
			);
			$this->session->set_userdata($sessiondata);
			return TRUE;
		}
		return FALSE;
	}
}
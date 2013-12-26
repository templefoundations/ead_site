<?php

class Index extends Controller {

	function __construct()
	{
		parent::Controller();
	}
	
	/**
	 * 
	 * Home Page
	 */
	function home()
	{
		$session_user = $this->session->userdata('user_id');
		if (!empty($session_user))
		{
			redirect(site_url('ii_home'));
		}
		$csspath = $this->config->item('css_path');
		$data = array(
			'title' 	=> 'Home',
			'css_list' 	=> array(
				$csspath.'style.css',
			),
			'js_list'	=> array(
				$this->config->item('jquery_path').'jquery.tools.min.js',
				$this->config->item('jquery_path').'jquery.vticker.min.js',
			),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		$this->load->view('home_view');
		$this->load->view('footer');
	}
	
	public function logout()
	{
		$sessiondata = array(
				'user_id'	=> '',
				'username'	=> '',
				'email_id'	=> '',
		);
		$this->session->unset_userdata($sessiondata);
		redirect(site_url('index/home'));
	}
}

/* End of file index.php */
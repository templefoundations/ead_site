<?php

class Ii_candidate extends Controller
{
	public function __construct()
	{
		parent::Controller();
		$session_user = $this->session->userdata('user_id');
		if (empty($session_user))
		{
			redirect(site_url('login'));
		}
	}
	
	public function index($candidate_id)
	{
		$data = array(
			'title' 	=> 'Candidate',
			'css_list' 	=> array($this->config->item('css_path').'style.css'),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		
		$this->load->library('candidate');
		$this->load->library('registered_course');
		$candidate = new Candidate(array('candidate_id'=>$candidate_id));		
		$reg_course = new Registered_course(array('reg_course_id'=>$candidate->get_appliation_form()->get_registered_course_id()));
		$cnd_data = array(
			'reg_course_id'	=> $reg_course->get_id(),
			'course_name'	=> $reg_course->get_course()->get_name(),
//			'inst_name'		=>,
			'tables'		=> $this->generate_result($candidate),
		);
		$this->load->view('ii_candidate_view', $cnd_data);
		
		$this->load->view('footer');
	}
	
	private function generate_result($candidate)
	{
		$result = array();
		$this->load->library('table');
		$appln_form = $candidate->get_appliation_form();
		 
		$this->table->set_caption('Candidate details');
		$candidate_data = array(
			'Name',				$candidate->get_name(),
			'Father\'s Name',	$candidate->get_father_name(),
			'Appln Number',		$candidate->get_application_number(),
			'Date of Birth',	$candidate->get_date_of_birth(),
			'BILL ID',			$candidate->get_payment()->get_bill_number(),
			'Email ID',			$candidate->get_email_id()
		);
		$candidate_data = $this->table->make_columns($candidate_data, 6);
		$result[] = $this->table->generate($candidate_data);
		$this->table->clear();
		
		$field_data = array(array());
		$field_values = $candidate->get_field_values();
		$field = $appln_form->get_first_field();
		$groups = array();
		do
		{
			if (array_search($field->get_group_name(), $groups)===false)
				$groups[] = $field->get_group_name();
			$field_data[$field->get_group_name()][] = $field->get_label();
			$field_data[$field->get_group_name()][] = $field_values[$field->get_id()];
			
			$field = $field->get_next_field();
		}while ($field!=null);
		foreach ($groups as $group)
		{
			$this->table->set_caption($group);
			$group_data = $field_data[$group];
			$group_data = $this->table->make_columns($group_data, 6);
			$result[] = $this->table->generate($group_data);
			$this->table->clear();
		}
		
		// Certificates data pending
		$this->table->set_caption('Certificates');
		$cert_data = array();
		$fields = $appln_form->get_fields_by_group('Certificates');
		foreach ($fields as $field)
		{
			$cert_data[] = $field->get_label();
		}
		
		return $result;
	}
}
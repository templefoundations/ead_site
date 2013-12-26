<?php

class Ii_home extends Controller
{
	function __construct()
	{
		parent::Controller();
		$session_user = $this->session->userdata('user_id');
		if (empty($session_user))
		{
			redirect(site_url('login'));
		}
	}
	
	function index()
	{
		$data = array(
			'title' 	=> 'II Home',
			'css_list' 	=> array($this->config->item('css_path').'style.css'),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		
		$home_data = $this->compute_courses_data();
		$this->load->view('ii_home_view', array('data'=>$home_data));
		
		$this->load->view('footer');
	}
	
	function compute_courses_data()
	{
		$result = array();
		$this->load->database();
		$this->load->library('registered_course');
		$user_id = $this->session->userdata('user_id');
		
		$reg_courses = array();
		$this->db->select('registered_course_id')->from('tbl_registered_course');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		foreach ($query->result() as $row)
		{
			$reg_courses[] = new Registered_course(array('reg_course_id'=>$row->registered_course_id));
		}
		$result['courses_count'] = count($reg_courses);
		$i=0;
		foreach ($reg_courses as $reg_course)
		{
			$result[$i]['reg_course_id'] = $reg_course->get_id();
			$result[$i]['course_name'] = $reg_course->get_course()->get_name();
			$appln_form = $reg_course->get_application_form();
			if ($appln_form == null)
			{
				$result[$i]['status_desc'] = 'Application form should be uploaded';
				$result[$i]['status'] = 'passive';
			}
			else if ($appln_form->is_valid()==false)
			{
				$result[$i]['status_desc'] = 'Application form will be processed soon';
				$result[$i]['status'] = 'passive';
			}
			else if ($appln_form->is_dates_set()==false)
			{
				$result[$i]['status_desc'] = 'Opening and Closing dates are not set';
				$result[$i]['status'] = 'passive';
			}
			else 
			{
				$open_time = strtotime($appln_form->get_opening_date());
				$close_time = strtotime($appln_form->get_closing_date());
				if (time()<$open_time)
					$result[$i]['status'] = 'to_open';
				else if (time()>$open_time && time()<$close_time)
				{
					$result[$i]['status'] = 'active';
				}
				else if (time()>$close_time)
				{
					$result[$i]['status'] = 'closed';
				}
				$result[$i]['candidates_count'] = $appln_form->applied_candidates_count();
				$result[$i]['opening_date'] = date('d-M-Y', $open_time);
				$result[$i]['closing_date'] = date('d-M-Y', $close_time);	
				$result[$i]['status_desc'] = 'open from <b>'.$result[$i]['opening_date'].'</b> to <b>'.
												$result[$i]['closing_date'].'</b>';
			}
			$i++;
		}
		return $result;
	}
	
}
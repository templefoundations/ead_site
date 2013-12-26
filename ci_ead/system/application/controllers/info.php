<?php

class Info extends Controller
{
	function __construct()
	{
		parent::Controller();
	}
	
	function course($course_id)
	{
		$this->load->library('course');
		$course = new Course(array('course_id'=>$course_id));
		$coursedata = array(	
			'course' => $course,
		);
		
		$data = array(
			'title' 	=> $course->get_name(),
			'css_list' 	=> array($this->config->item('css_path').'style.css'),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		if ($course->is_valid())
		{
			$this->load->view('course_view',$coursedata);
		}
		$this->load->view('footer');
	}
	
	function institution($inst_id)
	{
		$this->load->library('institution');
		$inst = new Institution(array('inst_id'=>$inst_id));
		$inst_data = array(	
			'inst' => $inst,
		);
		
		$data = array(
			'title' 	=> $inst->get_name(),
			'css_list' 	=> array($this->config->item('css_path').'style.css'),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		if ($inst->is_valid())
		{
			$this->load->view('inst_view', $inst_data);
		}
		$this->load->view('footer');
	}
	
	function registered_courses($offset=0)
	{
		$this->load->library('registered_course');
		$this->load->library('course');
		$this->load->library('institution');
		
		$PER_PAGE = 10;
		$data = array(
			'title' 	=> 'All Application forms',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
			),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		
		$reg_courses_data = array();
		$reg_courses_data['total_reg_courses'] = Registered_course::valid_registered_courses("count");
		$query = Registered_course::valid_registered_courses("query", $PER_PAGE, $offset);
		foreach ($query->result_array() as $row) 
		{
			$reg_course = new Registered_course(array('reg_course_id'=>$row['registered_course_id']));
			$course = $reg_course->get_course();
			$inst = $reg_course->get_inst();
			$appln_form = $reg_course->get_application_form();
			if ($appln_form->status()===Application_form::$APPLY)
			{
				$reg_courses_data['active_applns'][] = array('inst'=>$inst, 'course'=>$course,
					'reg_course'=>$reg_course, 'appln_form'=>$appln_form);
			}
			else if ($appln_form->status()===Application_form::$TO_OPEN)
			{
				$reg_courses_data['to_open_applns'][] = array('inst'=>$inst, 'course'=>$course,
					'reg_course'=>$reg_course, 'appln_form'=>$appln_form);
			}
		}
		
		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('info/registered_courses');
		$config['total_rows'] = (isset($reg_courses_data['total_reg_courses']))?$reg_courses_data['total_reg_courses']:'0';		
		$config['per_page'] = $PER_PAGE;
		$this->pagination->initialize($config);
		
		$this->load->view('reg_course_list_view', $reg_courses_data);
		
		$this->load->view('footer');
	}
	
	/**
	 * 
	 * List all the courses based on the parameter criteria
	 * @param $filter_key - filtering criteria like graduation, group, etc.
	 * @param $value - value for the filtering key
	 */
	function courses($category='all', $offset=0)
	{
		$this->load->library('course');
		
		$PER_PAGE = 25;
		$data = array(
			'title' 	=> 'All Courses',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
			),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		
		$filters = null;
		if ($category!='all')
		{
			$filters = array(
				'category' => $category,
			);
		}
		
		$courses_data = array();
		$courses_data['total_courses'] = Course::courses("count", -1, 0, null, $filters);
		$courses_data['courses'] = Course::courses("objects", $PER_PAGE, $offset, "category, name, graduation", $filters);
		
		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('info/courses/'.$category);
		$config['total_rows'] = (isset($courses_data['total_courses']))?$courses_data['total_courses']:'0';		
		$config['per_page'] = $PER_PAGE;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		
		$this->load->view('course_list_view', $courses_data);
		
		$this->load->view('footer');
	}
	
	function institutions($offset=0)
	{
		$this->load->library('institution');
		
		$PER_PAGE = 25;
		$data = array(
			'title' 	=> 'All Colleges',
			'css_list' 	=> array(
				$this->config->item('css_path').'style.css',
			),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		
		$insts_data = array();
		$insts_data['total_insts'] = Institution::institutions("count");
		$insts_data['insts'] = Institution::institutions("objects", $PER_PAGE, $offset, NULL); //"affiliated_to DESC, state DESC, district DESC, type DESC, category DESC");
		
		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('info/institutions');
		$config['total_rows'] = (isset($insts_data['total_insts']))?$insts_data['total_insts']:'0';		
		$config['per_page'] = $PER_PAGE;
		$this->pagination->initialize($config);
		
		$this->load->view('inst_list_view', $insts_data);
		
		$this->load->view('footer');
	}
	
}
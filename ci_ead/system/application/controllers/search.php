<?php

class Search extends Controller
{
	private $search_data = array();
	
	function __construct()
	{
		parent::Controller();
		$this->load->library('session');;;
	}
	
	function index()
	{	
		$this->session->unset_userdata('search_ids');
		
		$data = array(
			'title' 	=> 'Search',
			'css_list' 	=> array($this->config->item('css_path').'style.css'),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		
		$srp_data = array(
			'search_options' => $this->generate_search_options(),
		);
		$this->load->view('srp', $srp_data);
		
		$this->load->view('footer');
	}
	
	function submit()
	{
		$this->load->database();
		
		// if POST data is set, search procedure starts from the beginning
		if (!empty($_POST))
		{
			$course_options = array();
			$course_option_set = false;
			if ($this->input->post('course_name')!=false)
			{
				$course_options['name'] = $this->input->post('course_name');
				$course_option_set = true;
			}
			if ($this->input->post('graduation')!=false)
			{
				$course_options['graduation'] = $this->input->post('graduation');
				$course_option_set = true;
			}
			if ($this->input->post('course_category')!=false)
			{
				$course_options['category'] = $this->input->post('course_category');
				$course_option_set = true;
			}
			$inst_options = array();
			$inst_option_set = false;
			if ($this->input->post('inst_name')!=false)
			{
				$inst_options['name'] = $this->input->post('inst_name');
				$inst_option_set = true;
			}
			if ($this->input->post('university')!=false)
			{
				$inst_options['university'] = $this->input->post('university');
				$inst_option_set = true;
			}
			if ($this->input->post('inst_type')!=false)
			{
				$inst_options['type'] = $this->input->post('inst_type');
				$inst_option_set = true;
			}
			if ($this->input->post('inst_category')!=false)
			{
				$inst_options['category'] = $this->input->post('inst_category');
				$inst_option_set = true;
			}
		
			// check for options set
			if ($course_option_set===false && $inst_option_set===false)
			{
				redirect(site_url('search'));
				return;
			}
			
		
			// collect course ids which satisfies the course options
			$course_ids = array();
			if ($course_option_set)
			{
				$this->db->select('course_id')->from('tbl_course');
				if (!empty($course_options['graduation']))
				{
					$this->db->where('graduation', $course_options['graduation']);
				}
				if (!empty($course_options['category']))
				{
					$this->db->where('category', $course_options['category']);
				}
				if (!empty($course_options['name']))
				{
					$name = preg_replace('#[^a-z0-9]#i', '', $course_options['name']);
					$this->db->like('search_name', $name);
				}
				$query = $this->db->get();
				foreach ($query->result_array() as $row)
				{
					$course_ids[] = $row['course_id'];
				}
				$this->search_data['course_count'] = count($course_ids);
			}
			
			// collect inst ids which satisfies the inst options
			$inst_ids = array();
			if ($inst_option_set)
			{
				$this->db->select('inst_id')->from('tbl_inst');
				if (!empty($inst_options['university']))
				{
					$this->db->where('affiliated_to', $inst_options['university']);
				}
				if (!empty($inst_options['type']))
				{
					$this->db->where('type', $inst_options['type']);
				}
				if (!empty($inst_options['category']))
				{
					$this->db->where('category', $inst_options['category']);
				}
				if (!empty($inst_options['name']))
				{
					$name = preg_replace('#[^a-z0-9]#i', '', $inst_options['name']);
					$this->db->like('search_name', $name);
				}
				$query = $this->db->get();
				foreach ($query->result_array() as $row)
				{
					$inst_ids[] = $row['inst_id'];
				}
				$this->search_data['inst_count'] = count($inst_ids);
			}
			
			// Search appln forms available now
			$this->db->select('tbl_registered_course.registered_course_id')->from('tbl_user');
			$this->db->join('tbl_registered_course', 'tbl_user.user_id=tbl_registered_course.user_id');
			$this->db->join('tbl_application_form', 'current_application_form_id=application_form_id');
			$this->db->where('tbl_application_form.closing_date >= sysdate()');
			$this->db->where('tbl_application_form.valid_flag','1');
			if (!empty($course_ids))
			{
				$this->db->where_in('tbl_registered_course.course_id', $course_ids);
			}
			if (!empty($inst_ids))
			{
				$this->db->where_in('tbl_user.inst_id', $inst_ids);
			}
			$query = $this->db->get();
			$reg_course_ids = array();
			foreach ($query->result_array() as $row)
			{
				$reg_course_ids[] = $row['registered_course_id'];
			}
			$this->search_data['appln_form_count'] = count($reg_course_ids);
			
			$search_ids = array(
				'inst_ids'			=> $inst_ids,
				'course_ids'		=> $course_ids,
				'reg_course_ids'	=> $reg_course_ids,
			);
			$this->session->set_userdata('search_ids', $search_ids);
			
			if (count($reg_course_ids)>0)
			{
				redirect(site_url('search/appln_forms#search_results'));
			}
			else if (count($inst_ids)>0)
			{
				redirect(site_url('search/institutions#search_results'));
			}
			else if (count($course_ids)>0)
			{
				redirect(site_url('search/courses#search_results'));
			}
			else
			{
				redirect(site_url('search'));
			}
		}
		else 
		{
			redirect(site_url('search'));
		}
	}
	
	public function appln_forms($offset = 0)
	{
		$PER_PAGE = 10;
		
		$this->load->library('registered_course');
		$this->load_session_data();
		
		$data = array(
			'title' 	=> 'Search',
			'css_list' 	=> array($this->config->item('css_path').'style.css'),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		
		$search_ids = $this->session->userdata('search_ids');
		$reg_course_ids = $search_ids['reg_course_ids'];
		if (count($reg_course_ids)>0)
		{
			$this->search_data['appln_forms'] = array();
			$end_offset = ($offset+$PER_PAGE < $this->search_data['total_appln_forms']) ?  $offset+$PER_PAGE : $this->search_data['total_appln_forms'];
			for ($i=$offset; $i<$end_offset; $i++)
			{
				$reg_course = new Registered_course(array('reg_course_id'=>$reg_course_ids[$i]));
				$course = $reg_course->get_course();
				$inst = $reg_course->get_inst();
				$appln_form = $reg_course->get_application_form();
				if ($appln_form!=null)
				{
					if ($appln_form->status()===Application_form::$APPLY)
					{
						$this->search_data['appln_forms']['active'][] = array('inst'=>$inst, 'course'=>$course,
							'reg_course'=>$reg_course, 'appln_form'=>$appln_form);
					}
					else if ($appln_form->status()===Application_form::$TO_OPEN)
					{
						$this->search_data['appln_forms']['to_open'][] = array('inst'=>$inst, 'course'=>$course,
							'reg_course'=>$reg_course, 'appln_form'=>$appln_form);
					}
				}
			}
		}
		
		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('search/appln_forms');
		$config['total_rows'] = $this->search_data['total_appln_forms'];		
		$config['per_page'] = $PER_PAGE;
		$this->pagination->initialize($config);
		
		$this->search_data['show_appln_forms'] = true;
		$this->search_data['search_options'] = $this->generate_search_options();
		$this->load->view('srp', $this->search_data);
		
		$this->load->view('footer');
	}
	
	public function institutions($offset = 0)
	{
		$PER_PAGE = 25;
		
		$this->load->library('institution');
		$this->load_session_data();
		
		$data = array(
			'title' 	=> 'Search',
			'css_list' 	=> array($this->config->item('css_path').'style.css'),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		
		$search_ids = $this->session->userdata('search_ids');
		$inst_ids = $search_ids['inst_ids'];
		$insts = array();
		if (count($inst_ids)>0)
		{
			$this->search_data['$insts'] = array();
			$end_offset = ($offset+$PER_PAGE < $this->search_data['total_insts']) ?  $offset+$PER_PAGE : $this->search_data['total_insts']; 
			for ($i=$offset; $i<$end_offset; $i++)
			{
				$insts[] = new Institution(array('inst_id'=>$inst_ids[$i]));
			}
		}
		
		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('search/institutions');
		$config['total_rows'] = $this->search_data['total_insts'];		
		$config['per_page'] = $PER_PAGE;
		$this->pagination->initialize($config);
		
		$this->search_data['show_insts'] = true;
		$this->search_data['insts'] = $insts;
		$this->search_data['search_options'] = $this->generate_search_options();
		$this->load->view('srp', $this->search_data);
		
		$this->load->view('footer');
	}
	
	public function courses($offset = 0)
	{
		$PER_PAGE = 25;
		
		$this->load->library('course');
		$this->load_session_data();
		
		$data = array(
			'title' 	=> 'Search',
			'css_list' 	=> array($this->config->item('css_path').'style.css'),
		);
		$this->load->view('html_head',$data);
		$this->load->view('header');
		
		$search_ids = $this->session->userdata('search_ids');
		$course_ids = $search_ids['course_ids'];
		$courses = array();
		if (count($course_ids)>0)
		{
			$this->search_data['$courses'] = array();
			$end_offset = ($offset+$PER_PAGE < $this->search_data['total_courses']) ?  $offset+$PER_PAGE : $this->search_data['total_courses']; 
			for ($i=$offset; $i<$end_offset; $i++)
			{
				$courses[] = new Course(array('course_id'=>$course_ids[$i]));
			}
		}
		
		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('search/courses');
		$config['total_rows'] = $this->search_data['total_courses'];		
		$config['per_page'] = $PER_PAGE;
		$this->pagination->initialize($config);
		
		$this->search_data['show_courses'] = true;
		$this->search_data['courses'] = $courses;
		$this->search_data['search_options'] = $this->generate_search_options();
		$this->load->view('srp', $this->search_data);
		
		$this->load->view('footer');
	}
	
	private function load_session_data()
	{
		$search_ids = $this->session->userdata('search_ids');
		if (!empty($search_ids))
		{
			$this->search_data['show_result'] = true;
			$this->search_data['total_appln_forms'] = count($search_ids['reg_course_ids']);
			$this->search_data['total_insts'] = count($search_ids['inst_ids']);
			$this->search_data['total_courses'] = count($search_ids['course_ids']);
		}
		else 
		{
			$this->search_data['show_result'] = false;
			$this->search_data['total_appln_forms'] = 0;
			$this->search_data['total_insts'] = 0;
			$this->search_data['total_courses'] = 0;
		}
		$this->search_data['show_appln_forms'] = false;
		$this->search_data['show_insts'] = false;
		$this->search_data['show_courses'] = false;
	}
	
	private function generate_search_options()
	{
		$this->load->database();
		$options = array();
		
		$options['inst_universities'] = array();
		$this->db->select('affiliated_to')->from('tbl_inst');
		$this->db->distinct();
		$query = $this->db->get();
		foreach ($query->result_array() as $row)
		{
			$options['inst_universities'][] = $row['affiliated_to'];
		}
		
		$options['inst_types'] = array();
		$this->db->select('type')->from('tbl_inst');
		$this->db->distinct();
		$query = $this->db->get();
		foreach ($query->result_array() as $row)
		{
			$options['inst_types'][] = $row['type'];
		}
		
		$options['inst_categories'] = array();
		$this->db->select('category')->from('tbl_inst');
		$this->db->distinct();
		$query = $this->db->get();
		foreach ($query->result_array() as $row)
		{
			$options['inst_categories'][] = $row['category'];
		}
		
		$options['course_graduations'] = array();
		$this->db->select('graduation')->from('tbl_course');
		$this->db->distinct();
		$query = $this->db->get();
		foreach ($query->result_array() as $row)
		{
			$options['course_graduations'][] = $row['graduation'];
		}
		
		$options['course_categories'] = array();
		$this->db->select('category')->from('tbl_course');
		$this->db->distinct();
		$query = $this->db->get();
		foreach ($query->result_array() as $row)
		{
			$options['course_categories'][] = $row['category'];
		}
		
		return $options;
	}
	
}
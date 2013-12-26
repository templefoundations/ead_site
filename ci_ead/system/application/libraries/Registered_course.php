<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registered_course
{
	private $registered_course_id;
	private $course_id;
	private $user_id;
	private $current_application_form_id;
	private $desc;
	
	private static $CI;

	public function __construct($params = array())
	{
		self::$CI = & get_instance();
		self::$CI->load->model('registered_course_model');
		$data = null;
		if (!empty($params['reg_course_id']))
		{
			$data = self::$CI->registered_course_model->get_data_by_id($params['reg_course_id']);
		}
		else if (!empty($params['inst_id']) && !empty($params['course_id']))
		{
			$data = self::$CI->registered_course_model->get_data_by_inst_course_ids($params['inst_id'], $params['course_id']);
		}
		else if (!empty($params['data']))
		{
			$data = $params['data'];
		}
		if ($data != null)
		{
			$this->copy_data($data);
		}
		else 
		{
			return null;
		}
	}
	
	public function applied_candidates_count()
	{
		self::$CI->load->database();
		self::$CI->load->library('candidate');
		
		self::$CI->db->select('candidate_id')->from('tbl_candidate');
		self::$CI->db->join('tbl_registered_course','current_application_form_id=tbl_candidate.application_form_id');
		self::$CI->db->where('registered_course_id',$this->registered_course_id);
		return self::$CI->db->count_all_results();
	}
	
	/**
	 * 
	 * Get the list of all applied candidates
	 * @param int $count - if '0' returns all candidates
	 * @param int $offset
	 */
	public function applied_candidates_list($count=0, $offset=0, $filters=null)
	{
		self::$CI->load->database();
		self::$CI->load->library('candidate');
		$candidates = array();
		
		self::$CI->db->select('candidate_id')->from('tbl_candidate');
		self::$CI->db->join('tbl_registered_course','current_application_form_id=tbl_candidate.application_form_id');
		self::$CI->db->where('registered_course_id',$this->registered_course_id);
		if ($filters!=null)
		{
			foreach ($filters as $filter)
			{
				self::$CI->db->where($filter);
			}
		}
		if ($count>0)
		{
			self::$CI->db->limit($count,$offset);
		}
		$query = self::$CI->db->get();
		foreach ($query->result() as $row)
		{
			$candidates[] = new Candidate(array('candidate_id'=>$row->candidate_id));
		}
		return $candidates;
	}
	
	/**
	 * 
	 * Get all the registered courses that are active now
	 * 
	 * @param unknown_type $return - "query" or "count"
	 * @param unknown_type $filter_course_ids - return only the courses in this list of ids
	 * @param unknown_type $per_page
	 * @param unknown_type $offset
	 */
	public static function valid_registered_courses($return="query", $per_page=-1, $offset=0, $filter_course_ids=null)
	{
		/* --QUERY--
		 * SELECT tbl_registered_course.registered_course_id 
		 * FROM tbl_registered_course
		 * JOIN `tbl_application_form` ON current_application_form_id=application_form_id
		 * WHERE closing_date >= sysdate() AND course_id in (1,2,3)
		 */
		
		self::$CI->db->select('tbl_registered_course.registered_course_id');
		self::$CI->db->from('tbl_registered_course');
		self::$CI->db->join('tbl_application_form', 'current_application_form_id=application_form_id');
		self::$CI->db->where('tbl_application_form.closing_date >= sysdate()');
		self::$CI->db->where('tbl_application_form.valid_flag','1');
		if ($filter_course_ids!=null && !empty($filter_course_ids))
		{
			self::$CI->db->where_in('tbl_registered_course.course_id', $filter_course_ids);
		}
		if ($per_page > 0)
		{
			self::$CI->db->limit($per_page, $offset);
		}
		if ($return === "query")
			return self::$CI->db->get();
		else if ($return === "count")
			return self::$CI->db->count_all_results();
	}
	
	private function copy_data($data)
	{
		if (isset($data))
		{
			$this->registered_course_id	= $data->registered_course_id;			
			$this->course_id			= $data->course_id;
			$this->user_id				= $data->user_id;
			$this->desc 				= $data->desc;
			$this->current_application_form_id = $data->current_application_form_id;
		}
	}
	
	public function get_application_form()
	{
		self::$CI->load->library('application_form');
		if (!empty($this->current_application_form_id))
			return new Application_form(array('appln_id'=>$this->current_application_form_id));
		else
			return null;
	}

	public function get_course()	
	{	
		self::$CI->load->library('course');
		return new Course(array('course_id'=>$this->course_id));	
	}
	public function get_inst()
	{
		self::$CI->load->database();
		self::$CI->db->select('inst_id')->from('tbl_user')->where('user_id',$this->user_id);
		$query = self::$CI->db->get();
		if ($query->num_rows()===1)
		{
			$row = $query->row_array(1);
			$inst_id = $row['inst_id'];
			self::$CI->load->library('institution');
			return new Institution(array('inst_id'=>$inst_id));
		}
		else
			return null;
	}
	public function get_id()	{ return $this->registered_course_id;	}
	public function get_desc()	{	return $this->desc;	}
	public function get_application_form_id()	{	return $this->current_application_form_id;	}
	
}
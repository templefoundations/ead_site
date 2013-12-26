<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Course
{
	private $course_id;
	private $name;
	private $duration;
	private $graduation;
	private $category;
	private $sub_category;
	private $desc;
	private $qualification_degree;
	
	private static $CI;
	
	public function __construct($params=array())
	{
		self::$CI = & get_instance();
		self::$CI->load->model('course_model');
		$data = null;
		if (!empty($params['course_id']))
		{
			$data = self::$CI->course_model->get_data_by_id($params['course_id']);
		}
		else if (!empty($params['course_name']))
		{
			$data = self::$CI->course_model->get_data_by_name($params['course_name']);
		}
		else if (!empty($params['data']))
		{
			$data = $params['data'];
		}
		if ($data != null)
		{
			$this->copy_data($data);
		}
	}
	
	public function get_offering_insts()
	{
		$insts = array();
		self::$CI->load->model('inst_course_model');
		self::$CI->load->library('institution');
		
		$inst_ids = self::$CI->inst_course_model->get_inst_ids_by_course_id($this->course_id);
		foreach ($inst_ids as $inst_id)
		{
			$insts[] = new Institution(array('inst_id'=>$inst_id));
		} 
		return $insts;
	}
	
	public function is_valid()
	{
		if (empty($this->course_id) || empty($this->name))
		{
			return false;
		}
		return true;
	}
	
	/**
	 * 
	 * Returns the list of courses 
	 * @param unknown_type $return "query" or "objects" or "count"
	 * @param unknown_type $per_page
	 * @param unknown_type $offset
	 */
	public static function courses($return="objects", $per_page=-1, $offset=0, $order_by=null, $filters=null)
	{
		$courses = array();
		self::$CI->load->database();
		
		self::$CI->db->select('course_id')->from('tbl_course');
		if ($filters!=null)
		{
			$keys = array_keys($filters);
			foreach ($keys as $key)
			{
				self::$CI->db->where($key, $filters[$key]);	
			}
		}
		if ($per_page > 0)
		{
			self::$CI->db->limit($per_page, $offset);
		}
		
		if ($return === "count")
		{
			return self::$CI->db->count_all_results();
		}
		else 
		{
			if ($order_by != null)
			{
				self::$CI->db->order_by($order_by);
			}
			$query = self::$CI->db->get();
			if ($return === "query")
			{
				return $query;
			}
			else if ($return === "objects")
			{
				foreach ($query->result_array() as $row)
				{
					$courses[] = new Course(array('course_id'=>$row['course_id']));
				}
				return $courses;
			}
		}
	}
	
	private function copy_data($data)
	{
		if (isset($data))
		{
			$this->course_id 			= $data->course_id;
			$this->name 				= $data->name;
			$this->duration 			= $data->duration;
			$this->graduation 			= $data->graduation;
			$this->category				= $data->category;
			$this->sub_category			= $data->subcategory;
			$this->desc 				= $data->desc;
			$this->qualification_degree = $data->qualification_degree;
		}
	}
	
	// Getter & Setter fns
	public function get_id()	{	return $this->course_id;	}
	public function get_name()	{	return $this->name;	}
	public function get_duration()	
	{	
		if ($this->duration == 0)
			return 'NA';
		else if (substr($this->duration, strlen($this->duration)-1)==="0")
			return intval($this->duration).' Years';
		else
			return $this->duration. 'Years';
	}
	public function get_graduation()	
	{	
		if ($this->graduation == '')
			return 'NA';
		else 
			return $this->graduation;	
	}
	public function get_category()	
	{	
		if ($this->category == '')
			return 'NA';
		else
			return $this->category;	
	}
	public function get_sub_category()	
	{	
		if ($this->sub_category == '')
			return 'NA';
		else
			return $this->sub_category;	
	}
	public function get_desc()	
	{
		if ($this->desc == '')
			return 'NA';
		else	
			return $this->desc;	
	}
	public function get_qualification_degree()	
	{
		if ($this->qualification_degree == '')
			return 'NA';
		else	
			return $this->qualification_degree;	
	}
	
}
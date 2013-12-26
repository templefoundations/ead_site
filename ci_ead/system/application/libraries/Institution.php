<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Institution
{
	private $inst_id;
	private $name;
	private $affiliated_to;
	private $established_year;
	private $type;
	private $category;
	private $district;
	private $state;
	private $address;
	private $pincode;
	private $phone_numbers;
	private $email_address;
	private $logo_url;
	
	private static $CI;
	
	public function __construct($params = array())
	{
		self::$CI = & get_instance();		
		self::$CI->load->model('institution_model');
		
		$data = null;
		if (!empty($params['inst_id']))
		{
			$data = self::$CI->institution_model->get_data_by_id($params['inst_id']);
		}
		else if (!empty($params['inst_name']))
		{
			$data = self::$CI->institution_model->get_data_by_name($params['inst_name']);
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
	
	public function is_valid()
	{
		if (empty($this->inst_id) || empty($this->name))
		{
			return false;
		}
		return true;
	}
	
	public function get_offered_courses()
	{
		$courses = array();
		self::$CI->load->model('inst_course_model');
		self::$CI->load->library('course');
		
		$course_ids = self::$CI->inst_course_model->get_course_ids_by_inst_id($this->inst_id);
		foreach ($course_ids as $course_id)
		{
			$courses[] = new Course(array('course_id'=>$course_id));
		} 
		return $courses;
	}
	
	/**
	 * 
	 * To get all the institutions
	 * @param unknown_type $return - "query" or "objects" or "count"
	 * @param unknown_type $per_page
	 * @param unknown_type $offset
	 * @param unknown_type $order_by
	 */
	public static function institutions($return="objects", $per_page=-1, $offset=0, $order_by=null)
	{
		$insts = array();
		self::$CI->load->database();
		
		self::$CI->db->select('inst_id')->from('tbl_inst');
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
					$insts[] = new Institution(array('inst_id'=>$row['inst_id']));
				}
				return $insts;
			}
		}
	}
	
	private function copy_data($data)
	{
		if (isset($data))
		{
			$this->inst_id 			= $data->inst_id;
			$this->name 			= $data->name;
			$this->affiliated_to	= $data->affiliated_to;
			$this->established_year	= $data->established_year;
			$this->type				= $data->type;
			$this->category 		= $data->category;
			$this->district			= $data->district;
			$this->state 			= $data->state;
			$this->address 			= $data->address;
			$this->phone_numbers 	= $data->phone_numbers;
			$this->email_address 	= $data->email_address;
			$this->logo_url 		= $data->logo_url;
		}
	}
	
	// Getter & Setter fns
	public function get_id()	{	return $this->inst_id;	}
	public function get_name()	{	return $this->name;	}
	public function get_university()	
	{
		if ($this->affiliated_to == '')
			return 'NA';
		else	
			return $this->affiliated_to;	
	}
	public function get_established_year()	
	{
		if ($this->established_year == '')
			return 'NA';
		else	
			return $this->established_year;	
	}
	public function get_type()	
	{
		if ($this->type == '')
			return 'NA';
		else	
			return $this->type;	
	}
	public function get_category()	
	{
		if ($this->category == '')
			return 'NA';
		else	
			return $this->category;	
	}
	public function get_address()	
	{
		if ($this->address == '')
			return 'NA';
		else	
			return $this->address;	
	}
	public function get_district()	
	{
		if ($this->district == '')
			return 'NA';
		else	
			return $this->district;	
	}
	public function get_state()	
	{
		if ($this->state == '')
			return 'NA';
		else	
			return $this->state;	
	}
	public function get_phone_numbers()	
	{	
		if ($this->phone_numbers == '')
			return 'NA';
		else	
			return $this->phone_numbers;	
	}
	public function get_email_address()	
	{
		if ($this->email_address == '')
			return 'NA';
		else	
			return $this->email_address;	
	}
	public function get_logo_url()	
	{
		return $this->logo_url;	
	}
	
}
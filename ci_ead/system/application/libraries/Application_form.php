<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Application_form
{
	private $appln_form_id;
	private $registered_course_id;
	private $b_valid;
	private $price;
	private $opening_date;
	private $closing_date;
	private $form_file_id;
	private $form_def_tbl_name;
	private $form_candidates_tbl_name;	
	
	private $fields = array();
	
	private static $CI;
	
	public static $APPLY = 'open';
	public static $TO_OPEN = 'to_open';
	public static $CLOSED = 'closed';
	public static $DATE_NOT_SET = 'date_not_set';
	public static $TO_BE_PROCESSED = 'to_be_processed';
	
	public function __construct($params = array())
	{
		$this->CI = & get_instance();
		$this->CI->load->model('application_form_model');
		$data = null;
		if (!empty($params['appln_id']))
		{
			$data = $this->CI->application_form_model->get_data_by_id($params['appln_id']);
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
	
	public function applied_candidates_count()
	{
		$this->CI->load->database();
		$this->CI->db->from('tbl_candidate')->where('application_form_id',$this->appln_form_id);
		return $this->CI->db->count_all_results();
	}

	public function next_application_number()
	{
		$this->CI->load->database();
		$this->CI->db->select_max('application_number')->from('tbl_candidate');
		$this->CI->db->where('application_form_id', $this->appln_form_id);
		$query = $this->CI->db->get();
		$max_appln_no = $query->first_row()->application_number;
		return ++$max_appln_no;
	}
	
	private function copy_data($data)
	{
		if (!empty($data))
		{
			$this->appln_form_id		= $data->application_form_id;
			$this->registered_course_id	= $data->registered_course_id;
			$this->b_valid		= ($data->valid_flag=='1')?true:false;
			$this->price = $data->price;
			if ($data->opening_date=='0000-00-00')
				$this->opening_date = null;
			else
				$this->opening_date	= $data->opening_date;
			
			if ($data->closing_date=='0000-00-00')
				$this->closing_date = null;
			else
				$this->closing_date	= $data->closing_date;
			
			$this->form_file_id	= $data->form_file_id;
			$this->form_def_tbl_name = $data->form_def_tbl_name;
			$this->form_candidates_tbl_name = $data->form_candidates_tbl_name;
		}
	}
	
	public function is_valid()	{	return $this->b_valid;	}
	public function is_dates_set()
	{
		if (!empty($this->opening_date) && !empty($this->closing_date))
			return true;
		else
			return false;
	}
	
	public function is_applicable()
	{
		if ($this->is_dates_set())
		{
			$open_time = strtotime($this->opening_date);
			$close_time = strtotime($this->closing_date);
			$time = time();
			if ($time>=$open_time && $time<=$close_time)
			{
				return true;
			}
		}
		return false;
	}
	public function status()
	{
		$open_time = strtotime($this->opening_date);
		$close_time = strtotime($this->closing_date);
		$time = time();
		if ($this->is_applicable()) 
		{
			return self::$APPLY;
		}
		else if ($this->is_dates_set() && $time>$close_time)
		{
			return self::$CLOSED;
		}
		else if ($this->is_dates_set() && $time<$open_time)
		{
			return self::$TO_OPEN;
		}
	}
	
	public function get_first_field()
	{
		if (empty($this->fields))
		{
			$this->CI->load->library('form_field');
			$this->CI->load->database();
			$this->CI->db->select('field_id')->from($this->CI->config->item('form_def_tbl_prefix').$this->appln_form_id);
			$this->CI->db->limit(1);
			$query = $this->CI->db->get();
			return new Form_field(array(
						'appln_id'	=> $this->appln_form_id,
						'field_id'	=> $query->first_row()->field_id,
					));
		}
		else
			return $this->fields[0];
	}
	public function get_fields_by_group($group_name)
	{
		$result = array();
		if (empty($this->fields))
		{
			$this->CI->load->library('form_field');
			$this->CI->load->database();
			$this->CI->db->select('field_id')->from($this->CI->config->item('form_def_tbl_prefix').$this->appln_form_id);
			$this->CI->db->where('group_name',$group_name);
			$query = $this->CI->db->get();
			foreach ($query->result() as $row)
			{
				$result[] = new Form_field(array(
						'appln_id'	=> $this->appln_form_id,
						'field_id'	=> $row->field_id,
					));
			}
		}
		else
		{
			foreach ($this->fields as $field)
			{
				if ($field->get_group_name()==$group_name)
					$result[] = $field;
			}
		}
		return $result;
	}
	public function get_fields_except_group($group_name)
	{
		$result = array();
		if (empty($this->fields))
		{
			$this->CI->load->library('form_field');
			$this->CI->load->database();
			$this->CI->db->select('field_id')->from($this->CI->config->item('form_def_tbl_prefix').$this->appln_form_id);
			$this->CI->db->where('group_name !=',$group_name);
			$this->CI->db->or_where('group_name IS NULL');
			$query = $this->CI->db->get();
			foreach ($query->result() as $row)
			{
				$result[] = new Form_field(array(
						'appln_id'	=> $this->appln_form_id,
						'field_id'	=> $row->field_id,
					));
			}
		}
		else
		{
			foreach ($this->fields as $field)
			{
				if ($field->get_group_name()!=$group_name)
					$result[] = $field;
			}
		}
		return $result;
	}
	public function get_fields()
	{
		if (empty($this->fields))
		{
			$this->CI->load->library('form_field');
			$this->CI->load->database();
			$this->CI->db->select('field_id')->from($this->CI->config->item('form_def_tbl_prefix').$this->appln_form_id);
			$query = $this->CI->db->get();
			foreach ($query->result() as $row)
			{
				$this->fields[] = new Form_field(array(
						'appln_id'	=> $this->appln_form_id,
						'field_id'	=> $row->field_id,
					));
			}
		}
		return $this->fields;
	}
	public function get_course()
	{
		$this->CI->load->library('course');
		$this->CI->load->library('registered_course');
		$reg_course = new Registered_course(array('reg_course_id'=>$this->registered_course_id));
		return $reg_course->get_course();
//		return new Course(array('course_id'=>$this->registered_course_id));
	}
	public function get_id()	{ return $this->appln_form_id;	}
	public function get_price()	{ return $this->price;	}
	public function get_opening_date()	{	return $this->opening_date;	}
	public function get_closing_date()	{	return $this->closing_date;	}
	public function get_registered_course_id()	{	return $this->registered_course_id;	}
}
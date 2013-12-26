<?php
class Registered_course_model extends Model
{
	private $registered_course_id;
	private $user_id;
	private $course_id;
	private $current_application_form;
	private $desc;
	
	function __construct()
	{
		parent::Model();
		$this->load->database();	
	}
	
	function get_data_by_id($reg_course_id)
	{
		$this->db->from('tbl_registered_course')->where('registered_course_id',$reg_course_id);
		$query = $this->db->get();
		if ($query->num_rows==1)
		{
			return $query->first_row();
		}
		return null;
	}
	
	function get_data_by_inst_course_ids($inst_id, $course_id)
	{
//		$this->db->query('SELECT * FROM tbl_registered_course WHERE course_id='1' AND
//user_id IN (SELECT user_id FROM `tbl_user` WHERE inst_id='1')')

		$this->db->select('user_id')->from('tbl_user')->where('inst_id', $inst_id);
		$query = $this->db->get();
		$user_ids = array();
		foreach ($query->result_array() as $row)
		{
			$user_ids[] = $row['user_id'];
		}
		
		if (!empty($user_ids))
		{
			$this->db->from('tbl_registered_course');
			$this->db->where('course_id', $course_id);
			$this->db->where_in('user_id', $user_ids);
			$query = $this->db->get();
			if ($query->num_rows>0)
			{
				return $query->first_row();
			}
		}
		return null;
	}
	
	function insert_into_db($data)
	{
		$this->db->insert('tbl_registered_course', $data);
		return $this->db->insert_id();
	}
	
	function update_db($data, $id)
	{
		if (!empty($data))
		{
			$this->db->where('registered_course_id', $id);
			$this->db->update('tbl_registered_course', $data);
		}
	}
}
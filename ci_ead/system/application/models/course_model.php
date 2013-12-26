<?php
class Course_model extends Model
{
	private $course_id;
	private $name;
	private $duration;
	private $category_id;
	private $desc;
	private $qualification_degree;
	
	function Course_model()
	{
		parent::Model();
		$this->load->database();	
	}
	
	function copy_data($data)
	{
		$this->course_id 			= $data->course_id;
		$this->name 				= $data->name;
		$this->duration 			= $data->duration;
		$this->category_id 			= $data->category_id;
		$this->desc 				= $data->desc;
		$this->qualification_degree = $data->qualification_degree;
	}
	
	function get_data_by_id($course_id)
	{
		$this->db->from('tbl_course')->where('course_id',$course_id);
		$query = $this->db->get();
		if ($query->num_rows==1)
		{
			return $query->first_row();
		}
		return null;
	}
	
	function get_data_by_name($course_name)
	{
		$this->db->from('tbl_course')->where('name',$course_name);
		$query = $this->db->get();
		if ($query->num_rows==1)
		{
			return $query->first_row();
		}
		return null;
	}
	
	function get_all_course_ids()
	{
		$course_ids = array();
		$this->db->select('course_id')->from('tbl_course');
		$query = $this->db->get();
		foreach ($query->result() as $row)
		{
			$course_ids[] = $row->course_id;
		}
		return $course_ids;
	}
	
	function insert_into_db()
	{
		$this->db->insert('tbl_course', $this);
	}
	
	function update_db($id)
	{
		$this->db->update('tbl_course', $this, "course_id=$id");
	}
}
<?php
class Inst_course_model extends Model
{
	var $inst_course_id;
	var $inst_id;
	var $course_id;
	
	function Inst_course_model()
	{
		parent::Model();
		$this->load->database();	
	}
	
	function get_inst_ids_by_course_id($course_id)
	{
		$inst_ids = array();
		$this->db->select('inst_id')->from('tbl_inst_course')->where('course_id',$course_id);
		$query = $this->db->get();
		foreach ($query->result() as $row)
		{
			$inst_ids[] = $row->inst_id;
		}
		return $inst_ids;
	}
	
	function get_course_ids_by_inst_id($inst_id)
	{
		$course_ids = array();
		$this->db->select('course_id')->from('tbl_inst_course')->where('inst_id',$inst_id);
		$query = $this->db->get();
		foreach ($query->result() as $row)
		{
			$course_ids[] = $row->course_id;
		}
		return $course_ids;
	}
	
	function insert_into_db()
	{
		$this->db->insert('tbl_inst_course', $this);
	}
	
	function update_db($id)
	{
		$this->db->update('tbl_inst_course', $this, "inst_course_id=$id");
	}
}
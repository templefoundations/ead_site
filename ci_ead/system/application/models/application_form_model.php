<?php
class Application_form_model extends Model
{
	private $application_form_id;
	private $registered_course_id;
	private $form_file_id;
	private $valid_flag;
	private $price;
	private $opening_date;
	private $closing_date;
	private $form_def_tbl_name;
	private $form_candidates_tbl_name;
	
	function Application_form_model()
	{
		parent::Model();
		$this->load->database();	
	}
	
	function get_data_by_id($appln_id)
	{
		$this->db->from('tbl_application_form')->where('application_form_id',$appln_id);
		$query = $this->db->get();
		if ($query->num_rows==1)
		{
			return $query->first_row();
		}
		return null;
	}
	
	function insert_into_db($data)
	{
		if (!empty($data) && is_array($data))
		{
			$this->db->insert('tbl_application_form', $data);
			return $this->db->insert_id();
		}
		return false;
	}
	
	function update_db($data, $id)
	{
		if (!empty($data) && is_array($data))
		{
			$this->db->where('application_form_id', $id);
			$this->db->update('tbl_application_form', $data);
			return $this->db->affected_rows();
		}
		return false;
	}
}
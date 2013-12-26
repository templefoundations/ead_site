<?php
class Candidate_model extends Model
{
	private $candidate_id;
	private $application_number;
	private $application_id;
	private $name;
	private $father_name;
	private $date_of_birth;
	private $email_id;
	private $applied_date;
	private $location;
	
	function __construct()
	{
		parent::Model();
		$this->load->database();	
	}
	
	function get_data_by_id($candidate_id)
	{
		$this->db->from('tbl_candidate')->where('candidate_id',$candidate_id);
		$query = $this->db->get();
		if ($query->num_rows==1)
		{
			return $query->first_row();
		}
		return null;
	}
	
	function insert_into_db($data)
	{
		if (!empty($data))
		{
			$this->db->insert('tbl_candidate', $data);
			return $this->db->insert_id();
		}
		return false;
	}
	
	function update_db($id)
	{
		$this->db->update('tbl_candidate', $this, "candidate_id=$id");
	}
}
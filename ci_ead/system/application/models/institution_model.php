<?php
class Institution_model extends Model
{
	var $inst_id;
	var $name;
	var $category_id;
	var $address;
	var $city;
	var $state;
	var $pincode;
	var $phone_numbers;
	var $email_address;
	var $logo_url;
	
	function Institution_model()
	{
		parent::Model();
		$this->load->database();	
	}
	
	function get_data_by_id($inst_id)
	{
		$this->db->from('tbl_inst')->where('inst_id',$inst_id);
		$query = $this->db->get();
		if ($query->num_rows==1)
		{
			return $query->first_row();
		}
		return null;
	}
	
	function get_data_by_name($inst_name)
	{
		$this->db->from('tbl_inst')->where('name',$inst_name);
		$query = $this->db->get();
		if ($query->num_rows==1)
		{
			return $query->first_row();
		}
		return null;
	}
	
	function get_inst_ids($inst_name)
	{
		$this->db->select('inst_id')->from('tbl_inst')->like('name',$inst_name);
		$query = $this->db->get();
		return $query->result();
	}
	
	function insert_into_db()
	{
		$this->db->insert('tbl_inst', $this);
	}
	
	function update_db($id)
	{
		$this->db->update('tbl_inst', $this, "inst_id=$id");
	}
	
}
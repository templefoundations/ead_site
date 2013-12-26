<?php
class Account_model extends Model
{
	var $account_number;
	var $account_holder_name;
	var $bank_name;
	var $bank_branch;
	var $ifsc_code;
	
	function Account_model()
	{
		parent::Model();
		$this->load->database();	
	}
	
	function insert_into_db()
	{
		$this->db->insert('tbl_account', $this);
	}
	
	function update_db($id)
	{
		$this->db->update('tbl_account', $this, "account_number=$id");
	}
}
<?php
class Message_model extends Model
{
	var $message_id;
	var $sender_name;
	var $receiver;
	var $contact_email_id;
	var $message;
	var $sent_date_time;
	var $read_flag;
	
	function Message()
	{
		parent::Model();
		$this->load->database();	
	}
	
	function insert_into_db()
	{
		$this->db->insert('tbl_message', $this);
	}
	
	function update_db($id)
	{
		$this->db->update('tbl_message', $this, "message_id=$id");
	}
}
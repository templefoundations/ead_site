<?php
class Payment_model extends Model
{
	private $payment_id;
	private $candidate_id;
	private $user_id;
	private $mode;
	private $amount;
	private $date_time;
	private $success_flag;
	private $bill_number;
	
	function Payment_model()
	{
		parent::Model();
		$this->load->database();	
	}
	
	function get_data_by_id($payment_id)
	{
		$this->db->from('tbl_payment')->where('payment_id',$payment_id);
		$query = $this->db->get();
		if ($query->num_rows==1)
		{
			return $query->first_row();
		}
		return null;
	}
	
	function insert_into_db()
	{
		$this->db->insert('tbl_payment', $this);
	}
	
	function update_db($id)
	{
		$this->db->update('tbl_payment', $this, "payment_id=$id");
	}
}
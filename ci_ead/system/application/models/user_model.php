<?php
class User_model extends Model
{
	var $user_id;
	var $username;
	var $password;
	var $type;
	var $full_name;
	var $email_id;
	var $inst_id;
	var $dept_name;
	var $phone_numbers;
	var $account_number;
	
	function User_model()
	{
		parent::Model();
		$this->load->database();	
	}
	
	function get_data($params = array())
	{
		if (!empty($params) && is_array($params) && isset($params['password']))
		{
			if (isset($params['username']))
			{
				$this->db->from('tbl_user')->where('username',$params['username']);
			}
			else if (isset($params['email']))
			{
				$this->db->from('tbl_user')->where('email_id',$params['email']);
			}
			$this->db->where('password', md5($params['password']));
			$query = $this->db->get();
			if ($query->num_rows === 1)
			{
				return $query->row_array(1);
			}
		}
		return null;
	}
	
	function insert_into_db()
	{
		$this->db->insert('tbl_user', $this);
	}
	
	function update_db($id)
	{
		$this->db->update('tbl_user', $this, "user_id=$id");
	}
}
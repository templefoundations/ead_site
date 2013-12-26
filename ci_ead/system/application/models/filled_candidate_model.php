<?php

class Filled_candidate_model extends Model
{
	public function __construct()
	{
		parent::Model();
		$this->load->database();
	}
	
	public function get_data_by_id($params = array())
	{
		if (!empty($params) && is_array($params))
		{
			if (isset($params['appln_id']))
			{
				$tbl = $this->config->item('form_candidates_tbl_prefix') . $params['appln_id'];
				$this->db->from($tbl);
				if (isset($params['filled_candidate_id']))
				{
					$this->db->where('filled_candidate_id',$params['filled_candidate_id']);
				}
				else if (isset($params['candidate_id']))
				{
					$this->db->where('candidate_id',$params['candidate_id']);
				}
				$query = $this->db->get();
				if ($query->num_rows==1)
				{
					return $query->row_array(1);
				}
			}
		}
		return null;
	}
	
	public function insert_into_db($data, $appln_id)
	{
		if (!empty($data) && is_array($data))
		{
			$tbl = $this->config->item('form_candidates_tbl_prefix') . $appln_id;
			$this->db->insert($tbl, $data);
			return $this->db->insert_id();	
		}
		return false;
	}
}
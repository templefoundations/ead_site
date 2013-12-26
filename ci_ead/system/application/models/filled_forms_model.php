<?php
class Filled_forms_model extends Model
{
	var $filled_forms_id;
	var $candidate_id;
	var $fields = array();
	
	function Filled_forms_model()
	{
		parent::Model();
		$this->load->database();	
	}
}
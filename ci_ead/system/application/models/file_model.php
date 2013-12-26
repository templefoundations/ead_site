<?php

class File_model extends Model
{
	private $file_id;
	private $file_name;
	private $file_path;
	private $full_path;
	private $file_type;
	private $raw_name;
	private $client_name;
	private $file_ext;
	private $file_size;
	private $is_image;
	private $image_width;
	private $image_height;
	private $image_type;
	private $image_size_str;
	
	function __construct()
	{
		parent::Model();
		$this->load->database();
	}
	
	function copy_data($data)
	{
		$this->file_name = $data['file_name'];
		$this->file_path = $data['file_path'];
		$this->full_path = $data['full_path'];
		$this->file_type = $data['file_type'];
		$this->raw_name = $data['raw_name'];
		$this->client_name = $data['client_name'];
		$this->file_ext = $data['file_ext'];
		$this->file_size = $data['file_size'];
		$this->is_image = $data['is_image'];
	}
	
	function insert_into_db($data)
	{
		if (!empty($data))
		{
			$this->db->insert('tbl_file', $data);
			return $this->db->insert_id();
		}
	}
	
	function update_db($id)
	{
		$this->db->update('tbl_file', $this, "file_id=$id");
	}
}
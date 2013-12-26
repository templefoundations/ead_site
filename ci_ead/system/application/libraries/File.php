<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File {

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
	private $blob_data;

	private static $CI;

	public function __construct($params = array())
	{
		self::$CI = & get_instance();
		self::$CI->load->database();

		$data = null;
		if (!empty($params['file_id']))
		{
			self::$CI->db->from('tbl_file')->where('file_id',$params['file_id']);
			$query = self::$CI->db->get();
			if ($query->num_rows() === 1)
			{
				$data = $query->row_array(1);
				$this->copy_data($data);
			}
		}
	}

	private function copy_data($data)
	{
		$this->file_id = $data['file_id'];
		$this->file_name = $data['file_name'];
		$this->file_path = $data['file_path'];
		$this->image_type = $data['image_type'];
		$this->image_width = $data['image_width'];
		$this->image_height = $data['image_height'];
		$this->blob_data = $data['blob_data'];
	}

	public function get_name()	{	return $this->file_name;	}
	public function get_image_width()	{	return $this->image_width;	}
	public function get_image_height()	{	return $this->image_height;	}
	public function get_image_type()	{	return $this->image_type;	}

	public function get_blob_data()
	{
//		return $this->blob_data;
		return strip_slashes($this->blob_data);
	}
}
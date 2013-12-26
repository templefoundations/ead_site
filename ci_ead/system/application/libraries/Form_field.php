<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_field
{
	private $field_id;
	private $group_name;
	private $label;
	private $type;
	private $type_data;
	private $validation;
	private $next_field_id;
	
	private $appln_id;
	
	public static $TEXT = "text";
	public static $LIST = "list";
	public static $FILE = "file";
	public static $TEXTAREA = "textarea";
	
	private static $CI;
	
	public function __construct($params=array())
	{
		$this->CI = & get_instance();
		$data = null;
		if (!empty($params['appln_id']) && !empty($params['field_id']))
		{
			$this->CI->load->database();
			$this->CI->db->from($this->CI->config->item('form_def_tbl_prefix').$params['appln_id']);
			$this->CI->db->where('field_id',$params['field_id']);
			$query = $this->CI->db->get();
			if ($query->num_rows==1)
			{
				$data = $query->row_array(1);
			}
			$this->appln_id = $params['appln_id'];
		}
		if ($data != null)
		{
			$this->copy_data($data);
		}
	}
	
	public function html()
	{
		$html = '';
		if ($this->type === Form_field::$LIST)
		{
			$html .= '<select name="'.$this->field_id.'">';
			$html .= '<option selected="selected" value="">-- Select --</option>';
			$html .= $this->type_data;
			$html .= '</select>';
			$value = set_value($this->field_id);
			$html = str_replace('value="'.$value.'"', 'value="'.$value.'" selected="selected"', $html);
		}
		else if ($this->type === Form_field::$TEXT)
		{
			$html .= '<input type="text" name="'.$this->field_id.'" class="textbox" '.$this->type_data.
				' value="'.set_value($this->field_id).'" />';
		}
		else if ($this->type === Form_field::$TEXTAREA)
		{
			$html .= '<textarea name="'.$this->field_id.'" '.$this->type_data.' >';
			$html .= set_value($this->field_id);
			$html .= '</textarea>';
		}
		else if ($this->type === Form_field::$FILE)
		{
			$html .= '<input type="file" name="'.$this->field_id.'" '.$this->type_data.
				'class="textbox file" size="50" value="'.set_value($this->field_id).'" />';
		}
		return $html;
	}
	
	private function copy_data($data)
	{
		$this->field_id = $data['field_id'];
		$this->group_name = $data['group_name'];
		$this->label = $data['label'];
		$this->type = $data['type'];
		$this->type_data = $data['type_data'];
		$this->validation = $data['validation'];
		$this->next_field_id = $data['next_field_id'];
	}
	
	public function get_next_field()
	{
		if ($this->next_field_id==null)
			return null;
		else
			return new Form_field(array(
					'field_id'	=> $this->next_field_id,
					'appln_id'	=> $this->appln_id,
			));
	}
	public function get_id()	{	return $this->field_id;	}
	public function get_group_name()	{	return $this->group_name;	}
	public function get_label()	{	return $this->label;	}
	public function get_type()	{	return $this->type;	}
	public function get_type_data()	{	return $this->type_data;	}
	public function get_validation()	{	return $this->validation;	}
	public function get_next_field_id()	{	return $this->next_field_id;	}
}
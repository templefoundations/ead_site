<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

get_instance()->load->library('pdf');

class Candidate
{
	private $candidate_id;
	private $application_number;
	private $application_form_id;
	private $name;
	private $father_name;
	private $date_of_birth;
	private $email_id;
	private $applied_date;
	private $location;
	
	private $field_values = array();	
	private $payment;
	
	private static $CI;
		
	public function __construct($params = array())
	{
		self::$CI = & get_instance();	
		self::$CI->load->model('candidate_model');
		
		$data = null;
		if (!empty($params['candidate_id']))
		{
			$data = self::$CI->candidate_model->get_data_by_id($params['candidate_id']);
		}
		else if (!empty($params['data']))
		{
			$data = $params['data'];
		}
		if ($data != null)
		{
			$this->copy_data($data);
		}
	}
	
	public function get_pdf()
	{
		self::$CI->load->library('file');
		self::$CI->load->library('institution');
		
		$pdf = new Candidate_pdf();
		$pdf->AddPage();
		
		// Title text for the PDF
		$inst = new Institution(array('inst_id'=>self::$CI->session->userdata('inst_id')));
		if (!empty($inst))
		{
			$pdf->SetFont('Arial','BU',13);
			$pdf->Cell(0, 7, $inst->get_name(), 0, 1, 'C');
		}
//		$pdf->SetFont('Arial','B',11);
//		$pdf->Cell(0, 7, "Application for BTech Courses", 0, 1, 'C');
		$pdf->Ln(3);
		
		$pdf->add_caption('Candidate details');
		$candidate_data = array(
			'Name' 				=> $this->name,
			'Father\'s Name'	=> $this->father_name,
			'Appln Number'		=> $this->application_number,
			'Date of Birth'		=> $this->get_date_of_birth(),
			'Email ID'			=> $this->email_id,
			'BILL ID'			=> $this->get_payment()->get_bill_number(),
		);
		
		$pdf->create_table($candidate_data);
		
		$field_data = array(array());
		$field_values = $this->get_field_values();
		$appln_form = $this->get_appliation_form();
		$field = $appln_form->get_first_field();
		$groups = array();
		do
		{
			if (array_search($field->get_group_name(),$groups) === false)
				$groups[] = $field->get_group_name();
			$field_data[$field->get_group_name()][$field->get_label()] = $field_values[$field->get_id()];
			
			$field = $field->get_next_field();
		}while ($field!=null);
		foreach ($groups as $group)
		{
			if (empty($group))
				$pdf->add_caption('Other details');
			else
				$pdf->add_caption($group);
			$group_data = $field_data[$group];
			$pdf->create_table($group_data);
		}
		
		$cert_fields = $appln_form->get_fields_by_group('Certificates');
		
		// Get the text of list of certificates attached
		$cert_text = '';
		foreach ($cert_fields as $field)
		{
			$cert_text .= $field->get_label() . ', ';
		}
		$cert_text = substr($cert_text, 0, strlen($cert_text)-2);
		
		$pdf->add_caption('Attached Certificates');
		$pdf->SetFont('Arial', 'I', 10);
		$pdf->Write(6, $cert_text);
		
		// Append the certificates in the pdf
		foreach ($cert_fields as $field)
		{
			$pdf->AddPage();
			$pdf->SetFont('Arial', 'IU', 10);
			$pdf->Write(6, $field->get_label());
			$pdf->Ln();
			$pdf->Image_from_blob(new File(array('file_id'=>$field_values[$field->get_id()])));
		}
		
		return $pdf->Output(null, 'S');
	}
	
	private function copy_data($data)
	{
		self::$CI->load->database();
		self::$CI->load->library('payment');
		if (!empty($data))
		{
			$this->candidate_id			= $data->candidate_id;
			$this->application_number 	= $data->application_number;
			$this->application_form_id	= $data->application_form_id;
			$this->name 				= $data->name;
			$this->father_name 			= $data->father_name;
			$this->date_of_birth 		= $data->date_of_birth;
			$this->email_id 			= $data->email_id;
			$this->applied_date 		= $data->applied_date;
			$this->location				= $data->location;
			
			self::$CI->db->select('payment_id')->from('tbl_payment')->where('candidate_id',$this->candidate_id);
			$query = self::$CI->db->get();
			if ($query->num_rows==1)
			{
				$payment_id = $query->first_row()->payment_id;
				$this->payment = new Payment(array('payment_id'=>$payment_id));
			}
			else
			{
				$this->payment = null;
			}
		}
	}
	
	public function get_field_values()
	{
		if (empty($this->field_values))
		{
			$this->field_values = array();
			self::$CI->load->database();
			self::$CI->db->from(self::$CI->config->item('form_candidates_tbl_prefix').$this->application_form_id);
			self::$CI->db->where('candidate_id', $this->candidate_id);
			$query = self::$CI->db->get();
			if ($query->num_rows==1)
			{
				$row = $query->row_array(1);
				$tbl_fields = self::$CI->db->list_fields(self::$CI->config->item('form_candidates_tbl_prefix').$this->application_form_id);
				foreach ($tbl_fields as $field)
				{
					if ($field=="filled_candidate_id" || $field=="candidate_id")
						continue;
					$field_id = substr($field, strlen(self::$CI->config->item('form_candidates_tbl_field_prefix')));
					$this->field_values[$field_id] = $row[$field]; 
				}
			}
		}
		return $this->field_values;
	}
	public function get_appliation_form()
	{
		self::$CI->load->library('application_form');
		return new Application_form(array('appln_id'=>$this->application_form_id));
	}
	public function get_id()	{	return $this->candidate_id;	}
	public function get_name()	{	return $this->name;	}
	public function get_father_name()	{	return $this->father_name;	}
	public function get_application_number()	{	return $this->application_number;	}
	public function get_email_id()	{	return $this->email_id;	}
	public function get_date_of_birth()	
	{	
		return date('d-M-Y', strtotime($this->date_of_birth));	
	}
	public function get_payment()	{	return $this->payment;	}
	public function get_location()	{	return $this->location;	}
}

class Candidate_pdf extends Pdf
{
	private $FIELDS_PER_ROW = 2;
	private $NAME_COL_WIDTH = 40;
	private $VALUE_COL_WIDTH = 60;
	 
	public function __construct()
	{
		parent::__construct();
	}
	
	public function add_caption($caption)
	{
		$this->SetFont('Arial','BU',10);
		$this->Cell(0, 6, $caption);
		$this->Ln();
	}
	
	public function add_name_value($name, $value, $NAME_COL_WIDTH=40, $VALUE_COL_WIDTH=60, $HEIGHT=6)
	{
		$this->SetFont('Arial','',10);		
		$this->Cell($NAME_COL_WIDTH, $HEIGHT, $name);
		$this->SetFont('Arial','B',10);
		$this->Cell($VALUE_COL_WIDTH, $HEIGHT, $value);		
	}
	
	public function create_table($data, $FIELDS_PER_ROW=2)
	{
		$keys = array_keys($data);
		$index = 1;
		foreach ($keys as $key)
		{
			// first field already have line break
			if ($index%$FIELDS_PER_ROW!=1 && $this->GetStringWidth($data[$key])>$this->VALUE_COL_WIDTH)
				$this->Ln();
			$this->add_name_value($key, $data[$key]);
			// data needs more space
			if ($this->GetStringWidth($data[$key])>$this->VALUE_COL_WIDTH)
				$this->Ln();
			// last field or last key
			else if ($index%$FIELDS_PER_ROW===0 || $key==$keys[count($keys)-1])
				$this->Ln();
			$index++;
		}
		$this->Ln();
	}
	
}
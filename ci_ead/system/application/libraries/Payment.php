<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment
{
	private $payment_id;
	private $candidate_id;
	private $user_id;
	private $mode;
	private $amount;
	private $date_time;
	private $success_flag;
	private $bill_number;
	
	private static $CI;

	public function __construct($params = array())
	{
		$this->CI = & get_instance();
		$this->CI->load->model('payment_model');
		$data = null;
		if (!empty($params['payment_id']))
		{
			$data = $this->CI->payment_model->get_data_by_id($params['payment_id']);
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
	
	private function copy_data($data)
	{
		if (!empty($data))
		{
			$this->payment_id	= $data->payment_id;
			$this->candidate_id	= $data->candidate_id;
			$this->user_id		= $data->user_id;
			$this->mode			= $data->mode;
			$this->amount		= $data->amount;
			$this->date_time	= $data->date_time;
			$this->success_flag	= $data->success_flag;
			$this->bill_number	= $data->bill_number;
		}
	}
	
	public function get_bill_number()	{	return $this->bill_number;	}
}
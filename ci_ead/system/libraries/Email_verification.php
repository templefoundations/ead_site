<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Email verification can be done by using this class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries 
 * @author 		Mike
 *
 */
class Email_verification
{
	private static $CI;
	
	public $email_msg = "(Click this button to send the verification code to the email address)";
	public $email_error_msg;
	public $vcode_msg;
	
	public function __construct()
	{
		self::$CI = & get_instance();
	}
	
	public function send_vcode($field_name = 'email_id')
	{
		self::$CI->load->helper('email');
		
		$result = true;
		if (self::$CI->input->post('send_vcode_btn')=="1")
		{
			$email_id = self::$CI->input->post($field_name);
			if (!valid_email($email_id)) {
				$this->email_error_msg = "Invalid email address";
				$result = false;
			}
			else 
			{
				$result = @mail($email_id, "Email Verification", $this->generate_vcode($email_id));
				if ($result==false)
				{
					$this->email_error_msg = "Unable to send the email. Please verify the email address";
				}
				else {
					$this->email_msg = "Verfication code sent. Check your mail and enter the verification code below";
				}
			}
		}
		return $result;
	}
	
	public function verify_email($field_name = 'vcode')
	{
		$vcode = self::$CI->input->post('vcode');
		$email_id = self::$CI->input->post('email_id');
		if ($vcode == $this->generate_vcode($email_id))
		{
			$this->vcode_msg = "Email ID verified";
			return true;
		}
		$this->vcode_msg = "Incorrect verification code. Please enter the verification code sent to the email address";
		return false;
	}
	
	private function generate_vcode($email_id)
	{
		return substr(md5($email_id), 0, 5);
	}
	
}
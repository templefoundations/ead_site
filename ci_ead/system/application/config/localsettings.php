<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI = & get_instance();

/**
 * 
 * File location for css, js, images files
 * 
 * warning: css assumes images folder to be in same location of css folder 
 * @var String
 */
/*$config['rel_system_path'] = '/ci_ead/system/';
$config['css_path'] 	= $config['rel_system_path']."application/css/";
$config['js_path'] 		= $config['rel_system_path']."application/js/";
$config['jquery_path'] 	= $config['rel_system_path']."application/js/jquery/";
$config['images_path'] 	= $config['rel_system_path']."application/images/";*/

$config['css_path'] 	= $CI->config->system_url()."application/css/";
$config['js_path'] 		= $CI->config->system_url()."application/js/";
$config['jquery_path'] 	= $CI->config->system_url()."application/js/jquery/";
$config['images_path'] 	= $CI->config->system_url()."application/images/";

$config['appln_forms_path'] = APPPATH."assets/appln_forms/";

/** 
 * Dynamic tables data form application forms
 * @var string
 */
$config['form_def_tbl_prefix'] = "tg_form_def_";
$config['form_candidates_tbl_prefix'] = "tg_form_candidates_";
$config['form_candidates_tbl_field_prefix'] = "field_";

/**
 * Re-captcha configurations
 */
$config['recaptcha_public_key'] = "6Lex7sISAAAAAN0W6PcIiYEmo4nkKteihAOKYvj-";
$config['recaptcha_private_key'] = "6Lex7sISAAAAAD_idKTPjMzI_eyeegXYgNclx4Nv"; 


/* End of file localsettings.php */
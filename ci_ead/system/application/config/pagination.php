<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Pagination configurations
 * @var string
 */
$config['per_page'] 		= '10';

$config['full_tag_open'] 	= '<div id="page_nav" align="right">';
$config['full_tag_close'] 	= '</div>';

$config['first_link'] 		= '&lt;&lt; First';
$config['first_tag_open'] 	= '<span id="page">';
$config['first_tag_close'] 	= '</span>';

$config['last_link'] 		= 'Last &gt;&gt;';
$config['last_tag_open'] 	= '<span id="page">';
$config['last_tag_close'] 	= '</span>';

$config['prev_link'] 		= '&lt; Prev';
$config['prev_tag_open'] 	= '<span id="page">';
$config['prev_tag_close'] 	= '</span>';

$config['next_link'] 		= 'Next &gt;';
$config['next_tag_open'] 	= '<span id="page">';
$config['next_tag_close'] 	= '</span>';

$config['num_tag_open'] 	= '<span id="page">';
$config['num_tag_close'] 	= '</span>';

$config['cur_tag_open'] 	= '<span id="page" class="active">';
$config['cur_tag_close'] 	= '</span>';
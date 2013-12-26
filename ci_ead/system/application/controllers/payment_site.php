<?php

class Payment_site extends Controller
{
	public function __construct()
	{
		parent::Controller();
	}
	
	public function index($candidate_id)
	{
		echo "Payment page .... pending";
		echo '<a href="'.site_url('index/home').'"> Home </a>';
	}
}
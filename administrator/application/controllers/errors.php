<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:		banners extends VCI_Controller defined in libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:Manage banners page by admin 
---------------------------------------------------------------
*/

class Errors extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		//$this->load->model('banners_model');
	}
	function e403()
	{
		echo "<h2>Forbidden access is denied</h2>"; 
		die;
	}
	
}
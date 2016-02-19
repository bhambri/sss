<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/***********************************************************************
 * Version 1.1                      
 * WWW: http://www.segnant.com
 * Author Vince Balrai
 * Modified On 13 March, 2010
 * Purpose: Landing page of the admin, Serves login screen
 ************************************************************************/
 $this->load->view('default/includes/clientstore_header');
?>
<?php $this->load->view('default/' . $vci_view);?>
	 
<?php $this->load->view('default/includes/clientstore_footer'); ?>
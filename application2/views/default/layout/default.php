<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/***********************************************************************
 * Version 1.1                      
 * WWW: http://www.segnant.com
 * Author Vince Balrai
 * Modified On 13 March, 2010
 * Purpose: Landing page of the admin, Serves login screen
 ************************************************************************/
 svci_load_view('includes/marketplace_header');
?>
	
<?php svci_load_view($vci_view);?>
	 
<?php svci_load_view('includes/marketplace_footer'); ?>
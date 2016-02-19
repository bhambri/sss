<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/***********************************************************************
 * Version 1.1                      
 * WWW: http://www.segnant.com
 * Author Vince Balrai
 * Modified On 13 March, 2010
 * Purpose: Landing page of the admin, Serves login screen
 ************************************************************************/
 //echo 'Running specific layout for stored';
 #$this->load->view('default/includes/store_header');
 svci_load_view('includes/store_header') ;
?>

<?php 
#$this->load->view('default/' . $vci_view);
svci_load_view($vci_view) ;
?>
	 
<?php #$this->load->view('default/includes/store_footer'); 
svci_load_view('includes/store_footer') ;
?>
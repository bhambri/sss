<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/***********************************************************************
 * Version 1.1                      
 * WWW: http://www.segnant.com
 * Author Vince Balrai
 * Modified On 13 March, 2010
 * Purpose: Landing page of the admin, Serves login screen
 ************************************************************************/
 
$this->load->view('smartadmin/includes/header');
?>
	<tr>
		<td valign = "middle" height="440">
		<?php $this->load->view('smartadmin/' . $vci_view);?>
	   </td>
	</tr>
<?php $this->load->view('smartadmin/includes/footer'); ?>

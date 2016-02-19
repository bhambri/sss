<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/***********************************************************************
* Version 1.1                      
* WWW: http://www.segnant.com
* Author Vince Balrai
* Modified On 28 May, 2011 By Jaidev Bangar
* Purpose: Landing page of the admin, Serves login screen
************************************************************************/
$this->load->view('default/includes/header');
?>
	<tr>
		<td>
			<?php $this->load->view('default/includes/menu');?>
		</td>
	</tr>
	<tr>
		<td valign = "middle">
			<?php $this->load->view('default/' . $vci_view);?>
	   </td>
	</tr>
<?php $this->load->view('default/includes/footer'); ?>
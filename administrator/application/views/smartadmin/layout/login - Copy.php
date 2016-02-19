<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/***********************************************************************
* Version 1.1                      
* WWW: http://www.segnant.com
* Author Vince Balrai
* Modified On 28 May, 2011 By Jaidev Bangar
* Purpose: Landing page of the admin, Serves login screen
************************************************************************/

require_once("inc/init.php");
require_once("inc/config.ui.php");

$this->load->view('smartadmin/includes/header');
$page_nav["dashboard"]["active"] = true;
$this->load->view('smartadmin/includes/nav');
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php $this->load->view('smartadmin/includes/ribbon'); ?>
	<!-- MAIN CONTENT -->
	<div id="content">
		<?php $this->load->view('smartadmin/' . $vci_view); ?>
	</div>
	<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->
<?php $this->load->view('smartadmin/includes/footer'); ?>

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Dashboard <span></span></h1>
	</div>
</div>
<?php if($this->session->flashdata('errors')): ?>
<div class="alert alert-danger fade in">
	<button class="close" data-dismiss="alert">x</button>
	<i class="fa-fw fa fa-times"></i>
	<strong>Error!</strong> <?php echo $this->session->flashdata('errors');?>
</div>
<?php endif; ?>
<!-- Errors And Message Display Row > -->
<!-- Success And Message Display Row < -->
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success fade in">
	<button class="close" data-dismiss="alert">x</button>
	<i class="fa-fw fa fa-check"></i>
	<strong>Success</strong> <?php echo $this->session->flashdata('success');?>
</div>
<?php endif; ?>
<!-- widget grid -->

<?php


// CI_Loader instance
$ci = get_instance();
$baseurl=$ci->config->item('root_url');
#echo '<pre>';
$userData  = $this->session->userdata('user') ;

$roleId = $userData['role_id'] ;
$ci->load->model('client_model');
$ci->load->model('settings_model');
if($sitename == '') {
	$cdetail = $ci->client_model->getclientfromurl() ;
	$storeid = @$cdetail[0]['id'] ;
	$roleid = @$cdetail[0]['role_id'] ;
}

$taxlink  = "taxes/manage_taxes" ;
if( $roleId ==  2){
	$storesettings = $ci->settings_model->get_store_settings_page($userData['id'] , 2);

	$ava_account_number = $storesettings->ava_account_number ;
	$ava_license_key = $storesettings->ava_license_key ;
	$ava_company_code  = $storesettings->ava_company_code ;
	if($ava_account_number || $ava_license_key || $ava_company_code){
		$taxlink = "settings/edit_settings_avatax/".$storesettings->id ;
	}
}
?>
<!-- widget grid -->
<section id="widget-grid" class="">
	<!-- row -->
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
			<div class="alert alert-info">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
						<h3 class="no-margin"><?php @printf(lang('dashboard'), date('l dS M, Y'));?></h3>
						<ul>
							<li>Total News(Simple sales sytems only): <strong width="23%"><?php echo $news; ?></strong></li>
							<li>Total Contact us(including consultant enquires also): <strong width="23%"><?php echo $contacts; ?></strong></li>
						</ul>
					</div>
				</div>
			</div>
		</article>
		<article class="col-sm-12">
			<!-- new widget -->
			<div class="jarviswidget"  data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-check txt-color-black"></i> </span>
					<h2>Shortcuts</h2>
				</header>
				<?php if($is_mlmtype ) { ?>
					<div id="desktopShortcut">
						<ul>
							<li>
								<a href="<?php echo $this->config->item('root_url'); ?>" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-home fa-4x"></i> <span>Site Home</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "contact/manage_contact"; ?>" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-pencil-square-o fa-4x"></i> <span>Contact Us</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "coupons/manage_coupons"; ?>" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-cube fa-4x"></i> <span>Coupons</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "news/manage_news"; ?>" class="jarvismetro-tile big-cubes bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-desktop fa-4x"></i> <span>News</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "order/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-list-alt fa-4x"></i> <span>Orders</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "grouppurchase/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Parties</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "user/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>Users</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "consultant/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span><?php echo $this->consultant_label ;?></span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "consultant/tree_view"; ?>" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-tree fa-4x"></i> <span><?php echo $this->consultant_label ;?> Tree View</span> </a>
							</li>
							<li>
								<?php
									$ci = get_instance();
									$ci->load->helper('vci_common');
									$ci->load->model('mahana_model');
									$userData	= get_message_user();

									$msg_count	= $ci->mahana_model->get_msg_count($userData['user_id']);
								?>
								<a href="<?php echo base_url() . "messages/listing"; ?>" class="jarvismetro-tile big-cubes bg-color-orangeDark">
									<span class="iconbox">
										<i class="fa fa-envelope fa-4x"></i> 
										<span>Mail 
											<?php if($msg_count>0) { ?>
												<span class="label pull-right bg-color-darken"><?php echo $msg_count; ?></span>
											<?php } ?>
										</span>
									</span>
								</a>
							</li>
						</ul>
					</div>
				<?php } else { ?>
					<div id="desktopShortcut">
						<ul>
							<li>
								<a href="<?php echo $this->config->item('root_url'); ?>" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-home fa-4x"></i> <span>Site Home</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "contact/manage_contact"; ?>" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-pencil-square-o fa-4x"></i> <span>Contact Us</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "news/manage_news"; ?>" class="jarvismetro-tile big-cubes bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-desktop fa-4x"></i> <span>News</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "order/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-list-alt fa-4x"></i> <span>Orders</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "user/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>Users</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "consultant/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span><?php echo $this->consultant_label ;?></span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "consultant/tree_view"; ?>" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-tree fa-4x"></i> <span><?php echo $this->consultant_label ;?> Tree View</span> </a>
							</li>
							<li>
								<?php
									$ci = get_instance();
									$ci->load->helper('vci_common');
									$ci->load->model('mahana_model');
									$userData	= get_message_user();

									$msg_count	= $ci->mahana_model->get_msg_count($userData['user_id']);
								?>
								<a href="<?php echo base_url() . "messages/listing"; ?>" class="jarvismetro-tile big-cubes bg-color-orangeDark">
									<span class="iconbox">
										<i class="fa fa-envelope fa-4x"></i> 
										<span>Mail 
											<?php if($msg_count>0) { ?>
												<span class="label pull-right bg-color-darken"><?php echo $msg_count; ?></span>
											<?php } ?>
										</span>
									</span>
								</a>
							</li>
						</ul>
					</div>
					<div id="desktopShortcut">
						<ul>
							<li>
								<a href="<?php echo base_url() . "consultant/manage_alldues"; ?>" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-list-alt fa-4x"></i> <span>All Dues Reports</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "consultant/manage_bonus"; ?>" class="jarvismetro-tile big-cubes bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-list-alt fa-4x"></i> <span>Bonus Reports</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "sales/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-list-alt fa-4x"></i> <span>Sales Tracking Report</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "consultant/topconsultantmanage"; ?>" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-list-alt fa-4x"></i> <span>Top <?php echo $this->consultant_label ;?> Report</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "consultant/manage_volume_commission"; ?>" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-list-alt fa-4x"></i> <span>Volume Commission Reports</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "consultant_sales/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-list-alt fa-4x"></i> <span><?php echo $this->consultant_label ;?> Sales Report</span> </a>
							</li>
						</ul>
					</div>
				<?php } ?>
			</div>
		</article>
	</div>
</section>
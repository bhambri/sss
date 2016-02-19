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
								<li>Total Contact us(Simple sales sytems only): <strong width="23%"><?php echo $contacts; ?></strong></li>
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
					<div id="desktopShortcut">
						<ul>
							<li>
								<a href="<?php echo $this->config->item('root_url'); ?>" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-home fa-4x"></i> <span>Site Home</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "attributesets/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-folder-open fa-4x"></i> <span>Attribute set</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "content/manage_content"; ?>" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-file-code-o fa-4x"></i> <span>Content</span> </a>
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
								<a href="<?php echo base_url() . "client/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>Client</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "banners/manage_banners"; ?>" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-picture-o fa-4x"></i> <span>Banners</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "settings/manage_settings"; ?>" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-cog fa-4x"></i> <span>Settings</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "category/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-cog fa-4x"></i> <span>Categories</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "product/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-pencil-square-o fa-4x"></i> <span>Products</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "grouppurchase/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Parties</span> </a>
							</li>
							<li>
								<a href="<?php echo base_url() . "template/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-book fa-4x"></i> <span>Invoice</span> </a>
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
				</div>
			</article>
		</div>
	</section>
<!-- END SHORTCUT AREA -->
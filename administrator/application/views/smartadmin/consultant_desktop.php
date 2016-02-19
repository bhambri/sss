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
							<li>Total News: <strong width="23%"><?php echo $news; ?></strong></li>
							<?php if($is_mlmtype) { ?>
								<li>PPVC (MLM Comp. only) : <strong width="23%">$<?php echo @$pendingcom[0]['appv_sum']; ?></strong></li>
								<li>PCVC (MLM Comp. only) : <strong width="23%">$<?php echo @$pendingcom[0]['apcv_sum']; ?></strong></li>
								<li>PBVC (MLM Comp. only) : <strong width="23%">$<?php echo @$pendingcom[0]['acbv_sum']; ?></strong></li>
							<?php } ?>
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
							<a href="<?php echo base_url() . "news/manage_news"; ?>" class="jarvismetro-tile big-cubes bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-desktop fa-4x"></i> <span>News</span> </a>
						</li>
						<li>
							<a href="<?php echo base_url() . "grouppurchase/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Parties</span> </a>
						</li>
						<li>
							<a href="<?php echo base_url() . "coupons/manage_coupons"; ?>" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-cube fa-4x"></i> <span>Coupons</span> </a>
						</li>
						<li>
							<a href="<?php echo base_url() . "order/manage"; ?>" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-book fa-4x"></i> <span>Order</span> </a>
						</li>
						<li>
							<a href="<?php echo base_url() . "settings/manage_settings"; ?>" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-cog fa-4x"></i> <span>Settings</span> </a>
						</li>
						<?php if($training_link!= ''){?>
							<li>
								<a href="<?php echo $training_link; ?>" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-cog fa-4x"></i> <span>Training</span> </a>
							</li>
						<?php } ?>
						<li>
							<a href="<?php echo base_url() . "user/tree_view/".$consultantid ;?>" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-cog fa-4x"></i> <span>Unilevel Team View</span> </a>
						</li>
						<?php if($is_mlmtype){?>
							<li>
								<a href="<?php echo base_url() . "user/consbtree_view/".$consultantid ;?>" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-cog fa-4x"></i> <span>Binary team view(MLM type comp.)</span> </a>
							</li>
						<?php } ?>
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
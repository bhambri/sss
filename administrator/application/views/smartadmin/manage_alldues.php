<div class="row">
	<div class="col-xs-12">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> <?php echo ucfirst($caption);?></h1>
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

<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget">
	<!-- widget div-->
	<div role="content">
		<!-- widget edit box -->
		<div class="jarviswidget-editbox">
			<!-- This area used as dropdown edit box -->
		</div>
		<!-- end widget edit box -->
		<!-- widget content -->
		<div class="widget-body no-padding">
			<form class="smart-form">	
				<fieldset>
					<section>
						<label class="label">Select duration to view the Sale Report</label>
						<label class="select">
							<select name="adminid" id="adminid" onchange="setSessionSalesReportDuration(this.value, '<?php echo base_url() . 'consultant/manage_alldues/' ?>', '<?php echo base_url();?>' )">
								<option value="all">Select Duration</option>
								<option value="week" <?php if( $this->session->userdata('sales_report_duration') == "week") { echo "selected=selected"; }?>>Current Week</option>
								<option value="month" <?php if( $this->session->userdata('sales_report_duration') == "month") { echo "selected=selected"; }?>>Current Month</option>
								<option value="year" <?php if( $this->session->userdata('sales_report_duration') == "year") { echo "selected=selected"; }?>>Current Year</option>
							</select>
						</label>
					</section>
				</fieldset>
			</form>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>

<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget">
	<!-- widget div-->
	<div role="content">
		<!-- widget edit box -->
		<div class="jarviswidget-editbox">
			<!-- This area used as dropdown edit box -->
		</div>
		<!-- end widget edit box -->
		<!-- widget content -->
		<div class="widget-body no-padding">
			<?php echo form_open("consultant/manage_alldues",array( 'method'=>'GET' , 'name' => 'memberListing', 'id' => 'memberListing', 'class' => "smart-form"));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
				<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
				<header>Select dates to view the Sale Report</header>
				<fieldset>
					<section>
						<label class="label">From</label>
						<label class="input">
							<input type="text" name="from_date" id="from_date" value="<?php echo @$fromdate ;?>"/>
						</label>
					</section>
					<section>
						<label class="label">To</label>
						<label class="input">
							<input type="text" name="to_date" id="to_date" value="<?php echo @$todate ?>"/>
						</label>
					</section>
				</fieldset>
				<footer>
					<button type="submit" class="btn btn-primary">Filter</button>
				</footer>
			<?php echo form_close(); ?>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>


<!-- widget grid -->
<section id="widget-grid" class="">
	<!-- row -->
	<div class="row">
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2><?php echo ucfirst($caption);?></h2>
				</header>
				<!-- widget div-->
				<div>
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->
					</div>
					<!-- end widget edit box -->
					<!-- widget content -->
					<div class="widget-body no-padding">
						<?php echo form_open("consultant/manage_alldues", array('name' => 'userListing', 'id' => 'userListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header"><span>Consultant Name</span></th>
										<th align="center" class="form_header"><span>Order Commision</span></th>
										<th align="center" class="form_header"><span>Volume Commision</span></th>
										<th align="center" class="form_header"><span>Bonus Earned</span></th>
										<th align="center" class="form_header"><span>Overrides Commision</span></th>
										<th align="center" class="form_header"><span>Total</span></th>
										<th align="center" class="form_header"><span>Created</span></th>
										<th class="form_header"  nowrap="nowrap" align="center"><span><?php echo lang('paid')?></span></th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($users) && count($users)>0) { ?>
										<?php foreach($users as $user): ?>
											<tr>
												<td align="center">
													<span><?php echo substr($user['username'],0,20)?></span>
												</td>
												<td align="center"><span><?php echo $user['order_comm'] ;?></span></td>
												<td align="center"><span>$<?php echo $user['vol_comm'] ;?></span></td>
												<td align="center"><span>$<?php echo $user['bonus_earned'] ;?></span></td>
												<td align="center"><span>$<?php echo $user['overrides_comm'] ;?></span></td>
												<td align="center"><span>$<?php echo $user['all_due'] ;?></span></td>
												<td align="center"><span><?php echo $user['created'] ;?></span></td>
												<td nowrap="nowrap" align="center">		
													<?php if(!$user['mp_merchant_id'] || !$user['mp_merchant_key']) { ?>
														<a href="<?php echo base_url();?>settings/manage_settings" title="Meritus Setting Missing"><?php echo 'Meritus Setting Missing'; ?></a>
													<?php } else if(!$user['meritus_customer_id']) {
														echo $this->consultant_label . ' Meritus Setting Missing';
													} else if($user['all_due'] > 0) {
														$statusLink = base_url() . "consultant/update_status_allcommisions/" . $user['id'] . "/" . $user['is_paid'] . "/" . $this->uri->segment(3);
													if($user['is_paid'] == 1) {
														echo '<span style="color:green;">Paid</span>';						
													} else { ?>
														<a href="<?php echo $statusLink;?>" title="Pay Now"><?php echo '<span style="color:red;">Pay Now</span>';?></a>
													<?php }
													} ?>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php } else { ?>
										<tr>
											<td colspan="9" align="center"><strong><?php echo lang('consultants_not_found')?></strong></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						<div class="dt-toolbar-footer">
						   <div class="col-sm-6 col-xs-12 hidden-xs">
						   </div>
						   <div class="col-xs-12 col-sm-6">
								<div class="dataTables_paginate paging_simple_numbers" id="dt_basic_paginate">
									<?php echo $pagination; ?>
								</div>
						   </div>
						</div>
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
			</div>
			<!-- end widget -->
		</article>
	</div>
</section>
<script>
$(function() {
	$( "#from_date,#to_date" ).datepicker({dateFormat: 'yy-mm-dd' });
});
</script>
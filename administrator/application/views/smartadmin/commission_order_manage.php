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

<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable no-padding">
	<div class="alert alert-info">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
				<ul>
					<li>Total Sum: 
						<strong width="23%">
							$<?php echo	money_format('%.2n',$reportsum[0]['sum_commision_amount']); ?>
						</strong>
					</li>
				</ul>
			</div>
		</div>
	</div>
</article>

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
						<label class="label">Select <?php echo $this->consultant_label ; ?> to view the Commission Order Report</label>
						<label class="select">
							<select name="consid" id="consid" onchange="setSessionConsSalesReport(this.value, '<?php echo base_url() . 'commission_order/commission_order_manage/' ?>', '<?php echo base_url();?>' )">
								<option value="all">Select <?php echo $this->consultant_label ; ?></option>
								<?php foreach ($consultant as $cons) { ?>
									<option value="<?php echo $cons->id; ?>" <?php if( $this->session->userdata('consultant_user_id') == $cons->id) { echo "selected=selected"; }?>><?php echo $cons->username; ?></option>
								<?php } ?>
							</select>
						</label>
						<label class="checkbox">
							<?php $checked = $this->session->userdata('consultant_include_paid'); ?>
							<input type="checkbox" name="includepaiditems"  <?php if($checked == 1){ ?> checked <?php } ?> onchange="setSessionIncludePayItems(this.checked, '<?php echo base_url() . 'commission_order/commission_order_manage/' ?>', '<?php echo base_url();?>' )"  />
							<i></i>Include Paid items
						</label>
					</section>
				</fieldset>
				<fieldset>
					<section>
						<label class="label">Select duration to view the Commission Order Report</label>
						<label class="select">
							<select name="adminid" id="adminid" onchange="setSessionSalesReportDuration(this.value, '<?php echo base_url() . 'commission_order/commission_order_manage/' ?>', '<?php echo base_url();?>' )">
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
			<?php echo form_open("commission_order/commission_order_manage",array( 'method'=>'GET' , 'name' => 'memberListing', 'id' => 'memberListing', 'class'=> "smart-form"));?>
				<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
				<header>Select dates to view the Commission Order Report</header>
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

<section class="pull-left marginBottom10">
	<button type="button" class="btn btn-labeled btn-success" onclick="submitListingForm('commissionOrderListing', '<?php echo base_url() . "commission_order/markstatus"?>','markpaid');" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-plus"></i>
		</span>
		Mark Paid
	</button>
</section>


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
						<?php echo form_open("commission_order/commission_order_manage", array('name' => 'commissionOrderListing', 'id' => 'commissionOrderListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header"><span><input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('commissionOrderListing',this);"/></span></th>
										<th align="center" class="form_header"><span><?php echo $this->consultant_label ; ?> Name</span></th>
										<th align="center" class="form_header"><span>Commission Percentage</span></th>
										<th align="center" class="form_header"><span>Commission Amount</span></th>
										<th class="form_header"  nowrap="nowrap" align="center"><span>Payment Status</span></th>
										<th class="form_header"  nowrap="nowrap" align="center"><span>Action</span></th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($commission_order_data) && count($commission_order_data)>0) { ?>
										<?php foreach($commission_order_data as $commission_order): ?>
											<tr>
												<td align="center" width="5%">
													<span><input type="checkbox" name="commission_orderid[]" value="<?php echo $commission_order->id?>" onclick="checkMasterState('commissionOrderListing', 'masterCheckField')"/></span>
												</td>
												<td align="center">
													<span>
														<?php echo $commission_order->username; ?>
													</span>
												</td>
												<td align="center">
													<span>
														<?php echo $commission_order->commision_percentage;?>
													</span>
												</td>
												<td align="center">
													<span>
														<?php echo "$".$commission_order->commision_amount;?>
													</span>
												</td>
												<td align="center">
													<span>
														<?php  if($commission_order->pay_status != 0){
																echo 'Paid' ;
															}else{
																echo 'Not paid' ;
															}

															?>
													</span>
												</td>
												<td align="center">
													<span>
														<?php $statusLink = base_url() . "commission_order/changestatus/" . $commission_order->id . "/" . $commission_order->pay_status . "/" . $this->uri->segment(3)?>

														<?php  if($commission_order->pay_status != 0){ ?>
																<a href="<?php echo $statusLink;?>">Mark not paid</a>
														<?php }else{ ?>
																<a href="<?php echo $statusLink;?>">Mark paid</a> 
														<?php	} ?>
													</span>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php } else { ?>
										<tr>
											<td colspan="6" align="center"><strong><?php echo lang('commission_order_not_found')?></strong></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						<?php echo form_close(); ?>
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
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
				<h3 class="no-margin">Total of order amount, tax and shipping</h3>
				<ul>
					<li>Total : 
						<strong width="23%">
							<?php 
								$total = $sales_all_sum[0]->sum_order_amount+$sales_all_sum[0]->sum_tax+$sales_all_sum[0]->sum_shipping;
								echo "$".$total; 
							?>
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
						<label class="select">
							<?php if(isset($this->session->userdata['user']['role_id']) && ($this->session->userdata['user']['role_id'] == 2)){ ?>
								<?php $storeid = $this->session->userdata['user']['id']; ?>
									<?php foreach ($clients_consultant as $cvalue) { ?>
										<?php if($cvalue['id'] == $storeid) { ?>
											<select name="adminid" id="adminid" onchange="setStoreConsultantSession(this.value, '<?php echo base_url() . 'sales/topsales/' ?>', '<?php echo base_url();?>' )">
												<option value="<?php echo $cvalue['id'];?>|0" <?php if( $this->session->userdata('storeId') == $cvalue['id'] ) { echo 'selected="selected"'; } ?> ><?php echo ucwords( $cvalue['name'] ); ?></option>
												<?php if(!empty($cvalue['consultant'])) { ?>
													<?php foreach ( $cvalue['consultant'] as $con) { ?>
														<option value="<?php echo $cvalue['id'].'|'.$con['id'];?>" <?php if( $this->session->userdata('consultantId') == $con['id'] ) { echo 'selected="selected"'; } ?> >--<?php echo ucwords( $con['name'] ); ?></option>
													<?php }  ?>
												<?php } ?>
											</select>
									<?php } ?>
								<?php } ?>
							<?php } ?>
						</label>
					</section>
				</fieldset>
				<fieldset>
					<section>
						<label class="label">Select duration to view the Sale Report</label>
						<label class="select">
							<select name="adminid" id="adminid" onchange="setSessionSalesReportDuration(this.value, '<?php echo base_url() . 'sales/topsales/' ?>', '<?php echo base_url();?>' )">
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
			<?php echo form_open("sales/topsales",array( 'method'=>'GET' , 'name' => 'memberListing', 'id' => 'memberListing', 'class'=> "smart-form")); ?>
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
						<?php echo form_open("sales/topsales", array('name' => 'memberListing', 'id' => 'memberListing'));?>
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header"><span>User Name</span></th>
										<th align="center" class="form_header" ><span>Transaction ID</span></th>
										<th align="center" class="form_header" ><span>Order Amount</span></th>
										<th align="center" class="form_header" ><span>Order Date</span></th>
										<th align="center" class="form_header"  nowrap="nowrap" align="center"><span>Order Status</span></th>
									</tr>
								</thead>
								<tbody>
									<?php if($sales_report) { ?>
										<?php foreach($sales_report as $report): ?>
											<tr>
												<td align="center" ><span><?php echo $report->name;?></span></td>
												<td align="center" ><span><?php echo $report->transaction_id;?></span></td>
												<td align="center" ><span><?php echo $report->order_amount;?></span></td>
												<td align="center" ><span><?php echo date("M d, Y", strtotime($report->created_time));?></span></td>
												<td align="center" >
													<span>
														<?php 
														if($report->order_status == 0){
															echo 'Pending';
														}
														if($report->order_status == 1){
															echo 'Paid';
														}
														if($report->order_status == 2){
															echo 'shipped';
														}
														if($report->order_status == 3){
															echo 'completed';
														}
														if($report->order_status == 4){
															echo 'cancelled /Refunded';
														}
														?>
													</span>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php } else { ?>
										<tr>
											<td colspan="7" align="center"><strong>No Sales Report Found.</strong></td>
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
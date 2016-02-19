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
						<label class="label">Select <?php echo $this->consultant_label ;?> to view the Sale Report</label>
						<label class="select">
							<select name="consid" id="consid" onchange="setSessionConsSalesReport(this.value, '<?php echo base_url() . 'transactions/listing/' ?>', '<?php echo base_url();?>' )">
								<option value="all">Select <?php echo $this->consultant_label ;?></option>
								<?php foreach ($consultant as $cons) { ?>
									<option value="<?php echo $cons->id; ?>" <?php if( $this->session->userdata('consultant_user_id') == $cons->id) { echo "selected=selected"; }?>><?php echo $cons->username; ?></option>
								<?php } ?>
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
			<form class="smart-form">
			<?php echo form_open("transactions/listing",array( 'method'=>'GET' , 'name' => 'transactionListing', 'id' => 'transactionListing', 'class' => "smart-form"));?>
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
						<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
							<thead>			                
								<tr>
									<th width="15%" align="center" class="form_header"><span>Date</span></th>
									<th width="15%" align="center" class="form_header"><span>Transaction Id</span></th>
									<th width="10%" align="center" class="form_header"><span><?php echo $this->consultant_label; ?></span></th>
									<th width="50%" align="center" class="form_header"><span>Remarks</span></th>
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($transactions) && count($transactions)>0) { ?>
									<?php foreach($transactions as $transaction): ?>
										<tr>
											<td align="left"><span><?php echo $transaction['date']; ?></span></td>
											<td align="left"><span><?php echo $transaction['transaction_id']; ?></span></td>
											<td align="left"><span><?php echo $transaction['user']; ?></span></td>
											<td align="left"><span><?php echo $transaction['remarks']; ?></span></td>
										</tr>
									<?php endforeach; ?>
								<?php } else { ?>
									<tr>
										<td colspan="4" align="center"><strong><?php echo 'No transaction.'; ?></strong></td>
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
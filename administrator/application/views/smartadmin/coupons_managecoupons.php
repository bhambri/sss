<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
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

<?php if($consultant_role_id!=4) { ?>
	<?php if(isset($this->session->userdata['user']['is_admin'])) { ?>
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
							<label class="label">Select to view the categories</label>
							<label class="select">
								<select name="adminid" id="adminid" onchange="setStoreSession(this.value, '<?php echo base_url() . 'coupons/manage_coupons/' ?>', '<?php echo base_url();?>' )">
									<option value="0">--Administrator--</option>
									<?php foreach ( $clients as $client ) 
									{?>
									<option value="<?php echo $client->id;?>" <?php if( $this->session->userdata('storeId') == $client->id ) { echo 'selected="selected"'; } ?> ><?php echo $client->username; ?></option>
									<?php }?>
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
	<?php } ?>

	<section class="pull-left marginBottom10">
		<button type="button" class="btn btn-labeled btn-danger" onclick="submitListingForm('couponsListing', '<?php echo base_url() . "coupons/delete_coupons"?>','delete');" >
			<span class="btn-label">
				<i class="glyphicon glyphicon-minus"></i>
			</span>
			Delete
		</button>
		<?php if(isset($this->session->userdata['user']['is_admin'])) { ?>
			<button type="button" class="btn btn-labeled btn-success" onclick="return validate_store_selection();" >
		<?php } else { ?>
			<button type="button" class="btn btn-labeled btn-success" onclick="submitListingForm('couponsListing', '<?php echo base_url() . "coupons/add_coupons"?>','new');" >
		<?php } ?>
			<span class="btn-label">
				<i class="glyphicon glyphicon-plus"></i>
			</span>
			New
		</button>
	</section>
<?php } ?>

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
					<h2>Coupons</h2>
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
						<?php echo form_open("coupons/manage_coupons", array('name' => 'couponsListing', 'id' => 'couponsListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<?php  if($consultant_role_id!=4){ ?>
											<th align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($content)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('couponsListing',this);"/></span></th>
										<?php }else{?>
											<th align="center" class="form_header"><span>Sr. No.</span></th>
										<?php } ?>
										<th align="center" class="form_header"><span>Coupon Code</span></th>
										<th align="center" class="form_header"><span>Discount Percentage</span></th>
										<th align="center" class="form_header"><span>Status</span></th>
										<th align="center" class="form_header"><span>Coupon Type</span></th>
										<th align="center" class="form_header"><span>Start Date</span></th>
										<th align="center" class="form_header"><span>Expire Date</span></th>
										<th align="center" class="form_header"><span>Created</span></th>
									</tr>
								</thead>
								<tbody>
									<?php if($content): ?>
										<?php foreach($content as $banner): ?>
											<tr>
												<?php  if($consultant_role_id!=4){ ?>
												<td align="center" width="5%"><span><input type="checkbox" name="pageids[]" value="<?php echo $banner->id?>" onclick="checkMasterState('couponsListing', 'masterCheckField')"/></span></td>
												<td align="center" ><span><a href="<?php echo base_url()?>coupons/edit_coupons/<?php echo $banner->id;?>" ><?php echo wrapstr($banner->code);?></a></span></td>
												<?php }else{ $c++ ;?>
												<td align="center" width="5%"><span><?php echo $c; ?></span></td>
												<td align="center" ><span><?php echo wrapstr($banner->code);?></span></td>
												<?php } ?>
												<td align="center"><span><?php echo $banner->discount_percent;?></span></td>

												<td align="center"><span></span>
													<?php if($consultant_role_id!=4){ 
													$statusLink = base_url() . "coupons/update_status/" . $banner->id . "/" . $banner->status . "/";// . $this->uri->segment(3);?>
													<?php if($banner->status == 1):?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
													<?php else: ?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
													<?php endif; ?>
													<?php }else{ ?>
													<?php if($banner->status == 1):?>
														<a href="" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
													<?php else: ?>
														<a href="" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
													<?php endif; ?>

													<?php } ?>
												</td>
												<td align="center">
													<span>
														<?php 
															$ctype = $banner->coupon_type_id;
															if($ctype == 1){
																echo 'Gift coupon (Amount)' ;
															}
															elseif($ctype == 2){
																echo 'Discount Coupon (%)' ;
															}
															elseif($ctype == 3){
																echo 'Use it mutiple times (%)' ;
															}
															else{

															}
														?>
													
													</span>
												</td>
												<td align="center">
													<span>
														<?php 
															if($banner->start_date != '0000-00-00 00:00:00'){
																$expire_date = strtotime($banner->start_date);
																echo date("M,d Y",$expire_date);
															}else{
																echo 'N/A';
															}
															
														?>
													
													</span>
												</td>
												<td align="center">
													<span>
														<?php 
															if($banner->expire_date != '0000-00-00 00:00:00'){
																$expire_date = strtotime($banner->expire_date);
																echo date("M,d Y",$expire_date);
															}else{
																echo 'N/A';
															}
															
														?>
													
													</span>
												</td>
												<td align="center">
													<span>
														<?php 
															$date = strtotime($banner->created);
															echo date("M,d Y",$date);
														?>
													
													</span>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr>
											<td colspan="7" align='center' ><strong>No coupons records Found.</strong></td>
										</tr>
									<?php endif;?>
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
						<?php echo form_close(); ?>
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
			</div>
			<!-- end widget -->
		</article>
	</div>
</section>

<script type="text/javascript">
function validate_store_selection() {
	var vss = document.getElementById("adminid").value;

	if( vss==null || vss==0 || vss=='0' )
	{
		alert("Please select store/client");
		return false;
	} else {
		 submitListingForm('couponsListing', '<?php echo base_url() . "coupons/add_coupons"?>','new');
	}
}
</script>
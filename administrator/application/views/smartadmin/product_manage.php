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

<article class="col-sm-12 <?php if(isset($this->session->userdata['user']['is_admin'])) { echo "col-lg-6"; } ?>" >
	<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget">
		<header role="heading">
			<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
			<h2><?php echo lang('search')?></h2>
			<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
		</header>
		<!-- widget div-->
		<div role="content">
			<!-- widget edit box -->
			<div class="jarviswidget-editbox">
				<!-- This area used as dropdown edit box -->
			</div>
			<!-- end widget edit box -->
			<!-- widget content -->
			<div class="widget-body no-padding">
				<?php echo form_open('product/manage',array('name'=>'search', 'id'=>'search', 'class' => "smart-form"));?>
					<fieldset>
						<section>
							<label class="input">
								<input type="text" name="s" id="s" class="inputbox" value="<?php echo form_prep($this->input->get_post('s'));?>" size="30" />
							</label>
						</section>
					</fieldset>
					<footer>
						<span class="mandatory"><?php echo lang('client_product_search_instructions');?></span>
						<input type="submit" value="<?php echo lang('btn_search')?>" name="submit" class="button" style="margin-bottom: 2px;" />
					</footer>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</article>

<?php if(isset($this->session->userdata['user']['is_admin'])) { ?>
<article class="col-sm-12 col-md-12 col-lg-6" >
	<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget">
		<header role="heading">
			<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
			<h2>Upload CSV</h2>
			<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
		</header>
		<!-- widget div-->
		<div role="content">
			<!-- widget edit box -->
			<div class="jarviswidget-editbox">
				<!-- This area used as dropdown edit box -->
			</div>
			<!-- end widget edit box -->
			<!-- widget content -->
			<div class="widget-body no-padding">
				<?php echo form_open("product/manage", array('name' => 'uploadCsv', 'id' => 'uploadCsv', 'enctype'=>'multipart/form-data', 'class' => "smart-form")); ?>
					<fieldset>
						<section>
							<label class="input">
								<input type="file" name="upload_xls" id="upload_xls" class="inputbox" value="">
							</label>
						</section>
					</fieldset>
					<footer>
						
							<a href="<?php echo base_url(); ?>uploads/sample.csv">View sample format</a>
						
						<input type="submit" value="Upload CSV" name="submit" class="button" style="margin-bottom: 2px;" />
						<input type="hidden" value="1" name="formSubmitted">
					</footer>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</article>
<?php } ?>
<article class="col-sm-12 col-md-12">
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
							<label class="label">Select to view the Product</label>
							<label class="select">
								<select name="adminid" id="adminid" onchange="setStoreSession(this.value, '<?php echo base_url() . 'product/manage/' ?>', '<?php echo base_url();?>' )">
									<option value="0">--Administrator--</option>
									<?php foreach($clients as $client) { ?>
										<option value="<?php echo $client->id;?>" <?php if( $this->session->userdata('storeId') == $client->id ) { echo 'selected="selected"'; } ?> >
											<?php echo $client->username; ?>
										</option>
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
<?php } ?>
</article>

<section class="pull-left marginBottom10">
	<button type="button" class="btn btn-labeled btn-danger" onclick="submitListingForm('memberListing', '<?php echo base_url() . "product/delete"?>','delete');" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-minus"></i>
		</span>
		Delete
	</button>
	<?php if(isset($this->session->userdata['user']['is_admin'])) { ?>
	<button type="button" class="btn btn-labeled btn-success" onclick="return validate_store_selection();" >
	<?php } else { ?>
	<button type="button" class="btn btn-labeled btn-success" onclick="submitListingForm('memberListing', '<?php echo base_url() . "product/add"?>','new');" >
	<?php } ?>
		<span class="btn-label">
			<i class="glyphicon glyphicon-plus"></i>
		</span>
		New
	</button>
</section>

<?php if(isset($this->session->userdata['user']['is_admin'])) { ?>
	<script type="text/javascript">
	function validate_store_selection() {
		var vss = document.getElementById("adminid").value;

		if( vss==null || vss==0 || vss=='0' ) {
			alert("Please select store/client");
			return false;
		} else {
			submitListingForm('memberListing', '<?php echo base_url() . "product/add"?>','new');
		}
	}
	</script>
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
					<h2>Products<h2>
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
						<?php echo form_open("product/manage", array('name' => 'memberListing', 'id' => 'memberListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header" width=""><span><input type="checkbox" <?php if(empty($client_product)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('memberListing',this);"/></span></th>
										<th align="center" class="form_header" ><span>Product Title</span></th>
										<th align="center" class="form_header" ><span>Uploaded Photo</span></th>
										<th align="center" class="form_header"  nowrap="nowrap" align="center"><span>Assign Attributes</span></th>
										<th align="center" class="form_header"  nowrap="nowrap" align="center"><span>AvaTax code</span></th>
										<th align="center" class="form_header"  nowrap="nowrap" align="center"><span>Status</span></th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($client_product) && count($client_product)>0): ?> 
										<?php foreach($client_product as $product): ?>
											<tr>
												<td align="center" width="5%"><span><input type="checkbox" name="client_productids[]" value="<?php echo $product->id?>" onclick="checkMasterState('memberListing', 'masterCheckField')"/></span></td>
												<td align="center" ><span><a href="<?php echo base_url()?>product/edit/<?php echo $product->id;?>" ><?php echo $product->product_title;?></a></span></td>				
												<td align="center">
													<?php
														$settings = array('w'=>100,'h'=>100,'crop'=>true);
														$image = ROOT_PATH . $product->image;
													
														if(!empty($product->image)) {
													?>
														<img src="<?php echo ROOT_PATH.'/'.image_resize( $image, $settings);?>" border='0' />
													<?php } else { 
														echo 'No image found!';
													} ?>
												</td>
												<td nowrap="nowrap" align="center">
													<a href="<?php echo base_url() . "attributesets/assign_attribute/" . $product->id?>"> Assign Attribute</a>
												</td>
												<td nowrap="nowrap" align="center">
													<input type="text" id="<?php echo $product->id; ?>" onchange="updatetaxcode(<?php echo $product->id; ?>);" value="<?php echo $avatax[$product->id] ;?>" />
												</td>				
												<td nowrap="nowrap" align="center">					
													<?php $statusLink = base_url() . "product/update_status/" . $product->id . "/" . $product->status . "/" . $this->uri->segment(3)?>
													<?php if($product->status == 1):?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
													<?php else: ?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr>
											<td colspan="5" align='center' ><strong>No client Product Found.</strong></td>
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
<script>
function updatetaxcode(pid) {
	textval = jQuery('#'+pid).val() ;
	productid = pid ;

	jQuery.ajax({
		type:'POST',
		url :  '/administrator/product/updatetaxcode',
		data: 'product_id='+productid+'&tax_code='+textval ,
		success: function(result)
		{
			if( result == 1 )
			{
				// alert('The product is added to your wishlist.');
			}
			else
			{
			   alert('ATX code updation failed'); 
			}
		},
		error: function(error)
		{
			alert(JSON.stringify(error)+'Some error occured. Please try again later');
		}
	});
}
</script>
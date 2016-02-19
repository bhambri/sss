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
							<label class="label">Select to view the Contacts</label>
							<label class="select">
								<select name="adminid" id="adminid" onchange="setStoreSession(this.value, '<?php echo base_url() . 'contact/manage_contact/' ?>', '<?php echo base_url();?>' )">
									<option value="0">--Administrator--</option>
									<?php foreach($clients as $client) { ?>
										<option value="<?php echo $client->id;?>" <?php if( $this->session->userdata('storeId') == $client->id ) { echo 'selected="selected"'; } ?> ><?php echo $client->username; ?></option>
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
	
<section class="pull-left marginBottom10">
	<button type="button" class="btn btn-labeled btn-danger" onclick="submitListingForm('contactListing', '<?php echo base_url() . "contact/delete_contact"?>','delete');" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-minus"></i>
		</span>
		Delete
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
						<?php echo form_open("contact/manage_contact", array('name' => 'contactListing', 'id' => 'contactListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($contact)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('contactListing',this);"/></span></th>
										<th align="center" class="form_header"><span>Name</span></th>
										<th align="center" class="form_header"><span>Email</span></th>
										<th align="center" class="form_header"><span>Request Date</span></th>
									</tr>
								</thead>
								<tbody>
									<?php if($contact): ?>
										<?php foreach($contact as $page): ?>
											<tr>
												<td align="center" width="5%"><span><input type="checkbox" name="pageids[]" value="<?php echo $page->id?>" onclick="checkMasterState('contactListing', 'masterCheckField')"/></span></td>
												<td align="center" ><span><a href="<?php echo base_url()?>contact/view_contact/<?php echo $page->id;?>" ><?php echo wrapstr($page->name);?></a></span></td>
												<td align="center"><span><?php echo wrapstr($page->email);?></span></td>
												<td align="center">
													<span>
														<?php 
															$date = strtotime($page->date);
															echo date("M, d Y",$date);
														?>
													</span>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr>
											<td colspan="7" align='center' ><strong>No Contact records Found.</strong></td>
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
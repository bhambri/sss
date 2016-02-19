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
	<?php $nametodisplay = 'Administrator'; ?>
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
								<select name="adminid" id="adminid" onchange="setRoleAndUserIdSession(this.value, '<?php echo base_url() . 'settings/manage_settings/' ?>', '<?php echo base_url();?>' )">
									<option value="1||||1">--Administrator--</option>
									<?php foreach ($clients_consultant as $cc) { ?>
										<option value="<?php echo $cc['role_id'];?>||||<?php echo $cc['id'];?>" <?php if( $this->session->userdata('userId') == $cc['id'] && $this->session->userdata('roleId') == 2 ) { echo 'selected="selected"'; $nametodisplay = $cc['name']; } ?> ><?php echo ucwords( $cc['name'] ); ?></option>
										<?php if( !empty( $cc['consultant'] ) ) { ?>
											<?php foreach($cc['consultant'] as $con) { ?>
												<option value="<?php echo $con['role_id'].'||||'.$con['id'];?>" <?php if( $this->session->userdata('userId') == $con['id'] && $this->session->userdata('roleId') == 4 ) { echo 'selected="selected"'; $nametodisplay = $con['username']; } ?> >--<?php echo ucwords( $con['username'] ); ?></option>
											<?php } ?>
										<?php } ?>	
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
<?php } else { ?>
	<?php $nametodisplay = $this->session->userdata['user']['username'];?>
<?php } ?>

<section class="pull-left marginBottom10">
	<button type="button" class="btn btn-labeled btn-danger" onclick="submitListingForm('settingsListing', '<?php echo base_url() . "settings/delete_settings"?>','delete');" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-minus"></i>
		</span>
		Delete
	</button>
	<?php if($this->session->userdata('settingsExists') == false) { ?>
		<button type="button" class="btn btn-labeled btn-success" onclick="submitListingForm('settingsListing', '<?php echo base_url() . "settings/add_settings"?>','new');" >
			<span class="btn-label">
				<i class="glyphicon glyphicon-plus"></i>
			</span>
			New
		</button>
	<?php } ?>
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
						<?php echo form_open("settings/manage_settings", array('name' => 'settingsListing', 'id' => 'settingsListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header" ><span><input type="checkbox"  <?php if(empty($content)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('settingsListing',this);"/></span></th>
										<th align="center" class="form_header"><span>Name</span></th>
										<th align="center" class="form_header"><span>Logo Image</span></th>
										<th align="center" class="form_header"><span>Settings</span></th>
										<th align="center" class="form_header"><span>Status</span></th>
										<th align="center" class="form_header"><span>Created</span></th>
									</tr>
								</thead>
								<tbody>
									<?php if($content): ?>
										<?php foreach($content as $banner): ?>
											<tr>
												<td align="center" width="5%"><span><input type="checkbox" name="pageids[]" value="<?php echo $banner->id?>" onclick="checkMasterState('settingsListing', 'masterCheckField')"/></span></td>
												<td align="center"><?php echo $nametodisplay; ?></td>
												<td align="center"><span><?php //echo $banner->logo_image;?></span>
												<?php $settings = array('w'=>100,'h'=>100,'crop'=>true);
													 $image = $_SERVER['DOCUMENT_ROOT'].'/' . $banner->logo_image;
													
												?>
													<a href="<?php echo base_url()?>settings/edit_settings/<?php echo $banner->id;?>" ><img src="<?php echo image_resize( $image, $settings)?>" border='0' /></a></span>
												</td>
												<?php if(isset($banner->role_id) && (($banner->role_id ==4 ) || ($banner->role_id ==1 ))){ ?>
												<td align="center"><span><a href="<?php echo base_url()?>settings/edit_settings/<?php echo $banner->id;?>">Logo & Social Media</a></span></td>
												
												<?php } else{ ?>			
												
												<td align="center"><span><a href="<?php echo base_url()?>settings/edit_settings_paypal/<?php echo $banner->id;?>" >Paypal</a> | <a href="<?php echo base_url()?>settings/edit_settings_meritus/<?php echo $banner->id;?>" > Meritus </a> | <a href="<?php echo base_url()?>settings/edit_settings_avatax/<?php echo $banner->id;?>">AvaTax settings</a>|<a href="<?php echo base_url()?>settings/testavatax_connection/<?php echo $banner->id;?>"> Test AvaTax</a> | <a href="<?php echo base_url()?>settings/edit_settings/<?php echo $banner->id;?>">Logo & Social Media</a></span></td>
												<?php } ?>		
												<td align="center"><span></span>
													<?php 
													$statusLink = base_url() . "settings/update_status/" . $banner->id . "/" . $banner->status . "/";// . $this->uri->segment(3);?>
													<?php if($banner->status == 1):?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
													<?php else: ?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
													<?php endif; ?>
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
											<td colspan="7" align='center' ><strong>No Settings records Found.</strong></td>
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
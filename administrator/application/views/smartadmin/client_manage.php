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

<section class="pull-left marginBottom10">
	<button type="button" class="btn btn-labeled btn-danger" onclick="submitListingForm('clientListing', '<?php echo base_url() . "client/delete_client"?>','delete');" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-minus"></i>
		</span>
		Delete
	</button>
	<button type="button" class="btn btn-labeled btn-success" onclick="submitListingForm('clientListing', '<?php echo base_url() . "client/add"?>','new');" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-plus"></i>
		</span>
		New
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
					<h2>Orders</h2>
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
						<?php echo form_open("client/manage", array('name' => 'clientListing', 'id' => 'clientListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header" ><span><input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('clientListing',this);"/></span></th>
										<th align="center" class="form_header"><span><?php echo lang('full_name')?></span></th>
										<th align="center" class="form_header"><span>Email</span></th>
										<th align="center" class="form_header"><span>Action</span></th>
										<th align="center" class="form_header"><span>Theme Enabled</span></th>
										<th class="form_header"  nowrap="nowrap" align="center"><span><?php echo lang('active')?></span></th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($clients) && count($clients)>0): ?> 
										<?php foreach($clients as $client): ?>
											<tr>
												<td align="center" width="5%">
													<?php	//if($client->clientname != $this->session->clientdata['client']['clientname']):?>
															<span><input type="checkbox" name="clientids[]" value="<?php echo $client->id?>" onclick="checkMasterState('clientListing', 'masterCheckField')"/></span>
													<?php //endif; ?>
												</td>
												<td align="left"><span><a href="<?php echo base_url(). 'client/edit/id/'.$client->id; ?>"><?php echo ucwords($client->fName);?></a></span></td>
												<td align="left"><span><?php echo $client->email;?></span></td>
												<td align="left">
													<span>
														Manage <?php echo ucwords($client->fName).'\'s '; ?>(
															<a href="javascript:void(0)" onclick="setStoreSession( <?php echo $client->id;?>, '<?php echo base_url() . 'user/manage/' ?>', '<?php echo base_url();?>' )">Users</a>,
															<a href="javascript:void(0)" onclick="setStoreSession( <?php echo $client->id;?>, '<?php echo base_url() . 'consultant/manage/' ?>', '<?php echo base_url();?>' )">Consultants</a>,
															<a href="javascript:void(0)" onclick="setStoreSession( <?php echo $client->id;?>, '<?php echo base_url() . 'product/manage/' ?>', '<?php echo base_url();?>' )">Products</a>, 
															<a href="javascript:void(0)" onclick="setStoreSession( <?php echo $client->id;?>, '<?php echo base_url() . 'news/manage_news/' ?>', '<?php echo base_url();?>' )">News</a>,
															<!--a href="javascript:void(0)" onclick="setStoreSession( <?php echo $client->id;?>, '<?php echo base_url() . 'client/change_password/'.$client->id; ?>', '<?php echo base_url();?>' )">Change Password</a-->
															<a href="<?php echo base_url() . 'client/change_password_client/'.$client->id; ?>">Change Password</a>
														)
													</span>
												</td>
												<td nowrap="nowrap" align="center">
												<?php 
													$is_custom_theme = 1;
													if ( $client->is_custom_theme == 1 )
														$is_custom_theme = 0;

													$is_custom_themeLink = base_url() . "client/update_theme_option/" . $client->id . "/" . $is_custom_theme . "/" . $this->uri->segment(3); ?>

												
													<?php if($client->is_custom_theme == 1):?>
														<a onclick="return confirm('Are you sure to change settings related to theme as it may change the view for that store ?') ;" href="<?php echo $is_custom_themeLink ;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
													<?php else: ?>
														<a onclick="return confirm('Are you sure to change settings related to theme as it may change the view for that store ?') ;" href="<?php echo $is_custom_themeLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
													<?php endif; ?>
												</td>
												<td nowrap="nowrap" align="center">
												<?php $status = 1;
													if ( $client->status == 1 )
														$status = 0;
													$statusLink = base_url() . "client/update_status/" . $client->id . "/" . $status . "/" . $this->uri->segment(3); ?>
													<?php if($client->status == 1):?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
													<?php else: ?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr>
											<td colspan="5" align='center' ><strong><?php echo lang('clients_not_found')?></strong></td>
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
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
	<button type="button" class="btn btn-labeled btn-danger" onclick="submitListingForm('userListing', '<?php echo base_url() . "consultant/delete"; ?>','delete');" >
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
					<h2>Consultants</h2>
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
						<?php echo form_open("consultant/manage", array('name' => 'userListing', 'id' => 'userListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($users)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('userListing',this);"/></span></th>
										<th align="center" class="form_header"><span>User Name</span></th>
										<th align="center" class="form_header"><span>Executive level(current/Highest)</span></th>
										<th align="center" class="form_header"><span><?php echo lang('full_name')?></span></th>
										<th align="center" class="form_header"><span>Payment Profile(paypal)</span></th>
										<th class="form_header"  nowrap="nowrap" align="center"><span><?php echo lang('active')?></span></th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($users) && count($users)>0): ?> 
										<?php foreach($users as $user): ?>
											<tr>
												<td align="center" width="5%">
													<?php	if($user['username'] != $this->session->userdata['user']['username']):?>
															<span><input type="checkbox" name="userids[]" value="<?php echo $user['id']; ?>" onclick="checkMasterState('userListing', 'masterCheckField')"/></span>
													<?php endif; ?>
												</td>
												<td align="center">
													<span>
														<a href="<?php echo base_url()?>consultant/edit_consultant/<?php echo $user['id'];?>" >
															<?php echo substr($user['username'],0,20); ?>
														</a>
													</span>
												</td>
												<td align="center"><span>
													<?php
													error_reporting(1);
													$CI =& get_instance();

													echo $resultset = $CI->get_exe_lvl($user['id']);
													echo '/ '.$helvl = $CI->get_hexe_lvl($user['id']);
													?>
													</span>
												</td>
												<td align="center"><span><?php echo $user['name'] ;?></span></td>
												<td align="center"><span><?php echo htmlspecialchars( $user['profile_id'] != ''? $user['profile_id'] : 'Payment Failed' ) ;?></span></td>
												<td nowrap="nowrap" align="center">					
												<?php $statusLink = base_url() . "consultant/update_status/" . $user['id'] . "/" . $user['status'] . "/" . $this->uri->segment(3)?>
												<?php if($user['username'] == $this->session->userdata['user']['username']): ?>
													<?php if($user->status == 1):?>
														<img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/>
													<?php else: ?>
														<img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/>
													<?php endif; ?>
												<?php else: ?>
													<?php if($user['status'] == 1):?>
														<a onclick="return confirm('Are you sure, you want to deactivate this '+<?php echo $this->consultant_label ; ?>);" href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
													<?php else: ?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
													<?php endif; ?>
												<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr>
											<td colspan="5" align='center' ><strong><?php echo lang('consultants_not_found')?></strong></td>
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

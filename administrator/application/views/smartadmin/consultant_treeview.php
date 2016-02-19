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
	<button type="button" class="btn btn-labeled btn-success" onclick="javascript:window.location.href='<?php echo base_url(); ?>consultant/tree_view';" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-backward"></i>
		</span>
		Back to Main Parent
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
						<?php echo form_open("banners/manage_banners", array('name' => 'bannersListing', 'id' => 'bannersListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header"><span>User Name</span></th>
										<th align="center" class="form_header"><span><?php echo lang('full_name')?></span></th>
										<th class="form_header"  nowrap="nowrap" align="center"><span>Action</span></th> 
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($consultant) && count($consultant)>0): ?>
										<?php foreach($consultant as $user): ?>
											<tr>
												<td align="center">
													<span><?php echo substr($user->username,0,20); ?></span>
												</td>
												<td align="center">
													<span><?php echo $user->name ;?></span>
												</td>
												<td nowrap="nowrap" align="center">					
													<span><a href="<?php echo base_url().'consultant/tree_view?id='.$user->id.'&uname='.$user->username; ?>">View Child <?php echo $this->consultant_label ; ?></a></span> | <span><a href="<?php echo base_url().'user/tree_view/'.$user->id ?>">View Tree</a></span>
													<?php if($is_mlmtype){ ?> |
														<span><a href="<?php echo base_url().'user/btree_view/'.$user->id ?>">Binary Tree View</a></span>
													<?php } ?>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr>
											<td colspan="3" align='center' ><strong><?php echo lang('consultants_not_found')?>.</strong></td>
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
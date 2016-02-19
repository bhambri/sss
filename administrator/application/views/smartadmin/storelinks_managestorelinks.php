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
	<button type="button" class="btn btn-labeled btn-danger" onclick="submitListingForm('storelinksListing', '<?php echo base_url() . "storelinks/delete_storelinks"?>','delete');" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-minus"></i>
		</span>
		Delete
	</button>
	<button type="button" class="btn btn-labeled btn-success" onclick="submitListingForm('storelinksListing', '<?php echo base_url() . "storelinks/add_storelinks"?>','new');" >
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
						<?php echo form_open("storelinks/manage_storelinks", array('name' => 'storelinksListing', 'id' => 'storelinksListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<td align="center" class="form_header" ><span><input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('storelinksListing',this);"/></span></td>
										<td align="center" class="form_header"><span>Title</span></td>
										<td align="center" class="form_header"><span>Image</span></td>
										<td align="center" class="form_header"><span>Link To</span></td>
										<td align="center" class="form_header"><span>Status</span></td>
										<td align="center" class="form_header"><span>Created</span></td>
									</tr>
								</thead>
								<tbody>
									<?php if($content): ?>
										<?php foreach($content as $banner): ?>
											<tr>
												<td align="center" width="5%"><span><input type="checkbox" name="pageids[]" value="<?php echo $banner->id?>" onclick="checkMasterState('storelinksListing', 'masterCheckField')"/></span></td>
												<td align="center" ><span><a href="<?php echo base_url()?>storelinks/edit_storelinksnew/<?php echo $banner->id;?>" ><?php echo wrapstr($banner->title);?></a></span></td>
												<td align="center"><span><img src="<?php echo '../..'.$banner->image;?>" width="100px" height="100px" /></span></td>
												<td align="center"><span><?php echo wrapstr($banner->link);?></span></td>
												<td align="center"><span></span>
													<?php 
													$statusLink = base_url() . "storelinks/update_status/" . $banner->id . "/" . $banner->status . "/";// . $this->uri->segment(3);?>
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
											<td colspan="6" align='center' ><strong>No storelinks records Found.</strong></td>
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
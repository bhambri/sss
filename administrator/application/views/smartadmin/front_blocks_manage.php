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
	<button type="button" class="btn btn-labeled btn-danger" onclick="submitListingForm('frontBlocksListing', '<?php echo base_url() . "front_blocks/front_blocks_delete"?>','delete');" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-minus"></i>
		</span>
		Delete
	</button>
	<button type="button" class="btn btn-labeled btn-success" onclick="submitListingForm('frontBlocksListing', '<?php echo base_url() . "front_blocks/front_blocks_new"?>','new');" >
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
					<h2>Attribute Sets</h2>
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
						<?php echo form_open("front_blocks/front_blocks_manage", array('name' => 'frontBlocksListing', 'id' => 'frontBlocksListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($front_blocks)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('frontBlocksListing',this);"/></span></th>
										<th align="center" class="form_header"><span>Block Name</span></th>
										<th align="center" class="form_header"><span>Image Text</span></th>
										<th align="center" class="form_header"><span>Image</span></th>
										<th align="center" class="form_header"><span>Link</span></th>
										<th class="form_header"  nowrap="nowrap" align="center"><span>Priority</span></th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($front_blocks) && count($front_blocks)>0):
										foreach($front_blocks as $blocks):
										?>
										<tr class="<?php echo $rowClass?>">
											<td align="center" width="5%">
												<span>
													<input type="checkbox" name="blockids[]" value="<?php echo $blocks->id?>" onclick="checkMasterState('frontBlocksListing', 'masterCheckField')"/>
												</span>
											</td>
											<td align="center">
												<span>
													<a href="<?php echo base_url()?>front_blocks/front_blocks_edit/<?php echo $blocks->id;?>" ><?php echo $blocks->title; ?></a>
												</span>
											</td>
											<td align="center"><span><?php echo $blocks->image_text;?></span></td>
											<td align="center"><span><img src="<?php echo $blocks->image;?>" /></span></td>
											<td align="center"><span><?php echo $blocks->link;?></span></td>
											<td width="7%" align="center"><span><?php echo $blocks->priority;?></span></td>
										</tr>
										<?php endforeach; ?>
									<?php endif; ?>
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
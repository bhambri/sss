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

<section class="pull-left marginBottom10">
	<button type="button" class="btn btn-labeled btn-danger" onclick="submitListingForm('executiveListing', '<?php echo base_url() . "executives/executive_delete"?>','delete');" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-minus"></i>
		</span>
		Delete
	</button>
	<button type="button" class="btn btn-labeled btn-success" onclick="submitListingForm('executiveListing', '<?php echo base_url() . "executives/executive_new"?>','new');" >
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
						<?php echo form_open("executives/executive_manage", array('name' => 'executiveListing', 'id' => 'executiveListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($executives)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('executiveListing',this);"/></span></th>
										<th align="center" class="form_header"><span>Executive Level</span></th>
										<th align="center" class="form_header"><span>Direct Commission (%)</span></th>
										<th class="form_header"  nowrap="nowrap" align="center"><span>Generation Access</span></th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($executives) && count($executives)>0): ?>
										<?php foreach($executives as $executive): ?>
											<tr>
												<td align="center" width="5%">
													<span><input type="checkbox" name="executiveids[]" value="<?php echo $executive->id?>" onclick="checkMasterState('executiveListing', 'masterCheckField')"/></span>
												</td>
												<td align="center">
													<span><a href="<?php echo base_url()?>executives/executive_edit/<?php echo $executive->id;?>" ><?php echo $executive->executive_level; ?></a></span>
												</td>
												<td align="center"><span><?php echo $executive->direct_commision;?></span></td>
												<td align="center"><span><?php echo $executive->generation_access;?></span></td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr class='row0'>
											<td colspan="4" align='center' ><strong><?php echo lang('executive_not_found')?></strong></td>
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

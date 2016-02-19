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
	<?php if($check_store_exist==1) { ?>
	<button type="button" class="btn btn-labeled btn-success" onclick="javascript:window.location.href='<?php echo base_url(); ?>consultant/commission_setting_edit/<?php echo $commission_setting[0]->id; ?>';" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-edit"></i>
		</span>
		Edit Commission Setting
	</button>
	<?php } else { ?>
	<button type="button" class="btn btn-labeled btn-success" onclick="javascript:window.location.href='<?php echo base_url(); ?>consultant/commission_setting_add';" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-plus"></i>
		</span>
		Add Commission Setting
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
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header"><span>Level 1</span></th>
										<th align="center" class="form_header"><span>Level 2</span></th>
										<th align="center" class="form_header"><span>Level 3</span></th>
										<th align="center" class="form_header"><span>Level 4</span></th>
										<th align="center" class="form_header"><span>Level 5</span></th>
										<th align="center" class="form_header"><span>Level 6</span></th>
										<th class="form_header"  nowrap="nowrap" align="center"><span>Action</span></th> 
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($commission_setting) && count($commission_setting)>0): ?>
										<?php foreach($commission_setting as $comm_setting): ?>
											<tr>
												<td align="center">
													<span><?php echo $comm_setting->level1."%"; ?></span>
												</td>
												<td align="center">
													<span><?php echo $comm_setting->level2."%"; ?></span>
												</td>
												<td align="center">
													<span><?php echo $comm_setting->level3."%"; ?></span>
												</td>
												<td align="center">
													<span><?php echo $comm_setting->level4."%"; ?></span>
												</td>
												<td align="center">
													<span><?php echo $comm_setting->level5."%"; ?></span>
												</td>
												<td align="center">
													<span><?php echo $comm_setting->level6."%"; ?></span>
												</td>
												<td nowrap="nowrap" align="center">
													<?php $status = 1;
													if($comm_setting->status == 1) {
														$status = 0;
													}
													$statusLink = base_url() . "consultant/commission_update_status/" . $comm_setting->id . "/" . $status; ?>
													<?php if($comm_setting->status == 1):?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
													<?php else: ?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr class='row0'>
											<td colspan="7" align='center' ><strong><?php echo lang('comm_setting_not_found')?></strong></td>
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
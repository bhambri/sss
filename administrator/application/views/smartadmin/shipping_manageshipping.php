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
						<?php echo form_open("shipping/manage_shipping", array('name' => 'shippingListing', 'id' => 'shippingListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header"><span>Shipping State</span></th>
										<th align="center" class="form_header"><span>State Code</span></th>
										<th align="center" class="form_header"><span>Cost(<= 500 g)</span></th>
										<th align="center" class="form_header"><span>Cost(501 to 1000g)</span></th>
										<th align="center" class="form_header"><span>Cost(1001 to 1500 g)</span></th>
										<th align="center" class="form_header"><span>Cost(1501 g to 2000g)</span></th>
										<th align="center" class="form_header"><span>Cost(2001g and above)</span></th>
										<th align="center" class="form_header"><span>Action</span></th>
									</tr>
								</thead>
								<tbody>
									<?php if($content): ?>
										<?php foreach($content as $shipping_states): ?>
											<tr>
												<td align="center"><span><?php echo $shipping_states->state;?></span></td>
												<td align="center" ><span><a href="<?php if($shipping_states->id){ ?><?php echo base_url()?>shipping/edit_shipping/<?php echo $shipping_states->id;?>/<?php echo base64_encode($shipping_states->state); ?><?php }else{  ?><?php echo base_url()?>shipping/add_shipping/<?php echo base64_encode($shipping_states->state);?>/<?php echo base64_encode($shipping_states->state_code); ?> <?php } ?>" ><?php echo wrapstr($shipping_states->state_code);?></a></span></td>
												<td align="center"><span><?php echo $shipping_states->w1 ? $shipping_states->w1 :'NA' ;?></span></td>
												<td align="center"><span><?php echo $shipping_states->w2 ? $shipping_states->w2 :'NA';?></span></td>
												<td align="center"><span><?php echo $shipping_states->w3 ? $shipping_states->w3 :'NA';?></span></td>
												<td align="center"><span><?php echo $shipping_states->w4 ? $shipping_states->w4 :'NA';?></span></td>
												<td align="center"><span><?php echo $shipping_states->w5 ? $shipping_states->w5 :'NA';?></span></td>
												<td align="center" ><span><a href="<?php if($shipping_states->id){ ?><?php echo base_url()?>shipping/edit_shipping/<?php echo $shipping_states->id;?>/<?php echo base64_encode($shipping_states->state); ?><?php }else{  ?><?php echo base_url()?>shipping/add_shipping/<?php echo base64_encode($shipping_states->state);?>/<?php echo base64_encode($shipping_states->state_code); ?> <?php } ?>" ><?php echo $shipping_states->id ? 'Edit': 'Add' ;?></a></span></td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr class='row0'>
											<td colspan="7" align='center' ><strong>No shipping records Found.</strong></td>
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
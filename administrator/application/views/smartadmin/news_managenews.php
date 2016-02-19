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

<?php if(isset($this->session->userdata['user']['is_admin']))  { ?>
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
					<?php if(isset($this->session->userdata['user']['is_admin'])  && ($this->session->userdata['user']['role_id'] == 2))  { ?>
						<?php $storeid = $this->session->userdata['user']['id']; ?>
						<?php foreach ($clients_consultant as $cvalue) { ?>
							<?php if($cvalue['id'] == $storeid) { ?>
								<section>
									<label class="label">Select to view the news</label>
									<label class="select">
										<select name="adminid" id="adminid" onchange="setStoreConsultantSession(this.value, '<?php echo base_url() . 'news/manage_news/' ?>', '<?php echo base_url();?>' )">
											<option value="0">--Administrator--</option>
											<?php foreach ( $clients_consultant as $cc ) { ?>
												<option value="<?php echo $cc['id'];?>|0" <?php if( $this->session->userdata('storeId') == $cc['id'] ) { echo 'selected="selected"'; } ?> ><?php echo ucwords( $cc['name'] ); ?></option>
												<?php  if( !empty( $cc['consultant'] ) ) { ?>
													<?php foreach ( $cc['consultant'] as $con) { ?>
														<option value="<?php echo $cc['id'].'|'.$con['id'];?>" <?php if( $this->session->userdata('consultantId') == $con['id'] ) { echo 'selected="selected"'; } ?> >--<?php echo ucwords( $con['username'] ); ?></option>
													<?php } ?>
												<?php } ?>	
											<?php } ?>
										</select>
										<i></i>
									</label>
								</section>
							<?php } ?>
						<?php } ?>
					<?php } ?>
					<?php if(isset($this->session->userdata['user']['is_admin']))  { ?>
						<section>
							<label class="label">Select to view the news</label>
							<label class="select">
								<select name="adminid" id="adminid" onchange="setStoreConsultantSession(this.value, '<?php echo base_url() . 'news/manage_news/' ?>', '<?php echo base_url();?>' )">
									<option value="0">--Administrator--</option>
									<?php foreach ( $clients_consultant as $cc ) { ?>
										<option value="<?php echo $cc['id'];?>|0" <?php if( $this->session->userdata('storeId') == $cc['id'] ) { echo 'selected="selected"'; } ?> ><?php echo ucwords( $cc['name'] ); ?></option>
										<?php  if( !empty( $cc['consultant'] ) ) { ?>
											<?php foreach ( $cc['consultant'] as $con) { ?>
												<option value="<?php echo $cc['id'].'|'.$con['id'];?>" <?php if( $this->session->userdata('consultantId') == $con['id'] ) { echo 'selected="selected"'; } ?> >--<?php echo ucwords( $con['username'] ); ?></option>
											<?php } ?>
										<?php } ?>	
									<?php } ?>
								</select>
								<i></i>
							</label>
						</section>
					<?php } ?>
				</fieldset>
			</form>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>
<?php } ?>
<section class="pull-left marginBottom10">
	<button type="button" class="btn btn-labeled btn-danger" onclick="submitListingForm('newsListing', '<?php echo base_url() . "news/delete_news"?>','delete');" >
		<span class="btn-label">
			<i class="glyphicon glyphicon-minus"></i>
		</span>
		Delete
	</button>
	<button type="button" class="btn btn-labeled btn-success" onclick="submitListingForm('newsListing', '<?php echo base_url() . "news/add_news"?>','new');" >
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
					<h2>News</h2>
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
						<?php echo form_open("news/manage_news", array('name' => 'newsListing', 'id' => 'newsListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
							<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
								<thead>			                
									<tr>
										<th align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($content)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('newsListing',this);"/></span></th>
										<th align="center" class="form_header"><span>Title</span></th>
										<th align="center" class="form_header"><span>Short Description</span></th>
										<th align="center" class="form_header"><span>Status</span></th>
										<th align="center" class="form_header"><span>Created</span></th>
									</tr>
								</thead>
								<tbody>
									<?php if($content): ?>
										<?php foreach($content as $page): ?>
											<tr>
												<td align="center" width="5%"><span><input type="checkbox" name="pageids[]" value="<?php echo $page->id?>" onclick="checkMasterState('newsListing', 'masterCheckField')"/></span></td>
												<td align="center" ><span><a href="<?php echo base_url()?>news/edit_newsnew/<?php echo $page->id;?>" ><?php echo wrapstr($page->page_title);?></a></span></td>
												<td align="center"><span><?php echo wrapstr($page->page_shortdesc);?></span></td>
												<td align="center"><span></span>
													<?php $statusLink = base_url() . "news/update_status/" . $page->id . "/" . $page->status . "/" . $this->uri->segment(3)?>
													<?php if($page->status == 1):?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
													<?php else: ?>
														<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
													<?php endif; ?>
												</td>
												<td align="center">
													<span>
														<?php 
															$date = strtotime($page->created);
															echo date("m/d/Y",$date);
														?>
													</span>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr class='row0'>
											<td colspan="5" align='center' ><strong>No News records Found.</strong></td>
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
<?php if(isset($this->session->userdata['user']['is_admin'])) { ?>
<script type="text/javascript">
function validate_store_selection() {
	var vss = document.getElementById("adminid").value;

	if( vss==null || vss==0 || vss=='0' ) {
		alert("Please select store/client");
		return false;
	} else {
		submitListingForm('clientListing', '<?php echo base_url() . "attributesets/add"?>','new');
	}
}
</script>
<?php } ?>
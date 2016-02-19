<div class="page">
  <table border="0" cellspacing="0" cellpadding="0" class="page_width">
    <tr>
      <td id="id_td_pageHeading" valign="middle"><span id="pageTitle"><?php echo ucfirst($caption);?></span></td>
    </tr>
	<!-- Errors And Message Display Row < -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('errors')): ?>
			<ul class="error_ul"><?php echo $this->session->flashdata('errors');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Errors And Message Display Row > -->
	<!-- Success And Message Display Row < -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('success')): ?>
			<ul class="success_ul"><?php echo $this->session->flashdata('success');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Success And Message Display Row > -->
    <tr>
      <td id="content_center_td" valign="top">
          <div id="content_div">
			<div id="listpage_button_bar" >
				<?php echo form_open('client_product/manage_client_product',array('name'=>'search', 'id'=>'search'));?>
				<table align="right"  border="0">
					<tr>
						<td style="padding: 0px 7px 0px 7px;">
							<fieldset class="fieldset">
								<legend><?php echo lang('search')?></legend>
								<div style="margin: 5px;">
								  <input type="text" name="s" id="s" class="inputbox" value="<?php echo form_prep($this->input->get_post('s'));?>" style="margin-bottom:2px;" size="30" />
								  &nbsp;
								  <input type="submit" value="<?php echo lang('btn_search')?>" name="submit" class="button" style="margin-bottom: 2px;" />
								  <br/>
								  <?php echo lang('client_product_search_instructions');?>
								</div>
							</fieldset>
						</td>
					</tr>
				</table>
				<?php echo form_close();?>
				<table align="left" border="0">
					<tr>
						<td class="icon_box" onclick="submitListingForm('memberListing', '<?php echo base_url() . "product/delete"?>','delete');">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/delete.png" alt="Delete" border="0" />
								</td>
								
							</tr>
							<tr>
								<td align="center" class="icon_text">
									<strong><?php echo lang('delete')?></strong>
								</td>
								
							</tr>
							</table>
						</td>
						<td class="icon_box" onclick="submitListingForm('memberListing', '<?php echo base_url() . "client_product/new_client_product"?>','new');">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/notice2.png" alt="Delete" border="0" />
								</td>
								
							</tr>
							<tr>
								<td align="center">
									<strong><?php echo lang('new')?></strong>
								</td>
								
							</tr>
							</table>
						</td>
					</tr>
				</table>
            </div>
			<?php echo form_open("client_product/manage_client_product", array('name' => 'memberListing', 'id' => 'memberListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" width=""><span><input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('memberListing',this);"/></span></td>
					<!--<td align="center" class="form_header"><span>Category</span></td>-->
					<td align="center" class="form_header" ><span>Product Title</span></td>
					<td align="center" class="form_header" ><span>Uploaded Photo</span></td>
					<td align="center" class="form_header"  nowrap="nowrap" align="center"><span>Status</span></td>
				</tr>
				<?php
				
				if($client_product):
					$rowClass = 'row1';

					foreach($client_product as $product):
							
						if($rowClass == 'row0')
						{
							$rowClass = 'row1';
						}
						else
						{
							$rowClass = 'row0';
						}

						//$image_name		=	$client_product_images[0]->image_name;

				?>
				<tr class="<?php echo $rowClass?>">
					<td align="center" width="5%"><span><input type="checkbox" name="client_productids[]" value="<?php echo $product->id?>" onclick="checkMasterState('memberListing', 'masterCheckField')"/></span></td>
					<!--<td align="center"><span><?php echo substr(ucfirst($product->category_name),0,25)?></span></td>-->
					
					<td align="center" ><span><a href="<?php echo base_url()?>client_product/edit_client_product/<?php echo $product->id;?>" ><?php echo $product->product_title;?></a></span></td>				
					
					<td align="center"><img height = "60px"  width = "60px" src="<?php echo $this->config->item('root_url').'uploads/client_product/'. $product->image_name; ?>" title="<?php echo $product->image_name; ?>" alt="<?php echo $product->image_name; ?>" /></span></td>				
					<td nowrap="nowrap" align="center">					
					<?php $statusLink = base_url() . "client_product/update_status/" . $product->id . "/" . $product->status . "/" . $this->uri->segment(3)?>

					<?php if($product->status == 1):?>
						<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
					<?php else: ?>
						<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
					<?php endif; ?>
					</td>
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="7" align='center' ><strong>No client Product Found.</strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="10" align="center">
						<?php echo $pagination?>
					</td>
				</tr>
            </table>
			<?php echo form_close(); ?>
          </div>
        </td>
    </tr>
  </table>
  <script  type="text/javascript" src="includes/script/boxover.js" ></script>
</div>

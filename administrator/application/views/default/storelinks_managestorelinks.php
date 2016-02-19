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
				
				<table align="left" border="0">
					<tr>
						<td class="icon_box" onclick="submitListingForm('storelinksListing', '<?php echo base_url() . "storelinks/delete_storelinks"?>','delete');">
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
						  <td class="icon_box" onclick="submitListingForm('storelinksListing', '<?php echo base_url() . "storelinks/add_storelinks"?>','new');">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/notice2.png" alt="Add" border="0" />
								</td>
								
							</tr>
							<tr>
								<td align="center">
									<strong><?php echo lang('new')?></strong>
								</td>
								
							</tr>
							</table>
						</td>
						<!-- 
						<?php 
						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{
						?>
						<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">   
                                    <select name="adminid" id="adminid" onchange="setStoreSession(this.value, '<?php echo base_url() . 'storelinks/manage_storelinks/' ?>', '<?php echo base_url();?>' )">
                                        <option value="0">--Administrator--</option>
                                        <?php foreach ( $clients as $client ) 
                                        {?>
                                        <option value="<?php echo $client->id;?>" <?php if( $this->session->userdata('storeId') == $client->id ) { echo 'selected="selected"'; } ?> ><?php echo $client->username; ?></option>
                                        <?php }?>
                                    </select>
								</td>
								
							</tr>
							<tr>
								<td align="center">
									Select to view the Store links
								</td>
								
							</tr>
							</table>
						</td>
						<?php 
						}?>
						-->
					</tr>
				</table>
				</div>
			<?php echo form_open("storelinks/manage_storelinks", array('name' => 'storelinksListing', 'id' => 'storelinksListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" ><span><input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('storelinksListing',this);"/></span></td>
					<td align="center" class="form_header"><span>Title</span></td>
					<td align="center" class="form_header"><span>Image</span></td>
					<td align="center" class="form_header"><span>Link To</span></td>
					<td align="center" class="form_header"><span>Status</span></td>
					<td align="center" class="form_header"><span>Created</span></td>
				</tr>
				<?php
				
				if($content):
					$rowClass = 'row1';

					foreach($content as $banner):
						//echo '<pre>';print_r($banner);echo '</pre>';
						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
				?>
				<tr class="<?php echo $rowClass?>">
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
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="6" align='center' ><strong>No storelinks records Found.</strong></td>
				</tr>
				<?php endif;?>
				<?php if($content){?>
					<tr>
						 <td colspan="6" align="center">
							<?php echo $pagination?>
						</td>
					</tr>
				<?php }?>
				
				<tr>
					<td align="center" colspan="6">
						<input type="button" 
						<?php 
						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{
						?>
						onclick="javascript: window.location.href='<?php echo base_url().'admin/desktop';?>';" 
						<?php 
						}
						else
						{
						?>
						onclick="javascript: window.location.href='<?php echo base_url().'client/desktop';?>';"	
						<?php
						}
						?>
						class="button" value="Back">
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
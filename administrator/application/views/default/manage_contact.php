<script>
// post search filters with pagination     

</script>
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
						<td class="icon_box" onclick="submitListingForm('contactListing', '<?php echo base_url() . "contact/delete_contact"?>','delete');">
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
						  
						  <td>
						  <?php 
			                if( isset( $this->session->userdata['user']['is_admin'] ) ) 
			                {
			                ?>
			                Select to view the Contacts :
			                <select name="adminid" id="adminid" onchange="setStoreSession(this.value, '<?php echo base_url() . 'contact/manage_contact/' ?>', '<?php echo base_url();?>' )">
			                    <option value="0">--Administrator--</option>
			                    <?php foreach ( $clients as $client )
			                    {?>
			                        <option value="<?php echo $client->id;?>" <?php if( $this->session->userdata('storeId') == $client->id ) { echo 'selected="selected"'; } ?> ><?php echo $client->username; ?></option>
			                    <?php }?>
			                </select>
			                <?php 
			                }?>		  
						  </td>
						  
					</tr>
				</table>
				</div>
			<?php echo form_open("contact/manage_contact", array('name' => 'contactListing', 'id' => 'contactListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($contact)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('contactListing',this);"/></span></td>
					<td align="center" class="form_header"><span>Name</span></td>
					<td align="center" class="form_header"><span>Email</span></td>
					<!-- <td align="center" class="form_header"><span>Phone Number</span></td> -->
					<td align="center" class="form_header"><span>Request Date</span></td>
				</tr>
				<?php
				
				if($contact):
					$rowClass = 'row1';
					foreach($contact as $page):
						
						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
				?>
				<tr class="<?php echo $rowClass?>">
					<td align="center" width="5%"><span><input type="checkbox" name="pageids[]" value="<?php echo $page->id?>" onclick="checkMasterState('contactListing', 'masterCheckField')"/></span></td>
					<td align="center" ><span><a href="<?php echo base_url()?>contact/view_contact/<?php echo $page->id;?>" ><?php echo wrapstr($page->name);?></a></span></td>
					<td align="center"><span><?php echo wrapstr($page->email);?></span></td>
					<!-- <td align="center"><span><?php echo wrapstr($page->phone);?></span></td> -->
					<td align="center">
						<span>
							<?php 
								$date = strtotime($page->date);
								echo date("M, d Y",$date);
							?>
						
						</span>
					</td>

				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="7" align='center' ><strong>No Contact Found.</strong></td>
				</tr>
				<?php endif;?>
				<?php if($contact){?>
					<tr>
						 <td colspan="10" align="center" id="paginated">
							<?php echo $pagination?>
						</td>
					</tr>
				<?php }?>
				<tr>
					<td align="center" colspan="10">
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

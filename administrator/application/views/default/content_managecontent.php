
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
			<?php //echo '<pre>';print_r($clients);echo '</pre>';;?>
			<?php 
			if( isset( $this->session->userdata['user']['is_admin'] ) ) 
			{
			?>
			Select to view the Content :
			<select name="adminid" id="adminid" onchange="setStoreSession(this.value, '<?php echo base_url() . 'content/manage_content/' ?>', '<?php echo base_url();?>' )">
			    <option value="0">--Administrator--</option>
			    <?php foreach ( $clients as $client )
			    {?>
			        <option value="<?php echo $client->id;?>" <?php if( $this->session->userdata('storeId') == $client->id ) { echo 'selected="selected"'; } ?> ><?php echo $client->username; ?></option>
			    <?php }?>
			</select>
			<?php 
			}?>
			
				
				</div>
			<?php echo form_open("content/manage_content", array('name' => 'contentListing', 'id' => 'contentListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
				<!--
					<td align="center" class="form_header" width=""><span><input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('contentListing',this);"/></span></td>
					-->
					<td align="center" class="form_header"><span>Page Name</span></td>
					<td align="center" class="form_header"><span>Page Title</span></td>
					<td class="form_header" align="center"><span>Meta Title</span></td>
					<td class="form_header" align="center" nowrap="nowrap" ><span>Meta Keywords</span></td>
					<td class="form_header" align="center" nowrap="nowrap" ><span>Meta Description</span></td>
					<!--
					<td class="form_header"  nowrap="nowrap" align="center"><span>Actions</span></td>
					-->
				</tr>
				<?php
				
				if($content):
					$rowClass = 'row1';
					foreach($content as $page):
						
						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
				?>
				<tr class="<?php echo $rowClass?>">
					<!--
					<td align="center" width="5%"><span><input type="checkbox" name="pageids[]" value="<?php echo $page->id?>" 
					onclick="checkMasterState('contentListing', 'masterCheckField')"/></span></td>
					-->
					<td align="center" ><span><a href="<?php echo base_url()?>content/edit_page/<?php echo $page->id;?>" ><?php echo wrapstr($page->page_name);?></a></span></td>
					<td align="center"><span><?php echo wrapstr(htmlentities($page->page_title));?></span></td>
					<td align="center"><span><?php echo wrapstr($page->page_metatitle)?></span></td>
					<td align="center"><span><?php echo wrapstr($page->page_metakeywords)?></span></td>
					<td align="center" nowrap="nowrap"><span><?php echo wrapstr($page->page_metadesc);?></span></td>
					
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="5" align='center' ><strong>No Content Pages Found.</strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="5" align="center">
						<?php echo $pagination?>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="5">
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
</div>


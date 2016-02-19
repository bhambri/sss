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
				<?php echo form_open('subcategory/manage_subcategory',array('name'=>'search', 'id'=>'search'));?>
				<table align="left"  border="0">
					<tr>
						<td style="padding: 0px 7px 0px 7px;">
							<fieldset class="fieldset">
								<legend><?php echo lang('search')?></legend>
								<div style="margin: 5px;">
								  <input type="text" name="s" id="s" class="inputbox" value="<?php echo form_prep($this->input->get_post('s'));?>" style="margin-bottom:2px;" size="30" />
								  &nbsp;
								  <input type="submit" value="<?php echo lang('btn_search')?>" name="submit" class="button" style="margin-bottom: 2px;" />
								  <br/>
								  <?php echo lang('cd_search_instructions');?>
								</div>
							</fieldset>
						</td>
					</tr>
				</table>
				<?php echo form_close();?>
				
            </div>
			<?php echo form_open("subcategory/manage_subcategory", array('name' => 'memberListing', 'id' => 'memberListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" width=""><span><input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('memberListing',this);"/></span></td>
					<td align="center" class="form_header"><span>Category</span></td>
					<td align="center" class="form_header" ><span>Sub-Category</span></td>
					<!--<td align="center" class="form_header"  nowrap="nowrap" align="center"><span>Status</span></td>-->
				</tr>
				<?php
				
				if($cds):
					$rowClass = 'row1';
					foreach($cds as $cd):
						
						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
				?>
				<tr class="<?php echo $rowClass?>">
					<td align="center" width="5%"><span><input type="checkbox" name="cdids[]" value="<?php echo $cd->id?>" onclick="checkMasterState('memberListing', 'masterCheckField')"/></span></td>
					<td align="center"><span><?php echo substr(ucfirst($cd->artist_name),0,25)?></span></td>
					<td align="center" ><span><a href="<?php echo base_url()?>subcategory/edit_subcategory/<?php echo $cd->id;?>" ><?php echo $cd->cds_title;?></a></span></td>
					
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="7" align='center' ><strong>No Sub Category Found.</strong></td>
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

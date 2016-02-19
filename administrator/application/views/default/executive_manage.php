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
						<td class="icon_box" onclick="submitListingForm('executiveListing', '<?php echo base_url() . "executives/executive_delete"?>','delete');">
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
						<td class="icon_box" onclick="submitListingForm('executiveListing', '<?php echo base_url() . "executives/executive_new"?>','new');">
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
					</tr>
				</table>
            </div>
			<?php echo form_open("executives/executive_manage", array('name' => 'executiveListing', 'id' => 'executiveListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($executives)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('executiveListing',this);"/></span></td>
					<td align="center" class="form_header"><span>Executive Level</span></td>
					<td align="center" class="form_header"><span>Direct Commission (%)</span></td>
					<td class="form_header"  nowrap="nowrap" align="center"><span>Generation Access</span></td>
				</tr>
				<?php
				if(!empty($executives) && count($executives)>0):
				

					$rowClass = 'row1';

					foreach($executives as $executive):
						#hide the super admin username always
					/*	if($user->username == "admin")
							continue;*/

						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
				?>
				<tr class="<?php echo $rowClass?>">
					<td align="center" width="5%">
						<?php	//if($user->username != $this->session->userdata['user']['username']):?>
								<span><input type="checkbox" name="executiveids[]" value="<?php echo $executive->id?>" onclick="checkMasterState('executiveListing', 'masterCheckField')"/></span>
						<?php //endif; ?>
					</td>
					<td align="center">
						<span>
							
								<a href="<?php echo base_url()?>executives/executive_edit/<?php echo $executive->id;?>" ><?php echo $executive->executive_level; ?></a>

					</span></td>
					<td align="center"><span><?php echo $executive->direct_commision;?></span></td>
					<td align="center"><span><?php echo $executive->generation_access;?></span></td>
					
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="4" align='center' ><strong><?php echo lang('executive_not_found')?></strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="4" align="center">
						<?php echo $pagination?>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="4">
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

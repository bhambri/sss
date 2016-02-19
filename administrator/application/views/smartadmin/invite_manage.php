<div class="page">
<table border="0" cellspacing="0" cellpadding="0" class="page_width">
	<tr>
		<td id="id_td_pageHeading" valign="middle"><span id="pageTitle"><?php echo ucfirst($caption);?></span></td>
    </tr>
	<!-- Errors And Message Display Row < -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		 <?php if(validation_errors()): ?>
			<ul class="error_ul"><li><strong>Please correct the following:<br/><br/></strong></li><?php echo validation_errors('<li>','</li>');?></ul>
		<?php endif; ?>
	    
	    	<div id="errorsDiv" style="display:none;"></div>
		</td>
    </tr>
    <tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('success')): ?>
			<ul class="success_ul"><?php echo $this->session->flashdata('success');?></ul>
		<?php endif; ?>
		</td>
    </tr>
    <tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('errors')): ?>
			<ul class="error_ul"><?php echo $this->session->flashdata('errors');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Errors And Message Display Row > -->
	<tr>
		<td id="content_center_td" valign="top">
			<div id="content_div">
			
			<div id="listpage_button_bar">
				<table align="left" border="0">
					<tr>
						<td class="icon_box" onclick="submitListingForm('invitesListing', '<?php echo base_url() . "consultant/invite_delete"?>','delete');">
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
						
						<td class="icon_box" onclick="submitListingForm('invitesListing', '<?php echo base_url() . "consultant/invite_add"?>','new');">
						
						  
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
			
			<!-- Tree View Start -->
			<?php echo form_open("consultant/invite_manage", array('name' => 'invitesListing', 'id' => 'invitesListing'));?>
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($all_invites)) { echo "disabled"; }?>  name="masterCheckField" id="masterCheckField" onclick="checkAll('invitesListing',this);"/></span></td>
					<td align="center" class="form_header"><span>Receiver Email Address</span></td>
					<td class="form_header"  nowrap="nowrap" align="center"><span>Action</span></td> 
					<!-- td class="form_header"  nowrap="nowrap" align="center"><span><?php echo lang('active')?></span></td-->
				</tr>
				<?php
				if(!empty($all_invites) && count($all_invites)>0):
				

					$rowClass = 'row1';

					foreach($all_invites as $invites):
						#hide the super admin username always
					/*	if($user->username == "admin")
							continue;*/

						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
				?>
				<tr class="<?php echo $rowClass; ?>">
					<td align="center" width="5%">
						<?php	//if($invites->username != $this->session->userdata['user']['username']):?>
								<span><input type="checkbox" name="userids[]" value="<?php echo $invites->id; ?>" onclick="checkMasterState('invitesListing', 'masterCheckField')"/></span>
						<?php //endif; ?>
					</td>
					<td align="center">
						<span>
							<a href="<?php echo base_url();?>consultant/invite_edit/<?php echo $invites->id; ?>"><?php echo $invites->email; ?></a>
						</span>
					</td>
					
					<td align="center">
						<span>
							<a href="<?php echo base_url(); ?>consultant/invite_resend_invitation/<?php echo $invites->id; ?>">Resend Invitation</a>
						</span>
					</td>
					
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="3" align='center' ><strong><?php echo lang('invite_not_found')?></strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="3" align="center">
						<?php echo $pagination; ?>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center">
						<input  type="button" onclick="javascript: window.location.href='<?php echo base_url().'consultant/desktop';?>';" value="Back" class="button" />
					</td>
				</tr>
            </table>
			<?php echo form_close(); ?>
			<!-- Tree View End -->
			
			</div>
		</td>
    </tr>
</table>
</div>

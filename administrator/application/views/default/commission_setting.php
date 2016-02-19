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
			
			<?php 
			if($check_store_exist==1)
			{
			?>
			<div id="listpage_button_bar">
				<table align="left" border="0">
					<tr>
						<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center" onclick="javascript:window.location.href='<?php echo base_url(); ?>consultant/commission_setting_edit/<?php echo $commission_setting[0]->id; ?>';">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/notice2.png" alt="Back to main parent" border="0" />
								</td>						
							</tr>
							<tr>
								<td align="center">
									<strong><?php echo "Edit Commission Setting";?></strong>
								</td>
							</tr>
							</table>
						</td>
					</tr>
				</table>
            </div>
			<?php 
			}
			else
			{
			?>
			<div id="listpage_button_bar">
				<table align="left" border="0">
					<tr>
						<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center" onclick="javascript:window.location.href='<?php echo base_url(); ?>consultant/commission_setting_add';">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/notice2.png" alt="Back to main parent" border="0" />
								</td>
								
							</tr>
							<tr>
								<td align="center">
									<strong><?php echo "Add Commission Setting";?></strong>
								</td>
								
							</tr>
							</table>
						</td>
					</tr>
				</table>
            </div>
			<?php
			}
			?>
			
			
			
			
			
			<!-- Tree View Start -->
			
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<!--td align="center" class="form_header" ><span><input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('userListing',this);"/></span></td-->
					<td align="center" class="form_header"><span>Level 1</span></td>
					<td align="center" class="form_header"><span>Level 2</span></td>
					<td align="center" class="form_header"><span>Level 3</span></td>
					<td align="center" class="form_header"><span>Level 4</span></td>
					<td align="center" class="form_header"><span>Level 5</span></td>
					<td align="center" class="form_header"><span>Level 6</span></td>
					<td class="form_header"  nowrap="nowrap" align="center"><span>Action</span></td> 
					<!-- td class="form_header"  nowrap="nowrap" align="center"><span><?php echo lang('active')?></span></td-->
				</tr>
				<?php
				if(!empty($commission_setting) && count($commission_setting)>0):
				

					$rowClass = 'row1';

					foreach($commission_setting as $comm_setting):
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
					<!-- td align="center" width="5%">
						<?php	if($user->username != $this->session->userdata['user']['username']):?>
								<span><input type="checkbox" name="userids[]" value="<?php echo $user->id?>" onclick="checkMasterState('userListing', 'masterCheckField')"/></span>
						<?php endif; ?>
					</td-->
					<td align="center">
						<span>
							<?php echo $comm_setting->level1."%"; ?>
						</span>
					</td>
					<td align="center">
						<span>
							<?php echo $comm_setting->level2."%"; ?>
						</span>
					</td>
					<td align="center">
						<span>
							<?php echo $comm_setting->level3."%"; ?>
						</span>
					</td>
					<td align="center">
						<span>
							<?php echo $comm_setting->level4."%"; ?>
						</span>
					</td>
					<td align="center">
						<span>
							<?php echo $comm_setting->level5."%"; ?>
						</span>
					</td>
					<td align="center">
						<span>
							<?php echo $comm_setting->level6."%"; ?>
						</span>
					</td>
					<td nowrap="nowrap" align="center">
					<?php $status = 1;
					if ( $comm_setting->status == 1 )
					{
					    $status = 0;
					}
					$statusLink = base_url() . "consultant/commission_update_status/" . $comm_setting->id . "/" . $status; ?>

					<?php /*if($client->clientname==$this->session->clientdata['client']['clientname']): ?>
						<?php if($client->status == 1):?>
							<img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/>
						<?php else: ?>
							<img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/>
						<?php endif; ?>
					<?php else: */?>
						<?php if($comm_setting->status == 1):?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
						<?php else: ?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
						<?php endif; ?>
					<?php //endif; ?>
					</td>
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="7" align='center' ><strong><?php echo lang('comm_setting_not_found')?></strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="7" align="center">
						<?php //echo $pagination?>
					</td>
				</tr>
				<tr>
					<td colspan="7" align="center">
						<input  type="button" 
						
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
						
						value="Back" class="button" />
					</td>
				</tr>
            </table>
			
			<!-- Tree View End -->
			
			</div>
		</td>
    </tr>
</table>
</div>

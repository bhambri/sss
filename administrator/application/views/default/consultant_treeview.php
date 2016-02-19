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
	<!-- Errors And Message Display Row > -->
	<tr>
		<td id="content_center_td" valign="top">
			<div id="content_div">
			
			
			<div id="listpage_button_bar" >
				<table align="left" border="0">
					<tr>
						<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center" onclick="javascript:window.location.href='<?php echo base_url(); ?>consultant/tree_view';">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/notice2.png" alt="Back to main parent" border="0" />
								</td>
								
							</tr>
							<tr>
								<td align="center">
									<strong><?php echo "Back to Main Parent";?></strong>
								</td>
								
							</tr>
							</table>
						</td>
					</tr>
				</table>
            </div>
			
			
			
			
			
			
			<!-- Tree View Start -->
			
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<!--td align="center" class="form_header" ><span><input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('userListing',this);"/></span></td-->
					<td align="center" class="form_header"><span>User Name</span></td>
					<td align="center" class="form_header"><span><?php echo lang('full_name')?></span></td>
					<td class="form_header"  nowrap="nowrap" align="center"><span>Action</span></td> 
					<!-- td class="form_header"  nowrap="nowrap" align="center"><span><?php echo lang('active')?></span></td-->
				</tr>
				<?php
				if(!empty($consultant) && count($consultant)>0):
				

					$rowClass = 'row1';

					foreach($consultant as $user):
						#hide the super admin username always
						if($user->username == "admin")
							continue;

						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
				?>
				<tr class="<?php echo $rowClass; ?>">
					
					<td align="center">
						<span>
							<?php echo substr($user->username,0,20); ?>
						</span>
					</td>
					<td align="center">
						<span>
							<?php echo $user->name ;?>
						</span>
					</td>
					<td nowrap="nowrap" align="center">					
						<span>
							<a href="<?php echo base_url().'consultant/tree_view?id='.$user->id.'&uname='.$user->username; ?>">View Child <?php echo $this->consultant_label ; ?></a>
						</span> |
						<span>
							<a href="<?php echo base_url().'user/tree_view/'.$user->id ?>">View Tree</a>
						</span>
						<?php if($is_mlmtype){ ?> |
						<span>
							<a href="<?php echo base_url().'user/btree_view/'.$user->id ?>">Binary Tree View</a>
						</span>
						<?php } ?>
					</td>
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="3" align='center' ><strong><?php echo lang('consultants_not_found')?></strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="3" align="center">
						<?php echo $pagination?>
					</td>
				</tr>
				
            </table>
			
			<!-- Tree View End -->
			
			</div>
		</td>
    </tr>
</table>
</div>

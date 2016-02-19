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
						<td class="icon_box" <?php if(empty($messages)) { ?> onclick="alert('Messages are not available for delete.');" <?php  } else { ?> onclick="submitListingForm('messagesListing', '<?php echo base_url() . "messages/delete"?>','delete');" <?php } ?>>
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
						<td class="icon_box" <?php if(empty($messages)) { ?> onclick="alert('Messages are not available to mark as read.');" <?php  } else { ?> onclick="submitListingForm('messagesListing', '<?php echo base_url() . "messages/markread"?>','markread');" <?php } ?>>
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/markread.png" alt="Mark Read" border="0" />
								</td>
							</tr>
							<tr>
								<td align="center" class="icon_text">
									<strong><?php echo 'Mark Read'; ?></strong>
								</td>
							</tr>
							</table>
						</td>
						<td class="icon_box" onclick="submitListingForm('messagesListing', '<?php echo base_url() . "messages/compose"?>','new');">
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
			<?php echo form_open("messages/manage", array('name' => 'messagesListing', 'id' => 'messagesListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($front_blocks)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('messagesListing',this);"/></span></td>
					<td align="center" class="form_header"></td>
					<td align="center" class="form_header"><span>Sender</span></td>
					<td align="center" class="form_header"><span>Subject</span></td>
					<td align="center" class="form_header"><span>Date</span></td>
				</tr>
				<?php
				if(!empty($messages) && count($messages)>0):

					foreach($messages as $message):
						$rowClass = 'row1';
						if($message['status'] == MSG_STATUS_UNREAD) {
							$rowClass = '';
						}
				?>
				<tr class="<?php echo $rowClass?>">
				
					<td align="center" width="5%">
						<span><input type="checkbox" name="messages[]" value="<?php echo $message['thread_id']; ?>" onclick="checkMasterState('messagesListing', 'masterCheckField')"/></span>
					</td>
					<td align="left">
						<span>
							<?php if($message['status'] == MSG_STATUS_UNREAD) { ?>
								<img src="<?php echo layout_url('default/assets'); ?>/img/unread.png" />
							<?php } else { ?>
								<img src="<?php echo layout_url('default/assets'); ?>/img/read.png" />
							<?php } ?>
						</span>
					</td>
					<td align="left"><span><?php echo $message['user_name']; ?></span></td>
					<td align="left">
						<span>
							<a href="<?php echo base_url()?>messages/view/<?php echo $message['thread_id']; ?>" >
								<?php echo $message['subject']; ?>
							</a>
						</span>
					</td>
					<td width="15%" align="center"><span><?php echo $message['cdate']; ?></span></td>
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="6" align='center' ><strong><?php echo 'No message.'; ?></strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="6" align="center">
						<?php echo $pagination; ?>
					</td>
				</tr>
            </table>
			<?php echo form_close(); ?>
          </div>
        </td>
    </tr>
  </table>
</div>
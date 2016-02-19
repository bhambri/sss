<div class="page">
	<table border="0" cellspacing="0" cellpadding="0" class="page_width">
		<tr>
			<td id="id_td_pageHeading" valign="middle"><span id="pageTitle"><?php echo ucfirst($caption);?></span></td>
		</tr>
		<tr>
			<td id="content_center_td" valign="top">
				<div id="content_div">
					<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
						<tr>
							<td class="form_header" colspan="2"><span><?php echo ($messages[0]['subject']);?></span></td>
						</tr>
						<?php foreach($messages as $message) { ?>
							<tr>
								<td width="20%" align="left" valign="top">
									<?php echo $message['user_name']; ?>
									<br />
									<i><small><?php echo $message['cdate'];?></small></i>
								</td>
								<td><frame><?php echo $message['body']; ?></frame></td>
							</tr>
						<?php $message_id	= $message['id'];
							} ?>
						<tr>
							<td align="left" valign="top">
								Reply
							</td>
							<td align="right">
								<?php echo form_open('messages/reply/', array('id'=>'messagesReply','name'=>'messagesReply', 'onsubmit'=>'return yav.performCheck(\'messagesReply\', rules, \'classic\');'));?>
									<input type="hidden" name="message_id" value="<?php echo $message_id; ?>" />
									<input type="hidden" name="thread_id" value="<?php echo $thread_id; ?>" />
									<textarea name="message" id="message" class="mceEditor" cols="61" rows="4"></textarea>
									<br />
									<input type="submit" name="submit" class="button" value="Reply" />
								<?php echo form_close();?>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>


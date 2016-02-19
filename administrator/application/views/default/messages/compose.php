<link href="<?php echo layout_url('default/assets'); ?>/css/chosen.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo layout_url('default/assets'); ?>/js/chosen.jquery.js" type="text/javascript"></script>
<script>
var rules = new Array();
rules[0] = 'participant:<b>Sent to</b>|required';
rules[1] = 'subject:<b>Subject</b>|required';
rules[2] = 'message:<b>Message</b>|custom|content_validate()';


function content_validate()
{
	if(jQuery.trim(tinyMCE.activeEditor.getContent())=="") {
		return "Message must be entered!";
	}
}

</script>
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
			<?php echo form_open('messages/compose/', array('id'=>'messagesCompose','name'=>'messagesCompose', 
'onsubmit'=> "return yav.performCheck('messagesCompose', rules,'innerHtml'); " ) );?>
			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Sent To: <span> * </span></td>
						<td width="60%">
							<select data-placeholder="Receipients" name="participant[]" id="participant"  class="chosen-select" multiple style="width:350px;" tabindex="4">
								<?php 
									foreach($chat_users as $user) { ?>
									<option value="<?php echo $user->id; ?>"><?php echo $user->name; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Subject: <span> * </span></td>
						<td width="60%"><input type="text" name="subject" id="subject"  class="inputbox" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Message: <span> * </span></td>
						<td width="60%"><textarea name="message" id="message" class="mceEditor" cols="61" rows="4"></textarea></td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="submit" class="button" value="Save" />
							<input type="button" value="Cancel" class="button" onclick="javascript:history.back();"/>
						</td>
					</tr>
					<tr>
						<td colspan='2' class="form_base_header" align="center"><?php echo lang("mandatory_fields_notice"); ?></td>
					</tr>
				</table>
			</div>
			<?php echo form_close();?>
		</td>
    </tr>
</table>
</div>
<script type='text/javascript' language='javascript'>
//<![CDATA[
$('.chosen-select').chosen();


//]]>
</script>

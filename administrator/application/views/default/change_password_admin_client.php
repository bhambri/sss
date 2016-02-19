<div class="page">
<script type='text/javascript' language='javascript'>
//<![CDATA[
	var rules = new Array();
	rules[0] = 'new_password:New Password|required';
	rules[1] = 'new_password:New Password|minlength|6'; 
	rules[2] = 'confirm_password:Confirm Password|equal|$new_password|The Confirm Password field must be equal to New Password field ';
	
//]]>
</script>
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
			<?php echo form_open("client/change_password_client/$store_id",array('id'=>'formEditUser','name'=>'formEditUser', 'onsubmit'=>'return yav.performCheck(\'formEditUser\', rules, \'innerHtml\');'));?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
				
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('password')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="password" name="new_password" id="new_password"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($user->password_orig) ? $user->password_orig : set_value('password',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('conf_password')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="password" name="confirm_password" id="confirm_password"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($user->password_orig) ? $user->password_orig : set_value('passwordconf',''));?>" /></td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="<?php echo lang("btn_edit"); ?>" />
							<input type="button" value="Cancel" class="button" onclick="javascript:history.back();"/>	
							<input type="hidden" name="form_submitted" value="1" />
							<input type="hidden" name="id" value="<?php echo (isset($user->id) ? $user->id : $this->input->post('id'))?>" />
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


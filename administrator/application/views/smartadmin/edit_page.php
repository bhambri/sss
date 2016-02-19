<div class="page">
<script type='text/javascript' language='javascript'>
//<![CDATA[
	var rules = new Array();
	rules[0] = 'username:<?php echo lang("username")?>|required'; 
	rules[1] = 'password:<?php echo lang("password")?>|required';
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
			<?php echo form_open('user/edit_user',array('id'=>'formEditUser','name'=>'formEditUser', 'onsubmit'=>'return yav.performCheck(\'formEditUser\', rules, \'innerHtml\');'));?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2" align="left"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('username')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="username" id="username"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($user->username) ? $user->username : set_value('username',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('password')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="password" name="password" id="password"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($user->password_orig) ? $user->password_orig : set_value('password',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('conf_password')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="password" name="passwordconf" id="passwordconf"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($user->password_orig) ? $user->password_orig : set_value('passwordconf',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('first_name')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="first_name" id="first_name"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($user->first_name) ? $user->first_name : set_value('first_name',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('last_name')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="last_name" id="last_name"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($user->last_name) ? $user->last_name : set_value('last_name',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('email')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="email" id="email"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($user->email) ? $user->email : set_value('email',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('address')?>: <span> * </span></td>
						<td width="60%" align="left"><textarea onkeypress="textCounter(this, addresscount, 200)" onkeyup="textCounter(this, addresscount, 200)" name="address" id="address" rows="5" cols="20" class="inputbox"><?php echo (isset($user->address) ? $user->address : set_value('address',''));?></textarea><br/>
						<input type="text" name="addresscount" id="addresscount" readonly="readonly" style="width: 30px;" class="inputbox" value="200" />&nbsp;&nbsp;<?php echo lang('char_left')?></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('city')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="city" id="city"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($user->city) ? $user->city : set_value('city',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('zip_code')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="zipcode" id="zipcode"  maxlength = "20" style="width: 150px;" class="inputbox" value="<?php echo (isset($user->zipcode) ? $user->zipcode : set_value('zipcode',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('status')?>: </td>
						<td width="60%" align="left"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ((isset($user->status) ? $user->status : set_value('status','')) == 1) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="<?php echo lang("btn_edit"); ?>" />
							<input type="button" value="Cancel" class="button" onclick="javascript:history.back();"/>	
							<input  type="hidden" name="formSubmitted" value="1" />
							<input  type="hidden" name="id" value="<?php echo (isset($user->id) ? $user->id : $this->input->post('id'))?>" />
							<input  type="hidden" name="salt" value="<?php echo (isset($user->password_salt) ? $user->password_salt : $this->input->post('salt'))?>" />
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


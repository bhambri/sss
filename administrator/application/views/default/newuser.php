<div class="page">
<script type='text/javascript' language='javascript'>
//<![CDATA[
	var rules = new Array();

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
			<ul class="error_ul"><li><strong>Please correct the following:</strong><br/><br/></li><?php echo validation_errors('<li>','</li>');?></ul>
		<?php endif; ?>
		<div id="errorsDiv" style="display:none;"></div>
		</td>
    </tr>
	<!-- Errors And Message Display Row > -->
	<tr>
		<td id="content_center_td" valign="top">

			<?php echo form_open('user/new_user',array('id'=>'formNewUser','name'=>'formNewUser', 'onsubmit'=>'return yav.performCheck(\'formNewUser\', rules, \'innerHtml\');'));?>


			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Name: <span> * </span></td>
						<td width="60%"><input type="text" name="name" id="name"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('name','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Phone Number: <span> * </span></td>
						<td width="60%"><input type="text" name="phone" id="phone"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('phone','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('email')?>: <span> * </span></td>
						<td width="60%"><input type="text" name="email" id="email"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('email','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">User Name: <span> * </span></td>
						<td width="60%"><input type="text" name="username" id="username"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('username','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('password')?>: <span> * </span></td>
						<td width="60%"><input type="password" name="password" id="password"  maxlength = "50" style="width: 150px;" class="inputbox" value="" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('conf_password')?>: <span> * </span></td>
						<td width="60%"><input type="password" name="confirm_password" id="confirm_password"  maxlength = "50" style="width: 150px;" class="inputbox" value="" /></td>
					</tr>
					
					<?php /*
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('phone')?>: <span> * </span></td>
						<td width="60%"><input type="text" name="phone" id="phone"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('phone','');?>" /></td>
					</tr>*/ ?>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('active')?><span>&nbsp;</span> </td>
						<td width="60%"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo set_checkbox('status','1');?> /></td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Submit" />
							<input  type="button" value="Cancel" class="button" onclick="javascript: window.location ='<?php echo base_url(); ?>user/manage'" />
							<input  type="hidden" name="formSubmitted" value="1" class="button" />
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


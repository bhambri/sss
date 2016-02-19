<div class="page">
<script type='text/javascript' language='javascript'>
//<![CDATA[
	var rules = new Array();
	rules[0] = 'first_name:<?php echo lang("first_name")?>|required';
	rules[1] = 'first_name:<?php echo lang("first_name")?>|alphaspace';
	rules[2] = 'first_name:<?php echo lang("first_name")?>|minlength|2';
	rules[3] = 'first_name:<?php echo lang("first_name")?>|maxlength|15';

	rules[4] = 'last_name:<?php echo lang("last_name")?>|required';
	rules[5] = 'last_name:<?php echo lang("last_name")?>|alphaspace';
	rules[6] = 'last_name:<?php echo lang("last_name")?>|minlength|2';
	rules[7] = 'last_name:<?php echo lang("last_name")?>|maxlength|15';

	rules[8] = 'username:<?php echo lang("username")?>|required';
	rules[9] = 'username:<?php echo lang("username")?>|alphaspace';
	rules[10] = 'username:<?php echo lang("username")?>|minlength|2';
	rules[11] = 'username:<?php echo lang("username")?>|maxlength|15';

	rules[15]= 'email:<?php echo lang("email")?>|required';
	rules[16] = 'email:<?php echo lang("email")?>|email';
	rules[17] = 'phone:<?php echo lang("phone")?>|required';
	rules[18] = 'phone:<?php echo lang("phone")?>|custom|validate_phone1()';
//]]>

function validate_phone()
{
	var msg = null;
	var phone = jQuery.trim(jQuery("#phone").val());
	var phone_regex = /^(\+?\(\d{1,3}\)|\(\+?\d{1,3}\))?[ .,-]?\(?\d{3}\)?[ .,-]?\(?\d{3}\)?[ .,-]?\(?\d{4}\)?([ ,.-]?(x|ex)?[ :]?[ ]?\d{3,5})?$/;
	if(!phone_regex.test(phone))
	{
		msg  = "The phone no. field is invalid.";
	}
	return msg;
}
function validate_phone1()
{
	var msg = null;
	var phone = jQuery.trim(jQuery("#phone").val());
	var phone_regex = /^[ +.,()0-9-]+$/;
	var length = jQuery("#phone").val().length;
	if(length > 0 )
	{
		if(!phone_regex.test(phone))
		{
			msg  = "The Phone No. field is invalid.";
		}
	}
	return msg;
}
</script>
<?php 
#echo '<pre>';


?>
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
			<?php 
			echo form_open('consultant/edit_consultant/'.$user['id'] ,array('id'=>'formEditUser','name'=>'formEditUser', 'onsubmit'=>'return yav.performCheck(\'formEditUser\', rules, \'classic\');'));
			?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2" align="left"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<?php if($edit_roleid == 4){ 
								$readonly = 'disabled = "disabled"';
							}else{
								$readonly = '' ;
							}
					?>
					<?php 
					if($edit_roleid != 4) { 
						$displayClass = '' ;
					}else{
						$displayClass = 'display:none;' ;
					}
					?>
					<tr style="<?php echo $displayClass ;?>">
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Select Parent <?php echo $this->consultant_label ;?>: <span>&nbsp;</span></td>
						<td width="60%" align="left">
							<select name="parent_consultant" id="parent_consultant" <?php echo $readonly;?>>
								<option value="0">-- Parent <?php echo $this->consultant_label ;?> --</option>
								<?php 
								foreach ($consultant_list as $cons_list)
								{
									if( $current_edit_user_id != $cons_list->id )
									{
								?>
									<option value="<?php echo $cons_list->id ; ?>" <?php if( $cons_list->id==$user['parent_consultant_id'] ) { echo "selected='selected'"; }?> ><?php echo ucwords($cons_list->username); ?></option>
								<?php
									}
								}
								?>
							</select>
						</td>
					</tr>
					<tr  style="<?php echo $displayClass ;?>">
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Select Executive Level: <span>&nbsp;</span></td>
						<td width="60%" align="left">
							
							<select name="executive_level" id="executive_level" <?php echo $readonly;?>>
								<option value="0">-- Executive Level --</option>
								<?php 
								foreach ($executive_levels as $level_list)
								{ 	
									#echo '<pre>';
									#print_r($level_list) ;
								?>
									<option value="<?php echo $level_list->id ; ?>" <?php  if( $level_list->id== @$consultant_executive_data[0]->executive_level_id ) { echo "selected='selected'"; } ?> ><?php echo ucwords($level_list->executive_level); ?></option>
								<?php							
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('username')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="username" id="username"  maxlength = "50" style="width: 150px;" readonly="readonly" class="inputbox" value="<?php echo (isset($user['username']) ? $user['username'] : set_value('username',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('name')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="name" id="first_name"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($user['name']) ? $user['name'] : set_value('name',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('email')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="email" id="email"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($user['email']) ? $user['email'] : set_value('email',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('phone')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="phone" id="phone"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo isset($user['phone']) ? $user['phone'] :  set_value('phone','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('active')?>: <span>&nbsp;</span></td>
						<td width="60%" align="left"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ((isset($user['status']) ? $user['status'] : set_value('status','')) == 1) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Save" />
							<input type="button" value="Cancel" class="button" 
							<?php 
							#echo '<pre>' ;
							#print_r($this->session->userdata['user']) ;
							#echo '</pre>';

						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{
						?>
						onclick="javascript: window.location.href='<?php echo base_url();?>consultant/manage';" 
						<?php 
						}
						else if( $edit_roleid==2 )
						{
							?>
							onclick="javascript: window.location.href='<?php echo base_url().'consultant/manage';?>';"
							<?php
						}
						else
						{
						?>
						onclick="javascript: window.location.href='<?php echo base_url().'consultant/desktop';?>';"	
						<?php
						}
						?>
							
							/>	
							
							
							<input  type="hidden" name="formSubmitted" value="1" />
							<input  type="hidden" name="id" value="<?php echo $user['id']; ?>" />
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


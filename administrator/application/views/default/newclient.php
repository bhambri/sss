<div class="page">
<script type='text/javascript' language='javascript'>
//<![CDATA[
	var rules = new Array();
	rules[0]  = 'fName:First Name|required';
	rules[1]  = 'fName:First Name|alphaspace';
	rules[2]  = 'fName:First Name|minlength|2'; 
	rules[3]  = 'fName:First Name|maxlength|30'; 

	//rules[4]  = 'lName:Last Name|required';
	//rules[5]  = 'lName:Last Name|alphaspace';
	//rules[6]  = 'lName:Last Name|minlength|2'; 
	//rules[7]  = 'lName:Last Name|maxlength|30'; 

	rules[12] ='password:<?php echo lang("password")?>|required';
	rules[13] ='password:<?php echo lang("password")?>|minlength|6';
	rules[14] ='passwordconf:<?php echo lang("conf_password")?>|equal|$password';
	rules[15] ='email:<?php echo lang("email")?>|required';
	rules[16] ='email:<?php echo lang("email")?>|email';

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

			<?php echo form_open('client/add',array('id'=>'formNewclient','name'=>'formNewclient', 'onsubmit'=>'return yav.performCheck(\'formNewclient\', rules, \'innerHtml\');'));?>


			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Full Name: <span> * </span></td>
						<td width="60%"><input type="text" name="fName" id="fName"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('fName','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">(Store Name) Username: <span> * </span></td>
						<td width="60%"><input type="text" name="uName" id="uName"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('uName','');?>" /> &nbsp;<font size="-1">This will be used for store login as well as in CSV as a Store Name.</font></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('email')?>: <span> * </span></td>
						<td width="60%"><input type="text" name="email" id="email"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('email','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('password')?>: <span> * </span></td>
						<td width="60%"><input type="password" name="password" id="password"  maxlength = "50" style="width: 150px;" class="inputbox" value="" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('conf_password')?>: <span> * </span></td>
						<td width="60%"><input type="password" name="passwordconf" id="passwordconf"  maxlength = "50" style="width: 150px;" class="inputbox" value="" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Company Name: <span> * </span></td>
						<td width="60%"><input type="text" name="company" id="company"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('company','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Address: <span> &nbsp; </span></td>
						<td width="60%"><textarea name="address" id="address"  style="width: 150px; height:100px;" class="inputbox"></textarea></td>
					</tr>
					
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">City: <span> &nbsp; </span></td>
						<td width="60%"><input type="text" name="city" id="city"  style="width: 150px;" class="inputbox" value="" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">State: <span> &nbsp; </span></td>
						<td width="60%"><input type="text" name="state_code" id="state_code"  style="width: 150px;" class="inputbox" value="" /></td>

					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Zip: <span> &nbsp; </span></td>
						<td width="60%"><input type="text" name="zip" id="zip"  maxlength = "50" style="width: 150px;" class="inputbox" value="" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Comments: <span> &nbsp; </span></td>
						<td width="60%"><textarea name="comments" id="comments"  style="width: 150px; height:100px;" class="inputbox"></textarea></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('phone')?>: <span> * </span></td>
						<td width="60%"><input type="text" name="phone" id="phone"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('phone','');?>" /></td>
					</tr>
					
					
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('fax')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="fax" id="fax"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('fax','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('sale_support_email')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="sale_support_email" id="sale_support_email"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('sale_support_email','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('partner_support_email')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="partner_support_email" id="partner_support_email"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('partner_support_email','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('technical_support_email')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="technical_support_email" id="technical_support_email"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('technical_support_email','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('about_us_link')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="about_us_link" id="about_us_link"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('about_us_link','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('opportunity_link')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="opportunity_link" id="opportunity_link"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('opportunity_link','');?>" /></td>
					</tr>
					
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('active')?><span>&nbsp;</span> </td>
						<td width="60%"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo set_checkbox('status','1');?> /></td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Submit" />
							<input  type="button" value="Cancel" class="button" onclick="javascript: window.location ='<?php echo base_url(); ?>client/manage'" />
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


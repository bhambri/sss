<div class="page">
<script type='text/javascript' language='javascript'>
//<![CDATA[
	var rules = new Array();
	rules[0] = 'fName:<?php echo lang("first_name")?>|required';
	rules[1] = 'fName:<?php echo lang("first_name")?>|alphaspace';
	//rules[2] = 'fName:<?php echo lang("first_name")?>|minlength|2';
	rules[3] = 'fName:<?php echo lang("first_name")?>|maxlength|15';

	rules[8]= 'email:<?php echo lang("email")?>|required';
	rules[9] = 'email:<?php echo lang("email")?>|email';

//]]>

</script>
<?php $cusrrole = $this->session->userdata('user') ;

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
			<?php echo form_open('client/edit/id/'.$client->id ,array('id'=>'formEditclient','name'=>'formEditclient', 'onsubmit'=>'return yav.performCheck(\'formEditclient\', rules, \'innerHtml\');'));?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2" align="left"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Full Name: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="fName" id="fName"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($client->fName) ? $client->fName : set_value('fName',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">(Store Admin Name) Username: <span> * </span></td>
						<td width="60%" align="left"><input readonly="readonly" type="text" name="uName" id="uName"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($client->username) ? $client->username : set_value('username',''));?>" /> &nbsp;<font size="-1">This will be used for store login as well as in CSV as a Store Name.</font></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('email')?>: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="email" id="email"  style="width: 150px;" class="inputbox" value="<?php echo (isset($client->email) ? $client->email : set_value('email',''));?>" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Company Name: <span> * </span></td>
						<td width="60%"><input type="text" name="company" id="company"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($client->company) ? $client->company : set_value('company',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Address: <span>&nbsp;</span></td>
						<td width="60%"><textarea name="address" id="address"  style="width: 150px; height:100px;" class="inputbox"><?php echo (isset($client->address) ? $client->address : set_value('address',''));?></textarea></td>
					</tr>
					
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">City: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="city" id="city"  style="width: 150px;" class="inputbox" value="<?php echo (isset($client->city) ? $client->city : set_value('city',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">State: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="state_code" id="state_code"  style="width: 150px;" class="inputbox" value="<?php echo (isset($client->state_code) ? $client->state_code : set_value('state_code',''));?>" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Zip: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="zip" id="zip"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($client->zip) ? $client->zip : set_value('zip',''));?>" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Comments: <span>&nbsp;</span></td>
						<td width="60%"><textarea name="comments" id="comments"  style="width: 150px; height:100px;" class="inputbox"><?php echo (isset($client->comments) ? $client->comments : set_value('comments',''));?></textarea></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('phone')?>: <span> * </span></td>
						<td width="60%"><input type="text" name="phone" id="phone"  style="width: 150px;" class="inputbox" value="<?php echo (isset($client->phone) ? $client->phone : set_value('phone',''));?>" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"> Consultant fee <?php #echo lang('phone')?>: <span> * </span></td>
						<td width="60%"><input type="text" name="consultantfee" id="consultantfee"  style="width: 150px;" class="inputbox" value="<?php echo (isset($client->consultantfee) ? $client->consultantfee : set_value('consultantfee',''));?>" /> <font size="-1">(Recurring monthly fee, should be > 0 )</font></td>
					</tr>

					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"> Signup fee <?php #echo lang('phone')?>: <span> * </span></td>
						<td width="60%"><input type="text" name="signupfee" id="signupfee"  style="width: 150px;" class="inputbox" value="<?php echo (isset($client->signupfee) ? $client->signupfee : set_value('signupfee',''));?>" /> <font size="-1">(Initial sign up fee, should be > 0 )</font></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"> Billing Start delay <?php #echo lang('phone')?>: <span> * </span></td>
						<td width="60%"><input type="text" name="billing_start_delay" id="billing_start_delay"  style="width: 150px;" class="inputbox" value="<?php echo (isset($client->billing_start_delay) ? $client->billing_start_delay : set_value('billing_start_delay',''));?>" /> <font size="-1">(Delayed month value , Please note that this should be integer only(from 1 to 11)).</font></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('fax')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="fax" id="fax"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($client->fax) ? $client->fax : set_value('fax',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('sale_support_email')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="sale_support_email" id="sale_support_email"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($client->sale_support_email) ? $client->sale_support_email : set_value('sale_support_email',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('partner_support_email')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="partner_support_email" id="partner_support_email"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($client->partner_support_email) ? $client->partner_support_email : set_value('partner_support_email',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('technical_support_email')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="technical_support_email" id="technical_support_email"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($client->technical_support_email) ? $client->technical_support_email : set_value('technical_support_email',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('about_us_link')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="about_us_link" id="about_us_link"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($client->about_us_link) ? $client->about_us_link : set_value('about_us_link',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('opportunity_link')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="opportunity_link" id="opportunity_link"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($client->opportunity_link) ? $client->opportunity_link : set_value('opportunity_link',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php #echo lang('opportunity_link')?> Training Link: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="training_link" id="training_link"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($client->training_link) ? $client->training_link : set_value('training_link',''));?>" /></td>
					</tr>
<?php if($cusrrole['role_id'] == 1){ ?>					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Store Url<?php #echo lang('opportunity_link')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="text" name="store_url" id="store_url"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($client->store_url) ? $client->store_url : set_value('store_url',''));?>" /> <font size="-1">(Please note this domain needs to assigned the ip).</font></td>
					</tr>


<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">MLM type<?php #echo lang('opportunity_link')?>: <span>&nbsp;</span></td>
						<td width="60%"><input type="checkbox" name="is_mlmtype" id="is_mlmtype"  maxlength = "100" style="width: 150px;" class="inputbox" value="1" <?php echo ((isset($client->is_mlmtype) ? $client->is_mlmtype : set_value('is_mlmtype','')) == 1) ? 'checked="checked"' : '';?> " /> <font size="-1">(MLM Type Companies).</font></td>
					</tr>
<?php } ?>
					<?php 
						$styleclass = "" ;
					    if($cusrrole['role_id'] != 1){ $styleclass = 'display:none;' ; } ?>
					<tr style="<?php echo $styleclass ;?>">
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('active')?>: <span>&nbsp;</span></td>
						<td width="60%" align="left"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ((isset($client->status) ? $client->status : set_value('status','')) == 1) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Save" />
							<!-- input type="button" value="Cancel" class="button" onclick="javascript: window.location='<?php echo base_url(); ?>client/manage';"/-->
							<input type="button" value="Cancel" class="button" onclick="javascript:history.back();"/>	
							<input  type="hidden" name="formSubmitted" value="1" />
							<input  type="hidden" name="id" value="<?php echo (isset($client->id) ? $client->id : $this->input->post('id'))?>" />
							<input  type="hidden" name="salt" value="<?php echo (isset($client->password_salt) ? $client->password_salt : $this->input->post('salt'))?>" />
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


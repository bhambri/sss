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
			<?php echo form_open('settings/add_settings',array('id'=>'formAddsettings', 'enctype'=>'multipart/form-data','name'=>'formAddsettings', 'onsubmit'=>'return yav.performCheck(\'formAddsettings\', rules, \'classic\');'));?>
			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Logo image <span></span></td>
						<td width="60%">
						<input type="file" name="logo_image" id="logo_image" value="<?php echo set_value('logo_image',@$logo_image);?>" /> recommended height:160, width: 80 ,max size: 5000 kb    
						</td>
					</tr>
					<?php if(($role_id != 4)  && ($role_id != 1)) { ;?>
					<!-- <tr id="enter_allowed_times">
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Paypal Username <span> * </span></td>
						<td width="60%"><input type="text" name="paypal_username" id="paypal_username" maxlength="30" style="width: 250px;" class="inputbox" value="<?php echo set_value('paypal_username',@$paypal_username);?>" > (Business Account, needed to get all payments)</td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Paypal Email: <span> * </span></td>
						<td width="60%"><input type="text" name="paypal_email" id="paypal_email"  maxlength = "100" style="width: 250px;" class="inputbox" value="<?php echo set_value('paypal_email',@$paypal_email);?>" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">PayPal Signature:<span> * </span></td>
						<td width="60%"><input type="text" name="paypal_signature" id="paypal_signature"  style="width: 250px;" class="inputbox" value="<?php echo set_value('paypal_signature',@$paypal_signature);?>" /> (Business Account, needed to get all payments)</td>
					</tr>

					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Paypal Password:<span> * </span></td>
						<td width="60%"><input type="text" name="paypal_password" id="paypal_password"  style="width: 250px;" class="inputbox" value="<?php echo set_value('paypal_password',@$paypal_password);?>" /> (Business Account, needed to get all payments)</td>
					</tr>

					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Merchant ID:<span>  </span></td>
						<td width="60%"><input type="text" name="mp_merchant_id" id="mp_merchant_id"  style="width: 250px;" class="inputbox" value="<?php echo set_value('mp_merchant_id',@$mp_merchant_id);?>" /> (Meritus Pay , Merchant account , required to enable Meritus pay for customers)</td>
					</tr>

					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Merchant Key:<span> </span></td>
						<td width="60%"><input type="text" name="mp_merchant_key" id="mp_merchant_key"  style="width: 250px;" class="inputbox" value="<?php echo set_value('mp_merchant_key',@$mp_merchant_key);?>" /> (Meritus Pay , Merchant account , required to enable Meritus pay for customers)</td>
					</tr>
					-->
					<!--  AVAlara tax settings section -->
					<!-- <tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Account Number:<span> </span></td>
						<td width="60%"><input type="text" name="ava_account_number" id="ava_account_number"  style="width: 250px;" class="inputbox" value="<?php echo set_value('ava_account_number',@$ava_account_number);?>" /> (Avalara AVA Tax , Account No. , required to enable tax calculation using avalara )</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Licence Key:<span> </span></td>
						<td width="60%"><input type="text" name="ava_license_key" id="ava_license_key"  style="width: 250px;" class="inputbox" value="<?php echo set_value('ava_license_key',@$ava_license_key);?>" /> (Avalara AVA Tax , Licence key , required to enable tax calculation using avalara )</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Company Code:<span> </span></td>
						<td width="60%"><input type="text" name="ava_company_code" id="ava_company_code"  style="width: 250px;" class="inputbox" value="<?php echo set_value('ava_company_code',@$ava_company_code);?>" /> (Avalara AVA Tax , Company Code , required to enable tax calculation using avalara ) </td>
					</tr> -->
					<!--  AVAlara tax settings section ends here -->

					<!-- <tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Tax:<span> * </span></td>
						<td width="60%"><input type="text" name="tax" id="tax"  style="width: 250px;" class="inputbox" value="<?php echo set_value('tax',@$tax);?>" />% (This will be used in tax calculation)</td>
					</tr> -->
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Change Consultant label to : <span> </span></td>
						<td width="60%">
						    <input type="text" name="consultant_label" id="consultant_label" style="width: 250px;" class="inputbox" value="<?php echo set_value('consultant_label',@$consultant_label);?>"/>						    
						</td>
					</tr>
					<?php } ?>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Facebook link:<span> * </span> </td>
						<td width="60%">
						    <input type="text" name="fb_link" id="fb_link" style="width: 250px;" class="inputbox" value="<?php echo set_value('fb_link',@$fb_link);?>"/>					    
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Twitter link: <span> * </span></td>
						<td width="60%">
						    <input type="text" name="twitter_link" id="twitter_link" style="width: 250px;" class="inputbox" value="<?php echo set_value('twitter_link',@$twitter_link);?>"/>						    
						</td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Pinterest link:<span> * </span> </td>
						<td width="60%">
						    <input type="text" name="pinterest_link" id="pinterest_link" style="width: 250px;" class="inputbox" value="<?php echo set_value('pinterest_link',@$pinterest_link);?>"/>						    
						</td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Linkdin link: <span> * </span></td>
						<td width="60%">
						    <input type="text" name="linkdin_link" id="linkdin_link" style="width: 250px;" class="inputbox" value="<?php echo set_value('linkdin_link',@$linkdin_link);?>"/>						    
						</td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Google+ link: <span> * </span></td>
						<td width="60%">
						    <input type="text" name="gplus_link" id="gplus_link" style="width: 250px;" class="inputbox" value="<?php echo set_value('gplus_link',@$gplus_link);?>"/>						    
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Youtube link: <span> * </span></td>
						<td width="60%">
						    <input type="text" name="youtube_link" id="youtube_link" style="width: 250px;" class="inputbox" value="<?php echo set_value('youtube_link',@$youtube_link);?>"/>						    
						</td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Published: </td>
						<td width="60%"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo isset($status)?'checked="checked"':'';?> /></td>
					</tr>
					
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="submit" class="button" value="Add" />
							<input type="button" class="button" value="Cancel" onclick="javascript:window.location='<?php echo base_url()?>settings/manage_settings'" />
							<input  type="hidden" name="formSubmitted" value="1" class="button" />
							<!-- <input  type="hidden" name="id" value="<?php echo $id;?>" class="button" /> -->
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

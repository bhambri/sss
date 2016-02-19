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
			<?php echo form_open('settings/edit_settings_paypal/'.$id,array('id'=>'formEditsettings','enctype'=>'multipart/form-data','name'=>'formEditsettings', 'onsubmit'=>'return yav.performCheck(\'formEditsettings\', rules, \'classic\');'));?>
			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>

					<?php if(($role_id !=4 ) && ($role_id != 1 )) {?>
					<tr id="enter_allowed_times">
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Paypal Username <span> * </span></td>
						<td width="60%"><input type="text" name="paypal_username" id="paypal_username" maxlength="30" style="width: 250px;" class="inputbox" value="<?php echo set_value('paypal_username',@$paypal_username);?>" >(Business Account, needed to get all payments)</td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Paypal Email: <span> * </span></td>
						<td width="60%"><input type="text" name="paypal_email" id="paypal_email"  maxlength = "100" style="width: 250px;" class="inputbox" value="<?php echo set_value('paypal_email',@$paypal_email);?>" /> </td>
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
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Cart Payments(using):<span> * </span></td>
						<td width="60%"><input type="radio" name="payusing" id="payusing" value="0" <?php if(!$payusing){ echo 'checked'; } ?> > Paypal</input><input type="radio" name="payusing" id="payusing" value="1" <?php if($payusing == 1){ echo 'checked'; } ?>> Meritus</input> </td>
					</tr>
					
					<?php } ?>
					
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="submit" class="button" value="Save" />
							<input  type="hidden" name="formSubmitted" value="1" class="button" />
							<input  type="hidden" name="id" value="<?php echo $id;?>" class="button" />
							<input  type="button" value="Cancel" onclick="javascript:window.history.go(-1);" class="button" />
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
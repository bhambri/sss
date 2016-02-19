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
			<?php echo form_open('settings/edit_settings_avatax/'.$id,array('id'=>'formEditsettings','enctype'=>'multipart/form-data','name'=>'formEditsettings', 'onsubmit'=>'return yav.performCheck(\'formEditsettings\', rules, \'classic\');'));?>
			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					
					<?php if(($role_id !=4 ) && ($role_id != 1 )) {?>
					
					<!--  AVAlara tax settings section -->
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Account Number:<span> </span></td>
						<td width="60%"><input type="text" name="ava_account_number" id="ava_account_number"  style="width: 250px;" class="inputbox" value="<?php echo set_value('ava_account_number',@$ava_account_number);?>" /> (Avalara AVA Tax, Account No., required to enable tax calculation using avalara)</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Licence Key:<span> </span></td>
						<td width="60%"><input type="text" name="ava_license_key" id="ava_license_key"  style="width: 250px;" class="inputbox" value="<?php echo set_value('ava_license_key',@$ava_license_key);?>" /> (Avalara AVA Tax, Licence key, required to enable tax calculation using avalara )</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Company Code:<span> </span></td>
						<td width="60%"><input type="text" name="ava_company_code" id="ava_company_code"  style="width: 250px;" class="inputbox" value="<?php echo set_value('ava_company_code',@$ava_company_code);?>" /> (Avalara AVA Tax, Company Code, required to enable tax calculation using avalara ) </td>
					</tr> 
					<!--  AVAlara tax settings section ends here -->
					
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

<div class="page">
<script type='text/javascript' language='javascript'>
//<![CDATA[
	var rules = new Array();
	rules[0] = 'page_title:<b>Page Title</b>|required';
	rules[1] = 'page_shortdesc:<b>Page Name</b>|required';
	rules[2] = 'page_content:<b>Content</b>|custom|content_validate()';

function content_validate()
{
		if(jQuery.trim(tinyMCE.activeEditor.getContent())=="")

            {
              return "Description must be entered!";
            }
}

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
			<?php echo form_open('settings/edit_settings_meritus/'.$id,array('id'=>'formEditsettings','enctype'=>'multipart/form-data','name'=>'formEditsettings', 'onsubmit'=>'return yav.performCheck(\'formEditsettings\', rules, \'classic\');'));?>
			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					
					<?php if(($role_id !=4 ) && ($role_id != 1 )) {?>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Merchant ID:<span>  </span></td>
						<td width="60%"><input type="text" name="mp_merchant_id" id="mp_merchant_id"  style="width: 250px;" class="inputbox" value="<?php echo set_value('mp_merchant_id',@$mp_merchant_id);?>" /> (Meritus Pay, Merchant account, required to enable Meritus pay for customers)</td>
					</tr>

					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Merchant Key:<span> </span></td>
						<td width="60%"><input type="text" name="mp_merchant_key" id="mp_merchant_key"  style="width: 250px;" class="inputbox" value="<?php echo set_value('mp_merchant_key',@$mp_merchant_key);?>" /> (Meritus Pay, Merchant account, required to enable Meritus pay for customers)</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Cart Payments(using):<span> * </span></td>
						<td width="60%"><input type="radio" name="payusing" id="payusing" value="0" <?php if(!$payusing){ echo 'checked'; } ?> > Paypal</input><input type="radio" name="payusing" id="payusing" value="1" <?php if($payusing == 1){ echo 'checked'; } ?>> Meritus</input> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Enable Meritus for Consultant Payments :</td>
						<td width="60%">
							<input type="checkbox" name="meritus_enabled" id="meritus_enabled" <?php if($meritus_enabled){ echo 'checked'; } ?> > 
						</td>
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

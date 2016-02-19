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
			<?php echo form_open('executives/executive_edit/' ,array('id'=>'formEditExecutive','name'=>'formEditExecutive', 'onsubmit'=>'return yav.performCheck(\'formEditUser\', rules, \'classic\');'));?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2" align="left"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Executive Level: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="e_level" id="e_level"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($executive->executive_level) ? $executive->executive_level : set_value('e_level',''));?>" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Bonus Amount: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="bonus_amt" id="bonus_amt"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($executive->bonus_amt) ? $executive->bonus_amt : set_value('bonus_amt',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Executive Level order: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="exec_order" id="exec_order"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($executive->exec_order) ? $executive->exec_order : set_value('exec_order',''));?>" /></td>
					</tr>

					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Generation Access: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="g_access" id="g_access"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo isset($executive->generation_access) ? $executive->generation_access :  set_value('g_access','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Direct Commission: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="d_commission" id="d_commission"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($executive->direct_commision) ? $executive->direct_commision : set_value('d_commission',''));?>" />(%)</td>
					</tr>
					<tr style="display:none;">
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Configurable Volume: </td>
						<td width="60%"><input type="text" name="configurable_volume_percentage" id="configurable_volume_percentage"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($executive->configurable_volume_percentage) ? $executive->configurable_volume_percentage : set_value('configurable_volume_percentage',''));?>" />(%)</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Personal Purchase Volume: </td>
						<td width="60%"><input type="text" name="personal_purchase_volume" id="personal_purchase_volume"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($executive->personal_purchase_volume) ? $executive->personal_purchase_volume : set_value('personal_purchase_volume',''));?>" />(%)</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Personal Customer Volume: </td>
						<td width="60%"><input type="text" name="personal_customer_volume" id="personal_customer_volume"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($executive->personal_customer_volume) ? $executive->personal_customer_volume : set_value('personal_customer_volume',''));?>" />(%)</td>
					</tr> 
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Configurable Binary Volume: </td>
						<td width="60%"><input type="text" name="configurable_binary_volume" id="configurable_binary_volume"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo (isset($executive->configurable_binary_volume) ? $executive->configurable_binary_volume : set_value('configurable_binary_volume',''));?>" />(%)</td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Save" />
							<input type="button" value="Cancel" class="button" onclick="javascript: window.location='<?php echo base_url(); ?>executives/executive_manage';"/>	
							<input  type="hidden" name="formSubmitted" value="1" />
							<input  type="hidden" name="id" value="<?php echo (isset($executive->id) ? $executive->id : $this->input->post('id'))?>" />
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


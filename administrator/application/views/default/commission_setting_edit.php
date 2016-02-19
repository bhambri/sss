<div class="page">
<?php //echo "<pre>";print_r($client);die;echo $client->fName; die;?>
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
			<?php echo form_open('consultant/commission_setting_edit/'.$comm_setting['id'] ,array('id'=>'formEditclient','name'=>'formEditclient', 'onsubmit'=>'return yav.performCheck(\'formEditclient\', rules, \'innerHtml\');'));?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2" align="left"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Level 1: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="level1" id="level1"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($comm_setting['level1']) ? $comm_setting['level1'] : set_value('level1',''));?>" /> (%) </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Level 2: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="level2" id="level2"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($comm_setting['level2']) ? $comm_setting['level2'] : set_value('level2',''));?>" /> (%)</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Level 3: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="level3" id="level3"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($comm_setting['level3']) ? $comm_setting['level3'] : set_value('level3',''));?>" /> (%)</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Level 4: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="level4" id="level4"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($comm_setting['level4']) ? $comm_setting['level4'] : set_value('level4',''));?>" /> (%)</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Level 5: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="level5" id="level5"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($comm_setting['level5']) ? $comm_setting['level5'] : set_value('level5',''));?>" /> (%)</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Level 6: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="level6" id="level6"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($comm_setting['level6']) ? $comm_setting['level6'] : set_value('level6',''));?>" /> (%)</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"><?php echo lang('active')?>: <span>&nbsp;</span></td>
						<td width="60%" align="left"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ((isset($comm_setting['status']) ? $comm_setting['status'] : set_value('status','')) == 1) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Save" />
							<!-- input type="button" value="Cancel" class="button" onclick="javascript: window.location='<?php echo base_url(); ?>client/manage';"/-->
							<input type="button" value="Cancel" class="button" onclick="javascript:history.back();"/>	
							<input  type="hidden" name="formSubmitted" value="1" />
							<input  type="hidden" name="id" value="<?php echo (isset($comm_setting['id']) ? $comm_setting['id'] : $this->input->post('id'))?>" />
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


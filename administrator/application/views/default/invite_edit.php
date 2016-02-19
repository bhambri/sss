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
			<?php echo form_open('consultant/invite_edit/'.$edit_data_invite['id'] ,array('id'=>'formEditclient','name'=>'formEditclient', 'onsubmit'=>'return yav.performCheck(\'formEditclient\', rules, \'innerHtml\');'));?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2" align="left"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Receiver Email Address: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="email" id="email"  maxlength = "100" style="width: 300px;" class="inputbox" value="<?php echo (isset($edit_data_invite['email']) ? $edit_data_invite['email'] : set_value('email',''));?>" /></td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Save" />
							<!-- input type="button" value="Cancel" class="button" onclick="javascript: window.location='<?php echo base_url(); ?>client/manage';"/-->
							<input type="button" value="Cancel" class="button" onclick="javascript:history.back();"/>	
							<input  type="hidden" name="formSubmitted" value="1" />
							<input  type="hidden" name="id" value="<?php echo (isset($edit_data_invite['id']) ? $edit_data_invite['id'] : $this->input->post('id'))?>" />
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


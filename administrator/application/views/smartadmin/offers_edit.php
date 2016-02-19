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
			<?php 
			//echo form_open_multipart('front_blocks/front_blocks_edit/' ,array('id'=>'formEditFrontBlocks','name'=>'formEditFrontBlocks', 'onsubmit'=>'return yav.performCheck(\'formEditUser\', rules, \'classic\');'));
			echo form_open_multipart('offers/offers_edit/' ,array('id'=>'formEditOffers','name'=>'formEditOffers'));
			?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2" align="left"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Block Title: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="title" id="title"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($offers->title) ? $offers->title : set_value('title',''));?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Image Text: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="image_text" id="image_text"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo isset($offers->image_text) ? $offers->image_text :  set_value('image_text','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Image: <span> * </span></td>
						<td width="60%" align="left"><img src="<?php echo ROOT_PATH; ?><?php echo $offers->image; ?>" width="150px" height="150px" /></td>
					</tr>
					<tr>						
						<td nowrap="nowrap" class="input_form_caption_td">Upload Image: </td>
						<td id='image_section'>
							<div>
								<input type='file' name='image' id='image' value="<?php echo set_value('image','');?>">
							</div>
						</td>										
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Block Link: <span> * </span></td>
						<td width="60%"><input type="text" name="link" id="link"  maxlength = "200" style="width: 300px;" class="inputbox" value="<?php echo isset($offers->link) ? $offers->link :  set_value('link','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Priority: <span> * </span></td>
						<td width="60%"><input type="text" name="priority" id="priority"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo isset($offers->priority) ? $offers->priority :  set_value('priority','');?>" />&nbsp;It should be positive number, greater then 0 (Zero).</td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Save" />
							<input type="button" value="Cancel" class="button" onclick="javascript: window.location='<?php echo base_url(); ?>offers/offers_manage';"/>	
							<input  type="hidden" name="formSubmitted" value="1" />
							<input  type="hidden" name="id" value="<?php echo (isset($offers->id) ? $offers->id : $this->input->post('id'))?>" />
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


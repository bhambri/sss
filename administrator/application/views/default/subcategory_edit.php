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
			<?php echo form_open('subcategory/edit/id/'.$this->cat_id ,array('id'=>'formEditclient','name'=>'formEditclient'));?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2" align="left"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td width="30%" nowrap="nowrap" class="input_form_caption_td">Select Category:<span>&nbsp;*</span></td>
						<td width="70%" align="left">
							<select name="category_id">
							<?php if( isset( $categories ) ):
								foreach ($categories as $category ) {
									 $select = ( $subcategory->category_id == $category->id ) ? 'selected':'';
									echo "<option value='". $category->id ."' " . $select .  ">" . $category->name . "</option>";
								}
								endif;
							 ?>
								
							</select>							
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Name: <span> * </span></td>
						<td width="60%" align="left"><input type="text" name="name" id="name"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo (isset($subcategory->name) ? $subcategory->name : set_value('fName',''));?>" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Description: <span> &nbsp; </span></td>
						<td width="60%"><textarea name="description" id="description"  style="width: 150px; height:100px;" class="inputbox"><?php echo (isset($subcategory->description) ? $subcategory->description : set_value('description',''));?></textarea></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Active: <span>&nbsp;</span></td>
						<td width="60%" align="left"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ((isset($subcategory->status) ? $subcategory->status : set_value('status','')) == 1) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="<?php echo lang("btn_submit"); ?>" />
							<input type="button" value="Cancel" class="button" onclick="javascript: window.location='<?php echo base_url(); ?>subcategory/manage';"/>	
							<input  type="hidden" name="formSubmitted" value="1" />
							<input  type="hidden" name="id" value="<?php echo (isset($subcategory->id) ? $subcategory->id : $this->input->post('id'))?>" />
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


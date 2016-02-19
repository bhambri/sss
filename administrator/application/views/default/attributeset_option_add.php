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
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if( !empty($error_msg)): ?>
			<ul class="error_ul"><?php // echo $error_msg;?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Errors And Message Display Row > -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('errors')): ?>
			<ul class="error_ul"><?php //echo $this->session->flashdata('errors');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<tr>
		<td id="content_center_td" valign="top">
			<?php echo form_open_multipart('',array('id'=>'formNewMember','name'=>'formNewMember', 'onsubmit'=>'return yav.performCheck(\'formNewMember\', rules, \'innerHtml\');'));?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
					<tr>
						<td width="30%" nowrap="nowrap" class="input_form_caption_td">Field label to show:<span>&nbsp;*</span></td>
						<td width="70%" align="left"><input type="text" name="field_label" id="field_label"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('field_label', @$attribute_set_field->field_label) ; ?>" /></td>
					</tr>
					<tr>
						<td width="30%" nowrap="nowrap" class="input_form_caption_td">Select Attribute set:<span>&nbsp;*</span></td>
						<td width="70%" align="left">
							<select name="attribute_set_id">
							<?php if( isset( $attributesets ) ):
								foreach ($attributesets as $attributeset ) 
								{
									?>
									<option value="<?php echo $attributeset->id;?>" <?php if($curr_session_cat_id==$attributeset->id) { echo "selected='selected'"; } ?> ><?php echo $attributeset->name;?></option>
									<?php
								}
								endif;
							 ?>
								
							</select>							
						</td>
					</tr>
					<tr>
						<td width="30%" nowrap="nowrap" class="input_form_caption_td">Select Attribute option type:<span>&nbsp;*</span></td>
						<td width="70%" align="left">
							<select name="field_type" onchange="providefields();" id="field_type" >
								<option value="text" <?php if(isset($attribute_set_field->field_type) && ($attribute_set_field->field_type == 'text')){ echo 'selected' ; }?> >Text</option>
								<option value="radio" <?php if(isset($attribute_set_field->field_type) && ($attribute_set_field->field_type == 'radio')){ echo 'selected' ; }?> >Radio</option>	
								<option value="selectbox" <?php if(isset($attribute_set_field->field_type) && ($attribute_set_field->field_type == 'selectbox')){ echo 'selected' ; } ?> >Select Box</option>	
								<option value="checkbox"  <?php if(isset($attribute_set_field->field_type) && ($attribute_set_field->field_type == 'checkbox')){ echo 'selected' ; }?> >checkbox</option>	
							</select>							
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Required: <span>&nbsp;</span></td>
						<td width="60%" align="left"><input type="checkbox" name="required" id="required" class="inputbox" value="1" <?php echo ((isset($attribute_set_field->required) ? $attribute_set_field->required : set_value('required','')) == 1) ? 'checked="checked"' : '';?> />
						</td>
					</tr>	
					<tr id="chooseno_of_options">
						<!-- <td width="30%" nowrap="nowrap" class="input_form_caption_td">Select No of options:<span>&nbsp;*</span></td>
						<td width="70%" align="left">
							<select name="no_of_options" onchange="drawoptions();"; id="field_type">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
							</select>							
						</td> -->
						<?php if(@$attribute_set_field->id && (($attribute_set_field->field_type == 'radio') || ($attribute_set_field->field_type == 'selectbox') || ($attribute_set_field->field_type == 'checkbox')) ){ ?>
						<td width="30%" nowrap="nowrap" class="input_form_caption_td">Select No of options to add:<span>&nbsp;*</span></td>
						<td width="70%" align="left">
							<select name="no_of_options" onchange="drawoptions();" id="no_of_options" >
								<option value="1" <?php if(@$no_of_options == 1){ echo 'selected'; } ?> >1</option>
								<option value="2" <?php if(@$no_of_options == 2){ echo 'selected'; } ?> >2</option>
								<option value="3" <?php if(@$no_of_options == 3){ echo 'selected'; } ?> >3</option>
								<option value="4" <?php if(@$no_of_options == 4){ echo 'selected'; } ?> >4</option>
								<option value="5" <?php if(@$no_of_options == 5){ echo 'selected'; } ?> >5</option>
								<option value="6" <?php if(@$no_of_options == 6){ echo 'selected'; } ?> >6</option>
								<option value="7" <?php if(@$no_of_options == 7){ echo 'selected'; } ?> >7</option>
							</select> ( * option values are mandatory, if no option values provided that option will not be added/edited. )							
						</td> 
						<?php } ?>
					</tr>
					<tr style=""><td id="options_name_list1" style="width:100%;" colspan="2">
						<?php if(@$attribute_set_field->id && $no_of_options > 0 ){ 
							#echo '<pre>';
							#print_r($attribute_set_field_details_price) ;
							foreach ($attribute_set_field_details as $key => $value) { # code... 

								?>
							<tr><td width="30%" nowrap="nowrap" class="input_form_caption_td">Option:<span>&nbsp;*</span></td><td width="70%" align="left"><input type="text" name="options_name[<?php echo $key ; ?>]" id="field_label"  maxlength = "200" style="width: 150px;" class="inputbox" value="<?php echo $value ;?>" /> 
							 <input type="text" name="options_price[<?php echo $key ; ?>]" id="field_label"  maxlength = "6" style="width: 100px;" class="inputbox" value="<?php echo $attribute_set_field_details_price[$key] ;?>" />
							 (option name - price) <a href="<?php echo base_url()?>attributesets/remove_attr_opt/<?php echo $key ; ?>"><img border="0" alt="deactive" src="<?php echo base_url()?>/application/views/default/images/publish_x.png"></a> </td></tr>
						<?php  } 
							} ?>
					</td></tr>
					<tr><td></td><td> </td></tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Submit" />
							<input type="button" value="Cancel" class="button" onclick="javascript:window.location='<?php echo base_url()?>attributesets/manage_options'"/>	
							<input  type="hidden" name="formSubmitted" value="1" />
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
<script>
	function providefields(){
		//alert('provide fields') ;
		typeval = jQuery("#field_type").val() ;
		if(typeval == 'text'){
			// nothing to do
			// + remove the options if there
			jQuery('#no_of_options').html('');
		}
		if((typeval == 'radio') || (typeval == 'selectbox') || (typeval == 'checkbox')){
			// provide the radio option
			// alert('Enter no of option') ;
			noofoption = '<td width=\"30%\" nowrap=\"nowrap\" class=\"input_form_caption_td\">Choose No of options:<span>&nbsp;*</span></td><td width=\"70%\" align=\"left\"><select name=\"no_of_options\" onchange=\"drawoptions();\" id=\"no_of_options\"><option value=\"0\">0</option><option value=\"1\">1</option><option value=\"2\">2</option><option value=\"3\">3</option><option value=\"4\">4</option><option value=\"5\">5</option><option value=\"6\">6</option><option value=\"7\">7</option></select></td>';
			jQuery('#chooseno_of_options').html(noofoption);
		}
		/* if(typeval == 'selectbox'){
			// provide selectbox option
		}
		if(typeval == 'checkbox'){
			// provide checkbox option
		}
		*/
	}

	function drawoptions(){
		//alert('draw options fields');
		//options_name_list
		varoptfields = '<table style=\"width:100%\" class="\input_table\"><tr><td width=\"40%\" nowrap=\"nowrap\" class=\"input_form_caption_td\">Option:<span>&nbsp;*</span></td><td width=\"60%\" align=\"left\"> <input type=\"text\" name=\"options_name[]\" id=\"field_label\"  maxlength = \"200\" style=\"width: 150px;\" class=\"inputbox\" value=\"\" /><input type=\"text\" name=\"options_price[]\" id=\"field_label\"  maxlength = \"6\" style=\"width: 100px;\" class=\"inputbox\" value=\"0.00\" /> (option name - price) </td></tr></table>' ;
		noofopt = jQuery("#no_of_options").val() ;
		//alert(noofopt) ;
		var newhtml = '' ;
		for(i=1; i<= noofopt ; i++){
			newhtml +=varoptfields ;
		}
		jQuery('#options_name_list1').html(newhtml);
	}

</script>

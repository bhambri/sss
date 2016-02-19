<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>

</script>
<div class="page">
<script type='text/javascript' language='javascript'>
//<![CDATA[
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
			<?php echo form_open('promotionrules/edit_prule',array('id'=>'formAddcoupons', 'enctype'=>'multipart/form-data','name'=>'formAddcoupons', 'onsubmit'=>'return yav.performCheck(\'formAddcoupons\', rules, \'classic\');'));?>
			<div id="content_div">
			    <input type="hidden" name="id" value="<?php echo $id ; ?>">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Executive Level: <span> * </span></td>
						<td width="60%">
						<?php //echo '<pre>';print_r($coupon_types);die;?>
						    <select name="exe_type" id="exe_type">
						        <option value="">-Select Executive Level-</option>
						        <?php foreach ( $coupon_types as $each_type ) {?>
						        <option value="<?php echo $each_type->id; ?>" <?php if(@$executive_level_id == $each_type->id){ echo "selected" ; }?>><?php echo $each_type->executive_level; ?></option>
						        <?php }?>
						    </select>
						</td>
					</tr>
					
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Min. Binary Volume <span> * </span></td>
						<td width="60%">
						<input type="text" name="binaryvol_range_from" id="binaryvol_range_from"  maxlength = "100" style="width: 250px;" class="inputbox" value="<?php if( @$binaryvol_range_from ) { echo @$binaryvol_range_from;} else { echo @$binaryvol_range_from; } ?>" />
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"> <span id="range_to" style="color:#0f52b6;font-family: arial;">Max. Binary Volume</span>: <span> * </span></td>
						<td width="60%"><input type="text" name="binaryvol_range_to" id="binaryvol_range_to"  style="width: 250px;" class="inputbox" value="<?php echo @$binaryvol_range_to ;?>" /> </td>
					</tr>

					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"> <span id="range_to" style="color:#0f52b6;font-family: arial;">Min. Personal Purchase Volume</span>: <span> * </span></td>
						<td width="60%"><input type="text" name="min_ppv" id="min_ppv"  style="width: 250px;" class="inputbox" value="<?php echo @$min_ppv ;?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"> <span id="range_to" style="color:#0f52b6;font-family: arial;">Min. Personal Customer Volume</span>: <span> * </span></td>
						<td width="60%"><input type="text" name="min_pcv" id="min_pcv"  style="width: 250px;" class="inputbox" value="<?php echo @$min_pcv ;?>" /> </td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Active: <span>&nbsp;</span></td>
						<td width="60%"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ($status)?'checked="checked"':'';?> /></td>
					</tr>
					
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="submit" class="button" value="Add" />
							<input  type="hidden" name="formSubmitted" value="1" class="button" />
							<!-- <input  type="hidden" name="id" value="<?php echo $id;?>" class="button" /> -->
							<input type="button" name="back" class="button" value="Cancel" onclick="javascript: window.history.back();"; />
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
<script type="text/javascript">
 function label_change(obj){
 	//alert(obj) ;
 	var selval=obj[obj.selectedIndex].value;
 	//alert(selval) ;
 	if((selval ==  1)){
 		
 		jQuery('#disc_label').html('Discount Amount');
 	}else if((selval ==  2)  || (selval ==  3)){
 		jQuery('#disc_label').html('Discount Percentage');
 	}else{
 		jQuery('#disc_label').html('Discount Percentage');
 	}
 }
</script>

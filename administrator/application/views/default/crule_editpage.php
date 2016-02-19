<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
$(function() {
	$( "#from_date" ).datepicker({
			defaultDate: "+1w",
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
			$( "#to_date" ).datepicker( "option", "minDate", selectedDate );
			}
		});
	$( "#to_date" ).datepicker({
			defaultDate: "+1w",
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
			$( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
			}
		});

/*
	$( "#from_date,#to_date" ).datepicker(
		{dateFormat: 'yy-mm-dd' }
		);*/

});
</script>
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
			<?php echo form_open('couponrules/edit_crule',array('id'=>'formAddcoupons', 'enctype'=>'multipart/form-data','name'=>'formAddcoupons', 'onsubmit'=>'return yav.performCheck(\'formAddcoupons\', rules, \'classic\');'));?>
			<div id="content_div">
			    <input type="hidden" name="id" value="<?php echo $id ; ?>">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Coupon Type: <span> * </span></td>
						<td width="60%">
						<?php //echo '<pre>';print_r($coupon_types);die;?>
						    <select name="coupon_type" id="coupon_type" onchange="label_change(this);">
						        <option value="">-Select Coupon Type-</option>
						        <?php foreach ( $coupon_types as $each_type ) {?>
						        <option value="<?php echo $each_type->id; ?>" <?php if($coupon_type == $each_type->id){ echo "selected" ; }?>><?php echo $each_type->name; ?></option>
						        <?php }?>
						    </select>
						</td>
					</tr>
					
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Range from: <span> * </span></td>
						<td width="60%">
						<input type="text" name="range_from" id="range_from"  maxlength = "100" style="width: 250px;" class="inputbox" value="<?php if( @$range_from ) { echo @$range_from;} else { echo @$range_from; } ?>" />
						(lower limit of group sale)</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"> <span id="range_to" style="color:#0f52b6;font-family: arial;">Range To </span>: <span> * </span></td>
						<td width="60%"><input type="text" name="range_to" id="range_to"  style="width: 250px;" class="inputbox" value="<?php echo set_value('range_to',@$range_to);?>" /> (upper limit of group sale)</td>
					</tr>

					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"> <span id="disc_label" style="color:#0f52b6;font-family: arial;">Discount Percentage </span>: <span> * </span></td>
						<td width="60%"><input type="text" name="discount_percent" id="discount_percent"  style="width: 250px;" class="inputbox" value="<?php echo set_value('discount_percent',@$discount_percent);?>" /> </td>
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

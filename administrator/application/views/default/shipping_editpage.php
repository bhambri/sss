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
			<?php echo form_open('shipping/edit_shipping/'.$id.'/'.$this->uri->segments[4],array('id'=>'formEditshipping','enctype'=>'multipart/form-data','name'=>'formEditshipping', 'onsubmit'=>'return yav.performCheck(\'formEditshipping\', rules, \'classic\');'));?>
			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Shipping State: <span> * </span> </td>
						<td width="60%"><input readonly="readonly" type="text" name="state_name" id="state_name"  style="width: 250px;" class="inputbox" value="<?php echo trim(ucwords(base64_decode($this->uri->segments[4]))); ?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">State Code: <span> * </span> </td>
						<td width="60%"><input readonly="readonly" type="text" name="state_code" id="state_code"  style="width: 250px;" class="inputbox" value="<?php echo set_value('state_code',@$state_code);?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Shipping Cost (<= 500 g): <span> * </span> </td>
						<td width="60%"><input type="text" name="w1" id="w1"  style="width: 250px;" class="inputbox" value="<?php echo set_value('w1',@$w1);?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Shipping Cost (501 to 1000g): <span> * </span> </td>
						<td width="60%"><input type="text" name="w2" id="w2"  style="width: 250px;" class="inputbox" value="<?php echo set_value('w2',@$w2);?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Shipping Cost (1001 to 1500 g): <span> * </span> </td>
						<td width="60%"><input type="text" name="w3" id="w3"  style="width: 250px;" class="inputbox" value="<?php echo set_value('w3',@$w3);?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Shipping Cost (1501 g to 2000g): <span> * </span> </td>
						<td width="60%"><input type="text" name="w4" id="w4"  style="width: 250px;" class="inputbox" value="<?php echo set_value('w4',@$w4);?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Shipping Cost (2001g and above): <span> * </span> </td>
						<td width="60%"><input type="text" name="w5" id="w5"  style="width: 250px;" class="inputbox" value="<?php echo set_value('w5',@$w5);?>" /> </td>
					</tr>
					
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="submit" class="button" value="Update" />
							<input  type="button" name="back" value="Back" class="button" onclick="javascript: window.location.href='<?php echo base_url(); ?>shipping/manage_shipping'" />
							<input  type="hidden" name="formSubmitted" value="1" class="button" />
							<input  type="hidden" name="id" value="<?php echo $id;?>" class="button" />

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

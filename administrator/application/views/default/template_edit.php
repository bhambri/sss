<div class="page">
<script type='text/javascript' language='javascript'>
//<![CDATA[
	var rules = new Array();
	rules[0] = 'page_title:<b>Page Title</b>|required';
	rules[1] = 'page_name:<b>Page Name</b>|required';
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
			<?php echo form_open('template/edit/'.$template_detail[0]->id,array('id'=>'formEditPage','name'=>'formEditPage', 'onsubmit'=>'return yav.performCheck(\'formEditPage\', rules, \'classic\');'));?>
			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Email Template Name: <span> * </span></td>
						<td width="60%"><input readonly="readonly" type="text" name="name" id="name"  maxlength = "100" style="width: 300px;" class="inputbox" value="<?php echo set_value('name',$template_detail[0]->name);?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Email Template Content: <span> * </span></td>
						<td width="60%"><textarea name="content" id="content" class="mceEditor" cols="61" rows="4"><?php echo set_value('content',$template_detail[0]->content); ?></textarea></td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="submit" class="button" value="Save" />
							<input type="button" value="Cancel" class="button" onclick="javascript:window.location.href='<?php echo base_url(); ?>template/manage'"/>
							<input  type="hidden" name="formSubmitted" value="1" class="button" />
							<input  type="hidden" name="id" value="<?php echo $template_detail[0]->id;?>" class="button" />
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
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
<?php 
//echo $this->session->userdata('storeId');
                                    	//echo '<br />'.$this->session->userdata('consultantId')
?>

<table border="0" cellspacing="0" cellpadding="0" class="page_width">
	<tr>
		<td id="id_td_pageHeading" valign="middle"><span id="pageTitle"><?php echo ucfirst($caption);?></span></td>
    </tr>
	<!-- Errors And Message Display Row < -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">

		<?php if(validation_errors() && ($this->upload->display_errors('<li>', '</li>') ) ): ?>
			<ul class="error_ul">
			  <li><strong>Please correct the following:<br/><br/></strong></li><?php echo validation_errors('<li>','</li>');?>
			  <?php if( $this->upload->display_errors() != '<p>You did not select a file to upload.</p>' ) { ?>
			  	 <li><?php echo $this->upload->display_errors('<li>', '</li>'); ?></li>
			  <?php } ?>
			</ul>
		<?php endif; ?>
		<?php if(validation_errors() && (! $this->upload->display_errors('<li>', '</li>')) ): ?>
			<ul class="error_ul">
			  <li><strong>Please correct the following:<br/><br/></strong></li><?php echo validation_errors('<li>','</li>');?>
			</ul>
		<?php endif; ?>
		<?php if(!validation_errors() && ($this->upload->display_errors('<li>', '</li>')) ): ?>
			<ul class="error_ul">
			  <li><?php echo $this->upload->display_errors('<li>', '</li>'); ?></li>
			</ul>
		<?php endif; ?>
		
		<div id="errorsDiv" style="display:none;"></div>
		</td>
    </tr>
	<!-- Errors And Message Display Row > -->
	<tr>
		<td id="content_center_td" valign="top">
			<?php echo form_open('news/add_news',array('id'=>'formAddNews', 'enctype'=>'multipart/form-data','name'=>'formAddNews', 'onsubmit'=>'return yav.performCheck(\'formAddNews\', rules, \'classic\');'));?>
			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">News Title: <span> * </span></td>
						<td width="60%"><input type="text" name="page_title" id="page_title"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('page_title',@$page_title);?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Meta Title: </td>
						<td width="60%"><input type="text" name="page_metatitle" id="page_metatitle"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('page_metatitle',@$page_metatitle);?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Meta Keywords: </td>
						<td width="60%"><textarea onkeydown="textCounter(this, form.counter_mkey, 500)" onchange="textCounter(this, form.counter_mkey, 500)"  onkeyup="textCounter(this, form.counter_mkey, 500)" cols="61" rows="4" name="page_metakeywords" id="page_metakeywords" class="inputbox"><?php echo set_value('page_metakeywords',@$page_metakeywords)?></textarea><div><input type="text" size="3" value="500" readonly="readonly" class="inputbox" name="counter_mkey" id="counter_mkey"/> Characters Left</div></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Meta Description: </td>
						<td width="60%"><textarea onkeydown="textCounter(this, form.counter_mdesc, 500)" onchange="textCounter(this, form.counter_mdesc, 500)" onkeyup="textCounter(this, form.counter_mdesc, 500)" cols="61" rows="4" name="page_metadesc" id="page_metadesc" class="inputbox"><?php echo set_value('page_metadesc',@$page_metadesc)?></textarea><div><input type="text" size="3" value="500" readonly="readonly" class="inputbox" name="counter_mdesc" id="counter_mdesc"/> Characters Left</div></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Thumbnail image: </td>
						<td width="60%"><input type="file" name="thumb_image" id="thumb_image"  maxlength = "100" style="width: 200px;" class="inputbox" /> <span> max-height:768, max-width: 1024 ,max size: 5000 kb
					</span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">News ShortDesc: <span> * </span></td>
						<td width="60%"><textarea cols="61" rows="4" name="page_shortdesc" id="page_shortdesc" class="inputbox"><?php echo set_value('page_shortdesc',@$page_shortdesc)?></textarea></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Content: <span> * </span></td>
						<td width="60%"><textarea name="page_content" id="page_content" class="mceEditor" cols="61" rows="4" value="<?php echo set_value('page_content', @$page_content ) ;?>"><?php echo set_value('page_content', @$page_content ) ;?></textarea></td>
					</tr>
					
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="submit" class="button" value="Add" />
							<input type="button" value="Cancel" class="button" onclick="javascript:history.back();"/>
							<input  type="hidden" name="formSubmitted" value="1" class="button" />
							<!-- <input  type="hidden" name="id" value="<?php echo $id;?>" class="button" /> -->
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

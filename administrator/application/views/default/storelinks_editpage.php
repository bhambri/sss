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
		<!-- <?php if(validation_errors()): ?>
			<ul class="error_ul"><li><strong>Please correct the following:<br/><br/></strong></li><?php echo validation_errors('<li>','</li>');?></ul>
		<?php endif; ?>
	    -->
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
			<?php echo form_open('storelinks/edit_storelinksnew',array('id'=>'formEditstorelinks','enctype'=>'multipart/form-data','name'=>'formEditstorelinks', 'onsubmit'=>'return yav.performCheck(\'formEditstorelinks\', rules, \'classic\');'));?>
			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Banner's Title: <span> * </span></td>
						<td width="60%"><input type="text" name="title" id="title"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('page_title',@$title);?>" /></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<?php $settings = array('w'=>180,'h'=>100,'crop'=>true);
							$image = 'http://'.$_SERVER['HTTP_HOST'].'/marketplace' . $image;
					?>
						<img src="<?php echo image_resize( $image, $settings)?>" border='0' />
					<input type="hidden" name="path" id="path" value="<?php echo $image;?>"/>
						</td>

					</tr>						
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Image: </td>
						<td width="60%"><input type="file" name="image" id="image"  style="width: 150px;" class="inputbox" /><span>Best Size max-height:250, max-width: 250 ,max size: 5000 kb
					</td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">link: <span> * </span></td>
						<td width="60%"><input type="text" name="link" id="link" value="<?php echo $link; ?>" class="inputbox"></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Published: </td>
						<td width="60%"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ($status)?'checked="checked"':'';?> /></td>
					</tr>
					
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="submit" class="button" value="Save" />
							<input type="button" class="button" value="Cancel" onclick="javascript: window.history.back();" />
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

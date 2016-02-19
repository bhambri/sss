<link href="<?php echo layout_url('default/css')?>/imgareaselect-default.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="<?php echo layout_url('default/js')?>/jquery.imgareaselect.min.js"></script>
<script type="text/javascript" src="<?php echo layout_url('default/js')?>/custom.js"></script>

<link href="<?php echo layout_url('default/assets'); ?>/css/main.css" rel="stylesheet">
<link href="<?php echo layout_url('default/assets'); ?>/css/croppic.css" rel="stylesheet">
<script src=" https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="<?php echo layout_url('default/assets'); ?>/js/croppic.min.js"></script>

<div class="page">
<table border="0" cellspacing="0" cellpadding="0" class="page_width">
	<tr>
		<td id="id_td_pageHeading" valign="middle"><span id="pageTitle"><?php echo ucfirst($caption);?></span></td>
    </tr>
	<!-- Errors And Message Display Row < -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if(validation_errors()): ?>
			<ul class="error_ul"><li><strong>Please correct the following:</strong><br/><br/></li><?php echo validation_errors('<li>','</li>');?></ul>
		<?php endif; ?>
		<div id="errorsDiv" style="display:none;"></div>
		</td>
    </tr>
	<!-- Errors And Message Display Row > -->
	<tr>
		<td id="content_center_td" valign="top">

			<?php //echo form_open_multipart('front_blocks/front_blocks_new',array('id'=>'frontBlockNew','name'=>'frontBlockNew', 'onsubmit'=>'return yav.performCheck(\'formNewUser\', rules, \'innerHtml\');'));
					echo form_open_multipart('front_blocks/front_blocks_new',array('id'=>'frontBlockNew','name'=>'frontBlockNew'));?>


			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Block Title: <span> * </span></td>
						<td width="60%"><input type="text" name="title" id="title"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('title','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Image Text: <span> * </span></td>
						<td width="60%"><input type="text" name="image_text" id="image_text"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('image_text','');?>" /></td>
					</tr>
					<tr>						
						<td nowrap="nowrap" class="input_form_caption_td">Upload Image: <span> * </span></td>
						<td id='image_section'>
							<div class="container">			
								<div class="row mt ">
									<div class="col-lg-4 ">
										<div id="cropContaineroutput"></div>
										<input type="text" name="image" id="cropOutput" style="width:150px;" class="inputbox" value="<?php echo set_value('image','');?>" />
									</div>
								</div>	
							</div>
						</td>										
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Block Link: <span> * </span></td>
						<td width="60%"><input type="text" name="link" id="link"  maxlength = "200" style="width: 300px;" class="inputbox" value="<?php echo set_value('link','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Priority: <span> * </span></td>
						<td width="60%"><input type="text" name="priority" id="priority"  maxlength = "100" style="width: 150px;" class="inputbox" value="<?php echo set_value('priority','');?>" />&nbsp;It should be positive number, greater than 0 (Zero).</td>
					</tr>
					
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Submit" />
							<input  type="button" value="Cancel" class="button" onclick="javascript: window.location ='<?php echo base_url(); ?>front_blocks/front_blocks_manage'" />
							<input  type="hidden" name="formSubmitted" value="1" class="button" />
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
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			jQuery('#imgblah').attr('src', e.target.result);
	jQuery('#img_src').attr('value', e.target.result);
		}
		
		reader.readAsDataURL(input.files[0]);
	}
}

jQuery("#image").change(function(){
	readURL(this);
});

var croppicContaineroutputOptions = {
	uploadUrl:'<?php echo base_url() . 'front_blocks/img_save_to_file'; ?>',
	cropUrl:'<?php echo base_url() . 'front_blocks/img_crop_to_file'; ?>',
	outputUrlId:'cropOutput',
	loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
	onAfterImgCrop:function(){ },
}

var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);

</script>
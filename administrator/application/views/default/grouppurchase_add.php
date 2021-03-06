 <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
 <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
$(function() {
$( "#startdate,#enddate" ).datepicker();
});
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
			<?php echo form_open_multipart('',array('id'=>'formNewMember','enctype'=>'multipart/form-data','name'=>'formNewMember', 'onsubmit'=>'return yav.performCheck(\'formNewMember\', rules, \'innerHtml\');'));?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
					<tr>
						<td width="30%" nowrap="nowrap" class="input_form_caption_td">Select Host:<span>&nbsp;*</span></td>
						<td width="70%" align="left">
							<select name="host_id">
							<?php if( isset( $users ) ):
								foreach ($users as $user ) { print_r($users);
									echo "<option value='". $user['id'] ."'>" . $user['name'] . "</option>";
								}
								endif;
							 ?>
								
							</select>							
						</td>
					</tr>	

					<tr>
						<td width="30%" nowrap="nowrap" class="input_form_caption_td">Name:<span>&nbsp;*</span></td>
						<td width="70%" align="left"><input type="text" name="name" id="name"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('name','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Description:<span> &nbsp; </span></td>
						<td align="left"><textarea name="description" id="description" cols="30" rows="4"><?php echo set_value('description', $description ) ; ?></textarea></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Location:<span>&nbsp;*</span></td>
						<td align="left"><input type="text" name="location" id="location"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('location','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Event Code:<span>&nbsp;*</span></td>
						<td align="left">
						<!--input readonly="readonly" type="text" name="group_event_code" id="group_event_code"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('group_event_code','');?>" /-->
						<input readonly="readonly" type="text" name="group_event_code" id="group_event_code"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo $random_code;?>" />
						</td>
					</tr>

					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Start Date:<span>&nbsp;*</span></td>
						<td align="left"><input type="text" name="start_date" id="startdate"  maxlength = "20" style="width: 150px;" readonly="readonly" class="inputbox" value="<?php echo set_value('start_date','');?>" /></td>
					</tr>					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">End Date:<span>&nbsp;*</span></td>
						<td align="left"><input type="text" name="end_date" id="enddate"  maxlength = "20" readonly="readonly" style="width: 150px;" class="inputbox" value="<?php echo set_value('end_date','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Image: </td>
						<td width="60%"><input type="file" name="image" id="image"  style="width: 200px;" class="inputbox" value="<?php echo set_value('page_metatitle',@$image);?>" /> recommended height:585, width: 1900 ,max size: 5000 kb</td>

					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td"><?php echo lang('status')?>:<span>&nbsp;&nbsp;</span></td>
						<td align="left"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo set_value('status','')==1?"checked":""?> /></td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Submit" />
							<input type="button" value="Cancel" class="button" onclick="javascript:window.history.back();"/>	
							<input  type="hidden" name="formSubmitted" value="1" />
							<input  type="hidden" name="validat_image" value="" />
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
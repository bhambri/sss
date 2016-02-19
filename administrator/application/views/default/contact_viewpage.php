<div class="page">
<script type='text/javascript' language='javascript'>
//<![CDATA[
	var rules = new Array();
	rules[0] = 'page_title:<b>Page Title</b>|required';
	rules[1] = 'page_name:<b>Page Name</b>|required';
	rules[2] = 'page_content:<b>Content</b>|required';
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
			<?php echo form_open('contact/manage_contact');?>
			<div id="content_div">
				<table width="80%" border="0" cellspacing="5" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Name: </td>
						<td width="60%"><?php echo $firstname;?> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Phone: </td>
						<td width="60%"><?php echo $phone;?> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Email: </td>
						<td width="60%"><?php echo $email;?> </td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Request Date: </td>
						<td width="60%">
							<?php 
								$date = strtotime($request_date);

								echo date("d,M Y",$date);								
							?> </td>
					</tr>
					<?php if(@$city) { ?>
					     <tr>
							<td nowrap="nowrap" class="input_form_caption_td" width="40%" valign="top">City: </td>
							<td width="60%"><?php echo wordwrap(htmlentities($city),75,"\n",true);?> </td>
						</tr>
					<?php } ?>

					<?php if(@$contact_type == 'E'){ ?>
						<tr>
							<td nowrap="nowrap" class="input_form_caption_td" width="40%" valign="top">Address: </td>
							<td width="60%"><?php echo wordwrap(htmlentities($address),75,"\n",true);?> </td>
						</tr>
						
						<tr>
							<td nowrap="nowrap" class="input_form_caption_td" width="40%" valign="top">State: </td>
							<td width="60%"><?php echo wordwrap(htmlentities($state),75,"\n",true);?> </td>
						</tr>

						<tr>
							<td nowrap="nowrap" class="input_form_caption_td" width="40%" valign="top">zip code: </td>
							<td width="60%"><?php echo wordwrap(htmlentities($zip_code),75,"\n",true);?> </td>
						</tr>

						<tr>
							<td nowrap="nowrap" class="input_form_caption_td" width="40%" valign="top">When looking to invest : </td>
							<td width="60%"><?php echo wordwrap(htmlentities($looking_to_invest),75,"\n",true);?> </td>
						</tr>

						<tr>
							<td nowrap="nowrap" class="input_form_caption_td" width="40%" valign="top">No of units : </td>
							<td width="60%"><?php echo wordwrap(htmlentities($no_of_units),75,"\n",true);?> </td>
						</tr>

					<?php } ?>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%" valign="top">Comments: </td>
						<td width="60%"><?php echo wordwrap(htmlentities($comments),75,"\n",true);?> </td>
					</tr>

					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<?php if($contact_type == 'E'){ ?>
							<input type="button" name="back_button" class="button" value="Back" onclick="javascript:window.location='<?php echo base_url(); ?>contact//manage_enquires';" />
							<?php } ?>
							<?php if($contact_type == 'C'){ ?>
							<input type="button" name="back_button" class="button" value="Back" onclick="javascript:window.location='<?php echo base_url(); ?>contact/manage_contact';" />
							<?php } ?>
							<input  type="hidden" name="formSubmitted" value="1" class="button" />
							<input  type="hidden" name="id" value="<?php echo $id;?>" class="button" />
						</td>
					</tr>
					<tr>
						<td colspan='2' class="form_base_header" align="center"></td>
					</tr>
				</table>
			</div>
			<?php echo form_close();?>
		</td>
    </tr>
</table>
</div>


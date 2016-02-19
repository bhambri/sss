<div class="page">
<script src="<?php echo layout_url('default/js')?>/attachments/jquery-1.9.1.js"></script>
<script src="<?php echo layout_url('default/js')?>/attachments/add_attachment.js"></script>
<script type='text/javascript' language='javascript'>
//<![CDATA[
	var rules = new Array();
	rules[0] = 'category_id:Category|required';
	rules[1] = 'client_product_title:Product Title|required';
	rules[2] = 'client_product_price:Product Price|required';

//]]>

</script>


<script type="text/javascript">
function callSubCategories(cat_id)
{
    var res = cat_id.split("@@");
    var category_id = res[0];
    //alert(category_id); 
    $.ajax({
          type:'POST',
          url:'http://localhost/marketplace/administrator/client_product/getSubCategories/'+category_id,
    
          success:function(result)
          {
            $('#tr_subcategory').show();
            $('#td_subcategory').html(result);
            
          },
          error:function(error)
          {
            alert('error is '+error);
          }
    });
    return false;
}
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
			<ul class="error_ul"><?php echo $error_msg;?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Errors And Message Display Row > -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('errors')): ?>
			<ul class="error_ul"><?php echo $this->session->flashdata('errors');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<tr>
		<td id="content_center_td" valign="top">
			<?php //echo form_open_multipart('client_product/new_client_product',array('id'=>'formNewMember','name'=>'formNewMember', 'onsubmit'=>'return yav.performCheck(\'formNewMember\', rules, \'innerHtml\');'));?>
			<?php echo form_open_multipart('client_product/new_client_product',array('id'=>'formNewMember','name'=>'formNewMember' ) );?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td width="30%" nowrap="nowrap" class="input_form_caption_td">Select Category:<span>&nbsp;*</span></td>
						<td width="70%" align="left">
							<?php
							//$options = "class='inputbox' style='width: 150px;' onchange='callSubCategories(this.value);'";
							//echo form_dropdown('category_id',$category_data,set_value('category_id','',true),$options);
							?>
							<select name="category_id" id="category_id" onchange='callSubCategories(this.value);' >
							<option value="0">Select Category</option>
    							<?php foreach( $all_categories as $each_category ) { ?>
                                   <option value="<?php echo $each_category->id;?>" ><?php echo $each_category->name;?></option>
                                
                            
                            <?php } ?>
                            </select>
						</td>
					</tr>
					
					<tr id="tr_subcategory" style="display:none;">
						<td width="30%" nowrap="nowrap" class="input_form_caption_td">Select Subcategory:<span>&nbsp;*</span></td>
						<td width="70%" align="left" id="td_subcategory"></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Title:<span>&nbsp;*</span></td>
						<td align="left"><input type="text" name="client_product_title" id="client_product_title"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('client_product_title','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Product Price:<span>&nbsp;*</span></td>
						<td align="left"><input type="text" name="client_product_price" id="client_product_price"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('client_product_price','');?>" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Product Size:<span>&nbsp;&nbsp;</span></td>
						<td align="left"><input type="text" name="product_size" id="product_size"  style="width: 150px;" class="inputbox" value="<?php echo set_value('product_size','');?>" /></td>
					</tr>
					
					<tr>
						<input type='hidden' name='MAX_FILE_SIZE' value='10000000' />
						<input type="hidden" id="no_of_attachments" name="no_attach" value="1">
						<input type="hidden" id="no_of_colors" name="no_color" value="1">
						
						<td nowrap="nowrap" class="input_form_caption_td">Upload Product Images:<span></span></td>
						<td id='image_section'>
							<div>
								<input type='file' name='image_name_1'>
								<!--<small>Image Color</small>
								<input type='text' name='image_color_1'>-->
							</div>
							<div id="attach_more"  style='cursor: pointer; color: blue;'>Attach More</div>
						</td>										
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Description:<span>&nbsp;*</span></td>
						<td align="left"><textarea name="description" id="description" class="mceEditor" cols="30" rows="4"><?php echo set_value('description','')?></textarea></td>
					</tr>
					
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td"><?php echo lang('status')?>:<span>&nbsp;&nbsp;</span></td>
						<td align="left"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo set_value('status','')==1?"checked":""?> /></td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Submit" />
							<input type="button" value="View List" class="button" onclick="javascript:window.location='<?php echo base_url()?>client_product/manage_client_product'"/>
							<input  type="hidden" name="formSubmitted" value="1" class="button" />
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


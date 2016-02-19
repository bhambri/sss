<div class="page">
<script src="<?php echo layout_url('default/js')?>/attachments/jquery-1.9.1.js"></script>
<script src="<?php echo layout_url('default/js')?>/attachments/add_attachment.js"></script>

<script type="text/javascript">
function callSubCategories(cat_id)
{
    var res = cat_id.split("@@");
    var category_id = res[0];
    $.ajax({
          type:'POST',
          url:'<?php echo base_url();?>product/getSubCategories/'+category_id,
    
          success:function(result)
          {
            
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
	
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('errors')): ?>
			<ul class="error_ul"><?php echo $this->session->flashdata('errors');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<tr>
		<td id="content_center_td" valign="top">
			<?php echo form_open_multipart('product/add',array('id'=>'formNewMember','name'=>'formNewMember' ) );?>
			<?php 
			

#$category_id = !empty($this->input->post('category_id')) ? $this->input->post('category_id') : '0' ;
#$subcategory = !empty($this->input->post('subcategory')) ? $this->input->post('subcategory') : '0' ;


			?>
			<div id="content_div" align="center">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					
					<tr>
						<td width="30%" nowrap="nowrap" class="input_form_caption_td">Category:<span>&nbsp;*</span></td>
						<td width="70%" align="left">
							
							<select name="category_id" id="category_id" onchange='callSubCategories(this.value);' >
							<option value="">Select Category</option>
    							<?php foreach( $all_categories as $each_category ) { ?>
                                   <option value="<?php echo $each_category->id;?>" <?php if($category_id == $each_category->id){ echo "selected='selected'"; }?> ><?php echo $each_category->name;?></option>
                                
                            <?php } ?>
                            </select>
						</td>
					</tr>
					
					<tr id="tr_subcategory">
						<td width="30%" nowrap="nowrap" class="input_form_caption_td">Subcategory:<span>&nbsp;*</span></td>
						<td width="70%" align="left" id="td_subcategory">
							<select name="subcategory" id="subcategory" >
	    						<option value="" >Select Subcategory</option>
							<?php foreach($subcategories as $each_subcategory) 
						{?>
						    <option value="<?php echo $each_subcategory->id;?>" <?php if( $each_subcategory->id == $subcategory ){echo "selected='selected'";}?> ><?php echo $each_subcategory->name;?></option>
						<?php 
						}?>
	    					</select>	
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">SKU:<span>&nbsp;&nbsp;</span></td>
						<td align="left"><input type="text" name="sku" id="sku"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('sku','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Product Name:<span>&nbsp;*</span></td>
						<td align="left"><input type="text" name="client_product_title" id="client_product_title"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('client_product_title','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Product Price:<span>&nbsp;*</span></td>
						<td align="left"><input type="text" name="client_product_price" id="client_product_price"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('client_product_price','');?>" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Product Volume:<span>&nbsp;*</span></td>
						<td align="left"><input type="text" name="client_product_volume" id="client_product_volume"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('client_product_volume','');?>" /></td>
					</tr>
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Product Size:<span>&nbsp;&nbsp;</span></td>
						<td align="left"><input type="text" name="product_size" id="product_size"  style="width: 150px;" class="inputbox" value="<?php echo set_value('product_size','');?>" /></td>
					</tr>
					
					<tr>						
						<td nowrap="nowrap" class="input_form_caption_td">Upload Product Image:<span>&nbsp;*</span></td>
						<td id='image_section'>
							<div>
								<input type='file' name='image' id='image' value="<?php echo set_value('image','');?>">
								<br />
								(Image Size <= 5MB, Width X Height <= 2024 X 768)
							</div>
						</td>										
					</tr>
					<tr>						
						<td nowrap="nowrap" class="input_form_caption_td">Upload Product Image2:<span>&nbsp;</span></td>
						<td id='image_section'>
							<div>
								<input type='file' name='image2' id='image2' value="<?php echo set_value('image2','');?>">
								<br />
								(Image Size <= 5MB, Width X Height <= 2024 X 768)
							</div>
						</td>										
					</tr>
					<tr>						
						<td nowrap="nowrap" class="input_form_caption_td">Upload Product Image3:<span>&nbsp;</span></td>
						<td id='image_section'>
							<div>
								<input type='file' name='image3' id='image3' value="<?php echo set_value('image3','');?>">
								<br />
								(Image Size <= 5MB, Width X Height <= 2024 X 768)
							</div>
						</td>										
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Description:<span>&nbsp;*</span></td>
						<td align="left"><textarea name="description" id="description" class="mceEditor" cols="30" rows="4"><?php echo set_value('description','')?></textarea></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Product Weight(in grams):<span>&nbsp;&nbsp;</span></td>
						<td align="left"><input type="text" name="product_weight" id="product_weight"  style="width: 150px;" class="inputbox" value="<?php echo set_value('product_weight','');?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td"><?php echo lang('status')?>:<span>&nbsp;&nbsp;</span></td>
						<td align="left"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo set_value('status','')==1?"checked":""?> /></td>
					</tr>

					
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Submit" />
							<input type="button" value="Cancel" class="button" onclick="javascript:window.location='<?php echo base_url()?>product/manage'"/>
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

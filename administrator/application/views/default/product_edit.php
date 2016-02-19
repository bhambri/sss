<div class="page">
<script src="<?php echo layout_url('default/js')?>/attachments/jquery-1.9.1.js"></script>
<script src="<?php echo layout_url('default/js')?>/attachments/add_attachment.js"></script>

<script type="text/javascript">
function callSubCategories(cat_id)
{
    var res = cat_id.split("@@");
    var category_id = res[0];
    //alert(category_id); 
    $.ajax({
          type:'POST',
          url:'<?php echo base_url();?>product/getSubCategories/'+category_id,
    
          success:function(result)
          {
            //$('#tr_subcategory').show();
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
			<?php echo form_open_multipart('product/edit/'. $client_product->id,array('id'=>'formEditUser','name'=>'formEditUser', 'onsubmit'=>'return yav.performCheck(\'formEditUser\', rules, \'innerHtml\');'));?>
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
                                   <option value="<?php echo $each_category->id;?>" <?php if( $each_category->id == $client_product->category_id ){echo "selected='selected'";}?> ><?php echo $each_category->name;?></option>
                                
                            
                            <?php } ?>
                            </select>
						</td>
					</tr>
					<tr id="tr_subcategory">
						<td width="30%" nowrap="nowrap" class="input_form_caption_td">Subcategory:<span>&nbsp;*</span></td>
						<td width="70%" align="left" id="td_subcategory">
						<select name="subcategory" id="subcategory">
							<option value="">Select Subcategory</option>
						<?php foreach($subcategories as $each_subcategory) 
						{?>
						    <option value="<?php echo $each_subcategory->id;?>" <?php if( $each_subcategory->id == $client_product->subcategory_id ){echo "selected='selected'";}?> ><?php echo $each_subcategory->name;?></option>
						<?php 
						}?>
						</select></td>
					</tr>
					
					
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">SKU:<span>&nbsp;&nbsp;</span></td>
						<td align="left"><input type="text" name="sku" id="sku"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('sku',$client_product->sku);?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Product Name:<span>&nbsp;*</span></td>
						<td align="left"><input type="text" name="client_product_title" id="client_product_title"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('client_product_title',$client_product->product_title);?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Product Price:<span>&nbsp;*</span></td>
						<td align="left"><input type="text" name="client_product_price" id="client_product_price"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('client_product_price',$client_product->product_price );?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Product Volume:<span>&nbsp;*</span></td>
						<td align="left"><input type="text" name="client_product_volume" id="client_product_volume"  maxlength = "50" style="width: 150px;" class="inputbox" value="<?php echo set_value('client_product_volume',$client_product->product_volume );?>" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Product Size:<span>&nbsp;&nbsp;</span></td>
						<td align="left"><input type="text" name="product_size" id="product_size"  style="width: 150px;" class="inputbox" value="<?php echo set_value( 'product_size', $client_product->product_size ); ?>" /></td>
					</tr>
					<tr>
						<input type='hidden' name='MAX_FILE_SIZE' value='10000000' />
						<input type="hidden" id="no_of_attachments" name="no_attach" value="1">
						<input type="hidden" id="no_of_colors" name="no_color" value="1">
						
						<td nowrap="nowrap" class="input_form_caption_td">Upload Product Image:<span>&nbsp;&nbsp;</span></td>
						<td id='image_section'>
							<div>
								<input type='file' name='image'>
								<br />
								(Image Size <= 5MB, Width X Height <= 2024 X 768)
							</div>
						</td>										
					</tr>
					
					<tr>
					<td nowrap="nowrap" class="input_form_caption_td">Product Image:<span>&nbsp;*</span></td>
					<td align="left">	
					<?php $settings = array('w'=>100,'h'=>100,'crop'=>true);
					if( !empty( $client_product->image ) )
					{
						$image = ROOT_PATH . $client_product->image;
					
					?>
						<img src="<?php echo image_resize( $image, $settings)?>" border='0' />
					<?php 
					}
					else{ echo "No image found"; }	 
					?>
					</td>
					
					</tr>
					<!-- new part added here -->
					<tr>
						
						
						<td nowrap="nowrap" class="input_form_caption_td">Upload Product Image 2:<span>&nbsp;&nbsp;</span></td>
						<td id='image_section'>
							<div>
								<input type='file' name='image2'>
								<br />
								(Image Size <= 5MB, Width X Height <= 2024 X 768)
							</div>
						</td>										
					</tr>
					
					<tr>
					<td nowrap="nowrap" class="input_form_caption_td">Product Image2:<span>&nbsp;</span></td>
					<td align="left">	
					<?php $settings = array('w'=>100,'h'=>100,'crop'=>true);
					if( !empty( $client_product->image2 ) )
					{
						$image2 = ROOT_PATH . $client_product->image2;
					
					?>
						<img src="<?php echo image_resize( $image2, $settings)?>" border='0' />
					<?php 
					}
					else{ echo "No image found"; }	 
					?>
					</td>
					
					</tr>

					<tr>
						
						
						<td nowrap="nowrap" class="input_form_caption_td">Upload Product Image 3:<span>&nbsp;&nbsp;</span></td>
						<td id='image_section'>
							<div>
								<input type='file' name='image3'>
								<br />
								(Image Size <= 5MB, Width X Height <= 2024 X 768)
							</div>
						</td>										
					</tr>
					
					<tr>
					<td nowrap="nowrap" class="input_form_caption_td">Product Image 3:<span>&nbsp;</span></td>
					<td align="left">	
					<?php $settings = array('w'=>100,'h'=>100,'crop'=>true);
					if( !empty( $client_product->image3 ) )
					{
						$image3 = ROOT_PATH . $client_product->image3;
					
					?>
						<img src="<?php echo image_resize( $image3, $settings)?>" border='0' />
					<?php 
					}
					else{ echo "No image found"; }	 
					?>
					</td>
					
					</tr>
					<!-- new part added here ends now -->


					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Description:<span>&nbsp;*</span></td>
						<td align="left"><textarea name="description" id="description" class="mceEditor" cols="30" rows="4"><?php echo set_value('description',html_entity_decode($client_product->description))?></textarea></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td">Product Weight(in grams):<span>&nbsp;&nbsp;</span></td>
						<td align="left"><input type="text" name="product_weight" id="product_weight"  style="width: 150px;" class="inputbox" value="<?php echo set_value('product_weight', $client_product->weight);?>" /></td>
					</tr>

					<tr>
						<td nowrap="nowrap" class="input_form_caption_td"><?php echo lang('status')?>:<span>&nbsp;&nbsp;</span></td>
						<td align="left"><input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ((isset($client_product->status) ? $client_product->status: set_value('status','')) == 1) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="add" class="button" value="Save" />
						<input type="button" value="Cancel" class="button" onclick="javascript:window.location='<?php echo base_url()?>product/manage'"/>
							<input  type="hidden" name="formSubmitted" value="1" />
							<input  type="hidden" name="id" value="<?php echo (isset($client_product->id) ? $client_product->id : $this->input->post('id'))?>" />
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

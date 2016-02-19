<div class="page">
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
			<?php
			#echo '<pre>';
			#print_r($posteddata) ;

			?>
			<?php echo form_open('settings/testavatax_connection/'.$id,array('id'=>'formEditsettings','enctype'=>'multipart/form-data','name'=>'formEditsettings', 'onsubmit'=>'return yav.performCheck(\'formEditsettings\', rules, \'classic\');'));?>
			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					
					<?php if(($role_id !=4 ) && ($role_id != 1 )) {?>
					<tr>
						<td class="input_form_caption_td">Calculated Tax </td><td><span> -- $<?php if(@$posteddata['total_tax']){ //echo @$posteddata['total_tax'] ;
echo money_format('%.2n', $posteddata['total_tax']) ;
						}else{ echo 0 ;} ;?></span></td>
					</tr>
					
					<!--  AVAlara tax settings section -->
					<input type="hidden" name="id" value="<?php echo $id ;?>" />
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Account Number:<span> </span></td>
						<td width="60%"><input type="text" name="ava_account_number" id="ava_account_number"  style="width: 250px;" class="inputbox" value="<?php echo set_value('ava_account_number',@$posteddata['config']['accountNumber']);?>" /> (Avalara AvaTax, Account No., required to enable tax calculation using avalara)</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Licence Key:<span> </span></td>
						<td width="60%"><input type="text" name="ava_license_key" id="ava_license_key"  style="width: 250px;" class="inputbox" value="<?php echo set_value('ava_license_key',@$posteddata['config']['licenseKey']);?>" /> (Avalara AvaTax, Licence key, required to enable tax calculation using avalara )</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Company Code:<span> </span></td>
						<td width="60%"><input type="text" name="ava_company_code" id="ava_company_code"  style="width: 250px;" class="inputbox" value="<?php echo set_value('ava_company_code',@$posteddata['config']['company_code']);?>" /> (Avalara AvaTax, Company Code, required to enable tax calculation using avalara ) </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Account url:<span> </span></td>
						<td width="60%"><input type="text" name="account_url" id="account_url"  style="width: 250px;" class="inputbox" value="<?php echo set_value('account_url',@$posteddata['config']['serviceURL']);?>" /> (Avalara AvaTax,Development Url ) </td>
					</tr> 
					<!--  AVAlara tax settings section ends here -->
					<tr><td colspan="2">customer code </td></tr>

					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Customer Code:<span> </span></td>
						<td width="60%"><input type="text" name="customer_code" id="customer_code"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['Customer']['customer_code']) { echo @$posteddata['Customer']['customer_code'] ; }else{ echo '120' ; } ?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Customer ID:<span> </span></td>
						<td width="60%"><input type="text" name="customer_id" id="customer_id"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['Customer']['customer_id']){ echo @$posteddata['Customer']['customer_id']; }else{ echo '110' ; }?>" /> </td>
					</tr>

					<tr> <td colspan="2">Item Detail 1</td></tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Item 1 iD:<span> </span></td>
						<td width="60%"><input type="text" name="item_id[1]" id="item_id"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['cartitems'][0]['id']){ echo @$posteddata['cartitems'][0]['id'] ; }else{ echo '2111' ; } ?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Item 1 Qty:<span> </span></td>
						<td width="60%"><input type="text" name="item_qty[1]" id="item_id_1"  style="width: 250px;" class="inputbox" onkeyup="calculatesubtotalone();" value="<?php if(@$posteddata['cartitems'][0]['qty']){ echo @$posteddata['cartitems'][0]['qty'] ; }else{ echo '2'; }?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Item 1 price:<span> </span></td>
						<td width="60%"><input type="text" name="item_price[1]" id="item_price_1"  style="width: 250px;" class="inputbox" onkeyup="calculatesubtotalone();" value="<?php if(@$posteddata['cartitems'][0]['price']){echo @$posteddata['cartitems'][0]['price'] ; }else{ echo '100'; } ?>" /> </td>

					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Item 1 name:<span> </span></td>
						<td width="60%"><input type="text" name="item_name[1]" id="item_name"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['cartitems'][0]['name']){ echo @$posteddata['cartitems'][0]['name']; }else{ echo 'product one' ; }?>" /> </td>
						
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Item Subtotal:<span> </span></td>
						<td width="60%"><input type="text" name="item_subtotal[1]" id="item_subtotal_1"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['cartitems'][0]['subtotal']){echo @$posteddata['cartitems'][0]['subtotal']; }else{ echo '200'; }?>" /> </td>
						
					</tr> 
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Item Tax code:<span> </span></td>
						<td width="60%"><input type="text" name="tax_code[1]" id="item_name"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['cartitems'][0]['tax_code']){ echo @$posteddata['cartitems'][0]['tax_code']; }else{ echo 'PC040100' ; }?>" /> </td>	
					</tr>

					<tr> <td colspan="2">Item Detail 2</td></tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Item 2 iD:<span> </span></td>
						<td width="60%"><input type="text" name="item_id[2]" id="item_id"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['cartitems'][1]['id']){ echo @$posteddata['cartitems'][1]['id'] ;}else{ echo '1002' ;}?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Item 2 Qty:<span> </span></td>
						<td width="60%"><input type="text" name="item_qty[2]" id="item_id_2"  style="width: 250px;" class="inputbox" onkeyup="calculatesubtotalonel();" value="<?php if(@$posteddata['cartitems'][1]['qty']){ echo @$posteddata['cartitems'][1]['qty'] ;}else{ echo '1' ; }?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Item 2 price:<span> </span></td>
						<td width="60%"><input type="text" name="item_price[2]" id="item_price_2"  style="width: 250px;" class="inputbox" onkeyup="calculatesubtotalonel();" value="<?php if(@$posteddata['cartitems'][1]['price']){ echo @$posteddata['cartitems'][1]['price'] ; }else{ echo '90' ; }?>" /> </td>

					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Item 2 name:<span> </span></td>
						<td width="60%"><input type="text" name="item_name[2]" id="item_name"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['cartitems'][1]['name']){ echo @$posteddata['cartitems'][1]['name'] ; }else{ echo 'Freight' ; }?>" /> </td>
						
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Item Subtotal:<span> </span></td>
						<td width="60%"><input type="text" name="item_subtotal[2]" id="item_subtotal_2"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['cartitems'][1]['subtotal']){ echo @$posteddata['cartitems'][1]['subtotal'] ;}else{ echo '90' ;}?>" /> </td>
						
					</tr> 
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Item Tax code:<span> </span></td>
						<td width="60%"><input type="text" name="tax_code[2]" id="item_name"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['cartitems'][1]['tax_code']){ echo @$posteddata['cartitems'][1]['tax_code'] ; }else{ echo 'FR' ;}?>" /> </td>	
					</tr>
					<tr> <td colspan="2">Origin Address</td></tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">STATE code:<span> </span></td>
						<td width="60%"><input type="text" name="state_code[1]" id="state_code"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['address'][0]['state_code']){ echo @$posteddata['address'][0]['state_code'] ;}else{ echo 'NY' ; }?>" /> </td>	
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">City:<span> </span></td>
						<td width="60%"><input type="text" name="city[1]" id="city"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['address'][0]['city']){ echo @$posteddata['address'][0]['city'] ;}else{ echo 'newyork city';}?>" /> </td>	
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Zip:<span> </span></td>
						<td width="60%"><input type="text" name="zip[1]" id="zip"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['address'][0]['zip']){ echo @$posteddata['address'][0]['zip']; }else{ echo '10001';} ?>" /> </td>	
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Country:<span> </span></td>
						<td width="60%"><input type="text" name="country[1]" id="country"  style="width: 250px;" class="inputbox" value="US" /> </td>	
					</tr>
					<tr> <td colspan="2">Shipping Address</td></tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">State code:<span> </span></td>
						<td width="60%"><input type="text" name="state_code[2]" id="state_code"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['address'][1]['state_code']){ echo @$posteddata['address'][1]['state_code']; }else{ echo 'NY' ; } ?>" /> </td>	
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">City:<span> </span></td>
						<td width="60%"><input type="text" name="city[2]" id="city"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['address'][1]['city']){ echo @$posteddata['address'][1]['city'] ;}else{ echo 'Albany' ; }?>" /> </td>	
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Zip:<span> </span></td>
						<td width="60%"><input type="text" name="zip[2]" id="zip"  style="width: 250px;" class="inputbox" value="<?php if(@$posteddata['address'][1]['zip']){ echo @$posteddata['address'][1]['zip'] ;}else{ echo '12201'; } ?>" /> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Country:<span> </span></td>
						<td width="60%"><input type="text" name="country[2]" id="country"  style="width: 250px;" class="inputbox" value="US" /> </td>	
					</tr>	
					
					<?php } ?>

					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="submit" class="button" value="Calculate tax" />
							<input  type="hidden" name="formSubmitted" value="1" class="button" />
							<input  type="hidden" name="id" value="<?php echo $id;?>" class="button" />
							<input  type="button" value="Cancel" onclick="javascript:window.location='<?php echo base_url()?>settings/manage_settings'" class="button" />
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
<script type="text/javascript">
	function calculatesubtotalone(){
		//alert('ok');
		itmprice = jQuery('#item_id_1').val() ; 
		itemcount = jQuery('#item_price_1').val() ;
		//itemsubtotal = itmprice*itemcount ;
		var itemsubtotal =  Math.round( ( parseFloat(itmprice) * parseFloat(itemcount) )*100)/100 ;

		jQuery('#item_subtotal_1').val(itemsubtotal.toFixed(2)) ;
	}
	function calculatesubtotalonel(){
		//alert('ok');
		itmprice = jQuery('#item_id_2').val() ; 
		itemcount = jQuery('#item_price_2').val() ;
		//itemsubtotal = itmprice*itemcount ;
		var itemsubtotal =  Math.round( ( parseFloat(itmprice) * parseFloat(itemcount) )*100)/100 ;
		jQuery('#item_subtotal_2').val(itemsubtotal.toFixed(2)) ;
	}
</script>>
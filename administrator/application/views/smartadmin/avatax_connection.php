<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-edit fa-fw "></i> <?php echo ucfirst($caption);?></h1>
	</div>
</div>
<?php if($this->session->flashdata('errors')): ?>
<div class="alert alert-danger fade in">
	<button class="close" data-dismiss="alert">x</button>
	<i class="fa-fw fa fa-times"></i>
	<strong>Error!</strong> <?php echo $this->session->flashdata('errors');?>
</div>
<?php endif; ?>

<?php if(validation_errors()): ?>
<div class="alert alert-danger fade in">
	<button class="close" data-dismiss="alert">x</button>
	<i class="fa-fw fa fa-times"></i>
	<strong>Error!</strong>
	<ul class="error_ul">
		<li><strong>Please correct the following:</strong></li>
		<?php echo validation_errors('<li>','</li>'); ?>
	</ul>
</div>
<?php endif; ?>
<!-- Errors And Message Display Row > -->
<!-- Success And Message Display Row < -->
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success fade in">
	<button class="close" data-dismiss="alert">x</button>
	<i class="fa-fw fa fa-check"></i>
	<strong>Success</strong> <?php echo $this->session->flashdata('success');?>
</div>
<?php endif; ?>

<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget">
	<header role="heading">
		<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
		<h2><?php echo ucfirst($caption);?></h2>
		<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
	</header>
	<!-- widget div-->
	<div role="content">
		<!-- widget edit box -->
		<div class="jarviswidget-editbox">
			<!-- This area used as dropdown edit box -->
		</div>
		<!-- end widget edit box -->
		<!-- widget content -->
		<div class="widget-body no-padding">
			<?php echo form_open('settings/testavatax_connection/'.$id,array('id'=>'formEditsettings','enctype'=>'multipart/form-data','name'=>'formEditsettings', 'class'=>"smart-form"));?>
				<?php if(($role_id !=4 ) && ($role_id != 1 )) {?>
					<header>Test AvaTax connection</header>
					<fieldset>
						<section>
							<label class="label">Calculated Tax :
								<strong>$
									<?php if(@$posteddata['total_tax']) {
										echo money_format('%.2n', $posteddata['total_tax']) ;
									} else {
										echo 0;
									} ?>
								</strong>
							</label>
						</section>
						<section>
							<label class="label">Account Number :</label>
							<label class="input">
								<input type="text" name="ava_account_number" id="ava_account_number" class="inputbox" value="<?php echo set_value('ava_account_number',@$posteddata['config']['accountNumber']);?>" />
								<i>Avalara AvaTax, Account No., required to enable tax calculation using avalara</i>
							</label>
						</section>
						<section>
							<label class="label">Licence Key :</label>
							<label class="input">
								<input type="text" name="ava_license_key" id="ava_license_key" class="inputbox" value="<?php echo set_value('ava_license_key',@$posteddata['config']['licenseKey']);?>" />
								<i>Avalara AvaTax, Licence key, required to enable tax calculation using avalara</i>
							</label>
						</section>
						<section>
							<label class="label">Company Code :</label>
							<label class="input">
								<input type="text" name="ava_company_code" id="ava_company_code" class="inputbox" value="<?php echo set_value('ava_company_code',@$posteddata['config']['company_code']);?>" />
								<i>Avalara AvaTax, Company Code, required to enable tax calculation using avalara</i>
							</label>
						</section>
						<section>
							<label class="label">Account url :</label>
							<label class="input">
								<input type="text" name="account_url" id="account_url" class="inputbox" value="<?php echo set_value('account_url',@$posteddata['config']['serviceURL']);?>" />
								<i>Avalara AvaTax,Development Url</i>
							</label>
						</section>
					</fieldset>
					<header>Customer Code</header>
					<fieldset>
						<section>
							<label class="label">Customer Code :</label>
							<label class="input">
								<input type="text" name="customer_code" id="customer_code" class="inputbox" value="<?php if(@$posteddata['Customer']['customer_code']) { echo @$posteddata['Customer']['customer_code'] ; }else{ echo '120' ; } ?>" />
							</label>
						</section>
						<section>
							<label class="label">Customer Id :</label>
							<label class="input">
								<input type="text" name="customer_id" id="customer_id" class="inputbox" value="<?php if(@$posteddata['Customer']['customer_id']){ echo @$posteddata['Customer']['customer_id']; }else{ echo '110' ; }?>" />
							</label>
						</section>
					</fieldset>
					<header>Item Detail 1</header>
					<fieldset>
						<section>
							<label class="label">Item 1 Id :</label>
							<label class="input">
								<input type="text" name="item_id[1]" id="item_id" class="inputbox" value="<?php if(@$posteddata['cartitems'][0]['id']){ echo @$posteddata['cartitems'][0]['id'] ; }else{ echo '2111' ; } ?>" />
							</label>
						</section>
						<section>
							<label class="label">Item 1 Qty :</label>
							<label class="input">
								<input type="text" name="item_qty[1]" id="item_id_1" class="inputbox" onkeyup="calculatesubtotalone();" value="<?php if(@$posteddata['cartitems'][0]['qty']){ echo @$posteddata['cartitems'][0]['qty'] ; }else{ echo '2'; }?>" />
							</label>
						</section>
						<section>
							<label class="label">Item 1 Price :</label>
							<label class="input">
								<input type="text" name="item_price[1]" id="item_price_1" class="inputbox" onkeyup="calculatesubtotalone();" value="<?php if(@$posteddata['cartitems'][0]['price']){echo @$posteddata['cartitems'][0]['price'] ; }else{ echo '100'; } ?>" />
							</label>
						</section>
						<section>
							<label class="label">Item 1 Name :</label>
							<label class="input">
								<input type="text" name="item_name[1]" id="item_name" class="inputbox" value="<?php if(@$posteddata['cartitems'][0]['name']){ echo @$posteddata['cartitems'][0]['name']; }else{ echo 'product one' ; }?>" />
							</label>
						</section>
						<section>
							<label class="label">Item Subtotal :</label>
							<label class="input">
								<input type="text" name="item_subtotal[1]" id="item_subtotal_1" class="inputbox" value="<?php if(@$posteddata['cartitems'][0]['subtotal']){echo @$posteddata['cartitems'][0]['subtotal']; }else{ echo '200'; }?>" />
							</label>
						</section>
						<section>
							<label class="label">Item Tax Code :</label>
							<label class="input">
								<input type="text" name="tax_code[1]" id="item_name" class="inputbox" value="<?php if(@$posteddata['cartitems'][0]['tax_code']){ echo @$posteddata['cartitems'][0]['tax_code']; }else{ echo 'PC040100' ; }?>" />
							</label>
						</section>
					</fieldset>
					<header>Item Detail 2</header>
					<fieldset>
						<section>
							<label class="label">Item 2 Id :</label>
							<label class="input">
								<input type="text" name="item_id[2]" id="item_id" class="inputbox" value="<?php if(@$posteddata['cartitems'][1]['id']){ echo @$posteddata['cartitems'][1]['id'] ;}else{ echo '1002' ;}?>" />
							</label>
						</section>
						<section>
							<label class="label">Item 2 Qty :</label>
							<label class="input">
								<input type="text" name="item_qty[2]" id="item_id_2" class="inputbox" onkeyup="calculatesubtotalonel();" value="<?php if(@$posteddata['cartitems'][1]['qty']){ echo @$posteddata['cartitems'][1]['qty'] ;}else{ echo '1' ; }?>" />
							</label>
						</section>
						<section>
							<label class="label">Item 2 Price :</label>
							<label class="input">
								<td width="60%"><input type="text" name="item_price[2]" id="item_price_2" class="inputbox" onkeyup="calculatesubtotalonel();" value="<?php if(@$posteddata['cartitems'][1]['price']){ echo @$posteddata['cartitems'][1]['price'] ; }else{ echo '90' ; }?>" />
							</label>
						</section>
						<section>
							<label class="label">Item 2 Name :</label>
							<label class="input">
								<input type="text" name="item_name[2]" id="item_name" class="inputbox" value="<?php if(@$posteddata['cartitems'][1]['name']){ echo @$posteddata['cartitems'][1]['name'] ; }else{ echo 'Freight' ; }?>" />
							</label>
						</section>
						<section>
							<label class="label">Item Subtotal :</label>
							<label class="input">
								<input type="text" name="item_subtotal[2]" id="item_subtotal_2" class="inputbox" value="<?php if(@$posteddata['cartitems'][1]['subtotal']){ echo @$posteddata['cartitems'][1]['subtotal'] ;}else{ echo '90' ;}?>" />
							</label>
						</section>
						<section>
							<label class="label">Item Tax Code :</label>
							<label class="input">
								<input type="text" name="tax_code[2]" id="item_name" class="inputbox" value="<?php if(@$posteddata['cartitems'][1]['tax_code']){ echo @$posteddata['cartitems'][1]['tax_code'] ; }else{ echo 'FR' ;}?>" />
							</label>
						</section>
					</fieldset>
					<header>Origin Address</header>
					<fieldset>
						<section>
							<label class="label">State code :</label>
							<label class="input">
								<input type="text" name="state_code[1]" id="state_code"  class="inputbox" value="<?php if(@$posteddata['address'][0]['state_code']){ echo @$posteddata['address'][0]['state_code'] ;}else{ echo 'NY' ; }?>" />
							</label>
						</section>
						<section>
							<label class="label">City :</label>
							<label class="input">
								<input type="text" name="city[1]" id="city"  class="inputbox" value="<?php if(@$posteddata['address'][0]['city']){ echo @$posteddata['address'][0]['city'] ;}else{ echo 'newyork city';}?>" />
							</label>
						</section>
						<section>
							<label class="label">Zip :</label>
							<label class="input">
								<input type="text" name="zip[1]" id="zip"  class="inputbox" value="<?php if(@$posteddata['address'][0]['zip']){ echo @$posteddata['address'][0]['zip']; }else{ echo '10001';} ?>" />
							</label>
						</section>
						<section>
							<label class="label">Country :</label>
							<label class="input">
								<input type="text" name="country[1]" id="country"  class="inputbox" value="US" />
							</label>
						</section>
					</fieldset>
					<header>Shipping Address</header>
					<fieldset>
						<section>
							<label class="label">State code :</label>
							<label class="input">
								<input type="text" name="state_code[2]" id="state_code"  class="inputbox" value="<?php if(@$posteddata['address'][1]['state_code']){ echo @$posteddata['address'][1]['state_code']; }else{ echo 'NY' ; } ?>" />
							</label>
						</section>
						<section>
							<label class="label">City :</label>
							<label class="input">
								<input type="text" name="city[2]" id="city"  class="inputbox" value="<?php if(@$posteddata['address'][1]['city']){ echo @$posteddata['address'][1]['city'] ;}else{ echo 'Albany' ; }?>" />
							</label>
						</section>
						<section>
							<label class="label">Zip :</label>
							<label class="input">
								<input type="text" name="zip[2]" id="zip"  class="inputbox" value="<?php if(@$posteddata['address'][1]['zip']){ echo @$posteddata['address'][1]['zip'] ;}else{ echo '12201'; } ?>" />
							</label>
						</section>
						<section>
							<label class="label">Country :</label>
							<label class="input">
								<input type="text" name="country[2]" id="country"  class="inputbox" value="US" />
							</label>
						</section>
					</fieldset>
				<?php } ?>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Calculate tax</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url()?>settings/manage_settings'" >Cancel</button>
					<input  type="hidden" name="formSubmitted" value="1" class="button" />
					<input  type="hidden" name="id" value="<?php echo $id;?>" class="button" />
				</footer>
			<?php echo form_close();?>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
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
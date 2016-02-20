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

$(document).ready(function() {
	var $checkoutForm = $('#formEditUser').validate({
		rules : {
			category_id : {
				required : true
			},
			subcategory : {
				required : true
			},
			client_product_title : {
				required : true
			},
			client_product_price : {
				required : true
			},
			client_product_volume : {
				required : true
			},
			image : {
				required : true
			},
			description : {
				required : true
			}
		},
		messages : {
			category_id : {
				required : 'Please select category'
			},
			subcategory : {
				required : 'Please select sub category'
			},
			client_product_title : {
				required : 'Please enter product title'
			},
			client_product_price : {
				required : 'Please enter product price'
			},
			client_product_volume : {
				required : 'Please enter product volume'
			},
			image : {
				required : 'Please select image'
			},
			description : {
				required : 'Please enter description'
			}
		},
		errorPlacement : function(error, element) {
			error.insertAfter(element.parent());
		}
	});
});
</script>

<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-plus fa-fw "></i> <?php echo ucfirst($caption);?></h1>
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
			<?php echo form_open_multipart('product/edit/'. $client_product->id,array('id'=>'formEditUser','name'=>'formEditUser', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Category:<span class="mandatory">*</span></label>
						<label class="select">
							<select name="category_id" id="category_id" onchange='callSubCategories(this.value);' >
								<option value="">Select Category</option>
								<?php foreach( $all_categories as $each_category ) { ?>
									<option value="<?php echo $each_category->id;?>" <?php if( $each_category->id == $client_product->category_id ){echo "selected='selected'";}?> ><?php echo $each_category->name;?></option>
								<?php } ?>
							</select>
						</label>
					</section>
					<section>
						<label class="label">Subcategory:<span class="mandatory">*</span></label>
						<label class="select" id="td_subcategory">
							<select name="subcategory" id="subcategory" >
								<option value="" >Select Subcategory</option>
								<?php foreach($subcategories as $each_subcategory) { ?>
									<option value="<?php echo $each_subcategory->id;?>" <?php if( $each_subcategory->id == $client_product->subcategory_id ){echo "selected='selected'";}?> ><?php echo $each_subcategory->name;?></option>
								<?php } ?>
	    					</select>
						</label>
					</section>
					<section>
						<label class="label">SKU:</label>
						<label class="input">
							<input type="text" name="sku" id="sku"  maxlength = "50"  class="inputbox" value="<?php echo set_value('sku',$client_product->sku);?>" />
						</label>
					</section>
					<section>
						<label class="label">Product Name:<span class="mandatory">&nbsp;*</span></label>
						<label class="input">
							<input type="text" name="client_product_title" id="client_product_title"  maxlength = "50"  class="inputbox" value="<?php echo set_value('client_product_title',$client_product->product_title);?>" />
						</label>
					</section>
					<section>
						<label class="label">Product Price:<span class="mandatory">&nbsp;*</span></label>
						<label class="input">
							<input type="number" min="0" name="client_product_price" id="client_product_price"  maxlength = "50"  class="inputbox" value="<?php echo set_value('client_product_price',$client_product->product_price );?>" />
						</label>
					</section>
					<section>
						<label class="label">Product Volume:<span class="mandatory">&nbsp;*</span></label>
						<label class="input">
							<input type="text" name="client_product_volume" id="client_product_volume"  maxlength = "50"  class="inputbox" value="<?php echo set_value('client_product_volume',$client_product->product_volume );?>" />
						</label>
					</section>
					<section>
						<label class="label">Product Size:</label>
						<label class="input">
							<input type="text" name="product_size" id="product_size"   class="inputbox" value="<?php echo set_value( 'product_size', $client_product->product_size ); ?>" />
						</label>
					</section>
					<section>
						<label class="label">Product Type:</label>
						<div class="inline-group">
							<label class="radio">
								<input type="radio" name="type_consultant" value="1" <?php echo set_value('type_consultant', $client_product->type_consultant) == 1 ? "checked" : ""; ?> />
								<i></i>Consultant</label>
							<label class="radio">
								<input type="radio" name="type_consultant" value="0" <?php echo set_value('type_consultant', $client_product->type_consultant) == 0 ? "checked" : ""; ?> />
								<i></i>Normal</label>
							
						</div>
					</section>
					<section>
						<label class="label">Product Payment Type:</label>
						<div class="inline-group">
							<label class="radio">
								<input type="radio" name="payment_recurring" value="1" <?php echo set_value('payment_recurring', $client_product->payment_recurring) == 1 ? "checked" : ""; ?> />
								<i></i>Recurring</label>
							<label class="radio">
								<input type="radio" name="payment_recurring" value="0" <?php echo set_value('payment_recurring', $client_product->payment_recurring) == 0 ? "checked" : ""; ?> />
								<i></i>One Time</label>
							
						</div>
					</section>
					<section>
						<label class="label">Upload Product Image:<span class="mandatory">&nbsp;*</span></label>
						<label class="input">
							<input type='hidden' name='MAX_FILE_SIZE' value='10000000' />
							<input type="hidden" id="no_of_attachments" name="no_attach" value="1">
							<input type="hidden" id="no_of_colors" name="no_color" value="1">
							<input type='file' name='image' id='image' value="<?php echo set_value('image','');?>">
							<i>(Image Size <= 5MB, Width X Height <= 2024 X 768)</i>
						</label>
					</section>
					<section>
						<label class="label">Product Image:</label>
						<label class="input">
							<?php 
								$settings = array('w'=>100,'h'=>100,'crop'=>true);
								if(!empty($client_product->image)) {
									$image = ROOT_PATH . $client_product->image;
							?>
								<img src="<?php echo image_resize( $image, $settings)?>" border='0' />
							<?php } else { 
								echo "No image found"; 
							} ?>
						</label>
					</section>
					<section>
						<label class="label">Upload Product Image2:</label>
						<label class="input">
							<input type='file' name='image2' id='image2' value="<?php echo set_value('image2','');?>">
							<i>(Image Size <= 5MB, Width X Height <= 2024 X 768)</i>
						</label>
					</section>
					<section>
						<label class="label">Product Image2:</label>
						<label class="input">
							<?php 
								$settings = array('w'=>100,'h'=>100,'crop'=>true);
								if(!empty($client_product->image2)) {
									$image2 = ROOT_PATH . $client_product->image2; ?>
									<img src="<?php echo image_resize( $image2, $settings)?>" border='0' />
							<?php  } else { 
								echo "No image found"; 
							} ?>
						</label>
					</section>
					<section>
						<label class="label">Upload Product Image3:</label>
						<label class="input">
							<input type='file' name='image3' id='image3' value="<?php echo set_value('image3','');?>">
							<i>(Image Size <= 5MB, Width X Height <= 2024 X 768)</i>
						</label>
					</section>
					<section>
						<label class="label">Product Image:<span class="mandatory">&nbsp;*</span></label>
						<label class="input">
							<?php 
								$settings = array('w'=>100,'h'=>100,'crop'=>true);
								if(!empty($client_product->image3)) {
									$image3 = ROOT_PATH . $client_product->image3;
							?>
								<img src="<?php echo image_resize( $image3, $settings)?>" border='0' />
							<?php } else {
								echo "No image found";
							} ?>
						</label>
					</section>
					<section>
						<label class="label">Description:<span class="mandatory">&nbsp;*</span></label>
						<label class="input">
							<textarea name="description" id="description" class="mceEditor" cols="30" rows="4"><?php echo set_value('description',html_entity_decode($client_product->description))?></textarea>
						</label>
					</section>
					<section>
						<label class="label">Product Weight(in grams):</label>
						<label class="input">
							<input type="text" name="product_weight" id="product_weight" class="inputbox" value="<?php echo set_value('product_weight', $client_product->weight);?>" />
						</label>
					</section>
					<section>
						<label class="checkbox">
							<input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ((isset($client_product->status) ? $client_product->status: set_value('status','')) == 1) ? 'checked="checked"' : '';?> />
							<i></i>
							<?php echo lang('status')?>
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url(); ?>attributesets/manage'" >Cancel</button>
					<input  type="hidden" name="formSubmitted" value="1" class="button" />
					<input  type="hidden" name="validat_image" value="" />
					<input  type="hidden" name="id" value="<?php echo (isset($client_product->id) ? $client_product->id : $this->input->post('id'))?>" />
				</footer>
			<?php echo form_close();?>
		</div>
	</div>
</div>
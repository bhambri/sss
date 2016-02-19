<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
$(function() {
	$( "#from_date" ).datepicker({
		defaultDate: "+1w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
			$( "#to_date" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#to_date" ).datepicker({
		defaultDate: "+1w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
			$( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	
	var $checkoutForm = $('#formEditcoupons').validate({
		rules : {
			coupon_type : {
				required : true
			},
			code : {
				required : true
			},
			discount_percent : {
				required : true
			},
			from_date : {
				required : true
			},
			to_date : {
				required : true
			},			
		},
		messages : {
			coupon_type : {
				required : 'Please select coupon type'
			},
			code : {
				required : 'Please enter coupon code'
			},
			discount_percent : {
				required : 'Please enter discount percent'
			},
			from_date : {
				required : 'Please enter start date'
			},
			to_date : {
				required : 'Please enter end date'
			},
		},
		errorPlacement : function(error, element) {
			error.insertAfter(element.parent());
		}
	});
});

function label_change(obj) {
 	var selval=obj[obj.selectedIndex].value;
 	if((selval ==  1)) {
 		jQuery('#disc_label').html('Discount Amount');
 	} else if((selval ==  2)  || (selval ==  3)) {
 		jQuery('#disc_label').html('Discount Percentage');
 	} else {
 		jQuery('#disc_label').html('Discount Percentage');
 	}
}
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
			<?php echo form_open('coupons/edit_coupons/'.$id,array('id'=>'formEditcoupons','enctype'=>'multipart/form-data','name'=>'formEditcoupons', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Coupon Type:<span class="mandatory">*</span></label>
						<label class="select">
							<?php if(($coupon_type_id == 2) ||($coupon_type_id == 3)) {
								$dlabel = 'Discount Percentage' ;
							} else if($coupon_type_id == 1) {
								$dlabel = 'Discount Amount' ;
							} else {
								$dlabel = 'Discount Percentage' ;
							} ?>
							<select name="coupon_type" id="coupon_type" onchange="label_change(this);">
								<option vaue="">-Select Coupon Type-</option>
						        <?php foreach ( $coupon_types as $each_type ) {?>
									<option value="<?php echo $each_type->id; ?>" <?php if( $each_type->id == $coupon_type_id) {echo "selected='selected'";} ?> ><?php echo $each_type->name; ?></option>
						        <?php }?>
						    </select>
						</label>
					</section>
					<section>
						<label class="label">Coupon Code:<span class="mandatory">*</span></label>
						<label class="input">
							<input readonly="readonly" type="text" name="code" id="code"  maxlength = "100" class="inputbox" value="<?php if( @$code ) { echo $code;} else { echo $random_code; } ?>" />
						</label>
					</section>
					<section>
						<label class="label">Discount Percentage:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="discount_percent" id="discount_percent" class="inputbox" value="<?php echo set_value('discount_percent',@$discount_percent);?>" />
						</label>
					</section>
					<section>
						<label class="label">Day of Start:<span class="mandatory">*</span></label>
						<label class="input">
							<?php if(isset($start_date)) {
								$sdate  = explode(" ",$start_date);
					        } ?>
							<input type="date" name="from_date" id="from_date" value="<?php if(isset($start_date)){ echo $sdate[0];  }?>" />
						</label>
					</section>
					<section>
						<label class="label">Day of Expiration:<span class="mandatory">*</span></label>
						<label class="input">
							<?php if(isset($expire_date)) {
						            $date  = explode(" ",$expire_date);
					        } ?>
							<input type="date" name="to_date" id="to_date" value="<?php if(isset($expire_date)){ echo $date[0];  }?>" />
						</label>
					</section>
					<section>
						<label class="checkbox">
							<input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ($status)?'checked="checked"':'';?> />
							<i></i>Active
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url(); ?>attributesets/manage'" >Cancel</button>
					<input  type="hidden" name="formSubmitted" value="1" class="button" />
					<input  type="hidden" name="id" value="<?php echo $id;?>" class="button" />
				</footer>
			<?php echo form_close();?>
		</div>
	</div>
</div>
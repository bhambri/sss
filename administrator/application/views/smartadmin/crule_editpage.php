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
			<?php echo form_open('couponrules/edit_crule',array('id'=>'formAddcoupons', 'enctype'=>'multipart/form-data','name'=>'formAddcoupons', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Coupon Type :<span class="mandatory">*</span></label>
						<label class="select">
							<select name="coupon_type" id="coupon_type" onchange="label_change(this);">
								<option value="">-Select Coupon Type-</option>
								<?php foreach ( $coupon_types as $each_type ) {?>
								<option value="<?php echo $each_type->id; ?>" <?php if($coupon_type == $each_type->id){ echo "selected" ; }?>><?php echo $each_type->name; ?></option>
								<?php }?>
							</select>
						</label>
					</section>
					<section>
						<label class="label">Range From :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="range_from" id="range_from"  maxlength = "100" class="inputbox" value="<?php if( @$range_from ) { echo @$range_from;} else { echo @$range_from; } ?>" />
							<i>lower limit of group sale</i>
						</label>
					</section>
					<section>
						<label class="label">Range To :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="range_to" id="range_to" class="inputbox" value="<?php echo set_value('range_to',@$range_to);?>" />
							<i>upper limit of group sale</i>
						</label>
					</section>
					<section>
						<label class="label"><span id="disc_label">Discount Percentage</span> :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="discount_percent" id="discount_percent" class="inputbox" value="<?php echo set_value('discount_percent',@$discount_percent);?>" />
						</label>
					</section>
					<section>
						<label class="checkbox">
							<input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ($status)?'checked="checked"':'';?> />
							<i></i>
							<?php echo lang('active')?>
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url(); ?>couponrules/manage_crule';" >Cancel</button>
					<input  type="hidden" name="formSubmitted" value="1" />
					<input type="hidden" name="id" value="<?php echo $id ; ?>">
				</footer>
			</form>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>
<script type="text/javascript">
	function label_change(obj){
		var selval=obj[obj.selectedIndex].value;
		if((selval ==  1)){
			jQuery('#disc_label').text('Discount Amount');
		}else if((selval ==  2)  || (selval ==  3)){
			jQuery('#disc_label').text('Discount Percentage');
		}else{
			jQuery('#disc_label').text('Discount Percentage');
		}
	}
	$(document).ready(function() {
		var $checkoutForm = $('#formAddcoupons').validate({
			rules : {
				coupon_type : { required : true },
				range_from : { required : true },
				range_to : { required : true },
				discount_percent : { required : true },
			},
			messages : {
				coupon_type : { required : 'Please select coupon type' },
				range_from : { required : 'Please enter lower limit' },
				range_to : { required : 'Please enter upper limit' },
				discount_percent : { required : 'Please enter discount percentage' },
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
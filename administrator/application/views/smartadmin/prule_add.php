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
		<span class="widget-icon"> <i class="fa fa-plus"></i> </span>
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
			<?php echo form_open('promotionrules/add_prule',array('id'=>'formAddcoupons', 'enctype'=>'multipart/form-data','name'=>'formAddcoupons', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Executive Level :<span class="mandatory">*</span></label>
						<label class="select">
							<select name="exe_type" id="exe_type">
								<option value="">-Select Executive Level-</option>
								<?php foreach ( $coupon_types as $each_type ) { ?>
									<option value="<?php echo $each_type->id; ?>" <?php if(@$executive_level_id == $each_type->id){ echo "selected" ; }?>><?php echo $each_type->executive_level; ?></option>
								<?php } ?>
							</select>
						</label>
					</section>
					<section>
						<label class="label">Min. Binary Volume :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="binaryvol_range_from" id="binaryvol_range_from"  maxlength="100"  class="inputbox" value="<?php if( @$binaryvol_range_from ) { echo @$binaryvol_range_from;} else { echo @$binaryvol_range_from; } ?>" />
						</label>
					</section>
					<section>
						<label class="label">Max. Binary Volume :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="binaryvol_range_to" id="binaryvol_range_to"   class="inputbox" value="<?php echo @$binaryvol_range_to ;?>" />
						</label>
					</section>
					<section>
						<label class="label">Min. Personal Purchase Volume :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="min_ppv" id="min_ppv"   class="inputbox" value="<?php echo @$min_ppv ;?>" />
						</label>
					</section>
					<section>
						<label class="label">Min. Personal Customer Volume :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="min_pcv" id="min_pcv"   class="inputbox" value="<?php echo @$min_pcv ;?>" />
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
					<button type="button" class="btn btn-default" onclick="javascript: window.history.back();" >Cancel</button>
					<input  type="hidden" name="formSubmitted" value="1" class="button" />
				</footer>
			<?php echo form_close();?>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>
<script type="text/javascript">
 function label_change(obj){
 	//alert(obj) ;
 	var selval=obj[obj.selectedIndex].value;
 	//alert(selval) ;
 	if((selval ==  1)){
 		
 		jQuery('#disc_label').html('Discount Amount');
 	}else if((selval ==  2)  || (selval ==  3)){
 		jQuery('#disc_label').html('Discount Percentage');
 	}else{
 		jQuery('#disc_label').html('Discount Percentage');
 	}
 }
 
 $(document).ready(function() {
		var $checkoutForm = $('#formAddcoupons').validate({
			rules : {
				exe_type : { required : true },
				binaryvol_range_from : { required : true },
				binaryvol_range_to : { required : true },
				min_ppv : { required : true },
				min_pcv : { required : true },
			},
			messages : {
				exe_type : { required : 'Please select executive level' },
				binaryvol_range_from : { required : 'Please enter min binary volume' },
				binaryvol_range_to : { required : 'Please enter max binary volume' },
				min_ppv : { required : 'Please enter min. personal purchase volume' },
				min_pcv : { required : 'Please enter min. personal customer volume' },
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>

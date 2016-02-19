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
			<?php echo form_open('taxes/add_tax/'.$this->uri->segments[3].'/'.$this->uri->segments[4],array('id'=>'formAddshipping', 'enctype'=>'multipart/form-data','name'=>'formAddshipping', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Shipping State :<span class="mandatory">*</span></label>
						<label class="input">
							<input readonly="readonly" type="text" name="state_name" id="state_name"   class="inputbox" value="<?php echo trim(ucwords(base64_decode($this->uri->segments[3]))); ?>" />
						</label>
					</section>
					<section>
						<label class="label">State Code :<span class="mandatory">*</span></label>
						<label class="input">
							<input readonly="readonly" type="text" name="state_code" id="state_code"   class="inputbox" value="<?php echo trim(strtoupper(base64_decode($this->uri->segments[4]))); ?>" />
						</label>
					</section>
					<section>
						<label class="label">Tax :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="tax" id="tax"   class="inputbox" value="<?php echo set_value('tax','');?>" />
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
<script>
 $(document).ready(function() {
		var $checkoutForm = $('#formAddshipping').validate({
			rules : {
				state_name : { required : true },
				state_code : { required : true },
				tax : { required : true },
				
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
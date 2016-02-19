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
			<?php echo form_open('settings/edit_settings_paypal/'.$id,array('id'=>'formEditsettings','enctype'=>'multipart/form-data','name'=>'formEditsettings', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Paypal Username :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="paypal_username" id="paypal_username" maxlength="30"  class="inputbox" value="<?php echo set_value('paypal_username',@$paypal_username);?>" >
							<i>Business Account, needed to get all payments</i>
						</label>
					</section>
					<section>
						<label class="label">Paypal Email :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="paypal_email" id="paypal_email"  maxlength = "100"  class="inputbox" value="<?php echo set_value('paypal_email',@$paypal_email);?>" />
						</label>
					</section>
					<section>
						<label class="label">PayPal Signature :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="paypal_signature" id="paypal_signature"   class="inputbox" value="<?php echo set_value('paypal_signature',@$paypal_signature);?>" />
							<i>Business Account, needed to get all payments</i>
						</label>
					</section>
					<section>
						<label class="label">Paypal Password :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="paypal_password" id="paypal_password"   class="inputbox" value="<?php echo set_value('paypal_password',@$paypal_password);?>" />
						</label>
					</section>
					<section>
						<label class="label">Cart Payments(using) :<span class="mandatory">*</span></label>
						<div class="row">
							<div class="col col-4">
								<label class="radio">
									<input type="radio" name="payusing" id="payusing" value="0" <?php if(!$payusing){ echo 'checked'; } ?> >
									<i></i>Paypal
								</label>
							</div>
							<div class="col col-4">
								<label class="radio">
									<input type="radio" name="payusing" id="payusing" value="1" <?php if($payusing == 1){ echo 'checked'; } ?>>
									<i></i>Meritus
								</label>
							</div>
						</div>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript: window.history.back();" >Cancel</button>
					<input  type="hidden" name="formSubmitted" value="1" class="button" />
					<input  type="hidden" name="id" value="<?php echo $id;?>" class="button" />
				</footer>
			<?php echo form_close();?>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>
<script>
 $(document).ready(function() {
		var $checkoutForm = $('#formEditsettings').validate({
			rules : {
				paypal_username : { required : true },
				paypal_email : { required : true, email: true },
				paypal_signature : { required : true },
				paypal_password : { required : true },
				
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
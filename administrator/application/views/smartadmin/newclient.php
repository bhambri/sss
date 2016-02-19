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
			<?php echo form_open('client/add',array('id'=>'formNewclient','name'=>'formNewclient', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Full Name:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="fName" id="fName"  maxlength="50" class="inputbox" value="<?php echo set_value('fName','');?>" />
						</label>
					</section>
					<section>
						<label class="label">(Store Name) Username:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="uName" id="uName"  maxlength = "50" class="inputbox" value="<?php echo set_value('uName','');?>" />
							<i>This will be used for store login as well as in CSV as a Store Name.</i>
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('email')?>:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="email" id="email"  maxlength="100" class="inputbox" value="<?php echo set_value('email','');?>" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('password')?>:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="password" name="password" id="password" maxlength = "50" class="inputbox" value="" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('conf_password')?>:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="password" name="passwordconf" id="passwordconf" maxlength="50" class="inputbox" value="" />
						</label>
					</section>
					<section>
						<label class="label">Company Name:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="company" id="company"  maxlength="50" class="inputbox" value="<?php echo set_value('company','');?>" />
						</label>
					</section>
					<section>
						<label class="label">Address:</label>
						<label class="textarea">
							<textarea name="address" id="address" class="inputbox"></textarea>
						</label>
					</section>
					<section>
						<label class="label">City:</label>
						<label class="input">
							<input type="text" name="city" id="city" class="inputbox" value="" />
						</label>
					</section>
					<section>
						<label class="label">State:</label>
						<label class="input">
							<input type="text" name="state_code" id="state_code" class="inputbox" value="" />
						</label>
					</section>
					<section>
						<label class="label">Zip:</label>
						<label class="input">
							<input type="text" name="zip" id="zip" maxlength="50" class="inputbox" value="" />
						</label>
					</section>
					<section>
						<label class="label">Comments:</label>
						<label class="textarea">
							<textarea name="comments" id="comments" class="inputbox"></textarea>
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('phone'); ?>:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="phone" id="phone"  maxlength = "100" class="inputbox" value="<?php echo set_value('phone','');?>" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('fax'); ?></label>
						<label class="input">
							<input type="text" name="fax" id="fax" maxlength="100" class="inputbox" value="<?php echo set_value('fax','');?>" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('sale_support_email'); ?>:</label>
						<label class="input">
							<input type="text" name="sale_support_email" id="sale_support_email"  maxlength = "100" class="inputbox" value="<?php echo set_value('sale_support_email','');?>" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('partner_support_email'); ?>:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="partner_support_email" id="partner_support_email"  maxlength="100" class="inputbox" value="<?php echo set_value('partner_support_email','');?>" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('technical_support_email'); ?>:</label>
						<label class="input">
							<input type="text" name="technical_support_email" id="technical_support_email"  maxlength="100" class="inputbox" value="<?php echo set_value('technical_support_email','');?>" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('about_us_link'); ?>:</label>
						<label class="input">
							<input type="text" name="about_us_link" id="about_us_link"  maxlength="100" class="inputbox" value="<?php echo set_value('about_us_link','');?>" />
						</label>
					</section>
					<section>
						<label class="checkbox">
							<input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo set_checkbox('status','1');?> />
							<i></i>
							<?php echo lang('active')?>
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url(); ?>attributesets/manage'" >Cancel</button>
					<input  type="hidden" name="formSubmitted" value="1" class="button" />
				</footer>
			<?php echo form_close();?>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>
<script type="text/javascript">

	$(document).ready(function() {

		var $checkoutForm = $('#formNewclient').validate({
			rules : {
				fName : {
					required : true
				},
				uName : {
					required : true
				},
				email : {
					required : true,
					email: true
				},
				password : {
					required : true
				},
				passwordconf : {
					required : true,
					equalTo : '#password'
				},
				company : {
					required : true
				},
				phone : {
					required : true
				},
				partner_support_email : {
					required : true
				},
			},
			messages : {
				fName : {
					required : 'Please enter first name'
				},
				uName : {
					required : 'Please enter username'
				},
				email : {
					required : 'Please enter email',
					email	 : 'Please enter valid email'
				},
				password : {
					required : 'Please enter password'
				},
				passwordconf : {
					required : 'Please enter confirm password',
					equalTo	 : 'Confirm password does not matched to password'
				},
				company : {
					required : 'Please enter company'
				},
				phone : {
					required : 'Please enter phone'
				},
				partner_support_email : {
					required : 'Please enter partner support email'
				}
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
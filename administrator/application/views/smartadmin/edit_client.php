
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
			<?php echo form_open('client/edit/id/'.$client->id ,array('id'=>'formEditclient','name'=>'formEditclient', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Full Name:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="fName" id="fName"  maxlength="50" class="inputbox" value="<?php echo (isset($client->fName) ? $client->fName : set_value('fName',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">(Store Name) Username:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="uName" id="uName"  maxlength = "50" class="inputbox" value="<?php echo (isset($client->username) ? $client->username : set_value('username',''));?>" />
							<i>This will be used for store login as well as in CSV as a Store Name.</i>
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('email')?>:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="email" id="email"  maxlength="100" class="inputbox" value="<?php echo (isset($client->email) ? $client->email : set_value('email',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Company Name:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="company" id="company"  maxlength="50" class="inputbox" value="<?php echo (isset($client->company) ? $client->company : set_value('company',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Address:</label>
						<label class="textarea">
							<textarea name="address" id="address" class="inputbox"><?php echo (isset($client->address) ? $client->address : set_value('address',''));?></textarea>
						</label>
					</section>
					<section>
						<label class="label">City:</label>
						<label class="input">
							<input type="text" name="city" id="city" class="inputbox" value="<?php echo (isset($client->city) ? $client->city : set_value('city',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">State:</label>
						<label class="input">
							<input type="text" name="state_code" id="state_code" class="inputbox" value="<?php echo (isset($client->state_code) ? $client->state_code : set_value('state_code',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Zip:</label>
						<label class="input">
							<input type="text" name="zip" id="zip" maxlength="50" class="inputbox" value="<?php echo (isset($client->zip) ? $client->zip : set_value('zip',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Comments:</label>
						<label class="textarea">
							<textarea name="comments" id="comments" class="inputbox"><?php echo (isset($client->comments) ? $client->comments : set_value('comments',''));?></textarea>
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('phone'); ?>:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="phone" id="phone"  maxlength = "100" class="inputbox" value="<?php echo (isset($client->phone) ? $client->phone : set_value('phone',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Consultant fee:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="consultantfee" id="consultantfee"   class="inputbox" value="<?php echo (isset($client->consultantfee) ? $client->consultantfee : set_value('consultantfee',''));?>" />
							<i>(Recurring monthly fee, should be > 0 )</i>
						</label>
					</section>
					<section>
						<label class="label">Signup fee:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="signupfee" id="signupfee"   class="inputbox" value="<?php echo (isset($client->signupfee) ? $client->signupfee : set_value('signupfee',''));?>" />
							<i>(Initial sign up fee, should be > 0)</i>
						</label>
					</section>
					<section>
						<label class="label">Billing Start delay:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="billing_start_delay" id="billing_start_delay"   class="inputbox" value="<?php echo (isset($client->billing_start_delay) ? $client->billing_start_delay : set_value('billing_start_delay',''));?>" />
							<i>(Delayed month value , Please note that this should be integer only(from 1 to 11)).</i>
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('fax'); ?></label>
						<label class="input">
							<input type="text" name="fax" id="fax"  maxlength = "100"  class="inputbox" value="<?php echo (isset($client->fax) ? $client->fax : set_value('fax',''));?>" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('sale_support_email'); ?>:</label>
						<label class="input">
							<input type="text" name="sale_support_email" id="sale_support_email"  maxlength = "100"  class="inputbox" value="<?php echo (isset($client->sale_support_email) ? $client->sale_support_email : set_value('sale_support_email',''));?>" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('partner_support_email'); ?>:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="partner_support_email" id="partner_support_email"  maxlength = "100"  class="inputbox" value="<?php echo (isset($client->partner_support_email) ? $client->partner_support_email : set_value('partner_support_email',''));?>" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('technical_support_email'); ?>:</label>
						<label class="input">
							<input type="text" name="technical_support_email" id="technical_support_email"  maxlength = "100"  class="inputbox" value="<?php echo (isset($client->technical_support_email) ? $client->technical_support_email : set_value('technical_support_email',''));?>" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('about_us_link'); ?>:</label>
						<label class="input">
							<input type="text" name="about_us_link" id="about_us_link"  maxlength = "100"  class="inputbox" value="<?php echo (isset($client->about_us_link) ? $client->about_us_link : set_value('about_us_link',''));?>" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('opportunity_link')?>:</label>
						<label class="input">
							<input type="text" name="opportunity_link" id="opportunity_link"  maxlength = "100"  class="inputbox" value="<?php echo (isset($client->opportunity_link) ? $client->opportunity_link : set_value('opportunity_link',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Training Link:</label>
						<label class="input">
							<input type="text" name="training_link" id="training_link"  maxlength = "100"  class="inputbox" value="<?php echo (isset($client->training_link) ? $client->training_link : set_value('training_link',''));?>" />
						</label>
					</section>
					<?php if($cusrrole['role_id'] == 1) { ?>
						<section>
							<label class="label">Store Url:</label>
							<label class="input">
								<input type="text" name="store_url" id="store_url"  maxlength = "100"  class="inputbox" value="<?php echo (isset($client->store_url) ? $client->store_url : set_value('store_url',''));?>" />
								<i>(Please note this domain needs to assigned the ip).</i>
							</label>
						</section>
						<section>
							<label class="checkbox">
								<input type="checkbox" name="is_mlmtype" id="is_mlmtype"  maxlength = "100"  class="inputbox" value="1" <?php echo ((isset($client->is_mlmtype) ? $client->is_mlmtype : set_value('is_mlmtype','')) == 1) ? 'checked="checked"' : '';?> />
								<i></i>
								MLM type
							</label>
						</section>
					<?php } ?>
					<section>
						<label class="checkbox">
							<input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ((isset($client->status) ? $client->status : set_value('status','')) == 1) ? 'checked="checked"' : '';?> />
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
					<input  type="hidden" name="id" value="<?php echo (isset($client->id) ? $client->id : $this->input->post('id'))?>" />
					<input  type="hidden" name="salt" value="<?php echo (isset($client->password_salt) ? $client->password_salt : $this->input->post('salt'))?>" />
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
				company : {
					required : true
				},
				phone : {
					required : true
				},
				consultantfee : {
					required : true
				},
				signupfee : {
					required : true
				},
				billing_start_delay : {
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
				company : {
					required : 'Please enter company'
				},
				phone : {
					required : 'Please enter phone'
				},
				consultantfee : {
					required : 'Please enter consultant fee'
				},
				signupfee : {
					required : 'Please enter signup fee'
				},
				billing_start_delay : {
					required : 'Please enter billing start delay'
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
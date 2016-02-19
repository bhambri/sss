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
			<?php echo form_open("client/change_password_client/$store_id",array('id'=>'formEditUser','name'=>'formEditUser', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label"><?php echo lang('password')?>:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="password" name="new_password" id="new_password"  maxlength="50" class="inputbox" value="<?php echo (isset($user->password_orig) ? $user->password_orig : set_value('password',''));?>" />
						</label>
					</section>
					<section>
						<label class="label"><?php echo lang('conf_password')?>:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="password" name="confirm_password" id="confirm_password"  maxlength="50" class="inputbox" value="<?php echo (isset($user->password_orig) ? $user->password_orig : set_value('passwordconf',''));?>" />
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary"><?php echo lang("btn_edit"); ?></button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url(); ?>attributesets/manage'" >Cancel</button>
					<input type="hidden" name="form_submitted" value="1" />
					<input type="hidden" name="id" value="<?php echo (isset($user->id) ? $user->id : $this->input->post('id'))?>" />
				</footer>
			<?php echo form_close();?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var $checkoutForm = $('#formEditUser').validate({
			rules : {
				new_password : {
					required : true,
				},
				confirm_password : {
					required : true,
					equalTo : '#new_password'
				},
			},
			messages : {
				new_password : {
					required : 'Please enter password',
				},
				confirm_password : {
					required : 'Please enter confirm password',
					equalTo : 'Confirm password does not matched to password'
				},
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
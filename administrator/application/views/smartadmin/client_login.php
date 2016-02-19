<div class="well no-padding">
	<?php 
		$attr = array('name'=>'clientLogin','id'=>'clientLogin','class'=>"smart-form client-form");
		echo form_open('client/index', $attr);
	?>
		<header>Sign In</header>
		<fieldset>
			<?php if (strlen(validation_errors()) > 1)  : ?>
			<section>
				<div class="alert alert-danger fade in">
					<i class="fa-fw fa fa-times"></i>
					<strong>Error!</strong>
					<ul class="error_ul"><li><strong>Please correct the following:<br/><br/></strong></li><?php echo validation_errors('<li>','</li>');?></ul>
				</div>
			</section>
			<?php endif; ?>
			<?php if($this->session->flashdata('errors')): ?>
			<section>
				<div class="alert alert-danger fade in">
					<i class="fa-fw fa fa-times"></i>
					<strong>Error!</strong> <?php echo $this->session->flashdata('errors');?>
				</div>
			</section>
			<?php endif; ?>
			<!-- Errors And Message Display Row > -->
			<!-- Success And Message Display Row < -->
			<?php if($this->session->flashdata('success')): ?>
			<section>
				<div class="alert alert-success fade in">
					<i class="fa-fw fa fa-check"></i>
					<strong>Success</strong> <?php echo $this->session->flashdata('success');?>
				</div>
			</section>
			<?php endif; ?>
			<section>
				<label class="label"><?php echo lang("username"); ?></label>
				<label class="input"> <i class="icon-append fa fa-user"></i>
					<input name="clientusername" type="text" class="inputbox" id="clientusername" size="25" maxlength="40" />
					<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter username</b></label>
			</section>
			<section>
				<label class="label"><?php echo lang("password"); ?></label>
				<label class="input"> <i class="icon-append fa fa-lock"></i>
					<input name="clientpassword" type="password" class="inputbox" id="clientpassword" size="25" maxlength="40"  />
					<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b> </label>
				<div class="note">
					<a href="<?php echo base_url(); ?>client/forgot_password">Forgot password?</a>
				</div>
			</section>
		</fieldset>
		<footer>
			<button type="submit" class="btn btn-primary">Sign in</button>
		</footer>
		<input type="hidden" name="loginFormSubmitted" value="1" />
	<?php echo form_close();?>
</div>

<script type="text/javascript">
	$(function() {
		// Validation
		$("#clientLogin").validate({
			// Rules for form validation
			rules : {
				clientusername : {
					required : true,
				},
				clientpassword : {
					required : true,
					minlength : 3,
					maxlength : 20
				}
			},
			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
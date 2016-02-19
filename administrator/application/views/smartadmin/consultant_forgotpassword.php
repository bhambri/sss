<div class="well no-padding">
	<?php 
		$attr = array('name'=>'adminForgot', 'id'=>'adminForgot', 'class'=>"smart-form client-form");
		echo form_open('consultant/forgot_password', $attr);
	?>
		<header>Forgot Password</header>
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
				<label class="label"><?php echo lang("email"); ?></label>
				<label class="input">
					<input name="email" type="text" class="inputbox" id="email" size="25" maxlength="100" />
				</label>
				<div class="note">
					<a href="<?php echo base_url(); ?>consultant/index">Sign In</a>
				</div>
			</section>
		</fieldset>
		<footer>
			<button type="submit" class="btn btn-primary"><?php echo lang('btn_retrieve')?></button>
		</footer>
		<input type="hidden" name="loginFormSubmitted" value="1" />
	<?php echo form_close();?>
</div>

<script type="text/javascript">
	$(function() {
		// Validation
		$("#adminForgot").validate({
			// Rules for form validation
			rules : {
				email : {
					required : true,
					email : true,
				},
			},
			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
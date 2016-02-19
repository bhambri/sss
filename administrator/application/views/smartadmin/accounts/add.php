<div class="row">
	<div class="col-xs-12">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-plus fa-fw "></i>
			<?php
				if($CustomerID) {
					echo 'Update Account :: '.$CustomerID ;
				} else {
					echo ucfirst($caption);
				}
			?>
		</h1>
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
		<h2><?php 
				if($CustomerID) {
					echo 'Update Account :: Account already added with id '.$CustomerID ;
				} else {
					echo ucfirst($caption);
				}
			?>
		</h2>
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
			<?php if($meritusEnabled) { ?>
				<?php echo form_open('accounts/add',array('id'=>'accountsAddPage','name'=>'accountsAddPage', 'class'=>"smart-form"));?>
					<fieldset>
						<section>
							<label class="label">Bank Name :<span class="mandatory">*</span></label>
							<label class="input">
								<input type="text" name="BankName" id="BankName"  maxlength = "100" class="inputbox" />
							</label>
						</section>
						<section>
							<label class="label">Account Name :<span class="mandatory">*</span></label>
							<label class="input">
								<input type="text" name="AccountName" id="AccountName"  maxlength = "100" class="inputbox" />
							</label>
						</section>
						<section>
							<label class="label">Account Number :<span class="mandatory">*</span></label>
							<label class="input">
								<input type="text" name="AccountNumber" id="AccountNumber"  maxlength = "100" class="inputbox" />
							</label>
						</section>
						<section>
							<label class="label">Routing Number :<span class="mandatory">*</span></label>
							<label class="input">
								<input type="text" name="RoutingNumber" id="RoutingNumber"  maxlength = "100" class="inputbox" />
							</label>
						</section>
						<section>
							<label class="label">Bank Account Type :<span class="mandatory">*</span></label>
							<label class="select">
								<select name="BankAccountType" id="BankAccountType">
									<option value="CK">Checking Account</option>
									<option value="SA">Savings Account</option>
								</select>
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
			<?php } ?>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>
<script>
 $(document).ready(function() {
		var $checkoutForm = $('#accountsAddPage').validate({
			rules : {
				BankName : { required : true },
				AccountName : { required : true },
				AccountNumber : { required : true },
				RoutingNumber : { required : true },
				BankAccountType : { required : true },
				
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
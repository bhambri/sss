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
			<?php echo form_open('settings/edit_settings_avatax/'.$id,array('id'=>'formEditsettings','enctype'=>'multipart/form-data','name'=>'formEditsettings', 'class'=>"smart-form"));?>
				<fieldset>
					<?php if(($role_id !=4) && ($role_id != 1)) { ?>
						<section>
							<label class="label">Account Number :</label>
							<label class="input">
								<input type="text" name="ava_account_number" id="ava_account_number" class="inputbox" value="<?php echo set_value('ava_account_number',@$ava_account_number);?>" />
								<i>Avalara AVA Tax, Account No., required to enable tax calculation using avalara</i>
							</label>
						</section>
						<section>
							<label class="label">Licence Key :</label>
							<label class="input">
								<input type="text" name="ava_license_key" id="ava_license_key" class="inputbox" value="<?php echo set_value('ava_license_key',@$ava_license_key);?>" />
								<i>Avalara AVA Tax, Licence key, required to enable tax calculation using avalara</i>
							</label>
						</section>
						<section>
							<label class="label">Company Code :</label>
							<label class="input">
								<input type="text" name="ava_company_code" id="ava_company_code" class="inputbox" value="<?php echo set_value('ava_company_code',@$ava_company_code);?>" />
								<i>Avalara AVA Tax, Company Code, required to enable tax calculation using avalara</i>
							</label>
						</section>
					<?php } ?>
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
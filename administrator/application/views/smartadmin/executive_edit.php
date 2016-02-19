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
			<?php echo form_open('executives/executive_edit/' ,array('id'=>'formEditExecutive','name'=>'formEditExecutive', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Executive Level :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="e_level" id="e_level"  maxlength = "100"  class="inputbox" value="<?php echo (isset($executive->executive_level) ? $executive->executive_level : set_value('e_level',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Bonus Amount :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="bonus_amt" id="bonus_amt"  maxlength = "100"  class="inputbox" value="<?php echo (isset($executive->bonus_amt) ? $executive->bonus_amt : set_value('bonus_amt',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Executive Level order:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="exec_order" id="exec_order"  maxlength = "100"  class="inputbox" value="<?php echo (isset($executive->exec_order) ? $executive->exec_order : set_value('exec_order',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Generation Access:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="g_access" id="g_access"  maxlength = "100"  class="inputbox" value="<?php echo isset($executive->generation_access) ? $executive->generation_access :  set_value('g_access','');?>" />
						</label>
					</section>
					<section>
						<label class="label">Direct Commission (%) :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="d_commission" id="d_commission"  maxlength = "100"  class="inputbox" value="<?php echo (isset($executive->direct_commision) ? $executive->direct_commision : set_value('d_commission',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Configurable Volume (%) :</label>
						<label class="input">
							<input type="number" name="configurable_volume_percentage" id="configurable_volume_percentage"  maxlength = "100"  class="inputbox" value="<?php echo (isset($executive->configurable_volume_percentage) ? $executive->configurable_volume_percentage : set_value('configurable_volume_percentage',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Personal Purchase Volume (%) :</label>
						<label class="input">
							<input type="number" name="personal_purchase_volume" id="personal_purchase_volume"  maxlength = "100"  class="inputbox" value="<?php echo (isset($executive->personal_purchase_volume) ? $executive->personal_purchase_volume : set_value('personal_purchase_volume',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Personal Customer Volume (%) :</label>
						<label class="input">
							<input type="number" name="personal_customer_volume" id="personal_customer_volume"  maxlength = "100"  class="inputbox" value="<?php echo (isset($executive->personal_customer_volume) ? $executive->personal_customer_volume : set_value('personal_customer_volume',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Configurable Binary Volume (%) :</label>
						<label class="input">
							<input type="number" name="configurable_binary_volume" id="configurable_binary_volume"  maxlength = "100"  class="inputbox" value="<?php echo (isset($executive->configurable_binary_volume) ? $executive->configurable_binary_volume : set_value('configurable_binary_volume',''));?>" />
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript: window.location ='<?php echo base_url(); ?>executives/executive_manage';" >Cancel</button>
					<input  type="hidden" name="formSubmitted" value="1" />
					<input  type="hidden" name="id" value="<?php echo (isset($executive->id) ? $executive->id : $this->input->post('id'))?>" />
				</footer>
			</form>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var $checkoutForm = $('#formEditExecutive').validate({
			rules : {
				e_level : { required : true },
				bonus_amt : { required : true },
				exec_order : { required : true },
				g_access : { required : true },
				d_commission : { required : true },
			},
			messages : {
				e_level : { required : 'Please enter executive level' },
				bonus_amt : { required : 'Please enter bonus amount' },
				exec_order : { required : 'Please enter executive order' },
				g_access : { required : 'Please enter generation access' },
				d_commission : { required : 'Please enter direct commission' },
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
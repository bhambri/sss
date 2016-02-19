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
			<?php echo form_open('consultant/commission_setting_add',array('id'=>'formNewclient','name'=>'formNewclient', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Level 1 (%) :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="level1" id="level1"  maxlength="50"  class="inputbox" value="<?php echo set_value('level1','');?>" />
						</label>
					</section>
					<section>
						<label class="label">Level 2 (%) :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="level2" id="level2"  maxlength="50"  class="inputbox" value="<?php echo set_value('level2','');?>" />
						</label>
					</section>
					<section>
						<label class="label">Level 3 (%) :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="level3" id="level3"  maxlength="50"  class="inputbox" value="<?php echo set_value('level3','');?>" />
						</label>
					</section>
					<section>
						<label class="label">Level 4 (%) :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="level4" id="level4"  maxlength="50"  class="inputbox" value="<?php echo set_value('level4','');?>" />
						</label>
					</section>
					<section>
						<label class="label">Level 5 (%) :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="level5" id="level5"  maxlength="50"  class="inputbox" value="<?php echo set_value('level5','');?>" /> 
						</label>
					</section>
					<section>
						<label class="label">Level 6 (%) :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="level6" id="level6"  maxlength="50"  class="inputbox" value="<?php echo set_value('level6','');?>" />
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
					<input  type="hidden" name="formSubmitted" value="1" />
				</footer>
			</form>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>

<script type="text/javascript">
	$(document).ready(function() {
		var $checkoutForm=$('#formNewclient').validate({
			rules : {
				level1 : { required : true },
				level2 : { required : true },
				level3 : { required : true },
				level4 : { required : true },
				level5 : { required : true },
				level6 : { required : true },
			},
			messages : {
				level1 : {required : 'Please enter commission'},
				level2 : {required : 'Please enter commission'},
				level3 : {required : 'Please enter commission'},
				level4 : {required : 'Please enter commission'},
				level5 : {required : 'Please enter commission'},
				level6 : {required : 'Please enter commission'},
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
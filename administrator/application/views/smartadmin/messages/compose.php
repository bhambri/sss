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
			<?php echo form_open('messages/compose/', array('id'=>'messagesCompose','name'=>'messagesCompose', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Sent To:<span class="mandatory">*</span></label>
						<label class="select">
							<select data-placeholder="Receipients" name="participant[]" id="participant"  class="chosen-select" multiple>
								<?php foreach($chat_users as $user) { ?>
									<option value="<?php echo $user->id; ?>"><?php echo $user->name; ?></option>
								<?php } ?>
							</select>
						</label>
					</section>
					<section>
						<label class="label">Subject:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="subject" id="subject"  class="inputbox" />
						</label>
					</section>
					
					<section>
						<label class="label">Message:<span class="mandatory">*</span></label>
						<label class="textarea">
							<textarea name="message" id="message" class="mceEditor" cols="61" rows="4"></textarea>
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url(); ?>attributesets/manage'" >Cancel</button>
				</footer>
			<?php echo form_close();?>
		</div>
	</div>
</div>

<link href="<?php echo layout_url('default/assets'); ?>/css/chosen.css" rel="stylesheet">
<script src="<?php echo layout_url('default/assets'); ?>/js/chosen.jquery.js" type="text/javascript"></script>
<script>
	$(document).ready(function() {
		var $checkoutForm = $('#messagesCompose').validate({
			rules : {
				participant : {
					required : true
				},
				subject : {
					required : true
				},
				message : {
					required : true
				},
			},
			messages : {
				participant : {
					required : 'Please select sent to.'
				},
				subject : {
					required : 'Please enter subject'
				},
				message : {
					required : 'Please enter message'
				},
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
		
		$('.chosen-select').chosen();
	});
</script>


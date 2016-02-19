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
			<?php echo form_open('shipping/edit_shipping/'.$id.'/'.$this->uri->segments[4],array('id'=>'formEditshipping','enctype'=>'multipart/form-data','name'=>'formEditshipping', 'class'=>"smart-form")); ?>
				<fieldset>
					<section>
						<label class="label">Shipping State :<span class="mandatory">*</span></label>
						<label class="input">
							<input readonly="readonly" type="text" name="state_name" id="state_name"   class="inputbox" value="<?php echo trim(ucwords(base64_decode($this->uri->segments[4]))); ?>" />
						</label>
					</section>
					<section>
						<label class="label">State Code :<span class="mandatory">*</span></label>
						<label class="input">
							<input readonly="readonly" type="text" name="state_code" id="state_code"   class="inputbox" value="<?php echo set_value('state_code',@$state_code);?>" />
						</label>
					</section>
					<section>
						<label class="label">Shipping Cost (<= 500 g) :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="w1" id="w1"   class="inputbox" value="<?php echo set_value('w1',@$w1);?>" />
						</label>
					</section>
					<section>
						<label class="label">Shipping Cost (501 to 1000g) :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="w2" id="w2"   class="inputbox" value="<?php echo set_value('w2',@$w2);?>" /> 
						</label>
					</section>
					<section>
						<label class="label">Shipping Cost (1001 to 1500 g) :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="w3" id="w3"   class="inputbox" value="<?php echo set_value('w3',@$w3);?>" /> 
						</label>
					</section>
					<section>
						<label class="label">Shipping Cost (1501 g to 2000g) :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="w4" id="w4"   class="inputbox" value="<?php echo set_value('w4',@$w4);?>" /> 
						</label>
					</section>
					<section>
						<label class="label">Shipping Cost (2001g and above) :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="number" name="w5" id="w5"   class="inputbox" value="<?php echo set_value('w5',@$w5);?>" /> 
						</label>
					</section>
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
<script type="text/javascript">
	$(document).ready(function() {
		var $checkoutForm = $('#formEditshipping').validate({
			rules : {
				state_name : { required : true },
				state_code : { required : true },
				w1 : { required : true },
				w2 : { required : true },
				w3 : { required : true },
				w4 : { required : true },
				w5 : { required : true },
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
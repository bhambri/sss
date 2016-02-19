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
			<?php echo form_open_multipart('',array('id'=>'formNewMember','name'=>'formNewMember', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Select Category :<span class="mandatory">*</span></label>
						<label class="select">
							<select name="category_id">
								<?php if( isset( $categories ) ): ?>
									<?php foreach ($categories as $category ) { ?>
										<option value="<?php echo $category->id;?>" <?php if($curr_session_cat_id==$category->id) { echo "selected='selected'"; } ?> ><?php echo $category->name;?></option>
									<?php } ?>
								<?php endif;?>
							</select>
						</label>
					</section>
					<section>
						<label class="label">Name :<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="name" id="name"  maxlength="50" class="inputbox" value="<?php echo set_value('name','');?>" />
						</label>
					</section>
					<section>
						<label class="label">Description :</label>
						<label class="textarea">
							<textarea name="description" id="description" cols="30" rows="4"><?php echo set_value('description', $description ) ; ?></textarea>
						</label>
					</section>
					<section>
						<label class="checkbox">
							<input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo set_value('status','')==1?"checked":""?> />
							<i></i>
							<?php echo lang('active')?>
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url(); ?>subcategory/manage'" >Cancel</button>
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
		var $checkoutForm = $('#formNewMember').validate({
			rules : {
				category_id : {
					required : true
				},
				name : {
					required : true
				},
			},
			messages : {
				category_id : {
					required : 'Please select parent category'
				},
				name : {
					required : 'Please enter name'
				},
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
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
			<?php echo form_open('settings/edit_settings/'.$id,array('id'=>'formEditsettings','enctype'=>'multipart/form-data','name'=>'formEditsettings', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Logo image:</label>
						<label class="input">
							<input type="file" name="logo_image" id="logo_image" > 
							<i>recommended height:160, width: 80 ,max size: 5000 kb</i>
							<input type="hidden" name="path" id="path" value="<?php echo $logo_image; ?>"/>
						</label>
					</section>
					<section>
						<label class="input">
							<?php 
								$settings = array('w'=>100,'h'=>100,'crop'=>true);
								$image = $_SERVER['DOCUMENT_ROOT'].'/' . $logo_image;
							?>
							<img src="<?php echo image_resize( $image, $settings)?>" border='0' /> 
						</label>
					</section>
					<?php if(($role_id !=4 ) && ($role_id != 1 )) { ?>
						<section>
							<label class="label">Change Consultant label to:</label>
							<label class="input">
								<input type="text" name="consultant_label" id="consultant_label" class="inputbox" value="<?php echo set_value('consultant_label',@$consultant_label);?>" />
							</label>
						</section>
					<?php } ?>
					<section>
						<label class="label">Facebook link:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="fb_link" id="fb_link" class="inputbox" value="<?php echo set_value('fb_link',@$fb_link);?>" />
						</label>
					</section>
					<section>
						<label class="label">Twitter link:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="twitter_link" id="twitter_link" class="inputbox" value="<?php echo set_value('twitter_link',@$twitter_link);?>"/>
						</label>
					</section>
					<section>
						<label class="label">Pinterest link:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="pinterest_link" id="pinterest_link" class="inputbox" value="<?php echo set_value('pinterest_link',@$pinterest_link);?>"/>
						</label>
					</section>
					<section>
						<label class="label">Linkdin link:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="linkdin_link" id="linkdin_link" class="inputbox" value="<?php echo set_value('linkdin_link',@$linkdin_link);?>"/>
						</label>
					</section>
					<section>
						<label class="label">Google+ link:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="gplus_link" id="gplus_link" class="inputbox" value="<?php echo set_value('gplus_link',@$gplus_link);?>"/>
						</label>
					</section>
					<section>
						<label class="label">Youtube link:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="youtube_link" id="youtube_link" class="inputbox" value="<?php echo set_value('youtube_link',@$youtube_link);?>"/>
						</label>
					</section>
					<section>
						<label class="checkbox">
							<input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ($status)?'checked="checked"':'';?> />
							<i></i>
							Published
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url(); ?>attributesets/manage'" >Cancel</button>
					<input  type="hidden" name="formSubmitted" value="1" class="button" />
					<input  type="hidden" name="id" value="<?php echo $id;?>" class="button" />
				</footer>
			<?php echo form_close();?>
		</div>
	</div>
</div>
<script type="text/javascript">

	$(document).ready(function() {

		var $checkoutForm = $('#formEditsettings').validate({
			rules : {
				fb_link : {
					required : true,
					url: true
				},
				twitter_link : {
					required : true,
					url: true
				},
				pinterest_link : {
					required : true,
					url: true
				},
				linkdin_link : {
					required : true,
					url: true
				},
				gplus_link : {
					required : true,
					url: true
				},
				youtube_link : {
					required : true,
					url: true
				},
			},
			messages : {
				fb_link : {
					required : 'Please enter facebook link',
					url: 'Please enter valid url'
				},
				twitter_link : {
					required : 'Please enter twitter link',
					url: 'Please enter valid url'
				},
				pinterest_link : {
					required : 'Please enter pinterest link',
					url: 'Please enter valid url'
				},
				linkdin_link : {
					required : 'Please enter linkdin link',
					url: 'Please enter valid url'
				},
				gplus_link : {
					required : 'Please enter gplus link',
					url: 'Please enter valid url'
				},
				youtube_link : {
					required : 'Please enter youtube link',
					url: 'Please enter valid url'
				},
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
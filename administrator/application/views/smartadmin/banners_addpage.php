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

<?php if(validation_errors() && ($this->upload->display_errors('<li>', '</li>') ) ): ?>
	<div class="alert alert-danger fade in">
		<button class="close" data-dismiss="alert">x</button>
		<i class="fa-fw fa fa-times"></i>
		<strong>Error!</strong>
		<ul class="error_ul">
			<li><strong>Please correct the following:</strong></li>
			<?php echo $this->upload->display_errors('<li>','</li>'); ?>
		</ul>
	</div>
<?php endif; ?>
<?php if(validation_errors() && (! $this->upload->display_errors('<li>', '</li>')) ): ?>
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
<?php if(!validation_errors() && ($this->upload->display_errors('<li>', '</li>')) ): ?>
	<div class="alert alert-danger fade in">
		<button class="close" data-dismiss="alert">x</button>
		<i class="fa-fw fa fa-times"></i>
		<strong>Error!</strong>
		<ul class="error_ul">
			<?php echo $this->upload->display_errors('<li>','</li>'); ?>
		</ul>
	</div>
<?php endif; ?>
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
			<?php echo form_open('banners/add_banners',array('id'=>'formAddbanners', 'enctype'=>'multipart/form-data','name'=>'formAddbanners', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Title:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="title" id="title"  maxlength = "100" class="inputbox" value="<?php echo set_value('page_title',@$title);?>" />
						</label>
					</section>
					<section>
						<label class="label">Link:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="link" id="link" value="<?php echo set_value('link',@$link);?>"  class="inputbox" />
						</label>
					</section>
					<section>
						<label class="label">Image:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="file" name="image" id="image"  class="inputbox" value="<?php echo set_value('page_metatitle',@$image);?>" /> Recommended height:585, width: 1900 ,max size: 5000 kb
						</label>
					</section>
					<section>
						<label class="label">Published:</label>
						<label class="input">
							<input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ($status)?'checked="checked"':'';?> />
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
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		var $checkoutForm = $('#formAddbanners').validate({
			rules : {
				title : {
					required : true
				},
				link : {
					required : true
				},
				image : {
					required : true
				}
			},
			messages : {
				title : {
					required : 'Please enter title'
				},
				link : {
					required : 'Please enter link'
				},
				image : {
					required : 'Please select image'
				}
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
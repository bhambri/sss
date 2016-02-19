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
			<?php echo form_open('storelinks/edit_storelinksnew',array('id'=>'formEditstorelinks', 'enctype'=>'multipart/form-data','name'=>'formEditstorelinks', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Title:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="title" id="title"  maxlength="100" class="inputbox" value="<?php echo set_value('page_title',@$title);?>" />
						</label>
					</section>
					<section>
						<label class="label">Image:</label>
						<label class="input">
							<input type="file" name="image" id="image" class="inputbox" value="<?php echo set_value('page_metatitle',@$image);?>" />
							Best size: max-height:250, max-width: 250 ,max size: 5000 kb
						</label>
					</section>
					<section>
						<?php
							$settings = array('w'=>180,'h'=>100,'crop'=>true);
							$image = 'http://'.$_SERVER['HTTP_HOST'].'/marketplace' . $image;
						?>
						<img src="<?php echo image_resize( $image, $settings)?>" border='0' />
					<input type="hidden" name="path" id="path" value="<?php echo $image;?>"/>
					</section>
					<section>
						<label class="label">Link:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="link" id="link"  class="inputbox" />
						</label>
					</section>
					<section>
						<label class="checkbox">
							<input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ($status)?'checked="checked"':'';?> />
							<i></i>Published
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url(); ?>attributesets/manage'" >Cancel</button>
					<input  type="hidden" name="formSubmitted" value="1" />
					<input  type="hidden" name="id" value="<?php echo $id;?>" class="button" />
				</footer>
			<?php echo form_close();?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var $checkoutForm = $('#formEditstorelinks').validate({
			rules : {
				title : {
					required : true
				},
				link : {
					required : true
				},
			},
			messages : {
				title : {
					required : 'Please enter title'
				},
				link : {
					required : 'Please enter link'
				}
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
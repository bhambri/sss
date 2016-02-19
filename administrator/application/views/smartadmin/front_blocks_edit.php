<link href="<?php echo layout_url('default/assets'); ?>/css/main.css" rel="stylesheet">
<link href="<?php echo layout_url('default/assets'); ?>/css/croppic.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo layout_url('default/assets'); ?>/js/croppic.min.js"></script>


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
			<?php echo form_open_multipart('front_blocks/front_blocks_edit/' ,array('id'=>'formEditFrontBlocks', 'name'=>'formEditFrontBlocks', 'class'=>"smart-form")); ?>
				<fieldset>
					<section>
						<label class="label">Block Title:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="title" id="title"  maxlength = "50" class="inputbox" value="<?php echo (isset($blocks->title) ? $blocks->title : set_value('title',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Image Text:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="image_text" id="image_text"  maxlength = "50" class="inputbox" value="<?php echo isset($blocks->image_text) ? $blocks->image_text :  set_value('image_text','');?>" />
						</label>
					</section>
					<section>
						<label class="label">Image :</label>
						<label class="input">
							<img src="<?php echo $blocks->image; ?>" />
						</label>
					</section>
					<section>
						<label class="label">Upload Image:</label>
						<label class="input">
							<div id='image_section' style="margin-left:15px;">
								<div class="container">			
									<div class="row mt ">
										<div class="col-lg-4 ">
											<div id="cropContaineroutput"></div>
											<input type="text" name="image" id="cropOutput" style="width:150px;" class="inputbox" value="<?php echo set_value('image','');?>" />
										</div>
									</div>	
								</div>
							</div>
						</label>
					</section>
					<section>
						<label class="label">Block Link:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="link" id="link"  maxlength = "200" class="inputbox" value="<?php echo isset($blocks->link) ? $blocks->link :  set_value('link','');?>" />
						</label>
					</section>
					<section>
						<label class="label">Priority:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="priority" id="priority"  maxlength = "100" class="inputbox" value="<?php echo isset($blocks->priority) ? $blocks->priority :  set_value('priority','');?>" />
							<i></i>
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript: window.location='<?php echo base_url(); ?>front_blocks/front_blocks_manage';" >Cancel</button>
					<input  type="hidden" name="formSubmitted" value="1" />
				<input  type="hidden" name="id" value="<?php echo (isset($blocks->id) ? $blocks->id : $this->input->post('id'))?>" />
				</footer>
			<?php echo form_close();?>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>
<script type="text/javascript">

$(document).ready(function() {

	var $checkoutForm = $('#formEditFrontBlocks').validate({
		rules : {
			title : { required : true},
			image_text : { required : true},
			link : { required : true},
			priority : { required : true},
		},
		errorPlacement : function(error, element) {
			error.insertAfter(element.parent());
		}
	});
});

var croppicContaineroutputOptions = {
	uploadUrl:'<?php echo base_url() . 'front_blocks/img_save_to_file'; ?>',
	cropUrl:'<?php echo base_url() . 'front_blocks/img_crop_to_file'; ?>',
	outputUrlId:'cropOutput',
	loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
	onAfterImgCrop:function(){  },
}

var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);

</script>

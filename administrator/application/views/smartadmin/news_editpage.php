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
			<?php echo form_open('news/edit_newsnew',array('id'=>'formEditNews','enctype'=>'multipart/form-data','name'=>'formEditNews', 'class'=>"smart-form")); ?>
				<fieldset>
					<section>
						<label class="label">News Title:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="page_title" id="page_title"  maxlength = "100" value="<?php echo set_value('page_title',@$page_title);?>" />
						</label>
					</section>
					<section>
						<label class="label">Meta Title:</label>
						<label class="input">
							<input type="text" name="page_metatitle" id="page_metatitle"  maxlength = "100" value="<?php echo set_value('page_metatitle',@$page_metatitle);?>" />
						</label>
					</section>
					<section>
						<label class="label">Meta Keywords:</label>
						<label class="textarea">
							<textarea onkeydown="textCounter(this, form.counter_mkey, 500)" onchange="textCounter(this, form.counter_mkey, 500)"  onkeyup="textCounter(this, form.counter_mkey, 500)" cols="61" rows="4" name="page_metakeywords" id="page_metakeywords" class="inputbox"><?php echo set_value('page_metakeywords',@$page_metakeywords)?></textarea>
							<input type="text" size="3" value="500" readonly="readonly" class="inputbox" name="counter_mkey" id="counter_mkey" /> Characters Left
						</label>
					</section>
					<section>
						<label class="label">Meta Description:</label>
						<label class="textarea">
							<textarea onkeydown="textCounter(this, form.counter_mdesc, 500)" onchange="textCounter(this, form.counter_mdesc, 500)" onkeyup="textCounter(this, form.counter_mdesc, 500)" cols="61" rows="4" name="page_metadesc" id="page_metadesc" class="inputbox"><?php echo set_value('page_metadesc',@$page_metadesc)?></textarea>
							<input type="text" size="3" value="500" readonly="readonly" class="inputbox" name="counter_mdesc" id="counter_mdesc"/> Characters Left
						</label>
					</section>
					<section>
						<label class="label">Thumbnail Image:</label>
						<div class="input input-file">
							<span class="button">
								<input id="thumb_image" type="file" name="thumb_image" onchange="$('#thumb_image_placeholder').val(this.value);"/>Browse
							</span>
							<input type="text" id="thumb_image_placeholder" placeholder="Include some files" readonly="" />
							max-height:768, max-width: 1024 ,max size: 5000 kb
						</div>
					</section>
					<section>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%"></td>
						<td width="60%">
						<?php 
							$settings = array('w'=>180,'h'=>100,'crop'=>true);
							$image =  $_SERVER['DOCUMENT_ROOT'] . '/marketplace' . $page_thumbnailpath;
						?>
						<img src="<?php echo image_resize( $image, $settings)?>" border='0' /></td>
					</section>
					<section>
						<label class="label">News ShortDesc:<span> * </span></label>
						<label class="textarea">
							<textarea cols="61" rows="4" name="page_shortdesc" id="page_shortdesc" class="inputbox"><?php echo set_value('page_shortdesc',@$page_shortdesc)?></textarea>
						</label>
					</section>
					<section>
						<label class="label">Content:<span> * </span></label>
						<label class="textarea">
							<textarea name="page_content" id="page_content" class="mceEditor" cols="61" rows="4" class="mceEditor" value="<?php echo set_value('page_content', @$page_content ) ;?>"><?php echo set_value('page_content', @$page_content ) ;?></textarea>
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url(); ?>attributesets/manage'" >Cancel</button>
					<input  type="hidden" name="id" value="<?php echo $id; ?>" class="button" />
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
		var $checkoutForm = $('#formEditNews').validate({
			rules : {
				page_title : {
					required : true
				},
				page_shortdesc : {
					required : true
				},
				page_content : {
					required : true
				}
			},
			messages : {
				page_title : {
					required : 'Please enter page title'
				},
				page_shortdesc : {
					required : 'Please enter short description'
				},
				page_content : {
					required : 'Please enter short content'
				}
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
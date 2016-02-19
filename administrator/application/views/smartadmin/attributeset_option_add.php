<div class="row">
	<div class="col-xs-12">
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
			<?php echo form_open_multipart('',array('id'=>'formNewMember','name'=>'formNewMember','class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Field label to show:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="field_label" id="field_label"  maxlength = "50" class="inputbox" value="<?php echo set_value('field_label', @$attribute_set_field->field_label) ; ?>" />
						</label>
					</section>
					<section>
						<label class="label">Select Attribute set:<span class="mandatory">*</span></label>
						<label class="select">
							<select name="attribute_set_id">
								<?php if( isset( $attributesets ) ):
									foreach ($attributesets as $attributeset) { ?>
										<option value="<?php echo $attributeset->id;?>" <?php if($curr_session_cat_id==$attributeset->id) { echo "selected='selected'"; } ?> ><?php echo $attributeset->name;?></option>
									<?php }
									endif;
								?>
							</select>
						</label>
					</section>
					<section>
						<label class="label">Select Attribute option type:<span class="mandatory">*</span></label>
						<label class="select">
							<select name="field_type" onchange="providefields();" id="field_type" >
								<option value="text" <?php if(isset($attribute_set_field->field_type) && ($attribute_set_field->field_type == 'text')){ echo 'selected' ; }?> >Text</option>
								<option value="radio" <?php if(isset($attribute_set_field->field_type) && ($attribute_set_field->field_type == 'radio')){ echo 'selected' ; }?> >Radio</option>	
								<option value="selectbox" <?php if(isset($attribute_set_field->field_type) && ($attribute_set_field->field_type == 'selectbox')){ echo 'selected' ; } ?> >Select Box</option>	
								<option value="checkbox"  <?php if(isset($attribute_set_field->field_type) && ($attribute_set_field->field_type == 'checkbox')){ echo 'selected' ; }?> >checkbox</option>	
							</select>
						</label>
					</section>
					<section>
						<label class="checkbox">
							<input type="checkbox" name="required" id="required" class="inputbox" value="1" <?php echo ((isset($attribute_set_field->required) ? $attribute_set_field->required : set_value('required','')) == 1) ? 'checked="checked"' : '';?> />
							<i></i>Required
						</label>
					</section>
					<section id="chooseno_of_options">
						<?php if(@$attribute_set_field->id && (($attribute_set_field->field_type == 'radio') || ($attribute_set_field->field_type == 'selectbox') || ($attribute_set_field->field_type == 'checkbox')) ){ ?>
							<section>
								<label class="label">Select No of options to add:<span class="mandatory">*</span></label>
								<label class="select">
									<select name="no_of_options" onchange="drawoptions();" id="no_of_options" >
										<option value="1" <?php if(@$no_of_options == 1){ echo 'selected'; } ?> >1</option>
										<option value="2" <?php if(@$no_of_options == 2){ echo 'selected'; } ?> >2</option>
										<option value="3" <?php if(@$no_of_options == 3){ echo 'selected'; } ?> >3</option>
										<option value="4" <?php if(@$no_of_options == 4){ echo 'selected'; } ?> >4</option>
										<option value="5" <?php if(@$no_of_options == 5){ echo 'selected'; } ?> >5</option>
										<option value="6" <?php if(@$no_of_options == 6){ echo 'selected'; } ?> >6</option>
										<option value="7" <?php if(@$no_of_options == 7){ echo 'selected'; } ?> >7</option>
									</select>
								</label>
								<i>Option values are mandatory, if no option values provided that option will not be added/edited.</i>
							</section>
						<?php } ?>
					</section>
					<section id="options_name_list1">
						<?php if(@$attribute_set_field->id && $no_of_options > 0 ) {
							foreach ($attribute_set_field_details as $key => $value) { ?>
								<table style="width:100%" class="input_table user_options">
									<tr>
										<td width="40%" nowrap="nowrap" class="input_form_caption_td">Option:<span>&nbsp;*</span></td>
										<td width="60%" align="left">
											<input type="text" name="options_name[<?php echo $key ; ?>]" id="field_label"  maxlength = "200" style="width: 150px;" class="inputbox" value="<?php echo $value ;?>" /> 
											<input type="text" name="options_price[<?php echo $key ; ?>]" id="field_label"  maxlength = "6" style="width: 100px;" class="inputbox" value="<?php echo $attribute_set_field_details_price[$key] ;?>" />
											(option name - price)
											<a href="<?php echo base_url()?>attributesets/remove_attr_opt/<?php echo $key ; ?>">
												<img border="0" alt="deactive" src="<?php echo base_url()?>/application/views/default/images/publish_x.png">
											</a>
										</td>
									</tr>
								</table>
							<?php } ?>
						<?php } ?>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url(); ?>attributesets/manage_options'" >Cancel</button>
					<input  type="hidden" name="formSubmitted" value="1" />
					<input  type="hidden" name="id" value="<?php echo (isset($attributeset->id) ? $attributeset->id : $this->input->post('id'))?>" />
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
				field_label : { required : true},
				attribute_set_id : { required : true},
				field_type : { required : true},
				no_of_options : { required : true},
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});

	function providefields(){
		typeval = jQuery("#field_type").val() ;
		if(typeval == 'text'){
			// nothing to do
			// + remove the options if there
			jQuery('#no_of_options').html('');
		}
		if((typeval == 'radio') || (typeval == 'selectbox') || (typeval == 'checkbox')){
			// provide the radio option
			// // alert('Enter no of option') ;
			// noofoption = '<td width=\"30%\" nowrap=\"nowrap\" class=\"input_form_caption_td\">Choose No of options:<span>&nbsp;*</span></td><td width=\"70%\" align=\"left\"><select name=\"no_of_options\" onchange=\"drawoptions();\" id=\"no_of_options\"><option value=\"0\">0</option><option value=\"1\">1</option><option value=\"2\">2</option><option value=\"3\">3</option><option value=\"4\">4</option><option value=\"5\">5</option><option value=\"6\">6</option><option value=\"7\">7</option></select></td>';
			
			noofoption =  '<section>'
					+ '<label class="label">Choose No of options:<span class="mandatory">*</span></label>'
						+ '<label class="select">'
							+ '<select name="no_of_options" onchange="drawoptions();" id="no_of_options" >'
								+ '<option value="1" >1</option>'
								+ '<option value="2" >2</option>'
								+ '<option value="3" >3</option>'
								+ '<option value="4" >4</option>'
								+ '<option value="5" >5</option>'
								+ '<option value="6" >6</option>'
								+ '<option value="7" >7</option>'
							+ '</select>'
						+  '</label>'
					+ '</section>';
			jQuery('#chooseno_of_options').html(noofoption);
			drawoptions();
		}
	}

	function drawoptions(){
		noofopt = jQuery("#no_of_options").val() ;
		user_options = jQuery(".user_options").length ;
		
		if(noofopt > user_options) {
			//options_name_list
			varoptfields = '<table style=\"width:100%\" class="\input_table user_options\"><tr><td width=\"40%\" nowrap=\"nowrap\" class=\"input_form_caption_td\">Option:<span>&nbsp;*</span></td><td width=\"60%\" align=\"left\"> <input type=\"text\" name=\"options_name[]\" id=\"field_label\"  maxlength = \"200\" style=\"width: 150px;\" class=\"inputbox\" value=\"\" /><input type=\"text\" name=\"options_price[]\" id=\"field_label\"  maxlength = \"6\" style=\"width: 100px;\" class=\"inputbox\" value=\"0.00\" /> (option name - price) </td></tr></table>' ;
			
			
			var newhtml = '' ;
			for(i=user_options+1; i<= noofopt ; i++){
				newhtml +=varoptfields ;
			}
			jQuery('#options_name_list1').append(newhtml);
		} else {
			var i = 1
			jQuery(".user_options").each(function(){
				var element	= jQuery(this);
				if(i > noofopt) {
					element.remove();
				}
				i++;
			});
		}
	}

</script>
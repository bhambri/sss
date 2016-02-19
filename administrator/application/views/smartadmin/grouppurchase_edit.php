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
			<?php echo form_open_multipart('',array('id'=>'formNewMember','name'=>'formNewMember', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Select Host::<span class="mandatory">*</span></label>
						<label class="select">
							<select name="host_id">
							<?php if( isset( $hosts ) ):
								foreach ($hosts as $user ) { 
									$select=( $user['id'] == $grouppurchase['host_id'] ) ? 'selected':'';
									echo "<option value='". $user['id'] ."' " . $select .  ">" . $user['name'] . "</option>";

								}
								endif;
							 ?>								
							</select>	
						</label>
					</section>
					<section>
						<label class="label">Name:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="name" id="name"  maxlength="50" class="inputbox" value="<?php echo (isset($grouppurchase['name']) ? $grouppurchase['name'] : set_value('name',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Description:</label>
						<label class="textarea">
							<textarea name="description" id="description" cols="30" rows="4"><?php echo (isset($grouppurchase['description']) ? $grouppurchase['description'] : set_value('description',''));?></textarea>
						</label>
					</section>
					<section>
						<label class="label">Location:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="location" id="location"  maxlength="50" class="inputbox" value="<?php echo (isset($grouppurchase['location']) ? $grouppurchase['location'] : set_value('location',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Event Code:<span class="mandatory">*</span></label>
						<label class="input">
							<input readonly="readonly" type="text" name="group_event_code" id="group_event_code"  maxlength="50" class="inputbox" value="<?php echo (isset($grouppurchase['group_event_code']) ? $grouppurchase['group_event_code'] : set_value('group_event_code',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Start Date:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="start_date" id="startdate"  maxlength="20" readonly="readonly" class="inputbox" value="<?php echo (isset($grouppurchase['start_date']) ? $grouppurchase['start_date'] : set_value('start_date',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">End Date:<span class="mandatory">*</span></label>
						<label class="input">
							<input type="text" name="end_date" id="enddate"  maxlength="20" readonly="readonly" class="inputbox" value="<?php echo (isset($grouppurchase['end_date']) ? $grouppurchase['end_date'] : set_value('end_date',''));?>" />
						</label>
					</section>
					<section>
						<label class="label">Image:</label>
						<label class="input">
							<input type="file" name="image" id="image" class="inputbox" value="" /> 
							<i>Recommended height:585, width: 1900 ,max size: 5000 kb</i>
						</label>
					</section>
					<section>
						<label class="input">
							<?php 
								$settings = array('w'=>180,'h'=>100,'crop'=>true);
								$image = 'http://'.$_SERVER['HTTP_HOST'].'/marketplace' . $grouppurchase['image'];
							?>
							<img src="<?php echo image_resize( $image, $settings)?>" border='0' />
						</label>
					</section>
					<section>
						<label class="checkbox">
							<input type="checkbox" name="status" id="status" class="inputbox" value="1" <?php echo ((isset($grouppurchase['status']) ? $grouppurchase['status'] : set_value('status','')) == 1) ? 'checked="checked"' : '';?>  />
							<i></i>
							<?php echo lang('status')?>
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<button type="submit" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location='<?php echo base_url(); ?>attributesets/manage'" >Cancel</button>
					<input type="hidden" name="store_id" value="<?php echo $grouppurchase['store_id'] ;?>" >
					<input type="hidden" name="consultant_id" value="<?php echo $grouppurchase['consultant_id'] ;?>" >
					<input type="hidden" name="event_image" value="<?php echo $grouppurchase['image'] ;?>" >
					<input  type="hidden" name="formSubmitted" value="1" />
					<input  type="hidden" name="validat_image" value="" />
				</footer>
			<?php echo form_close();?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var $checkoutForm = $('#formNewMember').validate({
			rules : {
				host_id : {
					required : true
				},
				name : {
					required : true
				},
				location : {
					required : true
				},
				group_event_code : {
					required : true
				},
				start_date : {
					required : true
				},
				end_date : {
					required : true
				},
			},
			messages : {
				host_id : {
					required : 'Please select host'
				},
				name : {
					required : 'Please enter name'
				},
				location : {
					required : 'Please enter location'
				},
				group_event_code : {
					required : 'Please enter group event code'
				},
				start_date : {
					required : 'Please enter start date'
				},
				end_date : {
					required : 'Please enter end date'
				},
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
		
		$( "#startdate,#enddate" ).datepicker();
	});
</script>
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
	<!-- widget div-->
	<div role="content">
		<!-- widget edit box -->
		<div class="jarviswidget-editbox">
			<!-- This area used as dropdown edit box -->
		</div>
		<!-- end widget edit box -->
		<!-- widget content -->
		<div class="widget-body no-padding">
			<div class="table-wrap custom-scroll animated fast fadeInRight">
				<h2 class="email-open-header">
					<?php echo ($messages[0]['subject']); ?> <span class="label txt-color-white">inbox</span>
				</h2>
				<?php foreach($messages as $message) { ?>
					<div class="inbox-info-bar">
						<div class="row">
							<div class="col-sm-9">
								<img src="<?php echo ASSETS_URL; ?>/img/avatars/male.png" alt="<?php echo $message['user_name']; ?>" class="away">
								<strong><?php echo $message['user_name']; ?></strong>
								<span class="hidden-mobile">to <strong>me</strong> on <i><?php echo date('h:i A, j F Y', strtotime($message['cdate']));?></i></span> 
							</div>
						</div>
					</div>
					<div class="inbox-message">
						<frame><?php echo $message['body']; ?></frame>
					</div>
					
				<?php $message_id	= $message['id'];
					} ?>
			</div>
		</div>
	</div>
</div>
<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget">
	<!-- widget div-->
	<header role="heading">
		<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
		<h2>Reply</h2>
		<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
	</header>
	<!-- widget div-->
	<div role="content">
		<!-- widget content -->
		<div class="widget-body no-padding">
			<?php echo form_open('messages/reply/', array('id'=>'messagesReply','name'=>'messagesReply', 'class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Message:<span class="mandatory">*</span></label>
						<label class="textarea">
							<textarea name="message" id="message" class="mceEditor" cols="61" rows="4"></textarea>
						</label>
					</section>
				</fieldset>
				<footer>
					<span class="mandatory"><?php echo lang("mandatory_fields_notice"); ?></span>
					<input type="submit" name="submit" class="button" value="Reply" />
					<input type="hidden" name="message_id" value="<?php echo $message_id; ?>" />
					<input type="hidden" name="thread_id" value="<?php echo $thread_id; ?>" />
				</footer>
			<?php echo form_close();?>
		</div>
	</div>
</div>
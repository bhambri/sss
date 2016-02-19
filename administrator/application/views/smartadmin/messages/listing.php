<style>
.pagination { margin:0px;}
</style>
<div class="inbox-nav-bar no-content-padding">
	<h1 class="page-title txt-color-blueDark hidden-tablet"><i class="fa fa-fw fa-inbox"></i> Inbox
	</h1>

	<div class="btn-group hidden-desktop visible-tablet">
		<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			Inbox <i class="fa fa-caret-down"></i>
		</button>
	</div>

	<div class="inbox-checkbox-triggered">
		<div class="btn-group">
			<a href="javascript:void(0);" onclick="submitListingForm('messagesListing', '<?php echo base_url() . "messages/delete"?>','delete');" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete" class="deletebutton btn btn-default"><strong><i class="fa fa-trash-o fa-lg"></i></strong></a>
			<a href="javascript:void(0);" onclick="submitListingForm('messagesListing', '<?php echo base_url() . "messages/markread"?>','markread');" rel="tooltip" title="" data-placement="bottom" data-original-title="Mark as Read" class="deletebutton btn btn-default"><strong><i class="fa fa-envelope-o fa-lg"></i></strong></a>
		</div>
	</div>

	<a href="javascript:void(0);" id="compose-mail-mini" class="btn btn-primary pull-right hidden-desktop visible-tablet"> <strong><i class="fa fa-file fa-lg"></i></strong> </a>

	<div class="btn-group pull-right inbox-paging">
		<?php echo $pagination; ?>
	</div>
</div>
<div id="inbox-content" class="inbox-body no-content-padding">
	<div class="inbox-side-bar">
		<a href="javascript:void(0);" id="compose-mail" onclick="submitListingForm('messagesListing', '<?php echo base_url() . "messages/compose"?>','new');" class="btn btn-primary btn-block"> <strong>Compose</strong> </a>
		<ul class="inbox-menu-lg">
			<li class="active">
				<?php
					$ci = get_instance();
					$ci->load->helper('vci_common');
					$ci->load->model('mahana_model');
					$userData	= get_message_user();

					$msg_count	= $ci->mahana_model->get_msg_count($userData['user_id']);
				?>
				<a class="inbox-load" href="javascript:void(0);"> Inbox <?php echo ($msg_count>0)?'('.$msg_count.')':''; ?></a>
			</li>
		</ul>
	</div>
		
	<div class="table-wrap custom-scroll animated fast fadeInRight" style="height: 320px; opacity: 1;">
		<table id="inbox-table" class="table table-striped table-hover">
			<tbody>
				<?php echo form_open("messages/manage", array('name' => 'messagesListing', 'id' => 'messagesListing'));?>
					<?php foreach($messages as $message): ?>
						<?php if($message['status'] == MSG_STATUS_UNREAD) { ?>
							<tr id="msg<?php echo $message['thread_id']; ?>" class="unread" >
						<?php } else { ?>
							<tr id="msg<?php echo $message['thread_id']; ?>" class="read" >
						<?php } ?>
							<td class="inbox-table-icon" >
								<div class="checkbox" style="margin-top:7px;">
									<label>
										<input type="checkbox" name="messages[]" class="checkbox style-2" value="<?php echo $message['thread_id']; ?>" />
										<span></span>
									</label>
								</div>
							</td>
							<td class="inbox-data-from hidden-xs hidden-sm"  onclick="window.location.href='<?php echo base_url() . "messages/view/" . $message['thread_id']; ?>'" >
								<div>
									<?php echo $message['user_name']; ?>
								</div>
							</td>
							<td class="inbox-data-message" onclick="window.location.href='<?php echo base_url() . "messages/view/" . $message['thread_id']; ?>'" >
								<div><?php echo $message['subject']; ?></div>
							</td>
							<td class="inbox-data-attachment hidden-xs">
							</td>
							<td class="inbox-data-date hidden-xs" onclick="window.location.href='<?php echo base_url() . "messages/view/" . $message['thread_id']; ?>'">
								<div>
									<?php 
										if(date('Y-m-d') == date('Y-m-d', strtotime($message['cdate']))) {
											echo date('h:i A', strtotime($message['cdate']));
										} else {
											echo date('Y-m-d', strtotime($message['cdate']));
										}
									?>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php echo form_close(); ?>
			</tbody>
		</table>
	</div>
</div>
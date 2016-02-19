<div class="page">
  <table border="0" cellspacing="0" cellpadding="0" class="page_width">
    <tr>
      <td id="id_td_pageHeading" valign="middle"><span id="pageTitle"><?php echo ucfirst($caption);?></span></td>
    </tr>
	<!-- Errors And Message Display Row  -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('errors')): ?>
			<ul class="error_ul"><?php echo $this->session->flashdata('errors');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Errors And Message Display Row  -->
	<!-- Success And Message Display Row  -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('success')): ?>
			<ul class="success_ul"><?php echo $this->session->flashdata('success');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Success And Message Display Row  -->
    <tr>
      <td id="content_center_td" valign="top">
          <div id="content_div">
			<div id="listpage_button_bar" >
				
				<table align="left" border="0">
					<tr>
						<td class="icon_box" onclick="submitListingForm('clientListing', '<?php echo base_url() . "client/delete_client"?>','delete');">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/delete.png" alt="Delete" border="0" />
								</td>

							</tr>
							<tr>
								<td align="center" class="icon_text">
									<strong><?php echo lang('delete')?></strong>
								</td>

							</tr>
							</table>
						</td>
						<td class="icon_box" onclick="submitListingForm('clientListing', '<?php echo base_url() . "client/add"?>','new');">
						<td class="icon_box" onclick="submitListingForm('clientListing', '<?php echo base_url() . "client/add"?>','new');">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/notice2.png" alt="Delete" border="0" />
								</td>

							</tr>
							<tr>
								<td align="center">
									<strong><?php echo lang('new')?></strong>
								</td>

							</tr>
							</table>
						</td>
					</tr>
				</table>
            </div>
			<?php echo form_open("client/manage", array('name' => 'clientListing', 'id' => 'clientListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($clients)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('clientListing',this);"/></span></td>
					<td align="center" class="form_header"><span><?php echo lang('full_name')?></span></td>
					<td align="center" class="form_header"><span>Email</span></td>
					<td align="center" class="form_header"><span>Action</span></td>
					<td class="form_header"  nowrap="nowrap" align="center"><span><?php echo lang('active')?></span></td>
				</tr>
				<?php
				if(!empty($clients) && count($clients)>0):

					$rowClass = 'row1';

					foreach($clients as $client):
						
						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
				?>
				<tr class="<?php echo $rowClass?>">
					<td align="center" width="5%">
						<?php	//if($client->clientname != $this->session->clientdata['client']['clientname']):?>
								<span><input type="checkbox" name="clientids[]" value="<?php echo $client->id?>" onclick="checkMasterState('clientListing', 'masterCheckField')"/></span>
						<?php //endif; ?>
					</td>
					<td align="center"><span><a href="<?php echo base_url(). 'client/edit/id/'.$client->id; ?>"><?php echo ucwords($client->fName);?></a></span></td>
					<td align="center"><span><?php echo $client->email;?></span></td>
					<td align="center"><span>
					<a href="javascript:void(0)" onclick="setStoreSession( <?php echo $client->id;?>, '<?php echo base_url() . 'user/manage/' ?>', '<?php echo base_url();?>' )">M users</a>
					<a href="javascript:void(0)" onclick="setStoreSession( <?php echo $client->id;?>, '<?php echo base_url() . 'news/manage_news/' ?>', '<?php echo base_url();?>' )">M News</a>
	<!--				<a href="<?php echo base_url(). 'user/manage/'. $client->id; ?>">M users</a>
-->
					</span></td>
					<td nowrap="nowrap" align="center">
					<?php $status = 1;
					if ( $client->status == 1 )
					    $status = 0;
					$statusLink = base_url() . "client/update_status/" . $client->id . "/" . $status . "/" . $this->uri->segment(3); ?>
						<?php if($client->status == 1):?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
						<?php else: ?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
						<?php endif; ?>
					<?php //endif; ?>
					</td>
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="7" align='center' ><strong><?php echo lang('clients_not_found')?></strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="10" align="center">
						<?php echo $pagination?>
					</td>
				</tr>
            </table>
			<?php echo form_close(); ?>
          </div>
        </td>
    </tr>
  </table>

</div>

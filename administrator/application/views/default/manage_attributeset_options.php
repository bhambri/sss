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
						<td class="icon_box" <?php if(empty($attributeset_options)) { ?> onclick="alert('No record for delete');" <?php }else { ?>onclick="submitListingForm('clientListing', '<?php echo base_url() . "attributesets/delete_option"?>','delete');" <?php } ?>>
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
						<td class="icon_box" onclick="submitListingForm('clientListing', '<?php echo base_url() . "attributesets/option_add"?>','new');">
						<td class="icon_box" onclick="submitListingForm('clientListing', '<?php echo base_url() . "attributesets/option_add"?>','new');">
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
			<?php echo form_open("attributesets/manage_options", array('name' => 'clientListing', 'id' => 'clientListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" ><span><input <?php if(empty($attributeset_options)) { echo "disabled"; }?> type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('clientListing',this);"/></span></td>
					<td align="center" class="form_header"><span>Option Name <?php #echo lang('full_name')?></span></td>
					<td class="form_header"  nowrap="nowrap" align="center"><span> Field Type<?php #echo lang('active')?></span></td>
					<!-- <td class="form_header"  nowrap="nowrap" align="center"><span> Field Options </span></td> -->
				</tr>
				<?php
				if(!empty($attributeset_options) && count($attributeset_options)>0):

					$rowClass = 'row1';

					foreach($attributeset_options as $attributeset_option):
						
						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
						#echo '<pre>';
						#print_r($attributeset_option);

				?>
				<tr class="<?php echo $rowClass?>">
					<td align="center" width="5%">
								<span><input type="checkbox" name="ids[]" value="<?php echo $attributeset_option->id?>" onclick="checkMasterState('clientListing', 'masterCheckField')"/></span>
					</td>
					<td align="center"><span><a href="<?php echo base_url(). 'attributesets/option_edit/id/'.$attributeset_option->id; ?>"><?php echo ucwords($attributeset_option->field_label);?></a></span></td>
					<td nowrap="nowrap" align="center">
					<?php echo $attributeset_option->field_type ;?>
					<!-- <?php $status = 1;
					if ( $attributeset_option->status == 1 )
					    $status = 0;
					$statusLink = base_url() . "attributesets/update_opt_status/" . $attributeset_option->id . "/" . $status . "/" . $this->uri->segment(3); ?>
						<?php if($attributeset_option->status == 1):?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
						<?php else: ?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
						<?php endif; ?>
					<?php //endif; ?>
					-->
					</td>
					<!-- <td>
						<?php echo 'No options'; ?>
					</td> -->
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="7" align='center' ><strong> No options added yet <?php #echo lang('subcat_not_found')?></strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="10" align="center">
						<?php echo $pagination?>
					</td>
				</tr>
				<tr>
					<!-- <td colspan="3" align="center"><input type="button" value="Back" class="button" onclick="javascript:history.back();"/></td> -->

					<td colspan="4" align="center">
					<input type="button" value="Back" class="button" onclick="javascript: window.location.href='<?php echo base_url(); ?>attributesets/manage';" /></td>
				</tr>
            </table>
			<?php echo form_close(); ?>
          </div>
        </td>
    </tr>
  </table>
</div>
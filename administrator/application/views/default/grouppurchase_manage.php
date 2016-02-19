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
				<?php echo form_open('subcategory/manage',array('name'=>'search', 'id'=>'search'));?>
				<table align="right"  border="0" style="display:none;">
					<tr>
						<td style="padding: 0px 7px 0px 7px;">
							<fieldset class="fieldset">
								<legend><?php echo lang('search')?></legend>
								<div style="margin: 5px;">
								  <input type="text" name="s" id="s" class="inputbox" value="<?php echo form_prep($this->input->get_post('s'));?>" style="margin-bottom:2px;" size="30" />
								  &nbsp;
								  <input type="submit" value="<?php echo lang('btn_search')?>" name="submit" class="button" style="margin-bottom: 2px;" />
								  <br/>
								  <?php echo lang('client_search_instructions');?>
								</div>
							</fieldset>
						</td>
					</tr>
				</table>
				<?php echo form_close();?>
				<table align="left" border="0">
					<tr>
						<td class="icon_box" onclick="submitListingForm('clientListing', '<?php echo base_url() . "grouppurchase/delete"?>','delete');">
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
						<?php 

						$userDetails = $this->session->userdata('user') ;
						//echo '<pre>';
						//print_r($userDetails) ;
						if(isset($userDetails['role_id']) && (($userDetails['role_id'] != 2) && ($userDetails['role_id'] != 1)) ){
						
						?>
						<td class="icon_box" onclick="submitListingForm('clientListing', '<?php echo base_url() . "grouppurchase/add"?>','new');">
						<td class="icon_box" onclick="submitListingForm('clientListing', '<?php echo base_url() . "grouppurchase/add"?>','new');">
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
						<?php } ?>
						<?php 
						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{
						?>
						<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">   
                                    <?php 
                                    	//echo $this->session->userdata('storeId');
                                    	//echo '<br />'.$this->session->userdata('consultantId')
                                    ?>
                                    <select name="adminid" id="adminid" onchange="setStoreConsultantSession(this.value, '<?php echo base_url() . 'grouppurchase/manage/' ?>', '<?php echo base_url();?>' )">
                                        <option value="0">--Display All--</option>
                                        <?php foreach ( $clients_consultant as $cc ) 
                                        {?>
                                        <option value="<?php echo $cc['id'];?>|0" <?php if( $this->session->userdata('storeId') == $cc['id'] ) { echo 'selected="selected"'; } ?> ><?php echo ucwords( $cc['name'] ); ?></option>
                                        <?php 
                                        	if( !empty( $cc['consultant'] ) )
                                        	{
                                        		foreach ( $cc['consultant'] as $con) 
                                        		{
	                                        ?>
	                                        	<option value="<?php echo $cc['id'].'|'.$con['id'];?>" <?php if( $this->session->userdata('consultantId') == $con['id'] && $this->session->userdata('storeId') == $cc['id'] ) { echo 'selected="selected"'; } ?> >--<?php echo ucwords( $con['username'] ); ?></option>
	                                        <?php			
                                        		}
                                         		
                                        	}

                                        ?>	

                                        <?php }
                                       
                                        ?>
                                    </select>	
                                    
								</td>
								
							</tr>
							<tr>
								<td align="center">
									Select to view the news
								</td>
								
							</tr>
							</table>
						</td>
						<?php 
						}?>	

					</tr>
				</table>
            </div>
			<?php echo form_open("subcategory/manage", array('name' => 'clientListing', 'id' => 'clientListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($groups)) { echo "disabled"; }?>  name="masterCheckField" id="masterCheckField" onclick="checkAll('clientListing',this);"/></span></td>
					<td align="center" class="form_header"><span>Party Name</span></td>
<td align="center" class="form_header"><span>Host username</span></td>
					<td align="center" class="form_header"><span>Party Code</span></td>
					<td align="center" class="form_header"><span>Start Date</span></td>
					<td align="center" class="form_header"><span>End Date</span></td>
					<td align="center" class="form_header"><span><?php echo lang('active')?></span></td>
					<td class="form_header"  nowrap="nowrap" align="center"><span>Action</span></td>
				</tr>
				<?php
				if(!empty($groups) && count($groups)>0):

					$rowClass = 'row1';

					foreach($groups as $group):
						
						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
						//print_r($group);
				?>
				<tr class="<?php echo $rowClass?>">
					<td align="center" width="5%">
								<span><input type="checkbox" name="ids[]" value="<?php echo $group->id?>" onclick="checkMasterState('clientListing', 'masterCheckField')"/></span>
					</td>
					<td align="center"><span><a href="<?php echo base_url(). 'grouppurchase/edit/id/'.$group->id; ?>"><?php echo ucwords($group->name);?></a></span></td>
<td align="center"><span><?php echo $group->username;?></span></td>

					<td align="center"><span><?php echo $group->group_event_code;?></span></td>
					<td align="center"><span><?php echo $group->start_date;?></span></td>
					<td align="center"><span><?php echo $group->end_date;?></span></td>
					<td align="center">
					<?php $status = 1;
					if ( $group->status == 1 )
					    $status = 0; 
					 $statusLink = base_url() . "grouppurchase/update_status/" . $group->id . "/" . $status . "/" . $this->uri->segment(3); ?>
						<?php if($group->status == 1):?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
						<?php else: ?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
						<?php endif; ?>
					<?php //endif; ?>
					</td>
					<td nowrap="nowrap" align="center">
						<span>
							<a href="<?php echo base_url().'sales/grouppurchase?page=&store_id='.$group->store_id.'&group_code='.$group->id.'&from_date=&to_date=' ?>">View Sales</a>
						</span>
					</td>
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="6" align='center' ><strong><?php echo lang('group_purchase_not_found')?></strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="6" align="center">
						<?php echo $pagination?>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="6">
						<input type="button" 
						<?php 
						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{
						?>
						onclick="javascript: window.location.href='<?php echo base_url().'admin/desktop';?>';" 
						<?php 
						}
						else if(isset($consultant_role_id) && $consultant_role_id==4)
						{
						?>
							onclick="javascript: window.location.href='<?php echo base_url().'consultant/desktop';?>';"
						<?php
						}
						else
						{
						?>
						onclick="javascript: window.location.href='<?php echo base_url().'client/desktop';?>';"	
						<?php
						}
						?>
						class="button" value="Back">
					</td>
				</tr>
            </table>
			<?php echo form_close(); ?>
          </div>
        </td>
    </tr>
  </table>

</div>

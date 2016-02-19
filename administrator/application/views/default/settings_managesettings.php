<div class="page">
  <table border="0" cellspacing="0" cellpadding="0" class="page_width">
    <tr>
      <td id="id_td_pageHeading" valign="middle"><span id="pageTitle"><?php echo ucfirst($caption);?></span></td>
    </tr>
	<!-- Errors And Message Display Row < -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('errors')): ?>
			<ul class="error_ul"><?php echo $this->session->flashdata('errors');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Errors And Message Display Row > -->
	<!-- Success And Message Display Row < -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('success')): ?>
			<ul class="success_ul"><?php echo $this->session->flashdata('success');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Success And Message Display Row > -->
    <tr>
      <td id="content_center_td" valign="top">
          <div id="content_div">
			<div id="listpage_button_bar" >
				
				<table align="left" border="0">
					<tr>
						<td class="icon_box" onclick="submitListingForm('settingsListing', '<?php echo base_url() . "settings/delete_settings"?>','delete');">
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
						 
						 if( $this->session->userdata('settingsExists') == false )
						 { ?>
						  <td class="icon_box" onclick="submitListingForm('settingsListing', '<?php echo base_url() . "settings/add_settings"?>','new');">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/notice2.png" alt="Add" border="0" />
								</td>
								
							</tr>
							<tr>
								<td align="center">
									<strong><?php echo lang('new')?></strong>
								</td>
								
							</tr>
							</table>
						</td>
						<?php 
						}
						?>
						
						<?php 

						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{
						  $nametodisplay = 'Administrator';  
						?>
						<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">   
                                    <select style="display:none;" name="adminid" id="adminid" onchange="setRoleAndUserIdSession(this.value, '<?php echo base_url() . 'settings/manage_settings/' ?>', '<?php echo base_url();?>' )">
                                        <option value="1||||1">--Administrator--</option>
                                        <?php foreach ( $clients as $client ) 
                                        {?>
                                        <option value="<?php echo $client->role_id.'||||'.$client->id;?>" 
                                            <?php if( ( $this->session->userdata('userId') == $client->id ) && ( $this->session->userdata('roleId') == $client->role_id )  ) 
                                            {
                                                echo 'selected="selected"'; 
                                                $nametodisplay = $client->fName;
                                            } ?> ><?php echo $client->fName; ?></option>
                                        <?php }?>
                                    </select>
                                    
                                    <select name="adminid" id="adminid" onchange="setRoleAndUserIdSession(this.value, '<?php echo base_url() . 'settings/manage_settings/' ?>', '<?php echo base_url();?>' )">
                                        <option value="1||||1">--Administrator--</option>
                                        <?php foreach ( $clients_consultant as $cc ) 
                                        {?>
                                        <option value="<?php echo $cc['role_id'];?>||||<?php echo $cc['id'];?>" <?php if( $this->session->userdata('userId') == $cc['id'] && $this->session->userdata('roleId') == 2 ) { echo 'selected="selected"'; $nametodisplay = $cc['name']; } ?> ><?php echo ucwords( $cc['name'] ); ?></option>
                                        <?php 
                                        	if( !empty( $cc['consultant'] ) )
                                        	{
                                        		foreach ( $cc['consultant'] as $con ) 
                                        		{
	                                        ?>
	                                        	<option value="<?php echo $con['role_id'].'||||'.$con['id'];?>" <?php if( $this->session->userdata('userId') == $con['id'] && $this->session->userdata('roleId') == 4 ) { echo 'selected="selected"'; $nametodisplay = $con['username']; } ?> >--<?php echo ucwords( $con['username'] ); ?></option>
	                                        <?php			
                                        		}
                                         		
                                        	}

                                        ?>	

                                        <?php }?>
                                    </select>	
                                    
                                    
								</td>
								
							</tr>
							<tr>
								<td align="center">
									Select to view the categories
								</td>
								
							</tr>
							</table>
						</td>
						<?php 
						}else{
							$nametodisplay = $this->session->userdata['user']['username'] ;
						}

						?>
						
						
						
						
					</tr>
				</table>
				</div>
			<?php echo form_open("settings/manage_settings", array('name' => 'settingsListing', 'id' => 'settingsListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" ><span><input type="checkbox"  <?php if(empty($content)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('settingsListing',this);"/></span></td>
					<td align="center" class="form_header"><span>Name</span></td>
					<td align="center" class="form_header"><span>Logo Image</span></td>
					
					
					<td align="center" class="form_header"><span>Settings</span></td>
					<td align="center" class="form_header"><span>Status</span></td>
					<td align="center" class="form_header"><span>Created</span></td>
					
				</tr>
				<?php
				
				if($content):
					$rowClass = 'row1';

					foreach($content as $banner):
						//echo '<pre>';print_r($banner);echo '</pre>';
						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
				?>
				<tr class="<?php echo $rowClass?>">
					<td align="center" width="5%"><span><input type="checkbox" name="pageids[]" value="<?php echo $banner->id?>" onclick="checkMasterState('settingsListing', 'masterCheckField')"/></span></td>
					<td align="center"><?php echo $nametodisplay; ?></td>
					<td align="center"><span><?php //echo $banner->logo_image;?></span>
					<?php $settings = array('w'=>100,'h'=>100,'crop'=>true);
						 $image = $_SERVER['DOCUMENT_ROOT'].'/' . $banner->logo_image;
						
					?>
						<a href="<?php echo base_url()?>settings/edit_settings/<?php echo $banner->id;?>" ><img src="<?php echo image_resize( $image, $settings)?>" border='0' /></a></span>
					</td>
					<?php if(isset($banner->role_id) && (($banner->role_id ==4 ) || ($banner->role_id ==1 ))){ ?>
					<td align="center"><span><a href="<?php echo base_url()?>settings/edit_settings/<?php echo $banner->id;?>">Logo & Social Media</a></span></td>
					
					<?php } else{ ?>			
					
                    <td align="center"><span><a href="<?php echo base_url()?>settings/edit_settings_paypal/<?php echo $banner->id;?>" >Paypal</a> | <a href="<?php echo base_url()?>settings/edit_settings_meritus/<?php echo $banner->id;?>" > Meritus </a> | <a href="<?php echo base_url()?>settings/edit_settings_avatax/<?php echo $banner->id;?>">AvaTax settings</a>|<a href="<?php echo base_url()?>settings/testavatax_connection/<?php echo $banner->id;?>"> Test AvaTax</a> | <a href="<?php echo base_url()?>settings/edit_settings/<?php echo $banner->id;?>">Logo & Social Media</a></span></td>
                    <?php } ?>		
					<td align="center"><span></span>
						<?php 
						$statusLink = base_url() . "settings/update_status/" . $banner->id . "/" . $banner->status . "/";// . $this->uri->segment(3);?>
						<?php if($banner->status == 1):?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
						<?php else: ?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
						<?php endif; ?>
					</td>
					<td align="center">
						<span>
							<?php 
								$date = strtotime($banner->created);
								echo date("M,d Y",$date);
							?>
						
						</span>
					</td>
					

				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="7" align='center' ><strong>No settings records Found.</strong></td>
				</tr>
				<?php endif;?>
				<?php if($content){?>
					<?php 
						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{ ?>
					<tr>
						 <td colspan="10" align="center">
							<?php #cho $pagination ; ?>
						</td>
					</tr>
				<?php } ?>
				<?php }?>
				
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
  <script  type="text/javascript" src="includes/script/boxover.js" ></script>
</div>
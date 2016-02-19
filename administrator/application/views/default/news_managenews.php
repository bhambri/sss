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
				<?php 
				if( isset( $this->session->userdata['user']['is_admin'] ) ) 
				{
				?>
					<script type="text/javascript">
					function validate_store_selection()
					{
						var vss = document.getElementById("adminid").value;
		
						if( vss==null || vss==0 || vss=='0' )
						{
							//alert("Please select store/client");
							submitListingForm('newsListing', '<?php echo base_url() . "news/add_news"?>','new');
							//return false;
						}
						else
						{
							submitListingForm('newsListing', '<?php echo base_url() . "news/add_news"?>','new');
						}
					}
					</script>
				<?php 
				}
				?>
				
				<table align="left" border="0">
					<tr>
						<td class="icon_box" onclick="submitListingForm('newsListing', '<?php echo base_url() . "news/delete_news"?>','delete');">
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
						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{
						?>
						<td class="icon_box" onclick="return validate_store_selection();">
						<?php 
						}
						else
						{
						?>
						<td class="icon_box" onclick="submitListingForm('newsListing', '<?php echo base_url() . "news/add_news"?>','new');">
						<?php
						}
						?>
						  
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
						// added for client section dropdown starts here

						if(isset($this->session->userdata['user']['role_id']) && ($this->session->userdata['user']['role_id'] == 2)){
							
							$storeid = $this->session->userdata['user']['id'] ;
							foreach ($clients_consultant as $cvalue) { ?>
                                
								<?php
								
								#pr($cvalue) ;

								if($cvalue['id'] == $storeid){
								?>
								<select name="adminid" id="adminid" onchange="setStoreConsultantSession(this.value, '<?php echo base_url() . 'news/manage_news' ?>', '<?php echo base_url();?>' )">
								     <option value="<?php echo $cvalue['id'];?>|0" <?php if( $this->session->userdata('storeId') == $cvalue['id'] ) { echo 'selected="selected"'; } ?> ><?php echo ucwords( $cvalue['name'] ); ?></option>

								<?php
									#pr($cvalue) ;
									if( !empty( $cvalue['consultant'] ) ){
										foreach ( $cvalue['consultant'] as $con){
											?>
											<option value="<?php echo $cvalue['id'].'|'.$con['id'];?>" <?php if( $this->session->userdata('consultantId') == $con['id'] ) { echo 'selected="selected"'; } ?> >--<?php echo ucwords( $con['username'] ); ?></option>
										<?php
										} 
									} ?>
									</select>
								<?php } ?>
									
							<?php
							}
							#pr($clients_consultant) ;
						}
						// added for client section dropdown ends here

						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{
						?>
						<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">   
                                    <select style="display:none;" name="adminid" id="adminid" onchange="setStoreSession(this.value, '<?php echo base_url() . 'news/manage_news/' ?>', '<?php echo base_url();?>' )">
                                        <option value="0">--Administrator--</option>
                                        <?php foreach ( $clients as $client ) 
                                        {?>
                                        <option value="<?php echo $client->id;?>" <?php if( $this->session->userdata('storeId') == $client->id ) { echo 'selected="selected"'; } ?> ><?php echo $client->fName; ?></option>
                                        <?php }?>
                                    </select>
                                    <?php 
                                    	//echo $this->session->userdata('storeId');
                                    	//echo '<br />'.$this->session->userdata('consultantId')
                                    ?>
                                    <select name="adminid" id="adminid" onchange="setStoreConsultantSession(this.value, '<?php echo base_url() . 'news/manage_news/' ?>', '<?php echo base_url();?>' )">
                                        <option value="0">--Administrator--</option>
                                        <?php foreach ( $clients_consultant as $cc ) 
                                        {?>
                                        <option value="<?php echo $cc['id'];?>|0" <?php if( $this->session->userdata('storeId') == $cc['id'] ) { echo 'selected="selected"'; } ?> ><?php echo ucwords( $cc['name'] ); ?></option>
                                        <?php 
                                        	if( !empty( $cc['consultant'] ) )
                                        	{
                                        		foreach ( $cc['consultant'] as $con) 
                                        		{
	                                        ?>
	                                        	<option value="<?php echo $cc['id'].'|'.$con['id'];?>" <?php if( $this->session->userdata('consultantId') == $con['id'] ) { echo 'selected="selected"'; } ?> >--<?php echo ucwords( $con['username'] ); ?></option>
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
			<?php echo form_open("news/manage_news", array('name' => 'newsListing', 'id' => 'newsListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" ><span><input type="checkbox" <?php if(empty($content)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('newsListing',this);"/></span></td>
					<td align="center" class="form_header"><span>Title</span></td>
					<td align="center" class="form_header"><span>Short Description</span></td>
					<td align="center" class="form_header"><span>Status</span></td>
					<td align="center" class="form_header"><span>Created</span></td>
				</tr>
				<?php
				
				if($content):
					$rowClass = 'row1';

					foreach($content as $page):
						
						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
				?>
				<tr class="<?php echo $rowClass?>">
					<td align="center" width="5%"><span><input type="checkbox" name="pageids[]" value="<?php echo $page->id?>" onclick="checkMasterState('newsListing', 'masterCheckField')"/></span></td>
					<td align="center" ><span><a href="<?php echo base_url()?>news/edit_newsnew/<?php echo $page->id;?>" ><?php echo wrapstr($page->page_title);?></a></span></td>
					<td align="center"><span><?php echo wrapstr($page->page_shortdesc);?></span></td>
					
					<td align="center"><span></span>
						<?php $statusLink = base_url() . "news/update_status/" . $page->id . "/" . $page->status . "/" . $this->uri->segment(3)?>
						<?php if($page->status == 1):?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
						<?php else: ?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
						<?php endif; ?>
					</td>
					<td align="center">
						<span>
							<?php 
								$date = strtotime($page->created);
								echo date("m/d/Y",$date);
							?>
						
						</span>
					</td>

				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="5" align='center' ><strong>No News records Found.</strong></td>
				</tr>
				<?php endif;?>
				<?php if($content){?>
					<tr>
						 <td colspan="5" align="center">
							<?php echo $pagination?>
						</td>
					</tr>
				<?php }?>
				
				<tr>
					<td colspan="5" align="center">
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
						class="button" value="Back" />
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


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
          	<!-- drop down plus menus blocks starts here -->
          	<div id="listpage_button_bar">
          		<table align="left" border="0">
					<tr>
						
						
						
						<?php 
						// added for client section dropdown starts here

						if(isset($this->session->userdata['user']['role_id']) && ($this->session->userdata['user']['role_id'] == 2)){
							
							$storeid = $this->session->userdata['user']['id'] ;
							foreach ($clients_consultant as $cvalue) { ?>
                                
								<?php
								if($cvalue['id'] == $storeid){
								?>
								<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">   
								<select name="adminid" id="adminid" onchange="setStoreConsultantSession(this.value, '<?php echo base_url() . 'order/manage/' ?>', '<?php echo base_url();?>' )">
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
										</td>
								
							</tr>
							<tr>
								<td align="center">
									Select to view the orders
								</td>
								
							</tr>
							</table>
						</td>
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
                                    <select  style="display:none;" name="adminid" id="adminid" onchange="setStoreSession(this.value, '<?php echo base_url() . 'order/manage/' ?>', '<?php echo base_url();?>' )">
                                        <option value="0">--Administrator--</option>
                                        <?php foreach ( $clients as $client ) 
                                        {?>
                                        <option value="<?php echo $client->id;?>" <?php if( $this->session->userdata('storeId') == $client->id ) { echo 'selected="selected"'; } ?> ><?php echo $client->username; ?></option>
                                        <?php }?>
                                    </select>

                                    <select name="adminid" id="adminid" onchange="setStoreConsultantSession(this.value, '<?php echo base_url() . 'order/manage/' ?>', '<?php echo base_url();?>' )">
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
									Select to view the orders
								</td>
								
							</tr>
							</table>
						</td>
						<?php 
						}?>
						
						<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
								<tr>
									<td align="center"> 
										Total: <b>
													<?php 
													//$total = $orders_all_sum[0]->sum_order_amount+$orders_all_sum[0]->sum_tax+$orders_all_sum[0]->sum_shipping;
													$total = $orders_all_sum[0]->sum_order_amount ;

													echo "$".$total; 
													?>
												</b>		
									</td>
								</tr>
								<tr>
									<td align="center"> 
										(Total of order amount only)		
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
          	</div>  <!-- drop down plus menus blocks ends here -->
          		
			<?php echo form_open("order/manage", array('name' => 'orderListing', 'id' => 'orderListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header"><span>Order Id</span></td>
					<td align="center" class="form_header"><span>Store Name</span></td>
					<td align="center" class="form_header"><span><?php echo  $this->consultant_label ; ?> Name</span></td>
					<td align="center" class="form_header"><span>Buyer Name</span></td>
					<td align="center" class="form_header"><span>Transaction Id</span></td>
					<td align="center" class="form_header"><span>Order Amount</span></td>
					<td align="center" class="form_header"><span>Action</span></td>
				</tr>
				<?php
				if( !empty( $orders ) && count( $orders ) > 0 ):
					$rowClass = 'row1';
					foreach( $orders as $order ):						
						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
				?>
				<tr class="<?php echo $rowClass?>">
					<td align="center"><span><?php echo $order->id;?></span></td>
					<td align="center"><span><?php echo ucwords($order->store_name);?></span></td>
					<td align="center"><span><?php if(trim($order->consultant_username)!='') { echo ucwords($order->consultant_username); } else { echo "NA"; }?></span></td>
					<td align="center"><span><?php echo ucwords($order->buyer);?></span></td>
					<td align="center"><span><?php echo ucwords($order->transaction_id);?></span></td>
					<td align="center"><span>$<?php echo ucwords($order->order_amount);?></span></td>
					<td align="center"><span><a href="<?php echo base_url(). 'order/view/id/'.ucwords($order->transaction_id); ?>">View order</a></span></td>
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="6" align='center' ><strong><?php echo lang('orders_not_found')?></strong></td>
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
<?php

//echo "Its working"; die;
?>
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
			<?php 
				#pr($content) ;
			?>
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
			
			<?php echo form_open("shipping/manage_shipping", array('name' => 'shippingListing', 'id' => 'shippingListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<!-- <td align="center" class="form_header" ><span><input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('shippingListing',this);"/></span></td> -->
					<td align="center" class="form_header"><span>Shipping State</span></td>
					<td align="center" class="form_header"><span>State Code</span></td>

					<td align="center" class="form_header"><span>Cost(<= 500 g)</span></td>
					<td align="center" class="form_header"><span>Cost(501 to 1000g)</span></td>
					<td align="center" class="form_header"><span>Cost(1001 to 1500 g)</span></td>
					<td align="center" class="form_header"><span>Cost(1501 g to 2000g)</span></td>
					<td align="center" class="form_header"><span>Cost(2001g and above)</span></td>

					<!-- <td align="center" class="form_header"><span>Status</span></td> -->
					<td align="center" class="form_header"><span>Action</span></td>
				</tr>
				<?php
				
				if($content):
					$rowClass = 'row1';

					foreach($content as $shipping_states):
						//echo '<pre>';print_r($banner);echo '</pre>';
						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
						#pr($shipping_states);

				?>
				<tr><?php
					
					
				?></tr>
				 
				<tr class="<?php echo $rowClass?>">
					<!-- <td align="center" width="5%"><span><input type="checkbox" name="pageids[]" value="<?php echo $banner->id?>" onclick="checkMasterState('shippingListing', 'masterCheckField')"/></span></td> -->
					<td align="center"><span><?php echo $shipping_states->state;?></span></td>
					<td align="center" ><span><a href="<?php if($shipping_states->id){ ?><?php echo base_url()?>shipping/edit_shipping/<?php echo $shipping_states->id;?>/<?php echo base64_encode($shipping_states->state); ?><?php }else{  ?><?php echo base_url()?>shipping/add_shipping/<?php echo base64_encode($shipping_states->state);?>/<?php echo base64_encode($shipping_states->state_code); ?> <?php } ?>" ><?php echo wrapstr($shipping_states->state_code);?></a></span></td>
					<td align="center"><span><?php echo $shipping_states->w1 ? $shipping_states->w1 :'NA' ;?></span></td>
					<td align="center"><span><?php echo $shipping_states->w2 ? $shipping_states->w2 :'NA';?></span></td>
					<td align="center"><span><?php echo $shipping_states->w3 ? $shipping_states->w3 :'NA';?></span></td>
					<td align="center"><span><?php echo $shipping_states->w4 ? $shipping_states->w4 :'NA';?></span></td>
					<td align="center"><span><?php echo $shipping_states->w5 ? $shipping_states->w5 :'NA';?></span></td>
					<td align="center" ><span><a href="<?php if($shipping_states->id){ ?><?php echo base_url()?>shipping/edit_shipping/<?php echo $shipping_states->id;?>/<?php echo base64_encode($shipping_states->state); ?><?php }else{  ?><?php echo base_url()?>shipping/add_shipping/<?php echo base64_encode($shipping_states->state);?>/<?php echo base64_encode($shipping_states->state_code); ?> <?php } ?>" ><?php echo $shipping_states->id ? 'Edit': 'Add' ;?></a></span></td>
					

				</tr> 
				
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="7" align='center' ><strong>No shipping records Found.</strong></td>
				</tr>
				<?php endif;?>
				<?php if($content){?>
					<tr>
						 <td colspan="10" align="center">
							<?php echo $pagination?>
						</td>
					</tr>
				<?php }?>
				<tr>
					<td colspan="7" align="center">
						<input  type="button" 
						
						<?php 
						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{
						?>
						onclick="javascript: window.location.href='<?php echo base_url().'admin/desktop';?>';" 
						<?php 
						}
						else
						{
						?>
						onclick="javascript: window.location.href='<?php echo base_url().'client/desktop';?>';"	
						<?php
						}
						?>
						
						value="Back" class="button" />
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

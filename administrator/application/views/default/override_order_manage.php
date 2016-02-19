 <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
 <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
$(function() {
$( "#from_date,#to_date" ).datepicker(
		{dateFormat: 'yy-mm-dd' }
		);

});
</script>
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
						<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">   
                                    <select name="consid" id="consid" onchange="setSessionConsSalesReport(this.value, '<?php echo base_url() . 'override_order/override_order_manage/' ?>', '<?php echo base_url();?>' )">
                                        <option value="all">Select <?php echo $this->consultant_label ; ?></option>
                                        <?php 
                                        foreach ($consultant as $cons)
                                        {
                                        ?>
                                        <option value="<?php echo $cons->id; ?>" <?php if( $this->session->userdata('consultant_user_id') == $cons->id) { echo "selected=selected"; }?>><?php echo $cons->username; ?></option>
                                    	<?php 
                                        }
                                    	?>
                                    </select>
								</td>
								<td>
									<?php $checked = $this->session->userdata('consultant_include_paid')  ; ?>
									<label>Include Paid items </label><input type="checkbox" name="includepaiditems"  <?php if($checked == 1){ ?> checked <?php } ?> onchange="setSessionIncludePayItems(this.checked, '<?php echo base_url() . 'override_order/override_order_manage/' ?>', '<?php echo base_url();?>' )"  />
								</td>
							</tr>
							<tr>
								<td align="center">
									Select <?php echo $this->consultant_label ; ?> to view the Commission Order Report
								</td>
							</tr>
							</table>
						</td>
						<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">   
                                    <select name="adminid" id="adminid" onchange="setSessionSalesReportDuration(this.value, '<?php echo base_url() . 'override_order/override_order_manage/' ?>', '<?php echo base_url();?>' )">
                                        <option value="all">Select Duration</option>
                                        <option value="week" <?php if( $this->session->userdata('sales_report_duration') == "week") { echo "selected=selected"; }?>>Current Week</option>
                                        <option value="month" <?php if( $this->session->userdata('sales_report_duration') == "month") { echo "selected=selected"; }?>>Current Month</option>
                                        <option value="year" <?php if( $this->session->userdata('sales_report_duration') == "year") { echo "selected=selected"; }?>>Current Year</option>
                                    </select>
								</td>
								
							</tr>
							<tr>
								<td align="center">
									Select duration to view the Commission Order Report
								</td>
							</tr>
							</table>
						</td>
						<td class="icon_box">
							<?php echo form_open("override_order/override_order_manage",array( 'method'=>'GET' , 'name' => 'memberListing', 'id' => 'memberListing'));?>
							<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
							
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">   
                                    From: <input type="text" name="from_date" id="from_date" value="<?php echo @$fromdate ;?>"/>
								</td>
							</tr>
							<tr>
								<td align="center">   
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To: <input type="text" name="to_date" id="to_date" value="<?php echo @$todate ?>"/>
								</td>
							</tr>
							<tr>
								<td align="right">   
                                    <input type="submit" name="submit" id="submit" value="Filter" />
								</td>
							</tr>
							<tr>
								<td align="center">
									Select dates to view the Commission Order Report
								</td>
							</tr>
							</table>
							<?php echo form_close(); ?>
							<!-- </form>  -->
						</td>
						<td>
							Total Sum: $<?php echo	money_format('%.2n',$reportsum[0]['sum_commision_amount']); ?>
						</td>
					</tr>
				</table>
				</div>
			<div id="listpage_button_bar" >
				
				<table align="left" border="0">
					<tr>
						<td class="icon_box" onclick="submitListingForm('overrideOrderListing', '<?php echo base_url() . "override_order/markstatus"?>','markpaid');">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/notice2.png" alt="Mark Paid" border="0" />
								</td>
							</tr>
							<tr>
								<td align="center" class="icon_text">
									<strong><?php echo 'Mark Paid';?></strong>
								</td>
								
							</tr>
							</table>
						</td>
						
					</tr>
				</table>
            </div>
			<?php echo form_open("override_order/override_order_manage", array('name' => 'overrideOrderListing', 'id' => 'overrideOrderListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<!-- td align="center" class="form_header" ><span><input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('executiveListing',this);"/></span></td-->
					<td align="center" class="form_header"><span><input type="checkbox" <?php if(empty($override_order_data)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('overrideOrderListing',this);"/></span></td>
					<td align="center" class="form_header"><span><?php echo $this->consultant_label ; ?> Name</span></td>
					<td align="center" class="form_header"><span><?php echo $this->consultant_label ; ?> Generational Level</span></td>
					<td align="center" class="form_header"><span>Commission Percentage</span></td>
					<td class="form_header"  nowrap="nowrap" align="center"><span>Commission Amount</span></td>
					<td class="form_header"  nowrap="nowrap" align="center"><span>Payment Status</span></td>
					<td class="form_header"  nowrap="nowrap" align="center"><span>Action</span></td>
				</tr>
				<?php
				if(!empty($override_order_data) && count($override_order_data)>0):
				

					$rowClass = 'row1';

					foreach($override_order_data as $override_order):
						#hide the super admin username always
					/*	if($user->username == "admin")
							continue;*/

						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}
				?>
				<tr class="<?php echo $rowClass?>">
					<!-- td align="center" width="5%">
						<?php	//if($user->username != $this->session->userdata['user']['username']):?>
								<span><input type="checkbox" name="executiveids[]" value="<?php echo $executive->id?>" onclick="checkMasterState('executiveListing', 'masterCheckField')"/></span>
						<?php //endif; ?>
					</td-->
					<td align="center" width="5%">
						<?php	//if($user->username != $this->session->userdata['user']['username']):?>
								<span><input type="checkbox" name="override_order[]" value="<?php echo $override_order->id?>" onclick="checkMasterState('overrideOrderListing', 'masterCheckField')"/></span>
						<?php //endif; ?>
					</td>
					<td align="center">
						<span>
							<?php echo $override_order->username; ?>
						</span>
					</td>
					<td align="center">
						<span>
							<?php echo $override_order->consultant_genration_level;?>
						</span>
					</td>
					<td align="center">
						<span>
							<?php echo $override_order->commision_percentage;?>
						</span>
					</td>
					<td align="center">
						<span>
							<?php echo "$".$override_order->commision_amount;?>
						</span>
					</td>
					<td align="center">
						<span>
							<?php  if($override_order->pay_status != 0){
									echo 'Paid' ;
								}else{
									echo 'Not paid' ;
								}

								?>
						</span>
					</td>
					<td align="center">
						<span>
							<?php $statusLink = base_url() . "override_order/changestatus/" . $override_order->id . "/" . $override_order->pay_status . "/" . $this->uri->segment(3)?>

							<?php  if($override_order->pay_status != 0){ ?>
									<a href="<?php echo $statusLink;?>">Mark not paid</a>
							<?php }else{ ?>
								    <a href="<?php echo $statusLink;?>">Mark paid</a> 
							<?php	} ?>
						</span>
					</td>
					
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="7" align='center' ><strong><?php echo lang('override_order_not_found')?></strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="7" align="center">
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

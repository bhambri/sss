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
                                    <select name="adminid" id="adminid" onchange="setSessionSalesReportDuration(this.value, '<?php echo base_url() . 'sales/manage/' ?>', '<?php echo base_url();?>' )">
                                        <option value="all">Select Duration</option>
                                        <option value="week" <?php if( $this->session->userdata('sales_report_duration') == "week") { echo "selected=selected"; }?>>Current Week</option>
                                        <option value="month" <?php if( $this->session->userdata('sales_report_duration') == "month") { echo "selected=selected"; }?>>Current Month</option>
                                        <option value="year" <?php if( $this->session->userdata('sales_report_duration') == "year") { echo "selected=selected"; }?>>Current Year</option>
                                    </select>
								</td>
								
							</tr>
							<tr>
								<td align="center">
									Select duration to view the Sale Report
								</td>
							</tr>
							</table>
						</td>
						<td class="icon_box">
							<?php echo form_open("sales/manage",array( 'method'=>'GET' , 'name' => 'memberListing', 'id' => 'memberListing'));?>
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
									Select dates to view the Sale Report
								</td>
							</tr>
							</table>
							<?php echo form_close(); ?>
							<!-- </form>  -->
						</td>
						
						<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
								<tr>
									<td align="center"> 
										Total: <b>
													<?php $total = $sales_all_sum[0]->sum_order_amount+$sales_all_sum[0]->sum_tax+$sales_all_sum[0]->sum_shipping;
													echo "$".$total; 
													?>
												</b>		
									</td>
								</tr>
								<tr>
									<td align="center"> 
										(Total of order amount, tax and shipping)		
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
            </div>
			<?php echo form_open("sales/manage", array('name' => 'memberListing', 'id' => 'memberListing'));?>
			<!-- <input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />  -->
			<!-- <input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" /> -->
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<!-- td align="center" class="form_header" width="">
						<span>
							<input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('memberListing',this);"/>
						</span>
					</td-->
					<td align="center" class="form_header"><span>User Name</span></td>
					<td align="center" class="form_header" ><span>Transaction ID</span></td>
					<td align="center" class="form_header" ><span>Order Amount</span></td>
					<td align="center" class="form_header" ><span>Order Date</span></td>
					<td align="center" class="form_header"  nowrap="nowrap" align="center"><span>Order Status</span></td>
				</tr>
				<?php
				
				if($sales_report):
					$rowClass = 'row1';

					foreach($sales_report as $report):
							
						if($rowClass == 'row0')
						{
							$rowClass = 'row1';
						}
						else
						{
							$rowClass = 'row0';
						}

						//$image_name		=	$client_product_images[0]->image_name;

				?>
				<tr class="<?php echo $rowClass?>">
					<!--td align="center" width="5%"><span><input type="checkbox" name="client_productids[]" value="<?php echo $report->id?>" onclick="checkMasterState('memberListing', 'masterCheckField')"/></span></td-->
			
					
					<td align="center" ><span><?php echo $report->name;?></span></td>
					<td align="center" ><span><?php echo $report->transaction_id;?></span></td>
					<td align="center" ><span><?php echo $report->order_amount;?></span></td>
					<td align="center" ><span><?php echo date("M d, Y", strtotime($report->created_time));?></span></td>
					<td align="center" ><span><?php if($report->order_status == 0){
	echo 'Pending';
}
if($report->order_status == 1){
	echo 'Paid';
}
if($report->order_status == 2){
	echo 'shipped';
}
if($report->order_status == 3){
	echo 'completed';
}
if($report->order_status == 4){
	echo 'cancelled /Refunded';
}

?></span></td>
									
					

				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="5" align='center' ><strong>No Sales Report Found.</strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="5" align="center">
						<?php echo $pagination; ?>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="5">
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
  <script  type="text/javascript" src="includes/script/boxover.js" ></script>
</div>

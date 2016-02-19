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
    <tr>
      <td id="content_center_td" valign="top">
          <div id="content_div">
			<div id="listpage_button_bar" >
				<table align="left" border="0">
					<tr>
						<?php if($consultant) { ?>
							<td class="icon_box">
								<table border="0" cellspacing="0" cellpadding="0" align="center">
									<tr>
										<td align="center">   
											<select name="consid" id="consid" onchange="setSessionConsSalesReport(this.value, '<?php echo base_url() . 'transactions/listing/' ?>', '<?php echo base_url();?>' )">
												<option value="all">Select <?php echo $this->consultant_label ;?></option>
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
									</tr>
									<tr>
										<td align="center">
											Select <?php echo $this->consultant_label ;?> to view the Sale Report
										</td>
									</tr>
								</table>
							</td>
						<?php } ?>
						<td class="icon_box">
							<?php echo form_open("transactions/listing",array( 'method'=>'GET' , 'name' => 'transactionListing', 'id' => 'transactionListing'));?>
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
					</tr>
				</table>
            </div>
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td width="15%" align="center" class="form_header"><span>Date</span></td>
					<td width="15%" align="center" class="form_header"><span>Transaction Id</span></td>
					<td width="10%" align="center" class="form_header"><span><?php echo $this->consultant_label; ?></span></td>
					<td width="50%" align="center" class="form_header"><span>Remarks</span></td>
				</tr>
				<?php
				if(!empty($transactions) && count($transactions)>0):

					foreach($transactions as $transaction):
						$rowClass = 'row1';
				?>
				<tr class="<?php echo $rowClass?>">
					<td align="left"><span><?php echo $transaction['date']; ?></span></td>
					<td align="left"><span><?php echo $transaction['transaction_id']; ?></span></td>
					<td align="left"><span><?php echo $transaction['user']; ?></span></td>
					<td align="left"><span><?php echo $transaction['remarks']; ?></span></td>
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="6" align='center' ><strong><?php echo 'No transaction.'; ?></strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="6" align="center">
						<?php echo $pagination; ?>
					</td>
				</tr>
            </table>
          </div>
        </td>
    </tr>
  </table>
</div>
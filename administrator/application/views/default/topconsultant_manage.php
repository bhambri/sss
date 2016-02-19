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
				<?php echo form_open('consultant/topconsultantmanage',array('name'=>'search', 'id'=>'search'));?>
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
								  <?php echo lang('user_search_instructions');?>
								</div>
							</fieldset>
						</td>
					</tr>
				</table>
				<?php echo form_close();?>
				<table align="left" border="0">
					
					<tr>
						    <td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">   
                                    <select name="adminid" id="adminid" onchange="setSessionSalesReportDuration(this.value, '<?php echo base_url() . 'consultant/topconsultantmanage/' ?>', '<?php echo base_url();?>' )">
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
							<?php echo form_open("consultant/topconsultantmanage",array( 'method'=>'GET' , 'name' => 'memberListing', 'id' => 'memberListing'));?>
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
			<?php echo form_open("consultant/topconsultantmanage", array('name' => 'userListing', 'id' => 'userListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<!-- <td align="center" class="form_header" ><span><input type="checkbox" name="masterCheckField" id="masterCheckField" onclick="checkAll('userListing',this);"/></span></td> -->
					<td align="center" class="form_header"><span>User Name</span></td>
					<td align="center" class="form_header"><span><?php echo lang('full_name')?></span></td>
					<td align="center" class="form_header"><span>Total Sales(group sales + individual sales)</span></td>
					<td class="form_header"  nowrap="nowrap" align="center"><span><?php echo lang('active')?></span></td>
				</tr>
				<?php
				if(!empty($users) && count($users)>0):
				

					$rowClass = 'row1';

					foreach($users as $user):
						#hide the super admin username always
						if($user['username'] == "admin")
							continue;

						if($rowClass == 'row0') {
							$rowClass = 'row1';
						} else {
							$rowClass = 'row0';
						}

				?>
				<tr class="<?php echo $rowClass?>">
					
					<td align="center">
						<span>
							
								<a href="<?php echo base_url()?>consultant/edit_consultant/<?php echo $user['id'] ;?>" ><?php echo substr($user['username'],0,20)?></a>

					</span></td>
					<td align="center"><span><?php echo $user['name'] ;?></span></td>
					<td align="center"><span>$<?php echo $user['tota_sum'] ;?></span></td>

					<td nowrap="nowrap" align="center">					
					<?php $statusLink = base_url() . "consultant/update_status/" . $user['id'] . "/" . $user['status'] . "/" . $this->uri->segment(3)?>

					<?php if($user['username'] ==$this->session->userdata['user']['username']): ?>
						<?php if($user['status'] == 1):?>
							<img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/>
						<?php else: ?>
							<img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/>
						<?php endif; ?>
					<?php else: ?>
						<?php if($user['status'] == 1):?>

							<a onclick="return confirm('Are you sure, you want to deactivate this consultant');" href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
						<?php else: ?>
							<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
						<?php endif; ?>
					<?php endif; ?>
					</td>
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="7" align='center' ><strong><?php echo lang('consultants_not_found')?></strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="10" align="center">
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

</div>
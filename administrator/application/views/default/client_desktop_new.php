<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php


// CI_Loader instance
$ci = get_instance();
$baseurl=$ci->config->item('root_url');
#echo '<pre>';
$userData  = $this->session->userdata('user') ;

$roleId = $userData['role_id'] ;
$ci->load->model('client_model');
$ci->load->model('settings_model');
if($sitename == ''){
//error_reporting(1);	
	
	$cdetail = $ci->client_model->getclientfromurl() ;
	//echo '<pre>';
	//print_r($cdetail[0]['id']);
	//die;
	$storeid = @$cdetail[0]['id'] ;
	$roleid = @$cdetail[0]['role_id'] ;
}

$taxlink  = "taxes/manage_taxes" ;
if( $roleId ==  2){

$storesettings = $ci->settings_model->get_store_settings_page($userData['id'] , 2); // 
//echo '<pre>';
$ava_account_number = $storesettings->ava_account_number ;
$ava_license_key = $storesettings->ava_license_key ;
$ava_company_code  = $storesettings->ava_company_code ;
if($ava_account_number || $ava_license_key || $ava_company_code){
	$taxlink = "settings/edit_settings_avatax/".$storesettings->id ;
}
//print_r($storesettings->ava_account_number);
}

?>

<table cellspacing="0" cellpadding="0" border="0" width="100%" >
	<tr>
		<td id="id_td_pageHeading" valign="middle"><span id="pageTitle"><?php echo lang('desktop')?></span></td>
	</tr>
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
	<tr>
		<td id="content_center_td" valign="top">
			<div id="content_div">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-right: 10px;" valign="top">
						<table width="460" cellpadding="0" cellspacing="1" align="left" class="listing_table" border="0" bgcolor="#ffffff">
							<?php if($is_mlmtype ){ ?>
							<table class="listing_table" border="0" bgcolor="#ffffff">
							<tr bgcolor="#FFFFFF">    

								<td width="13%" valign="middle" align="center" class="my_icon" >
									<a href="<?php echo base_url() . "contact/manage_contact";?>"><img src="<?php echo layout_url('default/images')?>/icons/consultant.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Contact Us</a>
								</td>

								<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "coupons/manage_coupons/";?>"><img src="<?php echo layout_url('default/images')?>/icons/coupon.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Coupons</a></td>

								<td  width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "news/manage_news";?>"><img src="<?php echo layout_url('default/images')?>/icons/news.png"  height="60" width="60"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage News</a></td>

							<td  width="13%" valign="middle" align="center" class="my_icon" >
							<a href="<?php echo base_url() . "order/manage";?>">
							<img src="<?php echo layout_url('default/images')?>/icons/shipping.png"  height="60" width="60"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Order</a></td>

							<td  width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "grouppurchase/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/gpurchase.png"  height="50" width="50" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Parties</a></td>

								</tr>
								<tr bgcolor="#FFFFFF">

							<td width="13%" valign="middle" align="center" class="my_icon"> <a href="<?php echo base_url() . "user/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/user2.png"  height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Users</a></td>

							<td width="13%" valign="middle" align="center" class="my_icon" >
									<a href="<?php echo base_url() . "consultant/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/consultant.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage <?php echo $this->consultant_label ;?></a>
								</td>

							<td width="13%" valign="middle" align="center" class="my_icon" >
									<a href="<?php echo base_url() . "consultant/tree_view";?>"><img src="<?php echo layout_url('default/images')?>/icons/tree.png"  border="0" height="60" width="60" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										<?php echo $this->consultant_label ;?> Tree View
									</a>
							</td>

							
							</tr>
							</table>
							<table class="listing_table" border="2" bgcolor="#ffffff">
							<tr bgcolor="#FFFFFF">
							</tr>
							</table>
							<table class="listing_table" border="0" bgcolor="#ffffff">
							<tr bgcolor="#FFFFFF">
								

								<td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "consultant/manage_alldues";?>"><img src="<?php echo layout_url('default/images')?>/icons/sales-report.png" height="50" width="50" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										All Dues Reports
									</a>
								</td>
								<td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "consultant/manage_bonus";?>"><img src="<?php echo layout_url('default/images')?>/icons/sales-report.png" height="50" width="50" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										Bonus Reports
									</a>
								</td>

								<td  width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "grouppurchase/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/gpurchase.png"  height="50" width="50" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Parties</a></td>


							    <td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "sales/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/sale.png"  height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										Sales Tracking Report
									</a>
							    </td>
							    

								<td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "consultant/topconsultantmanage";?>"><img src="<?php echo layout_url('default/images')?>/icons/top_executive.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										Top <?php echo $this->consultant_label ;?> Report
									</a>
								</td>
								</tr>
							    <tr bgcolor="#FFFFFF">

								<td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "sales/topsales";?>"><img src="<?php echo layout_url('default/images')?>/icons/top_executive.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										Top X Sales By <?php echo $this->consultant_label ;?>
									</a>
								</td>


								<td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "consultant/manage_volume_commission";?>"><img src="<?php echo layout_url('default/images')?>/icons/top_executive.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
									Volume Commission Reports
									</a>
								</td>

								<td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "consultant_sales/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/sales-report.png" height="50" width="50" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										<?php echo $this->consultant_label ;?> Sales Report
									</a>
								</td>

							</tr>
							</table>

							<?php }else{ ?>
							<table class="listing_table" border="0" bgcolor="#ffffff">
							<tr bgcolor="#FFFFFF">                  
								<td width="13%" valign="middle" align="center" class="my_icon" >
									<a href="<?php echo base_url() . "contact/manage_contact";?>"><img src="<?php echo layout_url('default/images')?>/icons/consultant.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Contact Us</a>
								</td>
								<td  width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "news/manage_news";?>"><img src="<?php echo layout_url('default/images')?>/icons/news.png"  height="60" width="60"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage News</a></td>

							<td  width="13%" valign="middle" align="center" class="my_icon" >
							<a href="<?php echo base_url() . "order/manage";?>">
							<img src="<?php echo layout_url('default/images')?>/icons/shipping.png"  height="60" width="60"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Order</a></td>

							<td width="13%" valign="middle" align="center" class="my_icon"> <a href="<?php echo base_url() . "user/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/user2.png"  height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Users</a></td>

							<td width="13%" valign="middle" align="center" class="my_icon" >
									<a href="<?php echo base_url() . "consultant/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/consultant.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage <?php echo $this->consultant_label ;?></a>
								</td>
								</tr>
								<tr bgcolor="#FFFFFF">

							

							<td width="13%" valign="middle" align="center" class="my_icon" >
									<a href="<?php echo base_url() . "consultant/tree_view";?>"><img src="<?php echo layout_url('default/images')?>/icons/tree.png"  border="0" height="60" width="60" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										<?php echo $this->consultant_label ;?> Tree View
									</a>
							</td>
							</tr>
							</table>
							<table class="listing_table" border="2" bgcolor="#ffffff">
							<tr bgcolor="#FFFFFF">
							</tr>
							</table>
							<table class="listing_table" border="0" bgcolor="#ffffff">
							<tr bgcolor="#FFFFFF">                  
								
								<td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "consultant/manage_alldues";?>"><img src="<?php echo layout_url('default/images')?>/icons/sales-report.png" height="50" width="50" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										All Dues Reports
									</a>
								</td>
								<td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "consultant/manage_bonus";?>"><img src="<?php echo layout_url('default/images')?>/icons/sales-report.png" height="50" width="50" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										Bonus Reports
									</a>
								</td>
							    <td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "sales/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/sale.png"  height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										Sales Tracking Report
									</a>
							    </td>
							    
								<td width="13%" valign="middle" align="center" class="my_icon">
																	<a href="<?php echo base_url() . "sales/topsales";?>"><img src="<?php echo layout_url('default/images')?>/icons/top_executive.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
																		Top X Sales By <?php echo $this->consultant_label ;?>
																	</a>
								</td>
								<td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "consultant/topconsultantmanage";?>"><img src="<?php echo layout_url('default/images')?>/icons/top_executive.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										Top <?php echo $this->consultant_label ;?> Report
									</a>
								</td>
								</tr>
							    <tr bgcolor="#FFFFFF">

								


								<td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "consultant/manage_volume_commission";?>"><img src="<?php echo layout_url('default/images')?>/icons/top_executive.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
									Volume Commission Reports
									</a>
								</td>

								<td width="13%" valign="middle" align="center" class="my_icon">
									<a href="<?php echo base_url() . "consultant_sales/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/sales-report.png" height="50" width="50" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										<?php echo $this->consultant_label ;?> Sales Report
									</a>
								</td>

							</tr>
							</table>
							<?php } ?>
						</table>
					</td>
					<td id="desktop_right_column" valign="top" width="70%">
						<table width="99%" border="0" cellspacing="1" cellpadding="2" align="left" class="listing_table" id="right_column_table">
							<tr>
								<td colspan="4" class="form_header"><span><?php printf(lang('dashboard'), date('l dS M, Y'));?>
									</span>
								</td>
							</tr>
							<tr class="row0">
								<td width="27%" nowrap="nowrap">Total News(including consultant news also): </td>
								<td width="23%"><?php echo $news; ?></td>
								<td width="27%" nowrap="nowrap"></td>
								<td width="23%">&nbsp;</td>
							</tr>
							<tr class="row1">
								<td width="27%" nowrap="nowrap">Total Contact us(including consultant enquires also) :</td>
								<td width="23%"><?php echo $contacts; ?></td>
								<td width="27%" nowrap="nowrap"></td>
								<td width="23%"></td>
							</tr>
							
							<tr>
							  <td colspan="4" class="form_base_header"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</div>
		</td>
	</tr>
</table>
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
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
							<tr bgcolor="#FFFFFF">                  
								<td width="13%" valign="middle" align="center" class="my_icon"> 
									<a href="<?php echo $this->config->item('root_url');?>"><img src="<?php echo layout_url('default/images')?>/icons/home.png"  height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Site Home</a></td>
							<td width="13%" valign="middle" align="center" class="my_icon" >
								<a href="<?php echo base_url() . "news/manage_news";?>">
									<img src="<?php echo layout_url('default/images')?>/icons/news.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
									Manage News
								</a>
							</td>
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "grouppurchase/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/gpurchase.png" height="50" width="50" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Parties</a></td>
							
							<!-- <td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "banners/manage_banners";?>"><img src="<?php echo layout_url('default/images')?>/icons/banner.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Banner</a></td>

							-->
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "coupons/manage_coupons/";?>"><img src="<?php echo layout_url('default/images')?>/icons/coupon.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Coupons</a></td>
							</tr>
							
							
							<tr bgcolor="#FFFFFF"> 

								<td width="13%" valign="middle" align="center" class="my_icon" >
									<a href="<?php echo base_url() . "order/manage";?>">
										<img src="<?php echo layout_url('default/images')?>/icons/order-history.png"  height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
										Manage Order
									</a>
								</td>
								<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "settings/manage_settings";?>"><img src="<?php echo layout_url('default/images')?>/icons/configuration.png"  height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Settings</a></td> 

<?php if($training_link!= ''){?>
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo $training_link ;?>" target='_blank' ><img src="<?php echo layout_url('default/images')?>/icons/coupon.png" height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Training</a></td>
<?php } ?>

								<td width="13%" valign="middle" align="center" class="my_icon"> 
									<a href="<?php echo base_url() . "user/tree_view/".$consultantid ;?>">
										<img src="<?php echo layout_url('default/images')?>/icons/invite.png"  border="0"  height="60" width="60" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
									Unilevel Team View
									</a>
								</td>
							</tr>
							
							<tr  bgcolor="#FFFFFF">


<?php if($is_mlmtype){?>
<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "user/consbtree_view/".$consultantid ;?>"><img src="<?php echo layout_url('default/images')?>/icons/configuration.png"  height="60" width="60" border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Binary team view(MLM type comp.)</a></td>
<?php } ?>
							</tr>


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
								<td width="27%" nowrap="nowrap">Total News: </td>
								<td width="23%"><?php echo $news; ?></td>
								
							</tr>
							<?php if($is_mlmtype){?>
							<tr class="row0">
								<td width="27%" nowrap="nowrap">PPVC(MLM Comp. only): </td>
								<td width="23%">$<?php echo @$pendingcom[0]['appv_sum']; ?></td>
								
							</tr>
<tr class="row0">
								<td width="27%" nowrap="nowrap">PCVC(MLM Comp. only): </td>
								<td width="23%">$<?php echo @$pendingcom[0]['apcv_sum']; ?></td>
								
							</tr>
<tr class="row0">
								<td width="27%" nowrap="nowrap">PBVC(MLM Comp. only): </td>
								<td width="23%">$<?php echo @$pendingcom[0]['acbv_sum']; ?></td>
								
							</tr>
							<?php } ?>
							<!-- <tr class="row1">
								<td width="27%" nowrap="nowrap">Total Contact us </td>
								<td width="23%"><?php echo $contacts; ?></td>
								<td width="27%" nowrap="nowrap"></td>
								<td width="23%"></td>
							</tr>
							-->
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

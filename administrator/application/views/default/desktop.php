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
								<td width="13%" valign="middle" align="center" class="my_icon"> <a href="<?php echo $this->config->item('root_url');?>"><img src="<?php echo layout_url('default/images')?>/icons/home.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Site Home</a></td>
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "attributesets/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/misc.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Product Attribute set</a></td>
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "content/manage_content";?>"><img src="<?php echo layout_url('default/images')?>/icons/misc.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Content</a></td>
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "contact/manage_contact";?>"><img src="<?php echo layout_url('default/images')?>/icons/order.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Contact Us</a></td>
							</tr>
							<tr bgcolor="#FFFFFF">
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "coupons/manage_coupons";?>"><img src="<?php echo layout_url('default/images')?>/icons/order.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Coupons</a></td>
							                
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "news/manage_news";?>"><img src="<?php echo layout_url('default/images')?>/icons/user2.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage News</a></td>
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "client/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/user2.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Client </a></td>
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "banners/manage_banners";?>"><img src="<?php echo layout_url('default/images')?>/icons/order.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Banners</a></td>
							</tr>


							<tr bgcolor="#FFFFFF"> 
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "settings/manage_settings";?>"><img src="<?php echo layout_url('default/images')?>/icons/order.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />

							Manage Settings</a></td>
							
							                 
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "category/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/user2.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Category Settings</a></td>
							<!--td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "subcategory/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/user2.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Sub Category </a></td-->
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "product/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/order.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Products</a></td>
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "grouppurchase/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/order.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Parties</a></td>
							</tr>


							<tr bgcolor="#FFFFFF"> 
							<td width="13%" valign="middle" align="center" class="my_icon" ><a href="<?php echo base_url() . "template/manage";?>"><img src="<?php echo layout_url('default/images')?>/icons/order.png"  border="0" onmouseover="this.className = 'pressDown'" onmouseout="this.className = 'pressNo'" class='pressNo' alt="administrator" /><br />
							Manage Invoice/Email Template</a></td>
							</tr>
	

						</table>
					</td>
					<td id="desktop_right_column" valign="top" width="70%">
						<table width="99%" border="0" cellspacing="1" cellpadding="2" align="left" class="listing_table" id="right_column_table">
							<tr>
								<td colspan="4" class="form_header"><span><?php @printf(lang('dashboard'), date('l dS M, Y'));?>
									</span>
								</td>
							</tr>
							<tr class="row0">
								<td width="27%" nowrap="nowrap">Total News(Simple sales sytems only): </td>
								<td width="23%"><?php echo $news; ?></td>
								<td width="27%" nowrap="nowrap"></td>
								<td width="23%">&nbsp;</td>
							</tr>
							<tr class="row1">
								<td width="27%" nowrap="nowrap">Total Contact us(Simple sales sytems only) </td>
								<td width="23%"><?php echo $contacts; ?></td>
								<td width="27%" nowrap="nowrap"></td>
								<td width="23%"></td>
							</tr>
							<!--<tr class="row1">
								<td width="27%" nowrap="nowrap">Total area(city) </td>
								<td width="23%"><?php echo $area; ?></td>
								<td width="27%" nowrap="nowrap"></td>
								<td width="23%"></td>
							</tr>-->
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

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*********************************************
* Version:	1.0 CI
* Author:	Vince Balrai
* Company:	Segnant Technologies
* Purpose:	creates a menu bar.
* URL:		http://www.segnant.com

Version 1.0 CI
JSCookMenu version v2.0.4

	var mymenu = [
		['icon','title','url','target','description'],
		_cmSplit,
		['icon','title','url','target','description'
			['icon','title','url','target','description'],
			['icon','title','url','target','description']
		]

	]

*******************************************************************/
$user = $this->session->userdata('user');
//echo '<pre>';print_r( $user );echo '</pre>';


//$client = $this->session->userdata('client');

?>
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

$this->load->model('common_model');
	$resultStore  = $this->common_model->get_clientdetail('',$userData['id']) ;
	$sitename = $resultStore[0]['company'] ;
	$is_mlmtype = $resultStore[0]['is_mlmtype'] ;
	 
}

?>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<!-- Below row will include the menus for the admin -->
	<?php 
	if( $user['role_id'] == 1 ) // for super admin
    {
	?>
	<tr>
		<td colspan="2">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td id="id_menubar">
						<div id="myMenuID"></div>
						<script type="text/javascript" language="javascript">
						//<![CDATA[
							var myMenu =
							[
								[null,'<?php echo lang("home")?>','<?php echo base_url()."admin/desktop"?>',null,'Desktop'],
								
								_cmSplit,
								[null,'News',null,null,'News',
									['<img alt="Add news" src="<?php echo layout_url("default/images")?>/ThemeOffice/add_section.png" />','Add News','<?php echo base_url()."news/add_news"?>',null,'Add News'],
									
									['<img alt="Manage News" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage News','<?php echo base_url()."news/manage_news"?>',null,'Manage News'],
								],

								_cmSplit,
								[null,'Order',null,null,'Order',					
									['<img alt="Manage Order" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Order','<?php echo base_url()."order/manage"?>',null,'Manage Order'],
								],

                                _cmSplit,
								[null,'Banners',null,null,'Banners',								
									['<img alt="Manage Content" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Banner','<?php echo base_url()."banners/manage_banners"?>',null,'Manage Pages'],
									['<img alt="Manage Content" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Store links','<?php echo base_url()."storelinks/manage_storelinks"?>',null,'Manage Pages'],
								],

                                 _cmSplit,
								[null,'Clients',null,null,'Clients',								
									['<img alt="Manage Clients" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Clients','<?php echo base_url()."client/manage"?>',null,'Manage Pages'],
								],    

								_cmSplit,
								[null,'Content',null,null,'Content',								
									['<img alt="Manage Content" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Content','<?php echo base_url()."content/manage_content"?>',null,'Manage Pages'],
								],
								
								_cmSplit,
								[null,'Contact Us',null,null,'Contact Us',								
									['<img alt="Manage Contact" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Contact Us','<?php echo base_url()."contact/manage_contact"?>',null,'Manage Contact'],
								],
								
								_cmSplit,
								[null,'Coupons',null,null,'Coupons',								
									['<img alt="Manage Contact" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Coupons','<?php echo base_url()."coupons/manage_coupons"?>',null,'Manage Contact'],
								],
							
								
								_cmSplit,
								[null,'Themes',null,null,'Themes',
									['<img alt="default" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("default_thm")?>','javascript:loadStyle("default");',null,'<?php echo lang("default_thm")?>'],

									['<img alt="blue" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_blue")?>','javascript:loadStyle("blue");',null,'<?php echo lang("thm_blue")?>'],

									['<img alt="green" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_green")?>','javascript:loadStyle("green");',null,'<?php echo lang("thm_green")?>'],

									['<img alt="purple" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_purple")?>','javascript:loadStyle("purple");',null,'<?php echo lang("thm_purple")?>'],

									['<img alt="grey" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_grey")?>','javascript:loadStyle("grey");',null,'<?php echo lang("thm_grey")?>'],

									['<img alt="mosaic" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_mosaic")?>','javascript:loadStyle("mosaic");',null,'<?php echo lang("thm_mosaic")?>'],

									['<img alt="snowy" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_snowy")?>','javascript:loadStyle("snowy");',null,'<?php echo lang("thm_snowy")?>'],

									['<img alt="transparent" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_transparent")?>','javascript:loadStyle("transparent");',null,'<?php echo lang("thm_transparent")?>'],
								],
							];
							
							cmDraw ('myMenuID', myMenu, 'hbr', _cmNodeProperties, 'ThemeOffice');
						//]]>
						</script>
					</td>
				</tr>
			</table>
		</td>
	</tr>
<?php 
}
else if( $user['role_id'] == 2 ) // for clients 
{
?>

<tr>
		<td colspan="2">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td id="id_menubar">
						<div id="myMenuID"></div>
						<script type="text/javascript" language="javascript">
						//<![CDATA[
							var myMenu =
							[
								[null,'<?php echo lang("home")?>','<?php echo base_url()."client/desktop"?>',null,'Desktop'],
								
								_cmSplit,
								[null,'Banners',null,null,'Banners',								
									['<img alt="Manage Content" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Banner','<?php echo base_url()."banners/manage_banners"?>',null,'Manage Pages'],
					//				['<img alt="Manage Content" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Store links','<?php echo base_url()."storelinks/manage_storelinks"?>',null,'Manage Pages'],
								], 
_cmSplit,
[null,'Commission Payments',null,null,'Commission Payments',
	['<img alt="Commission Order" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Commission Order','<?php echo base_url()."commission_order/commission_order_manage"?>',null,'Commission Order'],

	['<img alt="Manage News" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Commission Payments','<?php echo base_url()."override_order/override_order_manage"?>',null,'Commission Payments'],
],

_cmSplit,
[null,'Operational',null,null,'Operational',
	['<img alt="<?php echo $this->consultant_label ;?> Tree View" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />', '<?php echo $this->consultant_label ;?>'+' Tree View','<?php echo base_url()."consultant/tree_view"?>',null,'Consultant Tree View'],

	['<img alt="Manage Consultant" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage '+'<?php echo $this->consultant_label ;?>','<?php echo base_url()."consultant/manage"?>',null,'Manage '+'<?php echo $this->consultant_label ;?>'],

'<?php if(!$is_mlmtype){ ?>'

	['<img alt="Manage Party" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Parties','<?php echo base_url()."grouppurchase/manage"?>',null,'Manage Party'],

'<?php } ?>',

'<?php if(!$is_mlmtype){ ?>'
	
	['<img alt="Manage Coupons" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Coupons','<?php echo base_url()."coupons/manage_coupons"?>',null,'Manage Coupons'],

'<?php } ?>' ,

	

	['<img alt="Manage Contact Us" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Contact Us','<?php echo base_url()."contact/manage_contact"?>',null,'Manage Contact Us'],

	['<img alt="Manage News" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage News','<?php echo base_url()."news/manage_news"?>',null,'Manage News'],
	
	['<img alt="Manage Orders" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Orders','<?php echo base_url()."order/manage"?>',null,'Manage Orders'],

	

	['<img alt="Manage Users" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Users','<?php echo base_url()."user/manage"?>',null,'Manage Users'],

],

_cmSplit,
[null,'Reports',null,null,'Reports',
	
		
	['<img alt="Consultant Sales Report" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo $this->consultant_label ;?>'+' Sales Report','<?php echo base_url()."consultant_sales/manage"?>',null, '<?php echo $this->consultant_label ;?>'+' Sales Report'],
	
['<img alt="Party Sale Management" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Party Sale Management','<?php echo base_url()."grouppurchase/manage"?>',null,'Party Sale Management'],	

['<img alt="Manage Sales" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Sale Tracking Report','<?php echo base_url()."sales/manage"?>',null,'Sale Tracking Report'],

	

	/* ['<img alt="Sales Report" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Sales Report','<?php echo base_url()."consultant_sales/manage"?>',null,'Sales Report'],  */

	['<img alt="Top Consultant" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Top '+'<?php echo $this->consultant_label ;?>','<?php echo base_url()."consultant/topconsultantmanage"?>',null,'Top '+'<?php echo $this->consultant_label ;?>'],

	
	
	['<img alt="Top X sales by <?php echo $this->consultant_label ;?>" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Top X sales by '+'<?php echo $this->consultant_label ;?>','<?php echo base_url()."sales/topsales"?>',null,'Top X sales by '+'<?php echo $this->consultant_label ;?>'],
	['<img alt="Total Commissions Report" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Total Commissions Report','<?php echo base_url()."consultant/manage_alldues"?>',null,'Total Commissions Report'],
	['<img alt="Transactions" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Transactions','<?php echo base_url() . "transactions/listing" ?>',null,'Transactions'],
	['<img alt="Volume Commission Reports" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Volume Commission Reports','<?php echo base_url()."consultant/manage_volume_commission"?>',null,'Volume Commission Reports'],

],
/* newly added part starts here */
_cmSplit,
[null,'Setup',null,null,'Setup',
	
	['<img alt="Commission Settings" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Commission Settings','<?php echo base_url()."consultant/commission_setting"?>',null,'Commission Settings'],
	
	
	
	['<img alt="Category Settings" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Category Settings','<?php echo base_url()."category/manage"?>',null,'Category Settings'],

'<?php if(!$is_mlmtype){ ?>'	
['<img alt="Coupon Rule Settings" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Coupon Rule Settings','<?php echo base_url()."couponrules/manage_crule"?>',null,'Coupon Rule Settings'],
'<?php } ?>',

['<img alt="Executive Level Settings" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Executive Level Settings','<?php echo base_url()."executives/executive_manage"?>',null,'Executive Level Settings'],

['<img alt="Product Attribute Sets" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Product Attribute Sets','<?php echo base_url()."attributesets/manage"?>',null,'Product Attribute Sets'],

['<img alt="Product Settings" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Product Settings','<?php echo base_url()."product/manage"?>',null,'Product Settings'],

	['<img alt="Promotion Rule Settings" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Promotion Rule Settings','<?php echo base_url()."promotionrules/manage_prule"?>',null,'Promotion Rule Settings'],

	['<img alt="Shipping Settings" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Shipping Settings','<?php echo base_url()."shipping/manage_shipping"?>',null,'Shipping Settings'],

	['<img alt="Store Front Settings" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Store Front Settings','<?php echo base_url()."front_blocks/front_blocks_manage"?>',null,'Store Front Settings'],


	['<img alt="Store Payment Settings" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Store Payment Settings','<?php echo base_url()."settings/manage_settings"?>',null,'Store Payment Settings'],

	
	['<img alt="Tax Settings" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Tax Settings','<?php echo base_url().$taxlink ?>',null,'Tax Settings'],

	
],
 
/* newly added part */
								/* _cmSplit,
								[null,'Contact Us',null,null,'Contact Us',								
									['<img alt="Manage Contact" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Contact Us','<?php echo base_url()."contact/manage_contact"?>',null,'Manage Contact'],
								], */

								_cmSplit,
								[null,'Content',null,null,'Content',								
									['<img alt="Manage Content" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Content','<?php echo base_url()."content/manage_content"?>',null,'Manage Pages'],
								],
								
								/* _cmSplit,
								[null,'Coupons',null,null,'Coupons',								
									['<img alt="Manage Contact" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Coupons','<?php echo base_url()."coupons/manage_coupons"?>',null,'Manage Coupons'],
									['<img alt="Manage Coupon Rule" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Coupon Rule','<?php echo base_url()."couponrules/manage_crule"?>',null,'Manage Coupon Rule'],
								],

								_cmSplit,
								[null,'News',null,null,'News',
									['<img alt="Add news" src="<?php echo layout_url("default/images")?>/ThemeOffice/add_section.png" />','Add News','<?php echo base_url()."news/add_news"?>',null,'Add News'],
									
									['<img alt="Manage News" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage News','<?php echo base_url()."news/manage_news"?>',null,'Manage News'],
								], 

								_cmSplit,
								[null,'Order',null,null,'Order',					
									['<img alt="Manage Order" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Order','<?php echo base_url()."order/manage"?>',null,'Manage Order'],
								],
								

								_cmSplit,
								[null,'Sales',null,null,'Sales',					
									['<img alt="Manage Sales" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Sales','<?php echo base_url()."sales/manage"?>',null,'Manage Sales'],
									['<img alt="Top X sales by <?php echo $this->consultant_label ;?>" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Top X sales by '+'<?php echo $this->consultant_label ;?>','<?php echo base_url()."sales/topsales"?>',null,'Top X sales by '+'<?php echo $this->consultant_label ;?>'],
									['<img alt="Party Sale Management" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Party Sale Management','<?php echo base_url()."grouppurchase/manage"?>',null,'Party Sale Management'],
								], 

								_cmSplit,
								[null,'Taxes',null,null,'Taxes',					
									['<img alt="Manage Taxes" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Taxes','<?php echo base_url()."taxes/manage_taxes"?>',null,'Manage Taxes'],
								],
								*/

								_cmSplit,
								[null,'Themes',null,null,'Themes',
									['<img alt="default" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("default_thm")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"default",2);',null,'<?php echo lang("default_thm")?>'],

									['<img alt="blue" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_blue")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"blue",2);',null,'<?php echo lang("thm_blue")?>'],

									['<img alt="green" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_green")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"green",2);',null,'<?php echo lang("thm_green")?>'],

									['<img alt="purple" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_purple")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"purple",2);',null,'<?php echo lang("thm_purple")?>'],

									['<img alt="grey" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_grey")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"grey",2);',null,'<?php echo lang("thm_grey")?>'],

									['<img alt="mosaic" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_mosaic")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"mosaic",2);',null,'<?php echo lang("thm_mosaic")?>'],

									['<img alt="snowy" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_snowy")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"snowy",2);',null,'<?php echo lang("thm_snowy")?>'],

									['<img alt="transparent" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_transparent")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"transparent",2);',null,'<?php echo lang("thm_transparent")?>'],
								],

								/*
								 _cmSplit,
								[null,'Users',null,null,'Users',								
									['<img alt="Manage Users" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Users','<?php echo base_url()."user/manage"?>',null,'Manage Users'],
								], */

								
							];
							
							cmDraw ('myMenuID', myMenu, 'hbr', _cmNodeProperties, 'ThemeOffice');
						//]]>
						</script>
					</td>
				</tr>
			</table>
		</td>
	</tr>

<?php 
}
else if( $user['role_id'] == 4 ) // for consultant 
{
?>

<tr>
		<td colspan="2">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td id="id_menubar">
						<div id="myMenuID"></div>
						<script type="text/javascript" language="javascript">
						//<![CDATA[
							var myMenu =
							[
								[null,'<?php echo lang("home")?>','<?php echo base_url()."consultant/desktop"?>',null,'Desktop'],
								
								_cmSplit,
								[null,'Operational',null,null,'Operational',
									['<img alt="Manage News" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage News','<?php echo base_url()."news/manage_news"?>',null,'Manage News'],

				['<img alt="Manage Order" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Order','<?php echo base_url()."order/manage"?>',null,'Manage Order'],
								
									['<img alt="Manage Party" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Parties','<?php echo base_url()."grouppurchase/manage"?>',null,'Manage Parties'],
								],
								
								
								/*
                                _cmSplit,
								[null,'Banners',null,null,'Banners',								
									['<img alt="Manage Content" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Banner','<?php echo base_url()."banners/manage_banners"?>',null,'Manage Pages'],
								//	['<img alt="Manage Content" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Store links','<?php echo base_url()."storelinks/manage_storelinks"?>',null,'Manage Pages'],
								], */
								_cmSplit,
								[null,'Reports',null,null,'Reports',
									['<img alt="Transactions" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Transactions','<?php echo base_url()."transactions/listing"?>',null,'Transactions'],
								],
								_cmSplit,
								[null,'Setup',null,null,'Setup',
									// ['<img alt="Add Group Purchase" src="<?php echo layout_url("default/images")?>/ThemeOffice/add_section.png" />','Add Group Purchase','<?php echo base_url()."grouppurchase/add"?>',null,'Add Group Purchase'],
									['<img alt="Add Account" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Add Account','<?php echo base_url()."accounts/add"?>',null,'Add Account'],
									
									['<img alt="Manage Settings" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Settings','<?php echo base_url()."settings/manage_settings"?>',null,'Manage Settings'],
								],
								/* [null,'Operational',null,null,'Operational',
									// ['<img alt="Add Group Purchase" src="<?php echo layout_url("default/images")?>/ThemeOffice/add_section.png" />','Add Group Purchase','<?php echo base_url()."grouppurchase/add"?>',null,'Add Group Purchase'],
									
								//	['<img alt="Manage Order" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Order','<?php echo base_url()."order/manage"?>',null,'Manage Order'],
								], */
							/*	_cmSplit,
								[null,'Invite',null,null,'Invite',								
									['<img alt="Invite <?php echo $this->consultant_label ;?>" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Invite '+'<?php echo $this->consultant_label ;?>','<?php echo base_url()."consultant/invite_manage"?>',null,'Invite '+'<?php echo $this->consultant_label ;?>'],
								],  */  

						/*		_cmSplit,
								[null,'Content',null,null,'Content',								
									['<img alt="Manage Content" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Content','<?php echo base_url()."content/manage_content"?>',null,'Manage Pages'],
								],
								
								_cmSplit,
								[null,'Contact Us',null,null,'Contact Us',								
									['<img alt="Manage Contact" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','Manage Contact Us','<?php echo base_url()."contact/manage_contact"?>',null,'Manage Contact'],
								],
	*/							
							/*	_cmSplit,
								[null,'Themes',null,null,'Themes',
									['<img alt="default" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("default_thm")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"default",4);',null,'<?php echo lang("default_thm")?>'],

									['<img alt="blue" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_blue")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"blue",4);',null,'<?php echo lang("thm_blue")?>'],

									['<img alt="green" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_green")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"green",4);',null,'<?php echo lang("thm_green")?>'],

									['<img alt="purple" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_purple")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"purple",4);',null,'<?php echo lang("thm_purple")?>'],

									['<img alt="grey" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_grey")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"grey",4);',null,'<?php echo lang("thm_grey")?>'],

									['<img alt="mosaic" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_mosaic")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"mosaic",4);',null,'<?php echo lang("thm_mosaic")?>'],

									['<img alt="snowy" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_snowy")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"snowy",4);',null,'<?php echo lang("thm_snowy")?>'],

									['<img alt="transparent" src="<?php echo layout_url("default/images")?>/ThemeOffice/content.png" />','<?php echo lang("thm_transparent")?>','javascript:updatectheme(<?php echo $user['id']; ?>,"transparent",4);',null,'<?php echo lang("thm_transparent")?>'],
								], */
							];
							
							cmDraw ('myMenuID', myMenu, 'hbr', _cmNodeProperties, 'ThemeOffice');
						//]]>
						</script>
					</td>
				</tr>
			</table>
		</td>
	</tr>

<?php 
}

$ci->load->helper('vci_common');
$ci->load->model('mahana_model');
$userData	= get_message_user();

$count	= $ci->mahana_model->get_msg_count($userData['user_id']);
$count	= ($count > 0) ? $count : '';
$msg_count	= '<a href="' .base_url() .'messages/listing">' . $count 
			. ' <img src="' . layout_url('default/assets') . '/img/unread.png" style="position: relative; top: 4px;" /></a>';

?>

	<!-- Below row prints out the user name and provide link to log out -->
	<?php if( $user['role_id'] == 1 ) { ?>
	<tr>
<td class="id_pathway"><?php echo isset($crumbs)? $crumbs:'';?></td>
		<td class="id_pathway" align="right"><span class="logout">Welcome <?php echo ucwords($user['first_name'] . " " . $user['last_name']) . $msg_count;?> [ <!--a href="<?php echo base_url()?><?php echo $user['controller']; ?>/<?php echo $user['edit'];?>/<?php $user = $this->session->userdata('user'); echo $user['id'];?>" ><?php echo lang('btn_update'); ?></a> | --> <a href="<?php echo base_url()?><?php echo $user['controller'];?>/change_password/<?php $user = $this->session->userdata('user'); echo $user['id'];?>" >Change Password</a> | <a href="#" onclick="logout('<?php echo base_url() .$user['controller'] ."/logout";?>')"><?php echo lang('btn_logout')?></a> ]</span> </td>
	
	</tr>
	<!--OLD links ->
	<tr>
<td class="id_pathway"><?php echo isset($crumbs)? $crumbs:'';?></td>
		<td class="id_pathway" align="right"><span class="logout">Welcome <?php echo ucwords($user['first_name'] . " " . $user['last_name']);?> [ <a href="<?php echo base_url()?>user/edit_user/<?php $user = $this->session->userdata('user'); echo $user['id'];?>" ><?php echo lang('btn_update'); ?></a> | <a href="<?php echo base_url()?>user/change_password/<?php $user = $this->session->userdata('user'); echo $user['id'];?>" >Change Password</a> | <a href="#" onclick="logout('<?php echo base_url() . "admin/logout";?>')"><?php echo lang('btn_logout')?></a> ]</span> </td>
	
	</tr>
	<!-- -->
	
	<?php }
	else if( $user['role_id'] == 2 )
	{?>
		<tr>
			<td class="id_pathway"><?php echo isset($crumbs)? $crumbs:'';?></td>
			<!--td class="id_pathway" align="right"><span class="logout">Welcome <?php echo ucwords($user['first_name'] . " " . $user['last_name']);?> [ <a href="<?php echo base_url()?><?php echo $user['controller']; ?>/<?php echo $user['edit'];?>/<?php $user = $this->session->userdata('user'); echo $user['id'];?>" ><?php echo lang('btn_update'); ?></a> | <a href="<?php echo base_url()?><?php echo $user['controller'];?>/change_password/<?php $user = $this->session->userdata('user'); echo $user['id'];?>" >Change Password</a> | <a href="#" onclick="logout('<?php echo base_url() .$user['controller'] ."/logout";?>')"><?php echo lang('btn_logout')?></a> ]</span> </td-->
			<td class="id_pathway" align="right"><span class="logout">Welcome <?php echo ucwords($user['first_name'] . " " . $user['last_name']) . $msg_count;?> [ <a href="<?php echo base_url()?><?php echo $user['controller']; ?>/edit/id/<?php $user = $this->session->userdata('user'); echo $user['id'];?>" ><?php echo lang('btn_update'); ?></a> | <a href="<?php echo base_url()?><?php echo $user['controller'];?>/change_password/<?php $user = $this->session->userdata('user'); echo $user['id'];?>" >Change Password</a> | <a href="#" onclick="logout('<?php echo base_url() .$user['controller'] ."/logout";?>')"><?php echo lang('btn_logout')?></a> ]</span> </td>
		</tr>
	<?php
	}
	else if( $user['role_id'] == 4 ) 
	{?>
		<tr>
			<td class="id_pathway"><?php echo isset($crumbs)? $crumbs:'';?></td>
			<td class="id_pathway" align="right"><span class="logout">Welcome <?php echo ucwords($user['name']) . $msg_count;?> [ <a href="<?php echo base_url()?><?php echo $user['controller']; ?>/<?php /*echo $user['edit'];*/ echo "edit_consultant"; ?>/<?php $user = $this->session->userdata('user'); echo $user['id'];?>" ><?php echo lang('btn_update'); ?></a> | <a href="<?php echo base_url()?><?php echo $user['controller'];?>/change_password/<?php $user = $this->session->userdata('user'); echo $user['id'];?>" >Change Password</a> | <a href="#" onclick="logout('<?php echo base_url() .$user['controller'] ."/logout";?>')"><?php echo lang('btn_logout')?></a> ]</span> </td>
		</tr>
	<?php
	}
	?>
</table>

<?php
$user = $this->session->userdata('user');

$ci = get_instance();
$ci->load->helper('vci_common');
$ci->load->model('mahana_model');
$userData	= get_message_user();

$msg_count	= $ci->mahana_model->get_msg_count($userData['user_id']);

$taxlink  = "taxes/manage_taxes" ;
$ci->load->model('settings_model');
if( $roleId ==  2){

	$storesettings = $ci->settings_model->get_store_settings_page($userData['id'] , 2);

	$ava_account_number = $storesettings->ava_account_number ;
	$ava_license_key = $storesettings->ava_license_key ;
	$ava_company_code  = $storesettings->ava_company_code ;
	if($ava_account_number || $ava_license_key || $ava_company_code){
		$taxlink = "settings/edit_settings_avatax/".$storesettings->id ;
	}
}

if( $user['role_id'] == 1 ) {
	$page_nav	= array(
		'dashboard' => array(
			'title' 	=> 'Dashboard',
			'url' 		=> base_url(),
			'icon' 		=> 'fa-home',
			'active' 	=> 1
		),
		'inbox' => array(
			'title' 	=> 'Inbox',
			'url' 		=> base_url() . "messages/listing",
			'icon' 		=> 'fa-inbox',
			'label_htm' => ($msg_count > 0)?('<span class="badge pull-right inbox-badge">'.$msg_count.'</span>'):''
		),
		'news' => array(
			'title' 	=> 'News',
			'icon' 		=> 'fa-desktop',
			'sub' 		=> array(
				'add_news' => array(
					'title' => 'Add News',
					'url'	=> base_url() . "news/add_news",
				),
				'manage_news' => array(
					'title' => 'Manage News',
					'url'	=> base_url() . "news/manage_news",
				)
			)
		),
		'Order'	=> array(
			'title'		=> 'Manage Order',
			'url'		=> base_url() . "order/manage",
			'icon' 		=> 'fa-list-alt',
		),
		'Banners'	=> array(
			'title'		=> 'Banners',
			'icon' 		=> 'fa-picture-o',
			'sub'		=> array(
				'Manage_Banner'	=> array(
					'title'	=> 'Manage Banner',
					'url'	=> base_url()."banners/manage_banners",
				),
				'Manage_Content'=> array(
					'title'	=> 'Manage Store links',
					'url'	=> base_url() . "storelinks/manage_storelinks",
				),
			),
		),
		'Clients'	=> array(
			'title'		=> 'Clients',
			'icon' 		=> 'fa-user',
			'url'		=> base_url() . "client/manage",
		),
		'Content'	=> array(
			'title'		=> 'Content',
			'icon' 		=> 'fa-file-code-o',
			'url'		=> base_url() . "content/manage_content",
		),
		'Contact_Us'	=> array(
			'title'		=> 'Contact Us',
			'icon' 		=> 'fa-pencil-square-o',
			'url'		=> base_url() . "contact/manage_contact",
		),
		'Coupons'	=> array(
			'title'		=> 'Coupons',
			'icon' 		=> 'fa-cube',
			'url'		=> base_url() . "coupons/manage_coupons",
		),
	);


} else if( $user['role_id'] == 2 ) {
	$page_nav	= array(
		'dashboard' => array(
			'title' 	=> 'Dashboard',
			'url' 		=> base_url(),
			'icon' 		=> 'fa-home',
			'active' 	=> 1
		),
		'inbox' => array(
			'title' 	=> 'Inbox',
			'url' 		=> base_url() . "messages/listing",
			'icon' 		=> 'fa-inbox',
			'label_htm' => ($msg_count > 0)?('<span class="badge pull-right inbox-badge">'.$msg_count.'</span>'):''
		),
		'Banners'	=> array(
			'title'		=> 'Banners',
			'icon' 		=> 'fa-picture-o',
			'sub'		=> array(
				'Manage_Banner'	=> array(
					'title'	=> 'Manage Banner',
					'url'	=> base_url()."banners/manage_banners",
				),
			),
		),
		'Commission_Payments'	=> array(
			'title'		=> 'Commission Payments',
			'icon' 		=> 'fa-list-alt',
			'sub'		=> array(
				'Commission_Order'	=> array(
					'title'	=> 'Commission Order',
					'url'	=> base_url()."commission_order/commission_order_manage",
				),
				'Commission_Payments'=> array(
					'title'	=> 'Commission Payments',
					'url'	=> base_url() . "override_order/override_order_manage",
				),
			),
		)
	);
	$page_nav['Operational']	= array(
		'title'		=> 'Operational',
		'icon' 		=> 'fa-list-alt',
		'sub'		=> array(
			'Tree_View'	=> array(
				'title'	=> $this->consultant_label .' Tree View',
				'url'	=> base_url()."consultant/tree_view",
			),
			'Manage_Stylist'=> array(
				'title'	=> 'Manage ' . $this->consultant_label,
				'url'	=> base_url() . "consultant/manage",
			)
		)
	);
	
	if(!$is_mlmtype) {
		$page_nav['Operational']['sub']['Manage_Party']	= array(
			'title'	=> 'Manage Party',
			'url'	=> base_url() . "grouppurchase/manage",
		);

		$page_nav['Operational']['sub']['Manage_Coupons']	= array(
			'title'	=> 'Manage Coupons',
			'url'	=> base_url() . "coupons/manage_coupons",
		);
	}
	
	$page_nav['Operational']['sub']['Manage_Contact_Us']	= array(
		'title'	=> 'Manage Contact Us',
		'url'	=> base_url() . "contact/manage_contact",
	);
	
	$page_nav['Operational']['sub']['Manage_News']	= array(
		'title'	=> 'Manage News',
		'url'	=> base_url() . "news/manage_news",
	);
	
	$page_nav['Operational']['sub']['Manage_Orders']	= array(
		'title'	=> 'Manage Orders',
		'url'	=> base_url() . "order/manage",
	);
	
	$page_nav['Operational']['sub']['Manage_Users']	= array(
		'title'	=> 'Manage Users',
		'url'	=> base_url() . "user/manage",
	);
	
	$page_nav['Reports']	= array(
		'title'		=> 'Reports',
		'icon' 		=> 'fa-list-alt',
		'sub'		=> array(
			'Sales_Report'	=> array(
				'title'	=> $this->consultant_label . ' Sales Report',
				'url'	=> base_url()."consultant_sales/manage",
			),
			'Party_Sale_Management'=> array(
				'title'	=> 'Party Sale Management',
				'url'	=> base_url() . "grouppurchase/manage",
			),
			'Sale_Tracking_Report'=> array(
				'title'	=> 'Sale Tracking Report',
				'url'	=> base_url() . "sales/manage",
			),
			'Top_Consultants'=> array(
				'title'	=> 'Top '.$this->consultant_label,
				'url'	=> base_url() . "consultant/topconsultantmanage",
			),
			'Top_X_sales_by'=> array(
				'title'	=> 'Top X sales by ' . $this->consultant_label,
				'url'	=> base_url() . "sales/topsales",
			),
			'Total_Commissions_Report'=> array(
				'title'	=> 'Total Commissions Report',
				'url'	=> base_url() . "consultant/manage_alldues",
			),
			'Transactions'=> array(
				'title'	=> 'Transactions',
				'url'	=> base_url() . "transactions/listing",
			),
			'Volume_Commission_Reports'=> array(
				'title'	=> 'Volume Commission Reports',
				'url'	=> base_url() . "consultant/manage_volume_commission",
			)
		)
	);
	
	$page_nav['Setup']	= array(
		'title'		=> 'Setup',
		'icon' 		=> 'fa-list-alt',
		'sub'		=> array(
			'Commission_Settings'	=> array(
				'title'	=> 'Commission Settings',
				'url'	=> base_url()."consultant/commission_setting",
			),
			'Category_Settings'	=> array(
				'title'	=> 'Category Settings',
				'url'	=> base_url()."category/manage",
			),
		)
	);
	
	if(!$is_mlmtype) {
		$page_nav['Setup']['sub']['Coupon_Rule_Settings']	= array(
			'title'	=> 'Coupon Rule Settings',
			'url'	=> base_url() . "couponrules/manage_crule",
		);
	}

	$page_nav['Setup']['sub']['Executive_Level_Settings']	= array(
		'title'	=> 'Executive Level Settings',
		'url'	=> base_url() . "executives/executive_manage",
	);
	
	$page_nav['Setup']['sub']['Product_Attribute_Sets']	= array(
		'title'	=> 'Product Attribute Sets',
		'url'	=> base_url() . "attributesets/manage",
	);
	
	$page_nav['Setup']['sub']['Product_Settings']	= array(
		'title'	=> 'Product Settings',
		'url'	=> base_url() . "product/manage",
	);
	
	$page_nav['Setup']['sub']['Promotion_Rule_Settings']	= array(
		'title'	=> 'Promotion Rule Settings',
		'url'	=> base_url() . "promotionrules/manage_prule",
	);
	
	$page_nav['Setup']['sub']['Shipping_Settings']	= array(
		'title'	=> 'Shipping Settings',
		'url'	=> base_url() . "shipping/manage_shipping",
	);
	
	$page_nav['Setup']['sub']['Store_Front_Settings']	= array(
		'title'	=> 'Store Front Settings',
		'url'	=> base_url() . "front_blocks/front_blocks_manage",
	);
	
	$page_nav['Setup']['sub']['Store_Payment_Settings']	= array(
		'title'	=> 'Store Payment Settings',
		'url'	=> base_url() . "settings/manage_settings",
	);
	
	$page_nav['Setup']['sub']['Tax_Settings']	= array(
		'title'	=> 'Tax Settings',
		'url'	=> base_url() . $taxlink,
	);
	
	$page_nav['Content']	= array(
		'title'		=> 'Content',
		'icon' 		=> 'fa-list-alt',
		'sub'		=> array(
			'Manage_Content'	=> array(
				'title'	=> 'Manage Content',
				'url'	=> base_url()."content/manage_content",
			),
		)
	);
} else if( $user['role_id'] == 4 ) {
	$page_nav	= array(
		'dashboard' => array(
			'title' 	=> 'Dashboard',
			'url' 		=> base_url(),
			'icon' 		=> 'fa-home',
			'active' 	=> 1
		),
		'inbox' => array(
			'title' 	=> 'Inbox',
			'url' 		=> base_url() . "messages/listing",
			'icon' 		=> 'fa-inbox',
			'label_htm' => ($msg_count > 0)?('<span class="badge pull-right inbox-badge">'.$msg_count.'</span>'):''
		),
		'Operational'	=> array(
			'title' 	=> 'Operational',
			'icon' 		=> 'fa-list-alt',
			'sub'		=> array(
				'Manage_News'	=> array(
					'title'	=> 'Manage News',
					'url'	=> base_url()."news/manage_news",
				),
				'Manage_Order'	=> array(
					'title'	=> 'Manage Order',
					'url'	=> base_url()."order/manage",
				),
				'Manage_Party'	=> array(
					'title'	=> 'Manage Party',
					'url'	=> base_url()."grouppurchase/manage",
				),
			)
		),
		'Reports'	=> array(
			'title' 	=> 'Reports',
			'icon' 		=> 'fa-list-alt',
			'sub'		=> array(
				'Transactions'	=> array(
					'title'	=> 'Transactions',
					'url'	=> base_url()."transactions/listing",
				),
			)
		),
		'Setup'	=> array(
			'title' 	=> 'Setup',
			'icon' 		=> 'fa-list-alt',
			'sub'		=> array(
				'Add_Group_Purchase'	=> array(
					'title'	=> 'Add Group Purchase',
					'url'	=> base_url()."accounts/add",
				),
				'Manage_Settings'	=> array(
					'title'	=> 'Manage Settings',
					'url'	=> base_url()."settings/manage_settings",
				),
			)
		),
	);
}

?>
<aside id="left-panel">
	<!-- User info -->
	<div class="login-info">
		<span> <!-- User image size is adjusted inside CSS, it should stay as is --> 
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				<img src="<?php echo ASSETS_URL; ?>/img/avatars/male.png" alt="me" class="online" /> 
				<span><?php echo $user['username']; ?></span>
				<i class="fa fa-angle-down"></i>
			</a>
		</span>
	</div>
	<!-- end user info -->

	<!-- NAVIGATION : This navigation is also responsive

	To make this navigation dynamic please make sure to link the node
	(the reference to the nav > ul) after page load. Or the navigation
	will not initialize.
	-->
	<nav>
		<!-- NOTE: Notice the gaps after each icon usage <i></i>..
		Please note that these links work a bit different than
		traditional hre="" links. See documentation for details.
		-->
		<?php
			$ui = new SmartUI();
			$ui->create_nav($page_nav)->print_html();
		?>
	</nav>
	<span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>
</aside>
<!-- END NAVIGATION -->
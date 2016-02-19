<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();
$CI->load->helper('language');

$config = array(
		'login'	=>	array(
			array(
				'field'	=>	'adminusername',
				'label'	=>	'lang:username',
				'rules'	=>	'trim|required'),
			array(
				'field'	=>	'adminpassword',
				'label'	=>	'lang:password',
				'rules'	=>	'trim|required|min_length[6]'
				),
			),
		'client_login' => array(
			array(
				'field'	=>	'clientusername',
				'label'	=>	'lang:username',
				'rules'	=>	'trim|required'),
			array(
				'field'	=>	'clientpassword',
				'label'	=>	'lang:password',
				'rules'	=>	'trim|required|min_length[6]'
				),
			),

		'forget_password' => array(
			array(
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'trim|required|valid_email|callback_is_email_exists')
			),
		'add_category' => array(
			array(
				'field' => 'name',
				'label' => 'Category name',
				'rules' => 'trim|required|callback_is_category_exists'),
		/*	array(
				'field'	=>	'description',
				'label'	=>	'Description',
				'rules'	=>	'trim|required'
				),*/
			),
		'add_attributeset' => array(
			array(
				'field' => 'name',
				'label' => 'Attribute set name',
				'rules' => 'trim|required|callback_is_category_exists'),
		 ),
		'add_grouppurchase' => array(
			array(
				'field' => 'name',
				'label' => 'Event name',
				'rules' => 'trim|required'),
		/*	array(
				'field'	=>	'description',
				'label'	=>	'Description',
				'rules'	=>	'trim|required'
				),*/
			array(
				'field'	=>	'location',
				'label'	=>	'Location',
				'rules'	=>	'trim|required'
				),
			array(
				'field'	=>	'start_date',
				'label'	=>	'Start date',
				'rules'	=>	'trim|required'
				),
			array(
				'field'	=>	'end_date',
				'label'	=>	'End date',
				'rules'	=>	'trim|required'
				),
			array(
				'field'	=>	'group_event_code',
				'label'	=>	'Event Code',
				'rules'	=>	'trim|required'
				),

			),
		'add_subcategory' => array(
			array(
				'field' => 'name',
				'label' => 'Category name',
				'rules' => 'trim|required|callback_is_subcategory_exists'),
		/*	array(
				'field'	=>	'description',
				'label'	=>	'Description',
				'rules'	=>	'trim|required'
				),*/
			),
		'attribute_option_add' => array(
			array(
				'field' => 'field_label',
				'label' => 'Field label',
				'rules' => 'trim|required'),
		/*	array(
				'field'	=>	'description',
				'label'	=>	'Description',
				'rules'	=>	'trim|required'
				),*/
			),
		'reg_user'=>array(
				array(
					'field' => 'first_name',
					'label' => 'First Name',
					'rules' => 'trim|required|min_length[2]|max_length[30]'),					
				array(
					'field' => 'last_name',
					'label' => 'Last Name',
					'rules' => 'trim|required|min_length[2]|max_length[30]'),	
					
				array(
					'field' => 'username',
					'label' => 'Username',
					'rules' => 'trim|required|min_length[2]|max_length[30]|callback_is_user_exists'),
				array(
					'field' => 'email',
					'label' => 'Email Address',
					'rules' => 'trim|required|valid_email|callback_is_email_exists'),
				
				array(
					'field' => 'phone',
					'label' => 'Phone No.',
				//	'rules' => 'trim|required|callback_is_valid_phone'),
					'rules' => 'trim|required|min_length[10]|max_length[15]'
					),
				),
		'reg_user_validation'=>array(
				array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'trim|required|min_length[2]|max_length[30]'),
				array(
						'field' => 'phone',
						'label' => 'Phone Number',
					//	'rules' => 'trim|required|numeric|callback_is_valid_phone'
						'rules' => 'trim|required|min_length[10]|max_length[15]'
						),
				array(
						'field' => 'email',
						'label' => 'Email Address',
						'rules' => 'trim|required|valid_email|callback_is_email_exists'),
				array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'trim|required|min_length[2]|max_length[30]|callback_is_user_exists'),
				array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'trim|required|min_length[6]'),
				array(
						'field' => 'confirm_password',
						'label' => 'Confirm Password',
						'rules' => 'trim|required|min_length[6]|matches[password]'),
		),
		'update_user_validation'=>array(
				array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'trim|required|min_length[2]|max_length[30]'),
				array(
						'field' => 'phone',
						'label' => 'Phone Number',
					//	'rules' => 'trim|required|callback_is_valid_phone'
						'rules' => 'trim|required|min_length[10]|max_length[15]'
						),
				array(
						'field' => 'email',
						'label' => 'Email Address',
						'rules' => 'trim|required|valid_email|callback_is_email_exists'),
				array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'trim|required|min_length[2]|max_length[30]|callback_is_user_exists'),
		),
			'change_password' => array(
				array(
					'field' => 'new_password',
					'label' => 'New Password',
					'rules' => 'trim|required|min_length[6]'),
				array(
					'field' => 'confirm_password',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|min_length[6]|matches[new_password]'),
				),
			'addarea'       => array(
				array(
					'field' => 'name',
					'label' => 'Name',
					'rules' => 'trim|required|callback_is_name_exists'
					),
				array(
					'field' => 'page_content',
					'label' => 'Content',
					'rules'  => 'trim|required'
					)
				),
			'editcontent'   => array(
				array(
					'field' => 'page_title',
					'label' => 'Page Title',
					'rules'  => 'trim|required'
					),
				array(
					'field' => 'page_name',
					'label' => 'Page Name',
					'rules'  => 'trim|required'
					),
				array(
					'field' => 'page_content',
					'label' => 'Content',
					'rules'  => 'trim|required'
					)
				),
			'email_template' => array(
					array(
						'field' => 'name',
						'label' => 'Email Template Name',
						'rules' => 'trim|required'
					),
					array(
						'field' => 'content',
						'label' => 'Email Template Content',
						'rules' => 'trim|required'
					)
				),
			'addnews'	=> array(
				array(
					'field' => 'page_title',
					'label' => 'News Title',
					'rules'  => 'trim|required'
					),
				array(
					'field' => 'page_shortdesc',
					'label' => 'News ShortDesc.',
					'rules'  => 'trim|required'
					),
				array(
					'field' => 'page_content',
					'label' => 'Content',
					'rules'  => 'trim|required'
					)
				),
			'addbanners' => array(
			        array(
			            'field'=>'title',
			            'label' => 'Title',
					    'rules'  => 'trim|required'
			        ),
					array(
						'field' => 'link',
						'label' => 'Link',
						'rules'  => 'trim|required|callback_banner_link_valid'
					),
			),
			'editbanners' => array(
			        array(
			            'field'=>'title',
			            'label' => 'Title',
					    'rules'  => 'trim|required'
			        ),
					array(
						'field' => 'link',
						'label' => 'Link',
						'rules' => 'trim|required|callback_banner_link_valid'
					),
			        array(
			            'field'=>'path',
			            'label' => 'Path',
					    'rules'  => 'trim|required'
			        ),
			
			),
			'add_invite' => array(
					array(
						'field'=>'email',
						'label' => 'Receiver Email Address',
						'rules'  => 'trim|required|valid_email|callback_is_email_exist'
					),
			),
		
			'add_client' => array(
			        array(
			            'field'=>'fName',
			            'label' => 'Full Name',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'uName',
			            'label' => 'Username',
					    'rules'  => 'trim|required|callback_is_client_exists'
			        ),
			        array(
			            'field'=>'email',
			            'label' => 'Email',
					    'rules'  => 'trim|required|valid_email|callback_is_email_exists'
			        ),
			        array(
			            'field'=>'password',
			            'label' => 'Password',
					    'rules' => 'trim|required|min_length[6]'
			        ),
			        array(
			            'field'=>'passwordconf',
			            'label' => 'Confirm Password',
					    'rules' => 'trim|required|min_length[6]|matches[password]'
			        ),
					array(
						'field'=>'company',
						'label' => 'Company Name',
						'rules'  => 'trim|required'
					),
					array(
						'field'=>'zip',
						'label' => 'Zip',
						'rules'  => 'trim|min_length[4]|max_length[15]'
					),
					array(
						'field'=>'phone',
						'label' => 'Phone Number',
						'rules'  => 'trim|required|min_length[10]|max_length[15]'
					),
					array(
						'field'=>'fax',
						'label' => 'Fax',
						'rules'  => 'trim|min_length[10]|max_length[15]'
					),
					array(
						'field'=>'sale_support_email',
						'label' => 'Sale Support Email',
						'rules'  => 'trim|valid_email'
					),
					array(
						'field'=>'partner_support_email',
						'label' => 'Partnership Support Email',
						'rules'  => 'trim|valid_email'
					),
					array(
						'field'=>'technical_support_email',
						'label' => 'Technical Support Email',
						'rules'  => 'trim|valid_email'
					),
					array(
						'field'=>'about_us_link',
						'label' => 'About Us Page Link',
						'rules'  => 'trim|callback_url_valid_format'
					),
					array(
						'field'=>'opportunity_link',
						'label' => 'Opportunity Page Link',
						'rules'  => 'trim|callback_url_valid_format_opp'
					),
			),
			'edit_client' => array(
			        array(
			            'field'=>'fName',
			            'label' => 'Full Name',
                        'rules' => 'trim|required'
			        ),
			        /*array(
			            'field'=>'lName',
			            'label' => 'Last Name',
					    'rules'  => 'trim|required'
			        ),*/
			        array(
			            'field'=>'email',
			            'label' => 'Email',
					    'rules' => 'trim|required|valid_email|callback_is_email_exists'
			        ),
					array(
						'field'=>'company',
						'label' => 'Company Name',
						'rules'  => 'trim|required'
					),
					array(
						'field'=>'zip',
						'label' => 'Zip',
						'rules'  => 'trim|min_length[4]|max_length[15]'
					),
					array(
						'field'=>'phone',
						'label' => 'Phone Number',
						'rules'  => 'trim|required|min_length[10]|max_length[15]'
					),
					array(
						'field'=>'consultantfee',
						'label' => 'Consultant fee',
						'rules'  => 'trim|numeric'
					),
					array(
						'field'=>'signupfee',
						'label' => 'Signup fee',
						'rules'  => 'trim|numeric'
					),
					array(
						'field'=>'billing_start_delay',
						'label' => 'Billing start delay',
						'rules'  => 'trim|integer|greater_than[0]|less_than[12]'
					),
					array(
						'field'=>'fax',
						'label' => 'Fax',
						'rules'  => 'trim|min_length[10]|max_length[15]'
					),
					array(
						'field'=>'sale_support_email',
						'label' => 'Sale Support Email',
						'rules'  => 'trim|valid_email'
					),
					array(
						'field'=>'partner_support_email',
						'label' => 'Partnership Support Email',
						'rules'  => 'trim|valid_email'
					),
					array(
						'field'=>'technical_support_email',
						'label' => 'Technical Support Email',
						'rules'  => 'trim|valid_email'
					),
					array(
						'field'=>'about_us_link',
						'label' => 'About Us Page Link',
						'rules'  => 'trim|callback_url_valid_format'
					),
					array(
						'field'=>'opportunity_link',
						'label' => 'Opportunity Page Link',
						'rules'  => 'trim|callback_url_valid_format_opp'
					),
					array(
						'field'=>'store_url',
						'label' => 'Store URL Link',
						'rules'  => 'trim|callback_url_valid_format'
					),
			),
			'product_add' => array(
			        array(
			            'field'=>'category_id',
			            'label' => 'Category',
                        'rules' => 'trim|required',
			        ),
			        array(
			            'field'=>'subcategory',
			            'label' => 'Subcategory',
                        'rules' => 'trim|required'
			        ),
			        array(
			            'field'=>'client_product_title',
			            'label' => 'Product Name',
                        'rules' => 'trim|required'
			        ),
			        array(
			            'field'=>'client_product_price',
			            'label' => 'Product Price',
                        'rules' => 'trim|required|numeric'
			        ),
					array(
			            'field'=>'client_product_volume',
			            'label' => 'Product volume',
                        'rules' => 'trim|required|numeric'
			        ),
					array(
						'field' => 'image',
						'label' => 'Upload Product Image',
						'rules' => 'trim|callback_upload_product_image'
					),
			        array(
			            'field'=>'description',
			            'label' => 'Description',
                        'rules' => 'trim|required'
			        ),
			        array(
			            'field'=>'product_weight',
			            'label' => 'Product weight',
                        'rules' => 'trim|numeric'
			        ),
			        			        		
			),
		'product_edit' => array(
				array(
						'field'=>'category_id',
						'label' => 'Category',
						'rules' => 'trim|required'
				),
				array(
						'field'=>'subcategory',
						'label' => 'Subcategory',
						'rules' => 'trim|required'
				),
				array(
						'field'=>'client_product_title',
						'label' => 'Product Name',
						'rules' => 'trim|required'
				),
				array(
						'field'=>'client_product_volume',
						'label' => 'Product Volume',
						'rules' => 'trim|required|numeric'
				),
				array(
						'field'=>'description',
						'label' => 'Description',
						'rules' => 'trim|required'
				),
				array(
			            'field'=>'product_weight',
			            'label' => 'Product weight',
                        'rules' => 'trim|numeric'
			        ),
		
		),
		
		'add_commission' => array(
					array(
						'field' => 'level1',
						'label' => 'Level 1',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'level2',
						'label' => 'Level 2',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'level3',
						'label' => 'Level 3',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'level4',
						'label' => 'Level 4',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'level5',
						'label' => 'Level 5',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'level6',
						'label' => 'Level 6',
						'rules' => 'trim|required|numeric'
					),
			),
			
			'addcoupons' =>array(
					array(
						'field' => 'coupon_type',
						'label' => 'Coupon Type',
						'rules' => 'required'
					),
				/*	array(
						'field' => 'allowed_times',
						'label' => 'Can be used',
						'rules' => 'trim|numeric|callback_no_times_used'
					),*/
					array(
			            'field' => 'code',
			            'label' => 'Coupon Code',
                        'rules' => 'trim|required'
			        ),
					array(
						'field' => 'discount_percent',
						'label' => 'Discount Percentage',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'from_date',
						'label' => 'Day of Start',
						'rules' => 'trim|required'
					),
					array(
						'field' => 'to_date',
						'label' => 'Day of Expiration',
						'rules' => 'trim|required'
					),
			),
			'add_crule' =>array(
					array(
						'field' => 'coupon_type',
						'label' => 'Coupon Type',
						'rules' => 'required'
					),
				
					array(
						'field' => 'range_from',
						'label' => 'Range from',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'range_to',
						'label' => 'Range To',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'discount_percent',
						'label' => 'Discount Percentage',
						'rules' => 'trim|required|numeric'
					),
					
			),
			'add_prule' =>array(
					array(
						'field' => 'exe_type',
						'label' => 'Executive Type',
						'rules' => 'required'
					),
				
					array(
						'field' => 'binaryvol_range_from',
						'label' => 'Bin. volume Range from',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'binaryvol_range_to',
						'label' => 'Bin. volume Range To',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'min_ppv',
						'label' => 'Min. personal purchase volume',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'min_pcv',
						'label' => 'Min. personal Customer volume',
						'rules' => 'trim|required|numeric'
					),
					
			),
			'addshipping' =>array(
					array(
						'field' => 'state_name',
						'label' => 'State Name',
						'rules' => 'trim|required'
					),
					array(
						'field' => 'state_code',
						'label' => 'State Code',
						'rules' => 'trim|required'
					),
					array(
						'field' => 'w1',
						'label' => 'Shipping Cost (<= 500 g)',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'w2',
						'label' => 'Shipping Cost (501 to 1000g)',
						'rules' => 'trim|required|numeric'
					),
					array(
						'field' => 'w3',
						'label' => 'Shipping Cost (1001 to 1500 g)',
						'rules' => 'trim|required|numeric'
					),
					array(
			            'field' => 'w4',
			            'label' => 'Shipping Cost (1501 g to 2000g)',
                        'rules' => 'trim|required|numeric'
			        ),
			        array(
			            'field' => 'w5',
			            'label' => 'Shipping Cost (2001g and above)',
                        'rules' => 'trim|required|numeric'
			        ),        
			),
			
			'addtax' =>array(
					array(
						'field' => 'state_name',
						'label' => 'State Name',
						'rules' => 'trim|required'
					),
					array(
						'field' => 'state_code',
						'label' => 'State Code',
						'rules' => 'trim|required'
					),
					array(
						'field' => 'tax',
						'label' => 'Tax',
						'rules' => 'trim|required|numeric'
					),      
			),
			
			'addsettingspaypal' => array(
			        
			        array(
			            'field'=>'paypal_username',
			            'label' => 'PayPal Username',
					    'rules'  => 'trim|required'
			        ),
			        array(
			        	'field'=>'paypal_signature',
			        	'label' => 'PayPal Signature',
					    'rules'  => 'trim|required'
			        	),
			        array(
			            'field'=>'paypal_email',
			            'label' => 'PayPal Email',
					    'rules'  => 'trim|required|valid_email'
			        ),
			        array(
			            'field'=>'paypal_password',
			            'label' => 'PayPal Password',
					    'rules'  => 'trim|required|min_length[6]'
			        ),
			
			),
			'addsettingsmeritus' => array(
					array(
			            'field' =>'mp_merchant_id',
			            'label' => 'Merchant ID',
					    'rules' => 'trim|required'
			        ),
			        array(
			        	'field' =>'mp_merchant_key',
			        	'label' => 'Merchant Key',
					    'rules' => 'trim|required'
			        	),

				),
			'addsettingsavatax' => array(
					array(
			            'field' =>'ava_account_number',
			            'label' => 'AVA TAX Account Number',
					    'rules' => 'trim'
			        	)
					/* 
			        array(
			        	'field' =>'ava_license_key',
			        	'label' => 'AVA TAX Licence Key',
					    'rules' => 'trim|required'
			        	),
			        array(
			        	'field' =>'ava_company_code',
			        	'label' => 'AVA TAX Company Code',
					    'rules' => 'trim|required'
			        	), */
			        
				),
			
			'addsettings' => array(
			        /*array(
			            'field'=>'logo_image',
			            'label' => 'Logo Image',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'paypal_username',
			            'label' => 'PayPal Username',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'paypal_email',
			            'label' => 'PayPal Email',
					    'rules'  => 'trim|required|valid_email'
			        ),
			        array(
			            'field'=>'paypal_password',
			            'label' => 'PayPal Password',
					    'rules'  => 'trim|required|min_length[6]'
			        ), */
				/*	array(
						'field'=>'tax',
						'label' => 'Tax',
						'rules'  => 'trim|required|numeric'
					),*/
			        array(
			            'field'=>'fb_link',
			            'label' => 'Facebook Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'twitter_link',
			            'label' => 'Twitter Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'pinterest_link',
			            'label' => 'Pinterest Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'linkdin_link',
			            'label' => 'Linkdin Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'gplus_link',
			            'label' => 'Google+ Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'youtube_link',
			            'label' => 'Youtube Link',
					    'rules'  => 'trim|required'
			        ),
			
			),           
			
			'edit_consultant' => array(
					
					array(
							'field' => 'username',
							'label' => 'Username',
							'rules' => 'trim|required'
					),
					array(
							'field' => 'name',
							'label' => 'Name',
							'rules' => 'trim|required'
					),
					array(
							'field' => 'email',
							'label' => 'Email',
							'rules' => 'trim|required|valid_email|callback_is_consultant_email_exist'
					),
					array(
							'field' => 'phone',
							'label' => 'Phone',
							'rules' => 'trim|required|min_length[10]|max_length[15]'
					),
					
					),
		
			'cons_addsettings' => array(
			        /*array(
			            'field'=>'logo_image',
			            'label' => 'Logo Image',
					    'rules'  => 'trim|required'
			        ),*/

			        array(
			            'field'=>'fb_link',
			            'label' => 'Facebook Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'twitter_link',
			            'label' => 'Twitter Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'pinterest_link',
			            'label' => 'Pinterest Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'linkdin_link',
			            'label' => 'Linkdin Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'gplus_link',
			            'label' => 'Google+ Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'youtube_link',
			            'label' => 'Youtube Link',
					    'rules'  => 'trim|required'
			        ),
			),
			'admin_addsettings' => array(
			        /*array(
			            'field'=>'logo_image',
			            'label' => 'Logo Image',
					    'rules'  => 'trim|required'
			        ),*/

			        array(
			            'field'=>'fb_link',
			            'label' => 'Facebook Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'twitter_link',
			            'label' => 'Twitter Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'pinterest_link',
			            'label' => 'Pinterest Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'linkdin_link',
			            'label' => 'Linkdin Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'gplus_link',
			            'label' => 'Google+ Link',
					    'rules'  => 'trim|required'
			        ),
			        array(
			            'field'=>'youtube_link',
			            'label' => 'Youtube Link',
					    'rules'  => 'trim|required'
			        ),
			),
			
			'executive_add' => array(
				array(
					'field'	=>	'e_level',
					'label'	=>	'Executive Level',
					'rules'	=>	'trim|required|callback_is_executive_level_exists'
				),
				array(
					'field'	=>	'g_access',
					'label'	=>	'Generation Access',
					'rules'	=>	'trim|required|numeric'
				),
				array(
					'field'	=>	'd_commission',
					'label'	=>	'Direct Commission',
					'rules'	=>	'trim|required|numeric'
				)
			),
			'front_block_add' => array(
				array(
						'field'	=>	'title',
						'label'	=>	'Block Title',
						'rules'	=>	'trim|required'
				),
				array(
						'field'	=>	'image_text',
						'label'	=>	'Image Text',
						'rules'	=>	'trim|required'
				),
			/*	array(
						'field'	=>	'image',
						'label'	=>	'Upload Image',
						'rules'	=>	'trim|required'
				),*/
				array(
						'field'	=>	'link',
						'label'	=>	'Block Link',
						'rules'	=>	'trim|required|callback_url_validation'
				),
				array(
						'field'	=>	'priority',
						'label'	=>	'Priority',
						'rules'	=>	'trim|required|numeric'
				),
				
				),
		'offer_add' => array(
				array(
						'field'	=>	'title',
						'label'	=>	'Block Title',
						'rules'	=>	'trim|required'
				),
				array(
						'field'	=>	'image_text',
						'label'	=>	'Image Text',
						'rules'	=>	'trim|required'
				),
				/*	array(
				 'field'	=>	'image',
						'label'	=>	'Upload Image',
						'rules'	=>	'trim|required'
				),*/
				array(
						'field'	=>	'link',
						'label'	=>	'Block Link',
						'rules'	=>	'trim|required|callback_url_validation'
				),
				array(
						'field'	=>	'priority',
						'label'	=>	'Priority',
						'rules'	=>	'trim|required|numeric'
				),
		
		),
			
	);

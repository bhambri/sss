<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();
$CI->load->helper('language');

$config = array(
		'login'	=>	array(
			array(
				'field'	=>	'username',
				'label'	=>	'lang:username',
				'rules'	=>	'trim|required'),
			array(
				'field'	=>	'password',
				'label'	=>	'lang:password',
				'rules'	=>	'trim|required|min_length[6]')
			),
		'client_add' => array(
	            array
	            (
	                'field' => 'fName',
	                'label' => 'Name',
	                'rules' => 'trim|required'
	            ),
	            array(
	                'field' => 'username',
	                'label' => 'Username',
	                'rules' => 'trim|required|callback_is_client_exists'
	            ),
	            array(
	                'field' => 'email',
	                'label' => 'Email Address',
	                'rules' => 'trim|required|valid_email|callback_is_email_exists'
	            ),
	            array(
	                'field' => 'phone',
	                'label' => 'Phone Number',
	            //    'rules' => 'trim|required|is_natural'
					'rules' => 'trim|required|min_length[4]|max_length[15]'
	            ),
	            array(
	                'field' => 'company',
	                'label' => 'Store Name',
	                'rules' => 'trim|required'
	            ),
	            array(
	                'field' => 'address',
	                'label' => 'Address',
	                'rules' => 'trim|required'
	            ),
				array(
					'field' => 'state_code',
					'label' => 'State',
					'rules' => 'trim|required'
				),
	            array(
	                'field' => 'city',
	                'label' => 'City',
	                'rules' => 'trim|required'
	            ),
	            array(
	                'field' => 'zip',
	                'label' => 'Zip Code',
	                'rules' => 'trim|min_length[4]|max_length[15]'
	            ),
	            array(
	                'field' => 'comments',
	                'label' => 'Comments',
	                'rules' => 'trim|required'
	            )
        	),
		
		'reset_password'=>array(
				array(
					'field' => 'password',
					'label' => 'New Password',
					'rules' => 'trim|required|min_length[6]'),
				array(
					'field' => 'confirm_password',
					'label' => 'Confirm New Password',
					'rules' => 'trim|required|min_length[6]|matches[password]')
		),
		
		'user_register'=>array(
				array(
					'field' => 'name',
					'label' => 'Name',
					'rules' => 'trim|required|min_length[2]|max_length[20]'),						
				array(
					'field' => 'phone',
					'label' => 'Phone No.',
				//	'rules' => 'trim|required|callback_is_valid_phone'
					'rules' => 'trim|required|min_length[4]|max_length[15]'
					),
				array(
					'field' => 'email',
					'label' => 'Email Address',
					'rules' => 'trim|required|valid_email|callback_is_email_exists'),
				array(
					'field' => 'username',
					'label' => 'Username',
					'rules' => 'trim|required|min_length[2]|max_length[20]|callback_is_user_exists'),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required|min_length[6]'),
				array(
					'field' => 'confirm_password',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|min_length[6]|matches[password]'),
				array(
					'field' => 'tnd',
					'label' => 'Term of use',
					'rules' => 'trim|required'),
				),
		
		'consultant_register'=>array(
				array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'trim|required|min_length[2]|max_length[20]'),
				array(
						'field' => 'phone',
						'label' => 'Phone No.',
						//	'rules' => 'trim|required|callback_is_valid_phone'
						'rules' => 'trim|required|min_length[4]|max_length[15]'
				),
				array(
						'field' => 'email',
						'label' => 'Email Address',
						'rules' => 'trim|required|valid_email|callback_is_consultant_email_exists'),
				array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'trim|required|min_length[2]|max_length[20]|callback_is_user_exists'),
				array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'trim|required|min_length[6]'),
				array(
						'field' => 'confirm_password',
						'label' => 'Confirm Password',
						'rules' => 'trim|required|min_length[6]|matches[password]'),
				array(
						'field' => 'tnd',
						'label' => 'Term of use',
						'rules' => 'trim|required'),
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

			'checkout_form'=>array(
		        array(
		            'field' => 'billing_first_name',
		            'label' => 'Billing first name',
		            'rules' => 'trim|required|min_length[2]|max_length[20]'
		        ),
		        array(
		            'field' => 'billing_last_name',
		            'label' => 'Billing last name',
		            'rules' => 'trim|required|min_length[2]|max_length[20]'
		        ),
		        array(
		            'field' => 'billing_state_code',
		            'label' => 'Billing state',
		            'rules' => 'trim|required'
		        ),
		        array(
		            'field' => 'billing_phone',
		            'label' => 'Billing phone',
		       //   'rules' => 'trim|required|is_natural'
					'rules' => 'trim|required|min_length[4]|max_length[15]'	
		        ),
		        array(
		            'field' => 'billing_address',
		            'label' => 'Billing address',
		            'rules' => 'trim|required|min_length[2]|max_length[100]'
		        ),
		        array(
		            'field' => 'billing_city',
		            'label' => 'Billing city',
		            'rules' => 'trim|required|min_length[2]|max_length[20]'
		        ),
		        array(
		            'field' => 'billing_email',
		            'label' => 'Billing email',
		            'rules' => 'trim|required|min_length[2]|max_length[50]'
		        ),
		        array(
		            'field' => 'billing_postal_code',
		            'label' => 'Billing postal code',
		            'rules' => 'trim|required|min_length[4]|max_length[15]'
		        ),
		        array(
		            'field' => 'shipping_first_name',
		            'label' => 'Shipping first name',
		            'rules' => 'trim|required|min_length[2]|max_length[20]'
		        ),
		        array(
		            'field' => 'shipping_last_name',
		            'label' => 'Shipping last name',
		            'rules' => 'trim|required|min_length[2]|max_length[20]'
		        ),
		        array(
		            'field' => 'shipping_state_code',
		            'label' => 'Shipping state',
		            'rules' => 'trim|required'
		        ),
		        array(
		            'field' => 'shipping_phone',
		            'label' => 'Shipping phone',
		        //  'rules' => 'trim|required|is_natural'
					'rules' => 'trim|required|min_length[4]|max_length[15]'
		        ),
		        array(
		            'field' => 'shipping_address',
		            'label' => 'Shipping address',
		            'rules' => 'trim|required|min_length[2]|max_length[100]'
		        ),
		        array(
		            'field' => 'shipping_city',
		            'label' => 'Shipping city',
		            'rules' => 'trim|required|min_length[2]|max_length[20]'
		        ),
		        array(
		            'field' => 'shipping_email',
		            'label' => 'Shipping email',
		            'rules' => 'trim|required|min_length[2]|max_length[50]'
		        ),
		        array(
		            'field' => 'shipping_postal_code',
		            'label' => 'Shipping postal code',
		            'rules' => 'trim|required|min_length[4]|max_length[15]'
		        )

		    ),
			'conatctus' => array(
	            array(
	                'field' => 'name',
	                'label' => 'Your Name',
	                'rules' => 'trim|required'
	            ),
	            array(
	                'field' => 'email',
	                'label' => 'Your Email',
	                'rules' => 'trim|required|valid_email'
	            ),
	            array(
	                'field' => 'phone',
	                'label' => 'Your Phone',
	          //    'rules' => 'trim|required|is_natural'
					'rules' => 'trim|required|min_length[4]|max_length[15]'
	            ),
	            array(
	                'field' => 'subject',
	                'label' => 'Your Subject',
	                'rules' => 'trim|required'
	            ),
	            array(
	                'field' => 'comments',
	                'label' => 'Your message',
	                'rules' => 'trim|required'
	            )
        	) ,
        	'forget_password' => array(
			array(
				'field' => 'email',
				'label' => 'lang:email',
				'rules' => 'trim|required|valid_email|callback_is_email_exists'
				),
			),
			'forgot_password' => array(
				array(
					'field' => 'email',
					'label' => 'Enter Email Address',
					'rules' => 'trim|required|valid_email'
				),
			),
			
			'shipping_address' => array(
			
			    array(
				'field' => 'first_name',
				'label' => 'First Name ',
				'rules' => 'trim|required'
				),
				array(
				'field' => 'last_name',
				'label' => 'Last Name',
				'rules' => 'trim|required'
				),
				array(
				'field' => 'address',
				'label' => 'Address',
				'rules' => 'trim|required'
				),
				
				array(
				'field' => 'state_code',
				'label' => 'State',
				'rules' => 'trim|required'
				),
				array(
				'field' => 'city',
				'label' => 'City',
				'rules' => 'trim|required'
				),
				array(
				'field' => 'postal_code',
				'label' => 'Postal Code',
				'rules' => 'trim|required|min_length[4]|max_length[15]'
				),
				array(
				'field' => 'phone_number',
				'label' => 'Phone Number',
				'rules' => 'trim|required|min_length[4]|max_length[15]'
				),
			),
			
        	'submitrequest' =>  array(
	            array(
	                'field' => 'name',
	                'label' => 'Your Name',
	                'rules' => 'trim|required'
	            ),
	            array(
	                'field' => 'email',
	                'label' => 'Your Email',
	                'rules' => 'trim|required'
	            ),
	            array(
	                'field' => 'how_know',
	                'label' => 'Your message',
	                'rules' => 'trim|required'
	            ),
	            array(
	                'field' => 'address',
	                'label' => 'Address',
	                'rules' => 'trim|required'
	            ),
	            array(
	                'field' => 'city',
	                'label' => 'City',
	                'rules' => 'trim|required'
	            ),
	            array(
	                'field' => 'state',
	                'label' => 'State',
	                'rules' => 'trim|required'
	            ),
	            array(
	                'field' => 'zip',
	                'label' => 'Zip ',
	                'rules' => 'trim|min_length[4]|max_length[15]'
	            ),
	            array(
	                'field' => 'cphone',
	                'label' => 'Day Time Phone Number',
	                'rules' => 'trim|required|min_length[4]|max_length[15]'
	            ),
	            array(
	                'field' => 'invest',
	                'label' => 'When are you looking to invest',
	                'rules' => 'trim|required'
	            ),
	            array(
	                'field' => 'units',
	                'label' => 'No Of Units',
	                'rules' => 'trim|required'
	            )
	        ) ,

	);

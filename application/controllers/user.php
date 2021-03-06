<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Class:		User extends VCI_Controller defined in libraries
 *	Author:	
 *	Platform:	Codeigniter
 *	Company:	Cogniter Technologies
 *	Description: Manage USer entity
 */
class User extends VCI_Controller {

    #Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
		$this->load->library('paypal');
		$this->load->model('user_model');
		$this->load->model('client_model');  // for social links
		$this->_vci_layout('store_default');
		$this->__is_valid_store();

		//custom theme option
		if( $this->uri->segment(1) )
        {   
            $username =  $this->uri->segment(1);
        }
        $is_custom_theme = 0 ;
		$store = $this->common_model->get_clientdetail(trim(strtolower($username)));
		if( count($store) >0 ){
			$username =  strtolower($store[0]['username']);
			$storeid = $store[0]['id'] ;
			$is_custom_theme = $store[0]['is_custom_theme'];
		}
		if($is_custom_theme){
			$this->_vci_layout('store_default' ,$username.'_'.$storeid);
		}else{
			$this->_vci_layout('store_default');
		}
		//custom theme option 
	}

	/**
	 * method name  register
     * purpose		for register page.
     * @param 		none
     */
	function register()
	{
		$storeuser = $this->uri->segments[1] ;
		
       	$this->load->model('product_model');

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		$userData = $this->session->userdata('storeUserSession');
			        if(!empty($userData)){
			        	$this->session->set_flashdata('errors', 'Already logged in, access denied');
			        	$this->output->set_header('location:' . base_url() .  $this->storename . '/store');
			        }
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

        $popularcat = $this->common_model->getpopularsubcatlist($storeid) ;

		// new code
        if ( $this->input->post( 'formSubmitted' ) > 0 )
        {
        	//print_r($_REQUEST); die;
            if ( $this->form_validation->run('user_register') )
            {            
            	
            	$data = array(
				'name' 		    => htmlspecialchars($this->input->post('name')),
				'phone' 		=> htmlspecialchars($this->input->post('phone')),
				'email' 		=> htmlspecialchars($this->input->post('email')),			
				'password' 		=> md5( htmlspecialchars($this->input->post('password')) ),
				'username' 		=> htmlspecialchars($this->input->post('username')),
				'store_id'		=> $this->store_id,
				'status'		=> 1,
				'role_id'		=> 3
				);
                if ( $this->user_model->add_user( $data ) )
                {
                   	$this->session->set_flashdata( 'success', 'Thank you for registering with us, You can login now.' );
                    	// user login starts now
			                	$where_data = array(
								'username' => $this->input->post('username'),
								'status'   => 1,
								'password' => md5( $this->input->post('password') ),
								'store_id' => $storeid,
								'role_id'  => 3
								);
							    if( ( $user = $this->common_model->findWhere( 'users', $where_data, $multi_record = FALSE, $order = '' ) ) == false )
								{
									
									$this->session->set_flashdata('errors', 'The username or password you entered is incorrect');
									$this->output->set_header('location:' . base_url() .  $this->storename . '/user/login'); 
								} 
								else
								{
									
									unset( $user['password'] );
									$this->session->set_userdata('storeUserSession',$user);
									$this->session->set_flashdata( 'success', 'Thank you for registering with us' );
													    
									$this->output->set_header('location:' . base_url() .  $this->storename . '/home');
								}
			                	// user login ends now
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
                else
                {
                    $view_data = $this->input->post();

                    $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
            }
            else
            {
                $view_data = $this->input->post();
                $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
               // redirect($_SERVER['HTTP_REFERER']) ;
            }
        }
		//form not submitted load view normally
        $view_data['states'] = $this->common_model->get_state();
        $view_data['popularcat'] = $popularcat ;

		$this->_vci_view('store/register', $view_data);
	}

	function cregister()
	{
		$storeuser = $this->uri->segments[1] ;
        #$this->_vci_layout('clientstore_default');
		$this->__is_valid_client_store() ;
			
		//$this->_vci_layout('clientstore_default');

       	$this->load->model('product_model');

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
			$is_custom_theme = $store[0]['is_custom_theme'];
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		if($is_custom_theme){
			$this->_vci_layout('clientstore_default' ,$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default');
		}
		
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

        $popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
        $userData = $this->session->userdata('storeUserSession');
			        if(!empty($userData)){
			        	$this->session->set_flashdata('errors', 'Already logged in, access denied');
			        	$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/'.$this->uri->segment(2). '/store');
			        }
		// new code
        if ( $this->input->post( 'formSubmitted' ) > 0 )
        {
        	//print_r($_REQUEST); die;
            if ( $this->form_validation->run('user_register') )
            {            
            	
            	$data = array(
				'name' 		    => htmlspecialchars($this->input->post('name')),
				'phone' 		=> htmlspecialchars($this->input->post('phone')),
				'email' 		=> htmlspecialchars($this->input->post('email')),			
				'password' 		=> md5( htmlspecialchars($this->input->post('password')) ),
				'username' 		=> htmlspecialchars($this->input->post('username')),
				'store_id'		=> $this->store_id,
				'status'		=> 1,
				'role_id'		=> 3
				);
                if ( $this->user_model->add_user( $data ) )
                {
                    $this->session->set_flashdata( 'success', 'Thank you for registering with us, You can login now.' );
                    //$this->session->set_flashdata( 'success', 'Thank you for registering with us, You can login now.' );
                    // user login starts now
                	$where_data = array(
					'username' => $this->input->post('username'),
					'status'   => 1,
					'password' => md5( $this->input->post('password') ),
					'store_id' => $storeid,
					'role_id'  => 3
					);
				    if( ( $user = $this->common_model->findWhere( 'users', $where_data, $multi_record = FALSE, $order = '' ) ) == false )
					{
						
						$this->session->set_flashdata('errors', 'The username or password you entered is incorrect');
						$this->output->set_header('location:' . base_url() .  $this->storename . '/user/login'); 
					} 
					else
					{
						
						unset($user['password']);
						$this->session->set_userdata('storeUserSession',$user);
						$this->session->set_flashdata( 'success', 'Thank you for registering with us' );
										    
						$this->output->set_header('location:' . base_url() .  $this->storename . '/home');
					}
                	// user login ends now
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
                else
                {
                    $view_data = $this->input->post();

                    $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
            }
            else
            {
                $view_data = $this->input->post();
                $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
               // redirect($_SERVER['HTTP_REFERER']) ;
            }
        }
			//form not submitted load view normally
        $view_data['states'] = $this->common_model->get_state();
        $view_data['popularcat'] = $popularcat ;

		$this->_vci_view('store/cregister', $view_data);
	}

	/**
	 * method name  consultant
     * purpose		for registering consultant page.
     * @param 		none
     */
	function consultant()
	{
		
		error_reporting(0);
		$storeuser = $this->uri->segments[1] ;
       	$this->load->model('product_model');

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;
		
        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
			$consultantfee = $store[0]['consultantfee'] ;
			$signupfee =  $store[0]['signupfee'] ;
			$billing_start_delay = $store[0]['billing_start_delay'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
	
		if( $consultantfee == 0 || $signupfee == 0 ){
		     
		     $this->session->set_flashdata( 'errors', 'Failed! Fee is not set yet. Signup cannot be completed.' );
		     //$this->output->set_header('location: ' . base_url() .  $this->storename . '/home');
		     
		    if($_SERVER['HTTP_REFERER']){
			  redirect($_SERVER['HTTP_REFERER']);
			  exit;		
			}else{
			  redirect(base_url() .$this->storename .'/home');
			  exit;
			}
		}
		$userData = $this->session->userdata('storeUserSession');
        if(!empty($userData)){
        	$this->session->set_flashdata('errors', 'Already logged in, access denied');
        	$this->output->set_header('location:' . base_url() .  $this->storename . '/store');
        }

        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

        $popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
		// new code

		// rule name conatctus
        if ( $this->input->post( 'formSubmitted' ) > 0 )
        {
        	//print_r($_REQUEST); die;
            if ( $this->form_validation->run('consultant_register') )
            {            
            	
            	$data = array(
				'name' 		    => htmlspecialchars($this->input->post('name')),
				'phone' 		=> htmlspecialchars($this->input->post('phone')),
				'email' 		=> htmlspecialchars($this->input->post('email')),			
				'password' 		=> md5( htmlspecialchars($this->input->post('password')) ),
				'username' 		=> htmlspecialchars($this->input->post('username')),
				'store_id'		=> $this->store_id,
				'status'		=> 0,
				'role_id'		=> 4,
            	'created'       => date("Y-m-d h:i:s")
				);
            	
            	$response_consultant_id = $this->user_model->add_user( $data );
            	
                if ( $response_consultant_id )
                {
                   $this->output->set_header('location:' . base_url() .  $this->storename . '/user/consultant_recurring_payment/'.$response_consultant_id);
                }
                else
                {
                    $view_data = $this->input->post();

                    $view_data['popularcat'] = $popularcat ;
                    
                    $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            else
            {
                $view_data = $this->input->post();
                $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
               // redirect($_SERVER['HTTP_REFERER']) ;
            }
        }
		//form not submitted load view normally
        $view_data['states'] = $this->common_model->get_state();
        $view_data['popularcat'] = $popularcat ;
		$this->_vci_view('store/consultant', $view_data);
	}

	/**
	 * method name  clientconsultant
     * purpose		for registering consultant under another consultant page.
     * @param 		none
     */
	function clientconsultant()
	{
		$this->__is_valid_client_store() ;
			
		//$this->_vci_layout('clientstore_default');

		$storeuser = $this->uri->segments[1] ;

        $this->load->model('common_model');
       	$this->load->model('user_model') ;
       	$this->load->model('product_model');

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
			$consultantfee = $store[0]['consultantfee'] ;
			$signupfee =  $store[0]['signupfee'] ;
			$billing_start_delay = $store[0]['billing_start_delay'] ;
			$is_custom_theme = $store[0]['is_custom_theme'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		if($is_custom_theme){
			$this->_vci_layout('clientstore_default' ,$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default');
		}

		if( $consultantfee == 0 || $signupfee == 0 ){
		     
		     $this->session->set_flashdata( 'errors', 'Failed! Fee is not set yet. Signup cannot be completed.' );
		     //$this->output->set_header('location: ' . base_url() .  $this->storename . '/home');
		     
		    if($_SERVER['HTTP_REFERER']){
			  redirect($_SERVER['HTTP_REFERER']);
			  exit;		
			}else{
			  redirect(base_url() .$this->storename .'/'.$this->uri->segments[2].'/home');
			  exit;
			}
		}
		$userData = $this->session->userdata('storeUserSession');
        if(!empty($userData)){
        	$this->session->set_flashdata('errors', 'Already logged in, access denied');
        	$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/'.$this->uri->segment(2). '/store');
        }
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

        $consultant = $this->user_model->is_consultant_exists(trim($this->uri->segments[2]), $storeid) ;
		
		$consultant_user_id = $consultant[0]->id ;

        $popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
		// new code

		// rule name conatctus
        if ( $this->input->post( 'formSubmitted' ) > 0 )
        {
        	//print_r($_REQUEST); die;
            if ( $this->form_validation->run('consultant_register') )
            {            
            	
            	$data = array(
				'name' 		=> htmlspecialchars($this->input->post('name')),
				'phone' 		=> htmlspecialchars($this->input->post('phone')),
				'email' 		=> htmlspecialchars($this->input->post('email')),			
				'password' 		=> md5( htmlspecialchars($this->input->post('password')) ),
				'username' 		=> htmlspecialchars($this->input->post('username')),
				'store_id'		=> $this->store_id,
				'status'		=> 0,
				'role_id'		=> 4,
				'parent_consultant_id' =>$consultant_user_id ,
            	'created'       => date("Y-m-d h:i:s")
				);
            	
            	$response_consultant_id = $this->user_model->add_user( $data );
            	
                if ( $response_consultant_id )
                {
                	$this->output->set_header('location:' . base_url() .  $this->storename .'/'.$this->uri->segments[2]. '/user/consultant_recurring_payment/'.$response_consultant_id);
                }
                else
                {
                    $view_data = $this->input->post();

                    $view_data['popularcat'] = $popularcat ;
                    
                    $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            else
            {
                $view_data = $this->input->post();
                $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
               // redirect($_SERVER['HTTP_REFERER']) ;
            }
        }
		//form not submitted load view normally
        $view_data['states'] = $this->common_model->get_state();
        $view_data['popularcat'] = $popularcat ;
		$this->_vci_view('store/cconsultant', $view_data);
	}

	/**
	 * method name  consultant_recurring_payment
     * purpose		for making consultant recurring payment
     * @param 		none
     */
	function consultant_recurring_payment()
	{

		$this->__is_valid_store(); 
		error_reporting(1);
		
		$view_data = '';	

		$consultant_id = $this->uri->segments[4];
		$storeid       = $this->store_id;
		
		$store_settings = $this->common_model->getstoresetting($storeid) ;

		$storedetail = $this->common_model->get_clientdetail('',$storeid);
		$feeAmount = $storedetail[0]['consultantfee'] > 0 ? $storedetail[0]['consultantfee'] : 10 ;
		$signupfee = $storedetail[0]['signupfee']  ;
		$billing_start_delay = $storedetail[0]['billing_start_delay']  ;
		
		if($signupfee == 0 && $billing_start_delay == 0 && $feeAmount != 0){
			$billing_start_delay = 1;
			$signupfee = $feeAmount ;
		}

		#print_r($storedetail);
		#print_r($store_settings) ;
		
		if(count($store_settings) == 0)
		{
			$this->session->set_flashdata( 'errors', 'Failed !, Payment can not be done, Pay options are not configured yet By Store' );
			$this->output->set_header('location:' . base_url() .  $this->storename . '/user/consultant');
			exit;
		}
		
		$PayPalApiUsername 		= $store_settings[0]->paypal_username; //PayPal API Username
		$PayPalApiPassword 		= $store_settings[0]->paypal_password; //Paypal API password
		$PayPalApiSignature 	= $store_settings[0]->paypal_signature;  //Paypal API Signature
		
		//paypal settings

		$PayPalMode 			= PAY_MODE ; // sandbox or live
	
		$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code
		$PayPalReturnURL 		= site_url() . $this->storename . '/user/success/'.$consultant_id; //'http://localhost/paypal-shopping-cart-example/paypal-express-checkout/process.php'; //Point to process.php page
		$PayPalCancelURL 		= site_url() . $this->storename . '/user/cancel'; //Cancel URL if user clicks cancel

		

		$paypal_data ='';
		$ItemTotalPrice = $feeAmount ;
		//$ItemTotalPrice = $feeAmount + $signupfee ;
		$key = 0;
		$total = 0;
		
	    $paypal_product['items'][$key] = array('itm_name'=>"Initial Fee",
	    		'itm_price'=>$signupfee,
	    		'itm_code'=>"Sign up fee",
	    		'itm_qty'=>1
	    );
	   
		$this->session->set_userdata('paypal_productsdata', $paypal_product);
		$d = date("Y-m-d", time());
	    $t = date("h:i:s", time());
	    //$billing_start_delay = 2 ;
		if($billing_start_delay){
			
			$date = new DateTime();
			$interval = new DateInterval('P'.$billing_start_delay.'M');
			//print_r($interval);
			$date->add($interval);
			$d = $date->format('Y-m-d') . "\n";
		}
		//echo '<pre>';
	    #print_r($paypal_product);
	    
	    #die;
	    $profile_start_date = $d."T".$t."Z";
	    $description = "Consultant setup fee for subscription  to store";
	    $billing_period = "Month";
	    $billing_frequency = 1;
	    $currency_code = "USD";
	    $recurring_payment = "RecurringPayments";
	    //$recurring_payment = "MerchantInitiatedBilling";
	    //$same_every_time   = "SameEveryTime";
	    $same_every_time   = "Set up fee will be one time and a charge of $ ".$feeAmount." will be monthly after ".$billing_start_delay." months";
		
			
		$padata = 	'&METHOD=SetExpressCheckout'.
			    '&VERSION='.urlencode( "64.0" ).
	    		'&RETURNURL='.urlencode($PayPalReturnURL ).
	    		'&CANCELURL='.urlencode($PayPalCancelURL).
	    		'&PAYMENTACTION='.urlencode( "Authorization" ).
	    		'&AMT='.urlencode($signupfee).
	    		'&CURRENCYCODE='.urlencode($currency_code).
	    		'&DESC='.urlencode($description).
	    		'&L_PAYMENTREQUEST_0_NAME0='.urlencode( "Consultant Account setup fee" ).
	    		'&L_PAYMENTREQUEST_0_AMT0='.urlencode( $signupfee ).
	    		'&L_PAYMENTREQUEST_0_QTY0='.urlencode( 1 ).
	    		//$paypal_data.
			    '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
			    '&L_BILLINGTYPE0='.$recurring_payment.
			    '&L_BILLINGAGREEMENTDESCRIPTION0='.$same_every_time.
			    '&NOSHIPPING=0'. //set 1 to hide buyer's shipping address, in-case products that does not require shipping
			    '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($signupfee).
			    '&PAYMENTREQUEST_0_AMT='.urlencode($signupfee).
			    '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
			    '&LOCALECODE=GB'. //PayPal pages to match the language on your website.
			    //'&LOGOIMG=http://www.cogniter.com/images/index/logo_n.jpg'. //site logo
			    '&CARTBORDERCOLOR=FFFFFF'. //border color of cart
			    '&ALLOWNOTE=1';

		$httpParsedResponseAr = $this->paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
		
    	//Respond according to message we receive from Paypal
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
		{
			$paypalmode = PAY_MODE;
//			$paypalurl ='https://www.'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
			$paypalurl = 'https://www.'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr['TOKEN'];
			if($paypalmode == 'live'){
			$paypalurl = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr['TOKEN'];
			}
			#success
			header('Location: '.$paypalurl);
		}
		else
		{
			$this->session->set_flashdata( 'errors', 'Failed !, Pay options not configured correctly' );
            redirect($_SERVER['HTTP_REFERER']);exit;
			//Show error message
			echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			echo '<pre>';
			#print_r($httpParsedResponseAr);
			echo '</pre>';
		}
	}

	
	/**
	 * method name  cl_consultant_recurring_payment
     * purpose		for making consultant recurring under another consulatnt payment
     * @param 		none
     */
	function cl_consultant_recurring_payment()
	{
		$this->__is_valid_client_store() ;
			
		//$this->_vci_layout('clientstore_default');

		error_reporting(0);
		$storeUserSession = $this->session->userdata('storeUserSession');
		$view_data = '';	

		$this->load->model('user_model') ;

		// Dynamic value 
		$consultant_id = $this->uri->segments[5];
		$storeid       = $this->store_id;
		
		$consultant = $this->user_model->is_consultant_exists(trim($this->uri->segments[2]), $storeid) ;
		
		$consultant_user_id = $consultant[0]->id ;

		$store_settings = $this->common_model->getstoresetting($storeid) ;
		$storedetail = $this->common_model->get_clientdetail('',$storeid);
		$feeAmount = $storedetail[0]['consultantfee'] > 0 ? $storedetail[0]['consultantfee'] : 10 ;
		$signupfee = $storedetail[0]['signupfee'] ;
		$billing_start_delay = $storedetail[0]['billing_start_delay']  ;
		$store_username = $storedetail[0]['username'] ;

		if($is_custom_theme){
			$this->_vci_layout('clientstore_default' ,$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default');
		}

		if($signupfee == 0 && $billing_start_delay == 0 && $feeAmount != 0){
			$billing_start_delay = 1;
			$signupfee = $feeAmount ;
		}

		if(count($store_settings) == 0)
		{
			$this->session->set_flashdata( 'errors', 'Failed !, Payment can not be done, Pay options are not configured yet By Store' );
			$this->output->set_header('location:' . base_url() .  $this->storename .'/'.$this->uri->segments[2].'/user/consultant');
			exit;
		}
		
		$PayPalApiUsername 		= $store_settings[0]->paypal_username; //PayPal API Username
		$PayPalApiPassword 		= $store_settings[0]->paypal_password; //Paypal API password
		$PayPalApiSignature 	= $store_settings[0]->paypal_signature;  //Paypal API Signature
		
		//paypal settings
		$PayPalMode 			= PAY_MODE; // sandbox or live
	
		$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code
		$PayPalReturnURL 		= site_url() . $this->storename .'/'.$this->uri->segments[2].'/user/success/'.$consultant_id; //'http://localhost/paypal-shopping-cart-example/paypal-express-checkout/process.php'; //Point to process.php page
		$PayPalCancelURL 		= site_url() . $this->storename .'/'.$this->uri->segments[2].'/user/cancel'; //Cancel URL if user clicks cancel


		$paypal_data ='';
		$ItemTotalPrice = $feeAmount;
		$key = 0;
		$total = 0;

	    $paypal_product['items'][$key] = array('itm_name'=>"Subscribe Consultant",
	    		'itm_price'=>$ItemTotalPrice,
	    		'itm_code'=>"Subscribe Consultant",
	    		'itm_qty'=>1
	    );	   
			  
		$this->session->set_userdata('paypal_productsdata', $paypal_product);
	
	    $d = date("Y-m-d", time());
	    $t = date("h:i:s", time());
	    $profile_start_date = $d."T".$t."Z";
	    $description = "Consultant subscribe to store";
	    $billing_period = "Month";
	    $billing_frequency = 1;
	    $currency_code = "USD";
	    $recurring_payment = "RecurringPayments";
	    //$same_every_time   = "SameEveryTime";
	    //$same_every_time   = "Set up fee will be one time and a charge of $ ".$feeAmount." will be monthly";
	    $same_every_time   = "Set up fee will be one time and a charge of $ ".$feeAmount." will be monthly after ".$billing_start_delay." months";
	    
		$padata = 	'&METHOD=SetExpressCheckout'.
			    '&VERSION='.urlencode( "64.0" ).
	    		'&RETURNURL='.urlencode($PayPalReturnURL ).
	    		'&CANCELURL='.urlencode($PayPalCancelURL).
	    		'&PAYMENTACTION='.urlencode( "Authorization" ).
	    		'&AMT='.urlencode($signupfee).
	    		'&CURRENCYCODE='.urlencode($currency_code).
	    		'&DESC='.urlencode($description).
	    		'&L_PAYMENTREQUEST_0_NAME0='.urlencode( "Consultant Account setup fee" ).
	    		'&L_PAYMENTREQUEST_0_AMT0='.urlencode( $signupfee ).
	    		'&L_PAYMENTREQUEST_0_QTY0='.urlencode( 1 ).
	    		//$paypal_data.
			    '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
			    '&L_BILLINGTYPE0='.$recurring_payment.
			    '&L_BILLINGAGREEMENTDESCRIPTION0='.$same_every_time.
			    '&NOSHIPPING=0'. //set 1 to hide buyer's shipping address, in-case products that does not require shipping
			    '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($signupfee).
			    '&PAYMENTREQUEST_0_AMT='.urlencode($signupfee).
			    '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
			    '&LOCALECODE=GB'. //PayPal pages to match the language on your website.
			    //'&LOGOIMG=http://www.cogniter.com/images/index/logo_n.jpg'. //site logo
			    '&CARTBORDERCOLOR=FFFFFF'. //border color of cart
			    '&ALLOWNOTE=1';
			    
		$httpParsedResponseAr = $this->paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
			    
    	//Respond according to message we receive from Paypal
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
		{
			$paypalmode = PAY_MODE;

			$paypalurl = 'https://www.'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr['TOKEN'];
			if($paypalmode == 'live'){
			$paypalurl = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr['TOKEN'];
			}
			#success
			header('Location: '.$paypalurl);
		}
		else
		{	$this->session->set_flashdata( 'errors', 'Failed !, Pay options not configured correctly' );
                        redirect($_SERVER['HTTP_REFERER']);
			exit;
			//Show error message
			echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			echo '<pre>';
			#print_r($httpParsedResponseAr);
			echo '</pre>';
		}
	}

	/**
	 * method name  success
     * purpose		After success on regsitration as consulatnt, paypal success url
     * @param 		none
     */
	function success()
	{
		
		
		$this->__is_valid_store();
		$consultant_id = $this->uri->segments[4];
		$storeid       = $this->store_id;
		
		$store_settings = $this->common_model->getstoresetting($storeid) ;

		$storedetail = $this->common_model->get_clientdetail('',$storeid);
		
		$feeAmount = $storedetail[0]['consultantfee'] > 0 ? $storedetail[0]['consultantfee'] : 10 ;
		
		$signupfee = $storedetail[0]['signupfee']   ;
		$billing_start_delay = $storedetail[0]['billing_start_delay']   ;
		
		if($signupfee == 0 && $billing_start_delay == 0 && $feeAmount != 0){
			$billing_start_delay = 1;
			$signupfee = $feeAmount ;
		}

		if(count($store_settings) == 0)
		{
			$this->session->set_flashdata( 'errors', 'Failed !, Payment can not be done, Pay options are not configured yet By Store' );
			$this->output->set_header('location:' . base_url() .  $this->storename . '/user/consultant');
			exit;
		}
		
		$PayPalApiUsername 		= $store_settings[0]->paypal_username; //PayPal API Username
		$PayPalApiPassword 		= $store_settings[0]->paypal_password; //Paypal API password
		$PayPalApiSignature 	= $store_settings[0]->paypal_signature;  //Paypal API Signature
		
		//if(isset($_GET["token"]))
		if(isset($_GET["token"]) && isset($_GET["PayerID"]))
		{
			$token = $_GET["token"];
			$payer_id = @$_GET["PayerID"];
			
			$PayPalMode 			= PAY_MODE; // sandbox or live
		
			$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code

			$padata = 	'&METHOD=GetExpressCheckoutDetails'.
					'&VERSION='.urlencode( "64.0" ).
					'&TOKEN='.urldecode($token);
			
			$httpParsedResponseAr = $this->paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
			
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
			{
				$PayPalMode 			= PAY_MODE; // sandbox or live
			
				$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code
					
				$ItemTotalPrice = $feeAmount ;
				$currency_code = "USD";
				$recurring_payment = "RecurringPayments";
				//$same_every_time   = "SameEveryTime";
				//$same_every_time   = "Set up fee will be one time and a charge of $ ".$feeAmount." will be monthly";
				$same_every_time   = "Set up fee will be one time and a charge of $ ".$feeAmount." will be monthly after ".$billing_start_delay." months";

				$padata3 = 	'&METHOD=DoExpressCheckoutPayment'.
						'&VERSION='.urlencode( "64.0" ).
						'&TOKEN='.urldecode($token).
						'&INITAMT='.urlencode($signupfee).
				//		'&PAYMENTACTION='.urldecode("Authorization").
						'&PAYMENTACTION='.urldecode("Sale").
						'&PAYERID='.urlencode($payer_id).
						'&AMT='.urldecode($ItemTotalPrice).
						'&CURRENCYCODE='.urlencode($currency_code).
						'&L_BILLINGTYPE0='.urlencode($recurring_payment).
						'&L_BILLINGAGREEMENTDESCRIPTION0='.urlencode($same_every_time);
					
				$httpParsedResponseAr3 = $this->paypal->PPHttpPost('DoExpressCheckoutPayment', $padata3, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
				//echo 'printing do-express checkout pay details';
				
				if("SUCCESS" == strtoupper($httpParsedResponseAr3["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr3["ACK"]))
				{
					$PayPalMode 			= PAY_MODE; // sandbox or live
					$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code

					$d = date("Y-m-d", time());
					$t = date("h:i:s", time());
					if($billing_start_delay){
			
						$date = new DateTime();
						$interval = new DateInterval('P'.$billing_start_delay.'M');
						//print_r($interval);
						$date->add($interval);
						$d = $date->format('Y-m-d') . "\n";
					}

					$profile_start_date = $d."T".$t."Z";
					$ItemTotalPrice = $feeAmount;
					$currency_code = "USD";
					$recurring_payment = "RecurringPayments";
					//$same_every_time   = "SameEveryTime";
					//$same_every_time   = "Set up fee will be one time and a charge of $ ".$feeAmount." will be monthly";
					$same_every_time   = "Set up fee will be one time and a charge of $ ".$feeAmount." will be monthly after ".$billing_start_delay." months";
					$max_failed_payment = 3;
					$billing_period = "Month";
					$billing_frequency = 1;
					
					$padata4 = 	'&METHOD=CreateRecurringPaymentsProfile'.
							'&VERSION='.urlencode( "64.0" ).
							'&TOKEN='.urldecode($token).
							'&INITAMT='.urlencode($signupfee).
							//'&SUBSCRIBERNAME='.urlencode("Mr Subscriber").
							'&PROFILESTARTDATE='.urlencode($profile_start_date).
							'&DESC='.urlencode($same_every_time).
							'&MAXFAILEDPAYMENTS='.urlencode($max_failed_payment).
							'&AUTOBILLAMT='.urlencode("AddToNextBilling").
							'&BILLINGPERIOD='.urldecode($billing_period).
							'&BILLINGFREQUENCY='.urlencode($billing_frequency).
							'&AMT='.urldecode($ItemTotalPrice).
							'&CURRENCYCODE='.urlencode($currency_code);
						
					$httpParsedResponseAr4 = $this->paypal->PPHttpPost('CreateRecurringPaymentsProfile', $padata4, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
					
					
					if( strtoupper($httpParsedResponseAr4['ACK']) == 'SUCCESS' )
					{
						$data = array(
								'consultant_id' => trim($consultant_id),
								'store_id' 		=> trim($storeid),
								'transaction_id'=> trim($httpParsedResponseAr3['TRANSACTIONID']),
								'profile_id' 	=> trim($httpParsedResponseAr4['PROFILEID']),
								'correlation_id'=> trim($httpParsedResponseAr4['CORRELATIONID']),
								// 'amount'		=> trim($httpParsedResponseAr3['AMT']),
								'amount'		=> trim($signupfee),
								'ack'		    => trim($httpParsedResponseAr4['ACK']),
								'profile_status'=> trim($httpParsedResponseAr4['PROFILESTATUS']),
								'payment_status'=> trim($httpParsedResponseAr3['PAYMENTSTATUS']),
								'order_time'	=> trim(urldecode($httpParsedResponseAr3['ORDERTIME'])),
								'created'       => date("Y-m-d h:i:s")
						);
						 
						if( $this->user_model->add_consultant_payment( $data ) )
						{
							$data = array(
									'status'     => 0,
									'modified'   => date("Y-m-d h:i:s")
							);
							$this->user_model->update_consultant_status( $consultant_id, $data );
							
							//email start

							$social_links = $this->client_model->get_client_social_links( trim($storeid) );
							$store_company_name = $this->client_model->get_client_details( trim($this->storename) );
							
							$this->fb_link        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
							$this->twitter_link   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
							$this->pinterest_link = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
							$this->linkdin_link   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
							$this->gplus_link     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
							$this->youtube_link   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
							
							
							$response_email = $this->user_model->get_new_consultant_detail( $consultant_id );
							$email    = $response_email[0]->email;
							$username = $response_email[0]->username;
							$consultant_login_link = base_url().'administrator/consultant';
							
							$s_email_address = $this->session->userdata('user');
							$store_email_address = trim($s_email_address['email']);
							
							//Send Email Below
							$this->load->library('email');
							$this->load->library('parser');
							$smtp_settings = $this->config->item('smtp');
							//$sender_from = $this->config->item($this->config->config['sender_from']);
							//$sender_name = $this->config->item($this->config->config['sender_name']);
							$sender_from = $this->config->item('sender_from');
							$sender_name = $this->config->item('sender_name');
							$this->email->initialize( $smtp_settings );
							$this->email->from( $sender_from, $sender_name );
							$this->email->to( htmlspecialchars( $email ) );
							
							
							$ndata = array(
									'base_url'         => base_url(),
									'facebook_link'    => $this->fb_link,
									'linkdin_link'     => $this->linkdin_link,
									'twitter_link'     => $this->twitter_link,
									'googleplus_link'  => $this->gplus_link,
									'pinterest_link'   => $this->pinterest_link,
									'youtube_link'     => $this->youtube_link,
									'email_logo'       => substr($this->logo_image, 1),
									'facebook_image'   => 'application/views/default/images/fb.png',
									'linkdin_image'    => 'application/views/default/images/in.png',
									'twitter_image'    => 'application/views/default/images/twitter.png',
									'googleplus_image' => 'application/views/default/images/googleplus.png',
									'pinterest_image'  => 'application/views/default/images/p.png',
									'youtube_image'    => 'application/views/default/images/youtb.png',
									'title' => $this->consultant_label.' Register Successfully',
									'CONTENT' => 'Please <a href="'.$consultant_login_link.'">Click Here</a> for login as consultant in admin section, Your account will be activated shortly.',
									'USER'=> htmlspecialchars( ucwords( $username ) ),
									'regards' => ucwords($store_company_name->company)
								);
								
							// get data from email_template id number 2
							$res_email_template = $this->common_model->get_email_template_data(2);
							$body = $this->parser->parse2($res_email_template->content, $ndata, true);
						//	$body = $this->parser->parse('default/store/emails/consultant_register', $ndata, true);
							$this->email->bcc($this->config->config['sender_from']);
							$this->email->bcc($store_email_address);
							$this->email->subject($this->consultant_label.' Register Successfully - '.ucwords($store_company_name->company));
							$this->email->message( $body );
							
							if ( ! $this->email->send())
							{
								echo $this->email->print_debugger();
							}
							else
							{
								$this->session->set_flashdata('success', ' You have been successfully registered as a '.$this->consultant_label.'. Please check your email.');
								$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/user/consultant/');
							}
							
							// email end
						}
					}
				}	
			}	
		}
		//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
	}

	/**
	 * method name  clientsuccess
     * purpose		cancel url call
     * param 		none
     */

	function cancel(){
		echo 'pay process cancelled now' ;
		die;
	}
	/**
	 * method name  clientsuccess
     * purpose		After success on regsitration from subconsultant as consulatnt, paypal success url
     * @param 		none
     */
	function clientsuccess()
	{
		$this->__is_valid_client_store() ;
		
		///$this->_vci_layout('clientstore_default');
		$consultant_id = $this->uri->segments[5];
		//die;
		$storeid       = $this->store_id;
		$store_settings = $this->common_model->getstoresetting($storeid) ;

		$storedetail = $this->common_model->get_clientdetail('',$storeid);
		$feeAmount = $storedetail[0]['consultantfee'] > 0 ? $storedetail[0]['consultantfee'] : 10 ;
		$signupfee = $storedetail[0]['signupfee']  ;
		$billing_start_delay = $storedetail[0]['billing_start_delay']   ;

		$store_username = $storedetail[0]['username'] ;
		$is_custom_theme = $storedetail[0]['is_custom_theme'] ;
		/* added by g */
		$is_mlmtype = $storedetail[0]['is_mlmtype'] ;

		if($is_custom_theme){
			$this->_vci_layout('clientstore_default' ,$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default');
		}

		if($signupfee == 0 && $billing_start_delay == 0 && $feeAmount != 0){
			$billing_start_delay = 1; // default is month
			$signupfee = $feeAmount ;
		}

		if(count($store_settings) == 0)
		{
			$this->session->set_flashdata( 'errors', 'Failed !, Payment can not be done, Pay options are not configured yet By Store' );
			$this->output->set_header('location:' . base_url() .  $this->storename .'/'.$this->uri->segments[2].'/user/consultant');
			exit;
		}
		
		$PayPalApiUsername 		= $store_settings[0]->paypal_username; //PayPal API Username
		$PayPalApiPassword 		= $store_settings[0]->paypal_password; //Paypal API password
		$PayPalApiSignature 	= $store_settings[0]->paypal_signature;  //Paypal API Signature
		
		if(isset($_GET["token"]) && isset($_GET["PayerID"]))
		{
			$token = $_GET["token"];
			$payer_id = $_GET["PayerID"];
			$PayPalMode 			= PAY_MODE; // sandbox or live
			$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code

			$padata = 	'&METHOD=GetExpressCheckoutDetails'.
					'&VERSION='.urlencode( "64.0" ).
					'&TOKEN='.urldecode($token);
			
			$httpParsedResponseAr = $this->paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
			
			
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
			{
				$PayPalMode 		= PAY_MODE; // sandbox or live
				$PayPalCurrencyCode = 'USD'; //Paypal Currency Code
					
				$ItemTotalPrice = $feeAmount ;
				$currency_code = "USD";
				$recurring_payment = "RecurringPayments";
				//$same_every_time   = "SameEveryTime";
				$same_every_time   = "Set up fee will be one time and a charge of $ ".$feeAmount." will be monthly after ".$billing_start_delay." months";

				$padata3 = 	'&METHOD=DoExpressCheckoutPayment'.
						'&VERSION='.urlencode( "64.0" ).
						'&TOKEN='.urldecode($token).
				//		'&PAYMENTACTION='.urldecode("Authorization").
						'&PAYMENTACTION='.urldecode("Sale").
						'&PAYERID='.urlencode($payer_id).
						'&AMT='.urldecode($ItemTotalPrice).
						'&CURRENCYCODE='.urlencode($currency_code).
						'&L_BILLINGTYPE0='.urlencode($recurring_payment).
						'&L_BILLINGAGREEMENTDESCRIPTION0='.urlencode($same_every_time);
					
				$httpParsedResponseAr3 = $this->paypal->PPHttpPost('DoExpressCheckoutPayment', $padata3, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
			
				if("SUCCESS" == strtoupper($httpParsedResponseAr3["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr3["ACK"]))
				{
					$PayPalMode 			= PAY_MODE; // sandbox or live
					$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code

					$d = date("Y-m-d", time());
					$t = date("h:i:s", time());
					if($billing_start_delay){
			
						$date = new DateTime();
						$interval = new DateInterval('P'.$billing_start_delay.'M');
						//print_r($interval);
						$date->add($interval);
						$d = $date->format('Y-m-d') . "\n";
					}
					
					$profile_start_date = $d."T".$t."Z";
					$ItemTotalPrice = $feeAmount;
					$currency_code = "USD";
					$recurring_payment = "RecurringPayments";
					//$same_every_time   = "SameEveryTime";
					$same_every_time   = "Set up fee will be one time and a charge of $ ".$feeAmount." will be monthly after ".$billing_start_delay." months";
					$max_failed_payment = 3;
					$billing_period = "Month";
					$billing_frequency = 1;
					
							$padata4 = 	'&METHOD=CreateRecurringPaymentsProfile'.
							'&VERSION='.urlencode( "64.0" ).
							'&TOKEN='.urldecode($token).
							'&INITAMT='.urlencode($signupfee).
							//'&SUBSCRIBERNAME='.urlencode("Mr Subscriber").
							'&PROFILESTARTDATE='.urlencode($profile_start_date).
							'&DESC='.urlencode($same_every_time).
							'&MAXFAILEDPAYMENTS='.urlencode($max_failed_payment).
							'&AUTOBILLAMT='.urlencode("AddToNextBilling").
							'&BILLINGPERIOD='.urldecode($billing_period).
							'&BILLINGFREQUENCY='.urlencode($billing_frequency).
							'&AMT='.urldecode($ItemTotalPrice).
							'&CURRENCYCODE='.urlencode($currency_code);
						
					$httpParsedResponseAr4 = $this->paypal->PPHttpPost('CreateRecurringPaymentsProfile', $padata4, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
					
					if( strtoupper($httpParsedResponseAr4['ACK']) == 'SUCCESS' )
					{
						$data = array(
								'consultant_id' => trim($consultant_id),
								'store_id' 		=> trim($storeid),
								'transaction_id'=> trim($httpParsedResponseAr3['TRANSACTIONID']),
								'profile_id' 	=> trim($httpParsedResponseAr4['PROFILEID']),
								'correlation_id'=> trim($httpParsedResponseAr4['CORRELATIONID']),
								//'amount'		=> trim($httpParsedResponseAr3['AMT']),
								'amount'		=> trim($signupfee),
								'ack'		    => trim($httpParsedResponseAr4['ACK']),
								'profile_status'=> trim($httpParsedResponseAr4['PROFILESTATUS']),
								'payment_status'=> trim($httpParsedResponseAr3['PAYMENTSTATUS']),
								'order_time'	=> trim(urldecode($httpParsedResponseAr3['ORDERTIME'])),
								'created'       => date("Y-m-d h:i:s")
						);
						 
						if( $this->user_model->add_consultant_payment( $data ) )
						{
							$data = array(
									'status'     => 0,
									'modified'   => date("Y-m-d h:i:s")
							);
							$this->user_model->update_consultant_status( $consultant_id, $data );
							/* code by G */
							if($is_mlmtype){
							$pconsultant = $this->user_model->is_consultant_exists(trim($this->uri->segments[2]), $storeid) ;
							$pconsultant_user_id = $pconsultant[0]->id ;
							$this->addbtree($consultant_id,$pconsultant_user_id , $storeid) ;
		
							}							
							/* code added by G ends here */

							//email start

							$social_links = $this->client_model->get_client_social_links( trim($storeid) );
							$store_company_name = $this->client_model->get_client_details( trim($this->storename) );
							
							$this->fb_link        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
							$this->twitter_link   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
							$this->pinterest_link = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
							$this->linkdin_link   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
							$this->gplus_link     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
							$this->youtube_link   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
							
							
							$response_email = $this->user_model->get_new_consultant_detail( $consultant_id );
							$email    = $response_email[0]->email;
							$username = $response_email[0]->username;
							$consultant_login_link = base_url().'administrator/consultant';
							
							$s_email_address = $this->session->userdata('user');
							$store_email_address = trim($s_email_address['email']);
							
							//Send Email Below
							$this->load->library('email');
							$this->load->library('parser');
							$smtp_settings = $this->config->item('smtp');
							//$sender_from = $this->config->item($this->config->config['sender_from']);
							//$sender_name = $this->config->item($this->config->config['sender_name']);
							$sender_from = $this->config->item('sender_from');
							$sender_name = $this->config->item('sender_name');
							$this->email->initialize( $smtp_settings );
							$this->email->from( $sender_from, $sender_name );
							$this->email->to( htmlspecialchars( $email ) );
							
							
							$ndata = array(
									'base_url'         => base_url(),
									'facebook_link'    => $this->fb_link,
									'linkdin_link'     => $this->linkdin_link,
									'twitter_link'     => $this->twitter_link,
									'googleplus_link'  => $this->gplus_link,
									'pinterest_link'   => $this->pinterest_link,
									'youtube_link'     => $this->youtube_link,
									'email_logo'       => substr($this->logo_image, 1),
									'facebook_image'   => 'application/views/default/images/fb.png',
									'linkdin_image'    => 'application/views/default/images/in.png',
									'twitter_image'    => 'application/views/default/images/twitter.png',
									'googleplus_image' => 'application/views/default/images/googleplus.png',
									'pinterest_image'  => 'application/views/default/images/p.png',
									'youtube_image'    => 'application/views/default/images/youtb.png',
									'title' => 'Consultant Register Successfully',
									'CONTENT' => 'Please <a href="'.$consultant_login_link.'">Click Here</a> for login as consultant in admin section, Your account will be activated shortly.',
									'USER'=> htmlspecialchars( ucwords( $username ) ),
									'regards' => ucwords($store_company_name->company)
							);

							$res_email_template = $this->common_model->get_email_template_data(2);
							$body = $this->parser->parse2($res_email_template->content, $ndata, true);
						//	$body = $this->parser->parse('default/store/emails/consultant_register', $ndata, true);
							$this->email->bcc($this->config->config['sender_from']);
							$this->email->bcc($store_email_address);
							$this->email->subject('Consultant Register Successfully - '.ucwords($store_company_name->company));
							$this->email->message( $body );
							
							if ( ! $this->email->send())
							{
								echo $this->email->print_debugger();
							}
							else
							{
								//$this->session->set_flashdata('success', $this->lang->line('consultant_register_success'));
								$this->session->set_flashdata('success', ' You have been successfully registered as a '.$this->consultant_label.'. Please check your email.');
								$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/'.$this->uri->segment(2).'/user/consultant/');
							}
							
							//email end
						}
					}
				}
				
			}
			
		}
		//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
	}



	/**
	 *	Method: is_client_exists
	 *	@param clientname string
	 *	Description: Callback method used for unique clientname check
 	 *	by form validation rules defined in config/form_validation.php
	 */
	function is_user_exists($clientname)
	{
		$storeuser = $this->uri->segments[1] ;
		$store = $this->common_model->get_clientdetail($storeuser);
		$storeid = '' ;
		
		if( count($store) >0 )
		{
			$storeid = $store[0]['id'] ;
		}
		else
		{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
		return (!empty($this->clientid)) ? !$this->user_model->is_user_exists($clientname, $storeid, $this->clientid) : !$this->user_model->is_user_exists($clientname, $storeid);
	}

	/*
	*	Method: is_email_exists
	*	@param email string
	*	Description: Callback method used for unique email check by
		form validation rules defined in config/form_validation.php
	*/

	function is_email_exists($email)
	{
		$storeuser = $this->uri->segments[1] ;
		$store = $this->common_model->get_clientdetail($storeuser);
		$storeid = '' ;
		
		if( count($store) >0 )
		{
			$storeid = $store[0]['id'] ;
		}
		else
		{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
		return (!empty($this->clientid)) ? !$this->user_model->is_email_exists($email, $storeid, $this->clientid) : !$this->user_model->is_email_exists($email, $storeid);
	}
	
	function is_consultant_email_exists($email)
	{
		$storeuser = $this->uri->segments[1] ;
		$store = $this->common_model->get_clientdetail($storeuser);
		$storeid = '' ;
	
		if( count($store) >0 )
		{
			$storeid = $store[0]['id'] ;
		}
		else
		{
			echo "<h1>Invalid store URL</h1>"; die;
		}
	
		return (!empty($this->clientid)) ? !$this->user_model->is_consultant_email_exists($email, $storeid, $this->clientid) : !$this->user_model->is_consultant_email_exists($email, $storeid);
	}
	
	/**
	 * method name  login
     * purpose		for login
     * @param 		none
     */
	function login()
	{	
		error_reporting(0);	
		$this->__is_valid_store();
		
		$storeuser = $this->uri->segments[1];
        $this->load->model('common_model');
       	$this->load->model('product_model');

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
        $popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
        
        $view_data['popularcat'] = $popularcat ;

        $userData = $this->session->userdata('storeUserSession');
        if(!empty($userData)){
        	$this->session->set_flashdata('errors', 'Already logged in, access denied');
        	$this->output->set_header('location:' . base_url() .  $this->storename . '/store');
        }

		$return_url = FALSE;
		
		if( isset( $_GET['url'] ) && !empty( $_GET['url'] ) )
		{
			//$return_url = urldecode( $_GET['url'] ); 
		}

		if($this->input->post('loginFormSubmitted') > 0)
		{
		    		
			if($this->form_validation->run('login'))
			{ 
				//echo $storeid.'store id printing' ;die;
				$where_data = array(
					'username' => $this->input->post('username'),
					'status'   => 1,
					'password' => md5( $this->input->post('password') ),
					'store_id' => $storeid,
					'role_id'  => 3
				);
			    if( ( $user = $this->common_model->findWhere( 'users', $where_data, $multi_record = FALSE, $order = '' ) ) == false )
				{
					
					$this->session->set_flashdata('errors', 'The username or password you entered is incorrect');
					$this->output->set_header('location:' . base_url() .  $this->storename . '/user/login'); 
				} 
				else
				{
					
					unset( $user['password'] );
					$this->session->set_userdata('storeUserSession',$user);

					if( $return_url )
					{
						$this->output->set_header( 'location:' . $return_url );
					}				    
					$this->output->set_header('location:' . base_url() .  $this->storename . '/home');
				}
			} else
			{
				$data['errors'] = true;
				$data['popularcat'] = $popularcat ;
				$this->_vci_view('store/login',$data);
			}
		}
		else
		{
			$view_data = '';
			$view_data['popularcat'] = $popularcat ;
			
			$this->_vci_view('store/login', $view_data);
		}
	}

	/**
	 * method name  clogin
     * purpose		for login at consultant section urls
     * @param 		none
     */

	function clogin()
	{	
		error_reporting(0);	
		$this->__is_valid_client_store() ;
		//$this->_vci_layout('clientstore_default');

		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
       	
       	$this->load->model('product_model');

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
			$is_custom_theme =  $store[0]['is_custom_theme'];
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		if($is_custom_theme){
			$this->_vci_layout('clientstore_default' ,$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default');
		}
		
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
        $popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
        
        $view_data['popularcat'] = $popularcat ;
		// new code

		
		$userData = $this->session->userdata('storeUserSession');
        if(!empty($userData)){
        	$this->session->set_flashdata('errors', 'Already logged in, access denied');
        	$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/'.$this->uri->segment(2). '/store');
        }

		$return_url = FALSE;
		
		if( isset( $_GET['url'] ) && !empty( $_GET['url'] ) )
		{
			//$return_url = urldecode( $_GET['url'] ); 
		}


		if($this->input->post('loginFormSubmitted') > 0)
		{
		    		
			if($this->form_validation->run('login'))
			{ 
				//echo $storeid.'store id printing' ;die;
				
				$where_data = array(
					'username' => $this->input->post('username'),
					'status'   => 1,
					'password' => md5( $this->input->post('password') ),
					'store_id' => $storeid,
					'role_id'  => 3
				);
			    if( ( $user = $this->common_model->findWhere( 'users', $where_data, $multi_record = FALSE, $order = '' ) ) == false )
				{
					
					$this->session->set_flashdata('errors', 'The username or password you entered is incorrect');
					$this->output->set_header('location:' . base_url() .  $this->storename .'/'.$this->uri->segment(2).'/user/login'); 
				} 
				else
				{
					unset( $user['password'] );
					$this->session->set_userdata('storeUserSession',$user);

					if( $return_url )
					{
						$this->output->set_header( 'location:' . $return_url );
					}				    
					$this->output->set_header('location:' . base_url() .  $this->storename .'/'.$this->uri->segment(2).'/home');
				}
			} else
			{
				$data['errors'] = true;
				$data['popularcat'] = $popularcat ;
				$this->_vci_view('store/clogin',$data);
			}
		}
		else
		{
			$view_data = '';
			$view_data['popularcat'] = $popularcat ;
			
			$this->_vci_view('store/clogin', $view_data);
		}
	}

	/**
	 * method name  logout
     * purpose		for logout
     * @param 		none
     */
	function logout()
	{
		$this->__is_valid_store();
		$this->load->library('cart');
		// clear the user created data.
		$this->session->unset_userdata('storeUserSession');
		$this->cart->destroy();
		// clear the system session data.
		// inform user about logout.
		//$this->session->set_flashdata('success', $this->lang->line('logout_success'));
		$this->output->set_header('location:' . base_url() .  $this->storename . '/home');
	}

	/**
	 * method name  account
     * purpose		for account
     * @param 		none
     */
	function account()
	{
	    $this->__is_valid_store();
		$view_data = '';
		
		$storeuser = $this->uri->segments[1] ;
        
       	$this->load->model('product_model');


		if(!is_array($this->session->userdata("storeUserSession")))
		{
			$this->session->set_flashdata('errors', 'Please login, access denied');
			header("location:".base_url() .  $this->storename . '/home');
			exit;
		}		
		
        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

		$userDetails = $this->session->userdata("storeUserSession");

		if(empty($userDetails)){
        	$this->session->set_flashdata('errors', 'Please login, access denied');
        	$this->output->set_header('location:' . base_url() .  $this->storename . '/store');
        }

		$view_data['userDetails']   = $userDetails;
		$user_id                    = $userDetails['id'];
    	$store_id                   = $userDetails['store_id'];
        
        
    	//$shipping = $this->user_model->getShipping( $store_id, $user_id );
    	$shipping = $this->user_model->getprimaryShipping( $store_id, $user_id );
        $view_data['shippingDetails']   = $shipping;
        $orders = $this->user_model->getOrders( $store_id, $user_id );
        $view_data['orders'] =  $orders;
		
		//$wishlists = $this->user_model->getWishlist( $store_id, $user_id );
        //$view_data['wishlists'] =  $wishlists;
        
        $favourites = $this->user_model->getFavourite( $store_id, $user_id );
        $view_data['favourites'] =  $favourites;
		#pr($view_data) ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid);
		$view_data['popularcat'] = $popularcat;
		$this->_vci_view('store/user_account', $view_data);
	}

	/**
	 * method name  consultant_useraccount
     * purpose		for account at consultant section
     * @param 		none
     */
	function consultant_useraccount()
	{
	    $this->__is_valid_client_store() ;
	    $this->_vci_layout('clientstore_default');
		$view_data = '';
		
		$storeuser = $this->uri->segments[1] ;
       	$this->load->model('product_model');

        $store = $this->common_model->get_clientdetail($storeuser);
 		$storeid = '' ;
        $store_role = '' ;
        $is_custom_theme = '' ;
        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
			$is_custom_theme = $store[0]['is_custom_theme'];
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
		if($is_custom_theme){
			$this->_vci_layout('clientstore_default' ,$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default');
		}

        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$userDetails = $this->session->userdata("storeUserSession");
		if(empty($userDetails)){
        	$this->session->set_flashdata('errors', 'Please login, access denied');
        	$this->output->set_header('location:' . base_url() .  $this->storename . '/store');
        }

		$view_data['userDetails']   = $userDetails;
		$user_id                    = $userDetails['id'];
    	$store_id                   = $userDetails['store_id'];
        
    	//$shipping = $this->user_model->getShipping( $store_id, $user_id );
    	$shipping = $this->user_model->getprimaryShipping( $store_id, $user_id );
        $view_data['shippingDetails']   = $shipping;
        $orders = $this->user_model->getOrders( $store_id, $user_id );
        $view_data['orders'] =  $orders;
		
		//$wishlists = $this->user_model->getWishlist( $store_id, $user_id );
        //$view_data['wishlists'] =  $wishlists;
        
        $favourites = $this->user_model->getFavourite( $store_id, $user_id );
        $view_data['favourites'] =  $favourites;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid);
		$view_data['popularcat'] = $popularcat;
		$this->_vci_view('store/user_claccount', $view_data);
	}

	/**
	 * method name  myorders
     * purpose		users oorders
     * @param 		none
     */
	function myorders()
	{
		$this->__is_valid_store();
		$this->load->model('common_model');
		$this->load->library('pagination') ;
		$storeuser = $this->uri->segments[1] ;

		$store = $this->common_model->get_clientdetail($storeuser);
 		$segs = $this->uri->segment_array();
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$userDetails = $this->session->userdata("storeUserSession");

		if(empty($userDetails)){
        	$this->session->set_flashdata('errors', 'Please login, access denied');
        	$this->output->set_header('location:' . base_url() .  $this->storename . '/store');
        }

		$view_data['userDetails']   = $userDetails;
		$user_id                    = $userDetails['id'];
    	$store_id                   = $userDetails['store_id'];

		$view_data = array() ;
		$per_page = 10 ;
		$page = ( isset( $segs[4] ) ) ? (int)$segs[4]: 0;	

		$getData = array();
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() .$store_username."/user/myorders?s=";
		$config['base_url'] = base_url() .$store_username."/user/myorders";
		$config['uri_segment'] = 4;

		$config['total_rows'] = intval($this->user_model->get_all_order_user( $page, $per_page, TRUE ,$storeid, $user_id )) ;

		$orders = $this->user_model->get_all_order_user( $page, $per_page, false ,$storeid, $user_id );

		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();

        $view_data['orders'] =  $orders;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid);
		$view_data['popularcat'] = $popularcat;
		$this->_vci_view('store/user_order', $view_data);
	}

	/**
	 * method name  cmyorders
     * purpose		for orders of a customer at consultant end
     * @param 		none
     */

	function cmyorders()
	{
		$this->__is_valid_client_store() ;
	    //$this->_vci_layout('clientstore_default');
		
		$this->load->model('common_model');
		$this->load->library('pagination') ;
		$storeuser = $this->uri->segments[1] ;

		$store = $this->common_model->get_clientdetail($storeuser);
 		$segs = $this->uri->segment_array();
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
			$is_custom_theme = $store[0]['is_custom_theme'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		if($is_custom_theme){
			$this->_vci_layout('clientstore_default' ,$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default');
		}

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

		$userDetails = $this->session->userdata("storeUserSession");

		if(empty($userDetails)){
        	$this->session->set_flashdata('errors', 'Please login, access denied');
        	$this->output->set_header('location:' . base_url() .  $this->uri->segment(1) .'/'.$this->uri->segment(2). '/store');
        }

		$view_data['userDetails']   = $userDetails;
		$user_id                    = $userDetails['id'];
    	$store_id                   = $userDetails['store_id'];

		$view_data = array() ;
		$per_page = 10 ;
		$page = ( isset( $segs[5] ) ) ? (int)$segs[5]: 0;	

		$getData = array();
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() .$store_username.'/'.$this->uri->segment(2)."/user/myorders?s=";
		$config['base_url'] = base_url() .$store_username.'/'.$this->uri->segment(2)."/user/myorders";
		$config['uri_segment'] = 5;

		$config['total_rows'] = intval($this->user_model->get_all_order_user( $page, $per_page, TRUE ,$storeid, $user_id )) ;
		$orders = $this->user_model->get_all_order_user( $page, $per_page, false ,$storeid, $user_id );

		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();

        $view_data['orders'] =  $orders;
        $popularcat = $this->common_model->getpopularsubcatlist($storeid);
		$view_data['popularcat'] = $popularcat;
		$this->_vci_view('store/user_corder', $view_data);
	}

	/**
	 * method name  orderview
     * purpose		users orderview
     * @param 		none
     */
	function orderview(){
		$this->__is_valid_store();
		$segs = $this->uri->segments;
		
		//categories section
		$storeuser = $this->uri->segments[1] ;

		$store = $this->common_model->get_clientdetail($storeuser);
 		$segs = $this->uri->segment_array();
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		// store categories ends here
		
		$userDetails = $this->session->userdata("storeUserSession");
		if(empty($userDetails)){
        	$this->session->set_flashdata('errors', 'Please login, access denied');
        	$this->output->set_header('location:' . base_url() .  $this->storename . '/store');
        }

		$this->load->model('common_model') ;
		
		$view_data = array();
		$where_data = array('store_id' => $storeid, 'order_id' => $segs[4] );
		$shipping_data = $this->common_model->findWhere( 'shipping', $where_data, $multi_record = FALSE, $order = '' );
		$billing_data = $this->common_model->findWhere( 'billing', $where_data, $multi_record = FALSE, $order = '' );

		
		$view_data['order'] 		= $this->common_model->order_view($segs[4]);
		$view_data['order_detail']  = $this->common_model->order_detail($segs[4]) ;
		$view_data['shipping_data'] = $shipping_data ;
		$view_data['billing_data']  = $billing_data ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid);
		$view_data['popularcat'] = $popularcat;
		$this->_vci_view('store/order_detail',$view_data) ;
	}

	/**
	 * method name  corderview
     * purpose		users orderview at consultant section
     * @param 		none
     */
	function corderview(){
		$this->__is_valid_client_store() ;
	    ///$this->_vci_layout('clientstore_default');

	    $segs = $this->uri->segments;
		
		//categories section
		$storeuser = $this->uri->segments[1] ;

		$store = $this->common_model->get_clientdetail($storeuser);
 		$segs = $this->uri->segment_array();
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
			$is_custom_theme = $store[0]['is_custom_theme'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		if($is_custom_theme){
			$this->_vci_layout('clientstore_default' ,$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default');
		}

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		// store categories ends here
		$userDetails = $this->session->userdata("storeUserSession");

		if(empty($userDetails)){
        	$this->session->set_flashdata('errors', 'Please login, access denied');
        	$this->output->set_header('location:' . base_url() .  $this->storename .'/'.$this->uri->segment(2).'/store');
        }

		$this->load->model('common_model') ;

		$where_data = array('store_id' => $storeid, 'order_id' => $segs[5] );
		$shipping_data = $this->common_model->findWhere( 'shipping', $where_data, $multi_record = FALSE, $order = '' );
		$billing_data = $this->common_model->findWhere( 'billing', $where_data, $multi_record = FALSE, $order = '' );

		$view_data = array();
		
		$view_data['order'] 		= $this->common_model->order_view($segs[5]);
		$view_data['order_detail']  = $this->common_model->order_detail($segs[5]) ;
		$view_data['shipping_data'] = $shipping_data ;
		$view_data['billing_data']  = $billing_data ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid);
		$view_data['popularcat'] = $popularcat;
		$this->_vci_view('store/corder_detail',$view_data) ;
	}

	/**
	 * method name  reset_password
     * purpose		Rest password
     * @param 		none
     */
	function reset_password()
	{
		error_reporting(0);
		$this->__is_valid_store();

		$storeuser = $this->uri->segments[1] ;
		$store = $this->common_model->get_clientdetail($storeuser);
 		$segs = $this->uri->segment_array();
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

		if ( $this->input->post( 'formSubmitted' ) > 0 )
		{
			if ( $this->form_validation->run('reset_password') )
			{
				$id = trim($this->input->post('user_id'));
				$data = array(
						'password' 		=> md5( htmlspecialchars($this->input->post('password')) )
				);
				if ( $this->user_model->reset_password( $data, $id ) )
				{
					$this->session->set_flashdata('success', $this->lang->line('password_reset_success'));
					$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/user/reset_password/');
				}
				else
				{
					$this->session->set_flashdata('errors', $this->lang->line('password_reset_fail'));
					$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/user/reset_password/');
				}	
			}
		}
		$popularcat = $this->common_model->getpopularsubcatlist($storeid);
		$view_data['popularcat'] = $popularcat;

		$view_data = '';
		$this->_vci_view('store/user_reset_password', $view_data);
	}

	/**
	 * method name  creset_password
     * purpose		Rest password consultant section
     * @param 		none
     */

	function creset_password()
	{
		error_reporting(0);
		#$this->__is_valid_store();
		$this->__is_valid_client_store() ;
	    $this->_vci_layout('clientstore_default');

		$storeuser = $this->uri->segments[1] ;
		$store = $this->common_model->get_clientdetail($storeuser);
 		$segs = $this->uri->segment_array();
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
			$is_custom_theme = $store[0]['is_custom_theme'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		if($is_custom_theme){
			$this->_vci_layout('clientstore_default' ,$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default');
		}

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

		if ( $this->input->post( 'formSubmitted' ) > 0 )
		{
			if ( $this->form_validation->run('reset_password') )
			{
				$id = trim($this->input->post('user_id'));
				$data = array(
						'password' 		=> md5( htmlspecialchars($this->input->post('password')) )
				);
				if ( $this->user_model->reset_password( $data, $id ) )
				{
					$this->session->set_flashdata('success', $this->lang->line('password_reset_success'));
					$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/'.$this->uri->segment(2).'/user/reset_password/');
				}
				else
				{
					$this->session->set_flashdata('errors', $this->lang->line('password_reset_fail'));
					$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/'.$this->uri->segment(2).'/user/reset_password/');
				}	
			}
		}
		
		$view_data = '';
		$popularcat = $this->common_model->getpopularsubcatlist($storeid);
		$view_data['popularcat'] = $popularcat;

		$this->_vci_view('store/cuser_reset_password', $view_data);
	}
	
	/**
	 * method name  forgot_password
     * purpose		Forgot password by user
     * @param 		none
     */
	function forgot_password()
	{
		error_reporting(0);	
		$this->__is_valid_store();
		
		$storeuser = $this->uri->segments[1] ;
		$store = $this->common_model->get_clientdetail($storeuser);
 		$segs = $this->uri->segment_array();
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
		$store_settings = $this->common_model->getstoresetting($storeid) ;
		$email_logo = '';
		if($store_settings[0]->logo_image){
		$email_logo = $store_settings[0]->logo_image ;
		}

		$userData = $this->session->userdata('storeUserSession');
        if(!empty($userData)){
        	$this->session->set_flashdata('errors', 'Already logged in, access denied');
        	$this->output->set_header('location:' . base_url() .  $store_username . '/store');
        }

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

		if ( $this->input->post( 'formSubmitted' ) > 0 )
		{
			if ( $this->form_validation->run('forgot_password') )
			{
				$store_id = $this->store_id;
				$email = trim(strtolower(htmlspecialchars($this->input->post('email'))));
				 
				$response = $this->user_model->getUserDetail($email, $store_id);
				if( $response )
				{	
				
					$id = $response[0]->id;
					$reset_password_link = base_url().$this->uri->segment(1).'/user/reset_password/'.base64_encode($id);
					 
					//Send Email Below
					$this->load->library('email');
					$this->load->library('parser');
					$smtp_settings = $this->config->item('smtp');
					$sender_from = $this->config->item('sender_from');
					$sender_name = $this->config->item('sender_name');
					$this->email->initialize( $smtp_settings );
					$this->email->from( $sender_from, $sender_name );
					$this->email->to( htmlspecialchars( $email ) );
					 
					 
					$ndata = array(
					 		'title' => 'Reset Password',
							'email_logo'=>$email_logo ,
							'base_url'=> 'http://'.$_SERVER['HTTP_HOST'] ,
					 		'CONTENT' => 'Please <a href="'.$reset_password_link.'">Click Here</a> for reset your password.',
					 		'USER'=> htmlspecialchars( ucwords( $email ) )
					);
					
					$body = $this->parser->parse('default/store/emails/reset_password', $ndata, true);
					
					//$this->email->cc('another@another-example.com');
					$this->email->subject('Reset your password');
					$this->email->message( $body );
					 
					if ( ! $this->email->send())
					{
					 	echo $this->email->print_debugger();
					}
					else
					{
						$this->session->set_flashdata('success', $this->lang->line('password_check_email'));
						$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/user/forgot_password/');
					 	// Mail to admin to inform about contact form submission
					}
					//email end
				}
				else
				{
					$view_data = $this->input->post();
					$this->session->set_flashdata( 'errors', 'Failed !, This email is not registered with store' );
					//redirect($_SERVER['HTTP_REFERER']) ;
					$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/user/forgot_password/');
				}
			}
		}
		$view_data = '';
		$this->_vci_view('store/user_forgot_password', $view_data);
	}

	/**
	 * method name  cforgot_password
     * purpose		Forgot password by user - consultant end
     * @param 		none
     */

	function cforgot_password()
	{
		error_reporting(0);	
		$this->__is_valid_client_store() ;
	    $this->_vci_layout('clientstore_default');

		$storeuser = $this->uri->segments[1] ;
		$store = $this->common_model->get_clientdetail($storeuser);
 		$segs = $this->uri->segment_array();
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
			$is_custom_theme = $store[0]['is_custom_theme'];
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		$store_settings = $this->common_model->getstoresetting($storeid) ;
		$email_logo = '';
		if($store_settings[0]->logo_image){
		$email_logo = $store_settings[0]->logo_image ;
		}

		if($is_custom_theme){
			$this->_vci_layout('clientstore_default' ,$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default');
		}

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		
		$userData = $this->session->userdata('storeUserSession');
        if(!empty($userData)){
        	$this->session->set_flashdata('errors', 'Already logged in, access denied');
        	$this->output->set_header('location:' . base_url() .  $store_username .'/'.$this->uri->segment(2).'/store');
        }

		if ( $this->input->post( 'formSubmitted' ) > 0 )
		{
			if ( $this->form_validation->run('forgot_password') )
			{
				$store_id = $this->store_id;
				$email = trim(strtolower(htmlspecialchars($this->input->post('email'))));
				 
				$response = $this->user_model->getUserDetail($email, $store_id);
				if( $response )
				{	
				
					$id = $response[0]->id;
					$reset_password_link = base_url().$this->uri->segment(1).'/user/reset_password/'.base64_encode($id);
					 
					//Send Email Below
					$this->load->library('email');
					$this->load->library('parser');
					$smtp_settings = $this->config->item('smtp');
					$sender_from = $this->config->item('sender_from');
					$sender_name = $this->config->item('sender_name');
					$this->email->initialize( $smtp_settings );
					$this->email->from( $sender_from, $sender_name );
					$this->email->to( htmlspecialchars( $email ) );
					 
					 
					$ndata = array(
					 		'title' => 'Reset Password',
							'email_logo'=>$email_logo ,
							'base_url'=> 'http://'.$_SERVER['HTTP_HOST'] ,
					 		'CONTENT' => 'Please <a href="'.$reset_password_link.'">Click Here</a> for reset your password.',
					 		'USER'=> htmlspecialchars( ucwords( $email ) )
					);
					
					$body = $this->parser->parse('default/store/emails/reset_password', $ndata, true);
					
					//$this->email->cc('another@another-example.com');
					$this->email->subject('Reset your password');
					$this->email->message( $body );
					 
					if ( ! $this->email->send())
					{
					 	echo $this->email->print_debugger();
					}
					else
					{
						$this->session->set_flashdata('success', $this->lang->line('password_check_email'));
						$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/'.$this->uri->segment(2).'/user/forgot_password/');
					 	// Mail to admin to inform about contact form submission
					}
					//email end
				}
				else
				{
					$view_data = $this->input->post();
					$this->session->set_flashdata( 'errors', 'Failed !, This email is not registered with store' );
					//redirect($_SERVER['HTTP_REFERER']) ;
					$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/'.$this->uri->segment(2).'/user/forgot_password/');
				}
			}
		}
		$view_data = '';
		$this->_vci_view('store/cuser_forgot_password', $view_data);
	}
	
	/**
	 * method name  deleteWishList
     * purpose		For deletion of wishlist
     * @param 		id 
     */
	function deleteWishList( $id=null )
	{
	    $id = $this->uri->segment(4);
	    if( $this->user_model->deleteWishList( $id ) )
	    {
            redirect( $_SERVER['HTTP_REFERER'] );
	    }
	}

	/**
	 * method name  cdeleteWishList
     * purpose		For deletion of wishlist - consultant end
     * @param 		id 
     */
	function cdeleteWishList( $id=null )
	{
	    $id = $this->uri->segment(5);
	    if( $this->user_model->deleteWishList( $id ) )
	    {
            redirect( $_SERVER['HTTP_REFERER'] );
	    }
	}

	/**
	 * method name  deleteFavourites
     * purpose		For deletion of favourites
     * @param 		id 
     */
	function deleteFavourites( $id=null )
	{
	    $id = $this->uri->segment(4);
	    if( $this->user_model->deleteFavourite( $id ) )
	    {
            redirect( base_url() . $this->uri->segment(1).'/user/account' );
	    }
	}
	/**
	 * method name  cdeleteFavourites
     * purpose		For deletion of favourites - consultant end
     * @param 		id 
     */
	function cdeleteFavourites( $id=null )
	{
	    $id = $this->uri->segment(5);
	    if( $this->user_model->deleteFavourite( $id ) )
	    {
            redirect( base_url() . $this->uri->segment(1).'/'.$this->uri->segment(2).'/user/account' );
	    }
	}

	/*
	* method changepassword
	* purpose  For changing the password
	*/
	function changepassword(){
		//error_reporting(1);
		$this->load->model('user_model');  // for social links
		//$this->load->library('form_validation');
		$this->__is_valid_store();

		$storeuser = $this->uri->segments[1] ;
		$store = $this->common_model->get_clientdetail($storeuser);
 		$segs = $this->uri->segment_array();
 		$storeid = '' ;
        $store_role = '' ;
        #echo '<pre>';
        #print_r($store);
        if(!is_array($this->session->userdata("storeUserSession")))
		{
			$this->session->set_flashdata('errors', 'Please login, access denied');
			header("location:".base_url() .  $this->storename .'/home');
			exit;
		}

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		$userData = $this->session->userdata('storeUserSession');
		
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

		#print_r($_POST);
		if ( !empty($_POST))
		{
			// Array ( [id] => 386 [old_password] => sdsdsds [new_password] => sadasdasd [formsubmitted] => 1 ) 
			
			$oldpassword = $_POST['old_password'] ;
			$new_password = $_POST['new_password'] ;
			$password_length = count($new_password);
			$userdetails = $this->user_model->get_store_user_details($userData['id']);
			
			if ( strlen($new_password) > 5 && strlen($oldpassword) > 0 )
			{
				$id = $userData['id'] ;
				if( ($userdetails->password != md5( htmlspecialchars($oldpassword)))){
					
					$this->session->set_flashdata('errors', 'Old password is not matching');
					$this->output->set_header('location:' . base_url().$this->uri->segment(1).'/user/changepassword/');
					
				}else{
					$data = array(
						'password' 		=> md5( htmlspecialchars($new_password) )
					);

					if ( $this->user_model->reset_password( $data, $id ) )
					{
						$this->session->set_flashdata('success', 'Password updated successfully');
						$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/user/changepassword/');
					}
					else
					{
						$this->session->set_flashdata('errors', 'Password updation failed');
						$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/user/changepassword/');
					}
				}	
			}else{
				// length should be greater than 5 characters
				// old password should not be empty
				
				$this->session->set_flashdata('errors', 'Failed, Please check the input, Password length should be greater than five');
			    $this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/user/changepassword/');
			}

		}
		
		$view_data = '';
		$view_data['breadcrumbdata'] = array('Home /'=> base_url() .$store_username."/home" ,
        									'Change Password'=>'') ;
		$view_data['id'] = $userData['id'] ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid);
		$view_data['popularcat'] = $popularcat;
		//$this->_vci_view('store/user_reset_password', $view_data);
		$this->_vci_view('store/changepassword', $view_data);
	}

	/*
	* method changepassword
	* purpose  For changing the password
	*/
	function cchangepassword(){
		//error_reporting(1);
		$this->load->model('user_model');  // for social links
		//$this->load->library('form_validation');
		$this->__is_valid_client_store() ;

		$storeuser = $this->uri->segments[1] ;
		$store = $this->common_model->get_clientdetail($storeuser);
 		$segs = $this->uri->segment_array();
 		$storeid = '' ;
        $store_role = '' ;
        #echo '<pre>';
        #print_r($store);
        if(!is_array($this->session->userdata("storeUserSession")))
		{
			$this->session->set_flashdata('errors', 'Please login, access denied');
			header("location:".base_url() .  $this->storename .'/'.$this->uri->segment(2).'/home');
			exit;
		}

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
			$is_custom_theme =  $store[0]['is_custom_theme'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		if($is_custom_theme){
			$this->_vci_layout('clientstore_default' ,$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default');
		}

		$userData = $this->session->userdata('storeUserSession');
		
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

		#print_r($_POST);
		if ( !empty($_POST))
		{
			// Array ( [id] => 386 [old_password] => sdsdsds [new_password] => sadasdasd [formsubmitted] => 1 ) 
			
			$oldpassword = $_POST['old_password'] ;
			$new_password = $_POST['new_password'] ;
			$password_length = count($new_password);
			$userdetails = $this->user_model->get_store_user_details($userData['id']);
			
			if ( strlen($new_password) > 5 && strlen($oldpassword) > 0 )
			{
				$id = $userData['id'] ;
				if( ($userdetails->password != md5( htmlspecialchars($oldpassword)))){
					
					$this->session->set_flashdata('errors', 'Old password is not matching');
					$this->output->set_header('location:' . base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/user/changepassword/');
					
				}else{
					$data = array(
						'password' 		=> md5( htmlspecialchars($new_password) )
					);

					if ( $this->user_model->reset_password( $data, $id ) )
					{
						$this->session->set_flashdata('success', 'Password updated successfully');
						$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/'.$this->uri->segment(2).'/user/changepassword/');
					}
					else
					{
						$this->session->set_flashdata('errors', 'Password updation failed');
						$this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/'.$this->uri->segment(2).'/user/changepassword/');
					}
				}	
			}else{
				// length should be greater than 5 characters
				// old password should not be empty
				
				$this->session->set_flashdata('errors', 'Failed, Please check the input, Password length should be greater than five');
			    $this->output->set_header('location:' . base_url() .  $this->uri->segment(1).'/'.$this->uri->segment(2).'/user/changepassword/');
			}

		}
		
		$view_data = '';
		$view_data['breadcrumbdata'] = array('Home /'=> base_url() .$store_username."/".$this->uri->segment(2)."/home" ,
        									'Change Password'=>'') ;
		$view_data['id'] = $userData['id'] ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid);
		$view_data['popularcat'] = $popularcat;

		//$this->_vci_view('store/user_reset_password', $view_data);
		$this->_vci_view('store/clchangepassword', $view_data);
	}

	function mywishlist(){
			// getWishlist($page, $per_page = 10, $count=false, $store_id, $user_id )
		$this->__is_valid_store();
		$this->load->model('common_model');
		$this->load->library('pagination') ;
		$storeuser = $this->uri->segments[1] ;

		$store = $this->common_model->get_clientdetail($storeuser);
 		$segs = $this->uri->segment_array();
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$userDetails = $this->session->userdata("storeUserSession");

		if(empty($userDetails)){
        	$this->session->set_flashdata('errors', 'Please login, access denied');
        	$this->output->set_header('location:' . base_url() .  $this->storename . '/store');
        }

		$view_data['userDetails']   = $userDetails;
		$user_id                    = $userDetails['id'];
    	$store_id                   = $userDetails['store_id'];

		$view_data = array() ;
		$per_page = 10 ;
		$page = ( isset( $segs[4] ) ) ? (int)$segs[4]: 0;	

		$getData = array();
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() .$store_username."/user/mywishlist?s=";
		$config['base_url'] = base_url() .$store_username."/user/mywishlist";
		$config['uri_segment'] = 4;
		
		$config['total_rows'] = intval($this->user_model->getWishlist( $page, $per_page, TRUE ,$storeid, $user_id )) ;

		$orders = $this->user_model->getWishlist( $page, $per_page, false ,$storeid, $user_id );

		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();

        $view_data['orders'] =  $orders;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid);
		$view_data['popularcat'] = $popularcat;
		$this->_vci_view('store/user_wishlist', $view_data);
	}

	function cmywishlist(){
			// getWishlist($page, $per_page = 10, $count=false, $store_id, $user_id )
		
		$this->__is_valid_store();
		$this->load->model('common_model');
		$this->load->library('pagination') ;
		$storeuser = $this->uri->segments[1] ;

		$store = $this->common_model->get_clientdetail($storeuser);
 		$segs = $this->uri->segment_array();
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
			$is_custom_theme =  $store[0]['is_custom_theme'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		if($is_custom_theme){
			$this->_vci_layout('clientstore_default' ,$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default');
		}
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$userDetails = $this->session->userdata("storeUserSession");

		if(empty($userDetails)){
        	$this->session->set_flashdata('errors', 'Please login, access denied');
        	$this->output->set_header('location:' . base_url() .  $this->storename . '/store');
        }

		$view_data['userDetails']   = $userDetails;
		$user_id                    = $userDetails['id'];
    	$store_id                   = $userDetails['store_id'];

		$view_data = array() ;
		$per_page = 10 ;
		$page = ( isset( $segs[5] ) ) ? (int)$segs[5]: 0;	

		$getData = array();
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() .$store_username.'/'.$this->uri->segment(2)."/user/mywishlist?s=";
		$config['base_url'] = base_url() .$store_username.'/'.$this->uri->segment(2)."/user/mywishlist";
		$config['uri_segment'] = 5;
		
		$config['total_rows'] = intval($this->user_model->getWishlist( $page, $per_page, TRUE ,$storeid, $user_id )) ;

		$orders = $this->user_model->getWishlist( $page, $per_page, false ,$storeid, $user_id );

		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$popularcat = $this->common_model->getpopularsubcatlist($storeid);
		$view_data['popularcat'] = $popularcat;
        $view_data['orders'] =  $orders;

		$this->_vci_view('store/cuser_wishlist', $view_data);
	}

	/* Fucntion added by G */
	function addbtree($consultantid,$parentconsulatantid , $storeid){
		$this->load->model('common_model');
       		$this->load->model('user_model') ;
       		$this->load->model('product_model');
		
		//get childs
		$allchilds = $this->common_model->getbtreechild($parentconsulatantid) ;
		$childcount = count($allchilds) ;
		
		if($childcount == 2){
			// check for sales of each individual node
			// sum up and decide the parent
			// repaet untill new parent is not decided
			
			$nodeonesales = $this->common_model->getallvoulumesum($allchilds[0]['consultant_id'], $storeid) ;
			// get sales of child two
			$nodetwosales = $this->common_model->getallvoulumesum($allchilds[1]['consultant_id'] , $storeid) ;
			
			if($nodeonesales <= $nodetwosales){
				// assign left as parent of tree	
				// tree parent -- $nodeonesales , $allchilds[0]['consultant_id']
				return $this->addbtree($consultantid, $allchilds[0]['consultant_id'] , $storeid) ;

			}else{
				// assign rgt as parent of tree
				// tree parent -- $nodetwosales , $allchilds[1]['consultant_id']
				return $this->addbtree($consultantid, $allchilds[1]['consultant_id'] , $storeid) ;
			}

		}elseif($childcount == 1){
			// just add the record to consultanttree with left right whatever
			$this->common_model->addtobtree($consultantid,$parentconsulatantid , $storeid, 'rgt') ;
		}else{
			// add the record as a lft child
			$this->common_model->addtobtree($consultantid,$parentconsulatantid , $storeid, 'lft') ;
		}
	}
}

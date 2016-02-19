<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:			Cart extends VCI_Controller defined in libraries
*	Author: 		
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	Managing all functionlities related to cart
---------------------------------------------------------------
*/

class Cart extends VCI_Controller {

	#class constructor
	function __construct()
	{
		parent::__construct();
		#$this->_vci_layout('store_default');
		$this->load->library('cart');
		$this->load->library('paypal');
		$this->load->model('common_model');
		$this->load->model('client_model');
		$this->load->model('address_model');
		$this->load->model('product_model');
		//$this->load->layout('store_default') ;
		if( $this->uri->segment(1) )
        {   
            $username =  $this->uri->segment(1);
        }

        //custom theme option
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
	 * method name  index
     * purpose		for index page
     * @param 		none
     * Note         not in use
     */
	function index()
	{
		$this->__is_valid_store();
		$view_data = '';
	}


	/**
	 * method name  checkout
     * purpose		for checkout page at payoption time from store admin page
     * @param 		none
     */
	function checkout()
	{   
		$this->__is_valid_store(); 

		/* for store active category */
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $this->load->library('Avatax'); // Added on

        $store = $this->common_model->get_clientdetail($storeuser);
		
		$storeid = $store[0]['id'] ;
		
		$store_settings = $this->common_model->getstoresetting($storeid) ;
		#pr($store_settings) ;
		if(count($store_settings) == 0){
			echo 'Purchase can not be done, Payoption is not configured yet By Store';
			exit;
		}

		$payusing = $store_settings[0]->payusing ;

		if($store_settings[0]->mp_merchant_id && $store_settings[0]->mp_merchant_key){
			$enableMeritus = 1 ;
		}

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
		// for store active category
		//error_reporting(0);
		$storeUserSession = $this->session->userdata('storeUserSession');
		if( !isset( $storeUserSession['id'] ) || empty( $storeUserSession['id'] ) )
		{
			$this->session->set_flashdata('errors', 'Please login to view this section');
  	    	$this->output->set_header('location:' . base_url() .  $this->storename . '/user/login?url=/'.$storeuser.'/cart/checkout');
		}

		$where_data = array('store_id' => $this->store_id, 'user_id' => $storeUserSession['id'] ,'is_primary'=>1);
		$view_data = '';	
		$view_data['states'] = $this->address_model->get_all_states();
		
		$shipping_data = $this->common_model->findWhere( 'shipping', $where_data, $multi_record = FALSE, $order = '' );
		$billing_data  = $this->common_model->findWhere( 'billing', $where_data, $multi_record = FALSE, $order = '' );

		$ship_cost = $this->common_model->calculate_shipping($storeid,$shipping_data['state_code']) ;
		#pr($store_settings) ;
		// AVALARA AVA TAX new part added here

		$avaconfig = array() ;
		if($store_settings[0]->ava_account_number && $store_settings[0]->ava_license_key && $store_settings[0]->ava_company_code){
			$avaconfig['accountNumber'] = $store_settings[0]->ava_account_number;
			$avaconfig['licenseKey']    = $store_settings[0]->ava_license_key;
			$avaconfig['serviceURL']    = AVATAX_SERVICEURL ;   
			$avaconfig['company_code']  = $store_settings[0]->ava_company_code ; 
			$overridetaxes =  1 ;

			$customer['customer_code'] = $storeUserSession['id'] ; 
			$customer['customer_id']   = $storeUserSession['id'] ; // simplesales system user id 

			
			$cartdetail[] = array('id'=>'shipping',
				'qty'=>1,
				'price'=>$ship_cost ,
				'name'=>'Shipping Charges',
				'subtotal'=>$ship_cost,
				'tax_code' => 'FR'
				) ;

			// $itemsdetail = array() ;
			// $cartdetail  = array() ;
			foreach ($this->cart->contents() as $key => $value) {
				# code...
				#pr($value) ;
				$items['id'] 		= $value['id'] ;
				$items['qty'] 		= $value['qty'] ;
				$items['price'] 	= $value['price'] ;
				$items['name'] 		= $value['name'] ;
				$items['subtotal'] 	= $value['subtotal'] ;
				$items['tax_code'] 	= $this->gettaxcode($value['id']) ;
				$cartdetail[] = $items ;
			}

			$addr =  array(
	    		'state_code'=>$store[0]['state_code'],
	    		'city'=>$store[0]['city'],
	    		'zip'=>$store[0]['zip'],
	    		'country'=>'US'
	    		) ;
	    	
	    	$addresss[] = $addr ;
	    	//pr($shipping_data) ; // customer detail
	    	$addr2 = array(
	    		'state_code'=>$shipping_data['state_code'],
	    		'city'=>$shipping_data['city'],
	    		'zip'=>$shipping_data['postal_code'],
	    		'country'=>'US'
	    		) ;
	    	$addresss[] = $addr2 ;
		}

		// new part added ends here

		if ( $this->input->post( 'formSubmitted' ) > 0 )
        {
		
            if ( $this->form_validation->run('checkout_form') )
            {
		            	
				#pr($this->input->post()) ;
            	#die;
            	$billing = array(
            		'store_id'		=>$this->store_id ,
            		'user_id'		=>$storeUserSession['id'] ,
            		'first_name'	=> htmlspecialchars($this->input->post('billing_first_name')),
            		'last_name'		=> htmlspecialchars($this->input->post('billing_last_name')),
            		'address'		=> htmlspecialchars($this->input->post('billing_address')),
            		'city'			=> htmlspecialchars($this->input->post('billing_city')),
            		'state_code'	=> htmlspecialchars($this->input->post('billing_state_code')),
            		'postal_code'	=> htmlspecialchars($this->input->post('billing_postal_code')),
            		'phone_number'	=> htmlspecialchars($this->input->post('billing_phone')),
            		'email'			=> htmlspecialchars($this->input->post('billing_email')),
            	);
            	$shpping = array(
            		'store_id'		=>$this->store_id ,
            		'user_id'		=>$storeUserSession['id'] ,
            		'first_name'	=> htmlspecialchars($this->input->post('shipping_first_name')),
            		'last_name'		=> htmlspecialchars($this->input->post('shipping_last_name')),
            		'address'		=> htmlspecialchars($this->input->post('shipping_address')),
            		'city'			=> htmlspecialchars($this->input->post('shipping_city')),
            		'state_code'	=> htmlspecialchars($this->input->post('shipping_state_code')),
            		'postal_code'	=> htmlspecialchars($this->input->post('shipping_postal_code')),
            		'phone_number'	=> htmlspecialchars($this->input->post('shipping_phone')),
            		'email'			=> htmlspecialchars($this->input->post('shipping_email')),
            	);

            	if(count($billing_data) == 0 ){

            		$billing['is_primary'] = 1 ;
            	}
            	if(count($shipping_data) == 0 ){
            		$shpping['is_primary'] = 1 ;
            	}


        		$this->db->insert('billing', $billing);
        		$this->db->insert('shipping', $shpping);
        		//  code for billing and shipping ends now

            	/* Set payment */	
            	$coupon_code = $this->input->get('coupon_code'); 
				
				$isCouponForStore = $this->common_model->checkCouponStoreN( $storeid , $coupon_code , $storeUserSession['id'] )  ;
				
				//paypal settings
				$PayPalMode 			= PAY_MODE ; // sandbox or live
				$PayPalApiUsername 		= $store_settings[0]->paypal_username; //PayPal API Username
				$PayPalApiPassword 		= $store_settings[0]->paypal_password; //Paypal API password
				$PayPalApiSignature 	= $store_settings[0]->paypal_signature;  //Paypal API Signature
				$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code
				$PayPalReturnURL 		= site_url() . $this->storename . '/cart/success'; //'http://localhost/paypal-shopping-cart-example/paypal-express-checkout/process.php'; //Point to process.php page
				$PayPalCancelURL 		= site_url() . $this->storename . '/cart/cancel'; //Cancel URL if user clicks cancel

				
				$HandalingCost 		= 0 ;  //Handling cost for this order.
				$InsuranceCost 		= 0;  //shipping insurance cost for this order.
				$ShippinDiscount 	= 0; //Shipping discount for this order. Specify this as negative number.
				// $ShippinCost 		= $this->common_model->calculate_shipping($storeid,$shpping['state_code']) ; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
				

				$storeUserSession = $this->session->userdata('storeUserSession');
				//print_r($storeUserSession);
				$code = $this->common_model->get_state_code( $storeUserSession['id'], $this->store_id );

				if( $code )
				{
					$state_code = $code->state_code;
				}
				else
				{
					$state_code = FALSE;
				}
	
				$ShippinCost 		= $this->common_model->calculate_shipping($storeid,$shpping['state_code']) ;

				/*
				we need 4 variables from product page Item Name, Item Price, Item Number and Item Quantity.
				Please Note : People can manipulate hidden field amounts in form,
				In practical world you must fetch actual price from database using item id. 
				eg : $ItemPrice = $mysqli->query("SELECT item_price FROM products WHERE id = Product_Number");
				*/

				$paypal_data ='';
				$ItemTotalPrice = 0;
				
				$key = 0;
				$total = 0;
			    foreach( $this->cart->contents() as $cart )
			    {
			      
			        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode( $cart['name'] );
			        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode( $cart['id'] );
			        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode( $cart['price'] );		
					$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='. urlencode($cart['qty'] );
			        
					// item price X quantity
			        $subtotal = ( $cart['price'] * $cart['qty'] );
					
			        //total price
			        $ItemTotalPrice = $ItemTotalPrice + $subtotal;
					
					//create items for session
					$paypal_product['items'][$key] = array('itm_name'=>$cart['name'],
														'itm_price'=>$cart['price'],
														'itm_code'=>$cart['name'], 
														'itm_qty'=>$cart['qty']
														);
					$key++;
			    }


			    $GrandTotal = $this->cart->total() ;
			    $cdisc = 0 ;
			    if($isCouponForStore)
			    {	    	
			    	
			    	$rcount = $this->common_model->check_coupon_used($storeUserSession['id'], $this->store_id , $isCouponForStore->id) ;
			    	if($isCouponForStore->coupon_type_id == 1){
			    		// direct deduction
			    		
			    		if(!$rcount){
			    			//$GrandTotal = $GrandTotal - $isCouponForStore->discount_percent ;
			    			$cdisc = $isCouponForStore->discount_percent ;
			    			//$GrandTotal = $GrandTotal - $cdisc ;
			    		}
			    	}
			    	if($isCouponForStore->coupon_type_id == 2){
			    		// direct percentage deduction
			    		if(!$rcount){
			    			
			    			$cdisc = ($GrandTotal*$isCouponForStore->discount_percent)/100 ;
			    			//$GrandTotal = $GrandTotal - $cdisc ;
			    		}
			    	}

			    	if($isCouponForStore->coupon_type_id == 3){
			    		$cdisc = ($GrandTotal*$isCouponForStore->discount_percent)/100 ;
			    		//$GrandTotal = $GrandTotal - $cdisc ;
			    	}
			    	if($cdisc > $this->cart->total() ){
						$cdisc = 0 ;
					}

			    	$paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'=Coupon Code';
			        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.$isCouponForStore->code ;
			        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'=' . -$cdisc;		
					$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'=1';

					$paypal_product['items'][] = array('itm_name'=>'Coupon Code',
														'itm_price'=>-$cdisc,
														'itm_code'=>$isCouponForStore->code, 
														'itm_qty'=>1
														);
					$ItemTotalPrice = $ItemTotalPrice - $cdisc;
					$GrandTotal = $GrandTotal - $cdisc;

			    }

			    if(!$overridetaxes){
					$TotalTaxAmount =  $this->common_model->calculate_taxes($storeid,$this->cart->total(),$shpping['state_code']) ;	
				}else{
					// Iterating through all item list again so that we can pass it to tax list
				    $cartdetail = array() ;
				    // $TotalTaxAmount 	= $this->common_model->calculate_taxes($storeid,$this->cart->total(),$shpping['state_code']) ; // commented on 18052015
					$cartdetail[] = array('id'=>'shipping',
								'qty'=>1,
								'price'=>$ShippinCost ,
								'name'=>'Shipping Charges',
								'subtotal'=>$ShippinCost,
								'tax_code' => 'FR'
								) ;

					foreach ($this->cart->contents() as $key => $value) {
						# code...
						#pr($value) ;
						$items['id'] 		= $value['id'] ;
						$items['qty'] 		= $value['qty'] ;
						$items['price'] 	= $value['price'] ;
						$items['name'] 		= $value['name'] ;
						$items['subtotal'] 	= $value['subtotal'] ;
						$items['tax_code'] 	= $this->gettaxcode($value['id']) ;
						$cartdetail[] = $items ;
					}

					// Iterating through all item list again so that we can pass it to tax list
					// ovrriding the current values of shipping address from form data
					$addresss[1] = array(
										'state_code'=>$shpping['state_code'],
							    		'city'		=>$shpping['city'],
							    		'zip'		=>$shpping['postal_code'],
							    		'country'	=>'US'
	    							) ;

					$TotalTaxAmount = $this->avatax->getax($avaconfig , $customer , $addresss, $cartdetail , $cdisc) ;   
				}

 
				//Grand total including all tax, insurance, shipping cost and discount
				$GrandTotal = ($ItemTotalPrice + $TotalTaxAmount + $HandalingCost + $InsuranceCost + $ShippinCost + $ShippinDiscount);
											
				$paypal_product['assets'] = array('tax_total'=>$TotalTaxAmount, 
											'handaling_cost'=>$HandalingCost, 
											'insurance_cost'=>$InsuranceCost,
											'shippin_discount'=>$ShippinDiscount,
											'shippin_cost'=>$ShippinCost,
											'grand_total'=>$GrandTotal);
				
				$paypal_product['assets']['grand_total'] = 	$GrandTotal;
				$paypal_product['assets']['shippin_cost'] = $ShippinCost;
				//create session array for later use
				
				#print_r($paypal_product) ;
				$this->session->set_userdata('paypal_productsdata', $paypal_product);
				
				//11052015 -- nw code to maritus payment gateway
				// $payusing -- 1 (meritus) , 0 - (Paypal)
				//if(strtolower($this->input->post('payusing') ) == 'meritus'){ 
				if($payusing){ 
					?>

					<div style="display:none;">
					<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
					<form action="https://webservice.paymentxp.com/wh/EnterPayment.aspx" method="POST" id="payxp">
						<input type="text" name="TransactionType" value="CreditCardHosted" />
						<input type="text" name="MerchantID" value="<?php echo $store_settings[0]->mp_merchant_id ;?>" />
						<input type="text" name="MerchantKey" value="<?php echo $store_settings[0]->mp_merchant_key ;?>" />
						<input type="text" name="TransactionAmount" value="<?php echo $GrandTotal ; ?>" /></td>
						<input type="text" name="PostBackURL" value="<?php echo site_url() . $this->storename . '/cart/success?method=meritus' ?>" />
						<input type="submit" value="Submit" />
					</form>
					<script>
						jQuery("#payxp").trigger('submit');
					</script>
					</div>
					<?php
					exit;
				}
				//11052015 nw code to maritus payment gateway ends here

				//Parameters for SetExpressCheckout, which will be sent to PayPal
				$padata = 	'&METHOD=SetExpressCheckout&SOLUTIONTYPE=Sole'.
							'&RETURNURL='.urlencode($PayPalReturnURL ).
							'&CANCELURL='.urlencode($PayPalCancelURL).
							'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
							$paypal_data.				
							'&NOSHIPPING=0'. //set 1 to hide buyer's shipping address, in-case products that does not require shipping
							'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
							'&PAYMENTREQUEST_0_TAXAMT='.urlencode($TotalTaxAmount).
							'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($ShippinCost).
							//'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($HandalingCost).
							//'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($ShippinDiscount).
							//'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($InsuranceCost).
							'&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
							'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
							'&LOCALECODE=GB'. //PayPal pages to match the language on your website.
							//'&LOGOIMG=http://www.cogniter.com/images/index/logo_n.jpg'. //site logo
							'&CARTBORDERCOLOR=FFFFFF'. //border color of cart
							'&ALLOWNOTE=0';
					
								
				/*We need to execute the "SetExpressCheckOut" method to obtain paypal token
				$paypal= new MyPayPal();*/

				$httpParsedResponseAr = $this->paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
				/*
				Respond according to message we receive from Paypal
				*/
				if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
				{
					//Redirect user to PayPal store with Token received.
					$paypalmode = PAY_MODE ;
					$paypalurl ='https://www.'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
					if($paypalmode == 'live'){
					$paypalurl ='https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
					}
					#success
					header('Location: '.$paypalurl);
				}
				else
				{
					//Show error message
					$view_data['pay_error']= $httpParsedResponseAr["L_LONGMESSAGE0"] ;
				}
            	/* End payment */
            }
        }

		
		if( isset( $_GET['coupon_code'] ) && !empty( $_GET['coupon_code'] ) )
		{
			//$view_data['coupon'] = $this->getCouponDiscount( $_GET['coupon_code'] ); 
			$view_data['coupon'] = '' ;

		}
		
		
		#echo '<pre>';
		#print_r($billing_data);
		$view_data['shipping_data'] = $shipping_data;
		$view_data['billing_data'] = $billing_data;
		$view_data['popularcat'] = $popularcat;
		$view_data['shipping_cost']  = $this->common_model->calculate_shipping($storeid,$shipping_data['state_code']) ;
		//$view_data['tax'] =  $this->common_model->calculate_taxes($storeid,$this->cart->total()) ;
		
		// NEW PATCH code begin now
		// coupon code starts here
		$discountprice = 0 ;

		$usercoupon_data = $this->session->userdata('coupon_data') ;
	    if(! empty($usercoupon_data)){
			$coupon_data = $this->session->userdata('coupon_data') ;
			if($coupon_data['ctype'] == 1){
				$discountprice = $coupon_data['amount'] ;
			}else if(($coupon_data['ctype'] == 2) || ($coupon_data['ctype'] == 3)){
				$discountprice = $this->cart->total()*$coupon_data['amount']/100 ;
			}else{
			   $discountprice = 0 ;
			}

			if($discountprice > $this->cart->total() ){
				$discountprice = 0 ;
			}
		}

		// coupon code ends here
		if(!$overridetaxes){
			$view_data['tax'] =  $this->common_model->calculate_taxes($storeid,$this->cart->total(),$shipping_data['state_code']) ;	
		}else{
			$view_data['tax'] = $this->avatax->getax($avaconfig , $customer , $addresss, $cartdetail , $discountprice) ;   
		}
		// new patch code to ge here ends now

		$view_data['enable_meritus'] = $enableMeritus ;

		$this->_vci_view('store/cart_checkout',$view_data);
	}

	/**
	 * method name  consultantcheckout
     * purpose		for checkout page at payoption time from consultant checkout page
     * @param 		none
     */
	function consultantcheckout()
	{   
	//	echo 'checkout page data';
		$this->__is_valid_client_store() ;
			
		#$this->_vci_layout('clientstore_default');
		/* for store active category */
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $this->load->library('Avatax'); // Added on

        $store = $this->common_model->get_clientdetail($storeuser);

		$storeid = $store[0]['id'] ;
		$store_username =  $store[0]['username'] ;
		$is_custom_theme =  $store[0]['is_custom_theme'] ;
		if($is_custom_theme){
			$this->_vci_layout('clientstore_default',$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default') ;
		}

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
		// for store active category
		
		$store_settings = $this->common_model->getstoresetting($storeid) ;
		
		if(count($store_settings) == 0){
			echo 'Purchase can not be done, Payoption is not configured yet By Store';
			exit;
		}
		if($store_settings[0]->mp_merchant_id && $store_settings[0]->mp_merchant_key){
			$enableMeritus = 1 ;
		}
		$payusing = $store_settings[0]->payusing ;

		$consultantDetail = trim($this->uri->segments[2]) ;

		/*  ----  group Code  ---- */
		
		$consultant = $this->user_model->is_consultant_exists(trim($this->uri->segments[2]), $storeid) ;

		$consultant_user_id = $consultant[0]->id ;

		/* ----- Group Details ends here */

		error_reporting(1);
		$storeUserSession = $this->session->userdata('storeUserSession');
		if( !isset( $storeUserSession['id'] ) || empty( $storeUserSession['id'] ) )
		{
			$this->session->set_flashdata('errors', 'Please login to view this section');
  	    	$this->output->set_header('location:' . base_url() .  $this->storename .'/'.$consultantDetail.'/user/login');
		}
		$where_data = array('store_id' => $this->store_id, 'user_id' => $storeUserSession['id'] ,'is_primary'=>1);
		$view_data = '';	
		$shipping_data = $this->common_model->findWhere( 'shipping', $where_data, $multi_record = FALSE, $order = '' );
		$billing_data = $this->common_model->findWhere( 'billing', $where_data, $multi_record = FALSE, $order = '' );

		$ship_cost = $this->common_model->calculate_shipping($storeid,$shipping_data['state_code']) ;
		$view_data['states'] = $this->address_model->get_all_states();

		// AVALARA AVA TAX new part added here

		$avaconfig = array() ;
		if($store_settings[0]->ava_account_number && $store_settings[0]->ava_license_key && $store_settings[0]->ava_company_code){
			$avaconfig['accountNumber'] = $store_settings[0]->ava_account_number;
			$avaconfig['licenseKey']    = $store_settings[0]->ava_license_key;
			$avaconfig['serviceURL']    = AVATAX_SERVICEURL ;   
			$avaconfig['company_code']  = $store_settings[0]->ava_company_code ; 
			$overridetaxes =  1 ;

			$customer['customer_code'] = $storeUserSession['id'] ; 
			$customer['customer_id']   = $storeUserSession['id'] ; // simplesales system user id 

			
			$cartdetail[] = array('id'=>'shipping',
				'qty'=>1,
				'price'=>$ship_cost ,
				'name'=>'Shipping Charges',
				'subtotal'=>$ship_cost,
				'tax_code' => 'FR'
				) ;

			// $itemsdetail = array() ;
			// $cartdetail  = array() ;
			foreach ($this->cart->contents() as $key => $value) {
				# code...
				#pr($value) ;
				$items['id'] 		= $value['id'] ;
				$items['qty'] 		= $value['qty'] ;
				$items['price'] 	= $value['price'] ;
				$items['name'] 		= $value['name'] ;
				$items['subtotal'] 	= $value['subtotal'] ;
				$items['tax_code'] 	= $this->gettaxcode($value['id']) ;
				$cartdetail[] = $items ;
			}

			$addr =  array(
	    		'state_code'=>$store[0]['state_code'],
	    		'city'=>$store[0]['city'],
	    		'zip'=>$store[0]['zip'],
	    		'country'=>'US'
	    		) ;
	    	
	    	$addresss[] = $addr ;
	    	//pr($shipping_data) ; // customer detail
	    	$addr2 = array(
	    		'state_code'=>$shipping_data['state_code'],
	    		'city'=>$shipping_data['city'],
	    		'zip'=>$shipping_data['postal_code'],
	    		'country'=>'US'
	    		) ;
	    	$addresss[] = $addr2 ;
		}
		// AVAlara tax Part added

		if ( $this->input->post( 'formSubmitted' ) > 0 )
        {
           	//pr($this->input->post()) ;
           	$gcodevalidaity = 0 ;
           	// [g_code] => Group Event Code
           	if($this->input->post('g_code') && ( (trim($this->input->post('g_code'))!= 'Group Event Code') || (trim($this->input->post('g_code'))!= '') ) ){
           		// check for code validity
           		//echo 'check for code validity';
           		$g_code = trim($this->input->post('g_code')) ;
           		
           		$gcodevalidaity = $this->common_model->check_group_code($consultant_user_id,$g_code) ;
           	}

            if ( $this->form_validation->run('checkout_form') )
            {
            	
            	$billing = array(
            		'store_id'=>$this->store_id ,
            		'user_id'=>$storeUserSession['id'] ,
            		'first_name'	=> htmlspecialchars($this->input->post('billing_first_name')),
            		'last_name'		=> htmlspecialchars($this->input->post('billing_last_name')),
            		'address'		=> htmlspecialchars($this->input->post('billing_address')),
            		'city'			=> htmlspecialchars($this->input->post('billing_city')),
            		'state_code'	=> htmlspecialchars($this->input->post('billing_state_code')),
            		'postal_code'	=> htmlspecialchars($this->input->post('billing_postal_code')),
            		'phone_number'	=> htmlspecialchars($this->input->post('billing_phone')),
            		'email'			=> htmlspecialchars($this->input->post('billing_email')),
            	);
            	if(count($billing_data) == 0 ){
            		$billing['is_primary'] = 1 ;
            	}
            	$shpping = array(
            		'store_id'=>$this->store_id ,
            		'user_id'=>$storeUserSession['id'] ,
            		'first_name'	=> htmlspecialchars($this->input->post('shipping_first_name')),
            		'last_name'		=> htmlspecialchars($this->input->post('shipping_last_name')),
            		'address'		=> htmlspecialchars($this->input->post('shipping_address')),
            		'city'			=> htmlspecialchars($this->input->post('shipping_city')),
            		'state_code'	=> htmlspecialchars($this->input->post('shipping_state_code')),
            		'postal_code'	=> htmlspecialchars($this->input->post('shipping_postal_code')),
            		'phone_number'	=> htmlspecialchars($this->input->post('shipping_phone')),
            		'email'			=> htmlspecialchars($this->input->post('shipping_email')),
            	);

            	if(count($shipping_data) == 0){
            		$shpping['is_primary'] = 1 ;
            	}

        		$this->db->insert('billing', $billing);
        		$this->db->insert('shipping', $shpping);
        		
            	/* Set payment */	
            	$coupon_code = $this->input->get('coupon_code'); 
            	
				
				$isCouponForStore = $this->common_model->checkCouponStoreN( $storeid , $coupon_code , $storeUserSession['id'] )  ;

				$coupon = $this->getCouponDiscount( $coupon_code ); 
				//paypal settings
				$PayPalMode 			= PAY_MODE ; // sandbox or live
				$PayPalApiUsername 		= $store_settings[0]->paypal_username; //PayPal API Username
				$PayPalApiPassword 		= $store_settings[0]->paypal_password; //Paypal API password
				$PayPalApiSignature 	= $store_settings[0]->paypal_signature;  //Paypal API Signature
				$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code
				$PayPalReturnURL 		= site_url() . $this->storename .'/'.$consultantDetail. '/cart/success'; //'http://localhost/paypal-shopping-cart-example/paypal-express-checkout/process.php'; //Point to process.php page
				$PayPalCancelURL 		= site_url() . $this->storename .'/'.$consultantDetail. '/cart/cancel' ; //Cancel URL if user clicks cancel


				$TotalTaxAmount 	= $this->common_model->calculate_taxes($storeid,$this->cart->total(),$shpping['state_code']) ;
				$HandalingCost 		= 0 ;  //Handling cost for this order.
				$InsuranceCost 		= 0;  //shipping insurance cost for this order.
				$ShippinDiscount 	= 0; //Shipping discount for this order. Specify this as negative number.
				// $ShippinCost 		= $this->common_model->calculate_shipping($storeid,$shpping['state_code']) ; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
				
				$storeUserSession = $this->session->userdata('storeUserSession');
				//print_r($storeUserSession);
				$code = $this->common_model->get_state_code( $storeUserSession['id'], $this->store_id );

				if( $code )
				{
					$state_code = $code->state_code;
				}
				else
				{
					$state_code = FALSE;
				}


				$ShippinCost = $this->common_model->calculate_shipping($storeid,$shpping['state_code']) ; 	

				/*
				we need 4 variables from product page Item Name, Item Price, Item Number and Item Quantity.
				Please Note : People can manipulate hidden field amounts in form,
				In practical world you must fetch actual price from database using item id. 
				eg : $ItemPrice = $mysqli->query("SELECT item_price FROM products WHERE id = Product_Number");
				*/
				$paypal_data ='';
				$ItemTotalPrice = 0;
				
				$key = 0;
				$total = 0;
			    foreach( $this->cart->contents() as $cart )
			    {

			        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode( $cart['name'] );
			        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode( $cart['id'] );
			        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode( $cart['price'] );		
					$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='. urlencode($cart['qty'] );
			        
					// item price X quantity
			        $subtotal = ( $cart['price'] * $cart['qty'] );
					
			        //total price
			        $ItemTotalPrice = $ItemTotalPrice + $subtotal;
					
					//create items for session
					$paypal_product['items'][$key] = array('itm_name'=>$cart['name'],
														'itm_price'=>$cart['price'],
														'itm_code'=>$cart['name'], 
														'itm_qty'=>$cart['qty']
														);

					$key++;
			    }


			    $GrandTotal = $this->cart->total() ;
			    
			    if($isCouponForStore)
			    {	    	
			    	
			    	$rcount = $this->common_model->check_coupon_used($storeUserSession['id'], $this->store_id , $isCouponForStore->id) ;
			    	if($isCouponForStore->coupon_type_id == 1){
			    		// direct deduction
			    		
			    		if(!$rcount){
			    			//$GrandTotal = $GrandTotal - $isCouponForStore->discount_percent ;
			    			$cdisc = $isCouponForStore->discount_percent ;
			    			//$GrandTotal = $GrandTotal - $cdisc ;
			    		}
			    	}
			    	if($isCouponForStore->coupon_type_id == 2){
			    		// direct percentage deduction
			    		if(!$rcount){
			    			
			    			$cdisc = ($GrandTotal*$isCouponForStore->discount_percent)/100 ;
			    			//$GrandTotal = $GrandTotal - $cdisc ;
			    		}
			    	}

			    	if($isCouponForStore->coupon_type_id == 3){
			    		$cdisc = ($GrandTotal*$isCouponForStore->discount_percent)/100 ;
			    		//$GrandTotal = $GrandTotal - $cdisc ;
			    	}

			    	if($cdisc > $GrandTotal){
			    		$cdisc = 0 ;
			    	}

			    	$paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'=Coupon Code';
			        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.$isCouponForStore->code ;
			        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'=' . -$cdisc;		
					$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'=1';

					$paypal_product['items'][] = array('itm_name'=>'Coupon Code',
														'itm_price'=>-$cdisc,
														'itm_code'=>$isCouponForStore->code, 
														'itm_qty'=>1
														);
					$ItemTotalPrice = $ItemTotalPrice - $cdisc;
					$GrandTotal = $GrandTotal - $cdisc;
					$key++;
			    }
			   
			    
			    // for group code
			    //echo 'Group code validity'.$gcodevalidaity ;
			    //die;
			    if( $gcodevalidaity)
			    {	    	
			    	
			    	$paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'=Group Event';
			        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.$g_code;
			        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'=0';		
					$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'=1';

					$paypal_product['items'][] = array('itm_name'=>'Group Event',
														'itm_price'=>0,
														'itm_code'=>$g_code, 
														'itm_qty'=>1
														);
					
					$key++ ;
			    }

			    /* for group code ends here */
			    if(!$overridetaxes){
					$TotalTaxAmount =  $this->common_model->calculate_taxes($storeid,$this->cart->total(),$shpping['state_code']) ;	
				}else{
					// Iterating through all item list again so that we can pass it to tax list
				    $cartdetail = array() ;
				    // $TotalTaxAmount 	= $this->common_model->calculate_taxes($storeid,$this->cart->total(),$shpping['state_code']) ; // commented on 18052015
					$cartdetail[] = array('id'=>'shipping',
								'qty'=>1,
								'price'=>$ShippinCost ,
								'name'=>'Shipping Charges',
								'subtotal'=>$ShippinCost,
								'tax_code' => 'FR'
								) ;

					foreach ($this->cart->contents() as $key => $value) {
						# code...
						#pr($value) ;
						$items['id'] 		= $value['id'] ;
						$items['qty'] 		= $value['qty'] ;
						$items['price'] 	= $value['price'] ;
						$items['name'] 		= $value['name'] ;
						$items['subtotal'] 	= $value['subtotal'] ;
						$items['tax_code'] 	= $this->gettaxcode($value['id']) ;
						$cartdetail[] = $items ;
					}

					// Iterating through all item list again so that we can pass it to tax list
					// ovrriding the current values of shipping address from form data
					$addresss[1] = array(
										'state_code'=>$shpping['state_code'],
							    		'city'		=>$shpping['city'],
							    		'zip'		=>$shpping['postal_code'],
							    		'country'	=>'US'
	    							) ;

					$TotalTaxAmount = $this->avatax->getax($avaconfig , $customer , $addresss, $cartdetail , $cdisc) ;   
				}
			   	
				//Grand total including all tax, insurance, shipping cost and discount
				$GrandTotal = ($ItemTotalPrice + $TotalTaxAmount + $HandalingCost + $InsuranceCost + $ShippinCost + $ShippinDiscount);
				
				
											
				$paypal_product['assets'] = array('tax_total'=>$TotalTaxAmount, 
											'handaling_cost'=>$HandalingCost, 
											'insurance_cost'=>$InsuranceCost,
											'shippin_discount'=>$ShippinDiscount,
											'shippin_cost'=>$ShippinCost,
											'grand_total'=>$GrandTotal);
				
				$paypal_product['assets']['grand_total'] = 	$GrandTotal;
				$paypal_product['assets']['shippin_cost'] = $ShippinCost;
				//create session array for later use
				
				$this->session->set_userdata('paypal_productsdata', $paypal_product);

				//11052015 -- nw code to maritus payment gateway //$payusing - 0 paypal , 1- Meritus
				//if(strtolower($this->input->post('payusing') ) == 'meritus'){ 
				if($payusing){
					?>
					<div style="display:none;">
					<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
					<form action="https://webservice.paymentxp.com/wh/EnterPayment.aspx" method="POST" id="payxp">
						<input type="text" name="TransactionType" value="CreditCardHosted" />
						<input type="text" name="MerchantID" value="<?php echo $store_settings[0]->mp_merchant_id ;?>" />
						<input type="text" name="MerchantKey" value="<?php echo $store_settings[0]->mp_merchant_key ;?>" />
						<input type="text" name="TransactionAmount" value="<?php echo $GrandTotal ; ?>" /></td>
						<input type="text" name="PostBackURL" value="<?php echo site_url() . $this->storename .'/'.$consultantDetail.'/cart/success?method=meritus' ?>" />
						<input type="submit" value="Submit" />
					</form>
					<script>
						jQuery("#payxp").trigger('submit');
					</script>
					</div>
					<?php
					exit;
				}
				//11052015 nw code to maritus payment gateway ends here
				
				//Parameters for SetExpressCheckout, which will be sent to PayPal
				$padata = 	'&METHOD=SetExpressCheckout&SOLUTIONTYPE=Sole'.
							'&RETURNURL='.urlencode($PayPalReturnURL ).
							'&CANCELURL='.urlencode($PayPalCancelURL).
							'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
							$paypal_data.				
							'&NOSHIPPING=0'. //set 1 to hide buyer's shipping address, in-case products that does not require shipping
							'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
							'&PAYMENTREQUEST_0_TAXAMT='.urlencode($TotalTaxAmount).
							'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($ShippinCost).
							//'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($HandalingCost).
							//'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($ShippinDiscount).
							//'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($InsuranceCost).
							'&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
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
					$paypalurl ='https://www.'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
					if($paypalmode == 'live'){
					$paypalurl ='https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
					}
					#success
					header('Location: '.$paypalurl);
				}
				else
				{
					$view_data['pay_error']= $httpParsedResponseAr["L_LONGMESSAGE0"] ;
				}
            	/* End payment */

            }
        }
		
		if( isset( $_GET['coupon_code'] ) && !empty( $_GET['coupon_code'] ) )
		{
			// $view_data['coupon'] = $this->getCouponDiscount( $_GET['coupon_code'] ); 
			$view_data['coupon'] = '' ;
		}
		
		$view_data['shipping_data'] = $shipping_data;
		$view_data['billing_data'] = $billing_data;
		$view_data['shipping_cost']  = $this->common_model->calculate_shipping($storeid,$shipping_data['state_code']) ;
		$view_data['popularcat'] = $popularcat ;
		// $view_data['tax'] =  $this->common_model->calculate_taxes($storeid,$this->cart->total(),$shipping_data['state_code']) ;

		// NEW PATCH code begin now
		// coupon code starts here
		$discountprice = 0 ;

		$usercoupon_data = $this->session->userdata('coupon_data') ;
	    if(! empty($usercoupon_data)){
			$coupon_data = $this->session->userdata('coupon_data') ;
			if($coupon_data['ctype'] == 1){
				$discountprice = $coupon_data['amount'] ;
			}else if(($coupon_data['ctype'] == 2) || ($coupon_data['ctype'] == 3)){
				$discountprice = $this->cart->total()*$coupon_data['amount']/100 ;
			}else{
			   $discountprice = 0 ;
			}

			if($discountprice > $this->cart->total() ){
				$discountprice = 0 ;
			}
		}

		// coupon code ends here
		if(!$overridetaxes){
			$view_data['tax'] =  $this->common_model->calculate_taxes($storeid,$this->cart->total(),$shipping_data['state_code']) ;	
		}else{
			$view_data['tax'] = $this->avatax->getax($avaconfig , $customer , $addresss, $cartdetail , $discountprice) ;   
		}
		// new patch code to ge here ends now
		
		$view_data['enable_meritus'] = $enableMeritus ;
		$this->_vci_view('store/consultantcart_checkout',$view_data);
	}

	function cancel(){
		echo 'You have cancelled the pay';
		die;
	}

	/**
	 * method name  add
     * purpose		for adding items in cart admin store page
     * @param 		none
     */

	function add()
	{
		$this->__is_valid_store();
		
		$customopt = $this->input->post('options') ;
		//pr($this->input->post('options')) ;
		//die;
		$attrString = '' ;
		$optprices = array() ;
		$attributelist = array() ;
		if(!empty($customopt)){
			foreach ($customopt as $key => $labelvalue) {
				
				$attrDetails = $this->product_model->getattributedetail($key) ;
				#pr($attrDetails) ;

				if(is_array($labelvalue)){
					
					$selectedvalue = '' ;
					foreach ($labelvalue as $key => $indval) {
						#echo $indval ;
						$optdetail = $this->product_model->getattributefielddetail($indval) ;
						#pr($optdetail) ;
						$optprices[$optdetail[0]['id']] = $optdetail[0]['option_price'] ; 
						$selectedvalue = $selectedvalue.' '.$optdetail[0]['option_value'].', ' ;

						$attributelist[$attrDetails[0]['id']][] = $optdetail[0]['id'] ;
					}
					

					$attrString = $attrString.'<span class="text-bold">'.$attrDetails[0]['field_label'].'</span>--'.$selectedvalue.', ' ;
				}else{
					
					$attributelist[$attrDetails[0]['id']] = $labelvalue ;

					$attrString = $attrString.'<span class="text-bold">'.$attrDetails[0]['field_label'].'</span>--'.$labelvalue.', ' ;
				}
				
			}
		}

		//die('All is well') ;
		//pr($optprices) ;
		//die;

		$id = $this->input->post('id');
		$qty = $this->input->post('qty');
		$price = $this->input->post('price');
		$name = $this->input->post('name');
		$image = $this->input->post('image');
		$weight = $this->input->post('weight') ;
		$size = 'NA';
		if(($this->input->post('size')!= "0") && ($this->input->post('size')!= "")){
			$size =  $this->input->post('size') ;
		}
		
		if( empty( $id ) || empty( $qty ) || !is_numeric( $qty ) || empty( $price ) || empty( $name ) )
		{
			echo "Empty cart"; die;
		}

		$productdetail = $this->product_model->findWhere('client_product', array( 'status' => 1, 'id' => $id ), false ) ;
		$sizeArr = explode(',',$productdetail['product_size']) ;
		
		if ($size =="NA" && $sizeArr[0]!=""){
			$size = $sizeArr[0] ;
		}
		$name  	= $productdetail['product_title'] ;
		$image  = $productdetail['image'] ;
		$weight = ($productdetail['weight'] > 0) ? 500 : $productdetail['weight'] ;

		$data = array(
               'id'      => $id,
               'qty'     => $qty,
               'price'   => $price + array_sum($optprices),
               'name'    =>  htmlspecialchars($name),
               'options' => array(
               		'image' => $image ,
               		'weight' => $weight,
               		'size' => $size,
               		'storeid' => $productdetail['store_id'] ,
               		'spcifications' => $attrString ,
               		'optprices' => $optprices,
               		'unit_price' => $price,
               		'attributelist' => $attributelist,
               		)
               	);

		  if($this->cart->insert($data)){
		 	$this->session->set_flashdata( 'success', 'Item added successfully in cart');
                  }else{
			$this->session->set_flashdata( 'errors', 'Item adding failed try later');
                  }
		  
		  redirect( site_url() . $this->storename . '/cart' );
	}

	/**
	 * method name  consultantadd
     * purpose		for adding items in cart consulatnt store page
     * @param 		none
     */
	function consultantadd()
	{
		$this->__is_valid_client_store() ;
		$consulttantDetail =  trim($this->uri->segments[2]) ;	

		$customopt = $this->input->post('options') ;
		#pr($this->input->post('options')) ;
		$attrString = '' ;
		$optprices = array() ;
		$attributelist = array() ;

		if(!empty($customopt)){
			foreach ($customopt as $key => $labelvalue) {
				
				$attrDetails = $this->product_model->getattributedetail($key) ;

				if(is_array($labelvalue)){
					
					$selectedvalue = '' ;
					foreach ($labelvalue as $key => $indval) {
						
						$optdetail = $this->product_model->getattributefielddetail($indval) ;
						
						$selectedvalue = $selectedvalue.' '.$optdetail[0]['option_value'].', ' ;

						$optprices[$optdetail[0]['id']] = $optdetail[0]['option_price'] ; 

						$attributelist[$attrDetails[0]['id']][] = $optdetail[0]['id'] ;
					}
					$attrString = $attrString.'<span class="text-bold">'.$attrDetails[0]['field_label'].'</span>--'.$selectedvalue.', ' ;
				}else{
					$attributelist[$attrDetails[0]['id']] = $labelvalue ;

					$attrString = $attrString.'<span class="text-bold">'.$attrDetails[0]['field_label'].'</span>--'.$labelvalue.', ' ;
				}
				
			}
		}

		$id = $this->input->post('id');
		$qty = $this->input->post('qty');
		$price = $this->input->post('price');
		$name = $this->input->post('name');
		$image = $this->input->post('image');
		$weight = $this->input->post('weight') ;
		$size = 'NA';
		if(($this->input->post('size')!= "0") && ($this->input->post('size')!= "")){
			$size =  $this->input->post('size') ;
		}
		if( empty( $id ) || empty( $qty ) || !is_numeric( $qty ) || empty( $price ) || empty( $name ) )
		{
			echo "Empty cart"; die;
		}
		$productdetail = $this->product_model->findWhere('client_product', array( 'status' => 1, 'id' => $id ), false ) ;
		
		$sizeArr = explode(',',$productdetail['product_size']) ;

		
		if ($size == "NA" && $sizeArr[0]!=""){
			$size = $sizeArr[0] ;
		}
		$name  	= $productdetail['product_title'] ;
		$image  = $productdetail['image'] ;
		$weight = ($productdetail['weight'] > 0) ? 500 : $productdetail['weight'] ;

		 $data = array(
               'id'      => $id,
               'qty'     => $qty,
               'price'   => $price + array_sum($optprices),
               'name'    => htmlspecialchars($name),
               'options' => array( 
	               	'image' => $image ,
	               	'weight' => $weight,
	               	'size' => $size,
	               	'storeid' => $productdetail['store_id'] ,
	               	'spcifications' => $attrString ,
	               	'optprices' => $optprices,
               		'unit_price' => $price,
               		'attributelist' => $attributelist,
               	)
            );	
		  if($this->cart->insert($data)){
		 	$this->session->set_flashdata( 'success', 'Item added successfully in cart');
                  }else{
			$this->session->set_flashdata( 'errors', 'Item adding failed try later');
                  }
		  redirect( site_url() . $this->storename .'/'. $consulttantDetail.'/cart' );
	}

	/**
	 * method name  consultant_removeitem
     * purpose		for removing items in cart consulatnt store page
     * @param 		none
     */
	function consultant_removeitem($id=''){

		$this->__is_valid_client_store() ;
		$consulttantDetail =  trim($this->uri->segments[2]) ;	

		if($id){
			$this->cart->remove_item($id);
			$this->session->set_flashdata( 'success', 'Item removed successfully');
			redirect( site_url() . $this->storename .'/'. $consulttantDetail.'/cart' );
		}
		
		return false;
	}

	/**
	 * method name  removeitem
     * purpose		for removing items in cart store page
     * @param 		none
     */
	function removeitem($id=''){

		$this->__is_valid_store() ;
		
		if($id){
			$this->cart->remove_item($id);
			$this->session->set_flashdata( 'success', 'Item removed successfully');
			redirect( site_url() . $this->storename .'/cart' );
		}
		return false;
	}

	/**
	 * method name  manage
     * purpose		for managing item list page on cart store admin section
     * @param 		none
     */
	function manage()
	{	
		$this->__is_valid_store();
		/* for store active category */
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
		$storeid = $store[0]['id'] ;
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
		// for store active category

		if ( $this->input->post( 'updateCartFormSubmitted' ) > 0 )
        {
        	if( isset( $_POST['rowid'] ) && !empty( $_POST['rowid'] ) && is_array( $_POST['rowid'] ) )
        	{
        		foreach ($_POST['rowid'] as $rowid => $qty) {
        			$data = array(
		               'rowid' => $rowid,
		               'qty'   => $qty
            		);	
            		$this->cart->update($data); 
        		}
        		
        		$this->session->set_flashdata( 'success', 'Cart updated successfully' );
        		redirect($_SERVER['HTTP_REFERER']) ;

        	}
        }	
          
		$view_data['qty_array'] = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);

		$view_data['cart'] = $this->cart->contents();
		$view_data['popularcat']= $popularcat ;

		$view_data['cart_comments'] = $this->cart->get_order_comment();

		$storeUserSession = $this->session->userdata('storeUserSession');
		if( !empty( $storeUserSession ) && is_array( $storeUserSession ) )
		{
			$user_id = $storeUserSession['id'];
			$code = $this->common_model->get_state_code( $user_id, $this->store_id );
			if( $code )
			{
				$state_code = $code->state_code;
				$view_data['shipping_address'] = $code;
			}
			else
			{
				$state_code = FALSE;
			}
			 //$view_data['shipping_cost'] = $ShippinCost = $this->getShippingAmount( $state_code ); //commented on 15-042015
			$view_data['shipping_cost'] = $ShippinCost = 0 ;
		}

		#pr($view_data) ;

		$this->_vci_view('store/cart_view',$view_data);
	}

	/**
	 * method name  consultantmanage
     * purpose		for managing item list page on store cart consulatnt 
     * @param 		none
     */
	function consultantmanage(){
		#echo 'consultant mange page';
		#$this->_vci_layout('clientstore_default');
		$this->__is_valid_client_store() ;
		$consulttantDetail =  trim($this->uri->segments[2]) ;	

		/* for store active category */
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
		$storeid = $store[0]['id'] ;
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
		// for store active category

		$store_username =  $store[0]['username'] ;
		$is_custom_theme =  $store[0]['is_custom_theme'] ;
		if($is_custom_theme){
			$this->_vci_layout('clientstore_default',$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default') ;
		}

		if ( $this->input->post( 'updateCartFormSubmitted' ) > 0 )
        {
        	
        	if( isset( $_POST['rowid'] ) && !empty( $_POST['rowid'] ) && is_array( $_POST['rowid'] ) )
        	{	
        		
        		foreach ($_POST['rowid'] as $rowid => $qty) {
        			$data = array(
		               'rowid' => $rowid,
		               'qty'   => $qty
            		);	
            		$this->cart->update($data); 
        		}
        		
        		$this->session->set_flashdata( 'success', 'Cart updated successfully' );
        		redirect($_SERVER['HTTP_REFERER']) ;

        	}
        }	
        $view_data['cart_comments'] = $this->cart->get_order_comment();
		$view_data['qty_array'] = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
		$view_data['cart'] = $this->cart->contents();
		$view_data['popularcat']= $popularcat;

		$storeUserSession = $this->session->userdata('storeUserSession');
		if( !empty( $storeUserSession ) && is_array( $storeUserSession ) )
		{
			$user_id = $storeUserSession['id'];
			$code = $this->common_model->get_state_code( $user_id, $this->store_id );
			if( $code )
			{
				$state_code = $code->state_code;
				$view_data['shipping_address'] = $code;
			}
			else
			{
				$state_code = FALSE;
			}
			 //$view_data['shipping_cost'] = $ShippinCost = $this->getShippingAmount( $state_code );
			$view_data['shipping_cost'] = $ShippinCost = 0 ;
		}	

		$this->_vci_view('store/consultantcart_view',$view_data);

	}


	/**
	 * method name  thanks
     * purpose		for rendering the thanks page after a successful puurchase
     * @param 		none
     */
	function thanks()
	{
	    $this->__is_valid_store(); 
	    $this->load->library('cart') ;
	    $this->cart->destroy();
	    $this->session->set_userdata('coupon_data',array('amount'=>0,'ctype'=>0));
	    // category section code starts now
	    $storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
		
		$storeid = $store[0]['id'] ;

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

	    // category section code ends now
	    $popularcat = $this->common_model->getpopularsubcatlist($storeid);
        $view_data['popularcat'] = $popularcat;

		$this->_vci_view('store/cart_success',$view_data );

	}

	/**
	 * method name  consultantthanks
     * purpose		for rendering the thanks page after a successful puurchase from consultant store
     * @param 		none
     */
	function consultantthanks()
	{
	    #$this->_vci_layout('clientstore_default');
	    $this->__is_valid_client_store() ;
	    $this->load->library('cart') ;
	    $this->cart->destroy();
	    $this->session->set_userdata('coupon_data',array('amount'=>0,'ctype'=>0));
	    // category section code starts now
	    $storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
		
		$storeid = $store[0]['id'] ;
		$store_username =   strtolower($store[0]['username']) ;
		$is_custom_theme =  $store[0]['is_custom_theme'] ;

		if($is_custom_theme){
			$this->_vci_layout('clientstore_default',$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default') ;
		}

		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

	    // category section code ends now
	    $popularcat = $this->common_model->getpopularsubcatlist($storeid);
        $view_data['popularcat'] = $popularcat;

		$this->_vci_view('store/consultantcart_success',$view_data);
	}	
	
	/**
	 * method name  success
     * purpose		After getting a success response from paypal the function is being used for final settlement of an account purrchase
     * @param 		none
     */
	function success()
	{
		$this->__is_valid_store();
		$itemVolume = 0;
		$itemVolumeArray = array();
		foreach( $this->cart->contents() as $cart )
		{		
			$volume = $this->product_model->getProductVolume($cart['id']);
			$itemVolume += ($volume*$cart['qty']);
			$itemVolumeArray[$cart['id']] = $volume;
		}
		
		//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
		
		$storeid = $store[0]['id'] ;

		$store_settings = $this->common_model->getstoresetting($storeid) ;
		if(count($store_settings) == 0){
			echo 'Purchase can not be done, Payoption is not configured yet By Store';
			exit;
		}
		/*
		// Added for avalara tax
		$storeUserSession = $this->session->userdata('storeUserSession');
		$customer['customer_code'] = $storeUserSession['id'] ; 
		$customer['customer_id']   = $storeUserSession['id'] ; // simplesales system user id 

		// Added for avalara tax
		*/

		if(@$_GET['method'] == 'meritus'){
			
			$paypal_product   = $this->session->userdata('paypal_productsdata');

			$ItemTotalPrice = 0;			
			$coupon_code = '';
			$disc_amt = 0 ;
		    foreach($paypal_product['items'] as $key=>$p_item)
		    {
				// item price X quantity
		        $subtotal = ($p_item['itm_price']*$p_item['itm_qty']);
				
		        //total price
		        $ItemTotalPrice = ($ItemTotalPrice + $subtotal);
		        if($p_item['itm_name'] == 'Coupon Code'){
		        	$coupon_code = $p_item['itm_code'] ;
		        	$disc_amt = $p_item['itm_price'] ;
		        }
		    }
			
			
			$transactionid =  $_POST['TransactionID'] ;
			$storeUserSession = $this->session->userdata('storeUserSession');
			$data = array(
				'transaction_id' => urldecode($_POST['TransactionID']),
				'authorization_code' => urldecode($_POST['AuthorizationCode']),
				'reference_number' => urldecode($_POST['ReferenceNumber']),
				'user_id'		=>  $storeUserSession['id'],
				'order_amount'	=>  $ItemTotalPrice ,
				'order_volume'  => $itemVolume,
				'store_id'		=>  $this->store_id,
				'order_status' => 1,
				'tax' => $paypal_product['assets']['tax_total'] ,
				'shipping' => $paypal_product['assets']['shippin_cost'] ,
				'coupon_code' =>$coupon_code ,
				'coupon_discount_ammount'=>$disc_amt ,
				'order_comment' => $this->cart->get_order_comment(),
				'gateway' => 1
			);

			// ResponseMessage
			// TransactionID
			// TransactionAmount
			// AuthorizationCode
			if( $this->common_model->insert('order', $data ) ){
				$orderid = $this->db->insert_id();
				foreach( $this->cart->contents() as $cart )
	    		{
				    #pr($cart) ;
				    #die;
				    $item_data = array( 
				    	'order_id'              => $orderid,
				    	'client_product_id'     => $cart['id'] ,
				    	'product_sale_price'    => $cart['price'] ,
						'product_volume'        => $itemVolumeArray[$cart['id']],
				    	'product_normal_price'  => $cart['price'],
				    	'product_quantity'      => $cart['qty'],
				    	'size'                  => @$cart['options']['size'] ,
				    	'product_specification' => @$cart['options']['spcifications'] ,
				    	) ;
				    $this->common_model->insert('order_detail', $item_data ) ;

				    $order_detailid = $this->db->insert_id();
				    if(!empty($cart['options']['attributelist'])){
				    	$this->update_orderdetail_attributelist($order_detailid , $cart['options']['attributelist']) ;
				    }

				    $item_data = array();
	    		}
	    		
	    		// updating the shipping and billing detail table
	    		$isCouponForStore = $this->common_model->checkCouponStore( $this->store_id , $coupon_code , $storeUserSession['id'] )  ;
	    		#pr($isCouponForStore) ;
	    		#die;
	    		if(@$isCouponForStore){
	    			$couponid =  $isCouponForStore->id ;

	    			$where_data = array('store_id' => $this->store_id, 'user_id' => $storeUserSession['id'] ,'coupon_id'=>$couponid);
	    			$coupon_up  = array('status_used'=>1) ;
	    			$this->common_model->updateWhere('coupontracking', $where_data,  $coupon_up );  
	    		}
	    		$where_data = array('store_id' => $this->store_id, 'user_id' => $storeUserSession['id'] ,'order_id'=>0);

	    		$shipping_data = $this->common_model->findWhere( 'shipping', $where_data, FALSE, array('id'=>'desc'));
	    		

				$billing_data = $this->common_model->findWhere( 'billing', $where_data, FALSE, array('id'=>'desc'));
	    		
	    		$billing_up =  array('order_id' =>$orderid) ;
	    		$shipping_up =  array('order_id' =>$orderid) ;

	    		$this->common_model->updateWhere('billing', $where_data,  $billing_up );
    			$this->common_model->updateWhere('shipping', $where_data,  $shipping_up );  
    			// call for function to genrate an invoice in AVALARA TAX system starts now 
    			// Disc amount  is in negative so we have to place a neg. sign before it .
    			$this->avalarainvoice($store , $store_settings , $paypal_product['assets']['shippin_cost'] , -$disc_amt , $orderid ,$shipping_data) ;
    			// call for function to genrate an invoice in AVALARA TAX system ends now
    			$this->emailtpl($orderid) ;
    			redirect( site_url() . $this->storename . '/cart/thanks?tid=' . $transactionid );
    			exit;
			}
			
		}
		
		if(isset($_GET["token"]) && isset($_GET["PayerID"]))
		{
			/*we will be using these two variables to execute the "DoExpressCheckoutPayment"
			Note: we haven't received any payment yet.*/
			
			$token = $_GET["token"];
			$payer_id = $_GET["PayerID"];
			
			$paypal_product   = $this->session->userdata('paypal_productsdata');
			

			$paypal_data = '';
			$ItemTotalPrice = 0;
			$coupon_code = '';
			$disc_amt = 0 ;
		    foreach($paypal_product['items'] as $key=>$p_item)
		    {

				$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='. urlencode($p_item['itm_qty']);
		        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($p_item['itm_price']);
		        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($p_item['itm_name']);
		        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($p_item['itm_code']);
		        
				// item price X quantity
		        $subtotal = ($p_item['itm_price']*$p_item['itm_qty']);
				
		        //total price
		        $ItemTotalPrice = ($ItemTotalPrice + $subtotal);
		        if($p_item['itm_name'] == 'Coupon Code'){
		        	$coupon_code = $p_item['itm_code'] ;
		        	$disc_amt = $p_item['itm_price'] ;
		        }
		    }

		    //paypal settings
			$PayPalMode 			= PAY_MODE; // sandbox or live
			$PayPalApiUsername 		= $store_settings[0]->paypal_username; //PayPal API Username
			$PayPalApiPassword 		= $store_settings[0]->paypal_password; //Paypal API password
			$PayPalApiSignature 	= $store_settings[0]->paypal_signature;  //Paypal API Signature
			$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code
			$PayPalReturnURL 		= site_url() . $this->storename . '/cart/success'; //'http://localhost/paypal-shopping-cart-example/paypal-express-checkout/process.php'; //Point to process.php page
			//$PayPalCancelURL 		= 'http://localhost/paypal-shopping-cart-example/paypal-express-checkout/cancel_url.html'; //Cancel URL if user clicks cancel
			$PayPalCancelURL 		= site_url() . $this->storename .'/cart/cancel' ; 

			$padata = 	'&TOKEN='.urlencode($token).
						'&PAYERID='.urlencode($payer_id).
						'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
						$paypal_data.
						'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
						'&PAYMENTREQUEST_0_TAXAMT='.urlencode($paypal_product['assets']['tax_total']).
						'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($paypal_product['assets']['shippin_cost']).
						//'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($paypal_product['assets']['handaling_cost']).
						//'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($paypal_product['assets']['shippin_discount']).
						//'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($paypal_product['assets']['insurance_cost']).
						'&PAYMENTREQUEST_0_AMT='.urlencode($paypal_product['assets']['grand_total']).
						'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);

			//We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
			
			$httpParsedResponseAr = $this->paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
			
			//Check if everything went ok..
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
			{
					//
					$storeUserSession = $this->session->userdata('storeUserSession');
					$data = array(
						'transaction_id' => urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]),
						'user_id'		=>  $storeUserSession['id'],
						'order_amount'	=>  $ItemTotalPrice ,
						'order_volume'  => $itemVolume,
						'store_id'		=>  $this->store_id,
						'order_status' => 1,
						'tax' => $paypal_product['assets']['tax_total'] ,
						'shipping' => $paypal_product['assets']['shippin_cost'] ,
						'coupon_code' =>$coupon_code ,
						'coupon_discount_ammount'=>$disc_amt ,
						'order_comment' => $this->cart->get_order_comment(),
					);
					if( $this->common_model->insert('order', $data ) )
					{
						$orderid = $this->db->insert_id();
						foreach( $this->cart->contents() as $cart )
			    		{
						    $item_data = array(
						    	'order_id'=> $orderid,
						    	'client_product_id' =>$cart['id'] ,
						    	'product_sale_price' => $cart['price'] ,
						    	'product_normal_price' => $cart['price'],
								'product_volume'        => $itemVolumeArray[$cart['id']],
						    	'product_quantity' => $cart['qty'],
						    	'size' => @$cart['options']['size'] ,
						    	'product_specification'=> @$cart['options']['spcifications'] ,
						    	) ;
						    $this->common_model->insert('order_detail', $item_data ) ;
						    $order_detailid = $this->db->insert_id();
						    if(!empty($cart['options']['attributelist'])){
						    	$this->update_orderdetail_attributelist($order_detailid , $cart['options']['attributelist']) ;
						    }
				    
						    $item_data = array();
			    		}
			    		// updating the shipping and billing detail table
			    		$isCouponForStore = $this->common_model->checkCouponStore( $this->store_id , $coupon_code , $storeUserSession['id'] )  ;
			    		
			    		if(@$isCouponForStore){
			    			$couponid =  $isCouponForStore->id ;

			    			$where_data = array('store_id' => $this->store_id, 'user_id' => $storeUserSession['id'] ,'coupon_id'=>$couponid);
			    			$coupon_up  = array('status_used'=>1) ;
			    			$this->common_model->updateWhere('coupontracking', $where_data,  $coupon_up );  
			    		}
			    		$where_data = array('store_id' => $this->store_id, 'user_id' => $storeUserSession['id'] ,'order_id'=>0);

			    		$shipping_data = $this->common_model->findWhere( 'shipping', $where_data, FALSE, array('id'=>'desc'));


						$billing_data = $this->common_model->findWhere( 'billing', $where_data, FALSE, array('id'=>'desc'));
			    		
			    		$billing_up =  array('order_id' =>$orderid) ;
			    		$shipping_up =  array('order_id' =>$orderid) ;

			    		$this->common_model->updateWhere('billing', $where_data,  $billing_up );
            			$this->common_model->updateWhere('shipping', $where_data,  $shipping_up );  

            			// call for function to genrate an invoice in AVALARA TAX system starts now
		    			$this->avalarainvoice($store , $store_settings , $paypal_product['assets']['shippin_cost'] ,  -$disc_amt , $orderid , $shipping_data) ;
		    			// call for function to genrate an invoice in AVALARA TAX system ends now

			    		// updating shipping and billing detail table ends here

            			$this->emailtpl($orderid) ;

						redirect( site_url() . $this->storename . '/cart/thanks?tid=' . $httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"] );
						echo "<h1>Its working</h1>";
					}
					
			}else{
				echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
				echo '<pre>';
		//		print_r($httpParsedResponseAr);
				echo '</pre>';
			}
		}
	}

	/**
	 * method name  consultantsuccess
     * purpose		After getting a success response from paypal at the time of consultant store page item purchase 
     * 				the function is being used for final settlement of an account purrchase
     * @param 		none
     */
	function consultantsuccess()
	{
		//echo 'consultant success page';
		$this->__is_valid_client_store() ;
		$consulttantDetail =  trim($this->uri->segments[2]) ;	
		$itemVolume = 0;
		$itemVolumeArray = array();
		foreach( $this->cart->contents() as $cart )
		{
			$volume = $this->product_model->getProductVolume($cart['id']);
			$itemVolume += ($cart['qty']*$volume);
			$itemVolumeArray[$cart['id']] = $volume;
		}
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
		
		$storeid = $store[0]['id'] ;
		$store_username =   strtolower($store[0]['username']) ;
		$is_custom_theme =  $store[0]['is_custom_theme'] ;

		if($is_custom_theme){
			$this->_vci_layout('clientstore_default',$store_username.'_'.$storeid);
		}else{
			$this->_vci_layout('clientstore_default') ;
		}

		$store_settings = $this->common_model->getstoresetting($storeid) ;
		if(count($store_settings) == 0){
			echo 'Purchase can not be done, Payoption is not configured yet By Store';
			exit;
		}

		$this->load->model('user_model');
		$clientdetail = $this->client_model->get_client_details( trim($this->uri->segments[1]) );

		$consultantDetail = $this->user_model->is_consultant_exists(trim($this->uri->segments[2]), $clientdetail->id) ;

		$consultant_user_id = $consultantDetail[0]->id ;

		if(@$_GET['method'] == 'meritus'){
			
			$paypal_product   = $this->session->userdata('paypal_productsdata');
			$transactionid 	  = $_POST['TransactionID'] ;
			$storeUserSession = $this->session->userdata('storeUserSession');
			
			$ItemTotalPrice = 0;
			$coupon_code = '';
			$disc_amt = 0 ;
			$g_code = '' ;
		    foreach($paypal_product['items'] as $key=>$p_item)
		    {
				// item price X quantity
		        $subtotal = ($p_item['itm_price']*$p_item['itm_qty']);
				
		        //total price
		        $ItemTotalPrice = ($ItemTotalPrice + $subtotal);

		        if($p_item['itm_name'] == 'Group Event'){
		        	$g_code = $p_item['itm_code'] ;
		        }

		        if($p_item['itm_name'] == 'Coupon Code'){
		        	$coupon_code = $p_item['itm_code'] ;
		        	$disc_amt = $p_item['itm_price'] ;
		        }
		        
		    }

			$data = array(
					'transaction_id' => urldecode($_POST['TransactionID']),
					'authorization_code' => urldecode($_POST['AuthorizationCode']),
					'reference_number' => urldecode($_POST['ReferenceNumber']),
					'user_id'		=>  $storeUserSession['id'],
					'order_amount'	=>  $ItemTotalPrice ,
					'order_volume'  => $itemVolume,
					'store_id'		=>  $this->store_id,
					'order_status' => 1,
					'consultant_user_id'=> $consultant_user_id,
					'tax' => $paypal_product['assets']['tax_total'] ,
					'shipping' => $paypal_product['assets']['shippin_cost'] ,
					'group_purchase_code' => $g_code ,
					'coupon_code' =>$coupon_code ,
					'coupon_discount_ammount'=>$disc_amt ,
					'order_comment' => $this->cart->get_order_comment(),
					'gateway' => 1
				);

			if( $this->common_model->insert('order', $data ) ){
					$orderid = $this->db->insert_id();
					foreach( $this->cart->contents() as $cart )
		    		{
		    			
					    $item_data = array(
					    	'order_id'=> $orderid,
					    	'client_product_id' =>$cart['id'] ,
					    	'product_sale_price' => $cart['price'] ,
					    	'product_normal_price' => $cart['price'],
							'product_volume'        => $itemVolumeArray[$cart['id']],
					    	'product_quantity' => $cart['qty'],
					    	'size' =>$cart['options']['size'] ,
					    	'product_specification'=> @$cart['options']['spcifications'] ,
					    	) ;
					    $this->common_model->insert('order_detail', $item_data ) ;
					    $order_detailid = $this->db->insert_id();
					    if(!empty($cart['options']['attributelist'])){
					    	$this->update_orderdetail_attributelist($order_detailid , $cart['options']['attributelist']) ;
					    }

					    $item_data = array();
		    		}

		    		// updating the shipping and billing detail table
		    		$isCouponForStore = $this->common_model->checkCouponStore( $this->store_id , $coupon_code , $storeUserSession['id'] )  ;
		    		#pr($isCouponForStore) ;
		    		#die;
		    		if(@$isCouponForStore){
		    			$couponid =  $isCouponForStore->id ;

		    			$where_data = array('store_id' => $this->store_id, 'user_id' => $storeUserSession['id'] ,'coupon_id'=>$couponid);
		    			$coupon_up  = array('status_used'=>1) ;
		    			$this->common_model->updateWhere('coupontracking', $where_data,  $coupon_up );  
		    		}
		    		
		    		$where_data = array('store_id' => $this->store_id, 'user_id' => $storeUserSession['id'] ,'order_id'=>0);

		    		$shipping_data = $this->common_model->findWhere( 'shipping', $where_data, FALSE, array('id'=>'desc'));
		    		

					$billing_data = $this->common_model->findWhere( 'billing', $where_data, FALSE, array('id'=>'desc'));
		    		
		    		$billing_up =  array('order_id' =>$orderid) ;
		    		$shipping_up =  array('order_id' =>$orderid) ;
		    		
		    		$this->common_model->updateWhere('billing', $where_data,  $billing_up );
        			$this->common_model->updateWhere('shipping', $where_data,  $shipping_up ); 

        			// call for function to genrate an invoice in AVALARA TAX system starts now
		    		$this->avalarainvoice($store , $store_settings , $paypal_product['assets']['shippin_cost'] ,  -$disc_amt , $orderid , $shipping_data) ;
		    		// call for function to genrate an invoice in AVALARA TAX system ends now

		    		// updating shipping and billing detail table ends here
		    		$this->emailtpl($orderid) ;
	    			redirect( site_url() . $this->storename .'/'.$this->uri->segments[2].'/cart/thanks?tid=' . $transactionid );
	    			exit;
        		}
		}

		//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
		if(isset($_GET["token"]) && isset($_GET["PayerID"]))
		{
			//we will be using these two variables to execute the "DoExpressCheckoutPayment"
			//Note: we haven't received any payment yet.
			
			$token = $_GET["token"];
			$payer_id = $_GET["PayerID"];

			$paypal_product   = $this->session->userdata('paypal_productsdata');

			$paypal_data = '';
			$ItemTotalPrice = 0;
			$coupon_code = '';
			$disc_amt = 0 ;
			$g_code = '' ;
		    foreach($paypal_product['items'] as $key=>$p_item)
		    {		
				//pr($p_item) ;
				$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='. urlencode($p_item['itm_qty']);
		        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($p_item['itm_price']);
		        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($p_item['itm_name']);
		        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($p_item['itm_code']);
		        
				// item price X quantity
		        $subtotal = ($p_item['itm_price']*$p_item['itm_qty']);
				
		        //total price
		        $ItemTotalPrice = ($ItemTotalPrice + $subtotal);

		        if($p_item['itm_name'] == 'Group Event'){
		        	$g_code = $p_item['itm_code'] ;
		        }

		        if($p_item['itm_name'] == 'Coupon Code'){
		        	$coupon_code = $p_item['itm_code'] ;
		        	$disc_amt = $p_item['itm_price'] ;
		        }
		        
		    }
		    
		    //paypal settings
			$PayPalMode 			= PAY_MODE ; // sandbox or live
			$PayPalApiUsername 		= $store_settings[0]->paypal_username; //PayPal API Username
			$PayPalApiPassword 		= $store_settings[0]->paypal_password; //Paypal API password
			$PayPalApiSignature 	= $store_settings[0]->paypal_signature;  //Paypal API Signature
			$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code
			$PayPalReturnURL 		= site_url() . $this->storename .'/'.$consulttantDetail.'/cart/success'; //'http://localhost/paypal-shopping-cart-example/paypal-express-checkout/process.php'; //Point to process.php page
			//$PayPalCancelURL 		= 'http://localhost/paypal-shopping-cart-example/paypal-express-checkout/cancel_url.html'; //Cancel URL if user clicks cancel
			$PayPalCancelURL 		= site_url() . $this->storename .'/'.$consultantDetail. '/cart/cancel' ; 

			$padata = 	'&TOKEN='.urlencode($token).
						'&PAYERID='.urlencode($payer_id).
						'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
						$paypal_data.
						'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
						'&PAYMENTREQUEST_0_TAXAMT='.urlencode($paypal_product['assets']['tax_total']).
						'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($paypal_product['assets']['shippin_cost']).
						//'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($paypal_product['assets']['handaling_cost']).
						//'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($paypal_product['assets']['shippin_discount']).
						//'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($paypal_product['assets']['insurance_cost']).
						'&PAYMENTREQUEST_0_AMT='.urlencode($paypal_product['assets']['grand_total']).
						'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);

			//We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
			$httpParsedResponseAr = $this->paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
			
			//Check if everything went ok..
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
			{
				$storeUserSession = $this->session->userdata('storeUserSession');
				
				
				
				$data = array(
					'transaction_id' => urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]),
					'user_id'		=>  $storeUserSession['id'],
					'order_amount'	=>  $ItemTotalPrice ,
					'order_volume'  => $itemVolume,
					'store_id'		=>  $this->store_id,
					'order_status' => 1,
					'consultant_user_id'=> $consultant_user_id,
					'tax' => $paypal_product['assets']['tax_total'] ,
					'shipping' => $paypal_product['assets']['shippin_cost'] ,
					'group_purchase_code' => $g_code ,
					'coupon_code' =>$coupon_code ,
					'coupon_discount_ammount'=>$disc_amt ,
					'order_comment' => $this->cart->get_order_comment(),
				);

				if( $this->common_model->insert('order', $data ) ){
					$orderid = $this->db->insert_id();
					foreach( $this->cart->contents() as $cart )
		    		{
		    			
					    $item_data = array(
					    	'order_id'=> $orderid,
					    	'client_product_id' =>$cart['id'] ,
					    	'product_sale_price' => $cart['price'] ,
					    	'product_normal_price' => $cart['price'],
							'product_volume'        => $itemVolumeArray[$cart['id']],
					    	'product_quantity' => $cart['qty'],
					    	'size' =>$cart['options']['size'] ,
					    	'product_specification'=> @$cart['options']['spcifications'] ,
					    	) ;
					    $this->common_model->insert('order_detail', $item_data ) ;
					    $order_detailid = $this->db->insert_id();
					    if(!empty($cart['options']['attributelist'])){
					    	$this->update_orderdetail_attributelist($order_detailid , $cart['options']['attributelist']) ;
					    }
				    
					    $item_data = array();
		    		}

		    		// updating the shipping and billing detail table
		    		$isCouponForStore = $this->common_model->checkCouponStore( $this->store_id , $coupon_code , $storeUserSession['id'] )  ;
		    		#pr($isCouponForStore) ;
		    		#die;
		    		if(@$isCouponForStore){
		    			$couponid =  $isCouponForStore->id ;

		    			$where_data = array('store_id' => $this->store_id, 'user_id' => $storeUserSession['id'] ,'coupon_id'=>$couponid);
		    			$coupon_up  = array('status_used'=>1) ;
		    			$this->common_model->updateWhere('coupontracking', $where_data,  $coupon_up );  
		    		}
		    		
		    		$where_data = array('store_id' => $this->store_id, 'user_id' => $storeUserSession['id'] ,'order_id'=>0);

		    		$shipping_data = $this->common_model->findWhere( 'shipping', $where_data, FALSE, array('id'=>'desc'));
		    		

					$billing_data = $this->common_model->findWhere( 'billing', $where_data, FALSE, array('id'=>'desc'));
		    		
		    		$billing_up =  array('order_id' =>$orderid) ;
		    		$shipping_up =  array('order_id' =>$orderid) ;
		    		
		    		$this->common_model->updateWhere('billing', $where_data,  $billing_up );
        			$this->common_model->updateWhere('shipping', $where_data,  $shipping_up );  

		    		// updating shipping and billing detail table ends here
        			/*
        			// email start	
        			$storedata = $this->common_model->get_clientdetail('',$this->store_id);
        			$c_user_email = $this->session->userdata['storeUserSession'];
        			$store_email_address = $storedata[0]['email'];
        			$email = $c_user_email['email'];
        			$username = $c_user_email['username'];
        			
        			//Send Email Below
        			$this->load->library('email');
        			$this->load->library('parser');
        			$smtp_settings = $this->config->item('smtp');
        			$sender_from = $this->config->config['sender_from'];
        			$sender_name = $this->config->config['sender_name'] ;
        			$this->email->initialize( $smtp_settings );
					//$this->email->initialize($config);
        			$this->email->from( $sender_from, $sender_name );
        			$this->email->to( htmlspecialchars( $email ) );
        			
        			$order_detail = $this->common_model->order_detail($orderid);
        			$order_view   = $this->common_model->order_view($orderid);
        			
        			$order_status = '';
        			if($order_view->order_status == 1)
        			{
        				$order_status = 'Paid';
        			}
        			else if($order_view->order_status == 2)
        			{
        				$order_status = 'shipped';
        			}
        			else if($order_view->order_status == 3)
        			{
        				$order_status = 'completed';
        			}
        			else if($order_view->order_status == 4)
        			{
        				$order_status = 'cancelled /Refunded';
        			}
        			else
        			{
        				$order_status == '' ;
        			}

        			$grandTotal = $order_view->order_amount+$order_view->tax+$order_view->shipping;
        			$first_order_detail = "
        			<table border='1'>
        				<tr>
        					<th colspan='2'>Order Detail</th>
        				</tr>
        				<tr>
        					<th>Store Name: </th>
        					<td>".$order_view->store_name."</td>
        				</tr>
            			<tr>
	            			<th>Transaction Id: </th>
	            			<td>".$order_view->transaction_id."</td>
            			</tr>
            			<tr>
	            			<th>Order Amount: </th>
	            			<td>$".$order_view->order_amount."</td>
            			</tr>
            			<tr>
	            			<th>Order Status: </th>
	            			<td>".$order_status."</td>
            			</tr>
            			<tr>
	            			<th>Order Date: </th>
	            			<td>".date('Y-m-d', strtotime($order_view->created_time))."</td>
            			</tr>
            			<tr>
	            			<th>Tax: </th>
	            			<td>$".$order_view->tax."</td>
            			</tr>
            			<tr>
	            			<th>Shipping: </th>
	            			<td>$".$order_view->shipping."</td>
            			</tr>
            			<tr>
	            			<th>Grand Total: </th>
	            			<td>$".$grandTotal."</td>
            			</tr>
        			</table>
        			";
        			 
        			$order_item = "
        			<table border='1' cellpadding='10px'>
        			<tr>
        				<th colspan='4'>Order Item</th>
        			</tr>
        			<tr>
            			<th>Item</th>
            			<th>Quantity</th>
            			<th>Total</th>
            			<th>Size</th>
        			</tr>";
        			foreach ($order_detail as $key => $value)
        			{
        			$order_item .= "<tr>
        			<td>
        			".$value->product_title."
        			</td>
        			<td>
        			".$value->product_quantity."
        			</td>
        			<td>
        			".$value->product_quantity." X ".$value->product_sale_price."
        			</td>
        			<td>
        			".$value->szp."
        			</td>
        			</tr></tr><tr><td>Specifications: </td><td colspan='3'>".$value->product_specification."</td></tr>";
        			}
        				$order_item .= "</table>
        				";
        			// email detail ends here

        				$social_links = $this->client_model->get_client_social_links( trim($this->store_id) );
        				$store_company_name = $this->client_model->get_client_details( trim($this->storename) );
        				
        				$this->fb_link        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
        				$this->twitter_link   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
        				$this->pinterest_link = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
        				$this->linkdin_link   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
        				$this->gplus_link     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
        				$this->youtube_link   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
        				
						$ndata = array(
								'base_url'         => base_url(),
								'facebook_link'    => $this->fb_link,
								'linkdin_link'     => $this->linkdin_link,
								'twitter_link'     => $this->twitter_link,
								'googleplus_link'  => $this->gplus_link,
								'pinterest_link'   => $this->pinterest_link,
								'youtube_link'     => $this->youtube_link,
								'email_logo'       => substr($this->logo_image,1),
								'facebook_image'   => 'application/views/default/images/fb.png',
								'linkdin_image'    => 'application/views/default/images/in.png',
								'twitter_image'    => 'application/views/default/images/twitter.png',
								'googleplus_image' => 'application/views/default/images/googleplus.png',
								'pinterest_image'  => 'application/views/default/images/p.png',
								'youtube_image'    => 'application/views/default/images/youtb.png',
								'title'            => 'Buy Product Successfully',
								'CONTENT'          => 'Thank you for placing your order, your order detail as follows:',
								'USER'             => htmlspecialchars( ucwords( $username ) ),
								'order_detail'     => $first_order_detail,
								'order_item'       => $order_item,
								'regards'          => ucwords($store_company_name->company)
        				);
        						 
        				// get data from email_template id number 2
        				$res_email_template = $this->common_model->get_email_template_data(1);
        				$body = $this->parser->parse2($res_email_template->content, $ndata, true);
        				//	$body = $this->parser->parse('default/store/emails/consultant_register', $ndata, true);
        				//$this->email->bcc($this->config->config['sender_from']);
        				//$this->email->bcc($store_email_address);
        				$this->email->subject('Thank you for placing your order - '.ucwords($store_company_name->company));
        				$this->email->message( $body );
        			
        				if ( ! $this->email->send())
        				{
        				  #echo $this->email->print_debugger();
					  
        				}
        			// email sent end shere
        			*/
        			// call for function to genrate an invoice in AVALARA TAX system starts now
		    		$this->avalarainvoice($store , $store_settings , $paypal_product['assets']['shippin_cost'] ,  -$disc_amt , $orderid , $shipping_data) ;
		    		// call for function to genrate an invoice in AVALARA TAX system ends now

        			$this->emailtpl($orderid) ;	
					redirect( site_url() . $this->storename .'/'.$consulttantDetail.'/cart/thanks?tid=' . $httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"] );
					echo "<h1>Its working</h1>";
				}
				#echo '<h2>Success</h2>';
				#echo 'Your Transaction ID : '.urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);

			}else{
				echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			}
		}
	}


	/**
	 * method name  getCouponDiscount
     * purpose		getting coupon discount
     * @param 		coupon , storeid , cuserid
     */
	function getCouponDiscount( $coupon='' , $storeid ='' , $cuserid = '')
	{
		if($cuserid){
			if($coupon && $storeid )
			{	
				$data = $this->common_model->findWhere( 'coupons', array( 'code' => $coupon,'store_id'=> $storeid ), FALSE );
				pr($data) ;
				die;
                if ( is_array( $data ) && !empty( $data ) )
                {
                	//print_r($data);
                	$discountPercent = $data['discount_percent'];
                	return $discountAmount = $this->cart->total() * $discountPercent / 100;
                }
                else
                {
                    return FALSE;die;
                }	
				die;
			}
			else
			{
				return false;
				die;
			}
		}else{
			return 0 ;
		}			
	}

	/**
	 * method name  getShippingAmount
     * purpose		for getting the shipping charges being appied
     * @param 		coupon , storeid , cuserid
     */
	function getShippingAmount( $state_code = FALSE )
	{
		$this->__is_valid_store();
		$storeUserSession = $this->session->userdata('storeUserSession');
		if( isset( $storeUserSession['id'] ) && !empty( $storeUserSession['id'] ) )
		{
			$data = $this->common_model->findWhere( 'shippingcost', array( 'state_code' => $state_code, 'store_id' => $this->store_id ), FALSE );
			if ( is_array( $data ) && !empty( $data ) )
            {
                	//print_r($data);
               	return $data['shipping_cost'];
            }
            else
            {
                return 10;die;
            }
		}
		else
		{
			return FALSE;
		}

	}

	
	/**
	 * method name  changeshipping
     * purpose		for changing the shipping state -- used in AJAX call at the page
     * @param 		
     */
	function changeshipping(){
		$this->_vci_layout = '' ;
		//$this->__is_valid_client_store() ;
		$consulttantDetail =  trim($this->uri->segments[2]) ;	
		$this->load->model('common_model') ;

		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
		$state_code = $this->input->get('state_id') ;
		$storeid = $store[0]['id'] ;
		$cost = $this->common_model->calculate_shipping($storeid,$state_code) ;
		echo $cost ;
		die;
	}

	/**
	 * method name  changeshipping
     * purpose		for changing the shipping state -- used in AJAX call at the page
     * @param 		
     */
	function changetax(){
		$this->_vci_layout = '' ;
		//$this->__is_valid_client_store() ;
		$consulttantDetail =  trim($this->uri->segments[2]) ;	
		$this->load->model('common_model') ;
		$this->load->library('Avatax'); // Added on
		$overridetaxes = 0 ;
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
        
		$state_code = $this->input->get('state_id') ;
		$city = $this->input->get('city') ;
		$postalcode = $this->input->get('postalcode') ;

		$cart_total = $this->input->get('cart_total') ;
		$storeid = $store[0]['id'] ; //calculate_taxes($store_id, $cart_total ,$state_code)

		$store_settings = $this->common_model->getstoresetting($storeid) ;

        //echo 'Assjgjgjd fdjgfjds gfdj';
        // pr($store_settings) ;
        $storeUserSession = $this->session->userdata('storeUserSession');
        $ship_cost = $this->common_model->calculate_shipping($storeid,$state_code) ;
		#pr($store_settings) ;
		// AVALARA AVA TAX new part added here

		$avaconfig = array() ;
		if($store_settings[0]->ava_account_number && $store_settings[0]->ava_license_key && $store_settings[0]->ava_company_code){
			$avaconfig['accountNumber'] = $store_settings[0]->ava_account_number;
			$avaconfig['licenseKey']    = $store_settings[0]->ava_license_key;
			$avaconfig['serviceURL']    = AVATAX_SERVICEURL ;   
			$avaconfig['company_code']  = $store_settings[0]->ava_company_code ; 
			$overridetaxes =  1 ;

			$customer['customer_code'] = $storeUserSession['id'] ; 
			$customer['customer_id']   = $storeUserSession['id'] ; // simplesales system user id 

			
			$cartdetail[] = array('id'=>'shipping',
				'qty'=>1,
				'price'=>$ship_cost ,
				'name'=>'Shipping Charges',
				'subtotal'=>$ship_cost,
				'tax_code' => 'FR'
				) ;

			// $itemsdetail = array() ;
			// $cartdetail  = array() ;
			foreach ($this->cart->contents() as $key => $value) {
				# code...
				#pr($value) ;
				$items['id'] 		= $value['id'] ;
				$items['qty'] 		= $value['qty'] ;
				$items['price'] 	= $value['price'] ;
				$items['name'] 		= $value['name'] ;
				$items['subtotal'] 	= $value['subtotal'] ;
				$items['tax_code'] 	= $this->gettaxcode($value['id']) ;
				$cartdetail[] = $items ;
			}

			$addr =  array(
	    		'state_code'=>$store[0]['state_code'],
	    		'city'=>$store[0]['city'],
	    		'zip'=>$store[0]['zip'],
	    		'country'=>'US'
	    		) ;
	    	
	    	$addresss[] = $addr ;
	    	//pr($shipping_data) ; // customer detail
	    	$addr2 = array(
	    		'state_code'=>$state_code ,
	    		'city'=>$city,
	    		'zip'=>$postalcode,
	    		'country'=>'US'
	    		) ;
	    	$addresss[] = $addr2 ;
		}

		// coupon code starts here
		$discountprice = 0 ;

		$usercoupon_data = $this->session->userdata('coupon_data') ;
	    if(! empty($usercoupon_data)){
			$coupon_data = $this->session->userdata('coupon_data') ;
			if($coupon_data['ctype'] == 1){
				$discountprice = $coupon_data['amount'] ;
			}else if(($coupon_data['ctype'] == 2) || ($coupon_data['ctype'] == 3)){
				$discountprice = $this->cart->total()*$coupon_data['amount']/100 ;
			}else{
			   $discountprice = 0 ;
			}

			if($discountprice > $this->cart->total() ){
				$discountprice = 0 ;
			}
		}

		// coupon code ends here
		if(!$overridetaxes){
			$cost =  $this->common_model->calculate_taxes($storeid,$this->cart->total(),$state_code) ;	
		}else{
			$cost = $this->avatax->getax($avaconfig , $customer , $addresss, $cartdetail , $discountprice) ;   
		}
		echo $cost ;
        die;
	}

	function changetaxold(){
		$this->_vci_layout = '' ;
		//$this->__is_valid_client_store() ;
		$consulttantDetail =  trim($this->uri->segments[2]) ;	
		$this->load->model('common_model') ;

		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);

		$state_code = $this->input->get('state_id') ;
		$cart_total = $this->input->get('cart_total') ;
		$storeid = $store[0]['id'] ; //calculate_taxes($store_id, $cart_total ,$state_code)

		$cost = $this->common_model->calculate_taxes($storeid,$cart_total,$state_code) ;
		echo $cost ;
		die;
	}

	
	function emailtpl($orderid){
      $this->load->model('common_model') ;
      $this->load->model('client_model') ;
      //Send Email Below
      $this->load->library('email');
      $this->load->library('parser');

      $storedata = $this->common_model->get_clientdetail('',$this->store_id);
      $c_user_email = $this->session->userdata['storeUserSession'];
      $store_email_address = $storedata[0]['email'];
      $email = $c_user_email['email'];
      $username = $c_user_email['username'];

      $smtp_settings = $this->config->item('smtp');
      $sender_from = $this->config->config['sender_from'];
      $sender_name = $this->config->config['sender_name'];
      $this->email->initialize( $smtp_settings );
                              
      $this->email->from( $sender_from, $sender_name );
      $this->email->to( htmlspecialchars( $email ) );

      $order_detail = $this->common_model->order_detail($orderid);
      $order_view   = $this->common_model->order_view($orderid);

      $order_status = '';
      if($order_view->order_status == 1)
      { 
            $order_status = 'Paid';
      }
      else if($order_view->order_status == 2)
      { 
            $order_status = 'shipped';
      }
      else if($order_view->order_status == 3)
      { 
          $order_status = 'completed';
      }
      else if($order_view->order_status == 4)
      { 
          $order_status = 'cancelled /Refunded';
      }
      else
      {
          $order_status == '' ;
      }
                              
      $grandTotal = $order_view->order_amount+$order_view->tax+$order_view->shipping;
      $first_order_detail = "
                              <table border='1'>
                                    <tr>
                                          <th colspan='2'>Order Detail</th>
                                    </tr>
                                    <tr>
                                          <th>Store Name: </th>
                                          <td>".$order_view->store_name."</td>
                                    </tr>
                                    <tr>
                                          <th>Transaction Id: </th>
                                          <td>".$order_view->transaction_id."</td>
                                    </tr>
                                    <tr>
                                          <th>Order Amount: </th>
                                          <td>$".$order_view->order_amount."</td>
                                    </tr>
                                    <tr>
                                          <th>Order Status: </th>
                                          <td>".$order_status."</td>
                                    </tr>
                                    <tr>
                                          <th>Order Date: </th>
                                          <td>".date('Y-m-d', strtotime($order_view->created_time))."</td>
                                    </tr>
                                    <tr>
                                          <th>Tax: </th>
                                          <td>$".$order_view->tax."</td>
                                    </tr>
                                    <tr>
                                          <th>Shipping: </th>
                                          <td>$".$order_view->shipping."</td>
                                    </tr>
                                    <tr>
                                          <th>Grand Total: </th>
                                          <td>$".$grandTotal."</td>
                                    </tr>
                              </table>
                              ";
                              
                              $order_item = "
                              <table border='1' cellpadding='10px'>
                                    <tr>
                                          <th colspan='4'>Order Item</th>
                                    </tr>
                                    <tr>
                                          <th>Item</th>
                                          <th>Quantity</th>
                                          <th>Total</th>
                                          <th>Size</th>
                                    </tr>";
                                    foreach ($order_detail as $key => $value) 
                                    {
                                          $order_item .= "<tr>
                                                <td>
                                                      ".$value->product_title."
                                                </td>
                                                <td>
                                                      ".$value->product_quantity."
                                                </td>
                                                <td>
                                                      ".$value->product_quantity." X ".$value->product_sale_price."
                                                </td>
                                                <td>
                                                ".$value->szp."
                                          </td>
                                          </tr></tr><tr><td>Specifications: </td><td colspan='3'>".$value->product_specification."</td></tr>";
                                   }
                              $order_item .= "</table>
                              ";
      $social_links = $this->client_model->get_client_social_links( trim($this->store_id) );
      $store_company_name = $this->client_model->get_client_details( trim($this->storename) );
      
      $this->fb_link        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
      $this->twitter_link   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
      $this->pinterest_link = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
      $this->linkdin_link   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
      $this->gplus_link     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
      $this->youtube_link   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
                                    
      $ndata = array(
                  'base_url'         => base_url(),
                  'facebook_link'    => $this->fb_link,
                  'linkdin_link'     => $this->linkdin_link,
                  'twitter_link'     => $this->twitter_link,
                  'googleplus_link'  => $this->gplus_link,
                  'pinterest_link'   => $this->pinterest_link,
                  'youtube_link'     => $this->youtube_link,
                  'email_logo'       => substr($this->logo_image,1),
                  'facebook_image'   => 'application/views/default/images/fb.png',
                  'linkdin_image'    => 'application/views/default/images/in.png',
                  'twitter_image'    => 'application/views/default/images/twitter.png',
                  'googleplus_image' => 'application/views/default/images/googleplus.png',
                  'pinterest_image'  => 'application/views/default/images/p.png',
                  'youtube_image'    => 'application/views/default/images/youtb.png',
                  'title'            => 'Buy Product Successfully',
                  'CONTENT'          => 'Thank you for placing your order, your order detail as follows:',
                  'USER'             => htmlspecialchars( ucwords( $username ) ),
                  'order_detail'     => $first_order_detail,
                  'order_item'       => $order_item,
                  'regards'          => ucwords($store_company_name->company)
      );
      // get data from email_template id number 2
      $res_email_template = $this->common_model->get_email_template_data(1);
      $body = $this->parser->parse2($res_email_template->content, $ndata, true);

      //    $body = $this->parser->parse('default/store/emails/consultant_register', $ndata, true);
      $this->email->bcc($this->config->config['sender_from']);
      $this->email->bcc($store_email_address);
      $this->email->subject('Thank you for placing your order - '.ucwords($store_company_name->company));
      $this->email->message( $body );
            
      if ( ! $this->email->send())
      {
            echo $this->email->print_debugger();
      }
      //email end

	}

	/* calculate tax */
	function ctax(){
		$this->__is_valid_store(); 
		ini_set('display_errors',1) ;
		$this->load->library('Avatax');
		$this->load->library('cart');

		/* for store active category */
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
		
    	$addr =  array(
    		'state_code'=>$store[0]['state_code'],
    		'city'=>$store[0]['city'],
    		'zip'=>$store[0]['zip'],
    		'country'=>'US'
    		) ;
    	
    	$addresss[] = $addr ;

    	$addr2 = array(
    		'state_code'=>$store[0]['state_code'],
    		'city'=>$store[0]['city'],
    		'zip'=>$store[0]['zip'],
    		'country'=>'US'
    		) ;

    	$addresss[] = $addr2 ;

		$storeid = $store[0]['id'] ;
		$store_settings = $this->common_model->getstoresetting($storeid) ;

		//pr($store_settings[0]) ;
		$avaconfig = array() ;
		if($store_settings[0]->ava_account_number && $store_settings[0]->ava_license_key && $store_settings[0]->ava_company_code){
			$avaconfig['accountNumber'] = $store_settings[0]->ava_account_number;
			$avaconfig['licenseKey']    = $store_settings[0]->ava_license_key;
			$avaconfig['serviceURL']    = AVATAX_SERVICEURL ;   
			$avaconfig['company_code']  = $store_settings[0]->ava_company_code ; 
		}
		

		$customer['customer_code'] = 'Abc-1551' ; 
		$customer['customer_id'] = '211212' ; // simplesales system user id 
		#$this->load->library('cart');
		#pr($this->cart->contents()) ;
		$itemsdetail = array() ;
		$cartdetail = array() ;
		foreach ($this->cart->contents() as $key => $value) {
			# code...
			#pr($value) ;
			$items['id'] 	= $value['id'] ;
			$items['qty'] 	= $value['qty'] ;
			$items['price'] = $value['price'] ;
			$items['name'] 	= $value['name'] ;
			$items['subtotal'] = $value['subtotal'] ;
			$items['tax_code'] = $this->gettaxcode($value['id']) ;
			$cartdetail[] = $items ;
		}
		//die;

		//$addresss = array('customer_id'=>'11111') ;
		$disc_amount = 0 ;
		//$cartdetail = $this->cart->contents();
		echo $totalTAx = $this->avatax->getax($avaconfig , $customer , $addresss, $cartdetail , $disc_amount) ;

		//die('Abhishek jdfjhdsf');
	}


	function avalarainvoice($store , $store_settings , $ship_cost , $disc_amt , $order_id , $shipping_data){
		$this->load->library('Avatax'); // Added on
		// AVALARA AVA TAX new part added here
		$storeUserSession = $this->session->userdata('storeUserSession');

		$overridetaxes =  0 ;
		$avaconfig = array() ;
		if($store_settings[0]->ava_account_number && $store_settings[0]->ava_license_key && $store_settings[0]->ava_company_code){
			$avaconfig['accountNumber'] = $store_settings[0]->ava_account_number;
			$avaconfig['licenseKey']    = $store_settings[0]->ava_license_key;
			$avaconfig['serviceURL']    = AVATAX_SERVICEURL ;   
			$avaconfig['company_code']  = $store_settings[0]->ava_company_code ; 
			$overridetaxes =  1 ;

			$customer['customer_code'] = $storeUserSession['id'] ; 
			$customer['customer_id']   = $storeUserSession['id'] ; // simplesales system user id 

			
			$cartdetail[] = array('id'=>'shipping',
				'qty'=>1,
				'price'=>$ship_cost ,
				'name'=>'Shipping Charges',
				'subtotal'=>$ship_cost,
				'tax_code' => 'FR'
				) ;

			// $itemsdetail = array() ;
			// $cartdetail  = array() ;
			foreach ($this->cart->contents() as $key => $value) {
				# code...
				#pr($value) ;
				$items['id'] 		= $value['id'] ;
				$items['qty'] 		= $value['qty'] ;
				$items['price'] 	= $value['price'] ;
				$items['name'] 		= $value['name'] ;
				$items['subtotal'] 	= $value['subtotal'] ;
				$items['tax_code'] 	= $this->gettaxcode($value['id']) ;
				$cartdetail[] = $items ;
			}

			$addr =  array(
	    		'state_code'=>$store[0]['state_code'],
	    		'city'=>$store[0]['city'],
	    		'zip'=>$store[0]['zip'],
	    		'country'=>'US'
	    		) ;
	    	
	    	$addresss[] = $addr ;
	    	//pr($shipping_data) ; // customer detail
	    	$addr2 = array(
	    		'state_code'=>$shipping_data['state_code'],
	    		'city'=>$shipping_data['city'],
	    		'zip'=>$shipping_data['postal_code'],
	    		'country'=>'US'
	    		) ;
	    	$addresss[] = $addr2 ;
		}
		// coupon code ends here
		if($overridetaxes){
			$this->avatax->createInvoice($avaconfig , $customer , $addresss, $cartdetail , $disc_amt , $order_id) ;   
		}
		// new patch code to ge here ends now
		// AVAlara tax Part added
	}

	/* Removing non mandtory option 
	   and then saving to database
	*/

	function removeopt($id,$rowid){
        //$this->cart->update($data); 
        $opt = $this->cart->product_options($rowid);
        $cartitem = $this->cart->contents();
        //pr($cartitem) ;
        $optdetailc = $this->product_model->getattributefielddetail($id) ; // fetching an opt detail to check whaether belong to mandatory one
        //pr($optdetailc[0]['attribute_set_field_id']);
        $attrDetailsN = $this->product_model->getattributedetail($optdetailc[0]['attribute_set_field_id']) ; // fetching an opt detail to check whaether belong to mandatory one
        //pr($attrDetailsN);
        if(is_array($attrDetailsN[0]) && ($attrDetailsN[0]['required'] == 1) ){
        	$this->session->set_flashdata( 'errors', 'Selected Attribute can\'t be removed, required! , please go on item details page to select again the attributes and remove old one');
        	redirect( site_url() . $this->uri->segment(1) . '/cart' );
        }
        //die;

        $data = array(
               'rowid' => $rowid,
               'qty'   => 0
            );
        $this->cart->update($data); 
        
        unset($cartitem[$rowid]['options']['optprices'][$id]) ;
        $cartitem[$rowid]['price'] = $cartitem[$rowid]['options']['unit_price'] + array_sum($cartitem[$rowid]['options']['optprices']) ;
        
        $remainingAttrlist = $cartitem[$rowid]['options']['attributelist'] ;
        $attrString = '';
        foreach ($remainingAttrlist as $key => $labelvalue) {
        	# code...
        	$attrDetails = $this->product_model->getattributedetail($key) ;
        	if(is_array($labelvalue)){
        		//pr($labelvalue) ;
        		$selectedvalue = '' ;
        		foreach ($labelvalue as $keyl => $indval) {
						if($indval != $id){
							$optdetail = $this->product_model->getattributefielddetail($indval) ;
							#pr($optdetail) ;
							$optprices[$optdetail[0]['id']] = $optdetail[0]['option_price'] ; 
							$selectedvalue = $selectedvalue.' '.$optdetail[0]['option_value'].', ' ;
						}else{
							// key to remove from detail
							// echo 'key to remove'.$key.'--'.$keyl.'Value to dis'.$indval ;
							unset($cartitem[$rowid]['options']['attributelist'][$key][$keyl]) ;
						}
					}
				$attrString = $attrString.'<span class="text-bold">'.$attrDetails[0]['field_label'].'</span>--'.$selectedvalue.', ' ;
        	}else{
        		$attrString = $attrString.'<span class="text-bold">'.$attrDetails[0]['field_label'].'</span>--'.$labelvalue.', ' ;
        	}

        }

		$id 	= $cartitem[$rowid]['id'];
		$qty 	= $cartitem[$rowid]['qty'];
		$price  = $cartitem[$rowid]['price'];
		$name   = $cartitem[$rowid]['name'];
		
		if( empty( $id ) || empty( $qty ) || !is_numeric( $qty ) || empty( $price ) || empty( $name ) )
		{
			echo "Empty cart"; die;
		}

		$productdetail = $this->product_model->findWhere('client_product', array( 'status' => 1, 'id' => $id ), false ) ;
		
		$data = array(
               'id'      => $id,
               'qty'     => $qty,
               'price'   => $price ,
               'name'    =>  htmlspecialchars($name),
               'options' => $cartitem[$rowid]['options']
               	);

		$data['options']['spcifications'] = $attrString ;
	  	if($this->cart->insert($data)){
	 		$this->session->set_flashdata( 'success', 'Item updated successfully in cart');
        }else{
			$this->session->set_flashdata( 'errors', 'Item updation failed failed try later');
        }

		redirect( site_url() . $this->uri->segment(1) . '/cart' );
		die;
	}

	function consultant_removeopt($id,$rowid){
        //$this->cart->update($data); 
        $opt = $this->cart->product_options($rowid);
        $cartitem = $this->cart->contents();
        //pr($cartitem) ;
        $optdetailc = $this->product_model->getattributefielddetail($id) ; // fetching an opt detail to check whaether belong to mandatory one
        //pr($optdetailc[0]['attribute_set_field_id']);
        $attrDetailsN = $this->product_model->getattributedetail($optdetailc[0]['attribute_set_field_id']) ; // fetching an opt detail to check whaether belong to mandatory one
        //pr($attrDetailsN);
        if(is_array($attrDetailsN[0]) && ($attrDetailsN[0]['required'] == 1) ){
        	$this->session->set_flashdata( 'errors', 'Selected Attribute can\'t be removed, required! , please go on item details page to select again the attributes and remove old one');
        	redirect( site_url() . $this->uri->segment(1) .'/'.$this->uri->segment(2).'/cart' );
        }
        //die;

        $data = array(
               'rowid' => $rowid,
               'qty'   => 0
            );
        $this->cart->update($data); 
        
        unset($cartitem[$rowid]['options']['optprices'][$id]) ;
        $cartitem[$rowid]['price'] = $cartitem[$rowid]['options']['unit_price'] + array_sum($cartitem[$rowid]['options']['optprices']) ;
        
        $remainingAttrlist = $cartitem[$rowid]['options']['attributelist'] ;
        $attrString = '';
        foreach ($remainingAttrlist as $key => $labelvalue) {
        	# code...
        	$attrDetails = $this->product_model->getattributedetail($key) ;
        	if(is_array($labelvalue)){
        		//pr($labelvalue) ;
        		$selectedvalue = '' ;
        		foreach ($labelvalue as $keyl => $indval) {
						if($indval != $id){
							$optdetail = $this->product_model->getattributefielddetail($indval) ;
							#pr($optdetail) ;
							$optprices[$optdetail[0]['id']] = $optdetail[0]['option_price'] ; 
							$selectedvalue = $selectedvalue.' '.$optdetail[0]['option_value'].', ' ;
						}else{
							// key to remove from detail
							// echo 'key to remove'.$key.'--'.$keyl.'Value to dis'.$indval ;
							unset($cartitem[$rowid]['options']['attributelist'][$key][$keyl]) ;
						}
					}
				$attrString = $attrString.'<span class="text-bold">'.$attrDetails[0]['field_label'].'</span>--'.$selectedvalue.', ' ;
        	}else{
        		$attrString = $attrString.'<span class="text-bold">'.$attrDetails[0]['field_label'].'</span>--'.$labelvalue.', ' ;
        	}

        }

		$id 	= $cartitem[$rowid]['id'];
		$qty 	= $cartitem[$rowid]['qty'];
		$price  = $cartitem[$rowid]['price'];
		$name   = $cartitem[$rowid]['name'];
		
		if( empty( $id ) || empty( $qty ) || !is_numeric( $qty ) || empty( $price ) || empty( $name ) )
		{
			echo "Empty cart"; die;
		}

		$productdetail = $this->product_model->findWhere('client_product', array( 'status' => 1, 'id' => $id ), false ) ;
		
		$data = array(
               'id'      => $id,
               'qty'     => $qty,
               'price'   => $price ,
               'name'    =>  htmlspecialchars($name),
               'options' => $cartitem[$rowid]['options']
               	);

		$data['options']['spcifications'] = $attrString ;
	  	if($this->cart->insert($data)){
	 		$this->session->set_flashdata( 'success', 'Item updated successfully in cart');
        }else{
			$this->session->set_flashdata( 'errors', 'Item updation failed failed try later');
        }

		redirect( site_url() . $this->uri->segment(1) .'/'.$this->uri->segment(2).'/cart' );
		die;
	}

	# for updating the attribute set list corresponding to an order
	function update_orderdetail_attributelist($order_detailid , $attributelist){
		#echo '$order_detailid'.$order_detailid ;
		#pr($attributelist) ;
		$data = array() ;
		$data['order_detail_id'] = $order_detailid  ;
		$data['created'] = date('Y-m-d H:i:s') ;
		foreach ($attributelist as $key => $value) {
			$data['attribute_set_field_id'] = $key ;
			if(!is_array($value)){
				$data['id'] = '' ;
				$data['text_value'] = $value ;
				$data['attribute_set_field_detail_id']  = 0 ; 
				$this->common_model->insert('order_detail_attribute_set_field_details_specifications', $data ) ;
			}else{
				$data['id'] = '' ;
				$data['text_value'] = '' ;
				foreach ($value as $keyval => $valueval) {
					# code...
					$data['text_value'] = '' ;
					if($valueval){
						$data['attribute_set_field_detail_id']  = $valueval ; 
					}else{
						$data['attribute_set_field_detail_id']  = 0 ; // No option selected
					}
					$this->common_model->insert('order_detail_attribute_set_field_details_specifications', $data ) ;
				}
			}
			
			# code...
			// key  -- attribute_set_field_id
			// value -- may be an array in that case it has  to conatin a value attribute_set_field_detail_id (checkox , radio, select box options etc)
			// value -- string then simple text fields values that specified

		}
	}

	# to check wheather an attribute is required or not
	function isrequired_attribute($indval){
		
    	$optdetailc = $this->product_model->getattributefielddetail($indval) ; // fetching an opt detail to check whaether belong to mandatory one
        //pr($optdetailc[0]['attribute_set_field_id']);
        $attrDetailsN = $this->product_model->getattributedetail($optdetailc[0]['attribute_set_field_id']) ; // fetching an opt detail to check whaether belong to mandatory one
        //pr($attrDetailsN);die;
        if(!empty($attrDetailsN) && isset($attrDetailsN[0]['required'])){
        	return $attrDetailsN[0]['required'] ;
        }
        return ;
    }

}
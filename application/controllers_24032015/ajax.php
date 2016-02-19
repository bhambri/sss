<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-------------------------------------------------------------
*	Class:		Ajax extends VCI_Controller defined in libraries
*	Author:		
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description: Manage user entity
-------------------------------------------------------------
*/
class Ajax extends VCI_Controller {
	

	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('common_model');
	}

	/**
	 * method name  couponSession
     * purpose		for checking of coupon on site
     * @param 		coupon - coupon code to check
     */
	function couponSession( $coupon = 'SUPER30' )
	{
        
        $storeUserSession = $this->session->userdata('storeUserSession');
        if($storeUserSession){
        	#echo 'you can proceed now';
        	$store_id  = $storeUserSession['store_id'];
        	$user_id   = $storeUserSession['id'];

        	if( isset( $coupon ) )
			{
			    // check if this coupon is for valid Store only and updates the times_used
			    $isCouponForStore = $this->common_model->checkCouponStore( $store_id, $coupon, $user_id )  ;
			    
			    if( $isCouponForStore = $this->common_model->checkCouponStore( $store_id, $coupon, $user_id ) )   
			    {
			        
			        if( $isCouponForStore != 'used' && $isCouponForStore != 'expired' && $isCouponForStore !='Invaild code')
			        {
			            $data = $this->common_model->findWhere( 'coupons', array( 'code' => $coupon ), FALSE );
			            
	                    if ( is_array( $data ) && !empty( $data ) )
	                    {	
				$this->session->set_userdata('coupon_data', array('amount'=>$data['discount_percent'],'ctype'=>$data['coupon_type_id']));
	                    	echo json_encode(array('amount'=>$data['discount_percent'],'ctype'=>$data['coupon_type_id'])); die;
	                    }else{
				$this->session->set_userdata('coupon_data', array('amount'=>0,'ctype'=>0));
	                    	echo json_encode(array('amount'=>0,'ctype'=>0)); die;
	                    }
			        }
			        else if( $isCouponForStore == 'used' )
			        {
			            echo 'used';die;
			        }
			        else if( $isCouponForStore == 'expired' )
			        {
			           echo 'expired'; die;
			        }
			        else
			        {
			            return false; die;
			        }
			    }
			    else
			    { 
			        echo 'Invalid Code'; die;
			    }
			}
			else
			{
				return FALSE;
				die;
			}

        }else{
        	echo 'not logged in';
        	die;
        }
        die;		
	}
	
	/**
	 * method name  addToWishList
     * purpose		for adding an item to wishlist
     * @param 		none
     */
	function addToWishList()
    {
        $productId      = $_POST['productId'];
        $this->__is_valid_store();
        $userDetails    =  $this->session->userdata( "storeUserSession" );
        if($userDetails['id'])
        {
        	$added  = $this->common_model->addToWishList( $userDetails['store_id'], $userDetails['id'], $productId );
        
	        if( $added == 'added')
	        {
	            echo '1';die;
	        }
	        else if( $added == 'exist' )
	        {   
	            echo '0';die;
	        }
	        else
	        {
	           echo '0';die; 
	        }
        }else
        {
        	echo '2'; die;
        }
        
    }
    
    /**
	 * method name  saveToFavourite
     * purpose		for saving an item as favourites
     * @param 		none
     */
    function saveToFavourite()
    {
        $productId      = $_POST['productId'];
        $this->__is_valid_store();
        $userDetails    =  $this->session->userdata( "storeUserSession" );
        if($userDetails['id'])
        {
	        $added   = $this->common_model->saveToFavourite( $userDetails['store_id'], $userDetails['id'], $productId );
	        
	        if( $added == 'added')
	        {
	            echo '1';die;
	        }
	        else if( $added == 'exist' )
	        {   
	            echo '0';die;
	        }
	        else
	        {
	           echo '0';die; 
	        }
    	}else
    	{
    		echo '2'; die;
    	}
    }
    
    /**
	 * method name  changeView
     * purpose		for switching view of product listing
     * @param 		none
     */
    function changeView(){
    	$storeview = $_POST['view_type'];
    	$this->session->set_userdata('store_view', $storeview);
    	echo 1;die;
    }
	
	/**
	 * method name  sortBy
     * purpose		for changing shorting option on list page
     * @param 		none
     */
	function sortBy(){
		$sort_by = $_POST['sort_by'];
    	$this->session->set_userdata('sort_by', $sort_by);
    	echo 1;die;
	}

	/**
	 * method name  perPage
     * purpose		for changing per option on list page
     * @param 		none
     */
	function perPage(){
		$per_page = $_POST['per_page'];
    	$this->session->set_userdata('per_page', $per_page);
    	echo 1;die;
	}

	/**
	 * method name  addtocart
     * purpose		for add to cart page
     * @param 		none
     */
	function addtocart($productid){
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
		$storeid = $store[0]['id'] ;

		$this->load->model('product_model') ;
		if(!empty($_POST)){

			$productId = $_POST['productId'] ;
			$productdetail = $this->product_model->findWhere('client_product', array( 'status' => 1, 'store_id' => $storeid, 'id' => $productId ), false ) ;
			
			$sizeArr = explode(',',$productdetail['product_size']) ;

			$size = 'NA' ;
			if($sizeArr[0]!=""){
				$size = $sizeArr[0] ;
			}

			$id  	= $productId ;
			$qty 	= 1;
			$price 	= $productdetail['product_price'] ;
			$name  	= $productdetail['product_title'] ;
			$image  = $productdetail['image'] ;
			$weight = ($productdetail['weight'] > 0) ? 500 : $productdetail['weight'] ;
			$storeId = $productdetail['store_id'] ;

			if( empty( $id ) || empty( $qty ) || !is_numeric( $qty ) || empty( $price ) || empty( $name ) )
			{
				echo "Empty cart"; die;
			}

			$data = array(
	               'id'      => $id,
	               'qty'     => $qty,
	               'price'   => $price,
	               'name'    => $name,
	               'options' => array(
	               		'image' => $image ,
	               		'weight' => $weight,
	               		'size'  => $size ,
	               		'storeid' => $storeId ,
	               		)
	               	);	
		  if($this->cart->insert($data))
		  {
		  	
		  	$this->session->set_flashdata( 'success', 'Item Added successfully in cart');
		  	echo 1; die;
		  }else{
		  	$this->session->set_flashdata( 'errors', 'Failed !, Please try later, unable to add in your cart');
		  	echo 0 ; die;
		  }
		}
		$this->session->set_flashdata( 'errors', 'Failed !, Please try later, unable to add in your cart');
		echo  0 ; die;
	}

}

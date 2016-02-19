<?php

ini_set('display_errors',1) ;

/*
---------------------------------------------------------------
*	Class:		Common_model extends Model defined in Core libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description: Manage database functionality to contact model. 
---------------------------------------------------------------
*/

class Common_model extends VCI_Model{

	/**
     * method  get_state
     * Description function for for getting all state list
    */
	function get_state()
	{
		$this->db->from( 'states' );
		$this->db->order_by( "state", "asc" );

		$state = $this->db->get();
		if( count( $state->result() ) > 0 )
		{
			 return  $data = $state->result_array();
            # print_r($data);
//             return $countries;
		}
		else
		{
			return false;
		}
	}

	/*
	 * method  get_banner
	 * Responsible for displaying banners at home page of store admin
	 * $store_id (int) , $role_id (int)
	*/
	function get_banner($store_id = '',$role_id =''){
		$this->db->from('banners');
		$this->db->order_by("id", "desc");
		$this->db->where(array('user_id' => 0));
		$this->db->where(array('status' => 1));
		//
		if($store_id)
		{
			$this->db->where(array('store_id' => $store_id));
		}
		/*
		if($role_id){
			$this->db->where(array('role_id' => $role_id));
		}
		*/
		//$this->db->limit(3);
		$content = $this->db->get();
		
		if(count($content->result()) > 0)
		{
			return $content->result_array();
		} else
		{
			return false;
		}
	}

	/*
	* method get_clientbanner
	* Responsible for displaying banners at consulatnt section pages
	* $store_id (int) , $user_id (int)
	*/
	function get_clientbanner($store_id = '',$user_id =''){
		$this->db->from('banners');
		$this->db->order_by("id", "desc");
		#$this->db->where(array('user_id' => 0));
		$this->db->where(array('status' => 1));
		//
		if($store_id)
		{
			$this->db->where(array('store_id' => $store_id));
		}
		if($user_id){
			$this->db->where(array('user_id' => $user_id));
		}
		/*
		if($role_id){
			$this->db->where(array('role_id' => $role_id));
		}
		*/
		//$this->db->limit(3);
		$content = $this->db->get();
		if(count($content->result()) > 0)
		{
			return $content->result_array();
		} else
		{
			return false;
		}
	}

	/*
	* method get_clientbanner
	* function for getting client id and status of a page
	* $username (string) $id (int)
	*/
	function get_clientdetail($username='',$sid=''){
		if($username)
		{
			$result = $this->db->get_where('clients',array('username'=>$username,'status'=>1));
		}else{
			if($sid)
			{
				$result = $this->db->get_where('clients',array('id'=>$sid,'status'=>1));	
			}else{
				return array();	
			}
			
		}
		
		if(count($result->result_array()) > 0)
		{
			return $result->result_array() ;
		}else
		{
			return array();
		}
	}


	function get_clientdetailurl($username='',$sid=''){

		if($username)
		{
			$this->db->from('clients');
			$this->db->select('clients.*');
			$this->db->like(array('store_url'=>$username));
			$this->db->where(array('status'=>1));
			$result = $this->db->get();

			//$result = $this->db->get_where('clients',array('store_url LIKE %'.$username.'%','status'=>1));
			
		}else{
			if($sid)
			{
				$result = $this->db->get_where('clients',array('id'=>$sid,'status'=>1));	
			}else{
				return array();	
			}
			
		}
		
		if(count($result->result_array()) > 0)
		{
			return $result->result_array() ;
		}else
		{
			return array();
		}
	}

	/**
	*********************************************************************
	*	Function Name :	get_news_page() .
	*	Functionality : Gets a content page based on ID
	*	@param 		  : id integer
	*********************************************************************
	**/
	function get_news_page($id = null)
	{
		if(is_null($id)) 
		{
			return false;			
		}else 
		{
			$result = $this->db->get_where('news',array('id'=>$id));
		}
		
		if ( count($result->row()) > 0 )
		{
			return $result->row();
		}
		else{
			return false;
		}
	}
	
	/**
	*********************************************************************
	*	Function Name :	get_news()
	*	Functionality : gets news list
	*	@param 		  : page integer
	*	@param 		  : per_page integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function get_news() {
		
		$this->db->from('news');
		$this->db->order_by("id", "desc");
		$this->db->where(array('store_id' => '0'));
		$this->db->where(array('status' => '1'));
		$this->db->limit(3);
		$content = $this->db->get();
		if(count($content->result()) > 0)
		{
			return $content->result_array();
		} else
		{
			return false;
		}
	}



		/**
	*********************************************************************
	*	Function Name :	get_news()
	*	Functionality : gets news list
	*	@param 		  : page integer
	*	@param 		  : per_page integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function view_news( $id ) {		
		$this->db->from('news');
		$this->db->order_by("id", "desc");
		$this->db->where(array('id' => $id));
	
		$content = $this->db->get();
		if(count($content->result()) > 0)
		{	
			return $content->row_array();
		} else
		{
			return false;
		}
	}

	/*
	* method get_state_code
	* function for getting state code
	* $$store_id (int) , $id (int)
	*/
	function get_state_code($id = null, $store_id = null)
	{
		if( is_null($id) || is_null($store_id ) ) {
			return false;			
		} else {
			$result = $this->db->get_where('shipping',array('user_id'=>$id, 'store_id' => $store_id ) );// echo $this->db->last_query();die;
		}
		
		if ( count($result->row()) > 0 )
		{
			return $result->row();
		}
		else{
			return false;
		}
	}

	/*
	* method checkCouponStore
	* function for getting state code
	* $store_id (int) , $coupon (string) $user_id (int)
	*/

	function checkCouponStore( $store_id=null, $coupon=null, $user_id=null )
    {
    	
        if( isset( $store_id ) && isset( $coupon ) )
        {
            $result = $this->db->get_where('coupons',array('store_id' => $store_id, 'code' => $coupon, 'status' => 1 ) );
            
            if( count( $result->row() ) > 0 )
            {
                $result_array   = $result->row();
                $couponId       = $result_array->id;
               
                //if( (strtotime( $result_array->expire_date ) >= strtotime( "now" )) && (strtotime( $result_array->start_date ) <= strtotime( "now" )) )
		if( (strtotime( $result_array->expire_date ) >= strtotime(date('Y-m-d'))) && (strtotime( $result_array->start_date ) <= strtotime(date('Y-m-d'))) )
                {
                	// print_r($result_array) ;
                	if($result_array->coupon_type_id == 1)
                	{
                		// Gift type
                		$rcount = $this->check_coupon_used($user_id, $store_id, $couponId) ;
                		if(!$rcount){
                			// Not used case
                			$this->insertCouponTracking( $user_id, $store_id, $result_array->id );
                			return $result->row();
                		}else{
                			// used case
                			echo 'used' ;die;
                		}		
                	}
                	if($result_array->coupon_type_id == 2)
                	{
                		// Discount coupons
                		$rcount = $this->check_coupon_used($user_id, $store_id, $couponId) ;
                		if(!$rcount){
                			// Not used case
                			$this->insertCouponTracking( $user_id, $store_id, $result_array->id );
                			return $result->row();
                		}else{
                			// used case
                			echo 'used' ;die;
                		}
                	}
                	if($result_array->coupon_type_id == 3)
                	{
                		// Discount coupons with unlimited use , No need to track the usage
                		return $result->row();
                	}
                }else{
                	 echo 'Invaild code';die;
                }
            }
            else
            {
                return  false;die;
            }
        }
    }

    function checkCouponStoreN( $store_id=null, $coupon=null, $user_id=null )
    {
    	
        if( isset( $store_id ) && isset( $coupon ) )
        {
            $result = $this->db->get_where('coupons',array('store_id' => $store_id, 'code' => $coupon, 'status' => 1 ) );
            
            if( count( $result->row() ) > 0 )
            {
                $result_array   = $result->row();
                $couponId       = $result_array->id;
               
                if( (strtotime( $result_array->expire_date ) >= strtotime( date('Y-m-d'))) && (strtotime( $result_array->start_date ) <= strtotime(date('Y-m-d'))) )
                {
                	// print_r($result_array) ;
                	if($result_array->coupon_type_id == 1)
                	{
                		// Gift type
                		$rcount = $this->check_coupon_used($user_id, $store_id, $couponId) ;
                		if(!$rcount){
                			// Not used case
                			$this->insertCouponTracking( $user_id, $store_id, $result_array->id );
                			return $result->row();
                		}else{
                			// used case
                			return false ;die;
                		}		
                	}
                	if($result_array->coupon_type_id == 2)
                	{
                		// Discount coupons
                		$rcount = $this->check_coupon_used($user_id, $store_id, $couponId) ;
                		if(!$rcount){
                			// Not used case
                			$this->insertCouponTracking( $user_id, $store_id, $result_array->id );
                			return $result->row();
                		}else{
                			// used case
                			return false ;die;
                		}
                	}
                	if($result_array->coupon_type_id == 3)
                	{
                		// Discount coupons with unlimited use , No need to track the usage
                		return $result->row();
                	}
                }else{
                	 return false ;die;
                }
            }
            else
            {
                return  false;die;
            }
        }
    }

    /*
	* method insertCouponTracking
	* function for tracking code being used in purchhase
	*  $user_id (int), $store_id (int) , $couponId (string) 
	*/
    function insertCouponTracking( $user_id, $store_id, $couponId )
    {
        $data = array(
                    'user_id'       => $user_id,
                    'store_id'      => $store_id,
                    'coupon_id'     => $couponId,
                    'created'       => date("Y-m-d h:i:s"),
                );
        $this->db->insert('coupontracking', $data);   
    }

    /*
	* method check_coupon_used
	* function for checking  coupon code being used in purchhase
	*  $user_id (int), $store_id (int) , $couponId (string) 
	*/

    function check_coupon_used($user_id, $store_id, $couponId){
    	$this->db->from('coupontracking');
        $this->db->where( 'user_id', $user_id );
        $this->db->where( 'store_id', $store_id );
        $this->db->where( 'coupon_id', $couponId );
        $this->db->where( 'status_used', 1 );
        
        $result = $this->db->get() ;
        return $result->num_rows ;

        //$result = $this->db->get_where('coupons',array('store_id' => $store_id, 'code' => $coupon, 'status' => 1 ) );
        die;
    }
    
    /*
	* method isCouponNotExpired
	* function for checking  coupon code being used in purchhase expired or not
	*  $expire_date (date type)
	*/
    function isCouponNotExpired( $expire_date ) // to check coupon expired or not
    {
        if( $expire_date > strtotime( "now" ) )
        {
            return true;die;
        }
        else
        {
            return false;die;
        }
    }
    
    /*
	* method updateCouponUsedTimes
	* function for updating  coupon code used times
	* $couponId (int ), $allowed_times (int), $times_used (int)
	*/
    function updateCouponUsedTimes( $couponId, $allowed_times, $times_used ) // update the coupon count in DB
    {
        if( $allowed_times > $times_used )
        {
            $times_used = $times_used+1;
            $this->db->where("id",$couponId);
           	$this->db->update('coupons', array('times_used'=>$times_used));
            return true;die;
        }
        else
        {
            return false;die;
        }
    }

	/*
	* method getCouponType
	* function for getting type of coupon
	* couponTypeId (int)
	*/

    function getCouponType( $couponTypeId = null )
    {
        $this->db->from('coupontypes');
        $this->db->where( 'id', $couponTypeId );
        $row = $this->db->get();
        if( count( $row->row() ) > 0 )
        {
            return $row->row();
        }
        else
        {
            return false;
        }
    }

    /*
	* method get_top_store
	* function for getting top store at markeplace home page
	* couponTypeId (int)
	*/
	function get_top_store() {
		
		$this->db->from('storelinks');
		$this->db->order_by("id", "desc");
		$this->db->where(array('status' => '1'));
		$this->db->limit(3);
		$content = $this->db->get();
		if(count($content->result()) > 0)
		{
			return $content->result_array();
		} else
		{
			return false;
		}
	}
	
	/*
	* method addToWishList
	* function for adding an item to wishlist
	* $store_id (int), $user_id (int), $product_id (int)
	*/
	function addToWishList( $store_id, $user_id, $product_id )
	{
	    $this->db->from('wishlist');
	    $this->db->where( 'store_id', $store_id );
	    $this->db->where( 'user_id', $user_id );
	    $this->db->where( 'product_id', $product_id );
	    
	    $result = $this->db->get();
	    if( count( $result->result() ) > 0 )
	    {
	        return 'exist';exit;
	    }
	    else
	    {
	        $data = array(
	            'store_id'      => $store_id,
	            'user_id'       => $user_id,
	            'product_id'    => $product_id, 
	            'status'        => 1,
	            'created'       => date("Y-m-d h:i:s"), 
	        );

	        $this->db->insert('wishlist', $data);   
	        return 'added'; exit; 
	    }
	}
	
	/*
	* method saveToFavourite
	* function for saving an item to favourite list
	* $store_id (int), $user_id (int), $product_id (int)
	*/
	function saveToFavourite( $store_id, $user_id, $product_id )
	{
	    $this->db->from('favourites');
	    $this->db->where( 'store_id', $store_id );
	    $this->db->where( 'user_id', $user_id );
	    $this->db->where( 'product_id', $product_id );
	    
	    $result = $this->db->get();
	    if( count( $result->result() ) > 0 )
	    {
	        return 'exist';exit;
	    }
	    else
	    {
	        $data = array(
	            'store_id'      => $store_id,
	            'user_id'       => $user_id,
	            'product_id'    => $product_id, 
	            'status'        => 1,
	            'created'       => date("Y-m-d h:i:s"), 
	        );
	    
	        $this->db->insert('favourites', $data);   
	        return 'added'; exit; 
	    }
	}
	
	/*
	* method getstoresetting
	* function for getting a store setting related data
	* $store_id (int)
	*/
	function getstoresetting($store_id= ''){
		//echo $store_id ;
		if($store_id)
		{
			$this->db->from('settings');
	    	$this->db->where( 'user_id', $store_id );
	    	$this->db->where( 'role_id', 2);
	    	$result = $this->db->get();
	    	return $result->result() ;
		}else{
			return array() ;
		}
	}

	/*
	* method getpopularsubcatlist
	* function for getting a stores popular subcategory list
	* $store_id (int)
	*/

	function getpopularsubcatlist($store_id= ''){
		//echo $store_id ;
		if($store_id)
		{
			$this->db->select('subcategory.* , category.id as cat_id, category.store_id as store_id');
			$this->db->from('subcategory');
	    	//$this->db->where('store_id', $store_id );
	    	$this->db->join('category', 'subcategory.category_id = category.id') ;
	    	$this->db->where( 'subcategory.is_popular', 1);
	    	$this->db->where( 'category.store_id',$store_id);

	    	$result = $this->db->get();
	    	#echo $this->db->last_query() ;

	    	return $result->result() ;
		}else{
			return array() ;
		}
	}

	/*
	* method order_detail
	* function for getting a order detail of an order
	* $orderid (int)
	*/
	function order_detail($orderid=''){
		
		#ini_set('display_errors',1) ;
		if($orderid)
		{
			$this->db->from('order_detail') ;
			$this->db->select(array('order_detail.*', 'order_detail.size as szp' ,'client_product.*')) ;
			$this->db->join('client_product', 'client_product.id = order_detail.client_product_id','left');
			$this->db->where('order_id',$orderid) ;
			$orderdetail = $this->db->get() ;
			
			return $orderdetail->result() ;
		}
		return array() ;
	}

	/*
	* method order_view
	* function for getting a order detail of an order 
	* $orderid (int)
	*/
	function order_view( $orderid='')
	{
		$qry = "SELECT ODR.*, USR.name as buyer, CLT.username as store_name FROM `order` as ODR 
			LEFT join users as USR on ODR.user_id = USR.id 
			LEFT join clients as CLT on ODR.store_id = CLT.id 
			WHERE ODR.id = '$orderid'";
		$query = $this->db->query( $qry );

		if( $query->num_rows > 0 )
		{
			$query = $this->db->query( $qry );
			return $query->row();
		}
		else 
		{
			return false;
		}
	}

	/*
	* method get_front_blocks
	* function for getting front blocks of an store
	* $orderid (int)
	*/
	function get_front_blocks($store_id)
	{
		$this->db->from('front_blocks');
		$this->db->order_by("priority", "DESC");
		$this->db->where(array('store_id' => $store_id));
		$this->db->limit(3);
		$content = $this->db->get();
		if(count($content->result()) > 0)
		{
			return $content->result_array();
		} else
		{
			return false;
		}
	}

	/*
	* method calculate_taxes
	* function for calculating taxes on totla items
	* $store_id (int), $cart_total (int)
	*/
	function calculate_taxes_17022015($store_id,$cart_total){
		if($store_id && $cart_total){
			$store_settings = $this->getstoresetting($store_id);
			if($store_settings[0])
			{
				if($store_settings[0]->tax){
					return (float)($cart_total*$store_settings[0]->tax/100) ;
				}else{
					return 0 ;
				}
			}else{
				return 0 ;
			}
		}else{
			return 0 ;
		}
	}

	function calculate_taxes($store_id, $cart_total ,$state_code){
		if($store_id && $cart_total && $state_code){
			
			$this->db->from('tax_costs') ;
			$this->db->where('store_id',$store_id);
			$this->db->where('state_code',$state_code) ;
			$result = $this->db->get();
			$taxcost = $result->result() ;
			$totaltax = $cart_total*$taxcost[0]->tax/100 ;
			
			return round($totaltax,2) ; 
		}else{
			return 0 ;
		}
	}

	/*
	* function name - calculate_shipping
	* function for Calculating  Shipping cost for a store
	* $store_id (int) ,$state_code (string)
	*/

	function calculate_shipping($store_id ,$state_code){
		
		if($store_id && $state_code)
		{
			$totalWeight = 0 ;
			foreach($this->cart->contents() as $content){
				#echo '<pre>';
				#print_r($content) ;
				$w = $content['options']['weight'] ? $content['options']['weight'] : 500 ;
				$totalWeight += $content['qty']*$w ;
			}
			//echo 'Weight total '.$totalWeight ;
			//die;
			$this->db->from('shipping_costs') ;
			$this->db->where('store_id',$store_id);
			$this->db->where('state_code',$state_code) ;

			$result = $this->db->get();
	    	#echo $this->db->last_query() ;
	    	if($result->result())
	    	{
	    		$cost = $result->result() ;
	    		if(($totalWeight <= 500 ) && ($totalWeight >= 0 )){
	    			return round($cost[0]->w1,2) ;
	    		}
	    		if(($totalWeight <= 1000 ) && ($totalWeight >= 501 )){
	    			return round($cost[0]->w2,2) ;
	    		}
	    		if(($totalWeight <= 1500 ) && ($totalWeight >= 1001 )){
	    			return round($cost[0]->w3,2) ;
	    		}
	    		if(($totalWeight <= 2000 ) && ($totalWeight >= 1501 )){
	    			return round($cost[0]->w4,2) ;
	    		}
	    		if(($totalWeight > 2000 )){
	    			return round($cost[0]->w5,2) ;
	    		}

	    	}else{
	    		return 0 ;
	    	}
		}else{
			return 0 ;   // default value of shipping cost
		}
	}

	/*
	* function name - check_group_code
	* function for identifying group code
	* $consultant_user_id (int ),$g_code (string)
	*/
	function check_group_code($consultant_user_id,$g_code){
		if($consultant_user_id && $g_code)
		{
			//return $consultant_user_id.'ABBA'.$g_code ;
			$this->db->from('grouppurchase') ;
			$this->db->where('consultant_id',$consultant_user_id) ;
			$this->db->where('group_event_code',$g_code) ;
			$this->db->where('status',1) ;

			$result = $this->db->get() ;
			$this->db->last_query() ;
			if($result->result())
			{
				$groupcode = $result->result() ;
				$dateArr = explode('/',$groupcode[0]->end_date) ;  //as current saving pattern m/d/y
				
				if(strtotime(date('Y-m-d')) <= strtotime($dateArr[2].'-'.$dateArr[0].'-'.$dateArr[1])){
					return 1;
				}else{
					return 0;
				}
			}
		}else{
			return 0;
		}
	}
	
	/**
	 * function name - check_group_code
	 * get social links of marketplace
	 * $role_id (int ), $admin_user_id (int)
	 */
	function get_marketplace_social_links( $role_id, $admin_user_id )
	{
		$result = $this->db->get_where( 'settings' ,array('role_id' => $role_id, 'user_id' => $admin_user_id ));
		if ( count($result->row()) > 0 )
		{
			return $result->row();
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * function name - get_email_template_data
	 * get email template data
	 * $id (int)
	 */
	function get_email_template_data($id)
	{
		$result = $this->db->get_where('email_templates',array('id'=>$id));
		if ( count($result->row()) > 0 )
		{
			return $result->row();
		}
		else{
			return false;
		}
	}
	
/* Added by T */
	function getbtreechild($cid){
		$result = $this->db->get_where('consultantstree',array('parent_conid'=>$cid));
		if ( count($result->row()) > 0 )
		{
			return $result->result_array();
		}
		else{
			return array() ;
		}
	}

	function addtobtree( $consultantid,$parentconsulatantid , $storeid ,$pos)
    {
        $data = array(
                    'parent_conid'  => $parentconsulatantid,
                    'store_id'      => $storeid,
                    'consultant_id' => $consultantid,
                    'pos' => $pos ,
                    'created'       => date("Y-m-d h:i:s"),
                );
        $this->db->insert('consultantstree', $data);   
    }


    function getallvoulumesum($cid , $storeid){
    	// echo 'btree section now' ;
    	$allassoArr = $this->getallbtreechilds($cid,array()) ;
    	// all logic of voulme sum needs to implemented
    	// return count($allassoArr) ;
	return $this->ptreelastweek($allassoArr,$storeid) ;
    	/*
    	//$this->db->select('*') ;
    	$result = $this->db->get_where('consultantstree',array('parent_conid'=>$cid));
    	if ( count($result->row()) > 0 )
		{
			//return $result->result_array();
		}
		else{
			// return array() ;
		}

    	return 100 ;
    	*/
    }

    function getallbtreechilds($nid , $prearr = array()){
    	//echo $nid ;
    	$result = $this->db->get_where('consultantstree',array('parent_conid'=>$nid));
    	// $prearr[] = $nid ;
    	$prearr = array_merge(array($nid),$prearr);
    	if ( count($result->row()) > 0 )
		{
			foreach ($result->result_array() as $key => $value) {
				//$prearr[] = $this->isparent($value['consultant_id'], $prearr) ;
				//$this->isparent($value['consultant_id'], $prearr) ;
				// $prearr['aaaaa'.$value['consultant_id']] = $this->isparent($value['consultant_id'], $prearr) ;
				$prear1 = $this->getallbtreechilds($value['consultant_id'], $prearr) ;
				// return array_merge($prearr, );
				$prearr = array_merge($prear1,$prearr);
			}
		}
		//echo '<pre>' ;
		//print_r($prearr);
		return array_unique($prearr) ;
    }
	// last week volume sum
	function ptreelastweek($charr,$storeid){
		
		$previous_week = strtotime("-1 week +1 day");

		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);

		$start_week = date("Y-m-d",$start_week);
		$end_week = date("Y-m-d",$end_week);

		$this->db->from('order') ;
		$this->db->select('SUM(order_volume) as pcv') ;
		
		//$this->db->where('user_id !=', $cid) ;
		$this->db->where_in('consultant_user_id', $charr) ;
		$this->db->where('store_id',$storeid ) ;
		//is_commision_calc
		//$this->db->where('is_overrides_calc',0) ;
		$this->db->where('DATE(created_time) <=' ,$end_week); 
		$this->db->where('DATE(created_time) >=' ,$start_week); 

		$this->db->where('order_status' , 1); // We are only distributing the commision for the order that is paid
		$resultSet = $this->db->get();
		/*
		if($resultSet->result())
		{
			$rs = $resultSet->result() ;
			return $rs[0]->pcv ;
		}else{
			return 0 ;
		} */
		if(count($resultSet->result()))
		{
			$rs = $resultSet->result() ;
			//echo '<pre>';
			//print_r($rs) ;
			if($rs[0]->pcv){
				return $rs[0]->pcv ;
			}
			return 0 ;
			
		}
		return 0 ;
	}

}

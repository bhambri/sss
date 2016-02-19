<?php
/*
---------------------------------------------------------------
*	Class:		Order_model extends Model defined in Core libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:	Manage database functionality to contact model. 
---------------------------------------------------------------
*/

class Order_model extends VCI_Model{

	public $chainArr = array();

	/*
	 * method  get_overrides_orders
	 * 	for getting all overrides order
	 *  param  - none
	*/

	function get_overrides_orders(){
		$this->db->from('order') ;
		$this->db->where('consultant_user_id !=', 0) ;
		//is_commision_calc
		$this->db->where('is_overrides_calc',0) ;
		$this->db->where('order_status' , 1); // We are only distributing the commision for the order that is paid
		$resultSet = $this->db->get();
		
		if($resultSet->result())
		{
			return $resultSet->result() ;
		}else{
			return array() ;
		}
	}

	/*
 	* method  get_overrides_orders
	* for getting the list of orders on which commision have to be paid
	*  param  - none
	*/

	function get_commision_orders(){
		$this->db->from('order') ;
		$this->db->where('consultant_user_id !=', 0) ;
		//is_commision_calc
		$this->db->where('is_commision_calc',0) ;
		$this->db->where('order_status' , 1); // We are only distributing the commision for the order that is paid
		$resultSet = $this->db->get();
		
		if($resultSet->result())
		{
			return $resultSet->result() ;
		}else{
			return array() ;
		}
	}

	/*
	* method getimmediate_chainlink
	* description function for getting immmediate parent in chain of consultant
	* $consultant_id  (int), $store_id (int), $chain_level (int ), &$chainArr (array)
	*/

	function getimmediate_chainlink($consultant_id = '', $store_id='', $chain_level = 0, &$chainArr){
		
		if($consultant_id && ($chain_level < 6) )
		{ // pick entres upto 6 genration only including consultant
			$this->db->from('users');
			$this->db->select(array('users.id' , 'users.store_id','users.parent_consultant_id','users.username','users.status','users.role_id')) ;
			$this->db->where('id', $consultant_id) ;
			$this->db->where('status', 1) ;
			if($store_id)
			{
				$this->db->where('store_id', $store_id) ;	
			}
			
			$resultSet = $this->db->get();
			//echo $this->db->last_query() ;

			if($resultSet->result())
			{
				//return $resultSet->result() ;
				
				#print_r($resultSet->result()) ;
				$chain_level_pre = $chain_level ;
				$chain_level = $chain_level + 1;
				#echo ' chain label ends now' ;

				$resultData =  $resultSet->result() ;
				$parentConsultantid  = $resultData[0]->parent_consultant_id ;

				$chainArr[] = array('chain_level'=> $chain_level_pre , 'consultantdata'=> (array)$resultData[0]) ; // putting zeroth level entry consulatnt itself first time
				
				$this->getimmediate_chainlink($parentConsultantid,$store_id ,$chain_level,$chainArr) ;

			}else{
				//return array() ;
				$this->chainArr = $chainArr ;
				//return $chainArr ;
			}

		}else{
			$this->chainArr = $chainArr ;
			//return $chainArr ;
		}
	}


	
	/*
	* method get_executivelevel
	* description function for getting executive level
	* $consultant_id (int) ,$store_id  (int)
	*/

	function get_executivelevel($consultant_id = '' ,$store_id = ''){
		if($consultant_id)
		{
			$this->db->from('consultant_executive_levels') ;
			
			//  [direct_commision] => 10.00
            // [generation_access] => 1
			$this->db->select(array('executive_levels.direct_commision', 'executive_levels.generation_access')) ;
			//$this->db->select() ;
			$this->db->join('executive_levels', 'executive_levels.id = consultant_executive_levels.executive_level_id','left');

			$this->db->where('consultant_user_id',$consultant_id) ;
			if($store_id)
			{
				$this->db->where('executive_levels.store_id', $store_id) ;	
			}
			$resultSet = $this->db->get();

			if($resultSet->result())
			{
				$data =  $resultSet->result() ;
				return (array)$data[0] ;
			}else{
				return array() ;
			}

		}else{
			return array() ;
		}
	}

	/*
	* method get_store_settings
	* description function for getting store settings
	* $store_id  (int)
	*/

	function get_store_settings($store_id = ''){
		if($store_id)
		{
			$this->db->from('generational_commission_setting') ;
			$this->db->where('store_id' , $store_id) ;
			$resultSet = $this->db->get();
			if($resultSet->result())
			{
				$data =  $resultSet->result() ;
				return (array)$data[0] ;
			}else{
				return array() ;
			}
		}else{
			return array() ;
		}
	}

	/*
	* method add_overrides
	* description function for adding overrides
	* $data  (array)
	*/

	function add_overrides($data){
		if($data)
		{
			$this->db->insert('overrides_order', $data);
			if($this->db->insert_id() > 0) {
				return $this->db->insert_id();
			}else{
				return false ;
			}
		}else{
			return false ;
		}
	}

	/*
	* method add_commission
	* description function for adding commision
	* $data  (array)
	*/
	function add_commission($data){
		if($data)
		{
			$this->db->insert('commision_order', $data);
			if($this->db->insert_id() > 0) {
				return $this->db->insert_id();
			}else{
				return false ;
			}
		}else{
			return false ;
		}
	}

	/*
	* method updateorder_status
	* description function for updating order status
	* $order_id ( int ) $data  (array)
	*/
	function updateorder_status($order_id ,$data){
		if($data)
		{
			$this->db->where('id',$order_id);
			$this->db->update('order',$data) ;	
			return true ;
		}else{
			return false ;
		}
	}
	
	/*
	* method get_all
	* description function for getting all  record
	* $table (string), $page (int ), $per_page(int ), $count (bool), $store_id (int) ,$consultant_id (int)
	*/

	function get_all($table, $page, $per_page = 10, $count=false, $store_id ,$consultant_id='')
	{
		$qry = "SELECT ODR.*, USR.name as buyer, CLT.username as store_name FROM `order` as ODR 
			LEFT join users as USR on ODR.user_id = USR.id 
			LEFT join clients as CLT on ODR.store_id = CLT.id 
			WHERE ODR.store_id = '$store_id'";

		if($consultant_id){
			$qry .= " AND  ODR.consultant_user_id = $consultant_id";
		}

		$qry .= " order by  ODR.id desc";

		$query = $this->db->query( $qry );
		//echo "<pre>";
		//echo 'Query'.$qry ;

		if( $count )
		{
			return $query->num_rows;
		}
		if( $query->num_rows > 0 )
		{
			$qry .= " LIMIT $page, $per_page";
			$query = $this->db->query( $qry );
			//print_r($query->result());
			return $query->result();
		}
		else 
		{
			return false;
		}
	} 
	

	/*
	* method get_all_clients
	* description return all clients for banners
	* none
	*/
	function get_all_clients()
	{
		$this->db->from('clients');
		$this->db->where('status', 1);
		$states = $this->db->get();
		return $states->result();
	}


	/*
	* method order_view
	* description for order view -- old  function
	* $table (string ), $transaction_id  (string)
	*/

	function order_view($table, $transaction_id )
	{
		$qry = "SELECT ODR.*, USR.name as buyer, CLT.username as store_name FROM `order` as ODR 
			LEFT join users as USR on ODR.user_id = USR.id 
			LEFT join clients as CLT on ODR.store_id = CLT.id 
			WHERE ODR.transaction_id = '$transaction_id'";
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
	* method order_detail
	* for order detail data
	* orderid (int )
	*/

	function order_detail($orderid=''){
		if($orderid){
			$this->db->from('order_detail') ;
			$this->db->join('client_product', 'client_product.id = order_detail.client_product_id','left');
			$this->db->where('order_id',$orderid) ;
			$orderdetail = $this->db->get() ;
			return $orderdetail->result() ;
		}
		return array() ;
	}

//$where_data = array('store_id' => $this->store_id, 'user_id' => $storeUserSession['id'] );
	/*
	* method get_billingshippingdetail
	* for getting billing shipping detail
	* $store_id (int), $user_id(int), $order_id (id) 
	*/
	function get_billingshippingdetail($store_id, $user_id, $order_id = ''){
		ini_set('display_errors',1) ;

		if($store_id && $user_id)
		{

			$address = array() ;
			$this->db->from('billing') ;
			$this->db->where('store_id' ,$store_id);
			$this->db->where('user_id' ,$user_id);
			
			if($order_id)
			{
			   $this->db->where('order_id' ,$order_id);	
			}
			
			$this->db->order_by('id DESC');
			$this->db->limit(1);
			$billingdetail = $this->db->get() ;

			$address['billingdetail'] = $billingdetail->result() ;

			$this->db->from('shipping') ;
			$this->db->where('store_id' ,$store_id);
			$this->db->where('user_id' ,$user_id);
			if($order_id)
			{
			   $this->db->where('order_id' ,$order_id);	
			}
			$this->db->order_by('id DESC');
			$this->db->limit(1);
			$shippingdetail = $this->db->get() ;
			
			$address['shippingdetail'] = $shippingdetail->result() ;

			return $address ;
		}

		return array() ;
	}
}
<?php
/*
---------------------------------------------------------------
*	Class:		Contact_model extends Model defined in Core libraries
*	Author: 	Jaidev Bangar , Abhishek Srivastav
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:	Manage database functionality to contact model. 
---------------------------------------------------------------
*/

class User_model extends CI_Model{

	/**
     * method  add_user
     * Description function for adding user
     * @param $data (array)
     */
    function add_user( $data ){
		$this->db->insert('users', $data);
		if($this->db->insert_id() > 0)
		{
			return $this->db->insert_id();
		} else
		{
			return false;
		}
    }
    

    /**
     * method  add_consultant_payment
     * Description function for adding consulatant paymment
     * @param $data (array)
     */
    function add_consultant_payment( $data ){
    
    	$this->db->insert('consultant_payment', $data);
    	if($this->db->insert_id() > 0)
    	{
    		return $this->db->insert_id();
    	} else
    	{
    		return false;
    	}
    }
    
    /**
     * method  update_consultant_status
     * Description function for updating consultant data
     * @param $id (int ), $data (array ), $table (string )
     */

    function update_consultant_status( $id, $data, $table='users' )
    {
    	$this->db->where(array('id'=>$id));
    	$this->db->where(array('role_id'=>4));
    	$this->db->update($table, $data);
    	return true;
    }
    
    /**
     * method  getShipping
     * Description function for getting shipping of store_id and user_id
     * @param $store_id, (int ), $user_id (int)
     */
    function getShipping( $store_id, $user_id ) 
    {
        $this->db->from("shipping");
        $this->db->where( "store_id" , $store_id );
        $this->db->where( "user_id" , $user_id );
        $this->db->order_by("id", "desc");
        $result = $this->db->get();
        return $result->row();
    }

    /**
     * method  getprimaryShipping
     * Description function for getting primary shipping
     * @param $store_id, (int ), $user_id (int)
     */
    function getprimaryShipping( $store_id, $user_id ) 
    {
        $this->db->from("shipping");
        $this->db->where( "store_id" , $store_id );
        $this->db->where( "user_id" , $user_id );
        $this->db->where( "is_primary" , 1 );
        $this->db->order_by("id", "desc");
        $result = $this->db->get();
        return $result->row();
    }
    
    /**
     * method  getOrders
     * Description function for getting orders
     * @param $store_id, (int ), $user_id (int)
     */
    function getOrders( $store_id, $user_id ) 
    {
        $this->db->from("order");
        $this->db->where( "store_id" , $store_id );
        $this->db->where( "user_id" , $user_id );
        $this->db->order_by("id", "desc");
        $result = $this->db->get();
        return $result->result();
    }

    /**
     * method  get_all_order_user
     * Description function for getting orders of an user
     * @param $page (int), $per_page(int), $count (bool ), $store_id (int) ,$user_id (int )
     */

    function get_all_order_user($page, $per_page = 10, $count=false, $store_id ,$user_id='')
    {
        $qry = "SELECT ODR.*, USR.name as buyer, CLT.username as store_name FROM `order` as ODR 
            LEFT join users as USR on ODR.user_id = USR.id 
            LEFT join clients as CLT on ODR.store_id = CLT.id 
            WHERE ODR.store_id = '$store_id'";

        if($user_id)
        {
            $qry .= " AND  ODR.user_id = $user_id";
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
    
     /**
     * method  getWishlist
     * Description function for getting wishlist
     * @param $store_id (int ), $user_id (int) 
     */
    function getWishlist($page, $per_page = 10, $count=false, $store_id, $user_id )
    {
        /*$qry = "SELECT w.id, p.product_title, p.description, p.image from wishlist as w LEFT JOIN client_product as p ON 
        ( p.store_id = w.store_id && p.id=w.product_id ) where p.status=1 && p.store_id='".$store_id."' order by p.id DESC ";
        */
        
        $qry = "SELECT w.* , p.product_title, p.description, p.image from wishlist as w LEFT JOIN client_product as p ON ((p.store_id = w.store_id) && (p.id = w.product_id)) where w.store_id= $store_id AND w.user_id = $user_id  order by p.id DESC";

        $result = $this->db->query( $qry );
       
        //echo '<pre>';print_r($result->result() );die;
        //return $result->result();

        if( $count )
        {
            return $result->num_rows;
        }
        if( $result->num_rows > 0 )
        {
            $qry .= " LIMIT $page, $per_page";
            $query = $this->db->query( $qry );
            
            return $query->result();
        }
        else 
        {
            return false;
        }
    }

    /**
     * method  getFavourite
     * Description function for getting favourites
     * @param $store_id (int ), $user_id (int) 
     */

    function getFavourite( $store_id, $user_id )
    { 
        $qry = "SELECT f.id,p.id as prod_id, p.product_title, p.description, p.image from favourites as f LEFT JOIN client_product as p ON 
        ( p.store_id = f.store_id && p.id=f.product_id ) where p.status=1 && p.store_id='".$store_id."' order by p.id DESC";
        $result = $this->db->query( $qry );
        //echo '<pre>';print_r( $query->result() );die;
        return $result->result();
    }
    
    /**
     * method  deleteWishList
     * Description function for deleting wishlist
     * @param $wid (int)
     */
    function deleteWishList( $wID=null )
    {
        $this->db->where('id', $wID);
        $this->db->delete('wishlist');
        return true;
    }
    
    /**
     * method  deleteFavourite
     * Description function for deleting favourites
     * @param $fID (int)
     */
    function deleteFavourite( $fID=null )
    {
        $this->db->where('id', $fID);
        $this->db->delete('favourites');
        return true;
    }
    
    
    /**
     * method  is_email_exists
     * Description checks an email already exists in databsae while registering new client
     * @param $email (string), $store_id (int), $id (int)
     */

	function is_email_exists($email, $store_id, $id = null)
	{
		if(!empty($id))
        {
			$this->db->where(array('email'=>$email, 'store_id'=>$store_id, 'role_id'=>3, 'id !=' => $id));
        }
		else
        {
			$this->db->where(array('email'=>$email, 'role_id'=>3, 'store_id'=>$store_id));
        }

		$this->db->from('users');
		$clients = $this->db->count_all_results();

		if($clients > 0)
		{
			$this->form_validation->set_message('is_email_exists', "The %s '$email' is already exists.");
			return true;
		}
		else
        {
			return false;
        }
	}
	
    /**
     * method  is_consultant_email_exists
     * Description checks an email already exists in databsae while registering new client
     * @param $email (string), $store_id (int), $id (int)
     */

	function is_consultant_email_exists($email, $store_id, $id = null)
	{
		if(!empty($id))
        {
			$this->db->where(array('email'=>$email, 'role_id'=>4, 'store_id'=>$store_id, 'id !=' => $id));
        }
		else{
			$this->db->where(array('email'=>$email, 'role_id'=>4, 'store_id'=>$store_id));
        }
	
		$this->db->from('users');
		$clients = $this->db->count_all_results();
	
		if($clients > 0)
		{
			$this->form_validation->set_message('is_consultant_email_exists', "The %s '$email' is already exists.");
			return true;
		}
		else{
			return false;
        }
	}


    /**
     * method  is_user_exists
     * Description checks an email already exists in databsae while registering new client
     * @param $name (string), $store_id (int), $id (int)
     */

	function is_user_exists($name, $store_id, $id = null)
	{
		if(!empty($id))
        {
			$this->db->where(array('username'=>$name, 'store_id'=>$store_id, 'id !=' => $id));
        }
		else{
			$this->db->where(array('username'=>$name, 'store_id'=>$store_id));
        }

		$this->db->from('users');
		$clients = $this->db->count_all_results();

		if($clients > 0)
		{
			$this->form_validation->set_message('is_user_exists', "The %s '$name' is already exists.");
			return true;
		}
		else{
			return false;
        }
	}

    /**
     * method  is_consultant_exists
     * Description user name checking
     * @param $name (string), $storeid (int)
     */

    function is_consultant_exists($name, $storeid){
        //echo $storeid ;
        if($name && $storeid)
        {
            $this->db->where(array('username'=>$name,'store_id'=>$storeid,'role_id'=>4)) ;
            $this->db->from('users');
            $result = $this->db->get();
            #print_r( $result->result());
            return $result->result();
            
        }else{
            return array() ;
        }
    }
    
    /**
     * method  getUserDetail
     * displaying user detail
     * @param $email_id (string ),  $store_id (int)
     */
    function getUserDetail( $email_id, $store_id )
    {
    	$this->db->from("users");
    	$this->db->where( "email" , $email_id );
    	$this->db->where( "role_id" , 3 );
    	$this->db->where( "store_id", $store_id );
    	$result = $this->db->get();
    	if( count($result->row()) > 0 )
    	{
    		return $result->result();
    	}
    	else
    	{
    		return false;
    	}
    }
    
    /**
     * method  reset_password
     * reseting password of an  user
     * @param $data (array), $id (int)
     */
    function reset_password($data, $id)
    {
    	$this->db->where(array('id'=>$id));
    	$this->db->update('users', $data);
    	return true;
    }
    
    /**
     * method  get_new_consultant_detail
     * for getting consultant detail
     * @param $data (array), $id (int)
     */

    function get_new_consultant_detail( $id )
    {
    	$this->db->from('users');
    	$this->db->where(array('id'=> $id));
    	$this->db->where(array('role_id'=> 4));
    	$result = $this->db->get();

    	if(count($result->result()) > 0)
    	{
    		return $result->result();
    	}
    	else
    	{
    		return false;
    	}
    }
// added by T
function get_store_user_details($id = null)
	{	
	$result = $this->db->get_where('users',array('id'=>$id));
			
	if ( count($result->row()) > 0 ){
	    return $result->row();
	}
	else{
	    return false;
	}
	}

//
}

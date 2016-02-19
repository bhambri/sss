<?php
/*
---------------------------------------------------------------
*	Class:		Address_model extends Model defined in Core libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:	Manage database functionality to contact model. 
---------------------------------------------------------------
*/

class Address_model extends CI_Model
{

	/**
     * method  add_contact
     * Description function for adding contact us data
     * on basis of id
     * @param nane
     */
    function is_username_exist( $username = null )
    {
		if( !empty( $username ) )
		{
		   
		  $this->db->where(array('username'=>$username));
		   $this->db->from('clients');
		   $clients = $this->db->count_all_results();
		   if($clients > 0)
		    {
			    return true;
		    }
		}
		else
		{
		    return false;
		}
    }
    /**
     * method  : get shipping data for that user
     * Description function to fetch shipping data 
     * on basis of user id
     * @param name
     */
    function get_shipping_data( $user_id ,$is_primary = 0 )
    {
	   $this->db->from('shipping');
       $this->db->where( array( 'user_id' => $user_id ) );
       $this->db->where(array('is_primary'=>$is_primary));
	   $shipping = $this->db->get();
	   
	   //echo '<pre>';print_r($shipping->result());die;
	   
	   if( count( $shipping->result() ) > 0)
	   {
	       //echo '<pre>';print_r( $shipping->result() );die;
	       return $shipping->result();
	   }
	   else
	   {
	        return false;
	   }
	       
    }

    function get_billing_data( $user_id ,$is_primary = 0 )
    {
	   $this->db->from('billing');
       $this->db->where( array( 'user_id' => $user_id ) );
       $this->db->where(array('is_primary'=>$is_primary));
	   $shipping = $this->db->get();
	   
	   //echo '<pre>';print_r($shipping->result());die;
	   
	   if( count( $shipping->result() ) > 0)
	   {
	       //echo '<pre>';print_r( $shipping->result() );die;
	       return $shipping->result();
	   }
	   else
	   {
	        return false;
	   }
	       
    }

    /*
    * method  : get_all_states
    * Description : get all states   
    * @param none 
    */
    function get_all_states()
    {
        $this->db->from('states');
        $states = $this->db->get();
	    return $states->result();
        
    }

    /**
     * method  : store_shipping_information
     * Description function to insert/update shipping information 
     * on basis of user id
     * @param $data array() , $user_id (int)
     */
    function store_shipping_information( $data, $user_id = null )
    {
        if( ($data['id'] !="" ) && isset( $user_id ) && !empty( $user_id ) )
        {
            $this->db->where(array('user_id'=>$user_id));
            $this->db->where(array('id'=>$data['id']));
		    $this->db->from('shipping');
            $this->db->update('shipping', $data);
		    return true; 
        }
        else
        {
            $this->db->insert('shipping', $data);
		    if($this->db->insert_id() > 0)
		    {
			    return $this->db->insert_id();
		    } else
		    {
			    return false;
		    }
		}
    }
    
    function store_billing_information( $data, $user_id = null )
    {
        if( ($data['id'] !="" ) && isset( $user_id ) && !empty( $user_id ) )
        {
            $this->db->where(array('user_id'=>$user_id));
            $this->db->where(array('id'=>$data['id']));
		    $this->db->from('billing');
            $this->db->update('billing', $data);
		    return true; 
        }
        else
        {
            $this->db->insert('billing', $data);
		    if($this->db->insert_id() > 0)
		    {
			    return $this->db->insert_id();
		    } else
		    {
			    return false;
		    }
		}
    }

    /**
     * method  : update_store_shipping_information
     * Description function to insert/update shipping information 
     * on basis of user id
     * @param $data array() , $user_id (int)
     */
    function update_store_shipping_information( $id, $data )
    {
        $this->db->insert('shipping', $data);
		if($this->db->insert_id() > 0)
		{
			return $this->db->insert_id();
		} else
		{
			return false;
		}
    }
    
    /**
     * method  : is_shipping_info_exist
     * Description function to check is shipping information exist
     * on basis of user id
     * @param $data array() , $user_id (int)
     */

    function is_shipping_info_exist( $user_id = null )
    {
        $this->db->where(array('user_id'=>$user_id));
		$this->db->from('shipping');
		$is_exist = $this->db->count_all_results();   
		if( $is_exist > 0 )
		{
		   return true; 
		}
		else
		{
		    return false;
		}
    }

     /**
     * method  : is_shipping_info_exist
     * Description  checks an email already exists in databsae while registering new client
     * @param email (string)  , id (int)
     */
	function is_email_exists($email, $id = null)
	{
		if(!empty($id))
		{
			$this->db->where(array('email'=>$email, 'id !=' => $id));
		}
		else{
			$this->db->where(array('email'=>$email));
		}

		$this->db->from('users');
		$clients = $this->db->count_all_results();

		if($clients > 0)
		{
			$this->form_validation->set_message('is_email_exists', "The %s '$email' is already exists.");
			return true;
		}
		else{
			return false;
		}
	}


	/**
     * method  : is_shipping_info_exist
     * Description   checks an email already exists in databsae while registering new client
     * @param $name (string) id (int)
     */
	function is_user_exists($name, $id = null)
	{
		if(!empty($id))
		{
			$this->db->where(array('username'=>$name, 'id !=' => $id));
		}
		else{
			$this->db->where(array('username'=>$name));
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
}
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:			Address extends VCI_Controller defined in libraries
*	Author: 		
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	Shipping related info there
---------------------------------------------------------------
*/

class Address extends VCI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->_vci_layout('store_default');
		$this->load->library('cart');
		$this->load->model('address_model');
		$this->load->model('user_model');
		$this->load->model('client_model');		
	}
	
	/**
	 * method name  shipping
     * purpose		For Editing primary shipping detail on site
     * @param 		none
     */
	function shipping()
	{
	  
		$this->__is_valid_store();
		$view_data = '';	
		
		$is_primary =  1 ; // making an address primary that will be shown at time of placing an order
		$storeUsername =  $this->uri->segment(1);
		
		$owner_details = $this->client_model->get_client_details( $storeUsername );
		$store_id = $owner_details->id;
		
		if( !$this->address_model->is_username_exist( $storeUsername ) )
		{
		    echo '<h1>Invalid Store. Please register with us to get your own store.</h1>';die;
		}
		
		$storeUserSession = $this->session->userdata('storeUserSession');
		$user_id      = $storeUserSession['id'];
		
        if($this->input->post())
        {
        	$data = $this->input->post();
           	

            if( $data['formsubmitted'] > 0 && !empty( $data['formsubmitted'] ) )
            {
                if ( $this->form_validation->run('shipping_address') )
                {
                   
                   $data_array = array( 
                   						'id'    		=> $data['id'], 
                   						'store_id'      => $store_id,
                                        'user_id'       => $user_id,
                                        'first_name'    => $data['first_name'], 
                                        'last_name'     => $data['last_name'],
                                        'address'       => $data['address'],
                                        'address_2'     => $data['address_2'],
                                        'state_code'    => $data['state_code'],
                                        'city'          => $data['city'],
                                        'postal_code'   => $data['postal_code'],
                                        'phone_number'  => $data['phone_number'],
                                        'status'        => 1,
                                        'is_primary'	=> 1,
                                        'created'       => date("Y-m-d h:i:s"), 
                                      );
                    
                    if( $this->address_model->store_shipping_information( $data_array, $user_id ) )
                    {
                       redirect( site_url() . $storeUsername . '/user/account' );
                    }
                }         
            }
        }
        
        if( $shipping_address = $this->address_model->get_shipping_data( $storeUserSession['id'] ,$is_primary) )
        {
        	$view_data['id']  		   = $shipping_address[0]->id;
            $view_data['first_name']   = $shipping_address[0]->first_name;
            $view_data['last_name']    = $shipping_address[0]->last_name;
            $view_data['address']      = $shipping_address[0]->address;
            $view_data['address_2']    = $shipping_address[0]->address_2;
            $view_data['state_code']   = $shipping_address[0]->state_code;
            $view_data['city']         = $shipping_address[0]->city;
            $view_data['postal_code']  = $shipping_address[0]->postal_code;
            $view_data['phone_number'] = $shipping_address[0]->phone_number;
        }
		$state_array = $this->address_model->get_all_states();
        $view_data['states']   = $state_array;
		$view_data['username'] = $storeUsername;
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($store_id) ;
		
		$this->_vci_view( 'store/address_shipping',$view_data );
	}

    /**
     * method name  cshipping
     * purpose      For Editing primary shipping detail on site at consultant end
     * @param       none
     */
    function cshipping()
    {
      
        $this->__is_valid_client_store() ;
        $this->_vci_layout('clientstore_default');

        $view_data = '';    
        
        $is_primary =  1 ; // making an address primary that will be shown at time of placing an order
        $storeUsername =  $this->uri->segment(1);
        
        $owner_details = $this->client_model->get_client_details( $storeUsername );
        $store_id = $owner_details->id;
        
        if( !$this->address_model->is_username_exist( $storeUsername ) )
        {
            echo '<h1>Invalid Store. Please register with us to get your own store.</h1>';die;
        }
        
        $storeUserSession = $this->session->userdata('storeUserSession');
        $user_id      = $storeUserSession['id'];
        
        if($this->input->post())
        {
            $data = $this->input->post();
            

            if( $data['formsubmitted'] > 0 && !empty( $data['formsubmitted'] ) )
            {
                if ( $this->form_validation->run('shipping_address') )
                {
                   
                   $data_array = array( 
                                        'id'            => $data['id'], 
                                        'store_id'      => $store_id,
                                        'user_id'       => $user_id,
                                        'first_name'    => $data['first_name'], 
                                        'last_name'     => $data['last_name'],
                                        'address'       => $data['address'],
                                        'address_2'     => $data['address_2'],
                                        'state_code'    => $data['state_code'],
                                        'city'          => $data['city'],
                                        'postal_code'   => $data['postal_code'],
                                        'phone_number'  => $data['phone_number'],
                                        'status'        => 1,
                                        'is_primary'    => 1,
                                        'created'       => date("Y-m-d h:i:s"), 
                                      );
                    
                    if( $this->address_model->store_shipping_information( $data_array, $user_id ) )
                    {
                       redirect( site_url() . $storeUsername .'/'.$this->uri->segment(2).'/user/account' );
                    }
                }         
            }
        }
        
        if( $shipping_address = $this->address_model->get_shipping_data( $storeUserSession['id'] ,$is_primary) )
        {
            $view_data['id']           = $shipping_address[0]->id;
            $view_data['first_name']   = $shipping_address[0]->first_name;
            $view_data['last_name']    = $shipping_address[0]->last_name;
            $view_data['address']      = $shipping_address[0]->address;
            $view_data['address_2']    = $shipping_address[0]->address_2;
            $view_data['state_code']   = $shipping_address[0]->state_code;
            $view_data['city']         = $shipping_address[0]->city;
            $view_data['postal_code']  = $shipping_address[0]->postal_code;
            $view_data['phone_number'] = $shipping_address[0]->phone_number;
        }
        $state_array = $this->address_model->get_all_states();
        $view_data['states']   = $state_array;
        $view_data['username'] = $storeUsername;
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($store_id) ;
        
        $this->_vci_view( 'store/address_shipping',$view_data );
    }
	
	
	/**
	 * method name  billing
     * purpose		For displaying billing details on site
     * @param 		none
     */
	function billing()
	{
		$this->__is_valid_store();
		$view_data = '';	
		//$this->load->model('common_model');
		//$view_data['title'] = 'Home ' ;
        $is_primary =  1 ; // making an address primary that will be shown at time of placing an order
        $storeUsername =  $this->uri->segment(1);
        
        $owner_details = $this->client_model->get_client_details( $storeUsername );
        $store_id = $owner_details->id;
        
        if( !$this->address_model->is_username_exist( $storeUsername ) )
        {
            echo '<h1>Invalid Store. Please register with us to get your own store.</h1>';die;
        }
        
        $storeUserSession = $this->session->userdata('storeUserSession');
        $user_id      = $storeUserSession['id'];
        
        if($this->input->post())
        {
            $data = $this->input->post();
            

            if( $data['formsubmitted'] > 0 && !empty( $data['formsubmitted'] ) )
            {
                if ( $this->form_validation->run('shipping_address') )
                {
                   
                   $data_array = array( 
                                        'id'            => $data['id'], 
                                        'store_id'      => $store_id,
                                        'user_id'       => $user_id,
                                        'first_name'    => $data['first_name'], 
                                        'last_name'     => $data['last_name'],
                                        'address'       => $data['address'],
                                        'address_2'     => $data['address_2'],
                                        'state_code'    => $data['state_code'],
                                        'city'          => $data['city'],
                                        'postal_code'   => $data['postal_code'],
                                        'phone_number'  => $data['phone_number'],
                                        'status'        => 1,
                                        'is_primary'    => 1,
                                        'created'       => date("Y-m-d h:i:s"), 
                                      );
                    
                    if( $this->address_model->store_billing_information( $data_array, $user_id ) )
                    {
                       redirect( site_url() . $storeUsername . '/user/account' );
                    }
                }         
            }
        }
        
        if( $shipping_address = $this->address_model->get_billing_data( $storeUserSession['id'] ,$is_primary) )
        {
            $view_data['id']           = $shipping_address[0]->id;
            $view_data['first_name']   = $shipping_address[0]->first_name;
            $view_data['last_name']    = $shipping_address[0]->last_name;
            $view_data['address']      = $shipping_address[0]->address;
            $view_data['address_2']    = $shipping_address[0]->address_2;
            $view_data['state_code']   = $shipping_address[0]->state_code;
            $view_data['city']         = $shipping_address[0]->city;
            $view_data['postal_code']  = $shipping_address[0]->postal_code;
            $view_data['phone_number'] = $shipping_address[0]->phone_number;
        }
        $state_array = $this->address_model->get_all_states();
        $view_data['states']   = $state_array;
        $view_data['username'] = $storeUsername;
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($store_id) ;

		$this->_vci_view('store/address_billing',$view_data);
	}

    function cbilling()
    {
      
        $this->__is_valid_client_store() ;
        $this->_vci_layout('clientstore_default');

        $view_data = '';    
        
        $is_primary =  1 ; // making an address primary that will be shown at time of placing an order
        $storeUsername =  $this->uri->segment(1);
        
        $owner_details = $this->client_model->get_client_details( $storeUsername );
        $store_id = $owner_details->id;
        
        if( !$this->address_model->is_username_exist( $storeUsername ) )
        {
            echo '<h1>Invalid Store. Please register with us to get your own store.</h1>';die;
        }
        
        $storeUserSession = $this->session->userdata('storeUserSession');
        $user_id      = $storeUserSession['id'];
        
        if($this->input->post())
        {
            $data = $this->input->post();
            

            if( $data['formsubmitted'] > 0 && !empty( $data['formsubmitted'] ) )
            {
                if ( $this->form_validation->run('shipping_address') )
                {
                   
                   $data_array = array( 
                                        'id'            => $data['id'], 
                                        'store_id'      => $store_id,
                                        'user_id'       => $user_id,
                                        'first_name'    => $data['first_name'], 
                                        'last_name'     => $data['last_name'],
                                        'address'       => $data['address'],
                                        'address_2'     => $data['address_2'],
                                        'state_code'    => $data['state_code'],
                                        'city'          => $data['city'],
                                        'postal_code'   => $data['postal_code'],
                                        'phone_number'  => $data['phone_number'],
                                        'status'        => 1,
                                        'is_primary'    => 1,
                                        'created'       => date("Y-m-d h:i:s"), 
                                      );
                    
                    if( $this->address_model->store_billing_information( $data_array, $user_id ) )
                    {
                       redirect( site_url() . $storeUsername .'/'.$this->uri->segment(2).'/user/account' );
                    }
                }         
            }
        }
        
        if( $shipping_address = $this->address_model->get_billing_data( $storeUserSession['id'] ,$is_primary) )
        {
            $view_data['id']           = $shipping_address[0]->id;
            $view_data['first_name']   = $shipping_address[0]->first_name;
            $view_data['last_name']    = $shipping_address[0]->last_name;
            $view_data['address']      = $shipping_address[0]->address;
            $view_data['address_2']    = $shipping_address[0]->address_2;
            $view_data['state_code']   = $shipping_address[0]->state_code;
            $view_data['city']         = $shipping_address[0]->city;
            $view_data['postal_code']  = $shipping_address[0]->postal_code;
            $view_data['phone_number'] = $shipping_address[0]->phone_number;
        }
        $state_array = $this->address_model->get_all_states();
        $view_data['states']   = $state_array;
        $view_data['username'] = $storeUsername;
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($store_id) ;
        
        $this->_vci_view( 'store/address_billing',$view_data );
    }

}
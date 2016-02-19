<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:		settings extends VCI_Controller defined in libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:Manage settings page by admin 
---------------------------------------------------------------
*/

class Settings extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('settings_model');
		$this->load->helper('resize');
	}
	
	/*
	-----------------------------------------------------------------
	* 	Method 		: add_settings
	*	@param  	: 
	* Description 	: to add settings
	*/
	function add_settings()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		$view_data = array();
		
		$allowed_types = array('gif','png','jpg','jpeg','jpe','image/jpeg','image/gif','image/png','image/jpg','image/jpeg','image/jpe');
        
        $store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }
				
		if( !isset($store_id) && empty( $store_id ) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }
        
       
        // Fetch settings type
        $all_clients            = $this->settings_model->get_all_clients();
        $view_data['clients']   = $all_clients;
        
        $role_id = $this->session->userdata('roleId');
	    $user_id = $this->session->userdata('userId');
        
        if( empty( $role_id ) && empty( $user_id ))
        {
            $session_data   = $this->session->userdata("user");
            $role_id        = $session_data['role_id'];
            $user_id        = $session_data['id'];
        } 
       
		$crumbs = breadcrumb(array( 
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Store Payment Settings' => array('link'=>'settings/manage_settings', 'attributes' => array('class'=>'breadcrumb')),
			'Add Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		
		$view_data['caption'] = "Add Settings";
		$view_data['role_id']  =  $role_id ;
		
		if($role_id == 4){
			$crumbs = breadcrumb(array( 
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Social Media Settings' => array('link'=>'settings/manage_settings', 'attributes' => array('class'=>'breadcrumb')),
			'Add Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
			));
			//Set the view crumbs
			$view_data['crumbs'] = $crumbs;
		}

        $this->load->library('upload');
		
		if( $this->input->post('formSubmitted') > 0 )
		{ 		
		    if( !empty( $_FILES['logo_image'] ) )
		    {
		    
				$config['upload_path']      = '../uploads/logos/';
				$config['allowed_types']    = 'gif|jpg|png|jpeg';
				$config['max_size']	        = '10000';
				$config['max_width']        = '1600';
				$config['max_height']       = '800';

				$this->upload->initialize($config);
				if( !$this->upload->do_upload('logo_image') )
				{
					// invalid image type 
					$error = array( 'error' => $this->upload->display_errors() );
				}
				else
				{
					$uploadedData = $this->upload->data();
					//echo '<pre>';print_r($uploadedData);die;
					$logopath = '/uploads/logos/'.$uploadedData['file_name'];
				}
			}
		    
		    if($role_id == 4){
		    	$vlRule = 'cons_addsettings' ;
		    }elseif($role_id == 1){
				$vlRule = 'admin_addsettings' ;
			}else{
		    	$vlRule = 'addsettings' ;
		    }
		    
		    if( $this->form_validation->run($vlRule) )
			//if( isset( $_POST['paypal_username'] ) && !empty( $_POST['paypal_username'] ) )
			{
				
			    if(!$this->upload->display_errors() || ($this->upload->display_errors() == '<p>You did not select a file to upload.</p>' ))
			    {
			       //Everything is ok lets update the page data
			    	//echo 'File uploaded ok';
				    if($this->settings_model->add( $role_id, $user_id, $logopath )) {
				    		//echo 'No error there';die;
						    $this->session->set_flashdata('success', "<li>settings has been added successfully.</li>");
						    $this->output->set_header('location:' . base_url() . 'settings/manage_settings');
					    } else {
					    	//echo 'errors there'; die;
						    $this->session->set_flashdata('error', "<li>Unknown Error: Unable to add settings.</li>");
						    $this->output->set_header('location:' . base_url() . 'settings/manage_settings');
					    }
				     
				     $view_data['logo_image']           = $logopath;
				     if(($role_id != 4) && ($role_id != 1)){
				     	 /*
				     	 $view_data['paypal_username']      = $this->input->post('paypal_username');
					     $view_data['paypal_email']         = $this->input->post('paypal_email');
					     $view_data['paypal_signature']     = $this->input->post('paypal_signature');
					     $view_data['paypal_password']      = $this->input->post('paypal_password');
					     */
					     //$view_data['tax']                  = $this->input->post('tax');
					     /*
					     $view_data['mp_merchant_id']       = $this->input->post('mp_merchant_id');
	         			 $view_data['mp_merchant_key']      = $this->input->post('mp_merchant_key');

	         			 $view_data['ava_account_number']   = $this->input->post('ava_account_number');
				         $view_data['ava_license_key']      = $this->input->post('ava_license_key');
				         $view_data['ava_company_code']     = $this->input->post('ava_company_code');
				         */

				     }
				     
				     $view_data['fb_link']              = $this->input->post('fb_link');
				     $view_data['twitter_link']         = $this->input->post('twitter_link');
				     $view_data['pinterest_link']       = $this->input->post('pinterest_link');
				     $view_data['linkdin_link']         = $this->input->post('linkdin_link');
				     $view_data['gplus_link']           = $this->input->post('gplus_link');
				     $view_data['youtube_link']         = $this->input->post('youtube_link');
				     $view_data['status']               = $this->input->post('status');
				     $view_data['created']              = date("Y-m-d h:i:s");
				     $view_data['modified']             = date("Y-m-d h:i:s");
				     $view_data['role_id']  =  $role_id ;
				     $this->_vci_view('settings_add', $view_data);
				}
			}
			else
			{

                 $view_data['logo_image']           = $logopath;
                 if(($role_id != 4) && ($role_id != 1)){
					 /* $view_data['paypal_username']      = $this->input->post('paypal_username');
					 $view_data['paypal_email']         = $this->input->post('paypal_email');
					 $view_data['paypal_signature']     = $this->input->post('paypal_signature');
					 $view_data['paypal_password']      = $this->input->post('paypal_password');

					 $view_data['mp_merchant_id']       = $this->input->post('mp_merchant_id'); ;
	         		 $view_data['mp_merchant_key']      = $this->input->post('mp_merchant_key');;
					*/
					 //$view_data['tax']                  = $this->input->post('tax');
					 /* $view_data['ava_account_number']   = $this->input->post('ava_account_number');
			         $view_data['ava_license_key']      = $this->input->post('ava_license_key');
			         $view_data['ava_company_code']     = $this->input->post('ava_company_code'); */
				 }
				 $view_data['fb_link']              = $this->input->post('fb_link');
				 $view_data['twitter_link']         = $this->input->post('twitter_link');
				 $view_data['pinterest_link']       = $this->input->post('pinterest_link');
				 $view_data['linkdin_link']         = $this->input->post('linkdin_link');
				 $view_data['gplus_link']           = $this->input->post('gplus_link');
				 $view_data['youtube_link']         = $this->input->post('youtube_link');
				 $view_data['status']               = $this->input->post('status');
				 $view_data['created']              = date("Y-m-d h:i:s");
				 $view_data['modified']             = date("Y-m-d h:i:s");
				 $view_data['role_id']  =  $role_id ;
				 $this->_vci_view('settings_add', $view_data);
			}
		}else
		{
			//form not submitted load view normally //
			$this->_vci_view('settings_add', $view_data);
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method:edit_page
	*	@param id integer
	*	Description: update the page data identified by the id
	-----------------------------------------------------------------
	*/
	function edit_settingsold($id = null)
	{
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit settings without settings id.</li>");
				$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
			}
		}

        // get the store id or admin 
        $store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }
				
		if( !isset($store_id) && empty($store_id) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }
        
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$view_data = array();

		// Fetch settings type
		$all_settings_types = $this->settings_model->get_all_settings_types();
        $view_data['settings_types'] = $all_settings_types;
        
		$allowed_types = array('gif','png','jpg','jpeg','jpe','image/jpeg','image/gif','image/png','image/jpg','image/jpeg','image/jpe');
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Store Payment Settings' => array('link'=>'settings/manage_settings', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit Settings";

		$page = $this->settings_model->get_settings_page(trim($id));
		#echo '<pre>';
		#print_r($page);
		if($page->role_id == 4){
			$crumbs = breadcrumb(array(
				'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
				'Social Media Settings' => array('link'=>'settings/manage_settings', 'attributes' => array('class'=>'breadcrumb')),
				'Edit Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
			));
			//Set the view crumbs
			$view_data['crumbs'] = $crumbs;
			//Set the view caption
			$view_data['caption'] = "Edit Settings";
		}
		//Set the validation rules for server side validation
        $this->load->library('upload');
		if($this->input->post('formSubmitted') > 0) 
		{
		        $logopath = $this->input->post('path');
		        
			    if(!empty($_FILES['logo_image']))
			    {
                    $config['upload_path'] = '../uploads/logos/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '1000000';
					$config['max_width']  = ' 6000';
					$config['max_height']  = '3500';
					$this->upload->initialize($config);

					if( ! $this->upload->do_upload('logo_image')){
						// invalid image type 
					$error = array('error' => $this->upload->display_errors());
						
					}else{
						$uploadedData = $this->upload->data() ;
						$logopath = '/uploads/logos/'.$uploadedData['file_name'] ;	
					}
				}
            //echo $logopath;die;
			//echo 'page Role'.$page->role_id ;
			//die;

			if($page->role_id == 4){
				$vlRule = 'cons_addsettings' ;

			}elseif($page->role_id == 1){
				$vlRule = 'admin_addsettings' ;
			}
			else{
				$vlRule = 'addsettings' ;
			}

			if($this->form_validation->run($vlRule)) 
			//if( isset( $_POST['code'] ) && !empty( $_POST['code'] ) )
			{
			    //echo '<pre>';print_r($this->input->post());die;
				//Everything is ok lets update the page data
				if($this->settings_model->update( trim($id), $logopath ) ) {
					$this->session->set_flashdata('success', "<li>settings has been edited successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
				} else {
					$this->session->set_flashdata('errors', "<li>Unknown Error: Unable to edit settings.</li>");
					$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
				}
			
			} else {
				//Set the view data and render the view in case validation fails
				$page = $this->settings_model->get_settings_page(trim($id));


			 $view_data["id"]                   = $page->id;
			 $view_data['logo_image']           = $page->logo_image;
	         $view_data['paypal_username']      = $page->paypal_username;
	         $view_data['paypal_email']         = $page->paypal_email;
	         $view_data['paypal_signature']     = $page->paypal_signature;
	         $view_data['paypal_password']      = $page->paypal_password;
	         //$view_data['tax']                  = $page->tax;
	         $view_data['fb_link']              = $page->fb_link;
	         $view_data['twitter_link']         = $page->twitter_link;
	         $view_data['pinterest_link']       = $page->pinterest_link;
	         $view_data['linkdin_link']         = $page->linkdin_link;
	         $view_data['gplus_link']           = $page->gplus_link;
	         $view_data['youtube_link']         = $page->youtube_link;
	         $view_data['consultant_label']     = $page->consultant_label ;
	         //Stylist
	         $view_data['status']               = $page->status;
	         $view_data['modified']             = date("Y-m-d h:i:s");
	         $view_data['role_id']              = $page->role_id ;

	         $view_data['mp_merchant_id']       = $page->mp_merchant_id ;
	         $view_data['mp_merchant_key']      = $page->mp_merchant_key ;

	         $view_data['ava_account_number']   = $page->ava_account_number ;
	         $view_data['ava_license_key']      = $page->ava_license_key ;
	         $view_data['ava_company_code']     = $page->ava_company_code ;

             $this->_vci_view('settings_editpage', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			//Set the view data and render the view
			 $page = $this->settings_model->get_settings_page( trim( $id ) );

			 $view_data["id"]                   = $page->id;
			 $view_data['logo_image']           = $page->logo_image;
	         $view_data['paypal_username']      = $page->paypal_username;
	         $view_data['paypal_email']         = $page->paypal_email;
	         $view_data['paypal_signature']     = $page->paypal_signature;
	         $view_data['paypal_password']      = $page->paypal_password;
	         //$view_data['tax']                  = $page->tax;
	         $view_data['fb_link']              = $page->fb_link;
	         $view_data['twitter_link']         = $page->twitter_link;
	         $view_data['pinterest_link']       = $page->pinterest_link;
	         $view_data['linkdin_link']         = $page->linkdin_link;
	         $view_data['gplus_link']           = $page->gplus_link;
	         $view_data['youtube_link']         = $page->youtube_link;
	         $view_data['consultant_label']     = $page->consultant_label ;
	         $view_data['status']               = $page->status;
	         $view_data['modified']             = date("Y-m-d h:i:s");
	         $view_data['role_id']              = $page->role_id ;
	         $view_data['mp_merchant_id']       = $page->mp_merchant_id ;
	         $view_data['mp_merchant_key']      = $page->mp_merchant_key ;

	         $view_data['ava_account_number']   = $page->ava_account_number ;
	         $view_data['ava_license_key']      = $page->ava_license_key ;
	         $view_data['ava_company_code']     = $page->ava_company_code ;

			$this->_vci_view('settings_editpage', $view_data);
		}	
	}

	function edit_settings($id = null)
	{
		//Check if we have got the page id
		error_reporting(1);		
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit settings without settings id.</li>");
				$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
			}
		}

        // get the store id or admin 
        $store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }
				
		if( !isset($store_id) && empty($store_id) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }
        
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$view_data = array();

		// Fetch settings type
		$all_settings_types = $this->settings_model->get_all_settings_types();
        $view_data['settings_types'] = $all_settings_types;
        
		$allowed_types = array('gif','png','jpg','jpeg','jpe','image/jpeg','image/gif','image/png','image/jpg','image/jpeg','image/jpe');
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Store Payment Settings' => array('link'=>'settings/manage_settings', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit Settings";

		$page = $this->settings_model->get_settings_page(trim($id));
		#echo '<pre>';
		#print_r($page);
		if($page->role_id == 4){
			$crumbs = breadcrumb(array(
				'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
				'Social Media Settings' => array('link'=>'settings/manage_settings', 'attributes' => array('class'=>'breadcrumb')),
				'Edit Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
			));
			//Set the view crumbs
			$view_data['crumbs'] = $crumbs;
			//Set the view caption
			$view_data['caption'] = "Edit Settings";
		}
		//Set the validation rules for server side validation
        $this->load->library('upload');
		if($this->input->post('formSubmitted') > 0) 
		{
		        $logopath = $this->input->post('path');
		        
			    if(!empty($_FILES['logo_image']))
			    {
                    $config['upload_path'] = '../uploads/logos/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '1000000';
					$config['max_width']  = ' 6000';
					$config['max_height']  = '3500';
					$this->upload->initialize($config);

					if( ! $this->upload->do_upload('logo_image')){
						// invalid image type 
					$error = array('error' => $this->upload->display_errors());
						
					}else{
						$uploadedData = $this->upload->data() ;
						$logopath = '/uploads/logos/'.$uploadedData['file_name'] ;	
					}
				}
            //echo $logopath;die;
			//echo 'page Role'.$page->role_id ;
			//die;

			if($page->role_id == 4){
				$vlRule = 'cons_addsettings' ;

			}elseif($page->role_id == 1){
				$vlRule = 'admin_addsettings' ;
			}
			else{
				$vlRule = 'addsettings' ;
			}

			if($this->form_validation->run($vlRule)) 
			//if( isset( $_POST['code'] ) && !empty( $_POST['code'] ) )
			{
			    //echo '<pre>';print_r($this->input->post());die;
				//Everything is ok lets update the page data
				if($this->settings_model->update( trim($id), $logopath ) ) {
					$this->session->set_flashdata('success', "<li>settings has been edited successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
				} else {
					$this->session->set_flashdata('errors', "<li>Unknown Error: Unable to edit settings.</li>");
					$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
				}
			
			} else {
				//Set the view data and render the view in case validation fails
				$page = $this->settings_model->get_settings_page(trim($id));


			 $view_data["id"]                   = $page->id;
			 $view_data['logo_image']           = $page->logo_image;
	        
	         //$view_data['tax']                  = $page->tax;
	         $view_data['fb_link']              = $page->fb_link;
	         $view_data['twitter_link']         = $page->twitter_link;
	         $view_data['pinterest_link']       = $page->pinterest_link;
	         $view_data['linkdin_link']         = $page->linkdin_link;
	         $view_data['gplus_link']           = $page->gplus_link;
	         $view_data['youtube_link']         = $page->youtube_link;
	         $view_data['consultant_label']     = $page->consultant_label ;
	         //Stylist
	         $view_data['status']               = $page->status;
	         $view_data['modified']             = date("Y-m-d h:i:s");
	         $view_data['role_id']              = $page->role_id ;

             $this->_vci_view('settings_editpage', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			//Set the view data and render the view
			 $page = $this->settings_model->get_settings_page( trim( $id ) );

			 $view_data["id"]                   = $page->id;
			 $view_data['logo_image']           = $page->logo_image;
	         
	         //$view_data['tax']                  = $page->tax;
	         $view_data['fb_link']              = $page->fb_link;
	         $view_data['twitter_link']         = $page->twitter_link;
	         $view_data['pinterest_link']       = $page->pinterest_link;
	         $view_data['linkdin_link']         = $page->linkdin_link;
	         $view_data['gplus_link']           = $page->gplus_link;
	         $view_data['youtube_link']         = $page->youtube_link;
	         $view_data['consultant_label']     = $page->consultant_label ;
	         $view_data['status']               = $page->status;
	         $view_data['modified']             = date("Y-m-d h:i:s");
	         $view_data['role_id']              = $page->role_id ;
	         
			$this->_vci_view('settings_editpage', $view_data);
		}	
	}

	function edit_settings_paypal($id = null)
	{
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit settings without settings id.</li>");
				$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
			}
		}

        // get the store id or admin 
        $store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }
				
		if( !isset($store_id) && empty($store_id) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }
        
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$view_data = array();

		// Fetch settings type
		$all_settings_types = $this->settings_model->get_all_settings_types();
        $view_data['settings_types'] = $all_settings_types;
        
		
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Store Payment Settings' => array('link'=>'settings/manage_settings', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Settings Paypal' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit Paypal Settings";

		$page = $this->settings_model->get_settings_page(trim($id));
		
		if($this->input->post('formSubmitted') > 0) 
		{
			error_reporting(1);
			$vlRule = 'addsettingspaypal' ;
			//echo '<pre>';print_r($this->input->post());die;

			if($this->form_validation->run($vlRule)) 
			{
			    
				//Everything is ok lets update the page data
				if($this->settings_model->updatepaypal( trim($id) ) ) {
					$this->session->set_flashdata('success', "<li>Paypal settings has been updated successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
				}else{
					$this->session->set_flashdata('errors', "<li>Unknown Error: Unable to edit settings.</li>");
					$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
				}
			
			} else {
				//Set the view data and render the view in case validation fails
			 $page = $this->settings_model->get_settings_page(trim($id));


			 $view_data["id"]                   = $page->id;
			 
	         $view_data['paypal_username']      = $page->paypal_username;
	         $view_data['paypal_email']         = $page->paypal_email;
	         $view_data['paypal_signature']     = $page->paypal_signature;
	         $view_data['paypal_password']      = $page->paypal_password;
	         $view_data['payusing']      = $page->payusing ;
	         
	        
	         $view_data['modified']             = date("Y-m-d h:i:s");
	         $view_data['role_id']              = $page->role_id ;

             $this->_vci_view('settings_editpage_paypal', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			//Set the view data and render the view
			 $page = $this->settings_model->get_settings_page( trim( $id ) );

			 $view_data["id"]                   = $page->id;
			
	         $view_data['paypal_username']      = $page->paypal_username;
	         $view_data['paypal_email']         = $page->paypal_email;
	         $view_data['paypal_signature']     = $page->paypal_signature;
	         $view_data['paypal_password']      = $page->paypal_password;
	         
	         
	         $view_data['modified']             = date("Y-m-d h:i:s");
	         $view_data['role_id']              = $page->role_id ;
	         $view_data['payusing']             = $page->payusing ;
			$this->_vci_view('settings_editpage_paypal', $view_data);
		}	
	}

	function edit_settings_meritus($id = null)
	{
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit settings without settings id.</li>");
				$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
			}
		}

        // get the store id or admin 
        $store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }
				
		if( !isset($store_id) && empty($store_id) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }
        
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$view_data = array();

		// Fetch settings type
		$all_settings_types = $this->settings_model->get_all_settings_types();
        $view_data['settings_types'] = $all_settings_types;
        
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Store Payment Settings' => array('link'=>'settings/manage_settings', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Meritus Setting' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit Meritus Settings";

		$page = $this->settings_model->get_settings_page(trim($id));
		
		if($this->input->post('formSubmitted') > 0) 
		{
			$vlRule = 'addsettingsmeritus' ;
			if($this->form_validation->run($vlRule)) 
			{
				if($this->settings_model->updatemeritus(trim($id)) ) {
					$this->session->set_flashdata('success', "<li>Meritus settings has been updated successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
				} else {
					$this->session->set_flashdata('errors', "<li>Unknown Error: Unable to edit settings.</li>");
					$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
				}
			
			} else {
				//Set the view data and render the view in case validation fails
				$page = $this->settings_model->get_settings_page(trim($id));


			 $view_data["id"]                   = $page->id;
			 
	         $view_data['modified']             = date("Y-m-d h:i:s");
	         $view_data['role_id']              = $page->role_id ;
	         $view_data['mp_merchant_id']       = $page->mp_merchant_id ;
	         $view_data['mp_merchant_key']      = $page->mp_merchant_key ;
	         $view_data['payusing']      		= $page->payusing ;
			$view_data['meritus_enabled']      = $page->meritus_enabled ;
             $this->_vci_view('settings_editpage_meritus', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			//Set the view data and render the view
			 $page = $this->settings_model->get_settings_page( trim( $id ) );

			 $view_data["id"]                   = $page->id;
			
	         $view_data['modified']             = date("Y-m-d h:i:s");
	         $view_data['role_id']              = $page->role_id ;
	         $view_data['mp_merchant_id']       = $page->mp_merchant_id ;
	         $view_data['mp_merchant_key']      = $page->mp_merchant_key ;
			 $view_data['meritus_enabled']      = $page->meritus_enabled ;
	         $view_data['payusing']      		= $page->payusing ;

			$this->_vci_view('settings_editpage_meritus', $view_data);
		}	
	}

	function edit_settings_avatax($id = null)
	{
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit settings without settings id.</li>");
				$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
			}
		}

        // get the store id or admin 
        $store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }
				
		if( !isset($store_id) && empty($store_id) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }
        
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$view_data = array();

		// Fetch settings type
		$all_settings_types = $this->settings_model->get_all_settings_types();
        $view_data['settings_types'] = $all_settings_types;
        
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Store Payment Settings' => array('link'=>'settings/manage_settings', 'attributes' => array('class'=>'breadcrumb')),
			'Edit AvaTax Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit AvaTax Settings";

		$page = $this->settings_model->get_settings_page(trim($id));
		
		if($this->input->post('formSubmitted') > 0) 
		{
			$vlRule = 'addsettingsavatax' ;
			if($this->form_validation->run($vlRule)) 
			{
				if($this->settings_model->updateavatax(trim($id)) ) {
					$this->session->set_flashdata('success', "<li>AvaTax settings has been updated successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
				} else {
					$this->session->set_flashdata('errors', "<li>Unknown Error: Unable to edit settings.</li>");
					$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
				}
			
			}else{
				//Set the view data and render the view in case validation fails
				$page = $this->settings_model->get_settings_page(trim($id));

				 $view_data["id"]                   = $page->id;
				 
		         $view_data['modified']             = date("Y-m-d h:i:s");
		         $view_data['role_id']              = $page->role_id ;

		         $view_data['ava_account_number']   = $page->ava_account_number ;
		         $view_data['ava_license_key']      = $page->ava_license_key ;
		         $view_data['ava_company_code']     = $page->ava_company_code ;

             $this->_vci_view('settings_editpage_avatax', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			//Set the view data and render the view
			 $page = $this->settings_model->get_settings_page( trim( $id ) );

			 $view_data["id"]                   = $page->id;
			
	         $view_data['modified']             = date("Y-m-d h:i:s");
	         $view_data['role_id']              = $page->role_id ;
	        
	         $view_data['ava_account_number']   = $page->ava_account_number ;
	         $view_data['ava_license_key']      = $page->ava_license_key ;
	         $view_data['ava_company_code']     = $page->ava_company_code ;

			$this->_vci_view('settings_editpage_avatax', $view_data);
		}	
	}

	function testavatax_connection($id){
		error_reporting(1);
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit settings without settings id.</li>");
				$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
			}
		}

        // get the store id or admin 
        $store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }
				
		if( !isset($store_id) && empty($store_id) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }
        
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$view_data = array();

		// Fetch settings type
		$all_settings_types = $this->settings_model->get_all_settings_types();
        $view_data['settings_types'] = $all_settings_types;
        $view_data['id'] = $id ;
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Store Payment Settings' => array('link'=>'settings/manage_settings', 'attributes' => array('class'=>'breadcrumb')),
			'Test AvaTax connection' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Test AvaTax connection";

		$page = $this->settings_model->get_settings_page( trim( $id ) );
		$this->load->library('Avatax'); 
		
    	$avaconfig['accountNumber'] = $page->ava_account_number ;
		$avaconfig['licenseKey']    = $page->ava_license_key;
		$avaconfig['serviceURL']    = 'https://development.avalara.net' ;
		$avaconfig['company_code']  = $page->ava_company_code ;

		$view_data['posteddata']['config']  = $avaconfig ;

		if($this->input->post('formSubmitted') > 0){
			#pr($this->input->post()) ;
			$postddata = $this->input->post() ;
			//echo '<pre>';
			//print_r($postddata);
			#die;
			$view_data['posteddata']['config']  = array() ;
	    	$view_data['posteddata']['Customer']  =  array() ;
	    	$view_data['posteddata']['address']  =  array() ;
	    	$view_data['posteddata']['cartitems'] =  array() ;
	    	$view_data['posteddata']['total_tax'] =  array() ;

			$avaconfig['accountNumber'] = $this->input->post('ava_account_number') ;
			$avaconfig['licenseKey']    = $this->input->post('ava_license_key');
			$avaconfig['serviceURL']    = $this->input->post('account_url') ;   
			$avaconfig['company_code']  = $this->input->post('ava_company_code') ;

			
			$customer['customer_code'] = $this->input->post('customer_code') ;
			$customer['customer_id']   = $this->input->post('customer_id') ; // simplesales system user id 

			$items['id'] 		= $postddata['item_id'][1] ;
			$items['qty'] 		= $postddata['item_qty'][1] ;
			$items['price'] 	= $postddata['item_price'][1] ;
			$items['name'] 		= $postddata['item_name'][1] ;
			$items['subtotal'] 	= $postddata['item_subtotal'][1] ;
			$items['tax_code'] 	= $postddata['tax_code'][1]  ;
			$cartdetail[] = $items ;

			$items['id'] 		= $postddata['item_id'][2] ;
			$items['qty'] 		= $postddata['item_qty'][2] ;
			$items['price'] 	= $postddata['item_price'][2] ;
			$items['name'] 		= $postddata['item_name'][2] ;
			$items['subtotal'] 	= $postddata['item_subtotal'][2] ;
			$items['tax_code'] 	= $postddata['tax_code'][2]  ;
			$cartdetail[] = $items ;

			$addr =  array(
	    		'state_code'=>$postddata['state_code'][1] ,
	    		'city'=>$postddata['city'][1],
	    		'zip'=>$postddata['zip'][1],
	    		'country'=>$postddata['country'][1] ,
	    		) ;
	    	
	    	$addresss[] = $addr ;
	    	//pr($shipping_data) ; // customer detail
	    	$addr2 = array(
	    		'state_code'=>$postddata['state_code'][2],
	    		'city'=>$postddata['city'][2],
	    		'zip'=>$postddata['zip'][2],
	    		'country'=>$postddata['country'][2],
	    		) ;
	    	$addresss[] = $addr2 ;
	    	$cdisc = 0 ;
	    	//echo 'tax result ammount' ;
		if(!empty($avaconfig['accountNumber'])){
			$TotalTaxAmount = $this->avatax->getax($avaconfig , $customer , $addresss, $cartdetail , $cdisc) ; 
		}else{
		        $TotalTaxAmount =  0 ;
		}
	    	
	    	#die('Stopped') ;
	    	$view_data['posteddata']['config']  = $avaconfig ;
	    	$view_data['posteddata']['Customer']  = $customer ;
	    	$view_data['posteddata']['address']  = $addresss ;
	    	$view_data['posteddata']['cartitems'] = $cartdetail ;
	    	$view_data['posteddata']['total_tax'] = $TotalTaxAmount ;
	    	$view_data['id'] = $postddata['id'];

		}

		$this->_vci_view('avatax_connection', $view_data);
	}
	/*
	-----------------------------------------------------------------
	*	Method: manage_settings
	*	@param id integer
	*	Description: Fetch all City from database and render on screen
	-----------------------------------------------------------------
	*/
	function manage_settings($page = 0) {

		//Set the layout and initialize the view variable; Set view caption
		$this->_vci_layout('menu-toolbar');
		$view_data = array();
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s');
		}
		
		//creates bread crumb
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Store Payment Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		$view_data['caption'] = "Store Payment Settings";
		//Load model and pagination library
		$this->load->library('pagination');
		
		//Set pagination configs
		$getData = array('s'=>$qstr);
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");

		$config['first_url'] = base_url() . "settings/manage_settings?s=".$qstr;
		
		//Fetch all pages from database
		$store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
            
        }
				
		if( !isset( $store_id ) && empty( $store_id ) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }
	    
	    $role_id = $this->session->userdata('roleId');
	    $user_id = $this->session->userdata('userId');
	    if( empty( $role_id ) && empty( $user_id ))
        {
            $session_data   = $this->session->userdata("user");
            $role_id        = $session_data['role_id'];
            $user_id        = $session_data['id'];
        } 
	    // check the admin settings are already in or not?
        
	    if ( $is_exist = $this->common_model->isSettingsexist( $role_id, $user_id) )
	    {
	        $this->session->set_userdata("settingsExists", true );
	    }
	    else
	    {
	        $this->session->set_userdata("settingsExists", false );
	    }

		$config['base_url']     = base_url() . "settings/manage_settings";
		$config['total_rows']   = intval($this->settings_model->get_settings($page,'',true, $role_id, $user_id ));
		$config['per_page']     = PAGE_LIMIT ;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		
	    $view_data['clients_consultant'] = $this->settings_model->all_clients_consultant();
			    
		$clients                = $this->settings_model->get_all_clients();
        $view_data['clients']   = $clients;
		$view_data['content']   = $this->settings_model->get_settings($page, $config['per_page'],'', $role_id, $user_id );
		
		if(isset($this->session->userdata))
		{
			$cons_role_id = $this->session->userdata('user');
			$view_data['consultant_role_id'] = $cons_role_id['role_id'];
			if($cons_role_id['role_id'] == 4){
				$view_data['caption'] = "Social Media Settings";
				$crumbs = breadcrumb(array(
				'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
				'Social Media Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
				));

				$view_data['crumbs'] = $crumbs;
			}
		}

		$this->_vci_view('settings_managesettings', $view_data);
	}

	/*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer 
	*	Description: update settings status. if status is active then 
		deactive toggles the operation
	-----------------------------------------------------------------
	*/

	function update_status($id = null, $status = 1, $page = 0)
	{
		//Set layout and load model
		$this->_vci_layout('menu-toolbar');
		
		//Check if id was passed
		if(is_null($id))
		{
			$this->session->set_flashdata('errors', '<li>Unable to perform the requested operation without id.</li>');
			$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
		}
		else
		{
		    //Toggles the status
		    if(intval($status) == 1)
		    {
			    $status = 0;
		    }
		    else
			{
			    $status = 1;
            }
            //echo $id.'   '.$status;die;
		    //Update the status for the settings page and redirect to listing with success msg
		    $result = $this->settings_model->update_status($id, $status);
		    $this->session->set_flashdata('success', '<li> settings has been updated successfully.</li>');
		    $this->output->set_header('location:' . base_url() . 'settings/manage_settings' . (($page>0) ? '/' . $page : ''));
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method: delete_settings
	*	@param none
	*	Description: for deleting settings
	-----------------------------------------------------------------
	*/

	function delete_settings(){
		$this->_vci_layout('menu-toolbar');
		
		if($this->settings_model->delete_settings())
		{	
			$this->session->set_flashdata('success', 'settings deleted sucessfully');
			$this->output->set_header('location:' . base_url() . 'settings/manage_settings');
		}
		else {
		    $this->session->set_flashdata('errors','settings deletion failed');
			$this->output->set_header('location:'. base_url(). 'settings/manage_settings');
		}
	}

}

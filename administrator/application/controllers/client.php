<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Class:	client extends VCI_Controller defined in libraries
 *	Author:	Mandeep Singh
 *	Platform:	Codeigniter
 *	Company:	Cogniter Technologies
 *	Description: Manage client entity
 */
class Client extends VCI_Controller {

	var $clientid		= null; 
	var $per_page;

    /**
     * Class constructor
     */
	function __construct()
	{
		parent::__construct();
        //$this->_vci_layout('menu-toolbar');
        $this->load->model('client_model');
        
	}

	/**
	 *	Method: New client
	 *	Description: Add a new client.
 	 */
	function add()
	{
	    //redirect( base_url( ) . 'client/manage' );
		//set required things
		
		//$this->session->unset_userdata('storeId');
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');

		//sets the data form exporting to view
		$view_data = array('caption' => $this->lang->line('newclient_caption'));
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'client/desktop', 'attributes' => array('class'=>'breadcrumb')),
			'Manage clients' => array('link'=>'client/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Add New client' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));

		$view_data['crumbs'] = $crumbs;

		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
		    //validates the post data by using the rules defined in config file
			if($this->form_validation->run('add_client'))
			//if( isset($_POST['fName']) && !empty($_POST['fName'])  && isset($_POST['lName']) && !empty($_POST['lName']) && isset($_POST['password']) && !empty($_POST['password']) )
			{
				$salt_value = str_random(6);
			    $post_data = array(
			        'fName'      => htmlspecialchars($this->input->post('fName', true)),
			        'username'   => htmlspecialchars($this->input->post('uName', true)),
			        'email'      => htmlspecialchars($this->input->post('email', true)),
			        'password'   => md5($this->input->post('password', true).md5($salt_value)),
			    	'password_salt' => $salt_value,
			        'company'    => $this->input->post('company', true),
			        'address'    => $this->input->post('address', true),
			        'city'       => $this->input->post('city', true),
			        'state_code' => $this->input->post('state_code', true),
			        'zip'        => $this->input->post('zip', true),
			        'phone'      => $this->input->post('phone', true),
			    	'fax'        => $this->input->post('fax', true),
			    	'sale_support_email'      => $this->input->post('sale_support_email', true),
			    	'partner_support_email'   => $this->input->post('partner_support_email', true),
			    	'technical_support_email' => $this->input->post('technical_support_email', true),
			    	'about_us_link'           => $this->input->post('about_us_link', true),
			    	'opportunity_link'        => $this->input->post('opportunity_link', true),
			        'comments'   => $this->input->post('comments', true),
			        'status'     => $this->input->post('status', true),
			        'created'    => date("Y-m-d h:i:s"),
                    'modified'   => date("Y-m-d h:i:s"),
			    );
				//register the client and redirect to listing page with success msg
				$response_add_client = $this->client_model->add( $post_data );
				if( $response_add_client )
				{
					$this->client_model->add_client_pages( $response_add_client );
					$this->session->set_flashdata('success', $this->lang->line('client_reg_success'));
					$this->output->set_header('location:' . base_url() . 'client/manage');
				}
			} else
			{
				//validation comes with errors the load the view again
				$this->_vci_view('newclient', $view_data);
			}
		} else
		{
			//form not submitted load view normally
			$this->_vci_view('newclient', $view_data);
		}
	}

	function url_valid_format()
	{
		$url = trim($_POST['about_us_link']);
		$pattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		if($url!='')
		{
			if (!@preg_match($pattern, $url))
			{
				$this->form_validation->set_message('url_valid_format', 'The About Us Page Link field must contain a valid URL. Eg. http://www.google.com or www.google.com');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			return TRUE;
		}
	}
	function url_valid_format_opp()
	{
		$url = trim($_POST['opportunity_link']);
		$pattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		
		if($url!='')
		{
			if (!@preg_match($pattern, $url))
			{
				$this->form_validation->set_message('url_valid_format_opp', 'The Opportunity Page Link field must contain a valid URL. Eg. http://www.google.com or www.google.com');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			return TRUE;
		}
	}
	/**
	 *	Method: is_client_exists
	 *	@param clientname string
	 *	Description: Callback method used for unique clientname check
 	 *	by form validation rules defined in config/form_validation.php
	 */
	function is_client_exists($clientname)
	{
		return (!empty($this->clientid)) ? !$this->client_model->is_client_exists($clientname, $this->clientid) : !$this->client_model->is_client_exists($clientname);
	}

	/*
	-----------------------------------------------------------------
	*	Method: is_email_exists
	*	@param email string
	*	Description: Callback method used for unique email check by
		form validation rules defined in config/form_validation.php
	-----------------------------------------------------------------
	*/

	function is_email_exists($email)
	{
		return (!empty($this->clientid)) ? !$this->client_model->is_email_exists($email, $this->clientid) : !$this->client_model->is_email_exists($email);
	}

	/**
	 *	Method: manage
	 *	@param page integer
	 *	Description: creates listing and handles search operations
	 */
	function manage($page = 0)
	{
	    //redirect( base_url( ) . 'admin/desktop' );

		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		$userdetail = $this->session->userdata('user');
		
		if($userdetail['role_id'] == 1){
			$desktoplink = base_url() .'admin/desktop' ;
		}else{
			$desktoplink = base_url() .'client/desktop' ;
		}
		//prepare the data for exporting to view
		$view_data = array('caption' => $this->lang->line('manageclient_caption'));
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>$desktoplink, 'attributes' => array('class'=>'breadcrumb')),
			'Manage clients' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));

		//set pagination configs
		$config['first_url'] = base_url() . "client/manage/";	
		$config['base_url']   = base_url() . "client/manage";
		$config['total_rows'] = intval($this->client_model->get_all_clients('','',true));
		$config['per_page']   = PAGE_LIMIT;
		//$config['per_page']   = 5;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();

		$view_data['crumbs']     = $crumbs;
		//fetch all clients from database
		$view_data['clients']      = $this->client_model->get_all_clients($page, PAGE_LIMIT);
		
		$this->_vci_view('client_manage', $view_data);
	}

	/**
	 * Method: delete_client
	 * Description: Deletes a client from database and redirect to
	 * manage_client
	 */

	function delete_client()
	{
	    //redirect( base_url( ) . 'client/manage' );
		$this->_vci_layout('menu-toolbar');
	
		if($this->client_model->delete_client())
		{
			$this->session->set_flashdata('success', $this->lang->line('client_del_success'));
			$this->output->set_header('location:' . base_url() . 'client/manage');
		}
		else {
		    $this->session->set_flashdata('errors',$this->lang->line('client_del_failed'));
			$this->output->set_header('location:'. base_url(). 'client/manage');
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer
	*	Description: update client status. if status is active then
		deactive toggles the operation
	-----------------------------------------------------------------
	*/

	function update_status($id = null, $status = 1, $page = 0)
	{
		$this->_vci_layout('menu-toolbar');

		//check if id was passed
		if(is_null($id))
		{
			$this->session->set_flashdata('errors', $this->lang->line('client_edit_id_error'));
			$this->output->set_header('location:' . base_url() . 'client/manage');
		}

		//toggles the status
		/*if(intval($status) == 1)
			$status = 0;
		else
			$status = 1;*/

		//update the status for the client and redirect to listing with success msg
		$result = $this->client_model->update_status($id, $status);
		$this->session->set_flashdata('success', $this->lang->line('client_upd_success'));
		$this->output->set_header('location:' . base_url() . 'client/manage' . (($page>0) ? '/' . $page : ''));
	}

	/**
	 *	Method: edit client
     *
	 *	@param id integer
	 *	Description: edit client information
	 */
	function edit($id = null)
	{
		//set required things
		$this->_vci_layout( 'menu-toolbar' );
		$this->load->model( 'client_model' );
		$this->load->library( 'form_validation' );
        $uri = $this->uri->uri_to_assoc(3);
        
		//get clientid either from argument passed or from posted fields
		$this->clientid = ( isset( $uri['id'] ) ) ? $uri['id'] : $this->input->post( 'id' );
		//check if client id is not empty
		$cusrrole = $this->session->userdata('user') ;
		
		if( empty( $this->clientid ) )
		{
			$this->session->set_flashdata('errors', $this->lang->line('client_edit_id_error'));
			if($cusrrole['role_id'] ==2){
			   $this->output->set_header('location:' . base_url().'client/desktop');
			}
			$this->output->set_header('location:' . base_url() . 'client/manage');
		}

		//prepare data to export to view
		$view_data = array( 'caption' => $this->lang->line( 'editclient_caption' ) );

		//get the client details by client id
		$view_data['client'] = $this->client_model->get_client_details( $this->clientid );

		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage clients'=> array('link'=>'client/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Client' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		) );

		if($cusrrole['role_id'] == 2){
			$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Client' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		    ) );
		}

		$view_data['crumbs'] = $crumbs;

		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
			//run the form validation using the rules defined in config file
			if($this->form_validation->run( 'edit_client' ) )
    		//if( isset($_POST['fName']) && !empty($_POST['fName'])  && isset($_POST['lName']) && !empty($_POST['lName']) )
			{
                // Modified the edit functionality for editing client
                $post_data = Array(
                    'fName'      => trim( $this->input->post( 'fName' ), true ),
                    //'lName'    => trim( $this->input->post( 'lName' ), true ),
                    'email'      => trim( $this->input->post( 'email', true ) ),
                    'company'    => $this->input->post('company', true),
			        'address'    => $this->input->post('address', true),
			        'city'       =>  $this->input->post('city', true),
			        'state_code' =>  $this->input->post('state_code', true),
			        'zip'        => $this->input->post('zip', true),
			        'phone'      => $this->input->post('phone', true),
                	'fax'        => $this->input->post('fax', true),
                	'sale_support_email'      => $this->input->post('sale_support_email', true),
                	'partner_support_email'   => $this->input->post('partner_support_email', true),
                	'technical_support_email' => $this->input->post('technical_support_email', true),
                	'about_us_link'           => $this->input->post('about_us_link', true),
                	'opportunity_link'        => $this->input->post('opportunity_link', true),
			        'comments'   => $this->input->post('comments', true),
                    'status'     => trim( $this->input->post( 'status', true ) ),
		    'is_mlmtype'     => trim( $this->input->post( 'is_mlmtype', true ) ),
                    'modified'   => date("Y-m-d h:i:s"),
                    'store_url'           => $this->input->post('store_url', true),
                	'consultantfee'        => $this->input->post('consultantfee', true),
                	'signupfee'        => $this->input->post('signupfee', true),
                	'billing_start_delay'        => $this->input->post('billing_start_delay', true),
			'training_link'        => $this->input->post('training_link', true),
                );

                if ( $this->client_model->update( $this->clientid, $post_data, 'clients' ) )
                {
                    $client = $this->client_model->get_client_details( $this->clientid );

					$this->session->set_flashdata('success', $this->lang->line('client_upd_success'));
					if( isset( $this->session->userdata['user']['is_admin'] ) )
					{
						$this->output->set_header('location:' . base_url() . 'client/manage');
					}
					else
					{
						$this->output->set_header('location:' . base_url() . 'client/desktop');
					}
                }
                else
                {
					$this->session->set_flashdata('success', $this->lang->line('client_updation_failed'));
					if( isset( $this->session->userdata['user']['is_admin'] ) )
					{
						$this->output->set_header('location:' . base_url() . 'client/manage');
					}
					else
					{
						$this->output->set_header('location:' . base_url() . 'client/desktop');
					}
                }
			}
        }
        //load the view normally
	//echo '<pre>';

	// $settings_detail = $this->settings_model->get_store_settings_page($this->clientid) ;
	// $view_data['settings'] = $settings_detail ;
	//print_r($settings_detail);
        $this->_vci_view('edit_client', $view_data);
	}

	
    /**
     * Download CSV
     *
     */
    function download()
    {
        $this->load->helper( 'csv_helper' );
        $this->load->model( 'clients_model' );
        $rs = $this->clients_model->get_all( '', '' );
        if ( empty( $rs ) )
        {
            $this->session->set_flashdata( 'errors', 'No client found to export' );
            redirect( base_url() . 'client/manage_registered_client' );
        }
        $clients = Array( );
        $clients[] = Array(
            'Mobile Number',
            'Email Address',
            'First Name',
            'Last Name',
            'Age',
            'City',
            'Postcode',
            'Gender',
            'Opt into Emails',
            'Profile Pic Uploaded',
            'Agree to TnC',
            'Agreed to being Contacted when winning a competition',
            'Joining Date',
        );
        foreach( $rs as $key => $value )
        {
            $clients[] = Array(
                $value['mobilenumber'],
                $value['emailid'],
                $value['firstname'],
                $value['lastname'],
                $value['age'],
                $value['city'],
                $value['postcode'],
                strtolower( $value['gender'] ) == 'male' ? 'M' : 'F',
                $value['promotion'] == 1 ? 'Yes' : 'No',
                $value['image'] == 'noimage.png' ? 'No' : 'Yes',
                $value['terms'] == 1 ? 'Yes' : 'No',
                $value['can_contact'] == 1 ? 'Yes' : 'No',
                $value['joining_date'] . 'test'
            );
        }
        array_to_csv( $clients, 'clients.csv' );
    }
    
   
    function index()
	{
		$this->_vci_layout('login');
		$this->load->library('form_validation');
		//echo 'ffkdjfkdjsf';
		//$this->client_model->getclientfromurl() ;

		//die;

		if($this->input->post('loginFormSubmitted') > 0)
		{
		    		
			if($this->form_validation->run('client_login'))
			{ 
			    if(($client = $this->client_model->get_client_details()) == false)
				{
					
					$this->session->set_flashdata('errors', $this->lang->line('error_invalid_user'));
					$this->output->set_header('location:' . $this->config->item('base_url') . 'client/index');
				} 
				else
				{
				   
					//echo '<pre>';print_r($client);die;
				    $data['first_name']	= $client->fName;
					$data['last_name']  = '';
					$data['username']	= $client->username;
					$data['email']	    = $client->email;
					$data['last_login']	= $client->last_login;
					$data['company']    = $client->company;
					$data['address']	= $client->address;
					$data['state']		= $client->state_code;
					$data['city']		= $client->city;
					$data['zip']		= $client->zip;
					$data['country']	= 'USA';
					
					$data['status']		= $client->status;
					$data['id']			= $client->id;
	                $data['controller'] = 'client';  
	                $data['edit']       = 'edit_client';  
	                $data['role_id']	= $client->role_id;        
					// set session data for future use
					$this->session->set_userdata('user',$data); // 
					
					// all data set redirect user to his desktop
					
					$this->output->set_header('location:' . $this->config->item('base_url') . 'client/desktop');
					//exit();
				}
			} else
			{
				$data['errors'] = true;
				$this->_vci_view('client_login',$data);
			}
		}
		else
		{
			$this->_vci_view('client_login');
		}
	}
	
	# Loads desktop view for admin site
	function desktop()
	{
		
		
		
		$this->_vci_layout('menu-toolbar');
		$usr = $this->session->userdata('user') ;
		// Create bread crumbs
		$crumbs = breadcrumb(array( lang('desktop') => array('link'=>'client/desktop', 'attributes' => array('title'=>'Home Title','class'=>'breadcrumb'))
		));
        //echo '<pre>';print_r($crumbs);die;
		$this->load->model('news_model');
		$this->load->model('contact_model');
		$this->load->model('area_model') ;

		//$data['users']		=	$this->user_model->count_users();
		
		$data['news'] =  intval($this->news_model->count_news_store($usr['id']));
		$data['contacts'] =  intval($this->contact_model->count_contact_store($usr['id']));
		$data['area'] =  intval($this->area_model->count_area());
		
		// assign breadcrumb to a view variable
		$data['crumbs'] = $crumbs;
		
		$client = $this->client_model->get_client_details( $usr['id'] );
	
		$data['is_mlmtype'] = $client->is_mlmtype ;
		//$this->_vci_view('client_desktop', $data);
		$this->_vci_view('client_desktop_new', $data);
		/* if($_SERVER['REMOTE_ADDR'] == ''){
			$this->_vci_view('client_desktop_new', $data);

			//$this->_vci_view('client_desktop', $data);
		}else{
			$this->_vci_view('client_desktop_new', $data);
			// $this->_vci_view('client_desktop', $data);
		}
*/

	}
    
    
    function logout()
	{
		// clear the user created data.
		$this->session->unset_userdata('client');
		// clear the system session data.
		$this->session->sess_destroy();
		// inform user about logout.
		$this->session->set_flashdata('success', $this->lang->line('logout_success'));
		$this->output->set_header('location:' . $this->config->item('base_url') . 'client/index');
	}
	
    
    
    function manage_product()
    {
        
        $this->_vci_view('manage_product', $data);
    }   
    
    function forgot_password(){
		$this->_vci_layout('login');
    	ini_set('display_errors',0) ;
    	$this->_vci_view('client_forgotpassword');
    	$this->load->helper('string');
    	$this->load->model('client_model');

    	if(!empty($_POST['email'])){
	    	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    		$rs = $this->client_model->get_clientdetailusing_email($_POST['email']) ;
	    		
	    		if(!$rs){
	    			$data['errors'] = true;
		    		$this->session->set_flashdata('errors','<li>Invalid email supplied .</li>');
					$this->output->set_header('location:' . base_url() . "client/forgot_password");	
	    		}else{
	    			
	    			$newpass = random_string('alnum',8); 
	    			$salt_value = str_random(6);
	    			
	    			#die;
	    			#print_r($_SERVER);
	    			$email = $rs->email;

	    			$data = array(
						'password' => md5($newpass)
					);
					$data = array(
						'password' => md5($newpass.md5($salt_value)),
						'password_salt' => $salt_value
					);

	    		 	// same password mechanism will run for consultant as well as client	
					$this->client_model->update_newpassword($rs->id,$data ,'') ;

					// mail sending script now 
					$this->load->library('email');
					$this->load->library('parser');
					$smtp_settings = $this->config->item('smtp');
					#echo '<pre>';
					#print_r($smtp_settings);

					$sender_from = $smtp_settings['smtp_user'];
					$sender_name = $smtp_settings['smtp_user'] ;
					$this->email->initialize( $smtp_settings );
					$this->email->from( $sender_from, $sender_name );
					$this->email->to( htmlspecialchars( $email ) );
					
					$ndata = array(
							'title' => 'Your new password',
							'base_url'=> $_SERVER['HTTP_HOST'] ,
							'base_url_name' => str_replace(array('http:','http://','//','/'), '' , $_SERVER['HTTP_HOST'] ) , 
							'CONTENT' => '<div> Your new password is : </div>'.$newpass,
							'USER'=> htmlspecialchars( ucwords( $email ) )
					);
						
					$body = $this->parser->parse('default/emails/consultant_fpassword', $ndata, true);
					
					//$this->email->cc('another@another-example.com');
					$this->email->subject('Password changed ! - New password to logon ');
					$this->email->message( $body );

					if ( $this->email->send())
					{
						$this->session->set_flashdata('success', 'New password sent to your email');
						$this->output->set_header('location: ' . base_url() . 'client/forgot_password');
					}
					else
					{	
						$this->session->set_flashdata('errors', 'Please try later mail sending failed !');
						$this->output->set_header('location: ' . base_url() . 'client/forgot_password');	
					}
					// mail sending script ends now
	    		}
	    	}else{
	    		$data['errors'] = true;
	    		$this->session->set_flashdata('errors','<li>Invalid email supplied .</li>');
				$this->output->set_header('location:' . base_url() . "client/forgot_password");	
	    	}
    	}
    	
    }

    function change_password()
	{
	    $this->_vci_layout('menu-toolbar');
		$this->load->model('client_model');
		$this->load->library('form_validation');
		$view_data['caption'] = "Change Password";
		$view_data['id'] = $this->session->userdata['user']['id'];	
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			
			'Change Password' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
				
		if($this->input->post('form_submitted',TRUE) > 0)
		{
			if($this->form_validation->run('change_password'))
			{
				$salt_value = str_random(6);
				$role_id = $this->session->userdata('user');
				$role_id = $role_id['role_id'];
				
				if($role_id==4)
				{
					$data = array(
						'password' => md5($this->input->post('new_password',TRUE))
					);
				}
				else
				{
					$data = array(
						'password' => md5($this->input->post('new_password',TRUE) . md5($salt_value)),
						'password_salt' => $salt_value
					);
				}
				
				$id = $this->session->userdata['user']['id'];
				
				if($this->client_model->update_password($id,$data))
				{
					$this->session->set_flashdata('success','<li>The password has been changed successfully.</li>');
					
					if($role_id==4)
					{
						$this->output->set_header('location:' . base_url() . "consultant/desktop");
					}
					else
					{
						$this->output->set_header('location:' . base_url() . "client/desktop");
					}
				}
				else 
				{
					$this->session->set_flashdata('errors','<li>The password has not been changed successfully.</li>');
					$this->output->set_header('location:' . base_url() . "client/desktop");										
				}
			}
			else 
			{
				$this->_vci_view('change_password_client',$view_data);
			}			
		}
		else
		{
			$this->_vci_view('change_password_client',$view_data);		
		}
	}
	
	/**
	 * Super admin can change password of client/store from super admin
	 */
	function change_password_client()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->model('client_model');
		$this->load->library('form_validation');
		$view_data['caption'] = "Change Password";
		$view_data['id'] = $this->session->userdata['user']['id'];
		$view_data['store_id'] = $this->uri->segments[3];

		$store_name_brdcrmb = 'Administrator';
		if($view_data['store_id']>0)
		{
			$store_response    = $this->client_model->get_current_store_detail($view_data['store_id']);
			$store_name_brdcrmb = $store_response->username;
		}
		
		$crumbs = breadcrumb(array(
				lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
					
				'Change Password ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
	
		if($this->input->post('form_submitted',TRUE) > 0)
		{
			if($this->form_validation->run('change_password'))
			{
				$salt_value = str_random(6);
	
				$data = array(
							'password' => md5($this->input->post('new_password',TRUE) . md5($salt_value)),
							'password_salt' => $salt_value
					);
				
	
				$id = $this->uri->segments[3];
	//die('vashisht');
				if($this->client_model->admin_client_update_password($id,$data))
				{
					$this->session->set_flashdata('success','<li>The password has been changed successfully.</li>');
					$this->output->set_header('location:' . base_url() . "client/manage");
				}
				else
				{
					$this->session->set_flashdata('errors','<li>The password has not been changed successfully.</li>');
					$this->output->set_header('location:' . base_url() . "client/change_password_admin_client/");
				}
			}
			else
			{
				$this->_vci_view('change_password_admin_client',$view_data);
			}
		}
		else
		{
			$this->_vci_view('change_password_admin_client',$view_data);
		}
	}

	/* for changing theme option */
	function update_theme_option($id = null, $status = 1, $page = 0)
	{
		//check if id was passed
		if(is_null($id))
		{
			$this->session->set_flashdata('errors', $this->lang->line('client_edit_id_error'));
			$this->output->set_header('location:' . base_url() . 'client/manage');
		}
		//update the status for the client and redirect to listing with success msg
		$result = $this->client_model->update_theme_option($id, $status);
		$this->session->set_flashdata('success', $this->lang->line('client_upd_success'));
		$this->output->set_header('location:' . base_url() . 'client/manage' . (($page>0) ? '/' . $page : ''));
	}

	function utheme(){
		if($_POST['storeid']  && $_POST['role_id']){
			$this->db->from('adminthemes') ;
			$this->db->where('user_id',$_POST['storeid'] );
			$this->db->where('role_id',$_POST['role_id'] );
			$content = $this->db->get();

			if($content->num_rows > 0 ){
				// update code
				$record = $content->result_array() ;
				$recordid = $record[0]['id'] ;
			
				$data = array(
				'theme' => htmlspecialchars($_POST['themecss']),
				'role_id'=> htmlspecialchars($_POST['role_id']),
				);
			
				$this->db->where('id', $recordid);
				$this->db->update('adminthemes', $data);

			}else{
				$data = array(
				'user_id' => htmlspecialchars($_POST['storeid']),
				'role_id'=> htmlspecialchars($_POST['role_id']),
				'theme' => htmlspecialchars($_POST['themecss']),
				);		
			
				$this->db->insert('adminthemes', $data);
			
			
			}
			echo 1  ;
			exit;
		}
	}

	function update_consultant_label(){
		//echo 'I am here';
		//echo '<pre>';
		//print_r($_POST);
		$this->load->model('settings_model');
		$store_id = $_POST['client_id'];
		$settings_detail = $this->settings_model->get_store_settings_page($store_id);
		//echo '<pre>';
		//print_r($settings_detail);
		
		if(@$settings_detail->id){
			// update case
			$data= array(
				'consultant_label' => htmlspecialchars($_POST['consultant_label']),			
			);
			$this->settings_model->update_cons_label($settings_detail->id,$data);
			return 1;
		}else{
			// insert case	
			$this->settings_model->add_settings_ajax(2,$store_id,htmlspecialchars($_POST['consultant_label']));	
			return 1;
		}
	}
}

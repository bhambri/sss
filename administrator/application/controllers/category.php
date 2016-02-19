<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Class:	client extends VCI_Controller defined in libraries
 *	Author:	Mandeep Singh
 *	Platform:	Codeigniter
 *	Company:	Cogniter Technologies
 *	Description: Manage client entity
 */
class Category extends VCI_Controller {

	var $clientid		= null; //stores current client id
	var $cat_id = null;
	var $per_page;

    /**
     * Class constructor
     */
	function Category()
	{
		// /error_reporting(0);
		parent::__construct();
		$this->load->model( 'category_model' );
		$this->load->model( 'subcategory_model');
		//$this->load->model( 'product_model' );
	}

	/**
	 *	Method: New client
	 *	Description: Add a new client.
 	 */
	function add()
	{
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');

		$store_name_brdcrmb = 'Administrator';
		if($store_id>0)
		{
			$store_response    = $this->subcategory_model->get_current_store_detail($store_id);
			$store_name_brdcrmb = $store_response->username;
		}
		
		//sets the data form exporting to view
		$view_data = array('caption' => $this->lang->line('add_new_category_caption'));
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Category Settings' => array('link'=>'category/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Add New Category ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));

		$view_data['crumbs'] = $crumbs;

		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
		    //validates the post data by using the rules defined in config file
			if($this->form_validation->run('add_category'))
			//if( isset($_POST['fName']) && !empty($_POST['fName'])  && isset($_POST['lName']) && !empty($_POST['lName']) && isset($_POST['password']) && !empty($_POST['password']) )
			{
			    $post_data = array(
			    	'store_id'  => $store_id,
			        'name'      => trim(htmlspecialchars($this->input->post('name', true))),
			        'description' => htmlspecialchars($this->input->post('description', true)),
			        'status' => htmlspecialchars($this->input->post('status', true)),
			    );
				//register the client and redirect to listing page with success msg
				if( $this->category_model->add( $post_data ) )
				{
					$this->session->set_flashdata('success', 'Add category successfully');
					$this->output->set_header('location:' . base_url() . 'category/manage');
				}
			} else
			{
				//validation comes with errors the load the view again
			
			$this->_vci_view('new_category', $view_data);
			}
		} else
		{
			//form not submitted load view normally
			$this->_vci_view('new_category', $view_data);
		}
	}

	/**
	 *	Method: is_client_exists
	 *	@param clientname string
	 *	Description: Callback method used for unique clientname check
 	 *	by form validation rules defined in config/form_validation.php
	 */
	function is_category_exists($clientname)
	{
		return (!empty($this->cat_id)) ? !$this->category_model->is_category_exists($clientname, $this->cat_id) : !$this->category_model->is_category_exists($clientname);
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
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}

		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		
		$store_name_brdcrmb = 'Administrator';
		if($store_id>0)
		{
			$store_response    = $this->subcategory_model->get_current_store_detail($store_id);
			$store_name_brdcrmb = $store_response->username;
		}
		
		//prepare the data for exporting to view
		$view_data = array('caption' => 'Category Settings');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Category Settings ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));

	    
		//set pagination configs
		$config['base_url']   = base_url() . "category/manage";
		$config['total_rows'] = intval($this->category_model->get_all_category('','',true, $store_id));
		$config['per_page']   = PAGE_LIMIT;
				
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs']     = $crumbs;
		$view_data['clients']    = $this->category_model->get_all_clients();
		$view_data['categories'] = $this->category_model->get_all_category($page,PAGE_LIMIT,false, $store_id);
		$this->_vci_view('manage_category', $view_data);
	}


	/**
	 * Method: delete_client
	 * Description: Deletes a client from database and redirect to
	 * manage_client
	 */

	function delete()
	{
	    //redirect( base_url( ) . 'client/manage' );
		$this->_vci_layout('menu-toolbar');
	
		if($this->category_model->delete())
		{
			$this->session->set_flashdata('success', 'Delete record successfully');
			$this->output->set_header('location:' . base_url() . 'category/manage');
		}
		else {
		    $this->session->set_flashdata('errors','Error in delete records');
			$this->output->set_header('location:'. base_url(). 'category/manage');
		}
	}

	/**
     * updates status of the client
     */
	function update_status($id = null, $status = 0, $table = 'category')
	{
		$this->db->where(array('id'=>$id));
		$this->db->update($table, array('status'=>$status));
		$this->session->set_flashdata('success', 'Update status successfully');
		$this->output->set_header('location:' . base_url() . 'category/manage');
		return true;
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
		//$this->load->model( 'client_model' );
		$this->load->library( 'form_validation' );
        $uri = $this->uri->uri_to_assoc(3);
        
        
        $store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
        	$store_id = $this->storeId();
        }
        
		//get clientid either from argument passed or from posted fields
		$this->cat_id = ( isset( $uri['id'] ) ) ? $uri['id'] : $this->input->post( 'id' );
		//check if client id is not empty
		if( empty( $this->cat_id ) )
		{
			$this->session->set_flashdata('errors', 'Please check the URLw');
			$this->output->set_header('location:' . base_url() . 'category/manage');
		}

		
		$store_name_brdcrmb = 'Administrator';
		if($store_id>0)
		{
			$store_response    = $this->subcategory_model->get_current_store_detail($store_id);
			$store_name_brdcrmb = $store_response->username;
		}
		
		//prepare data to export to view
		$view_data = array( 'caption' => 'Edit Category' );

		//get the client details by client id
		$view_data['category'] = $this->category_model->get_category_details( $this->cat_id );
		//set breadcrumb
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Category Settings'=> array('link'=>'category/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Category ('.$store_name_brdcrmb.')'=> array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		) );
		$view_data['crumbs'] = $crumbs;

		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
			//run the form validation using the rules defined in config file
			if($this->form_validation->run( 'add_category' ) )
    		//if( isset($_POST['fName']) && !empty($_POST['fName'])  && isset($_POST['lName']) && !empty($_POST['lName']) )
			{
                // Modified the edit functionality for editing client
                $post_data = Array(
                    'name'  => trim( $this->input->post( 'name' ), true ),
                     'description'  => trim( $this->input->post( 'description' ), true ),
                      'status'  => trim( $this->input->post( 'status' ) ),
                );

                if ( $this->category_model->update( $this->cat_id, $post_data, 'category' ) )
                {
                    $client = $this->category_model->get_category_details( $this->cat_id );

					$this->session->set_flashdata('success', 'Update category successfully');
					$this->output->set_header('location:' . base_url() . 'category/manage');
                }
                else
                {
					$this->session->set_flashdata('error', 'client updation failed' );
					$this->output->set_header('location:' . base_url() . 'category/manage');
                }
			}
        }
        //load the view normally
        $this->_vci_view('category_edit', $view_data);
	}

	
    /**
     * Download CSV
     *
     */
    function download( )
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
		$this->load->library('form_validation');
		
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
				    // 'kanav';die;
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
		// Create bread crumbs
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>null, 'attributes' => array('title'=>'Home Title','class'=>'breadcrumb'))
		));

		$this->load->model('news_model');
		$this->load->model('contact_model');
		$this->load->model('area_model') ;

		//$data['users']		=	$this->user_model->count_users();
		
		$data['news'] =  intval($this->news_model->count_news());
		$data['contacts'] =  intval($this->contact_model->count_contact());
		$data['area'] =  intval($this->area_model->count_area());
		
		// assign breadcrumb to a view variable
		$data['crumbs'] = $crumbs;
		$this->_vci_view('client_desktop', $data);

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
}

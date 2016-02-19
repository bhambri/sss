<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin extends VCI_Controller defined in libraries
 * Manage access to admin by admin users, performs authentication etc.
 *
 * @author 
 */

class Attributesets extends VCI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('subcategory_model');
		$this->load->model('attributeset_model');
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
		$view_data = array('caption' => 'Add new attribute set');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Product Attribute Set' => array('link'=>'attributesets/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Add New Attribute Set ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));

		$view_data['crumbs'] = $crumbs;

		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
		    //validates the post data by using the rules defined in config file
			if($this->form_validation->run('add_attributeset'))
			{
			    $post_data = array(
			    	'store_id'  => $store_id,
			        'name'      => trim(htmlspecialchars(strtolower($this->input->post('name', true)))),
			        'description' => htmlspecialchars($this->input->post('description', true)),
			        'status' => htmlspecialchars($this->input->post('status', true)),
			    );
				//register the client and redirect to listing page with success msg
				if( $this->attributeset_model->add( $post_data ) )
				{
					$this->session->set_flashdata('success', 'Attribute set added successfully');
					$this->output->set_header('location:' . base_url() . 'attributesets/manage');
				}
			} else
			{
				//validation comes with errors the load the view again
			
			$this->_vci_view('attributeset_add', $view_data);
			}
		} else
		{
			//form not submitted load view normally
			$this->_vci_view('attributeset_add', $view_data);
		}
	}


	function option_add()
	{
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
	    //redirect( base_url( ) . 'client/manage' );
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		$attributesetid = $this->session->userdata('categoryId');
		// get store username and category name for breadcrumb
		$store_response    = $this->subcategory_model->get_current_store_detail($store_id);
		$atttrset_response = $this->attributeset_model->get_attributeset_details($attributesetid);

		//sets the data form exporting to view
		$view_data = array('caption' => 'Add Attribute set option');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Product Attribute set' => array('link'=>'attributesets/manage_options', 'attributes' => array('class'=>'breadcrumb')),
			'Add Attribute set option ('.$store_response->username.' - '.ucwords($atttrset_response->name).')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['attributesets']    = $this->attributeset_model->get_all_attributeset_dropdownlist($store_id);
		$view_data['crumbs'] = $crumbs;
		$view_data['curr_session_cat_id'] = $atttrset_response->id;
		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{

		    /*
		    [field_label] => choose color
		    [attribute_set_id] => 2
		    [field_type] => radio
		    [no_of_options] => 3
		    [options_name] => Array
		        (
		            [0] => red color
		            [1] => Blue color
		            [2] => green color
		        )

		    [add] => Submit
		    [formSubmitted] => 1
		   
		    die; */
		    //validates the post data by using the rules defined in config file
			if($this->form_validation->run('attribute_option_add'))
			//if( isset($_POST['fName']) && !empty($_POST['fName'])  && isset($_POST['lName']) && !empty($_POST['lName']) && isset($_POST['password']) && !empty($_POST['password']) )
			{
			    $post_data = array(
			    	'attribute_set_id' => $this->input->post('attribute_set_id'),
			        'field_type'      => trim(htmlspecialchars(strtolower($this->input->post('field_type', true)))),
			        'field_label' => htmlspecialchars($this->input->post('field_label', true)),
			        'required' => $this->input->post('required'),
			    );
				//register the client and redirect to listing page with success msg
				$optionid = $this->attributeset_model->add_option( $post_data ) ;
				if( $optionid )
				{
					// handle the case for select box, check , radio option
					if(($_POST['field_type'] == 'radio') || ($_POST['field_type'] == 'selectbox') || ($_POST['field_type'] == 'checkbox')){

						foreach ($_POST['options_name'] as $key => $opvalue) {
							# code...
							if($opvalue != ''){
								$optpostdata = array('option_value'=>$opvalue,
								'attribute_set_field_id' => $optionid,
								'option_price' => $_POST['options_price'][$key],
								) ;
								$this->attributeset_model->add_option_details( $optpostdata ) ;
								$optpostdata = array() ;
							}
						}
					}
					$this->session->set_flashdata('success', 'Attribute set option added successfully');
					$this->output->set_header('location:' . base_url() . 'attributesets/manage_options');
				}
			} else
			{
				//validation comes with errors the load the view again
				$this->_vci_view('attributeset_option_add', $view_data);
			}
		} else
		{
			//form not submitted load view normally
			$this->_vci_view('attributeset_option_add', $view_data);
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
		return (!empty($this->cat_id)) ? !$this->attributeset_model->is_attributeset_exists($clientname, $this->cat_id) : !$this->attributeset_model->is_attributeset_exists($clientname);
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
		$view_data = array('caption' => 'Manage Product Attribute set');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Product Attribute set ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));

	    
		//set pagination configs
		$config['base_url']   = base_url() . "attributesets/manage";
		$config['total_rows'] = intval($this->attributeset_model->get_all_attributeset('','',true, $store_id));
		$config['per_page']   = PAGE_LIMIT;
				
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs']     = $crumbs;
		$view_data['clients']    = $this->attributeset_model->get_all_clients();
		$view_data['attributesets'] = $this->attributeset_model->get_all_attributeset($page,PAGE_LIMIT,false, $store_id);
		$this->_vci_view('manage_attributeset', $view_data);
	}

	/* fr listing out a particular mange option set */
	function manage_options($page = 0)
	{
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		$attributesetid = $this->session->userdata('categoryId');
		
		// get store username and category name for breadcrumb
		$store_response    = $this->subcategory_model->get_current_store_detail($store_id);
		$category_response = $this->attributeset_model->get_attributeset_details($attributesetid);
		
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		
		//prepare the data for exporting to view
		$view_data = array('caption' => 'Manage Product Attribute set option');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Product Attribute set' => array('link'=>'attributesets/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Attribute set Options ('.$store_response->username.' - '.ucwords($category_response->name).')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb'))
		));

		//set pagination configs
		$config['base_url']   = base_url() . "attributesets/manage_options";
		$config['total_rows'] = intval($this->attributeset_model->get_all_attributeset_options('','',true, $attributesetid));
		$config['per_page']   = PAGE_LIMIT;

		$this->pagination->initialize($config);

		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs']     = $crumbs;
		//fetch all clients from database
		$view_data['attributeset_options']    = $this->attributeset_model->get_all_attributeset_options($page, PAGE_LIMIT, false, $attributesetid);
		//echo "<pre>";print_r($view_data['clients']);die;
		$this->_vci_view('manage_attributeset_options', $view_data);
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
		
		if($this->attributeset_model->delete())
		{
			$this->session->set_flashdata('success', 'Record deleted successfully');
			$this->output->set_header('location:' . base_url() . 'attributesets/manage');
		}
		else {
		    $this->session->set_flashdata('errors','Error in deleting records');
			$this->output->set_header('location:'. base_url(). 'attributesets/manage');
		}
	}

	function delete_option(){
		$this->_vci_layout('menu-toolbar');
		
		if($this->attributeset_model->delete_option())
		{
			$this->session->set_flashdata('success', 'Record deleted successfully');
			$this->output->set_header('location:' . base_url() . 'attributesets/manage_options');
		}
		else {
		    $this->session->set_flashdata('errors','Error in deleting records');
			$this->output->set_header('location:'. base_url(). 'attributesets/manage_options');
		}
	}

	/**
     * updates status of the client
     */
	function update_status($id = null, $status = 0, $table = 'attribute_sets')
	{
		$this->db->where(array('id'=>$id));
		$this->db->update($table, array('status'=>$status));
		$this->session->set_flashdata('success', 'Status updated successfully');
		$this->output->set_header('location:' . base_url() . 'attributesets/manage');
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
			$this->output->set_header('location:' . base_url() . 'attributesets/manage');
		}

		
		$store_name_brdcrmb = 'Administrator';
		if($store_id>0)
		{
			$store_response    = $this->subcategory_model->get_current_store_detail($store_id);
			$store_name_brdcrmb = $store_response->username;
		}
		
		//prepare data to export to view
		$view_data = array( 'caption' => 'Edit Attribute Set' );

		//get the client details by client id
		$view_data['attributeset'] = $this->attributeset_model->get_attributeset_details( $this->cat_id );
		//set breadcrumb
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Attribute Set'=> array('link'=>'attributesets/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Attribute Set ('.$store_name_brdcrmb.')'=> array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		) );
		$view_data['crumbs'] = $crumbs;

		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
			//run the form validation using the rules defined in config file
			if($this->form_validation->run( 'add_attributeset' ) )
    		//if( isset($_POST['fName']) && !empty($_POST['fName'])  && isset($_POST['lName']) && !empty($_POST['lName']) )
			{
                // Modified the edit functionality for editing client
                $post_data = Array(
                    'name'  => trim( strtolower($this->input->post( 'name' )), true ),
                    'description'  => trim( $this->input->post( 'description' ), true ),
                    'status'  => trim( $this->input->post( 'status' ) ),
                );

                if ( $this->attributeset_model->update( $this->cat_id, $post_data, 'attribute_sets' ) )
                {
                    $client = $this->attributeset_model->get_attributeset_details( $this->cat_id );

					$this->session->set_flashdata('success', 'Attribute set updated successfully');
					$this->output->set_header('location:' . base_url() . 'attributesets/manage');
                }
                else
                {
					$this->session->set_flashdata('error', 'client updation failed' );
					$this->output->set_header('location:' . base_url() . 'attributesets/manage');
                }
			}
        }
        //load the view normally
        $this->_vci_view('attributeset_edit', $view_data);
	}

	function option_edit($id=''){
		ini_set('display_errors',0);
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
	    //redirect( base_url( ) . 'client/manage' );
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$uri = $this->uri->uri_to_assoc(3);
		#echo '<pre>';
		#print_r($uri);
		$attributefield = ( isset( $uri['id'] ) ) ? $uri['id'] : $this->input->post('id'); 
		$attributesetid = $this->session->userdata('categoryId');
		// get store username and category name for breadcrumb
		$store_response    = $this->subcategory_model->get_current_store_detail($store_id);
		$atttrset_response = $this->attributeset_model->get_attributeset_details($attributesetid);
		$attributefields = $this->attributeset_model->get_attributesetfield_detail($attributefield) ;

		#echo '<pre>';
		#print_r($attributefields);
		$fieldsoptiondetail =  array() ;
		$fieldsoptiondetailprice = array() ;
		if(($attributefields->field_type == 'radio') || ($attributefields->field_type == 'selectbox') || ($attributefields->field_type == 'checkbox')){
			// list out availble options
			//echo $attributefields->id ;
			$attributefieldoptdetail = $this->attributeset_model->get_attributesetfield_option_detail($attributefield) ;
			//echo '<pre>';
			//print_r($attributefieldoptdetail);
			if($attributefieldoptdetail){
				foreach ($attributefieldoptdetail as $key => $value) {
					# code...
					$fieldsoptiondetail[$value->id] = $value->option_value ;
					$fieldsoptiondetailprice[$value->id] = $value->option_price ;
				}
			}
			
		}
		if(count($fieldsoptiondetail) > 0 ){
			$option_count = count($fieldsoptiondetail) ;
		}
		#echo '<pre>';
		#print_r($fieldsoptiondetail);
		//sets the data form exporting to view
		$view_data = array('caption' => 'Add Attribute set option');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Attribute set' => array('link'=>'attributesets/manage_options', 'attributes' => array('class'=>'breadcrumb')),
			'Add Attribute set option ('.$store_response->username.' - '.ucwords($atttrset_response->name).')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['attributesets']    = $this->attributeset_model->get_all_attributeset_dropdownlist($store_id);
		$view_data['crumbs'] = $crumbs;
		$view_data['curr_session_cat_id'] = $atttrset_response->id;

		$view_data['attribute_set_field'] = $attributefields ;
		$view_data['attribute_set_field_details'] = $fieldsoptiondetail ;
		$view_data['attribute_set_field_details_price'] = $fieldsoptiondetailprice ;
		$view_data['no_of_options'] = count($fieldsoptiondetail) ;

		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
		    /* echo '<pre>';
		    print_r($_POST);
		    die; */
		    /*
		    [field_label] => Attribute set option two
		    [attribute_set_id] => 2
		    [field_type] => radio
		    [no_of_options] => 4
		    [options_name] => Array
		        (
		            [4] => radiobb14545
		            [5] => radio 2
		            [6] => radio 3
		        )

		    [add] => Submit
		    [formSubmitted] => 1 
		    die; */
		    //validates the post data by using the rules defined in config file
			if($this->form_validation->run('attribute_option_add'))
			//if( isset($_POST['fName']) && !empty($_POST['fName'])  && isset($_POST['lName']) && !empty($_POST['lName']) && isset($_POST['password']) && !empty($_POST['password']) )
			{
			    $post_data = array(
			    	'attribute_set_id' => $this->input->post('attribute_set_id'),
			        'field_type'      => trim(htmlspecialchars(strtolower($this->input->post('field_type', true)))),
			        'field_label' => htmlspecialchars($this->input->post('field_label', true)),
			        'required' => $this->input->post('required'),
			    );
				//register the client and redirect to listing page with success msg
				$optionid = $this->attributeset_model->update( $attributefield ,$post_data ,'attribute_set_fields') ;
				if( $optionid )
				{
					// handle the case for select box, check , radio option
					$attribute_set_field_details = $this->attributeset_model->get_attribute_set_field_details($attributefield) ;
					#echo '<pre>';  
					#print_r($attribute_set_field_details) ;
					#die;

					if(($_POST['field_type'] == 'radio') || ($_POST['field_type'] == 'selectbox') || ($_POST['field_type'] == 'checkbox')){

						foreach ($_POST['options_name'] as $key => $opvalue){
							/* echo '<pre>';
							print_r($key);
							print_r($opvalue);
							die; */
							# code...
							
							if($opvalue != ''){
								$optpostdata = array(
									'option_value' => $opvalue,
									'option_price' => $_POST['options_price'][$key],
									'attribute_set_field_id' => $attributefield,
								) ;
								/* echo '<pre>';
								print_r($optpostdata) ;
								die;
								*/
								if(in_array($key , $attribute_set_field_details)){
									$this->attributeset_model->update( $key ,$optpostdata ,'attribute_set_field_details' ) ;
								}else{
									$this->attributeset_model->add_option_details( $optpostdata ) ;
								}
								$optpostdata = array() ;
							}
						}
						#die('Abhishek');
					}else{
						$this->attributeset_model->delete_attribute_set_field_details($attributefield) ;
					}
					#die('Abhishek srrr');
					$this->session->set_flashdata('success', 'Attribute set option updated successfully');
					$this->output->set_header('location:' . base_url() . 'attributesets/manage_options');
				}
			} else
			{
				//validation comes with errors the load the view again
				$this->_vci_view('attributeset_option_add', $view_data);
			}
		} else
		{
			//form not submitted load view normally
			#echo '<pre>';
			#print_r($view_data);

			$this->_vci_view('attributeset_option_add', $view_data);
		}
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

	function remove_attr_opt($id){
		#echo '<pre>';
		#print_r($_SERVER['HTTP_REFERER']);
		#die;
		if($this->attributeset_model->delete_attribute_set_field_detail_opt($id))
		{
			$this->session->set_flashdata('success', 'Record deleted successfully');
			$this->output->set_header('location:' .$_SERVER['HTTP_REFERER']);
		}
		else {
		    $this->session->set_flashdata('errors','Error in deleting records');
			$this->output->set_header('location:' .$_SERVER['HTTP_REFERER']);
		}
	}

	function assign_attribute($id){
		$this->load->model('client_product_model') ;
		#echo 'Assign the attribute set to supplied id ';
		#echo $id ;
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		
		// get store username and category name for breadcrumb
		$store_response    = $this->subcategory_model->get_current_store_detail($store_id);
		$client_product = $this->client_product_model->get_client_product_details( $id);
		if(!$client_product){
			$this->session->set_flashdata('errors','Invalid Url');
			$this->output->set_header('location:' . $this->config->item('base_url') . 'client/desktop');
		}
		
		$assAttributeArr  = $this->attributeset_model->get_assigned_attributesettoproduct($client_product->id);
		#print_r($assAttributeArr);
		$assAttrOpt = array() ;
		if(!empty($assAttributeArr)){
			foreach($assAttributeArr as $optionAttr){
				$assAttrOpt[] = $optionAttr->attribute_set_id ;
			}
		}
		
		
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		
		//prepare the data for exporting to view
		$view_data = array('caption' => 'Assign Attribute set option');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manange Products' => array('link'=>'product/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Assign Attribute set option ('.$store_response->username.' - '.ucwords($client_product->product_title).')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb'))
		));

		
		$view_data['productid']  = $id;
		$view_data['crumbs']     = $crumbs;

		//get_all_attributeset_dropdown
		$view_data['attributeset_options']  = $this->attributeset_model->get_all_attributeset_dropdownlist($store_id);
		$view_data['assigned_attribute']    = $assAttrOpt ;

		#echo "<pre>";
		#print_r($view_data);
		#die;
		$this->_vci_view('assign_attribute_option', $view_data);

	}

	function removefromprod($attributeid,$prodid){
		
		if($this->attributeset_model->unassign_attributeset($attributeid,$prodid))
		{
			$this->session->set_flashdata('success', 'Attribute removed successfully');
			$this->output->set_header('location:' .$_SERVER['HTTP_REFERER']);
		}
		else {
		    $this->session->set_flashdata('errors','Error in removing records');
			$this->output->set_header('location:' .$_SERVER['HTTP_REFERER']);
		}
	}

	function assigntoprod($attributeid,$prodid){
		if($this->attributeset_model->assign_attributeset($attributeid,$prodid))
		{
			$this->session->set_flashdata('success', 'Attribute set assigned successfully');
			$this->output->set_header('location:' .$_SERVER['HTTP_REFERER']);
		}
		else {
		    $this->session->set_flashdata('errors','Error in deleting records');
			$this->output->set_header('location:' .$_SERVER['HTTP_REFERER']);
		}
	}

}

/* End of file admin.php */
/* Location: ./system/application/controllers/admin.php */

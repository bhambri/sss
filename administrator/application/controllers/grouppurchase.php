<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Class:	Grouppurchase extends VCI_Controller defined in libraries
 *	Author:	
 *	Platform:	Codeigniter
 *	Company:	Cogniter Technologies
 *	Description: mange Grouppurchase
 */
class Grouppurchase extends VCI_Controller {

	var $clientid		= null; //stores current client id
	var $cat_id = null;
	var $per_page;

    /**
     * Class constructor
     */
	function Grouppurchase()
	{
		error_reporting(0);
		parent::__construct();
		$this->load->model( 'category_model' );
		$this->load->model( 'subcategory_model');
		$this->load->model( 'common_model');
		$this->load->model( 'grouppurchase_model');
		$this->load->helper('resize');
		//$this->load->model( 'product_model' );
	}

	

	/**
	 *	Method: is_client_exists
	 *	@param clientname string
	 *	Description: Callback method used for unique clientname check
 	 *	by form validation rules defined in config/form_validation.php
	 */
	function callback_is_subcategory_exists($clientname)
	{
		return (!empty($this->cat_id)) ? !$this->subcategory_model->is_subcategory_exists($clientname, $this->cat_id) : !$this->subcategory_model->is_subcategory_exists($clientname);
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
	function manage($page = 0,$q_s=null,$startdate="", $enddate ="")
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		$this->load->model('sales_model');
		
		//prepare the data for exporting to view
		$view_data = array('caption' => 'Manage Parties');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Parties' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));


		$table = 'grouppurchase';
		//set pagination configs
		
		$view_data['crumbs']     = $crumbs;

		$store_id = $this->session->userdata('storeId');
        
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }
				
		if( !isset($store_id) && empty($store_id) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }

		$userDetails = $this->session->userdata("user");
		
		if( $userDetails['role_id'] == 4 )
		{	
			$consultantId = $userDetails['id'];	
		}
		else
		{
			$consultantId = $this->session->userdata('consultantId');
			$consultantId = '';
			if( $this->session->userdata('consultant_user_id')> 0 )
			{
				$consultantId = $this->session->userdata('consultant_user_id');
			}

		}

		if($this->input->get('from_date')){
			$startdate = $this->input->get('from_date');
			$view_data['fromdate'] = $startdate ;
		}
		if($this->input->get('to_date')){
			$enddate = $this->input->get('to_date');
			$view_data['todate'] = $enddate ;
		}

		ini_set('display_errors',1);
		$date_from = "";
		$date_to = "" ;
		if($startdate == "" && $enddate== ""){
			$current_month      = date('m', time());
			$current_year       = date('Y', time());
			if( $this->session->userdata('sales_report_duration')=='week' )
			{
				$source_date         = Date('d-m-Y', strtotime("Last Sunday"));
				$source_date_time_ms = strtotime($source_date." 00:00:00");
					
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
			else if( $this->session->userdata('sales_report_duration')=='month' )
			{
				$source_date         = "01-".$current_month."-".$current_year;
				$source_date_time_ms = strtotime($source_date." 00:00:00");
			
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
			else if( $this->session->userdata('sales_report_duration')=='year' )
			{
				$source_date         = "01-01-".$current_year;
				$source_date_time_ms = strtotime($source_date." 00:01:00");
			
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}else{
				// default should be weekly, As per comment by client
				$source_date         = Date('d-m-Y', strtotime("Last Sunday"));
				$source_date_time_ms = strtotime($source_date." 00:00:00");
					
				$date_from = $source_date_time_ms;
				$date_to   = time();

				$this->session->set_userdata('sales_report_duration','week') ;
			}
				
		}else{
			if($startdate !=''){
				$date_from = str_replace('/','-',$startdate) ;
				$date_from = strtotime($date_from." 00:00:00");
				
			}
			
			if($enddate !=''){
				$date_to = str_replace('/','-',$enddate) ;
				$date_to = strtotime($date_to." 00:00:00");
			}
			
		}

		
		//$qstr = "" ;
		//$getData = array('s'=>$qstr);
		$getData = array('from_date'=>$startdate ,'to_date'=>$enddate,'submit'=>'Filter');

		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");

		$config['first_url'] = base_url() . "grouppurchase/manage?page=&from_date=".$startdate."&to_date=".$enddate;
		$config['base_url'] = base_url() . "grouppurchase/manage";
		$config['total_rows'] = intval($this->grouppurchase_model->get_all_group_report('','',true,$store_id,$consultantId,$date_from,$date_to));
		$config['per_page']   = PAGE_LIMIT;

		$this->pagination->initialize($config);

		$view_data['pagination'] = $this->pagination->create_links();

		$view_data['groups']      = $this->grouppurchase_model->get_all_group_report($page, PAGE_LIMIT, FALSE, $store_id, $consultantId ,$date_from,$date_to);
		$view_data['clients_consultant'] = $this->grouppurchase_model->all_clients_consultant();

		$view_data['consultant'] = $this->sales_model->get_all_consultant_from_current_store($store_id);

		if(isset($this->session->userdata))
		{
			$cons_role_id = $this->session->userdata('user');
			$view_data['consultant_role_id'] = $cons_role_id['role_id'];
		}
		
		$this->_vci_view('grouppurchase_manage', $view_data);
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
	
		if($this->common_model->delete( $table = 'grouppurchase', $field = 'id', $ids = $this->input->post('ids')  ) )
		{
			$this->session->set_flashdata('success', 'Delete record successfully');
			$this->output->set_header('location:' . base_url() . 'grouppurchase/manage');
		}
		else {
		    $this->session->set_flashdata('errors','Error in delete records');
			$this->output->set_header('location:'. base_url(). 'grouppurchase/manage');
		}
	}

	/**
     * updates status of the client
     */
	function update_status($id = null, $status = 0, $table = 'grouppurchase')
	{
		$this->db->where(array('id'=>$id));
		$this->db->update($table, array('status'=>$status));//echo $this->db->last_query(); die;
		$this->session->set_flashdata('success', 'Update status successfully');
		$this->output->set_header('location:' . base_url() . 'grouppurchase/manage');
		return true;
	}



	/**
	 *	Method: New client
	 *	Description: Add a new client.
 	 */
	function add()
	{	
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$this->load->library('upload');

		//sets the data form exporting to view
		$view_data = array('caption' => 'Add Party');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Party' => array('link'=>'grouppurchase/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Add New Party' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//prepare data to export to view
		$currentUserdetail = $this->session->userdata('user') ;

		$where_data = array( 'role_id' => 3, 'status' => 1  );  // 3 role id for normal user
		
		// in case of consultant store_id to select that store users only
		if(isset($currentUserdetail['store_id']) && ($currentUserdetail['store_id']!=0) )
		{
			$where_data['store_id'] = $currentUserdetail['store_id'] ;
		}

		// in case of admin-client login id is itself a store id , to select that store users only
		if(isset($currentUserdetail['role_id']) && ($currentUserdetail['role_id'] ==2 ) )
		{
			$where_data['store_id'] = $currentUserdetail['id'] ;
		}

		$view_data['users'] = $this->common_model->findWhere( 'users', $where_data );

		$view_data['crumbs'] = $crumbs;
		
		$this->load->helper('string');
		$view_data['random_code'] = random_string('alnum', 8);
		
		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{	
			$filepath = '' ;
		    if(!empty($_FILES['image'])){
				$config['upload_path'] = '../uploads';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '10000';
				$config['max_width']  = '2024';
				$config['max_height']  = '768';

				$this->upload->initialize($config);
				if( ! $this->upload->do_upload('image')){
					// invalid image type 
					$error = array('error' => $this->upload->display_errors());
				}else{
					$uploadedData = $this->upload->data() ;
					$filepath = '/uploads/'.$uploadedData['file_name'] ;
				}
				
			}

			if(! $this->upload->display_errors() || ($this->upload->display_errors() == '<p>You did not select a file to upload.</p>' ))
			{
				//validates the post data by using the rules defined in config file
				if($this->form_validation->run('add_grouppurchase'))
				//if( isset($_POST['fName']) && !empty($_POST['fName'])  && isset($_POST['lName']) && !empty($_POST['lName']) && isset($_POST['password']) && !empty($_POST['password']) )
				{

					$user = $this->session->userdata('user');
				    $post_data = array(
				    	'host_id' 		=> $this->input->post('host_id'),
				        'name'      	=> htmlspecialchars($this->input->post('name', true)),
				        'description' 	=> htmlspecialchars($this->input->post('description', true)),
				        'location' 		=> htmlspecialchars($this->input->post('location')),
				        'start_date' 	=> htmlspecialchars($this->input->post('start_date')),
				        'end_date' 		=> htmlspecialchars($this->input->post('end_date')),
				        'status' 		=> htmlspecialchars($this->input->post('status')),
				        'store_id'		=> $user['store_id'],
				        'consultant_id'	=> $user['id'],
				        'status' 		=> htmlspecialchars($this->input->post('status')),
				        'image'			=> $filepath,
				        'group_event_code' => htmlspecialchars($this->input->post('group_event_code')),
				    );
					//register the client and redirect to listing page with success msg
					if( $this->common_model->add( 'grouppurchase', $post_data ) )
					{
						$this->session->set_flashdata('success', 'Party added successfully');
						$this->output->set_header('location:' . base_url() . 'grouppurchase/manage');
					}
				} else
				{
					//validation comes with errors the load the view again
					$this->_vci_view('grouppurchase_add', $view_data);
				}
			}else{
				// Needed to display extra erroors also
				//validation comes with errors the load the view again
				$this->_vci_view('grouppurchase_add', $view_data);
			}
		    
		} else
		{
			//form not submitted load view normally
			$this->_vci_view('grouppurchase_add', $view_data);
		}
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
		$this->load->library('upload');
		
        $uri = $this->uri->uri_to_assoc(3);
        
		//get clientid either from argument passed or from posted fields
		$this->cat_id = ( isset( $uri['id'] ) ) ? $uri['id'] : $this->input->post( 'id' );
		//check if client id is not empty
		if( empty( $this->cat_id ) )
		{
			$this->session->set_flashdata('errors', 'Please check the URL');
			$this->output->set_header('location:' . base_url() . 'grouppurchase/manage');
		}

		//prepare data to export to view
		$currentUserdetail = $this->session->userdata('user') ;

		$where_data = array( 'role_id' => 3, 'status' => 1  );  // 3 role id for normal user
		
		// in case of consultant store_id to select that store users only
		if(isset($currentUserdetail['store_id']) && ($currentUserdetail['store_id']!=0) )
		{
			$where_data['store_id'] = $currentUserdetail['store_id'] ;
		}

		// in case of admin-client login id is itself a store id , to select that store users only
		if(isset($currentUserdetail['role_id']) && ($currentUserdetail['role_id'] ==2 ) )
		{
			$where_data['store_id'] = $currentUserdetail['id'] ;
		}


		$view_data = array( 'caption' => 'Edit Party' );
		
		$view_data['hosts'] = $this->common_model->findWhere( 'users', $where_data );
		
		$view_data['grouppurchase'] = $this->common_model->findWhere( $table = 'grouppurchase', array( 'id' => $this->cat_id ), $multi_record = FALSE, $order = '' );
		
		//set breadcrumb
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Party'=> array('link'=>'grouppurchase/manage', 'attributes' => array('class'=>'breadcrumb')),
			//lang('editclient_caption') => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		) );
		$view_data['crumbs'] = $crumbs;

		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
			//run the form validation using the rules defined in config file
			if($this->form_validation->run( 'add_grouppurchase' ) )
    		//if( isset($_POST['fName']) && !empty($_POST['fName'])  && isset($_POST['lName']) && !empty($_POST['lName']) )
			{
                // Modified the edit functionality for editing client
                
                $filepath = htmlspecialchars($this->input->post('event_image')) ;
			    if(!empty($_FILES['image'])){
					$config['upload_path'] = '../uploads';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '10000';
					$config['max_width']  = '2024';
					$config['max_height']  = '768';

					$this->upload->initialize($config);
					if( ! $this->upload->do_upload('image')){
						// invalid image type 
						$error = array('error' => $this->upload->display_errors());
					}else{
						$uploadedData = $this->upload->data() ;
						$filepath = '/uploads/'.$uploadedData['file_name'] ;
					}
					
				}

				if(! $this->upload->display_errors() || ($this->upload->display_errors() == '<p>You did not select a file to upload.</p>' ))
				{	
					$post_data = array(
				    	'host_id' 		=> $this->input->post('host_id'),
				        'name'      	=> htmlspecialchars($this->input->post('name', true)),
				        'description' 	=> htmlspecialchars($this->input->post('description', true)),
				        'location' 		=> htmlspecialchars($this->input->post('location')),
				        'start_date' 	=> htmlspecialchars($this->input->post('start_date')),
				        'end_date' 		=> htmlspecialchars($this->input->post('end_date')),
				        'status' 		=> htmlspecialchars($this->input->post('status')),
				        'store_id'		=> ((int) $this->input->post('store_id')) != 0 ? htmlspecialchars($this->input->post('store_id')) : $user['store_id'],
				        'consultant_id'	=> ((int) $this->input->post('consultant_id')) != 0 ? htmlspecialchars($this->input->post('consultant_id')) : $user['id'],
				        'status' 		=> htmlspecialchars($this->input->post('status')),
				        'image'			=> $filepath,
					    'group_event_code' => htmlspecialchars($this->input->post('group_event_code')),
				    );

					if ( $this->subcategory_model->update( $this->cat_id, $post_data, 'grouppurchase' ) )
	                {
	                   // $client = $this->subcategory_model->get_subcategory_details( $this->cat_id );

						$this->session->set_flashdata('success', 'Party updated successfully');
						$this->output->set_header('location:' . base_url() . 'grouppurchase/manage');
	                }
	                else
	                {
						$this->session->set_flashdata('error', 'Party updation failed' );
						$this->output->set_header('location:' . base_url() . 'grouppurchase/manage');
	                }	
				}else{
					// updation failed
					$this->session->set_flashdata('error', 'Party updation failed' );
					$this->output->set_header('location:' . base_url() . 'grouppurchase/manage');
				}
                
			}
        }
        //load the view normally
        $this->_vci_view('grouppurchase_edit', $view_data);
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
		
		$data['news'] =  intval($this->news_model->count_news());
		$data['contacts'] =  intval($this->contact_model->count_contact());
		$data['area'] =  intval($this->area_model->count_area());
		
		// assign breadcrumb to a view variable
		$data['crumbs'] = $crumbs;
		$this->_vci_view('client_desktop', $data);

	}

	function sendemails($group_id){
		//echo $group_id;
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->model('grouppurchase_model');
		//sets the data form exporting to view
		$view_data = array('caption' => 'Send Emails');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Party' => array('link'=>'grouppurchase/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Send Emails' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		$view_data['group_purchaseid'] = $group_id;
		if($this->input->post('formSubmitted') > 0){
			$emails = $this->input->post('emails') ;
			$emailArr =  explode(',',$emails);
			$group_purchaseid = $this->input->post('group_purchaseid') ;
			$groupDetails = $this->common_model->findWhere( $table = 'grouppurchase', array( 'id' => $group_purchaseid ), FALSE, '' );
			
			if(count($emailArr) > 0 && $emailArr[0]!='' && !empty($groupDetails)){
				foreach($emailArr as $newEmail){
					//echo '<pre>';
					//print_r($newEmail);
					if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
					$this->sendEmailsNow($groupDetails['store_id'] ,$groupDetails['consultant_id'],$newEmail,$group_purchaseid);
					}else{
					$this->session->set_flashdata('success', 'Party invitation failed, Invalid email');
					$this->output->set_header('location:' . base_url() . 'grouppurchase/manage');
					}
					//die;
				}
				$this->session->set_flashdata('success', 'Party invitation sent');
				$this->output->set_header('location:' . base_url() . 'grouppurchase/manage');
			}else{
				//no emails suplied 
				$this->session->set_flashdata('success', 'Party invitation failed');
				$this->output->set_header('location:' . base_url() . 'grouppurchase/manage');

			}
			//die;		
		}
		$this->_vci_view('grouppurchase_sendemail', $view_data);
		//die('Nw names are going there');
	}

	/* send email */
	
	function sendEmailsNow($store_id ,$cons_id,$emailn,$group_purchaseid){
	
	$this->load->model('consultant_model');
	$this->load->model('grouppurchase_model');

	$response_store = $this->consultant_model->get_detail_current_store( $store_id );
	$store_username = $response_store[0]->username;
//echo '<pre>';
//print_r($response_store);
//die;
	$response_sender = $this->consultant_model->get_invitation_sender_detail($cons_id);
	$email_from = $response_sender[0]->email;
	$email_name = $response_sender[0]->username;
	//register the client and redirect to listing page with success msg
	$groupDetails = $this->grouppurchase_model->getgroupevent_detail($group_purchaseid) ;

	$groupDetails_host = $groupDetails[0]['username'];
	$groupDetails_name = $groupDetails[0]['name'];
	$groupDetails_description = $groupDetails[0]['description'];
	$groupDetails_location = $groupDetails[0]['location'];

	$groupDetails_start_date = $groupDetails[0]['start_date'];
	$groupDetails_end_date = $groupDetails[0]['end_date'];

	$groupDetails_image = $groupDetails[0]['image'];
	$groupDetails_group_event_code = $groupDetails[0]['group_event_code'];

	$htmlNow   = '<div>HOST NAME :'.$groupDetails_host.'</div>';
	$htmlNow  .= '<div>PARTY NAME :'.$groupDetails_name.'</div>';
	$htmlNow  .= '<div>PARTY LOCATION :'.$groupDetails_location.'</div>';
	$htmlNow  .= '<div>PARTY START DATE :'.$groupDetails_start_date.'</div>';
	$htmlNow  .= '<div>PARTY END DATE :'.$groupDetails_end_date.'</div>';
	$htmlNow  .= '<div>PARTY CODE :'.$groupDetails_group_event_code.'</div>';
	$htmlNow  .= '<div>PARTY DESCRIPTION :'.$groupDetails_description.'</div>';
	$htmlNow  .= '<div> <IMG src='.$_SERVER['HTTP_HOST'].'/'.$groupDetails_image.'</img></div>';


	$this->load->library('email');
	$this->load->library('parser');
	$smtp_settings = $this->config->item('smtp');
	
	$sender_from = $email_from;
	$sender_name = $email_name ;
	$this->email->initialize( $smtp_settings );
	$this->email->from( $sender_from, $sender_name );
	$this->email->to( $emailn );
	
	$ndata = array(
			'title' => 'Party Invitation',
			'CONTENT' => 'You have been invited in party',
			'CONTENT_DETAIL' => $htmlNow,
			'USER'=> htmlspecialchars( ucwords( $emailn ) ),
			'STORE'=>$store_username,
			'FOOTER_TEXT'=> $_SERVER['HTTP_HOST'],
			'BASE_URL' => $_SERVER['HTTP_HOST'],
			'EMAIL_LOGO'=> ''
	);
		
	$body = $this->parser->parse('default/emails/grouppurchase_invite', $ndata, true);
	//echo $body ;
	//die;
	//$this->email->cc('another@another-example.com');
	$this->email->subject('Party Invitation - simple sales systems');
	$this->email->message( $body );
	if ( ! $this->email->send())
	{
		//echo $this->email->print_debugger();
	//die;
	}else{
		//echo 'sent';
		//echo $this->email->print_debugger();
	}
	}
        /* send emails ends here */	
}

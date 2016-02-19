<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:		coupons extends VCI_Controller defined in libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:Manage coupons page by admin 
---------------------------------------------------------------
*/

class Coupons extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('coupons_model');
		$this->load->helper('resize');
	}
	
	/*
	-----------------------------------------------------------------
	* 	Method 		: add_coupons
	*	@param  	: 
	* Description 	: to add coupons
	*/
	function add_coupons()
	{
	    //Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		//$view_data = array();
		$view_data['code'] = '';
		$view_data['discount_percent'] = '';
		$view_data['status'] = '';

		$allowed_types = array('gif','png','jpg','jpeg','jpe','image/jpeg','image/gif','image/png','image/jpg','image/jpeg','image/jpe');
        
        $store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }
				
		if( !isset($store_id) && empty($store_id) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }
        
        
        // Fetch coupon type
        $all_coupon_types = $this->coupons_model->get_all_coupon_types();
        $view_data['coupon_types'] = $all_coupon_types;
                
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Coupons' => array('link'=>'coupons/manage_coupons', 'attributes' => array('class'=>'breadcrumb')),
			'Add Coupon' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Add Coupon";
		
		//Set the validation rules for server side validation
		// rule name addcoupons
		$this->load->helper('string');
		$view_data['random_code'] = random_string('alnum', 8);
		 

		if($this->input->post('formSubmitted') > 0) 
		{
		    //echo '<pre>';print_r($this->input->post());die;
			if($this->form_validation->run('addcoupons')) 
			//if( isset( $_POST['code'] ) && !empty( $_POST['code'] ) )
			{
			//Everything is ok lets update the page data
				if($this->coupons_model->add( $store_id )) {
						$this->session->set_flashdata('success', "<li>Coupons has been added successfully.</li>");
						$this->output->set_header('location:' . base_url() . 'coupons/manage_coupons');
					} else {
						$this->session->set_flashdata('error', "<li>Unknown Error: Unable to add coupons.</li>");
						$this->output->set_header('location:' . base_url() . 'coupons/manage_coupons');
					}
				 	
				 $view_data['code']  = $this->input->post('code');
				 $view_data['discount_percent']  = $this->input->post('discount_percent');
				 $view_data['status'] = $this->input->post('status');
				 $view_data['created'] = date("Y-m-d h:i:s");
				 $view_data['modified'] = date("Y-m-d h:i:s");
				 $this->_vci_view('coupons_add', $view_data);
			}
			else{

				 $view_data['code']  = $this->input->post('code');
				 $view_data['discount_percent']  = $this->input->post('discount_percent');
				 $view_data['status'] = $this->input->post('status');
				 $view_data['modified'] = date("Y-m-d h:i:s");
				 $this->_vci_view('coupons_add', $view_data);
			}
		}else
		{
			//form not submitted load view normally //
			$this->_vci_view('coupons_add', $view_data);
		}
	}
	
	/*
	-----------------------------------------------------------------
	*	Method:edit_page
	*	@param id integer
	*	Description: update the page data identified by the id
	-----------------------------------------------------------------
	*/
	function edit_coupons($id = null)
	{
		
		ini_set('display_errors',0);
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit coupons without coupons id.</li>");
				$this->output->set_header('location:' . base_url() . 'coupons/manage_coupons');
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

		// Fetch coupon type
		$all_coupon_types = $this->coupons_model->get_all_coupon_types();
        $view_data['coupon_types'] = $all_coupon_types;
        
		$allowed_types = array('gif','png','jpg','jpeg','jpe','image/jpeg','image/gif','image/png','image/jpg','image/jpeg','image/jpe');
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Coupons' => array('link'=>'coupons/manage_coupons', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Coupon' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit Coupon";

		//Set the validation rules for server side validation

		if($this->input->post('formSubmitted') > 0) 
		{

			if($this->form_validation->run('addcoupons')) 
			//if( isset( $_POST['code'] ) && !empty( $_POST['code'] ) )
			{
			    
				//Everything is ok lets update the page data
				if($this->coupons_model->update( trim($id), $store_id ) ) {
					$this->session->set_flashdata('success', "<li>Coupons has been edited successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'coupons/manage_coupons');
				} else {
					$this->session->set_flashdata('errors', "<li>Unknown Error: Unable to edit coupons.</li>");
					$this->output->set_header('location:' . base_url() . 'coupons/manage_coupons');
				}
			
			} else {
				//Set the view data and render the view in case validation fails
				$page = $this->coupons_model->get_coupons_page(trim($id));
				
				$view_data["id"]                = $page->id;
			//	$view_data["allowed_times"]     = $page->allowed_times;
			    $view_data["coupon_type_id"]    = $page->coupon_type_id;
			    $view_data["expire_date"]       = $page->expire_date;
			    $view_data["start_date"]       = $page->start_date;
				$view_data["code"]              = $page->code;
				$view_data["discount_percent"]  = $page->discount_percent;
				$view_data["status"]            = $page->status;
				$this->_vci_view('coupons_editpage', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			$page = $this->coupons_model->get_coupons_page(trim($id));

			$view_data["id"]                = $page->id;
		//	$view_data["allowed_times"]     = $page->allowed_times;
			$view_data["coupon_type_id"]    = $page->coupon_type_id;
			$view_data["start_date"]       	= $page->start_date;
			$view_data["expire_date"]       = $page->expire_date;
			$view_data["id"]                = $page->id;
			$view_data["code"]              = $page->code;
			$view_data["discount_percent"]  = $page->discount_percent;
			$view_data["status"]            = $page->status;
			
			$this->_vci_view('coupons_editpage', $view_data);
		}	
	}

	
	/*
	-----------------------------------------------------------------
	*	Method: manage_coupons
	*	@param id integer
	*	Description: Fetch all City from database and render on screen
	-----------------------------------------------------------------
	*/
	function manage_coupons($page = 0) {

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
			'Manage coupons' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		$view_data['caption'] = "Manage coupons";
		//Load model and pagination library
		$this->load->library('pagination');
		
		//Set pagination configs
		$getData = array('s'=>$qstr);
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");

		$config['first_url'] = base_url() . "coupons/manage_coupons?s=".$qstr;
		
		//Fetch all pages from database
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
		}

		if(isset($this->session->userdata))
		{
			$cons_role_id = $this->session->userdata('user');
			$view_data['consultant_role_id'] = $cons_role_id['role_id'];
		}
		
		#echo 'consultant id'.$consultantId ;
	    $config['per_page'] = PAGE_LIMIT;
		$config['base_url'] = base_url() . "coupons/manage_coupons";
		$config['total_rows'] = intval($this->coupons_model->get_coupons($page,$config['per_page'],true, $store_id,$consultantId ));
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$clients  = $this->coupons_model->get_all_clients();
        $view_data['clients'] = $clients;
		$view_data['content'] = $this->coupons_model->get_coupons($page, $config['per_page'],false, $store_id,$consultantId);
		$this->_vci_view('coupons_managecoupons', $view_data);
	}

	/*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer 
	*	Description: update coupons status. if status is active then 
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
			$this->output->set_header('location:' . base_url() . 'coupons/manage_coupons');
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
		    //Update the status for the coupons page and redirect to listing with success msg
		    $result = $this->coupons_model->update_status($id, $status);
		    $this->session->set_flashdata('success', '<li> coupons has been updated successfully.</li>');
		    $this->output->set_header('location:' . base_url() . 'coupons/manage_coupons' . (($page>0) ? '/' . $page : ''));
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method: delete_coupons
	*	@param none
	*	Description: for deleting coupons
	-----------------------------------------------------------------
	*/

	function delete_coupons(){
		$this->_vci_layout('menu-toolbar');
		
		if($this->coupons_model->delete_coupons())
		{	
			$this->session->set_flashdata('success', 'coupons deleted sucessfully');
			$this->output->set_header('location:' . base_url() . 'coupons/manage_coupons');
		}
		else {
		    $this->session->set_flashdata('errors','coupons deletion failed');
			$this->output->set_header('location:'. base_url(). 'coupons/manage_coupons');
		}
	}
	
}

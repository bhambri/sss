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

class Promotionrules extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		error_reporting(1);		
		parent::__construct();
		$this->load->model('promotion_model');
		$this->load->model('coupons_model');
		$this->load->helper('resize');
	}
	
	/*
	-----------------------------------------------------------------
	* 	Method 		: add_coupons
	*	@param  	: 
	* Description 	: to add coupons
	*/
	function add_prule()
	{
	    //Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		ini_set('display_errors',1);
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
        #echo $store_id ;
        #die('checking');
        
        // Fetch coupon type
        $all_coupon_types = $this->promotion_model->get_all_executives( $store_id ) ;
        $view_data['coupon_types'] = $all_coupon_types;
                
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Promotion Rule Settings' => array('link'=>'promotionrules/manage_prule', 'attributes' => array('class'=>'breadcrumb')),
			'Add Promotion Rule' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Add Promotion Rule";
		
		//Set the validation rules for server side validation
		// rule name addcoupons
		$this->load->helper('string');
		//$view_data['random_code'] = random_string('alnum', 8);
		
		if($this->input->post('formSubmitted') > 0) 
		{
		    
			if($this->form_validation->run('add_prule')) 
			//if( isset( $_POST['code'] ) && !empty( $_POST['code'] ) )
			{
			//Everything is ok lets update the page data
				if($this->promotion_model->add( $store_id )) {
						$this->session->set_flashdata('success', "<li>Promotion Rule has been added successfully.</li>");
						$this->output->set_header('location:' . base_url() . 'promotionrules/manage_prule');
					} else {
						$this->session->set_flashdata('error', "<li>Unknown Error: Unable to add Promotion Rule.</li>");
						$this->output->set_header('location:' . base_url() . 'promotionrules/manage_prule');
					}
				 /*
			
				 */

				 $view_data['executive_level_id']  = $this->input->post('executive_level_id');
				 $view_data['binaryvol_range_from']  = $this->input->post('binaryvol_range_from');
				 $view_data['binaryvol_range_to']  = $this->input->post('binaryvol_range_to');
				 $view_data['min_pcv']  = $this->input->post('min_pcv');
				 $view_data['min_ppv']  = $this->input->post('min_ppv');
				 $view_data['status'] = $this->input->post('status');
				
				 $view_data['created'] = date("Y-m-d h:i:s");
				 $view_data['modified'] = date("Y-m-d h:i:s");
				 $this->_vci_view('prule_add', $view_data);
			}
			else{

				 $view_data['executive_level_id']  = $this->input->post('executive_level_id');
				 $view_data['binaryvol_range_from']  = $this->input->post('binaryvol_range_from');
				 $view_data['binaryvol_range_to']  = $this->input->post('binaryvol_range_to');
				 $view_data['min_pcv']  = $this->input->post('min_pcv');
				 $view_data['min_ppv']  = $this->input->post('min_ppv');
				 $view_data['status'] = $this->input->post('status');

				 $view_data['status'] = $this->input->post('status');
				 $view_data['modified'] = date("Y-m-d h:i:s");
				 $this->_vci_view('prule_add', $view_data);
			}
		}else
		{
			//form not submitted load view normally //
			
			$this->_vci_view('prule_add', $view_data);
		}
	}
	
	/*
	-----------------------------------------------------------------
	*	Method:edit_page
	*	@param id integer
	*	Description: update the page data identified by the id
	-----------------------------------------------------------------
	*/
	function edit_prule($id = null)
	{
		
		ini_set('display_errors',1);
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit Promotion Rule without rule id.</li>");
				$this->output->set_header('location:' . base_url() . 'promotionrules/manage_prule');
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
	        echo 'You are not authorized to see the page.';die;
	    }
        
        
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$view_data = array();

		// Fetch coupon type
		$all_coupon_types = $this->promotion_model->get_all_executives( $store_id ) ;
        $view_data['coupon_types'] = $all_coupon_types;
        
		$allowed_types = array('gif','png','jpg','jpeg','jpe','image/jpeg','image/gif','image/png','image/jpg','image/jpeg','image/jpe');
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Promotion Rule Settings' => array('link'=>'promotionrules/manage_prule', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Promotion Rule' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit Promotion Rule";

		//Set the validation rules for server side validation

		if($this->input->post('formSubmitted') > 0) 
		{

			if($this->form_validation->run('add_prule')) 
			//if( isset( $_POST['code'] ) && !empty( $_POST['code'] ) )
			{
			    
				//Everything is ok lets update the page data
				if($this->promotion_model->update( trim($id), $store_id ) ) {
					$this->session->set_flashdata('success', "<li>Promotion Rule has been edited successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'promotionrules/manage_prule');
				} else {
					$this->session->set_flashdata('errors', "<li>Unknown Error: Unable to edit Promotion Rule.</li>");
					$this->output->set_header('location:' . base_url() . 'promotionrules/manage_prule');
				}
			
			} else {
				//Set the view data and render the view in case validation fails
				$page = $this->promotion_model->get_coupons_page(trim($id));
				

				$view_data["id"]                = $page->id;
			    //$view_data["allowed_times"]     = $page->allowed_times;
			    $view_data["executive_level_id"]    = $page->executive_level_id;
				$view_data["binaryvol_range_from"]       	= $page->binaryvol_range_from;
				$view_data["binaryvol_range_to"]       = $page->binaryvol_range_to;
				$view_data["id"]                = $page->id;
				$view_data["min_pcv"]              = $page->min_pcv;
				$view_data["min_ppv"]  = $page->min_ppv;
				$view_data["status"]            = $page->status;

				$this->_vci_view('prule_editpage', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			$page = $this->promotion_model->get_coupons_page(trim($id));
			
			$view_data["id"]                = $page->id;
		    //	$view_data["allowed_times"]     = $page->allowed_times;
			$view_data["executive_level_id"]    = $page->executive_level_id;
			$view_data["binaryvol_range_from"]       	= $page->binaryvol_range_from;
			$view_data["binaryvol_range_to"]       = $page->binaryvol_range_to;
			$view_data["id"]                = $page->id;
			$view_data["min_pcv"]              = $page->min_pcv;
			$view_data["min_ppv"]  = $page->min_ppv;
			$view_data["status"]            = $page->status;
			
			$this->_vci_view('prule_editpage', $view_data);
		}	
	}

	
	/*
	-----------------------------------------------------------------
	*	Method: manage_coupons
	*	@param id integer
	*	Description: Fetch all City from database and render on screen
	-----------------------------------------------------------------
	*/
	function manage_prule($page = 0) {
		
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
			'Promotion Rule Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		$view_data['caption'] = "Promotion Rule Settings";
		//Load model and pagination library
		$this->load->library('pagination');
		
		//Set pagination configs
		$getData = array('s'=>$qstr);
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");

		$config['first_url'] = base_url()."promotionrules/manage_prule?s=".$qstr;
		
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
		//error_reporting(1);
		//echo 1111;
		//die('jdjdjdj');
	    $config['per_page'] = PAGE_LIMIT;
		$config['base_url'] = base_url() ."promotionrules/manage_prule";
		$config['total_rows'] = intval($this->promotion_model->get_promotionrule($page,$config['per_page'],true, $store_id ));
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$clients  = $this->coupons_model->get_all_clients();
       		$view_data['clients'] = $clients;
		
		$view_data['content'] = $this->promotion_model->get_promotionrule($page, $config['per_page'],false, $store_id);
		$all_coupon_types = $this->promotion_model->get_all_executives( $store_id ) ;
				
		$executivelevels = array();
		foreach($all_coupon_types as $ex_lvls){
			//echo '<pre>';
			//print_r($ex_lvls);
			$executivelevels[$ex_lvls->id] = $ex_lvls->executive_level;
		}
		$view_data['executive_lvl'] = $executivelevels ;
		
		$this->_vci_view('prule_manageprule', $view_data);
		
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
			$this->output->set_header('location:' . base_url() . 'promotionrules/manage_prule');
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
		    $result = $this->promotion_model->update_status($id, $status);
		    $this->session->set_flashdata('success', '<li>Promotion rule has been updated successfully.</li>');
		    $this->output->set_header('location:' . base_url() . 'promotionrules/manage_prule' . (($page>0) ? '/' . $page : ''));
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method: delete_coupons
	*	@param none
	*	Description: for deleting coupons
	-----------------------------------------------------------------
	*/

	function delete_prule(){
		$this->_vci_layout('menu-toolbar');
		
		if($this->promotion_model->delete_prule())
		{	
			$this->session->set_flashdata('success', 'Promotion rule deleted sucessfully');
			$this->output->set_header('location:' . base_url() . 'promotionrules/manage_prule');
		}
		else {
		    $this->session->set_flashdata('errors','Promotion rule deletion failed');
			$this->output->set_header('location:'. base_url(). 'promotionrules/manage_prule');
		}
	}
	
}

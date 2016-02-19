<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:		banners extends VCI_Controller defined in libraries
*	Author: 	Abhishek Srivastav
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:Manage banners page by admin 
---------------------------------------------------------------
*/

class Banners extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('banners_model');
		$this->load->helper('resize');
		$this->load->model('user_model');
		$this->load->model('client_model');
		
	}
	
	/*
	-----------------------------------------------------------------
	* 	Method 		: add_banners
	*	@param  	: 
	* Description 	: to add banners
	*/
	function add_banners()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		//$view_data = array();
		$view_data['title'] = '';
		$view_data['image'] = '';
		$view_data['link'] = '';
		$view_data['status'] = '';

		$allowed_types = array('gif','png','jpg','jpeg','jpe','image/jpeg','image/gif','image/png','image/jpg','image/jpeg','image/jpe');

		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage banners' => array('link'=>'banners/manage_banners', 'attributes' => array('class'=>'breadcrumb')),
			'Add banner' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Add New Banner";
		
		//Set the validation rules for server side validation
		// rule name addbanners
		
		$this->load->library('upload');

		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{
			if(!empty($_FILES['image'])){
				$config['upload_path'] = '../uploads';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '50000';
				$config['max_width']  = '6024';
				$config['max_height']  = '2000';

				$this->upload->initialize($config);
				if( ! $this->upload->do_upload('image')){
					// invalid image type 
					$error = array('error' => $this->upload->display_errors());
				}else{
					$uploadedData = $this->upload->data() ;
					$filepath = '/uploads/'.$uploadedData['file_name'] ;
				}
				
			}
			
            //echo 'kanav';die;
           // echo '<pre>';
            if($this->form_validation->run('addbanners'))
			//if( isset( $_POST['title'] ) && !empty( $_POST['title'] ) )
			{
			
			//Everything is ok lets update the page data
			//$this->upload->display_errors('<li>', '</li>')

				if(! $this->upload->display_errors())
				{
                    if( isset( $this->session->userdata['user']['id'] ) && !isset( $this->session->userdata['user']['is_admin'] ) )
                    {
                        $store_id   = $this->session->userdata['user']['id'];
                    }
                    
                    $store_id = $this->session->userdata('storeId');
			        if( empty( $store_id ) )
			        {
			            $store_id = $this->storeId();
			        }

			        //Below checks removed as there was store id was zero in case of admin is adding banner for him
			        /*
			        if( !isset($store_id) || empty($store_id) )
				    {
				        echo ' You are not authorized to see the page.';die;
				    }
					*/

	    			$consultantId = $this->session->userdata('consultantId');

	    			if( !$store_id  && ! $consultantId )
				    {
				       $userDetails = $this->session->userdata('user');
	    			   $consultantId = $userDetails['id'];
				    }else{
				    	//$consultantId = "";
				    }

	    			if( empty($consultantId) )
	    			{
	    				$userDetails = $this->session->userdata('user');
	    				$consultantId = $userDetails['id'];
					}

					// hack for super admin case
					if( $consultantId == 1){
						$consultantId = 0 ;
					}
					
					
					
					if($this->banners_model->add($filepath, $store_id, $consultantId))
					{
						$this->session->set_flashdata('success', "<li>Banner has been added successfully.</li>");
						$this->output->set_header('location:' . base_url() . 'banners/manage_banners');
					}
					else 
					{
						$this->session->set_flashdata('error', "<li>Unknown Error: Unable to add banners.</li>");
						$this->output->set_header('location:' . base_url() . 'banners/manage_banners');
					}
				}else
				{
				   
					 $view_data['title']  = $this->input->post('title');
					 $view_data['image']  = $this->input->post('image');
					 $view_data['link']   = $this->input->post('link');
					 $view_data['status'] = $this->input->post('status');
					 $view_data['created'] = $this->input->post('created');
					 $view_data['modified'] = $this->input->post('modified');
					 
					 $this->_vci_view('banners_addpage', $view_data);
				}	
			}else{
                 
				 $view_data['title'] = $this->input->post('title');
				 $view_data['image'] = $this->input->post('image');
				 $view_data['link'] = $this->input->post('link');
				 $view_data['status'] = $this->input->post('status');
				 $this->_vci_view('banners_addpage', $view_data);
			}
		}else
		{
			//form not submitted load view normally //
			$this->_vci_view('banners_addpage', $view_data);
		}

	}

	
	function banner_link_valid()
	{
		$url = trim($_POST['link']);
		$pattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		if($url!='')
		{
			if (!@preg_match($pattern, $url))
			{
				$this->form_validation->set_message('banner_link_valid', 'The Link field must contain a valid URL. Eg. http://www.google.com');
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
	
	/*
	-----------------------------------------------------------------
	*	Method:edit_page
	*	@param id integer
	*	Description: update the page data identified by the id
	-----------------------------------------------------------------
	*/
	function edit_banners($id = null)
	{
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit banners without banners id.</li>");
				$this->output->set_header('location:' . base_url() . 'banners/manage_banners');
			}
		}
		
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$view_data = array();
		$allowed_types = array('gif','png','jpg','jpeg','jpe','image/jpeg','image/gif','image/png','image/jpg','image/jpeg','image/jpe');
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage banners' => array('link'=>'banners/manage_banners', 'attributes' => array('class'=>'breadcrumb')),
			'Edit banners' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit Banner";

		//Set the validation rules for server side validation

        $this->load->library('upload');
		if($this->input->post('formSubmitted') > 0) 
		{

			if($this->form_validation->run('addbanners')) 
			//if( isset( $_POST['title'] ) && !empty( $_POST['title'] ) )
			{
			    $filepath = $this->input->post('path') ;
			    
			    if(!empty($_FILES['image'])){

						$config['upload_path'] = '../uploads';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['max_size']	= '1000000';
						$config['max_width']  = ' 6000';
						$config['max_height']  = '3500';
						$this->upload->initialize($config);

						if( ! $this->upload->do_upload('image')){
							// invalid image type 
						$error = array('error' => $this->upload->display_errors());
							
						}else{
							$uploadedData = $this->upload->data() ;
							$filepath = '/uploads/'.$uploadedData['file_name'] ;	
						}
				}
				//Everything is ok lets update the page data
				if($this->banners_model->update(trim($id),$filepath)) {
					$this->session->set_flashdata('success', "<li>Banner has been edited successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'banners/manage_banners');
				} else {
					$this->session->set_flashdata('error', "<li>Unknown Error: Unable to edit banners.</li>");
					$this->output->set_header('location:' . base_url() . 'banners/manage_banners');
				}
			
			} else {
				//Set the view data and render the view in case validation fails
				$page = $this->banners_model->get_banners_page(trim($id));
				
				$view_data["id"]                = $page->id;
				$view_data["page_title"]        = $page->title;
				$view_data["image"]             = $page->image;
				$view_data["link"]              = $page->link;
				$view_data["status"]            = $page->status;
				
				$this->_vci_view('banners_editpage', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			//Set the view data and render the view
			$page = $this->banners_model->get_banners_page(trim($id));

			$view_data["id"]                = $page->id;
			$view_data["page_title"]        = $page->title;
			$view_data["image"]             = $page->image;
			$view_data["link"]              = $page->link;
			$view_data["status"]            = $page->status;
			
			$this->_vci_view('banners_editpage', $view_data);
		}	
	}

	function edit_bannersnew($id = null)
	{
		
		$store_id = $this->session->userdata('storeId');
        
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }
				
		if( !isset($store_id) && empty($store_id) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }
		
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit banners without banners id.</li>");
				$this->output->set_header('location:' . base_url() . 'banners/manage_banners');
			}
		}
		
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		$view_data = array();
		$allowed_types = array('gif','png','jpg','jpeg','jpe','image/jpeg','image/gif','image/png','image/jpg','image/jpeg','image/jpe');
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage banners' => array('link'=>'banners/manage_banners', 'attributes' => array('class'=>'breadcrumb')),
			'Edit banner' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit Banner";
		
		//Set the validation rules for server side validation
		
        $this->load->library('upload');
		if($this->input->post('formSubmitted') > 0) 
		{
            $this->load->library('upload');
			$filepath = $this->input->post('path');
			 if(!empty($_FILES['image'])){
						$config['upload_path'] = '../uploads';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['max_size']	= '5000';
						$config['max_width']  = '5000';
						$config['max_height']  = '3000';
						$this->upload->initialize($config);

						if( ! $this->upload->do_upload('image')){
							// invalid image type 
							$error = array('error' => $this->upload->display_errors());
							
						}else{
							$uploadedData = $this->upload->data() ;
							$filepath = '/uploads/'.$uploadedData['file_name'];	
						}
				}

			if($this->form_validation->run('editbanners')) 
			//if( isset( $_POST['title'] ) && !empty( $_POST['title'] ) )
			{
			    
			    if(! $this->upload->display_errors() || ($this->upload->display_errors() == '<p>You did not select a file to upload.</p>' )){
			    	//Everything is ok lets update the page data
					if($this->banners_model->update(trim($id),$filepath)) {
						$this->session->set_flashdata('success', "<li>Banner has been edited successfully.</li>");
						$this->output->set_header('location:' . base_url() . 'banners/manage_banners');
					} else {
						$this->session->set_flashdata('error', "<li>Unknown Error: Unable to edit banners.</li>");
						$this->output->set_header('location:' . base_url() . 'banners/manage_banners');
					}

			    }else{

			    	$page = $this->banners_model->get_banners_page(trim($id));
				
					$view_data["id"] = $page->id;
					$view_data["title"] = $page->title;
					$view_data["image"] = $page->image;
					$view_data["link"] = $page->link;
					$view_data["status"] = $page->status;
					$view_data["modified"] = $page->modified;
					
					$this->_vci_view('banners_editpage', $view_data);
			    }
				
			} else {
				//Set the view data and render the view in case validation fails
				$page = $this->banners_model->get_banners_page(trim($id));
				
				$view_data["id"] = $page->id;
				$view_data["title"] = $page->title;
				$view_data["image"] = $page->image;
				$view_data["link"] = $page->link;
				$view_data["status"] = $page->status;
				$view_data["modified"] = $page->modified;
				$this->_vci_view('banners_editpage', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			//Set the view data and render the view
			$page = $this->banners_model->get_banners_page(trim($id));

			$view_data["id"] = $page->id;
			$view_data["title"] = $page->title;
			$view_data["image"] = $page->image;
			$view_data["link"] = $page->link;
			$view_data["status"] = $page->status;
			$view_data["modified"] = $page->modified;
			$this->_vci_view('banners_editpage', $view_data);
		}	
	}

	/*
	-----------------------------------------------------------------
	*	Method: manage_banners
	*	@param id integer
	*	Description: Fetch all City from database and render on screen
	-----------------------------------------------------------------
	*/
	function manage_banners($page = 0) {
		//adding baner case

		//Set the layout and initialize the view variable; Set view caption
		$this->_vci_layout('menu-toolbar');
		$view_data = array();
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s') ;
		}
		
		//creates bread crumb
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage banners' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		
		$view_data['crumbs'] = $crumbs;
		$view_data['caption'] = "Manage banners";
		//Load model and pagination library
		$this->load->library('pagination');

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

		//echo '<pre>';
		//print_r($userDetails);
		
		if( isset( $userDetails['role_id'] ) &&  $userDetails['role_id'] == 4 )
		{	
			$consultantId = $userDetails['id'];	
		}
		else
		{
			$consultantId = '';
		}

		//echo 'consultant_id'.$consultantId ;

		// added by abhishek to show only the selected consultant data
		if(!$consultantId){
			$consultantId = $this->session->userdata('consultantId') ;
		}

		if(isset($userDetails['is_admin']) && ($userDetails['is_admin'] == 1)){
			if(!$store_id){
				$consultantId = 0 ;
			}
			//echo $store_id;
		}
		
		$config['first_url'] = base_url() . "banners/manage_banners/";	

		$config['base_url'] = base_url() . "banners/manage_banners";
		$config['total_rows'] = intval($this->banners_model->get_banners($page,'',true,$store_id, $consultantId));
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();

		$view_data['content'] = $this->banners_model->get_banners( $page, 10,'', $store_id, $consultantId );	

		$view_data['clients_consultant']  = $this->banners_model->all_clients_consultant();

		$clients  = $this->banners_model->get_all_clients();
        $view_data['clients'] = $clients;
        
        if(isset($this->session->userdata))
        {
        	$cons_role_id = $this->session->userdata('user');
        	$view_data['consultant_role_id'] = $cons_role_id['role_id'];
        }
        
        
		$this->_vci_view('banners_managebanners', $view_data);
	}

	/*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer 
	*	Description: update banners status. if status is active then 
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
			$this->output->set_header('location:' . base_url() . 'banners/manage_banners');
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
            
		    //Update the status for the banners page and redirect to listing with success msg
		    $result = $this->banners_model->update_status($id, $status);
		    $this->session->set_flashdata('success', '<li> Banner has been updated successfully.</li>');
		    $this->output->set_header('location:' . base_url() . 'banners/manage_banners' . (($page>0) ? '/' . $page : ''));
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method: delete_banners
	*	@param none
	*	Description: for deleting banners
	-----------------------------------------------------------------
	*/

	function delete_banners(){
		$this->_vci_layout('menu-toolbar');
		
		if($this->banners_model->delete_banners())
		{	
			$this->session->set_flashdata('success', 'Banner deleted sucessfully');
			$this->output->set_header('location:' . base_url() . 'banners/manage_banners');
		}
		else {
		    $this->session->set_flashdata('errors','banners deletion failed');
			$this->output->set_header('location:'. base_url(). 'banners/manage_banners');
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method: remove_image
	*	@param id integer
	* 	@param remove 1 or 0 
	*	Description: removing the images
	-----------------------------------------------------------------
	*/
	function remove_image($id=null, $remove = 1){
		//Set layout and load model
		$this->_vci_layout('menu-toolbar');
		
		//Check if id was passed
		if(is_null($id))
		{
			$this->session->set_flashdata('errors', '<li>Unable to perform the requested operation without id.</li>');
			$this->output->set_header('location:' . base_url() . 'banners/manage_banners');
		}
		
		//Toggles the status
		if(intval($remove ) == 1){
			$this->session->set_flashdata('success', '<li> Thumbnail removed sucessfuly .</li>');
			$this->output->set_header('location:' . base_url() . 'banners/edit_banners/'.$id );
			$result = $this->banners_model->remove_image($id); 
		}
		else{
			
			$this->output->set_header('location:' . base_url() . 'banners/edit_banners/'.$id );
		}
		//Update the status for the banners page and redirect to listing with success msg
	}
}

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:		storelinks extends VCI_Controller defined in libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:Manage storelinks page by admin 
---------------------------------------------------------------
*/

class Storelinks extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('storelinks_model');
		$this->load->helper('resize');
	}
	
	/*
	-----------------------------------------------------------------
	* 	Method 		: add_storelinks
	*	@param  	: 
	* Description 	: to add storelinks
	*/
	function add_storelinks()
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
			'Manage storelinks' => array('link'=>'storelinks/manage_storelinks', 'attributes' => array('class'=>'breadcrumb')),
			'Add storelinks' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "storelinks [Add]";
		
		//Set the validation rules for server side validation
		// rule name addstorelinks
		
		$this->load->library('upload');

		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{
			if(!empty($_FILES['image'])){
				$config['upload_path'] = '../uploads/topStore';
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
					$filepath = '/uploads/topStore/'.$uploadedData['file_name'] ;
				}
				
			}

			//if($this->form_validation->run('addstorelinks')) 
			if( isset( $_POST['title'] ) && !empty( $_POST['title'] ) )
			{
			//Everything is ok lets update the page data
				
				if(! $this->upload->display_errors() || ($this->upload->display_errors() == '<p>You did not select a file to upload.</p>' ))
				{
											   
					if($this->storelinks_model->add($filepath)) {
						$this->session->set_flashdata('success', "<li>storelinks has been added successfully.</li>");
						$this->output->set_header('location:' . base_url() . 'storelinks/manage_storelinks');
					} else {
						$this->session->set_flashdata('error', "<li>Unknown Error: Unable to add storelinks.</li>");
						$this->output->set_header('location:' . base_url() . 'storelinks/manage_storelinks');
					}
				}else
				{
					 $view_data['title']  = $this->input->post('title');
					 $view_data['image']  = $this->input->post('image');
					 $view_data['link']   = $this->input->post('link');
					 $view_data['status'] = $this->input->post('status');
					 $view_data['created'] = $this->input->post('created');
					 $view_data['modified'] = $this->input->post('modified');
					 
					 $this->_vci_view('storelinks_addpage', $view_data);
				}	
			}else{

				 $view_data['title'] = $this->input->post('title');
				 $view_data['image'] = $this->input->post('image');
				 $view_data['link'] = $this->input->post('link');
				 $view_data['status'] = $this->input->post('status');
				 $this->_vci_view('storelinks_addpage', $view_data);
			}
		}else
		{
			//form not submitted load view normally //
			$this->_vci_view('storelinks_add', $view_data);
		}

	}

	/*
	-----------------------------------------------------------------
	*	Method:edit_page
	*	@param id integer
	*	Description: update the page data identified by the id
	-----------------------------------------------------------------
	*/
	function edit_storelinks($id = null)
	{
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit storelinks without storelinks id.</li>");
				$this->output->set_header('location:' . base_url() . 'storelinks/manage_storelinks');
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
			'Manage storelinks' => array('link'=>'storelinks/manage_storelinks', 'attributes' => array('class'=>'breadcrumb')),
			'Edit storelinks' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "storelinks [Edit Page]";

		//Set the validation rules for server side validation

        $this->load->library('upload');
		if($this->input->post('formSubmitted') > 0) 
		{

			if($this->form_validation->run('addstorelinks')) 
			//if( isset( $_POST['title'] ) && !empty( $_POST['title'] ) )
			{
			    $filepath = $this->input->post('path') ;
			    
			    if(!empty($_FILES['image'])){

						$config['upload_path'] = '../uploads/topStore';
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
							$filepath = '/uploads/topStore/'.$uploadedData['file_name'];
							echo "dd";	
						}
				}
				//Everything is ok lets update the page data
				if($this->storelinks_model->update(trim($id),$filepath)) {
					$this->session->set_flashdata('success', "<li>storelinks has been edited successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'storelinks/manage_storelinks');
				} else {
					$this->session->set_flashdata('errors', "<li>Unknown Error: Unable to edit storelinks.</li>");
					$this->output->set_header('location:' . base_url() . 'storelinks/manage_storelinks');
				}
			
			} else {
				//Set the view data and render the view in case validation fails
				$page = $this->storelinks_model->get_storelinks_page(trim($id));
				
				$view_data["id"]                = $page->id;
				$view_data["page_title"]        = $page->title;
				$view_data["image"]             = $page->image;
				$view_data["link"]              = $page->link;
				$view_data["status"]            = $page->status;
				
				$this->_vci_view('storelinks_editpage', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			//Set the view data and render the view
			$page = $this->storelinks_model->get_storelinks_page(trim($id));

			$view_data["id"]                = $page->id;
			$view_data["page_title"]        = $page->title;
			$view_data["image"]             = $page->image;
			$view_data["link"]              = $page->link;
			$view_data["status"]            = $page->status;
			
			$this->_vci_view('storelinks_editpage', $view_data);
		}	
	}

	function edit_storelinksnew($id = null)
	{
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit storelinks without storelinks id.</li>");
				$this->output->set_header('location:' . base_url() . 'storelinks/manage_storelinks');
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
			'Manage storelinks' => array('link'=>'storelinks/manage_storelinks', 'attributes' => array('class'=>'breadcrumb')),
			'Edit storelinks' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "storelinks [Edit Page]";
		
		//Set the validation rules for server side validation
		
        $this->load->library('upload');
		if($this->input->post('formSubmitted') > 0) 
		{	
            $this->load->library('upload');
			$filepath = $this->input->post('path');
			 if(!empty($_FILES['image'])){

						$config['upload_path'] = '../uploads/topStore';
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
							$filepath = '/uploads/topStore/'.$uploadedData['file_name'];	
						}
				}

			if($this->form_validation->run('editstorelinks')) 
			//if( isset( $_POST['title'] ) && !empty( $_POST['title'] ) )
			{
			    if(! $this->upload->display_errors() || ($this->upload->display_errors() == '<p>You did not select a file to upload.</p>' )){
			    	//Everything is ok lets update the page data
					if($this->storelinks_model->update(trim($id),$filepath)) {
						$this->session->set_flashdata('success', "<li>storelinks has been edited successfully.</li>");
						$this->output->set_header('location:' . base_url() . 'storelinks/manage_storelinks');
					} else {
						$this->session->set_flashdata('error', "<li>Unknown Error: Unable to edit storelinks.</li>");
						$this->output->set_header('location:' . base_url() . 'storelinks/manage_storelinks');
					}

			    }else{

			    	$page = $this->storelinks_model->get_storelinks_page(trim($id));
				
					$view_data["id"] = $page->id;
					$view_data["title"] = $page->title;
					$view_data["image"] = $page->image;
					$view_data["link"] = $page->link;
					$view_data["status"] = $page->status;
					$view_data["modified"] = $page->modified;
					
					$this->_vci_view('storelinks_editpage', $view_data);
			    }
				
			} else {
				//Set the view data and render the view in case validation fails
				$page = $this->storelinks_model->get_storelinks_page(trim($id));
				
				$view_data["id"] = $page->id;
				$view_data["title"] = $page->title;
				$view_data["image"] = $page->image;
				$view_data["link"] = $page->link;
				$view_data["status"] = $page->status;
				$view_data["modified"] = $page->modified;
				$this->_vci_view('storelinks_editpage', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			//Set the view data and render the view
			$page = $this->storelinks_model->get_storelinks_page(trim($id));

			$view_data["id"] = $page->id;
			$view_data["title"] = $page->title;
			$view_data["image"] = $page->image;
			$view_data["link"] = $page->link;
			$view_data["status"] = $page->status;
			$view_data["modified"] = $page->modified;
			$this->_vci_view('storelinks_editpage', $view_data);
		}	
	}

	/*
	-----------------------------------------------------------------
	*	Method: manage_storelinks
	*	@param id integer
	*	Description: Fetch all City from database and render on screen
	-----------------------------------------------------------------
	*/
	function manage_storelinks($page = 0) {

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
			'Manage storelinks' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		$view_data['caption'] = "Manage storelinks";
		//Load model and pagination library
		$this->load->library('pagination');
		
		//Set pagination configs
		$getData = array('s'=>$qstr);
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");

		$config['first_url'] = base_url() . "storelinks/manage_storelinks?s=".$qstr;
			
		$config['base_url'] = base_url() . "storelinks/manage_storelinks";
		$config['total_rows'] = intval($this->storelinks_model->get_storelinks($page,'',true));
		$config['per_page'] = PAGE_LIMIT;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
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
		
		$view_data['content'] = $this->storelinks_model->get_storelinks($page, $config['per_page'], '', $store_id);
		$clients  = $this->storelinks_model->get_all_clients();
        $view_data['clients'] = $clients;
		$this->_vci_view('storelinks_managestorelinks', $view_data);
	}

	/*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer 
	*	Description: update storelinks status. if status is active then 
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
			$this->output->set_header('location:' . base_url() . 'storelinks/manage_storelinks');
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
            
		    $result = $this->storelinks_model->update_status($id, $status);
		    $this->session->set_flashdata('success', '<li> storelinks has been updated successfully.</li>');
		    $this->output->set_header('location:' . base_url() . 'storelinks/manage_storelinks' . (($page>0) ? '/' . $page : ''));
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method: delete_storelinks
	*	@param none
	*	Description: for deleting storelinks
	-----------------------------------------------------------------
	*/

	function delete_storelinks(){
		$this->_vci_layout('menu-toolbar');
		
		if($this->storelinks_model->delete_storelinks())
		{	
			$this->session->set_flashdata('success', 'storelinks deleted sucessfully');
			$this->output->set_header('location:' . base_url() . 'storelinks/manage_storelinks');
		}
		else {
		    $this->session->set_flashdata('errors','storelinks deletion failed');
			$this->output->set_header('location:'. base_url(). 'storelinks/manage_storelinks');
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
			$this->output->set_header('location:' . base_url() . 'storelinks/manage_storelinks');
		}
		
		//Toggles the status
		if(intval($remove ) == 1){
			$this->session->set_flashdata('success', '<li> Thumbnail removed sucessfuly .</li>');
			$this->output->set_header('location:' . base_url() . 'storelinks/edit_storelinks/'.$id );
			$result = $this->storelinks_model->remove_image($id); 
		}
		else{
			
			$this->output->set_header('location:' . base_url() . 'storelinks/edit_storelinks/'.$id );
		}
		//Update the status for the storelinks page and redirect to listing with success msg
	}
}

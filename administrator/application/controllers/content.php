<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:		Content extends VCI_Controller defined in libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description: Manage dynamic content by admin users. 
---------------------------------------------------------------
*/

class Content extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('content_model');
		$this->load->model('client_model');
		$this->load->model('user_model');
	}
	
	/*
	-----------------------------------------------------------------
	*	Method:edit_page
	*	@param id integer
	*	Description: update the page data identified by the id
	-----------------------------------------------------------------
	*/
	function edit_page($id = null)
	{
	    
	    if( isset( $this->session->userdata['user']['id'] ) && !empty( $this->session->userdata['user']['id'] ) )
		{
		    if( $this->user_model->is_admin_exists(  $this->session->userdata['user']['id'] ) )
		    {
		        $is_admin_login = $this->session->userdata['user']['id'];
		    }
		    else
		    {
		        
		        $client_id          = trim($this->session->userdata['user']['id']);
		        $client_username    = trim($this->session->userdata['user']['username']);
		        $is_client_exist    = $this->client_model->is_client_exists($client_username, $client_id);
		        $store_id           = $client_id;
		        $content_id         = $id;
		        $is_editable        = $this->content_model->is_content_editable( $store_id,  $content_id );
		        
		        if( !$is_editable )
		        {
		        
		            echo ' You are not authorized to see the page. ';die;
		        }
		        
            }
            
            
            
            if( !isset($is_client_exist) && !isset($is_admin_login) )
	        {
	            echo ' You are not authorized to see the page. ';die;
	        }
		}
		if( !isset($is_client_exist) && !isset($is_admin_login) )
	    {
	        echo ' You are not authorized to see the page. ';die;
	    }
	    
	    /////////////// 
	    
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit the page without page id.</li>");
				$this->output->set_header('location:' . base_url() . 'content/manage_content');
			}
		}
		
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		$view_data = array();

		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Content' => array('link'=>'content/manage_content', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Page' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit Content";
		
		//Set the validation rules for server side validation
		// rule name editcontent
		
		if($this->form_validation->run('editcontent')) {
			//Everything is ok lets update the page data
			if($this->content_model->update(trim($id))) {
				$this->session->set_flashdata('success', "<li>Page has been edited successfully.</li>");
				$this->output->set_header('location:' . base_url() . 'content/manage_content');
			} else {
				$this->session->set_flashdata('error', "<li>Unknown Error: Unable to edit page.</li>");
				$this->output->set_header('location:' . base_url() . 'content/manage_content');
			}
			
		} else {
			//Set the view data and render the view
			if( isset( $store_id ) ) 
			{
			    $page = $this->content_model->get_content_page(trim($id), $store_id );
			}
			else
			{
			   $page = $this->content_model->get_content_page(trim($id)); 
			}
			$view_data["id"] = $page->id;
			$view_data["page_title"] = $page->page_title;
			$view_data["page_name"] = $page->page_name;
			$view_data["page_metatitle"] = $page->page_metatitle;
			$view_data["page_metakeywords"] = $page->page_metakeywords;
			$view_data["page_metadesc"] = $page->page_metadesc;
			$view_data["page_content"] = $page->page_content;
			$view_data["status"] = $page->status;
			$this->_vci_view('content_editpage', $view_data);
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method:manage_content
	*	@param id integer
	*	Description: Fetch all content from database and render on screen
	-----------------------------------------------------------------
	*/

	function manage_content($page = 0) {
		
		
		$store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }
		//$store_id = 0;
				
		if( !isset($store_id) && empty($store_id) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }
		
		$this->_vci_layout('menu-toolbar');
		$view_data = array();
        
        $clients  = $this->content_model->get_all_clients();
        //echo '<pre>';print_r($clients);die;
        $view_data['clients'] = $clients;
        
           
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s') ;
		}
        
		//creates bread crumb
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Content' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		$view_data['caption'] = "Manage Content";
		//Load model and pagination library
		$this->load->library('pagination');
		
		//Set pagination configs
		
		$config['per_page'] = PAGE_LIMIT;
		
		//Fetch all pages from database
		if( isset( $store_id ) )
		{
		    $view_data['content'] = $this->content_model->get_content( $page, $config['per_page'], 'false' , $store_id );
		    $config['total_rows'] = intval($this->content_model->get_content( $page, $config['per_page'], 'false' , $store_id));
		}
		else
		{
		   $view_data['content'] = $this->content_model->get_content( $page, $config['per_page'] );
		   $config['total_rows'] = intval($this->content_model->get_content( $page, $config['per_page'], 'false'));
		}
		$getData = array('s'=>$qstr);
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() . "content/manage_content?s=".$qstr;
		$config['base_url'] = base_url() . "content/manage_content";
		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		
		$this->_vci_view('content_managecontent', $view_data);
	}

	/*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer 
	*	Description: update content status. if status is active then 
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
			$this->output->set_header('location:' . base_url() . 'content/manage_content');
		}
		
		//Toggles the status
		if(intval($status) == 1)
		{
			$status = 0;
		}
		else{
			$status = 1;
		}

		//Update the status for the content page and redirect to listing with success msg
		$result = $this->content_model->update_status($id, $status);
		$this->session->set_flashdata('success', '<li>Content has been updated successfully.</li>');
		$this->output->set_header('location:' . base_url() . 'content/manage_content' . (($page>0) ? '/' . $page : ''));
	}
}

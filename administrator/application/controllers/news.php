<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:		News extends VCI_Controller defined in libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:Manage news page by admin 
---------------------------------------------------------------
*/

class News extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
		$this->load->helper('resize');
	}
	
	/*
	-----------------------------------------------------------------
	* 	Method 		: add_news
	*	@param  	: 
	* Description 	: to add news
	*/
	function add_news()
	{
	    
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		//$view_data = array();
		$view_data['page_title'] = '';
		$view_data['page_shortdesc'] = '';
		$view_data['page_content'] = '';
		$view_data['page_metatitle'] = '';
		$view_data['page_metakeywords'] = '';

		$allowed_types = array('gif','png','jpg','jpeg','jpe','image/jpeg','image/gif','image/png','image/jpg','image/jpeg','image/jpe');

		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage News' => array('link'=>'news/manage_news', 'attributes' => array('class'=>'breadcrumb')),
			'Add News' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Add News";
		
		$this->load->library('upload');

		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{
			if(!empty($_FILES['thumb_image'])){
				$config['upload_path'] = '../uploads/news';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '5000';
				$config['max_width']  = '1024';
				$config['max_height']  = '768';

				$this->upload->initialize($config);
				if( ! $this->upload->do_upload('thumb_image')){
					// invalid image type 
					$error = array('error' => $this->upload->display_errors());
				}else{
					$uploadedData = $this->upload->data();
					$filepath = '/uploads/news/'.$uploadedData['file_name'];
				}
				
			}
            
			if($this->form_validation->run('addnews')) {
			//Everything is ok lets update the page data
				
				if(! $this->upload->display_errors() || ($this->upload->display_errors() == '<p>You did not select a file to upload.</p>' )){
					
                    $store_id = $this->session->userdata('storeId');
	                if( empty( $store_id ) )
                    {
                        $store_id = $this->storeId();
                    }
                    
                    //$consultantId = $this->session->userdata('consultantId');
                    $userDetails = $this->session->userdata("user");
					if( isset( $userDetails['role_id'] ) &&  $userDetails['role_id'] == 4 )
					{	
						$consultantId = $userDetails['id'];	
					}
					else
					{
						$consultantId = '';
					}

					// added by abhishek to show only the selected consultant data
					if(!$consultantId){
						$consultantId = $this->session->userdata('consultantId') ;
					}
					
					// added by abhishek to show only the selected consultant data ends here

					if($this->news_model->add($filepath, $store_id, $consultantId )) {
					
						$this->session->set_flashdata('success', "<li>News has been added successfully.</li>");
						$this->output->set_header('location:' . base_url() . 'news/manage_news');
					} else {
						$this->session->set_flashdata('error', "<li>Unknown Error: Unable to add news.</li>");
						$this->output->set_header('location:' . base_url() . 'news/manage_news');
					}
				}else{
					$view_data['page_title'] = $this->input->post('page_title');
					 $view_data['page_metatitle'] = $this->input->post('page_metatitle');
					 $view_data['page_metakeywords'] = $this->input->post('page_metakeywords');
					 $view_data['page_metadesc'] = $this->input->post('page_metadesc');
					 $view_data['page_shortdesc'] = $this->input->post('page_shortdesc');
					 $view_data['page_content'] = $this->input->post('page_content');
					 $this->_vci_view('news_addpage', $view_data);
				}	
			}else{
				 $view_data['page_title'] = $this->input->post('page_title');
				 $view_data['page_metatitle'] = $this->input->post('page_metatitle');
				 $view_data['page_metakeywords'] = $this->input->post('page_metakeywords');
				 $view_data['page_metadesc'] = $this->input->post('page_metadesc');
				 $view_data['page_shortdesc'] = $this->input->post('page_shortdesc');
				 $view_data['page_content'] = $this->input->post('page_content');
				 $this->_vci_view('news_addpage', $view_data);
			}
		}else
		{
			//form not submitted load view normally //
			$this->_vci_view('news_addpage', $view_data);
		}

	}

	/*
	-----------------------------------------------------------------
	*	Method:edit_page
	*	@param id integer
	*	Description: update the page data identified by the id
	-----------------------------------------------------------------
	*/
	function edit_news($id = null)
	{
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit news without news id.</li>");
				$this->output->set_header('location:' . base_url() . 'news/manage_news');
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
			'Manage News' => array('link'=>'news/manage_news', 'attributes' => array('class'=>'breadcrumb')),
			'Edit News' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit News";

		//Set the validation rules for server side validation

        $this->load->library('upload');
		if($this->input->post('formSubmitted') > 0) 
		{

			
			if($this->form_validation->run('addnews')) {
			    $filepath = $this->input->post('page_thumbnailpath') ;
			    
			    if(!empty($_FILES['thumb_image'])){

						$config['upload_path'] = '../uploads/news';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['max_size']	= '5000';
						$config['max_width']  = '1024';
						$config['max_height']  = '768';
						$this->upload->initialize($config);

						if( ! $this->upload->do_upload('thumb_image')){
							// invalid image type 
							$error = array('error' => $this->upload->display_errors());
							
						}else{
							$uploadedData = $this->upload->data() ;
							$filepath = '/uploads/news/'.$uploadedData['file_name'] ;	
						}
				}
				//Everything is ok lets update the page data
				if($this->news_model->update(trim($id),$filepath)) {
					$this->session->set_flashdata('success', "<li>News has been edited successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'news/manage_news');
				} else {
					$this->session->set_flashdata('error', "<li>Unknown Error: Unable to edit news.</li>");
					$this->output->set_header('location:' . base_url() . 'news/manage_news');
				}
			
			} else {
				//Set the view data and render the view in case validation fails
				$page = $this->news_model->get_news_page(trim($id));
				
				$view_data["id"] = $page->id;
				$view_data["page_title"] = $page->page_title;
				$view_data["page_shortdesc"] = $page->page_shortdesc;
				$view_data["page_thumbnailpath"] = $page->page_thumbnailpath;
				$view_data["page_metatitle"] = $page->page_metatitle;
				$view_data["page_metakeywords"] = $page->page_metakeywords;
				$view_data["page_metadesc"] = $page->page_metadesc;
				$view_data["page_content"] = $page->page_content; 
				$view_data["status"] = $page->status ; 
				$this->_vci_view('news_editpage', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			//Set the view data and render the view
			$page = $this->news_model->get_news_page(trim($id));

			$view_data["id"] = $page->id;
			$view_data["page_title"] = $page->page_title;
			$view_data["page_shortdesc"] = $page->page_shortdesc;
			$view_data["page_thumbnailpath"] = $page->page_thumbnailpath;
			$view_data["page_metatitle"] = $page->page_metatitle;
			$view_data["page_metakeywords"] = $page->page_metakeywords;
			$view_data["page_metadesc"] = $page->page_metadesc;
			$view_data["page_content"] = $page->page_content; 
			$view_data["status"] = $page->status ; 
			$this->_vci_view('news_editpage', $view_data);
		}	
	}

	function edit_newsnew($id = null)
	{
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit news without news id.</li>");
				$this->output->set_header('location:' . base_url() . 'news/manage_news');
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
			'Manage News' => array('link'=>'news/manage_news', 'attributes' => array('class'=>'breadcrumb')),
			'Edit News' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit News";
		
		//Set the validation rules for server side validation
		
        $this->load->library('upload');
		if($this->input->post('formSubmitted') > 0) 
		{

			$this->load->library('upload');
			$filepath = $this->input->post('page_thumbnailpath') ;
			    
			    if(!empty($_FILES['thumb_image'])){
						$config['upload_path'] = '../uploads/news';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['max_size']	= '5000';
						$config['max_width']  = '1024';
						$config['max_height']  = '768';
						$this->upload->initialize($config);

						if( ! $this->upload->do_upload('thumb_image')){
							// invalid image type 
							$error = array('error' => $this->upload->display_errors());
							
						}else{
							$uploadedData = $this->upload->data() ;
							$filepath = '/uploads/news/'.$uploadedData['file_name'] ;	
						}
				}

			if($this->form_validation->run('addnews')) {
			    
			    if(! $this->upload->display_errors() || ($this->upload->display_errors() == '<p>You did not select a file to upload.</p>' )){
			    	//Everything is ok lets update the page data
					if($this->news_model->update(trim($id),$filepath)) {
						$this->session->set_flashdata('success', "<li>News has been edited successfully.</li>");
						$this->output->set_header('location:' . base_url() . 'news/manage_news');
					} else {
						$this->session->set_flashdata('error', "<li>Unknown Error: Unable to edit news.</li>");
						$this->output->set_header('location:' . base_url() . 'news/manage_news');
					}

			    }else{

			    	$page = $this->news_model->get_news_page(trim($id));
				
					$view_data["id"] = $page->id;
					$view_data["page_title"] = $page->page_title;
					$view_data["page_shortdesc"] = $page->page_shortdesc;
					$view_data["page_thumbnailpath"] = $page->page_thumbnailpath;
					$view_data["page_metatitle"] = $page->page_metatitle;
					$view_data["page_metakeywords"] = $page->page_metakeywords;
					$view_data["page_metadesc"] = $page->page_metadesc;
					$view_data["page_content"] = $page->page_content; 
					$view_data["status"] = $page->status ; 
					$this->_vci_view('news_editpage', $view_data);
			    }
				
			} else {
				//Set the view data and render the view in case validation fails
				$page = $this->news_model->get_news_page(trim($id));
				
				$view_data["id"] = $page->id;
				$view_data["page_title"] = $page->page_title;
				$view_data["page_shortdesc"] = $page->page_shortdesc;
				$view_data["page_thumbnailpath"] = $page->page_thumbnailpath;
				$view_data["page_metatitle"] = $page->page_metatitle;
				$view_data["page_metakeywords"] = $page->page_metakeywords;
				$view_data["page_metadesc"] = $page->page_metadesc;
				$view_data["page_content"] = $page->page_content; 
				$view_data["status"] = $page->status ; 
				$this->_vci_view('news_editpage', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			//Set the view data and render the view
			$page = $this->news_model->get_news_page(trim($id));
$store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }

        if( !isset($store_id) && empty($store_id) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }
	    
			$view_data["id"] = $page->id;
			$view_data["page_title"] = $page->page_title;
			$view_data["page_shortdesc"] = $page->page_shortdesc;
			$view_data["page_thumbnailpath"] = $page->page_thumbnailpath;
			$view_data["page_metatitle"] = $page->page_metatitle;
			$view_data["page_metakeywords"] = $page->page_metakeywords;
			$view_data["page_metadesc"] = $page->page_metadesc;
			$view_data["page_content"] = $page->page_content; 
			$view_data["status"] = $page->status ; 
			$this->_vci_view('news_editpage', $view_data);
		}	
	}

	/*
	-----------------------------------------------------------------
	*	Method: manage_news
	*	@param id integer
	*	Description: Fetch all City from database and render on screen
	-----------------------------------------------------------------
	*/
	function manage_news($page = 0) {
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
			'Manage News' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		$view_data['caption'] = "Manage News";
		//Load model and pagination library
		$this->load->library('pagination');
		
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
		if( isset( $userDetails['role_id'] ) &&  $userDetails['role_id'] == 4 )
		{	
			$consultantId = $userDetails['id'];	
		}
		else
		{
			$consultantId = '';
		}

		// added by abhishek to show only the selected consultant data
		if(!$consultantId){
			$consultantId = $this->session->userdata('consultantId') ;
		}
		// added by abhishek to show only the selected consultant data ends here
		//echo 'consultant id'.$consultantId ;
		//Set pagination configs
		$getData = array('s'=>$qstr);
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");

		$config['first_url'] = base_url() . "news/manage_news?s=".$qstr;
			
		$config['base_url'] = base_url() . "news/manage_news";
		$config['total_rows'] = intval($this->news_model->get_news($page,PAGE_LIMIT,true, $store_id, $consultantId));
		$config['per_page'] = PAGE_LIMIT;
		$this->pagination->initialize( $config );
		$view_data['pagination'] = $this->pagination->create_links();
		//Fetch all pages from database

	    $view_data['clients_consultant'] = $this->news_model->all_clients_consultant();
        $clients  = $this->news_model->get_all_clients();
        $view_data['clients'] = $clients;
        
	    $view_data['content'] = $this->news_model->get_news($page, PAGE_LIMIT,'', $store_id, $consultantId );
	
	    //$view_data['content'] = $this->news_model->get_news($page, $config['per_page']);
		$view_data['clients_consultant']  = $this->news_model->all_clients_consultant();
		
		if(isset($this->session->userdata))
		{
			$cons_role_id = $this->session->userdata('user');
			$view_data['consultant_role_id'] = $cons_role_id['role_id'];
		}
		
		$this->_vci_view('news_managenews', $view_data);
	}

	/*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer 
	*	Description: update news status. if status is active then 
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
			$this->output->set_header('location:' . base_url() . 'news/manage_news');
		}
		
		//Toggles the status
		if(intval($status) == 1)
		{
			$status = 0;
		}
		else{
			$status = 1;
		}

		//Update the status for the news page and redirect to listing with success msg
		$result = $this->news_model->update_status($id, $status);
		$this->session->set_flashdata('success', '<li> News has been updated successfully.</li>');
		$this->output->set_header('location:' . base_url() . 'news/manage_news' . (($page>0) ? '/' . $page : ''));
	}

	/*
	-----------------------------------------------------------------
	*	Method: delete_news
	*	@param none
	*	Description: for deleting news
	-----------------------------------------------------------------
	*/

	function delete_news(){
		$this->_vci_layout('menu-toolbar');
		
		if($this->news_model->delete_news())
		{	
			$this->session->set_flashdata('success', 'News deleted sucessfully');
			$this->output->set_header('location:' . base_url() . 'news/manage_news');
		}
		else {
		    $this->session->set_flashdata('errors','News deletion failed');
			$this->output->set_header('location:'. base_url(). 'news/manage_news');
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
			$this->output->set_header('location:' . base_url() . 'news/manage_news');
		}
		
		//Toggles the status
		if(intval($remove ) == 1){
			$this->session->set_flashdata('success', '<li> Thumbnail removed sucessfuly .</li>');
			$this->output->set_header('location:' . base_url() . 'news/edit_news/'.$id );
			$result = $this->news_model->remove_image($id); 
		}
		else{
			
			$this->output->set_header('location:' . base_url() . 'news/edit_news/'.$id );
		}
		//Update the status for the news page and redirect to listing with success msg
	}
}

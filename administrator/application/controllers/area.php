<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:		 Area extends VCI_Controller defined in libraries
*	Author: 	 Abhishek Srivastav
*	Platform:	 Codeigniter
*	Company:	 Cogniter Technologies
*	Description: Manage area page by admin 
---------------------------------------------------------------
*/

class Area extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('area_model');
	}
	
	/*
	* Method 		: add_area
	* @param  		: none
	* Description 	: to add area
	*/
	function add_area()
	{
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		$view_data['name'] = '';
		$view_data['page_metadesc'] = '';
		$view_data['page_content'] = '';
		$view_data['page_metakeywords'] = '';

		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage area' => array('link'=>'area/manage_area', 'attributes' => array('class'=>'breadcrumb')),
			'Add area' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "area [Add]";

		//Set the validation rules for server side validation
		// rule name addarea

		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{
			//$this->form_validation->set_rules('name', 'Name', 'is_name_exists');

			if($this->form_validation->run('addarea')) {
			//Everything is ok lets update the page data
				
				if($this->area_model->add()) {
					
					$this->session->set_flashdata('success', "<li>area has been added successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'area/manage_area');
				} else {

					$this->session->set_flashdata('error', "<li>Unknown Error: Unable to add area.</li>");
					$this->output->set_header('location:' . base_url() . 'area/manage_area');
				}
			
			} else {
				
			 $view_data['name'] = $this->input->post('page_title');
			 $view_data['page_metakeywords'] = $this->input->post('page_metakeywords');
			 $view_data['page_metadesc'] = $this->input->post('page_metadesc');
			 $view_data['page_content'] = $this->input->post('page_content');
    
			 $this->_vci_view('area_addpage', $view_data);

			}
		}else
		{
			//form not submitted load view normally //
			$this->_vci_view('area_addpage', $view_data);
		}

	}

	/*
	* form validation for unique name
		of city
	*/
	function is_name_exists($name, $id = null)
	{
		
		$id = intval($this->input->post('id'));

		if(!empty($id))
			$this->db->where(array('name'=>$name, 'id !=' => $id));
		else
			$this->db->where(array('name'=>$name));

		$this->db->from('area');
		$users = $this->db->count_all_results();

		if($users > 0)
		{
			$this->form_validation->set_message('is_name_exists', "The %s <b>$name</b> is already exists.");
			return false;
		}
		else
			return true;
	}

	/*
	-----------------------------------------------------------------
	*	Method:		 edit_page
	*	@param 		 id integer
	*	Description: update the page data identified by the id
	-----------------------------------------------------------------
	*/
	function edit_area($id = null)
	{
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit area without area id.</li>");
				$this->output->set_header('location:' . base_url() . 'area/manage_area');
			}
		}
		
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$view_data = array();
		
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage area' => array('link'=>'area/manage_area', 'attributes' => array('class'=>'breadcrumb')),
			'Edit area' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "area [Edit Page]";
		
		//Set the validation rules for server side validation
		// rule name  addarea

		if($this->input->post('formSubmitted') > 0) 
		{

			if($this->form_validation->run('addarea')) {
				//Everything is ok lets update the page data
				if($this->area_model->update(trim($id))) {
					$this->session->set_flashdata('success', "<li>area has been edited successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'area/manage_area');
				} else {
					$this->session->set_flashdata('error', "<li>Unknown Error: Unable to edit area.</li>");
					$this->output->set_header('location:' . base_url() . 'area/manage_area');
				}
			
			} else {
				//Set the view data and render the view in case validation fails
				$page = $this->area_model->get_area_page(trim($id));
				
				$view_data["id"] = $page->id;
				$view_data['name'] = $page->name;
			 	$view_data['page_metakeywords'] = $page->page_metakeywords;
			 	$view_data['page_metadesc'] = $page->page_metadesc;
			 	$view_data['page_content'] = $page->page_content;
			 	$view_data['status'] = $page->status;
				 
				$this->_vci_view('area_editpage', $view_data);
			}
		}else{
			// form not submitted load view noramally 
			//Set the view data and render the view
			$page = $this->area_model->get_area_page(trim($id));

			$view_data["id"] = $page->id;
			$view_data['name'] = $page->name;
		 	$view_data['page_metakeywords'] = $page->page_metakeywords;
		 	$view_data['page_metadesc'] = $page->page_metadesc;
		 	$view_data['page_content'] = $page->page_content;
		 	$view_data['status'] = $page->status;

			$this->_vci_view('area_editpage', $view_data);
		}
		
	}

	/*
	-----------------------------------------------------------------
	*	Method: manage_area
	*	@param id integer
	*	Description: Fetch all City from database and render on screen
	-----------------------------------------------------------------
	*/

	function manage_area($page = 0) {
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
			'Manage area' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		$view_data['caption'] = "Manage area";
		//Load model and pagination library
		
		$this->load->library('pagination');
		
		//Set pagination configs
		$getData = array('s'=>$qstr);
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");

		$config['first_url'] = base_url() . "area/manage_area?s=".$qstr;

		$config['base_url'] = base_url() . "area/manage_area";
		$config['total_rows'] = intval($this->area_model->get_area($page,'',true));
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		
		//Fetch all pages from database
		$view_data['content'] = $this->area_model->get_area($page, $config['per_page']);
		
		$this->_vci_view('area_managearea', $view_data);
	}

	/*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer 
	*	Description: update area status. if status is active then 
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
			$this->output->set_header('location:' . base_url() . 'area/manage_area');
		}
		
		//Toggles the status
		if(intval($status) == 1)
			$status = 0;
		else
			$status = 1;

		//Update the status for the area page and redirect to listing with success msg
		$result = $this->area_model->update_status($id, $status);
		$this->session->set_flashdata('success', '<li> area has been updated successfully.</li>');
		$this->output->set_header('location:' . base_url() . 'area/manage_area' . (($page>0) ? '/' . $page : ''));
	}

	/*
	-----------------------------------------------------------------
	*	Method: delete_area
	*	@param none
	*	Description: to delete area/city page
	-----------------------------------------------------------------
	*/
	function delete_area(){
		$this->_vci_layout('menu-toolbar');
		
		if($this->area_model->delete_area())
		{	
			$this->session->set_flashdata('success', 'area deleted sucessfully');
			$this->output->set_header('location:' . base_url() . 'area/manage_area');
		}
		else {
		    $this->session->set_flashdata('errors','area deletion failed');
			$this->output->set_header('location:'. base_url(). 'area/manage_area');
		}
	}
}
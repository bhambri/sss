<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:		taxes  extends VCI_Controller defined in libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:Manage taxes page by admin 
---------------------------------------------------------------
*/

class Taxes extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('tax_model');
		$this->load->helper('resize');
	}
	
	/*
	-----------------------------------------------------------------
	* 	Method 		: add_tax
	*	@param  	: 
	* Description 	: to add tax
	*/
	function add_tax()
	{
	
	    //Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Tax Settings' => array('link'=>'taxes/manage_taxes', 'attributes' => array('class'=>'breadcrumb')),
			'Add Tax' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Add Tax";
		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{
			if($this->form_validation->run('addtax')) 
			{
			
			    $session_data =  $this->session->userdata('user');
                $store_id = $session_data['id'];
			//Everything is ok lets update the page data
				if($this->tax_model->add( $store_id )) 
				{
					$this->session->set_flashdata('success', "<li>Tax has been added successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'taxes/manage_taxes');
				} 
				else 
				{
					$this->session->set_flashdata('error', "<li>Unknown Error: Unable to add tax.</li>");
					$this->output->set_header('location:' . base_url() . 'taxes/manage_taxes');
				}
				$this->_vci_view('tax_add', $view_data);
			}
			else
			{
				 $this->_vci_view('tax_add', $view_data);
			}
		}
		else
		{
			//form not submitted load view normally //
			$this->_vci_view('tax_add', $view_data);
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method:edit_page
	*	@param id integer
	*	Description: update the page data identified by the id
	-----------------------------------------------------------------
	*/
	function edit_tax($id = null)
	{
		//Check if we have got the page id
		if(is_null($id)) {
			$id = intval($this->input->post('id'));
			if(empty($id)) {
				$this->session->set_flashdata('error', "<li>Unable to edit tax without tax id.</li>");
				$this->output->set_header('location:' . base_url() . 'taxes/manage_taxes');
			}
		}
		//Get/Set the required layout and libraries and initiates view variables
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		//create breadcrumbs
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Tax Settings' => array('link'=>'taxes/manage_taxes', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Tax' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		//Set the view crumbs
		$view_data['crumbs'] = $crumbs;
		//Set the view caption
		$view_data['caption'] = "Edit Tax";

		//Set the validation rules for server side validation
        $session_data =  $this->session->userdata('user');
        $store_id = $session_data['id'];
		if($this->input->post('formSubmitted') > 0) 
		{
			if($this->form_validation->run('addtax'))
			{
				if($this->tax_model->update( trim ($id), $store_id ) )
				{
					$this->session->set_flashdata('success', "<li>Tax has been updated successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'taxes/manage_taxes');
				} 
				else 
				{
					$this->session->set_flashdata('errors', "<li>Unknown Error: Unable to edit tax.</li>");
					$this->output->set_header('location:' . base_url() . 'taxes/manage_taxes');
				}
			
			} 
			else 
			{
				//Set the view data and render the view in case validation fails
				$page = $this->tax_model->get_tax_page(trim($id), $store_id );
				$view_data["id"]          = $id;
				$view_data["state_code"]  = $page->state_code;
				$view_data["tax"]         = $page->tax;
				
				$this->_vci_view('tax_editpage', $view_data);
			}
		}
		else
		{
			// form not submitted load view noramally 
			//Set the view data and render the view
			$page = $this->tax_model->get_tax_page(trim($id), $store_id);
			
            $view_data["id"]          = $id;
			$view_data["state_code"]  = $page->state_code;
			$view_data["tax"]         = $page->tax;
			$this->_vci_view('tax_editpage', $view_data);
		}	
	}

	
	/*
	-----------------------------------------------------------------
	*	Method: manage_tax
	*	@param id integer
	*	Description: Fetch all City from database and render on screen
	-----------------------------------------------------------------
	*/
	function manage_taxes($page = 0) 
	{
		
        $session_data =  $this->session->userdata('user');
	    $s_id = $this->session->userdata('user');
		$store_id = $s_id['id'];
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}

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
			'Tax Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		$view_data['caption'] = "Tax Settings";
		//Load model and pagination library
		$this->load->library('pagination');
		
		//Set pagination configs
		$qstr = '' ;
		$getData = array('s'=>@$qstr);
		$config['per_page'] = PAGE_LIMIT;
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
        
		$config['first_url'] = base_url() . "taxes/manage_taxes?s=".$qstr;
			
		$config['base_url'] = base_url() . "taxes/manage_taxes";
		
		$config['total_rows'] = intval($this->tax_model->get_tax_state($page,$config['per_page'],true,$qstr,$store_id));
		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		//Fetch all pages from database
		
		$view_data['content'] = $this->tax_model->get_tax_state($page,$config['per_page'] ,false,$qstr,$store_id) ;
		
		$this->_vci_view('tax_managetax', $view_data);
	}

	/*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer 
	*	Description: update tax status. if status is active then 
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
			$this->output->set_header('location:' . base_url() . 'taxes/manage_taxes');
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
          
		    $result = $this->tax_model->update_status($id, $status);
		    $this->session->set_flashdata('success', '<li> Tax has been updated successfully.</li>');
		    $this->output->set_header('location:' . base_url() . 'taxes/manage_taxes' . (($page>0) ? '/' . $page : ''));
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method: delete_tax
	*	@param none
	*	Description: for deleting tax
	-----------------------------------------------------------------
	*/

	function delete_tax(){
		$this->_vci_layout('menu-toolbar');
		
		if($this->tax_model->delete_tax())
		{	
			$this->session->set_flashdata('success', 'Tax deleted sucessfully');
			$this->output->set_header('location:' . base_url() . 'taxes/manage_taxes');
		}
		else {
		    $this->session->set_flashdata('errors','Tax deletion failed');
			$this->output->set_header('location:'. base_url(). 'taxes/manage_taxes');
		}
	}
	
}

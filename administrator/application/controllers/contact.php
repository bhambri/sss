<?php
/*
---------------------------------------------------------------
*	Class	:	Contact extends VCI_Controller defined in libraries
*	Author	:	Jaidev Bangar , Abhishek Sr
*	Platform:	Codeigniter
*	Company	:	Cogniter Technologies
*	Description:	Manage access to contacts by admin users. 
---------------------------------------------------------------
*/
class Contact extends VCI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('contact_model');
	}

	/*
	************************************************************
	**	Function Name : View_contact()
	**	Functionality : Show Conatct Information 
	**	Called From   : Controller - contact.php
	*************************************************************
	*/
	function view_contact($id = null)
	{
			if(is_null($id)) {
			$id = $this->input->post('id');
			if(empty($id)) {
				$this->session->set_flashdata('errors', "Unable to view the page without page id.");
				$this->output->set_header('location:' . base_url() . 'content/manage_content');
			}
		}

		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$view_data = array();

		//creates bread crumb
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Contact Us' => array('link'=>'contact/manage_contact', 'attributes' => array('class'=>'breadcrumb')),
			'View Contact' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
			$view_data['crumbs'] = $crumbs;
			$view_data['caption'] = "View Contact";
			
			$store_id = $this->session->userdata('storeId');
            if( empty( $store_id ) )
            {
                $store_id = $this->storeId();
            }
            if( isset( $this->session->userdata['user']['is_admin'] ) )
            {
                $store_id = 0;
            }
			$page = $this->contact_model->get_contact_page(trim($id), $store_id );
			
			$view_data["id"] = $page->id;
			$view_data["firstname"] = $page->name;
			$view_data["address"] = $page->address;
			$view_data["request_date"] = $page->date;
			$view_data["phone"] = $page->phone;
			$view_data["email"] = $page->email;
			$view_data["city"] = $page->city;
			$view_data["comments"] = $page->comments;
			$view_data["contact_type"] = $page->contact_type;
			
			$this->_vci_view('contact_viewpage', $view_data);
		
	}

	/*
	************************************************************
	**	Function Name : view_enquiry()
	**	Functionality : Show Enquiry Information 
	**	Called From   : Controller - contact.php
	**	param   :       none
	*************************************************************
	*/
	function view_enquiry($id = null)
	{
			if(is_null($id)) {
			$id = $this->input->post('id');
			if(empty($id)) {
				$this->session->set_flashdata('errors', "Unable to view the page without page id.");
				$this->output->set_header('location:' . base_url() . 'content/manage_enquires');
			}
		}

		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$view_data = array();

		//creates bread crumb
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Enquiries' => array('link'=>'contact/manage_enquires', 'attributes' => array('class'=>'breadcrumb')),
			'View Enquiry' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
			$view_data['crumbs'] = $crumbs;
			$view_data['caption'] = "View Enquiry";
			$page = $this->contact_model->get_contact_page(trim($id));
			
			$view_data["id"] = $page->id;
			$view_data["firstname"] = $page->name;
			$view_data["address"] = $page->address;
			$view_data["request_date"] = $page->date;
			$view_data["phone"] = $page->phone;

			$view_data["contact_type"] = $page->contact_type;
			$view_data["no_of_units"] = $page->no_of_units;
			$view_data["looking_to_invest"] = $page->looking_to_invest;
			$view_data["address"] = $page->address;
			$view_data["city"] = $page->city;
			$view_data["state"] = $page->state;
			$view_data["zip_code"] = $page->zip_code;
			$view_data["email"] = $page->email;
			$view_data["comments"] = $page->comments;
			
			$this->_vci_view('contact_viewpage', $view_data);	
	}

	/*
	******************************************************************
	**	Function Name : manage_contact() .
	**	purpose: for managing contact us data
	**  param  none
	******************************************************************
	*/
	function manage_contact($page = 0)
	{
		$this->_vci_layout('menu-toolbar');
		$view_data = array();
		$view_data['caption'] = "Manage Contact Us Requests";
		// contact/manage_contact?s=h
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s') ;
		}
		
		//creates bread crumb
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Contact Us Requests' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));

		$view_data['crumbs'] = $crumbs;

		$this->load->library('pagination');
		
		//set pagination configs
		
		$store_id = $this->session->userdata('storeId');
        if( empty( $store_id ) )
        {
            $store_id = $this->storeId();
        }
				
		if( !isset($store_id) && empty($store_id) )
	    {
	        echo ' You are not authorized to see the page.';die;
	    }

		$clients  = $this->contact_model->get_all_clients();
		
        $view_data['clients'] = $clients;

		$getData = array('s'=>$qstr);

		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");

		$config['first_url'] = base_url() . "contact/manage_contact?s=".$qstr;
		$config['base_url'] = base_url() . "contact/manage_contact";

		$config['total_rows'] = intval($this->contact_model->get_contact('','',true,$store_id));
		$config['per_page'] = PAGE_LIMIT;
		$this->pagination->initialize($config);

		$view_data['contact'] = $this->contact_model->get_contact($page, $config['per_page'],'', $store_id );
		
		$view_data['pagination'] = $this->pagination->create_links();
		
		$this->_vci_view('manage_contact', $view_data);
	}

	/*
	******************************************************************
	**	Function Name : manage_enquires() .
	**	purpose: for managing enquiries data received
	**  param  page integer
	******************************************************************
	*/
	function manage_enquires($page = 0)
	{
		$this->_vci_layout('menu-toolbar');
		$view_data = array();
		$view_data['caption'] = "Manage Enquires";
		
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s') ;
		}

		//creates bread crumb
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Enquires' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));

		$view_data['crumbs'] = $crumbs;

		$this->load->library('pagination');
		
		//set pagination configs
		$getData = array('s'=>$qstr);
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() . "contact/manage_enquires?s=".$qstr;
		$config['base_url'] = base_url() . "contact/manage_enquires";
		$config['total_rows'] = intval($this->contact_model->get_enquiry('','',true));
		$config['per_page'] = PAGE_LIMIT;
		
		$this->pagination->initialize($config);

		$view_data['pagination'] = $this->pagination->create_links();
		
		//fetch all users from database except current user and super user
		$view_data['contact'] = $this->contact_model->get_enquiry($page, $config['per_page']);

		$this->_vci_view('manage_enquiry', $view_data);
	}

	/**
	******************************************************************
	**	Method : Delete_contact
	**	@Action: Delete Contact From Database
	**  param   ; deleting contact info
	******************************************************************
	*/
	function delete_contact()
	{
		$this->_vci_layout('menu-toolbar');
		
		$result = $this->contact_model->delete_contact();
        if($result)
		{
             $this->session->set_flashdata('success', '<li>Contact(s) have been deleted successfully.</li>');
		}
         else
        {
          
         $this->session->set_flashdata('success', '<li>No contacts are available to delete.</li>');
		}
		$this->output->set_header('location:' . base_url() . 'contact/manage_contact');
	}

	/**
	******************************************************************
	**	Method : delete_enquiry
	**	@Action: Delete enquiry from database
	**  param   ; deleting contact info
	******************************************************************
	*/
	function delete_enquiry()
	{
		$this->_vci_layout('menu-toolbar');
		
		$result = $this->contact_model->delete_contact();
        if($result)
		{
             $this->session->set_flashdata('success', '<li>Enquiry have been deleted successfully.</li>');
		}
         else
        {
         $this->session->set_flashdata('success', '<li>No Enquiries are available to delete.</li>');
		}
		$this->output->set_header('location:' . base_url() . 'contact/manage_enquires');
	}

}

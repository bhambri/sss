<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-------------------------------------------------------------
*	Class:	User extends VCI_Controller defined in libraries
*	Author:	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description: Manage user entity
-------------------------------------------------------------
*/
class Template extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('template_model');
	}

	
	/*
	-----------------------------------------------------------------
	*	Method: manage
	*	@param page integer
	*	Description: creates listing and handles search operations
	-----------------------------------------------------------------
	*/

	function manage($page = 0)
	{
		
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		
		//prepare the data for exporting to view
		$view_data = array('caption' => 'Manage Templates');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Templates' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		//set pagination configs
		$config['base_url'] = base_url() . "template/manage";
		$config['total_rows'] = intval($this->template_model->get_all_templates( '','',true ));
		$config['per_page'] = PAGE_LIMIT;		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		//fetch all users from database except current user and super user
		$view_data['email_templates'] = $this->template_model->get_all_templates( $page, PAGE_LIMIT, false );
		$this->_vci_view('template_manage', $view_data);
	}

	
	/*
	-----------------------------------------------------------------
	*	Method: edit_user
	*	@param id integer
	*	Description: edit user information
	-----------------------------------------------------------------
	*/

	function edit($id = null)
	{
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		if( $id==0 || $id=='0' )
		{
			$this->session->set_flashdata('success', $this->lang->line('template_update_fail'));
			$this->output->set_header('location:' . base_url() . 'template/manage');
		}
		//prepare data to export to view
		$view_data = array('caption' => 'Edit Template');
		$view_data['template_detail'] = $this->template_model->get_template_details($id);
		
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Templates'=> array('link'=>'template/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Template' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		
		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{	
			//run the form validation using the rules defined in config file
			if($this->form_validation->run('email_template'))
			{
				$post_data = array(
						'name'     => htmlspecialchars($this->input->post('name', true)),
						'content'  => $this->input->post('content'),
						'modified' => date("Y-m-d h:i:s"),
				);
					
				if($this->template_model->update_template($id, $post_data))
				{
					$this->session->set_flashdata('success', $this->lang->line('template_update_success'));
					$this->output->set_header('location:' . base_url() . 'template/manage');
				}
				else
				{
					$this->session->set_flashdata('success', $this->lang->line('template_update_fail'));
					$this->output->set_header('location:' . base_url() . 'template/manage');
				}
			} 
			else
			{
				//form validation fails load the view.
				$this->_vci_view('template_edit', $view_data);
			}
		} 
		else
		{
			//load the view normally
			$this->_vci_view('template_edit', $view_data);
		}
	}
}
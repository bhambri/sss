<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-------------------------------------------------------------
*	Class:	Executives extends VCI_Controller defined in libraries
*	Author:	
*	Platform:	Codeigniter
*	Company:	Segnant Technologies
*	Description: Manage user entity
-------------------------------------------------------------
*/
class Executives extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('executives_model');
	}

	/*
	-----------------------------------------------
	*	Method: New User
	*	Description: Registers a new user.
	-----------------------------------------------
	*/
	function executive_new()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
	
		$s_id = $this->session->userdata('user');
		
		$store_id = $s_id['id'];
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		
		//sets the data form exporting to view
		$view_data = array('caption' => 'Add Executive Level');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Executive Level Settings' => array('link'=>'executives/executive_manage', 'attributes' => array('class'=>'breadcrumb')),
			'Add Executive Level' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		
		if($this->input->post('formSubmitted') > 0) 
		{	
			if($this->form_validation->run('executive_add'))
			{	
				$post_data = array(
						'store_id'         => $store_id,
						'executive_level'  => htmlspecialchars($this->input->post('e_level', true)),

						'exec_order'  => htmlspecialchars($this->input->post('exec_order', true)),
						'bonus_amt'  => htmlspecialchars($this->input->post('bonus_amt', true)),

						'generation_access'=> htmlspecialchars($this->input->post('g_access', true)),
						'direct_commision' => htmlspecialchars($this->input->post('d_commission', true)),
						'configurable_volume_percentage' => htmlspecialchars($this->input->post('configurable_volume_percentage', true)),
						'personal_purchase_volume' => htmlspecialchars($this->input->post('personal_purchase_volume', true)),
						'personal_customer_volume' => htmlspecialchars($this->input->post('personal_customer_volume', true)),
						'configurable_binary_volume' => htmlspecialchars($this->input->post('configurable_binary_volume', true))
				);
				
				if($this->executives_model->executive_add( $post_data ))
				{
					$this->session->set_flashdata('success', $this->lang->line('executive_level_add_success'));
					$this->output->set_header('location:' . base_url() . 'executives/executive_manage');
				} 
			} 
			else
			{
				$this->_vci_view('executive_new', $view_data);
			}
		} 
		else
		{
			$this->_vci_view('executive_new', $view_data);
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method: is_user_exists
	*	@param username string
	*	Description: Callback method used for unique username check
		by form validation rules defined in config/form_validation.php
	-----------------------------------------------------------------
	*/
	function is_data_exists($username)
	{
		return (!empty($this->userid)) ? !$this->user_model->is_user_exists($username, $this->userid) : !$this->user_model->is_user_exists($username);
	}

	/*
	-----------------------------------------------------------------
	*	Method: is_email_exists
	*	@param email string
	*	Description: Callback method used for unique email check by
		form validation rules defined in config/form_validation.php
	-----------------------------------------------------------------
	*/

	function is_email_exists($email)
	{
		$this->load->model('user_model');
		return (!empty($this->userid)) ? !$this->user_model->is_email_exists($email, $this->userid) : !$this->user_model->is_email_exists($email);
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: manage
	*	@param page integer
	*	Description: creates listing and handles search operations
	-----------------------------------------------------------------
	*/

	function executive_manage($page = 0)
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		
	    $store_id = $this->session->userdata('storeId');
	    if( empty( $store_id ) )
	    {
	        $store_id = $this->storeId();
	    }
		
		//prepare the data for exporting to view
		$view_data = array('caption' => 'Executive Level Settings');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Executive Level Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		//set pagination configs
		$config['base_url'] = base_url() . "executives/executive_manage";
		$config['total_rows'] = intval($this->executives_model->get_all_executives('','',true, $store_id ));
		$config['per_page'] = PAGE_LIMIT;		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		//fetch all users from database except current user and super user
		$view_data['executives'] = $this->executives_model->get_all_executives($page, PAGE_LIMIT, false, $store_id );
		$this->_vci_view('executive_manage', $view_data);
	}

	
	
	/*
	-----------------------------------------------------------------
	*	Method: delete_user
	*	Description: Deletes a user from database and redirect to 
		manage
	-----------------------------------------------------------------
	*/

	function executive_delete()
	{
		$this->_vci_layout('menu-toolbar');
		
		if($this->executives_model->delete_executive())
		{
			$this->session->set_flashdata('success', $this->lang->line('executive_del_success'));
			$this->output->set_header('location:' . base_url() . 'executives/executive_manage');
		}
		else {
		    $this->session->set_flashdata('errors',$this->lang->line('executive_del_failed'));
			$this->output->set_header('location:'. base_url(). 'executives/executive_manage');
		}
	}
	
	/**
	 * is_executive_level_exists
	 * checking for executive level exist
	 */
	
	function is_executive_level_exists()
	{
		$id              = $this->input->post('id');
		$executive_level = htmlspecialchars($this->input->post('e_level', true));
		$s_id            = $this->session->userdata('user');
		$store_id        = $s_id['id'];
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		//echo $store_id ;
		//die;
		if($this->executives_model->is_executive_level_exists($executive_level, $store_id, $id))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	
	/*
	-----------------------------------------------------------------
	*	Method: edit_user
	*	@param id integer
	*	Description: edit user information
	-----------------------------------------------------------------
	*/

	function executive_edit($id = null)
	{
		ini_set('display_errors',1);
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		//get userid either from argument passed or from posted fields
		$this->executive_id = (isset($id)) ? $id : $this->input->post('id');
		//check if user id is not empty
		if(empty($this->executive_id))
		{
			$this->session->set_flashdata('errors', $this->lang->line('user_edit_id_error'));
			$this->output->set_header('location:' . base_url() . 'user/manage');
		}

		//prepare data to export to view
		$view_data = array('caption' => 'Edit Executive Level');
		
		//get the user details by user id
		$view_data['executive'] = $this->executives_model->get_executive_level_details($this->executive_id);
		
		//set breadcrumb
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Executive Levels'=> array('link'=>'executives/executive_manage', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Executive Level' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		
		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{	
			//run the form validation using the rules defined in config file
			if($this->form_validation->run('executive_add'))
			{
				$post_data = array(
						'executive_level'  => htmlspecialchars($this->input->post('e_level', true)),

						'exec_order'  => htmlspecialchars($this->input->post('exec_order', true)),
						'bonus_amt'  => htmlspecialchars($this->input->post('bonus_amt', true)),

						'generation_access'=> htmlspecialchars($this->input->post('g_access', true)),
						'direct_commision' => htmlspecialchars($this->input->post('d_commission', true)),
						'configurable_volume_percentage' => htmlspecialchars($this->input->post('configurable_volume_percentage', true)),
						'personal_purchase_volume' => htmlspecialchars($this->input->post('personal_purchase_volume', true)),
						'personal_customer_volume' => htmlspecialchars($this->input->post('personal_customer_volume', true)),
						'configurable_binary_volume' => htmlspecialchars($this->input->post('configurable_binary_volume', true)),
						'modified'         => date("Y-m-d h:i:s")
				);
				//update user and redirect to user listing with success msg
				if($this->executives_model->update_executive($this->executive_id, $post_data))
				{
					$this->session->set_flashdata('success', $this->lang->line('executive_upd_success'));
					$this->output->set_header('location:' . base_url() . 'executives/executive_manage');
				}
			} 
			else
			{
				//form validation fails load the view.
				$this->_vci_view('executive_edit', $view_data);
			}
		} 
		else
		{
			//load the view normally
			$this->_vci_view('executive_edit', $view_data);
		}
	}
}

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
class User extends VCI_Controller {
	
	var $userid		= null; //stores current user id
	var $per_page;
	# Class constructor
	function __construct()
	{
		parent::__construct();
	}

	/*
	-----------------------------------------------
	*	Method: New User
	*	Description: Registers a new user.
	-----------------------------------------------
	*/
	function new_user()
	{
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		$this->load->library('form_validation');
		
		
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		
		$store_name_brdcrmb = 'Administrator';
		if($store_id>0)
		{
			$store_response    = $this->user_model->get_current_store_detail($store_id);
			$store_name_brdcrmb = $store_response->username;
		}
		
		//sets the data form exporting to view
		$view_data = array('caption' => $this->lang->line('newuser_caption'));
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Users' => array('link'=>'user/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Add New User ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		
		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{	
	      	//validates the post data by using the rules defined in config file
			if($this->form_validation->run('reg_user_validation'))
			{	
			
				//register the user and redirect to listing page with success msg
				if($this->user_model->new_user_register())
				{
					$this->session->set_flashdata('success', $this->lang->line('user_reg_success'));
					$this->output->set_header('location:' . base_url() . 'user/manage');
				}
			
			} 
			else
			{
				//validation comes with errors the load the view again
				$this->_vci_view('newuser', $view_data);
			}
		} 
		else
		{
			//form not submitted load view normally
			$this->_vci_view('newuser', $view_data);
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
	function is_user_exists($username)
	{
		$this->load->model('user_model');
		
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		
		return (!empty($this->userid)) ? !$this->user_model->is_user_exists($username, $store_id, $this->userid) : !$this->user_model->is_user_exists($username, $store_id);
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
		
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		
		return (!empty($this->userid)) ? !$this->user_model->is_email_exists($email, $store_id, $this->userid) : !$this->user_model->is_email_exists($email, $store_id);
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
	    $store_id = $this->session->userdata('storeId');
	    if( empty( $store_id ) )
	    {
	        $store_id = $this->storeId();
	    }
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		$this->load->library('pagination');
		
		$store_name_brdcrmb = 'Administrator';
		if($store_id>0)
		{
			$store_response    = $this->user_model->get_current_store_detail($store_id);
			$store_name_brdcrmb = $store_response->username;
		}
		
		//prepare the data for exporting to view
		$view_data = array('caption' => $this->lang->line('manageuser_caption'));
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Users ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		//set pagination configs
		$config['base_url'] = base_url() . "user/manage";
		$config['total_rows'] = intval($this->user_model->get_all_users('','',true, $store_id, 3 ));
		$config['per_page'] = PAGE_LIMIT;		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		//fetch all users from database except current user and super user
		$view_data['users'] = $this->user_model->get_all_users($page, PAGE_LIMIT, false, $store_id, 3);
		$this->_vci_view('user_manage', $view_data);
	}

	
	
	/*
	-----------------------------------------------------------------
	*	Method: delete_user
	*	Description: Deletes a user from database and redirect to 
		manage
	-----------------------------------------------------------------
	*/

	function delete_user()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		
		if($this->user_model->delete_user())
		{
			$this->session->set_flashdata('success', $this->lang->line('user_del_success'));
			$this->output->set_header('location:' . base_url() . 'user/manage');
		}
		else {
		    $this->session->set_flashdata('errors',$this->lang->line('user_del_failed'));
			$this->output->set_header('location:'. base_url(). 'user/manage');
		}
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer 
	*	Description: update user status. if status is active then 
		deactive toggles the operation
	-----------------------------------------------------------------
	*/

	function update_status($id = null, $status = 1, $page = 0)
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		
		//check if id was passed
		if(is_null($id))
		{
			$this->session->set_flashdata('errors', $this->lang->line('user_edit_id_error'));
			$this->output->set_header('location:' . base_url() . 'user/manage');
		}
		
		//toggles the status
		if(intval($status) == 1)
		{
			$status = 0;
		}
		else{
			$status = 1;
		}

		//update the status for the user and redirect to listing with success msg
		$result = $this->user_model->store_user_update_status($id, $status);
		$this->session->set_flashdata('success', $this->lang->line('user_upd_success'));
		if($_SERVER['HTTP_REFERER']){
			redirect($_SERVER['HTTP_REFERER']) ;
		}
		$this->output->set_header('location:' . base_url() . 'user/manage' . (($page>0) ? '/' . $page : ''));
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: edit_user
	*	@param id integer
	*	Description: edit user information
	-----------------------------------------------------------------
	*/

	function edit_user($id = null)
	{
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		$this->load->library('form_validation');
		
		//get userid either from argument passed or from posted fields
		$this->userid = (isset($id)) ? $id : $this->input->post('id');
		//check if user id is not empty
		if(empty($this->userid))
		{
			$this->session->set_flashdata('errors', $this->lang->line('user_edit_id_error'));
			$this->output->set_header('location:' . base_url() . 'user/manage');
		}

		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		
		$store_name_brdcrmb = 'Administrator';
		if($store_id>0)
		{
			$store_response    = $this->user_model->get_current_store_detail($store_id);
			$store_name_brdcrmb = $store_response->username;
		}
		
		
		//prepare data to export to view
		$view_data = array('caption' => $this->lang->line('edituser_caption'));
		
		//get the user details by user id
		$view_data['user'] = $this->user_model->get_store_user_details($this->userid);
		
		//set breadcrumb
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Users'=> array('link'=>'user/manage', 'attributes' => array('class'=>'breadcrumb')),
			lang('edituser_caption').' ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		
		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{	
			//run the form validation using the rules defined in config file
			if($this->form_validation->run('update_user_validation'))
			{
				//update user and redirect to user listing with success msg
				if($this->user_model->new_user_register($this->userid))
				{
					$user = $this->user_model->get_store_user_details($id);
					$this->session->set_flashdata('success', $this->lang->line('user_upd_success'));
					$this->output->set_header('location:' . base_url() . 'user/manage');
				}
			} 
			else
			{
				//form validation fails load the view.
				$this->_vci_view('edit_user', $view_data);
			}
		} 
		else
		{
			//load the view normally
			$this->_vci_view('edit_user', $view_data);
		}
	}
	
	/**
	 * method 		change_password
	 * Description  Change password of the logged in user
	 * @param none
	 */
	function change_password()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$view_data['caption'] = "Change Password";
		$view_data['id'] = $this->session->userdata['user']['id'];	
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			
			'Change Password' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;		
		if($this->input->post('form_submitted',TRUE) > 0)
		{
			if($this->form_validation->run('change_password'))
			{
				$salt_value = str_random(6);
				$data = array(
					'password' => md5($this->input->post('new_password',TRUE) . md5($salt_value)),
					'password_salt' => $salt_value
				);
				$id = $this->session->userdata['user']['id'];
				if($this->user_model->update_password($id,$data))
				{
					$this->session->set_flashdata('success','<li>The password has been changed successfully.</li>');
					$this->output->set_header('location:' . base_url() . "admin/desktop");					
				}
				else 
				{
					$this->session->set_flashdata('errors','<li>The password has not been changed successfully.</li>');
					$this->output->set_header('location:' . base_url() . "admin/desktop");										
				}
			}
			else 
			{
				$this->_vci_view('change_password',$view_data);
			}			
		}
		else
		{
			$this->_vci_view('change_password',$view_data);		
		}
	}

	#tree View
	function tree_view($userid=''){
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		
		$view_data['caption'] = "Tree View";
		$view_data['id'] = $this->session->userdata['user']['id'];	
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			
			'Tree View' => array('link'=>'consultant/tree_view', 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;

		
		$lavel = 0 ;

		$rootDetail = $this->user_model->treeview($userid) ;
		
		$view_data['tree'] = $rootDetail ;
		$this->_vci_view('tree_view',$view_data) ;
	}

	function btree_view($userid=''){

		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		
		$view_data['caption'] = "Binary Tree View";
		$view_data['id'] = $this->session->userdata['user']['id'];	
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			
			'Binary Tree View' => array('link'=>'consultant/btree_view', 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;

		
		$lavel = 0 ;

		$rootDetail = $this->user_model->btreeview($userid) ;
		
		$view_data['tree'] = $rootDetail ;
		//echo '<pre>';
		//print_r($view_data['tree']);
		$this->_vci_view('btree_view',$view_data) ;
	}

	function consbtree_view($userid=''){

		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		
		$view_data['caption'] = "Binary Team View";
		$view_data['id'] = $this->session->userdata['user']['id'];	
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			
			'Binary Team View' => array('link'=>'user/consbtree_view', 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;

		
		$lavel = 0 ;

		$rootDetail = $this->user_model->btreeview($userid) ;
		#echo '<pre>' ;
		#print_r($rootDetail);

		$view_data['tree'] = $rootDetail ;
		$this->_vci_view('cbtree_view',$view_data) ;
	}

	function getbtreevolumeatroot($cid){
		$getbtree = $this->user_model->getbtreechild($cid) ;
		
		$firstleg = 0 ;
		$firstlegvol = 0 ;
		$secondleg = 0 ;
		$firstlegvol = 0 ;
		if(!empty($getbtree) && isset($getbtree[0]['consultant_id'])){
			$firstleg = $getbtree[0]['consultant_id'] ;
		}
		if(!empty($getbtree) && isset($getbtree[1]['consultant_id'])){
			$secondleg = $getbtree[1]['consultant_id'] ;
		}
		if($firstleg){
			$firstlegvol = 0 ;
			//geta all childs
			$conArr = $this->user_model->getallbtreechilds($firstleg , $prearr = array()) ;
			
			if(!empty($conArr) && ((count($conArr) !=1) && ($conArr[0] != 0) ) ){
				$firstlegvol = $this->user_model->ptreelastweek($conArr, $value['store_id']) ; // tree consultant sum voulme data
			}
		}
		if($secondleg){
			$secondleg = 0 ;
			//geta all childs
			
			$conArr2 = $this->user_model->getallbtreechilds($secondleg , $prearr = array()) ;
			
			if(!empty($conArr2) && ((count($conArr2) !=1) && ($conArr2[0] != 0) )){
				$secondleg = $this->user_model->ptreelastweek($conArr2, $value['store_id']) ; // tree consultant sum voulme data
			}
		}

		return $firstlegvol+$secondleg ;
	}
}

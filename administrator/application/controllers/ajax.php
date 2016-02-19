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
class Ajax extends VCI_Controller {
	

	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
	}

	#changing store session
	function storeSession( $storeId )
	{
		if( isset( $storeId ) && $storeId != 0 )
		{
			$this->session->set_userdata('storeId', $storeId );
			echo $this->session->userdata('storeId');
			die;
		}
		else if( $storeId == 0 )
		{
			$this->session->set_userdata('storeId', 0 );
		    die;
		}
		else
		{
			return false;die;
		}		
	}
	
	#changing sales report duration
	function salesReportDurationSession( $duration )
	{
		if( isset( $duration ) && $duration != '' )
		{
			$this->session->set_userdata('sales_report_duration', $duration );
			echo $this->session->userdata('sales_report_duration');
			die;
		}
		else if( $duration == 0 )
		{
			$this->session->set_userdata('sales_report_duration', 0 );
			die;
		}
		else
		{
			return false;die;
		}
	}
	
	#changing consultant sales report duration
	function conSalesReportSession( $consId )
	{
 	    if( isset( $consId ) && $consId != '' )
		{
			$this->session->set_userdata('consultant_user_id', $consId );
			echo $this->session->userdata('consultant_user_id');
			die;
		}
		else if( $consId == 0 )
		{
			$this->session->set_userdata('consultant_user_id', 0 );
			die;
		}
		else
		{
			return false;die;
		}
	}

	#changing for option wheather to include paid item or not
	function conIncludePayItems( $includepaid = 0 ){
		if($includepaid != 0){
			$this->session->set_userdata('consultant_include_paid', 1 );
			echo $this->session->userdata('consultant_include_paid');
			die;
		}else{
			$this->session->set_userdata('consultant_include_paid', 0 );
			echo $this->session->userdata('consultant_include_paid');
			die;
		}
	}
	
	#changing for option category
	function categorySession( $categoryId )
	{
		if( isset( $categoryId ) && $categoryId != 0 )
		{
			$this->session->set_userdata('categoryId', $categoryId );
			echo $this->session->userdata('categoryId');
			die;
		}
		else if( $categoryId == 0 )
		{
			$this->session->set_userdata('categoryId', 0 );
			die;
		}
		else
		{
			return false;die;
		}
	}


	#changing for store consulatnt session
	function storeConsultantSession( $storeId )
	{
	//	if( isset( $storeId ) && $storeId != 0 )
		if( isset( $storeId ) )
		{
			$s = explode( '|', $storeId );
			echo $this->session->set_userdata('storeId', $s['0'] );
			echo $this->session->set_userdata('consultantId', $s['1'] );
			//echo $this->session->userdata('storeId');
			die;
		}
		else if( $storeId == 0 )
		{
			$this->session->set_userdata('storeId', 0 );
		    die;
		}
		else
		{
			return false;die;
		}		
	}

	#changing for store role user id session
	function storeRoleAndUserIdSession( )
	{
	    //print_r($_POST);die;
	    $role_id    = $_POST['role_id'];
	    $user_id    = $_POST['user_id'];
	    
	    if( isset( $role_id ) && isset( $user_id )  )
	    {
	        if( $settings = $this->common_model->isSettingsexist( $role_id, $user_id ) )
	        {
	            //echo '<pre>';print_r($settings);die;
	            $this->session->set_userdata('roleId', $role_id );
	            $this->session->set_userdata('userId', $user_id );
	        }
	        else
	        {  
	            $this->session->set_userdata('roleId', $role_id );
	            $this->session->set_userdata('userId', $user_id ); 
	            
	        }
	        return true;
	        
	    }
	}
	
	#setting role and store id session
	function roleAndStoreIdSession()
	{
	    
	    $role_id     = $_POST['role_id'];
	    $store_id    = $_POST['store_id'];
	    
	    if( isset( $role_id ) && isset( $store_id )  )
	    {
	        $this->session->set_userdata('roleId', $role_id );
            $this->session->set_userdata('storeId', $store_id );
        
	        return true;   
	    }
	}
	
	#setting role id in  session
    function setRoleIdSession()
    {
        $role_id     = $_POST['role_id'];
        if( isset( $role_id ) )
	    {
	        $this->session->set_userdata('roleId', $role_id );
	        return true;   
	    }
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
		
		//sets the data form exporting to view
		$view_data = array('caption' => $this->lang->line('newuser_caption'));
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Users' => array('link'=>'user/manage_user', 'attributes' => array('class'=>'breadcrumb')),
			'Add New User' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		
		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{	
	      			
			//validates the post data by using the rules defined in config file
			if($this->form_validation->run('reg_user'))
			{
				//register the user and redirect to listing page with success msg
				if($this->user_model->register_user())
				{
					$this->session->set_flashdata('success', $this->lang->line('user_reg_success'));
					$this->output->set_header('location:' . base_url() . 'user/manage_user');
				} 
			} else
			{
				//validation comes with errors the load the view again
				$this->_vci_view('newuser', $view_data);
			}
		} else
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
	*	Method: manage_user
	*	@param page integer
	*	Description: creates listing and handles search operations
	-----------------------------------------------------------------
	*/

	function manage($page = 0)
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		$this->load->library('pagination');
		
		//prepare the data for exporting to view
		$view_data = array('caption' => $this->lang->line('manageuser_caption'));
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Users' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		//set pagination configs
		$config['base_url'] = base_url() . "user/manage";
		$store_id = 8;
		$config['total_rows'] = intval($this->user_model->get_all_users('','',true, $store_id ));
		$config['per_page'] = PAGE_LIMIT;		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		//fetch all users from database except current user and super user
		$view_data['users'] = $this->user_model->get_all_users($page, PAGE_LIMIT, false, $store_id);
		$this->_vci_view('user_manage', $view_data);
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: delete_user
	*	Description: Deletes a user from database and redirect to 
		manage_user
	-----------------------------------------------------------------
	*/

	function delete_user()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		
		if($this->user_model->delete_user())
		{
			$this->session->set_flashdata('success', $this->lang->line('user_del_success'));
			$this->output->set_header('location:' . base_url() . 'user/manage_user');
		}
		else {
		    $this->session->set_flashdata('errors',$this->lang->line('user_del_failed'));
			$this->output->set_header('location:'. base_url(). 'user/manage_user');
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
			$this->output->set_header('location:' . base_url() . 'user/manage_user');
		}
		
		//toggles the status
		if(intval($status) == 1)
			$status = 0;
		else
			$status = 1;

		//update the status for the user and redirect to listing with success msg
		$result = $this->user_model->update_status($id, $status);
		$this->session->set_flashdata('success', $this->lang->line('user_upd_success'));
		$this->output->set_header('location:' . base_url() . 'user/manage_user' . (($page>0) ? '/' . $page : ''));
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
			$this->output->set_header('location:' . base_url() . 'user/manage_user');
		}

		//prepare data to export to view
		$view_data = array('caption' => $this->lang->line('edituser_caption'));
		
		//get the user details by user id
		$view_data['user'] = $this->user_model->get_user_details($this->userid);
		
		//set breadcrumb
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Users'=> array('link'=>'user/manage_user', 'attributes' => array('class'=>'breadcrumb')),
			lang('edituser_caption') => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		
		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{	
			//run the form validation using the rules defined in config file
			if($this->form_validation->run('reg_user'))
			{
				//update user and redirect to user listing with success msg
				if($this->user_model->register_user($this->userid))
				{
					$user = $this->user_model->get_user_details($id);

					$data['first_name']	= $user->first_name;
					$data['last_name']	= $user->last_name;
					$data['username']	= $user->username;
					$data['first_name']	= $user->first_name;
					$data['last_login']	= $user->last_login;
					$data['email']		= $user->email;
					$data['state']		= $user->state;
					$data['city']		= $user->city;
					$data['country']	= $user->country;
					$data['address']	= $user->address;
					$data['status']		= $user->status;
					$data['id']			= $user->id;
	
					// set session data for future use
					$this->session->set_userdata('user',$data);
					
					
					$this->session->set_flashdata('success', $this->lang->line('user_upd_success'));
					$this->output->set_header('location:' . base_url() . 'user/manage_user');
				} 
			} else
			{
				//form validation fails load the view.
				$this->_vci_view('edit_user', $view_data);
			}
		} else
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

}
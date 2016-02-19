<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin extends VCI_Controller defined in libraries
 * Manage access to admin by admin users, performs authentication etc.
 *
 * @author Vince Balrai
 */

class Admin extends VCI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	# Loads default view for the admin, 
	# verifies login credentials and redirects to Administrator Desktop Area
	function index()
	{
		$this->_vci_layout('login');
		$this->load->library('form_validation');
		if($this->input->post('loginFormSubmitted') > 0)
		{		
			if($this->form_validation->run('login'))
			{ 
				if(($user = $this->user_model->get_user_details()) == false)
				{
					//print_r($user);	
					//echo "working"; die;
					$this->session->set_flashdata('errors', $this->lang->line('error_invalid_user'));
					$this->output->set_header('location:' . $this->config->item('base_url') . 'admin/index');
				} else
				{
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
					$data['is_admin']   = 1;
					$data['controller'] = 'admin';  
	                $data['edit']       = 'edit_user';      
					$data['role_id']	= $user->role_id;
					// set session data for future use
					$this->session->set_userdata('user',$data);
					// all data set redirect user to his desktop
					$this->output->set_header('location:' . $this->config->item('base_url') . 'admin/desktop');
				}
			} else
			{
				$data['errors'] = true;
				$this->_vci_view('index',$data);
			}
		}
		else
		{
			$this->_vci_view('index');
		}
	}
	
	# Loads desktop view for admin site
	function desktop()
	{
		$this->_vci_layout('menu-toolbar');
		// Create bread crumbs
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>null, 'attributes' => array('title'=>'Home Title','class'=>'breadcrumb'))
		));

		$this->load->model('news_model');
		$this->load->model('contact_model');
		$this->load->model('area_model') ;

		//$data['users']		=	$this->user_model->count_users();
		
		$data['news'] =  intval($this->news_model->count_news_admin());
		$data['contacts'] =  intval($this->contact_model->count_contact_admin());
		$data['area'] =  intval($this->area_model->count_area());
		
		// assign breadcrumb to a view variable
		$data['crumbs'] = $crumbs;
		$this->_vci_view('desktop', $data);

	}
	
	# Logouts for the admin area
	function logout()
	{
		// clear the user created data.
		$this->session->unset_userdata('user');
		// clear the system session data.
		$this->session->sess_destroy();
		// inform user about logout.
		$this->session->set_flashdata('success', $this->lang->line('logout_success'));
		$this->output->set_header('location:' . $this->config->item('base_url') . 'admin/index');
	}
	
	# Loads forget password view and sends email for password retrieval
	function forgot_password()
	{
		$this->_vci_layout('login');
	    $this->_vci_view('forgotpassword');
	}
	
	/**
	 * Function	: Is Email Exists
	 * Author	: Jaidev Bangar
	 * Description	:	Checks whether email exists in the database before sending password
	 * @params	: Null
	 * @return	: TRUE if not exists and FALSE if exists, and sets form_validation message
	 * Create Date	:	07 March, 2011	
	 */
	function is_email_exists() //start func
	{	
		if($this->user_model->verify_email()==false)
		{
			$this->form_validation->set_message("is_email_exists","<li>".lang('error_invalid_email')."</li>");
			return FALSE;
		}
		else {
		    return TRUE;
		}
	} // end func
	
	
	#changing password utility
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

/* End of file admin.php */
/* Location: ./system/application/controllers/admin.php */
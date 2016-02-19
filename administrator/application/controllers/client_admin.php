<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * client_admin extends VCI_Controller defined in libraries
 * Manage access to client_admin by client_admin users, performs authentication etc.
 *
 * @author Vince Balrai
 */

class Client_admin extends VCI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	# Loads default view for the client_admin, 
	# verifies login credentials and redirects to client_administrator Desktop Area
	function index()
	{
	    //
		$this->load->library('form_validation');
		if($this->input->post('loginFormSubmitted') > 0)
		{		
			if($this->form_validation->run('client_login'))
			{ 
				if(($user = $this->user_model->get_user_details()) == false)
				{
					$this->session->set_flashdata('errors', $this->lang->line('error_invalid_user'));
					$this->output->set_header('location:' . $this->config->item('base_url') . 'client_admin/index');
				} 
				else
				{
					$data['first_name']	= $user->first_name;
					$data['last_name']	= $user->last_name;
					//$data['username']	= $user->username;
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
					// all data set redirect user to his desktop
					$this->output->set_header('location:' . $this->config->item('base_url') . 'client_admin/desktop');
				}
			} else
			{
				$data['errors'] = true;
				$this->_vci_view('client_admin_index',$data);
			}
		}
		else
		{
			$this->_vci_view('client_admin_index');
		}
	}
	
	# Loads desktop view for client_admin site
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

		$data['news'] =  intval($this->news_model->count_news());
		$data['contacts'] =  intval($this->contact_model->count_contact());
		$data['area'] =  intval($this->area_model->count_area());
		
		// assign breadcrumb to a view variable
		$data['crumbs'] = $crumbs;
		$this->_vci_view('desktop', $data);
	}
	
	# Logouts for the client_admin area
	function logout()
	{
		// clear the user created data.
		$this->session->unset_userdata('user');
		// clear the system session data.
		$this->session->sess_destroy();
		// inform user about logout.
		$this->session->set_flashdata('success', $this->lang->line('logout_success'));
		$this->output->set_header('location:' . $this->config->item('base_url') . 'client_admin/index');
	}
	
	# Loads forget password view and sends email for password retrieval
	function forgot_password()
	{

		if($this->form_validation->run('forget_password')) 
		{

			$this->load->library('email');
			$this->load->library('parser');
			$data = array(
				//'username'		=> $data['username'],
				'email'			=> $data['email'],
				'password'		=> $data['password_orig'],
				'first_name'	=> $data['first_name'],
				'last_name'		=> $data['last_name'],
				'images'		=> layout_url('default/images'),
				'dear_txt'		=> sprintf(lang('forgot_dear_txt'), ucwords($data['first_name'] . ' ' . $data['last_name'])),
				//'username_txt'	=> sprintf(lang('forgot_username_txt'), $data['username']),
				'password_txt'	=> sprintf(lang('forgot_password_txt'), $data['password_orig'])
				);
			//set email class parameters
			$htmlMessage =  $this->parser->parse('default/templates/forgetpassword', $data, true);

			$this->email->from($this->config->item('email_from'),$this->config->item('from_name'));
			$this->email->to($data['email']);
			$this->email->subject($this->lang->line('retrieved_password'));
			$this->email->message($htmlMessage);
			$this->email->set_mailtype('html');
			$this->email->set_alt_message($txtMessage);
			$this->email->send();
			//echo $this->email->print_debugger();
	        
			if($this->email->send())
			{
				//if mail sent successfully
				$this->session->set_flashdata('success',lang('password_sent_successfully'));
				$this->output->set_header('location:' . base_url() . 'client_admin/forgot_password');
			}
			else
			{
				//if mail sending failed
				$this->session->set_flashdata('errors',lang('password_sent_failed'));
				$this->output->set_header('location:' . base_url() . 'client_admin/forgot_password');
			}
		}
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
}

/* End of file client_admin.php */
/* Location: ./system/application/controllers/client_admin.php */
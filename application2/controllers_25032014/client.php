<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Class:	client extends VCI_Controller defined in libraries
 *	Author:	
 *	Platform:	Codeigniter
 *	Company:	Cogniter Technologies
 *	Description: Manage client entity
 */
class Client extends VCI_Controller {

	//var $clientid		= null; //stores current client id
	//var $per_page;

   
    # Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('client_model');
        //$this->_vci_layout('menu-toolbar');
        //
	}

	/**
	 * method name  add
     * purpose		Add a new client.
     * @param 		none
     */
	function add()
	{
		// rule name conatctus
        if ( $this->input->post( 'formSubmitted' ) > 0 )
        {
            if ( $this->form_validation->run('client_add') )
            {            
            	$response_add_client = $this->client_model->add_client();
                if ( $response_add_client )
                {
            		$this->client_model->add_client_pages( $response_add_client );
                	$this->load->library('email');
	                $this->load->library('parser');
	                $smtp_settings = $this->config->item('smtp');
	                $sender_from = $this->config->item('sender_from');
	                $sender_name = $this->config->item('sender_name');
                	$this->email->initialize( $smtp_settings );
	                $this->email->from( $sender_from, $sender_name );
	                $this->email->to( htmlspecialchars( $this->input->post('email') ) );


	                $data = array(
                        'title' => 'Contact us form submitted',
                        'CONTENT' => 'Thanks for registering on Simple Sales Systems. We will contact you soon.',
                        'USER'=> htmlspecialchars( ucwords( $this->input->post('name') ) )
                        
                        );

	                $body = $this->parser->parse('default/store/emails/client_register', $data, true);
	                //$this->email->cc('another@another-example.com');
	                $this->email->subject('Thanks for registering with us - Simple Sales Systems');
	                $this->email->message( $body );							

	                if ( ! $this->email->send())
	                {
	                    echo $this->email->print_debugger();
	                }
	                else
	                {
	                    // Mail to admin to inform about contact form submission  
                        $smtp_settings = $this->config->item('smtp');
                        $this->email->initialize( $smtp_settings );
                        $this->email->from( $sender_from, $sender_name );
                        $this->email->to( $sender_from );
                        $data2 = array(
                            'title' => 'Contact us form submitted',
                            'CONTENT' => 'An user registered from Simple Sales Systems. Please find the details below',                                    
                                'USER' 		    => htmlspecialchars($this->input->post('fName')),
			                        'USERNAME' 		=> htmlspecialchars($this->input->post('username')),
		                        'EMAIL' 		=> htmlspecialchars($this->input->post('email')),
		                        'PHONE' 		=> htmlspecialchars($this->input->post('phone')),
		                        'COMPANY' 		=> htmlspecialchars($this->input->post('company')), 
		                        'ADDRESS' 		=> htmlspecialchars($this->input->post('address')),
		                        'STATE' 	    => htmlspecialchars($this->input->post('state_code')),
		                        'CITY' 			=> htmlspecialchars($this->input->post('city')),
		                        'ZIP' 			=> htmlspecialchars($this->input->post('zip')),
		                        'COMMENTS' 		=> htmlspecialchars($this->input->post('comments')),
                                
                                );

                        $body2 = $this->parser->parse('default/store/emails/notify_admin_register', $data2, true);
                        $this->email->subject('Contact us form submitted');
                        $this->email->message( $body2 );	
                        $this->email->send();
	                    //Mail to admin ends
		                echo "Mail sent";
	                }
                    
                    
                    //$this->notify_user();
                    $this->session->set_flashdata( 'success', 'Thanks for submitting your details with Simple Sales System. Request has been sent to the administrator for approval. An email will be sent to you with the status in next 24 hours.' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
                else
                {
                    $view_data = $this->input->post();

                    $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
            }
            else
            {
                $view_data = $this->input->post();
                $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                // redirect($_SERVER['HTTP_REFERER']) ;
            }
        }
		//form not submitted load view normally
        $view_data['states'] = $this->common_model->get_state();
        // super admin links adding starts there
        $social_links = $this->common_model->get_marketplace_social_links( 1,1 );
        $view_data['fb_link']        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
		$view_data['twitter_link']   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
		$view_data['pinterest_link'] = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
		$view_data['linkdin_link']   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
		$view_data['gplus_link']     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
		$view_data['youtube_link']   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
        // super admin links added there
		$this->_vci_view('client_add', $view_data);
	}

	/**
	 *	Method: is_client_exists
	 *	@param clientname string
	 *	Description: Callback method used for unique clientname check
 	 *	by form validation rules defined in config/form_validation.php
	 */
	function is_client_exists($clientname)
	{
		return (!empty($this->clientid)) ? !$this->client_model->is_client_exists($clientname, $this->clientid) : !$this->client_model->is_client_exists($clientname);
	}

	/*
	*	Method: is_email_exists
	*	@param email string
	*	Description: Callback method used for unique email check by
		form validation rules defined in config/form_validation.php
	*/

	function is_email_exists($email)
	{
		return (!empty($this->clientid)) ? !$this->client_model->is_email_exists($email, $this->clientid) : !$this->client_model->is_email_exists($email);
	}

	/**
	 *	Method: manage
	 *	@param page integer
	 *	Description: creates listing and handles search operations
	 */
	function manage($page = 0)
	{
	    //redirect( base_url( ) . 'admin/desktop' );
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');

		//prepare the data for exporting to view
		$view_data = array('caption' => $this->lang->line('manageclient_caption'));
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'admin/desktop', 'attributes' => array('class'=>'breadcrumb')),
			'Manage clients' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));

		//set pagination configs
		$config['base_url']   = base_url() . "client/manage";
		$config['total_rows'] = intval($this->client_model->get_all_clients('','',true));
		$config['per_page']   = PAGE_LIMIT;

		$this->pagination->initialize($config);

		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs']     = $crumbs;
		//fetch all clients from database
		$view_data['clients']      = $this->client_model->get_all_clients($page, PAGE_LIMIT);
		//echo "<pre>";print_r($view_data['clients']);die;
		$this->_vci_view('manage_client', $view_data);
	}

	/**
	 * Method: delete_client
	 * Description: Deletes a client from database and redirect to
	 * manage_client
	 */
	function delete_client()
	{
	    //redirect( base_url( ) . 'client/manage' );
		$this->_vci_layout('menu-toolbar');
	
		if($this->client_model->delete_client())
		{
			$this->session->set_flashdata('success', $this->lang->line('client_del_success'));
			$this->output->set_header('location:' . base_url() . 'client/manage');
		}
		else {
		    $this->session->set_flashdata('errors',$this->lang->line('client_del_failed'));
			$this->output->set_header('location:'. base_url(). 'client/manage');
		}
	}

	/*
	*	Method: update_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer
	*	Description: update client status. if status is active then
		deactive toggles the operation
	*/

	function update_status($id = null, $status = 1, $page = 0)
	{
		$this->_vci_layout('menu-toolbar');

		//check if id was passed
		if(is_null($id))
		{
			$this->session->set_flashdata('errors', $this->lang->line('client_edit_id_error'));
			$this->output->set_header('location:' . base_url() . 'client/manage');
		}

		//toggles the status
		/*if(intval($status) == 1)
			$status = 0;
		else
			$status = 1;*/

		//update the status for the client and redirect to listing with success msg
		$result = $this->client_model->update_status($id, $status);
		$this->session->set_flashdata('success', $this->lang->line('client_upd_success'));
		$this->output->set_header('location:' . base_url() . 'client/manage' . (($page>0) ? '/' . $page : ''));
	}

	/**
	 *	Method: edit client
     *
	 *	@param id integer
	 *	Description: edit client information
	 */
	function edit($id = null)
	{
		//set required things
		$this->_vci_layout( 'menu-toolbar' );
		$this->load->model( 'client_model' );
		$this->load->library( 'form_validation' );
        $uri = $this->uri->uri_to_assoc(3);
        
		//get clientid either from argument passed or from posted fields
		$this->clientid = ( isset( $uri['id'] ) ) ? $uri['id'] : $this->input->post( 'id' );
		//check if client id is not empty
		if( empty( $this->clientid ) )
		{
			$this->session->set_flashdata('errors', $this->lang->line('client_edit_id_error'));
			$this->output->set_header('location:' . base_url() . 'client/manage');
		}

		//prepare data to export to view
		$view_data = array( 'caption' => $this->lang->line( 'editclient_caption' ) );

		//get the client details by client id
		$view_data['client'] = $this->client_model->get_client_details( $this->clientid );

		//set breadcrumb
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'admin/desktop', 'attributes' => array('class'=>'breadcrumb')),
			'Manage clients'=> array('link'=>'client/manage', 'attributes' => array('class'=>'breadcrumb')),
			lang('editclient_caption') => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		) );
		$view_data['crumbs'] = $crumbs;

		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
			//run the form validation using the rules defined in config file
			//if($this->form_validation->run( 'edit_client' ) )
    		if( isset($_POST['fName']) && !empty($_POST['fName'])  && isset($_POST['lName']) && !empty($_POST['lName']) )
			{
                // Modified the edit functionality for editing client
                $post_data = Array(
                    'fName'  => trim( $this->input->post( 'fName' ), true ),
                    'lName'  => trim( $this->input->post( 'lName' ), true ),
                    //'email'  => trim( $this->input->post( 'email', true ) ),
                    'status' => trim( $this->input->post( 'status', true ) ),
                    'modified'   => date("Y-m-d h:i:s"),
                );

                if ( $this->client_model->update( $this->clientid, $post_data, 'clients' ) )
                {
                    $client = $this->client_model->get_client_details( $this->clientid );

					$this->session->set_flashdata('success', $this->lang->line('client_upd_success'));
					$this->output->set_header('location:' . base_url() . 'client/manage');
                }
                else
                {
					$this->session->set_flashdata('success', 'client updation failed' );
					$this->output->set_header('location:' . base_url() . 'client/manage');
                }
			}
        }
        //load the view normally
        $this->_vci_view('edit_client', $view_data);
	}

}
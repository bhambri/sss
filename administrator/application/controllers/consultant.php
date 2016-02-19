<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Class:	client extends VCI_Controller defined in libraries
 *	Author:	Mandeep Singh
 *	Platform:	Codeigniter
 *	Company:	Cogniter Technologies
 *	Description: Manage client entity
 */
class Consultant extends VCI_Controller {

	var $clientid		= null; 
	var $per_page;

    /**
     * Class constructor
     */
	function __construct()
	{
		parent::__construct();
        //$this->_vci_layout('menu-toolbar');
        $this->load->model('consultant_model');
        
	}

	
	
    function index()
	{
		$this->_vci_layout('login');
		$this->load->library('form_validation');
		
		if($this->input->post('loginFormSubmitted') > 0)
		{
		    		
			if($this->form_validation->run('client_login'))
			{ 
			    if(($client = $this->consultant_model->get_details()) == false)
				{
					
					$this->session->set_flashdata('errors', $this->lang->line('error_invalid_user'));
					$this->output->set_header('location:' . $this->config->item('base_url') . 'consultant/index');
				} 
				else
				{
				    $data 				= $client;
	                $data['controller'] = 'consultant';  
	                $data['edit']       = 'edit_client';  
					// set session data for future use

					$this->session->set_userdata('user',$data); // 
					
					// all data set redirect user to his desktop
					
					$this->output->set_header('location:' . $this->config->item('base_url') . 'consultant/desktop');
					//exit();
				}
			} else
			{
				$data['errors'] = true;
				$this->_vci_view('consultant_login',$data);
			}
		}
		else
		{
			$this->_vci_view('consultant_login');
		}
	}
	
	# Loads desktop view for admin site
	function desktop()
	{
		error_reporting(1);		
		$this->_vci_layout('menu-toolbar');
		// Create bread crumbs
		$crumbs = breadcrumb(array( lang('desktop') => array('link'=>'consultant/desktop', 'attributes' => array('title'=>'Home Title','class'=>'breadcrumb'))
		));
        
        $usr = $this->session->userdata('user') ;
        //echo '<pre>';
	//print_r($usr);

        $cid = $usr['id'];
        $storeid = $usr['store_id'];
		$this->load->model('news_model');
		$this->load->model('client_model');
		$this->load->model('contact_model');
		$this->load->model('area_model') ;
		$this->load->model('user_model') ;
	$client = $this->client_model->get_client_details( $storeid );
	//echo '<pre>';
	//print_r($client);	
		$data['news'] =  intval($this->news_model->count_news_consultant($cid,$storeid));
		#$data['contacts'] =  intval($this->contact_model->count_contact());
		$data['area'] =  intval($this->area_model->count_area());
		$data['consultantid'] = $cid ;
		$data['pendingcom'] = $this->user_model->getpendingcommisiondetails($cid) ;
		$data['is_mlmtype'] = $client->is_mlmtype ;
		$data['training_link'] = $client->training_link ;
		// assign breadcrumb to a view variable
		$data['crumbs'] = $crumbs;
		$this->_vci_view('consultant_desktop', $data);

	}
    
    
    function logout()
	{
		// clear the user created data.
		$this->session->unset_userdata('client');
		// clear the system session data.
		$this->session->sess_destroy();
		// inform user about logout.
		$this->session->set_flashdata('success', $this->lang->line('logout_success'));
		$this->output->set_header('location:' . $this->config->item('base_url') . 'consultant/index');
	}
	
    
    function forgot_password() {
		$this->_vci_layout('login');
    	ini_set('display_errors',1) ;
    	$this->_vci_view('consultant_forgotpassword');
    	$this->load->helper('string');
    	$this->load->model('client_model');

    	if(!empty($_POST['email'])){
	    	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    		$rs = $this->consultant_model->get_consultantdetailusing_email($_POST['email']) ;
	    		
	    		if(!$rs){
	    		   $data['errors'] = true;
		    	   $this->session->set_flashdata('errors','<li>Invalid email supplied .</li>');
			   $this->output->set_header('location:' . base_url() . "consultant/forgot_password");	
	    		}else{
	    			
	    			$newpass = random_string('alnum',8); 
	    			#echo '<pre>';
	    			#print_r($rs[0]);
	    			#print_r($_SERVER);
				#die;
	    			$email = $rs[0]->email;

	    			$data = array(
						'password' => md5($newpass)
					);

	    		 	// same password mechanism will run for consultant as well as client	
					$this->client_model->update_newpassword($rs[0]->id,$data ,4) ;

					// mail sending script now 
					$this->load->library('email');
					$this->load->library('parser');
					$smtp_settings = $this->config->item('smtp');
					#echo '<pre>';
					#print_r($smtp_settings);

					$sender_from = $smtp_settings['smtp_user'];
					$sender_name = $smtp_settings['smtp_user'] ;
					$this->email->initialize( $smtp_settings );
					$this->email->from( $sender_from, $sender_name );
					$this->email->to( htmlspecialchars( $email ) );
					
					$ndata = array(
							'title' => 'Your new password',
							'base_url'=> $_SERVER['HTTP_HOST'] ,
							'base_url_name' => str_replace(array('http:','http://','//','/'), '' , $_SERVER['HTTP_HOST'] ) , 
							'CONTENT' => '<div> Your new password is : </div>'.$newpass,
							'USER'=> htmlspecialchars( ucwords( $email ) )
					);
						
					$body = $this->parser->parse('default/emails/consultant_fpassword', $ndata, true);
					
					//$this->email->cc('another@another-example.com');
					$this->email->subject('Password changed ! - New password to logon ');
					$this->email->message( $body );

					if ( $this->email->send())
					{
						$this->session->set_flashdata('success', 'New password sent to your email');
						$this->output->set_header('location: ' . base_url() . 'consultant/forgot_password');
					}
					else
					{
						#echo $this->email->print_debugger();
						$this->session->set_flashdata('errors', 'Please try later mail sending failed !');
						$this->output->set_header('location: ' . base_url() . 'consultant/forgot_password');	
					}
					// mail sending script ends now
	    		}
	    	}else{
	    		$data['errors'] = true;
	    		$this->session->set_flashdata('errors','<li>Invalid email supplied .</li>');
			$this->output->set_header('location:' . base_url() . "consultant/forgot_password");	
	    	}
    	}
    	
    }
    
    
    function change_password()
	{
	    $this->_vci_layout('menu-toolbar');
		$this->load->model('client_model');
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
				if($this->client_model->update_password($id,$data))
				{
					$this->session->set_flashdata('success','<li>The password has been changed successfully.</li>');
					$this->output->set_header('location:' . base_url() . "client/desktop");					
				}
				else 
				{
					$this->session->set_flashdata('errors','<li>The password has not been changed successfully.</li>');
					$this->output->set_header('location:' . base_url() . "client/desktop");										
				}
			}
			else 
			{
				$this->_vci_view('change_password_client',$view_data);
			}			
		}
		else
		{
			$this->_vci_view('change_password_client',$view_data);		
		}
	}
    /*
    function get_hexe_lvl($consultant_id){
	$result = $this->consultant_model->get_heighest_executivelvl_consultant($consultant_id) ;
	return $result[0]->executive_level;
	}

    function get_exe_lvl($consultant_id){
	$result = $this->consultant_model->get_consultant_executive_detail( $consultant_id );
	//return $result[0]->executive_level_id ;	
	if($result[0]->executive_level_id){
		$this->db->from('executive_levels');
		$this->db->where(array('id'=> $result[0]->executive_level_id));
		//$this->db->order_by("executive_level", "ASC");
		$result = $this->db->get();
		
		if(count($result->result()) > 0)
		{
			$rsData = $result->result();
			return $rsData[0]->executive_level ;
		}
		else
		{
			return false;
		}
	}else{
		return false;
	}
		

	} */
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
		$view_data = array('caption' => "Manage ".$this->consultant_label);
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage '.$this->consultant_label.' ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		//set pagination configs
		$config['base_url'] = base_url() . "consultant/manage";
		$config['total_rows'] = intval($this->user_model->get_all_users('','',true, $store_id, 4 ));
		$config['per_page'] = PAGE_LIMIT;		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		//fetch all users from database except current user and super user
		//$view_data['users'] = $this->user_model->get_all_users($page, PAGE_LIMIT, false, $store_id, 4);
		$view_data['users'] = $this->user_model->get_all_usersconsultant($page, PAGE_LIMIT, false, $store_id, 4);
		//echo '<pre>';
		//print_r($view_data['users']);
		$this->_vci_view('consultant_manage', $view_data);
	}

	function topconsultantmanage($page = 0 , $q_s=null,$startdate="", $enddate ="" )
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
		$view_data = array('caption' => "Top ".$this->consultant_label);
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage '.$this->consultant_label.' ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		//set pagination configs
		if($this->input->get('from_date')){
			$startdate = $this->input->get('from_date');
			$view_data['fromdate'] = $startdate ;
		}
		if($this->input->get('to_date')){
			$enddate = $this->input->get('to_date');
			$view_data['todate'] = $enddate ;
		}
		
		//set required things
		
		ini_set('display_errors',1);
		$date_from = "";
		$date_to = "" ;
		if($startdate == "" && $enddate== ""){
			$current_month      = date('m', time());
			$current_year       = date('Y', time());
			if( $this->session->userdata('sales_report_duration')=='week' )
			{
				$source_date         = Date('d-m-Y', strtotime("Last Sunday"));
				$source_date_time_ms = strtotime($source_date." 00:00:00");
					
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
			else if( $this->session->userdata('sales_report_duration')=='month' )
			{
				$source_date         = "01-".$current_month."-".$current_year;
				$source_date_time_ms = strtotime($source_date." 00:00:00");
			
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
			else if( $this->session->userdata('sales_report_duration')=='year' )
			{
				$source_date         = "01-01-".$current_year;
				$source_date_time_ms = strtotime($source_date." 00:01:00");
			
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
				
		}else{
			if($startdate !=''){
				$date_from = str_replace('/','-',$startdate) ;
				$date_from = strtotime($date_from." 00:00:00");
				
			}
			
			if($enddate !=''){
				$date_to = str_replace('/','-',$enddate) ;
				$date_to = strtotime($date_to." 00:00:00");
			}
			
		}
				
		//set pagination configs
		$getData = array('from_date'=>$startdate ,'to_date'=>$enddate,'submit'=>'Filter');
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		

		$config['base_url'] = base_url() . "consultant/topconsultantmanage";
		$config['first_url'] = base_url() . "consultant/topconsultantmanage?page=&from_date=".$startdate."&to_date=".$enddate;

		$config['total_rows'] = intval($this->user_model->get_all_topconsusers('','',true, $store_id, 4 ,$date_from, $date_to));
		$config['per_page'] = PAGE_LIMIT;		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		//fetch all users from database except current user and super user
		$view_data['users'] = $this->user_model->get_all_topconsusers($page, PAGE_LIMIT, false, $store_id, 4,$date_from, $date_to);
		$this->_vci_view('topconsultant_manage', $view_data);
	}
    
    function manage_volume_commission($page = 0 , $q_s=null,$startdate="", $enddate ="" )
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
		$view_data = array('caption' => "Volume Commission Reports- ".$this->consultant_label);
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Volume Commission Reports - '.$this->consultant_label.' ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		//set pagination configs
		if($this->input->get('from_date')){
			$startdate = $this->input->get('from_date');
			$view_data['fromdate'] = $startdate ;
		}
		if($this->input->get('to_date')){
			$enddate = $this->input->get('to_date');
			$view_data['todate'] = $enddate ;
		}
		
		//set required things
		
		ini_set('display_errors',1);
		$date_from = "";
		$date_to = "" ;
		if($startdate == "" && $enddate== ""){
			$current_month      = date('m', time());
			$current_year       = date('Y', time());
			if( $this->session->userdata('sales_report_duration')=='week' )
			{
				$source_date         = Date('d-m-Y', strtotime("Last Sunday"));
				$source_date_time_ms = strtotime($source_date." 00:00:00");
					
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
			else if( $this->session->userdata('sales_report_duration')=='month' )
			{
				$source_date         = "01-".$current_month."-".$current_year;
				$source_date_time_ms = strtotime($source_date." 00:00:00");
			
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
			else if( $this->session->userdata('sales_report_duration')=='year' )
			{
				$source_date         = "01-01-".$current_year;
				$source_date_time_ms = strtotime($source_date." 00:01:00");
			
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
				
		}else{
			if($startdate !=''){
				$date_from = str_replace('/','-',$startdate) ;
				$date_from = strtotime($date_from." 00:00:00");
				
			}
			
			if($enddate !=''){
				$date_to = str_replace('/','-',$enddate) ;
				$date_to = strtotime($date_to." 00:00:00");
			}
			
		}
				
		//set pagination configs
		$getData                 = array('from_date'=>$startdate ,'to_date'=>$enddate,'submit'=>'Filter');		
		$config['suffix']        = '?'.http_build_query($getData,'',"&amp;");		
		$config['base_url']      = base_url() . "consultant/manage_volume_commission";
		$config['first_url']     = base_url() . "consultant/manage_volume_commission?page=&from_date=".$startdate."&to_date=".$enddate;

		$config['total_rows']    = intval($this->user_model->get_all_volume_commissions('','',true, $store_id, 4 ,$date_from, $date_to));
		$config['per_page']      = PAGE_LIMIT;		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs']     = $crumbs;
		//fetch all users from database except current user and super user
		$view_data['users']      = $this->user_model->get_all_volume_commissions($page, PAGE_LIMIT, false, $store_id, 4,$date_from, $date_to);
		
		$this->_vci_view('manage_volume_commission', $view_data);
	}
    
    /*
	-----------------------------------------------------------------
	*	Method: delete_user
	*	Description: Deletes a user from database and redirect to 
		manage_user
	-----------------------------------------------------------------
	*/

	function delete()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		
		if($this->consultant_model->delete_consultant($id))
		{
			$this->session->set_flashdata('success', $this->lang->line('consultant_del_success'));
			$this->output->set_header('location:' . base_url() . 'consultant/manage');
		}
		else {
		    $this->session->set_flashdata('errors',$this->lang->line('consultant_del_failed'));
			$this->output->set_header('location:'. base_url(). 'consultant/manage');
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
			$this->session->set_flashdata('errors', $this->lang->line('consultant_edit_id_error'));
			$this->output->set_header('location:' . base_url() . 'consultant/manage');
		}
		
		//toggles the status
		if(intval($status) == 1)
		{
			$consultant_data      = $this->consultant_model->get_consultant_detail($id);
			$parent_consultant_id = $consultant_data[0]->parent_consultant_id;
			$consultant_id        = $consultant_data[0]->id;
			
			/**
			 * below update query is for set child's consultant parent consultant id
			 */
			
			$post_data = Array(
			 		'parent_consultant_id' => trim($parent_consultant_id),
                );
			$this->user_model->updateWhere( 'users', array('parent_consultant_id' => $consultant_id, 'role_id' => 4 ), $post_data );
			
			/**
			 * below update query is for set parent consultant id 0
			 * this is the consultant, whose status is going to 0
			 */
			
			$post_data = Array(
					'parent_consultant_id' => 0,
			);
			$this->user_model->updateWhere( 'users', array('id' => $consultant_id, 'role_id' => 4 ), $post_data );

			$status = 0;
		}
		else
		{
			$status = 1;
		}

		//update the status for the user and redirect to listing with success msg
		$result = $this->consultant_model->update_status($id, $status);
		$this->session->set_flashdata('success', $this->lang->line('consultant_upd_success'));
		$this->output->set_header('location:' . base_url() . 'consultant/manage' . (($page>0) ? '/' . $page : ''));
	}

	function update_status_allcommisions($id = null, $status = 1, $payment_mode = 'offline', $page = 0) {
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		
		//check if id was passed
		if(is_null($id))
		{
			$this->session->set_flashdata('errors', 'Error marking as Paid');
			$this->output->set_header('location:' . base_url() . 'consultant/manage_alldues');
		}	
		

		//update the status for the user and redirect to listing with success msg
		$result = $this->user_model->update_status_allcommisions($id, $payment_mode);
		$this->session->set_flashdata('success', 'Successfully marked as Paid');
		$this->output->set_header('location:' . base_url() . 'consultant/manage_alldues' . (($page>0) ? '/' . $page : ''));
	}
	
	
	function update_status_commission($id = null, $status = 1, $page = 0)
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		
		//check if id was passed
		if(is_null($id))
		{
			$this->session->set_flashdata('errors', 'Error marking as Paid');
			$this->output->set_header('location:' . base_url() . 'consultant/manage_volume_commission');
		}	
		

		//update the status for the user and redirect to listing with success msg
		$result = $this->user_model->update_status_commission($id);
		$this->session->set_flashdata('success', 'Successfully marked as Paid');
		$this->output->set_header('location:' . base_url() . 'consultant/manage_volume_commission' . (($page>0) ? '/' . $page : ''));
	}

function update_status_bonus($id = null, $status = 1, $page = 0)
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		
		//check if id was passed
		if(is_null($id))
		{
			$this->session->set_flashdata('errors', 'Error marking as Paid');
			$this->output->set_header('location:' . base_url() . 'consultant/manage_bonus');
		}	
		

		//update the status for the user and redirect to listing with success msg
		$result = $this->user_model->update_status_bonus($id);
		$this->session->set_flashdata('success', 'Successfully marked as Paid');
		$this->output->set_header('location:' . base_url() . 'consultant/manage_bonus' . (($page>0) ? '/' . $page : ''));
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: edit_user
	*	@param id integer
	*	Description: edit user information
	-----------------------------------------------------------------
	*/

	function edit_consultant($id = null)
	{

		//set required things
		#echo '<pre>';
		//echo $this->uri->segment(3) ;
		$cDetail = $this->session->userdata('user') ;
		$roleid = $cDetail['role_id'];
		
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
		$view_data = array('caption' => 'Edit '.$this->consultant_label);
		
		//get the user details by user id
		
		$view_data['current_edit_user_id'] = $this->uri->segment(3);
		$view_data['edit_roleid'] = $roleid ;
		
		$where_data = array('id' => $this->uri->segment(3));
		$view_data['user'] = $this->user_model->findWhere( 'users', $where_data, $multi_record = FALSE, $order = '' );

		$view_data['consultant_executive_data'] = $this->consultant_model->get_consultant_executive_detail( $this->uri->segment(3) );
		//echo '<pre>';
		//print_r($view_data['consultant_executive_data']);
		
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
		
		//set breadcrumb
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage '.$this->consultant_label => array('link'=>'consultant/manage', 'attributes' => array('class'=>'breadcrumb')),
			lang('edituser_caption').' ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));

		$consData = $this->session->userdata('user') ;
		if(isset($consData['role_id']) && ($consData['role_id'] == 4)){
			$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage '.$this->consultant_label => array('link'=>'#', 'attributes' => array('class'=>'breadcrumb')),
			lang('edituser_caption').' ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));


		}
		$view_data['crumbs'] = $crumbs;
		
		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{
			if($this->form_validation->run('edit_consultant'))
			{
			 $post_data = Array(
			 		'parent_consultant_id' => $this->input->post( 'parent_consultant' ),
                    'name'                 => trim( $this->input->post( 'name' ), true ),
                    'username'             => trim( $this->input->post( 'username' ), true ),
                    'email'                => trim( $this->input->post( 'email' ), true ),
                    //'phone'                => trim( $this->input->post( 'phone' ), true ),
		    'phone'                => trim( $this->input->post( 'phone' )),
                    'status'               => trim( $this->input->post( 'status' ) ),
                );
			$this->user_model->updateWhere( 'users', array('id' => $this->input->post( 'id' ) ), $post_data );
			
			/**
			 * Insert value in consultant executive levels
			 */
			
			//$response_exist = $this->consultant_model->get_consultant_executive_detail( trim( $this->input->post( 'id' ) ) );
			
			$this->creditBonus($this->input->post( 'id' ), $this->input->post( 'executive_level' ),$store_id) ;

			$response_exist = $this->consultant_model->get_executivelvl_consultant(trim( $this->input->post( 'id' ) ),$this->input->post( 'executive_level' ));
			
			if($response_exist)
			{       // if same level assigned earlier
				// update first all to current level to 0
				$this->consultant_model->update_executivelvl_consultant($this->input->post( 'id' )) ;				
				// update to current level
				$post_data2 = Array(
						'executive_level_id' => $this->input->post( 'executive_level' ),
						'modified'           => date("Y-m-d h:i:s"),
						'is_current_lvl'     => 1
				);
					
				$this->consultant_model->update_executive( $this->input->post( 'id' ), $post_data2 );
			}
			else
			{
				// update first
				$this->consultant_model->update_executivelvl_consultant($this->input->post( 'id' )) ;

				// insert now				
				$post_data2 = Array(
						'consultant_user_id' => trim( $this->input->post( 'id' ) ),
						'executive_level_id' => $this->input->post( 'executive_level' ),
						'modified'           => date("Y-m-d h:i:s"),
						'is_current_lvl'     => 1
				);
				
				$this->consultant_model->executive_add( $post_data2 );
				//credit bonus amt
				
			}

			$this->session->set_flashdata('success', $this->consultant_label.' update successfully');
	
			$role_id = $this->session->userdata('user');
			$role_id = $role_id['role_id'];
			if($role_id==4)
			{
				$this->output->set_header('location:' . base_url() . 'consultant/desktop');
			}	
			else if($role_id==2)
			{
				$this->output->set_header('location:' . base_url() . 'consultant/manage');
			}
			else if($role_id==1)
			{
				$this->output->set_header('location:' . base_url() . 'consultant/manage');
			}

			}
			
		} 
		
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		
		$view_data['consultant_list'] = (array)$this->consultant_model->get_all_parent_consultant($store_id, $id);
		$view_data['executive_levels'] = (array)$this->consultant_model->get_all_executive_level($store_id);
		
		$this->_vci_view('edit_consultant', $view_data);
	}
    
    /**
     * Consultant tree view (Parent child relationship)
     */
	function tree_view($page=0, $parent_consultant_id=0)
	{
		$s_id = $this->session->userdata('user');

		

		$store_id = $s_id['id']; 
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		$this->load->model('client_model');
		$storerole = $this->client_model->get_client_details($store_id);
		
		$is_mlmtype = $storerole->is_mlmtype ;
		$role_id = 4;
		
		if(isset($_GET['id']) && $_GET['id']!='')
		{
			$parent_consultant_id = trim($_GET['id']);
		}
		
		if(isset($_GET['id']) && $_GET['id']!='' && $_GET['id']!=0)
		{
			$_SESSION['cons_data'][$_GET['id']] = $_GET['uname'];
			
			$arr1[]= array(
					lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
					$this->consultant_label.' Tree View '=> array('link'=>base_url().'consultant/tree_view', 'attributes' => array('class'=>'breadcrumb')),
			);
			foreach ($_SESSION['cons_data'] as $key => $value)
			{
				if($_GET['id'] == $key)
				{
					$arr1[0][$value." "]= array('link'=>null , 'attributes' => array('class'=>'breadcrumb')) ;
				}
				else
				{
					$arr1[0][$value." "]= array('link'=>base_url().'consultant/tree_view?id='.$key.'&uname='.$value , 'attributes' => array('class'=>'breadcrumb')) ;
				}
			}
		}
		if(!isset($_GET['id']))
		{
			unset($_SESSION);
			session_unset();
			session_destroy();
			$_SESSION = array();
	
			$arr1[]= array(
					lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
					$this->consultant_label.' Tree View '=> array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
			);
		}
		
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		$this->load->library('pagination');
		
		//prepare data to export to view
		$view_data = array('caption' => $this->consultant_label.' Tree View');
		$crumbs = breadcrumb($arr1[0]);
	
		
		$config['base_url'] = base_url() . "consultant/tree_view";
		$config['total_rows'] = intval($this->consultant_model->get_all_consultant('','',true, $store_id, $role_id, $parent_consultant_id ));
		$config['per_page'] = PAGE_LIMIT;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		$view_data['is_mlmtype']= $is_mlmtype ;
		$view_data['consultant'] = $this->consultant_model->get_all_consultant($page, PAGE_LIMIT, false, $store_id, $role_id, $parent_consultant_id);
		$this->_vci_view('consultant_treeview', $view_data);
	}
	
	
	/**
	 * Generational Commission Setting manage
	 */
	function commission_setting()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		$s_id = $this->session->userdata('user');
		$store_id = $s_id['id'];
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		
		$view_data = array('caption' => 'Manage Generational Commission Settings');
		$crumbs = breadcrumb(array(
				lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
				'Manage Generational Commission Settings'=> array('link'=>null, 'attributes' => array('class'=>'breadcrumb'))
		));
		$view_data['crumbs'] = $crumbs;
		
		$view_data['check_store_exist'] = $this->consultant_model->check_store_exist($store_id);
		$view_data['commission_setting'] = $this->consultant_model->get_all_commission_setting($store_id);
		
		$this->_vci_view('commission_setting', $view_data);
	}

	/**
	 * Generational Commission Setting Add
	 */
	function commission_setting_add()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
	
		$s_id = $this->session->userdata('user');
		$store_id = $s_id['id'];
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
	
		$view_data = array('caption' => 'Add Commission');
		$crumbs = breadcrumb(array(
				lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
				'Manage Generational Commission Settings'=> array('link'=>base_url().'consultant/commission_setting', 'attributes' => array('class'=>'breadcrumb')),
				'Add Commission'=> array('link'=>null, 'attributes' => array('class'=>'breadcrumb'))
		));
		$view_data['crumbs'] = $crumbs;
	
		
		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
			//validates the post data by using the rules defined in config file
			if($this->form_validation->run('add_commission'))
				//if( isset($_POST['fName']) && !empty($_POST['fName'])  && isset($_POST['lName']) && !empty($_POST['lName']) && isset($_POST['password']) && !empty($_POST['password']) )
			{
				$post_data = array(
						'store_id' => $store_id,
						'level1'   => htmlspecialchars($this->input->post('level1', true)),
						'level2'   => htmlspecialchars($this->input->post('level2', true)),
						'level3'   => htmlspecialchars($this->input->post('level3', true)),
						'level4'   => htmlspecialchars($this->input->post('level4', true)),
						'level5'   => htmlspecialchars($this->input->post('level5', true)),
						'level6'   => htmlspecialchars($this->input->post('level6', true)),
						'status'   => $this->input->post('status', true),
						'time_created'  => time(),
						'time_modified' => time(),
				);
				//register the client and redirect to listing page with success msg
				if( $this->consultant_model->add_commission( $post_data ) )
				{
					$this->session->set_flashdata('success', $this->lang->line('commission_add_success'));
					$this->output->set_header('location:' . base_url() . 'consultant/commission_setting');
				}
			} else
			{
				//validation comes with errors the load the view again
				$this->_vci_view('commission_setting_add', $view_data);
			}
		} else
		{
			//form not submitted load view normally
			$this->_vci_view('commission_setting_add', $view_data);
		}
	}
	
	/**
	 * Generational Commission Setting Edit
	 */
	function commission_setting_edit()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
	
		$s_id = $this->session->userdata('user');
		$store_id = $s_id['id'];
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		$view_data = array('caption' => 'Edit Commission');
	//	$view_data['current_edit_user_id'] = $this->uri->segment(3);
		$where_data = array('id' => $this->uri->segment(3));
		$view_data['comm_setting'] = $this->consultant_model->commission_findWhere( $where_data, $multi_record = FALSE, $order = '' );
		
		
		
		
		$crumbs = breadcrumb(array(
				lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
				'Manage Generational Commission Setting'=> array('link'=>'consultant/commission_setting', 'attributes' => array('class'=>'breadcrumb')),
				'Edit Commission'=> array('link'=>null, 'attributes' => array('class'=>'breadcrumb'))
		));
		$view_data['crumbs'] = $crumbs;
	
		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
			//validates the post data by using the rules defined in config file
			if($this->form_validation->run('add_commission'))
			{
				$post_data = array(
						'store_id' => $store_id,
						'level1'   => htmlspecialchars($this->input->post('level1', true)),
						'level2'   => htmlspecialchars($this->input->post('level2', true)),
						'level3'   => htmlspecialchars($this->input->post('level3', true)),
						'level4'   => htmlspecialchars($this->input->post('level4', true)),
						'level5'   => htmlspecialchars($this->input->post('level5', true)),
						'level6'   => htmlspecialchars($this->input->post('level6', true)),
						'status'   => $this->input->post('status', true),
						'time_modified' => time(),
				);
				
				//register the client and redirect to listing page with success msg
				if( $this->consultant_model->update_commission( $id = htmlspecialchars($this->input->post('id', true)), $post_data ) )
				{
					$this->session->set_flashdata('success', $this->lang->line('commission_update_success'));
					$this->output->set_header('location:' . base_url() . 'consultant/commission_setting');
				}
				else
				{
					$this->session->set_flashdata('errors', $this->lang->line('commission_error'));
					$this->output->set_header('location:' . base_url() . 'consultant/commission_setting');
				}
			}
			else
			{
				//validation comes with errors the load the view again
				$this->_vci_view('commission_setting_edit', $view_data);
			}
		} 
		else
		{
			//form not submitted load view normally
			$this->_vci_view('commission_setting_edit', $view_data);
		}
		
	}
	
	function commission_update_status($id = null, $status = 1)
	{
		$this->_vci_layout('menu-toolbar');
		
		//check if id was passed
		if(is_null($id))
		{
			$this->session->set_flashdata('errors', $this->lang->line('commission_edit_id_error'));
			$this->output->set_header('location:' . base_url() . 'consultant/commission_setting');
		}
		
		//toggles the status
		if(intval($status) == 1){
			$status = 1;
		}
		else{
			$status = 0;
		}
		
		//update the status for the user and redirect to listing with success msg
		$result = $this->consultant_model->commission_update_status($id, $status);
		$this->session->set_flashdata('success', $this->lang->line('commission_update_success'));
		$this->output->set_header('location:' . base_url() . 'consultant/commission_setting');
	}
    
	
	/**
	 * Invite manage
	 */
	function invite_manage($page = 0)
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		
		$s_id = $this->session->userdata('user');
		$cons_id = $s_id['id'];
		$store_id = $s_id['store_id'];
		
		if( empty( $cons_id ) )
		{
			$cons_id = $this->storeId();
		}
	
		$view_data = array('caption' => 'Manage Invite');
		$crumbs = breadcrumb(array(
				lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
				'Manage Invite'=> array('link'=>null, 'attributes' => array('class'=>'breadcrumb'))
		));
	
		$config['base_url'] = base_url() . "consultant/invite_manage";
		$config['total_rows'] = intval($this->consultant_model->get_all_invites('','',true, $store_id, $cons_id ));
		$config['per_page'] = PAGE_LIMIT;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		//fetch all users from database except current user and super user
		$view_data['all_invites'] = $this->consultant_model->get_all_invites($page, PAGE_LIMIT, false, $store_id, $cons_id);
		$this->_vci_view('invite_manage', $view_data);
	}
	
	/**
	 * Invite Add
	 */
	function invite_add()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
	
		$s_id = $this->session->userdata('user');
		$cons_id = $s_id['id'];
		$store_id = $s_id['store_id'];
		if( empty( $cons_id ) )
		{
			$cons_id = $this->storeId();
		}
	
		$view_data = array('caption' => 'Add Invite');
		$crumbs = breadcrumb(array(
				lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
				'Manage Invite'=> array('link'=> 'consultant/invite_manage', 'attributes' => array('class'=>'breadcrumb')),
				'Add Invite'=> array('link'=>null, 'attributes' => array('class'=>'breadcrumb'))
		));
		$view_data['crumbs'] = $crumbs;
	
	
		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
			//validates the post data by using the rules defined in config file
			if($this->form_validation->run('add_invite'))
				//if( isset($_POST['fName']) && !empty($_POST['fName'])  && isset($_POST['lName']) && !empty($_POST['lName']) && isset($_POST['password']) && !empty($_POST['password']) )
			{
				$email = $this->input->post('email', true);
				
				$post_data = array(
						'store_id'      => $store_id,
						'consultant_id' => $cons_id,
						'email'         => htmlspecialchars($this->input->post('email', true)),
						'time_created'  => time(),
						'time_modified' => time()
				);
				
				
				$response_store = $this->consultant_model->get_detail_current_store( $store_id );
				$store_username = $response_store[0]->username;
				$cons_username = $s_id['username'];
				
				
				$consultant_refer_register_link = root_path.$store_username.'/'.$cons_username.'/user/consultant/'.base64_encode($cons_id);
				
				$response_sender = $this->consultant_model->get_invitation_sender_detail($cons_id);
				$email_from = $response_sender[0]->email;
				$email_name = $response_sender[0]->username;
				//register the client and redirect to listing page with success msg
				
				$this->load->library('email');
				$this->load->library('parser');
				$smtp_settings = $this->config->item('smtp');
				$sender_from = $email_from;
				$sender_name = $email_name ;
				$this->email->initialize( $smtp_settings );
				$this->email->from( $sender_from, $sender_name );
				$this->email->to( htmlspecialchars( $email ) );
				
				$ndata = array(
						'title' => $this->consultant_label.' Invitation',
						'CONTENT' => 'Please <a href="'.$consultant_refer_register_link.'">Click Here</a> for register as '.$this->consultant_label ,
						'USER'=> htmlspecialchars( ucwords( $email ) )
				);
					
				$body = $this->parser->parse('default/emails/invite_consultant', $ndata, true);
				#echo $body ;
				//$this->email->cc('another@another-example.com');
				$this->email->subject($this->consultant_label.' Invitation - Online Market Place');
				$this->email->message( $body );
				
				if ( ! $this->email->send())
				{
					#echo $this->email->print_debugger();
					#echo 'No mail';
					#die;
				}
				else
				{
				
				
					if( $this->consultant_model->add_invite( $post_data ) )
					{
						$this->session->set_flashdata('success', $this->lang->line('consultant_invite_success'));
						$this->output->set_header('location: ' . base_url() . 'consultant/invite_manage');
						
					}
					else 
					{
						$this->session->set_flashdata('errors', $this->lang->line('consultant_invite_errors'));
						$this->output->set_header('location: ' . base_url() . 'consultant/invite_manage');
						
					}
					
				}
			}
			else
			{
				//validation comes with errors the load the view again
				$this->_vci_view('invite_add', $view_data);
			}
		} 
		else
		{
			//form not submitted load view normally
			$this->_vci_view('invite_add', $view_data);
		}
	}
	
	/**
	 * Invite edit
	 */
	function invite_edit()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
	
		$s_id = $this->session->userdata('user');
		$cons_id = $s_id['id'];
		$store_id = $s_id['store_id'];
		if( empty( $cons_id ) )
		{
			$cons_id = $this->storeId();
		}
		
		$view_data = array('caption' => 'Edit Invite');
		
		
		//	$view_data['current_edit_user_id'] = $this->uri->segment(3);
		$where_data = array('id' => $this->uri->segment(3));
		$view_data['edit_data_invite'] = $this->consultant_model->invite_findWhere( $where_data, $multi_record = FALSE, $order = '' );
	
		$crumbs = breadcrumb(array(
				lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
				'Manage Invite'=> array('link'=> 'consultant/invite_manage', 'attributes' => array('class'=>'breadcrumb')),
				'Edit Invite'=> array('link'=>null, 'attributes' => array('class'=>'breadcrumb'))
		));
		$view_data['crumbs'] = $crumbs;
	
		//check if form was submitted by the client
		if($this->input->post('formSubmitted') > 0)
		{
			//validates the post data by using the rules defined in config file
			if($this->form_validation->run('add_invite'))
			{
				$post_data = array(
						'email'         => htmlspecialchars($this->input->post('email', true)),
						'time_modified' => time(),
				);
	
				//register the client and redirect to listing page with success msg
				if( $this->consultant_model->update_invite( $id = htmlspecialchars($this->input->post('id', true)), $post_data ) )
				{
					$this->session->set_flashdata('success', $this->lang->line('invite_update_success'));
					$this->output->set_header('location:' . base_url() . 'consultant/invite_manage');
				}
				else
				{
					$this->session->set_flashdata('errors', $this->lang->line('consultant_invite_errors'));
					$this->output->set_header('location:' . base_url() . 'consultant/invite_manage');
				}
			}
			else
			{
				//validation comes with errors the load the view again
				$this->_vci_view('invite_edit', $view_data);
			}
		}
		else
		{
			//form not submitted load view normally
			$this->_vci_view('invite_edit', $view_data);
		}
	
	}
	
	function invite_delete()
	{
		$this->_vci_layout('menu-toolbar');
		
		if($this->consultant_model->delete_invite())
		{
			$this->session->set_flashdata('success', $this->lang->line('invite_del_success'));
			$this->output->set_header('location:' . base_url() . 'consultant/invite_manage');
		}
		else {
		    $this->session->set_flashdata('errors',$this->lang->line('invite_del_failed'));
			$this->output->set_header('location:'. base_url(). 'consultant/manage');
		}
	}
	
	function invite_resend_invitation( $id = 0 )
	{
	
		if( $id == 0 )
		{
			$this->session->set_flashdata('errors', $this->lang->line('invite_resend_error'));
			$this->output->set_header('location:' . base_url() . 'consultant/invite_manage');
			exit;
		}
		
		$s_id = $this->session->userdata('user');
		$cons_id = $s_id['id'];
		$store_id = $s_id['store_id'];
		if( empty( $cons_id ) )
		{
			$cons_id = $this->storeId();
		}
		
		$response_store = $this->consultant_model->get_detail_current_store( $store_id );
		$store_username = $response_store[0]->username;
		$cons_username = $s_id['username'];
		
	//	$consultant_refer_register_link = root_path.$store_username.'/'.$cons_username.'/user/consultant/'.base64_encode($cons_id);
		$consultant_refer_register_link = root_path.$store_username.'/'.$cons_username.'/user/consultant/';
		
		$response_sender = $this->consultant_model->get_invitation_sender_detail($cons_id);
		$email_from = $response_sender[0]->email;
		$email_name = $response_sender[0]->username;
		
		$response = $this->consultant_model->get_invitation_receiver_detail($id);
		$email = $response[0]->email;
		
		$this->load->library('email');
		$this->load->library('parser');
		$smtp_settings = $this->config->item('smtp');
		$sender_from = $email_from;
		$sender_name = $email_name;
		$this->email->initialize( $smtp_settings );
		$this->email->from( $sender_from, $sender_name );
		$this->email->to( htmlspecialchars( $email ) );
		
		
		$ndata = array(
				'title' => 'Consultant Invitation',
				'CONTENT' => 'Please <a href="'.$consultant_refer_register_link.'">Click Here</a> for register as '.$this->consultant_label ,
				'USER'=> htmlspecialchars( ucwords( $email ) )
		);
			
		$body = $this->parser->parse('default/emails/invite_consultant', $ndata, true);
		//$this->email->cc('another@another-example.com');
		$this->email->subject($this->consultant_label.' Invitation - Online Market Place');
		$this->email->message( $body );
		
		if ( ! $this->email->send())
		{
			#echo $this->email->print_debugger();
		}
		else
		{
			$this->session->set_flashdata('success', $this->lang->line('invite_resend_success'));
			$this->output->set_header('location:' . base_url() . 'consultant/invite_manage');
		}
	}
	
	function is_consultant_email_exist($email)
	{
	//	$this->load->model('user_model');
		
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		
		return (!empty($this->userid)) ? !$this->consultant_model->is_consultant_email_exist($email, $store_id, $this->userid) : !$this->consultant_model->is_consultant_email_exist($email, $store_id);
	}
	
	function is_email_exist()
	{
		$s_id = $this->session->userdata('user');
		$cons_id = $s_id['id'];
		$store_id = $s_id['store_id'];
		if( empty( $cons_id ) )
		{
			$cons_id = $this->storeId();
		}
		
		$email = trim($_POST['email']);
		if($email != '')
		{
			$result = $this->consultant_model->is_invite_email_exist($email, $cons_id);
			
			if( $result == 'consultant' && $result != 1 )
			{
				$this->form_validation->set_message('is_email_exist', 'This email address already registered with us as a '.$this->consultant_label );
				return false;
			}
			else if( $result == 'invite' && $result != 1 )
			{
				$this->form_validation->set_message('is_email_exist', 'This email address already invited, You can resend invitation.');
				return false;
			}
			else if( $result == 'invitebyother' && $result != 1 )
			{
				//$this->form_validation->set_message('is_email_exist', 'This email address already invited, You can resend invitation.');
				return true;
			}
			else 
			{
				return true;
			}
		}
	}

	///

	function manage_bonus($page = 0 , $q_s=null,$startdate="", $enddate ="" )
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
		$view_data = array('caption' => "Bonus Reports- ".$this->consultant_label);
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Bonus Reports Reports - '.$this->consultant_label.' ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		//set pagination configs
		if($this->input->get('from_date')){
			$startdate = $this->input->get('from_date');
			$view_data['fromdate'] = $startdate ;
		}
		if($this->input->get('to_date')){
			$enddate = $this->input->get('to_date');
			$view_data['todate'] = $enddate ;
		}
		
		//set required things
		
		ini_set('display_errors',1);
		$date_from = "";
		$date_to = "" ;
		if($startdate == "" && $enddate== ""){
			$current_month      = date('m', time());
			$current_year       = date('Y', time());
			if( $this->session->userdata('sales_report_duration')=='week' )
			{
				$source_date         = Date('d-m-Y', strtotime("Last Sunday"));
				$source_date_time_ms = strtotime($source_date." 00:00:00");
					
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
			else if( $this->session->userdata('sales_report_duration')=='month' )
			{
				$source_date         = "01-".$current_month."-".$current_year;
				$source_date_time_ms = strtotime($source_date." 00:00:00");
			
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
			else if( $this->session->userdata('sales_report_duration')=='year' )
			{
				$source_date         = "01-01-".$current_year;
				$source_date_time_ms = strtotime($source_date." 00:01:00");
			
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
				
		}else{
			if($startdate !=''){
				$date_from = str_replace('/','-',$startdate) ;
				$date_from = strtotime($date_from." 00:00:00");
				
			}
			
			if($enddate !=''){
				$date_to = str_replace('/','-',$enddate) ;
				$date_to = strtotime($date_to." 00:00:00");
			}
			
		}
				
		//set pagination configs
		$getData                 = array('from_date'=>$startdate ,'to_date'=>$enddate,'submit'=>'Filter');		
		$config['suffix']        = '?'.http_build_query($getData,'',"&amp;");		
		$config['base_url']      = base_url() . "consultant/manage_bonus";
		$config['first_url']     = base_url() . "consultant/manage_bonus?page=&from_date=".$startdate."&to_date=".$enddate;

		$config['total_rows']    = intval($this->user_model->get_all_bonus('','',true, $store_id, 4 ,$date_from, $date_to));
		$config['per_page']      = PAGE_LIMIT;		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs']     = $crumbs;
		//fetch all users from database except current user and super user
		$view_data['users']      = $this->user_model->get_all_bonus($page, PAGE_LIMIT, false, $store_id, 4,$date_from, $date_to);
		
		$this->_vci_view('manage_bonus', $view_data);
	}

	function manage_alldues($page = 0 , $q_s=null,$startdate="", $enddate ="" )
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
		$view_data = array('caption' => "Total Commissions Report - ".$this->consultant_label);
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Total Commissions Report - '.$this->consultant_label.' ('.$store_name_brdcrmb.')' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		//set pagination configs
		if($this->input->get('from_date')){
			$startdate = $this->input->get('from_date');
			$view_data['fromdate'] = $startdate ;
		}
		if($this->input->get('to_date')){
			$enddate = $this->input->get('to_date');
			$view_data['todate'] = $enddate ;
		}
		
		//set required things
		
		ini_set('display_errors',1);
		$date_from = "";
		$date_to = "" ;
		if($startdate == "" && $enddate== ""){
			$current_month      = date('m', time());
			$current_year       = date('Y', time());
			if( $this->session->userdata('sales_report_duration')=='week' )
			{
				$source_date         = Date('d-m-Y', strtotime("Last Sunday"));
				$source_date_time_ms = strtotime($source_date." 00:00:00");
					
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
			else if( $this->session->userdata('sales_report_duration')=='month' )
			{
				$source_date         = "01-".$current_month."-".$current_year;
				$source_date_time_ms = strtotime($source_date." 00:00:00");
			
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
			else if( $this->session->userdata('sales_report_duration')=='year' )
			{
				$source_date         = "01-01-".$current_year;
				$source_date_time_ms = strtotime($source_date." 00:01:00");
			
				$date_from = $source_date_time_ms;
				$date_to   = time();
			}
				
		}else{
			if($startdate !=''){
				$date_from = str_replace('/','-',$startdate) ;
				$date_from = strtotime($date_from." 00:00:00");
				
			}
			
			if($enddate !=''){
				$date_to = str_replace('/','-',$enddate) ;
				$date_to = strtotime($date_to." 00:00:00");
			}
			
		}
				
		//set pagination configs
		$getData                 = array('from_date'=>$startdate ,'to_date'=>$enddate,'submit'=>'Filter');		
		$config['suffix']        = '?'.http_build_query($getData,'',"&amp;");		
		$config['base_url']      = base_url() . "consultant/manage_alldues";
		$config['first_url']     = base_url() . "consultant/manage_alldues?page=&from_date=".$startdate."&to_date=".$enddate;

		$config['total_rows']    = intval($this->user_model->get_all_duereport('','',true, $store_id, 4 ,$date_from, $date_to));
		$config['per_page']      = PAGE_LIMIT;		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs']     = $crumbs;
		//fetch all users from database except current user and super user
		$view_data['users']      = $this->user_model->get_all_duereport($page, PAGE_LIMIT, false, $store_id, 4,$date_from, $date_to);
		
		$this->_vci_view('manage_alldues', $view_data);
	}	

}

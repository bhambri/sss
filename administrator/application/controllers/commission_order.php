<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-------------------------------------------------------------
*	Class:	Commission_order extends VCI_Controller defined in libraries
*	Author:	Vince Balrai
*	Platform:	Codeigniter
*	Company:	Segnant Technologies
*	Description: Manage user entity
-------------------------------------------------------------
*/
class Commission_order extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('commission_order_model');
	}

	/*
	-----------------------------------------------------------------
	*	Method: commission_order_manage
	*	@param page integer
	*	Description: creates listing and handles search operations
	-----------------------------------------------------------------
	*/

	function commission_order_manage($page = 0,$q_s=null,$startdate="", $enddate ="")
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		$this->load->model('sales_model') ;
		
	    $store_id = $this->session->userdata('storeId');
	    if( empty( $store_id ) )
	    {
	        $store_id = $this->storeId();
	    }
		
		//prepare the data for exporting to view
		$view_data['duration'] = $this->session->userdata('sales_report_duration');

		$view_data = array('caption' => 'Commission Order');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Commission Order' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		

		if($this->input->get('from_date')){
			$startdate = $this->input->get('from_date');
			$view_data['fromdate'] = $startdate ;
		}
		if($this->input->get('to_date')){
			$enddate = $this->input->get('to_date');
			$view_data['todate'] = $enddate ;
		}

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
			}else{
				// default should be weekly, As per comment by client
				$source_date         = Date('d-m-Y', strtotime("Last Sunday"));
				$source_date_time_ms = strtotime($source_date." 00:00:00");
					
				$date_from = $source_date_time_ms;
				$date_to   = time();

				$this->session->set_userdata('sales_report_duration','week') ;
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

		$getData = array('from_date'=>$startdate ,'to_date'=>$enddate,'submit'=>'Filter');
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");

		//set pagination configs
		$config['first_url'] = base_url() . "commission_order/commission_order_manage?page=&from_date=".$startdate."&to_date=".$enddate;

		$config['base_url'] = base_url() . "commission_order/commission_order_manage";
		//$config['total_rows'] = intval($this->commission_order_model->get_all_data('','',true, $store_id ));
		$config['total_rows'] = intval($this->commission_order_model->get_all_data_report('','',true, $store_id,$date_from , $date_to ));
		//$this->commission_order_model->get_all_data_report($page, PAGE_LIMIT, false, $store_id,$date_from , $date_to);

		$config['per_page'] = PAGE_LIMIT;		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		//fetch all users from database except current user and super user
		
		$view_data['commission_order_data'] = $this->commission_order_model->get_all_data_report($page, PAGE_LIMIT, false, $store_id,$date_from , $date_to);
		$view_data['reportsum'] = $this->commission_order_model->get_all_data_reportsum($store_id,$date_from , $date_to) ;
	
		$view_data['consultant'] = $this->sales_model->get_all_consultant_from_current_store($store_id);
		
		$this->_vci_view('commission_order_manage', $view_data);

	}

	/*
	Marking order entry as paid
	*/
	function markstatus($status=1)
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->model('user_model');
		
		if($this->commission_order_model->markstatuspaid($status))
		{
			$this->session->set_flashdata('success', 'Pay status updated successfully');
			$this->output->set_header('location:' . base_url() . 'commission_order/commission_order_manage');
		}
		else {
		    $this->session->set_flashdata('errors', 'Updating pay Status failed');
			$this->output->set_header('location:'. base_url(). 'commission_order/commission_order_manage');
		}
	}

	/*
	changing order entry status
	*/
	function changestatus($cid = null, $status = 1, $page = 0){
		if(intval($status) == 1){
			$status = 0;
		}
		else{
			$status = 1;
		}

		//update the status for the user and redirect to listing with success msg
		$result = $this->commission_order_model->changestatus($cid ,$status);
		$this->session->set_flashdata('success', 'Pay status updated successfully');
		if($_SERVER['HTTP_REFERER']){
			redirect($_SERVER['HTTP_REFERER']) ;
		}
		$this->output->set_header('location:' . base_url() . 'commission_order/commission_order_manage' . (($page>0) ? '/' . $page : ''));
	}
}

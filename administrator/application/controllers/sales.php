<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-------------------------------------------------------------
*	Class:	User extends VCI_Controller defined in libraries
*	Author:	Rakesh
*	Platform:	Codeigniter
*	Description: Manage Sales Products
-------------------------------------------------------------
*/
class Sales extends VCI_Controller {
	
	var $userid = null; //stores current user id

	function __construct()
	{
		parent::__construct();
			
		$this->load->library('session' );
		$this->load->model('sales_model');
	}

	function manage( $page = 0, $q_s=null,$startdate="", $enddate ="" )
	{
		
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		$view_data['duration'] = $this->session->userdata('sales_report_duration');
		
		//prepare the data for exporting to view
		$view_data = array('caption' => 'Sale Tracking Report');
		$crumbs = breadcrumb(array(
				'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
				'Sale Tracking Report' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		if($this->input->get('from_date')){
			$startdate = $this->input->get('from_date');
			$view_data['fromdate'] = $startdate ;
		}
		if($this->input->get('to_date')){
			$enddate = $this->input->get('to_date');
			$view_data['todate'] = $enddate ;
		}
		
		//set required things
		
		#ini_set('display_errors',1);
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
		
		$config['first_url'] = base_url() . "sales/manage?page=&from_date=".$startdate."&to_date=".$enddate;
		
		$config['base_url'] = base_url() . "sales/manage";
		$config['total_rows'] = intval($this->sales_model->get_all_sales_report($page,PAGE_LIMIT,true,$store_id , $date_from, $date_to ));
		$config['per_page'] = PAGE_LIMIT;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		
		$view_data['sales_report'] = $this->sales_model->get_all_sales_report( $page,PAGE_LIMIT,false,$store_id ,$date_from,$date_to );
		
		$view_data['sales_all_sum'] = $this->sales_model->get_all_sales_report_sum( true, $store_id, $date_from, $date_to );
		
		$this->_vci_view('sales_manage', $view_data);
	}

/*
Top sales report
for consultants
*/
	function topsales( $page = 0, $q_s=null,$startdate="", $enddate ="" )
	{
		
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		$store_id = $this->session->userdata('storeId');
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
        
        $userDetails = $this->session->userdata("user");
		
		if( isset( $userDetails['role_id'] ) &&  $userDetails['role_id'] == 4 )
		{	
			$consultantId = $userDetails['id'];	
		}
		else
		{
			$consultantId = '';
		}

		if(!$consultantId){
			$consultantId = $this->session->userdata('consultantId') ;
		}

		#echo 'consultantid'.$consultantId ;
		$view_data['duration'] = $this->session->userdata('sales_report_duration');
		
		//prepare the data for exporting to view
		$view_data = array('caption' => 'Top X sales by '.$this->consultant_label);
		$crumbs = breadcrumb(array(
				'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
				'Manage Sales Reports' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
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
				
		
		$getData = array('from_date'=>$startdate ,'to_date'=>$enddate,'submit'=>'Filter');
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		
		$config['first_url'] = base_url() . "sales/topsales?page=&from_date=".$startdate."&to_date=".$enddate;
		
		$config['base_url'] = base_url() . "sales/topsales";
		$config['total_rows'] = intval($this->sales_model->get_topx_sales_report($page,PAGE_LIMIT,true,$store_id ,$consultantId, $date_from, $date_to ));
		$config['per_page'] = PAGE_LIMIT;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		//fetch all users from database except current user and super user

		$view_data['sales_report'] = $this->sales_model->get_topx_sales_report( $page,PAGE_LIMIT,false,$store_id ,$consultantId,$date_from,$date_to );
		
		$view_data['sales_all_sum'] = $this->sales_model->get_topx_sales_report_sum( true, $store_id, $consultantId, $date_from, $date_to );
		
		$view_data['clients_consultant']  = $this->sales_model->all_clients_consultant();
		$this->_vci_view('topsales', $view_data);
	}


	function grouppurchase($page=0){
		
		ini_set('display_errors',0) ;
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		
		$Actstore_id = $this->session->userdata('storeId');
		
		if( empty( $store_id ) )
		{
			$Actstore_id = $this->storeId();
		}

		
        $store_id = $_REQUEST['store_id'] ;
        $group_code = $_REQUEST['group_code'] ;

        if(!$store_id){
        	die('invalid url') ;
        }
        if(!$group_code){
        	die('invalid url') ;
        }

        $userDetails = $this->session->userdata("user");
		
		if( isset( $userDetails['role_id'] ) &&  $userDetails['role_id'] == 4 )
		{	
			$consultantId = $userDetails['id'];	
		}
		else
		{
			$consultantId = '';
		}

		if(!$consultantId){
			$consultantId = $this->session->userdata('consultantId') ;
		}

		#echo 'consultantid'.$consultantId ;
		$view_data['duration'] = $this->session->userdata('sales_report_duration');

		//prepare the data for exporting to view
		$view_data = array('caption' => 'Party Sale management');
		$crumbs = breadcrumb(array(
				'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
				'Party Sale management' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		//$startdate = '';
		//$enddate =''
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
		if(@$startdate == "" && @$enddate== ""){
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
		
		
		
		$getData = array('store_id'=>$store_id , 'group_code'=>$group_code,'from_date'=>@$startdate ,'to_date'=>@$enddate,'submit'=>'Filter');
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		
		$config['first_url'] = base_url() . "sales/grouppurchase/?page=&store_id=".$store_id."&group_code=".$group_code."&from_date=".@$startdate."&to_date=".@$enddate;
		
		$config['base_url'] = base_url() . "sales/grouppurchase/";

		
		$config['total_rows'] = intval($this->sales_model->get_grouppurchase_sales_report(@$page,PAGE_LIMIT,true,$store_id ,$group_code, @$date_from, @$date_to ));
		$config['per_page'] = PAGE_LIMIT;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;

		$view_data['sales_report'] = $this->sales_model->get_grouppurchase_sales_report(@$page,PAGE_LIMIT,false,$store_id ,$group_code,$date_from,$date_to );
		$view_data['sales_report_sum'] = $this->sales_model->get_grouppurchase_sales_report_sum(true,'' ,true,$store_id ,$group_code,$date_from,$date_to );
		
		$this->_vci_view('grouppurchase_sales', $view_data);
	}

} //class file end here

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * VCI_Controller extends Controller default controller of codeigniter
 * 	overriding the default controller. provides additional 
 *	functionality for layout and views and handles unauthorized user access
 *	to admin panel and provides common functionality
 *
 *  @author Vince Balrai
 */
class VCI_Controller extends CI_Controller {
	var $layout = "default/layout/default"; //default layout

	var $sclientid;	
	var $consultant_label = 'Consultant' ;
	/**
	 * Default constructor
	 * 
	 */
	function __construct() 
	{
		ini_set("display_errors",0);
		
		parent::__construct();
		$this->_is_user_logged_in();
		$this->_is_authorized_user();
		$segs = $this->uri->segment_array();

	    if( ( isset( $segs[3] ) && !empty( $segs[3] ) ) && (substr($segs[3], 0, 5) == "scid_") )
	     {
	            $this->sclientId =  str_replace('scid_', '', $segs[3] );	
	     }
	     elseif( ( isset( $segs[4] ) && !empty( $segs[4] ) ) && (substr($segs[4], 0, 5) == "scid_") )
	     {
	            $this->sclientId =  str_replace('scid_', '', $segs[3] );	
	     }

	     $loggeduser = $this->session->userdata('user') ;

	     if(!empty($loggeduser) && isset($loggeduser['role_id']) && ($loggeduser['role_id'] == 2) ){

	     	$this->load->model('settings_model') ;
	     	$se = $this->settings_model->get_store_settings_page($loggeduser['id'], $loggeduser['role_id']) ;
	     	
	     	if(isset($se->consultant_label) && ($se->consultant_label != "")) {
	     		$this->consultant_label  = $se->consultant_label ;
	     	}
	     }

	     if(!empty($loggeduser) && isset($loggeduser['role_id']) && ($loggeduser['role_id'] == 4) ){

	     	$this->load->model('settings_model') ;
	     	$se = $this->settings_model->get_store_settings_page($loggeduser['store_id'], 2 ) ;
	     	
	     	if(isset($se->consultant_label) && ($se->consultant_label != "")) {
	     		$this->consultant_label  = $se->consultant_label ;
	     	}
	     }

	    #echo '<pre>';
	    #print_r($loggeduser);
	    #echo 'Abhishek'.$this->consultant_label ;
	}

	/**
	 * Set the layout for the view
	 * 
	 * @param string $layout
	 * @param string $theme
	 */
	function _vci_layout($layout,$theme = 'default')
	{
		error_reporting(E_ERROR);
		$user = $this->session->userdata('user');
		
		// if(($user['is_admin']) || $_GET['theme'] == 1 || $user['role_id'] == 2) {
			// $theme	= 'smartadmin';
		// }
		$theme	= 'smartadmin';
		(!empty($layout))? $this->layout = trim(strtolower($theme)) . '/layout/' . trim(strtolower($layout)) : 'default/layout/default';
	}

	/**
	 * Set the view to load
	 * 
	 * @param string $view
	 * @param array $data
	 * @param string $output
	 */
	function _vci_view($view = 'index', $data = array(), $output = false)
	{
		$data['vci_view'] = trim($view);
		$this->load->view($this->layout, $data, $output);
	}
	
	/*
	------------------------------------------------------------------------
	*	Method:	_is_user_logged_in
	*	Description: check if user is not logged in then redirect him to login
		page or if logged in then send him inside
	------------------------------------------------------------------------
	*/
	/**
	 * Check if user is not logged in then redirect user to login page or if logged in then 
	 * send inside 
	 */
	function _is_user_logged_in()
	{
		$user = $this->session->userdata('user');
		//$this->session->unset_userdata('user');
		//user is logged in send him inside
		if ( isset($user['username']) && $this->router->fetch_method() == 'index')
		{
			//$this->output->set_header('location:' . $this->config->item('base_url') . 'admin/desktop');
			$this->output->set_header('location:' . $this->config->item('base_url') . $user['controller'].'/desktop');
			//user is not logged in and requested the forgot password so do nothing let him retrieve his password
		} else if ( ( ! isset($user['username'])) && $this->router->fetch_method() == 'forgot_password')
		{
			// Do nothing let it continue.
			//user is not logged in and he is try to access inner pages. send him out.
		} else if ( ( ! isset($user['username'])) && $this->router->fetch_method() != 'index')
		{

			$this->output->set_header('location:' . $this->config->item('base_url') . $user['controller'].'/index');
		}
	}


	function _is_authorized_user()
	{
		$this->load->model('common_model');
		$user = $this->session->userdata('user');
		$user_id = $user['id'];
		$role_id  = $user['role_id'];
		$current_controller = $this->router->fetch_class(); 
		$current_method = $this->router->fetch_method(); 
		//echo $current_controller . '/' . $current_method . '/' . $user_id .'/'.$role_id;  die;
		if( !isset($user['username']) && ( $current_method != 'index' ) && ( $current_method  != 'forgot_password' ) && ( ( $current_controller != 'admin' ) || ( $current_controller != 'client' ) || ( $current_controller != 'consultant' ) ) )
		{			   
			$this->output->set_header('location:' . $this->config->item('base_url') . $current_controller . '/index');
		}
		else if( ( $current_method != 'index' ) && ( $current_method  != 'forgot_password' ) && ( ( $current_controller != 'admin' ) || ( $current_controller != 'client' ) || ( $current_controller != 'consultant' ) )  
		
		    && ( ( $current_controller != 'content' ) )
		  )
		{ //echo $current_controller . '/' . $current_method . '/' . $user_id .'/'.$role_id;  die;
		    if( !$this->common_model->_is_authorized_user( $user_id, $current_controller, $current_method, $role_id) )
			{
				redirect( base_url() . 'errors/e403/'. $current_controller . '/' . $current_method );
			}
		}	

		if(  $current_controller == 'errors')
		{	
			return true;
			die();
		}
		//echo $current_controller . '/' . $current_method . '/' . $user_id .'/'.$role_id; die;
		
		//echo " ITs working "; die;
	}

	function pr( $data, $die = true )
	{
		echo "<pre>";
		print_r( $data );
		echo "</pre>";
		( $die ) ? die(): '';
	}

	function storeId()
	{
		$session_user_data =  $this->session->userdata('user');

		if( $session_user_data['role_id']  == 2 )
		{
  	        return ( isset( $session_user_data['role_id'] ) && ( $session_user_data['role_id']  == 2 ) ) ? $session_user_data['id'] : 0; // clients id is store_id
  	    }
  	    else if( $session_user_data['role_id']  == 4 )
  	    {
  	        return ( isset( $session_user_data['role_id'] ) && ( $session_user_data['role_id']  == 4 ) ) ? $session_user_data['store_id'] : 0; //consultant's has store_id
  	    }
  	    else
  	    {  
  	        return 0; 
  	    }

  	}

	function get_hexe_lvl($consultant_id){
	$this->load->model('consultant_model');
	$result = $this->consultant_model->get_heighest_executivelvl_consultant($consultant_id) ;
	return $result[0]->executive_level;
	}

    function get_exe_lvl($consultant_id){
	$this->load->model('consultant_model');
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
		

	}
  	
 	function creditBonus($consultant_id , $exe_lvl_beingassigned,$store_id){
		//get current executive level
		$elevels = array() ; // all exe. levels assigned

		$this->load->model('consultant_model');
		$result = $this->consultant_model->get_consultant_executive_detail( $consultant_id ); // return current executive levels
		
		//get all exe levels assigned previously
		$all_exe_levels = $this->consultant_model->get_consultant_allexecutive_levels( $consultant_id ) ;
		foreach($all_exe_levels as $exelevels){
		   $elevels[] = $exelevels->executive_level_id;
		}
		
		//get exe level assigned currently
		$current_exe_lvl =  @$result[0]->executive_level_id ;

		// check wheather this exe lvl assigned before
		if(!in_array($exe_lvl_beingassigned,$elevels)){
			//compare the ranks of both
			$ranktoupdate = $this->compare_levels($exe_lvl_beingassigned,$current_exe_lvl) ;
			//if greater then credit
			//echo '<pre>';
			//print_r($ranktoupdate);
			if(!empty($ranktoupdate)){
				//echo 'needs t be credited now';
				$bonusData = array(
				   'consultant_id' => $consultant_id ,
				   'exe_lvl_id' => $ranktoupdate['id'] ,
				   'bonus_amt' => $ranktoupdate['bonus_amt'],
				   'store_id'  => $store_id,
				);

			$this->db->insert('executive_bonus', $bonusData); 
			}
			
		}else{
		  //echo  'nothing to do'; 
		  // bonus paid already
		}		
		//die;		
	}

	function compare_levels($lvl_b_ass,$lvl_a_ass){
		$this->db->select(array('id','bonus_amt','exec_order'));
		$this->db->where_in('id',array($lvl_b_ass));
		$this->db->from('executive_levels') ;	
		$result = $this->db->get();
		//echo '<pre>';	
		$resExelvlbeingAss = $result->result() ;
		//print_r($resExelvlbeingAss);

		$this->db->select(array('id','bonus_amt','exec_order'));
		$this->db->where_in('id',array($lvl_a_ass));
		$this->db->from('executive_levels') ;	
		$result = $this->db->get();
		
                $resExelvlalreadyAss = $result->result() ;
		//print_r($resExelvlalreadyAss);
		if($resExelvlbeingAss[0]->exec_order > $resExelvlalreadyAss[0]->exec_order){
			// return 1
			return (array)$resExelvlbeingAss[0];
		}
		return array() ;
	}
	
	/* getting current week sales */
	function getcw_sales($consultant_id=''){
		$previous_week = strtotime(date('Y-m-d'));
		//$previous_week = strtotime("-1 week +1 day");
		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);
		$start_week = date("Y-m-d",$start_week);
		$end_week = date("Y-m-d",$end_week);
		$this->load->model('sales_model');
		$salesReport = $this->sales_model->get_sales_sum($consultant_id,$start_week, $end_week);
		return (float)$salesReport[0]['sum_order_amount'] ;	
	}
	
	/* getting last week sales */
	function getlw_sales($consultant_id=''){
		//return 200;
		$previous_week = strtotime("-1 week +1 day");
		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);
		$start_week = date("Y-m-d",$start_week);
		$end_week = date("Y-m-d",$end_week);
		$this->load->model('sales_model');
		$salesReport = $this->sales_model->get_sales_sum($consultant_id,$start_week, $end_week);
		return (float)$salesReport[0]['sum_order_amount'] ;	
	}
	/* getting the current month sales */
	function getcm_sales($consultant_id=''){
		//return 500;
		
		$start_week = date("Y-m-01");
		$end_week = date("Y-m-d");
		$this->load->model('sales_model');
		$salesReport = $this->sales_model->get_sales_sum($consultant_id,$start_week, $end_week);
		return (float)$salesReport[0]['sum_order_amount'] ;
	}

	function getcwvol_sales($consultant_id=''){
		$previous_week = strtotime(date('Y-m-d'));
		//$previous_week = strtotime("-1 week +1 day");
		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);
		$start_week = date("Y-m-d",$start_week);
		$end_week = date("Y-m-d",$end_week);
		$this->load->model('sales_model');
		$salesReport = $this->sales_model->get_sales_sumvol($consultant_id,$start_week, $end_week);
		return (float)$salesReport[0]['sum_order_volume'] ;	
	}
	
	/* getting last week sales */
	function getlwvol_sales($consultant_id=''){
		//return 200;
		$previous_week = strtotime("-1 week +1 day");
		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);
		$start_week = date("Y-m-d",$start_week);
		$end_week = date("Y-m-d",$end_week);
		$this->load->model('sales_model');
		$salesReport = $this->sales_model->get_sales_sumvol($consultant_id,$start_week, $end_week);
		return (float)$salesReport[0]['sum_order_volume'] ;	
	}
	/* getting the current month sales */
	function getcmvol_sales($consultant_id=''){
		//return 500;
		
		$start_week = date("Y-m-01");
		$end_week = date("Y-m-d");
		$this->load->model('sales_model');
		$salesReport = $this->sales_model->get_sales_sumvol($consultant_id,$start_week, $end_week);
		return (float)$salesReport[0]['sum_order_volume'] ;
	}
	
	function getsales_labels($consultant_id=''){
		return ' ( $'.$this->getcw_sales($consultant_id).' / $'.$this->getlw_sales($consultant_id).' / $'.$this->getlw_sales($consultant_id).' )' ;

	}

	function getsales_vol_labels($consultant_id=''){
		return ' ( '.$this->getcwvol_sales($consultant_id).' / '.$this->getlwvol_sales($consultant_id).' / '.$this->getlwvol_sales($consultant_id).' )' ;

	}	
}

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * VCI_Controller extends Controller default controller of codeigniter
 * 	ov                                             erriding the default controller. provides additional 
 *	functionality for layout and views and handles unauthorized user access
 *	to admin panel and provides common functionality
 *
 *  @author Vince Balrai
 */
class VCI_Controller extends CI_Controller {
	var $layout = "default/layout/default"; //default layout
	
	/**
	 * Default constructor
	 */
	function __construct() 
	{
		parent::__construct();
		$this->load->model('product_model');
		$this->load->model('client_model') ;
		$this->categories = $this->product_model->all_categories_subcategories();
		#$this->_is_user_logged_in();
		$this->store_id = null;
		$this->storename = null;
		$this->consultant_label = 'Consultant' ;
		$this->load->helper('resize');
		
		
		$this->load->library('cart');
		
		$userData = $this->session->userdata('storeUserSession');
		#pr($userData) ;
		#pr($this->uri->segments);
		$segs = $this->uri->segments ;
		$data = $this->client_model->get_client_details( trim(@$segs[1]) );
		
		#echo '<pre>'; 
		
		if( !empty($data) && !empty($userData['store_id']) 
			&& $userData['store_id'] != $data->id)
		{
			$this->session->unset_userdata('storeUserSession');
		}

		$cartOptions = $this->cart->product_options(key($this->cart->contents()));

		if(!empty($cartOptions['storeid']) && !empty($data)
			&& $cartOptions['storeid'] != $data->id )
		{
			$this->cart->destroy();
		}
		
		/**
		 * redirection code start after login
		 */
		if(is_array($this->session->userdata('storeUserSession')))
		{
			if(count($this->session->userdata('current_url_path'))>1)
			{
				$url_path = count($this->session->userdata('current_url_path'))-1;
				$current_path_array = $this->session->userdata('current_url_path');
				$header_redirect = $current_path_array[$url_path];
				$this->session->unset_userdata('current_url_path');
				$this->output->set_header('location:' . $header_redirect);
			}
		}
		else
		{
			$current_uri = implode("/",$this->uri->segments);
			
			
			if(@$pcurrenturl_path != "" && !in_array("login", $this->uri->segments) && !in_array("register", $this->uri->segments) && !in_array("ajax", $this->uri->segments))
			{
				$this->session->set_userdata('current_url_path', array_merge((array)$this->session->userdata('current_url_path'),array(base_url().$current_uri))) ;
			}elseif(@$pcurrenturl_path == "" && (in_array("login", $this->uri->segments) || in_array("register", $this->uri->segments)) ){
				// write store home page url or consultant home page url
				
				if(in_array("login", $this->uri->segments)){
					$ksearch = 'login' ;
				}else{
					$ksearch = 'register' ;
				}

				$keyval = array_search($ksearch, $this->uri->segments);
				// consultant page url 
				if($keyval == 4){
					$url_to_go = $this->uri->segments[1].'/'.$this->uri->segments[2].'/store' ;
				}
				// store page url
				if($keyval == 3){
					$url_to_go = $this->uri->segments[1].'/store' ;
				}
				
				$this->session->set_userdata('current_url_path', array_merge((array)$this->session->userdata('current_url_path'),array(base_url().$url_to_go))) ;			
			}
		}
		/**
		 * redirection code end after login
		 */
	}

	/**
	 * Set the layout for the view
	 * 
	 * @param string $layout
	 * @param string $theme
	 */

	function _vci_layout($layout,$theme = 'default')
	{
		$layoutpath  = trim(strtolower($theme)) . '/layout/' . trim(strtolower($layout)).'.php' ;
		
		if(file_exists( APPPATH.'views/'.$layoutpath)){
			
			(!empty($layout))? $this->layout = trim(strtolower($theme)) . '/layout/' . trim(strtolower($layout)) : 'default/layout/default';	
		}else{
			
			(!empty($layout))? $this->layout = 'default/layout/' . trim(strtolower($layout)) : 'default/layout/default';	 // as store name folder does'nt exist
		}
		
	}

	/*
	function _vci_layout($layout,$theme = 'default')
	{
		(!empty($layout))? $this->layout = trim(strtolower($theme)) . '/layout/' . trim(strtolower($layout)) : 'default/layout/default';
	}
	*/

	function __is_valid_store()
	{
		$segs = $this->uri->segment_array();
		$storeurl = $_SERVER['HTTP_HOST'] ;

		if( isset( $storeurl ) && empty( $storeurl ) )
		{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		$this->load->model('client_model');
		if( !$this->client_model->is_client_existsurl(trim($storeurl) ) )
		{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		else
		{
			
			$data = $this->client_model->get_client_detailsurl( trim($storeurl) );
			
			$this->store_id = $data->id;
			$this->storename = $data->username;
			$this->store_about_us_link = isset($data->about_us_link) ? $data->about_us_link : "#";
			$this->store_opportunity_link = isset($data->opportunity_link) ? $data->opportunity_link : "#";
			
			$social_links = $this->client_model->get_client_social_links( trim($data->id) );
			
			$this->fb_link        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
			$this->twitter_link   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
			$this->pinterest_link = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
			$this->linkdin_link   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
			$this->gplus_link     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
			$this->youtube_link   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
			$this->logo_image     = isset($social_links->logo_image) ? $social_links->logo_image : "#";
			$this->consultant_label = (isset($social_links->consultant_label) && $social_links->consultant_label !="" ) ? $social_links->consultant_label : "Consultant";
		}
		#echo '<pre>';
		#print_r($this->consultant_label) ;

	}

	function __is_valid_client_store()
	{
		$segs = $this->uri->segment_array();
		
		if( isset( $segs[1] ) && empty( $segs[1] ) )
		{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
		$this->load->model('client_model');
		
		$storeurl = $_SERVER['HTTP_HOST'] ;

		$clientdetail = $this->client_model->get_client_detailsurl( trim($storeurl) );
		

		if(!empty($clientdetail)){
			
			$this->load->model('user_model');
			$response = $this->user_model->is_consultant_exists(trim($segs[1]), $clientdetail->id) ;
			

			if( !$this->user_model->is_consultant_exists(trim($segs[1]), $clientdetail->id))
			{
				echo "<h1>Invalid store URL</h1>"; die;
			}
			else
			{
				
				$data = $this->client_model->get_client_detailsurl( trim($storeurl) );
				$this->store_id = $data->id;
				$this->storename = $data->username;
				$this->store_about_us_link = $data->about_us_link;
				$this->store_opportunity_link = $data->opportunity_link;
				
				//$social_links = $this->client_model->get_client_social_links( trim($data->id) );
				$social_links = $this->client_model->get_consultant_social_links( trim($response[0]->id) );

				#pr($social_links) ;

				$this->fb_link        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
				$this->twitter_link   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
				$this->pinterest_link = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
				$this->linkdin_link   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
				$this->gplus_link     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
				$this->youtube_link   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
				$this->logo_image     = isset($social_links->logo_image) ? $social_links->logo_image : "#";

				#pr($this);
				$storelabel = $this->client_model->get_client_social_links( trim($data->id) );

				$this->consultant_label = (isset($storelabel->consultant_label) && $storelabel->consultant_label !="" ) ? $storelabel->consultant_label : "Consultant";
			}
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

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
		ini_set('display_errors',0) ;

		$user = $this->session->userdata('user');
		//print_r();
		$segs = $this->uri->segments ;
		//die;
		$s_u_info = $this->session->userdata('storeUserSession'); 
		
if( count($s_u_info) >0 )
		{
			$store_user = $s_u_info['store_id'];  // it have detail of current logged in user from which store id
			$storeuser = @$this->uri->segments[1];
			$this->load->model('common_model');
			$store = $this->common_model->get_clientdetail($storeuser);
			
			$storeid = '' ;
			$store_role = '' ;
			//$store_username = $segs[1] ; // default is for same url : Abh
			if( count($store) >0 )
			{
				$storeid = trim($store[0]['id']);
				$store_role = $store[0]['role_id'] ;
				$store_username =  $store[0]['username'] ;
			}
			
			if( $storeid!=$store_user && $store_user!=0 && $store_user!='' )
			{
				$this->session->unset_userdata('storeUserSession');
				$this->session->set_flashdata('errors', 'You are not valid user for this store, Please login in your store.');
				$this->output->set_header('location:' . base_url() .  $store_username . '/home');
			}
		}

	}

	function gettaxcode($pid){
        $this->db->select(array('tax_code'));
        $this->db->from('client_product_avataxcode');
        $this->db->where('client_product_id',$pid);
        $taxcode = $this->db->get();
        if(count($taxcode->result()) > 0)
        {
            $rs = $taxcode->result_array();
            return $rsret = $rs[0]['tax_code'] ;
        } else
        {
            return false;
	}
    }

    function prciceswithlabel($indval){
    	$this->db->from('attribute_set_field_details');
		$this->db->where('id' , $indval);
		$optlist = $this->db->get();
		$allopt = array();
		if($optlist->num_rows){
			$rsset = $optlist->result_array() ;
		}

		// pr($rsset) ;
		if(!empty($rsset)){
			return '<strong>'.$rsset[0]['option_value'].'</strong> - $'.$rsset[0]['option_price'].' ' ;
		}
    }	
}

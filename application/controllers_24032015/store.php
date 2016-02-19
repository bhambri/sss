<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:			Store extends VCI_Controller defined in libraries
*	Author: 		
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	display home page etc.
---------------------------------------------------------------
*/

class Store extends VCI_Controller {

	function __construct()
	{
		parent::__construct();
		if( $this->uri->segment(1) )
        {   
            $username =  $this->uri->segment(1);
		    $this->load->model('common_model');     
        }
		$this->_vci_layout('store_default');
		
		//$this->load->layout('store_default') ;
	}
	
	/**
	 * method index 
     * function for rendering home page
     * @param none
     */
	function index()
	{
		
		$this->__is_valid_store();
		$view_data = '';

        $storeuser = $this->uri->segments[1] ;

        $this->load->model('common_model');
       
        $store = $this->common_model->get_clientdetail($storeuser);
 
        $storeid = '' ;
        $store_role = '' ;

		if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
		
       	$this->load->model('product_model');
		
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;

        $banners = $this->common_model->get_banner($storeid,$store_role) ;
        $popularcat = $this->common_model->getpopularsubcatlist($storeid);
		
		$view_data['title'] = 'Home ' ;
		$view_data['banners'] = $banners;
		$view_data['popularcat'] = $popularcat;

		$view_data['front_blocks'] = $this->common_model->get_front_blocks($storeid) ;
		$this->_vci_view('store_home',$view_data);
	}

	/**
	 * method  consultant_home 
     * purpose function for rendering home page of consulatants own
     * @param  none
     */
	function consultant_home(){
		$this->__is_valid_client_store() ;
		$view_data = '';
        
        $storeuser = $this->uri->segments[1] ;
        $this->_vci_layout('clientstore_default');

        $this->load->model('common_model');
       	$this->load->model('news_model') ;
       	$this->load->model('user_model');

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
     	$consultantDetail = $this->user_model->is_consultant_exists(trim($this->uri->segments[2]), $storeid) ;

		//
		$banners = $this->common_model->get_clientbanner($storeid,$consultantDetail[0]->id) ;
		if(!$banners){
			$banners = $this->common_model->get_banner($storeid,$store_role) ;
		}
        
        $news_data = $this->news_model->get_consultantnews($storeid,$consultantDetail[0]->id,5,0,false) ;
		//$this->load->model('common_model');
		$view_data['title'] = 'Home ' ;
		$view_data['banners'] = $banners;
        $view_data['news_data'] = $news_data ;

		$this->_vci_view('consultant_home',$view_data);
	}

	/**
	 * method  consultant_news 
     * purpose function for rendering news page of consulatnt
     * @param  none
     */
	function consultant_news(){
		$this->__is_valid_client_store() ;
		$view_data = '';

        $storeuser = $this->uri->segments[1] ;
        $consultantuser = trim($this->uri->segments[2]) ;
        $this->_vci_layout('clientstore_default');

        $this->load->model('common_model');
       	$this->load->model('news_model') ;
       	$this->load->model('user_model');
       	$this->load->model('grouppurchase_model') ;

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
     	$consultantDetail = $this->user_model->is_consultant_exists(trim($this->uri->segments[2]), $storeid) ;

		//
        $banners = $this->common_model->get_clientbanner($storeid,$consultantDetail[0]->id) ;
		if(!$banners){
			$banners = $this->common_model->get_banner($storeid,$store_role) ;
		}
        
        //get_all_group($page, $per_page = 10,$count=false, $store_id=null, $consultantId=null )
        $view_data['title'] = 'Home ' ;
		$view_data['banners'] = $banners;
        
        $view_data['breadcrumbdata'] = array('Home /'=> base_url() .$store_username ."/".$consultantuser."/store" ,
        									'News'=>base_url() .$store_username ."/".$consultantuser."/news") ;

        $segs = $this->uri->segment_array();
        $page = ( isset( $segs[4] ) ) ? (int)$segs[4]: 0;

        	//get_consultantnews($store_id='',$consultant_id='',$per_page = 10,$page,$count=false){
        $this->load->library('pagination');
        $qstr = '';
        $per_page = 5 ;
        $getData = array('s'=>'');
        $config['uri_segment'] = 4; 
        $config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() .$store_username .'/'.$consultantuser."/news?s=".$qstr;
		$config['base_url'] = base_url() .$store_username .'/'.$consultantuser."/news";
		$config['total_rows'] = intval($this->news_model->get_consultantnews($storeid , $consultantDetail[0]->id ,$page, $per_page ,true));
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();

		
        $news_data = $this->news_model->get_consultantnews($storeid , $consultantDetail[0]->id ,$page, $per_page ,false) ;
        $view_data['news_data'] = $news_data ;
		$this->_vci_view('consultant_newslist',$view_data);
	}

	function store_news(){
		$this->__is_valid_store();
		$view_data = '';

        $storeuser = $this->uri->segments[1] ;
        #$consultantuser = trim($this->uri->segments[2]) ;
        #$this->_vci_layout('clientstore_default');

        $this->load->model('common_model');
       	$this->load->model('news_model') ;
       	$this->load->model('user_model');
       	$this->load->model('grouppurchase_model') ;

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
     	$consultantDetail = $this->user_model->is_consultant_exists(trim($this->uri->segments[2]), $storeid) ;

		//
        $banners = $this->common_model->get_banner($storeid,$store_role) ;
		if(!$banners){
			$banners = $this->common_model->get_banner($storeid,$store_role) ;
		}
        
        //get_all_group($page, $per_page = 10,$count=false, $store_id=null, $consultantId=null )
        $view_data['title'] = 'Home ' ;
		$view_data['banners'] = $banners;
        
        $view_data['breadcrumbdata'] = array('Home /'=> base_url() .$store_username."/store" ,
        									'News'=>base_url() .$store_username."/news") ;

        $segs = $this->uri->segment_array();

        $page = ( isset( $segs[3] ) ) ? (int)$segs[3]: 0;

        	//get_consultantnews($store_id='',$consultant_id='',$per_page = 10,$page,$count=false){
        $this->load->library('pagination');
        $qstr = '';
        $per_page = 5 ;
        $getData = array('s'=>'');
        $config['uri_segment'] = 3; 
        $config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() .$store_username."/news?s=".$qstr;
		$config['base_url'] = base_url() .$store_username ."/news";
		$config['total_rows'] = intval($this->news_model->get_storenews($storeid , 0 ,$page, $per_page ,true));
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();

		
        $news_data = $this->news_model->get_storenews($storeid , 0 ,$page, $per_page ,false) ;
        $view_data['news_data'] = $news_data ;
		

		$this->_vci_view('store_newslist',$view_data);
	}

	/**
	 * method  consultant_event 
     * purpose function for rendering group events page
     * @param  none
     */
	function consultant_event($page=0){
		//echo 'consultant event page';
		$this->__is_valid_client_store() ;
		$view_data = '';

        $storeuser = $this->uri->segments[1] ;
        $consultantuser = trim($this->uri->segments[2]) ;
        $this->_vci_layout('clientstore_default');

        $this->load->model('common_model');
       	$this->load->model('news_model') ;
       	$this->load->model('user_model');
       	$this->load->model('grouppurchase_model') ;

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
     	$consultantDetail = $this->user_model->is_consultant_exists(trim($this->uri->segments[2]), $storeid) ;

		//
        $banners = $this->common_model->get_clientbanner($storeid,$consultantDetail[0]->id) ;
		if(!$banners){
			$banners = $this->common_model->get_banner($storeid,$store_role) ;
		}
		
        //get_all_group($page, $per_page = 10,$count=false, $store_id=null, $consultantId=null )
        $view_data['title'] = 'Home ' ;
		$view_data['banners'] = $banners;
        
		$view_data['breadcrumbdata'] = array('Home /'=> base_url() .$store_username ."/".$consultantuser."/store" ,
        									'Group Purchase Event'=>base_url() .$store_username ."/".$consultantuser."/event") ;

        $segs = $this->uri->segment_array();
        $page = ( isset( $segs[4] ) ) ? (int)$segs[4]: 0;

        $this->load->library('pagination');
        $qstr = '';
        $per_page = 5 ;
        $getData = array('s'=>'');
        $config['uri_segment'] = 4; 
        $config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() .$store_username .'/'.$consultantuser."/event?s=".$qstr;
		$config['base_url'] = base_url() .$store_username .'/'.$consultantuser."/event";
		$config['total_rows'] = intval($this->grouppurchase_model->get_all_group($page, $per_page ,true, $storeid , $consultantDetail[0]->id ));
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();

        $event_data = $this->grouppurchase_model->get_all_group($page, $per_page ,false, $storeid , $consultantDetail[0]->id ) ;
		
        $view_data['event_data'] = $event_data ;
		$this->_vci_view('consultant_eventlist',$view_data);
	}

	/**
	 * method  event_detail 
     * purpose function for rendering group events detail page
     * @param  
     */
	function event_detail(){
		
		$this->__is_valid_client_store() ;
		$view_data = '';

        $storeuser = $this->uri->segments[1] ;
        $consultantuser = trim($this->uri->segments[2]) ;
        $this->_vci_layout('clientstore_default');

        $this->load->model('common_model');
       	#$this->load->model('news_model') ;
       	$this->load->model('user_model');
       	$this->load->model('grouppurchase_model') ;

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
     	$consultantDetail = $this->user_model->is_consultant_exists(trim($this->uri->segments[2]), $storeid) ;

		//
        $banners = $this->common_model->get_banner($storeid,$store_role) ;
        
        $view_data['title'] = 'Home ' ;
		$view_data['banners'] = $banners;
        
        $segs = $this->uri->segment_array();
        //pr($segs) ;
        $eveid = $segs[4] ;
		$view_data['breadcrumbdata'] = array('Home /'=> base_url() .$store_username ."/".$consultantuser."/store" ,
        									'Group Purchase Event'=>base_url() .$store_username ."/".$consultantuser."/event") ;

        $group_data = $this->grouppurchase_model->get_grouppurcahse_by_id($eveid) ;
		#die;
		if(@$group_data){
			if(($group_data[0]->store_id == $storeid) && ($group_data[0]->consultant_id == $consultantDetail[0]->id )){
    		     $view_data['group_data'] = $group_data ;
	    	}else{
	    		$view_data['group_data']  = array();
	    	}
		}else{
			$view_data['group_data']  = array();
		}
		$this->_vci_view('consultant_eventdetail',$view_data);
	}

	/**
	 * method  news_detail 
     * purpose function for rendering news detail page
     * @param  
     */
	function news_detail(){

		$this->__is_valid_client_store() ;
		$view_data = '';

        $storeuser = $this->uri->segments[1] ;
        $consultantuser = trim($this->uri->segments[2]) ;
        $this->_vci_layout('clientstore_default');

        $this->load->model('common_model');
       	$this->load->model('news_model') ;
       	$this->load->model('user_model');
       	#$this->load->model('grouppurchase_model') ;

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
     	$consultantDetail = $this->user_model->is_consultant_exists(trim($this->uri->segments[2]), $storeid) ;

		//
        $banners = $this->common_model->get_banner($storeid,$store_role) ;
        
        //get_all_group($page, $per_page = 10,$count=false, $store_id=null, $consultantId=null )
        $view_data['title'] = 'Home ' ;
		$view_data['banners'] = $banners;
        $view_data['breadcrumbdata'] = array('Home /'=> base_url() .$store_username ."/".$consultantuser."/store" ,
        									'News'=>base_url() .$store_username ."/".$consultantuser."/news") ;

        $segs = $this->uri->segment_array();
        //pr($segs) ;
        $newsid = $segs[4] ;

        $news_data = $this->news_model->get_news_page($newsid) ;
		#pr($news_data) ;
		
		if(@$news_data){
			if(($news_data->store_id == $storeid) && ($news_data->user_id == $consultantDetail[0]->id )){
    		     $view_data['news_data'] = $news_data ;
	    	}else{
	    		$view_data['news_data']  = array();
	    	}
		}else{
			$view_data['news_data']  = array();
		}
    	 
		$this->_vci_view('consultant_newsdetail',$view_data);
	}

	function storenews_detail(){

		$this->__is_valid_store();
		$view_data = '';

        $storeuser = $this->uri->segments[1] ;
        
        $this->_vci_layout('clientstore_default');

        $this->load->model('common_model');
       	$this->load->model('news_model') ;
       	$this->load->model('user_model');
       	#$this->load->model('grouppurchase_model') ;

        $store = $this->common_model->get_clientdetail($storeuser);
 		
 		$storeid = '' ;
        $store_role = '' ;

        if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		
        $this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
     	

		//
        $banners = $this->common_model->get_banner($storeid,$store_role) ;
        
        //get_all_group($page, $per_page = 10,$count=false, $store_id=null, $consultantId=null )
        $view_data['title'] = 'Home ' ;
		$view_data['banners'] = $banners;
        $view_data['breadcrumbdata'] = array('Home /'=> base_url() .$store_username ."/store" ,
        									'News'=>base_url() .$store_username ."/news") ;

        $segs = $this->uri->segment_array();
        //pr($segs) ;
        $newsid = $segs[3] ;

        $news_data = $this->news_model->get_news_page($newsid) ;
		#pr($news_data) ;
		
		if(@$news_data){
			$view_data['news_data'] = $news_data ;
		}else{
			$view_data['news_data']  = array();
		}
    	 
		$this->_vci_view('store_newsdetail',$view_data);
	}

	/**
	 * method  news_detail 
     * purpose function for rendering news detail page
     * @param  
     * NOTE : Currently NOT IN USE
     */
	function homesss()
	{
		$this->load->library('email');
		$this->load->library('parser');
		$smtp_settings = $this->config->item('smtp');
		$sender_from = $this->config->item('sender_from');
		$sender_name = $this->config->item('sender_name');
    	$this->email->initialize( $smtp_settings );
		$this->email->from($sender_from, $sender_name);
		$this->email->to('someone@yopmail.com');

		$data = array(
            'title' => 'My Blog Title',
            'heading' => 'My Blog Heading'
            );

		$body = $this->parser->parse('default/store/emails/client-store-link', $data, true);
		//$this->email->cc('another@another-example.com');
		$this->email->subject('Email Test');
		$this->email->message( $body );							

		if ( ! $this->email->send())
		{
		    echo $this->email->print_debugger();
		}
		else
		{
			echo "Mail sent";
		}

	}

	/**
	 * method  about 
     * purpose function for rendering about us page
     * @param  
     * NOTE : Currently NOT IN USE, as this is for now link of third party sites only, 
     */
	function about()
	{	
		$this->__is_valid_store();
		$storeuser = $this->uri->segments[1];
		$this->load->model('common_model');
		$store = $this->common_model->get_clientdetail($storeuser);
		$view_data = '';	
		$this->_vci_view('store/about',$view_data);
	}
	
	/**
	 * method  contact 
     * purpose function for contact us page
     * @param  none
     */
	function contact()
	{
		$this->__is_valid_store();
		$storeuser = $this->uri->segments[1];
		$this->load->model('common_model');
		$store = $this->common_model->get_clientdetail($storeuser);
		$view_data = '';
		$this->_vci_view('store/contact',$view_data);
	}


	/**
	 * method  clientproducts 
     * purpose for listing client products
     * @param  pageno
     */

	function clientproducts($page = 0 ){

		$this->__is_valid_client_store() ;
		// new part added
		$storeuser = $this->uri->segments[1] ;
		$consultantuser = trim($this->uri->segments[2]) ;
		//echo 'cons user'.$consultantuser ; die;

        $this->load->model('common_model');
        $this->_vci_layout('clientstore_default');

        $store = $this->common_model->get_clientdetail($storeuser);
        
        $per_page = $this->session->userdata('per_page') ; 
        $sort_by = $this->session->userdata('sort_by') ; 

        if(!$per_page){
        	$per_page = 12 ;
        }

        if(!$sort_by){
        	$sort_by = 'product_title:asc' ;
        }

        $storeid = '' ;
        $store_role = '' ;
        $store_username = '' ;
		if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		#die;
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
		// new part added
		$segs = $this->uri->segment_array();

		$page = ( isset( $segs[4] ) ) ? (int)$segs[4]: 0;	

		//Set the layout and initialize the view variable; Set view caption
		$view_data = array();
		//Load model and pagination library
		$this->load->library('pagination');
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s') ;
		}
		#pr($segs);
		//Set pagination configs
		//echo 'Sot by option'.$sort_by ;

		$getData = array('s'=>$qstr,'cat_id'=>@$category_id);
		$config['uri_segment'] = 4;  //storeD/conD/store/24?s= 24 page no
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() .$store_username ."/".$consultantuser."/store?s=".$qstr;
		//$config['uri_segment'] = 4 ; 
		$config['base_url'] = base_url() .$store_username ."/".$consultantuser."/store";
		$config['total_rows'] = intval($this->product_model->get_all($page,$per_page,true,$sort_by,@$category_id));
		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		
		//Fetch all pages from database
		$view_data['breadcrumbdata'] = array('Home /'=> base_url() .$store_username ."/".$consultantuser."/store" ) ;

		$view_data['products'] = $this->product_model->get_all($page, $per_page,false,$sort_by,@$category_id);
		$view_data['popularcat'] = $popularcat ;

		$this->_vci_view('store/clientproducts',$view_data);
	}

	/**
	 * method  search_consultantproducts 
     * purpose for searching consultant/client products
     * @param  page
     */

	function search_consultantproducts($page = 0 ){

		$this->__is_valid_client_store() ;
		// new part added
		$storeuser = $this->uri->segments[1] ;
		$consultantuser = trim($this->uri->segments[2]) ;
		//echo 'cons user'.$consultantuser ; die;

        $this->load->model('common_model');
        $this->_vci_layout('clientstore_default');

        $store = $this->common_model->get_clientdetail($storeuser);
        
        $per_page = $this->session->userdata('per_page') ; 
        $sort_by = $this->session->userdata('sort_by') ; 

        if(!$per_page){
        	$per_page = 12 ;
        }

        if(!$sort_by){
        	$sort_by = 'product_title:asc' ;
        }

        $storeid = '' ;
        $store_role = '' ;
        $store_username = '' ;
		if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		#die;
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
		// new part added
		$segs = $this->uri->segment_array();

		$page = ( isset( $segs[4] ) ) ? (int)$segs[4]: 0;	

		//Set the layout and initialize the view variable; Set view caption
		$view_data = array();
		//Load model and pagination library
		$this->load->library('pagination');
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s') ;
		}

		//Set pagination configs

		$getData = array('s'=>$qstr,'cat_id'=>@$category_id);
		$config['uri_segment'] = 4;  //storeD/conD/store/24?s= 24 page no
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() .$store_username ."/".$consultantuser."/store/search?s=".$qstr;
		//$config['uri_segment'] = 4 ; 
		$config['base_url'] = base_url() .$store_username ."/".$consultantuser."/store/search";
		$config['total_rows'] = intval($this->product_model->get_all($page,$per_page,true,$sort_by,@$category_id));
		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		
		//Fetch all pages from database
		$view_data['breadcrumbdata'] = array('Home /'=> base_url() .$store_username ."/".$consultantuser."/store" ) ;

		$view_data['products'] = $this->product_model->get_all($page, $per_page,false,$sort_by,@$category_id);
		$view_data['popularcat'] = $popularcat ;

		$this->_vci_view('store/clientproducts',$view_data);
	}

	/**
	 * method  products 
     * purpose for listing store products
     * @param  pageno
     */
	function products( $page = 0 )
	{	
		
		$this->__is_valid_store();
		// new part added
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
       
        $store = $this->common_model->get_clientdetail($storeuser);
        
        $per_page = $this->session->userdata('per_page') ; 
        $sort_by = $this->session->userdata('sort_by') ; 

        if(!$per_page){
        	$per_page = 12 ;
        }

        if(!$sort_by){
        	$sort_by = 'product_title:asc' ;
        }

        $storeid = '' ;
        $store_role = '' ;
        $store_username = '' ;
		if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		#die;
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
		// new part added
		$segs = $this->uri->segment_array();

		$page = ( isset( $segs[4] ) ) ? (int)$segs[4]: 0;	

		//Set the layout and initialize the view variable; Set view caption
		$view_data = array();
		//Load model and pagination library
		$this->load->library('pagination');
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s') ;
		}
		
		//Set pagination configs
		$getData = array('s'=>$qstr,'cat_id'=>@$category_id);
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['uri_segment'] = 4;
		$config['first_url'] = base_url() .$store_username ."/store/product?s=".$qstr;
		$config['base_url'] = base_url() .$store_username ."/store/product";
		$config['total_rows'] = intval($this->product_model->get_all($page,$per_page,true,$sort_by,@$category_id));
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		
		//Fetch all pages from database
		$view_data['breadcrumbdata'] = array('Home /'=> base_url() .$store_username ."/store/product" ) ;

		$view_data['products'] = $this->product_model->get_all($page, $per_page,false,$sort_by,@$category_id);
		$view_data['popularcat'] = $popularcat ;
		$this->_vci_view('store/products',$view_data);
	}

	function search_products( $page = 0 )
	{	
		
		
		$this->__is_valid_store();
		// new part added
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
       
        $store = $this->common_model->get_clientdetail($storeuser);
        
        $per_page = $this->session->userdata('per_page') ; 
        $sort_by = $this->session->userdata('sort_by') ; 

        if(!$per_page){
        	$per_page = 12 ;
        }

        if(!$sort_by){
        	$sort_by = 'product_title:asc' ;
        }

        $storeid = '' ;
        $store_role = '' ;
        $store_username = '' ;
		if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		#die;
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
		// new part added
		$segs = $this->uri->segment_array();

		$page = ( isset( $segs[3] ) ) ? (int)$segs[3]: 0;	

		//Set the layout and initialize the view variable; Set view caption
		$view_data = array();
		//Load model and pagination library
		$this->load->library('pagination');
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s') ;
		}

		//Set pagination configs
		$getData = array('s'=>$qstr,'cat_id'=>@$category_id);
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['uri_segment'] = 4;
		$config['first_url'] = base_url() .$store_username ."/store/search?s=".$qstr;
		$config['base_url'] = base_url() .$store_username ."/store/search";
		$config['total_rows'] = intval($this->product_model->get_all($page,$per_page,true,$sort_by,@$category_id));
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		
		//Fetch all pages from database
		$view_data['breadcrumbdata'] = array('Home /'=> base_url() .$store_username ."/store" ) ;

		$view_data['products'] = $this->product_model->get_all($page, $per_page,false,$sort_by,@$category_id);
		$view_data['popularcat'] = $popularcat ;
		$this->_vci_view('store/products',$view_data);
	}

	/**
	 * method  catproducts 
     * purpose for listing category  products
     * @param  pageno
     */
	function catproducts(){
		
		$this->__is_valid_store();
		// new part added
		$storeuser = $this->uri->segments[1] ;
		$category_id = $this->uri->segments[4] ;

        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
        
        $per_page = $this->session->userdata('per_page') ; 
        $sort_by = $this->session->userdata('sort_by') ; 

        if(!$per_page){
        	$per_page = 12 ;
        }

        if(!$sort_by){
        	$sort_by = 'product_title:asc' ;
        }

        $storeid = '' ;
        $store_role = '' ;
        $store_username = '' ;
		if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		
		$segs = $this->uri->segment_array();
		
		$page = ( isset( $segs[6] ) ) ? (int)$segs[6]: 0;	
		$subcategory_id = ( isset( $segs[5] ) ) ? (int)$segs[5]: 0 ;
		
		//Set the layout and initialize the view variable; Set view caption
		$view_data = array();
		//Load model and pagination library
		$this->load->library('pagination');
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s') ;
		}
		//Set pagination configs
		$getData = array('s'=>$qstr);
		

		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['uri_segment'] = 6;  //storeD/store/cat_id/108?s= 
		$config['first_url'] = base_url() .$store_username ."/store/cat_id/$segs[4]/$segs[5]?s=".$qstr;
		$config['base_url'] = base_url() .$store_username ."/store/cat_id/$segs[4]/$segs[5]";
		$config['total_rows'] = intval($this->product_model->get_all($page,$per_page,true,$sort_by,$category_id,$subcategory_id));
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		

		$view_data['pagination'] = $this->pagination->create_links();
		

		$subcategoryDetail = $this->product_model->getsubcategory_detail($segs[4],$segs[5]) ;
		$categoryDetail = $this->product_model->getcategory_detail($segs[4]) ;
		$view_data['category'] = $categoryDetail[0]->name ;

		$view_data['subcategory'] = $subcategoryDetail[0]->name ;
		//Fetch all pages from database
		$view_data['products'] = $this->product_model->get_all($page, $per_page,false,$sort_by,$category_id,$subcategory_id);
		
		$view_data['breadcrumbdata'] = array() ;

		if((@$categoryDetail[0]->name !='') && ($subcategoryDetail[0]->name !='' )){
			$view_data['breadcrumbdata'] = array(
							'Home /'=> base_url() .$store_username ."/store",
							 $categoryDetail[0]->name.'::'.$subcategoryDetail[0]->name =>base_url() .$store_username ."/store/cat_id/".$segs[4]."/".$segs[5]
							);
		}
        

		$this->_vci_view('store/products',$view_data);
	}
    

	/**
	 * method  clientcatproducts 
     * purpose for listing client store products
     * @param  pageno
     */

    function clientcatproducts(){
		$this->__is_valid_client_store() ;
		// new part added
		$storeuser = $this->uri->segments[1] ;

		$category_id = $this->uri->segments[5] ;

		#pr($this->uri->segments) ;
 		$this->_vci_layout('clientstore_default');

        $this->load->model('common_model');
       
        $store = $this->common_model->get_clientdetail($storeuser);
        
        $per_page = $this->session->userdata('per_page') ; 
        $sort_by = $this->session->userdata('sort_by') ; 

        if(!$per_page){
        	$per_page = 12 ;
        }

        if(!$sort_by){
        	$sort_by = 'product_title:asc' ;
        }

        $storeid = '' ;
        $store_role = '' ;
        $store_username = '' ;
		if( count($store) >0 ){
			$storeid = $store[0]['id'] ;
			$store_role = $store[0]['role_id'] ;
			$store_username =  $store[0]['username'] ;
		}else{
			echo "<h1>Invalid store URL</h1>"; die;
		}

		#die;
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		
		// new part added
		$segs = $this->uri->segment_array();
		
		$page = ( isset( $segs[7] ) ) ? (int)$segs[7]: 0;	
		$subcategory_id = ( isset( $segs[6] ) ) ? (int)$segs[6]: 0 ;
		
		//Set the layout and initialize the view variable; Set view caption
		$view_data = array();
		//Load model and pagination library
		$this->load->library('pagination');
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s') ;
		}
		//Set pagination configs
		$getData = array('s'=>$qstr);
		
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['uri_segment'] = 7;  //storeD/store/cat_id/108?s= 
		$config['first_url'] = base_url() .$store_username."/".$segs[2]."/store/cat_id/$segs[5]/$segs[6]?s=".$qstr;
		$config['base_url'] = base_url() .$store_username ."/".$segs[2]."/store/cat_id/$segs[5]/$segs[6]";
		$config['total_rows'] = intval($this->product_model->get_all($page,$per_page,true,$sort_by,$category_id,$subcategory_id));
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		
		$view_data['pagination'] = $this->pagination->create_links();
		
		$subcategoryDetail = $this->product_model->getsubcategory_detail($segs[5],$segs[6]) ;
		$categoryDetail = $this->product_model->getcategory_detail($segs[5]) ;
		$view_data['category'] = $categoryDetail[0]->name ;

		$view_data['subcategory'] = $subcategoryDetail[0]->name ;
		//Fetch all pages from database
		$view_data['products'] = $this->product_model->get_all($page, $per_page,false,$sort_by,$category_id,$subcategory_id);
		
		$view_data['breadcrumbdata'] = array() ;

		if((@$categoryDetail[0]->name !='') && ($subcategoryDetail[0]->name !='' )){
			$view_data['breadcrumbdata'] = array(
							'Home /'=> base_url() .$store_username."/".$segs[2]."/store",
							 $categoryDetail[0]->name.'::'.$subcategoryDetail[0]->name =>base_url() .$store_username ."/".$segs[2]."/store/cat_id/".$segs[5]."/".$segs[6]
							);
		}
        
		$this->_vci_view('store/clientproducts',$view_data);
	}

	/**
	 * method  productDetail 
     * purpose for product detail page
     * @param  pageno
     */    
	function productDetail( $page = 0 )
	{
		error_reporting(0);
		$product_id = null;
		
		$this->__is_valid_store();

		/* for store active category */
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
		$storeid = $store[0]['id'] ;
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
		// for store active category

		$segs = $this->uri->segment_array();
		if( isset($segs[4]) && is_numeric( $segs[4] ) )
		{
		 $product_id = 	$segs[4];
		}
		$view_data['product_detail'] = $this->product_model->findWhere('client_product', array( 'status' => 1, 'store_id' => $this->store_id, 'id' => $product_id ), false );
		
		$view_data['popularcat'] = $popularcat ;
		
		$this->_vci_view('store/product_detail',$view_data);

	}

	/**
	 * method  clientproductDetail 
     * purpose for product detail page of client
     * @param  pageno
     */
	function clientproductDetail( $page = 0 )
	{
		error_reporting(0);
		$product_id = null;
		$this->__is_valid_client_store() ;
		$segs = $this->uri->segment_array();
		$this->_vci_layout('clientstore_default');
		/* for store active category */
		$storeuser = $this->uri->segments[1] ;
        $this->load->model('common_model');
        $store = $this->common_model->get_clientdetail($storeuser);
		$storeid = $store[0]['id'] ;
		$this->categories = $this->product_model->get_all_category_subcategoryof_store($storeid) ;
		$popularcat = $this->common_model->getpopularsubcatlist($storeid) ;
		// for store active category

		if( isset($segs[5]) && is_numeric( $segs[5] ) )
		{
			$product_id = 	$segs[5];
		}
		$view_data['product_detail'] = $this->product_model->findWhere('client_product', array( 'status' => 1, 'store_id' => $this->store_id, 'id' => $product_id ), false );
		$view_data['popularcat'] = $popularcat ;
		#echo "<pre>";print_r( $view_data['product_detail'] ); die;
		$this->_vci_view('store/clientproduct_detail',$view_data);
	}

	/**
	 * method  addEmailHeaderFooter 
     * purpose A common function to add email header footer
     * @param  pageno
     */
	function addEmailHeaderFooter( $body = '', $title = 'Email' )
	{
		$mailBody = '<!DOCTYPE html><html><head><title>' . $title . '</title></head><body>';
		$mailBody .= $body;
		$mailBody .= '</body></html>';
		return $mailBody;
	}
}

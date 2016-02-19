<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:			Content extends VCI_Controller defined in libraries
*	Author: 		
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	display static content page etc.
---------------------------------------------------------------
*/

class Content extends VCI_Controller {

	function __construct()
	{
		parent::__construct();

	}

	/**
	 * method view_content
     * function for rendering static pages
     * displaying at front area that are admin manageble
     * @param none
    */
	function view_content($cid = ''){
		$this->load->model('content_model') ;
		$this->load->model('common_model') ;
		$this->load->helper('url');
		$social_links = $this->common_model->get_marketplace_social_links( 1,1 ); // for super admin
		if( $cid == 'how-it-works')
		{
			
			$content1 = $this->content_model->get_content_page(16);
			$content2 = $this->content_model->get_content_page(15);
			$content3 = $this->content_model->get_content_page(14);

			$view_data['title1'] = $content1->page_title;
			$view_data['content1'] = $content1->page_content;
			$view_data['title2'] = $content2->page_title;
			$view_data['content2'] = $content2->page_content;
			$view_data['title3'] = $content3->page_title;
			$view_data['content3'] = $content3->page_content;

			$view_data['fb_link']        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
			$view_data['twitter_link']   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
			$view_data['pinterest_link'] = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
			$view_data['linkdin_link']   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
			$view_data['gplus_link']     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
			$view_data['youtube_link']   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";

			$this->_vci_view('view_how_it_works', $view_data );
		}
		else
		{

			$content = $this->content_model->get_content_page($cid);
			if($content){
				$view_data['title'] = $content->page_title ;
				$view_data['content'] = $content ;
			}else{
				$view_data['title'] = 'Wrong page url encountered' ;
				$view_data['content'] = $content ;
			}
			$view_data['fb_link']        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
			$view_data['twitter_link']   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
			$view_data['pinterest_link'] = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
			$view_data['linkdin_link']   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
			$view_data['gplus_link']     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
			$view_data['youtube_link']   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
			
			$this->_vci_view('view_content',$view_data);
		}
	}
	
	/**
	 * method view_tnc
     * function for rendering terms and coondition pages
     * displaying at front area that are admin manageble
     * @param none
    */
	function view_tnc()
	{
		// function for all store tnc pages
		$this->_vci_layout('store_default');
		$this->__is_valid_store();
		$view_data = '';
		
		$storeuser = $this->uri->segments[1] ;
		$consultantuser = trim($this->uri->segments[2]);
	//	$this->_vci_layout('clientstore_default');
		
		$this->load->model('common_model');
		$this->load->model('client_model');
		$this->load->model('news_model') ;
		$this->load->model('user_model');
		$this->load->model('grouppurchase_model') ;
		 
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
		
		$view_data['breadcrumbdata'] = array('Home /'=> base_url() .$storeuser ."/store" ,
				'Terms of use'=>'') ;
		
		$store_pages_get = $this->client_model->get_client_pages( trim($storeid) );
			
	/*	echo "<pre>";
		print_r($store_pages_get);
		echo "</pre>";*/
		
		#pr($store_pages_get);

		$view_data['page_title']   = isset($store_pages_get->page_title)?$store_pages_get->page_title:'';
		$view_data['page_content'] = isset($store_pages_get->page_content)?$store_pages_get->page_content:'';
		
		$this->_vci_view('store/tc',$view_data);
	}
	
	/**
	 * method view_ctnc
     * function for rendering terms and coondition pages for consultant section
     * displaying at front area that are admin manageble
     * @param none
    */
	function view_ctnc()
	{
		// function for all store consultant term and conditions
		$this->__is_valid_client_store() ;
		$view_data = '';
		
		$storeuser = $this->uri->segments[1];
		$consultantuser = trim($this->uri->segments[2]);
		$this->_vci_layout('clientstore_default');
		
		$this->load->model('common_model');
		$this->load->model('client_model');
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
		
		$view_data['breadcrumbdata'] = array('Home /'=> base_url() .$storeuser ."/".$consultantuser."/store" ,
				'Terms of use'=>'') ;
		
		$store_pages_get = $this->client_model->get_client_pages( trim($storeid) );
			
	/*	echo "<pre>";
		print_r($store_pages_get);
		echo "</pre>";
	*/	
		$view_data['page_title']   = isset($store_pages_get->page_title)?$store_pages_get->page_title:'';
		$view_data['page_content'] = isset($store_pages_get->page_content)?$store_pages_get->page_content:'';
		
		$this->_vci_view('store/tc',$view_data);
	}

}

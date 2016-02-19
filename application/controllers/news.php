<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:			News extends VCI_Controller defined in libraries
*	Author: 		
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	display list details etc. 
---------------------------------------------------------------
*/

class News extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
		$this->load->model('common_model');
	}

	/*
	*	Method: index
	*	@param integer $page 
	*	Description: to list all news item from database
	*/
	function index( $page=0 ){
		$view_data['title'] = ' News :' ;
		
		$this->load->library('pagination');
		$this->load->helper('url');
		//Set pagination configs
		$config['base_url'] = base_url() . "news/index";
		$config['total_rows'] = intval($this->news_model->get_newscount($page,'',true));
		$config['per_page'] = 15;
		
		$config['first_link'] = 'First';
        $config['num_links'] = 2;
        
        $config['last_link'] = 'Last';

		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		
		//Fetch all pages from database
		$view_data['content'] = $this->news_model->get_news($page, $config['per_page'],'');
		
		$this->_vci_view('news_data', $view_data);
	}

	
	/*
	*	Method: view_news
	*	@param id integer
	*	@param title string
	*	Description: display news detail page
	*/

	function view(){
		$view_data = '';
		$segs = $this->uri->segment_array();
		if( isset( $segs[3] ) && !empty( $segs[3] ) )
		{
			$data = $this->common_model->view_news( $segs[3] );
			//pr($data) ;
			if(($data['store_id'] == 0) && ($data['user_id'] == 0) ){
				$social_links = $this->common_model->get_marketplace_social_links( 1,1 ); // for super admin
				$view_data['fb_link']        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
				$view_data['twitter_link']   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
				$view_data['pinterest_link'] = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
				$view_data['linkdin_link']   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
				$view_data['gplus_link']     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
				$view_data['youtube_link']   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
			}
			$view_data['data'] = $data;
		}
		else
		{

		}
		
		$this->_vci_view('news_detail',$view_data);
	}
	
}
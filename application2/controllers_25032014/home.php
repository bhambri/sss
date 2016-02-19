<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:			Home extends VCI_Controller defined in libraries
*	Author: 		
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	display home page etc.
---------------------------------------------------------------
*/

class Home extends VCI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * method index 
     * function for rendering home page
     * @param none
     */
	function index()
	{
		$this->load->model('common_model');
		$view_data['title'] = 'Home ';
	//	echo ; die;
		$view_data['latest_news'] = $this->common_model->get_news();
		$view_data['banners'] = $this->common_model->findWhere('banners', array( 'status' => 1, 'store_id' => 0 ) );
		$view_data['topStore'] = $this->common_model->get_top_store();
		
		$social_links = $this->common_model->get_marketplace_social_links( 1,1 );
		#pr($social_links) ;	

		$view_data['fb_link']        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
		$view_data['twitter_link']   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
		$view_data['pinterest_link'] = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
		$view_data['linkdin_link']   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
		$view_data['gplus_link']     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
		$view_data['youtube_link']   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
		
		$this->_vci_view('index', $view_data);
	}
}
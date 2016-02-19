<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:			Contactus extends VCI_Controller defined in libraries
*	Author: 		
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	display list details etc. 
---------------------------------------------------------------
*/

class Contactus extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
        $this->load->model('content_model');
        
	}

	/**
     * method  index
     * description function for adding contact us records
     * submitted from front area
     * @param none
     */
    function index()
    {
        $this->load->model( 'contact_model' );
        $this->load->model('common_model') ;

        $view_data[ 'title' ] = 'Contact us :';
        $view_data[ 'name' ] = '';
        $view_data[ 'email' ] = '';
        $view_data[ 'comments' ] = '';

        $social_links = $this->common_model->get_marketplace_social_links( 1,1 );
        
        $view_data['fb_link']        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
        $view_data['twitter_link']   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
        $view_data['pinterest_link'] = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
        $view_data['linkdin_link']   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
        $view_data['gplus_link']     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
        $view_data['youtube_link']   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
        
        if($view_data['fb_link']!="#" && strpos($view_data['fb_link'], 'http') === false)
        {
        	$view_data['fb_link'] = "http://".$view_data['fb_link'];
        }
        if($view_data['linkdin_link']!="#" && strpos($view_data['linkdin_link'], 'http') === false)
        {
        	$view_data['linkdin_link'] = "http://".$view_data['linkdin_link'];
        }
        if($view_data['twitter_link']!="#" && strpos($view_data['twitter_link'], 'http') === false)
        {
        	$view_data['twitter_link'] = "http://".$view_data['twitter_link'];
        }
        if($view_data['gplus_link']!="#" && strpos($view_data['gplus_link'], 'http') === false)
        {
        	$view_data['gplus_link'] = "http://".$view_data['gplus_link'];
        }
        if($view_data['youtube_link']!="#" && strpos($view_data['youtube_link'], 'http') === false)
        {
        	$view_data['youtube_link'] = "http://".$view_data['youtube_link'];
        }
        if($view_data['pinterest_link']!="#" && strpos($view_data['pinterest_link'], 'http') === false)
        {
        	$view_data['pinterest_link'] = "http://".$view_data['pinterest_link'];
        }
        
        $view_data['address'] = $this->content_model->get_content_page(13);
        $view_data['ngooglemap'] = $this->content_model->get_content_page(23);
        $view_data['googlemap'] = $view_data['ngooglemap']->page_content ;
        
        
        // rule name conatctus
        if ( $this->input->post( 'formSubmitted' ) > 0 )
        {

            if ( $this->form_validation->run('conatctus') )
            {
            	$data = array(
			'name' => htmlspecialchars($this->input->post('name')),
			'comments' => htmlspecialchars($this->input->post('comments')),
			'email' => htmlspecialchars($this->input->post('email')),
			'phone' => $this->input->post('phone'), 			
			);
               // echo "Its working";
                if ( $this->contact_model->add_contact( $data ) )
                {
                    //Send Email Below
                    $this->load->library('email');
	                $this->load->library('parser');
	                $smtp_settings = $this->config->item('smtp');
	                $sender_from = $this->config->item('sender_from');
	                $sender_name = $this->config->item('sender_name');
                    $this->email->initialize( $smtp_settings );
	                $this->email->from( $sender_from, $sender_name );
	                $this->email->to( htmlspecialchars( $this->input->post('email') ) );


	                $ndata = array(
                        'title'          => 'Contact us form submitted',
                        'CONTENT'        => 'Thanks for contacting Simple Sales Systems. We will contact you soon.',
                        'USER'           => htmlspecialchars( ucwords( $this->input->post('name') ) ),
	                	'fb_link'        => $view_data['fb_link'],
	                	'twitter_link'   => $view_data['twitter_link'],
	                	'pinterest_link' => $view_data['pinterest_link'],
	                	'linkdin_link'   => $view_data['linkdin_link'],
	                	'gplus_link'     => $view_data['gplus_link'],
	                	'youtube_link'   => $view_data['youtube_link'],
						'email_logo'       => 'application/views/default/images/logo.png',
	                	'facebook_image'   => 'application/views/default/images/fb.png',
	                	'linkdin_image'    => 'application/views/default/images/in.png',
	                	'twitter_image'    => 'application/views/default/images/twitter.png',
	                	'googleplus_image' => 'application/views/default/images/googleplus.png',
	                	'pinterest_image'  => 'application/views/default/images/p.png',
	                	'youtube_image'    => 'application/views/default/images/youtb.png',
	                	'base_url'         => base_url(),
	                	'company_name'     => 'simplesalessystem.com'
                    );

	                $body = $this->parser->parse('default/store/emails/contact_us', $ndata, true);
	                
	                //$this->email->cc('another@another-example.com');
	                $this->email->subject('Thanks for Contact us - Simple Sales Systems');
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
                                'title'    =>  'Contact us form submitted',
                                'CONTENT'  =>  'An user contacted from contact form - Simple Sales Systems. Please find the details below',
                                'USER'     =>  htmlspecialchars( ucwords( $this->input->post('name') ) ),
                                'EMAIL'    =>  htmlspecialchars( $this->input->post('email') ),
                                'PHONE'    =>  htmlspecialchars( $this->input->post('phone') ),
                                'COMMENTS' =>  htmlspecialchars( ucfirst( $this->input->post('comments') ) ),
	                        	'fb_link'        => $view_data['fb_link'],
	                        	'twitter_link'   => $view_data['twitter_link'],
	                        	'pinterest_link' => $view_data['pinterest_link'],
	                        	'linkdin_link'   => $view_data['linkdin_link'],
	                        	'gplus_link'     => $view_data['gplus_link'],
	                        	'youtube_link'   => $view_data['youtube_link'],
	                        	'email_logo'       => 'application/views/default/images/logo.png',
	                        	'facebook_image'   => 'application/views/default/images/fb.png',
	                        	'linkdin_image'    => 'application/views/default/images/in.png',
	                        	'twitter_image'    => 'application/views/default/images/twitter.png',
	                        	'googleplus_image' => 'application/views/default/images/googleplus.png',
	                        	'pinterest_image'  => 'application/views/default/images/p.png',
	                        	'youtube_image'    => 'application/views/default/images/youtb.png',
	                        	'base_url'         => base_url(),
	                        	'company_name'     => 'simplesalessystem.com'
                            );

	                        $body2 = $this->parser->parse('default/store/emails/notify_admin', $data2, true);
	                        
	                        $this->email->subject('Contact us form submitted');
	                        $this->email->message( $body2 );	
	                        $this->email->send();
	                    //Mail to admin ends
		                //echo "Mail sent";
	                }
                    
                    //Send Email Ends
                    
                    //$this->notify_user();
                    $this->session->set_flashdata( 'success', 'Thank you for contacting with us, we will contact you soon.' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
                else
                {
                    $view_data = $this->input->post();

                    $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                    //redirect($_SERVER['HTTP_REFERER']) ;
                }
            }
            else
            {
                $view_data = $this->input->post();

                $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                //redirect($_SERVER['HTTP_REFERER']) ;
            }
        }
    /*    $social_links = $this->common_model->get_marketplace_social_links( 1,1 );

        $view_data['fb_link']        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
        $view_data['twitter_link']   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
        $view_data['pinterest_link'] = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
        $view_data['linkdin_link']   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
        $view_data['gplus_link']     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
        $view_data['youtube_link']   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
        
        $view_data['address'] = $this->content_model->get_content_page(13);
        $view_data['ngooglemap'] = $this->content_model->get_content_page(23);
        $view_data['googlemap'] = $view_data['ngooglemap']->page_content ;
      */  
        
    //    echo "<pre>";
    //    print_r($view_data['googlemap']);
    //    die;
        
        $this->_vci_view( 'contentus', $view_data );
    }


    /**
     * method  client
     * description function for adding contact request from store pages
     * submitted from front area
     * @param none
     */
    function client()
    {	
        $this->load->model('common_model') ;
        $this->load->model('contact_model') ;
        $this->__is_valid_store();
    	$this->_vci_layout('store_default');
        $this->load->model('client_model');
        
        $popularcat = $this->common_model->getpopularsubcatlist($this->store_id) ;

        
        $social_links = $this->common_model->get_marketplace_social_links( 2,$this->store_id );
        
        $view_data['fb_link']        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
        $view_data['twitter_link']   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
        $view_data['pinterest_link'] = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
        $view_data['linkdin_link']   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
        $view_data['gplus_link']     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
        $view_data['youtube_link']   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
        $view_data['email_logo']     = isset($social_links->logo_image) ? $social_links->logo_image : '';
        
        if($view_data['fb_link']!="#" && strpos($view_data['fb_link'], 'http') === false)
        {
        	$view_data['fb_link'] = "http://".$view_data['fb_link'];
        }
        if($view_data['linkdin_link']!="#" && strpos($view_data['linkdin_link'], 'http') === false)
        {
        	$view_data['linkdin_link'] = "http://".$view_data['linkdin_link'];
        }
        if($view_data['twitter_link']!="#" && strpos($view_data['twitter_link'], 'http') === false)
        {
        	$view_data['twitter_link'] = "http://".$view_data['twitter_link'];
        }
        if($view_data['gplus_link']!="#" && strpos($view_data['gplus_link'], 'http') === false)
        {
        	$view_data['gplus_link'] = "http://".$view_data['gplus_link'];
        }
        if($view_data['youtube_link']!="#" && strpos($view_data['youtube_link'], 'http') === false)
        {
        	$view_data['youtube_link'] = "http://".$view_data['youtube_link'];
        }
        if($view_data['pinterest_link']!="#" && strpos($view_data['pinterest_link'], 'http') === false)
        {
        	$view_data['pinterest_link'] = "http://".$view_data['pinterest_link'];
        }
        
        
        
        $view_data[ 'title' ] = 'Contact us :';
        $view_data[ 'name' ] = '';
        $view_data[ 'email' ] = '';
        $view_data[ 'comments' ] = '';
        $view_data['popularcat'] = $popularcat ;
        //categories section
        #$storeuser = $this->uri->segments[1] ;

        #$store = $this->common_model->get_clientdetail($storeuser);
        $storeurl = $_SERVER['HTTP_HOST'] ;
        $store = $this->common_model->get_clientdetailurl($storeurl);

        $segs = $this->uri->segment_array();
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
        // store categories ends here
        
        // rule name conatctus
        $view_data['breadcrumbdata'] = array('Home /'=> base_url() ."store" ,
                'Contact'=>'') ;

        $store_email = '';
        $sender_name = '' ;
        $sender_from = '';
        if( @$this->store_id > 0 ){
            
            $storedata = $this->common_model->get_clientdetail('',$this->store_id);
            //pr($storedata) ;
            //die;
            if(!empty($storedata)){
                $store_email = $storedata[0]['email'];
                $sender_from = $store_email;
                $sender_name = $storedata[0]['username'];
                $view_data['company'] = $storedata[0]['company'];
                $view_data['address'] = $storedata[0]['address'];
                $view_data['state_code'] = $storedata[0]['state_code'];
                $view_data['city'] = $storedata[0]['city'];
                $view_data['zip'] = $storedata[0]['zip'];
                $view_data['phone'] = $storedata[0]['phone'];
                $view_data['fax'] = $storedata[0]['fax'];
                $view_data['sale_support_email'] = $storedata[0]['sale_support_email'];
                $view_data['partner_support_email'] = $storedata[0]['partner_support_email'];
                $view_data['technical_support_email'] = $storedata[0]['technical_support_email'];
           //     $view_data['about_us_link'] = $storedata[0]['about_us_link'];
           //     $view_data['opportunity_link'] = $storedata[0]['opportunity_link'];
            }
            
        }
        
        if ( $this->input->post( 'formSubmitted' ) > 0 )
        {

            if ( $this->form_validation->run('conatctus') )
            {
            	$data = array(
            'store_id' => $this->store_id,		
			'name' => htmlspecialchars($this->input->post('name')),
			'comments' => htmlspecialchars($this->input->post('comments')),
			'email' => htmlspecialchars($this->input->post('email')),
			'phone' => $this->input->post('phone'), 
			);
               // echo "Its working";
                if ( $this->contact_model->add_contact( $data ) )
                {                    
                    //Send Email Below
                    $this->load->library('email');
	                $this->load->library('parser');
	                $smtp_settings = $this->config->item('smtp');
                    
               /*     if(!$store_email){
                       $sender_from = $this->config->item('sender_from'); 
                       $sender_name = $this->config->item('sender_name');
                    }*/
	                
                    $this->email->initialize( $smtp_settings );
	                $this->email->from( $sender_from, $sender_name );
	                $this->email->to( htmlspecialchars( $this->input->post('email') ) );


	                $ndata = array(
                        'title' => 'Contact us form submitted',
                        'CONTENT' => 'Thanks for contacting us. We will contact you soon.',
                        'USER'=> htmlspecialchars( ucwords( $this->input->post('name') ) ),
	                	'fb_link'        => $view_data['fb_link'],
	                	'twitter_link'   => $view_data['twitter_link'],
	                	'pinterest_link' => $view_data['pinterest_link'],
	                	'linkdin_link'   => $view_data['linkdin_link'],
	                	'gplus_link'     => $view_data['gplus_link'],
	                	'youtube_link'   => $view_data['youtube_link'],
	                	'email_logo'       => $view_data['email_logo'],
	                	'facebook_image'   => 'application/views/default/images/fb.png',
	                	'linkdin_image'    => 'application/views/default/images/in.png',
	                	'twitter_image'    => 'application/views/default/images/twitter.png',
	                	'googleplus_image' => 'application/views/default/images/googleplus.png',
	                	'pinterest_image'  => 'application/views/default/images/p.png',
	                	'youtube_image'    => 'application/views/default/images/youtb.png',
	                	'base_url'         => base_url(),
	                	'company_name'     => $view_data['company']
                    );

	                $body = $this->parser->parse('default/store/emails/contact_us', $ndata, true);
	                
	                //$this->email->cc('another@another-example.com');
	                $this->email->subject('Thanks for Contact us ');
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
                            //$this->email->to('asrivastav@cogniter.com');
	                        $data2 = array(
                                'title'    =>  'Contact us form submitted',
                                'CONTENT'  =>  'An user contacted from contact form . Please find the details below',
                                'USER'     =>  htmlspecialchars( ucwords( $this->input->post('name') ) ),
                                'EMAIL'    =>  htmlspecialchars( $this->input->post('email') ),
                                'PHONE'    =>  htmlspecialchars( $this->input->post('phone') ),
                                'COMMENTS' =>  htmlspecialchars( ucfirst( $this->input->post('comments') ) ),
	                        	'fb_link'        => $view_data['fb_link'],
	                        	'twitter_link'   => $view_data['twitter_link'],
	                        	'pinterest_link' => $view_data['pinterest_link'],
	                        	'linkdin_link'   => $view_data['linkdin_link'],
	                        	'gplus_link'     => $view_data['gplus_link'],
	                        	'youtube_link'   => $view_data['youtube_link'],
	                        	'email_logo'       => $view_data['email_logo'],
	                        	'facebook_image'   => 'application/views/default/images/fb.png',
	                        	'linkdin_image'    => 'application/views/default/images/in.png',
	                        	'twitter_image'    => 'application/views/default/images/twitter.png',
	                        	'googleplus_image' => 'application/views/default/images/googleplus.png',
	                        	'pinterest_image'  => 'application/views/default/images/p.png',
	                        	'youtube_image'    => 'application/views/default/images/youtb.png',
	                        	'base_url'         => base_url(),
	                        	'company_name'     => $view_data['company']
                            );

	                        $body2 = $this->parser->parse('default/store/emails/notify_admin', $data2, true);
	                        
	                        $this->email->subject('Contact us form submitted');
	                        $this->email->message( $body2 );	
	                        $this->email->send();
	                    //Mail to admin ends
		                //echo "Mail sent";
	                }
                    
                    //Send Email Ends
                    
                    //$this->notify_user();
                    $this->session->set_flashdata( 'success', 'Thank you for contacting with us, we will contact you soon.' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
                else
                {
                    $view_data[] = $this->input->post();

                    $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                    //redirect($_SERVER['HTTP_REFERER']) ;
                }
            }
            else
            {
                $view_data[] = $this->input->post();

                $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                //redirect($_SERVER['HTTP_REFERER']) ;
            }
        }
        
        $this->_vci_view('store/contactus', $view_data);
    }

    /**
     * method  cclient
     * description function for adding contact request from store pages
     * submitted from front area using consultant section
     * @param none
     */
    function cclient()
    {
        $this->__is_valid_client_store() ;
        $this->_vci_layout('clientstore_default');

        $this->load->model('common_model') ;
        $this->load->model('contact_model') ;
        #$this->__is_valid_store();
        $this->load->model('client_model');
        
        $popularcat = $this->common_model->getpopularsubcatlist($this->store_id) ;
        $consultantDetail = $this->user_model->is_consultant_exists(trim($this->uri->segments[1]), $this->store_id) ;
        
        #echo '<pre>';
        #print_r($consultantDetail);

        $sender_con_from = $consultantDetail[0]->email;
        $sender_con_name = $consultantDetail[0]->username;
        $consultant_phone = $consultantDetail[0]->phone;
    //    echo '<pre>';
    //    print_r($consultantDetail);
        //die;
        $social_links = $this->common_model->get_marketplace_social_links( 4 ,$consultantDetail['0']->id );
        
  /*    echo '<pre>';
        print_r($social_links);
        die;*/
        $view_data['fb_link']        = isset($social_links->fb_link) ? $social_links->fb_link : "#";
        $view_data['twitter_link']   = isset($social_links->twitter_link) ? $social_links->twitter_link : "#";
        $view_data['pinterest_link'] = isset($social_links->pinterest_link) ? $social_links->pinterest_link : "#";
        $view_data['linkdin_link']   = isset($social_links->linkdin_link) ? $social_links->linkdin_link : "#";
        $view_data['gplus_link']     = isset($social_links->gplus_link) ? $social_links->gplus_link : "#";
        $view_data['youtube_link']   = isset($social_links->youtube_link) ? $social_links->youtube_link : "#";
        $view_data['email_logo']     = isset($social_links->logo_image) ? $social_links->logo_image : '';
        
        if($view_data['fb_link']!="#" && strpos($view_data['fb_link'], 'http') === false)
        {
        	$view_data['fb_link'] = "http://".$view_data['fb_link'];
        }
        if($view_data['linkdin_link']!="#" && strpos($view_data['linkdin_link'], 'http') === false)
        {
        	$view_data['linkdin_link'] = "http://".$view_data['linkdin_link'];
        }
        if($view_data['twitter_link']!="#" && strpos($view_data['twitter_link'], 'http') === false)
        {
        	$view_data['twitter_link'] = "http://".$view_data['twitter_link'];
        }
        if($view_data['gplus_link']!="#" && strpos($view_data['gplus_link'], 'http') === false)
        {
        	$view_data['gplus_link'] = "http://".$view_data['gplus_link'];
        }
        if($view_data['youtube_link']!="#" && strpos($view_data['youtube_link'], 'http') === false)
        {
        	$view_data['youtube_link'] = "http://".$view_data['youtube_link'];
        }
        if($view_data['pinterest_link']!="#" && strpos($view_data['pinterest_link'], 'http') === false)
        {
        	$view_data['pinterest_link'] = "http://".$view_data['pinterest_link'];
        }
        
        
        
        
        $view_data['title'] = 'Contact us :';
        $view_data['name'] = '';
        $view_data['email'] = '';
        $view_data['comments'] = '';
        $view_data['popularcat'] = $popularcat ;
        $view_data['consultant_phone'] = $consultant_phone ;
        $view_data['consultant_email'] = $sender_con_from ;
        //categories section
        #$storeuser = $this->uri->segments[1] ;
        #$store = $this->common_model->get_clientdetail($storeuser);
        $storeurl = $_SERVER['HTTP_HOST'] ;
        $store = $this->common_model->get_clientdetailurl($storeurl);

        $segs = $this->uri->segment_array();
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
        // store categories ends here
        // rule name conatctus
        $view_data['breadcrumbdata'] = array('Home /'=> base_url() .$this->uri->segment(1)."/store" ,
                'Contact'=>'') ;
        
        // rule name conatctus
        $store_email = '';
        $sender_name = '' ;
        if( @$this->store_id > 0 ){
            
            $storedata = $this->common_model->get_clientdetail('',$this->store_id);
            //pr($storedata) ;
            //die;
            if(!empty($storedata)){
                $store_email = $storedata[0]['email'];
                $sender_name = $storedata[0]['username'];
                $view_data['company'] = $storedata[0]['company'];
                $view_data['address'] = $storedata[0]['address'];
                $view_data['state_code'] = $storedata[0]['state_code'];
                $view_data['city'] = $storedata[0]['city'];
                $view_data['zip'] = $storedata[0]['zip'];
                $view_data['phone'] = $storedata[0]['phone'];
                $view_data['fax'] = $storedata[0]['fax'];
                $view_data['sale_support_email'] = $storedata[0]['sale_support_email'];
                $view_data['partner_support_email'] = $storedata[0]['partner_support_email'];
                $view_data['technical_support_email'] = $storedata[0]['technical_support_email'];
           //     $view_data['about_us_link'] = $storedata[0]['about_us_link'];
           //     $view_data['opportunity_link'] = $storedata[0]['opportunity_link'];
            }
            
        }
        if ( $this->input->post( 'formSubmitted' ) > 0 )
        {

            if ( $this->form_validation->run('conatctus') )
            {
                $data = array(
            'store_id' => $this->store_id,      
            'name' => htmlspecialchars($this->input->post('name')),
            'comments' => htmlspecialchars($this->input->post('comments')),
            'email' => htmlspecialchars($this->input->post('email')),
            'phone' => $this->input->post('phone'), 
            );
               // echo "Its working";
                if ( $this->contact_model->add_contact( $data ) )
                {                    
                    //Send Email Below
                    $this->load->library('email');
                    $this->load->library('parser');
                    $smtp_settings = $this->config->item('smtp');
                    
            /*        if(!$store_email){
                       $sender_from = $this->config->item('sender_from'); 
                       $sender_name = $this->config->item('sender_name');
                    }
              */      
                    $this->email->initialize( $smtp_settings );
                    $this->email->from( $sender_con_from, $sender_con_name );
                    $this->email->to( htmlspecialchars( $this->input->post('email') ) );

                    $ndata = array(
                        'title' => 'Contact us form submitted',
                        'CONTENT' => 'Thanks for contacting us. We will contact you soon.',
                        'USER'=> htmlspecialchars( ucwords( $this->input->post('name') ) ),
                    	'fb_link'        => $view_data['fb_link'],
                    	'twitter_link'   => $view_data['twitter_link'],
                    	'pinterest_link' => $view_data['pinterest_link'],
                    	'linkdin_link'   => $view_data['linkdin_link'],
                    	'gplus_link'     => $view_data['gplus_link'],
                    	'youtube_link'   => $view_data['youtube_link'],
                    	'email_logo'       => $view_data['email_logo'],
                    	'facebook_image'   => 'application/views/default/images/fb.png',
                    	'linkdin_image'    => 'application/views/default/images/in.png',
                    	'twitter_image'    => 'application/views/default/images/twitter.png',
                    	'googleplus_image' => 'application/views/default/images/googleplus.png',
                    	'pinterest_image'  => 'application/views/default/images/p.png',
                    	'youtube_image'    => 'application/views/default/images/youtb.png',
                    	'base_url'         => base_url(),
                    	'company_name'     => $view_data['company']
                    );

                    $body = $this->parser->parse('default/store/emails/contact_us', $ndata, true);
                    //$this->email->cc('another@another-example.com');
                    $this->email->subject('Thanks for Contacting us');
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
                            $this->email->from( $sender_con_from, $sender_con_name );
                            $this->email->to( $sender_con_from );
                            //$this->email->to('asrivastav@cogniter.com');
                            $data2 = array(
                                'title'    =>  'Contact us form submitted',
                                'CONTENT'  =>  'An user contacted from contactus form . Please find the details below',
                                'USER'     =>  htmlspecialchars( ucwords( $this->input->post('name') ) ),
                                'EMAIL'    =>  htmlspecialchars( $this->input->post('email') ),
                                'PHONE'    =>  htmlspecialchars( $this->input->post('phone') ),
                                'COMMENTS' =>  htmlspecialchars( ucfirst( $this->input->post('comments') ) ),
                            	'fb_link'        => $view_data['fb_link'],
                            	'twitter_link'   => $view_data['twitter_link'],
                            	'pinterest_link' => $view_data['pinterest_link'],
                            	'linkdin_link'   => $view_data['linkdin_link'],
                            	'gplus_link'     => $view_data['gplus_link'],
                            	'youtube_link'   => $view_data['youtube_link'],
                            	'email_logo'       => $view_data['email_logo'],
                            	'facebook_image'   => 'application/views/default/images/fb.png',
                            	'linkdin_image'    => 'application/views/default/images/in.png',
                            	'twitter_image'    => 'application/views/default/images/twitter.png',
                            	'googleplus_image' => 'application/views/default/images/googleplus.png',
                            	'pinterest_image'  => 'application/views/default/images/p.png',
                            	'youtube_image'    => 'application/views/default/images/youtb.png',
                            	'base_url'         => base_url(),
                            	'company_name'     => $view_data['company']
                            );

                            $body2 = $this->parser->parse('default/store/emails/notify_admin', $data2, true);
                            $this->email->subject('Contact us form submitted');
                            $this->email->message( $body2 );    
                            $this->email->send();
                        //Mail to admin ends
                        //echo "Mail sent";
                    }
                    
                    //Send Email Ends
                    
                    //$this->notify_user();
                    $this->session->set_flashdata( 'success', 'Thank you for contacting with us, we will contact you soon.' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
                else
                {
                    $view_data[] = $this->input->post();

                    $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                    //redirect($_SERVER['HTTP_REFERER']) ;
                }
            }
            else
            {
                $view_data[] = $this->input->post();

                $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                //redirect($_SERVER['HTTP_REFERER']) ;
            }
        }
        
        $this->_vci_view('store/contactus', $view_data);
    }

}

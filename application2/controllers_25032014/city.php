<?php

if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

/*
---------------------------------------------------------------
*   Class:          City extends VCI_Controller defined in libraries
*   Author:         
*   Platform:       Codeigniter
*   Company:        Cogniter Technologies
*   Description:    display city list and details and contact us form etc.
---------------------------------------------------------------
*/

class City extends VCI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    /**
     * method  available_cities
     * Description function fetching city lists
     * @param none
     */
    function available_cities()
    {
        $view_data[ 'title' ] = 'Availble Areas (City)';
        $this->load->model( 'area_model' );
        $this->load->helper( 'url' );
        $area = $this->area_model->get_area_listdata();

        $view_data[ 'listarea' ] = $area;
        $this->_vci_view( 'available_cities', $view_data );
    }

    /**
     * method  view_city
     * description function fetching details for city
     * @param string $cityname
     * @param string $cid
     */
    function view_city( $cityname = '', $cid = '' )
    {

        $this->load->model( 'area_model' );
        $this->load->helper( 'url' );
        $this->load->model( 'contact_model' );

        $view_data[ 'name' ] = '';
        $view_data[ 'email' ] = '';
        $view_data[ 'comments' ] = '';

        //$citydata = $this->area_model->get_area_page( $cid );

        $replacewith = array(' ','/');
        $replace = array('-','_');
        $cityname =  strtolower(str_replace($replace,$replacewith,$cityname)) ;

        $citydata = $this->area_model->get_area_pagebyname( $cityname );

        $view_data[ 'city' ] = $citydata;

        $view_data[ 'city_id' ] = $cid;

        // rule name city_contact
        
        if ( $this->input->post( 'formSubmitted' ) > 0 )
        {

            if ( $this->form_validation->run('city_contact') )
            {
                if ( $this->contact_model->add_contact() )
                {
                    //send email to user as well receiver
                    $this->notify_user();
                    $this->session->set_flashdata( 'success', 'Your request has been submitted successfully. Our executive will be in
touch with you shortly.' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
                else
                {
                    $view_data = $this->input->post();
                    $view_data[ 'city' ] = $citydata;
                    $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
            }
            else
            {
                $view_data = $this->input->post();
                $view_data[ 'city' ] = $citydata;
                $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                redirect($_SERVER['HTTP_REFERER']) ;
            }
        }
        if(@$citydata){
            $view_data[ 'title' ] = 'Availble Areas (City) : City Detail :' . $citydata->name;
         }else{
             $view_data[ 'title' ] = 'Availble Areas (City) : City Detail : Page Not Found';
         }
       
        $this->_vci_view( 'city_detail', $view_data );
    }

    /**
     * method  contactus
     * description function for adding contact us records
     * submitted from front area
     * @param none
     */
    function contactus()
    {
        $this->load->model( 'contact_model' );
        $view_data[ 'title' ] = 'Contact us :';
        $view_data[ 'name' ] = '';
        $view_data[ 'email' ] = '';
        $view_data[ 'comments' ] = '';

        // rule name conatctus
        
        if ( $this->input->post( 'formSubmitted' ) > 0 )
        {

            if ( $this->form_validation->run('conatctus') )
            {
                if ( $this->contact_model->add_contact() )
                {
                    $this->notify_user();
                    $this->session->set_flashdata( 'success', 'Thank you for contacting with us, we will contact you soon.' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
                else
                {
                    $view_data = $this->input->post();

                    $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
            }
            else
            {
                $view_data = $this->input->post();

                $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                redirect($_SERVER['HTTP_REFERER']) ;
            }
        }
        $this->_vci_view( 'contact_us', $view_data );
    }

    /**
     * method  submitrequest
     * function for adding submit enquiries record
     * submitted from front area
     * @param none
     */
    function submitrequest()
    {
        $this->load->model( 'contact_model' );
        
        $view_data[ 'title' ] = 'Contact us :';
        $view_data[ 'name' ] = '';
        $view_data[ 'email' ] = '';
        $view_data[ 'how_know' ] = '';

        $view_data[ 'address' ] = '';
        $view_data[ 'city' ] = '';
        $view_data[ 'state' ] = '';

        $view_data[ 'zip' ] = '';
        $view_data[ 'cphone' ] = '';
        $view_data[ 'invest' ] = '';

        $view_data[ 'units' ] = '';

        if ( count( $this->input->post() ) > 0 )
        {

            if ( $this->form_validation->run('submitrequest') )
            {
                if ( $this->contact_model->add_enquiry() )
                {
                    $this->notify_user();
                    $this->session->set_flashdata( 'success', 'Your request has been submitted successfully. Our executive will be in touch with you
shortly.' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
                else
                {
                    $view_data = $this->input->post();
                    $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                    redirect($_SERVER['HTTP_REFERER']) ;
                }
            }
            else
            {
                $view_data = $this->input->post();
                $this->session->set_flashdata( 'errors', 'Failed !, Please check data that you have filled' );
                
            }
        }
        $this->_vci_view( 'submit_request', $view_data );
    }

    /**
     * method  notify_user
     * function for notifying user as well as site admin that 
     * he have received a ticket for the same
     * submitted from front area
     * @param none
     */
    function notify_user(){

        $this->load->library('email'); 
        
        $name      = $this->input->post('name') ;
        $useremail = $this->input->post('email') ;

        $comments = '';
        if(@$this->input->post('comments')){
          $comments  =  $this->input->post('comments') ;  
        }
        
        
        $msgBody = '<div>Hi,</div>';
        $msgBody .= '<div>&nbsp;</div>';
        $msgBody .= '<div>We have received a mail with below details : </div>';
        $msgBody .= '<div>&nbsp;</div>';
        $msgBody .= '<div style="width:100%;display:block;"><div style="font-weight:bold;width:200px;float:left;">Name :</div><div style="width:300px;float:left;">'.$name.'</div></div><br/>';
        $msgBody .= '<div style="width:100%;display:block;"><div style="font-weight:bold;width:200px;float:left;">Email :</div> <div style="width:300px;float:left;"> '.$useremail.'</div></div><br/>';
       

        if(@$this->input->post('city')){
           $city      = $this->input->post('city') ; 
           $msgBody .= '<div><div style="font-weight:bold;width:200px;float:left;">City :</div> <div style="width:300px;float:left;">'.$city.'</div></div><br/>';
        }
        
        if(@$this->input->post('state')){ 
            $state     = $this->input->post('state') ;
            $msgBody .= '<div><div style="font-weight:bold;width:200px;float:left;">State :</div> <div style="width:300px;float:left;">'.$state.'</div></div><br/>';
        } 

        if(@$this->input->post('zip')){ 
            $zip       = $this->input->post('zip') ;
            $msgBody .= '<div><div style="font-weight:bold;width:200px;float:left;">Zip :</div> <div style="width:300px;float:left;">'.$zip.'</div></div><br/>';
        }

        if(@$this->input->post('cphone')){ 
            $daytimephone =  $this->input->post('cphone') ;
            $msgBody .= '<div><div style="font-weight:bold;width:200px;float:left;">Day Time phone no :</div> <div style="width:300px;float:left;">'.$daytimephone.'</div></div><br/>';
        }
        
        if(@$this->input->post('invest')){ 
            $invest    = $this->input->post('invest') ;
            $msgBody .= '<div><div style="font-weight:bold;width:200px;float:left;">When are you looking to invest : </div><div style="width:300px;float:left;">'.$invest.'</div></div><br/>';
        }
         $msgBody .= '<div></div><br/>';
        if(@$this->input->post('units')){ 
          $invest    = $this->input->post('units') ;
          $msgBody .= '<div><div style="font-weight:bold;width:200px;float:left;">No of units : </div><div style="width:300px;float:left;">'.$invest.'</div></div><br/>';
        }

        if(! $comments){
          $comments = $this->input->post('how_know') ;  
          $msgBody .= '<div><div style="font-weight:bold;width:200px;float:left;float:left;">How did you hear about us :</div> <div style="width:300px;float:left;">'.$comments.'</div></div><br/>';
        }else{
           $msgBody .= '<div style="display:inline-block"><div style="font-weight:bold;width:200px;float:left;">Comments : </div><div style="width:300px;float:left;">'.$comments.'</div></div><br/>';
        }
        
        $footermsgBody  = '<div>&nbsp;</div>';
        $footermsgBody .= '<div><div style="width:200px;">Thanks,</div></div>';
        $footermsgBody .= '<div>DogDayCare Team</div>';
        
        $finalmsgBody = $msgBody.$footermsgBody;

        // mail from visiitor of site sendintg to admin starts here

        $this->email->from($this->config->item('email_from')); // admin email setted in config
        $this->email->to($this->config->item('email_from')); // admin email setted in config
        
        $this->email->subject('A Contact message from visitor of site');
        $this->email->message($finalmsgBody);
        $this->email->set_mailtype('html');
        #$this->email->set_alt_message($txtMessage);
        $this->email->send();

        #echo $this->email->print_debugger();
        // mail from visiitor of site ends here sending to admin --

        // mail from visiitor of site sending to user --
        $htmlMessage = 'Message body to go here';
        //$this->email->from($this->config->item('email_from'),$this->config->item('from_name'));
        $this->email->from($this->config->item('email_from'));

        $this->email->to($useremail); // submitted email
        $this->email->subject('We have received Query from you , Thank you for contacting us');

        $msgBody .= '<div>&nbsp;</div><div>&nbsp;</div><br/><div>We will contact you shortly. </div>';
        $usermsgBody = $msgBody.$footermsgBody;

        $this->email->message($usermsgBody);
        $this->email->set_mailtype('html');
        $this->email->send();
        #echo $this->email->print_debugger();
    }

}
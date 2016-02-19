<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Class:	Order extends VCI_Controller defined in libraries
 *	Author:	
 *	Platform:	Codeigniter
 *	Company:	Cogniter Technologies
 *	Description: Manage Order entity
 */
class Order extends VCI_Controller {

	var $clientid		= null; //stores current client id
	var $cat_id = null;
	var $per_page;

    /**
     * Class constructor
     */
	function __construct()
	{
		parent::__construct();
        $this->load->model('common_model');
        $this->load->model('order_model');
        $this->load->library('paypalrefund');
        
	}

	
	/**
	 *	Method: manage
	 *	@param page integer
	 *	Description: creates listing and handles search operations
	 */
	function manage($page = 0)
	{
	    //redirect( base_url( ) . 'admin/desktop' );
		$table = 'order';
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

		//prepare the data for exporting to view
		$view_data = array('caption' => 'Order Manage');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Orders' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs']     = $crumbs;


		//Load model and pagination library
		$this->load->library('pagination');
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s') ;
		}
		//Set pagination configs
		
		//Set pagination configs
		$getData = array('s'=>$qstr);	
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() . "order/manage?s=".$qstr;
		$config['base_url'] = base_url() . "order/manage";
		$config['total_rows'] = intval($this->order_model->get_all( $table, '','',true, $store_id ,$consultantId ));
		$config['per_page'] = PAGE_LIMIT;
		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		
		$view_data['orders'] = $this->order_model->get_all( $table, $page, PAGE_LIMIT, false, $store_id,$consultantId );
		
		$view_data['orders_all_sum'] = $this->order_model->get_all_sum( $table, true, $store_id, $consultantId ); 
		
		$view_data['clients_consultant']  = $this->order_model->all_clients_consultant();

		$clients  = $this->order_model->get_all_clients();
        $view_data['clients'] = $clients;

        if(isset($this->session->userdata))
        {
        	$cons_role_id = $this->session->userdata('user');
        	$view_data['consultant_role_id'] = $cons_role_id['role_id'];
        }
        
		$this->_vci_view('order_manage',$view_data);
	}


/**
	 *	Method: manage
	 *	@param page integer
	 *	Description: creates listing and handles search operations
	 */
	function consultantactivity($page = 0)
	{
	    //redirect( base_url( ) . 'admin/desktop' );
		$table = 'order';
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

		//prepare the data for exporting to view
		$view_data = array('caption' => $this->consultant_label.' Order Activity');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage '.$this->consultant_label.' Order Activity' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs']     = $crumbs;


		//Load model and pagination library
		$this->load->library('pagination');
		$qstr = '';
		if($this->input->get('s')){
			$qstr = $this->input->get('s') ;
		}
		//Set pagination configs
		
		//Set pagination configs
		$getData = array('s'=>$qstr);	
		$config['suffix'] = '?'.http_build_query($getData,'',"&amp;");
		$config['first_url'] = base_url() . "order/consultantactivity?s=".$qstr;
		$config['base_url'] = base_url() . "order/consultantactivity";
		$config['total_rows'] = intval($this->order_model->get_all_consultantactivity( $table, '','',true, $store_id ,$consultantId ));
		$config['per_page'] = PAGE_LIMIT;
		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		
		$view_data['orders'] = $this->order_model->get_all_consultantactivity( $table, $page, PAGE_LIMIT, false, $store_id,$consultantId );
		
		$view_data['orders_all_sum'] = $this->order_model->get_all_consultantactivity_sum( $table, true, $store_id, $consultantId ); 
		
		$view_data['clients_consultant']  = $this->order_model->all_clients_consultant();

		$clients  = $this->order_model->get_all_clients();
        $view_data['clients'] = $clients;

        if(isset($this->session->userdata))
        {
        	$cons_role_id = $this->session->userdata('user');
        	$view_data['consultant_role_id'] = $cons_role_id['role_id'];
        }
        
		$this->_vci_view('order_manage_consultantactivity',$view_data);
	}


	/**
	 *	Method: edit client
     *
	 *	@param id integer
	 *	Description: edit client information
	 */
	function view($id = null)
	{
		//set required things
		$this->_vci_layout( 'menu-toolbar' );
		$this->load->library( 'form_validation' );
		$this->load->model('settings_model');
        $uri = $this->uri->uri_to_assoc(3);
        
        $this->load->library('Avatax'); // Added on


        $transaction_id = $uri['id'];
        if( !isset( $transaction_id ) || empty( $transaction_id ) )
        {
        	$this->session->set_flashdata('errors', 'Error in transaction id - Please check the URL' );
        	redirect( base_url() . 'order/manage' );
        }

        $order_view = $this->order_model->order_view($table = 'order', $transaction_id );
		
       	
		$storesettings = $this->settings_model->get_store_settings_page($order_view->store_id ,2) ;
		//echo '<pre>' ;
		//echo $order_view->id ;
        //print_r($storesettings);
        /*
         [ava_account_number] => 1100152941
    	 [ava_license_key] => F0D3AC768AE0A755
         [ava_company_code] => ABCDEFG
        */
    	//print_r($order_view);

    	$avaconfig['accountNumber'] = $storesettings->ava_account_number;
		$avaconfig['licenseKey']    = $storesettings->ava_license_key;
		$avaconfig['serviceURL']    = AVATAX_SERVICEURL ;   
		$avaconfig['company_code']  = $storesettings->ava_company_code ; 

        $order_detail = $this->order_model->order_detail($order_view->id) ;

        $billing_shipping = $this->order_model->get_billingshippingdetail($order_view->store_id, $order_view->user_id , $order_view->id) ;
    
        if( empty( $order_view ) )
        {
        	$this->session->set_flashdata('errors', 'Invalid transaction id' );
        	redirect( base_url() . 'order/manage' );
        }

        if($this->input->post('formSubmitted') > 0)
		{
			
			$this->avatax->canceltax($avaconfig, $order_view->id) ;
			
			$retund_transaction_id = htmlspecialchars($this->input->post('transaction_id', true));
			if( empty( $retund_transaction_id ) )
			{
				$this->session->set_flashdata('errors', 'Error in transaction id' );
        		redirect( base_url() . 'order/manage' );
			}
			
			if($this->input->post('gateway') == 0 ){
				$aryData['transactionID'] = $retund_transaction_id;
			    $aryData['refundType'] = "Partial"; //Partial or Full
			    $aryData['currencyCode'] = "USD";
			    $aryData['amount'] = $order_view->order_amount;
			    $aryData['memo'] = "There Memo Detail entered for Partial Refund";
			    $aryData['invoiceID'] = "123";
			    
			   $aryData['paypal_username'] = $storesettings->paypal_username;
			   $aryData['paypal_email'] = $storesettings->paypal_email;
			   $aryData['paypal_password'] = $storesettings->paypal_password;
			   $aryData['paypal_signature'] = $storesettings->paypal_signature;

			   $aryRes = $this->paypalrefund->refundAmount($aryData);
			    
			    if($aryRes['ACK'] == "Success")
			    {
			    	$data = array('refund_transaction_id' => $aryRes['REFUNDTRANSACTIONID'] ,'order_status'=>4 );
			    	if( $this->order_model->updateWhere( 'order', array( 'transaction_id' => $retund_transaction_id ), $data ) )
			    	{
			    		$this->session->set_flashdata('success', 'Amount Refunded Successfully' );
			    		redirect( base_url() . 'order/view/id/' . $retund_transaction_id );
			    	}
			    	else
			    	{
			    		$this->session->set_flashdata('errors', 'Error in update refuend status' );
			    		redirect( base_url() . 'order/view/id/' . $retund_transaction_id );
			    	}
			    }
			    else
			    {
			    	$this->session->set_flashdata('errors', 'Error refunding amount- '.$aryRes['L_LONGMESSAGE0'] );
		    		redirect( base_url() . 'order/view/id/' . $retund_transaction_id );
			    }
			}else{
				$data = array('refund_transaction_id' => 'MARITUS(Refund using panel)' ,'order_status'=>4 );
				if( $this->order_model->updateWhere( 'order', array( 'transaction_id' => $retund_transaction_id ), $data ) ){
					$this->session->set_flashdata('errors', 'Error refunding amount-(Please use maritus pay account panel , locate using transaction id), order marked refunded ' );
				}
				//$this->session->set_flashdata('errors', 'Error refunding amount-(Please use maritus pay account panel , locate using transaction id) ' );
				redirect( base_url() . 'order/view/id/' . $retund_transaction_id );
			}

			/* Refund ammount code gose here */

		}

                
		//get clientid either from argument passed or from posted fields
		$this->cat_id = ( isset( $uri['id'] ) ) ? $uri['id'] : $this->input->post( 'id' );
		//check if client id is not empty

		$view_data = array( 'caption' => 'View Order' );
		
		//set breadcrumb
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Order'=> array('link'=>'order/manage', 'attributes' => array('class'=>'breadcrumb')),
			//lang('editclient_caption') => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		) );
		$view_data['crumbs'] = $crumbs;
		$view_data['order_view'] = $order_view;
		$view_data['order_detail'] = $order_detail ;
		$view_data['billing_shipping'] = $billing_shipping ;
		
        //load the view normally
        $this->_vci_view('order_view', $view_data);

	}
}

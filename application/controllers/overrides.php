<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Class:	client extends VCI_Controller defined in libraries
 *	Author:	Mandeep Singh
 *	Platform:	Codeigniter
 *	Company:	Cogniter Technologies
 *	Description: Manage client entity
 */
class Overrides extends VCI_Controller {
//class Overrides extends CI_Controller {
	var $clientid		= null; //stores current client id
	var $cat_id = null;
	var $per_page;

    /**
     * Class constructor
     */
	function __construct()
	{
		ini_set('display_errors',1) ;
		parent::__construct();
        $this->load->model('common_model');
        $this->load->model('order_model');
        //$this->load->library('paypalrefund');
        
	}

	/*
	purpose cron_job for calculating the overrides and commision
	*/
	function cron_job(){
		
		$this->load->model('order_model');
		$ordersArr = $this->order_model->get_overrides_orders() ;

		foreach ($ordersArr as $key => $value) {
			
			$rootOrderId = $value->id ;
			$rootOrderAmt = $value->order_amount ;
			$rootStoreID = $value->store_id ;
			$rootConsulatntID = $value->consultant_user_id ;
			$chainArr = array() ;
			// get store settings now //
			
			$store_settings = $this->order_model->get_store_settings($rootStoreID) ;
			#pr($store_settings) ;
			#die;
			if(!$store_settings){
				continue; 
				// no need to go as there is no store settings applied there 
				// cross check needed here
			}
			// get store settings ends here //
			$this->order_model->getimmediate_chainlink($rootConsulatntID, $rootStoreID, 0 , $chainArr) ;
			
			//die;
			$chainArr = $this->order_model->chainArr ;
			
			$k = 0 ;
			foreach ($chainArr as $key => $valuechain) {
				# code...
				if($k == 0){
					// user will be getting direct commisions only
				}
				if($k!= 0){ // for skipping first entry
					// getting executive level detail of consultant
					$executiveDetail = $this->order_model->get_executivelevel($valuechain['consultantdata']['id'] ,$rootStoreID ) ; 
					if($executiveDetail){

						// distribute the overrides commision
						if($valuechain['chain_level'] <= $executiveDetail['generation_access']){
							//echo 'Entry paid';
							/// eligible to get overrides commision now
							$overdata = array() ;
							// insert query
							$overdata['order_id'] = $rootOrderId ;
							$overdata['consultant_user_id']	= $valuechain['consultantdata']['id'];
							$overdata['commision_percentage'] = $store_settings['level'.$valuechain['chain_level']] ;
							$overdata['commision_amount'] = (float) ($rootOrderAmt* $store_settings['level'.$valuechain['chain_level']])/100 ;
							$overdata['consultant_genration_level'] = $valuechain['chain_level'] ;
							$overdata['store_id'] = $rootStoreID ;
							$this->order_model->add_overrides($overdata) ;

						}else{
							//echo 'No paid';
							// Not eligible  to get the genrational overrides commision as More deeper acces  is required  to get that commision
						}
					}else{
						// Not to calculate override for that consultant , as having no executive levels assigned by store
					}
				}
				$k++ ;	
			}
			// update order for now as overrides calculation done
			$odata =  array('is_overrides_calc'=>1) ;
			$this->order_model->updateorder_status($rootOrderId,$odata) ;
			// update that order entry as we have to mark that commision is distributed among them
		}
	}

	/*
	commision calculation
	*/
	function calculate_commision(){
		//echo 'cron job is running now' ;
		$this->load->model('order_model');
		$ordersArr = $this->order_model->get_commision_orders() ;

		foreach ($ordersArr as $key => $value) {
			$rootOrderId = $value->id ;
			$rootOrderAmt = $value->order_amount ;
			$rootStoreID = $value->store_id ;
			$rootConsulatntID = $value->consultant_user_id ;
			$chainArr = array() ;
			// get store settings now //
			if($rootConsulatntID){
				$store_settings = $this->order_model->get_store_settings($rootStoreID) ;
				$executiveDetail = $this->order_model->get_executivelevel($rootConsulatntID ,$rootStoreID ) ; 
				
				if($executiveDetail){
					$data = array() ;
					$data['order_id'] = $rootOrderId;
					$data['commision_percentage'] =  $executiveDetail['direct_commision'] ; 
					$data['commision_amount'] = (float) ($rootOrderAmt*$executiveDetail['direct_commision'])/100 ;
					$data['consultant_user_id'] = $rootConsulatntID ;
					$data['store_id'] = $rootStoreID ;

					$this->order_model->add_commission($data) ;
				}
			}
			
			$odata =  array('is_commision_calc'=>1) ;
			$this->order_model->updateorder_status($rootOrderId,$odata) ;
		}
		echo 'call goes now to clubbing the entries right now';
		$this->combine_allpayments();
		die('checking some stuffs there');
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
        $uri = $this->uri->uri_to_assoc(3);
        $transaction_id = $uri['id'];
        if( !isset( $transaction_id ) || empty( $transaction_id ) )
        {
        	$this->session->set_flashdata('errors', 'Error in transaction id - Please check the URL' );
        	redirect( base_url() . 'order/manage' );
        }

        $order_view = $this->order_model->order_view($table = 'order', $transaction_id );
        
        #echo '<pre>';
        #print_r($order_view) ;

        $order_detail = $this->order_model->order_detail($order_view->id) ;

        $billing_shipping = $this->order_model->get_billingshippingdetail($order_view->store_id, $order_view->user_id , $order_view->id) ;
        
        if( empty( $order_view ) )
        {
        	$this->session->set_flashdata('errors', 'Invalid transaction id' );
        	redirect( base_url() . 'order/manage' );
        }

        if($this->input->post('formSubmitted') > 0)
		{
			$retund_transaction_id = htmlspecialchars($this->input->post('transaction_id', true));
			if( empty( $retund_transaction_id ) )
			{
				$this->session->set_flashdata('errors', 'Error in transaction id' );
        		redirect( base_url() . 'order/manage' );
			}

			$aryData['transactionID'] = $retund_transaction_id;
		    $aryData['refundType'] = "Partial"; //Partial or Full
		    $aryData['currencyCode'] = "USD";
		    $aryData['amount'] = $order_view->order_amount;
		    $aryData['memo'] = "There Memo Detail entered for Partial Refund";
		    $aryData['invoiceID'] = "123";
		    

		    $aryRes = $this->paypalrefund->refundAmount($aryData);
		    #echo '<pre>';
		    #print_r($aryRes) ;
		    #die;

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
		    	$this->session->set_flashdata('errors', 'Error refunding amount' );
	    		redirect( base_url() . 'order/view/id/' . $retund_transaction_id );
		    }

		    /*echo "<pre>";
		    print_r($aryRes);
		    echo "</pre>";*/
			/* Refund ammount code gose here */
		}

                
		//get clientid either from argument passed or from posted fields
		$this->cat_id = ( isset( $uri['id'] ) ) ? $uri['id'] : $this->input->post( 'id' );
		//check if client id is not empty
		

		//prepare data to export to view
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

	/* calculate and update group purchase sales entry cron -3*/
	function cron_markexpired_groupsales(){
		$this->load->model('grouppurchase_model') ;
		$rs = $this->grouppurchase_model->getexpired_grouppurchase();
		$group_id = array() ;
		if(!empty($rs)){
		    foreach($rs as $rsvalue){
		    	$group_id[] =  $rsvalue->id;
		    	$this->grouppurchase_model->update_expiredgroupentry($rsvalue->id, array('is_expired'=>1)) ;
		    }
		}
		$this->grouppurchase_model->calculate_groupsales() ;
	}

	/* cron job to genrate coupons on behalf of given rules  cron -4*/
	function cron_genrate_coupon(){
		$this->load->model('grouppurchase_model') ;
		$rs = $this->grouppurchase_model->get_coupons_eligiblegrouppurchases();
	}

	/// Newly added functions
	function cron_offerpromotions(){
		error_reporting(1);
		
		//echo 'Cron for promotions';
		//$order = $this->order_model->get_lastweek_orders() ;
		$order = $this->order_model->getallconsultants() ;
		//echo '<pre>';
		$allconsArr = array() ;
		foreach ($order as $key => $value) {
			# code...
			//print_r($value);
			#die;
			$executivedetail = $this->order_model->get_consultant_executive_detail( $value['id'] );
			//print_r($executivedetail) ;
			$executivedetail = @$executivedetail[0]->executive_level_id ;
			$consdetail = array('store_id'=>$value['store_id'] ,'consultant_user_id'=>$value['id'] ,'executive_detail'=>$executivedetail) ;
			if(!in_array($consdetail, $allconsArr)){
				$allconsArr[] = $consdetail  ;
			}
			
		}
		
		//print_r($allconsArr) ;
		
		foreach ($allconsArr as $key => $value) {
			# code...
			// print_r($value);
			$ppv = $this->order_model->ppvlastweek($value['consultant_user_id'], $value['store_id']); // personal purchase volume
			$pcv = $this->order_model->pcvlastweek($value['consultant_user_id'], $value['store_id']); // personal customer volume
			
			$getbtree = $this->common_model->getbtreechild($value['consultant_user_id']) ;
			$firstleg = 0 ;
			$firstlegvol = 0 ;
			$secondleg = 0 ;
			$firstlegvol = 0 ;
			if(!empty($getbtree) && isset($getbtree[0]['consultant_id'])){
				$firstleg = $getbtree[0]['consultant_id'] ;
			}
			if(!empty($getbtree) && isset($getbtree[1]['consultant_id'])){
				$secondleg = $getbtree[1]['consultant_id'] ;
			}
			if($firstleg){
				$firstlegvol = 0 ;
				//geta all childs
				$conArr = $this->common_model->getallbtreechilds($firstleg , $prearr = array()) ;
				
				if(!empty($conArr) && (count($conArr) !=1) && ($conArr[0] != 0) ){
					$firstlegvol = $this->order_model->ptreelastweek($conArr, $value['store_id']) ; // tree consultant sum voulme data
				}
			}
			if($secondleg){
				$secondleg = 0 ;
				//geta all childs
				$conArr2 = $this->common_model->getallbtreechilds($secondleg , $prearr = array()) ;
				if(!empty($conArr2) && (count($conArr2) !=1) && ($conArr2[0] != 0) ){
					$secondleg = $this->order_model->ptreelastweek($conArr2, $value['store_id']) ; // tree consultant sum voulme data
				}
			}
			
			$legvol = min($firstlegvol ,$secondleg) ;
			// die;
			$ruledetail = $this->order_model->getruleforstoreconsulant($value['store_id'] , $legvol ,$ppv, $pcv);
			
			if(!empty($ruledetail)){
				//print_r($ruledetail->executive_level_id) ;
				$this->order_model->updateexelevel($value['store_id'] , $value['consultant_user_id'] ,$ruledetail->executive_level_id) ;
			}
			if($ppv || $pcv || $legvol){
			$datatoAdd = array(
				'consultant_id'=>$value['consultant_user_id'],
				'store_id' => $value['store_id'],
				'tppv'=>$ppv,
				'tpcv'=>$pcv,
				'tcbv'=>$legvol
				) ;
			$this->order_model->insert_volumedata($datatoAdd) ;
			}
			// insert a record in ppv pcv table weekly

		}
		//die;
		// Get all order of last week

	}
	
	function cron_volumecommissions(){
		error_reporting(1);
		echo 'Cron for volume commissions';
		
		//fetching all entries from volume commissions to update them
		$volumeCommissions = $this->order_model->fetch_volumedata();
		
		//Processing each consultant entry in the volume.
		foreach ($volumeCommissions as $key => $value) {
			//array to updates values for each entries
			$arrayToUpdate = array( 'date_added' => date('Y-m-d H:i:s') );
			
			//fetching cunsultant executive ID
			$executivedetail   = $this->order_model->get_consultant_executive_detail( $value['consultant_id'] );			
			$executivedetailID = @$executivedetail[0]->executive_level_id ;
			
			//fetching percentage criteria as per the executive level
			if( $executivedetailID ){
				$executiveCriteriaValues = $this->order_model->get_volume_executive_detail( $executivedetailID );
				if(is_array($executiveCriteriaValues))
				{
					$arrayToUpdate['pppv'] = $executiveCriteriaValues[0]['personal_purchase_volume'];
					$arrayToUpdate['ppcv'] = $executiveCriteriaValues[0]['personal_customer_volume'];
					$arrayToUpdate['pcbv'] = $executiveCriteriaValues[0]['configurable_binary_volume'];
					
					$arrayToUpdate['appv'] = ($value['tppv']*$executiveCriteriaValues[0]['personal_purchase_volume'])/100;
					$arrayToUpdate['apcv'] = ($value['tpcv']*$executiveCriteriaValues[0]['personal_customer_volume'])/100;
					$arrayToUpdate['acbv'] = ($value['tcbv']*$executiveCriteriaValues[0]['configurable_binary_volume'])/100;
				}
			}
			$this->order_model->update_volumedata($arrayToUpdate,$value['consultant_id']);			
			
		}
		die('Cron Ends');
	}

	//added on 01112015
	function combine_allpayments(){
		
		$previous_week = strtotime("-1 week +1 day");

		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);

		$start_week = date("Y-m-d",$start_week);
		$end_week = date("Y-m-d",$end_week);

		$consArr = $this->order_model->getconrecfromCommisionOrder() ;
		$consArr2 = $this->order_model->getconrecfromExecutiveBonus();
		$consArr3 = $this->order_model->getconrecfromOverrideOrder();
		$consArr4 = $this->order_model->getconrecfromVolumeCommision();
		//echo '<pre>';
		//print_r($consArr);
		//print_r($consArr2);
		//print_r($consArr3);
		//print_r($consArr4);
		$allCosultant = array_unique(array_merge($consArr,$consArr2,$consArr3,$consArr4));
		//print_r($allCosultant);	
		foreach($allCosultant as $eachCons) {
		   #print_r($eachCons);	
		   //get commision order
		   $storeDetail = $this->order_model->getconsultantstore($eachCons) ;
		   $commSum   = $this->order_model->getconrecfromCommisionOrderSum($eachCons) ;	
		   $exeBonSum = $this->order_model->getconrecfromExecutiveBonusSum($eachCons) ;	
		   $overridesSum = $this->order_model->getconrecfromOverrideOrderSum($eachCons) ;
		   $volComSum = $this->order_model->getconrecfromVolumeCommisionSum($eachCons) ;	
		   
		   
		   $allCommisionOrderSum= $commSum[0]['sum_camt'];
		   $allexeBonSum	= $exeBonSum[0]['bonus_sum'];
		   $alloverrideSum	= $overridesSum[0]['sum_ocamt'];
		   $allvolComSum	= $volComSum[0]['fin_comsum'] ;
		   $storeId 		= $storeDetail[0]['store_id'] ;
		   
		   $dataToSave = array(
			'consultant_id'=>$eachCons,
			'store_id'=>	$storeId,
			'order_comm'=> (float)$allCommisionOrderSum,
			'vol_comm'=> (float)$allvolComSum,
			'bonus_earned'=> (float)$allexeBonSum,
			'overrides_comm'=>(float)$alloverrideSum,
			'all_due'=> ($allCommisionOrderSum+$allvolComSum+$allexeBonSum+$alloverrideSum) ,
			'date_from'=>$start_week ,
			'date_to'=> $end_week,
		   );
                   $insRes = $this->order_model->addduepayments($dataToSave);
		   if($insRes){
		   // update the all four tables
		   	$this->order_model->getconrecfromCommisionOrderUpdate($eachCons) ;
			$this->order_model->getconrecfromExecutiveBonusUpdate($eachCons) ;
			$this->order_model->getconrecfromOverrideOrderUpdate($eachCons) ;
			$this->order_model->getconrecfromVolumeCommisionUpdate($eachCons) ;
                   }
		   
		}	
		die('combine ends now');
	}	

}

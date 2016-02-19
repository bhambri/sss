<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter AVAtax  Class
 *
 * Permits AVAtax tobe calculated using cart details and to integrate it with AVAtax system
 *
 * @package		AVAlara AVAtax
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Abhishek Sr.
 * @link        reference - https://github.com/avadev/AvaTax-Calc-REST-PHP
 * @company 	Cogniter Tech. Pvt Ltd. 
*/

Class Avatax{

	public $serviceURL = 'https://development.avalara.net' ;
	public $accountNumber = '1100152941' ;
	public $licenseKey = 'F0D3AC768AE0A755' ;

	function __construct(){
		include 'avatax_autoload.php'; // includeing autoloader
	}

	function getax($configuration , $customer , $address, $cartdetail ,$disc_amount ){
		ini_set('display_errors',1);
	
		if(!empty($configuration)){
			$this->serviceURL = $configuration['serviceURL'];
			$this->accountNumber = $configuration['accountNumber'];
			$this->licenseKey = $configuration['licenseKey'];
		}
		
		$serviceURL = $this->serviceURL ;
		$accountNumber = $this->accountNumber ;
		$licenseKey = $this->licenseKey ;
			
		$taxSvc = new AvaTax\TaxServiceRest($serviceURL, $accountNumber, $licenseKey);
		$getTaxRequest = new AvaTax\GetTaxRequest();

		// Document Level Elements
		// Required Request Parameters
		$getTaxRequest->setCustomerCode($customer['customer_code']);
		$getTaxRequest->setDocDate(date('Y-m-d'));

		// Best Practice Request Parameters
		// companycode -- APITrialCompany
		$getTaxRequest->setCompanyCode($configuration['company_code']);
		
		// $getTaxRequest->setDocCode("INV001");
		$getTaxRequest->setDetailLevel(AvaTax\DetailLevel::$Tax);
		$getTaxRequest->setCommit(FALSE);
		//$getTaxRequest->setCommit(TRUE);

		$getTaxRequest->setDocType(AvaTax\DocumentType::$SalesOrder);

		if($disc_amount){
			$getTaxRequest->setDiscount($disc_amount);
		}
		
		$getTaxRequest->setCurrencyCode("USD");

		// Address Data
		$addresses = array();

		foreach ($address as $key => $value) {

			$address1 = new AvaTax\Address();
			$address1->setAddressCode($key);
			
			$address1->setCity($value['city']);
			$address1->setRegion($value['state_code']);
			$address1->setCountry("US");
			$address1->setPostalCode($value['zip']);
			$addresses[] = $address1;
		}
		
		$getTaxRequest->setAddresses($addresses);
		
		$lines = array();

		foreach ($cartdetail as $key => $value) {

			$line1 = new AvaTax\Line();
			$line1->setLineNo($key);
			$line1->setItemCode($value['id']);
			$line1->setQty($value['qty']);
			$line1->setAmount($value['subtotal']);
			$line1->setOriginCode("0");
			$line1->setDestinationCode("1");
			if($disc_amount){
				$line1->setDiscounted(TRUE);
			}

			$line1->setTaxCode($value['tax_code']);
			$lines[] = $line1;
		}
		
		$getTaxRequest->setLines($lines);

		$getTaxResult = $taxSvc->getTax($getTaxRequest);

		//pr($getTaxResult) ;
		$resultCode = $getTaxResult->getResultCode() ; 
		if($resultCode == 'Success'){
			$totaltax =  $getTaxResult->getTotalTax() ;
			if($totaltax){
				return $totaltax ;
			}
		}else{
			return 0 ;
		}
		return 0 ;
	}

	function createInvoice($configuration , $customer , $address, $cartdetail ,$disc_amount ,$orderid ){
		
		if(!empty($configuration)){
			$this->serviceURL = $configuration['serviceURL'];
			$this->accountNumber = $configuration['accountNumber'];
			$this->licenseKey = $configuration['licenseKey'];
		}
		
		$serviceURL = $this->serviceURL ;
		$accountNumber = $this->accountNumber ;
		$licenseKey = $this->licenseKey ;
			
		$taxSvc = new AvaTax\TaxServiceRest($serviceURL, $accountNumber, $licenseKey);
		$getTaxRequest = new AvaTax\GetTaxRequest();

		// Document Level Elements
		// Required Request Parameters
		$getTaxRequest->setPurchaseOrderNo($orderid);

		$getTaxRequest->setCustomerCode($customer['customer_code']);
		$getTaxRequest->setDocDate(date('Y-m-d'));

		// Best Practice Request Parameters
		// companycode -- APITrialCompany
		$getTaxRequest->setCompanyCode($configuration['company_code']);
		
		$getTaxRequest->setDocCode($orderid);
		$getTaxRequest->setDetailLevel(AvaTax\DetailLevel::$Tax);
		$getTaxRequest->setCommit(TRUE);
		//$getTaxRequest->setCommit(TRUE);

		$getTaxRequest->setDocType(AvaTax\DocumentType::$SalesInvoice);

		if($disc_amount){
			$getTaxRequest->setDiscount($disc_amount);
		}
		
		$getTaxRequest->setCurrencyCode("USD");

		// Address Data
		$addresses = array();

		foreach ($address as $key => $value) {

			$address1 = new AvaTax\Address();
			$address1->setAddressCode($key);
			
			$address1->setCity($value['city']);
			$address1->setRegion($value['state_code']);
			$address1->setCountry("US");
			$address1->setPostalCode($value['zip']);
			$addresses[] = $address1;
		}
		
		$getTaxRequest->setAddresses($addresses);
		
		$lines = array();

		foreach ($cartdetail as $key => $value) {

			$line1 = new AvaTax\Line();
			$line1->setLineNo($key);
			$line1->setItemCode($value['id']);
			$line1->setQty($value['qty']);
			$line1->setAmount($value['subtotal']);
			$line1->setOriginCode("0");
			$line1->setDestinationCode("1");
			if($disc_amount){
				$line1->setDiscounted(TRUE);
			}

			$line1->setTaxCode($value['tax_code']);
			$lines[] = $line1;
		}
		
		$getTaxRequest->setLines($lines);

		$getTaxResult = $taxSvc->getTax($getTaxRequest);

		//pr($getTaxResult) ;
		$resultCode = $getTaxResult->getResultCode() ; 
		if($resultCode == 'Success'){
			$totaltax =  $getTaxResult->getTotalTax() ;
			if($totaltax){
				return $totaltax ;
			}
		}else{
			return 0 ;
		}
		return 0 ;
	}

	function canceltax($configuration, $orderid){
		// Header Level Elements
		// Required Header Level Elements
		$serviceURL = $configuration['serviceURL'];
		$accountNumber = $configuration['accountNumber'];
		$licenseKey = $configuration['licenseKey'];
			
		$taxSvc = new AvaTax\TaxServiceRest($serviceURL, $accountNumber, $licenseKey);
		$cancelTaxRequest = new AvaTax\CancelTaxRequest();

		// Required Request Parameters
		$cancelTaxRequest->setCompanyCode($configuration['company_code']);
		$cancelTaxRequest->setDocType(AvaTax\DocumentType::$SalesInvoice);		
		$cancelTaxRequest->setDocCode($orderid);		
		$cancelTaxRequest->setCancelCode(AvaTax\CancelCode::$DocVoided);	

		$cancelTaxResult = $taxSvc->cancelTax($cancelTaxRequest);

		//Print Results
		echo 'CancelTaxTest Result: ' . $cancelTaxResult->getResultCode() . "\n";
		if($cancelTaxResult->getResultCode() != AvaTax\SeverityLevel::$Success)	// call failed
		{	
			foreach($cancelTaxResult->getMessages() as $message)
			{
				echo $message->getSeverity() . ": " . $message->getSummary()."\n";
			}
		}
	}

}
/* Avatx ends here */
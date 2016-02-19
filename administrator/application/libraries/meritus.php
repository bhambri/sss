<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:        Mahana Messaging Library for CodeIgniter
*
* Author:      Jeff Madsen
*              jrmadsen67@gmail.com
*              http://www.codebyjeff.com
*
* Location:    will be on github shortly
*
* Description: CI library for linking to application's existing user table and
*              creating basis of an internal messaging system. No views or controllers
*              included.
*
*              DO CHECK the README.txt for setup instructions and notes!
*
*/

class Meritus
{
	protected $postURL = "https://webservice.paymentxp.com/wh/webhost.aspx";
	
    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function addAccount($data) {
		$response	= $this->makeRequest($data);
		
		if(isset($response['CustomerID']) && $response['CustomerID']) {
			return array('success'	=> 1, 'CustomerID'	=> $response['CustomerID']);
		} else {
			return array('success'	=> 0, 'Message'	=> $response['Message']);
		}
	}
	
	public function makeCredit($CustomerID, $MerchantID, $MerchantKey, $amount) {
		
		$postArray	= array(
			'Amount'			=> $amount,
			'CustomerID'		=> $CustomerID,
			'Description'		=> 'Payed commission for sales.',
			'MerchantID'		=> $MerchantID,
			'MerchantKey'		=> $MerchantKey,
			'ProcessDate'		=> date('mdY'),
			'TransactionType'	=> 'AddCustomerACHCredit'
		);
		
		$response	= $this->makeRequest($postArray);
		if(isset($response['TransactionID']) && $response['TransactionID']) {
			return array('success'	=> 1, 'TransactionID'	=> $response['TransactionID']);
		} else {
			return array('success'	=> 0, 'Message'	=> $response['Message']);
		}
	}
	
	private function makeRequest($postArray) {
		//Generate post String
        $postString = "";
        foreach( $postArray as $key => $value )
        { 
            $postString .= "$key=" . urlencode( $value ) . "&"; 
        }
        $postString = rtrim( $postString, "& " );

        // This sample code uses the CURL library for php to establish an HTTP POST
        // To find out if Curl is enabled. Include code below on your page. Then searh for the word Curl.
        $request = curl_init($this->postURL); // Initiate
        curl_setopt($request, CURLOPT_HEADER, 0);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_POSTFIELDS, $postString); //HTTP POST
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
        $post_response = curl_exec($request); // Execute
        curl_close ($request); // Close

		$response	= [];
		foreach(explode('&', $post_response) as $data) {
			$params	= explode('=', $data);
			if(isset($params[1])) {
				$response[$params[0]]	= $params[1];
			} else {
				$response[$params[0]]	= '';
			}
		}
		
		return $response;
	}
}

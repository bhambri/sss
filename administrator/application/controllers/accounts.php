<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends VCI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->user	= $this->session->userdata('user');
		$this->load->library('meritus');
		$this->load->model('consultant_model');
		$this->load->model('settings_model');
		$this->_vci_layout('menu-toolbar');
	}
	
	function add()
	{
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Accounts' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		
		$view_data['meritusEnabled']		= true;
		$settings	=  $this->db->get_where('settings', array('user_id' => $this->user['store_id'], 'role_id' => 2))->row_array();
		if(!$settings['mp_merchant_id'] || !$settings['mp_merchant_key']) {
			$view_data['meritusEnabled']		= false;
			$view_data['meritusMessage']		= 'Store merchant does not enabled this feature yet.';
		} else {
			if($this->input->post('submit')) {
				if($this->input->post('AccountName') && $this->input->post('AccountNumber') && $this->input->post('RoutingNumber')
					&& $this->input->post('BankAccountType') && $this->input->post('BankName')) {
					$postArray = array(
						"TransactionType" 	=> "AddCustomer",
						"MerchantID" 		=> $settings['mp_merchant_id'],
						"MerchantKey" 		=> $settings['mp_merchant_key'],
						
						"CustomerID" 		=> strtoupper($this->user['controller'] . $this->user['id'] . rand()),
						"CustomerName" 		=> $this->user['name'],

						"AccountName"		=> $this->input->post('AccountName'),
						"AccountNumber"		=> $this->input->post('AccountNumber'),
						"RoutingNumber"		=> $this->input->post('RoutingNumber'),
						"BankAccountType"	=> $this->input->post('BankAccountType'),
						"BankName"			=> $this->input->post('BankName'),
						
						'Email'				=> $this->user['email'],
						"FirstName" 		=> $this->user['name']
					);
					
					$response	= $this->meritus->addAccount($postArray);

					if(isset($response['success'])) {
						$this->db->where('id', $this->user['id']);
						$this->db->update('users', ['meritus_customer_id' => $response['CustomerID']]);
						$this->session->set_flashdata('success', 'Account has been added successfully.');
					} else {
						$this->session->set_flashdata('errors', ($response['Message'])?($response['Message']):('Error while adding the account. Kindly try again.'));
					}
				} else {
					$this->session->set_flashdata('errors', 'Kindly specify all the mandatory fields.');
				}
				redirect('/accounts/add', 'refresh');
			}

			$this->user	=  $this->db->get_where('users', array('id' => $this->user['id']))->row_array();
			$view_data['CustomerID']	= $this->user['meritus_customer_id'];
		}
		$view_data['caption']		= 'Add Account';
		$this->_vci_view('accounts/add', $view_data);
	}
}
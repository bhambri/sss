<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Transactions extends VCI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('transaction_model');
		$this->load->model('sales_model');
		$user	= $this->session->userdata('user');
		
		switch($user['controller']) {
			case 'client':
				$this->user_id	= 0;
				$this->store_id	= $user['id'];
				break;
			case 'consultant':
				$this->user_id	= $user['id'];
				$this->store_id	= $user['store_id'];
				break;
		}
		$this->_vci_layout('menu-toolbar');
	}
	
	function listing($last_record_number = 0)
	{
		if( $this->session->userdata('consultant_user_id')> 0 )
		{
			$this->user_id = $this->session->userdata('consultant_user_id');
		}
		
		$startdate	= '';
		if($this->input->get('from_date')){
			$startdate = $this->input->get('from_date');
			$view_data['fromdate'] = $startdate ;
		}
		
		$enddate	= '';
		if($this->input->get('to_date')){
			$enddate = $this->input->get('to_date');
			$view_data['todate'] = $enddate ;
		}
		
		$view_data['caption']		= 'Transactions';
		$view_data['transactions']	= $this->transaction_model->getList($this->store_id, $this->user_id, $last_record_number, 'desc', $startdate, $enddate);
		
		if(!$this->user_id) {
			$view_data['consultant'] 	= $this->sales_model->get_all_consultant_from_current_store($this->store_id, $this->user_id, $startdate, $enddate);
		}
		$this->load->library('pagination');

		$config	= [
			'base_url' 	=> base_url() . 'transactions/listing/',
			'total_rows'=> $this->transaction_model->getCount($this->store_id, $this->user_id, $startdate, $enddate),
			'per_page'	=> PAGE_LIMIT,
		];

		$this->pagination->initialize($config); 

		$view_data['pagination']	= $this->pagination->create_links();
		
		$this->_vci_view('transactions/listing', $view_data);
	}
}
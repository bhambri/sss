<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:			Commission_order_model extends Model defined in Core libraries
*	Author:			Cogniter
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	Manage database functionality for Users. 
---------------------------------------------------------------
*/

class Commission_order_model extends VCI_Model {
	
	
	/**
	 * Get all executives
	 */
	function get_all_data( $page, $per_page = 10, $count=false, $store_id )
	{
		$this->db->select('users.username, commision_order.*');
		$this->db->from('commision_order');
		$this->db->join('users', 'users.id = commision_order.consultant_user_id', 'left');
		$this->db->where(array('commision_order.store_id'=>$store_id));
		$this->db->order_by("commision_order.id", "desc");
		
		if($count)
		{	
			$result = $this->db->get();
		//	echo $this->db->last_query();die;
			return count($result->result());
		}
		else
		{
			$this->db->limit($per_page, $page);
			$result = $this->db->get();
			
			if(count($result->result()) > 0)
			{
				return $result->result();
			} else
			{
				return false;
			}
		}
	}

	function get_all_data_report($page,$per_page = 10,$count=false,$store_id,$datefr="" , $dateto="")
	{
	
		
		$consultant_id = '';
		if( $this->session->userdata('consultant_user_id')> 0 )
		{
			$consultant_id = $this->session->userdata('consultant_user_id');
		}
		/// code to change

		$this->db->select('users.username, commision_order.*');
		$this->db->from('commision_order');
		$this->db->join('users', 'users.id = commision_order.consultant_user_id', 'left');
		$this->db->where(array('commision_order.store_id'=>$store_id));
		$this->db->order_by("commision_order.id", "desc");

		if($this->session->userdata('consultant_include_paid') != 1 ){
			$this->db->where(array('commision_order.pay_status' => 0 ));
		}

		/// code to change ends now 
		if( isset($consultant_id) && $consultant_id>0 )
			{
				$this->db->where(array('commision_order.consultant_user_id'=>$consultant_id ));
			}
		
		if($datefr !=""){
			$startdate = date('Y-m-d',$datefr) ;
			$this->db->where(array('DATE(commision_order.created) >= '=> $startdate ));
		}
		
		if($dateto !=""){
			$enddate = date('Y-m-d',$dateto) ;
			$this->db->where(array('DATE(commision_order.created) <= '=> $enddate ));
		}
		
		if($count)
		{
			$sales_report = $this->db->get();
			//echo $this->db->last_query();
			//die;
			return count($sales_report->result());
		}
		else
		{
			$this->db->order_by("commision_order.id", "desc");
			$this->db->limit($per_page,$page);
			
			$sales_report = $this->db->get();
			if(count($sales_report->result()) > 0)
			{
				return $sales_report->result();
				
			} else
			{
				return false;
			}
		}
	}

	function get_all_data_reportsum($store_id,$datefr="" , $dateto="")
	{
	
		$consultant_id = '';
		if( $this->session->userdata('consultant_user_id')> 0 )
		{
			$consultant_id = $this->session->userdata('consultant_user_id');
		}

		/// code to change

		$this->db->select('SUM(commision_order.commision_amount) as sum_commision_amount');
		$this->db->from('commision_order');
		$this->db->join('users', 'users.id = commision_order.consultant_user_id', 'left');
		$this->db->where(array('commision_order.store_id'=>$store_id));
		

		if($this->session->userdata('consultant_include_paid') != 1 ){
			$this->db->where(array('commision_order.pay_status' => 0 ));
		}

		/// code to change ends now 
		if( isset($consultant_id) && $consultant_id>0 )
			{
				$this->db->where(array('commision_order.consultant_user_id'=>$consultant_id ));
			}
		
		if($datefr !=""){
			$startdate = date('Y-m-d',$datefr) ;
			$this->db->where(array('DATE(commision_order.created) >= '=> $startdate ));
		}
		
		if($dateto !=""){
			$enddate = date('Y-m-d',$dateto) ;
			$this->db->where(array('DATE(commision_order.created) <= '=> $enddate ));
		}
		
		$sales_report = $this->db->get();
		if(count($sales_report->result()) > 0)
		{
			return $sales_report->result_array();
			
		} else
		{
			return false;
		}

	}

	function markstatuspaid($markstatuspaid ){
		$this->db->where_in('id', $this->input->post('commission_orderid'));
		$data = array('pay_status'=>$markstatuspaid ) ;
		if($this->db->update('commision_order',$data)){
			return TRUE;
		}
		else{
			  return FALSE;
		}
		
	}

	function changestatus($cid ,$markstatuspaid){

		$this->db->where('id',$cid);

		$data = array('pay_status'=>$markstatuspaid ) ;
		if($this->db->update('commision_order',$data)){
			return TRUE;
		}
		else{
			  return FALSE;
		} 
	}

}
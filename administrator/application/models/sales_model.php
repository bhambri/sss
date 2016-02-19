<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_model extends VCI_Model {
	
	function get_all_sales_report($page,$per_page = 10,$count=false,$store_id,$datefr="" , $dateto="")
	{
	
		$consultant_id = '';
		if( $this->session->userdata('consultant_user_id')> 0 )
		{
			$consultant_id = $this->session->userdata('consultant_user_id');
		}
		
		$this->db->select('order.*, users.name');
		$this->db->from('order');
		$this->db->join('users', 'users.id = order.user_id');
		$this->db->where(array('order.store_id'=> $store_id ));
		
		if( isset($consultant_id) && $consultant_id>0 )
			{
				$this->db->where(array('order.consultant_user_id'=>$consultant_id ));
			}
		
		if($datefr !=""){
			$startdate = date('Y-m-d',$datefr) ;
			$this->db->where(array('DATE(order.created_time) >= '=> $startdate ));
		}
		
		if($dateto !=""){
			$enddate = date('Y-m-d',$dateto) ;
			$this->db->where(array('DATE(order.created_time) <= '=> $enddate ));
		}
		
		if($count)
		{
			$sales_report = $this->db->get();
		
			return count($sales_report->result());
		}
		else
		{
			$this->db->order_by("order.id", "desc");
			$this->db->limit($per_page,$page);
			
			$sales_report = $this->db->get();
			//echo $this->db->last_query();
			//die;
			if(count($sales_report->result()) > 0)
			{
				return $sales_report->result();
				
			} else
			{
				return false;
			}
		}
	}

	
	function get_all_sales_report_sum( $count=false, $store_id, $datefr="" ,$dateto="" )
	{
		$consultant_id = '';
		if( $this->session->userdata('consultant_user_id')> 0 )
		{
			$consultant_id = $this->session->userdata('consultant_user_id');
		}
		
		$this->db->select('SUM(order.order_amount) as sum_order_amount, SUM(order.tax) as sum_tax, SUM(order.shipping) as sum_shipping');
		$this->db->from('order');
		$this->db->join('users', 'users.id = order.user_id');
		$this->db->where(array('order.store_id'=> $store_id ));
		
		if( isset($consultant_id) && $consultant_id>0 )
			{
				$this->db->where(array('order.consultant_user_id'=>$consultant_id ));
			}
		
		if($datefr !=""){
			$startdate = date('Y-m-d',$datefr) ;
			$this->db->where(array('DATE(order.created_time) >= '=> $startdate ));
		}
		
		if($dateto !=""){
			$enddate = date('Y-m-d',$dateto) ;
			$this->db->where(array('DATE(order.created_time) <= '=> $enddate ));
		}
		
		if($count)
		{
			$this->db->where(array('order.order_status'=> 1 )); // only sum of successfull orders, please note listing contains all data		
			$sales_report = $this->db->get();
			//echo $this->db->last_query() ;
			if(count($sales_report->result()) > 0)
			{
				/* echo '<pre>';
				print_r($sales_report->result());
				die;
				*/				
				return $sales_report->result();
			} 
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	
		if( $count )
		{
		// basically it returns a sum of order amount and tax and shipping seperatly
			$query = $this->db->query( $qry );
			return $query->result();
		}
		else
		{
			return false;
		}
	}
		
		
	/*
	 getting all sales data from a particular store
	*/

	function get_groouppurchase($group_code=''){
		ini_set('display_errors', '0');
		
		$this->db->select('grouppurchase.*') ;
		$this->db->from('grouppurchase') ;
		$this->db->where(array('grouppurchase.id'=> $group_code)) ;
		$groupcode = $this->db->get() ;
		$groupcodedata = $groupcode->result() ;
		return $groupcodedata ;
	}

	function get_grouppurchase_sales_report($page,$per_page = 10,$count=false,$store_id,$group_code='',$datefr="" , $dateto="")
	{
	
		// query based on code of group
		$grouppurchaseres = $this->get_groouppurchase($group_code) ;
		
		if(!empty($grouppurchaseres)){
			$groupcode = $grouppurchaseres[0]->group_event_code ;
		}
		#die;
		$this->db->select('order.*, users.name , users.username');
		$this->db->select('order.*');
		$this->db->from('order');
		$this->db->join('users', 'users.id = order.user_id');
		$this->db->where(array('order.store_id'=> $store_id ));
		
		
		if( isset($group_code) && $group_code!="")
		{
			$this->db->where(array('order.group_purchase_code'=>$groupcode ));
		}
		

		if($datefr !=""){
			$startdate = date('Y-m-d',$datefr) ;
			$this->db->where(array('DATE(order.created_time) >= '=> $startdate ));
		}
		
		if($dateto !=""){
			$enddate = date('Y-m-d',$dateto) ;
			$this->db->where(array('DATE(order.created_time) <= '=> $enddate ));
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
			$this->db->order_by("order.id", "desc");
			$this->db->limit($per_page,$page);
			
			$sales_report = $this->db->get();
			//echo $this->db->last_query();
			//die;
			if(count($sales_report->result()) > 0)
			{
				return $sales_report->result();
				
			} else
			{
				return false;
			}
		}
	}

	function get_grouppurchase_sales_report_sum($page,$per_page = 10,$count=false,$store_id,$group_code='',$datefr="" , $dateto="")
	{
	
		// query based on code of group
		$grouppurchaseres = $this->get_groouppurchase($group_code) ;
		
		if(!empty($grouppurchaseres)){
			$groupcode = $grouppurchaseres[0]->group_event_code ;
		}
		#die;
		//$this->db->select('order.*, users.name , users.username');
		//$this->db->select('order.*');
		$this->db->select('SUM(order.order_amount) as sum_order_amount, SUM(order.tax) as sum_tax, SUM(order.shipping) as sum_shipping');
		$this->db->from('order');
		$this->db->join('users', 'users.id = order.user_id');
		$this->db->where(array('order.store_id'=> $store_id ));
		
		
		if( isset($group_code) && $group_code!="")
		{
			$this->db->where(array('order.group_purchase_code'=>$groupcode ));
		}
		

		if($datefr !=""){
			$startdate = date('Y-m-d',$datefr) ;
			$this->db->where(array('DATE(order.created_time) >= '=> $startdate ));
		}
		
		if($dateto !=""){
			$enddate = date('Y-m-d',$dateto) ;
			$this->db->where(array('DATE(order.created_time) <= '=> $enddate ));
		}
		
		if($count)
		{
			$this->db->where(array('order.order_status'=>1)) ;			
			$sales_report = $this->db->get();
			return $sales_report->result() ;
			/* echo $this->db->last_query();
			echo '<pre>' ;
			print_r($sales_report->result());
			*/
			//die;
			//return count($sales_report->result());
		}
		else
		{
					
			$this->db->order_by("order.id", "desc");
			$this->db->limit($per_page,$page);
			
			$sales_report = $this->db->get();
			//echo $this->db->last_query();
			//die;
			if(count($sales_report->result()) > 0)
			{
				return $sales_report->result();
				
			} else
			{
				return false;
			}
		}
	}

	
	function get_all_consultant_from_current_store($store_id)
	{
	    $this->db->from('users');
	    $this->db->order_by('username ASC');
		
		$this->db->where(array( 'store_id'=>$store_id ));
		$this->db->where(array( 'role_id'=>4 ));
		
		$content	= $this->db->get();
		#echo $this->db->last_query();
		
		if ( count($content->row()) > 0 )
		{
			#print_r($content->result()) ;
			return $content->result();
		}
		else
		{
			return false;
		}
	}

	function get_topx_sales_report($page,$per_page = 10,$count=false,$store_id,$consultant_id ,$datefr="" , $dateto="")
	{
		$this->db->select('order.*, users.name');
		$this->db->from('order');
		$this->db->join('users', 'users.id = order.user_id');
		$this->db->where(array('order.store_id'=> $store_id ));
		
		if( isset($consultant_id) && $consultant_id>0 )
			{
				$this->db->where(array('order.consultant_user_id'=>$consultant_id ));
			}
		
		if($datefr !=""){
			$startdate = date('Y-m-d',$datefr) ;
			$this->db->where(array('DATE(order.created_time) >= '=> $startdate ));
		}
		
		if($dateto !=""){
			$enddate = date('Y-m-d',$dateto) ;
			$this->db->where(array('DATE(order.created_time) <= '=> $enddate ));
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
			$this->db->order_by("order.order_amount", "desc");
			$this->db->limit($per_page,$page);
			
			$sales_report = $this->db->get();
			//echo $this->db->last_query();
			//die;
			if(count($sales_report->result()) > 0)
			{
				return $sales_report->result();
				
			} else
			{
				return false;
			}
		}
	}
	
	function get_topx_sales_report_sum( $count=false, $store_id, $consultant_id , $datefr="" , $dateto="" )
	{
		$this->db->select('SUM(order.order_amount) as sum_order_amount, SUM(order.tax) as sum_tax, SUM(order.shipping) as sum_shipping');
		$this->db->from('order');
		$this->db->join('users', 'users.id = order.user_id');
		$this->db->where(array('order.store_id'=> $store_id ));
	
		if( isset($consultant_id) && $consultant_id>0 )
		{
			$this->db->where(array('order.consultant_user_id'=>$consultant_id ));
		}
	
		if($datefr !=""){
			$startdate = date('Y-m-d',$datefr) ;
			$this->db->where(array('DATE(order.created_time) >= '=> $startdate ));
		}
	
		if($dateto !=""){
			$enddate = date('Y-m-d',$dateto) ;
			$this->db->where(array('DATE(order.created_time) <= '=> $enddate ));
		}
	
		if($count)
		{
			$this->db->where(array('order.order_status'=> 1 ));
			$sales_report = $this->db->get();
			if(count($sales_report->result()) > 0)
			{
				return $sales_report->result();
			
			} else
			{
				return false;
			}
		}
		else
		{	return false;
		}
	}	

}	// class file end here

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:			Content_model extends Model defined in Core libraries
*	Author: 		
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	Manage database functionality for content. 
---------------------------------------------------------------
*/
class Grouppurchase_model extends VCI_Model {
	
	
	function getgroupevent_detail($group_id){
		$this->db->select(array('users.username', 'grouppurchase.*'));		
		$this->db->from('grouppurchase');
		
		$this->db->join('users', 'grouppurchase.host_id = users.id','left');
		$this->db->order_by("grouppurchase.id", "desc");
		$this->db->where("grouppurchase.id", $group_id);
		$category = $this->db->get();
		if(count($category->result()) > 0)
		{				
			return $category->result_array();
		} else
		{
			return false;
		}
	}
	/**
	*********************************************************************
	*	Function Name :	update() .
	*	Functionality : To update the page
	*	@param 		  : id integer
	*********************************************************************
	**/
	
	function get_all_group($page, $per_page = 10,$count=false, $store_id=null, $consultantId=null )
	{
		$this->db->select(array('users.username', 'grouppurchase.*'));		
		$this->db->from('grouppurchase');
		
		$this->db->join('users', 'grouppurchase.host_id = users.id','left');
		$this->db->order_by("grouppurchase.id", "desc");
		//$this->db->limit($per_page, $page);

		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('grouppurchase.name',trim($like));
		}

		if( !empty( $store_id ) )
 	       {
 	           $this->db->where( array( 'grouppurchase.store_id'=>$store_id ) );
 	       }
 	       //echo $consultantId;
		if( !empty( $consultantId ) )
		{
				$this->db->where( 'grouppurchase.consultant_id', $consultantId);
		}

		if($count)
		{
			$category = $this->db->get(); // just filtering data without applying limit

			return count($category->result());
		}
		else
		{
			$this->db->limit($per_page,$page); // filter data with limit option now
			$category = $this->db->get();
			if(count($category->result()) > 0)
			{				
				return $category->result();
			} else
			{
				return false;
			}
		}
	}

	
	function get_all_group_report($page, $per_page = 10,$count=false, $store_id=null, $consultantId=null ,$datefr="" , $dateto="")
	{
		$this->db->select(array('users.username', 'grouppurchase.*'));		
		$this->db->from('grouppurchase');
		
		$this->db->join('users', 'grouppurchase.host_id = users.id','left');
		$this->db->order_by("grouppurchase.id", "desc");
		//$this->db->limit($per_page, $page);

		// if($datefr !=""){
			// $startdate = date('Y-m-d',$datefr) ;
			// $this->db->where(array('DATE(STR_TO_DATE(grouppurchase.start_date,"%m/%d/%Y")) >= '=> $startdate ));
		// }
		
		// if($dateto !=""){
			// $enddate = date('Y-m-d',$dateto) ;
			// // STR_TO_DATE('12/31/2011', '%m/%d/%Y')
			// $this->db->where(array('DATE(STR_TO_DATE(grouppurchase.end_date,"%m/%d/%Y")) <= '=> $enddate ));
		// }

		// if(strlen($this->input->get_post('s')) > 0)
		// {
			// $like = $this->input->get_post('s');
			// $this->db->or_like('grouppurchase.name',trim($like));
		// }

		if( !empty( $store_id ) )
 	       {
 	           $this->db->where( array( 'grouppurchase.store_id'=>$store_id ) );
 	       }
 	       //echo $consultantId;
		if( !empty( $consultantId ) )
		{
				$this->db->where( 'grouppurchase.consultant_id', $consultantId);
		}

		if($count)
		{
			$category = $this->db->get(); // just filtering data without applying limit

			return count($category->result());
		}
		else
		{
			$this->db->limit($per_page,$page); // filter data with limit option now
			$category = $this->db->get();
			
			if(count($category->result()) > 0)
			{				
				return $category->result();
			} else
			{
				return false;
			}
		}
	}
	
	
}

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:			Executives_model extends Model defined in Core libraries
*	Author:			Cogniter
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	Manage database functionality for Users. 
---------------------------------------------------------------
*/

class Offers_model extends VCI_Model {
	
	
	/**
	 *********************************************************************
	 *	Function Name :	get_executive_level_details() .
	 *	Functionality : gets user details based on id
	 *	@param 		  : id integer
	 *********************************************************************
	 **/
	function get_offers_details($id = null)
	{
		$result = $this->db->get_where('offers',array('id'=>$id));
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;
	}
	
	/**
	 * update executive levels
	 */
	function update_offers( $id = '', $data = '', $table = 'offers' )
	{
		if ( empty( $id ) || empty( $data ) )
		{
			return false;
		}
	
		$this->db->where( 'id', $id );
		if ($this->db->update( $table, $data ) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	/**
	 * Get all executives
	 */
	function get_all_offers( $page, $per_page = 10, $count=false, $store_id )
	{
		$this->db->from('offers');
		$this->db->where(array('store_id'=>$store_id));
		$this->db->order_by("id", "desc");
		
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

	/**
	 * executive_add
	 */
	function offers_add( $data = null )
	{
		if ( empty( $data ) )
			return false;
		 
		$this->db->insert('offers', $data);
		if($this->db->insert_id() > 0) {
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	
	}
	
	/**
	 * Deletes executives levels from database
	 */
	function delete_offers()
	{
		$this->db->where_in('id', $this->input->post('offerids'));
		if($this->db->delete('offers'))
			return TRUE;
		else
			return FALSE;
	}
}

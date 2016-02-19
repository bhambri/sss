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

class Front_blocks_model extends VCI_Model {
	
	
	/**
	 *********************************************************************
	 *	Function Name :	get_executive_level_details() .
	 *	Functionality : gets user details based on id
	 *	@param 		  : id integer
	 *********************************************************************
	 **/
	function get_front_blocks_details($id = null)
	{
		$result = $this->db->get_where('front_blocks',array('id'=>$id));
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;
	}
	
	/**
	 * update executive levels
	 */
	function update_front_blocks( $id = '', $data = '', $table = 'front_blocks' )
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
	function get_all_blocks( $page, $per_page = 10, $count=false, $store_id )
	{
		$this->db->from('front_blocks');
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
	function front_block_add( $data = null )
	{
		if ( empty( $data ) )
			return false;
		 
		$this->db->insert('front_blocks', $data);
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
	function delete_front_blocks()
	{
		$this->db->where_in('id', $this->input->post('blockids'));
		if($this->db->delete('front_blocks'))
			return TRUE;
		else
			return FALSE;
	}

	
	/**
	*********************************************************************
	*	Function Name :	is_executive_level_exists() .
	*	Functionality : check same level with same store exist
	*	@param 		  : executive_level string
	*	@param 		  : id and store_id integer
	*********************************************************************
	**/
	function is_executive_level_exists($executive_level, $store_id, $id = null)
	{
		if(!empty($id))
			$this->db->where(array('executive_level'=>$executive_level, 'store_id'=>$store_id, 'id !=' => $id));
		else
			$this->db->where(array('executive_level'=>$executive_level, 'store_id'=>$store_id));

		$this->db->from('executive_levels');
		$levels = $this->db->count_all_results();
	//	echo $this->db->last_query();die;
		if($levels > 0)
		{
			$this->form_validation->set_message('is_executive_level_exists', "This executive level is already exist, Please enter another name of executive level.");
			return true;
		}
		else
			return false;
	}
}

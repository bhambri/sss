<?php
/*
---------------------------------------------------------------
*	Class:	Contact_model extends Model defined in Core libraries
*	Author: Jaidev Bangar
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:	Manage database functionality to category. 
---------------------------------------------------------------
*/

class Template_model extends CI_Model{

	
	/**
	 *********************************************************************
	 *	Function Name :	get_all_users() .
	 *	Functionality : Gets all users
	 *	@param 		  : page integer
	 *	@param 		  : per_page integer
	 * 	@param 		  : count integer
	 *********************************************************************
	 **/
	function get_all_templates($page, $per_page = 10,$count=false)
	{
		$this->db->from('email_templates');
	
		if($count)
		{
			$users = $this->db->get();
			return count($users->result());
		}
		else
		{
			$this->db->order_by("id", "desc");
			$this->db->limit($per_page,$page);
				
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
	
	function get_template_details( $id )
	{
		$this->db->from('email_templates');
		$this->db->where(array('id'=> $id ));
		$result = $this->db->get();
		if(count($result->result()) > 0)
		{
			return $result->result();
		} else
		{
			return false;
		}
	}
	
	/**
	 * update email template
	 */
	function update_template( $id = '', $data = '', $table = 'email_templates' )
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
}

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:		Content_model extends Model defined in Core libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:for area section operations
---------------------------------------------------------------
*/

class Content_model extends CI_Model {
	
	/**
     * method  get_content_page
     * Description function for for getting conetent page
     * on basis of id
     * @param id integer
     */
	function get_content_page($id = null)
	{
		if(is_null($id)) {
			return false;			
		} else {
			$result = $this->db->get_where('content',array('id'=>$id));
		}
		
		if ( count($result->row()) > 0 )
		{
			return $result->row();
		}
		else{
			return false;
		}
	}

}
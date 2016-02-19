<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:			Content_model extends Model defined in Core libraries
*	Author: 		Jaidev Bangar
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	Manage database functionality for content. 
---------------------------------------------------------------
*/
class Content_model extends CI_Model {
	
	/**
	*********************************************************************
	*	Function Name :	update() .
	*	Functionality : To update the page
	*	@param 		  : id integer
	*********************************************************************
	**/
	function update($id = null) {
		if(is_null($id)) {
			return false;
		}

		$data = array(
				'page_title' => ($this->input->post('page_title',true)),
				'page_name' => ($this->input->post('page_name',true)),
				'page_content' => $this->input->post('page_content',true),
				'page_metakeywords' => ($this->input->post('page_metakeywords',true)),
				'page_metadesc' => ($this->input->post('page_metadesc',true)),
				'page_metatitle' => ($this->input->post('page_metatitle',true)),
				'status' => ($this->input->post('status',true))
		);
		
		$this->db->where('id', $id);
		$this->db->update('content', $data);
		return true;
		
	}
	
	/* 
	 * return all clients for banners
	 */
	function get_all_clients()
	{
	    $this->db->from('clients');
	    $this->db->where('status', 1);
        $states = $this->db->get();
	    return $states->result();
	}
	
	
	/**
	*********************************************************************
	*	Function Name :	get_content_page() .
	*	Functionality : Gets a content page based on ID
	*	@param 		  : id integer
	*********************************************************************
	**/
	function get_content_page($id = null, $store_id = null )
	{
		if(is_null($id)) {
			return false;			
		} else {
			$result = $this->db->get_where('content',array('id'=>$id));
		}
		
		if( isset( $store_id ) && !empty( $store_id ) )
		{
		    $this->db->where('store_id', $store_id);
		}
		
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;

	}
	
	/**
	*********************************************************************
	*	Function Name :	get_content() .
	*	Functionality : Gets all contents
	*	@param 		  : page integer
	*   @param 		  : per_page integer
	*   @param 		  : count integer
	*********************************************************************
	**/
	function get_content($page, $per_page = 10, $count = false , $store_id = null) {
		
		$this->db->from('content');

		$qstr = $this->input->get('s');

		if($count === true) {
			if(strlen($qstr) > 0) {
			    $like = array('page_name' => $qstr ,'page_title' => $qstr); 
			    $this->db->or_like($like);
			}
			$total = $this->db->count_all_results();
			return $total;
		}
        if( isset( $store_id ) )
        {
            $this->db->where(array('store_id'=>$store_id));
        }
        
		$this->db->order_by("id", "desc");
		$this->db->limit($per_page, $page);

		if(strlen($qstr) > 0) {
			$like = array('page_name' => $qstr, 'page_title' => $qstr);
			$this->db->or_like($like);
		}

		$content = $this->db->get();
		
		if(count($content->result()) > 0)
		{
			return $content->result();
		} else
		{
			return false;
		}
	}

	/**
	*********************************************************************
	*	Function Name :	update_status() .
	*	Functionality : updates status of content page active/inactive
	*	@param 		  : page integer
	*   @param 		  : per_page integer
	*   @param 		  : count integer
	*********************************************************************
	**/
	function update_status($id = null, $status = 0)
	{
		$this->db->where(array('id'=>$id));
		$this->db->update('content', array('status'=>$status));
		return true;
	}
	
	function is_content_editable( $store_id = null, $id = null )
	{
	    
	    if( !empty( $store_id ) && !empty( $id ) )
	    {
	                        
		$result = $this->db->get_where('content',array('id'=>$id));
		$this->db->where('store_id', $store_id);
		
		//echo '<pre>';print_r( $result->row()->store_id );die;
		
		if ( count($result->row()) > 0  && $result->row()->store_id == $store_id  )
			//return $result->row()->;
			return true;
		else
			return false;
	    }
	    
	}	
}
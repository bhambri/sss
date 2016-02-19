<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:	storelinks_model extends Model defined in Core libraries
*	Author: 
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:	Manage database functionality for content. 
---------------------------------------------------------------
*/
class Storelinks_model extends CI_Model {
	
	/**
	*********************************************************************
	*	Function Name :	add storelinks() .
	*	Functionality : for adding storelinks there
	*	@param 		  : page integer
	*	@param 		  : perpage integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function add($filepath = '' ){
        if($this->input->post('formSubmitted') > 0){
        	
        	$data = array(
				'title' => htmlspecialchars($this->input->post('title',true)),
				'image' => $filepath,
				'link' => $this->input->post('link',true),
				'status' => htmlspecialchars($this->input->post('status',true)),
				'created' => htmlspecialchars($this->input->post('created',true)),
				'modified' => htmlspecialchars($this->input->post('modified',true)),
			);
			
        	$this->db->insert('storelinks', $data);
			if($this->db->insert_id() > 0)
			{
				return $this->db->insert_id();
			}else
			{
				return false;
			}
        }else{
        	return false ;
        }
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
	*	Function Name :	update() .
	*	Functionality : for Updating storelinks contents	
	*	@param 		  : id integer
	*	@param 		  : filepath string
	*********************************************************************
	**/
	function update($id = null, $filepath= '') {
		
		if(is_null($id)) {
			return false;
		}

		$data = array(
				'title' => htmlspecialchars($this->input->post('title',true)),
				'image' => $filepath,
				'link' => $this->input->post('link',true),
				'status' => htmlspecialchars($this->input->post('status',true)),
				'modified' => htmlspecialchars($this->input->post('modified',true)),
				
		);

		$this->db->where('id', $id);
		$this->db->update('storelinks', $data);
		return true;
		
	}
	
	/**
	*********************************************************************
	*	Function Name :	get_storelinks_page() .
	*	Functionality : Gets a content page based on ID
	*	@param 		  : id integer
	*********************************************************************
	**/
	function get_storelinks_page($id = null)
	{
		if(is_null($id)) {
			return false;			
		} else {
			$result = $this->db->get_where('storelinks',array('id'=>$id));
		}
		
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;

	}
	
	/**
	*********************************************************************
	*	Function Name :	get_storelinks()
	*	Functionality : gets storelinks list
	*	@param 		  : page integer
	*	@param 		  : per_page integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function get_storelinks($page, $per_page = 10, $count = false, $store_id = null ) {
		$qstr = $this->input->get('s') ;
		$this->db->from('storelinks');
		if($count === true) {
			if(strlen($qstr) > 0) {
			$like = array('page_title' => $qstr, 'page_shortdesc' => $qstr	);
			$this->db->or_like($like);
			}
			$total = $this->db->count_all_results();
			return $total;
		}
        
		/*
        if( isset( $store_id ) )
        {
           $this->db->where('store_id', $store_id );    
        } 
        */
		$this->db->order_by("id", "desc");
		$this->db->limit($per_page, $page);
		
		
		if(strlen($qstr) > 0) {
			$like = array('page_title' => $qstr, 'page_shortdesc' => $qstr);
			$this->db->or_like($like);
		}

		$content = $this->db->get();
		//echo $this->db->last_query(); 
		
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
	*	Function Name :	update_status()
	*	Functionality : updates status of content page active/inactive
	*	@param 		  : id integer
	*	@param 		  : status 0 or 1  integer
	*********************************************************************
	**/
	function update_status($id = null, $status = 0)
	{
	    $this->db->where(array('id'=>$id));
		$this->db->update('storelinks', array('status'=>$status));
		return true;
	}

	/**
	*********************************************************************
	*	Function Name :	delete_storelinks()
	*	Functionality : for deleting storelinks
	*	@param 		  : none
	*********************************************************************
	**/
	function delete_storelinks(){
		$this->db->where_in('id', $this->input->post('pageids'));
	    $this->db->delete('storelinks');
		return $this->db->affected_rows();
	}

	/**
	*********************************************************************
	*	Function Name :	remove_image()
	*	Functionality : for removing image
	*	@param 		  : id integer
	*********************************************************************
	**/
	function remove_image($id){
		$this->db->where(array('id'=>$id));
		$this->db->update('storelinks', array('page_thumbnailpath'=>''));
		return true;
	}
	
	/**
	*********************************************************************
	*	Function Name :	count_storelinks()
	*	Functionality : for counting
	*	@param 		  : id integer
	*********************************************************************
	**/
	function count_storelinks(){
		$total = $this->db->count_all('storelinks');
		return $total;
	}

}
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:	banners_model extends Model defined in Core libraries
*	Author: 
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:	Manage database functionality for content. 
---------------------------------------------------------------
*/
class Banners_model extends VCI_Model {
	
	/**
	*********************************************************************
	*	Function Name :	add banners() .
	*	Functionality : for adding banners there
	*	@param 		  : page integer
	*	@param 		  : perpage integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function add($filepath = '', $store_id = null, $consultantId=null ){
        if($this->input->post('formSubmitted') > 0){
        	
        	if(trim($store_id)==trim($consultantId))
        	{
        		$consultantId = 0;
        	}
        	
        	$data = array(
        	    'store_id' => $store_id,
        	    'user_id' => $consultantId,
				'title' => htmlspecialchars($this->input->post('title',true)),
				'image' => $filepath,
				'link' => $this->input->post('link',true),
				'status' => htmlspecialchars($this->input->post('status',true)),
				'created' => date("Y-m-d h:i:s"),
				'modified' => date("Y-m-d h:i:s"),
			);
			
        	$this->db->insert('banners', $data);
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

	/**
	*********************************************************************
	*	Function Name :	update() .
	*	Functionality : for Updating banners contents	
	*	@param 		  : id integer
	*	@param 		  : filepath string
	*********************************************************************
	**/
	function update($id = null, $filepath= '') {
		
		if(is_null($id)) {
			return false;
		}

		if( !empty($_FILES['image']['name']) )
		{
			$data = array(
					'title' => htmlspecialchars($this->input->post('title',true)),
					'image' => $filepath,
					'link' => $this->input->post('link',true),
					'status' => htmlspecialchars($this->input->post('status',true)),
					'modified' => date("Y-m-d h:i:s"),
			
			);
		}
		else
		{
			$data = array(
					'title' => htmlspecialchars($this->input->post('title',true)),
					'link' => $this->input->post('link',true),
					'status' => htmlspecialchars($this->input->post('status',true)),
					'modified' => date("Y-m-d h:i:s"),
			);
		}
		$this->db->where('id', $id);
		$this->db->update('banners', $data);
		return true;
		
	}
	
	/**
	*********************************************************************
	*	Function Name :	get_banners_page() .
	*	Functionality : Gets a content page based on ID
	*	@param 		  : id integer
	*********************************************************************
	**/
	function get_banners_page($id = null)
	{
		if(is_null($id)) {
			return false;			
		} else {
			$result = $this->db->get_where('banners',array('id'=>$id));
		}
		
		if ( count($result->row()) > 0 )
		{
			return $result->row();
		}
		else
		{
			return false;
		}

	}
	
	/**
	*********************************************************************
	*	Function Name :	get_banners()
	*	Functionality : gets banners list
	*	@param 		  : page integer
	*	@param 		  : per_page integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function get_banners($page, $per_page = 10, $count = false, $store_id = null, $consultantId=null ) {
		$qstr = $this->input->get('s') ;
		$this->db->from('banners');
		
        if( isset( $store_id ) )
        {
            $this->db->where( array( 'store_id'=>$store_id ) );
        }
        
        if( isset( $consultantId ) )
        {
			$this->db->where( array( 'user_id'=>$consultantId) );
        }
        
        if($count === true) {
			if(strlen($qstr) > 0) {
				$like = array('page_title' => $qstr, 'page_shortdesc' => $qstr	);
				$this->db->or_like($like);
			}
			$total = $this->db->count_all_results();
			return $total;
		}

		if(strlen($qstr) > 0) {
			$like = array('page_title' => $qstr, 'page_shortdesc' => $qstr);
			$this->db->or_like($like);
		}

		$this->db->order_by("id", "desc");
		$this->db->limit($per_page, $page);

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
	*	Function Name :	update_status()
	*	Functionality : updates status of content page active/inactive
	*	@param 		  : id integer
	*	@param 		  : status 0 or 1  integer
	*********************************************************************
	**/
	function update_status($id = null, $status = 0)
	{
	    //echo 'model --->'.$status;die;
		$this->db->where(array('id'=>$id));
		$this->db->update('banners', array('status'=>$status));
		return true;
	}

	/**
	*********************************************************************
	*	Function Name :	delete_banners()
	*	Functionality : for deleting banners
	*	@param 		  : none
	*********************************************************************
	**/
	function delete_banners(){
		$this->db->where_in('id', $this->input->post('pageids'));
	    $this->db->delete('banners');
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
		$this->db->update('banners', array('page_thumbnailpath'=>''));
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
	*	Function Name :	count_banners()
	*	Functionality : for counting
	*	@param 		  : id integer
	*********************************************************************
	**/
	function count_banners(){
		$total = $this->db->count_all('banners');
		return $total;
	}

    /**
	*********************************************************************
	*	Function Name :	is_content_editable()
	*	Functionality : To check the banner is editable by client
	*	@param 		  :  store_id, id integer
	*********************************************************************
	**/
    function is_content_editable( $store_id = null, $id = null )
	{
	    
	    if( !empty( $store_id ) && !empty( $id ) )
	    {
	                        
		$result = $this->db->get_where('banners',array('id'=>$id));
		$this->db->where('store_id', $store_id);
		
		if ( count($result->row()) > 0  && $result->row()->store_id == $store_id  )
		{
			//return $result->row()->;
			return true;
		}
		else{
			return false;
		}
	    }
	    
	}
}
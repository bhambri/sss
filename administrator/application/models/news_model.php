<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:	News_model extends Model defined in Core libraries
*	Author: 
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:	Manage database functionality for content. 
---------------------------------------------------------------
*/
class News_model extends VCI_Model {
	
	/**
	*********************************************************************
	*	Function Name :	add news() .
	*	Functionality : for adding news there
	*	@param 		  : page integer
	*	@param 		  : perpage integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function add($filepath = '', $store_id = null, $user_id=null )
	{
        if($this->input->post('formSubmitted') > 0)
        {
        	
        	$data = array(
        	    'store_id'   => $store_id,
        	    'user_id' 	=> $user_id,
				'page_title' => htmlspecialchars($this->input->post('page_title',true)),
				'page_shortdesc' => htmlspecialchars($this->input->post('page_shortdesc',true)),
				'page_content' => $this->input->post('page_content',true),
				'page_metakeywords' => htmlspecialchars($this->input->post('page_metakeywords',true)),
				'page_metadesc' => htmlspecialchars($this->input->post('page_metadesc',true)),
				'page_metatitle' => htmlspecialchars($this->input->post('page_metatitle',true)),
				'page_thumbnailpath' => $filepath ,
			);
			
        	$this->db->insert('news', $data);
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
	*	Functionality : for Updating news contents	
	*	@param 		  : id integer
	*	@param 		  : filepath string
	*********************************************************************
	**/
	function update($id = null, $filepath= '') {
		
		if(is_null($id)) {
			return false;
		}

		$data = array(
				'page_title' => htmlspecialchars($this->input->post('page_title',true)),
				'page_shortdesc' => htmlspecialchars($this->input->post('page_shortdesc',true)),
				'page_content' => $this->input->post('page_content',true),
				'page_metakeywords' => htmlspecialchars($this->input->post('page_metakeywords',true)),
				'page_metadesc' => htmlspecialchars($this->input->post('page_metadesc',true)),
				'page_metatitle' => htmlspecialchars($this->input->post('page_metatitle',true)),
				'page_thumbnailpath' => $filepath ,
		);

		$this->db->where('id', $id);
		$this->db->update('news', $data);
		return true;
		
	}
	
	/**
	*********************************************************************
	*	Function Name :	get_news_page() .
	*	Functionality : Gets a content page based on ID
	*	@param 		  : id integer
	*********************************************************************
	**/
	function get_news_page($id = null)
	{
		if(is_null($id)) {
			return false;			
		} else {
			$result = $this->db->get_where('news',array('id'=>$id));
		}
		
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;

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
	*	Function Name :	get_news()
	*	Functionality : gets news list
	*	@param 		  : page integer
	*	@param 		  : per_page integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function get_news( $page, $per_page = 10, $count = false, $store_id = null, $consultantId=null ) {
		$qstr = $this->input->get('s');
		$this->db->from('news');
		
        if( isset( $store_id ) )
        {
            $this->db->where( array( 'store_id'=>$store_id) );
        }
        if( isset( $consultantId ) && !empty( $consultantId ) )
        {
			$this->db->where( array( 'user_id'=>$consultantId) );
        }

		
		
		if(strlen($qstr) > 0) {
			$like = array('page_title' => $qstr, 'page_shortdesc' => $qstr);
			$this->db->or_like($like);
		}

		if($count === true) {
			if(strlen($qstr) > 0) {
			$like = array('page_title' => $qstr, 'page_shortdesc' => $qstr	);
			$this->db->or_like($like);
			}
			$total = $this->db->count_all_results();
			return $total;
		}
		
		$this->db->order_by("id", "desc");
		$this->db->limit($per_page, $page);

		$content = $this->db->get();
		
		//echo $this->db->last_query();
		//die;

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
		$this->db->update('news', array('status'=>$status));
		return true;
	}

	/**
	*********************************************************************
	*	Function Name :	delete_news()
	*	Functionality : for deleting news
	*	@param 		  : none
	*********************************************************************
	**/
	function delete_news(){
	//	print_r($this->input->post('pageids')); die;
		$this->db->where_in('id', $this->input->post('pageids'));
	    $this->db->delete('news');

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
		$this->db->update('news', array('page_thumbnailpath'=>''));
		return true;
	}
	
	/**
	*********************************************************************
	*	Function Name :	count_news()
	*	Functionality : for counting
	*	@param 		  : id integer
	*********************************************************************
	**/
	function count_news(){
		$total = $this->db->count_all('news');
		return $total;
	}


	function count_news_admin(){
		$this->db->from('news');
		$result = $this->db->where(array('store_id'=>0,'user_id'=>0));
		$result = $result->get() ;	
		$total = $result->num_rows() ;
		return $total;
	}

	function count_news_store($sid){
		$this->db->from('news');
		$result = $this->db->where(array('store_id'=>$sid));
		$result = $result->get() ;	
		
		$total = $result->num_rows() ;
		return $total;
	}

	function count_news_consultant($cid,$storeid){
		$this->db->from('news');
		$result = $this->db->where(array('store_id'=>$storeid,'user_id'=>$cid));
		$result = $result->get() ;	
		
		$total = $result->num_rows() ;
		return $total;
	}

}
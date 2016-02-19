<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*Class:			Area_model extends Model defined in Core libraries
*Author:    	
*Platform:		Codeigniter
*Company:		Cogniter Technologies
*Description:	For area section operations
---------------------------------------------------------------
*/

class Area_model extends CI_Model {
	
	/**
     * method  get_area_listdata
     * Description function fetching city- area  lists
     * @param none
     */
    function get_area_listdata(){
		$this->db->from('area');
		$this->db->where('status', 1);
		$this->db->order_by("name", "ASC");
		$this->db->select('id, name');
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
     * method  get_area_page
     * Description function fetching city details data
     * on basis of id
     * @param id integer
     */
	function get_area_page($id = null)
	{
		if(is_null($id)) {
			return false;			
		} else {
			$result = $this->db->get_where('area',array('id'=>$id,'status'=>1));
		}
		
		if ( count($result->row()) > 0 )
		{
			return $result->row();
		}
		else{
			return false;
		}

	}

	/**
     * method  get_area_pagebyname
     * Description getting area page by name
     * on basis of id
     * @param id (string)
     */
	function get_area_pagebyname($id = null)
	{
		if(is_null($id)) 
		{
			return false;			
		}else{
			$result = $this->db->get_where('area',array('LOWER(name)'=>$id,'status'=>1));
		}
		
		if ( count($result->row()) > 0 )
		{
			return $result->row();
		}
		else{
			return false;
		}
	}
	
	/**
     * method  get_area listing
     * Description function listing area
     * on basis of id
     * @param page integer
     * @param per_page integer
     * @param count integer
     */
	function get_area($page, $per_page = 10, $count = false) {

		if($count === true) {
			$total = $this->db->count_all('area');
			return $total;
		}

		$this->db->from('area');
		$this->db->order_by("id", "desc");
		$this->db->limit($per_page, $page);

		if(strlen($this->input->get_post('s')) > 0) {
			$like = array('name' => $this->input->get_post('s'));
			$this->db->or_like($like);
		}

		$content = $this->db->get();
		
		if(count($content->result()) > 0)
		{
			return $content->result();
		}else
		{
			return false;
		}
	}
}
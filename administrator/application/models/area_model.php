<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:		Area_model extends Model defined in Core libraries
*	Author: 	Abhishek Sr.
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description: for area section operations
---------------------------------------------------------------
*/
class Area_model extends CI_Model {
	
	/**
	*********************************************************************
	*	Function Name :	add
	*	Functionality : add area city
	* 	param 		  : none
	*********************************************************************
	**/
	function add()
	{
		$data = array(
				'name' => htmlspecialchars($this->input->post('name',true)),
				'page_content' => $this->input->post('page_content',true),
				'page_metakeywords' => htmlspecialchars($this->input->post('page_metakeywords',true)),
				'page_metadesc' => htmlspecialchars($this->input->post('page_metadesc',true)),
				'status' => 1
		);
				
		
		$this->db->insert('area', $data);
		if($this->db->insert_id() > 0)
		{
			return $this->db->insert_id();
		} else
		{
			return false;
		}	
	}

	/*
	* form validation for unique name
		of city
	*/
	function is_name_exists($name, $id = null)
	{
		echo 'Abhishek';die;
		if(!empty($id)){
			$this->db->where(array('name'=>$name, 'id !=' => $id));
		}
		else{
			$this->db->where(array('name'=>$name));
		}

		$this->db->from('area');
		$users = $this->db->count_all_results();

		if($users > 0)
		{
			$this->form_validation->set_message('is_name_exists', "The %s <b>$name</b> is already exists.");
			return true;
		}
		else{
			return false;
		}
	}

	/**
	*********************************************************************
	*	Function Name :	update
	*	Functionality : Updates area city
	* 	param 		  : none
	*********************************************************************
	**/
	function update($id = null) {
		
		if(is_null($id)) {
			return false;
		}

		$data = array(
				'name' => htmlspecialchars($this->input->post('name',true)),
				'page_content' => $this->input->post('page_content',true),
				'page_metakeywords' => htmlspecialchars($this->input->post('page_metakeywords',true)),
				'page_metadesc' => htmlspecialchars($this->input->post('page_metadesc',true)),
				'status' => htmlspecialchars($this->input->post('status',true))
		);
		
		$this->db->where('id', $id);
		$this->db->update('area', $data);
		return true;	
	}
	
	/**
	*********************************************************************
	*	Function Name :	get_area_page
	*	Functionality : Gets a area page based on ID
	* 	param 		  : id integer
	*********************************************************************
	**/
	function get_area_page($id = null)
	{
		if(is_null($id)) {
			return false;			
		} else {
			$result = $this->db->get_where('area',array('id'=>$id));
		}
		
		if ( count($result->row()) > 0 ){
			return $result->row();
		}
		else{
			return false;
		}
	}
	
	/**
	*********************************************************************
	*	Function Name :	get_area
	*	Functionality : Gets a area page listing
	* 	param 		  : page integer
	* 	param 		  : per_page integer
	* 	param 		  : count integer
	*********************************************************************
	**/
	function get_area($page, $per_page = 10, $count = false) {
		$qstr = $this->input->get('s') ;

		$this->db->from('area');
		if($count === true) {
			if(strlen($qstr) > 0) {
			$like = array('name' => $qstr ); 
			$this->db->or_like($like);
			}
			$total = $this->db->count_all_results();
			return $total;
		}
		
		$this->db->order_by("id", "desc");
		$this->db->limit($per_page, $page);

		
		if(strlen($qstr) > 0) {
			$like = array('name' =>$qstr );
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
	*	Function Name :	update_status
	*	Functionality : updates status of content page active/inactive
	* 	param 		  : id integer
	* 	param 		  : status 0 or 1  integer
	*********************************************************************
	**/
	function update_status($id = null, $status = 0)
	{
		$this->db->where(array('id'=>$id));
		$this->db->update('area', array('status'=>$status));
		return true;
	}

	/**
	*********************************************************************
	*	Function Name :	delete_area
	*	Functionality : deletes an existing area
	* 	param 		  : none
	*********************************************************************
	**/
	function delete_area()
	{
		$this->db->where_in('id', $this->input->post('pageids'));
		if($this->db->delete('area'))
		{
			return TRUE;
		}
		else{
		    return FALSE;
		}
		
	}

	/**
	*********************************************************************
	*	Function Name :	count_area
	*	Functionality : for counting
	* 	param 		  : none
	*********************************************************************
	**/
	function count_area(){
		return 33;
		$total = $this->db->count_all('area');
		return $total;
	}

}
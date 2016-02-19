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

class Contact_model extends CI_Model{

	/**
	*********************************************************************
	*	Function Name :	get_contact() .
	*	Functionality : To Get Conatct List Of Contact us Form .
	*	@param 		  : page integer
	*	@param 		  : perpage integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function get_contact($page, $per_page = 10, $count = false, $store_id=null) {
		
		$qstr = $this->input->get('s') ;
		
		if($count == true){
			$this->db->from('contact');
			$this->db->where('contact_type','C');
			if(strlen($qstr) > 0) {
				$likenew = "(name LIKE "."'%".$qstr."%'"." OR email LIKE "."'%".$qstr."%')";
				$this->db->where($likenew);
			}
			if( isset( $store_id ) )
			{
			    $this->db->where("store_id", $store_id );   
			}

			$total = $this->db->count_all_results();
			return $total;
		}

		$this->db->from('contact');
		$this->db->where('contact_type','C');
		if( isset( $store_id ) )
		{
		    $this->db->where("store_id", $store_id );   
		}
		$this->db->order_by("id", "desc");
		$this->db->limit($per_page,$page);
		

		if(strlen($qstr) > 0) {	
			$likenew = "(name LIKE "."'%".$qstr."%'"." OR email LIKE "."'%".$qstr."%')";
			$this->db->where($likenew);
		}

		$contact = $this->db->get();
		
		if(count($contact->result()) > 0)
		{
		  return $contact->result();
		} else
		{
			return false;
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
	*	Function Name :	get_enquiry() .
	*	Functionality : To Get Enquiery List Of received through request submitted.
	*	@param 		  : page integer
	*	@param 		  : perpage integer
	*	@param 		  : count integer
	*********************************************************************
	**/	
	function get_enquiry($page, $per_page = 10, $count = false) {
		$qstr = $this->input->get('s') ;
		if($count == true){
			$this->db->from('contact');
			$this->db->where('contact_type','E');
			if(strlen($qstr) > 0) {
				$likenew = "(name LIKE "."'%".$qstr."%'"." OR email LIKE "."'%".$qstr."%')";
				$this->db->where($likenew);
			}
			
			$total = $this->db->count_all_results();
			return $total;
		}

		$this->db->from('contact');
		$this->db->where('contact_type','E');
		$this->db->order_by("id", "desc");
		$this->db->limit($per_page,$page);
		
		if(strlen($qstr) > 0) {
			$likenew = "(name LIKE "."'%".$qstr."%'"." OR email LIKE "."'%".$qstr."%')";
			$this->db->where($likenew);
		}

		$contact = $this->db->get();
		
		if(count($contact->result()) > 0)
		{
			return $contact->result();
		} else
		{
			return false;
		}
	}

	/*
	******************************************************************
	** method : get_contact_page
	** @usage : To Get Content Of Contact us Form To Display .
	** @param : id integer
	**
	******************************************************************
	*/

	function get_contact_page($id = null, $store_id = null)
	{
		if(is_null($id)) {
			return false;			
		} else {
			//$result = $this->db->get_where('contact',array('id'=>$id) );
			$this->db->from('contact');
			$this->db->where('id',$id);
		}
		
		if( !empty( $store_id ) )
		{
		    $this->db->where("store_id", $store_id );
		}
		
		$result = $this->db->get();				
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;
	}

	/**
	*********************************************************************
	**	Method : delete_contact .
	**	@Action: Delete Contact Infromation From Database .
	**  @called: Called Fron Contact Controller .
	**********************************************************************
	*/
	function delete_contact()
	{
		$this->db->where_in('id', $this->input->post('pageids'));
		$this->db->delete('contact');
		return $this->db->affected_rows();
	}

	/**
	*********************************************************************
	**	Method  : count_contact .
	**	@purpose: counting contacts.
	**********************************************************************
	*/
	function count_contact(){
		return 3;
		//$this->db->where('contact_type','C');
		//$total = $this->db->count_all('contact');
		return $total;
	}
	
	function count_contact_admin(){
		
		//$this->db->where('contact_type','C');
		//$total = $this->db->count_all('contact');
		
		$this->db->from('contact');
		$result = $this->db->where(array('store_id'=>0));
		$result = $result->get() ;	
		$total = $result->num_rows() ;
		return $total;
	}

	function count_contact_store($sid){
		
		//$this->db->where('contact_type','C');
		//$total = $this->db->count_all('contact');
		
		$this->db->from('contact');
		$result = $this->db->where(array('store_id'=>$sid));
		$result = $result->get() ;	
		$total = $result->num_rows() ;
		return $total;
	}

	function count_contact_consultant($cid,$storeid){
		
		//$this->db->where('contact_type','C');
		//$total = $this->db->count_all('contact');
		
		$this->db->from('contact');
		$result = $this->db->where(array('store_id'=>$sid));
		$result = $result->get() ;	
		$total = $result->num_rows() ;
		return $total;
	}

}

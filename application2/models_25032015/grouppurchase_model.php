<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:			Grouppurchase_model extends Model defined in Core libraries
*	Author: 		
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	Manage database functionality for content. 
---------------------------------------------------------------
*/
class Grouppurchase_model extends VCI_Model {
	
	/**
	*********************************************************************
	*	Function Name :	update() .
	*	Functionality : To update the page
	*	@param 		  : id integer
	*********************************************************************
	**/
	function get_all_group($page, $per_page = 10,$count=false, $store_id=null, $consultantId=null )
	{
		/*
		if( empty( $consultantId ) )
		{
			return false;
		}
		*/

		$this->db->from('grouppurchase');
		$this->db->order_by("id", "desc");
		//$this->db->limit($per_page, $page);

		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('name',trim($like));
		}

		if( !empty( $store_id ) )
        {
            $this->db->where( array( 'store_id'=>$store_id ) );
        }
        //echo $consultantId;
        if( !empty( $consultantId ) )
        {
			$this->db->where( 'consultant_id', $consultantId);
        }

		if($count)
		{
			$category = $this->db->get(); // just filtering data without applying limit

			return count($category->result());
		}
		else
		{
			$this->db->limit($per_page,$page); // filter data with limit option now
			$category = $this->db->get();
			if(count($category->result()) > 0)
			{				
				return $category->result();
			} else
			{
				return array();
			}
		}
	}

	/**
     * method  get_grouppurcahse_by_id
     * Description geting group purchase corresponding to an id
     * @param nane
     */
	function get_grouppurcahse_by_id($groupid=''){
		if($groupid){
			$this->db->from('grouppurchase') ;
			$this->db->where('id',$groupid) ;
			
			$groupDetail = $this->db->get() ;

			if(count($groupDetail->result()) > 0 ){
				return  $groupDetail->result() ;
			}else{
				return array() ;
			}	
		}else{
			return array() ;
		}
	}	
}
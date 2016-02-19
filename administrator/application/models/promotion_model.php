<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:	Couponrule_model extends Model defined in Core libraries
*	Author: 
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:	Manage database functionality for content. 
---------------------------------------------------------------
*/
class Promotion_model extends CI_Model {
	
	/**
	*********************************************************************
	*	Function Name :	add coupons() .
	*	Functionality : for adding coupons there
	*	@param 		  : page integer
	*	@param 		  : perpage integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function add( $store_id = null ){
		
        if($this->input->post('formSubmitted') > 0)
        {
        	$data = array(
        	    'executive_level_id' => $this->input->post('exe_type'),
        	    'store_id'    => $store_id,
				'binaryvol_range_from'  => $this->input->post('binaryvol_range_from'),
				'binaryvol_range_to'    => $this->input->post('binaryvol_range_to'),
				'min_ppv'  => $this->input->post('min_ppv'),
				'min_pcv'  => $this->input->post('min_pcv'),
				'created'           => date( "Y-m-d h:i:s" ),
				'modified'          => date( "Y-m-d h:i:s" ),
			);
			
        	$this->db->insert('promotion_rules', $data);
			if($this->db->insert_id() > 0)
			{
				return $this->db->insert_id();
			}else
			{
				return false;
			}
        }
        else
        {
        	return false ;
        }
	}
    
    /*
     * fetch all the coupons type
     */
     function get_all_coupon_types()
     {
        $this->db->from('coupontypes');
	    $this->db->where('status', 1);
        $coupon_types = $this->db->get();
	    return $coupon_types->result();  
     }
    
	/**
	*********************************************************************
	*	Function Name :	update() .
	*	Functionality : for Updating coupons contents	
	*	@param 		  : id integer
	*	@param 		  : filepath string
	*********************************************************************
	**/
	function update($id = null , $store_id=null) {
		
		if(is_null($id)) {
			return false;
		}
		/*
		$data = array(
                'coupon_type'      => htmlspecialchars( $this->input->post('coupon_type',true ) ),
				'amount' => $this->input->post('discount_percent',true),
				'range_from'       => htmlspecialchars($this->input->post('range_from',true)),
				'range_to'         => htmlspecialchars($this->input->post('range_to',true)),
				'status'           => htmlspecialchars($this->input->post('status',true)),
				'modified'         => date("Y-m-d h:i:s"),
		); */
		$data = array(
        	    'executive_level_id' => $this->input->post('exe_type'),
        	    'store_id'    => $store_id,
				'binaryvol_range_from'  => $this->input->post('binaryvol_range_from'),
				'binaryvol_range_to'    => $this->input->post('binaryvol_range_to'),
				'min_ppv'  => $this->input->post('min_ppv'),
				'min_pcv'  => $this->input->post('min_pcv'),
				'modified'          => date( "Y-m-d h:i:s" ),
			);

        //echo '<pre>';print_r($data);die;
		$this->db->where( 'id', $id );
		if( isset( $store_id ) )
		{
		    $this->db->where( 'store_id', $store_id );		    
		}
		
		$this->db->update( 'promotion_rules', $data );
		//echo $this->db->last_query();die;
		return true;
		
	}
	
	/**
	*********************************************************************
	*	Function Name :	get_coupons_page() .
	*	Functionality : Gets a content page based on ID
	*	@param 		  : id integer
	*********************************************************************
	**/
	function get_coupons_page($id = null)
	{
		if(is_null($id)) {
			return false;			
		} else {
			$result = $this->db->get_where('promotion_rules',array('id'=>$id));
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
	*	Function Name :	get_coupons()
	*	Functionality : gets coupons list
	*	@param 		  : page integer
	*	@param 		  : per_page integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function get_promotionrule($page, $per_page = 10, $count = false, $store_id=null) {
		$qstr = $this->input->get('s') ;
		$this->db->from('promotion_rules');
		
		if( isset( $store_id ) )
		{
			$this->db->where('store_id', $store_id );
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
		$this->db->update('promotion_rules', array('status'=>$status));
		return true;
	}

	/**
	*********************************************************************
	*	Function Name :	delete_coupons()
	*	Functionality : for deleting coupons
	*	@param 		  : none
	*********************************************************************
	**/
	function delete_prule(){
		$this->db->where_in('id', $this->input->post('pageids'));
	    $this->db->delete('promotion_rules');
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
		$this->db->update('coupons', array('page_thumbnailpath'=>''));
		return true;
	}
	
	/**
	*********************************************************************
	*	Function Name :	count_coupons()
	*	Functionality : for counting
	*	@param 		  : id integer
	*********************************************************************
	**/
	function count_coupons(){
		$total = $this->db->count_all('coupons');
		return $total;
	}

	function get_all_executives( $store_id )
	{
		error_reporting(1);		
		$this->db->from('executive_levels');
		$this->db->where(array('store_id'=>$store_id));
		$this->db->order_by("executive_level", "asc");
		
		$executives = $this->db->get();
			
		if(count($executives->result()) > 0)
		{
			return $executives->result();
		} else
		{
			return false;
		}
	}

}

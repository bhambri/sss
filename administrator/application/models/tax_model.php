<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:	Tax_model extends Model defined in Core libraries
*	Author: 
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:	Manage database functionality for content. 
---------------------------------------------------------------
*/
class Tax_model extends CI_Model {
	
	/**
	*********************************************************************
	*	Function Name :	add shipping() .
	*	Functionality : for adding shipping there
	*	@param 		  : page integer
	*	@param 		  : perpage integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function add( $store_id ){
        if($this->input->post('formSubmitted') > 0){
        	
        	$data = array(
        			'state_code'  => htmlspecialchars($this->input->post('state_code', true)),
        			'store_id'    => $store_id,
        			'tax'         => htmlspecialchars($this->input->post('tax', true)),
        			'created'     => date("Y-m-d h:i:s")
        	);
			
        	$this->db->insert('tax_costs', $data);
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

    function get_all_states()
    {
        $this->db->from('states');
        $states = $this->db->get();
	    return $states->result();
        
    }



	/**
	*********************************************************************
	*	Function Name :	update() .
	*	Functionality : for Updating shipping contents	
	*	@param 		  : id integer
	*	@param 		  : filepath string
	*********************************************************************
	**/
	function update($id = null, $store_id) {
		
		if(is_null($id)) {
			return false;
		}
		$data = array(
				'state_code'  => htmlspecialchars($this->input->post('state_code', true)),
				'store_id'    => $store_id,
				'tax'   => htmlspecialchars($this->input->post('tax', true)),
				'modified'    => date("Y-m-d h:i:s")
		);

		$this->db->where('id', $id);
		$this->db->update('tax_costs', $data);
		return true;
		
	}
	
	/**
	*********************************************************************
	*	Function Name :	get_shipping_page() .
	*	Functionality : Gets a content page based on ID
	*	@param 		  : id integer
	*********************************************************************
	**/
	function get_tax_page($id = null, $store_id)
	{
		if(is_null($id)) {
			return false;			
		} else {
			$result = $this->db->get_where('tax_costs',array('id'=>$id,'store_id'=>$store_id));
		}
		
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;

	}
	
	/**
	*********************************************************************
	*	Function Name :	get_shipping()
	*	Functionality : gets shipping list
	*	@param 		  : page integer
	*	@param 		  : per_page integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function get_shipping($page, $per_page = 10, $count = false) {
		$qstr = $this->input->get('s') ;
		$this->db->from('tax_costs');
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
		
		if(strlen($qstr) > 0) {
			$like = array('page_title' => $qstr, 'page_shortdesc' => $qstr);
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

	/*
	for getting the shipping state
	*/
	function get_shipping_state_old($page, $per_page = 10, $count = false,$qstr='',$store_id) {
		
		$this->db->from('states');
		if($count === true) {
			if(strlen($qstr) > 0) {
			$like = array('state' => $qstr, 'state_code' => $qstr	);
			$this->db->or_like($like);
			}
			$total = $this->db->count_all_results();
			return $total;
		}

		$this->db->order_by("state", "asc");
		$this->db->limit($per_page, $page);
		
		if(strlen($qstr) > 0) {
			$like = array('state' => $qstr, 'state_code' => $qstr);
			$this->db->or_like($like);
		}
		
		$this->db->where('shipping_costs.store_id', $store_id ) ;
		//$this->db->or_where('shipping_costs.store_id', Null ) ; // older part
		$this->db->or_where('states.state_code !=','' ) ;

		$this->db->group_by('states.state_code') ;
		$this->db->select('states.*,shipping_costs.id,shipping_costs.store_id,shipping_costs.w1,shipping_costs.w2,shipping_costs.w3,shipping_costs.w4,shipping_costs.w5,shipping_costs.created');

		$this->db->join('shipping_costs','states.state_code = shipping_costs.state_code','left') ;

		
		$content = $this->db->get();
		
		//pr($this->db->last_query()) ;die;
		if(count($content->result()) > 0)
		{
			return $content->result();
		} else
		{
			return false;
		}
	}

	function get_tax_state($page, $per_page = 10, $count = false,$qstr='',$store_id) {
		
		$this->db->from('states');
		if($count === true) {
			if(strlen($qstr) > 0) {
			$like = array('state' => $qstr, 'state_code' => $qstr	);
			$this->db->or_like($like);
			}
			$total = $this->db->count_all_results();
			return $total;
		}

		$this->db->order_by("state", "asc");
		$this->db->limit($per_page, $page);
		
		if(strlen($qstr) > 0) {
			$like = array('state' => $qstr, 'state_code' => $qstr);
			$this->db->or_like($like);
		}
		
		
		//$this->db->select('states.*,shipping_costs.id,shipping_costs.store_id,shipping_costs.w1,shipping_costs.w2,shipping_costs.w3,shipping_costs.w4,shipping_costs.w5,shipping_costs.created');
		$this->db->select('states.*');

		//$this->db->join('shipping_costs','states.state_code = shipping_costs.state_code','left') ;

		$content = $this->db->get();
		
		//pr($this->db->last_query()) ;die;
		if(count($content->result()) > 0)
		{
			#pr($content->result());
			#die;
			//return $content->result();
			$stateArr =  array() ;
			foreach ($content->result() as $key => $value) {
				
				$this->db->from('tax_costs');
				$this->db->where('tax_costs.state_code', $value->state_code );
				$this->db->where('tax_costs.store_id' , $store_id);
				$cn = $this->db->get();
				if(count($cn->result_array()) > 0 ){
					$costResult = $cn->result_array() ;
					//pr($costResult[0]) ;
					$arrName = array('state' => $value->state) ;
					#pr($arrName);
					$tempArr = array_merge($arrName ,$costResult[0]);
					
				    $stateArr[] = (object) $tempArr ;
				    
				}else{
					//$temp[] = array('')
					$tempArr =  array(
						'id'=>'',
						'state_code'=>$value->state_code,
						'state'=>$value->state,
						'store_id'=>$store_id,
						'tax'=>'',
						'created'=>'',
						'modified'=>'',
						) ;
					//$tempArr[] = $intArr ;
					$stateArr[] = (object) $tempArr ;
				}
			}
			//pr($stateArr);
			//die;
			return $stateArr ; 
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
		$this->db->update('tax_costs', array('status'=>$status));
		return true;
	}

	/**
	*********************************************************************
	*	Function Name :	delete_shipping()
	*	Functionality : for deleting shipping
	*	@param 		  : none
	*********************************************************************
	**/
	function delete_shipping(){
		$this->db->where_in('id', $this->input->post('pageids'));
	    $this->db->delete('tax_costs');
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
		$this->db->update('tax_costs', array('page_thumbnailpath'=>''));
		return true;
	}
	
	/**
	*********************************************************************
	*	Function Name :	count_shipping()
	*	Functionality : for counting
	*	@param 		  : id integer
	*********************************************************************
	**/
	function count_shipping(){
		$total = $this->db->count_all('tax_costs');
		return $total;
	}

}
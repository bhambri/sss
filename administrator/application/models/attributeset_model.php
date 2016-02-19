<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attributeset_model extends CI_Model {
	

	function get_attributeset_details($id)
	{
		$result = $this->db->get_where('attribute_sets',array('id'=>$id));
		if ( count($result->row()) > 0 )
		{
			return $result->row();
		}
		else{
			return false;
		}
	}

	function get_attributesetfield_detail($id)
	{
		$result = $this->db->get_where('attribute_set_fields',array('id'=>$id));
		if ( count($result->row()) > 0 )
		{
			return $result->row();
		}
		else{
			return false;
		}
	}

	function get_attributesetfield_option_detail($id){
		$result = $this->db->get_where('attribute_set_field_details',array('attribute_set_field_id'=>$id));
		if ( count($result->row()) > 0 )
		{
			return $result->result();
		}
		else{
			return false;
		}
	}

	// Adding attribute set
	function add( $data = null )
	{
	    if ( empty( $data ) ){
	        return false;
	    }
	        
		$this->db->insert('attribute_sets', $data);
		if($this->db->insert_id() > 0) {
			return $this->db->insert_id();
		}
		else {
			return false;
		}
		
	}

	// Adding attribute set option like text field,radio field label etc
	function add_option( $data = null )
	{
	    if ( empty( $data ) ){
	        return false;
	    }
	        
		$this->db->insert('attribute_set_fields', $data);
		if($this->db->insert_id() > 0) {
			return $this->db->insert_id();
		}
		else {
			return false;
		}
		
	}

	// Adding options in case of radio, select box ,checkboxes etc. 
	function add_option_details( $data = null){
		if ( empty( $data ) ){
	        return false;
	    }

		$this->db->insert('attribute_set_field_details', $data);
		if($this->db->insert_id() > 0) {
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}
    

	function update_status($id = null, $status = 0)
	{
		$this->db->where(array('id'=>$id));
		$this->db->update('attribute_sets', array('status'=>$status));
		return true;
	}


	function is_attributeset_exists($name, $id = null)
	{	
		if(!empty($id)){
			$this->db->where(array('name'=>$name, 'id !=' => $id));
		}
		else{
			$this->db->where(array('name'=>$name));
		}

		$this->db->from('attribute_sets');
		$clients = $this->db->count_all_results();

		if($clients > 0)
		{
			$this->form_validation->set_message('is_category_exists', "The %s '$name' is already exists.");
			return true;
		}
		else{
			return false;
		}
	}

    /* 
     * Gets all clients
     */
    
    function get_all_clients()
	{
	    $this->db->from('clients');
	    $this->db->where('status', 1);
        $states = $this->db->get();
	    return $states->result();
	}

	/**
     * Gets all clients
     */
	function get_all_attributeset($page, $per_page = 10,$count=false, $store_id = null)
	{
		$this->db->from('attribute_sets');
		$this->db->order_by("id", "desc");
	//	$this->db->limit($per_page, $page);

		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('name',trim($like));
		}
		
		$this->db->where(array('store_id'=> $store_id));
		
		if($count)
		{
			$category = $this->db->get();
			return count($category->result());
		}
		else
		{
			$this->db->limit($per_page, $page);
			$category = $this->db->get();
			if(count($category->result()) > 0)
			{
				return $category->result();
			} else
			{
				return false;
			}
		}
	}

	function get_all_attributeset_options($page, $per_page = 10,$count=false, $categoryId)
	{
		$this->db->from('attribute_set_fields');
		$this->db->order_by("id", "desc");
	//	$this->db->limit($per_page, $page);

		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('name',trim($like));
		}
		
		$this->db->where(array('attribute_set_id'=> $categoryId));

		if($count)
		{
			$category = $this->db->get();
			return count($category->result());
		}
		else
		{
			$this->db->limit($per_page, $page);
			$category = $this->db->get();
			if(count($category->result()) > 0)
			{
				return $category->result();
			} else
			{
				return false;
			}
		}
	}


	function get_all_attributeset_dropdown()
	{
		$this->db->select(array('id','name'));
		$this->db->from('attribute_sets');
		$this->db->where('id !=', 1); 
		$this->db->where('id !=', 11);
		$this->db->order_by("name");
		$artists = $this->db->get();
		if(count($artists->result()) > 0)
		{
			return $artists->result();
		} else
		{
			return false;
		}
	}

	function get_all_attributeset_dropdownlist($storeid)
	{
		$this->db->select(array('id','name','description'));
		$this->db->from('attribute_sets');
		$this->db->where('store_id',$storeid) ;
		$this->db->order_by("name");
		$artists = $this->db->get();
		if(count($artists->result()) > 0)
		{
			return $artists->result();
		} else
		{
			return false;
		}
	}

	function get_assigned_attributesettoproduct($productid){
		//$this->db->select(array('id','name','description'));
		$this->db->select('*');
		$this->db->from('client_product_attribute_sets');
		$this->db->where('client_product_id',$productid) ;
		#$this->db->order_by("name");
		$artists = $this->db->get();
		if(count($artists->result()) > 0)
		{
			return $artists->result();
		} else
		{
			return false;
		}	
	}
	
	/**
     * Deletes an existing client
     */
	function delete()
	{
		$this->db->where_in('id', $this->input->post('ids'));
		if($this->db->delete('attribute_sets'))
		{
			// remove the data attribute_set_fields data : TO DO
			// remove attribute_set_field_details fields data : TO DO
			return TRUE;
		}
		else{
		    return FALSE;
		}
	}

	function delete_option(){
		$this->db->where_in('id', $this->input->post('ids'));
		if($this->db->delete('attribute_set_fields'))
		{
			// remove attribute_set_field_details fields data : TO DO
			return TRUE;
		}
		else{
		    return FALSE;
		}
	}

	function delete_attribute_set_field_details($idtodel){
		$this->db->where('attribute_set_field_id', $idtodel );
		if($this->db->delete('attribute_set_field_details'))
		{
			// remove attribute_set_field_details fields data : TO DO
			return TRUE;
		}
		else{
		    return FALSE;
		}
	}

	function delete_attribute_set_field_detail_opt($idtodel){
		$this->db->where('id', $idtodel );
		if($this->db->delete('attribute_set_field_details'))
		{
			// remove attribute_set_field_details fields data : TO DO
			return TRUE;
		}
		else{
		    return FALSE;
		}
	}

	function get_attribute_set_field_details($attribute_set_field_id){
		// attribute_set_field_id
		$this->db->select(array('id'));
		$this->db->from('attribute_set_field_details');
		$this->db->where('attribute_set_field_id', $attribute_set_field_id); 
		$artists = $this->db->get();
		$valueArr =  array() ;
		if(count($artists->result()) > 0)
		{
			#return $artists->result_array();
			foreach ($artists->result_array() as $key => $value) {
				# code...
				$valueArr[] =  $value['id'] ;
			}

			return $valueArr ;
		} else
		{
			return array();
		}
	}

	function update( $id = '', $data = '', $table = 'attribute_sets' )
    {

        if ( empty( $id ) || empty( $data ) )
        {
            return false;
        }
        //print_r( $data );
        $this->db->where( 'id', $id );
        if ($this->db->update( $table, $data ) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function unassign_attributeset($attributeid,$prodid){
    	if($prodid && $attributeid){
    		$this->db->where( 'client_product_id', $prodid );
    		$this->db->where( 'attribute_set_id', $attributeid );
     
			if($this->db->delete('client_product_attribute_sets')){
				return true;
			}
			else {
				return false;
			}
    	}
    	return false ;
    }

    function assign_attributeset($attributeid,$prodid){
    	if($prodid && $attributeid){
    		$data = array(
    		'client_product_id'=>$prodid ,
			'attribute_set_id'=> $attributeid
    		) ;
     
			$this->db->insert('client_product_attribute_sets', $data);
			if($this->db->insert_id() > 0) {
				return $this->db->insert_id();
			}
			else {
				return false;
			}
    	}
    	return false ;
    }

}// class file end here
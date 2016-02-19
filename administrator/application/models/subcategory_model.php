<?php 
class Subcategory_model extends CI_Model {
	

	function get_subcategory_details($id)
	{
		$result = $this->db->get_where('subcategory',array('id'=>$id));
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;
	}



	function add( $data = null )
	{
	    if ( empty( $data ) )
	        return false;
	        
		$this->db->insert('subcategory', $data);
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
		$this->db->update('category', array('status'=>$status));
		return true;
	}


	function is_subcategory_exists($name, $id = null)
	{	
		if(!empty($id))
			$this->db->where(array('name'=>$name, 'id !=' => $id));
		else
			$this->db->where(array('name'=>$name));

		$this->db->from('subcategory');
		$clients = $this->db->count_all_results();

		if($clients > 0)
		{
			$this->form_validation->set_message('is_subcategory_exists', "The %s '$name' is already exists.");
			return true;
		}
		else
			return false;
	}




	/**
     * Gets all clients
     */
	function get_all_subcategory($page, $per_page = 10,$count=false, $categoryId)
	{
		$this->db->from('subcategory');
		$this->db->order_by("id", "desc");
	//	$this->db->limit($per_page, $page);

		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('name',trim($like));
		}
		
		$this->db->where(array('category_id'=> $categoryId));

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
	
	function get_all_category_dropdown($store_id)
	{
		$this->db->select(array('id','name'));
		$this->db->from('category');
		$this->db->where('id !=', 1); 
		$this->db->where('id !=', 11);
		$this->db->where('store_id', $store_id);
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
	function get_all_category_dropdown_edit()
	{
		$this->db->select(array('id','first_name'));
		$this->db->from('category');
		$this->db->order_by("first_name");
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
		if($this->db->delete('subcategory'))
			return TRUE;
		else
		    return FALSE;
	}

	function validate_size($tmp_name)
	{
		$imageinfo = getimagesize($tmp_name);
		$width = $imageinfo[0];
		$height = $imageinfo[1];
		
			if(($width > 210 || $width < 180) || ($height > 210 || $height < 180))
				return false;
			else
				return true;
	}

	function validate_image($image)
	{
		if($image['size'] > 2097152)
			return false;
		else if($image['type'] != 'image/jpeg' && $image['type'] != 'image/pjpeg' && $image['type'] != 'image/gif' && $image['type'] != 'image/png')	
			return false;
		else if($image['error'] != 0)
			return false;
		else	
			return true;
	}


	/**
     * Update table by the data forwarded from data
     *
     * @param integer $id
     * @param Array $data
     * @param String $table
     * @return boolean
     */
    function update( $id = '', $data = '', $table = 'clients' )
    {

        if ( empty( $id ) || empty( $data ) )
        {
            return false;
        }
        /*
        print_r( $data );
        die;
        */
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
    
    function get_current_store_detail($store_id)
    {
    	$result = $this->db->get_where('clients',array('id'=>$store_id));
    	if ( count($result->row()) > 0 )
    		return $result->row();
    	else
    		return false;
    }
    
    function get_current_category_detail($cat_id)
    {
    	$result = $this->db->get_where('category',array('id'=>$cat_id));
    	if ( count($result->row()) > 0 )
    		return $result->row();
    	else
    		return false;
    }

}	// class file end here

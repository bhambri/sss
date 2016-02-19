<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * VCI_Controller extends Controller default controller of codeigniter
 * 	overriding the default controller. provides additional 
 *	functionality for layout and views and handles unauthorized user access
 *	to admin panel and provides common functionality
 *
 *  @author Parveen Chauhan  @ Sep 19, 2014
 */
class VCI_Model extends CI_Model {

	function __construct() 
	{
		parent::__construct();
		
	}


	function add(  $table = null, $data = null )
	{
	    if ( empty( $data ) || empty( $table ) )
	    {
	        return false;
	    }
	        
		$this->db->insert( $table , $data);
		if($this->db->insert_id() > 0) {
			return $this->db->insert_id();
		}
		else {
			return false;
		}
		
	}


	function edit(  $table = null, $id = null, $data = null )
	{
	    if ( empty( $data ) || empty( $table ) || !is_numeric( $id ) )
	        return false;
	    
	    $this->db->where(array('id'=>$id));
		$this->db->update( $table, $data );
		return true;
		
	}



	function delete( $table = null, $field = null, $ids = array()  )
	{	
		if ( empty( $table ) || empty( $field ) ){
	        return false;
		}
		$this->db->where_in( $field, $ids );
		//$this->db->where_in('id', $this->input->post('ids'));
		if($this->db->delete( $table ))
			return TRUE;
		else
		    return FALSE;
	}



	/**
	*********************************************************************
	*	Function Name :	get_all() .
	*	Functionality : Gets all users 
	*	@param 		  : page integer
	*	@param 		  : per_page integer
	* 	@param 		  : count integer
	*********************************************************************
	**/
	function get_all($table, $page, $per_page = 10, $count=false, $where = array(), $search_field = null )
	{
		$this->db->from( $table );
		
		//print_r($this->input->get_post('s'));

		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('product_title',trim($like));
			$this->db->or_like('sku',trim($like));
		}

		$this->db->where( $where );
		$data = $this->db->get();
	//	echo $this->db->last_query(); die;
		if($count)
		{
			return count($data->result());
		}
		else
		{
			
			$this->db->order_by("id", "desc");
			$this->db->limit($page,$per_page);
			
			if(count($data->result()) > 0)
			{
				return $data->result();
			} else
			{
				return false;
			}
		}
	}

	
     /**
     * Find data using where clause from a table
     *
     * @param $where_data
     * @return mixed <p>Array is returned as result and FALSE in case of no
     * result found</p>
     */
	function findWhere( $table, $where_data, $multi_record = TRUE, $order = '' )
	{
        $this->db->where( $where_data );
        if ( !empty( $order ) && is_array( $order ) )
        {
            foreach( $order as $key => $value )
            {
                $this->db->order_by( $key, $value );
            }
        }

        $result = $this->db->get( $table );
        //echo $this->db->last_query(); die;
        if ( $result )
        {
            if ( $multi_record )
            {
                return $result->result_array();
            }
            else
            {
                return $result->row_array();
            }
        }
        else
        {
            return FALSE;
        }
	}

	function updateWhere( $table, $where_data, $data )
    {
        if( !empty( $table )  && is_array( $where_data ) && !empty( $where_data ) )    
        return $this->db->update( $table, $data, $where_data );
    }


	function all_clients_consultant()
	{
	    $this->db->from('clients');
	    $this->db->where('status', 1);
        $states = $this->db->get();
        //print_r( $states->result() );die;
        if( $states )
        {
        	$clients = $states->result_array();
        	foreach ($clients as $client) {
        		$this->db->from('users');
	    		$this->db->where('store_id', $client['id'] );
	    		$this->db->where('status',1);
	    		$this->db->where('role_id', 4 );
	    		$user_data = $this->db->get();
	    		$consultant = $user_data->result_array();
	    		if( $consultant )
	    		{
	    			
	    			$data[] = array( 
        			'id' 			=> $client['id'],
        			'name'  		=> $client['username'],
        			'role_id'       => $client['role_id'],
        			'consultant' 	=> $consultant
        		);
	    		}
	    		else
	    		{
	    			$data[] = array( 
        			'id' 			=> $client['id'],
        			'name'  		=> $client['username'] ,
        			'role_id'       => $client['role_id'],
        			'consultant' 	=> ''
        		);
	    		}
        		
        	}
        	return $data; die;
        	
        }

	    return false;
	}
	
}

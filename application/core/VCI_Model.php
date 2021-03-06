<?php
/*
© 2013 Training Works, LLC, and/or Training Works Solutions, Inc.  All Rights Reserved. Protected by international copyright treaty. Confidential and proprietary to Training Works, LLC, and/or Training Works Solutions, Inc. Use and access of this software is governed by the terms and conditions of the Training Works Solutions, Inc., End User License Agreement.
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Extending core model class to add custom and common methods for all Model
 * classes
 *
 */
class VCI_Model extends CI_Model
{
    var $table = '';
	/**
	 * Default constructor calling parent constructor of the CI_Model Class
	 */
	function __construct()
	{
    	parent::__construct();
	}

	/**
	 * Inserts data in table(table specified in the child class)
	 *
	 * @param mixed $data
	 * @return bool
	 */
	function insert( $table, $data )
	{
        if ( $this->db->insert( $table, $data  ) )
        {   
            #echo $this->db->last_query();
            return TRUE;
        }
        else
        {
            return FALSE;
        }
	}

	/**
	 * Inserts multiple data in table(table specified in the child class)
	 *
	 * @param mixed $data
	 * @return bool
	 */
	function insertBatch( $data )
	{
        if ( $this->db->insert_batch( $this->table, $data  ) )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
	}

	/**
	 * Find record based on id from a table and table is specified in the child
	 * classs
	 *
	 * @param int $id
	 * @return mixed<p>An array of row is returned as result and False if no
	 * result found</p>
	 */
	function findById( $record_id )
	{
	    $this->db->where( $this->table . '_id', $record_id );
        $result = $this->db->get( $this->table );
        if ( $result )
        {
            return $result->row_array();
        }
        else
        {
            return FALSE;
        }
	}

	/**
	 * Find all records from the table and table specified in the child class
	 *
	 * @return mixed <p>An array of result is return as result and False if no
	 * result found</p>
	 */
	function findAll()
	{
        $result = $this->db->get( $this->table );
        if ( $result )
        {
            return $result->result_array();
        }
        else
        {
            return FALSE;
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

    /**
     * Find records where $field is matching with $where_in_array
     *
     * @param string $field
     * @param array $where_in_array
     */
    function findWhereIn( $field, $where_in_array )
    {
        $this->db->where_in( $field, $where_in_array );
        $result = $this->db->get( $this->table );
        if ( $result->num_rows() > 0 )
        {
            return $result->result_array();
        }
        else
        {
            return false;
        }
    }

    /**
     * Find records using where id In clause
     *
     * @param array $ids
     * @return mixed/boolean
     */
    function findWhereIdIn( $ids )
    {
        $this->db->where_in( $this->table . '_id', $ids );
        $result = $this->db->get( $this->table );
        if ( $result->num_rows() > 0 )
        {
            return $result->result_array();
        }
        else
        {
            return false;
        }
    }

    /**
     * Updates table row based on $id and $data passed to function
     *
     * @param int $id<p>Unique primary key of the table</p>
     * @param mixed $data<p>Data to update in the table row</p>
     * @return bool
     */
	function update( $record_id, $data )
	{
        $this->db->where( $this->table . '_id', $record_id );
        if ( $this->db->update( $this->table, $data ) )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
	}

    /**
     * Updates table rows based on $ids and $data passed to function
     *
     * @param mixed $ids<p>Unique primary keys of the table in the form
     * array</p>
     * @param mixed $data<p>Data to update in the table row</p>
     * @return bool
     */
	function updateWhereIn( $ids, $data )
	{
        $this->db->where_in( $this->table . '_id', $ids );
        if ( $this->db->update( $this->table, $data ) )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
	}

    /**
     * Returns last insert id
     *
     * @return number
     */
    function lastId()
    {
        return $this->db->insert_id();
    }

    /**
     * Remove record from database based on id
     *
     * @param array $data
     * @return bool
     */
    function remove( $data )
    {
        $this->db->where_in( $this->table . '_id', $data );
        return $this->db->delete( $this->table );
    }

    /**
     * Remove record from database based on where clause
     *
     * @param mixed $data
     * @return bool
     */
    function removeWhere( $data )
    {
        $this->db->where( $data );
        return $this->db->delete( $this->table );
    }
    
    /**
     * Remove record from database based on ids (array)
     *
     * @param mixed $data
     * @return bool
     */
    function removeWhereIn( $field, $ids )
    {
        $this->db->where_in( $field, $ids );
        return $this->db->delete( $this->table );
    }
    
    /**
     * Get list of groups or single group
     *
     * @param integer $group_id
     */
    function getGroupsByType( $data )
    {
        $group = array();
        $cData = $data['cData'];
        if ( !empty( $data['course_id'] ) )
            $where = array(  'course_id' => $data['course_id'] );
            
        if ( !empty( $data['user_id'] ) )
            $where = array(  'user_id' => $data['user_id'] );

        if ( !empty( $data['group_id'] ) )
        {
            $where += $data['group_id'];
        }
        $this->db->where( $where );
        
        $this->db->join( 'group g', 'g.group_id = '.$data['table'].'.group_id' );
        
        $result = $this->db->get( $this->table );
        //echo $this->db->last_query();die;
        if ( $result )
        {
            if ( $data['multi_record'] )
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

        //return $group;
    }


    function updateWhere( $table, $where_data, $data )
    {
        if( !empty( $table )  && is_array( $where_data ) && !empty( $where_data ) )    
        return $this->db->update( $table, $data, $where_data );
    }
}

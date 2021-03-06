<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	client_model extends Model defined in Core libraries
 *	@autho Mandeep Singh
 */
class Client_model extends CI_Model {

    /**
     * Find data using where clause from a table
     *
     * @param $where_data
     * @return mixed <p>Array is returned as result and FALSE in case of no
     * result found</p>
     */
	function findWhere( $where_data, $multi_record = TRUE, $order = '' )
	{
        $this->db->where( $where_data );
        if ( !empty( $order ) && is_array( $order ) )
        {
            foreach( $order as $key => $value )
            {
                $this->db->order_by( $key, $value );
            }
        }

        $result = $this->db->get( 'clients' );
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
     * gets client details based on id
     */
	function get_client_details($id = null, $table = 'clients' )
	{
		if( empty( $id ) && $table == 'clients' )
		{
			$saltResult = $this->db->get_where($table,
				Array(
                    'username' => $this->input->post('clientusername'),
                    'status' => 1
				)
			);
			$salt = $saltResult->row();
			$result = $this->db->get_where('clients',
				array(
				    'username' => $this->input->post('clientusername'),
				    'password' => md5($this->input->post('clientpassword') . md5($salt->password_salt)),
					//'password' => md5($this->input->post('clientpassword')),
				    //'password' => md5($this->input->post('clientpassword') ),
				    'status' => 1
				)
				
			);
//echo $this->db->last_query();die;

			$logintime = array(
                'last_login' => date('Y-m-d h:i:s')
			);

			$this->db->where('username',$this->input->post('clientusername'));
			$this->db->where('password',md5($this->input->post('clientpassword') . md5($salt->password_salt)));
			$this->db->update('clients', $logintime);
			//echo $this->db->last_query();die;
		} 
		else
		{
			$result = $this->db->get_where($table,array('id'=>$id));
		}
		if ( count($result->row()) > 0 ){
			 //echo $result->row();die;
			return $result->row();
		}  
		else{
			return false;
		}

	}

	/**
     * register/add new client
     */
	function add( $data = null )
	{
	    if ( empty( $data ) ){
	        return false;
	    }

		$this->db->insert('clients', $data);
		if($this->db->insert_id() > 0) {
			return $this->db->insert_id();
		}
		else {
			return false;
		}	
	}

	/**
     * updates status of the client
     */
	function update_status($id = null, $status = 0, $table = 'clients')
	{
		$this->db->where(array('id'=>$id));
		$this->db->update($table, array('status'=>$status));
		return true;
	}

	/**
     * checks client exists already or not based on clientname
     */
	function is_client_exists($username, $id = null) // cogniter
	{//die("sdfs");
	//	echo "shi".$id; //die;
		if(!empty($id))
		{
		    $this->db->where(array('username'=>$username, 'id !=' => $id));
		}
		else
		{
			$this->db->where(array('username'=>$username));
        }
		$this->db->from('clients');
		$clients = $this->db->count_all_results();
		
		if( $clients > 0 )
		{
			$this->form_validation->set_message('is_client_exists', "The %s <b>$username</b> is already exists.");
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
     * checks an email already exists in databsae while registering new client
     */
	function is_email_exists($email, $id = null)
	{
		if(!empty($id)){
			$this->db->where(array('email'=>$email, 'id !=' => $id));
		}
		else{
			$this->db->where(array('email'=>$email));
		}

		$this->db->from('clients');
		$clients = $this->db->count_all_results();

		if($clients > 0)
		{
			$this->form_validation->set_message('is_email_exists', "The %s <b>$email</b> is already exists.");
			return true;
		}
		else{
			return false;
		}
	}

	/**
     * Gets all clients
     */
	function get_all_clients($page, $per_page = 10,$count=false)
	{
		$this->db->from('clients');
		

		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('email',trim($like));
			$this->db->or_like('fName',trim($like));
			$this->db->or_like('lName',trim($like));
		}

		if($count)
		{
			$clients = $this->db->get();
			return count($clients->result());
		}
		else
		{
			$this->db->order_by("username", "asc");
			$this->db->limit($per_page, $page);
			$clients = $this->db->get();

			if(count($clients->result()) > 0)
			{
				return $clients->result();
			} else
			{
				return false;
			}
		}
	}

	/**
     * Deletes an existing client
     */
	function delete_client()
	{
		$this->db->where_in('id', $this->input->post('clientids'));
		if($this->db->delete('clients')){
			return TRUE;
		}
		else{
		    return FALSE;
		}
	}
	/**
     * verify email id in case of forgot password
     */
	function verify_email()
	{
		$this->db->select('clientname,first_name,last_name,email,password_orig');
		$this->db->where('email',$this->input->post('email'));
		$this->db->where('status','1');
		$this->db->limit(1);

		$query = $this->db->get('clients');
		if($query->num_rows() > 0)
		{
			$data = $query->row_array();
			$query->free_result();
			return $data;
		}else
		{
			return false;
		}
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


	
	/**
     * count all records in given table
     *
     * @params : $table (table name)
     */
	function count_all( $table = 'clients' )
	{
		$count = $this->db->count_all_results($table);
		return $count;
	}
	
	/**
	 * Updates password of the client based on id
	 *
	 * @param integer $id
	 * @param array $data
	 */
	function update_password($id,$data)
	{	
		$role_id = $this->session->userdata('user');
		$role_id = $role_id['role_id'];
	
		$this->db->where('id',$id);
		if($role_id==4)
		{
			$table_name = 'users';
		}
		else
		{
			$table_name = 'clients';
		}
		
		if($this->db->update($table_name,$data))
		{
		//	echo $this->db->last_query();die;
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}

	function update_newpassword($id,$data,$role_id)
	{

		$this->db->where('id',$id);
		if($role_id==4)
		{
			$table_name = 'users';
		}
		else
		{
			$table_name = 'clients';
		}
		
		if($this->db->update($table_name,$data))
		{
		//	echo $this->db->last_query();die;
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
	
	/**
	 * Update store password via super admin based on id
	 *
	 * @param integer $id
	 * @param array $data
	 */
	function admin_client_update_password($id,$data)
	{
		$this->db->where('id',$id);
		$table_name = 'clients';
	
		if($this->db->update($table_name,$data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
    
    function add_client_pages($store_id)
    {
    	if ( empty( $store_id ) ){
    		return false;
    	}
    	 
    	$data = array(
    			'store_id'   => trim($store_id),
    			'page_name'  => 'Term & Conditions',
    			'page_title' => 'Term & Conditions'
    			);
    	
    	$this->db->insert('content', $data);
    	if($this->db->insert_id() > 0) {
    		return $this->db->insert_id();
    	}
    	else {
    		return false;
    	}
    }
    
    function get_current_store_detail($store_id)
    {
    	$result = $this->db->get_where('clients',array('id'=>$store_id));
    	if ( count($result->row()) > 0 ){
    		return $result->row();
    	}
    	else{
    		return false;
    	}
    }

    function get_clientdetailusing_email($store_id)
    {
    	$result = $this->db->get_where('clients',array('email'=>$store_id));
    	if ( count($result->row()) > 0 ){
    		return $result->row();
    	}
    	else{
    		return false;
    	}
    }

    function update_theme_option($id = null, $status = 0, $table = 'clients')
	{
		$this->db->where(array('id'=>$id));
		$this->db->update($table, array('is_custom_theme'=>$status));
		return true;
	}


    function getadmintheme($user_id, $role_id){
		$this->db->from('adminthemes');
		$this->db->where(array('user_id'=>$user_id ,'role_id'=>$role_id));
		$result = $this->db->get();
		if(count($result->result_array()) > 0)
		{
			return $result->result_array() ;
		}else
		{
			return array();
		}
	}

   function getclientfromurl(){

	$res = $this->get_clientdetailurl(str_ireplace('www.','',$_SERVER['SERVER_NAME'])) ;
	//echo '<pre>';	
	//print_r($res);
	return $res ;

	}

function get_clientdetailurl($username='',$sid=''){
		
		if($username)
		{
			$this->db->ar_where = array();
			$this->db->from('clients');
			$this->db->select('clients.*');
			$this->db->like(array('store_url' => $username));
			$this->db->where(array('status'=>1));
			$result = $this->db->get();
			//$result = $this->db->get_where('clients',array('store_url LIKE %'.$username.'%','status'=>1));
			
		}else{
			if($sid)
			{
				$result = $this->db->get_where('clients',array('id'=>$sid,'status'=>1));	
			}else{
				return array();	
			}
			
		}
		
		if(count($result->result_array()) > 0)
		{
			return $result->result_array() ;
		}else
		{
			return array();
		}
	}

} // class ends here

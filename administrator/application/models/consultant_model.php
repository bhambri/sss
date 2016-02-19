<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	client_model extends Model defined in Core libraries
 *	@autho Mandeep Singh
 */
class Consultant_model extends CI_Model {

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

        $result = $this->db->get( 'users' );
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
/*
	function get_details($id = null, $table = 'users' )
	{
		if( empty( $id ) && $table == 'users' )
		{
			$result = $this->db->get_where('users',
				array(
				    'username' => $this->input->post('clientusername'),
				    'password' => md5($this->input->post('clientpassword') ),
				    //'password' => md5($this->input->post('clientpassword') ),
				    'status' => 1,
				    'role_id' => 4
				)
				
			);

			if ( count($result->row()) > 0 )
			{
				return $result->row_array();
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}

	}*/
	function get_client_detailsurl( $name )
	{
		//$result = $this->db->get_where( 'clients' ,array('username' => $name ));
		$this->db->from('clients');
		$this->db->select('clients.*');
		$this->db->like(array('store_url'=>$name));
		$result = $this->db->get();
		
		if ( count($result->row()) > 0 ){
			
			return $result->row();
		}
		else
		{
			return false;
		}
	}

	/**
     * gets client details based on id
     */
	function get_details($id = null, $table = 'users' )
	{
		// echo '<pre>';
		#print_r($_SERVER);
		
		$ifo = str_replace('www.','',$_SERVER['HTTP_HOST']) ;
		$storeDetail = $this->get_client_detailsurl($ifo);

		if($ifo == 'dev.simplesalessystems.com'){
			$urltype = 1;
		}else{
			$urltype = 2;
		}
		#echo '<pre>';
		#print_r($storeDetail->id);
		#die;
		if( empty( $id ) && $table == 'users' )
		{
			
			if($urltype ==  2){
				$result = $this->db->get_where('users',
				array(
				    'username' => $this->input->post('clientusername'),
				    'password' => md5($this->input->post('clientpassword') ),
				    //'password' => md5($this->input->post('clientpassword') ),
				    'status' => 1,
				    'store_id' => $storeDetail->id,
				    'role_id' => 4
				)
				
			   );
			}else{
				$result = $this->db->get_where('users',
				array(
				    'username' => $this->input->post('clientusername'),
				    'password' => md5($this->input->post('clientpassword') ),
				    //'password' => md5($this->input->post('clientpassword') ),
				    'status' => 1,
				    'role_id' => 4
				)
				
			   );
			}

			if ( count($result->row()) > 0 )
			{
				return $result->row_array();
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}

	}
	/**
     * register/add new client
     */
	function add( $data = null )
	{
	    if ( empty( $data ) )
	        return false;
	        
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
	function update_status($id = null, $status = 0, $table = 'users')
	{
		$this->db->where(array('id'=>$id));
		$this->db->where(array('role_id'=>4));
		$this->db->update($table, array('status'=>$status));
		return true;
	}

	/**
     * checks client exists already or not based on clientname
     */
	function is_client_exists($username, $id = null) // cogniter
	{
		if(!empty($id))
		{
		    $this->db->where(array('username'=>$username, 'id =' => $id));
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
		if(!empty($id))
			$this->db->where(array('email'=>$email, 'id !=' => $id));
		else
			$this->db->where(array('email'=>$email));

		$this->db->from('clients');
		$clients = $this->db->count_all_results();

		if($clients > 0)
		{
			$this->form_validation->set_message('is_email_exists', "The %s <b>$email</b> is already exists.");
			return true;
		}
		else
			return false;
	}
	
	function is_consultant_email_exist($email, $store_id, $id = null)
	{ 
		if(!empty($id)){
			$this->db->where(array('email'=>$email, 'role_id'=>4, 'store_id'=>$store_id,  'id !=' => $id));
		}
		else{
			$this->db->where(array('email'=>$email, 'role_id'=>4, 'store_id'=>$store_id));
		}
	
		$this->db->from('users');
		$clients = $this->db->count_all_results();
	
		if($clients > 0)
		{
			$this->form_validation->set_message('is_consultant_email_exist', "The %s <b>$email</b> is already exists.");
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
		$this->db->order_by("username", "desc");
		$this->db->limit($per_page, $page);

		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('email',trim($like));
			$this->db->or_like('fName',trim($like));
			$this->db->or_like('lName',trim($like));
		}
		$clients = $this->db->get();

		if($count)
		{
			return count($clients->result());
		}
		else
		{
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
	 * Deletes an existing user
	 */
	function delete_consultant()
	{	
		$this->db->where_in('id', $this->input->post('userids'));
		if($this->db->delete('users')){
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
		$this->db->where('id',$id);
		if($this->db->update('clients',$data)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	function get_all_consultant($page, $per_page = 10,$count=false, $store_id = false, $role_id = null, $parent_consultant_id=0)
	{
	//	$user = $this->session->userdata('adminuser');
		$this->db->from('users');
		$this->db->order_by("id", "desc");
		
		$this->db->where(array('store_id'=> $store_id, 'role_id' => $role_id, 'parent_consultant_id' => $parent_consultant_id ));
	
		if($count)
		{
			$users = $this->db->get();
			return count($users->result());
		}
		else
		{
			$this->db->order_by("username", "asc");
			$this->db->limit($per_page,$page);
				
			$users = $this->db->get();
			if(count($users->result()) > 0)
			{
				return $users->result();
			} else
			{
				return false;
			}
		}
	}
	
	
	function get_all_consultant_edit($store_id = false, $role_id = null)
	{
		//	$user = $this->session->userdata('adminuser');
		$this->db->from('users');
		$this->db->where(array('store_id'=> $store_id, 'role_id' => $role_id ,'status'=>1));
		$this->db->order_by("username", "asc");
		$users = $this->db->get();
		
		if(count($users->result()) > 0)
		{
			return $users->result();
		} else
		{
			return false;
		}
	}
	
	function get_all_parent_consultant($store_id = null, $consultant_id = null)
	{
		//	$user = $this->session->userdata('adminuser');
		$this->load->model('user_model');
		$res = $this->user_model->getavailble_notparents($consultant_id, array());
		
		
		$this->db->from('users');
		$this->db->where(array('store_id'=> $store_id, 'role_id' => 4 ,'status'=>1));
		$this->db->where_not_in('id',$res);
		$this->db->order_by("username", "asc");
		$users = $this->db->get();
	
		if(count($users->result()) > 0)
		{
			return $users->result();
		} else
		{
			return false;
		}
	}
	
	
	function get_all_commission_setting($store_id)
	{
		//	$user = $this->session->userdata('adminuser');
		$this->db->from('generational_commission_setting');
		$this->db->where(array('store_id'=> $store_id));
		$comm_setting = $this->db->get();
	
		if(count($comm_setting->result()) > 0)
		{
			return $comm_setting->result();
		} else
		{
			return false;
		}
	}
	
	function check_store_exist($store_id)
	{
		$this->db->from('generational_commission_setting');
		$this->db->where(array('store_id'=> $store_id));
		$comm_setting = $this->db->get();
		
		if(count($comm_setting->result()) > 0)
		{
			return '1';
		} 
		else
		{
			return '0';
		}	
	}
	
	/**
	 * add data in commission setting
	 */
	function add_commission( $data = null )
	{
		if ( empty( $data ) )
			return false;
		 
		$this->db->insert('generational_commission_setting', $data);
		if($this->db->insert_id() > 0) {
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	
	}
	
	/**
	 * updates status of the commission
	 */
	function commission_update_status($id = null, $status = 0, $table = 'generational_commission_setting')
	{
		$this->db->where(array('id'=>$id));
		$this->db->update($table, array('status'=>$status));
		return true;
	}
	
	function update_commission( $id, $data = '' )
	{
		if ( empty( $id ) || empty( $data ) )
		{
			return false;
		}
	
		$this->db->where( 'id', $id );
		if ($this->db->update( 'generational_commission_setting', $data ) )
		{
		//	echo $this->db->last_query();die;
			return true;
		}
		else
		{
		//	echo $this->db->last_query();die;
			return false;
		}
	}
	
	function commission_findWhere( $where_data, $multi_record = TRUE, $order = '' )
	{
		$this->db->where( $where_data );
		if ( !empty( $order ) && is_array( $order ) )
		{
			foreach( $order as $key => $value )
			{
				$this->db->order_by( $key, $value );
			}
		}
	
		$result = $this->db->get( 'generational_commission_setting' );
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
	
	
	function invite_findWhere( $where_data, $multi_record = TRUE, $order = '' )
	{
		$this->db->where( $where_data );
		if ( !empty( $order ) && is_array( $order ) )
		{
			foreach( $order as $key => $value )
			{
				$this->db->order_by( $key, $value );
			}
		}
	
		$result = $this->db->get( 'invite' );
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
	 * Get all invites, which are sent by consultant
	 */
	function get_all_invites($page, $per_page = 10,$count=false, $store_id, $cons_id)
	{
		$this->db->from('invite');
		$this->db->where(array('store_id'=>$store_id));
		$this->db->where(array('consultant_id'=>$cons_id));
		$this->db->order_by("id", "desc");

		if($count)
		{	
			$invites = $this->db->get();
		//	echo $this->db->last_query();die;
			return count($invites->result());
		}
		else
		{
			$this->db->limit($per_page, $page);
			$invites = $this->db->get();
			
			if(count($invites->result()) > 0)
			{
				return $invites->result();
			} else
			{
				return false;
			}
		}
	}
	
	/**
	 * add_invite
	 */
	function add_invite( $data = null )
	{
		if ( empty( $data ) )
		{
			return false;
		}	
		$this->db->insert('invite', $data);
		if($this->db->insert_id() > 0) {
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	}
	
	/**
	 * update_invite
	 */
	function update_invite( $id = '', $data = '', $table = 'invite' )
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
	 * Deletes invites from database
	 */
	function delete_invite()
	{
		$this->db->where_in('id', $this->input->post('userids'));
		if($this->db->delete('invite'))
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * Is invite email exist in invite table and user table with role id 4
	 */
	function is_invite_email_exist($email, $cons_id)
	{
		$this->db->from('users');
		$this->db->where(array('email'=> $email));
		$this->db->where(array('role_id'=> 4));
		$invite_email = $this->db->get();
		#echo $this->db->last_query();
		
		if(count($invite_email->result()) !=  0)
		{
			return  'consultant';
			
		}
		else
		{
			$this->db->from('invite');
			$this->db->where(array('email'=> $email));
			$this->db->where(array('consultant_id'=> $cons_id));
			$invite_email2 = $this->db->get();
			if(count($invite_email2->result()) != 0)
			{
				return 'invite';
			}
			else
			{	
				$this->db->from('invite');
				$this->db->where(array('email'=> $email));
				
				$invite_email3 = $this->db->get();
				if(count($invite_email3->result()) != 0){
				  return 'invitebyother';
				}
				return true;
			}
		}
	}
	
	function get_invitation_receiver_detail( $id )
	{
		$this->db->from('invite');
		$this->db->where(array('id'=> $id));
		$invite_email = $this->db->get();
		
		if(count($invite_email->result()) > 0)
		{
			return $invite_email->result();
		}
		else
		{
			return false;
		}
	}
	
	function get_invitation_sender_detail( $id )
	{
		$this->db->from('users');
		$this->db->where(array('id'=> $id));
		$this->db->where(array('role_id'=> 4));
		$invite_email = $this->db->get();
		
		if(count($invite_email->result()) > 0)
		{
			return $invite_email->result();
		}
		else
		{
			return false;
		}
	}
	
	function get_detail_current_store( $id )
	{
		$this->db->from('clients');
		$this->db->where(array('id'=> $id));
		$result = $this->db->get();
		
		if(count($result->result()) > 0)
		{
			return $result->result();
		}
		else
		{
			return false;
		}
	}
	
	function get_all_executive_level($store_id)
	{
		$this->db->from('executive_levels');
		$this->db->where(array('store_id'=> $store_id));
		$this->db->order_by("executive_level", "ASC");
		$result = $this->db->get();
		
		if(count($result->result()) > 0)
		{
			return $result->result();
		}
		else
		{
			return false;
		}
	}

	function get_executivelvl_consultant($cond_id,$exelvl_id){
		$this->db->from('consultant_executive_levels');
		$this->db->where(array('consultant_user_id'=>$cond_id,'executive_level_id'=>$exelvl_id));
		$result = $this->db->get();
		
		if(count($result->result()) > 0)
		{
			return $result->result();
		}
		else
		{
			return false;
		}
	}
	
// updating all entries to past levels
	function update_executivelvl_consultant($cond_id){
		//$this->db->from('consultant_executive_levels');
		$data =  array('is_current_lvl'=>0) ;
		$this->db->where(array('consultant_user_id'=>$cond_id));
		$this->db->update( 'consultant_executive_levels', $data ) ;
	}

	function get_heighest_executivelvl_consultant($cond_id){
		$this->db->select(array('consultant_executive_levels.executive_level_id','consultant_executive_levels.consultant_user_id','executive_levels.*'));
		//$this->db->select('*') ;		
		$this->db->from('consultant_executive_levels');
		$this->db->where(array('consultant_executive_levels.consultant_user_id'=>$cond_id));
		$this->db->join('executive_levels', 'consultant_executive_levels.executive_level_id = executive_levels.id','left');		
  		
  		$this->db->order_by( "executive_levels.exec_order", "Desc" );
  		$this->db->limit(1,0);

		$result = $this->db->get();
		
		if(count($result->result()) > 0)
		{
			return $result->result();
		}
		else
		{
			return false;
		}
	}

	/**
	 * executive_add
	 */
	function executive_add( $data = null )
	{
		if ( empty( $data ) )
			return false;
			
		$this->db->insert('consultant_executive_levels', $data);
		if($this->db->insert_id() > 0) {
			return $this->db->insert_id();
		}
		else {
			return false;
		}
	
	}
	
	/**
	 * update executive levels
	 */
	function update_executive( $id = '', $data = '', $table = 'consultant_executive_levels' )
	{
		if ( empty( $id ) || empty( $data ) )
		{
			return false;
		}
	
		$this->db->where( 'consultant_user_id', $id );
		if ($this->db->update( $table, $data ) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function get_consultant_executive_detail( $id )
	{
		$this->db->from('consultant_executive_levels');
		$this->db->where(array('consultant_user_id'=>$id,'is_current_lvl'=>1));
		$result = $this->db->get();
		
		if(count($result->result()) > 0)
		{
			return $result->result();
		}
		else
		{
			return false;
		}
	}

	function get_consultant_allexecutive_levels( $conid )
	{
		$this->db->from('consultant_executive_levels');
		$this->db->where(array('consultant_user_id'=>$conid));
		$result = $this->db->get();
		
		if(count($result->result()) > 0)
		{
			return $result->result();
		}
		else
		{
			return false;
		}
	}

	
	/**
	 * This is use for get detail of consultant, before update status to 0 
	 */
	function get_consultant_detail( $id )
	{
		$this->db->from('users');
		$this->db->where(array('id'=>$id));
		$result = $this->db->get();
	
		if(count($result->result()) > 0)
		{
			return $result->result();
		}
		else
		{
			return false;
		}
	}
	
	function get_consultantdetailusing_email($email=''){
		$ifo = str_replace('www.','',$_SERVER['HTTP_HOST']) ;

		
		if($ifo == 'simplesalessystems.com'){
			$urltype = 1;
			$this->db->where(array('email'=>$email ,'role_id'=>4));
		}else{
			$urltype = 2;
			$storeDetail = $this->get_client_detailsurl($ifo);
			#print_r($storeDetail);
			#die;
			$this->db->where(array('email'=>$email ,'role_id'=>4,'store_id'=>$storeDetail->id));
		}
		$this->db->from('users') ;

		$result = $this->db->get();
		#echo $this->db->last_query() ;
		
		if(count($result->result()) > 0)
		{
			return $result->result();
		}
		else
		{
			return false;
		}
	}

	

	
} // class ends here

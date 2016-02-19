<?php
/*
---------------------------------------------------------------
*	Class:		Client_model extends Model defined in Core libraries
*	Author: 	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description: Manage database functionality to contact model. 
---------------------------------------------------------------
*/

class Client_model extends CI_Model{

	/**
     * method  add_client
     * Description function for adding contact us data
     * on basis of id
     * @param nane
     */
    function add_client(){
		$data = array(
			'fName' 		=> htmlspecialchars($this->input->post('fName')),
			'email' 		=> htmlspecialchars($this->input->post('email')),
			'phone' 		=> htmlspecialchars($this->input->post('phone')),
			'company' 		=> htmlspecialchars($this->input->post('company')), 
			'address' 		=> htmlspecialchars($this->input->post('address')),
			'state_code' 	=> htmlspecialchars($this->input->post('state_code')),
			'city' 			=> htmlspecialchars($this->input->post('city')),
			'zip' 			=> htmlspecialchars($this->input->post('zip')),
			'comments' 		=> htmlspecialchars($this->input->post('comments')),
			'username' 		=> htmlspecialchars($this->input->post('username')),
			'role_id' 		=> 2,
			);

		$this->db->insert('clients', $data);
		if($this->db->insert_id() > 0)
		{
			return $this->db->insert_id();
		} else
		{
			return false;
		}
    }


   /**
     * method  is_email_exists
     * Description  checks an email already exists in databsae while registering new client
     * @params  $email(string), $id(int)
     */
	function is_email_exists($email, $id = null)
	{
		if(!empty($id))
		{
			$this->db->where(array('email'=>$email, 'id !=' => $id));
		}
		else{
			$this->db->where(array('email'=>$email));
		}

		$this->db->from('clients');
		$clients = $this->db->count_all_results();

		if($clients > 0)
		{
			$this->form_validation->set_message('is_email_exists', "The %s '$email' is already exists.");
			return true;
		}
		else{
			return false;
		}
	}


	/**
     * method  is_client_exists
     * Description  checks an email already exists in databsae while registering new client
     * @params  $name(string), $id(int)
     */
	function is_client_exists($name, $id = null)
	{
		if(!empty($id))
		{
			$this->db->where(array('username'=>$name, 'id !=' => $id));
		}
		else{
			$this->db->where(array('username'=>$name));
		}

		$this->db->from('clients');
		$clients = $this->db->count_all_results();
		//echo $this->db->last_query(); die;
		if($clients > 0)
		{
			$this->form_validation->set_message('is_client_exists', "The %s '$name' is already exists.");
			return true;
		}
		else{
			return false;
		}
	}

	function is_client_existsurl($name, $id = null){
		if(!empty($id))
		{
			$this->db->like('store_url', $name ) ;
			$this->db->where(array('id !=' => $id)) ;
		}
		else{
			$this->db->like(array('store_url'=>$name));
		}

		$this->db->from('clients');
		$clients = $this->db->count_all_results();
		//echo $this->db->last_query(); die;
		if($clients > 0)
		{
			$this->form_validation->set_message('is_client_existsurl', "The %s '$name' is already exists.");
			return true;
		}
		else{
			return false;
		}
	}
	/**
	 * method  get_client_details
     * Description  gets client details based on id
     * @params  $name(string),    
    */
	function get_client_details( $name )
	{
		$result = $this->db->get_where( 'clients' ,array('username' => $name ));
		if ( count($result->row()) > 0 ){
			return $result->row();
		}
		else
		{
			return false;
		}
	}

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
	 * method  get_client_details
     * Description  Get social links of current store
     * @param $store_id( int)
	 */
	function get_client_social_links($store_id)
	{
		$result = $this->db->get_where( 'settings' ,array('role_id' => 2, 'user_id' => $store_id ));
		if ( count($result->row()) > 0 ){
			return $result->row();
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * method  get_client_pages
     * Description  Get client-stroe  static pages page
     * @param $store_id( int)
	 */
	function get_client_pages($store_id)
	{
		$result = $this->db->get_where( 'content' ,array( 'store_id' => $store_id ));
		if ( count($result->row()) > 0 )
		{
			return $result->row();
		}
		else
		{
			return false;
		}
	}

	/**
	 * method  get_consultant_social_links
     * Description  Get social links of current store/ consultant
     * @param $consultantid ( int)
	 */

	function get_consultant_social_links($consultantid)
	{
		$result = $this->db->get_where( 'settings' ,array('role_id' => 4, 'user_id' => $consultantid ));
		if ( count($result->row()) > 0 ){
			return $result->row();
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * method  add_client_pages
     * Description  Adding store pages
	 * @param $store_id ( int)
	 */
	function add_client_pages($store_id)
	{
		if ( empty( $store_id ) )
			return false;
	
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
}
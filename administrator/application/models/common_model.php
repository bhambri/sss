<?php
/*
---------------------------------------------------------------
*	Class:		Contact_model extends Model defined in Core libraries
*	Author: 	Jaidev Bangar , Abhishek Srivastav
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:	Manage database functionality to contact model. 
---------------------------------------------------------------
*/

class Common_model extends VCI_Model{

	/**
     * method  get_state
     * Description function for for getting all state list
    */
	function _is_authorized_user( $user_id, $current_controller, $action, $role_id = 1 )
	{	

		//echo $user_id .'/'. $current_controller.'/'. $action.'/'. $role_id; die;

		if( empty( $user_id ) || empty( $action ) || empty( $current_controller ) )
			return false;

		$p_id = $this->get_permission_id( $current_controller, $action  );
		if( $p_id )
		{
				$p_id = $p_id->id;

				$result = $this->db->get_where('user_permissions',array('role_id' => $role_id, 'permission' => $p_id ));
				if ( count($result->row()) > 0 ){
					return true;
				}
				else{
					return false;
				}
		}
		else
		{
			return false;
		}

	}


	function get_permission_id( $current_controller,  $action )
	{
		$result = $this->db->get_where('premissions',array('controller'=>$current_controller, 'action' => $action));

		if ( count($result->row()) > 0 ){
			return $result->row();
		}
		else{
			return false;
		}
	} 
	
	function isSettingsexist( $role_id, $user_id )
	{
	    //echo $role_id.' '.$user_id;die;
	    
	    $this->db->from("settings");
	    $this->db->where( 'role_id', $role_id );
	    $this->db->where( 'user_id', $user_id );	
	    $result = $this->db->get();
	    if( count( $result->row() ) > 0 )
	    {
	        return $result->row();
	    }
	    else
	    {
	        return false;
	    }
	}
	
	
	/*
	 function for getting client id and status of a page
	*/
	function get_clientdetail($username='',$sid=''){
	
		if($username){
			$result = $this->db->get_where('clients',array('username'=>$username,'status'=>1));
		}else{
			if($sid){
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
	
	function get_categorydetail($catName='', $storeId=''){
		
		if($catName){
			$result = $this->db->get_where('category',array('name'=>$catName,'status'=>1, 'store_id'=>$storeId));
		}else{
			return array();
		}
		
		if(count($result->result_array()) > 0)
		{
			return $result->result_array() ;
		}else
		{
			return array();
		}
	}
	
	function create_category($catName='', $storeId=''){
	
		if($catName && $storeId)
		{
			$catName = trim(strtolower($catName));
			
			$result = $this->db->get_where('category',array('name'=>$catName, 'store_id'=>$storeId));
				
			#echo count($result->result_array());
			#die;
			if(count($result->result_array()) == 0)
			{
				$data = array(
						'store_id'  => $storeId,
						'name'      => trim(htmlspecialchars(strtolower($catName))),
						'status'    => 1
				);
				$this->db->insert('category', $data);
				return $this->db->insert_id();
			}else{
				//echo '<pre>';
				//print_r($result->result_array()) ;
				
				$resut = $result->result_array();
				return $resut[0]['id'] ;
			}
		}
		else
		{
			return 0 ;
		}
		
	}
	
function create_subcat($subcatName='', $catId=''){
		if($subcatName && $catId)
		{
			$subcatName = trim(strtolower($subcatName));
			$result = $this->db->get_where('subcategory',array('name'=>$subcatName, 'category_id'=>$catId));
			if(count($result->result_array())==0)
			{
				$post_data = array(
						'category_id' => $catId,
						'name'        => trim(htmlspecialchars(strtolower($subcatName))),
						'status'      => 1
				);
				$this->db->insert('subcategory', $post_data);
				return $this->db->insert_id();
			}else{
				$resut = $result->result_array();
				return $resut[0]['id'] ;
			}
		}
		else
		{
			return 0 ;
		}
	}
	
	
	function get_subcategorydetail($subcatName='', $catId=''){
	
		if($subcatName){
			$result = $this->db->get_where('subcategory',array('name'=>$subcatName,'status'=>1, 'category_id'=>$catId));
		}else{
			return array();
		}
		
		if(count($result->result_array()) > 0)
		{
			return $result->result_array() ;
		}else
		{
			return array();
		}
	}
	
}
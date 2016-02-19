<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:	settings_model extends Model defined in Core libraries
*	Author: 
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description:	Manage database functionality for content. 
---------------------------------------------------------------
*/
class Settings_model extends VCI_Model {
	
	/**
	*********************************************************************
	*	Function Name :	add settings() .
	*	Functionality : for adding settings there
	*	@param 		  : page integer
	*	@param 		  : perpage integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function add( $role_id = null, $user_id = null, $logopath ){
        if($this->input->post('formSubmitted') > 0)
        {
        	
        	if($role_id != 1){
        		$data = array(
        	     'logo_image'        => $logopath,
        	     'role_id'           => $role_id,
        	     'user_id'           => $user_id,
				 'paypal_username'   => $this->input->post('paypal_username'),
				 'paypal_signature'	 => $this->input->post('paypal_signature'),
				 'paypal_email'      => $this->input->post('paypal_email'),
				 'paypal_password'   => $this->input->post('paypal_password'),
				 'mp_merchant_id'	 => $this->input->post('mp_merchant_id'),
				 'mp_merchant_key'   => $this->input->post('mp_merchant_key'),

				 'ava_account_number' => $this->input->post('ava_account_number'),
				 'ava_license_key'	 => $this->input->post('ava_license_key'),
				 'ava_company_code'  => $this->input->post('ava_company_code'),

				 'fb_link'           => $this->input->post('fb_link'),
				 'twitter_link'      => $this->input->post('twitter_link'),
				 'pinterest_link'    => $this->input->post('pinterest_link'),
				 'linkdin_link'      => $this->input->post('linkdin_link'),
				 'gplus_link'        => $this->input->post('gplus_link'),
				 'youtube_link'      => $this->input->post('youtube_link'),
				 'consultant_label'	 => $this->input->post('consultant_label'),
				 'status'            => htmlspecialchars( $this->input->post( 'status',true ) ),
				 'created'           => date( "Y-m-d h:i:s" ),
				 'modified'          => date( "Y-m-d h:i:s" ),
			  );
        	}else{
        		$data = array(
        	     'logo_image'        => $logopath,
        	     'role_id'           => $role_id,
        	     'user_id'           => $user_id,
				 //'paypal_username'   => $this->input->post('paypal_username'),
				 //'paypal_signature'	 => $this->input->post('paypal_signature'),
				//'paypal_email'      => $this->input->post('paypal_email'),
				 //'paypal_password'   => $this->input->post('paypal_password'),
				 'fb_link'           => $this->input->post('fb_link'),
				 'twitter_link'      => $this->input->post('twitter_link'),
				 'pinterest_link'    => $this->input->post('pinterest_link'),
				 'linkdin_link'      => $this->input->post('linkdin_link'),
				 'gplus_link'        => $this->input->post('gplus_link'),
				 'youtube_link'      => $this->input->post('youtube_link'),
				 'consultant_label'	 => $this->input->post('consultant_label'),
				 'status'            => htmlspecialchars( $this->input->post( 'status',true ) ),
				 'created'           => date( "Y-m-d h:i:s" ),
				 'modified'          => date( "Y-m-d h:i:s" ),
			  );
        	}
        	
			
        	$this->db->insert('settings', $data);
			
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
     * fetch all the settings type
     */
     function get_all_settings_types()
     {
        $this->db->from('settings');
	    $this->db->where('status', 1);
        $settings_types = $this->db->get();
	    return $settings_types->result();  
     }
    
	/**
	*********************************************************************
	*	Function Name :	update() .
	*	Functionality : for Updating settings contents	
	*	@param 		  : id integer
	*	@param 		  : filepath string
	*********************************************************************
	**/
function updatepaypal($id = null) {
		
		if(is_null($id)) {
			return false;
		}
		
        $this->db->from('settings');
	    $this->db->where('id',$id);
        $settings_types = $this->db->get();
	   
	    $rsdata = $settings_types->result_array() ;
	    $settingRolerole = $rsdata[0]['role_id'] ;

		if($settingRolerole !=1){
			$data = array(
        	     'paypal_username'   => $this->input->post('paypal_username'),
				 'paypal_email'      => $this->input->post('paypal_email'),
				 'paypal_signature'	 => $this->input->post('paypal_signature'),
				 'paypal_password'   => $this->input->post('paypal_password'),

				 'payusing'	 => $this->input->post('payusing'),
				 'modified'          => date( "Y-m-d h:i:s" ),
			);
		}

		$this->db->where( 'id', $id );
		$this->db->update( 'settings', $data );
		//echo $this->db->last_query();die;
		return true;
	}

	function updatemeritus($id = null) {
		
		if(is_null($id)) {
			return false;
		}
		
        $this->db->from('settings');
	    $this->db->where('id',$id);
        $settings_types = $this->db->get();
	   
	    $rsdata = $settings_types->result_array() ;
	    $settingRolerole = $rsdata[0]['role_id'] ;

		if($settingRolerole !=1){
			$data = array(
        	     'mp_merchant_id'	 => $this->input->post('mp_merchant_id'),
				 'mp_merchant_key'   => $this->input->post('mp_merchant_key'),
				'meritus_enabled'   => ($this->input->post('meritus_enabled'))?1:0,
				 'payusing'	 => $this->input->post('payusing'),
				 'modified'          => date( "Y-m-d h:i:s" ),
			);
		}

		$this->db->where( 'id', $id );
		$this->db->update( 'settings', $data );
		//echo $this->db->last_query();die;
		return true;
	}

	function updateavatax($id = null) {
		
		if(is_null($id)) {
			return false;
		}
		
        $this->db->from('settings');
	    $this->db->where('id',$id);
        $settings_types = $this->db->get();
	   
	    $rsdata = $settings_types->result_array() ;
	    $settingRolerole = $rsdata[0]['role_id'] ;

		if($settingRolerole !=1){
			$data = array(
        	     'ava_account_number' => $this->input->post('ava_account_number'),
				 'ava_license_key'	  => $this->input->post('ava_license_key'),
				 'ava_company_code'   => $this->input->post('ava_company_code'),

				 'modified'          => date( "Y-m-d h:i:s" ),
			);
		}

		$this->db->where('id', $id );
		$this->db->update('settings', $data );
		//echo $this->db->last_query();die;
		return true;
	}

	function update($id = null , $logopath) {
		
		if(is_null($id)) {
			return false;
		}
        #print_r($_POST);
        #die;
        $this->db->from('settings');
	    $this->db->where('id',$id);
        $settings_types = $this->db->get();
	   
	    $rsdata = $settings_types->result_array() ;
	    $settingRolerole = $rsdata[0]['role_id'] ;

		if($settingRolerole !=1){
			$data = array(
        	     'logo_image'        => $logopath,
        	    
				 'fb_link'           => $this->input->post('fb_link'),
				 'tax'           	 => $this->input->post('tax'),
				 'twitter_link'      => $this->input->post('twitter_link'),
				 'pinterest_link'    => $this->input->post('pinterest_link'),
				 'linkdin_link'      => $this->input->post('linkdin_link'),
				 'gplus_link'        => $this->input->post('gplus_link'),
				 'youtube_link'      => $this->input->post('youtube_link'),
				 'consultant_label'	 => $this->input->post('consultant_label'),
				 'status'            => htmlspecialchars( $this->input->post( 'status',true ) ),
				 'modified'          => date( "Y-m-d h:i:s" ),
			);
		}else{
			$data = array(
        	     'logo_image'        => $logopath,
        	    
				 'fb_link'           => $this->input->post('fb_link'),
				 //'tax'           	 => $this->input->post('tax'),
				 'twitter_link'      => $this->input->post('twitter_link'),
				 'pinterest_link'    => $this->input->post('pinterest_link'),
				 'linkdin_link'      => $this->input->post('linkdin_link'),
				 'gplus_link'        => $this->input->post('gplus_link'),
				 'youtube_link'      => $this->input->post('youtube_link'),
				 'consultant_label'	 => $this->input->post('consultant_label'),
				 'status'            => htmlspecialchars( $this->input->post( 'status',true ) ),
				 'modified'          => date( "Y-m-d h:i:s" ),
			);
		}

		$this->db->where( 'id', $id );
		$this->db->update( 'settings', $data );
		//echo $this->db->last_query();die;
		return true;
	}



	function updateold($id = null , $logopath) {
		
		if(is_null($id)) {
			return false;
		}
        #print_r($_POST);
        #die;
        $this->db->from('settings');
	    $this->db->where('id',$id);
        $settings_types = $this->db->get();
	   
	    $rsdata = $settings_types->result_array() ;
	    $settingRolerole = $rsdata[0]['role_id'] ;

		if($settingRolerole !=1){
			$data = array(
        	     'logo_image'        => $logopath,
        	     'paypal_username'   => $this->input->post('paypal_username'),
				 'paypal_email'      => $this->input->post('paypal_email'),
				 'paypal_signature'	 => $this->input->post('paypal_signature'),
				 'paypal_password'   => $this->input->post('paypal_password'),
				 'mp_merchant_id'	 => $this->input->post('mp_merchant_id'),
				 'mp_merchant_key'   => $this->input->post('mp_merchant_key'),

				 'ava_account_number' => $this->input->post('ava_account_number'),
				 'ava_license_key'	 => $this->input->post('ava_license_key'),
				 'ava_company_code'  => $this->input->post('ava_company_code'),


				 'fb_link'           => $this->input->post('fb_link'),
				 'tax'           	 => $this->input->post('tax'),
				 'twitter_link'      => $this->input->post('twitter_link'),
				 'pinterest_link'    => $this->input->post('pinterest_link'),
				 'linkdin_link'      => $this->input->post('linkdin_link'),
				 'gplus_link'        => $this->input->post('gplus_link'),
				 'youtube_link'      => $this->input->post('youtube_link'),
				 'consultant_label'	 => $this->input->post('consultant_label'),
				 'status'            => htmlspecialchars( $this->input->post( 'status',true ) ),
				 'modified'          => date( "Y-m-d h:i:s" ),
			);
		}else{
			$data = array(
        	     'logo_image'        => $logopath,
        	     //'paypal_username'   => $this->input->post('paypal_username'),
				 //'paypal_email'      => $this->input->post('paypal_email'),
				 // 'paypal_signature'	 => $this->input->post('paypal_signature'),
				 //'paypal_password'   => $this->input->post('paypal_password'),
				 'fb_link'           => $this->input->post('fb_link'),
				 //'tax'           	 => $this->input->post('tax'),
				 'twitter_link'      => $this->input->post('twitter_link'),
				 'pinterest_link'    => $this->input->post('pinterest_link'),
				 'linkdin_link'      => $this->input->post('linkdin_link'),
				 'gplus_link'        => $this->input->post('gplus_link'),
				 'youtube_link'      => $this->input->post('youtube_link'),
				 'consultant_label'	 => $this->input->post('consultant_label'),
				 'status'            => htmlspecialchars( $this->input->post( 'status',true ) ),
				 'modified'          => date( "Y-m-d h:i:s" ),
			);
		}

		$this->db->where( 'id', $id );
		$this->db->update( 'settings', $data );
		//echo $this->db->last_query();die;
		return true;
	}
	
	function update_cons_label($id,$data){
		//echo $id;
		
		$this->db->where( 'id', $id );
		$this->db->update( 'settings', $data );
		return true;
	}
	
	/**
	*********************************************************************
	*	Function Name :	get_settings_page() .
	*	Functionality : Gets a content page based on ID
	*	@param 		  : id integer
	*********************************************************************
	**/
	function get_settings_page($id = null)
	{
		if(is_null($id)) {
			return false;			
		} else {
			$result = $this->db->get_where('settings',array('id'=>$id));
		}
		
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;

	}

	function get_store_settings_page($userid = null , $roleid = 2)
	{
		if(is_null($userid)) {
			return false;			
		} else {
			$result = $this->db->get_where('settings',array('user_id'=>$userid , 'role_id'=>$roleid));
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
	*	Function Name :	get_settings()
	*	Functionality : gets settings list
	*	@param 		  : page integer
	*	@param 		  : per_page integer
	*	@param 		  : count integer
	*********************************************************************
	**/
	function get_settings($page, $per_page = 10, $count = false, $role_id, $user_id ) {
		$qstr = $this->input->get('s') ;
		$this->db->from('settings');
		if($count === true) {
			if(strlen($qstr) > 0) {
			$like = array('page_title' => $qstr, 'page_shortdesc' => $qstr	);
			$this->db->or_like($like);
			}
			$total = $this->db->count_all_results();
			return $total;
		}
		
        if( isset( $role_id ) && isset( $user_id ) )
        {
           $this->db->where('role_id', $role_id ); 
           $this->db->where('user_id', $user_id );       
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
		$this->db->update('settings', array('status'=>$status));
		return true;
	}

	/**
	*********************************************************************
	*	Function Name :	delete_settings()
	*	Functionality : for deleting settings
	*	@param 		  : none
	*********************************************************************
	**/
	function delete_settings(){
		$this->db->where_in('id', $this->input->post('pageids'));
	    $this->db->delete('settings');
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
		$this->db->update('settings', array('page_thumbnailpath'=>''));
		return true;
	}
	
	/**
	*********************************************************************
	*	Function Name :	count_settings()
	*	Functionality : for counting
	*	@param 		  : id integer
	*********************************************************************
	**/
	function count_settings(){
		$total = $this->db->count_all('settings');
		return $total;
	}

	function add_settings_ajax($role_id,$user_id,$consultant_label){
	$data = array(
	     'logo_image'        => '',
	     'role_id'           => $role_id,
	     'user_id'           => $user_id, 
		 'fb_link'           => '#',
		 'twitter_link'      => '#',
		 'pinterest_link'    => '#',
		 'linkdin_link'      => '#',
		 'gplus_link'        => '#',
		 'youtube_link'      => '#',
		 'consultant_label'	 => $consultant_label,
		 'status'            => 1,
		 'created'           => date( "Y-m-d h:i:s" ),
		 'modified'          => date( "Y-m-d h:i:s" ),
	  );	
		$this->db->insert('settings', $data);
		return $this->db->insert_id();
	}

}

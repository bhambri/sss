<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:			User_model extends Model defined in Core libraries
*	Author:			Jaidev Bangar
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	Manage database functionality for Users. 
---------------------------------------------------------------
*/

class User_model extends VCI_Model {
	
	/**
	*********************************************************************
	*	Function Name :	get_user_details() .
	*	Functionality : gets user details based on id
	*	@param 		  : id integer
	*********************************************************************
	**/
	function get_user_details($id = null)
	{
		if(is_null($id))
		{
			$saltResult = $this->db->get_where('adminuser',
				array(
				'username'=>$this->input->post('adminusername'), 
				'status'=>1
				)
			);

			$salt = $saltResult->row();
			$result = $this->db->get_where('adminuser',
				array(
				'username'=>$this->input->post('adminusername'), 
				'password'=>md5($this->input->post('adminpassword') . md5($salt->password_salt)),
				'status'=>1
				)
			);
			
			$logintime = array(
			'last_login' => date('Y-m-d h:i:s')
			);
			
			$this->db->where('username',$this->input->post('adminusername'));
			$this->db->where('password',md5($this->input->post('adminpassword') . md5($salt->password_salt)));			
			$this->db->update('adminuser', $logintime);
		} else
		{
			$result = $this->db->get_where('adminuser',array('id'=>$id));
		}
		
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;

	}
	
	
	/**
	 *********************************************************************
	 *	Function Name :	get_store_user_details() .
	 *	Functionality : gets user details based on id
	 *	@param 		  : id integer
	 *********************************************************************
	 **/
	function get_store_user_details($id = null)
	{
	
		$result = $this->db->get_where('users',array('id'=>$id));

		if ( count($result->row()) > 0 ){
			return $result->row();
		}
		else{
			return false;
		}
	
	}
	
	

	/**
	*********************************************************************
	*	Function Name :	get_countries() .
	*	Functionality : gets countries from country table
	*	@param 		  : none
	*********************************************************************
	**/
	function get_countries()
	{
		$result = $this->db->get('country');

		$countries = array();
		if(count($result->result())) 
		{
			foreach($result->result() as $key => $country)
			{
				$countries[$country->iso] = $country->printable_name;
			}
			return $countries;
		} else
		{
			return false;
		}

	}

	/**
	*********************************************************************
	*	Function Name :	get_states() .
	*	Functionality : gets states based on country
	*	@param 		  : none
	*********************************************************************
	**/
	function get_states() 
	{
		$result = $this->db->get_where('state',array('country_iso'=>$this->input->post('country')));

		$states = array();
		if(count($result->result())) 
		{
			foreach($result->result() as $key => $state)
			{
				$states[$state->name] = $state->name;
			}
			return $states;
		} else
		{
			return false;
		}

	}

	/**
	*********************************************************************
	*	Function Name :	register_user() .
	*	Functionality : register new user
	*	@param 		  : id integer
	*********************************************************************
	**/
	function register_user($id = null)
	{
		if(!is_null($id))
		{
			$salt = $this->input->post('salt');
		} else
		{
			$this->load->helper('string');
			$salt = random_string('alnum', 4);
		}

		$data = array(
			'username' => htmlspecialchars($this->input->post('username')),
			'password' => md5($this->input->post('password') . md5($salt)),
			'password_salt' => $salt,
			'password_orig' => $this->input->post('password'),
			'first_name' => htmlspecialchars($this->input->post('first_name')),
			'last_name' => htmlspecialchars($this->input->post('last_name')),
			'email' => htmlspecialchars($this->input->post('email')),
			'phone' => trim($this->input->post('phone')),
			'status' => $this->input->post('status'),
			'role' => 0
			);
		
		if(is_null($id))
		{
			$this->db->insert('adminuser', $data);
			if($this->db->insert_id() > 0)
			{
				return $this->db->insert_id();
			} else
			{
				return false;
			}
		} else
		{
			$this->db->where(array('id'=>$id));
			$this->db->update('adminuser', $data);
			return true;
		}
	}
	
	
	/**
	 *********************************************************************
	 *	Function Name :	new_user_register() .
	 *	Functionality : register new user from store admin
	 *	@param 		  : id integer
	 *********************************************************************
	 **/
	function new_user_register($id = null)
	{
		if(!is_null($id))
		{
			$salt = $this->input->post('salt');
		} 
		else
		{
			$this->load->helper('string');
			$salt = random_string('alnum', 4);
		}
		if( isset( $this->session->userdata['user']['is_admin'] ) )
		{
			$s_id = $this->session->userdata('storeId');
		}
		else
		{
			$store_id = $this->session->userdata('user');
			$s_id = $store_id['id'];
		}
		
		if(is_null($id))
		{
			$data = array(
				
				'store_id'  => $s_id,
				'name'      => htmlspecialchars($this->input->post('name')),
				'phone'	    => htmlspecialchars($this->input->post('phone')),
				'email'	    => htmlspecialchars($this->input->post('email')),
				'password'  => md5( htmlspecialchars($this->input->post('password')) ),
				'username'  => htmlspecialchars($this->input->post('username')),
				'status'    => $this->input->post('status'),
				'created'   => date("Y-m-d h:i:s"),
				'modified'  => date("Y-m-d h:i:s"),
				'role_id'   => 3
				
		);
		}
		else
		{
			$data = array(
			'name'      => htmlspecialchars($this->input->post('name')),
			'phone'	    => htmlspecialchars($this->input->post('phone')),
			'email'	    => htmlspecialchars($this->input->post('email')),
			'username'  => htmlspecialchars($this->input->post('username')),
			'modified'  => date("Y-m-d h:i:s")
			);
		}
		
		if(is_null($id))
		{
			$this->db->insert('users', $data);
			if($this->db->insert_id() > 0)
			{
				return $this->db->insert_id();
			} 
			else
			{
				return false;
			}
		} 
		else
		{
			$this->db->where(array('id'=>$id));
			$this->db->update('users', $data);
			return true;
		}
	}
	
	
	
	/**
	*********************************************************************
	*	Function Name :	update_status() .
	*	Functionality : updates status of the user
	*	@param 		  : id integer
	*	@param 		  : status 0 or 1 integer
	*********************************************************************
	**/
	function update_status($id = null, $status = 0)
	{
		$this->db->where(array('id'=>$id));
		$this->db->update('adminuser', array('status'=>$status));
		return true;
	}
	
	/**
	 *********************************************************************
	 *	Function Name :	store_user_update_status() .
	 *	Functionality : updates status of the user from store admin
	 *	@param 		  : id integer
	 *	@param 		  : status 0 or 1 integer
	 *********************************************************************
	 **/
	function store_user_update_status($id = null, $status = 0)
	{
		$this->db->where(array('id'=>$id));
		$this->db->update('users', array('status'=>$status));
		return true;
	}

	
	/**
	 *********************************************************************
	 *	Function Name :	is_user_exists() .
	 *	Functionality : checks user exists already or not based on username
	 *	@param 		  : username string
	 *	@param 		  : id integer
	 *********************************************************************
	 **/
	function is_user_exists($username, $store_id, $id = null)
	{
		if(!empty($id))
			$this->db->where(array('username'=>$username, 'store_id'=>$store_id, 'id !=' => $id));
		else
			$this->db->where(array('username'=>$username, 'store_id'=>$store_id));
	
		$this->db->from('users');
		$users = $this->db->count_all_results();
	
		if($users > 0)
		{
			$this->form_validation->set_message('is_user_exists', "The %s <b>$username</b> is already exists.");
			return true;
		}
		else
			return false;
	}
	
	
	/**
	*********************************************************************
	*	Function Name :	is_email_exists() .
	*	Functionality : checks an email already exists in databsae while registering new user
	*	@param 		  : email string
	*	@param 		  : id integer
	*********************************************************************
	**/
	function is_email_exists($email, $store_id, $id = null)
	{
		if(!empty($id))
			$this->db->where(array('email'=>$email, 'role_id'=>3, 'store_id'=>$store_id, 'id !=' => $id));
		else
			$this->db->where(array('email'=>$email, 'role_id'=>3, 'store_id'=>$store_id));

		$this->db->from('users');
		$users = $this->db->count_all_results();

		if($users > 0)
		{
			$this->form_validation->set_message('is_email_exists', "The %s <b>$email</b> is already exists.");
			return true;
		}
		else
			return false;
	}

	/**
	*********************************************************************
	*	Function Name :	get_all_users() .
	*	Functionality : Gets all users 
	*	@param 		  : page integer
	*	@param 		  : per_page integer
	* 	@param 		  : count integer
	*********************************************************************
	**/
	function get_all_users($page, $per_page = 10,$count=false, $store_id = false, $role_id = null)
	{
		$user = $this->session->userdata('adminuser');
		$this->db->from('users');
		$this->db->order_by("id", "desc");
		//$this->db->limit($per_page, $page);
		
		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('username',trim($like));
		}

		$this->db->where(array('store_id'=> $store_id, 'role_id' => $role_id ));
		
		if($count)
		{
			$users = $this->db->get();
			return count($users->result());
		}
		else
		{
			$this->db->order_by("id", "desc");
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
	
	/* new function added there */
	function get_all_usersconsultant($page, $per_page = 10,$count=false, $store_id = false, $role_id = null)
	{
		$user = $this->session->userdata('adminuser');
		$this->db->from('users');
		$this->db->order_by("id", "desc");
		//$this->db->limit($per_page, $page);
		
		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('username',trim($like));
		}

		$this->db->where(array('store_id'=> $store_id, 'role_id' => $role_id ));
		
		if($count)
		{
			$users = $this->db->get();
			return count($users->result());
		}
		else
		{
			$this->db->order_by("id", "desc");
			$this->db->limit($per_page,$page);
			
			$users = $this->db->get();
			//$users = $this->db->get();
			if(count($users->result()) > 0)
			{
				#echo '<pre>';
				#print_r($users->result_array()) ;
				$finArr = array() ;
				foreach ($users->result_array() as $key => $value) {
					# code...
					#echo '<pre>';
					#print_r($value);
					$total_sales = $this->get_feepaid($value['id']) ;
					#print_r($total_sales);
					$finArr[] = array_merge($value,array('profile_id'=> @$total_sales[0]['profile_id'] ) ) ;
				}
				
				#$finalSortedArr = $this->array_sort($finArr, 'tota_sum', SORT_DESC) ;
				return array_slice($finArr,$page,$per_page ) ;
			} else
			{
				return false;
			}
		}
	}
	
	/* new function to update */
	function get_feepaid($consid){
		$this->db->from('consultant_payment');
		$this->db->select(array('consultant_id','profile_id'));
		$this->db->where('consultant_id' ,$consid);
		$feepaid = $this->db->get();
		#echo $this->db->last_query() ;

		if(count($feepaid->result())){
			return $feepaid->result_array() ;
		}

	}
	 /* New function to update */

	function get_all_topconsusers($page, $per_page = 10,$count=false, $store_id = false, $role_id = null, $date_from="", $date_to="" )
	{
		$user = $this->session->userdata('adminuser');
		$this->db->from('users');
		//$this->db->order_by("id", "desc");
		//$this->db->limit($per_page, $page);
		
		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('username',trim($like));
		}

		$this->db->where(array('store_id'=> $store_id, 'role_id' => $role_id ));
		
		if($count)
		{
			$users = $this->db->get();
			return count($users->result());
		}
		else
		{
			$this->db->order_by("id", "desc");
			//$this->db->limit($per_page,$page);
			
			$users = $this->db->get();
			if(count($users->result()) > 0)
			{
				#echo '<pre>';
				#print_r($users->result_array()) ;
				$finArr = array() ;
				foreach ($users->result_array() as $key => $value) {
					# code...

					$total_sales = $this->get_totalsales_amt($value['id'] , $date_from , $date_to) ;

					$finArr[] = array_merge($value,array('tota_sum'=> money_format('%.2n', $total_sales['0']['sum_order_amount'])) ) ;
				}
				
				$finalSortedArr = $this->array_sort($finArr, 'tota_sum', SORT_DESC) ;
				return array_slice($finalSortedArr,$page,$per_page ) ;
			} else
			{
				return false;
			}
		}
	}


	
	function get_all_volume_commissions($page, $per_page = 10,$count=false, $store_id = false, $role_id = null, $date_from="", $date_to="" )
	{
		$user = $this->session->userdata('adminuser');
		$this->db->from('volume_comissions');
		$this->db->join('users', 'volume_comissions.consultant_id = users.id');
		$this->db->select(array('volume_comissions.*','users.name','users.username')) ;
		$this->db->order_by("id", "desc");
		//$this->db->limit($per_page, $page);
		
		$this->db->where(array('volume_comissions.store_id'=> $store_id ));
		if($date_from !=""){
			$startdate = date('Y-m-d',$date_from) ;
			$this->db->where(array('DATE(date_added) >= '=> $startdate ));
		}
		
		if($date_to !=""){
			$enddate = date('Y-m-d',$date_to) ;
			$this->db->where(array('DATE(date_added) <= '=> $enddate ));
		}
		if($count)
		{
			$users = $this->db->get();
			return count($users->result());
		}
		else
		{
			$this->db->order_by("id", "desc");
			$this->db->limit($per_page,$page);
			
			$users = $this->db->get();
			if(count($users->result()) > 0)
			{
				return $users->result_array();
			} else
			{
				return false;
			}
		}
	}

	function get_all_bonus($page, $per_page = 10,$count=false, $store_id = false, $role_id = null, $date_from="", $date_to="" )
	{
		$user = $this->session->userdata('adminuser');
		$this->db->from('executive_bonus');
		$this->db->join('users', 'executive_bonus.consultant_id = users.id');
		$this->db->join('executive_levels', 'executive_bonus.exe_lvl_id = executive_levels.id');
		$this->db->select(array('executive_bonus.*','users.name','users.username','executive_levels.executive_level')) ;
		$this->db->order_by("id", "desc");
		//$this->db->limit($per_page, $page);
		
		$this->db->where(array('executive_bonus.store_id'=> $store_id ));
		if($date_from !=""){
			$startdate = date('Y-m-d',$date_from) ;
			$this->db->where(array('DATE(executive_bonus.created) >= '=> $startdate ));
		}
		
		if($date_to !=""){
			$enddate = date('Y-m-d',$date_to) ;
			$this->db->where(array('DATE(executive_bonus.created) <= '=> $enddate ));
		}
		if($count)
		{
			$users = $this->db->get();
			return count($users->result());
		}
		else
		{
			$this->db->order_by("id", "desc");
			$this->db->limit($per_page,$page);
			
			$users = $this->db->get();
			if(count($users->result()) > 0)
			{
				return $users->result_array();
			} else
			{
				return false;
			}
		}
	}

	function get_all_duereport($page, $per_page = 10,$count=false, $store_id = false, $role_id = null, $date_from="", $date_to="" )
	{
		$user = $this->session->userdata('adminuser');
		$this->db->from('allcommisions');
		$this->db->join('users', 'allcommisions.consultant_id = users.id');
		//$this->db->join('executive_levels', 'executive_bonus.exe_lvl_id = executive_levels.id');
		$this->db->join('settings', 'settings.user_id = allcommisions.store_id AND settings.role_id = 2');
		$this->db->select(array('allcommisions.*','users.name','users.username', 'users.meritus_customer_id', 'settings.mp_merchant_id', 'settings.mp_merchant_key'));
		$this->db->order_by("id", "desc");
		//$this->db->limit($per_page, $page);
		
		$this->db->where(array('allcommisions.store_id'=> $store_id ));
		if($date_from !=""){
			$startdate = date('Y-m-d',$date_from) ;
			$this->db->where(array('DATE(allcommisions.created) >= '=> $startdate ));
		}
		
		if($date_to !=""){
			$enddate = date('Y-m-d',$date_to) ;
			$this->db->where(array('DATE(allcommisions.created) <= '=> $enddate ));
		}
		if($count)
		{
			$users = $this->db->get();
			return count($users->result());
		}
		else
		{
			$this->db->order_by("id", "desc");
			$this->db->limit($per_page,$page);
			
			$users = $this->db->get();
			if(count($users->result()) > 0)
			{
				return $users->result_array();
			} else
			{
				return false;
			}
		}
	}

	
	function get_totalsales_amt($consid, $datefr="" , $dateto=""){

		$rTree = $this->treeview($consid , 0) ;

		$treeNodes = $this->getaall_keyelement($rTree) ;

		$finalTreeNode = array_merge(array($consid),$treeNodes) ;

		$this->db->from('order');
		$this->db->select('SUM(order.order_amount) as sum_order_amount');
		$this->db->where('order_status' , 1);  // for paid orders only
		if($datefr !=""){
			$startdate = date('Y-m-d',$datefr) ;
			$this->db->where(array('DATE(order.created_time) >= '=> $startdate ));
		}
		
		if($dateto !=""){
			$enddate = date('Y-m-d',$dateto) ;
			$this->db->where(array('DATE(order.created_time) <= '=> $enddate ));
		}

		//$this->db->where('consultant_user_id',$consid) ;

		$this->db->where_in('consultant_user_id',$finalTreeNode) ;
		

		$totalsales = $this->db->get();
		#echo $this->db->last_query() ;

		if(count($totalsales->result())){
			return $totalsales->result_array() ;
		}

	}

	function getaall_keyelement($tree){
		$arrCid = array() ;
		foreach ($tree as $key => $treeView) {
	
			if($key== 'detail'){

				$arrCid[] = $treeView['id'] ;
			}
			if($key == 'immediatesuceesor'){
				
				if(is_array($treeView) && !empty($treeView['0'])){
					
					foreach ($treeView[0] as $keylv1 => $treeViewlv1) {
						
						if(is_array($treeViewlv1) && !empty($treeViewlv1['detail'])){
							
							$arrCid[] = $treeViewlv1['detail']['id'] ;

							//if(!empty($treeViewlv1['immediatesuceesor']) && isset($treeViewlv1['immediatesuceesor'][0])){
							if(!empty($treeViewlv1['immediatesuceesor']['immediatesuceesor'][0])){
								
								foreach ($treeViewlv1['immediatesuceesor']['immediatesuceesor'][0] as $keyval2 => $treeViewlv2) {
									# code...

									$arrCid[] = $treeViewlv2['detail']['id'] ;

									if(!empty($treeViewlv2['immediatesuceesor']['immediatesuceesor'][0])){
										
										foreach ($treeViewlv2['immediatesuceesor']['immediatesuceesor'][0] as $keyval3 => $treeViewlv3) {
											# code...
											$arrCid[] = $treeViewlv3['detail']['id'] ;
											if(!empty($treeViewlv3['immediatesuceesor']['immediatesuceesor'][0])){
												
												foreach ($treeViewlv3['immediatesuceesor']['immediatesuceesor'][0] as $keyval4 => $treeViewlv4) {
													$arrCid[] = $treeViewlv4['detail']['id'] ;
													if(!empty($treeViewlv4['immediatesuceesor']['immediatesuceesor'][0])){
														foreach ($treeViewlv4['immediatesuceesor']['immediatesuceesor'][0] as $keyval5 => $treeViewlv5) {
															$arrCid[] = $treeViewlv5['detail']['id'] ;
																if(!empty($treeViewlv5['immediatesuceesor']['immediatesuceesor'][0])){
																foreach ($treeViewlv5['immediatesuceesor']['immediatesuceesor'][0] as $keyval6 => $treeViewlv6) {
																	
																	$arrCid[] = $treeViewlv6['detail']['id'] ;
																}
															}
														}
													}
													
												}
											}
										}

									}
								}
							}
						}
						
						if($keylv1 == 'immediatesuceesor'){
							
						}
					}
				}
			}
		}

		return array_unique($arrCid) ;
	}
	
	/**
	*********************************************************************
	*	Function Name :	count_users() .
	*	Functionality : count all records	in adminuser table except 'Admin' username
	*********************************************************************
	**/

	function count_users()
	{
		$this->db->where('username <>',"admin");
		$user_count = $this->db->count_all_results('adminuser');
		return $user_count;
	}

	/**
	*********************************************************************
	*	Function Name :	delete_user() .
	*	Functionality :  deletes existing users
	*********************************************************************
	**/
	function delete_user()
	{
		$this->db->where_in('id', $this->input->post('userids'));
		if($this->db->delete('users'))
			return TRUE;
		else 
		    return FALSE;
		
	}

	/**
	*********************************************************************
	*	Function Name :	verify_email() .
	*	Functionality :  verify email id in case of forgot password
	*********************************************************************
	**/
	function verify_email()
	{
		$this->db->select('username,first_name,last_name,email,password_orig');
		$this->db->where('email',$this->input->post('email'));
		$this->db->where('status','1');
		$this->db->limit(1);

		$query = $this->db->get('adminuser');
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
	*********************************************************************
	*	Function Name :	count_dynamic_pages() .
	*	Functionality :   count all dynamic pages
	*********************************************************************
	**/
	function count_dynamic_pages()
	{
		$result	=	$this->db->count_all('content');
		if($result > 0)
			return $result;
		else
			return 0;
	}

	/**
	*********************************************************************
	*	Function Name :	update_password() .
	*	Functionality :   Updates password of the user based on id
	* 	@param integer $id
	* 	@param array $data
	*********************************************************************
	**/
	function update_password($id,$data)
	{
		$this->db->where('id',$id);
		if($this->db->update('adminuser',$data))
			return TRUE;
		else 	
			return FALSE;
		
	}

    /// cogniter 
    function is_admin_exists($id = null)
	{
		if(!empty($id))
		{ 
			$this->db->where(array( 'id =' => $id));
		}

		$this->db->from('adminuser');
		$users = $this->db->count_all_results();

		if($users > 0 && $this->session->userdata['user']['is_admin'] == 1 )
		{
			//$this->form_validation->set_message('is_email_exists', "The %s <b>$email</b> is already exists.");
			return true;
		}
		else
			return false;
	}

	function get_current_store_detail($store_id)
	{
		$result = $this->db->get_where('clients',array('id'=>$store_id));
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;
	}
	// tree view
	function treeview($id ,$g_label=0){
		if(!empty($id)){
			$this->db->where('id',$id);
		}

		ini_set('display_errors',1);
		$this->db->from('users') ;
		$this->db->select(array('users.id','users.name','users.username','users.email','users.parent_consultant_id')) ;
		//$this->db->where('status',1) ;
		$this->db->where('role_id',4) ;

		$query = $this->db->get() ;
		$data = $query->row_array();
		$treArr =  array() ;
		$lavel_count =  0  ;

		if(!empty($data)){
			//echo '<pre>';
			//print_r($data) ;
			return array('detail'=>$data,'g_label'=>$g_label , 'immediatesuceesor'=>array($this->getimmidiate_successor($data['id'] , $g_label+1)));
		}
		#echo '<pre>';
		#print_r($data) ;
		
		#return $data ;
	}

	// tree view
	function btreeview($id){
		if(!empty($id)){
			$this->db->where('id',$id);
		}

		ini_set('display_errors',1);
		$this->db->from('users') ;
		$this->db->select(array('users.id','users.name','users.username','users.email','users.parent_consultant_id')) ;
		//$this->db->where('status',1) ;
		$this->db->where('role_id',4) ;

		$query = $this->db->get() ;
		$data = $query->row_array();
		$treArr =  array() ;
		$lavel_count =  0  ;
		$t = array() ;
		if(!empty($data)){
			//echo '<pre>';
			//print_r($data) ;
			//die;
			$t[$data['id']] = array(
				'details'=>$data,
				'tr_lvl'=>0 ,
				'childs' => $this->getimmidiate_childbtree($data['id'],1) ,
				) ;

			
			// return array('detail'=>$data,'g_label'=>0 , 'immediatesuceesor'=>array($this->getimmidiate_childbtree($data['id'] , 0)));
		}
		#echo '<pre>';
		#print_r($data) ;
		
		return $t ;
	}

	function getimmidiate_childbtree($pid,$tr_lvl=0){
		if(!empty($pid)){
			$this->db->where('parent_conid',$pid);
		}

		ini_set('display_errors',1);

		$this->db->from('consultantstree') ;
		$this->db->join('users', 'consultantstree.consultant_id = users.id');
		$this->db->select(array('consultantstree.pos','users.id','users.name','users.username','users.email','users.parent_consultant_id')) ;
		//$this->db->where('status',1) ;
		$this->db->where('role_id',4) ;

		$query = $this->db->get() ;
		$cdata = $query->result_array();
		$newcdata = array() ;
		if(!empty($cdata)){
			foreach ($cdata as $key => $value) {
			# code...
				$newcdata[$value['id']]['tr_lvl'] = $tr_lvl ;
				$newcdata[$value['id']]['childs'] = $this->getimmidiate_childbtree($value['id'],$newcdata[$value['id']]['tr_lvl']+1) ;
				$newcdata[$value['id']]['details'] = $value ;
			}
		}else{
			$newcdata = array() ;
		}

		//$dataArr['childs'] = $carray ;
		//$dataArr['details'] = $newcdata ;
		return $newcdata ;
		//return $data ;
	}

	function getimmidiate_childbtreenew($pid){
		if(!empty($pid)){
			$this->db->where('parent_conid',$pid);
		}

		ini_set('display_errors',1);

		$this->db->from('consultantstree') ;
		$this->db->join('users', 'consultantstree.consultant_id = users.id');
		$this->db->select(array('consultantstree.pos','users.id','users.name','users.username','users.email','users.parent_consultant_id')) ;
		//$this->db->where('status',1) ;
		$this->db->where('role_id',4) ;

		$query = $this->db->get() ;
		$cdata = $query->result_array();
		$newcdata = array() ;
		if(!empty($cdata)){
			foreach ($cdata as $key => $value) {
			# code...
				// $carray[$value['id']] = $this->getimmidiate_childbtree($value['id']) ;
				$newcdata[$value['id']] = $value ;
			}
		}else{
			$carray = array() ;
		}

		//$dataArr['childdetails'] = $carray ;
		$dataArr['details'] = $newcdata ;
		return $dataArr ;
		//return $data ;
	}

	function getimmidiate_successor($pid , $g_label = 0){

		if($g_label > 6){
			return ;
		}
		if(!empty($pid)){
			$this->db->where('parent_consultant_id',$pid);
		}

		ini_set('display_errors',1);
		$this->db->from('users') ;
		$this->db->select(array('users.id','users.name','users.username','users.email','users.parent_consultant_id')) ;
		//$this->db->where('status',1) ;
		$this->db->where('role_id',4) ;

		$query = $this->db->get() ;
		$data = $query->result_array();
		//return  $data ;

		#echo '<pre>';
		#print_r($data) ;
		$ftempArr = array() ;
		if(!empty($data)){
			foreach($data as $successorDetail){
				//echo '<pre>';
				// print_r($successorDetail) ;
				$tempArr['detail'] = $successorDetail ;
				$tempArr['immediatesuceesor'] = $this->treeview($successorDetail['id'] , $g_label) ;
				$tempArr['g_label'] = $g_label ;
				$ftempArr[] = $tempArr ;
			}
		}

		return $ftempArr ;

	}


	/*
	getting a list all consultant that can't be assigned as parent
	*/

	function getavailble_notparents($currentId = '', $idArr = array()){

		ini_set('display_error',1) ;

		if(!empty($currentId) && (!in_array($currentId,$idArr))){
			$idArr[] = $currentId ;
		}

		$this->db->from('users') ;
		$this->db->where('parent_consultant_id',$currentId) ;

		$query = $this->db->get() ;
		$data = $query->result_array();

		if(!empty($data)){
			
			foreach($data as $newdata){

				$idArr = array_unique(array_merge( $idArr, $this->getavailble_notparents($newdata['id'] ,$idArr))) ;

			}
		}else{
			return $idArr ;
		}

		return $idArr ;
	}


	/*
	function copied from 
	http://php.net/manual/en/function.sort.php
	*/

	function array_sort($array, $on, $order=SORT_ASC)
	{
	    $new_array = array();
	    $sortable_array = array();

	    if (count($array) > 0) {
	        foreach ($array as $k => $v) {
	            if (is_array($v)) {
	                foreach ($v as $k2 => $v2) {
	                    if ($k2 == $on) {
	                        $sortable_array[$k] = $v2;
	                    }
	                }
	            } else {
	                $sortable_array[$k] = $v;
	            }
	        }

	        switch ($order) {
	            case SORT_ASC:
	                asort($sortable_array);
	            break;
	            case SORT_DESC:
	                arsort($sortable_array);
	            break;
	        }

	        foreach ($sortable_array as $k => $v) {
	            $new_array[$k] = $array[$k];
	        }
	    }

	    return $new_array;
	}
	
	function update_status_allcommisions($id){
		$this->db->select('allcommisions.*, users.meritus_customer_id, settings.mp_merchant_id, settings.mp_merchant_key');
		$this->db->join('users', 'users.id = allcommisions.consultant_id');
		$this->db->join('settings', 'settings.user_id = allcommisions.store_id AND settings.role_id = 2');
		$data	= $this->db->get_where('allcommisions', ['allcommisions.id' => $id])->row_array();
		
		$this->load->library('meritus');
		$response	= $this->meritus->makeCredit($data['meritus_customer_id'], $data['mp_merchant_id'], $data['mp_merchant_key']);
		
		if($response['TransactionID']) {
			$transaction	= [
				'store_id'			=> $data['store_id'],
				'transaction_id'	=> $response['TransactionID'],
				'user_id'			=> $data['consultant_id'],
				'user_type'			=> 4,
				'payment_method'	=> 'Meritus',
				'remarks'			=> 'Paid all dues'
			];
			if($this->db->insert('transactions', $transaction)) {
				$data = array('is_paid'=>'1');
				$this->db->where('id', $id);
				$this->db->update('allcommisions', $data) ;	
				return true;
			}
		}
		return false;
	}
	
	function update_status_commission($consultant_user_id){
		$data = array('is_paid'=>'1');
		$this->db->where('id',$consultant_user_id);
		$this->db->update('volume_comissions',$data) ;	
		return true ;
		
	}
	function update_status_bonus($consultant_user_id){
		$data = array('is_paid'=>'1');
		$this->db->where('id',$consultant_user_id);
		$this->db->update('executive_bonus',$data) ;	
		return true ;
		
	}
	
	/* 
	from from application copied
	*/

	function ptreelastweek($charr,$storeid){
		
		$previous_week = strtotime("-1 week +1 day");

		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);

		$start_week = date("Y-m-d",$start_week);
		$end_week = date("Y-m-d",$end_week);

		$this->db->from('order') ;
		$this->db->select('SUM(order_volume) as pcv') ;
		
		//$this->db->where('user_id !=', $cid) ;
		$this->db->where_in('consultant_user_id', $charr) ;
		//$this->db->where('store_id',$storeid ) ;
		//is_commision_calc
		//$this->db->where('is_overrides_calc',0) ;
		$this->db->where('DATE(created_time) <=' ,$end_week); 
		$this->db->where('DATE(created_time) >=' ,$start_week); 

		$this->db->where('order_status' , 1); // We are only distributing the commision for the order that is paid
		$resultSet = $this->db->get();
		
		/*
		print_r($this->db->last_query());
		die;
		if($resultSet->result())
		{
			$rs = $resultSet->result() ;
			return $rs[0]->pcv ;
		}else{
			return 0 ;
		} */
		if(count($resultSet->result()))
		{
			$rs = $resultSet->result() ;
			//echo '<pre>';
			//print_r($rs) ;
			if($rs[0]->pcv){
				return $rs[0]->pcv ;
			}
			return 0 ;
			
		}
		return 0 ;
	}

	function getbtreechild($cid){
		$result = $this->db->get_where('consultantstree',array('parent_conid'=>$cid));
		if ( count($result->row()) > 0 )
		{
			return $result->result_array();
		}
		else{
			return array() ;
		}
	}

	function getallbtreechilds($nid , $prearr = array()){
    	//echo $nid ;
    	$result = $this->db->get_where('consultantstree',array('parent_conid'=>$nid));
    	// $prearr[] = $nid ;
    	$prearr = array_merge(array($nid),$prearr);
    	if ( count($result->row()) > 0 )
		{
			foreach ($result->result_array() as $key => $value) {
				//$prearr[] = $this->isparent($value['consultant_id'], $prearr) ;
				//$this->isparent($value['consultant_id'], $prearr) ;
				// $prearr['aaaaa'.$value['consultant_id']] = $this->isparent($value['consultant_id'], $prearr) ;
				$prear1 = $this->getallbtreechilds($value['consultant_id'], $prearr) ;
				// return array_merge($prearr, );
				$prearr = array_merge($prear1,$prearr);
			}
		}
		//echo '<pre>' ;
		//print_r($prearr);
		return array_unique($prearr) ;
    }

	function getpendingcommisiondetails($consultant_user_id){
		$this->db->from('volume_comissions') ;
		$this->db->select(array('SUM(appv) as appv_sum','SUM(apcv) as apcv_sum','SUM(acbv) as acbv_sum')) ;
		$this->db->where('is_paid', '0'); // We are only distributing the commision for the order that is paid
		$this->db->where('consultant_id', $consultant_user_id); 		
		$resultSet = $this->db->get();

		return $resultSet->result_array() ;
		
	}
}

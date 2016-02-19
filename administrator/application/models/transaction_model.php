<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_model extends CI_Model
{
    function getList($store_id = 0, $user_id = 0, $last_record_number  = 0, $order_by = 'desc', $startdate = NULL, $enddate = NULL)
    {
		$sql	= 'SELECT transactions.*, users.name as user from transactions ';
		$sql 	.= ' join users on users.id = transactions.user_id ';
		$sql 	.= ' where 1 ';

		if($store_id) {
			$sql 	.= ' and transactions.store_id = ' . $store_id . ' ';	
		}
		if($user_id) {
			$sql 	.= ' and transactions.user_id = ' . $user_id . ' ';	
		}
		
		if($startdate) {
			$sql 	.= ' and transactions.date >= "' . $startdate . ' 00:00 " ';	
		}
		
		if($enddate) {
			$sql 	.= ' and transactions.date <= "' . $enddate . ' 23:59" ';
		}
		
		$sql 	.= ' ORDER BY transactions.id ' . $order_by. ' ';
		$sql	.= ' limit '.$last_record_number.',' . PAGE_LIMIT . ' ';

        $query = $this->db->query($sql);
        return $query->result_array();
    }
	
	function getCount($store_id = 0, $user_id = 0, $startdate = NULL, $enddate = NULL) {
		$sql	= 'SELECT count(*) as count from transactions where 1 ';

		if($store_id) {
			$sql 	.= ' and transactions.store_id = ' . $store_id . ' ';	
		}
		if($user_id) {
			$sql 	.= ' and transactions.user_id = ' . $user_id . ' ';	
		}
		
		if($startdate) {
			$sql 	.= ' and transactions.date >= "' . $startdate . ' 00:00 " ';	
		}
		
		if($enddate) {
			$sql 	.= ' and transactions.date <= "' . $enddate . ' 23:59" ';
		}
		
        $query = $this->db->query($sql);
        return $query->row()->count;
	}
}
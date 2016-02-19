<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
---------------------------------------------------------------
*	Class:			Grouppurchase_model extends Model defined in Core libraries
*	Author: 		
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	Manage database functionality for content. 
---------------------------------------------------------------
*/
class Grouppurchase_model extends VCI_Model {
	
	/**
	*********************************************************************
	*	Function Name :	update() .
	*	Functionality : To update the page
	*	@param 		  : id integer
	*********************************************************************
	**/
	function get_all_group($page, $per_page = 10,$count=false, $store_id=null, $consultantId=null )
	{
		/*
		if( empty( $consultantId ) )
		{
			return false;
		}
		*/

		$this->db->from('grouppurchase');
		$this->db->order_by("id", "desc");
		//$this->db->limit($per_page, $page);

		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('name',trim($like));
		}

		if( !empty( $store_id ) )
        {
            $this->db->where( array( 'store_id'=>$store_id ) );
        }
        //echo $consultantId;
        if( !empty( $consultantId ) )
        {
			$this->db->where( 'consultant_id', $consultantId);
        }

		if($count)
		{
			$category = $this->db->get(); // just filtering data without applying limit

			return count($category->result());
		}
		else
		{
			$this->db->limit($per_page,$page); // filter data with limit option now
			$category = $this->db->get();
			if(count($category->result()) > 0)
			{				
				return $category->result();
			} else
			{
				return array();
			}
		}
	}

	/**
     * method  get_grouppurcahse_by_id
     * Description geting group purchase corresponding to an id
     * @param nane
     */
	function get_grouppurcahse_by_id($groupid=''){
		if($groupid){
			$this->db->from('grouppurchase') ;
			$this->db->where('id',$groupid) ;
			
			$groupDetail = $this->db->get() ;

			if(count($groupDetail->result()) > 0 ){
				return  $groupDetail->result() ;
			}else{
				return array() ;
			}	
		}else{
			return array() ;
		}
	}

	function getexpired_grouppurchase(){
		
		$category = $this->db->query("Select grouppurchase.id , STR_TO_DATE(grouppurchase.end_date, '%m/%d/%Y') as ndate from grouppurchase  where is_expired=0 having ndate <= CURDATE()");
		
		if(count($category->result()) > 0)
		{				
			
			return $category->result();

		} else
		{
			return array();
		}
	}

	function update_expiredgroupentry($g_id ,$data){
		if($data)
		{
			$this->db->where('id',$g_id);
			$this->db->update('grouppurchase',$data) ;	 // updating is_expired to 1
			//echo $this->db->last_query() ;die;
			return true ;
		}else{

			return false ;
		}
	}

	/* calculate and update group purchase sales entry*/
	function calculate_groupsales(){
		
		$this->db->from('grouppurchase') ;
		$this->db->select(array('grouppurchase.id','grouppurchase.store_id','grouppurchase.group_event_code')) ;
		$this->db->where('is_expired',1);
		$this->db->where('is_sales_calculated',0);
		$groupDetail = $this->db->get() ;
		
		if(count($groupDetail->result()) > 0)
		{				
			foreach ($groupDetail->result() as $rvalue) {
				# code...
				
				/*
				[id] => 3
			    [store_id] => 8
			    [group_event_code] => Ev-code
				*/
				$this->db->from('order');
				$this->db->select(array('SUM(order.order_amount) as group_sum')) ;
				$this->db->where('group_purchase_code',$rvalue->group_event_code);
				$this->db->where('store_id',$rvalue->store_id);
				$groupSaleDetail = $this->db->get() ;
				$sumData =  $groupSaleDetail->result() ;
				
				$udata =  array('sales_sum'=>$sumData[0]->group_sum,'is_sales_calculated'=>1) ;
				$this->update_expiredgroupentry($rvalue->id ,$udata) ;

			}
			
		}else
		{
			return array();
		}

	}

	/* Getting all coupon eligible group purchase
		-- is_coupon_genrated -0
		-- is_sale_calculated -1
		-- calculating only for those for which sales happend
	 */
	function get_coupons_eligiblegrouppurchases(){
		$this->db->from('grouppurchase') ;
		$this->db->select(array('grouppurchase.id','grouppurchase.store_id','grouppurchase.group_event_code','grouppurchase.sales_sum','grouppurchase.consultant_id')) ;
		$this->db->where('is_coupon_generated',0);
		$this->db->where('is_sales_calculated',1);
		$this->db->where('sales_sum >', 0);
		$groupDetail = $this->db->get() ;
		if(count($groupDetail->result()) > 0)
		{	
			foreach ($groupDetail->result() as $rvalue) {
				# code...
			    #echo '<pre>';
				#print_r($rvalue);

				$this->db->from('coupon_genrationrules');
				$this->db->where('store_id',$rvalue->store_id);
				$this->db->where('range_from <=',$rvalue->sales_sum);
				$this->db->where('range_to >=',$rvalue->sales_sum);
				$this->db->where('status',1);
				$couponrule = $this->db->get() ;
				$crule =  $couponrule->result() ;

				#echo 'printing rules';
				#echo '<pre>';
				#print_r($crule);
				if(count($crule) > 0){
					foreach ($crule as $eachcrule) {
						# code...
						#echo '<pre>';
						#print_r($eachcrule) ;
						//print_r($rvalue); //individual coupon value
						// create coupon data
						$couponData['coupon_type_id'] = $eachcrule->coupon_type;
						$couponData['discount_percent'] = $eachcrule->amount;
						$couponData['store_id'] = $eachcrule->store_id;
						$couponData['code'] = random_string('alnum', 8);
						$couponData['start_date']  = date('Y-m-d');
						$couponData['expire_date'] = date('Y-m-d', strtotime("+2 week"));
						$couponData['created']  = date("Y-m-d h:i:s");
				        $couponData['modified'] = date("Y-m-d h:i:s");
				        $couponData['status'] = 1 ;
				        $couponData['grouppurchase_id'] = $rvalue->id ;
				        $couponData['consultant_id'] = $rvalue->consultant_id ;
				        #echo '<pre>';
				        #print_r($couponData);
				        $this->db->insert('coupons', $couponData);
				        $couponData = array() ;
						// create coupond data ends now
					}
				}
			   // update the group purchase id to  as coupon created
				$udata =  array('is_coupon_generated'=>1) ;
				#$this->update_expiredgroupentry($rvalue->id ,$udata) ;
			}
			
		}else
		{
			return array();
		}
	}

}
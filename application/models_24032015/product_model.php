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

class Product_model extends VCI_Model{

	/**
	*********************************************************************
	*	Function Name :	get_content() .
	*	Functionality : Gets all contents
	*	@param 		  : page integer
	*   @param 		  : per_page integer
	*   @param 		  : count integer
	*********************************************************************
	**/
	function get_all($page, $per_page, $count = false,$sort_by='id',$category_id='',$subcategory_id='') {
		#print_r($this->store_id) ;
		#echo 'Sort By opt'.$sort_by  ;
		$sortArr = explode(':',$sort_by) ;
		
		$this->db->from('client_product');
		$qstr = $this->input->get('s') ;
		$this->db->where("store_id", $this->store_id);
		$this->db->where('status', 1 );

		if($category_id){
			$this->db->where("category_id", $category_id);
		}
		if($subcategory_id){
			$this->db->where("subcategory_id", $subcategory_id);
		}
		
		if(strlen($qstr) > 0) {
			$like = array('sku' => $qstr, 'product_title' => $qstr);
			$this->db->or_like($like);
		}

		if($count === true) 
		{
			/*
			if(strlen($qstr) > 0) {
			$like = array('page_name' => $qstr ,'page_title' => $qstr); 
			$this->db->or_like($like);
			}
			*/
			$total = $this->db->count_all_results();
			return $total;
		}
		if($sortArr[0] == 'id')
		{
			$this->db->order_by($sortArr[0], "desc");
		}
		if($sortArr[0] == 'product_price')
		{
			if($sortArr[1]=='desc'){
				$this->db->order_by($sortArr[0], "desc");
			}else{
				$this->db->order_by($sortArr[0], "asc");
			}
			
		}
		//
		if($sortArr[0] == 'product_title')
		{
			if($sortArr[1]=='desc'){
				$this->db->order_by($sortArr[0], "desc");
			}else{
				$this->db->order_by($sortArr[0], "asc");
			}
			
		}
		
		$this->db->limit($per_page, $page);
		$content = $this->db->get();
		//echo $this->db->last_query() ;
		//die;
		if(count($content->result()) > 0)
		{
			return $content->result();
		} else
		{
			return false;
		}
	}



	/*
	* method get_all_category_subcategoryof_store
	* for getting all category subcategory of a store
	* $store_id (int)
	*/
	function get_all_category_subcategoryof_store($store_id){
		$this->db->select('category.*');
		$this->db->from('category');
		$this->db->join('subcategory', 'subcategory.category_id = category.id','right');
		$this->db->group_by('category.id');
		$this->db->order_by("category.name", "asc");
		$this->db->where('category.store_id', $store_id );
		$this->db->where('category.status', 1 );
		$this->db->where('subcategory.status', 1 );
		$category = $this->db->get();
		if(count($category->result()) > 0)
		{
			$categories = $category->result();
			//return $category->result();
			$i = 0;
			foreach ($categories as $category ) {
				$data[$i] = array( 'id' => $category->id, 'name' => $category->name );
				
			 	$this->db->from('subcategory');
				$this->db->order_by("name", "asc");
				$this->db->where('category_id', $category->id );
				$this->db->where('status', 1 );
				$subcategory = $this->db->get();
				if(count($subcategory->result()) > 0)
				{
					$data[$i]['subcategory'] = $subcategory->result();
				
				}
				$i++;
			}
			return $data;
		} 
	}

	/*
	* method all_categories_subcategories
	* for getting all category subcategory
	* params - none
	*/
	function all_categories_subcategories()
	{
		
		$this->db->select('category.*');
		$this->db->from('category');
		$this->db->join('subcategory', 'subcategory.category_id = category.id','right');
		$this->db->group_by('category.id');
		$this->db->order_by("category.name", "asc");
		//$this->db->where('category.store_id', $store_id );
		$this->db->where('category.status', 1 );
		$this->db->where('subcategory.status', 1 );
		$category = $this->db->get();
		if(count($category->result()) > 0)
		{
			$categories = $category->result();
			//return $category->result();
			$i = 0;
			foreach ($categories as $category ) {
				
				$data[$i] = array( 'id' => $category->id, 'name' => $category->name );
				

			 	$this->db->from('subcategory');
				$this->db->order_by("name", "asc");
				$this->db->where('category_id', $category->id );
				$this->db->where('status', 1 );
				$subcategory = $this->db->get();
				if(count($subcategory->result()) > 0)
				{
					$data[$i]['subcategory'] = $subcategory->result();
				
				}
				$i++;
			}

			return $data;

		} 
	}

	/*
	* method getcategory_detail
	* for getting all category  detail
	* $cat_id ( int)
	*/

	function getcategory_detail($cat_id=''){
		$this->db->select('category.*');
		$this->db->from('category');
		$this->db->where('category.id', $cat_id);
		$category = $this->db->get();
		return $category->result();
	}

	/*
	* method getsubcategory_detail
	* for getting subcategory category  detail
	* $cat_id ( int) ,$subcatid (int)
	*/

	function getsubcategory_detail($cat_id='',$subcatid=''){
		$this->db->select('subcategory.*');
		$this->db->from('subcategory');
		$this->db->where('subcategory.category_id', $cat_id);
		$this->db->where('subcategory.id', $subcatid);
		$category = $this->db->get();
		return $category->result();
	}
	
}
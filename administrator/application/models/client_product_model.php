<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-------------------------------------------------------------
*	Class:	User extends Model
*	Author:	Rakesh
*	Platform:	Codeigniter
*	Description: Manage client Products
-------------------------------------------------------------
*/
class Client_product_model extends VCI_Model {
	
    
	function __construct() 
	{
		parent::__construct();
		
	}

    /*
	-----------------------------------------------------------------
	*	Method: get_client_product_details
	*	@param $id id
	*	Description: get all the products details from the database
	-----------------------------------------------------------------
	*/
	function get_client_product_details($id)
	{
		$result = $this->db->get_where('client_product',array('id'=>$id));
		if ( count($result->row()) > 0 ){
			return $result->row();
		}
		else{
			return false;
		}
	}
	
	function get_all_clients()
	{
	    $this->db->from('clients');
	    $this->db->where('status', 1);
        $states = $this->db->get();
	    return $states->result();
	}
	
    /*
	-----------------------------------------------------------------
	*	Method: get_client_product_details_categoryID
	*	@param $category_id as id
	*	Description: get category id of client product from the database
	-----------------------------------------------------------------
	*/
	function get_client_product_details_categoryID($category_id)
	{
		$result = $this->db->get_where('client_product',array('category_id'=>$category_id));
		if ( count($result->row()) > 0 ){
			return $result->row();
		}
		else{
			return false;
		}
	}
	
	
	function get_allprod($page, $per_page = 10, $count = false, $searchstr = '', $storeid='' )
	{
		$this->db->from('client_product');
		
		if(strlen($searchstr) > 0){
			$like = $searchstr ;
			$this->db->or_like('product_title',trim($like));
			$this->db->or_like('sku',trim($like));
		}
	    
		$this->db->where('store_id',$storeid);
		
		
		//echo $this->db->last_query(); die;
		if($count)
		{
			$data = $this->db->get();
			return count($data->result());
		}
		else
		{
			
			$this->db->order_by("id", "desc");
			$this->db->limit($per_page,$page);
			$data = $this->db->get();
			if(count($data->result()) > 0)
			{
				return $data->result();
			} else
			{
				return false;
			}
		}
	}
	
	function save_image_data( $id, $image_name )
	{
		$data = array(
		'product_id' => $id,
		'image_name' => $image_name,
		//'image_color' => $image_color,
		'status'     => '1'
		);
		//echo  "<pre>"; print_r($data); die;
		
		$this->db->insert('client_product_images', $data);
			if( $this->db->insert_id() > 0 )
			{
				return $this->db->insert_id();
			}
			else
			{
				return false;
			}
	}
	
    /*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param $id_id as NULL and $status
	*	Description: Update the status of product as per user selection
	-----------------------------------------------------------------
	*/
	function update_status($id = null, $status = 0)
	{
		$this->db->where(array('id'=>$id));
		$this->db->update('client_product', array('status'=>$status));
		return true;
	}
    /*
	-----------------------------------------------------------------
	*	Method: update_product_images_status
	*	@param $id_id as NULL and $status
	*	Description: Update the status of product images as per user selection
	-----------------------------------------------------------------
	*/
	function update_product_images_status($id = null, $status = 0)
	{
		$this->db->where(array('id'=>$id));
		$this->db->update('client_product_images', array('status'=>$status));
		return true;
	}
    /*
	-----------------------------------------------------------------
	*	Method: is_client_product_exists
	*	@param $title and $category_id
	*	Description: Check product name is already exists or not
	-----------------------------------------------------------------
	*/

	function is_client_product_exists( $title, $category_id )
	{	
		$category_data = explode('@@',$category_id);
		$result = $this->db->get_where('client_product',array('client_product_title'=>$title,'category_id'=>$category_data[0]));
		if(count($result->result()) > 0 ){
			return true;
		} 
		else{
			return false;
		}
	}
    
    /*
	-----------------------------------------------------------------
	*	Method: edit_client_product_exists
	*	@param $title and $category_id, $id
	*	Description: Edit the Product name title
	-----------------------------------------------------------------
	*/
	function edit_client_product_exists( $title, $category_id, $id )
	{
		$category_data = explode('@@',$category_id);
		$result = $this->db->get_where('client_product', array('client_product_title'=>$title,'category_id'=>$category_data[0],'id !='=>$id));

		if(count($result->result()) > 0 ){
			 return true;
		}
		else{
			return false;
		}
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: get_all_client_product
	*	@param $page and $count
	*	Description: get all products with adjustment of pagination 
	-----------------------------------------------------------------
	*/

	function get_all_client_product( $page, $q_s=null, $per_page = 10,$count=false )
	{
		$this->db->select('m1.*,m2.image_name');	
		$this->db->from('client_product as m1');
		$this->db->join('client_product_images as m2', 'm1.id = m2.product_id','left');		
		$this->db->group_by("m1.id");
		$this->db->order_by( "m1.id", "Desc" );
		$this->db->limit($per_page, $page);

		/*select * from client_product_images m1 inner join client_product as m2 ON m1.product_id=m2.id group by m1.product_id  order by m1.product_id Desc */
		/*select * from client_product m1 Left join client_product_images as m2 ON m1.id=m2.product_id group by m1.id  order by m1.id Desc*/
		if(strlen($q_s) > 0)
		{
			$s =  base64_decode($q_s);
			$like = array('product_title' => $s);
			$this->db->or_like($like);
		}

		$client_product = $this->db->get();

		if(count($client_product->result()) > 0)
		{
			if( $count==true )
			{
				return count($client_product->result());
			}
			else
			{
				return $client_product->result();
			}
		}
		else
		{
			return false;
		}
	}
	/*
	-----------------------------------------------------------------
	*	Method: get_all_client_product
	*	@param $page and $count
	*	Description: get all products with adjustment of pagination 
	-----------------------------------------------------------------
	*/

	function get_a_product_images( $id )
	{
		
		$this->db->select(array('id','image_name'));
		$this->db->from( 'client_product_images' );
		$this->db->where(array('product_id'=>$id));

		$client_product = $this->db->get();

		$image_result = $client_product->result(); 
		return $image_result;

		
	}

	function get_all_client_product_images( $id, $page,$q_s=null, $per_page = 10,$count=false )
	{
	    
		$this->db->from('client_product_images');
		$this->db->where(array('product_id'=>$id));
		$this->db->order_by("id", "desc");
		$this->db->limit($per_page, $page);
		
		if(strlen($q_s) > 0)
		{
			$s =  base64_decode($q_s);
			$like = array('id' => $s);
			$this->db->or_like($like);
		}

		$client_product = $this->db->get();
		
		if(count($client_product->result()) > 0)
		{
			if( $count==true )
			{
				return count($client_product->result());
			}
			else
			{
				return $client_product->result();
			}
		}
		else
		{
			return false;
		}
	}
	/*
	-----------------------------------------------------------------
	*	Method: get_all_client_product
	*	@param $page and $count
	*	Description: get all products with adjustment of pagination 
	-----------------------------------------------------------------
	*/

	function get_product_images()
	{
		$this->db->select(array('image_name'));
		//	$this->db->select('*');
		$this->db->from( 'client_product_images' );
		$this->db->limit(1,1);

		$client_product = $this->db->get();
	
		if(count($client_product->result()) > 0)
		{
			return $client_product->result();
		} 
		else
		{
			return false;
		}
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: get_all_client_product_dropdown
	*	@param No
	*	Description: get all products in Dropdown
	-----------------------------------------------------------------
	*/
	function get_all_client_product_dropdown()
	{
		$this->db->select(array('id','client_product_title'));
		$this->db->from( 'client_product' );
		$this->db->order_by( "client_product_title" );

		$client_product = $this->db->get();
		if(count($client_product->result()) > 0)
		{
			return $client_product->result();
		} else
		{
			return false;
		}
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: get_category_client_product
	*	@param No
	*	Description: get all products as per the category id
	-----------------------------------------------------------------
	*/
	
	function get_category_client_product($id)
	{
		$this->db->select(array('id','client_product_title'));
		$this->db->from('client_product');
		$this->db->where(array('category_id'=>$id));
		$this->db->order_by("client_product_title");
		$categories = $this->db->get();
		if(count($categories->result()) > 0)
		{
			return $categories->result();
		} else
		{
			return false;
		}
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: delete_client_product
	*	@param No
	*	Description: delete product from database and
	    remove the image from desired location
	-----------------------------------------------------------------
	*/
	function delete_client_product()
	{
		$ids = $this->input->post( 'client_productids' );
		foreach ($ids as $id)
		{
			$this->db->select('*');
			$this->db->from('client_product');
			$this->db->where('id',$id);
			$result		= $this->db->get();
				
		}
		$this->db->where_in('id', $this->input->post('client_productids'));
		$this->db->delete('client_product');

		return $this->db->affected_rows();
	}
	/*
	-----------------------------------------------------------------
	*	Method: delete_client_product
	*	@param No
	*	Description: delete product from database and
	    remove the image from desired location
	-----------------------------------------------------------------
	*/
	function delete_product_image( $id = NULL)
	{		
		$this->db->select(array('image_name'));
		$this->db->from( 'client_product_images' );
		$this->db->where('id', $id);		
		$image_detail	=	$this->db->get();
		$image_result = $image_detail->result(); 
		$image_name = $image_result[0]->image_name; 			
			
		$path = dirname(dirname(dirname(dirname(__FILE__)))) . "/uploads/client_product/". $image_name;

		$result	= $this->db->delete('client_product_images', array('id' => $id ));
	
		if( $result )
		{	
			@unlink( $path );

			return TRUE;
		}		
		return false;
	}

	
	function get_product_id( $imageid = NULL)
	{		
		$this->db->select(array('product_id'));
		$this->db->from( 'client_product_images' );
		$this->db->where(array('id'=>$imageid));

		$client_product = $this->db->get();

		$image_result = $client_product->result(); 

		$product_id = $image_result[0]->product_id; 
			
		return $product_id;
			
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: validate_size
	*	@param $tmp_name
	*	Description: validate the size of uploaded image
	-----------------------------------------------------------------
	*/

	function validate_size( $tmp_name )
	{
		$imageinfo = getimagesize( $tmp_name );
		$width = $imageinfo[0];
		$height = $imageinfo[1];
		
			if(($width > 210 || $width < 180) || ($height > 210 || $height < 180)){
				return false;
			}
			else{
				return true;
			}
	}
    /*
	-----------------------------------------------------------------
	*	Method: validate_image
	*	@param $tmp_name
	*	Description: validate the image extension of uploaded image
	-----------------------------------------------------------------
	*/
	function validate_image($image)
	{
		if($image['size'] > 2097152){
			return false;
		}
		else if($image['type'] != 'image/jpeg' && $image['type'] != 'image/pjpeg' && $image['type'] != 'image/gif' && $image['type'] != 'image/png'){
			return false;
		}
		else if($image['error'] != 0){
			return false;
		}
		else{
		 	return true;
		}	
	}

	function get_all_product()
	{
		$this->db->select(array('id','client_product_title'));
		$this->db->from('client_product');
		$this->db->order_by("client_product_title");
		$products = $this->db->get();
		if(count($products->result()) > 0)
		{
			return $products->result();
		} else
		{
			return false;
		}
	}

	public function upload_product_images($product_id, $data )
	{
		$image_name = $data['image_name'];
		//$this->db->insert('client_product', $data);
		$query = "insert into client_product_images values('$image_name',now(),now(),0,0)";
		$query = $this->db->query("$query");
	}
	
	function get_all_subcategories($cat_id)
    	{
        	$this->db->select(array('id','name'));
		$this->db->from('subcategory');
		$this->db->where('category_id',$cat_id);
		$subcategories = $this->db->get();
		if(count($subcategories->result()) > 0)
		{
			return $subcategories->result();
		} else
		{
			return false;
		}
    	}

	function gettaxcode($pid){
    		$this->db->select(array('tax_code'));
		$this->db->from('client_product_avataxcode');
		$this->db->where('client_product_id',$pid);
		$taxcode = $this->db->get();
		if(count($taxcode->result()) > 0)
		{
			$rs = $taxcode->result_array();
			return $rsret = $rs[0]['tax_code'] ;
		} else
		{
			return false;
		}
   	 }

}	// class file end here

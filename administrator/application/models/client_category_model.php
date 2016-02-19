<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-------------------------------------------------------------
*	Class:	User extends Model
*	Author:	
*	Platform:	Codeigniter
*	Description: Manage client Categories
-------------------------------------------------------------
*/
class Client_category_model extends CI_Model {
	
	/*
	-----------------------------------------------------------------
	*	Method: get_client_category_details
	*	@param $id id
	*	Description: get all the categroy details from the database
	-----------------------------------------------------------------
	*/

	function get_client_category_details($id)
	{
		$result = $this->db->get_where('client_category',array('id'=>$id));
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;
	}

    /*
	-----------------------------------------------------------------
	*	Method: add_client_category
	*	@param $id_id as NULL
	*	Description: Add the client category to database
	    and upload the product image as the desired location
	-----------------------------------------------------------------
	*/

	function add_client_category($id = null)
	{
		if($_FILES['userfile']['size']!=0)
		{	
		
			if($this->validate_image($_FILES['userfile']) && $this->validate_size($_FILES['userfile']['tmp_name']))
			{
				$config['upload_path']	 = '../uploads/client_category/large/';
				$config['allowed_types'] = 'jpeg|gif|jpg|png';
				$config['max_size']		 = '1000';
				//$config['max_width']	 = '200';
				//$config['max_height']	 = '200';
				$config['overwrite']     = FALSE;

				$this->load->library('upload', $config);
				if ($this->upload->do_upload())
				{	
					$image_data = $this->upload->data();
					$config = array(
						'source_image'   => $image_data['full_path'],
						'new_image'      => '../uploads/client_category/small/',
						'maintain_ratio' => true,
						'width'          => 61,
						'height'         => 61,
						'overwrite'      => FALSE
						);

					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$image_data = $this->upload->data();
					$view_data = array(
						'category_name' => htmlspecialchars($this->input->post('category_name')),
						'description' => htmlspecialchars($this->input->post('description')),
						'image' => $image_data['file_name'],
						'status' => $this->input->post('status'),
						);
						if(!empty($_POST['id']))
						{
							//   Edit data is submitted.
							$this->db->where(array('id'=>$id));
							if($this->db->update('client_category', $view_data)){
								return true;
							}		
							else{
								return false;
							}
						}
						else
						{	
							//new Members is added
							$this->db->insert('client_category', $view_data);
							if($this->db->insert_id() > 0){
								return $this->db->insert_id();
							}
							else{
								return false;
							}
						}
				}
				else
				{	
					$this->session->set_flashdata('errors','Please select Valid image.');
					if(!empty($id)){
						$this->output->set_header('location:'.base_url()."client_category/edit_client_category/$id");
					}
					else{
						return false;
					}
				}

			}else{
				// image is not validated .
				$this->session->set_flashdata('errors','Please select Valid image.');
				if(!empty($id)){
					$this->output->set_header('location:'.base_url()."client_category/edit_client_category/$id");
				}
				else{
					return false;
				}
			}
		}
		else if($_FILES['userfile']['size']==0 && !empty($_POST['id']))
		{	
		
			$view_data = array(
				'category_name' => htmlspecialchars($this->input->post('category_name')),
				'description' => htmlspecialchars($this->input->post('description')),
				'status' => $this->input->post('status'),
				);
				$this->db->where(array('id'=>$id));
				if($this->db->update('client_category', $view_data)){
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

    /*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param $id_id as NULL and $status
	*	Description: Update the status of category as per user selection
	-----------------------------------------------------------------
	*/

	function update_status($id = null, $status = 0)
	{
		$this->db->where(array('id'=>$id));
		$this->db->update('client_category', array('status'=>$status));
		return true;
	}


    /*
	-----------------------------------------------------------------
	*	Method: is_client_category_exists
	*	@param $cat
	*	Description: Check if same name category is exist
	-----------------------------------------------------------------
	*/
	function is_client_category_exists($cat)
	{	
		$result = $this->db->get_where('client_category',array('category_name'=>$cat));
		if(count($result->result()) > 0 ){
			 return true;
		}	
		else{
			return false;
		}
	}


	function edit_client_category_exists($username,$id)
	{	
		$result = $this->db->get_where('client_category',array('category_name'=>$username,'id !='=>$id));
		if(count($result->result()) > 0 ) {
			 return true;
		}	
		else{
			return false;
		}
	}

	function get_all_client_category($page,$q_s=null, $per_page = 10,$count=false)
	{ 
		$this->db->from('client_category');
		$this->db->order_by("id", "desc");
		$this->db->limit($per_page, $page);
		if(strlen($q_s) > 0)
		{
			$s =  base64_decode($q_s);
			$like = array('name' => $s);
			$this->db->or_like($like);
		}

		$categories = $this->db->get();
		if(count($categories->result()) > 0)
		{
			if($count==true){
				return count($categories->result());
			}
			else{
				return $categories->result();
			}	
		} else
		{
			return false;
		}
	}
		
	function get_all_client_category_dropdown()
	{

		$this->db->select(array('id','name'));
		$this->db->from('category');
		$this->db->order_by("name");
		$categories = $this->db->get();
		if(count($categories->result()) > 0)
		{
			return $categories->result();
		} else
		{
			return false;
		}
	}

	function get_all_client_category_dropdown_forstore($storeid)
	{
		$this->db->select(array('category.id','category.name'));
		$this->db->from('category');
		$this->db->join('subcategory', 'subcategory.category_id = category.id','right');

		$this->db->where(array('store_id'=>$storeid));
		$this->db->group_by('category.id');

		$this->db->order_by("name");
		$categories = $this->db->get();
		if(count($categories->result()) > 0)
		{
			return $categories->result();
		} else
		{
			return false;
		}
	}

	function get_all_business_seller()
	{
		$this->db->select(array('profile_id','user_name'));
		$this->db->from('users');
		//$this->db->where('profile_id',$id);
		$seller = $this->db->get();
		if(count($seller->result()) > 0)
		{
			return $seller->result();
		} else
		{
			return false;
		}
	}

	function delete_client_category()
	{
		$ids = $this->input->post('categoryids');
		foreach ($ids as $id)
		{
			$this->db->select('image');
			$this->db->from('client_category');
			$this->db->where('id',$id);
			$result		= $this->db->get();
			
				if(count($result->row()) > 0 )
				{
					unlink("../uploads/client_category/large/". $result->row('image'));
					unlink("../uploads/client_category/small/". $result->row('image'));
				}
		}
		$this->db->where_in('id', $this->input->post('categoryids'));
		$this->db->delete('client_category');
		return $this->db->affected_rows();
	}

	function validate_size($tmp_name)
	{
		$imageinfo = getimagesize($tmp_name);
		$width = $imageinfo[0];
		$height = $imageinfo[1];
		
		return true;
			/*if(($width > 210 || $width < 180) || ($height > 210 || $height < 180))
				return false;
			else
				return true;*/
	}

	function validate_image($image)
	{
		if($image['size'] > 2097152)
			return false;
		else if($image['type'] != 'image/jpeg' && $image['type'] != 'image/pjpeg' && $image['type'] != 'image/gif' && $image['type'] != 'image/png')	
			return false;
		else if($image['error'] != 0)
			return false;
		else	
			return true;
	}
	
}	// class file end here

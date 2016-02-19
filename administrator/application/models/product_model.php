<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends VCI_Model {
	

	function get_product_details($id)
	{
		$result = $this->db->get_where('product',array('id'=>$id));
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;
	}
	function get_product_details_categoryID($artist_id)
	{
		$this->db->from('product');
		$this->db->where('artist_id',$artist_id);
		$this->db->order_by('artist_id ASC, position ASC');
		$result	= $this->db->get();
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;
	}
	function get_product_details_subcategoryID($cd_id)
	{
		$this->db->from('product');
		$this->db->where('cd_id',$cd_id);
		$this->db->order_by('artist_id ASC, position ASC');
		$result	= $this->db->get();
		if ( count($result->row()) > 0 )
			return $result->row();
		else
			return false;
	}
	


	function add_product($id = null)
	{
		if($_FILES['userfile']['size']!=0)
		{
			$config['upload_path']	 = '../uploads/mp3s/';
			$config['allowed_types'] = 'jpeg|gif|jpg|png';
			$config['max_size']		 = '1000';
			$config['overwrite']     = FALSE;

			$this->load->library('upload', $config);
			if ($this->upload->do_upload())
			{	
				$image_data = $this->upload->data();
				$config = array(
					'source_image'   => $image_data['full_path'],
					'new_image'      => '../uploads/mp3s/',
					'maintain_ratio' => true,
					'overwrite'      => FALSE
					);

				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				$image_data = $this->upload->data();
			}
		}


		$image = $_FILES['userfile']['name'];
		$image = str_replace(" ","_","$image");

		$this->load->library('upload');
		$artist_data = explode('@@',$this->input->post('artist_id'));
		$cd_data = explode('@@',$this->input->post('cd_id'));
		if($_FILES['userfile']['size']!=0)
		{
			$view_data = array(
			'artist_id' => htmlspecialchars($artist_data[0]),
			'artist_name' => htmlspecialchars($artist_data[1]),
			'cd_id' => htmlspecialchars($cd_data[0]),
			'cd_title' => htmlspecialchars($cd_data[1]),
			'mp3s_title' => htmlspecialchars($this->input->post('mp3s_title')),
			'mp3s_price' => htmlspecialchars($this->input->post('mp3s_price')),
			'image' => $image_data['file_name'],
			'description' => htmlspecialchars($this->input->post('description')),
			'part_no' => htmlspecialchars($this->input->post('part_no')),
			'status' => $this->input->post('status'),
			'price' => htmlspecialchars($this->input->post('price'))
			);
		}
		else
		{
			$view_data = array(
			'artist_id' => htmlspecialchars($artist_data[0]),
			'artist_name' => htmlspecialchars($artist_data[1]),
			'cd_id' => htmlspecialchars($cd_data[0]),
			'cd_title' => htmlspecialchars($cd_data[1]),
			'mp3s_title' => htmlspecialchars($this->input->post('mp3s_title')),
			'mp3s_price' => htmlspecialchars($this->input->post('mp3s_price')),
			'description' => htmlspecialchars($this->input->post('description')),
			'part_no' => htmlspecialchars($this->input->post('part_no')),
			'status' => $this->input->post('status'),
			'price' => htmlspecialchars($this->input->post('price'))
			);
		}
		
		
			if($id != null)
			{
                $this->db->select('image');
                $this->db->from('product');
                $this->db->where('id',$id);
                $result		= $this->db->get();
			
				if(count($result->row()) > 0 && $_FILES['userfile']['size']!=0 )
				{
					@unlink("../uploads/mp3s/". $result->row('image'));
					//@unlink("../uploads/mp3s/small/". $result->row('small_song'));
				}   
				//   Edit data is submitted.
				$this->db->where(array('id'=>$id));
				if($this->db->update('product', $view_data))
				{
						return true;
				}
				else
					return false;
			}
			else
			{	
			//  new product is added
			$this->db->insert('product', $view_data);
			if($this->db->insert_id() > 0)
				return $this->db->insert_id();
			else
				return false;
			}
	}


	function update_status($id = null, $status = 0)
	{
		$this->db->where(array('id'=>$id));
		$this->db->update('product', array('status'=>$status));
		return true;
	}


	function is_product_exists($title,$artist_id,$cdid)
	{	
		$artist_data = explode('@@',$artist_id);
		$cd_data = explode('@@',$cdid);
		$result = $this->db->get_where('product',array('mp3s_title'=>$title,'artist_id'=>$artist_data[0],'cd_id'=>$cd_data[0]));
		if(count($result->result()) > 0 ) 
			 return true;
		else
			return false;
	}


	function edit_product_exists($title,$artist_id,$cdid,$id)
	{
		$artist_data = explode('@@',$artist_id);
		$cd_data = explode('@@',$cdid);
		$result = $this->db->get_where('product',array('mp3s_title'=>$title,'artist_id'=>$artist_data[0],'cd_id'=>$cd_data[0],'id !='=>$id));
		if(count($result->result()) > 0 ) 
			 return true;
		else
			return false;
	}

	function get_all_product($page,$q_s=null, $per_page = 10,$count=false)
	{
		$this->db->from('product');
		$this->db->order_by('artist_id ASC, cd_title ASC, position ASC');
		$this->db->limit($per_page, $page);
		
		if(strlen($q_s) > 0)
		{
			$s =  base64_decode($q_s);
			$like = array('mp3s_title' => $s,'artist_name' => $s,'cd_title' => $s);
			$this->db->or_like($like);
		}

		$mp3s = $this->db->get();
		if(count($mp3s->result()) > 0)
		{
			if($count==true)
				return count($mp3s->result());
			else
			return $mp3s->result();
		} else
		{
			return false;
		}
	}

	function delete_product()
	{
		$ids = $this->input->post('mp3ids');
		foreach ($ids as $id)
		{
			$this->db->select('image');
			$this->db->from('product');
			$this->db->where('id',$id);
			$result		= $this->db->get();
			
				if(count($result->row()) > 0 )
				{
					@unlink("../uploads/mp3s/". $result->row('image'));
					//@unlink("../uploads/mp3s/small/". $result->row('small_song'));
				}
		}
		$this->db->where_in('id', $this->input->post('mp3ids'));
		$this->db->delete('product');
		return $this->db->affected_rows();
	}
	function update_product()
	{
		$positions = $this->input->post('positions');
		foreach ($positions as $id => $position)
		{
			$this->db->where(array('id'=>$id));
			$this->db->update('product', array('position'=>$position));
		}
		return true;
	}

	function validate_image($image)
	{
		if($image['type'] != 'audio/mpeg')	
			return false;
		else if($image['error'] != 0)
		{
			return false;
		}
		else	
			return true;
	}

}	// class file end here

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-------------------------------------------------------------
*	Class:	User extends VCI_Controller defined in libraries
*	Author:	Rakesh
*	Platform:	Codeigniter
*	Description: Manage client Products
-------------------------------------------------------------
*/
class Client_product extends VCI_Controller {
	
	var $userid = null; //stores current user id

	function client_product()
	{
	    //echo 'kanav';die;
		//parent::VCI_Controller();
		parent::__construct();
//		$this->load->helper(array( 'url', 'form' ) );
		$this->load->library('session' );
		$this->load->model('client_product_model');
		$this->load->model('client_category_model');
		//echo 'kanav';die;
	}

	/*
	-----------------------------------------------
	*	Method: New client Product
	*	Description: Add a new client Product.
	-----------------------------------------------
	*/
	function new_client_product()
	{
	    //echo  '</pre>'; print_r($this->session->userdata);echo '</pre>';die;
  	    $session_user_data =  $this->session->userdata('user');
  	    $session_store_id = $session_user_data['id'];
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		
		//sets the data form exporting to view
		$view_data = array('caption' => 'Add New client Product');
		
		//creates bread crumb
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage client Product' => array('link'=>'client_product/manage_client_product', 'attributes' => array('class'=>'breadcrumb')),
			'Add New client Product' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		
		//Create categories array for selection
		$Category_Array = $this->client_category_model->get_all_client_category_dropdown();
		$Category_Data[""]="Select Category";
		foreach($Category_Array as $key => $category_ar)
		{
			$Category_Data[$category_ar->id.'@@'.$category_ar->name] = $category_ar->name;
		}
		
		$view_data['category_data'] = $Category_Data;
        
        $view_data['all_categories'] = $this->client_category_model->get_all_client_category_dropdown();
        
		//check if form was submitted by the user
		if( $this->input->post('formSubmitted') > 0 ) 
		{
			//echo '<pre>';print_r($_POST);die;
			$image_count = $this->input->post('no_attach');
			//$image_color = $this->input->post('image_color');

			for($i=1; $i<=$image_count; $i++)
			{
				$image_field_name = 'image_name_' . $i;

				if (($_FILES[$image_field_name]["type"] == "image/gif")
				|| ($_FILES[$image_field_name]["type"] == "image/jpeg")
				|| ($_FILES[$image_field_name]["type"] == "image/jpg")
				|| ($_FILES[$image_field_name]["type"] == "image/pjpeg")
				|| ($_FILES[$image_field_name]["type"] == "image/x-png")
				|| ($_FILES[$image_field_name]["type"] == "image/png"))
				{
					//VALID IMAGES DO NOTHING
					
				}
				else
				{
					$this->session->set_flashdata('errors','Please upload Valid Image files only!');
					redirect( base_url() . 'client_product/new_client_product', 'refresh');
				}
			}

			//if( $this->form_validation->run('add_client_product') )
			if( isset( $_POST['category_id']) )
			{
				$product_id = $this->client_product_model->add_client_product('', $session_store_id );
			
				if( $product_id )
				{
					if( $this->upload_product_images( $product_id ) )
					{
						$this->session->set_flashdata('success','client Product has been added successfully');
						$this->output->set_header('location:' . base_url() . 'client_product/manage_client_product');
					} 	
				}
			}
			else
			{
				echo "form not validated";
			}			
		}
		else
		{
			//form not submitted load view normally
			$this->_vci_view('new_client_product', $view_data);
		}

	}

	function upload_product_images( $product_id )
	{ 		
		 $image_count = $this->input->post('no_attach');
		 //$image_color = $this->input->post('no_color');
		
		for( $i=1; $i<=$image_count; $i++ )
		{
			$this->load->library('upload');
            $this->upload->initialize($this->set_upload_options());
			
			$image_field_name = 'image_name_' . $i;
			
			if( !$this->upload->do_upload( $image_field_name ) )
			{
				echo $this->upload->display_errors();
			}
			else
			{
				$data       = $this->upload->data();
				$image_name = $data['file_name'];								
				//$color_value =	$this->input->post( 'image_color_'.$i );
				$this->client_product_model->save_image_data( $product_id, $image_name );
			}		
		}		
		return TRUE;
     }

	private function set_upload_options()
    {   
		$config = array();

		$config['upload_path']		=	dirname(dirname(dirname(dirname(__FILE__)))) . '/uploads/client_product/';
		$config['allowed_types'] 	=   'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
		$config['overwrite']		=	 FALSE;
		$config['remove_spaces']	=	 TRUE;
		$config['max_size']			=	'100000';
		$config['max_width'] 		=   '6000';
		$config['max_height']  		=   '3500';

        return $config;
    }



	/*
	-----------------------------------------------------------------
	*	Method: imagesize
	*	Description: image validation 
	-----------------------------------------------------------------
	*/
	function validate_image($image_field_name)
	{	
		if (($_FILES[$image_field_name]["type"] == "image/gif")
		|| ($_FILES[$image_field_name]["type"] == "image/jpeg")
		|| ($_FILES[$image_field_name]["type"] == "image/jpg")
		|| ($_FILES[$image_field_name]["type"] == "image/pjpeg")
		|| ($_FILES[$image_field_name]["type"] == "image/x-png")
		|| ($_FILES[$image_field_name]["type"] == "image/png"))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}	
	}
	

	/*
	-----------------------------------------------------------------
	*	Method: is_client_product_exists
	*	@param title string
	*	Description: Callback method used for unique username check
		by form validation rules defined in config/form_validation.php
	-----------------------------------------------------------------
	*/
	
	function is_client_product_exists()
	{	
		$title = $_POST['client_product_title'];
		$categoryid = $_POST['category_id'];
		if($this->client_product_model->is_client_product_exists($title,$categoryid))
		{
			 $this->form_validation->set_message('is_client_product_exists', "The client product name <b>$title</b> already exists.");
			 return false;
		}
		else
			return true;
	}

	function edit_client_product_exists( $title, $categoryid, $id )
	{
		if($this->client_product_model->edit_client_product_exists($title,$categoryid,$id))
		{
			 $this->form_validation->set_message('edit_client_product_exists', "The client product name <b>$title</b> already exists.");
			 return false;
		}
		else
			return true;
	}

	
	/*
	-----------------------------------------------------------------
	*	Method: manage_client_product
	*	@param page integer
	*	Description: creates listing and handles search operations
	-----------------------------------------------------------------
	*/
	function manage_client_product( $page = 0, $q_s=null )
	{	
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		
		//prepare the data for exporting to view
		$view_data = array('caption' => 'Manage client Products');

		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage client Products' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$q_s = empty($q_s)?"":base64_decode($q_s);

		if(strlen($this->input->get_post('s')) > 0)
		{
			$s =$this->input->get_post('s');
			$q_s=$s;
		}

		$query_string = base64_encode($q_s);
		
		//set pagination configs
		$config['base_url'] = base_url() . "client_product/manage_client_product";
		$config['total_rows'] = intval($this->client_product_model->get_all_client_product('',$query_string,'',true));
		
		$config['per_page'] = PAGE_LIMIT_NEW;
		$config['query_string_after_pagenu'] = $query_string;
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		$view_data['client_product_images'] = $this->client_product_model->get_product_images();

		$view_data['client_product'] = $this->client_product_model->get_all_client_product( $page, $query_string,$config['per_page']);
		$view_data['pagenum'] = 0;
		$this->_vci_view( 'manage_client_product', $view_data );
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: delete_client_product
	*	Description: Deletes a client_product from database and redirect to 
		manage_client_product
	-----------------------------------------------------------------
	*/

	function delete_client_product()
	{
		$this->_vci_layout( 'menu-toolbar' );
		$ids = $this->input->post('client_productids');
		$result = $this->client_product_model->delete_client_product();
		
		$this->session->set_flashdata('success', 'client Product Deleted Successfully.');
		$this->output->set_header('location:' . base_url() . 'client_product/manage_client_product');			
	}

	/*
	-----------------------------------------------------------------
	*	Method: delete_client_product
	*	Description: Deletes a client_product from database and redirect to 
		manage_client_product
	-----------------------------------------------------------------
	*/

	function delete_product_image( $image_id = null )
	{	
		$product_id = $this->client_product_model->get_product_id( $image_id );
		$edit_url	=	base_url() ."client_product/edit_client_product/".$product_id;

		$result		=	$this->client_product_model->delete_product_image( $image_id );
		
		if( $result )		
		{		
			$this->session->set_flashdata('success', 'client Product Image Deleted Successfully.');				
			redirect( $edit_url, 'refresh');
		}
	}		
	
	/*
	-----------------------------------------------------------------
	*	Method: update_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer 
	*	Description: update client_product status. if status is active then 
		deactive toggles the operation
	-----------------------------------------------------------------
	*/

	function update_status($id = null, $status = 1, $page = 0)
	{
		$this->_vci_layout('menu-toolbar');
		
		//check if id was passed
		if(is_null($id))
		{
			$this->session->set_flashdata('errors','Error updating client Product Status.');
			$this->output->set_header('location:' . base_url() . 'client_product/manage_client_product');
		}
		
		//toggles the status
		if(intval($status) == 1)
		{
			$status = 0;
		}
		else{
			$status = 1;
		}

		//update the status for the user and redirect to listing with success msg
		$result = $this->client_product_model->update_status($id, $status);
		$this->session->set_flashdata('success', 'client Product Status Updated Successfully');
		$this->output->set_header('location:' . base_url() . 'client_product/manage_client_product' . (($page>0) ? '/' . $page : ''));
	}
	

	/*
	-----------------------------------------------------------------
	*	Method: update_product_images_status
	*	@param id integer
	*	@param status integer 1 or 0
	*	@param page integer 
	*	Description: update  status. if status is active then 
		deactive toggles the operation
	-----------------------------------------------------------------
	*/

	function update_product_images_status($id = null, $status = 1, $page = 0)
	{
		$this->_vci_layout('menu-toolbar');
		
		//check if id was passed
		if(is_null($id))
		{
			$this->session->set_flashdata('errors','Error updating client Product Status.');
			$this->output->set_header('location:' . base_url() . 'client_product/edit_client_product');
		}
		
		//toggles the status
		if(intval($status) == 1)
		{
			$status = 0;
		}
		else{
			$status = 1;
		}

		//update the status for the user and redirect to listing with success msg
		$result = $this->client_product_model->update_product_images_status($id, $status);
		$this->session->set_flashdata('success', 'client Product Status Updated Successfully');
		$this->output->set_header('location:' . base_url() . 'client_product/edit_client_product' . (($page>0) ? '/' . $page : ''));
	}


	function edit_client_product( $id = null )
	{
	    error_reporting(0);
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');

		//get client_productid either from argument passed or from posted fields
		$this->client_productid = (isset($id)) ? $id : $this->input->post('id');
        
		$view_data = array( 'caption' => 'Edit client Product' );		
		$view_data['client_product'] = $this->client_product_model->get_client_product_details( $this->client_productid );
		//creates bread crumb
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage client Product' => array('link'=>'client_product/manage_client_product', 'attributes' => array('class'=>'breadcrumb')),
			'Edit client Product' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		$view_data['client_product_images'] = $this->client_product_model->get_all_client_product_images( $id, $page, $query_string,$config['per_page'] );

		//Create category array for selection
		$Category_Array = $this->client_category_model->get_all_client_category_dropdown();			
		foreach($Category_Array as $key => $category_ar)
		{
			$Category_Data[$category_ar->id.'@@'.$category_ar->name] = $category_ar->name;
		}
		$view_data['category_data'] = $Category_Data;
		
		$view_data['all_categories'] = $this->client_category_model->get_all_client_category_dropdown();
		
		// Create subcategory array  
		$product_details = $this->client_product_model->get_client_product_details($id);	
		//echo '<pre>';print_r($product_details->category_id);die;
		
		$view_data['subcategories'] = $this->client_product_model->get_all_subcategories($product_details->category_id);	
		// Create subcategory array  ends
		
		//check if form was submitted by the user
		if( $this->input->post('formSubmitted') > 0 ) 
		{	
			//echo '<pre>'; print_r( $_FILES ); exit;

			$image_count = $this->input->post('no_attach');
			//$image_color = $this->input->post('image_color');
	
			for( $i=1; $i<=$image_count; $i++ )
			{
				$image_field_name = 'image_name_' . $i;

				if( $_FILES[$image_field_name]["type"] == "" )
				{
					continue;
				}
				else if (($_FILES[$image_field_name]["type"] == "image/gif")
				|| ($_FILES[$image_field_name]["type"] == "image/jpeg")
				|| ($_FILES[$image_field_name]["type"] == "image/jpg")
				|| ($_FILES[$image_field_name]["type"] == "image/pjpeg")
				|| ($_FILES[$image_field_name]["type"] == "image/x-png")
				|| ($_FILES[$image_field_name]["type"] == "image/png"))
				{
					//VALID IMAGES DO NOTHING
				}
				else
				{
					$this->session->set_flashdata('errors','Please upload Valid Image files only!');
					redirect( base_url() . 'client_product/edit_client_product/'.$this->client_productid, 'refresh');
				}
			}

			//if( $this->form_validation->run( 'edit_client_product' ) )
			if( $this->input->post('category_id') )
			{	
				$product_id = $this->client_product_model->add_client_product( $this->client_productid );	
				
				if( $product_id )
				{
					if( $this->upload_product_images( $this->client_productid  ) )
					{
					
						$this->session->set_flashdata('success','client Product has been added successfully');
						$this->output->set_header('location:' . base_url() . 'client_product/manage_client_product');
					}
				}				
			}
			else
			{
				echo "Form not validated";
			}			
		}
		else
		{
			//form not submitted load view normally
			$this->_vci_view('edit_client_product', $view_data);
		}

	}
	
	function getSubCategories( $cat_id = null )
	{
	    //echo trim($cat_id);die;
	    $subcategories = $this->client_product_model->get_all_subcategories( $cat_id );	
	    $subcategory =  '<select class="inputbox" style="width: 200px;" name="subcategory" id="subcategory" >';
	    $subcategory .=  '<option value="0" >Select Subcategory</option>';
	    foreach( $subcategories as $each_category )
	    {
	      $subcategory .= '<option value="'.$each_category->id.'">'.$each_category->name.'</option>';
	    }
	    
	    $subcategory .= '</select>';
	    echo $subcategory;die;
	    
	}
		
} //class file end here

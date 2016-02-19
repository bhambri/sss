<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-------------------------------------------------------------
*	Class:	User extends VCI_Controller defined in libraries
*	Author:	
*	Platform:	Codeigniter
*	Description: Manage client Products
-------------------------------------------------------------
*/
class Product extends VCI_Controller {
	
	var $userid = null; //stores current user id

	function __construct()
	{	
		parent::__construct();
		$this->load->library('session' );
		$this->load->helper('resize');
		$this->load->model('client_product_model');
		$this->load->model('client_category_model');
		$this->load->model('client_model');
		//error_reporting(E_ALL);
	}

	/*
	-----------------------------------------------
	*	Method: New client Product
	*	Description: Add a new client Product.
	-----------------------------------------------
	*/
	function add()
	{
		
	    $store_id = $this->session->userdata('storeId');	    
	    if( empty( $store_id ) )
	    {
	       $store_id = $this->storeId();
	    }
	    
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$this->load->library('upload');
		//sets the data form exporting to view
		$view_data = array('caption' => 'Add New client Product');
		
		//creates bread crumb
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Client Product Settings' => array('link'=>'product/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Add New client Product' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		
		//Create categories array for selection
		$Category_Array = $this->client_category_model->get_all_client_category_dropdown_forstore($store_id);
		$Category_Data[""]="Select Category";
		if(!empty($Category_Array))
		{
		foreach($Category_Array as $key => $category_ar)
		{
			$Category_Data[$category_ar->id.'@@'.$category_ar->name] = $category_ar->name;
		}
		}
		$view_data['category_data'] = $Category_Data;
        
        $view_data['all_categories'] = $this->client_category_model->get_all_client_category_dropdown_forstore($store_id);
        
		
		//check if form was submitted by the user
		if( $this->input->post('formSubmitted') > 0 ) 
		{
			$view_data['subcategories'] = $this->client_product_model->get_all_subcategories($this->input->post('category_id'));

			//validates the post data by using the rules defined in config file
			if($this->form_validation->run('product_add'))
			{
				$post_data = array(
			        'store_id'      	=> $store_id,
			        'category_id'       =>  $this->input->post('category_id'),
					'subcategory_id'    =>  $this->input->post('subcategory'),
					'sku'               => htmlspecialchars($this->input->post('sku')),
					'product_title'     => htmlspecialchars($this->input->post('client_product_title')),
					'product_size'	    => htmlspecialchars($this->input->post('product_size')),
					'product_price'	    => round(htmlspecialchars($this->input->post('client_product_price')),2),
					'product_volume'	=> round(htmlspecialchars($this->input->post('client_product_volume')),2),
					'description'       => htmlspecialchars($this->input->post('description')),
					'status'            => $this->input->post('status'),
					'created'           => date("Y-m-d h:i:s"),
					'modified'          => date("Y-m-d h:i:s"),	
			    );
			    
				if((int)$this->input->post('product_weight') > 0){
					$post_data['weight'] = (int)$this->input->post('product_weight') ;
				}

				// newly updated starts here
				$storedetail = $this->client_model->get_client_details($store_id) ;
				$storefolder = strtolower($storedetail->username.'_'.$storedetail->id.'/products/'.date('Y').'_'.date('F'));
				// newly updated part

				if(!empty($_FILES['image']))
				{
					//$config['upload_path'] = '../uploads/products';
					// newly updated starts here
					$config['upload_path'] = '../uploads/'.$storefolder;
					if (!file_exists($config['upload_path'])) {
					    mkdir($config['upload_path'], 0775, true);
					    //mkdir($config['upload_path'].'/thumb', 0775, true);
					}
					// newly updated part

					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					/* $config['max_size']	= '5120';
					$config['max_width']  = '2024';
					$config['max_height']  = '768';
					*/
					$config['max_size']	= '30000';
					$config['max_width']  = '5500';
					$config['max_height']  = '5500';
					$this->upload->initialize($config);
					
					//print_r($this->upload->data());
//die('AAA');
					if( ! $this->upload->do_upload('image'))
					{
						// invalid image type 
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('errors', $this->upload->display_errors());
						$this->output->set_header('location:' . base_url() . 'product/add');
					}
					else
					{
						$uploadedData = $this->upload->data() ;
						$filepath = '/uploads/'.$storefolder.'/'.$uploadedData['file_name'];
						//$filepath = '/uploads/'.$uploadedData['file_name'];
					}				
				}
// new code starts here
				if(!empty($_FILES['image2']) && ($_FILES['image2']['name'] !=""))
				{
					$config['upload_path'] = '../uploads/products';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '30000';
					$config['max_width']  = '5500';
					$config['max_height']  = '5500';
					$this->upload->initialize($config);
				
					if( ! $this->upload->do_upload('image2'))
					{
						// invalid image type 
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('errors', 'product Image 2'.$this->upload->display_errors());
						$this->output->set_header('location:' . base_url() . 'product/add');
					}
					else
					{
						$uploadedData2 = $this->upload->data() ;
						$filepath2 = '/uploads/products/'.$uploadedData2['file_name'];
					}				
				}
				if(!empty($_FILES['image3']) && ($_FILES['image2']['name'] !=""))
				{
					$config['upload_path'] = '../uploads/products';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '30000';
					$config['max_width']  = '5500';
					$config['max_height']  = '5500';
					$this->upload->initialize($config);
				
					if( ! $this->upload->do_upload('image3'))
					{
						// invalid image type 
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('errors', 'product Image 3'.$this->upload->display_errors());
						$this->output->set_header('location:' . base_url() . 'product/add');
					}
					else
					{
						$uploadedData3 = $this->upload->data() ;
						$filepath3 = '/uploads/products/'.$uploadedData3['file_name'];
					}				
				}
				// new code ends here


				if(	!$this->upload->display_errors() )
				{
					$post_data['image'] = 	$filepath;
					$post_data['image2'] = 	$filepath2;
					$post_data['image3'] = 	$filepath3;

					if( $this->client_product_model->add( 'client_product', $post_data ) ) {
						$this->session->set_flashdata('success', "<li>Product has been added successfully.</li>");
						$this->output->set_header('location:' . base_url() . 'product/manage');
					} else {
						$this->session->set_flashdata('error', "<li>Unknown Error: Unable to add product.</li>");
						$this->output->set_header('location:' . base_url() . 'product/manage');
					}
				}				  
			}
			$view_data['category_id']  =  @$this->input->post('category_id');
			$view_data['subcategory']    =  @$this->input->post('subcategory');
			$this->_vci_view('product_add', $view_data);		
		}
		else
		{
			$view_data['category_id']  =  @$this->input->post('category_id');
			$view_data['subcategory']    =  @$this->input->post('subcategory');
			//form not submitted load view normally
			$this->_vci_view('product_add', $view_data);
		}
		

	}

	function upload_product_image()
	{
		if(empty($_FILES['image']['name']))
		{
			$this->form_validation->set_message('upload_product_image', 'The Upload Product Image field is required.');
			return FALSE;
		}
		else
		{
			return true;
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
	*	Method: manage_client_product
	*	@param page integer
	*	Description: creates listing and handles search operations
	-----------------------------------------------------------------
	*/
	function manage( $page = 0, $q_s=null )
	{
		
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		$store_id = $this->session->userdata('storeId');
	    if( empty( $store_id ) )
	    {
	        $store_id = $this->storeId();
	    }
	    
		//prepare the data for exporting to view
		$view_data = array('caption' => 'Manage client Product Settings');

		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage client Product Settings' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$q_s = empty($q_s)?"":base64_decode($q_s);

		if(strlen($this->input->get_post('s')) > 0)
		{
			$s =$this->input->get_post('s');
			$q_s=$s;
		}

		if($this->input->post('formSubmitted') > 0)
		{	
			 //echo mime_content_type ( '../uploads/xls/sample-product.csv' ); die;
			$this->load->library('upload');
			if(!empty($_FILES['upload_xls'])){
				$config['upload_path'] = '../uploads/xls';
				$config['allowed_types'] = 'csv';
				$config['max_size']	= '5000';

				$this->upload->initialize($config);
				if( ! $this->upload->do_upload('upload_xls')){
					// invalid image type 
					$this->session->set_flashdata('errors', "<li>" . $this->upload->display_errors() . "</li>");
					$this->output->set_header('location:' . base_url() . 'product/manage');
				}else{
					$uploadedData = $this->upload->data();
					$fileName = '../uploads/xls/'.$uploadedData['file_name'];

					$CSVfp = fopen( $fileName, "r" );
                        if( $CSVfp !== FALSE ) 
                        {
                        
                        	if(fgetcsv( $CSVfp, 1000, "," )!==FALSE)
                        	{
                        		$sep = ",";
                        	}
                        	else
                        	{
                        		$sep = "\t";
                        	}
                        	
                        //    $i =1;
                            while( !feof( $CSVfp ) )
                            {
                            	
                            	$data = fgetcsv( $CSVfp, 1000, $sep );
               //           pr($data); die;
                          $storedata = $this->common_model->get_clientdetail(strtolower($data[0])) ;

                          $post_data = array();
							if(!empty($storedata)){
								
								//$catdata = $this->common_model->get_categorydetail(strtolower($data[2]), $storedata[0]['id']) ;
								$catdata = $this->common_model->create_category(strtolower($data[2]), $storedata[0]['id']);
								
								//$subcatdata = $this->common_model->get_subcategorydetail(strtolower($data[3]), $catdata[0]['id']) ;
								$subcatdata = $this->common_model->create_subcat(strtolower($data[3]), $catdata) ;
								//if(!empty($catdata))
								if($catdata !=0)
								{

								$post_data = array(
										'store_id'      	=> $storedata[0]['id'],
										//'category_id'       => $catdata[0]['id'],
										'category_id'       => $catdata ,
										//'subcategory_id'    => $subcatdata[0]['id'],
										'subcategory_id'    => $subcatdata,
									//  'category_name'     => $data[3],
										'product_title'     => $data[4],
										'product_price'	    => $data[5],
										'description'       => $data[9],
										'status'            => $data[10],
										'created'           => date("Y-m-d h:i:s"),
										'modified'          => date("Y-m-d h:i:s"),
										'image'             => $data[11],
										'image2'            => $data[12],
										'image3'            => $data[13],
										'sku'               => $data[1],
										'product_whole_sale_price' => $data[6],
										'catalog'           => $data[7],
										'product_discount_price' => $data[8]
								);
								}
							}
                                	if( !empty( $post_data['store_id'] ) )
                                	{
                                   		if( $this->client_product_model->add( 'client_product', $post_data ) ) 
                                   		{
											$this->session->set_flashdata('success', "<li>Product has been added successfully.</li>");
										} 
										else 
										{
											$this->session->set_flashdata('error', "<li>Unknown Error: Unable to add product.</li>");
											$this->output->set_header('location:' . base_url() . 'product/manage');
										}	
                                	}
                            } 
                        	$this->output->set_header('location:' . base_url() . 'product/manage');
                        }  
                    fclose($CSVfp); @unlink($CSVfp) ;
				}
			}
		}
		ini_set('display_errors',0) ;
		$query_string = base64_encode($q_s);
		$table = 'client_product';
		//set pagination configs
		$config['base_url'] = base_url() . "product/manage";
		$config['total_rows'] = intval($this->client_product_model->get_allprod($page,PAGE_LIMIT,true, $q_s,$store_id ));
		$config['per_page'] = PAGE_LIMIT;	
			
		$this->pagination->initialize($config);
		
		//pr($config) ;
		
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		//fetch all users from database except current user and super user
		//pr($view_data);
        $clients  = $this->client_product_model->get_all_clients();
        
        $view_data['clients'] = $clients;
		$view_data['client_product'] = $this->client_product_model->get_allprod( $page, PAGE_LIMIT, false, $q_s,$store_id);

		foreach ($view_data['client_product'] as $key => $prvalue) {
			# code...
			
			$res[$prvalue->id] = $this->client_product_model->gettaxcode($prvalue->id) ;
		}
		//pr($res) ;
		$view_data['avatax'] = $res ;

		$this->_vci_view('product_manage', $view_data);
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: delete_client_product
	*	Description: Deletes a client_product from database and redirect to 
		manage_client_product
	-----------------------------------------------------------------
	*/

	function delete()
	{
		$this->_vci_layout( 'menu-toolbar' );
		$ids = $this->input->post('client_productids');
		$result = $this->client_product_model->delete('client_product', 'id', $ids );
		if($result){
		$this->session->set_flashdata('success', 'client Product Deleted Successfully.');
		$this->output->set_header('location:' . base_url() . 'product/manage');			
		}else
		{	
			$this->session->set_flashdata('errors', 'Error! not able to delete record.');
			$this->output->set_header('location:' . base_url() . 'product/manage');	
		}
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
			$this->output->set_header('location:' . base_url() . 'product/manage');
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
		$this->output->set_header('location:' . base_url() . 'product/manage' . (($page>0) ? '/' . $page : ''));
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


	function edit( $id = null )
	{	
		//error_reporting(0);
	    $store_id = $this->session->userdata('storeId');
	    if( empty( $store_id ) )
	    {
	        $store_id = $this->storeId();
	    }
	    $this->load->library('upload');
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
			'Manage client Product Settings' => array('link'=>'product/manage', 'attributes' => array('class'=>'breadcrumb')),
			'Edit client Product' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		$Category_Array = $this->client_category_model->get_all_client_category_dropdown_forstore($store_id);			
		foreach($Category_Array as $key => $category_ar)
		{
			$Category_Data[$category_ar->id.'@@'.$category_ar->name] = $category_ar->name;
		}
		$view_data['category_data'] = $Category_Data;
		
		$view_data['all_categories'] = $this->client_category_model->get_all_client_category_dropdown_forstore($store_id);
		
		// Create subcategory array  
		$product_details = $this->client_product_model->get_client_product_details($id);	
		
		$view_data['subcategories'] = $this->client_product_model->get_all_subcategories($product_details->category_id);	
		//check if form was submitted by the user
		if( $this->input->post('formSubmitted') > 0 ) 
		{
			//validates the post data by using the rules defined in config file
			if( $this->form_validation->run('product_edit') )
			{

				$post_data = array(
			        'store_id'      	=> $store_id,
			        'category_id'       =>  $this->input->post('category_id'),
					'subcategory_id'    =>  $this->input->post('subcategory'),
					'sku'               => htmlspecialchars($this->input->post('sku')),
					'product_title'     => htmlspecialchars($this->input->post('client_product_title')),
					'product_size'	    => htmlspecialchars($this->input->post('product_size')),
					'product_price'	    => round(htmlspecialchars($this->input->post('client_product_price')),2),
					'product_volume'	=> round(htmlspecialchars($this->input->post('client_product_volume')),2),
					'description'       => htmlspecialchars($this->input->post('description')),
					'status'            => $this->input->post('status'),
					'created'           => date("Y-m-d h:i:s"),
					'modified'          => date("Y-m-d h:i:s"),	
					'weight'			=> (int)$this->input->post('product_weight'),
			    );
				
				$filepath = false;
				
				// newly updated starts here
				$storedetail = $this->client_model->get_client_details($store_id) ;
				$storefolder = strtolower($storedetail->username.'_'.$storedetail->id.'/products/'.date('Y').'_'.date('F'));
				// newly updated part

				if(!empty($_FILES['image']['name']))
				{
					//$config['upload_path'] = '../uploads/products';
					$config['upload_path'] = '../uploads/'.$storefolder;
					if (!file_exists($config['upload_path'])) {
					    mkdir($config['upload_path'], 0775, true);
					    //mkdir($config['upload_path'].'/thumb', 0775, true);
					}
					// newly updated part

					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					 /* $config['max_size']	= '10000';
					$config['max_width']  = '2024';
					$config['max_height']  = '768';
					*/
					$config['max_size']	= '30000';
					$config['max_width']  = '5500';
					$config['max_height']  = '5500';
					$config['file_name']	= rand();
					$this->upload->initialize($config);
					if( ! $this->upload->do_upload('image'))
					{
						// invalid image type 
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('errors', 'Unknown Error: Invalid image - Unable to add product images.');
						header('location: ' . base_url() . 'product/edit/' . $this->client_productid);
						exit;
					}
					else
					{
						$uploadedData = $this->upload->data() ;
						// $filepath = '/uploads/products/'.$uploadedData['file_name'];
						$filepath = '/uploads/'.$storefolder.'/'.$uploadedData['file_name'];
					}				
				}

				if( $filepath )
				{
					$post_data['image'] = 	$filepath;
					if($product_details->image){
					  @unlink($_SERVER['DOCUMENT_ROOT'].$product_details->image) ;
					}					   
				}


				// new code
				if(!empty($_FILES['image2']['name']))
				{
					$config['upload_path'] = '../uploads/products';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '30000';
					$config['max_width']  = '5500';
					$config['max_height']  = '5500';
					$config['file_name']	= rand();
					$this->upload->initialize($config);
					
					if( ! $this->upload->do_upload('image2'))
					{
						// invalid image type 
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('errors', 'Invalid image2 - Unable to add product images please check dimensions.');
						header('location: ' . base_url() . 'product/edit/' . $this->client_productid);
						exit;
					}
					else
					{
						$uploadedData2 = $this->upload->data() ;
						$filepath2 = '/uploads/products/'.$uploadedData2['file_name'];
					}				
				}
				if( $filepath2 )
				{
					$post_data['image2'] = 	$filepath2;					   
				}

				if(!empty($_FILES['image3']['name']))
				{
					$config['upload_path'] = '../uploads/products';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '30000';
					$config['max_width']  = '5500';
					$config['max_height']  = '5500';
					$config['file_name']	= rand();
					$this->upload->initialize($config);
					
					if( ! $this->upload->do_upload('image3'))
					{
						// invalid image type 
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('errors', 'Invalid image3 - Unable to add product images please check dimensions.');
						header('location: ' . base_url() . 'product/edit/' . $this->client_productid);
						exit;
					}
					else
					{
						$uploadedData2 = $this->upload->data() ;
						$filepath3 = '/uploads/products/'.$uploadedData2['file_name'];
					}				
				}

				if( $filepath3 )
				{
					$post_data['image3'] = 	$filepath3;					   
				}
				// new code ends here

				if( $this->client_product_model->edit( 'client_product', $this->client_productid, $post_data ) ) {
					$this->session->set_flashdata('success', "<li>Product has been added successfully.</li>");
					$this->output->set_header('location:' . base_url() . 'product/manage/');
				} else {
					$this->session->set_flashdata('errors', "<li>Unknown Error: Unable to add product.</li>");
					$this->output->set_header('location:' . base_url() . 'product/edit/' . $this->client_productid);
				}
								  
			}
			$this->_vci_view('product_edit', $view_data);
		}
		else
		{
			//form not submitted load view normally
			$this->_vci_view('product_edit', $view_data);
		}

	}
	
	function getSubCategories( $cat_id = null )
	{
	    //echo trim($cat_id);die;
	    if( empty( $cat_id ) ) 
	    	return false;
	    $subcategories = $this->client_product_model->get_all_subcategories( $cat_id );	
	    $subcategory =  '<select name="subcategory" id="subcategory" >';
	    $subcategory .=  '<option value="" >Select Subcategory</option>';
	    foreach( $subcategories as $each_category )
	    {
	      $subcategory .= '<option value="'.$each_category->id.'">'.$each_category->name.'</option>';
	    }
	    
	    $subcategory .= '</select>';
	    echo $subcategory;die;
	    
	}

	function updatetaxcode(){
		
		if($_POST['product_id']  && $_POST['tax_code']){
			$this->db->from('client_product_avataxcode') ;
			$this->db->where('client_product_id',$_POST['product_id'] );
			$content = $this->db->get();

			if($content->num_rows > 0 ){
				// update code
				$record = $content->result_array() ;
				$recordid = $record[0]['id'] ;
			
				$data = array(
				'tax_code' => htmlspecialchars($_POST['tax_code'])
				);
			
				$this->db->where('id', $recordid);
				$this->db->update('client_product_avataxcode', $data);

			}else{
				$data = array(
				'client_product_id' => htmlspecialchars($_POST['product_id']),
				'tax_code' => htmlspecialchars($_POST['tax_code']),
				);		
			
				$this->db->insert('client_product_avataxcode', $data);
			
			
			}
			echo 1  ;
			exit;
		}

	}
		
} //class file end here

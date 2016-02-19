<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-------------------------------------------------------------
*	Class:	Offers extends VCI_Controller defined in libraries
*	Author:	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description: Manage offers
-------------------------------------------------------------
*/
class Offers extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('offers_model');
	}

	/*
	-----------------------------------------------
	*	Method: New User
	*	Description: Registers a new user.
	-----------------------------------------------
	*/
	function offers_new()
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$this->load->library('upload');
		
		$s_id = $this->session->userdata('user');
		$store_id = $s_id['id'];
		if( empty( $store_id ) )
		{
			$store_id = $this->storeId();
		}
		
		//sets the data form exporting to view
		$view_data = array('caption' => 'Add Offer');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Offers' => array('link'=>'offers/offers_manage', 'attributes' => array('class'=>'breadcrumb')),
			'Add Offer' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		
		if($this->input->post('formSubmitted') > 0) 
		{	
			if($this->form_validation->run('offer_add'))
			{	
				$post_data = array(
						'store_id'   => $store_id,
						'title'      => htmlspecialchars($this->input->post('title', true)),
						'image_text' => htmlspecialchars($this->input->post('image_text', true)),
						'link'       => htmlspecialchars($this->input->post('link', true)),
						'priority'   => htmlspecialchars($this->input->post('priority', true))
				);
				
				
				if(!empty($_FILES['image']))
				{
					$config['upload_path'] = '../uploads/products';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '50000';
					$config['max_width']  = '2024';
					$config['max_height']  = '768';
					$this->upload->initialize($config);
				
					if( ! $this->upload->do_upload('image'))
					{
						// invalid image type
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('errors', 'The Upload Image field is required');
						$this->output->set_header('location:' . base_url() . 'offers/offers_new');
					}
					else
					{
						$uploadedData = $this->upload->data() ;
						$filepath = '/uploads/products/'.$uploadedData['file_name'];
					}
				}
				if(	!$this->upload->display_errors() )
				{
					$post_data['image'] = 	$filepath;
					if( $this->offers_model->offers_add( $post_data ) ) 
					{
						$this->session->set_flashdata('success', $this->lang->line('offer_add_success'));
						$this->output->set_header('location:' . base_url() . 'offers/offers_manage');
					} 
					else 
					{
						$this->session->set_flashdata('error', "<li>Please try again, after some time.</li>");
						$this->output->set_header('location:' . base_url() . 'offers/offers_manage');
					}
				}
				
			} 
			else
			{
				$this->_vci_view('offers_new', $view_data);
			}
		} 
		else
		{
			$this->_vci_view('offers_new', $view_data);
		}
	}

	function url_validation()
	{
		$url = trim($_POST['link']);
		$pattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		if($url!='')
		{
			if (!@preg_match($pattern, $url))
			{
				$this->form_validation->set_message('url_validation', 'The Link field must contain a valid URL. Eg. http://www.google.com or www.google.com');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			return TRUE;
		}
	}

	/*
	-----------------------------------------------------------------
	*	Method: manage
	*	@param page integer
	*	Description: creates listing and handles search operations
	-----------------------------------------------------------------
	*/

	function offers_manage($page = 0)
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		
	    $store_id = $this->session->userdata('storeId');
	    if( empty( $store_id ) )
	    {
	        $store_id = $this->storeId();
	    }
		
		//prepare the data for exporting to view
		$view_data = array('caption' => 'Manage Offers');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Offers' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		//set pagination configs
		$config['base_url'] = base_url() . "offers/offers_manage";
		$config['total_rows'] = intval($this->offers_model->get_all_offers('','',true, $store_id ));
		$config['per_page'] = PAGE_LIMIT;		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		//fetch all users from database except current user and super user
		$view_data['offers'] = $this->offers_model->get_all_offers($page, PAGE_LIMIT, false, $store_id );
		
		$this->_vci_view('offers_manage', $view_data);
	}

	
	
	/*
	-----------------------------------------------------------------
	*	Method: delete_user
	*	Description: Deletes a user from database and redirect to 
		manage
	-----------------------------------------------------------------
	*/

	function offers_delete()
	{
		$this->_vci_layout('menu-toolbar');
		
		if($this->offers_model->delete_offers())
		{
			$this->session->set_flashdata('success', $this->lang->line('offers_del_success'));
			$this->output->set_header('location:' . base_url() . 'offers/offers_manage');
		}
		else {
		    $this->session->set_flashdata('errors',$this->lang->line('offers_del_failed'));
			$this->output->set_header('location:'. base_url(). 'offers/offers_manage');
		}
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: edit_user
	*	@param id integer
	*	Description: edit user information
	-----------------------------------------------------------------
	*/

	function offers_edit($id = null)
	{
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$this->load->library('upload');
		
		//get userid either from argument passed or from posted fields
		$offers_id = (isset($id)) ? $id : $this->input->post('id');
		//check if user id is not empty
		if(empty($offers_id))
		{
			$this->session->set_flashdata('errors', $this->lang->line('user_edit_id_error'));
			$this->output->set_header('location:' . base_url() . 'offers/offers_manage');
		}

		//prepare data to export to view
		$view_data = array('caption' => 'Edit offer');
		
		//get the user details by user id
		$view_data['offers'] = $this->offers_model->get_offers_details($offers_id);
		
		//set breadcrumb
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Manage Offers'=> array('link'=>'offers/offers_manage', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Offer' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		
		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{	
			//run the form validation using the rules defined in config file
			if($this->form_validation->run('offer_add'))
			{
				$post_data = array(
						'title'      => htmlspecialchars($this->input->post('title', true)),
						'image_text' => htmlspecialchars($this->input->post('image_text', true)),
						'link'       => htmlspecialchars($this->input->post('link', true)),
						'priority'   => htmlspecialchars($this->input->post('priority', true)),
						'modified'   => date("Y-m-d h:i:s")
				);
				
				if(!empty($_FILES['image']['name']))
				{
					$config['upload_path'] = '../uploads/products';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '50000';
					$config['max_width']  = '2024';
					$config['max_height']  = '768';
					$this->upload->initialize($config);
				
					if( ! $this->upload->do_upload('image'))
					{
						// invalid image type
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('errors', '<li>Image upload failed, Please try again.</li>');
						$this->output->set_header('location:' . base_url() . 'offers/offers_manage');
					}
					else
					{
						$uploadedData = $this->upload->data() ;
						$filepath = '/uploads/products/'.$uploadedData['file_name'];
					}
				}
				if(	!$this->upload->display_errors() )
				{
					if(!empty($_FILES['image']['name']))
					{
						$post_data['image'] = 	$filepath;
					}
				
					
					if( $this->offers_model->update_offers( $offers_id, $post_data ) ) 
					{
						$this->session->set_flashdata('success', $this->lang->line('offers_update_success'));
						$this->output->set_header('location:' . base_url() . 'offers/offers_manage');
					} 
					else 
					{
						$this->session->set_flashdata('error', $this->lang->line('offers_update_fail'));
						$this->output->set_header('location:' . base_url() . 'offers/offers_manage');
					}
				}
			} 
			else
			{
				//form validation fails load the view.
				$this->_vci_view('offers_edit', $view_data);
			}
		} 
		else
		{
			//load the view normally
			$this->_vci_view('offers_edit', $view_data);
		}
	}
}
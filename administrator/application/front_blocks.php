<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
-------------------------------------------------------------
*	Class:	Front_blocks extends VCI_Controller defined in libraries
*	Author:	
*	Platform:	Codeigniter
*	Company:	Cogniter Technologies
*	Description: Manage user entity
-------------------------------------------------------------
*/
class Front_blocks extends VCI_Controller {
	
	# Class constructor
	function __construct()
	{
		parent::__construct();
		$this->load->model('front_blocks_model');
	}

	/*
	-----------------------------------------------
	*	Method: New User
	*	Description: Registers a new user.
	-----------------------------------------------
	*/
	function front_blocks_new()
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
		$view_data = array('caption' => 'Add Front Block');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Store Front Settings' => array('link'=>'front_blocks/front_blocks_manage', 'attributes' => array('class'=>'breadcrumb')),
			'Add Front Block' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		$view_data['crumbs'] = $crumbs;
		
		if($this->input->post('formSubmitted') > 0) 
		{	
			if($this->form_validation->run('front_block_add'))
			{	
				
				$post_data = array(
						'store_id'   => $store_id,
						'title'      => htmlspecialchars($this->input->post('title', true)),
						'image_text' => htmlspecialchars($this->input->post('image_text', true)),
						'image'		 => htmlspecialchars($this->input->post('image', true)),
						'link'       => htmlspecialchars($this->input->post('link', true)),
						'priority'   => htmlspecialchars($this->input->post('priority', true))
				);
				
				
				if( $this->front_blocks_model->front_block_add( $post_data ) ) 
				{
					$this->session->set_flashdata('success', $this->lang->line('block_add_success'));
					$this->output->set_header('location:' . base_url() . 'front_blocks/front_blocks_manage');
				} 
				else 
				{
					$this->session->set_flashdata('error', "<li>Please try again, after some time.</li>");
					$this->output->set_header('location:' . base_url() . 'front_blocks/front_blocks_manage');
				}
			} 
			else
			{
				$this->_vci_view('front_blocks_new', $view_data);
			}
		} 
		else
		{
			$this->_vci_view('front_blocks_new', $view_data);
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

	function front_blocks_manage($page = 0)
	{
		$this->_vci_layout('menu-toolbar');
		$this->load->library('pagination');
		
	    $store_id = $this->session->userdata('storeId');
	    if( empty( $store_id ) )
	    {
	        $store_id = $this->storeId();
	    }
		
		//prepare the data for exporting to view
		$view_data = array('caption' => 'Store Front Settings');
		$crumbs = breadcrumb(array(
			'Desktop' => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Store Front Settings(Blocks)' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		
		//set pagination configs
		$config['base_url'] = base_url() . "front_blocks/front_blocks_manage";
		$config['total_rows'] = intval($this->front_blocks_model->get_all_blocks('','',true, $store_id ));
		$config['per_page'] = PAGE_LIMIT;		
		$this->pagination->initialize($config);
		$view_data['pagination'] = $this->pagination->create_links();
		$view_data['crumbs'] = $crumbs;
		//fetch all users from database except current user and super user
		$view_data['front_blocks'] = $this->front_blocks_model->get_all_blocks($page, PAGE_LIMIT, false, $store_id );
		
		$this->_vci_view('front_blocks_manage', $view_data);
	}

	
	
	/*
	-----------------------------------------------------------------
	*	Method: delete_user
	*	Description: Deletes a user from database and redirect to 
		manage
	-----------------------------------------------------------------
	*/

	function front_blocks_delete()
	{
		$this->_vci_layout('menu-toolbar');
		
		if($this->front_blocks_model->delete_front_blocks())
		{
			$this->session->set_flashdata('success', $this->lang->line('blocks_del_success'));
			$this->output->set_header('location:' . base_url() . 'front_blocks/front_blocks_manage');
		}
		else {
		    $this->session->set_flashdata('errors',$this->lang->line('front_blocks_del_failed'));
			$this->output->set_header('location:'. base_url(). 'front_blocks/front_blocks_manage');
		}
	}
	
	/*
	-----------------------------------------------------------------
	*	Method: edit_user
	*	@param id integer
	*	Description: edit user information
	-----------------------------------------------------------------
	*/

	function front_blocks_edit($id = null)
	{
		//set required things
		$this->_vci_layout('menu-toolbar');
		$this->load->library('form_validation');
		$this->load->library('upload');
		
		//get userid either from argument passed or from posted fields
		$front_block_id = (isset($id)) ? $id : $this->input->post('id');
		//check if user id is not empty
		if(empty($front_block_id))
		{
			$this->session->set_flashdata('errors', $this->lang->line('user_edit_id_error'));
			$this->output->set_header('location:' . base_url() . 'front_blocks/front_blocks_manage');
		}

		//prepare data to export to view
		$view_data = array('caption' => 'Edit Front Blocks');
		
		//get the user details by user id
		$view_data['blocks'] = $this->front_blocks_model->get_front_blocks_details($front_block_id);
		
		//set breadcrumb
		$crumbs = breadcrumb(array(
			lang('desktop') => array('link'=>'/', 'attributes' => array('class'=>'breadcrumb')),
			'Store Front Settings(Blocks)'=> array('link'=>'front_blocks/front_blocks_manage', 'attributes' => array('class'=>'breadcrumb')),
			'Edit Front Block' => array('link'=>null, 'attributes' => array('class'=>'breadcrumb')),
		));
		$view_data['crumbs'] = $crumbs;
		
		//check if form was submitted by the user
		if($this->input->post('formSubmitted') > 0) 
		{	
			//run the form validation using the rules defined in config file
			if($this->form_validation->run('front_block_add'))
			{
				$post_data = array(
					'title'      => htmlspecialchars($this->input->post('title', true)),
					'image_text' => htmlspecialchars($this->input->post('image_text', true)),
					'image'		 => htmlspecialchars($this->input->post('image', true)),
					'link'       => htmlspecialchars($this->input->post('link', true)),
					'priority'   => htmlspecialchars($this->input->post('priority', true)),
					'modified'   => date("Y-m-d h:i:s")
				);

				if( $this->front_blocks_model->update_front_blocks( $front_block_id, $post_data ) ) 
				{
					$this->session->set_flashdata('success', $this->lang->line('block_update_success'));
					$this->output->set_header('location:' . base_url() . 'front_blocks/front_blocks_manage');
				} 
				else 
				{
					$this->session->set_flashdata('error', $this->lang->line('block_update_fail'));
					$this->output->set_header('location:' . base_url() . 'front_blocks/front_blocks_manage');
				}
			}
			else
			{
				//form validation fails load the view.
				$this->_vci_view('front_blocks_edit', $view_data);
			}
		} 
		else
		{
			//load the view normally
			$this->_vci_view('front_blocks_edit', $view_data);
		}
	}
	
	function img_save_to_file() {
		$imagePath = ROOT_DIR . '/uploads/blocks/';

		$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
		$temp = explode(".", $_FILES["img"]["name"]);
		$extension = end($temp);
		
		//Check write Access to Directory
		if(!is_writable($imagePath)){
			$response = Array(
				"status" => 'error',
				"message" => 'Can`t upload File; no write Access '. $imagePath
			);
			print json_encode($response);
			return;
		}
		
		if ( in_array($extension, $allowedExts)) {
			if ($_FILES["img"]["error"] > 0) {
				 $response = array(
					"status" => 'error',
					"message" => 'ERROR Return Code: '. $_FILES["img"]["error"],
				);			
			} else {
				$filename = $_FILES["img"]["tmp_name"];
				list($width, $height) = getimagesize( $filename );

				move_uploaded_file($filename,  $imagePath . $_FILES["img"]["name"]);

				$response = array(
					"status" => 'success',
					"url" => ROOT_PATH . '/uploads/blocks/' . $_FILES["img"]["name"],
					"width" => $width,
					"height" => $height
				);
			}
		} else {
			$response = array(
				"status" => 'error',
				"message" => 'something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini',
			);
		}
		print json_encode($response);
		die;
	}
	
	function img_crop_to_file() {
		$imgUrl = $_POST['imgUrl'];
		// original sizes
		$imgInitW = $_POST['imgInitW'];
		$imgInitH = $_POST['imgInitH'];
		// resized sizes
		$imgW = $_POST['imgW'];
		$imgH = $_POST['imgH'];
		// offsets
		$imgY1 = $_POST['imgY1'];
		$imgX1 = $_POST['imgX1'];
		// crop box
		$cropW = $_POST['cropW'];
		$cropH = $_POST['cropH'];
		// rotation angle
		$angle = $_POST['rotation'];

		$jpeg_quality = 100;

		$filename	= 'blockImg_'.rand();
		$output_filename = ROOT_DIR . '/uploads/blocks/' . $filename;

		// uncomment line below to save the cropped image in the same location as the original image.
		//$output_filename = dirname($imgUrl). "/croppedImg_".rand();

		$what 	= getimagesize($imgUrl);
		$ext	= pathinfo($imgUrl, PATHINFO_EXTENSION);
		
		//switch(strtolower($what['mime']))
		switch($ext)
		{
			case 'png':
				$img_r = imagecreatefrompng($imgUrl);
				$source_image = imagecreatefrompng($imgUrl);
				$type = '.png';
				break;
			case 'jpg':
			case 'jpeg':
				$img_r = imagecreatefromjpeg($imgUrl);
				$source_image = imagecreatefromjpeg($imgUrl);
				error_log("jpg");
				$type = '.jpeg';
				break;
			case 'gif':
				$img_r = imagecreatefromgif($imgUrl);
				$source_image = imagecreatefromgif($imgUrl);
				$type = '.gif';
				break;
			default: die('image type not supported');
		}

		//Check write Access to Directory
		if (!is_writable(dirname($output_filename))) {
			$response = Array(
				"status" => 'error',
				"message" => 'Can`t write cropped File'
			);	
		} else {
			// resize the original image to size of editor
			$resizedImage = imagecreatetruecolor($imgW, $imgH);
			imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
			// rotate the rezized image
			$rotated_image = imagerotate($resizedImage, -$angle, 0);
			// find new width & height of rotated image
			$rotated_width = imagesx($rotated_image);
			$rotated_height = imagesy($rotated_image);
			// diff between rotated & original sizes
			$dx = $rotated_width - $imgW;
			$dy = $rotated_height - $imgH;
			// crop rotated image to fit into original rezized rectangle
			$cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
			imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
			imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
			// crop image into selected area
			$final_image = imagecreatetruecolor($cropW, $cropH);
			imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
			imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
			// finally output png image
			//imagepng($final_image, $output_filename.$type, $png_quality);
			imagejpeg($final_image, $output_filename.$type, $jpeg_quality);
			$response = Array(
				"status" => 'success',
				"url" => ROOT_PATH . '/uploads/blocks/' . $filename .$type
			);
		}
		print json_encode($response);
		die;
	}
}

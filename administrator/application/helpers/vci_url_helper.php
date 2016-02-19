<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();
$CI->load->helper('url');

function layout_url($rpath = null)
{
	return (!is_null($rpath))? base_url() . 'application/views/' . $rpath :base_url() . 'application/views/';
}

function breadcrumb($links = array(), $delimiter = '<span class="breadcrumb">></span>')
{
	
	
	$CI 	= &get_instance();
	$user	= $CI->session->userdata('user');
	if(1) {
		$crumb	= '';
		foreach ($links as $display => $data) {
			if(isset($data['link']) && !empty($data['link'])) {
				$breadcrumb = $data['link'] != "" ? '<a href="' . site_url() . $data['link'] . '">'.$display.'</a>' : $display;
				$crumb	.= '<li>'.$breadcrumb.'</li>';
			} else {
				$crumb	.= '<li>'.$display.'</li>';
			}
		}
		
		return $crumb;
	}
	
	if(!is_array($links) && count($links) <= 0)
		return false;

	foreach($links as $name => $detail)
	{
		if((!isset($crumb)) || empty($crumb))
		{
			if(!empty($detail['link']))
			{
				$crumb = anchor($detail['link'], $name, $detail['attributes']) . '&nbsp;';
			} else
			{
				$crumb = '<label ';
				if(is_array($detail['attributes']) && !empty($detail['attributes']))
				{
					foreach($detail['attributes'] as $key => $value)
					{
						$crumb .= " $key='$value' "; 
					}
				}
				$crumb .= '>' . $name . '</label>' . '&nbsp;';
			}
		} else if(!empty($detail['link']))
		{
			$crumb .= $delimiter . '&nbsp;' . anchor($detail['link'], $name, $detail['attributes']);
		} else
		{
			$crumb .= '&nbsp;' . $delimiter . '&nbsp;<label ';
			if(is_array($detail['attributes']) && !empty($detail['attributes']))
			{
				foreach($detail['attributes'] as $key => $value)
				{
					$crumb .= " $key='$value' "; 
				}
			}
			$crumb .= '>' . $name . '</label>';
		}
	}

	return $crumb;

}

function wrapstr($str, $maxchars = 50, $wordlength = 20) {
	$str = wordwrap($str, $wordlength, "\n", true);
	
	if(strlen($str) >= $maxchars)
		$str = substr($str, 0, $maxchars) . '...';
	
	return $str;
}

function root_path($path = "") {
	$root = dirname(dirname(dirname(dirname(__FILE__))));
	
	if(!empty($path)) {
		$root .= '/uploads'.$path;
	}
	
	$root = str_replace('\\', DIRECTORY_SEPARATOR, str_replace('/',DIRECTORY_SEPARATOR,$root));
	return $root;
}

/*
-----------------------------------------------------
*	method name image_exist()
*	@param $folder =/folder name after uploads/
*	@param $edit-> if you are on edit page pass =1
*	@param $filename->your image name
-----------------------------------------------------
*/
function image_exist($folder = null ,$filename = null, $edit = null)
{
	global $CI;
	$default = "uploads".$folder."noimage.jpg";

	if(!empty($filename)) 
		if(!empty($filename)) 
		{
			if( file_exists(root_path($folder.$filename)) )
					return $CI->config->item('root_url').'uploads'.$folder.$filename;
			else
					return $CI->config->item('root_url').$default;
		}
}

function store_fallback_path($rpath = null)
{
	$co = & get_instance() ;
	$co->load->model('common_model');
    // Call a function of the model
    $store = $co->common_model->get_clientdetail(trim(strtolower($co->storename)));

    if(@$store[0]['is_custom_theme']){
    	$layoutpath  = trim(strtolower($co->storename)).'_'.trim(strtolower($co->store_id)).'/' . trim(strtolower($rpath)) ; 
		if(file_exists( APPPATH.'views/'.$layoutpath)){
			
			return (!is_null($rpath))? base_url() . 'application/views/' . $layoutpath :base_url() . 'application/views/';
		}else{
			
			return (!is_null($rpath))? base_url() . 'application/views/default/' . $rpath :base_url() . 'application/views/';
		}
    }
    return (!is_null($rpath))? base_url() . 'application/views/default/' . $rpath :base_url() . 'application/views/';
}

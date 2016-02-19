<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();
$CI->load->helper('url');

function set_value($field = '', $default = '') {
	global $CI;
	if (FALSE === ($OBJ =& _get_validation_object()))
	{
		if ( ! isset($_POST[$field]))
		{
			return $default;
		}

		return form_prep($_POST[$field], $field);
	}

	$val = form_prep($OBJ->set_value($field, $default), $field);
	
	if(empty($val)) {
		return $CI->input->post($field);
	} else {
		return $val;
	}
}

?>
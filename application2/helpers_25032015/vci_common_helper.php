<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
# Helper  :  Common Helper
# Purpose : Common function and validation defination
# company : Cogniter Technology
# Generate a Random String 
function str_random($length=6)
{
	$str = '';
	if($length > 0 )
	{
		for($i=0;$i<$length;$i++)
		{

			if($i % 2 ==0)
			{
				if(rand(1,10) % 2 == 0 )
				{
					switch (rand(1,6))
					{
						case 1:
							$str	.=	'~';
							break;
						case 2:	
							$str	.=	'!';
							break;
						case 3:
							$str	.=	'#';
							break;
						case 4:
							$str	.=	'%';
							break;
						case 5:
							$str	.=	'^';
							break;
						case 6:
							$str	.=	'*';
							break;
					}
				}
				else
				{
					$str .= rand(0,9);
				}
			}
			else
			{
				$num = rand(97,122);
				$str .= chr($num);
			}		
		}
	}
	return $str;
}

# Phone Number Validation, this will validate all types of phone number formats
function valid_phone1($phone_number)
{
	$phone_regex = '/^(\+?\(\d{1,3}\)|\(\+?\d{1,3}\))?[ .,-]?\(?\d{3}\)?[ .,-]?\(?\d{3}\)?[ .,-]?\(?\d{4}\)?([ ,.-]?(x|ex)?[ :]?[ ]?\d{3,5})?$/';		
	return ( ! preg_match($phone_regex, $phone_number)) ? FALSE : TRUE;
}

function valid_phone($phone_number)
{
	$phone_regex = '/^[ +.,()0-9-]+$/';		
	return ( ! preg_match($phone_regex, $phone_number)) ? FALSE : TRUE;
}

# validate email address
function email_validation($str)
{
	return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function valid_domain($domain_name)
{
	$regex = '/^(http|https|ftp)\:\/\/([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|localhost|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*$/';	
	return ( ! preg_match($regex, $domain_name ) ) ? FALSE : TRUE;
}

/**
 * Functionwill performs logged in check using session
 * @params		: $url to redirect
 * @return		: void
 */
function is_logged_in($url) //start func
{
	$CI = &get_instance();
    if($CI->session->userdata['customer']['logged_in'])
	{
		$CI->output->set_header('location:' . base_url() . $url);
	}
} // end func


/**
 * Function will check for logged in user session.
 * @params string $url
 * @return void
 */
function is_not_logged_in($url) //start func
{
    $CI = &get_instance();
	if(!$CI->session->userdata['customer']['logged_in'])
	{
		$CI->output->set_header('location:' . base_url() . $url);
	}
} // end func

/**
 * Encrypts the string using base_64
 * 
 * @param string $string
 * String to be encrypted
 */
function encrypt($string)
{
	return urlencode(base64_encode($string));
}

/**
 * Decrypts the encrypted string using base64
 * 
 * @param string $string
 * String to be decrypted
 */
function decrypt($string)
{
	return base64_decode(urldecode($string));
}

/**
* Function will store information required for user referral.
*
* @access	public
* @return	void
*/
function process_ref_link() //start func
{
	$CI = &get_instance();
	$uri_arr		= $CI->uri->segment_array();
	if(in_array('signup', $uri_arr) && count($uri_arr) > 2)
	{
		$referral_id	= end($uri_arr);
		$CI->session->set_userdata('referral_id', $referral_id);
	}
	return true;
} // end func

	/**
	 * Create customer's referral link
	 */
function create_ref_link() //start func
{
	$CI 		= &get_instance();	
	$url		= base_url();
	$user_id	= isset($CI->session->userdata['customer']['id']) ? $CI->session->userdata['customer']['id'] : '';
	if($user_id)
	{
		$enc_id	= urlencode(base64_encode($user_id));
		$url	.= 'customer/signup/'.$enc_id;
	}
	return $url;
} // end func

/**
 * Function will retured trimmed value of a string.
 * 
 * @param string $string
 * @param integer $limit Optional
 */

function trim_desc($string, $limit = 40)
{
	$return_str	= $string;
	if(strlen($string) > $limit )
		$return_str	= substr($string, 0, $limit).'..';
		
	return $return_str;	
}

?>
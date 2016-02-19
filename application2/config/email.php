<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| --------------------------------------------------
| EMAIL CONFIG
| --------------------------------------------------
| configuration of outgoing mail server
|
*/

# Note : dont enable both the setting at same time

/*
* Sendmail settings 
* Enable these setting when loading site at segnant
*/
/*---------------Starts---------------------------*/

/*
$config['protocol']     = 'sendmail';
$config['mailpath']     = '/usr/sbin/sendmail';
$config['charset']      = 'iso-8859-1';
$config['wordwrap']     = TRUE;
*/

/*---------------Ends---------------------------*/

/*
* SMTP settings 
* Enable these settings when running on local machine
*/
/*---------------Starts---------------------------*/

$config['protocol']     = 'smtp';
$config['smtp_host']    = 'mail.simplesalessystems.com';
$config['smtp_port']    = '25';
$config['smtp_timeout'] = '7';
$config['smtp_user']    = 'smtp@simplesalessystems.com';
$config['smtp_pass']    = '8$McfKBvk@5q';

/*---------------Ends---------------------------*/


/*
* Common Settings
*/
/*---------------Starts---------------------------*/
$config['charset']      = 'utf-8';
$config['newline']      = "\r\n";
$congif['mailtype']		= 'html';	
$config['validation']   = TRUE;//whether to validate email or not
/*---------------Ends---------------------------*/

/* End of file email.php */
/* Location: ./system/application/config/email.php */

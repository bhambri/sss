<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

# Common Site settings and messages
/*---------------Start-----------------------*/
$lang['site_name']			= 'Simple Sales Systems';
if($_SERVER['SERVER_NAME'] !='http://simplesales.com/'){
	$lang['site_name']			= $_SERVER['SERVER_NAME'] ;
}

$lang['site_version']		= 'Version 2.0 CI';
$lang['error_invalid_user']	= '<li>Invalid username or password.</li>';
$lang['error_invalid_email']= '<li>Invalid email address</li>';
$lang['logout_success']		= '<li>User has been logged out successfully.</li>';
$lang['btn_login']			= 'Login';
$lang['btn_logout']			= 'Logout';
$lang['btn_update']			= 'Update';
$lang['footer_bookmark']	= 'Bookmark this page';
$lang['copy_right']			= 'All rights reserved %s.';
$lang['footer_design_by']	= 'Designed by %s.';
$lang['footer_best_view_suggestions'] = 'Best viewed at 1024 x 768 or higher resolution.';
$lang['thm']				= 'Theme';
$lang['default_thm']		= 'Default Theme';
$lang['thm_blue']			= 'Blue';
$lang['thm_green']			= 'Green';
$lang['thm_grey']			= 'Grey';
$lang['thm_purple']			= 'Purple';
$lang['thm_mosaic']			= 'Mosaic';
$lang['thm_transparent']	= 'Transparent';
$lang['thm_snowy']			= 'Snowy';
$lang['home']				= 'Home';
$lang['dashboard']			= 'Dashboard: %s';
$lang['desktop']			= 'Desktop';

/*---------------Ends-----------------------*/

//--------------------- Menus -------------------------
/*---------------Start-----------------------*/
$lang['user_menu']				= 'Users';
$lang['user_menu_newuser']		= 'New User';
$lang['user_menu_manageuser']	= 'Manage Users';
$lang['content_menu']			= 'Content';
$lang['content_menu_newpage']	= 'Add Page';
$lang['content_menu_managecontent']	= 'Manage Content';
/*---------------Ends-----------------------*/

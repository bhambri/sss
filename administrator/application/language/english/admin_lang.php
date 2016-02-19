<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*
*	Required Admin Language Variables 
*	Labels
*/
$lang['username']			= 'Username';
$lang['password']			= 'Password';
$lang['conf_password']		= 'Confirm Password';
$lang['store_detail']		= 'Store Detail';
$lang['first_name']			= 'First Name';
$lang['full_name']			= 'Full Name';
$lang['last_name']			= 'Last Name';
$lang['email']				= 'Email Address';
$lang['address']			= 'Address';
$lang['city']				= 'City';
$lang['state']				= 'State/Province';
$lang['country']			= 'Country';
$lang['status']				= 'Status';
$lang['zip_code']			= 'Zip Code';
$lang['phone']				= 'Phone Number';

$lang['fax']				= 'Fax Number';
$lang['sale_support_email']	= 'Sale Support Email';
$lang['partner_support_email']= 'Partnership Support Email';
$lang['technical_support_email']= 'Technical Support Email';
$lang['about_us_link']		= 'About Us Page Link';
$lang['opportunity_link']	= 'Opportunity Page Link';

$lang['active']				= 'Is Active ?';									 
$lang['delete']				= 'Delete';
$lang['new']				= 'New';
$lang['actions']			= 'Actions';
$lang['action']			    = 'Action';
$lang['approved']			= 'Approved';
$lang['commission']			= 'Commission';
$lang['login_welcome_text'] = 'Welcome to %s!<br /><br />Use a valid username and password to gain access to the administration console.';
$lang['login_forgotpassword_text'] = 'Welcome to %s!<br /><br />Use a valid email address to retrieve your password to get access to the administration console.';
$lang['forgot_password']	= 'Forgot Password?';
$lang['mandatory_fields_notice'] = 'Fields marked with (*) are mandatory.';
$lang['newuser_caption']	= 'Add New User';
$lang['edituser_caption']	= 'Edit User';
$lang['editclient_caption'] = "Edit Client/Store";
$lang['newclient_caption']  = "Add New Client/Store";
$lang['manageuser_caption'] = 'Manage Users';
$lang['users_not_found']	= 'No Users Found.';
$lang['commission_order_not_found'] = 'No Commission Order Found.';
$lang['override_order_not_found'] = 'No Override Order Found.';
$lang['consultants_not_found'] = 'No Consultants Found.';
$lang['comm_setting_not_found'] = 'No Commission Settings Found.';
$lang['invite_not_found']   = 'No Invite(s) found.';
$lang['blocks_not_found']   = 'No Front Block(s) Found.';
$lang['offers_not_found']   = 'No Offer(s) Found.';
$lang['template_not_found'] = 'No Email Template(s) found.';
$lang['category_not_found']	= 'No Categories Found.';
$lang['orders_not_found']	= 'No Orders Found.';
$lang['executive_not_found']= 'No Executive Level(s) Found.';
$lang['group_purchase_not_found']	= 'No Group Purchase Found.';
$lang['subcat_not_found']	= 'No Sub Categories Found.';
$lang['char_left']			= 'Characters left.';
$lang['search']				= 'Search';
$lang['name']				= 'Name';
$lang['manageclient_caption'] = 'Manage Clients';
$lang['add_new_category_caption'] = 'Add New Category';
$lang['category_name']      = 'Category Name';

/*
* Button's Label Start
*/

$lang['btn_submit']			= 'Submit';
$lang['btn_add']			= 'Add';
$lang['btn_reset']			= 'Reset';
$lang['btn_edit']			= 'Edit';
$lang['btn_retrieve']		= 'Retrieve';
$lang['btn_cancel']			= 'Cancel';
$lang['btn_search']			= 'Search';
/*
* Buttons's Label end
*/


# User  messages starts
/*---------------Start-----------------------*/
$lang['user_del_success']	= '<li>User(s) have been deleted successfully.</li>';
$lang['consultant_del_success']	= '<li>Consultant(s) have been deleted successfully.</li>';
$lang['blocks_del_success'] = '<li>Front Block(s) have been deleted successfully.</li>';
$lang['front_blocks_del_failed'] = '<li>Front Block(s) have not deleted, Please try again.</li>';
$lang['block_add_success'] = '<li>Front Block has been added successfully.</li>';
$lang['block_updated_success'] = '<li>Front Block has been updated successfully.</li>';
$lang['block_updated_fail'] = '<li>Front Block has not updated, Please try again.</li>';

$lang['offers_del_success'] = '<li>Offer(s) have been deleted successfully.</li>';
$lang['offers_del_failed'] = '<li>Offer(s) have not deleted, Please try again.</li>';
$lang['offers_add_success'] = '<li>Offers has been added successfully.</li>';
$lang['offers_updated_success'] = '<li>Offers has been updated successfully.</li>';
$lang['offers_updated_fail'] = '<li>Offers has not updated, Please try again.</li>';

$lang['invite_del_success'] = '<li>Invite(s) have been deleted successfully.</li>';
$lang['invite_del_failed'] = '<li>Invite(s) have not been deleted successfully. Please try again.</li>';
$lang['client_reg_success'] = '<li>Client/Store has been registered successfully.</li>';
$lang['executive_level_add_success'] = '<li>Executive level has been added successfully.</li>';
$lang['executive_del_success'] = '<li>Executive level(s) have been deleted successfully.</li>';
$lang['executive_del_failed'] = '<li>Executive level(s) have not deleted, Please try again.</li>';
$lang['commission_add_success'] = '<li>Commission has been added successfully.</li>';
$lang['consultant_invite_success'] = '<li>Consultant has been added/invited successfully.</li>';
$lang['invite_update_success'] = '<li>Invite has been updated successfully.</li>';
$lang['executive_upd_success'] = '<li>Executive Level has been updated successfully.</li>';
$lang['template_update_success'] = '<li>Email template has been updated successfully.</li>';
$lang['template_update_fail'] = '<li>Email template has not been updated. Please try again.</li>';
$lang['invite_resend_success'] = '<li>Invite has been resend successfully.</li>';
$lang['invite_resend_error'] = '<li>Invite has not been resend, Please try again.</li>';
$lang['commission_update_success'] = '<li>Commission has been updated successfully.</li>';
$lang['commission_error'] = '<li>Commission has not been added/updated, Please try after some time.</li>';
$lang['consultant_invite_errors'] =  '<li>Consultant has not been invited/added/updated, Please try after some time.</li>';
$lang['client_upd_success'] = '<li>Client/Store has been updated successfully.</li>';
$lang['client_updation_failed'] = '<li>Client/Store has not been updated, Please contact with admin.</li>';
$lang['user_del_failed']	= '<li>User(s) have not been deleted successfully. Please try again.</li>';
$lang['consultant_del_failed']	= '<li>Consultant(s) have not been deleted successfully. Please try again.</li>';
$lang['user_edit_id_error'] = '<li>Unexpected error occured. Unable to find user id for updating user.</li>';
$lang['consultant_edit_id_error'] = '<li>Unexpected error occured. Unable to find consultant id for updating consultant.</li>';
$lang['commission_edit_id_error'] = '<li>Unexpected error occured. Unable to find commission id for updating commission.</li>';
$lang['user_reg_success']	= '<li>A new user has been registered successfully.</li>';
$lang['user_upd_success']	= '<li>User has been updated successfully.</li>';
$lang['consultant_upd_success']	= '<li>Consultant has been updated successfully.</li>';
$lang['user_search_instructions'] = "<small>&#8226; Use blank search to see all records.</small><br /><small>&#8226; Search with in Username. </small>";
$lang['retrieved_password'] = 'Retrieved Password';
/*---------------Ends-----------------------*/


# Forget password email messages
/*---------------Start-----------------------*/
$lang['forgot_dear_txt'] = 'Dear %s,';
$lang['forgot_username_txt'] = "Your username is : <b>%s</b> ";
$lang['forgot_password_txt'] = " and password is : <b>%s</b>";
$lang['password_sent_successfully'] = "Password is sent to your email id";
$lang['password_sent_failed'] = "Please try after some time";
/*---------------Ends-----------------------*/

/**
* Contact Us Messages
*/
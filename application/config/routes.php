<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = '';

//consultant-store product detail page
$route['(:any)/(:any)/store/productDetail/(:any)'] = 'store/clientproductDetail/$1';

//client-store product detail 
$route['(:any)/store/productDetail/(:any)'] = 'store/productDetail/$1';

$route['(:any)/store/About-Us'] = 'store/about';
$route['(:any)/store/register-consultant'] = 'store/register_consultant';

#$route['(:any)/store/home']='store/home';


$route['(:any)/(:any)/store/search'] = 'store/search_consultantproducts';
$route['(:any)/store/search'] = 'store/search_products';

//consultant-store category products
$route['(:any)/(:any)/store/cat_id/(:num)/(:any)'] = 'store/clientcatproducts/(:num)/(:any)';
$route['(:any)/(:any)/store/cat_id/(:any)'] = 'store/clientcatproducts';

//client-store page starts now
$route['(:any)/store/cat_id/(:num)/(:any)'] = 'store/catproducts/(:num)/(:any)';
$route['(:any)/store/cat_id/(:any)'] = 'store/catproducts';

// consultant-store product listing
$route['(:any)/(:any)/store'] = 'store/clientproducts';
$route['(:any)/(:any)/store/(:any)'] = 'store/clientproducts';

#$route['(:any)/(:any)/home'] = 'store/index';

$route['(:any)/(:any)/news_detail/(:any)'] = 'store/news_detail/$3' ;
$route['(:any)/(:any)/event_detail/(:any)'] = 'store/event_detail/$3' ;

$route['(:any)/news_detail/(:any)'] = 'store/storenews_detail/$2' ;

// for consultant event page
$route['(:any)/(:any)/event'] = 'store/consultant_event' ;
$route['(:any)/(:any)/event/(:any)'] = 'store/consultant_event/$1' ;


// for consultant event page
$route['(:any)/(:any)/news'] = 'store/consultant_news' ;
$route['(:any)/(:any)/news/(:any)'] = 'store/consultant_news/$1' ;

$route['(:any)/news/(:any)'] = 'store/store_news/$2' ;
$route['(:any)/news'] = 'store/store_news' ;

//client store section starts now
$route['(:any)/store'] = 'store/products';
$route['(:any)/store/(:any)'] = 'store/products';

//consultant home pages
$route['(:any)/(:any)/home']='store/consultant_home';
$route['(:any)/home'] = 'store/index';

//consulatnt remove item from a cart
$route['(:any)/(:any)/cart/removeitem/(:any)'] = 'cart/consultant_removeitem/$3';
$route['(:any)/cart/removeitem/(:any)'] = 'cart/removeitem/$2';

$route['(:any)/(:any)/cart/removeopt/(:any)/(:any)'] = 'cart/consultant_removeopt/$3/$4';
$route['(:any)/cart/removeopt/(:any)/(:any)'] 		 = 'cart/removeopt/$2/$3';

//consultant-store prod. adding listing to cart
$route['(:any)/(:any)/cart/add'] = 'cart/consultantadd';
$route['(:any)/(:any)/cart'] = 'cart/consultantmanage';

//store client adding listing product to cart
$route['(:any)/cart/add'] = 'cart/add';
$route['(:any)/cart'] = 'cart/manage';

//consultant checkout page
$route['(:any)/(:any)/cart/checkout'] = 'cart/consultantcheckout';

// store client-checkout page
$route['(:any)/cart/checkout'] = 'cart/checkout';

//consultant thanks and success page on purchase
$route['(:any)/(:any)/cart/thanks'] = 'cart/consultantthanks';
$route['(:any)/(:any)/cart/success'] = 'cart/consultantsuccess';

//store success pay thanks page on purchase
$route['(:any)/cart/payment'] = 'cart/payment';
$route['(:any)/cart/success'] = 'cart/success';

$route['(:any)/cart/thanks'] = 'cart/thanks';

$route['(:any)/(:any)/cart/cancel'] = 'cart/cancel';
$route['(:any)/cart/cancel'] = 'cart/cancel';

$route['(:any)/(:any)/user/consultant/(:any)'] = 'user/clientconsultant' ; // More specific should be first
$route['(:any)/(:any)/user/consultant'] = 'user/clientconsultant' ; // More specific should be first
$route['(:any)/user/consultant']='user/consultant';

//$route['(:any)/user/success']='user/success';
$route['(:any)/(:any)/user/success/(:any)']='user/clientsuccess/$3';

$route['(:any)/user/success/(:any)']='user/success/$2';

$route['(:any)/(:any)/user/cancel']='user/cancel' ;
$route['(:any)/user/cancel']='user/cancel' ;

//$route['(:any)/user/consultant_recurring_payment']='user/consultant_recurring_payment';
$route['(:any)/(:any)/user/consultant_recurring_payment/(:any)']='user/cl_consultant_recurring_payment/$3';

$route['(:any)/user/consultant_recurring_payment/(:any)']='user/consultant_recurring_payment/$2';

$route['(:any)/(:any)/user/register']='user/cregister';

$route['(:any)/user/register']='user/register';

$route['(:any)/(:any)/user/changepassword']='user/cchangepassword';  // routes new
$route['(:any)/user/changepassword']='user/changepassword';  // routes new


$route['(:any)/(:any)/user/mywishlist']='user/cmywishlist';  // routes new
$route['(:any)/(:any)/user/mywishlist/(:any)']='user/cmywishlist';  // routes new

$route['(:any)/user/mywishlist']='user/mywishlist';  // routes new
$route['(:any)/user/mywishlist/(:any)']='user/mywishlist';  // routes new


$route['(:any)/(:any)/user/login']='user/clogin';
$route['(:any)/user/login']='user/login';

$route['(:any)/(:any)/user/logout']='user/logout';
$route['(:any)/user/logout']='user/logout';

$route['(:any)/(:any)/user/account']='user/consultant_useraccount';
$route['(:any)/user/account']='user/account';

$route['(:any)/(:any)/user/myorders']='user/cmyorders';
$route['(:any)/(:any)/user/myorders/(:any)']='user/cmyorders';


$route['(:any)/user/myorders']='user/myorders';
$route['(:any)/user/myorders/(:any)']='user/myorders';

$route['(:any)/(:any)/user/orderview/(:any)']='user/corderview';
$route['(:any)/user/orderview/(:any)']='user/orderview';


$route['(:any)/ajax/addToWishList/(:any)']='ajax/addToWishList';
$route['(:any)/ajax/saveToFavourite/(:any)']='ajax/saveToFavourite';

$route['(:any)/(:any)/ajax/couponSession/(:any)'] = 'ajax/couponSession/$3' ;
$route['(:any)/ajax/couponSession/(:any)'] = 'ajax/couponSession/$2' ;

//ajax/addtocart/164
$route['(:any)/(:any)/ajax/addtocart/(:any)'] = 'ajax/addtocart/$3' ;
$route['(:any)/ajax/addtocart/(:any)'] 	= 'ajax/addtocart/$2' ;

$route['(:any)/(:any)/user/deleteWishList/(:any)']='user/cdeleteWishList';
$route['(:any)/(:any)/user/deleteFavourites/(:any)']='user/cdeleteFavourites';

$route['(:any)/user/deleteWishList/(:any)']='user/deleteWishList';
$route['(:any)/user/deleteFavourites/(:any)']='user/deleteFavourites';

$route['(:any)/(:any)/user/forgot_password']='user/cforgot_password';
$route['(:any)/user/forgot_password']='user/forgot_password';

$route['(:any)/(:any)/user/reset_password/(:any)']='user/creset_password';
$route['(:any)/(:any)/user/reset_password']='user/creset_password';

$route['(:any)/user/reset_password/(:any)']='user/reset_password';
$route['(:any)/user/reset_password']       ='user/reset_password';

$route['(:any)/(:any)/contact']='contactus/cclient' ;
$route['(:any)/contact']='contactus/client';


$route['(:any)/(:any)/address/shipping']='address/cshipping';
$route['(:any)/address/shipping']='address/shipping';

$route['(:any)/(:any)/address/billing']='address/cbilling';
$route['(:any)/address/billing']='address/billing';
$route['(:any)/store/addToWishList/(:any)']='store/addToWishList';
$route['(:any)/store/about'] = 'store/about';
//$route['(:any)/store/contact'] = 'store/contact';

$route['(:any)/cart/changeshipping?(:any)'] = 'cart/changeshipping/$1' ;
$route['(:any)/cart/changetax?(:any)'] = 'cart/changetax' ;

$route['faq'] = 'content/view_content/18' ;
$route['how-it-works'] = 'content/view_content/how-it-works' ;
$route['aboutus'] = 'content/view_content/17' ;

$route['(:any)/(:any)/t_n_c'] = 'content/view_ctnc' ;
$route['(:any)/t_n_c'] = 'content/view_tnc';
#$route['(:any)/t_n_c'] = 'content/view_content/3' ;
$route['t_n_c'] = 'content/view_content/3' ;

$route['(:any)/ajax/changeView'] = 'ajax/changeView' ;
$route['(:any)/ajax/sortBy'] = 'ajax/sortBy' ;
$route['(:any)/ajax/perPage'] = 'ajax/perPage';

$route['ajax/changeView'] = 'ajax/changeView' ;
$route['ajax/sortBy'] = 'ajax/sortBy' ;
$route['ajax/perPage'] = 'ajax/perPage';
$route['client/add'] = 'client/add';

$route['overrides/cron_job'] = 'overrides/cron_job';
$route['overrides/calculate_commision'] = 'overrides/calculate_commision' ;
$route['overrides/cron_genrate_coupon'] = 'overrides/cron_genrate_coupon' ;
$route['overrides/cron_markexpired_groupsales'] ='overrides/cron_markexpired_groupsales' ;
$route['overrides/cron_offerpromotions'] ='overrides/cron_offerpromotions' ;
$route['overrides/cron_volumecommissions'] ='overrides/cron_volumecommissions' ;

$route['news/view/(:any)'] ='news/view/$1' ;

$route['(:any)/ajax/updateordercomment'] = 'ajax/updateordercomment' ;
$route['ajax/updateordercomment'] 	= 'ajax/updateordercomment' ;
$route['uploads/(:any)'] 	= 'uploads/(:any)' ;

$route['(:any)/(:any)/(:any)'] = 'content/cview_usingslug/$3';
$route['(:any)/(:any)'] = 'content/view_usingslug/$2';

/* End of file routes.php */
/* Location: ./application/config/routes.php */

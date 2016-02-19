<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/***********************************************************************
 * Version 2.0 CI                      
 * WWW: http://www.segnant.com
 * Author Vince Balrai
 * Modified On 13 March, 2010
 * Purpose: Header file of admin used to load all defaul css, js, editors
 ************************************************************************/
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo lang('site_name');?></title>
<!-- Default stylesheets -->
<link href="<?php echo layout_url('default/css')?>/common.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo layout_url('default/css')?>/validations.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo layout_url('default/js')?>/datepicker/jquery.ui.all.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo layout_url('default/css')?>/global.css" rel="stylesheet" type="text/css" media="screen" title="global" />
<link href="<?php echo layout_url('default/css')?>/theme.css" type="text/css" rel="stylesheet" media="screen" />
<link href="<?php echo layout_url('default/js')?>/fancybox/fancybox.css" type="text/css" rel="stylesheet"/>
<!-- Alternate stylesheets, required to change themes -->
<link href="<?php echo layout_url('default/css')?>/globalgreen.css" rel="alternate stylesheet" type="text/css" title="global-green" />
<link href="<?php echo layout_url('default/css')?>/globalblue.css" rel="alternate stylesheet" type="text/css" title="global-blue" />
<link href="<?php echo layout_url('default/css')?>/globalpurple.css" rel="alternate stylesheet" type="text/css" title="global-purple" />
<link href="<?php echo layout_url('default/css')?>/globalgrey.css" rel="alternate stylesheet" type="text/css" title="global-grey" />
<link href="<?php echo layout_url('default/css')?>/globalmosaic.css" rel="alternate stylesheet" type="text/css" title="global-mosaic" />
<link href="<?php echo layout_url('default/css')?>/globaltransparent.css" rel="alternate stylesheet" type="text/css" title="global-transparent" />
<link href="<?php echo layout_url('default/css')?>/globalsnowy.css" rel="alternate stylesheet" type="text/css" title="global-snowy" />
<script type="text/javascript">
	//get layout base path
	var layout_base_path = '<?php echo layout_url("default")?>';
</script>
<!-- Default Javascripts -->
<script type="text/javascript" src="<?php echo layout_url('default/js')?>/jscookmenu.js"></script>
<script type="text/javascript" src="<?php echo layout_url('default/js')?>/swapstyle.js"></script>
<script type="text/javascript" src="<?php echo layout_url('default/js')?>/jquery.js"></script>
<script type="text/javascript" src="<?php echo layout_url('default/js')?>/yav.js"></script>
<script type="text/javascript" src="<?php echo layout_url('default/js')?>/yav-config.js"></script>
<script type="text/javascript" src="<?php echo layout_url('default/js')?>/basicfunctions.js"></script>
<script type="text/javascript" src="<?php echo layout_url('default/js')?>/snow.js"></script>
<script type="text/javascript" src="<?php echo layout_url('default/js')?>/common_function.js"></script>

<script src="http://tinymce.cachefly.net/4.3/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: "textareas.mceEditorBasic",
	editor_selector : "mceEditorBasic",
    theme: "modern"
});

tinymce.init({
	selector: "textarea.mceEditor",
	editor_selector : "mceEditor",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern imagetools"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});
</script>

<script  type="text/javascript" >
// Function to load the selected theme.
function loadStyle(optionValue) {
	mycookies = document.cookie;

	if (optionValue == "green")	{
		changeStyle('global-green');
	} else if (optionValue == "snowy") {
		changeStyle('global-snowy');
	} else if (optionValue == "blue") {
		changeStyle('global-blue');
	} else if (optionValue == "purple")	{
		changeStyle('global-purple');
	} else if (optionValue == "grey") {
		changeStyle('global-grey');
	} else if (optionValue == "mosaic") {
		changeStyle('global-mosaic');
	} else if (optionValue == "transparent") {
		changeStyle('global-transparent');
	} else {
		changeStyle('global');
	}
}

// Changes theme to the default one
changeStyle('global');

// If it is not default theme and then fetch selected theme from cookie and apply that theme.
//useStyleAgain('remembered');
//changeStyle('global-blue');

function printPage() {
	window.print();
}
 // Below code used to slide up and down the shortcut toolbar.
function toggleShortcutBar() {
	if (document.images['toggle'].title == "Show Shortcuts") {
		document.images['toggle'].title = "Hide Shortcuts";					
		document.images['toggle'].src = "<?php echo layout_url('default/images')?>/btn_hide_shortcuts.png";
		document.getElementById("shortcut_icons_table").className = "TransparentToolbar1";
		jQuery("div#toolbar").slideDown();
	} else if (document.images['toggle'].title == "Hide Shortcuts") {
		document.images['toggle'].title = "Show Shortcuts";					
		document.images['toggle'].src = "<?php echo layout_url('default/images')?>/btn_show_shortcuts.png";
		document.getElementById("shortcut_icons_table").className = "TransparentToolbar0";
		jQuery("div#toolbar").slideUp();	
	}
}
</script>

 <script>
	function updatectheme(storeid,themeoption,typestore) {
		//alert(storeid+themeoption+typestore);
		//textval = jQuery('#'+pid).val() ;
		//productid = pid ;
		loadStyle(themeoption);
		jQuery.ajax({
	        type:'POST',
	        url :  '/administrator/client/utheme',
	        data: 'storeid='+storeid+'&themecss='+themeoption+'&role_id='+typestore ,
	        success: function(result)
	        {
	            if( result == 1 )
	            {
	                // alert('The product is added to your wishlist.');
	            }
	            else
	            {
	               //alert('ATX code updation failed'); 
	            }
	        },
	        error: function(error)
	        {
	            alert(JSON.stringify(error)+'Some error occured. Please try again later');
	        }
    	});
		
	}
</script>

<?php


// CI_Loader instance
$ci = get_instance();
$baseurl=$ci->config->item('root_url');
#echo '<pre>';
$userData  = $this->session->userdata('user') ;
#echo '<pre>';
#print_r($userData) ;
$sitename = '' ;
$roleId = $userData['role_id'] ;
$ci->load->model('client_model');
if($sitename == ''){
//error_reporting(1);	
	
	$cdetail = $ci->client_model->getclientfromurl() ;
	//echo '<pre>';
	//print_r($cdetail[0]['id']);
	//die;
	$storeid = @$cdetail[0]['id'] ;
	$roleid = @$cdetail[0]['role_id'] ;
	$sitename = @$cdetail[0]['company'] ;
	$admintheme = $ci->client_model->getadmintheme($storeid,$roleid) ;
	$ctheme = @$admintheme[0]['theme'] ;
}

$taxlink  = "taxes/manage_taxes" ;
if( $roleId ==  2){
	$sitename = $userData['company'].' ('.$userData['username'].')'  ;

	$admintheme = $ci->client_model->getadmintheme($userData['id'],2) ;
	$ctheme = @$admintheme[0]['theme'] ;

$storesettings = $ci->settings_model->get_store_settings_page($userData['id'] , 2); // 
//echo '<pre>';
$ava_account_number = $storesettings->ava_account_number ;
$ava_license_key = $storesettings->ava_license_key ;
$ava_company_code  = $storesettings->ava_company_code ;
if($ava_account_number || $ava_license_key || $ava_company_code){
	$taxlink = "settings/edit_settings_avatax/".$storesettings->id ;
}
//print_r($storesettings->ava_account_number);

}elseif($roleId ==  4){
	
	#print_r($this->session);
	$storeid = $userData['store_id'] ;
	$this->load->model('common_model');
	//$resultStore  = $this->common_model->get_clientdetail('',$storeid) ;
	$sitename = $resultStore[0]['company'] ;
	
	$admintheme = $ci->client_model->getadmintheme($storeid,2) ; // store settings
	$ctheme = @$admintheme[0]['theme'] ;

}elseif($roleId ==  1){
	$sitename = 'Simple Sales Systems' ;
	
	$admintheme = $ci->client_model->getadmintheme($userData['id'],1) ;
	$ctheme = @$admintheme[0]['theme'] ;
}

if($ctheme){
?>
<script> loadStyle('<?php echo $ctheme ?>'); </script>
<?php }
?>

</head>
<!-- Below onunload function remember style will run to remember the theme selected -->
<body onunload="qqqrememberStyle('remembered',30);">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="page_width">
	<tr>
		<td valign = "top">
		<!-- Below table will print the site name and the version information -->
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="header_bg"><?php echo $sitename !='' ? $sitename : 'Simple Sales Systems'; #lang('site_name') ;?></td> 
					<td class="header_bg_version" align="right"><?php echo lang('site_version');?></td>
				</tr>
				<tr>
					<td class="header_base_line" colspan="2"></td>
				</tr>
			</table>
		</td>
	</tr>

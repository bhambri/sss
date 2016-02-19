<?php
$segs =  $this->uri->segments ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Store::</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>

<!-- new code part neede -->
<link href="<?php echo store_fallback_path('store/css/home-style.css') ;?>" rel="stylesheet" type="text/css" />
<link href="<?php echo store_fallback_path('store/css/jcarousel.responsive.css') ;?>" rel="stylesheet" type="text/css" />
<!-- new code part needed here -->
<link href="<?php echo store_fallback_path('store/css/style.css') ;?>" rel="stylesheet" type="text/css" />

<script src="http://code.jquery.com/jquery-1.9.0.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?php echo store_fallback_path('store/fonts/stylesheet.css') ;?>" type="text/css"/>
<link type="text/css" href="<?php echo store_fallback_path('store/menu/menu.css') ;?>" rel="stylesheet" />

<script src="<?php echo store_fallback_path('store/resp-new/jquery.js') ;?>" type="text/javascript"></script>
<link rel="stylesheet"  href="<?php echo store_fallback_path('store/resp-new/css.css') ;?>" type="text/css" />

<script src="<?php echo store_fallback_path('store/resp-new/doubletaptogo.js') ;?>" type="text/javascript"></script>
<script type="text/javascript">
	jQuery( function()
	{
		jQuery( '#nav li:has(ul)' ).doubleTapToGo();
	});

</script>

<!--tabs-->
<script type="text/javascript" src="<?php echo store_fallback_path('store/tabs/tabber.js') ;?>"></script>
<link rel="stylesheet" href="<?php echo store_fallback_path('store/tabs/example.css') ;?>" type="text/css" media="screen"/>

<script type="text/javascript">
/* Optional: Temporarily hide the "tabber" class so it does not "flash"
   on the page as plain HTML. After tabber runs, the class is changed
   to "tabberlive" and it will appear. */

document.write('<style type="text/css">.tabber{display:none;} </style>');
</script>

<!--tabs-->
  <!--poppup--> 
  <link rel="stylesheet" href="<?php echo store_fallback_path('store/popup/css/colorbox.css') ;?>" />
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> -->
	<script src="<?php echo store_fallback_path('store/popup/js/jquery.colorbox.js') ;?>" type="text/javascript"></script>
	<script type="text/javascript">
			jQuery(document).ready(function(){
				//Examples of how to assign the ColorBox event to elements
				jQuery(".inline").colorbox({inline:true, width:"41%"});
			});
	</script>
  <!--poppup-->   
<!--productzoom -->
<script src="<?php echo store_fallback_path('store/zoom/ga.js') ;?>" type="text/javascript"></script>
<script src="<?php echo store_fallback_path('store/zoom/jquery.js') ;?>" type="text/javascript"></script>
 
<script type="text/javascript">
$(document).ready(function () {
	      jQuery("#zoom_09").elevateZoom({
	      	 zoomType:"inner",
           gallery : "gallery_09",
           galleryActiveClass: "active",
        	 zoomWindowWidth:550,
        	 zoomWindowHeight:550,
        	 borderSize:1,
    	  	}); 
            
  
     jQuery("#select").change(function(e){
         var currentValue = $("#select").val();
         if(currentValue == 1){    
         smallImage = '';
         largeImage = '';
         }
         if(currentValue == 2){    
         smallImage = '';
         largeImage = '';
         }
         if(currentValue == 3){    
         smallImage = '';
         largeImage = '';
         }
         if(currentValue == 4){    
         smallImage = '';
         largeImage = '';
         }
	// Example of implementing Active Class
    $('#gallery_09 a').removeClass('active').eq(currentValue-1).addClass('active');		
      var ez =   $('#zoom_09').data('elevateZoom');	  
        ez.swaptheimage(smallImage, largeImage);
    });
  }); 

</script> 

  <!--productzoom -->   
<!--toogle-->
<script type="text/javascript">
jQuery(document).ready(function () {
	jQuery('#toggle-view li').click(function () {
		var text = jQuery(this).children('div.panel');

		if (text.is(':hidden')) {
			text.slideDown('200');
			$(this).children('span').html('-');		
		} else {
			text.slideUp('200');
			$(this).children('span').html('+');		
		}
		
	});

});
</script>
<!--toogle-->

<script type="text/javascript" src="<?php echo store_fallback_path('js/common_function.js') ; ?>"></script>

<script type="text/javascript">
jQuery(document).ready(function(){


jQuery('#addToWishList').click(function()
{
    var product_id = jQuery('#product_id').val();
    var baseurl     = jQuery('#baseurl').val(); 
   
    jQuery.ajax({
        type:'POST',
        url:baseurl+'/ajax/addToWishList/'+product_id,
        data:'productId='+product_id,
        success: function(result)
        {
            //alert(result);
            if( result == 1 )
            {
                alert('The product is added to your wishlist.');
            }
            else if(result== 2){
                alert('Please login first.');
            }else
            {
               alert('Product is already added in your wish list.'); 
            }
        },
        error: function(error)
        {
            alert(JSON.stringify(error)+'Some error occured. Please try again later');
        }
    });
});

// new code starts here
  jQuery('#cart_comments').change(
      function(){
        // Ajax call starts here
        var cart_comments = jQuery('#cart_comments').val();
        var baseurl    = '<?php echo site_url();?>' ;
        //alert(cart_comments) ;
        //alert(baseurl) ;
        jQuery.ajax({
            type:'POST',
            url:baseurl+'ajax/updateordercomment/',
            data:'cart_comments='+cart_comments,
            success: function(result)
            {
               
            },
            error: function(error)
            {
                //alert(JSON.stringify(error)+'Some error occured. Please try again later');
            }
        });
        // Ajax call ends here
      }
    );
  // new code added ends here

jQuery('#saveToFavourite').click(function()
{
    var product_id = jQuery('#product_id').val();
    var baseurl     = jQuery('#baseurl').val(); 
    
    jQuery.ajax({
        type:'POST',
        url:baseurl+'/ajax/saveToFavourite/'+product_id,
        data:'productId='+product_id,
        success: function(result)
        {
            //alert(result);
            if( result == 1 )
            {
                alert('The product is added to your favourites.');
            }else if(result== 2){
                alert('Please login first.');
            }
            else
            {
               alert('Product is already added in your favourites.'); 
            }
        },
        error: function(error)
        {
            alert('Some error occured. Please try again later');
        }
    });
});



 
    jQuery('#applyCoupon').click(function(){
        var coupon = jQuery('#couponCodeValue').val();
        var totalPrice = jQuery('#realTotalPrice').val();
        var tax = 0 ;

        if( coupon != '' )
        {   
        	jQuery('input[name=coupon_code]').val(coupon);
            var baseurl = '<?php echo site_url();?>'+'/'+'<?php echo $segs[1] ; ?>'+'/';
            jQuery.ajax({
                type:'POST',
                url:baseurl+'ajax/couponSession/'+coupon,
                success:function(msg)
                {   
                  
                  //console.log(msg);
                  msg = msg.trim();
		
                  if( msg != '' && msg !='used' && msg !='expired' && msg != 'not logged in' && msg !='Invaild code' &&  msg !='Invalid Code')
                   { 
                     
		      nobj = JSON.parse(msg) ;    
                      
                      if((nobj.ctype == 2) || (nobj.ctype == 3)){
                          var discountPrice = totalPrice*(nobj.amount)/100;
                         
                          var grandTotal =  Math.round( ( parseFloat(totalPrice) - parseFloat(discountPrice)+parseFloat(tax) )*100)/100 ;

                      }else{
                          var discountPrice = nobj.amount ;
                          var grandTotal =  Math.round( ( parseFloat(totalPrice) - parseFloat(discountPrice)+parseFloat(tax) )*100)/100 ;
                      }
                      
		    
                      jQuery('#addDiscount').html(parseFloat(discountPrice).toFixed(2) );
		      
                      
		      jQuery('#couponAlreadyUsed').html('');
		      jQuery('#couponSuccess').html('Coupon applied');
                      jQuery('span#totalPrice').html( '$ '+ grandTotal.toFixed(2) );
                      return false;    
                    }
                    else if( msg =='used' )
                    {
                        //alert('This coupon is already used Or expired');
                        jQuery('#couponAlreadyUsed').html('This coupon is already used Or expired. Please try another coupon.');
			jQuery('#couponSuccess').html('');
                    }
                    else if( msg =='expired' )
                    {
                        //alert('This coupon is already used Or expired');
                        jQuery('#couponAlreadyUsed').html('This coupon is already used Or expired. Please try another coupon.');
			jQuery('#couponSuccess').html('');
                    }else if(msg =='not logged in'){
                         jQuery('#couponAlreadyUsed').html('Please login to avail Coupon discount functionality');
			jQuery('#couponSuccess').html('');
                    }
                    else
                    {
                        jQuery('#couponAlreadyUsed').html('This coupon is already used Or expired. Please try another coupon.');
			jQuery('#couponSuccess').html('');
                    }
                       
                },
                error:function(error)
                {
                    alert('error is->> '+ error);   
                }
            });
        }
    });
 });

function addtocart(baseurl, productid){
	
  jQuery.ajax({
        type:'POST',
        url:baseurl+'/ajax/addtocart/'+productid,
        data:'productId='+productid,
        success: function(result)
        {
            if( (result == 1 ) || (result == 0 ))
            {
                //alert('The product is added to you cart');
                window.location.reload();
            }else if(result == 2){
                window.location.assign(baseurl+'/store/productDetail/'+productid);
            }
            // 
        },
        error: function(error)
        {
            alert('Some error occured. Please try again later');
        }
    });

}

function addtowishlist(baseurl, productid){
    jQuery.ajax({
        type:'POST',
        url:baseurl+'/ajax/addToWishList/'+productid,
        data:'productId='+productid,
        success: function(result)
        {
            if( result == 1 )
            {
                alert('The product is added to your wishlist.');
            }
            else if(result== 2){
                alert('Please login first.');
            }else
            {
               alert('Product is already added in your wish list.'); 
            }

            /*
            if( result == 1 )
            {
                //alert('The product is added to you cart');
                
            }else{
                //alert('Product is already there in cart') ;

            }
            window.location.reload();
            */
        },
        error: function(error)
        {
            alert('Some error occured. Please try again later');
        }
    });
}
 
function hideshow(){
  var text = jQuery('.coupondiv');
  if (text.is(':hidden')) {
     
      jQuery('h5').children('span').html('-');   
    } else {
     
      jQuery('h5').children('span').html('+');   
    }

  jQuery('.coupondiv').toggle("slow") ;

}

</script>
<!--tooltip-->
<script type="text/javascript" src="<?php echo store_fallback_path('store/tooltip/vtip.js') ;?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo store_fallback_path('store/tooltip/css/vtip.css') ;?>" />
<!--tooltip-->
<!--slider-->
</head>
<body>
 <div class="wrapper">
 <!--header--> 
   <div class="header">
 	    <div class="header-inner">
   	 	 <div class="logo">
         <a href="<?php echo base_url() .  $this->storename; ?>/home">
     	 	 <img src="<?php echo base_url();?><?php echo $this->logo_image; ?>" alt=""/>
     	 	 </a>
       </div>	 	 
      <div class="header-strip">
         <div class="header-strip-main">
    
     <span class="cart"><a href="<?php echo base_url() .  $this->storename . '/cart/';?>">Cart(<?php echo $this->cart->total_items() ;?>)</a></span>
    
        <span class="account">
  	    <?php 
  	    	$storeUserSession = $this->session->userdata('storeUserSession');
  	    	if( isset( $storeUserSession ) && !empty( $storeUserSession ) && is_array( $storeUserSession ) )
  	    	{
  	    ?>

  	    		<a href="javascript:void(0);" onclick="showaccountdiv() ;"><?php echo 'Welcome '.ucwords($storeUserSession['name']);?></a> |
  	    		<a href="<?php echo base_url() .  $this->storename . '/user/logout';?>">Logout</a>
  	    <?php 
  	    	}
  	    	else
  	    	{
  	    ?>
  	    	<a class='inline cboxElement' href="#inline_content">Create Account</a>
  	    <?php
  	    	}
  	    ?>

  <span class="account-dropdown">       
    <a href="<?php echo base_url() .  $this->storename . '/user/myorders';?>"> My orders</a><br/>
   <a href="<?php echo base_url() .  $this->storename . '/user/account';?>"> Account Info</a><br/>
    <a href="<?php echo base_url() .  $this->storename . '/user/changepassword';?>">Change Password</a><br/>
   <a href="<?php echo base_url() .  $this->storename . '/user/mywishlist';?>"> My wishlist</a><br/>
  </span>

  	    </span> 
  	    
  	    
  	    
  	    	
  	    	 <?php 
                if( isset( $storeUserSession ) && !empty( $storeUserSession ) && is_array( $storeUserSession ) )
                {
               ?>
			 	 	      
               <?php }else{ ?>	
		<span class="login"> 
               <a href="<?php echo base_url() .  $this->storename . '/user/login';?>">Login</a>
 		</span>
               <?php } ?>
  	    	
  	   
  	    
  	   	 <!-- span class="wishlist"><a href="#">Wishlist</a> (0)</span-->
     <form action="<?php echo base_url().$segs[1] ;?>/store/search">
  	    <div class="search"><input class="inp" name="s" value="<?php echo ($this->input->get('s') != "") ? $this->input->get('s') : 'Search' ?>" onblur="if(this.value=='') this.value='Search'" onfocus="if(this.value =='Search' ) this.value=''"/> <!-- <input type="button" value="Search" class="btn"/> -->
        <input type="submit" value="Search" class="btn"/>
        </div>
  	    </form>
    </div>	
</div>
	 	 <div class="right-top">
	 	 	   	  <div class="navigation" id="menu">  
			 	 	   <ul>
			 	 	   <li><a href="<?php echo base_url() .  $this->storename; ?>/home">Home</a></li>
			 	 	   <li><a href="<?php echo base_url() .  $this->storename; ?>/store/product">Shop</a>
			 	 	       <div class="columns two">                
			                <?php  
			                	if( !empty( $this->categories ) )
			                	{
			                		foreach ($this->categories as $categories) {
                            
			                ?>
				                <ul class="one categorylisting js-masonry"  style="<?php echo $splitclass;?>" data-masonry-options='{ "columnWidth": 500, "itemSelector": ".box" }'>
				                   <li><h5><?php echo $categories['name'];?></h5></li>
				                   <?php 
                               $splitclass = "" ;
				                   	  if( isset( $categories['subcategory'] ) && !empty( $categories['subcategory'] ) )
				                   	  {
				                   	  	 foreach ($categories['subcategory'] as $subcategory) 
				                   	  	 {				                   	  	 		
				                   ?>          
				                       	    <li class="box"><a href="<?php echo base_url().$this->storename; ?>/store/cat_id/<?php echo $categories['id'].'/'.$subcategory->id;?>"   > <span <?php if(strtolower($this->uri->uri_string) == strtolower($this->storename.'/store/cat_id/'.$categories['id'].'/'.$subcategory->id )){ echo ' class=menuselected '; $selCategory = $categories['name']; $selsubCategory = $subcategory->name ;} ?> > <?php echo $subcategory->name;?></span></a></li>
				                    <?php 
				                     	 }	
				                   	  }
				                    ?>				                    
				                </ul>
				            <?php                    	  	 	
				            		}	 
				        		}
				            ?>
                </div>
			 	 	   </li>
			 	 	   <li><a href="<?php echo base_url().$this->storename ;?>/become-stylist">Become a Stylist</a></li>
			 	 	   <li><a href="<?php echo base_url().$this->storename ;?>/host-a-party">Host a Party</a></li>
			 	 	   <!-- <li><a href="<?php echo $this->store_about_us_link ? $this->store_about_us_link : base_url().$this->storename.'/home#' ;  ?>" target="_blank">About Us</a></li> -->
             <li><a href="<?php echo base_url().$this->storename ;?>/about-us">About Us</a></li>
  			 	   <li class="no-mnu"><a href="http://joncarjewelry.com/blog/">Blog</a></li>
  			 	 	 <!-- <li><a href="<?php echo base_url() .  $this->storename; ?>/contact">Contact Us</a></li>-->
  			 	 	 </ul>	 	 	   
		 	 	  </div>
		 	 	    <div class="responsive_menu"> 
					 	<nav id="nav" role="navigation">
	<a href="#nav" title="Show navigation">Show navigation</a>
	<a href="#" title="Hide navigation">Hide navigation</a>
	<span class="mobile-txt">Menu</span>
	
		<ul class="clearfix">
							 <li><a href="<?php echo base_url() .  $this->storename; ?>/home">Home</a></li>
             <li><a href="<?php echo base_url() .  $this->storename; ?>/store/product">Shop</a>
							
            <?php  
                if( !empty( $this->categories ) )
                {
                  //$count  = 0 ;
                  foreach ($this->categories as $categories) {
                     
                     #echo '<pre>';
                     #print_r($splitclass) ;
                     //die;
                     #echo 'Abhishek';
              ?>
                <ul class="one categorylisting js-masonry" data-masonry-options='{ "columnWidth": 500, "itemSelector": ".box" }'>
                   <!-- <h5><?php echo $categories['name'];?></h5> -->
                   <?php 
                     
                      if( isset( $categories['subcategory'] ) && !empty( $categories['subcategory'] ) )
                      {
                         foreach ($categories['subcategory'] as $subcategory) 
                         {                                    
                   ?>          
                            <li><a href="<?php echo base_url().$this->storename; ?>/store/cat_id/<?php echo $categories['id'].'/'.$subcategory->id;?>"   > <span <?php if(strtolower($this->uri->uri_string) == strtolower($this->storename.'/store/cat_id/'.$categories['id'].'/'.$subcategory->id )){ echo ' class=menuselected '; $selCategory = $categories['name']; $selsubCategory = $subcategory->name ;} ?> > <?php echo $subcategory->name;?></span></a></li>
                    <?php 
                       }  
                      }
                    ?>                            
                </ul>
            <?php                           
                }  
            }
            ?>
							</li>
							 <li><a href="<?php echo base_url().$this->storename ;?>/become-stylist">Become a Stylist</a></li>
             <li><a href="<?php echo base_url().$this->storename ;?>/host-a-party">Host a Party</a></li>
			 	 	   
			 	 
			 	 	  <!-- <li><a href="<?php echo $this->store_about_us_link ? $this->store_about_us_link : base_url().$this->storename.'/home#' ;  ?>" target="_blank">About Us</a></li>-->
			 	     <li><a href="<?php echo base_url().$this->storename ;?>/about-us">About Us</a></li>
             <li><a href="http://joncarjewelry.net/blog/">Blog</a></li>
							
							
							</ul>
															
               </nav>	
	             	</div>
	             	
 	 	 </div>
     
<?php 
 $arrd = explode('/',$_SERVER['PATH_INFO']) ;      
if((count($arrd) > 2) && (!in_array($arrd[2] ,array('/','home','news')))){ ?>
  <div class="simpleBorder"></div>
<?php } ?> 

<div class="cart-popup">
<h2>My Cart- 12 Items</h2>
<div class="cart-fld">
   <div class="cart-fld-inner">
    <div class="img"><img src="<?php echo store_fallback_path('store/images/offer2.png') ; ?>" alt=""/></div>
    <div class="txt">Meridian Leather Wrap Bracelet <br/><span>Quantity: <strong>5</strong></span></div>
   </div> 

 <div class="cart-fld-inner">
    <div class="img"><img src="<?php echo store_fallback_path('store/images/offer2.png') ; ?>" alt=""/></div>
    <div class="txt">Meridian Leather Wrap Bracelet <br/><span>Quantity: <strong>5</strong></span></div>
   </div> 

    <div class="cart-fld-inner">
    <div class="img"><img src="<?php echo store_fallback_path('store/images/offer2.png') ; ?>" alt=""/></div>
    <div class="txt">Meridian Leather Wrap Bracelet <br/><span>Quantity: <strong>5</strong></span></div>
   </div> 

</div>

<div class="btn"><a href="#">VIEW CART</a></div>
<div class="quick-check"><a href="#">Quick Checkout</a></div>
</div>

 	 	</div>




 	 </div>
<?php if($this->session->flashdata('success')) : ?>
<div class="sucess-box" style="text-align:center; width:100%;"><?php echo $this->session->flashdata('success'); ?></div>
<?php endif; ?>
<?php if($this->session->flashdata('errors')) : ?>
<div class="error-box" style="text-align:center; width:100%;"><?php echo $this->session->flashdata('errors'); ?></div>
<?php endif; ?>  

 	 <!--header-->
<!--header-->



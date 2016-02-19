<!-- new code part needed here -->

<script type="text/javascript" src="<?php echo store_fallback_path('store/js/jquery.bxslider.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo store_fallback_path('store/js/jquery.jcarousel.min.js') ?>">  </script>
<script type="text/javascript" src="<?php echo store_fallback_path('store/js/jcarousel.responsive.js') ?>" ></script>

<div class="home-pg">
	           <!-- <div class="slider"> -->
<div class="banner1"> 
	<div class="banner-slider">

     <?php 
    
      if( !empty( $banners ) && is_array( $banners ) ){ 
        ?>
    
      <ul class="bxslider">
	      <?php

	      foreach( $banners as $banner ){ 
	        $settings = array('w'=>1900,'h'=>700,'crop'=>false);
	          if( $banner['image'] && @file_get_contents(site_url().$banner['image']))
	          { 
	            //$image = $_SERVER['DOCUMENT_ROOT'] .'/marketplace' . $banner['image'];
	            $image = site_url().$banner['image'];
	            $image = image_resize( $image, $settings);
	            ?>
	            <li ><a href="<?php echo $banner['link'];?>">  <img src="<?php echo $image;?>" alt="<?php echo $banner['id'];?>" id=""  /></a> </li>
	      <?php } ?> 
	      <?php } ?>
	      
	     
	      <?php } ?>
	   </ul>
	</div>
	<script>
	
	jQuery('.bxslider').bxSlider({
	  auto: true,
	  autoControls: false,
	  speed :2000,
	  pause :7000,
	});
	</script></div>
				<!-- slider end here-->
				
				<div class="products">
					<div class="product1 displayproduct">
						<img src="<?php echo store_fallback_path('store/images/joncarhome1.jpg') ;?>" alt="" />
						<p>"These original timeless jewelry are expertly handcrafted using the finest materials."
						</p>
					</div>
					
					<div class="product2 displayproduct">
						<!--<img src="images/product1.jpg" alt="" />-->
					<img src="<?php echo store_fallback_path('store/images/joncarhome2.jpg') ;?>" alt="" />
						<p>"Personalize your jewelry and have it say what you want, straight from the heart."
						</p>
					</div>
				</div>
				<!-- product end here-->
				<div class="border"></div>
				
				<div class="product_detail">
					<p class="productPic">
						<img src="<?php echo store_fallback_path('store/images/descriptionpic.jpg') ;?>" alt="" />
					</p>
					
					<p class="product_content">
						"Our jewelry pieces are handmade using the finest raw materials<br/>
<span class="spacer"></span>
We are proud to provide mothers a source of income by having them expertly handcraft our jewelry pieces. <br/>
<span class="spacer"></span>
At JonCar Jewelry, we celebrate the art of handmade, providing work to women, and being Made in the USA.<br/>
<span class="spacer"></span>
Thank you for purchasing JonCar Jewelry."
					</p>
				</div>
				<!-- product detail end here-->
				<div class="clr"></div>
				<div class="productSlider">
						<div class="jcarousel-wrapper">
						<div class="jcarousel">
						<ul>
						<li><a href="<?php echo base_url() ;?>/store/products" target="_blank"><img src="<?php echo store_fallback_path('store/images/img1.jpg') ;?>" alt="Image 1"></a></li>
						<li><a href="<?php echo base_url() ;?>/store/products" target="_blank"><img src="<?php echo store_fallback_path('store/images/img2.jpg') ;?>" alt="Image 2"></a></li>
						<li><a href="<?php echo base_url() ;?>/store/products" target="_blank"><img src="<?php echo store_fallback_path('store/images/img3.jpg') ;?>" alt="Image 3"></a></li>
						<li><a href="<?php echo base_url() ;?>/store/products" target="_blank"><img src="<?php echo store_fallback_path('store/images/img4.jpg') ;?>" alt="Image 4"></a></li>
						<li><a href="<?php echo base_url() ;?>/store/products" target="_blank"><img src="<?php echo store_fallback_path('store/images/img5.jpg') ;?>" alt="Image 5"></a></li>
						<li><a href="<?php echo base_url() ;?>/store/products" target="_blank"><img src="<?php echo store_fallback_path('store/images/img1.jpg') ;?>" alt="Image 6"></a></li>
						<li><a href="<?php echo base_url() ;?>/store/products" target="_blank"><img src="<?php echo store_fallback_path('store/images/img2.jpg') ;?>" alt="Image 1"></a></li>
						<li><a href="<?php echo base_url() ;?>/store/products" target="_blank"><img src="<?php echo store_fallback_path('store/images/img3.jpg') ;?>" alt="Image 2"></a></li>
						<li><a href="<?php echo base_url() ;?>/store/products" target="_blank"><img src="<?php echo store_fallback_path('store/images/img4.jpg') ;?>" alt="Image 3"></a></li>
						<li><a href="<?php echo base_url() ;?>/store/products" target="_blank"><img src="<?php echo store_fallback_path('store/images/img5.jpg') ;?>" alt="Image 4"></a></li>
						<li><a href="<?php echo base_url() ;?>/store/products" target="_blank"><img src="<?php echo store_fallback_path('store/images/img1.jpg') ;?>" alt="Image 5"></a></li>
						<li><a href="<?php echo base_url() ;?>/store/products" target="_blank"><img src="<?php echo store_fallback_path('store/images/img2.jpg') ;?>" alt="Image 6"></a></li>

						</ul>
						</div>

						<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
						<a href="#" class="jcarousel-control-next">&rsaquo;</a>

						<!--<p class="jcarousel-pagination"></p>-->
						</div>
				</div>
</div>				
				
<script>
	 $(document).ready(function(){
       /* $('.bxslider').bxSlider({
	  auto: true,
	  controls: false,
	  autoControls: false,
	  speed :3000,
	  pause :4000,
	  adaptiveHeight: true,
	  infiniteLoop: false,
	}); */
        $('.bxslider2').bxSlider({auto:true, pager:false, controls:false, pause: 4000});
      });
	
		</script>

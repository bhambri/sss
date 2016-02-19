<script type="text/javascript" src="http://dev.simplesalessystems.com/application/views/joncaradmin_82/store/js/jquery.bxslider.min.js"></script>
<link href="<?php echo store_fallback_path('includes/bxslider/jquery.bxslider.css') ?>" rel="stylesheet" />
<!--banner-->
<div class="banner">
<div class="banner1"> 
	<div class="banner-slider">

     <?php 
    
      if( !empty( $banners ) && is_array( $banners ) ){ 
        ?>
    
      <ul class="bxslider">
	      <?php

	      foreach( $banners as $banner ){ 
	        $settings = array('w'=>1900,'h'=>440,'crop'=>false);
	          if( $banner['image'] && @file_get_contents(site_url().$banner['image']))
	          { 
	            //$image = $_SERVER['DOCUMENT_ROOT'] .'/marketplace' . $banner['image'];
	            $image = site_url().$banner['image'];
	            //$image = image_resize( $image, $settings);
	            ?>
	            <li ><a href="<?php echo $banner['link'];?>">  <img src="<?php echo $image;?>" alt="<?php echo $banner['id'];?>" id=""  height="442" width="1900" /></a> </li>
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
</div>
<!--banner-->
<div class="con box-shadow">
  <div class="con-inner">
  <div class="hometxt">
      <h2>Welcome to Dramming shop</h2>
      <p>Offerings such as the largest in-season product catalogue, 100% authentic products, cash on delivery, EMI facility and 30 day return policy make Myntra.com, the preferred shopping destination in the country. To make online shopping easier for you, a dedicated customer connect team is on standby to answer your queries 24x7.</p>
  </div>
     <div class="top-store">
     <?php 
     if(!empty($front_blocks))
     {
       $f_b=1;  
       foreach ($front_blocks as $blocks)
       {
       ?>
        <div <?php if($f_b==3) { ?> class="box no-mar" <?php } else { ?>class="box" <?php } ?>>
          <h2>
            <a href="<?php echo $blocks['link']; ?>"><?php echo $blocks['title']; ?></a>
          </h2>
          <div class="img">
            <a href="<?php echo $blocks['link']; ?>">
              <img width="" height="" src="<?php echo $blocks['image']; ?>" alt=""/>
            </a>
            <span><?php echo $blocks['image_text']; ?></span>
          </div>
        </div>
       <?php 
       $f_b++;
       }
     }
     ?>
    </div>
  </div>
</div>
<!--con-->

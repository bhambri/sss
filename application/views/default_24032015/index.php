<!--banner-->
<div class="banner">
<?php 
     if( !empty( $banners ) && is_array( $banners ) )
     { 
    ?>
<div id="wowslider-container1">
	<div class="ws_images">
  <ul>
  <?php
  foreach( $banners as $banner ){ 
    $settings = array('w'=>1900,'h'=>585,'crop'=>true);
    if( $banner['image'] && @file_get_contents(site_url().$banner['image'])){ 
      $image = site_url(). $banner['image'];
      $image = image_resize( $image, $settings);
      ?>
      <li> <a href="<?php echo $banner['link'];?>"><img src="<?php echo $image;?>" alt="<?php echo $banner['link'] ; ?>" id="wows1_0"/></a></li>
    <?php  } ?>
    
  <?php } ?>
  </ul> 
  </div>
  <?php } ?>
</div>
<script type="text/javascript" src="<?php echo layout_url('default/marketplace/')?>slider/engine1/wowslider.js"></script>
<script type="text/javascript" src="<?php echo layout_url('default/marketplace/')?>slider/engine1/script.js"></script>
</div>
 	<div class="shadow"><img src="<?php echo layout_url('default/')?>images/shadow.png" alt=""/></div>
 	  <?php 
    $topStore = array() ;
    if( !empty( $topStore ) && is_array( $topStore ) )
     { 
    ?>
   <div class="con">
      <div class="con-inner">
         <div class="top-store">
       <div class="heading"><span class="left-line"><img src="<?php echo layout_url('default/')?>images/heading-line.png" alt=""/></span>Top <span class="color">Stores</span><span class="right-line"><img src="<?php echo layout_url('default/')?>images/heading-line.png" alt=""/></span></div>
  	  <?php foreach( $topStore as $top ){  
          $link = $top['link'];
          if( substr( $link, 7) != 'http://' )
          {
            $link = 'http://' . $link;
          }
          //$settings = array('w'=>320,'h'=>252,'crop'=>true);
          if( $top['image'] )
          {
            $image = $_SERVER['DOCUMENT_ROOT'] .'/marketplace' . $top['image'];
            $image = image_resize( $image, $settings);
          }
          else
          {
             $image = base_url() . '/upload/topStore/images/store1.png';
          }
        ?>
  	 <div class="box">
  	    <h2><a target="_blank" href="<?php echo $link; ?>"><?php echo $top['title'] ?></a></h2>
  	    <div class="img"><a target="blank" href="<?php echo $link; ?>"><img src="<?php echo $image?>" width="320" height="252" alt=""/></a></div>
  	  </div>
  	 <?php } ?> 
  	  </div>
  	</div>
  </div><!--con-->
<?php }  

if( $latest_news ){  ?>

<div class="latest-news">
  <div class="latest-news-inner">    

  <div class="heading"><span class="left-line"><img src="<?php echo layout_url('default/')?>images/heading-line.png" alt=""/></span>LATEST <span class="color">NEWS &amp; EVENTS</span><span class="right-line"><img src="<?php echo layout_url('default/')?>images/heading-line.png" alt=""/></span></div>
  
  <?php 
	$k = 0 ;
foreach( $latest_news as $news ) { $k = $k+1 ;
if($k %3 == 0){ ?>
	<div class="news-details no-mar">
      	   <div class="img"><a href="<?php echo site_url() . 'news/view/' . $news['id'];?>"><img src="<?php echo layout_url('default/')?>images/news-ico.png" alt=""/></a></div>
      	   <div class="text">
      	   	 <h3><?php echo $news['page_title'];?></h3>
      	   	  <p><?php echo $news['page_shortdesc'];?></p>
      	   </div>
      </div>
<?php }else{ ?>
<div class="news-details">
      	   <div class="img"><a href="<?php echo site_url() . 'news/view/' . $news['id'];?>"><img src="<?php echo layout_url('default/')?>images/news-ico.png" alt=""/></a></div>
      	   <div class="text">
      	   	 <h3><?php echo $news['page_title'];?></h3>
      	   	  <p><?php echo $news['page_shortdesc'];?></p>
      	   </div>
      </div>
<?php } ?>
      
  <?php } ?>    
	 </div>
</div><!--news-->
<?php } ?>

<script src="<?php echo store_fallback_path('includes/bxslider/jquery.bxslider.min.js') ?>" type="text/javascript"></script>
<!-- bxSlider CSS file -->
<link href="<?php echo store_fallback_path('includes/bxslider/jquery.bxslider.css') ?>" rel="stylesheet" />

<!--banner-->
<div class="banner-slider">
<div class="banner1"> 
 
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
            <li ><a href="<?php echo $banner['link'];?>"> <img src="<?php echo $image;?>" alt="<?php echo $banner['id'];?>" id=""  /></a> </li>
            
      <?php } ?> 
      <?php } ?>
      </ul> 
     
      <?php } ?>
   <!-- <li><img alt="" src="http://202.164.57.202:1448/marketplace/application/views/storeg_8/store/images/pic1.jpg"></li> -->
</div> 
<script type="text/javascript">
jQuery('.bxslider').bxSlider({
  auto: true,
  autoControls: false,
  speed :2000,
  pause :7000,
});
</script>
</div>
<!--banner-->
<div class="con">
  <div class="con-inner">
  <div class="hometxt">
      <h2>News</h2>
  </div>
  <div class="constant-news">
<?php
$segs = $this->uri->segments ;


if(count($news_data)){      
foreach($news_data as $news){ 
?>
<div class="news">
   <?php if(file_get_contents(site_url().$news->page_thumbnailpath) && (trim($news->page_thumbnailpath)!="")){ ?>
   <div class="news-img"><img src="<?php echo site_url().$news->page_thumbnailpath ;?>" alt="" /></div> 
   <?php } ?>        
   <div class="details">
      <h3><?php echo $news->page_title ?></h3>
      <p><?php echo substr($news->page_content,0,100) ; ?></p>
      <p><a class="readmor" href="<?php echo site_url().$segs[1].'/'.$segs[2].'/news_detail/'.$news->id ;?>" > Read More</a></p>
   </div>
</div>
<?php  }  ?>
<?php }else{ ?>
<div class="news">
 No News There
</div>
<?php } ?>
<a href="<?php echo site_url().$segs[1].'/'.$segs[2].'/news' ;?>" ><div class="readmr"> Read More >> </div> </a>
</div> 
</div>
</div>

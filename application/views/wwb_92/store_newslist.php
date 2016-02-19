<script type="text/javascript" src="<?php echo store_fallback_path('store/js/jquery.bxslider.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo store_fallback_path('store/js/jquery.jcarousel.min.js') ?>">  </script>
<script type="text/javascript" src="<?php echo store_fallback_path('store/js/jcarousel.responsive.js') ?>" ></script>
<!--banner-->
<div class="banner-slider">
<?php
/*
$i=0 ;

if(is_array($banners)){
  
foreach ($banners as $banner_detail) {
  # code...
  
  if(($i != 3) && (@file_get_contents(site_url().$banner_detail['image']))){
  #pr($banner_detail) ;
    $i++ ;
  ?>
  <div class="SACarouselImgCol" style="" id="satopimage-<?php echo $i ; ?>">
      <!-- <img src="<?php echo store_fallback_path('default/store/')?>slider/banner1.jpg" alt=""/> -->
      <img src="<?php echo site_url().$banner_detail['image'] ;?>" alt="" style="width:620px;height:443px;" >
  </div>
  <div class="SACarouselDetailsCol" id="satopcontent-<?php echo $i ; ?>" style="">
  </div>

<?php
}
}
}
*/
?>
 
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
<div class="inner-banner">
 <div class="breadcrumb">
      <!-- Home / Constant News Details -->
     <?php
      foreach ($breadcrumbdata as $key=>$value) { ?>  
        <a href="<?php echo $value ; ?>"> <?php echo $key ; ?> </a>
      <?php  } ?>
    </div>
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
    #pr($segs) ;
    if(@count($news_data) > 0 ){   
      foreach($news_data as $news){  ?>
      <div class="news">
         <!-- <div class="news-img"><img src="<?php echo site_url().$news->page_thumbnailpath ;?>" alt="" /></div>  -->
         <?php if(file_get_contents(site_url().$news->page_thumbnailpath) && (trim($news->page_thumbnailpath)!="")){ ?>
         <div class="news-img"><img src="<?php echo site_url().$news->page_thumbnailpath ;?>" alt="" /></div> 
         <?php } ?>         
         <div class="details">
            <h3><?php echo $news->page_title ?></h3>
            <p><?php echo substr($news->page_content,0,100) ; ?></p>
            <p> <a class="readmor" href="<?php echo site_url().$segs[1].'/news_detail/'.$news->id ;?>" > Read More</a></p>
         </div>
     </div>
    <?php  } ?>
    <?php }else{ ?>
      <div class="news">
      No News there
      </div>
    <?php } ?>
    <!-- <div class="readmr">Read More >></div> -->
    <div class="pagination">
      <?php echo ( isset($news_data) ) ? $pagination : ''; ?>
    </div>
    </div> 
  </div>  
  </div>

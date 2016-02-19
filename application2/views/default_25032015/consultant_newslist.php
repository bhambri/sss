<!--banner-->
<!-- 
<div class="banner"> 
 <div class="banner-main  discount-banner">
 <?php 
  if( !empty( $banners ) && is_array( $banners ) ){ 
    ?>
    <div id="wowslider-container1">
      <div class="ws_images">
      <ul>
      <?php
      foreach( $banners as $banner ){ 
            $settings = array('w'=>1900,'h'=>443,'crop'=>false);
                if( $banner['image'] && @file_get_contents(site_url().$banner['image']))
                { 
                  //$image = $_SERVER['DOCUMENT_ROOT'] .'/marketplace' . $banner['image'];
                  $image = site_url().$banner['image'];
                  $image = image_resize( $image, $settings);
                  ?>
              <li> <a href="<?php echo $banner['link'];?>"><img src="<?php echo $image;?>" alt="<?php echo $banner['id'];?>" id="wows1_0"/></a></li>
              <?php }
        ?>
        
      <?php } ?>
      </ul> 
      </div>
  <?php } ?>
    </div>
  </div>
</div> 
<script type="text/javascript" src="<?php echo layout_url('default/marketplace/')?>slider/engine1/wowslider.js"></script>
<script type="text/javascript" src="<?php echo layout_url('default/marketplace/')?>slider/engine1/script.js"></script>
-->
<script src="<?php echo layout_url('default/includes/bxslider')?>/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="<?php echo layout_url('default/includes/bxslider')?>/jquery.bxslider.css" rel="stylesheet" />
<div class="banner1"> 
 <!-- <div class="banner-main  discount-banner"> -->
     <?php 
      if( !empty( $banners ) && is_array( $banners ) ){ 
        ?>
    <!-- <div id="wowslider-container1">
      <div class="ws_images">
      -->
      <ul class="bxslider">
      <?php
      foreach( $banners as $banner ){ 
        $settings = array('w'=>1900,'h'=>443,'crop'=>false);
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
      <!-- </div> -->
      <?php } ?>
    <!-- </div>  -->   
  <!-- </div> -->
</div> 
<script>
jQuery('.bxslider').bxSlider({
  auto: true,
  autoControls: false
});
</script>
<!--banner-->
  <div class="con box-shadow">
    <div class="con-inner">
      <div class="hometxt">
        <h2>News</h2>
      </div>  
    <div class="constant-news">
    <div class="breadcrumb">
      <!-- Home / Constant News Details -->
      <p>
     <?php
      foreach ($breadcrumbdata as $key=>$value) { ?>  
        <a href="<?php echo $value ; ?>" style="float:left;width:auto;display:block;"> <?php echo $key ; ?> </a>
      <?php  } ?>
      </p>
    </div>
    <?php
    $segs = $this->uri->segments ;
    #pr($segs) ;
    if(@count($news_data) > 0 ){   
      foreach($news_data as $news){  ?>
      <div class="news">
         <!-- <div class="news-img"><img src="<?php echo site_url().$news->page_thumbnailpath ;?>" alt="" /></div>  -->
         <?php if(file_exists(site_url().$news->page_thumbnailpath) && (trim($news->page_thumbnailpath)!="")){ ?>
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

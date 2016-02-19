<!--banner-->
<!--banner-->
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
<!-- <div class="shadow"><img src="<?php echo layout_url('default/')?>images/shadow.png" alt=""/></div> -->
<script type="text/javascript" src="<?php echo layout_url('default/marketplace/')?>slider/engine1/wowslider.js"></script>
<script type="text/javascript" src="<?php echo layout_url('default/marketplace/')?>slider/engine1/script.js"></script>
<!--banner-->
<div class="con box-shadow">
    <div class="con-inner">
      <div class="hometxt">
          <h2>Group Purchase Events</h2>
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
      <div style="clear:both"></div>
    <?php
    if(@count($event_data) > 0 ){   
      $segs = $this->uri->segments ;
      foreach($event_data as $group){  ?>
      <div class="news">
         <div class="news-img"><img src="<?php echo site_url().$group->image ;?>" alt="" /></div>         
         <div class="details">
            <h3><?php echo $group->name ?></h3>
            <p><?php echo substr($group->description,0,100) ; ?></p>
         </div>
         <p> <a class="readmor" href="<?php echo site_url().$segs[1].'/'.$segs[2].'/event_detail/'.$group->id ;?>" > Read More</a></p>
         <!--  -->
     </div>
    <?php  } ?>

    <?php }else{ ?>
      <div class="news">
      No Group Events There
      </div>
    <?php } ?>
    <!-- <div class="readmr">Read More >></div> -->
    <div class="pagination">
      <?php echo ( isset($event_data) ) ? $pagination : ''; ?>
    </div>
    </div> 
  </div>
</div>     
<!--banner-->
<div class="banner">
  <div class="banner-main">
    <div class="SACarouselThumbsCol">
        <ul>
            <li class="active bgcol1" id="satopthumbactive-1" style="" title="" onclick="changeWidget('1')">
              
                <div class="figure"><img src="<?php echo store_fallback_path('store/slider/small1.png')?>" alt="" /></div>
                <div class="txt"><h3>New Fashion</h3>
                 <p>In the past people were born royal. Nowadays royalty comes from what you do.</p>
                </div>
               
              <span class="carouselPointer" style="background:url(<?php echo store_fallback_path('store/slider/arrow1.png')?>); background-repeat:no-repeat; width:14px; height:26px;"><img src="<?php echo store_fallback_path('default/store/')?>slider/arrow1.png"/></span> </li>
            <li id="satopthumb-1" class="bgcol1"  style="display: none;" title="" onclick="changeWidget('1')">
             
                <div class="figure"><img src="<?php echo store_fallback_path('store/slider/small1.png')?>" alt=""  /></div>
                <div class="txt"><h3>New Fashion</h3>
                 <p>In the past people were born royal. Nowadays royalty comes from what you do.</p>
                </div>
            </li>
            <li class="active bgcol2" id="satopthumbactive-2" style="display:none" title="" onclick="changeWidget('2')">
             
                <div class="figure"><img src="<?php echo store_fallback_path('store/slider/small2.png')?>" alt=""  /></div>
               <div class="txt"><h3>Special offer today</h3>
                 <p>Tailor made to fit you prefectly any size to dressyou up.</p>
                </div>   
            <span class="carouselPointer"><img src="<?php echo store_fallback_path('store/slider/arrow2.png')?>" /></span> </li>
            <li id="satopthumb-2" class="bgcol2" style="" title="" onclick="changeWidget('2')">
            
                <div class="figure"><img src="<?php echo store_fallback_path('store/slider/small2.png')?>" alt=""  /></div>
                 <div class="txt"><h3>Special offer today</h3>
                 <p>Tailor made to fit you prefectly any size to dressyou up.</p>
                </div>    
            </li>
            <li class="active bgcol3" id="satopthumbactive-3" style="display:none" title="" onclick="changeWidget('3')">
             
                <div class="figure"><img src="<?php echo store_fallback_path('store/slider/small3.png')?>" alt=""  /></div>
                  <div class="txt"><h3>New Collection</h3>
                 <p>A lace dress is a great time to have an a nice night out in the town.</p>            
                
                 </div>
              <span class="carouselPointer"><img src="<?php echo store_fallback_path('store/slider/arrow3.png')?>" /></span> </li>
            <li id="satopthumb-3" class="bgcol3" style="" title="" onclick="changeWidget('3')">
             
                <div class="figure"><img src="<?php echo store_fallback_path('store/slider/small3.png')?>" alt=""  /></div>
                
                <div class="txt"><h3>New Collection</h3>
                 <p>A lace dress is a great time to have an a nice night out in the town.</p>
                </div>
                
            </li>
          </ul>
        
        </div>
      
<?php
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

?>
      
<script language="javascript">
currentWidget = 0;
intervalTrigger = 1;
counter = 3;
function changeWidget(widget){
  if(typeof(widget) != 'undefined'){
    currentWidget = widget;
  }else{
    if(intervalTrigger == 1){
      currentWidget = (currentWidget)%counter + 1;
    }else{
      return;
    }
  }
  for(var i=1;i<=counter;i++){
    if($('satopthumbactive-'+i)){
      $('satopthumbactive-'+i).style.display = 'none';
      $('satopthumb-'+i).style.display = '';
      $('satopimage-'+i).style.display = 'none';
      $('satopcontent-'+i).style.display = 'none';
    }
  }
  $('satopthumbactive-'+currentWidget).style.display = '';
  $('satopthumb-'+currentWidget).style.display = 'none';
  $('satopimage-'+currentWidget).style.display = '';
  $('satopcontent-'+currentWidget).style.display = '';
}
changeWidget();
setInterval('changeWidget()',3000);
</script> 
</div> 
</div>
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
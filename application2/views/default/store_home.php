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
               
              <span class="carouselPointer" style="background:url(<?php echo store_fallback_path('store/slider/arrow1.png')?>); background-repeat:no-repeat; width:14px; height:26px;"><img src="<?php echo store_fallback_path('store/slider/arrow1.png')?>"/></span> </li>
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
      <!-- <img src="<?php echo store_fallback_path('store/')?>slider/banner1.jpg" alt=""/> -->
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
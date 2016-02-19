<!--banner-->
<div class="inner-banner">
<div class="inner-banner-main">
 <h2> <?php if(@$news_data){ echo $news_data->page_title ; } ?></h2>
   </div>
 <div class="breadcrumb">
  <p>
 <?php
  foreach ($breadcrumbdata as $key=>$value) { ?>  
    <a href="<?php echo $value ; ?>" style="float:left;width:auto;display:block;"> <?php echo $key ; ?> </a>
  <?php  } ?>
  </p>
 </div>	    	  
</div>
 	  <!--banner-->
<?php
#pr($news_data);
if(!empty($news_data)){
  ?>
  <div class="con">
   <div class="con-inner">
        <div class="inner-txt">
           <p> 
              <?php if(file_exists(site_url().$news_data->page_thumbnailpath) && (trim($news_data->page_thumbnailpath)!="")){ ?>
              <img src="<?php echo site_url().$news_data->page_thumbnailpath ; ?>" alt="" class="f1"/>
              <?php } ?>
               <!-- <span class="heading-bold"></span><br /> -->
               <?php echo $news_data->page_content ; ?>
            </p> 
        </div>     
  </div>
  <div class="con-inner"><a href="<?php echo $breadcrumbdata['News'] ; ?>">Back to News</a></div>
  </div><!--con-->
<?php }else{ ?>
 <div class="con">
    <div class="con-inner">
      <div class="inner-txt">
         Wrong Url incountered 
      </div>     
    </div>
    <div class="con-inner" ><a href="<?php echo $breadcrumbdata['News'] ; ?>">Back to News</a></div>
  </div>
<?php } ?>
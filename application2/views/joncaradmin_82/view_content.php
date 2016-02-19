<!--banner-->
<div class="inner-banner">
   <div class="inner-banner-main">
	   <?php if($content){ ?>

	  <h2><?php echo $content->page_title ; ?></h2>
	  <?php 
		}
		else{

			echo "<h2>404 Not found</h2>";
		}
	  ?>
	  <img  src="<?php echo store_fallback_path('images/about-banner.jpg')?>"/>
	  </div>
 </div>
 	  <!--banner-->
 	<?php if($content){ ?>
   <div class="con">
       <div class="con-inner">
         <div class="con-inner-main">
         <p><?php echo $content->page_content ; ?></p>
         </div>
  	</div>
  </div><!--con-->
<?php } else{
    	echo "Invalid Id";
} ?>

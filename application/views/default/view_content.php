<!--banner-->
<div class="inner-banner">
   <?php
#echo '<pre>';
#print_r($_SERVER['REQUEST_URI']);
   ?>
   <div class="inner-banner-main" style="width:auto;">
	   <?php if($content){ ?>

	  <h2><?php echo $content->page_title ; ?></h2>
	  <?php 
		}
		else{

			echo "<h2>404 Not found</h2>";
		}
	  ?>
	  <?php if(str_replace('/','',$_SERVER['REQUEST_URI']) == 'aboutus') {?>
	  <img  src="<?php echo store_fallback_path('images/about-banner.jpg')?>"/>
	  <?php } ?>
	  
	  <?php if(str_replace('/','',$_SERVER['REQUEST_URI']) == 't_n_c') {?>
	  <img  src="<?php echo store_fallback_path('images/about-banner.jpg')?>"/>
	  <?php } ?>
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

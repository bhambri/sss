<!--banner-->
 	  <div class="inner-banner">
 	      <div class="inner-banner-main">
         <h2><?php echo $page_title; ?></h2>
      	 </div>  
         <div class="breadcrumb">
      
         <?php 
          //pr($breadcrumbdata);
          foreach($breadcrumbdata as $key => $value) {
            ?>
            <a href="<?php echo $value ;?>"><?php echo $key ; ?></a>
         
         <?php
          } 
          ?>
         </div>    	  
 	  </div>
 	  <!--banner-->
     <div class="con">
        <div class="con-inner">
            <div class="inner-txt">
               
               <p>
               	  <!-- <img src="<?php echo layout_url('default/store/')?>images/about-img.jpg" alt="" class="f1"/> -->
               	  <?php echo $page_content; ?>
               </p>
            </div>     
    	</div>
    </div><!--con-->
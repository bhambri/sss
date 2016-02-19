<!--banner-->
  <div class="inner-banner">
     <div class="inner-banner-main">
  	  <h2><?php echo $data['page_title'];?></h2>
  	  </div>
   </div>
 	<!--banner-->	  
<div class="con">
   <div class="con-inner">
     <div class="con-inner-main">
     <p>
	<?php if(file_get_contents(base_url().$data['page_thumbnailpath']) && ($data['page_thumbnailpath'] !="" )){ ?>
	<img src="<?php echo base_url().$data['page_thumbnailpath']; ?>" alt="" />
	<?php } ?>
      <?php echo $data['page_content'];?>
     </p>
     </div>
</div>
</div>

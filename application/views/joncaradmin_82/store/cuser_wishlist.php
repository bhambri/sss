 <?php 

$segs =  $this->uri->segments ;
//pr($segs);
$store_user= $segs[1] ;
 ?>
 	 <!--banner-->
 	  <div class="inner-banner">
 	      <div class="inner-banner-main">
         <h2>My Wishlist</h2>
      	   </div> 	 
      	   
      	     <div class="breadcrumb"><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/home'?>">Home</a>/ My Wishlist</div>
      	    	  
 	  </div>
 	
 	  <!--banner-->
     <div class="con">
        <div class="con-inner">
            <div class="inner-txt">
            
              <div class="accountpage">

                   <?php
                   svci_load_view('store/claccount_sidebar');
                   ?>

       <div class="account-right">               	              
              <div class="heading">
              		My Wishlist
              	</div>
                 <?php if($orders ){
                  
                  ?>
              	<!-- <table width="100%" cellpadding="0" cellspacing="0" class="accounttable"> -->
                <div class="wishlist-details-account">
                      <?php 
                      foreach( $orders as $wishlist  )
                      {      
                                    
                      ?>
                      <div class="wishlist-details-txt">
                                  <div class="img"><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/store/productDetail/'.$wishlist->product_id;?>">
                                  <?php if(@file_get_contents(base_url().$wishlist->image) && $wishlist->image !=''){ ?>
                                  <img src="<?php echo base_url().$wishlist->image;?>" alt=""/><br/><?php #echo $wishlist->product_title; ?>
                                  <?php } else{ ?>
                                  <img src="<?php echo base_url();?>/uploads/products/noprod.png" alt=""/><br/><?php #echo $wishlist->product_title; ?>
                                  <?php } ?></a>
                                  </div>
                                  <div class="txt">                                  
                                  <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/store/productDetail/'.$wishlist->product_id;?>">
                                  <?php echo $wishlist->product_title; ?></a> &nbsp;
                                  </div>
                                  <div class="btn">  
                          <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/user/deleteWishList/'.$wishlist->id; ?>" style="cursor:pointer;" onclick="return confirm('Are you sure you want to delete this item?');" >Delete</a>
                            </div>
                      </div> 
                      
                      <?php 
                      }
                      ?>
                    </div>
               
                <?php if($pagination){ ?>
                <div class="pagination"><?php echo $pagination;?></div>
		<?php } ?>
                <?php }else{ ?>
                <div> No Wishlist there </div>
                <?php } ?>
              </div>
             </div> 
            </div>     
    	</div>
    </div>
<!--con-->

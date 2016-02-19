<?php
$conSeg =  $this->uri->segments[1];

$segs  = $this->uri->segments ;

$product_url = site_url().$segs[1].'/'.$segs[2].'/'.$segs[3].'/'.$segs[4];
?>
<!--banner-->
    <div class="inner-banner">
        <div class="inner-banner-main">
         <h2>Products Details</h2>
         </div> 
         
         <div class="breadcrumb"><a href="<?php echo base_url() .$this->uri->segments[1].'/store'?>">Home </a> / Products Details</div>       
    </div>
    <!--banner-->
     <div class="con">
        <div class="con-inner">
        <?php if(!empty($product_detail)){ ?>
            <div class="inner-txt">
               <div class="singleproduct">
                <div class="left-img">
                <?php 
                  $full_image = site_url().$product_detail['image'];

                  if( !empty( $product_detail['image'] )  && @file_get_contents($full_image))
                  {
                      $full_image = site_url().$product_detail['image'];
                      $settings = array('w'=>450,'h'=>537,'crop'=>true);
                      $image1 = image_resize( $full_image, $settings);
                  }
                  else
                  {
                     $image1 = layout_url('default/store/') . 'images/product1.jpg';
                     $full_image = $image1 ;
                  }

                  $full_image2 = site_url().$product_detail['image2'];

                  if( !empty( $product_detail['image2'] )  && @file_get_contents($full_image2))
                  {
                      $full_image2 = site_url().$product_detail['image2'];
                      $settings = array('w'=>450,'h'=>537,'crop'=>true);
                      $image2 = image_resize( $full_image2, $settings);
                      $imgtwo = 1 ;
                  }
                  else
                  {
                     $image2 = layout_url('default/store/') . 'images/product2.jpg';
                     $full_image2 = $image2 ;
                     $imgtwo = "" ;
                  }

                  $full_image3 = site_url().$product_detail['image3'];

                  if( !empty( $product_detail['image3'] )  && @file_get_contents($full_image3))
                  {
                      $full_image3 = site_url().$product_detail['image3'];
                      $settings = array('w'=>450,'h'=>537,'crop'=>true);
                      $image3 = image_resize( $full_image3, $settings);
                      $imgthree = 1 ;
                  }
                  else
                  {
                     $image3 = layout_url('default/store/') . 'images/product3.jpg';
                     $full_image3 = $image3 ;
                     $imgthree = 0;
                  }
                   #pr($product_detail);
                ?>  
                <div class="zoom-left">
                <img id="zoom_09" src="<?php echo $image; ?>"  data-zoom-image1="<?php echo $image1; ?>" data-zoom-image="<?php echo $full_image;?>" width="450">
                <div id="gallery_09">
                  <?php # if($image1){?>
                  <a href="#" class="elevatezoom-gallery active" data-update="" data-image="<?php echo $image;?>" data-zoom-image="<?php echo $full_image;?>"><img src="<?php echo $image1; ?>" height="80"></a>
                  <?php # } ?>
                  <?php if($imgtwo){ ?>
                  <a href="#" class="elevatezoom-gallery" data-image="<?php echo $image2;?>" data-zoom-image="<?php echo $full_image2;?>"><img src="<?php echo $image2 ;?>" height="80"></a>
                  <?php } ?>
                  <?php if($imgthree){ ?>
                  <a href="#" class="elevatezoom-gallery" data-image="<?php echo $image3;?>" data-zoom-image="<?php echo $full_image3;?>"><img src="<?php echo $image3 ;?>" height="80">
                  </a>
                   <?php } ?>
                </div>
                </div>
                </div><!--left-img-->

                <div class="right-details">
                <h2><?php echo $product_detail['product_title']; ?></h2>
                <?php #pr($product_detail); ?>
                <span class="price"><!-- <span class="off">30%</span><s>$39.00</s> --> <strong>$<?php echo $product_detail['product_price'];?></strong></span>
                <!--- <p><?php echo $product_detail['description']; ?></p> -->
                <?php $sizeArr = explode(',',$product_detail['product_size']) ;
                      #pr($sizeArr) ; ?>
                <form action="<?php echo site_url() . $conSeg ;?>/cart/add" method="POST">  
                 <?php if($sizeArr[0] !="" ){ ?>
                 <div class="size">
                   <div class="selectimg">
                   <select name="size">
                      <option selected=""  value="" >Select size</option>
                      <?php foreach ($sizeArr as $key => $value) {
                        # code...
                        echo '<option>'.$value.'</option>' ;
                      }?>
                      
                    </select> 
                    </div>
                 </div>
                <?php } ?>

                <input type="hidden" name="baseurl" id="baseurl" value="<?php echo site_url().$conSeg ; ?>">
                <input type="hidden" name="id" id="product_id" value="<?php echo $product_detail['id']; ?>">
                <input type="hidden" name="qty" value="1">
                <input type="hidden" name="price" value="<?php echo $product_detail['product_price'];?>">
                <input type="hidden" name="name" value="<?php echo htmlspecialchars($product_detail['product_title']);?>">  
                <input type="hidden" name="image" value="<?php echo $product_detail['image'];?>">                                           
                <div class="cart-btn"><input type="submit" value="Buy Now" class="btn"/></div>
                </form>
                <div class="share-item">
                 <div class="wishlist"><a id="addToWishList" >Add to a wishlist</a></div>
                 <div class="wishlist"><a id="saveToFavourite" >Add to Favourite</a></div>
                 <div class="email"><a href="mailto: ?Subject='Please check this product'&body=<?php echo $product_url ;?>" target="_top">Email to a friend</a></div>
                </div>
                </div>
               </div><!--singleproduct-->
               <div class="product-details"> 
                  <div class="tabber">
                     <div class="tabbertab">
                      <h2>Prducts Details</h2>
                        <p>
                          <p><?php echo $product_detail['description']; ?></p>
                        </p>
                     </div>
                     <div class="tabbertab">
                     <h2>Size and Fit</h2>
                      <p>
                      <table class="basic-table" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                            <tr bgcolor="#f5f5f5">
                              <td width="100"><strong>Size</strong></td>
                              <td><?php echo $product_detail['product_size']!="" ? $product_detail['product_size'] : 'N/A' ; ?></td>
                            </tr>
                           
                            <tr>
                              <td width="100"><strong>Weight</strong></td>
                              <td><?php echo ($product_detail['weight']> 0) ? $product_detail['weight'].' '.'gm Approx.'  : 'N/A'; ?></td>
                            </tr>
                              
                          </tbody>
                       </table>
                      </p>
                     </div>
                  </div> 
               </div>
              </div>
              <div id="content_3" class="tab_view">
                
                  <div class="text">
                  
                  </div>
              </div>
              <?php }else{ ?>
              <div class="inner-txt">
              <?php echo 'In valid url'; ?>
              </div>
             <?php } ?>
            </div> <!-- /#view_container --> 
        </div> <!-- /#content -->                                          
      </div>
    </div>
  </div>     
</div>
</div><!--con-->

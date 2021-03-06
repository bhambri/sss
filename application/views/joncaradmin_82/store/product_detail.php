<script type="text/javascript" src="<?php echo store_fallback_path('js/jquery.validationEngine-en.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo store_fallback_path('js/jquery.validationEngine.js') ; ?>"></script>

<link type="text/css" href="<?php echo store_fallback_path('js/validationEngine.jquery.css') ;?>" rel="stylesheet" />
<script>
   jQuery(document).ready(function(){
      // binds form submission and fields to the validation engine
      jQuery("#formID").validationEngine();
    });
</script>
<?php

#pr($_SERVER['PATH_INFO']) ;
$segs  = $this->uri->segments ;
#pr($segs);
#pr($this->uri->segments) ;
$product_url = site_url().$segs[1].'/'.$segs[2].'/'.$segs[3].'/'.$segs[4] ;
?>
<!--banner-->
<div class="inner-banner">
    <div class="inner-banner-main">
     <h2>Products Details</h2>
     </div> 
      <div class="breadcrumb"><a href="<?php echo base_url() .$this->uri->segments[1].'/store'?>">Home </a> / Products Details</div>       
      <!-- <div class="breadcrumb">Home / Products Details</div>     -->  
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
                      $image = image_resize( $full_image, $settings);
                      //stop resizing
                      //$image = $full_image ;
                  }
                  else
                  {
                     $image = store_fallback_path('store/images/no-images-zoom.png') ;
                     $full_image = $image ;
                  }

                  $full_image2 = site_url().$product_detail['image2'];

                  if( !empty( $product_detail['image2'] )  && @file_get_contents($full_image2))
                  {
                      $full_image2 = site_url().$product_detail['image2'];
                      $settings = array('w'=>450,'h'=>537,'crop'=>true);
                      $image2 = image_resize( $full_image2, $settings);
                      $imgtwo = 1 ;
                      //stop resizing
                      //$image2 = $full_image2 ;
                  }
                  else
                  {
                     $image2 = store_fallback_path('store/images/no-images-zoom.png') ;
                     $full_image2 = $image2 ;
                     $imgtwo = 0 ;
                  }

                  $full_image3 = site_url().$product_detail['image3'];

                  if( !empty( $product_detail['image3'] )  && @file_get_contents($full_image3)  && (file_get_contents($full_image) !='<h1>Invalid store URL</h1>') && (site_url() != $full_image) )
                  {
                      $full_image3 = site_url().$product_detail['image3'];
                      $settings = array('w'=>450,'h'=>537,'crop'=>true);
                      $image3 = image_resize( $full_image3, $settings);
                      $imgthree = 1 ;
                      //stop resizing
                      //$image3 = $full_image3 ;
                  }
                  else
                  {
                     $image3 = store_fallback_path('store/images/no-images-zoom.png') ;
                     $full_image3 = $image3 ;
                     $imgthree = 0 ;
                  }
                ?>  
            <div class="zoom-left">
            
            <img id="zoom_09" src="<?php echo $image; ?>" data-zoom-image="<?php echo $full_image;?>" width="450" alt="" />
            
            
  
            
      
            </div>
    </div>   <!--left-img-->           
    <div class="right-details">
          <h2><?php echo $product_detail['product_title']; ?></h2>
          <span class="price"><!-- <span class="off">30%</span><s>$39.00</s> --> <strong>$<?php echo $product_detail['product_price'];?></strong></span>
         
               <div id="gallery_09">
              <a href="#" class="elevatezoom-gallery active" data-update="" data-image="<?php echo $image;?>" data-zoom-image="<?php echo $full_image;?>"><img src="<?php echo $image; ?>" height="60" alt=""/></a>
              <?php if($imgtwo){ ?>
              <a href="#" class="elevatezoom-gallery" data-image="<?php echo $image2;?>" data-zoom-image="<?php echo $full_image2;?>"><img src="<?php echo $image2 ;?>" height="60" alt="" /></a>
              <?php } ?>
              <?php if($imgthree){ ?>
              <a href="#" class="elevatezoom-gallery" data-image="<?php echo $image3;?>" data-zoom-image="<?php echo $full_image3;?>"><img src="<?php echo $image3 ;?>" height="60" alt="" />
              </a>
              <?php } ?>
             </div>
         
          
          <?php $sizeArr = explode(',',$product_detail['product_size']) ;
          ?>
           <form action="<?php echo site_url() . $this->storename; ?>/cart/add" method="post" id="formID">
           <?php if($sizeArr[0] !="" ){ ?>
           <div class="size">
             <div class="selectimg">
             <select name="size">
                <option value="">Select size</option>
                <?php foreach ($sizeArr as $key => $value) {
                  # code...
                  echo '<option>'.$value.'</option>' ;
                }?>
                
              </select> 
              </div>
           </div>
          <?php } ?>
          
          <input type="hidden" name="baseurl" id="baseurl" value="<?php echo site_url() . $this->storename; ?>"/>
          <input type="hidden" name="id" id="product_id" value="<?php echo $product_detail['id']; ?>"/>
          <input type="hidden" name="qty" value="1"/>
          <input type="hidden" name="price" value="<?php echo $product_detail['product_price'];?>"/>
          <input type="hidden" name="name" value="11<?php echo htmlspecialchars($product_detail['product_title']);?>"/>  
          <input type="hidden" name="image" value="<?php echo $product_detail['image'];?>"/> 
          
          <input type="hidden" name="weight" value="<?php echo ($product_detail['weight'] == 0) ? 500 : $product_detail['weight'] ; ?>"/>                                           
          
          <!-- </form> -->
         <div class="share-item cart_share_item">
             <div class="wishlist"><a id="addToWishList" >Add to a wishlist</a></div>
             <div class="wishlist"><a id="saveToFavourite" >Add to Favourite</a></div>

             <div class="email"><a href="mailto: ?Subject='Please check this product'&body=<?php echo $product_url ;?>" target="_top">Email to a friend</a></div>
             
        </div>
          <!-- New div class added here -->
        <div class="contact-details">
          <?php 
          #echo '<pre>';
          #print_r($productatrr);
          if(!empty($productatrr)){
            foreach ($productatrr as $key => $productatrrsetdetail) {
              # code...
              #echo '<pre>';
              #print_r($productatrrsetdetail) ;
              if(is_array($productatrrsetdetail) && !empty($productatrrsetdetail)){
                 foreach ($productatrrsetdetail as $key => $optiondetail) {
                   # code...
                    #echo '<pre>';
                    $required = '' ;
                    
                    if($optiondetail['required']){
                      $required = 'validate[required]' ;
                    }

                    if($optiondetail['field_type'] == 'text'){
                      ?>
                      <div class="fld dyn_fld">
                      <label><?php echo $optiondetail['field_label'] ; ?></label>
                      <input type="text" class="<?php echo @$required ; ?> inp" name="options[<?php echo $optiondetail['id'];?>]" />
                      </div>
                      
                      <?php
                    }
                    if($optiondetail['field_type'] == 'radio' && (count($optiondetail['option_detail']) > 0 ) ){
                      ?>
                      <div class="fld dyn_fld">
                      <label><?php echo $optiondetail['field_label'] ; ?></label>
                      <!-- <input type="radio" name="<?php echo $optiondetail['id'];?>" /> -->

                      
                      <?php
                     
                      foreach ($optiondetail['option_detail'] as $key => $value) { 
                        ?>
                        
                        <div class="dyn_fld_50"><input type="radio" class="<?php echo @$required ; ?>" name="options[<?php echo $optiondetail['id'] ; ?>][]" value="<?php echo $value['id'] ; ?>" /> <?php echo $value['option_value'] ; ?> <?php if($value['option_price'] > 0){ echo '+ $ '.$value['option_price'] ;}  ?>
                        </div>
                        
                      <?php } ?>
                      </div>
                    <?php }

                    if($optiondetail['field_type'] == 'checkbox' && (count($optiondetail['option_detail']) > 0 )){
                      ?>
                      <div class="fld dyn_fld">
                      <label><?php echo $optiondetail['field_label'] ; ?></label>
                      <!--<input type="radio" name="<?php echo $optiondetail['id'];?>" />
                      -->
                      
                      <?php
                      foreach ($optiondetail['option_detail'] as $key => $value) {
                       
                        # code...
                        #echo '<pre>';
                        #print_r($value);
                        ?>
                        <div class="dyn_fld_50"><input type="checkbox" name="options[<?php echo $optiondetail['id']; ?>][]" value="<?php echo $value['id']; ?>"  class="<?php echo @$required ; ?>"  /> <?php echo $value['option_value'] ; ?> <?php if($value['option_price'] > 0){ echo '+ $ '.$value['option_price'] ;} ?>
                        </div>
                        <?php
                        
                      }
                      #echo '<pre>';
                      #print_r($rulesarray);
                       ?>
                      </div>
                    <?php }
                    if($optiondetail['field_type'] == 'selectbox' && (count($optiondetail['option_detail']) > 0 )){
                      ?>
                     
                      <!-- <input type="radio" name="<?php echo $optiondetail['id'];?>" /> -->
                      <div class="size dyn_fld">
                         <label><?php echo $optiondetail['field_label'] ; ?></label>
                      <div class="selectimg">
                      <select name="options[<?php echo $optiondetail['id'] ; ?>][]"  class="<?php echo @$required ; ?>" >
                      <option value="">Please select</option>
                    <?php 
                      foreach ($optiondetail['option_detail'] as $key => $value) {
                        # code...
                        #echo '<pre>';
                        #print_r($value);
                        ?>
                       <option value="<?php echo $value['id'] ; ?>"><?php echo $value['option_value'] ;?> <?php if($value['option_price'] > 0){ echo '+ $ '.$value['option_price'] ;} ?> </option>
                        <?php
                      } ?>
                      </select>
                      </div> 
                      </div>
                      <br/>
                    <?php }

                 }
              }
            }
          }
          ?>
        </div>
        <div class="cart-btn"><input type="submit" value="Buy Now" class="btn"/></div>
         </form>

         <div class="product-details"> 
      <div class="tabber">
        <div class="tabbertab">
            <h2>Prducts Details</h2>
              <p>
                <p><?php echo html_entity_decode($product_detail['description']) ; ?></p>
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
                <td><?php 
                echo ($product_detail['weight']> 0) ? $product_detail['weight'].' '.'gm Approx.'  : 'N/A'; ?></td>
              </tr>
                
            </tbody>
         </table>
        </p>
       </div>
      </div> 
  </div>
        
        
        
    </div>             
  </div>  <!--singleproduct-->       
 
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
</div></div>   
</div>     
</div>
</div><!--con-->

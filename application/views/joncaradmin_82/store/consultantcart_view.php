<script>
function addtofav(pid)
{
    var product_id = pid ;
    var baseurl    = '<?php echo base_url().$this->uri->segments[1]."/".$this->uri->segments[2] ; ?>';
    
    //alert(product_id);
    //alert(baseurl) ;

    jQuery.ajax({
        type:'POST',
        url:baseurl+'/ajax/saveToFavourite/'+product_id,
        data:'productId='+product_id,
        success: function(result)
        {
            //alert(result);
            if( result == 1 )
            {
                alert('The product is added to your favourites.');
            }else if(result== 2){
                alert('Please login first.');
            }
            else
            {
               alert('Product is already added in your favourites.'); 
            }
        },
        error: function(error)
        {
            alert('Some error occured. Please try again later');
        }
    });
}

</script>
<?php
$conSeg =  $this->uri->segments[2];
?>
<!--banner-->
<div class="inner-banner">
<div class="inner-banner-main">
<h2>Cart</h2>
 </div> 	  	  
 <div class="breadcrumb"><a href="<?php echo base_url() .$this->uri->segments[1].'/'.$this->uri->segments[2].'/home'?>">Home</a> / Cart</div>
</div>

 	<!--banner-->
    <div class="con">
      <div class="con-inner">
        <div class="inner-txt">
          <div class="cart-left">
           

          <?php if($this->session->flashdata('success')) : ?>
          <!-- <div class="sucess-box"><ul> <li><?php echo $this->session->flashdata('success'); ?></li></ul></div> -->
          <?php endif; ?>
          <?php 
if( isset( $cart ) && is_array( $cart ) && !empty( $cart ) )
             {
echo form_open('',array('id'=>'formAddPage','name'=>'formAddPage'));?>
           <div class="group_one" >
              <div class="headings">
	      <span class="item-hd">Items</span>
	      <span class="quantity-hd">Quantity</span>
	      <span class="price-hd">Price</span>
      	  </div>
          <?php 
           
            foreach ($cart as $currentCart ) 
            { 
              $image = site_url().$currentCart['options']['image'] ;
              if($currentCart['options']['image'] && @file_get_contents($image)){
                  $full_image = site_url() . $currentCart['options']['image'];
                  $settings   = array('w'=>150,'h'=>175,'crop'=>true);
                  $image      = image_resize( $full_image, $settings); 
              }
              else
              {
                $image = store_fallback_path('store/images/no-images.jpg') ;
          		  $settings   = array('w'=>150,'h'=>175,'crop'=>true);
          		  $image      = image_resize( $image, $settings); 
              }
            ?>
          <div class="cartproduct">            	 	
            <div class="left-img">           	 	  
                <img src="<?php echo $image;?>" alt="" width="150"/> 	 
            </div><!--left-img-->   
            <div class="right-details">
              <div class="txt">
      	   	  <h2><?php echo htmlspecialchars_decode($currentCart['name']) ;?></h2>
      	   	 
              <?php if(@$currentCart['options']['size'] !="") { ?>
                <div class="sizes">
                  <span class="size-qty">Size <?php echo $currentCart['options']['size'] ; ?></span> <!-- <span class="code">CODE : 257058</span>  -->
                </div> 
                <?php } ?> 
                <div class="sizes cart-page-option">
                  <div>Base price :<strong>$<?php echo $this->cart->format_number($currentCart['options']['unit_price']); ?></strong> |
                  &nbsp; Unit Price :<strong>$<?php echo $this->cart->format_number($currentCart['price']); ?></strong></div>
                  <br/>
                  <div class="price_detail">
                  <?php
                  $CI =& get_instance();
                  foreach ($currentCart['options']['optprices'] as $key => $value) {
                    if($key){ 
                    $required = $CI->isrequired_attribute($key) ; 
                    echo $CI->prciceswithlabel($key).' ' ;
                    if($required){
                      echo '(Required)' ;
                    }
                  ?>
                  <?php if(!$required){ ?><a href="<?php echo base_url().$this->uri->segments[1].'/'.$this->uri->segments[2].'/cart/removeopt/'.$key.'/'.$currentCart['rowid'] ;?>">Remove</a> | <?php } ?>
                  <?php
                   // echo $value ;
                    }
                  }
                  ?>
                  </div>
                  <br/>
                  Specifications :
                  <?php if($currentCart['options']['spcifications']){ echo $currentCart['options']['spcifications'] ;}else{ echo 'NA' ; } ?>
                  <!-- <span class="size-qty text-bold">Size </span>text :comment,text :comment,text :comment,text :comment,text :comment,text :comment,text :comment,text :comment,text :comment,text :comment,text :comment,text :comment, -->
                </div>
                <?php #pr() ; ?>
                 <div class="share-item">
                   <div class="edit" style="display:none;" ><img src="<?php echo store_fallback_path('store/images/edit.png')?>" alt="" title="EDIT SIZE & QTY" class="vtip"/></div>
                   <div class="wishlist"><a href="#" onclick="addtofav('<?php echo $currentCart['id'] ?>');"><img src="<?php echo store_fallback_path('store/images/wishlist2.png')?>" alt="" title="Move to Wishlist" class="vtip"/></a></div>
                   <div class="remove">                              
                    <a id="removeItem" href="<?php echo site_url() . $this->storename.'/'.$conSeg.'/cart/removeitem/'.$currentCart['rowid'] ; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><img src="<?php echo store_fallback_path('store/images/remove.png')?>" alt="" title="Remove from bag" class="vtip"/></a>
                   </div>
                </div>

             </div>
              <span class="price"><span class="off"><?php #echo $currentCart['qty']; ?>
 <span class="select-quantity">              
  <select name="rowid[<?php echo $currentCart['rowid'];?>]">
                    <?php  
                    foreach ($qty_array as $value) {
                        if( $currentCart['qty'] == $value )
                        {
                            echo "<option selected >{$value}</option>";  
                        } 
                        else
                        { 
                            echo "<option>{$value}</option>";
                        }
                    }
                    ?>

                </select>
</span>
                </span> &nbsp; <strong>$<?php echo $this->cart->format_number($currentCart['subtotal']); ?></strong></span>
      	   	   
                
            </div>
          </div>
          <?php } ?>
            <div class="right-btn">
            <input type="hidden" name="updateCartFormSubmitted" value="1">  
                <div class="fld"><input type="submit" value="Update Cart" class="btn"/></div>
             </div> 
          </div> <!-- group one ends here -->	 
          <!-- 
          <div class="coupondiv">
            <div class="left-btn">
                <div class="fld">
                <input type="text" id="couponCodeValue" name="coupon" onclick="javascript:if(this.value=='Coupon Code'){ this.value=''; }" onblur="if( this.value==''){  this.value='Coupon Code';}" value="Coupon Code" class="inp"/>
                <input type="hidden" id="store_id" name="store_id" value="" class="inp"/>
                </div>
                <div class="fld"><input type="button" id="applyCoupon" value="Apply Coupon" class="btn"/></div><span id="couponAlreadyUsed"></span><span id="couponSuccess"></span>
            </div>
            
                      
          </div>  -->
<div class="cart_comment">
       <label>Order Comment:</label> <textarea name="cart_comments" id="cart_comments"><?php echo $cart_comments ;?></textarea>
     </div> 
          <div id="toggle-view1">
              <li><h5 onclick="hideshow();"><span>+</span> Coupon Code</h5>
                  <div class="panel">
                      <div class="coupondiv" style="display:none;">
                            <div class="left-btn">
                                <div class="fld">
                                <input type="text" id="couponCodeValue" name="coupon" onclick="javascript:if(this.value=='Coupon Code'){ this.value=''; }" onblur="if( this.value==''){  this.value='Coupon Code';}" value="Coupon Code" class="inp"/>
                                <input type="hidden" id="store_id" name="store_id" value="" class="inp"/>
                               <input type="button" id="applyCoupon" value="Apply Coupon" class="btn"/>
                                </div>
                              
                          <span id="couponAlreadyUsed"></span>
                          <span id="couponSuccess"></span>
                            </div>
                        </div>                               
                    </div>
                    </li> 
              </div> 


          <?php  echo form_close();?>
          </div>
          <div class="order-total-summary">    

  <h2>Cart Details</h2> 
            <?php 
               
                $grand_total = $this->cart->total();
                //$grand_total = $grand_total+$tax ;
            ?>
            <div class="sub-total">
               <!-- <span style="display:none;">MRP Rs. 4,398</span> --> Sub Total  <div class="item-total-red">$ <?php echo money_format('%.2n',$this->cart->total()); ?></div>
            </div>
            <!-- <div class="shipping">
                Tax <span class="free"></span>
                <span class="item-total-red">$ <?php echo money_format('%.2n',$tax) ; ?></span>
            </div> -->
            <div class="coupon">
              Coupon Discount(-) <span class="item-total-green" id="addDiscount">$ 0</span>
            </div>

            <div class="grand-total">
            <input type="hidden" id="realTotalPrice" value="<?php echo $this->cart->total(); ?>">
            <input type="hidden" id="shipping" value="<?php echo @$shipping_cost; ?>">
            <!-- <input type="hidden" name="tax" id="tax" value="<?php echo $tax; ?>"> -->
               Total <span id="totalPrice">$<?php echo money_format('%.2n',$grand_total);//$this->cart->format_number($this->cart->total()); ?></span>	 
              </div>
                             <div class="placeorder">
                  
                  <form action="<?php echo site_url() . $this->storename.'/'.$conSeg; ?>/cart/checkout" method="get"> 
                    <input type="hidden" name="coupon_code">                     
                   <input type="submit" value="place order" class="btn">
                  </form>
                  <div class="continue-btn"><a href="<?php echo site_url() . $this->storename.'/'.$conSeg; ?>/store/" class="btn"> Continue Shopping</a></div> 
               </div>	
          
          </div>
         <?php 
          }
          else
          { ?>
		<div class="cart_empty">
			Your cart is empty
              <div class="continue-btn"><a href="<?php echo site_url() . $this->storename.'/'.$conSeg; ?>/store/" class="btn"> Continue Shopping</a></div> 
		</div>

         <?php }
         ?>	
          </div>     
    	</div>
    </div><!--con-->

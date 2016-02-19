<!--banner-->
<div class="inner-banner">
<div class="inner-banner-main">
<h2>My Account</h2>
</div> 	 

<div class="breadcrumb"><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/home'?>">Home </a>/ My account</div>
	  
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
                        My Profile <span  class="edit"><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/address/shipping';?>">Edit Shipping Detail</a></span>
                        &nbsp;<span  class="edit"><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/address/billing';?>">Edit Billing Detail</a></span>
                        </div>

                        <div class="details">
                        <div class="details-one">
                        <b><?php echo ucwords( $userDetails['name'] );?></b><br/>
                        <?php echo $userDetails['phone'];?><br/>                  		 
                        <?php echo $userDetails['email'];?>
                        </div>

                        <div class="details-two">
                        <b>Shipping Address</b><br/>
                        <?php if($shippingDetails){ ?>
                        <?php echo $shippingDetails->address; ?>,<br/> <?php echo $shippingDetails->state_code; ?> <?php echo $shippingDetails->postal_code; ?>   
                        <?php } ?>
                        </div>            
                        </div>

                        <div class="heading"> My Recent Purchase  <span  class="edit"><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/user/myorders';?>">View All orders</a></span>
                        </div>
                        <table width="100%" cellpadding="0" cellspacing="0" class="accounttable">


                        <?php 
                        $i = 0;
                        foreach ( $orders as $order ) 
                        {
                        if($i < 10 ){
                        $i++ ; ?>
                        <tr>
                        <!--<td>25 July 2014</td>-->
                        <td><?php echo $order->transaction_id;?></td>
                        <!--<td>Shoes of coxel</td>-->
                        <td>$<?php echo $order->order_amount; ?></td>
                        <td><?php 
                        if( $order->refund_transaction_id == '' )
                        { 
                        echo 'Completed'; 
                        }
                        else
                        {
                        echo 'Refunded';
                        } ?></td>
                        </tr>
                        <?php } }  ?>	
                        	
                        </table>

                
                        <!-- 
                        <div class="heading">
                        My Wishlist
                        </div>

                        <div class="wishlist-details-account">
                        <?php 
                        foreach( $wishlists as $wishlist  )
                        {
                        ?>
                        <div class="wishlist-details-txt">
                       <div class="img"> <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/store/productDetail/'.$wishlist->product_id;?>">
                        <?php if(@file_get_contents(base_url().$wishlist->image) && $wishlist->image !=''){ ?>
                        <img src="<?php echo base_url().$wishlist->image;?>" alt=""/><br/><?php #echo $wishlist->product_title; ?>
                        <?php } else{ ?>
                        <img src="<?php echo base_url();?>/uploads/products/noprod.png" alt=""/><br/><?php #echo $wishlist->product_title; ?>
                        <?php } ?>
                        </a>
                       
                           </div>
                           <div class="txt"> 
                        <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/store/productDetail/'.$wishlist->product_id;?>">
                        <?php echo $wishlist->product_title; ?>
                        </a> &nbsp;
                         </div>
                       <div class="btn"> 
                        <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/user/deleteWishList/'.$wishlist->id; ?>" style="cursor:pointer;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                        </div> 

                        <?php 
                        }
                        ?>
                        </div>
                        -->


                        <div class="heading">
                        My Favourites
                        </div>

                        <div class="wishlist-details-account">
                        <?php 
                        foreach( $favourites as $favourite  )
                        {

                        ?>
                        <div class="wishlist-details-txt">
                        <div class="img"> <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/store/productDetail/'.$favourite->prod_id;?>">
                        <?php if(@file_get_contents(base_url().$favourite->image) && $favourite->image !=''){ ?>
                        <img src="<?php echo base_url().$favourite->image;?>" alt=""/>
                        <?php }else{?>
                        <img src="<?php echo base_url();?>/uploads/products/noprod.png" alt=""/>
                        <?php } ?>
                        

                        <?php #echo $favourite->product_title; ?>
                        </a>
                        
                           </div>
                           <div class="txt"> 
                        <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/store/productDetail/'.$favourite->prod_id;?>">
                        
                        <?php echo $favourite->product_title; ?>
                        </a>
                         </div>
                       <div class="btn">

                        <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/user/deleteFavourites/'.$favourite->id; ?>" style="cursor:pointer;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                        <a href="javascript:void(0);"  onclick="addtocart('<?php echo base_url() .  $this->storename.'/'.$this->uri->segment(2) ; ?>' ,'<?php echo $favourite->prod_id; ?>');" class="add">Add To Cart</a>
                        </div>
                        </div>
                        <?php 
                        }
                        ?>
                        
                        </div>      
                  </div>
            </div>     
      </div>
    </div><!--con-->

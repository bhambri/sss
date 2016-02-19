 <?php 

$segs =  $this->uri->segments ;
//pr($segs);
 ?>
 	 <!--banner-->
 	  <div class="inner-banner">
 	      <div class="inner-banner-main">
         <h2>My orders</h2>
      	   </div> 	 
      	   
      	     <div class="breadcrumb"><a href="<?php echo base_url().'home'?>">Home</a>/ My orders</div>
      	    	  
 	  </div>
 	
 	  <!--banner-->
     <div class="con">
        <div class="con-inner">
            <div class="inner-txt">
              <div class="accountpage">
              <div class="spacer-top"></div>
              <div class="heading">
              		My orders
              	</div>
                 <?php if($orders ){
                    
                  ?>
              	<table width="100%" cellpadding="0" cellspacing="0" class="accounttable">
                 <?php 
                  $i = 0;
                  foreach ( $orders as $order ) 
              	 	{ ?>
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
               	 		 } ?>
                     </td>
                     <td><a href="<?php echo base_url();?>user/orderview/<?php echo $order->id ; ?>/">view order</td>
              	 	</tr>
              	 <?php } ?>	                  	 	
              	</table>
                <div class="pagination"><?php echo $pagination;?></div>
                <?php }else{ ?>
                <div> No orders there </div>
                <?php } ?>
              </div>
            </div>     
    	</div>
    </div>
<!--con-->
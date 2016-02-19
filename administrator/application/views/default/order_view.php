<div class="page">
<table border="0" cellspacing="0" cellpadding="0" class="page_width">
	<tr>
		<td id="id_td_pageHeading" valign="middle"><span id="pageTitle"><?php echo ucfirst($caption);?></span></td>
    </tr>
	<!-- Errors And Message Display Row  -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('errors')): ?>
			<ul class="error_ul"><?php echo $this->session->flashdata('errors');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Errors And Message Display Row  -->
	<!-- Success And Message Display Row  -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('success')): ?>
			<ul class="success_ul"><?php echo $this->session->flashdata('success');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Success And Message Display Row  -->
	<tr>
    <?php 
    
    ?>
		<td id="content_center_td" valign="top">
			<div id="content_div">			
			<?php echo form_open('',array('id'=>'formAddPage','name'=>'formAddPage'));?>
				<table width="80%" border="0" cellspacing="5" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2"><span><?php echo ucfirst($caption);?></span></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Buyer: </td>
						<td width="60%"><?php echo $order_view->buyer;?> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Store name: </td>
						<td width="60%"><?php echo $order_view->store_name;?> </td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Transaction id: </td>
						<td width="60%"><?php echo $order_view->transaction_id;?> </td>
					</tr>
          <tr>
            <td nowrap="nowrap" class="input_form_caption_td" width="40%">Payment Gateway: </td>
            <td width="60%"><?php if($order_view->gateway == 1){ echo 'Maritus' ;}else if($order_view->gateway == 0){echo 'Paypal' ;}else{} ?> </td>
          </tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Grand Total: </td>
						<td width="60%"><?php echo $order_view->order_amount+$order_view->shipping+$order_view->tax  ;?> </td>
					</tr>
					<?php 
					if( !empty( $order_view->refund_transaction_id ))
					{
					?>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Refund transaction id: </td>
						<td width="60%"><?php echo $order_view->refund_transaction_id;?> </td>
					</tr>
					<?php 
					}
					?>
					<tr>
						<td colspan='2' class="form_base_header" align="center">
						<?php 
							if( empty( $order_view->refund_transaction_id ) )
							{
						?>
							<input type="submit" name="refund" value="Refund" class="button">
							<input type="hidden" name="transaction_id" value="<?php echo $order_view->transaction_id;?>">
              <input type="hidden" name="gateway" value="<?php echo $order_view->gateway ; ?>">
							<input type="hidden" name="formSubmitted" value="1" />	
						<?php 
							}
						?>	
						</td>
					</tr>
                     
                     <tr>
                     <td colspan="2">
<div class="account-info-back"> 	

 
 <div class="form-back">
  <?php
#echo '<pre>';
#print_r($order_view);

/*
0- pay pending
1- pay done
2- shipped
3- completed
4- refunded

*/
#print_r($order_detail);
  ?>	
 	<h2>General Details</h2>
  <div class="fld">
      <strong>Customer Name</strong>: <span> <?php echo $order_view->buyer ;?> </span>
  </div>
 	<div class="fld">
 		<strong>Order date:</strong> &nbsp; <?php echo $order_view->created_time ?>
 	</div>
 	<div class="fld">
   
 		<strong>Order Status</strong> 
 		<select  class="sel" disabled>
      <option value="1" <?php if($order_view->order_status == 1 ){ echo 'selected' ;} ?> >Paid</option>
      <option value="2" <?php if($order_view->order_status == 2 ){ echo 'selected' ;} ?> >shipped</option>
      <option value="3" <?php if($order_view->order_status == 3 ){ echo 'selected' ;} ?> >completed</option>
      <option value="4" <?php if($order_view->order_status == 4 ){ echo 'selected' ;} ?> >cancelled /Refunded</option>
      </select>
 	</div>
 	<div class="fld">
  <strong>Order Comment:</strong> &nbsp; <?php if($order_view->order_comment){ echo $order_view->order_comment ; } ?>
  </div>
 	
 </div>	
 
 <?php 

 #print_r($billing_shipping) ;
?>
 <div class="details">
   <?php if(count($billing_shipping['billingdetail']) >0 ){ 
      #echo '<pre>';
#print_r($billing_shipping['billingdetail'][0]) ;
      ?>
	<div class="details-one">
	 <b>Billing Details</b><br/><br/>
	 <?php echo $billing_shipping['billingdetail'][0]->first_name ; ?> <?php echo $billing_shipping['billingdetail'][0]->last_name ; ?>
<br>
   <?php echo $billing_shipping['billingdetail'][0]->address ; ?><br>
   <?php echo $billing_shipping['billingdetail'][0]->city ; ?> ,<?php echo $billing_shipping['billingdetail'][0]->state_code ; ?> ,<?php echo $billing_shipping['billingdetail'][0]->postal_code ; ?> <br>
   Phone: <?php echo $billing_shipping['billingdetail'][0]->phone_number ; ?> <br/>
   Email: <?php echo $billing_shipping['billingdetail'][0]->email ; ?>
    <!-- 801-431-4900<br>                  		 
   sales@onlinemarketplace.com -->
   </div>
   <?php } ?>
   <?php if(count($billing_shipping['shippingdetail']) >0 ){ ?>
  <div class="details-two">
   <b>Shipping Address</b><br/><br/>
   <?php echo $billing_shipping['shippingdetail'][0]->first_name ; ?> <?php echo $billing_shipping['shippingdetail'][0]->last_name ; ?>
<br>
   <?php echo $billing_shipping['shippingdetail'][0]->address ; ?><br>
   <?php echo $billing_shipping['shippingdetail'][0]->city ; ?> ,<?php echo $billing_shipping['shippingdetail'][0]->state_code ; ?> ,<?php echo $billing_shipping['shippingdetail'][0]->postal_code ; ?> <br>
   Phone: <?php echo $billing_shipping['shippingdetail'][0]->phone_number ; ?> <br/>
   Email: <?php echo $billing_shipping['shippingdetail'][0]->email ; ?>
    <!-- 801-431-4900<br>                        
   sales@onlinemarketplace.com -->
   </div> 
   <?php } ?>           
</div>
 
 
 <h3>Order Item</h3>
 <?php 
#echo '<pre>';
#print_r($order_detail);
?>
 
 
 <table cellspacing="0" cellpadding="0" width="100%" class="table-back">
                  	 	
                  	 	<tbody>
                  	 	  <tr>
                  	 		<!-- <th><input type="checkbox"/></th> -->
                  	 		<th>Item</th>
                        <th>Size</th>
                  	 		<th>SKU</th>
                  	 		<th>Qty</th>
                  	 		<th>Total</th>
                  	 		
                  	 	</tr>
                  	 	
                  	 	<?php foreach($order_detail as $item){ 
                        
                           ?>
                  	 	<tr>
                  	 	<!-- <td><input type="checkbox" value="<?php echo $item->id ; ?>"/></td> -->	
                  	 	<td> <?php echo $item->product_title ?> </td>
                      
                  	 	<td><?php echo $item->product_size ; ?></td>
                      <td><?php echo $item->sku ; ?></td>
                  	 	<td><?php echo $item->product_quantity ; ?></td>
                  	 	<td>$ <?php echo $item->product_quantity*$item->product_sale_price  ;?></td>
                  	 	<!-- <td>$0.00</td> -->
                  	 	</tr>
                      <tr>
                        <td> Specification : </td>
                        <td colspan="4"> <?php echo $item->product_specification;?> </td>
                      </tr>
                  	 	<?php } ?>
                  	 	
                  	 	<tr>
                  	 		<td colspan="6">
                  	 		  
                  	 		</td>
                  	 	</tr>
                  	 	
                  	 	   	 	
                  	 </tbody>
  </table>
 

<table cellspacing="0" cellpadding="0" width="10%" class="table-back-total">
                  	 	
                  	 	<tbody>
                  	 	  <tr>
                  	 		<th colspan="2">Order Total</th>
                  	 	</tr>
                  	 	
                  	 	<tr>
                  	 	<td>Billing (item Sub total)</td> <td>$ <?php echo $order_view->order_amount - $order_view->coupon_discount_ammount ; ?></td>	
                  	 	</tr>

                  	 	<tr>
                  	 	<td>shipping</td> <td>$ <?php echo $order_view->shipping ;?></td>	
                  	 	</tr>
                  	 	<tr>
                      <td>Tax</td> <td>$ <?php echo $order_view->tax ;?></td> 

                      </tr>
                      <tr>
                      <td>Discount Amount</td> <td>$ <?php echo $order_view->coupon_discount_ammount ;?></td> 
                      
                      </tr>
                  	 	<tr class="grand-total">
                  	 	 <td>Grand Total</td>
                  	 	 <td class="amount">$<?php echo $order_view->order_amount+$order_view->shipping+$order_view->tax ;?> <!-- <a href="#">Refund</a> --></td>
                  	 	 </tr>
                  	 	   	 	
                  	 </tbody>
  </table>
 </div>


                     </td>
                     </tr>
                     <tr>
                     <td colspan="2" align="center"><input type="button" value="Back" class="button" onclick="javascript:history.back();"/></td>
                     </tr>


				</table>
			<?php echo form_close();?>	
			</div>
		</td>
    </tr>
</table>
</div>

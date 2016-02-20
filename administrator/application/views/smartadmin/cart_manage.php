<script>
function addtofav(pid)
{
    var product_id = pid ;
    var baseurl    = '<?php //echo base_url().$this->uri->segments[1] ; ?>';

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

jQuery(document).ready(function(){
	jQuery('#applyCoupon').click(function(){
        var coupon = jQuery('#couponCodeValue').val();
        var totalPrice = jQuery('#realTotalPrice').val();
        //var tax = jQuery('#tax').val() ;
		var tax = 0 ;
        
        if( coupon != '' ) {   
          jQuery('input[name=coupon_code]').val(coupon);
            var baseurl = '<?php echo site_url();?>';
            
            jQuery.ajax({
                type:'POST',
                url:baseurl+'ajax/couponSession/'+coupon,
                success:function(msg)
                {   
					msg = msg.trim();
					//alert(msg);
                  if( msg != '' && msg !='used' && msg !='expired' && msg != 'not logged in' && msg != 'Invalid Code' && msg !='Invaild code')
                   {     
                      nobj = JSON.parse(msg) ;

                      /*
                      alert(JSON.stringify(msg));
                      alert(msg.amount);
                      alert(msg.amount);
                      */
                      if((nobj.ctype == 2) || (nobj.ctype == 3)){
                          var discountPrice = totalPrice*(nobj.amount)/100;
                          //var grandTotal = Math.round(( parseFloat( totalPrice - discountPrice ) + parseFloat(tax) )*100/100);
                          //var grandTotal = (totalPrice - discountPrice) +tax ;

                          var grandTotal =  Math.round( ( parseFloat(totalPrice) - parseFloat(discountPrice)+parseFloat(tax) )*100)/100 ;

                      }else{
                          var discountPrice = nobj.amount ;
                         // var grandTotal = ( totalPrice - discountPrice ) + tax;
                          //var grandTotal = Math.round( ( parseFloat( totalPrice - discountPrice ) + parseFloat(tax) )*100/100);
                          var grandTotal =  Math.round( ( parseFloat(totalPrice) - parseFloat(discountPrice)+parseFloat(tax) )*100)/100 ;
                      }
                      

                      jQuery('#addDiscount').html( '-$' + parseFloat(discountPrice).toFixed(2) );
                      //var shipping = jQuery('#shipping').val();
                      /*
                      alert(totalPrice) ;
                      alert(grandTotal) ;
                      alert(discountPrice) ;
                      */
                      //grandTotal = +grandTotal 
                      //alert(grandTotal) ;
					  jQuery('#couponAlreadyUsed').html('');
					  jQuery('#couponSuccess').html('<div class="alert alert-success fade in">Coupon applied</div>');

                      jQuery('span#totalPrice').html( '$' + grandTotal.toFixed(2) );
                      return false;    
                    }
                    else if( msg =='used' )
                    {
                        //alert('This coupon is already used Or expired');
                        jQuery('#couponAlreadyUsed').html('<div class="alert alert-danger fade in">This coupon is already used Or expired. Please try another coupon.</div>');
						jQuery('#couponSuccess').html('');
                    }
                    else if( msg =='expired' )
                    {
                        //alert('This coupon is already used Or expired');
                        jQuery('#couponAlreadyUsed').html('<div class="alert alert-danger fade in">This coupon is already used Or expired. Please try another coupon.</div>');
						jQuery('#couponSuccess').html('');
                    }else if(msg =='not logged in'){
                        jQuery('#couponAlreadyUsed').html('<div class="alert alert-danger fade in">Please login to avail Coupon discount functionality</div>');
						jQuery('#couponSuccess').html('');
                    }
                    else
                    {
                        jQuery('#couponAlreadyUsed').html('<div class="alert alert-danger fade in">This coupon is already used Or expired. Please try another coupon.</div>');
						jQuery('#couponSuccess').html('');
                    }
                },
                error:function(error)
                {
                    alert('error is->> '+ error);   
                }
            });
        }
    });

 });
</script>
<div role="content">
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-shopping-cart fa-fw "></i> Cart <span></span></h1>
	</div>
</div>	
<?php if($this->session->flashdata('errors')): ?>
<div class="alert alert-danger fade in">
	<button class="close" data-dismiss="alert">x</button>
	<i class="fa-fw fa fa-times"></i>
	<strong>Error!</strong> <?php echo $this->session->flashdata('errors');?>
</div>
<?php endif; ?>
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success fade in">
	<button class="close" data-dismiss="alert">x</button>
	<i class="fa-fw fa fa-check"></i>
	<strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
</div>
<?php endif; ?>

<div class="widget-body">
	<?php echo form_open('',array('id'=>'formAddPage','name'=>'formAddPage'));?>
            <?php
            if( isset( $cart ) && is_array( $cart ) && !empty( $cart ) ) { ?>
                	
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="text-center">QTY</th>
							<th>ITEM</th>
							<th>DESCRIPTION</th>
							<th>UNIT PRICE</th>
							<th>SUBTOTAL</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($cart as $currentCart )
						{
							$image = base_url().$currentCart['options']['image'] ;
							if($currentCart['options']['image'] && @file_get_contents($image)){
								$full_image = site_url() . $currentCart['options']['image'];
								$settings   = array('w'=>150,'h'=>175,'crop'=>true);
								//$image      = image_resize( $full_image, $settings);
							}
							else
							{
								$image = store_fallback_path('store/images/no-images.jpg') ;
								$settings   = array('w'=>150,'h'=>175,'crop'=>true);
								//$image      = image_resize( $image, $settings);
							}
							
						?>
						<tr>
							<td class="text-center">
								<strong><?php echo $currentCart['qty']; ?> </strong>
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
							</td>
							<td><a href="javascript:void(0);"><?php echo htmlspecialchars_decode($currentCart['name']) ;?></a></td>
							<td>
								<?php if(@$currentCart['options']['size'] !="") { ?>
								<div class="sizes cart-page-option">
									<span class="text-bold">Size <?php echo $currentCart['options']['size'] ; ?></span> <!-- <span class="code">CODE : 257058</span>  -->
								</div>
								<?php } ?>
								<br/>
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
										<?php if(!$required){ ?><a href="<?php echo base_url() .'cart/removeopt/'.$key.'/'.$currentCart['rowid'] ;?>">Remove</a> | <?php } ?>
										<?php
										 echo $value ;
									}
								}
								?>								
								<br/>
								Specifications :
								<?php if($currentCart['options']['spcifications']){ echo $currentCart['options']['spcifications'] ;}else{ echo 'NA' ; } ?>
							</td>
							<td>$<?php echo $this->cart->format_number($currentCart['options']['unit_price']); ?></td>
							
							<td>$<?php echo $this->cart->format_number($currentCart['subtotal']); ?> </td>
							<td><a id="removeItem" href="<?php echo site_url() .'cart/removeitem/'.$currentCart['rowid'] ; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> </td>
						</tr>
						<?php
						} //endforeach
						?>
						
						<tr>
							<td colspan="6"><label>Order Comment:</label>
							<br />
							<textarea style="width:100%;" name="cart_comments" id="cart_comments"><?php echo $cart_comments ;?></textarea></td>
						</tr>
					</tbody>
				</table>
				
                <div class="row padding-10 noMarginLeft noMarginRight">
                    <div class="pull-left">
                        <input type="text" id="couponCodeValue" name="coupon" placeholder="Coupon Code" class="input" required="required" />
                        <input type="hidden" id="store_id" name="store_id" value=""/>
                        <input type="button" id="applyCoupon" value="Apply Coupon" class="btn btn-primary"/>
                    </div>

                    <div class="pull-right">
                        <input type="hidden" namke="updateCartFormSubmitted" value="1">
                        <div class="fld"><input type="submit" value="Update Cart" class="btn btn-warning"/></div>
                    </div>
					<div class="clearfix"></div>
					<div class="pull-left" style="margin-top:5px;">
					<span id="couponAlreadyUsed"></span>
					<span id="couponSuccess"></span>
					</div>
                </div>
                <?php  echo form_close();?>
                <div class="clearfix"></div>
                <hr/>
                <div class="order-total-summary">

                    <?php
                    $cartData = $this->session->userdata('cart_contents');
                    //echo "<pre>";print_r($cartData);
                    $grand_total = $cartData['cart_total'];
                    //$grand_total = $grand_total+$tax ;
                    ?>
                    <div class="pull-right">
                        <span class="pull-left margin-right-5">Sub Total</span>  <div class="txt-color-red pull-left">$ <?php echo money_format('%.2n',$cartData['cart_total']); ?></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="pull-right padding-10 ">
                        Coupon Discount <span class="green" id="addDiscount"> -$ 0  </span>
                    </div>
                    
					<div class="clearfix"></div>
                    <div class="pull-right padding-10 ">
                        <span class="pull-left margin-right-5 font-lg">Total </span><div class="pull-left  font-lg" id="totalPrice">$ <?php echo money_format('%.2n',$grand_total);//$this->cart->format_number($this->cart->total()); ?></div>
                    </div>
					<div class="clearfix"></div>
                    <div class="row-seperator-header">
                        <input type="hidden" id="realTotalPrice" value="<?php echo $cartData['cart_total']; ?>">
                        <input type="hidden" id="shipping" value="<?php echo @$shipping_cost; ?>">
                        <!-- <input type="hidden" name="tax" id="tax" value="<?php echo $tax; ?>"> -->


                        <div class="row padding-10">
                            <div class="pull-left"><a href="<?php echo site_url();?>product/browse" class="btn btn-warning"> Continue Shopping</a></div>
                            <form action="<?php echo site_url()?>cart/checkout" method="get">
                                <input type="hidden" name="coupon_code">
                                <input type="submit" value="place order" class="btn btn-primary pull-right">
                            </form>
                        </div>
                    </div>
                </div>
			<?php
			} else {
				echo "<div class='message danger'>Your Cart is empty</div>";
			}
			?>

</div>
</div>
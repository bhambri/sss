<?php
$conSeg =  $this->uri->segments[2];
$store_name = $this->uri->segments[1] ;
?>
 <!--banner-->
<div class="inner-banner">
  <div class="inner-banner-main">
      <h2>Checkout</h2>
  </div> 	  	  
 	<div class="breadcrumb">Home / Checkout</div>
</div>
<!--banner-->
<div class="con">
  <div class="con-inner">
  <form action="" method="post"> 
  <input type="hidden" name="formSubmitted" value="1">
    <div class="inner-txt">  
      <?php
      if(@$pay_error !=""){ ?>
        <div class="error-box">
            <ul>
              <li>We are unable to process the pay : due to <?php echo urldecode($pay_error) ; ?></li>
            </ul>
          </div>
      <?php } ?>
      <?php if(strlen(validation_errors())) { ?>
          <div class="error-box">
            <ul>
              <?php echo validation_errors("<li>","</li>"); ?>
            </ul>
          </div>
        <?php } ?>  

      <div class="cart-form">
        <div class="form-left">         
            <h5>Billing Details</h5>
            <?php  $billing_state_code =  isset($billing_data['state_code']) ? $billing_data['state_code'] : ''; ?>
              <div class="fld-left">
                 First Name<span class="star">*</span> 
                  <input type="text" name="billing_first_name" id="billing_first_name" class="inp" value="<?php echo set_value('billing_first_name', isset($billing_data['first_name']) ? $billing_data['first_name'] : ''); ?>">
              </div> 
              
              <div class="fld-right">
                 Last Name<span class="star">*</span> 
                  <input type="text" name="billing_last_name" id="billing_last_name" class="inp" value="<?php echo set_value('billing_last_name', isset($billing_data['last_name']) ? $billing_data['last_name'] : ''); ?>">
              </div> 
              <div class="fld-left">
                 State<span class="star">*</span> 
                  <select class="sel" name="billing_state_code" id="state_code">
                    <option value="0">--select--</option>
                    <?php  foreach ($states as $state) {
                    ?>
                            <option value="<?php echo $state->state_code;?>" <?php if( $billing_state_code == $state->state_code ){ echo "selected='selected'"; }?> ><?php echo $state->state; ?></option>
                    <?php  }
                    ?>
                </select>
              </div> 
              <div class="fld-right">
               Phone<span class="star">*</span> 
                  <input type="text" name="billing_phone"  id="billing_phone"  class="inp" value="<?php echo set_value('billing_phone', isset($billing_data['phone_number']) ? $billing_data['phone_number'] : ''); ?>" maxlength="15">
              </div> 
              <div class="fld-left">
                Address<span class="star">*</span> 
                  <input type="text" name="billing_address"  id="billing_address"  class="inp" value="<?php echo set_value('billing_address', isset($billing_data['last_name']) ? $billing_data['last_name'] : ''); ?>">
              </div> 
              <div class="fld-right">
                 Town/City<span class="star">*</span> 
                  <input type="text" name="billing_city"  id="billing_city"  class="inp" value="<?php echo set_value('billing_city', isset($billing_data['city']) ? $billing_data['city'] : ''); ?>">
              </div> 
              <div class="fld-left">
               Email Address<span class="star">*</span> 
                  <input type="text" class="inp" name="billing_email"  id="billing_email"   value="<?php echo set_value('billing_email', isset($billing_data['email']) ? $billing_data['email'] : ''); ?>">
              </div>               
              <div class="fld-right">
               Zipcode<span class="star">*</span> 
                  <input type="text" name="billing_postal_code" class="inp"  id="billing_postal_code"  value="<?php echo set_value('billing_postal_code', isset($billing_data['postal_code']) ? $billing_data['postal_code'] : ''); ?>">
              </div> 
        </div>
        <div class="form-right">  
        <h5>Shipping Details (Same as billing detail )<input type="checkbox" name="same_as_billing" id="same_as_billing" onclick="sameasbilling(this);"> </input></h5>          
              <div class="fld-left">
                 First Name<span class="star">*</span> 
                  <input type="text" name="shipping_first_name" class="inp"  id="shipping_first_name"  value="<?php echo set_value('shipping_first_name', isset($shipping_data['first_name']) ? $shipping_data['first_name'] : ''); ?>">
              </div> 
              
              <div class="fld-right">
                 Last Name<span class="star">*</span> 
                  <input type="text" name="shipping_last_name" class="inp"  id="shipping_last_name"  value="<?php echo set_value('shipping_last_name', isset($shipping_data['last_name']) ? $shipping_data['last_name'] : ''); ?>">
              </div> 


              <?php  $shipping_state_code =  isset($shipping_data['state_code']) ? $shipping_data['state_code'] : ''; ?>
              <div class="fld-left">
                 State<span class="star">*</span> 
                  <select class="sel" name="shipping_state_code" id="state_code" onchange="calculateshipping();" >
                    <option value="0">--select--</option>
                    <?php  foreach ($states as $state) {
                    ?>
                            <option value="<?php echo $state->state_code;?>" <?php if( $shipping_state_code == $state->state_code ){ echo "selected='selected'"; }?> ><?php echo $state->state; ?></option>
                    <?php  }
                    ?>
                </select>
              </div> 
              <div class="fld-right">
               Phone<span class="star">*</span> 
                  <input type="text" name="shipping_phone" class="inp"  id="shipping_phone"  value="<?php echo set_value('shipping_phone', isset($shipping_data['phone_number']) ? $shipping_data['phone_number'] : ''); ?>" maxlength="15">
              </div> 
              <div class="fld-left">
                Address<span class="star">*</span> 
                  <input type="text" name="shipping_address" class="inp"  id="shipping_address"  value="<?php echo set_value('shipping_address', isset($shipping_data['address']) ? $shipping_data['address'] : ''); ?>">
              </div> 
              <div class="fld-right">
                 Town/City<span class="star">*</span> 
                  <input type="text" name="shipping_city" class="inp"  id="shipping_city"  value="<?php echo set_value('shipping_city', isset($shipping_data['city']) ? $shipping_data['city'] : ''); ?>">
              </div> 
              <div class="fld-left">
               Email Address<span class="star">*</span> 
                  <input type="text" class="inp" name="shipping_email"  id="shipping_email"  value="<?php echo set_value('shipping_email', isset($shipping_data['email']) ? $shipping_data['email'] : ''); ?>">
              </div>               
              <div class="fld-right">
               Zipcode<span class="star">*</span> 
                  <input type="text" name="shipping_postal_code"  id="shipping_postal_code"  class="inp" value="<?php echo set_value('shipping_postal_code', isset($shipping_data['postal_code']) ? $shipping_data['postal_code'] : ''); ?>">
              </div>
        </div>
      </div>  
      <div class="coupondiv">
              <div class="left-btn">
                  <div class="fld">
                  <span style="float:left;">Party Purchase</span><input type="text" class="inp" value="Party Purchase Code" onblur="if( this.value==''){  this.value='Party Purchase Code';}" onclick="javascript:if(this.value=='Party Purchase Code'){ this.value=''; }" name="g_code" id="g_code">
                  <!-- <input type="hidden" class="inp" value="" name="store_id" id="store_id"> -->
                  
                  </div>
                  <!-- <div class="fld"><input type="button" class="btn" value="Apply Coupon" id="applyCoupon"></div><span id="couponAlreadyUsed"></span> -->
              </div>
              
                         
      </div>                      
      <div class="order-total-summary">            	 	 
        
        <?php
        
          $grand_total = $this->cart->total();
          if( isset( $coupon ) && !empty( $coupon ) )
          {
            $grand_total = $grand_total-$coupon;
          }

          $grand_total = $grand_total+$tax ;
        ?>
        
          <div class="sub-total">
             Sub Total </span><div class="item-total-red"><?php echo '$ '.money_format('%.2n',$this->cart->total()); ?></div>
          </div>
          <div class="sub-total">
             Tax  <span class="item-total-red" style="text-decoration:none;"> $ <span id="tax" class="item-total-red" style="text-decoration:none;"><?php echo money_format('%.2n',$tax) ; ?></span></span>
          </div>
          <div class="shipping">
                Shipping Cost<span class="free"></span>
                <span class="item-total-red" id="shipping" ><?php echo '$ '.money_format('%.2n',$shipping_cost); ?></span>
          </div>
            <?php 
		$discountprice = 0 ;
    
    $usercoupon_data = $this->session->userdata('coupon_data') ;
    
		if(! empty($usercoupon_data)){
			$coupon_data = $this->session->userdata('coupon_data') ;
			if($coupon_data['ctype'] == 1){
				$discountprice = $coupon_data['amount'] ;
			}else if(($coupon_data['ctype'] == 2) || ($coupon_data['ctype'] == 3)){
				$discountprice = $this->cart->total()*$coupon_data['amount']/100 ;
			}else{
			   $discountprice = 0 ;
			}
		}
    
	?>
	 <div class="coupon">
            Coupon Discount   <span class="item-total-red" style="width:5px;"> -$</span><span class="item-total-green" id="addDiscount"> <?php #echo $coupon; ?> <?php echo '-$'.money_format('%.2n',$discountprice); ?> </span>
          </div>

          <div class="grand-total">
          <input type="hidden" id="realTotalPrice" value="<?php echo $this->cart->total(); ?>">
          <input type="hidden" id="shipping" value="<?php echo $shipping_cost; ?>">
          <input type="hidden" id="tax" value="<?php echo $tax; ?>">
             Total <span id="totalPrice"><?php echo '$ '.money_format('%.2n',$grand_total + $shipping_cost);//$this->cart->format_number($this->cart->total()); ?></span>  
             <div class="placeorder">
             <!--<form action="<?php echo site_url() . $this->storename; ?>/cart/payment" method="post">   -->
              <input type="hidden" name="coupon_code" value="<?php echo $coupon; ?>">                     
              <input type="submit" value="place order" class="btn">
             </div> 
          </div> 

      </div>
          </form>         	             	
    </div>     
  </div>
</div><!--con-->

<script>
  function sameasbilling(obj){
    //alert('sameasbilling') ;
    //alert(JSON.stringify(obj)) ;
    if(jQuery('#same_as_billing').is(':checked')){
      
      jQuery('#shipping_first_name').val(jQuery('#billing_first_name').val()) ;
      jQuery('#shipping_last_name').val(jQuery('#billing_last_name').val()) ;
      jQuery('#shipping_phone').val(jQuery('#billing_phone').val()) ;
      jQuery('#shipping_address').val(jQuery('#billing_address').val()) ;
      jQuery('#shipping_city').val(jQuery('#billing_city').val()) ;

      // 
      jQuery('#shipping_email').val(jQuery('#billing_email').val()) ;
      jQuery('#shipping_postal_code').val(jQuery('#billing_postal_code').val()) ;

      //var select = jQuery('#state_code').html();
      //alert(select) ; billing_state_code
      var select = jQuery("[name='billing_state_code']").html();
      //alert(select) ;
      var nationality = jQuery('select[name="billing_state_code"]').val() ;
      //alert(nationality) ;

      jQuery("[name='shipping_state_code']").html(select) ;
      //jQuery("[name='shipping_state_code']").html(select) ;
      jQuery("[name='shipping_state_code']").val(nationality);
      jQuery("select[name='shipping_state_code']").change();

    }else{
      jQuery('#shipping_first_name').val('') ;
      jQuery('#shipping_last_name').val('') ;
      jQuery('#shipping_phone').val('') ;
      jQuery('#shipping_address').val('') ;
      jQuery('#shipping_city').val('') ;
 
      jQuery('#shipping_email').val('') ;
      jQuery('#shipping_postal_code').val('') ;

      //var select = jQuery('#state_code').html();
      //alert(select) ; billing_state_code
      var select = jQuery("[name='billing_state_code']").html();
      //alert(select) ;

      jQuery("[name='shipping_state_code']").html(select) ;

    }
    // alert(obj.is(':checked'));
  }

  function calculateshipping(){
      var nationality = jQuery("select[name='shipping_state_code']").val() ;
      
        jQuery.ajax({
          url:'<?php echo base_url().$store_name."/cart/changeshipping"; ?>',
          data:{'state_id':nationality},
          success:function(result){
            //alert(result) ;
            //$("#div1").html(result);
            jQuery('span#shipping').html(result) ;

            jQuery('input#shipping').val(result) ;
            
	    calculatetax();
        }});
  }

  function calculatetax(){
      var nationality = jQuery("select[name='shipping_state_code']").val() ;
      var tPrice = jQuery('input#realTotalPrice').val() ;
        jQuery.ajax({
          url:'<?php echo base_url().$store_name."/cart/changetax" ;?>',
          data:{'state_id':nationality,'cart_total':tPrice},
          success:function(result){
            jQuery('span#tax').html(result) ;
            jQuery('input#tax').val(result) ;
            var ttax = jQuery('input#tax').val() ;
            var tPrice = jQuery('input#realTotalPrice').val() ;
            var tshipping =jQuery('input#shipping').val() ;
            var sum = Math.round((parseFloat(ttax)+parseFloat(tPrice)+parseFloat(tshipping))*100)/100 ;
            jQuery('span#totalPrice').html('$ '+sum) ;
        }});
  }

</script>

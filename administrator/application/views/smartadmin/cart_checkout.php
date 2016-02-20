<?php
$coupon_c = $this->input->get('coupon_code') ;
// pr($segs);
?>
<!--banner-->
<div role="conent">
    <div class="widget-body">
        <?php if(@$pay_error !="")
        { ?>
        <div class="alert-danger">
            <ul>
                <li>We are unable to process the pay : due to <?php echo urldecode($pay_error) ; ?></li>
            </ul>
        </div>
        <?php if(strlen(validation_errors())) { ?>
			<div class="alert alert-danger fade in">
				<button class="close" data-dismiss="alert">x</button>
				<ul>
                    <?php echo validation_errors("<li>","</li>"); ?>
                </ul>
			</div>
        <?php } ?>
        <?php } ?>
        <form class="smart-form" action="" method="post">
            <input type="hidden" name="formSubmitted" value="1" />

            <header class="padding-10 noMarginLeft noMarginRight">Billing Details</header>
            <?php  $billing_state_code =  isset($billing_data['state_code']) ? $billing_data['state_code'] : ''; ?>
            <fieldset>
                <section>
                    <label class="label">First Name</label>
                    <label class="input">
                        <input type="text" class="input" name="billing_first_name" id="billing_first_name" value="<?php echo set_value('billing_first_name', isset($billing_data['first_name']) ? $billing_data['first_name'] : ''); ?>"/>
                    </label>
                </section>

                <section>
                    <label class="label">Last Name</label>
                    <label class="input">
                        <input type="text" class="input" name="billing_last_name" id="billing_last_name" value="<?php echo set_value('billing_last_name', isset($billing_data['last_name']) ? $billing_data['last_name'] : ''); ?>"/>
                    </label>
                </section>

                <section>
                    <label class="label">State</label>
                    <label class="select">
                    <select class="select" name="billing_state_code" id="state_code">
                        <option value="0">--select--</option>
                        <?php  foreach ($states as $state) {
                            ?>
                            <option value="<?php echo $state->state_code;?>" <?php if( $billing_state_code == $state->state_code ){ echo "selected='selected'"; }?> ><?php echo $state->state; ?></option>
                        <?php  }
                        ?>
                    </select> <i></i></label>
                </section>
                <section>
                    <label class="label">Phone</label>
                    <label class="input">
                        <input type="text" class="input" id="billing_phone" name="billing_phone" value="<?php echo set_value('billing_phone', isset($billing_data['phone_number']) ? $billing_data['phone_number'] : ''); ?>" maxlength="15">
                    </label>
                </section>
                <section>
                    <label class="label">Town/City</label>
                    <label class="input">
                        <input type="text" class="input" id="billing_city" name="billing_city" value="<?php echo set_value('billing_city', isset($billing_data['city']) ? $billing_data['city'] : ''); ?>">
                    </label>
                </section>
                <section>
                    <label class="label">Email Address</label>
                    <label class="input">
                        <input type="text" class="input" id="billing_email" class="inp" name="billing_email" value="<?php echo set_value('billing_email', isset($billing_data['email']) ? $billing_data['email'] : ''); ?>">
                    </label>
                </section>
                <section>
                    <label class="label">Zipcode</label>
                    <label class="input">
                        <input type="text" class="input" id="billing_postal_code" name="billing_postal_code" value="<?php echo set_value('billing_postal_code', isset($billing_data['postal_code']) ? $billing_data['postal_code'] : ''); ?>">
                    </label>
                </section>
            </fieldset>

            <header class="padding-10 noMarginLeft noMarginRight">Shipping Details(same as billing details) <input type="checkbox" name="same_as_billing" id="same_as_billing" onclick="sameasbilling(this);"> </input></header>
            <fieldset>
                <section>
                    <label class="label">First Name</label>
                    <label class="input">
                        <input type="text" class="input" name="shipping_first_name" id="shipping_first_name" value="<?php echo set_value('shipping_first_name', isset($shipping_data['first_name']) ? $shipping_data['first_name'] : ''); ?>"/>
                    </label>
                </section>

                <section>
                    <label class="label">Last Name</label>
                    <label class="input">
                        <input type="text" class="input" name="shipping_last_name" id="shipping_last_name" value="<?php echo set_value('shipping_last_name', isset($shipping_data['last_name']) ? $shipping_data['last_name'] : ''); ?>"/>
                    </label>
                </section>

                <section>
                    <label class="label">State</label>
                    <label class="select">
                        <select class="select" name="shipping_state_code" id="state_code">
                            <option value="0">--select--</option>
                            <?php  foreach ($states as $state) {
                                ?>
                                <option value="<?php echo $state->state_code;?>" <?php if( $shipping_state_code == $state->state_code ){ echo "selected='selected'"; }?> ><?php echo $state->state; ?></option>
                            <?php  }
                            ?>
                        </select> <i></i></label>
                </section>
                <section>
                    <label class="label">Phone</label>
                    <label class="input">
                        <input type="text" class="input" id="shipping_phone" name="shipping_phone" value="<?php echo set_value('shipping_phone', isset($shipping_data['phone_number']) ? $shipping_data['phone_number'] : ''); ?>" maxlength="15">
                    </label>
                </section>
                <section>
                    <label class="label">Town/City</label>
                    <label class="input">
                        <input type="text" class="input" id="shipping_city" name="shipping_city" value="<?php echo set_value('shipping_city', isset($shipping_data['city']) ? $shipping_data['city'] : ''); ?>">
                    </label>
                </section>
                <section>
                    <label class="label">Email Address</label>
                    <label class="input">
                        <input type="text" class="input" id="shipping_email" class="inp" name="shipping_email" value="<?php echo set_value('shipping_email', isset($shipping_data['email']) ? $shipping_data['email'] : ''); ?>">
                    </label>
                </section>
                <section>
                    <label class="label">Zipcode</label>
                    <label class="input">
                        <input type="text" class="input" id="shipping_postal_code" name="shipping_postal_code" value="<?php echo set_value('shipping_postal_code', isset($shipping_data['postal_code']) ? $shipping_data['postal_code'] : ''); ?>">
                    </label>
                </section>
            </fieldset>

            <div class="form-group">
                <?php
                $grand_total = $this->cart->total();

                if( isset( $coupon ) && !empty( $coupon ) )
                {
                    $grand_total = $grand_total-$coupon;
                }

                #$grand_total = $this->cart->total();
                $grand_total = $grand_total + $tax ;
                ?>
                <div class="pull-right padding-5">
                    <span class="pull-left margin-right-5">Sub-Total</span>
                    <div class="pull-left txt-color-red">$<?php echo money_format('%.2n',$this->cart->total()); ?></div>
                </div>
                <div class="clearfix"></div>
                <div class="pull-right padding-5">
                    <span class="pull-left margin-right-5">Tax</span><div class="txt-color-red pull-left">$<?php echo money_format('%.2n',$tax) ; ?></div>
                </div>
                <div class="clearfix"></div>
                <div class="pull-right padding-5">
                    <span class="pull-left margin-right-5">Shipping Cost</span><div class="txt-color-red pull-left">$<?php echo money_format('%.2n',$shipping_cost) ;?></div>
                </div>

                <?php #echo '<pre>'; //print_r($this->session->userdata('coupon_data')) ;
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
				<div class="clearfix"></div>
                <div class="pull-right padding-5">
					<span class="pull-left margin-right-5">Coupon Discount</span>
					<div class="txt-color-green pull-left"  id="addDiscount"><?php echo '-$'.money_format('%.2n',$discountprice); ?></div>
                </div>

                <div class="payoption" style="display:none;">

                    <?php if($enable_meritus){?>
                        <label>Pay Using:</label>
                        <input id="payusing" type="radio" name="payusing" value="Paypal" checked >Paypal</input>
                        <input id="payusing" type="radio" name="payusing" value="Meritus">Meritus</input>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>

                <div class="pull-right padding-10">
                    <input type="hidden" id="realTotalPrice" value="<?php echo $this->cart->total(); ?>">
                    <input type="hidden" id="shipping" value="<?php echo $shipping_cost; ?>">
                    <input type="hidden" id="tax" value="<?php echo $tax; ?>">
                    <input id="discount_amount" type="hidden" value="<?php echo $discountprice ; ?>"/>

                    <span class="pull-left margin-right-5 font-lg"> Total </span><span class="pull-left  font-lg" id="totalPrice"> $<?php echo money_format('%.2n',$grand_total + $shipping_cost - $discountprice ) ;//$this->cart->format_number($this->cart->total()); ?></span>
                    <footer>
					<input type="hidden" name="coupon_code" value="<?php echo $coupon_c; ?>">
						<button type="submit" class="btn btn-primary">
							Place Order
						</button>
					</footer>
					<div class="pull-right padding-10">
					</div>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
  function sameasbilling(obj){
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
          url:'<?php echo base_url()."cart/changeshipping"; ?>',
          data:{'state_id':nationality},

          success:function(result){
            //alert(result) ;
            //$("#div1").html(result);
            //jQuery('span#shipping').html(result) ;
	    jQuery('span#shipping').html(result) ;

            jQuery('input#shipping').val(result) ;
            
	    calculatetax();
        }});
  }

  function calculatetax(){
      var nationality = jQuery("select[name='shipping_state_code']").val() ;
      var tPrice = jQuery('input#realTotalPrice').val() ;
      var city = jQuery("input[name='shipping_city']").val() ;
      var postalcode = jQuery("input[name='shipping_postal_code']").val() ;
      var discount_amount = jQuery('input#discount_amount').val() ;

        jQuery.ajax({
          url:'<?php echo base_url()."cart/changetax" ;?>',
          data:{'state_id':nationality,'cart_total':tPrice ,'city':city ,'postalcode':postalcode},
          success:function(result){
            jQuery('span#tax').html(result) ;
            jQuery('input#tax').val(result) ;
            var ttax = jQuery('input#tax').val() ;
            var tPrice = jQuery('input#realTotalPrice').val() ;
            var tshipping =jQuery('input#shipping').val() ;
            var sum = Math.round((parseFloat(ttax)+parseFloat(tPrice)+parseFloat(tshipping) - parseFloat(discount_amount) )*100)/100 ;
            jQuery('span#totalPrice').html('$ '+sum) ;
        }});
  }

</script>

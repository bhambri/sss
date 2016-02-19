<!--banner-->
<div class="inner-banner">
  <div class="inner-banner-main">
<h2>Billing Address</h2>
	   </div> 	  	  
	   <div class="breadcrumb"><a href="<?php echo base_url().'home' ;?>">Home </a> / Billing Address</div>
</div>
<!--banner-->
<div class="con">
    <div class="con-inner">
        <div class="inner-txt">
            <div class="registration-details cart-form">
                <?php //echo form_open( $username.'/address/shipping/', array('id'=>'formShipping','name'=>'formShipping' ));?>  
                <form id='formShipping' name='formShipping' action="" method="post" >
				  <div class="form" style="width:100%;">
				  	<?php if(validation_errors()): ?>
				    <div class="fld error-box">
				       
			                    <ul class="error_ul"><li>Please correct the following:</li><?php echo validation_errors('<li>','</li>');?></ul>
		               
		                       <div id="errorsDiv" style="display:none;"></div>
		            </div>
		            <?php endif; ?>
		            
		        	<input type="hidden" name="id" value="<?php if( isset( $id ) ) { echo $id;} ?>" />
					<div class="fld-left">
					   First Name<span class="star">*</span> 
						<input type="text" value="<?php if( isset( $first_name ) ) { echo $first_name;} ?>" name="first_name" maxlength="15" id="first_name" class="inp">
					</div> 
					
					
					<div class="fld-right">
					   Last Name<span class="star">*</span> 
						<input type="text" value="<?php if( isset( $last_name ) ) { echo $last_name;} ?>" name="last_name" maxlength="15" id="last_name" class="inp">
					</div> 
					
					<div class="fld-left">
					   Address<span class="star">*</span> 
						<textarea class="text" name="address" maxlength="500" id="address" ><?php if( isset( $address ) ) { echo $address;} ?></textarea>
					</div> 
					
					
					<div class="fld-right">
					   Address, Line 2<span class="star"></span> 
						<textarea class="text" name="address_2" maxlength="500" id="address_2" ><?php if( isset( $address_2 ) ) { echo $address_2;} ?></textarea>
					</div> 
					
					<div class="fld-left">
					 State<span class="star">*</span> 

						<select class="sel" name="state_code" id="state_code" >
						    <option value="0">--select--</option>
						    <?php  foreach ($states as $state) {
						    	#pr($state) ;
						    ?>
    						        <option value="<?php echo $state->state_code;?>" <?php if( @$state_code == $state->state_code ){ echo "selected='selected'"; }?> ><?php echo $state->state; ?></option>
						    <?php  }
						    ?>
						</select>
					</div> 
					
					<div class="fld-right">
					   City<span class="star">*</span> 
						<input type="text" class="sel" name="city" id="city" maxlength="20" value="<?php if( isset( $city ) ) { echo $city;} ?>">
					</div> 
					
					<div class="fld-left">
					   Postal Code<span class="star">*</span> 
						<input type="text" value="<?php if( isset( $postal_code ) ) { echo $postal_code;} ?>" name="postal_code" id="postal_code" maxlength="10" class="inp">
					</div> 
					
					<div class="fld-right">
					  Phone Number<span class="star">*</span> 
						<input type="text" value="<?php if( isset( $phone_number ) ) { echo $phone_number;} ?>" name="phone_number" id="phone_number" maxlength="12" class="inp">
					</div>
					
					<div class="fld-left">
					  <input type="submit" value="Save" class="btn"/>
					  <input type="hidden" value="1" name="formsubmitted" id="formsubmitted" class="inp">
					   <div class="fld-mandatory">* mark fields are mandatory </div>
					</div>		
		           </div>
		         </form>		
	        <div class="register-img">	
	    </div>
		</div><!--registration details-->    
        </div>     
    </div>
</div><!--con-->
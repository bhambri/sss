<!--banner-->
<div class="inner-banner">
  <div class="inner-banner-main">
<h2>Change Password</h2>
	   </div> 
	   <div class="breadcrumb">
	   <?php #echo '<pre>';
			foreach ($breadcrumbdata as $key => $value) {
				# code...
				echo '<a href="'.$value.'">'.$key.'</a>' ;
			}
	   ?>	  	  
	   </div>
</div>
<!--banner-->
<div class="con">
    <div class="con-inner">
        <div class="inner-txt">
    <div class="accountpage">
           <div class="account-lft-link">
                   	  <ul>
                   	  	<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/user/myorders';?>">My orders</a></li>
                   	  	<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/user/account';?>">Account Info</a></li>
                   	  	<li><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/user/changepassword';?>">Change Password</a></li>
                   	  	<li class="nobtm"><a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/user/changepassword';?>">My wishlist</a></li>
                   	  </ul>
                   </div>
        
        <div class="account-right">
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
					   Old password<span class="star">*</span> 
						<input type="password" name="old_password" maxlength="15" id="old_password" class="inp">
					</div>
					<div class="fld-right">
					   New Password<span class="star">*</span> 
						<input type="password" name="new_password" maxlength="15" id="new_password" class="inp">
					</div> 
					
					<div class="fld-left">
					  <input type="submit" value="Save" class="btn"/>
					  <input type="hidden" value="1" name="formsubmitted" id="formsubmitted" class="inp">
					   <div class="fld-mandatory">* mark fields are mandatory </div>
					</div>	

		           </div>
		         </form>		
	        
		</div><!--registration details-->    
		  </div>
		</div>
        </div>     
    </div>
</div><!--con-->
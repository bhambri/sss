 <!--banner-->
 <div class="inner-banner">
      <div class="inner-banner-main">
 <h2>Reset Password</h2>
  	   </div> 	  	  
  	   <div class="breadcrumb"><a href="<?php echo base_url().$this->uri->segment(1).'/home'?>">Home</a> / Reset Password</div>
 </div>	
 <!--banner-->
	<div class="con">
 	<div class="con-inner">
        <div class="inner-txt">
          	<div class="registration-details">   
	       	<?php if(strlen(validation_errors())) { ?>
           	<div class="error-box">
	            <ul>
	              <?php echo validation_errors("<li>","</li>"); ?>
	            </ul>
           	</div>
   			<?php } ?>  
    		<?php if($this->session->flashdata('success')) : ?>
      		<!-- <div class="sucess-box"><?php echo $this->session->flashdata('success'); ?></div> -->
    		<?php endif; ?>
    
		    <?php echo form_open($this->uri->segment(1).'/user/reset_password',array('id'=>'resetPassword','name'=>'resetPassword'));?>     
			<div class="form">
				<div class="fld">
					New Password<span class="star">*</span> 
					<input type="password" name="password" id="password" value="" class="inp">
				</div>
				<div class="fld">
					Confirm New Password<span class="star">*</span> 
					<input type="password" name="confirm_password" id="confirm_password" value="" class="inp">
				</div> 
				<div class="fld">
					<input type="hidden" name="user_id" value="<?php echo base64_decode(trim($this->uri->segment(4))); ?>" />
					<input type="hidden" name="formSubmitted" value="1" class="button" />
				  	<input type="submit" value="Reset Password" class="btn"/>
				   	<div class="fld-mandatory">* mark fields are mandatory </div>
				</div>
		   	</div>
		    <?php echo form_close() ; ?>
			  <div class="register-img">
			  	 <ul>
				   <li>Lorem ipsum dolor sit amet, cons </li>
				   <li>Lorem ipsum dolor sit amet, cons </li>
				   <li>Lorem ipsum dolor sit amet, cons </li>
			  	 </ul>
			  </div>
		   </div><!--registration details-->
        </div>     
	</div>
	</div><!--con-->
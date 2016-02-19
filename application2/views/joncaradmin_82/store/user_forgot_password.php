 <!--banner-->
<div class="inner-banner">
  <div class="inner-banner-main">
  <h2>Forgot Password</h2>
	   </div> 	  	  
	   <div class="breadcrumb"><a href="<?php echo base_url().'home'?>">Home </a> / Forgot Password</div>
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
    
    <div class="lft-form">
		    <?php echo form_open('user/forgot_password',array('id'=>'forgotPassword','name'=>'forgotPassword'));?>     
			<div class="form">
				<div class="fld">
					Enter Email Address<span class="star">*</span> 
					<input type="text" name="email" id="email" value="" class="inp" />
				</div> 
				<div class="fld">
					<input type="hidden" name="formSubmitted" value="1" class="button" />
				  	<input type="submit" value="Email Reset link" class="btn"/>
				   	<div class="fld-mandatory">* mark fields are mandatory </div>
				</div>
		   	</div>
		    <?php echo form_close() ; ?>
	</div>	    
		    
			  <div class="register-img">	
			  	 <ul>		  	 	 
<li>It's easy to recover </li>
<li>Just follow instructions</li>
<li></li>
			  	 </ul>
			  </div>
		   </div><!--registration details-->
        </div>     
	</div>
</div><!--con-->

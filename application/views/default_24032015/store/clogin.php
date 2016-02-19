 <!--banner-->
<div class="inner-banner">
  <div class="inner-banner-main">
		<h2>Login to your account</h2></h2>
	   </div> 	  	  
	   <div class="breadcrumb"><a href="<?php echo base_url().'/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/home'?>">Home</a> / Login</div>
</div>
<!--banner-->
 <div class="con">
    <div class="con-inner">
        <div class="inner-txt">
       	 	<div class="login-form">
				<div class="login-details">  
				<?php if(strlen(validation_errors())) { ?>
				<div class="error-box">
				<ul>
				<?php echo validation_errors("<li>","</li>"); ?>
				</ul>
				</div>
				<?php } ?>  
				<?php if($this->session->flashdata('success')) : ?>
				<!-- <div class="sucess-box"><ul> <li><?php echo $this->session->flashdata('success'); ?></li></ul></div> -->
				<?php endif; ?>

				<?php echo form_open('',array('id'=>'formAddPage','name'=>'formAddPage'));?>   
				<span class="heading-bg">Sign In to your Account</span>
				<div class="fld">   

				<input type="text" name="username" class="inp"  value="<?php echo set_value('username', $username ) ; ?>" placeholder="Username">
				</div>
				<div class="fld">

				<input type="password" class="inp" name="password" placeholder="Password">
				</div>  

				<div class="fld"> 
				<div class="txt"><a href="<?php echo base_url() .  $this->storename.'/'.$this->uri->segment(2); ?>/user/forgot_password">Forgot password?</a> | <a href="<?php echo base_url() .  $this->storename.'/'.$this->uri->segment(2); ?>/user/register">Register</a></div>		 <input type="submit" value="Login" class="btn">
				</div>

				<input type="hidden" name="loginFormSubmitted" value="1">       
				<?php echo form_close() ; ?>
				</div>
			<div class="register-btn">
				<span><a href="<?php echo base_url() .  $this->storename.'/'.$this->uri->segment(2); ?>/user/consultant">Register as a <?php echo $this->consultant_label ;?></a></span>
				
				<span><a href="<?php echo base_url() .  $this->storename.'/'.$this->uri->segment(2); ?>/user/register">Register as a user</a></span>
			</div>	
		</div>     
        </div>     
	</div>
</div>
<!--con-->

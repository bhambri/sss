 <?php 
    error_reporting(0);
 ?>
 <!--banner-->
  <div class="inner-banner">
      <div class="inner-banner-main">
       <h2>Register as a Customer</h2>
       </div>         
      <div class="breadcrumb"><a href="<?php echo base_url().$this->uri->segment(1).'/home'?>">Home </a>/ Register Customer</div> 
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

          <div class="form">
           <?php echo form_open('',array('id'=>'formAddPage','name'=>'formAddPage'));?>   
          <div class="fld">
              Name<span class="star">*</span> 
            <input type="text" maxlength="20" name="name" id="name"  value="<?php echo set_value('name', $name ) ; ?>" class="inp">
          </div> 
          <div class="fld">
              Phone Number<span class="star">*</span> 
            <input type="text" name="phone" id="phone"  value="<?php echo set_value('phone', $phone ) ; ?>" class="inp">
          </div> 
          <div class="fld">
              Email<span class="star">*</span> 
            <input type="text" maxlength="40" name="email" id="email"  value="<?php echo set_value('email', $email ) ; ?>" class="inp">
          </div> 
          <div class="fld">
          User Name<span class="star">*</span> 
            <input type="text" maxlength="20" name="username" id="username"  value="<?php echo set_value('username', $username ) ; ?>" class="inp">
          </div> 
          <div class="fld">
          Password<span class="star">*</span> 
            <input type="password" maxlength="20" name="password" id="password"  value="<?php echo set_value('password', $password ) ; ?>" class="inp">
          </div> 
          <div class="fld">
          Confirm Password<span class="star">*</span> 
            <input type="password" maxlength="20" name="confirm_password" id="confirm_password"  value="<?php echo set_value('confirm_password', $confirm_password ) ; ?>" class="inp">
          </div> 
          
          <div class="fld">
            <input type="checkbox" name="tnd" <?php echo ($tnd)?'checked':'';?> value="yes" /> <a href="<?php echo base_url().$this->storename.'/t_n_c' ?>" target="_blank" >Terms of use</a><span class="star">*</span> 
          </div> 
          <div class="fld">
            <input type="hidden" name="formSubmitted" value="1" class="button" />
            <input type="submit" value="Submit" class="btn"/>
             <div class="fld-mandatory">* mark fields are mandatory </div>
          </div>
           <?php echo form_close() ; ?>
         </div>
          <div class="register-img">
            <ul> 
              <li>Happy Shopping</li>
              <li>Best Deals</li>
              <li>Best Price</li>
            </ul>
          </div>
         </div><!--registration details-->  
        </div>     
      </div>
    </div><!--con-->

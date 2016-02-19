<?php 
  error_reporting(0);
?>
<SCRIPT>
  var rules=new Array();
  rules[0] = 'name|required|Enter your name here';
  rules[1] = 'name|alphaspace|Enter your name only containing alphaspaces here';
  
  rules[2]= 'email|required|Enter your email here';
  rules[3] = 'email|email|Enter vaild email here';

  rules[4]= 'phone|required|Enter your phone here';
  rules[5] = 'phone|numeric|Enter vaild phone here';
  rules[6]= 'subject|required|Enter your subject here';
  rules[7] = 'comments|required|Enter your message';
  rules[8] = 'comments|minlength|5|Message should be of min. 5 char. length';
</SCRIPT>
<script type="text/javascript">
function cap()
{
  var num1 = Math.ceil(Math.random() * 9);
  var num2 = Math.ceil(Math.random() * 9);
  var num3 = Math.ceil(Math.random() * 9);
  var num4 = Math.ceil(Math.random() * 9);
  var code = num1+''+''+num2+''+num3+''+num4;
  document.formAddPage.cahp.value = code;
  document.getElementById('cap').innerHTML = code;
  rules[18]='caph|equal|'+code+'|Enter valid captcha code';
}
</script>
<script>
    window.onload = cap;
</script>

<!--banner-->
<div class="inner-banner">
   <div class="inner-banner-main">
	  <h2>Registration</h2>
    <img  src="<?php echo store_fallback_path('images/about-banner.jpg') ?>"/>
	  </div>
</div>
<!--banner-->
<div class="con">
  <div class="con-inner">
    <div class="con-inner-main">
      <div class="registration-details">

      <h2>Registration of a free account</h2>
      <p>Get in touch with us in a moment. 
      You can find our location on the map, phone number to communicate with 
      our members and email address to ask your questions.
      <div class="fld-mandatory" style="text-align:center;"><strong>All fields marked * are required</strong> </div>
      </p>

      <?php if(strlen(validation_errors())) { ?>
          <div class="error-box">
            <ul>
              <?php echo validation_errors("<li>","</li>"); ?>
            </ul>
          </div>
      <?php } ?>  
      <?php if($this->session->flashdata('success')) : ?>
      <div class="sucess-box"><ul> <li><?php echo $this->session->flashdata('success'); ?></li></ul></div>
      <?php endif; ?>            
          <div class="form">
            <?php echo form_open('',array('id'=>'formAddPage','name'=>'formAddPage'));?>  
            <?php //echo form_open('',array('id'=>'formAddPage','name'=>'formAddPage', 'onsubmit'=>'return yav.performCheck(\'formAddPage\', rules, \'inline\');'));?>  

          <div class="fld">
              Name<span> * </span> 
            <input type="text" maxlength="20" name="fName" id="fName"  value="<?php echo set_value('fName', $fName ) ; ?>" class="inp" />
          </div> 
          <div class="fld">
              Username<span> * </span>
            <input type="text" maxlength="20" name="username" id="username"  value="<?php echo set_value('username', $username ) ; ?>" class="inp" />
          </div> 
          
          <div class="fld">
              Email<span> * </span>
            <input type="text" maxlength="40" name="email" id="email" value="<?php echo set_value('email', $email ) ; ?>" class="inp" />
          </div> 
          
          <div class="fld">
              Phone Number<span> * </span>
            <input type="text" name="phone" id="phone"  value="<?php echo set_value('phone', $phone ) ; ?>" class="inp" />
          </div> 
        
          <div class="fld">
          Store Name<span> * </span>
            <input type="text" maxlength="30" name="company" id="company"  value="<?php echo set_value('company', $company ) ; ?>" class="inp" />
          </div> 
          
          <div class="fld">
          Address<span> * </span>
            <textarea name="address" maxlength="500" id="address" class="text"><?php echo set_value('address', $address ) ; ?></textarea>
          </div> 
          
          <div class="fld">
          State<span> * </span>
          <?php //echo "<pre>";print_r($states);?>
          <select class="sel" name="state_code" id="state_code">
            <option value="">--Select State--</option>
            <?php 
              foreach ($states as $data) {
                ?>
                <option value="<?php echo $data['state'] ?>"><?php echo $data['state']; ?></option>
                <?php 
              }
            ?> 
          </select>
          </div> 
          <div class="fld">
          City<span> * </span>
            <input type="text" maxlength="30" name="city" id="city"  value="<?php echo set_value('city', $city ) ; ?>" class="inp" />
          </div> 
          <div class="fld">
          Zip<span></span>
            <input type="text" maxlength="6" name="zip" id="zip"  value="<?php echo set_value('zip', $zip ) ; ?>" class="inp" />
          </div>
          <div class="fld">
          Comments<span> * </span>
            <textarea maxlength="200" name="comments" id="comments" class="text"><?php echo set_value('comments', $comments ) ; ?></textarea>
          </div> 
          <div class="fld">
            <input type="hidden" name="formSubmitted" value="1" class="button" />
            <input type="submit" value="Submit" class="btn"/>
             
          </div>
          <?php echo form_close() ; ?>
         </div>
         </div><!--registration details-->
        </div>
      </div>
    </div><!--con-->

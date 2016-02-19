<?php
  error_reporting(1);
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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
<script src="<?php echo store_fallback_path('js/jquery.textareaCounter.plugin.js')?>" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function(){
        
      var options2 = {
          'maxCharacterSize': 500,
          'originalStyle': 'originalTextareaInfo',
          'warningStyle' : 'warningTextareaInfo',
          'warningNumber': 40,
          'displayFormat' : '#input/#max | #words words'
      };
        $('#comments').textareaCount(options2);
      });

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
 	  	  <h2>Contact Us</h2>
 	  	  <img  src="<?php echo store_fallback_path('images/about-banner.jpg')?>"/>
 	  	  </div>
 	   </div>
 	  <!--banner-->
 	  
     <div class="con">
         <div class="con-inner">
           <div class="con-inner-main">
              
                 <div class="contact-details">
            <div class="left">
            
             <h2>Queries/Comments:</h2>
            
            <p>Get in touch with us in a moment. 
You can find our location on the map, phone number to communicate with 
our members and email address to ask your questions.</p>
            <?php if(strlen(validation_errors())) { ?>
          <div class="error-box" style="width:100%;">
            <ul>
              <?php echo validation_errors("<li>","</li>"); ?>
            </ul>
          </div>
      <?php } ?>
      <?php if($this->session->flashdata('success')) : ?>
           <div class="sucess-box" style="width:100%;"><ul> <li><?php echo $this->session->flashdata('success'); ?></li></ul></div>
      <?php endif; ?> 
          <div class="form">
          <?php //echo form_open('',array('id'=>'formAddPage','name'=>'formAddPage', 'onsubmit'=>'return yav.performCheck(\'formAddPage\', rules, \'inline\');'));?>  
          <?php echo form_open('',array('id'=>'formAddPage','name'=>'formAddPage'));?>  
          <div class="fld">
              Name<span class="star">*</span>
            <input type="text" name="name" id="name" maxlength="50" value="<?php echo set_value('name', $name ) ; ?>" class="inp">
            <span class="error" id="errorsDiv_name"></span>
          </div> 
          
          
          <div class="fld">
              Email<span class="star">*</span> 
            <input type="text" name="email" id="email" value="<?php echo set_value('email', $email ) ; ?>" class="inp">
            <span classs="error" id="errorsDiv_email"></span>
          </div> 
          
          <div class="fld">
              Phone Number<span class="star">*</span> 
            <input type="text" name="phone" id="phone" maxlength="12" value="<?php echo set_value('phone', $phone ) ; ?>" class="inp">
            <span class="error" id="errorsDiv_phone"></span>
          </div> 
          
          
          <div class="fld">
          Subjects<span class="star">*</span> 
            <input type="text" name="subject" id="subject" value="<?php echo set_value('subject', $subject ) ; ?>" class="inp">
            <span class="error" id="errorsDiv_subject"></span>
          </div> 
          
          
          <div class="fld">
          Comments<span class="star">*</span> 
            <textarea class="text" id="comments" name="comments" value="<?php echo set_value('comments', $comments ) ; ?>"></textarea>
            <span class="error" id="errorsDiv_comments" style="display:none;"></span>
          </div> 
          
          <div class="fld">
            <input type="hidden" name="formSubmitted" value="1" class="button" />
            <input type="submit" value="Submit" class="btn"/>
             <div class="fld-mandatory">* mark fields are mandatory </div>
          </div>
          <?php echo form_close() ; ?>
          
          
         </div>
          
          </div><!--left-->
          
          <div class="right">
                <div class="address">
                  <h2>Address:</h2>
                  <p>
                    <?php echo $address->page_content; ?>
                   </p>                
        <div class="map">        
         <script src="http://maps.google.com/maps/api/js?sensor=false" 
                 type="text/javascript"></script> 
         <div id="map" style="width: 100%; height: 300px;"></div> 

         <script type="text/javascript"> 
           var address = '<?php echo $googlemap; ?>';
           var map = new google.maps.Map(document.getElementById('map'), { 
               mapTypeId: google.maps.MapTypeId.TERRAIN,
               zoom: 50
           });
           var geocoder = new google.maps.Geocoder();

           geocoder.geocode({
              'address': address
           }, 
           function(results, status) {
              if(status == google.maps.GeocoderStatus.OK) {
                 new google.maps.Marker({
                    position: results[0].geometry.location,
                    map: map
                 });
                 map.setCenter(results[0].geometry.location);
              }
           });
        </script>
        </div>
        </div>  
      </div>
    </div><!--contact details-->
  </div>
</div>
</div><!--con-->
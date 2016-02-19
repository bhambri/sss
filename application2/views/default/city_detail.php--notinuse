<script type='text/javascript' language='javascript'>
//<![CDATA[
	var rules = new Array();
	rules[0] = 'name|required|Enter your name here';
	rules[1] = 'name|alphaspace|Enter your name only containing alphaspaces here';
	
	rules[2]= 'email|required|Enter your email here';
	rules[3] = 'email|email|Enter vaild email here';

	rules[4] = 'comments|required|Enter your message';
    rules[5] = 'comments|minlength|5|Message should be of min. 5 char. length';
    rules[5] = 'caph|required|Enter captcha code';

</script>
<script type="text/javascript">
	    function cap()
		 {
			 var num1 = Math.ceil(Math.random() * 9);
			 var num2 = Math.ceil(Math.random() * 9);
			 var num3 = Math.ceil(Math.random() * 9);
			 var num4 = Math.ceil(Math.random() * 9);
			 var code = num1+''+''+num2+''+num3+''+num4;
			 document.formAddContact.cahp.value = code;
			 document.getElementById('cap').innerHTML = code;
			 rules[18]='caph|equal|'+code+'|Enter valid captcha code';
		 }
         function vali(){
            if(!document.formAddContact.caph.value)
			{
				 document.getElementById('error').innerHTML = ' *Plese Enter Captcha';
				 return false;
			}
			else
			{
				if(document.formAddContact.caph.value.match(document.formAddContact.cahp.value))
				{	
				return performCheck('formAddContact', rules, 'inline');	 
				}
 				else
  				{
				 document.getElementById('error').innerHTML = ' *Invalid';
				 cap();
				 document.formAddContact.caph.value = '';
				 return false;
				}
			}
        }
</script>
<script>
    window.onload = cap;
</script>
<div class="main_content">
	<?php if($city){ ?>
	<h1 class="mainheading"	>City Description</h1>
	    <?php if($this->session->flashdata('errors')): ?>
		<ul class="error_ul"><?php echo $this->session->flashdata('errors');?></ul>
		<?php endif; ?>
		<?php if($this->session->flashdata('success')): ?>
		<ul class="success_ul"><?php echo $this->session->flashdata('success');?></ul>
		<?php endif; ?>

		<p><span class="hightlightp">City Name:</span>
		<?php echo $city->name ;?></p><div class="clr"></div>
		<p><span class="hightlightp">Description:</span><?php echo $city->page_content ;?>
		</P>
		<div class="clr"></div>
		<?php echo form_open('',array('id'=>'formAddContact','name'=>'formAddContact', 'onsubmit'=>'return yav.performCheck(\'formAddContact\', rules, \'inline\');'));?>		
		<p>
			<input placeholder="Your Name" name="name" id="name"/></br>
			<span class="error">Please fill the empty area</span> <span id="errorsDiv_name"></span>
		</p>
			
		<p>
			<input placeholder="Your Email" name="email" id="email"/></br>
			<span class="error">Please fill the empty area</span><span id="errorsDiv_email"></span>
		</p>
		<div class="clr"></div>
		<p>
			<textarea cols="41" rows="8" placeholder="Your Message" name="comments" id="comments" ></textarea>
			<div class="clr"></div>
			<span id="errorsDiv_comments"></span>
		</p>
		<div class="clr"></div>
		<p>
			<input type="text" name="caph" class="input" placeholder="Enter The captcha code" />
	        <span disabled id="cap" style="font-family:Arial, Helvetica, sans-serif; cursor: pointer; background-color: green; padding: 8px; color: white; font-size:12px; font-weight:bold;"></span>
	        <span id="error" class="reg_error"></span>
	         
	        <input type="hidden" name="cahp" />
	        <div class="clr"></div>
	        <span id="errorsDiv_caph"></span>
		</p>
		<div class="clr"></div>
		<div class="submit_button">
			<input type="submit" name="submit" class="button test" value="Submit" />
			<input  type="hidden" name="formSubmitted" value="1" class="button" />
			<input  type="hidden" name="city_id" value="<?php echo $city->id;?>" class="button" />
			<input  type="hidden" name="city" value="<?php echo $city->name;?>" class="button" />
		</div>	 
        <?php echo form_close();?>
	<?php } else{ ?>
		<?php echo '<div style="padding-top:20px;"> Page not found ! </div>' ; ?>
	<?php } ?>
</div>
<div class="clr"></div>
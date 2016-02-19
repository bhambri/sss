<SCRIPT>
    var rules=new Array();
	rules[0] = 'name|required|Enter your name here';
	rules[1] = 'name|alphaspace|Enter your name only containing alphaspaces here';
	
	rules[2]= 'email|required|Enter your email here';
	rules[3] = 'email|email|Enter vaild email here';

	rules[4] = 'comments|required|Enter your message';
    rules[5] = 'comments|minlength|5|Message should be of min. 5 char. length';
    rules[6] = 'caph|required|Enter captcha code';
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
function vali()
{
     if(!document.formAddPage.caph.value)
		{
			document.getElementById('error').innerHTML = ' *Plese Enter Captcha';
			return false;
		}
		else
		{
			if(document.formAddPage.caph.value.match(document.formAddPage.cahp.value))
			{	
			return performCheck('formAddPage', rules, 'inline');	 
			}
			else
			{
			document.getElementById('error').innerHTML = ' *Invalid';
			cap();
			document.formAddPage.caph.value = '';
			return false;
			}
		}
}
</script>
<script>
    window.onload = cap;
</script>

<div class="main_content">
	<h1 class="mainheading">Contact us</h1>
	<?php if($this->session->flashdata('errors')) :?>
		<ul class="error_ul"><?php echo $this->session->flashdata('errors'); ?></ul>
	<?php endif; ?>
	<?php if($this->session->flashdata('success')) : ?>
		<!-- <ul class="success_ul"><?php echo $this->session->flashdata('success'); ?></ul> -->
	<?php endif; ?>
	<div class="contact_left">
	    
		<?php echo form_open('',array('id'=>'formAddPage','name'=>'formAddPage', 'onsubmit'=>'return yav.performCheck(\'formAddPage\', rules, \'inline\');'));?>
			<p>	
				<input type="text" placeholder="Your Name" name="name" id="name" value="<?php echo set_value('name', $name ) ; ?>"/></br>
				<span class="error" id="errorsDiv_name"></span>
			</p>

			<p>
				<input type="text" placeholder="Your Email" name="email" id="email" value="<?php echo set_value('email', $email ) ; ?>"/></br>
				<span classs="error" id="errorsDiv_email"></span>
			</p>
			
			<div class="clr"></div>
			<p>
				<textarea cols="41" rows="8" placeholder="Your Message" id="comments" name="comments" value="<?php echo set_value('comments', $comments ) ; ?>" ></textarea>
				</br>
				<span class="error" id="errorsDiv_comments"></span>
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
				<input type="hidden" name="formSubmitted" value="1" class="button" />
			    <input type="submit" name="submit" class="button test" value="Submit" />
			</div>
            <?php echo form_close() ; ?>
	</div>
	
	<div class="contact_right">
	<img src="<?php echo layout_url('default/img')?>/5dogs.jpg" style="margin-top:20px;"/>
		<h2>Christy Thom</h2>
		<p><span class="location"></span>Orange County, CA Executive Director</br>
        <span class="contact"></span>714.290.2744</br>	
		<span class="mail"></span>cthom@dogdaycare.com</p>
	</div>
	
<iframe class="orng_cont" width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Orange+County,+CA+&amp;aq=&amp;sll=33.842986,-118.095299&amp;sspn=1.003729,2.113495&amp;ie=UTF8&amp;hq=&amp;hnear=Orange,+Orange+County,+California&amp;ll=33.787794,-117.853112&amp;spn=0.03139,0.066047&amp;t=m&amp;z=14&amp;output=embed"></iframe>

</div>
<div class="clr"></div>
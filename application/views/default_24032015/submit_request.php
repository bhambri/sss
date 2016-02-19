<SCRIPT>
    var rules=new Array();
    rules[0]='name|required|Enter name here';
    rules[1]='email|required|Enter email here';
    rules[2]='email|email|Enter vaild email here';  
    rules[3]='address|required|Enter address ';
    rules[4]='address|required|Enter valid address ';    
    rules[5]='city|required|Enter city ';
    rules[6]='city|alphaspace|Enter valid city ';
    rules[7]='state|required|Enter state';
    rules[8]='state|alphaspace|Enter valid state';
    rules[9]='zip|required|Enter Zipcode';
    rules[10]='zip|numeric|Enter valid Zipcode'; 
    rules[11]='cphone|required|Enter contact detail here';
    rules[12]='cphone|alnumhyphen|Enter valid contact detail here';
    rules[13]='invest|required|Select duration';
    rules[14]='units|required|Select units';

    rules[15] = 'how_know|required|How did you hear about us';
    rules[16] = 'how_know|minlength|5|How did you hear about us ? should be of min. 5 char. length';

    rules[17]='caph|required|Enter captcha code';
</SCRIPT>
<script type="text/javascript">
function cap()
 {
	 var num1 = Math.ceil(Math.random() * 9);
	 var num2 = Math.ceil(Math.random() * 9);
	 var num3 = Math.ceil(Math.random() * 9);
	 var num4 = Math.ceil(Math.random() * 9);
	 var code = num1+''+''+num2+''+num3+''+num4;
	 document.contact_form.cahp.value = code;
	 document.getElementById('cap').innerHTML = code;
	 rules[18]='caph|equal|'+code+'|Enter valid captcha code';
 }
 function vali()
 {
         if(!document.contact_form.caph.value)
     {
    	 document.getElementById('error').innerHTML = ' *Plese Enter Captcha';
    	 return false;
     }
     else
     {
    	if(document.contact_form.caph.value.match(document.contact_form.cahp.value))
    	{	
    	return performCheck('contact_form', rules, 'inline');	 
    	}
    		else
    		{
    	 document.getElementById('error').innerHTML = ' *Invalid';
    	 cap();
    	 document.contact_form.caph.value = '';
    	 return false;
    	}
     }
}
</script>
<script>
    window.onload = cap;
</script>
<div style="display:none;">
    <DIV id="errorsDiv"></DIV>
</div>
<div id="wrapper-content">
     <?php if($this->session->flashdata('errors')): ?>
            <ul class="error_ul"><?php echo $this->session->flashdata('errors');?></ul>
        <?php endif; ?>
        <?php if($this->session->flashdata('success')): ?>
            <ul class="success_ul"><?php echo $this->session->flashdata('success');?></ul>
        <?php endif; ?>

    <?php 
    echo form_open('',array('id'=>'contact_form','class'=>'contact_form','name'=>'contact_form', 'onsubmit'=>'return yav.performCheck(\'contact_form\', rules, \'inline\');')); 
    ?>

       <ul>
        <li>
             <h2>Request information </br> <span style="color: #808080;font-family: verdana;font-size: 12px;">*All Fields are Required</span></h2>
             </li>
        <li>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Your name" value="<?php if(!empty($data)) { echo $data['name']; } ?>"/>
            <span id="errorsDiv_name" class="error"></span>
        </li>
        <li>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" placeholder="john_doe@example.com"  value="<?php if(!empty($data)) { echo $data['email']; } ?>" />
            <!-- <span class="form_hint">Proper format "name@something.com"</span> -->
			<span id="errorsDiv_email" class="error"></span>
        </li>
        <li>
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" placeholder="Mailing Address" value="<?php if(!empty($data)) { echo $data['address']; } ?>"/>
             <!-- <span class="form_hint">Field Required</span> -->
			<span id="errorsDiv_address" class="error"></span>
        </li>
           
            <li>
            <label for="city">City:</label>
            <input type="text" name="city" id="city" placeholder="city"  value="<?php if(!empty($data)) { echo $data['city']; } ?>"/>
             <!-- <span class="form_hint">Field Required</span> -->
			<span id="errorsDiv_city" class="error"></span>
        </li>


        <li>
            <label for="state">State:</label>
            <input type="text" name="state" id="state" placeholder="state" value="<?php if(!empty($data)) { echo $data['state']; } ?>"/>
            <!-- <span class="form_hint">Field Required</span> -->
			<span id="errorsDiv_state" class="error"></span>
        </li>

        <li>
            <label for="zip">Zip Code:</label>
            <input type="text" name="zip" id="zip" placeholder="zip" value="<?php if(!empty($data)) { echo $data['zip']; } ?>"/>
            <!-- <span class="form_hint">Field Required</span> -->
			<span id="errorsDiv_zip" class="error"></span>
        </li>
		<li>
            <label for="cphone">Day Time Phone Number :</label>
            <input type="text" name="cphone" placeholder=" Contact Number" value="<?php if(!empty($data)) { echo $data['cphone']; } ?>" />
            <!-- <span class="form_hint">Field Required</span> -->
			<span id="errorsDiv_cphone"></span>
        </li>	
		
		<li>
            <label for="invest">When are you looking to invest </label>
            <select name="invest" >
                <option value="">Please select</option>
                <option> 1 – 3 months</option>
                <option>6 months</option>
                <option> 12+ months</option>
            </select>
            <!-- <span style="padding-left:10px; color:#AAAAAA;">*Field Required</span> -->
            <span id="errorsDiv_invest"></span>
        </li>

		<li>
            <label for="unit">No Of Units  </label>

            <select id="units" name="units" >
                <option value=""  <?php if( empty($data) || $data['units'] == '') { echo 'selected = true'; } ?> >Please select</option>
                <option value="1" <?php if(!empty($data) && $data['units'] == 1) { echo ' selected = true'; } ?> >1</option>
                <option value="2" <?php if(!empty($data) && $data['units'] == 2) { echo 'selected = true'; } ?> >2</option>
                <option value="3" <?php if(!empty($data) && $data['units'] == 3) { echo 'selected = true'; } ?> >3</option>
                <option value="4" <?php if(!empty($data) && $data['units'] == 4) { echo 'selected = true'; } ?> >4</option>
                <option value="5" <?php if(!empty($data) && $data['units'] == 5) { echo 'selected = true'; } ?> >5</option>
            </select>
        <!-- <span style="padding-left:10px; color:#AAAAAA;">*Field Required</span> --> <span id="errorsDiv_units"></span>
        </li>
		
        <li>
            <label for="how_know">How did you hear about us ? </label>
            <textarea name="how_know" cols="40" rows="6" placeholder="How did you hear about us ?" ><?php if(!empty($data)) { echo $data['how_know']; } ?></textarea>
            <!-- <span class="form_hint">Field Required</span> -->
            <span id="errorsDiv_how_know" style="float:left;margin:10px;padding-left:240px;"></span>
        </li>
     
        <li>
         <label for="cap">Enter The captcha code?  </label><input type="text" name="caph" class="input" placeholder="Enter The captcha code" />
         <span disabled id="cap" style="font-family:Arial, Helvetica, sans-serif; cursor: pointer; background-color: green; padding: 8px; color: white; font-size:12px; font-weight:bold;"></span>
         <span id="error" class="reg_error"></span>
         
         <input type="hidden" name="cahp" />
         <span id="errorsDiv_caph"></span>
        </li>
    </ul>	
    <button name="submit" class="test" type="submit" id="submit">Submit</button>
    <?php echo form_close(); ?>
</div>
<style>
button.test{background: none repeat scroll 0 0 #F46523;
    border-radius: 5px;
    color: #FFFFFF;
    cursor: pointer;
    display: inline-block;
    font-family: century gothic;
    font-size: 17px;
    font-weight: bold;
    padding: 10px 50px;
    text-decoration: none;
    border:0 px;
    box-shadow: 0 1px 0 0 #F46523 inset;
}
button.test:hover{
    opacity:1.0;
}
</style>
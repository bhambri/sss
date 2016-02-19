<!--
  <div class="line-arr">&nbsp;</div>
 <div class="footer">
     <div class="footer-inner">
      
       <div class="fst">
        <h2>shop</h2>
        <ul>
        <?php 
      if( !empty( $this->categories ) )
      {
      //  echo "<pre>";
      //  print_r($this->categories);die;
      $count=1;
        foreach ($this->categories as $categories) 
        {
            if( isset( $categories['subcategory'] ) && !empty( $categories['subcategory'] ) )
            {
              foreach ($categories['subcategory'] as $subcategory) 
                {
                  if($count<=6)
                  {
      ?>          
                  
                  <li>
                    <a href="<?php echo base_url();?>store/cat_id/<?php echo $categories['id'].'/'.$subcategory->id;?>">
                      <?php echo $subcategory->name;?>
                    </a>
                  </li>
      <?php 
                  }
            $count++;
                } 
            }                         
        }  
      }
            ?>   
         
      </ul>
      </div>
      
      
       <div class="sec">
        <h2>help</h2>
       <ul>
      
      <?php 
//pr($this) ;

      ?>
      <li><a href="<?php echo $this->store_opportunity_link ? $this->store_opportunity_link : base_url().'home#' ; ?>" >Opportunities</a></li>
      <li><a href="<?php echo base_url();?>about-us">About Us</a></li>
      <li><a href="<?php echo base_url(); ?>store/product">Store</a></li>
      <li><a href="<?php echo base_url(); ?>contact">Contact us</a></li>
      <li><a href="<?php echo base_url(); ?>news">News</a></li>
      <li><a href="<?php echo base_url(); ?>warranty-returns-and-exchanges">  
Warranty and Exchanges and Returns</a></li>
      </ul>
      </div>
      
      
       <div class="thr">
        <h2>account</h2>
        <ul>
          <?php 
          $storeUserSession = $this->session->userdata('storeUserSession');
          if( isset( $storeUserSession ) && !empty( $storeUserSession ) && is_array( $storeUserSession ) )
          {
            #pr($storeUserSession) ;
      ?>
      <li><a href="<?php echo base_url(); ?>user/account">My Account</a></li>
      <li><a href="<?php echo base_url(); ?>user/logout"> Logout</a></li>

          
      <li><a href="<?php echo base_url();?>store/product">My store</a></li>
      <li><a href="<?php echo base_url();?>cart">My shopping bag</a></li>
      <?php
          }else{
            ?>
            <li><a href="<?php echo base_url(); ?>user/login">Login</a></li>
        <li><a class="inline cboxElement" href="#inline_content">Create account</a></li>
          <?php
          }
          ?>
          
      </ul>
      </div>
      
      
       <div class="fou">
        <h2>Popular</h2>
          <?php

      if(!empty($popularcat) && count($popularcat)){

          ?>
        <ul>
          <?php foreach($popularcat as $subcat){ 
            #pr($subcat);
            ?>
      <li><a href="<?php echo base_url(); ?>store/cat_id/<?php echo $subcat->id.'/'.$subcat->category_id?>"><?php echo $subcat->name ;?></a></li>
      

      <?php } ?>
      </ul>
        <?php } ?>
      </div>
    </div>



    <div class="strip">
     <div class="strip-inner">
    <div class="copy">Copyright &copy; <?php echo date('Y') ; ?> JonCar Jewelry - All Rights Reserved. <a href="http://cogniter.com/" target="_blank">Site By Cogniter</a> &nbsp; | &nbsp;  <a href="<?php echo base_url().'t_n_c' ?>" >Terms of use</a></div>
    <div class="social">
    <?php 
    if($this->fb_link!="#" && strpos($this->fb_link, 'http') === false)
    {
      $this->fb_link = "http://".$this->fb_link;
    }
    if($this->linkdin_link!="#" && strpos($this->linkdin_link, 'http') === false)
    {
      $this->linkdin_link = "http://".$this->linkdin_link;
    }
    if($this->twitter_link!="#" && strpos($this->twitter_link, 'http') === false)
    {
      $this->twitter_link = "http://".$this->twitter_link;
    }
    if($this->gplus_link!="#" && strpos($this->gplus_link, 'http') === false)
    {
      $this->gplus_link = "http://".$this->gplus_link;
    }
    if($this->youtube_link!="#" && strpos($this->youtube_link, 'http') === false)
    {
      $this->youtube_link = "http://".$this->youtube_link;
    }
    if($this->pinterest_link!="#" && strpos($this->pinterest_link, 'http') === false)
    {
      $this->pinterest_link = "http://".$this->pinterest_link;
    }
    ?>
    
    <ul class="social_icon">
                <li><a href="<?php echo $this->fb_link; ?>" class="fb"></a></li>
                <li><a href="<?php echo $this->twitter_link; ?>" class="twit"></a></li>
                <li><a href="<?php echo $this->youtube_link; ?>" class="youtube"></a></li>
                <li><a href="<?php echo $this->pinterest_link; ?>" class="pint"></a></li>
    </ul>
    
    
    
    </div>
     </div>
  </div>


 </div>
  
    <div style='display:none'>
      <div id='inline_content' style='background:#fff;' class='create-account'>
                 <h2>Choose your membership type</h2>
                  
                  <div class="register-consultant"> 
                     <h3>Register as a <?php echo $this->consultant_label ;?></h3>                  
                    <ul>                      
                     <li>Get the maximum with minimum investment</li>                                     
                     <li>Get commision on sales</li>
                     <li>Promote & earn</li> 
                    </ul>
                    
                    <div class="btn"><a href="<?php echo base_url();?>user/consultant"><input type="button" value="Sign up today" src="" /></a></div>
                    
                  </div>
                  
                  
                 <div class="register-user">     
                      <h3>Register as a Customer</h3>   
                   <ul>             
                    <li>Happy Shopping</li>                                     
                    <li>Best Deals</li>
                    <li>Best Prices</li> 
                    </ul> 
                    
                    <div class="btn"><a href="<?php echo base_url() ;?>/user/register"><input type="button" value="Sign up today" /></a></div>                    
                  </div>
 
                  
                  
      </div>
    </div>
 


    
    </div>

</body>
</html> -->
<?php 
    ?>

<div class="footer">
			<div class="footer_left">
				<ul>
					<li><a href="<?php echo base_url(); ?>home">Home</a></li>
					<li><a href="<?php echo base_url(); ?>company-profile">Company</a></li>
					<li><a href="<?php echo base_url(); ?>products-power">Products</a></li>
					<li><a href="<?php echo base_url(); ?>opportunity">Opportunity</a></li>
					<li><a href="<?php echo base_url(); ?>contact-us">Contact Us</a></li>
					<li><a href="<?php echo base_url(); ?>store/products">Shop Now</a></li>
					<li><a href="<?php echo base_url(); ?>news">News</a></li>
				</ul>
				<ul>
					<li>&copy; WorldWide Bullionaires 2015</li>
					<li>All rights reserved</li>
					<li><a href="#">Autoship Terms and Conditions</a></li>
					<li><a href="#">Privacy Policy</a></li>
				
				</ul>
			</div>
			<div class="footer_right">
				<ul>
					<?php if(!in_array(trim($this->fb_link),array("",'#'))){ ?><li><a href="<?php echo $this->fb_link; ?>" class="facebook">facebook</a></li> <?php } ?>
					<?php  if(!in_array(trim($this->twitter_link),array("",'#'))){ ?><li><a href="<?php echo $this->twitter_link; ?>" class="twitter">twitter</a></li> <?php } ?>
					<?php  if(!in_array(trim($this->pinterest_link),array("",'#'))){ ?><li><a href="<?php echo $this->pinterest_link; ?>" class="pin">pin</a></li><?php } ?>
				</ul>
			</div>
		
		</div>
		
		</div>
	
	<!-- end content -->
</div>


<!-- Home page slider -->

<?php 
$arrd = explode('/',$_SERVER['REQUEST_URI']);
#var_dump($_SERVER['REQUEST_URI']);

if((count($arrd) > 1) && (!in_array('home' ,$arrd)) && ($_SERVER['REQUEST_URI'] != '/'))
{ 
?>
  
<?php }else{ ?> 

<div id="wrap">
<img class="bgfade" src="<?php echo store_fallback_path('store/images/bg2.gif') ;?>" />
<img class="bgfade" src="<?php echo store_fallback_path('store/images/bg1.gif') ;?>" />
<img class="bgfade" src="<?php echo store_fallback_path('store/images/bg3.gif') ;?>" />
<img class="bgfade" src="<?php echo store_fallback_path('store/images/bg4.gif') ;?>" />
</div>
<!-- end home page slider -->

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(window).load(function(){
$('img.bgfade').hide();
var dg_H = $(window).height();
var dg_W = $(window).width();
$('#wrap').css({'height':dg_H,'width':dg_W});
function anim() {
    $("#wrap img.bgfade").first().appendTo('#wrap').fadeOut(3700);
    $("#wrap img").first().fadeIn(500);
    setTimeout(anim, 7000);
}
anim();})
$(window).resize(function(){window.location.href=window.location.href})</script>

<?php } ?>
<div style='display:none'>
			<div id='inline_content' style='background:#fff;' class='create-account'>
         <h2>Choose your membership type</h2>
          <div class="register-consultant"> 
             <h3>Register as a <?php echo $this->consultant_label ;?></h3>                	
          	<ul>                  		
             <li>Get the maximum with minimum investment</li>                                 		
             <li>Get commision on sales</li>
             <li>Promote &amp; earn</li> 
          	</ul>
          	
          	<div class="btn"><a href="<?php echo base_url(); ?>user/consultant"><input type="button" value="Sign up today"/></a></div>
          	
          </div>
          
          
         <div class="register-user">     
              <h3>Register as a Customer</h3>   
           <ul>            	
          	<li>Happy Shopping</li>                                 		
            <li>Best Deals</li>
            <li>Best Prices</li> 
            </ul> 
            
            <div class="btn"><a href="<?php echo base_url(); ?>user/register"><input type="button" value="Sign up today"/></a></div>                    
          </div>        
			</div>
		</div>
</body>
</html>

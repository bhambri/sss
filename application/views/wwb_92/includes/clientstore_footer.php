<?php 
#echo '<pre>';
$segsments =  $this->uri->segments ;
#print_r();
#die('test comment hereer');
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
<div class="footer">
  <div class="footer_left">
    <ul>
          <li><a href="<?php echo base_url() .  $this->storename.'/'.$segsments[2]; ?>/home">Home</a></li>
          <li><a href="<?php echo base_url() .  $this->storename.'/'.$segsments[2]; ?>/company-profile">Company</a></li>
          <li><a href="<?php echo base_url() .  $this->storename.'/'.$segsments[2]; ?>/products-power">Products</a></li>
          <li><a href="<?php echo base_url() .  $this->storename.'/'.$segsments[2]; ?>/opportunity">Opportunity</a></li>
          <li><a href="<?php echo base_url() .  $this->storename.'/'.$segsments[2]; ?>/contact-us">Contact Us</a></li>
          <li><a href="<?php echo base_url().$this->storename.'/'.$segsments[2]; ?>/store/products">Shop Now</a></li>
          <li><a href="<?php echo base_url().$this->storename.'/'.$segsments[2]; ?>/news">News</a></li>
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
//echo '<pre>';
//print_r(count($arrd));
//if((count($arrd) > 3) && (!in_array('home' ,$arrd)))
if(!((count($arrd) == 4) && (in_array('home' ,$arrd))))
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

<!-- <script type="text/javascript" src="js/jquery.min.js"></script> -->
<script type="text/javascript">
jQuery(window).load(function(){
jQuery('img.bgfade').hide();
var dg_H = jQuery(window).height();
var dg_W = jQuery(window).width();
jQuery('#wrap').css({'height':dg_H,'width':dg_W});
function anim() {
    jQuery("#wrap img.bgfade").first().appendTo('#wrap').fadeOut(3700);
    jQuery("#wrap img").first().fadeIn(500);
    setTimeout(anim, 7000);
}
anim();})
jQuery(window).resize(function(){window.location.href=window.location.href})</script>

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
            
            <div class="btn"><a href="<?php echo base_url() .  $this->storename.'/'.$segsments[2]; ?>/user/consultant"><input type="button" value="Sign up today"/></a></div>
            
          </div>
          
          
         <div class="register-user">     
              <h3>Register as a Customer</h3>   
           <ul>             
            <li>Happy Shopping</li>                                     
            <li>Best Deals</li>
            <li>Best Prices</li> 
            </ul> 
            
            <div class="btn"><a href="<?php echo base_url() .  $this->storename.'/'.$segsments[2]; ?>/user/register"><input type="button" value="Sign up today"/></a></div>                    
          </div>        
      </div>
    </div>
</body>
</html>

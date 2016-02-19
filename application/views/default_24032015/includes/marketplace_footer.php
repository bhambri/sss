<div class="footer">
     <div class="footer-inner">
      <ul>
        <li><a href="<?php echo base_url(); ?>">Home</a>|</li>
        <li><a href="<?php echo base_url(); ?>content/view_content/17">About Us</a>|</li>
        <li><a href="<?php echo base_url(); ?>content/view_content/how-it-works">How it Works</a>|</li>
        <li><a href="<?php echo base_url(); ?>faq">FAQ</a>|</li>
        <li><a href="<?php echo base_url(); ?>contactus">Contact Us</a>|</li>
        <li><a href="<?php echo base_url(); ?>t_n_c">Terms & conditions</a>|</li>
        <li class="no-sp"><a href="<?php echo base_url(); ?>client/add">Register</a>|</li>
    </ul>
    <?php 
		if($fb_link!="#" && strpos($fb_link, 'http') === false)
		{
			$fb_link = "http://".$fb_link;
		}
		if($linkdin_link!="#" && strpos($linkdin_link, 'http') === false)
		{
			$linkdin_link = "http://".$linkdin_link;
		}
		if($twitter_link!="#" && strpos($twitter_link, 'http') === false)
		{
			$twitter_link = "http://".$twitter_link;
		}
		if($gplus_link!="#" && strpos($gplus_link, 'http') === false)
		{
			$gplus_link = "http://".$gplus_link;
		}
		if($youtube_link!="#" && strpos($youtube_link, 'http') === false)
		{
			$youtube_link = "http://".$youtube_link;
		}
		if($pinterest_link!="#" && strpos($pinterest_link, 'http') === false)
		{
			$pinterest_link = "http://".$pinterest_link;
		}
    ?>
    <div class="social">
    <a target="_blank" href="<?php echo $fb_link; ?>"><img onmouseout="this.src='<?php echo layout_url('default/')?>images/fb.png'" onmouseover="this.src='<?php echo layout_url('default/')?>images/fb-hv.png'" src="<?php echo layout_url('default/')?>images/fb.png" alt=""/></a> 
    <a target="_blank" href="<?php echo $linkdin_link; ?>"><img onmouseout="this.src='<?php echo layout_url('default/')?>images/in.png'" onmouseover="this.src='<?php echo layout_url('default/')?>images/in-hv.png'" src="<?php echo layout_url('default/')?>images/in.png" alt=""/></a>  
    <a target="_blank" href="<?php echo $twitter_link; ?>"><img onmouseout="this.src='<?php echo layout_url('default/')?>images/twitter.png'" onmouseover="this.src='<?php echo layout_url('default/')?>images/twitter-hv.png'" src="<?php echo layout_url('default/')?>images/twitter.png" alt=""/></a> 
    <a target="_blank" href="<?php echo $gplus_link; ?>"><img onmouseout="this.src='<?php echo layout_url('default/')?>images/googleplus.png'" onmouseover="this.src='<?php echo layout_url('default/')?>images/googleplus-hv.png'" src="<?php echo layout_url('default/')?>images/googleplus.png" alt=""/></a> 
    <a target="_blank" href="<?php echo $youtube_link; ?>"><img onmouseout="this.src='<?php echo layout_url('default/')?>images/youtb.png'" onmouseover="this.src='<?php echo layout_url('default/')?>images/youtb-hv.png'" src="<?php echo layout_url('default/')?>images/youtb.png" alt=""/></a> 
    <a target="_blank" href="<?php echo $pinterest_link; ?>"><img onmouseout="this.src='<?php echo layout_url('default/')?>images/p.png'" onmouseover="this.src='<?php echo layout_url('default/')?>images/p-hv.png'" src="<?php echo layout_url('default/')?>images/p.png" alt=""/></a>

    </div>
    </div>
		<div class="strip">
		 <div class="strip-inner">
		<div class="copy">Copyright &copy;<?php echo date('Y') ; ?> simplesalessystems.com. All rights reserved.</div>
		<div class="site"><a href="http://cogniter.com/" target="_blank">Site by Cogniter</a></div>
		 </div>
		</div>
 </div>
    </div><!--wrapper-->
</body>
</html>

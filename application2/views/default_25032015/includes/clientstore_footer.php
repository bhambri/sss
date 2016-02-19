<?php

$segs = $this->uri->segments['1'] ;
$consultantDetail = trim($segs);
?>
 <!--footer-->
	<div class="line-arr">&nbsp;</div>
 <div class="footer">
     <div class="footer-inner">
      
       <div class="fst">
        <h2>shop</h2>
	      <ul>
			<?php 
			if( !empty( $this->categories ) )
			{
			//	echo "<pre>";
			//	print_r($this->categories);die;
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
				        	<!--li>
				        		<a href="<?php echo base_url().$this->storename.'/'.$consultantDetail ;?>/store/cat_id/<?php echo $categories['id'].'/'.$subcategory->id;?>"> 
				        			<span <?php if(strtolower($this->uri->uri_string) == strtolower($this->storename.'/store/cat_id/'.$categories['id'].'/'.$subcategory->id )){ echo ' class=menuselected '; $selCategory = $categories['name']; $selsubCategory = $subcategory->name ;} ?> > <?php echo $subcategory->name;?></span>
				        		</a>
				        	</li-->
				        	<li>
				        		<a href="<?php echo base_url().$consultantDetail ;?>/store/cat_id/<?php echo $categories['id'].'/'.$subcategory->id;?>">
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
			
			<li><a href="<?php echo $this->store_opportunity_link ? $this->store_opportunity_link : base_url().$consultantDetail.'/home#' ; ?>" target="_blank">Opportunities</a></li>
			<li><a href="<?php echo $this->store_about_us_link ? $this->store_about_us_link : base_url().$consultantDetail.'/home#' ;  ?>" target="_blank">About us</a></li>
			<li><a href="<?php echo base_url() .$consultantDetail; ?>/store/product">Store</a></li>
			<!-- <li><a href="special-offer.php">Special offer</a></li> -->
			<!-- li><a href="recently-viewed.php">Recently viewed</a></li-->
			<li><a href="<?php echo base_url() .$consultantDetail; ?>/contact">Contact us</a></li>
			<li><a href="<?php echo base_url() .$consultantDetail; ?>/news">News</a></li>
	    </ul>
      </div>
      
      
       <div class="thr">
        <h2>My account</h2>
	      <ul>
	      
			<?php 
	        $storeUserSession = $this->session->userdata('storeUserSession');
  	    	if( isset( $storeUserSession ) && !empty( $storeUserSession ) && is_array( $storeUserSession ) )
  	    	{
  	    		#pr($storeUserSession) ;
			?>
			<li><a href="<?php echo base_url() .$consultantDetail; ?>/user/account">My Account</a></li>
			<li><a href="<?php echo base_url() .$consultantDetail; ?>/user/logout"> Logout</a></li>

  	    	<!-- <li><a href="<?php echo base_url() .  $this->storename.'/'.$consultantDetail; ?>/store/product">Create wishlist</a></li> -->
			<li><a href="<?php echo base_url() .$consultantDetail; ?>/store/product">My store</a></li>
			<li><a href="<?php echo base_url() .$consultantDetail; ?>/cart">My shopping bag</a></li>
			<?php
  	    	}else{
  	    		?>
  	    		<li><a href="<?php echo base_url() .$consultantDetail; ?>/user/login">Login</a></li>
				<li><a class="inline" href="#inline_content">Create account</a></li>
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
			<li><a href="<?php echo base_url() .$consultantDetail ; ?>/store/cat_id/<?php echo $subcat->id.'/'.$subcat->category_id?>"><?php echo $subcat->name ;?></a></li>
			

			<?php } ?>
	    </ul>
	      <?php } ?>

      </div>
    </div>
<div class="payment-strip"><a href="#"><img src="<?php echo layout_url('default/store/')?>images/ico-payment.png" alt=""/></a></div>
		<div class="strip">
		
		 <div class="strip-inner">
		<div class="copy">Copyright &copy; <?php echo date('Y') ; ?> simplesalessystems.com. All rights reserved. &nbsp; | &nbsp; <!-- <a href="privacy.php">Privacy Policy</a>  &nbsp;  | --> &nbsp;  <a href="<?php echo base_url().$consultantDetail.'/t_n_c' ?>" target="_blank" >Terms of use</a></div>
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
		<a href="<?php echo $this->fb_link; ?>"><img onmouseout="this.src='<?php echo layout_url('default/store/')?>images/fb.png'" onmouseover="this.src='<?php echo layout_url('default/store/')?>images/fb-hv.png'" src="<?php echo layout_url('default/store/')?>images/fb.png" alt=""/></a> 
		
		<a href="<?php echo $this->linkdin_link; ?>"><img onmouseout="this.src='<?php echo layout_url('default/store/')?>images/in.png'" onmouseover="this.src='<?php echo layout_url('default/store/')?>images/in-hv.png'" src="<?php echo layout_url('default/store/')?>images/in.png" alt=""/></a> 
		
		<a href="<?php echo $this->twitter_link; ?>"><img onmouseout="this.src='<?php echo layout_url('default/store/')?>images/twitter.png'" onmouseover="this.src='<?php echo layout_url('default/store/')?>images/twitter-hv.png'" src="<?php echo layout_url('default/store/')?>images/twitter.png" alt=""/></a> 
		
		<a href="<?php echo $this->gplus_link; ?>"><img onmouseout="this.src='<?php echo layout_url('default/store/')?>images/googleplus.png'" onmouseover="this.src='<?php echo layout_url('default/store/')?>images/googleplus-hv.png'" src="<?php echo layout_url('default/store/')?>images/googleplus.png" alt=""/></a> 
		
		<a href="<?php echo $this->youtube_link; ?>"><img onmouseout="this.src='<?php echo layout_url('default/store/')?>images/youtb.png'" onmouseover="this.src='<?php echo layout_url('default/store/')?>images/youtb-hv.png'" src="<?php echo layout_url('default/store/')?>images/youtb.png" alt=""/></a> 
		
		<a href="<?php echo $this->pinterest_link; ?>"><img onmouseout="this.src='<?php echo layout_url('default/store/')?>images/p.png'" onmouseover="this.src='<?php echo layout_url('default/store/')?>images/p-hv.png'" src="<?php echo layout_url('default/store/')?>images/p.png" alt=""/></a></div>
		 </div>
	</div>
 </div>
 	<!-- This contains the hidden content for inline calls -->
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
                  	
                  	<div class="btn"><a href="<?php echo base_url() .$consultantDetail; ?>/user/consultant"><input type="button" value="Sign up today" src=""></a></div>
                  	
                  </div>
                  
                  
                 <div class="register-user">     
                      <h3>Register as a user</h3>   
                   <ul>            	
                  	<li>Happy Shopping</li>                                 		
                    <li>Best Deals</li>
                    <li>Best Prices</li> 
                    </ul> 
                    
                    <div class="btn"><a href="<?php echo base_url() . $consultantDetail; ?>/user/register"><input type="button" value="Sign up today"></a></div>                    
                  </div>
    
			</div>
		</div>
 
<!--footer-->
    </div><!--wrapper-->
          
<script type="text/javascript">
$(document).ready(function()
{
    
});
</script>

</body>
</html>
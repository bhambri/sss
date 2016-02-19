<!--banner-->
<div class="inner-banner">
    <div class="inner-banner-main">
   <h2>Thanks</h2>
     </div>    
     <div class="breadcrumb"><a href="<?php echo base_url().$this->uri->segments[1].'/home' ;?>">Home </a> / Thanks</div>       
</div>
<!--banner-->    
 <div class="con">
    <div class="con-inner">
        <div class="inner-txt">        
           <div class="thanks">Payment Received! Your product will be sent to you very soon <?php if( isset($_GET['tid'] ) ) { echo ' <br>Your Transaction ID: ' . $_GET['tid']; } ?></div>   
          </div> 
    </div>
</div><!--con-->

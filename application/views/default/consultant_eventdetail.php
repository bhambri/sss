<!--banner-->
<div class="banner">
  <div class="banner-main">      
  <script language="javascript">
  currentWidget = 0;
  intervalTrigger = 1;
  counter = 3;
  function changeWidget(widget){
    if(typeof(widget) != 'undefined'){
      currentWidget = widget;
    }else{
      if(intervalTrigger == 1){
        currentWidget = (currentWidget)%counter + 1;
      }else{
        return;
      }
    }
    for(var i=1;i<=counter;i++){
      if($('satopthumbactive-'+i)){
        $('satopthumbactive-'+i).style.display = 'none';
        $('satopthumb-'+i).style.display = '';
        $('satopimage-'+i).style.display = 'none';
        $('satopcontent-'+i).style.display = 'none';
      }
    }
    $('satopthumbactive-'+currentWidget).style.display = '';
    $('satopthumb-'+currentWidget).style.display = 'none';
    $('satopimage-'+currentWidget).style.display = '';
    $('satopcontent-'+currentWidget).style.display = '';
  }
  changeWidget();
  setInterval('changeWidget()',3000);
  </script> 
</div> 
</div>

<div class="discount-banner">           
  <img src="/images/discount-banner.jpg" alt="" width="100%"/></div>   
<!--banner-->
  <div class="con box-shadow">
  <div class="con-inner">
  <div class="hometxt">
  	  <h2>Event Details & Description</h2>
  </div>
  <div class="event-details">
   <div class="breadcrumb">
   <!-- Home / Constant News Details -->
    <p>
     <?php
    foreach ($breadcrumbdata as $key=>$value) { ?>  
      <a href="<?php echo $value ; ?>" style="float:left;width:auto;display:block;"> <?php echo $key ; ?> </a>
    <?php  } ?>
    </p>
   </div>
   <div style="clear:both"></div>
   <p>

  <?php if($group_data){ ?>

   <img src="<?php echo site_url().$group_data[0]->image ; ?>" />
    <?php echo $group_data[0]->description ; ?>
    <br /> <br />
    <strong>Event Code:</strong><?php echo $group_data[0]->name ; ?><br/>
    <strong>Venue:</strong>  <?php echo $group_data[0]->location ; ?> <br /><strong>Date & Timing:</strong> <?php echo date('Y-m-d',strtotime($group_data[0]->start_date)) ; ?> to <?php echo date('Y-m-d',strtotime($group_data[0]->end_date)) ; ?> </p>
      <div class="fld">
  	  <span><a href="#">Contact via Email</a></span>
  	</div>
  <?php }else{ ?>
   <p>
   Invalid Url occured !
   <br /> <br />
   </p> 
  <div class="fld">
  <!-- <span><a href="#">Contact via Email</a></span> -->
  </div> 
  <?php } ?>
  </div>
  </div>
  </div>
<!--banner-->
<?php 
$conSeg =  $this->uri->segments[2];
?>
<div class="inner-banner">
   <div class="inner-banner-main">
   <h2>Products</h2>
   </div>   
   <div class="breadcrumb">
   <!-- Home / Products -->
   <!-- <a href="<?php echo $breadcrumbdata['home'] ; ?>">  Home /</a> <a href="<?php echo $breadcrumbdata['subcatName'] ; ?>"><?php echo 'Abcdef'.$selCategory ;?> </a> -->
   <?php
    foreach($breadcrumbdata as $key=>$value){
      #pr($breadcrumb) ;
      echo  " <a href=".$value.">".$key."</a>" ;
    }
   ?>
   </div>
</div>
    <!--banner-->
<div class="con">
  <div class="con-inner">
    <div class="inner-txt">
    <div class="sorting">
      <?php
      $redirectURl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    
     if($this->session->userdata('store_view')== 'list'){
        $viewclass = 'all-products-list  product-lisiting-new';
     }else{
        $viewclass = 'all-products';
     }
      ?>
      
       <div class="grid"><a href="javascript:void(0);" onclick="setStoreView('grid','<?php echo $redirectURl ?>','<?php echo base_url() ?>');"><img src="<?php echo layout_url('default/store/')?>images/grid-view.png" alt=""/></a></div> <div class="list-grid"><a href="javascript:void(0);" onclick="setStoreView('list','<?php echo $redirectURl ?>' ,'<?php echo base_url() ?>' );" ><img src="<?php echo layout_url('default/store/')?>images/list-view.png" alt=""/></a></div>
        <div class="sort">Sort By 
          <select onchange="sortByItem(this.value,'<?php echo $redirectURl ?>','<?php echo base_url() ?>') ;">
            <option value="product_title:asc" <?php if($this->session->userdata('sort_by') == 'product_title:asc'){ echo 'selected';}?> >Title - A to Z</option>
            <option value="product_title:desc" <?php if($this->session->userdata('sort_by') == 'product_title:desc'){ echo 'selected';}?>>Title - Z to A</option>
            <option value="product_price:desc" <?php if($this->session->userdata('sort_by') == 'product_price:desc'){ echo 'selected';}?>>Price - High To Low</option>
            <option value="product_price:asc" <?php if($this->session->userdata('sort_by') == 'product_price:asc'){ echo 'selected';}?>>Price - Low To High</option>
            <option value="id" <?php if($this->session->userdata('sort_by') == 'id'){ echo 'selected';}?>>Latest Products</option>
          </select>
        </div>  
        <div class="show">Show 
          <?php # echo $this->session->userdata('per_page'); ?>
          <select onchange="perPageItem(this.value,'<?php echo $redirectURl ?>','<?php echo base_url() ?>') ;" >
            <option value="12" <?php if($this->session->userdata('per_page') == 12){ echo 'selected';}?>>12</option>
            <option value="24" <?php if($this->session->userdata('per_page') == 24){ echo 'selected';}?>>24</option>
            <option value="36" <?php if($this->session->userdata('per_page') == 36){ echo 'selected';}?>>36</option>
          </select> per page</div>
       </div>          
       <!-- <div class="all-products"> --> <!--  <div class="all-products"> //all-products-list -->
       <div class="<?php echo $viewclass ;?>">
        <?php 
          if( isset($products) && is_array( $products ) )
          {
              $i = 0;
              foreach ($products as $product)
              {

              $i++;
              if( $i == 4 ) 
              {
                  $class = 'no-mar';
                  $i = 1;
                  $i--;
             }  
             else
             {
                $class = '';
             }
            if($viewclass != 'all-products-list'){
                $settings = array('w'=>230,'h'=>430,'crop'=>true);
            }else{
               $settings = array('w'=>235,'h'=>300,'crop'=>true);
            }
            if( !empty( $product->image )  )
            {
                $image = site_url().$product->image;
                 if(@file_get_contents($image) && ($image != site_url()) ){
                    $image = image_resize( $image, $settings);
                    if(!$image){
		    $image = layout_url('default/store/') . 'images/no-images.jpg';
		    }
                }else{
                    $image = layout_url('default/store/') . 'images/no-images.jpg';
                    //$image = image_resize( $image, $settings);
                }   
            }
            else
            {
               $image = layout_url('default/store/') . 'images/no-images.jpg';
               //$image = image_resize( $image, $settings);
            }                                 
        ?>
        <div class="product <?php echo $class;?>">
           <!-- <div class="img_container"> -->

           <a href="<?php echo base_url() .  $this->storename.'/'.$conSeg; ?>/store/productDetail/<?php echo $product->id; ?>"><img src="<?php echo $image; ?>" alt="" /> </a>

           <!-- </div> -->
           <div class="con-details">  
          <span class="txt">
            <?php echo $product->product_title ; ?>
          </span> 
          <span class="price"> <!-- <img src="images/offer.png" alt=""/><s>$ddd.</s>  -->
             $<?php  echo $product->product_price ?>
          </span>
             <div class="showdiv"><span class="buy">
             <a href="javascript:void(0)" ; onclick="addtocart('<?php echo base_url() .  $this->storename.'/'.$conSeg; ?>' ,'<?php echo $product->id; ?>');">
             <img src="<?php echo layout_url('default/store/')?>images/buy.png" alt=""/><br/>Buy</a></span> 
             <span class="share"></span>
             <!-- <span class="share"><img src="<?php echo layout_url('default/store/')?>images/share.png" alt=""/><br/>
             <a href="#">Share</a></span> --> <span class="quick"><a href="<?php echo base_url() .  $this->storename.'/'.$conSeg; ?>/store/productDetail/<?php echo $product->id; ?>">
             <img src="<?php echo layout_url('default/store/')?>images/view.png" alt=""/><br/>View</a></span>
             </div>
           </div>
          </div>
          <?php 
            }}
          else
            {  
          ?>
            <div>No product found!</div>
          <?php
          }
          ?>
       </div>
      <div class="pagination">
        <?php echo ( isset($products) ) ? $pagination : ''; ?>
      </div>
    </div> 
  </div>
</div><!--con-->

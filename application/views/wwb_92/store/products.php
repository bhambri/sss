<!--banner-->
<?php #echo 'Running specific layout' ;die; ?>
     <div class="inner-banner">
           <div class="breadcrumb">
            <?php
            foreach($breadcrumbdata as $key=>$value){ ?>
              <a href="<?php echo $value ; ?>"><?php echo ucwords($key) ?></a>
           <?php }
           ?>
           </div>
    </div>
    <!--banner-->
     <div class="con">
        <div class="con-inner">
            <div class="inner-txt">
              <!-- -new code -->

<div class="category">
  <div class="cat-inner">
    <h2>Categories</h2>
    <div id="toggle-view">
    <ul><li><h5><a href="<?php echo base_url().$this->storename; ?>/store">All</a></h5></li>
    <?php  
        if( !empty( $this->categories ) )
          {
          foreach ($this->categories as $categories)
          {
          ?>
           <li>
              <h5><?php echo $categories['name'];?></h5>
              <div class="panel">
                <?php 
                  if( isset( $categories['subcategory'] ) && !empty( $categories['subcategory'] ) )
                  {
                     foreach ($categories['subcategory'] as $subcategory) 
                     {                                    
                     ?>          
                      <a href="<?php echo base_url().$this->storename; ?>/store/cat_id/<?php echo $categories['id'].'/'.$subcategory->id;?>"<?php if(strtolower($this->uri->uri_string) == strtolower($this->storename.'/store/cat_id/'.$categories['id'].'/'.$subcategory->id )){ echo ' class=menuselected '; $selCategory = $categories['name']; $selsubCategory = $subcategory->name ;} ?> > <?php echo $subcategory->name;?></a>
                  <?php 
                      }  
                  }
                ?>
               </div>
            </li>  
      <?php } 
            } ?>
	</ul>
        </div>
    </div>
</div>
              <!-- new code ends here -->
             <div class="right-side">
         
         <!-- <div class="top-img">
         <img src="<?php echo store_fallback_path('store/images/jew1.png')?>" alt=""/> 
         <a href="<?php echo site_url() ;?>uploads/joncarjewelry/CatalogALL2015.pdf"><img src="<?php echo store_fallback_path('store/images/jew2.png')?>" alt="" class="no-mar"/></a></div>
          -->
         
         <div class="page-heading">
         <h2>Jewelry</h2>
         </div>  
            
            
               <div class="sorting">
              <?php
              $redirectURl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            
             if($this->session->userdata('store_view')== 'list'){
                $viewclass = 'all-products-list product-listing-new';
             }else{
                $viewclass = 'all-products';
             }
              ?>
              
               <div class="grid"><a href="javascript:void(0);" onclick="setStoreView('grid','<?php echo $redirectURl ?>','<?php echo base_url() ?>');"><img src="<?php echo store_fallback_path('store/images/grid-view.png')?>" alt=""/></a></div> <div class="list-grid"><a href="javascript:void(0);" onclick="setStoreView('list','<?php echo $redirectURl ?>' ,'<?php echo base_url() ?>' );" ><img src="<?php echo store_fallback_path('store/images/list-view.png')?>" alt=""/></a></div>
                <div class="sort"><span>Sort By</span> 
                 <div class="sort-select">
                  <select onchange="sortByItem(this.value,'<?php echo $redirectURl ?>','<?php echo base_url() ?>') ;">
                    <option value="product_title:asc" <?php if($this->session->userdata('sort_by') == 'product_title:asc'){ echo 'selected';}?> >Title - A to Z</option>
                    <option value="product_title:desc" <?php if($this->session->userdata('sort_by') == 'product_title:desc'){ echo 'selected';}?>>Title - Z to A</option>
                    <option value="product_price:desc" <?php if($this->session->userdata('sort_by') == 'product_price:desc'){ echo 'selected';}?>>Price - High To Low</option>
                    <option value="product_price:asc" <?php if($this->session->userdata('sort_by') == 'product_price:asc'){ echo 'selected';}?>>Price - Low To High</option>
                    <option value="id" <?php if($this->session->userdata('sort_by') == 'id'){ echo 'selected';}?>>Latest Products</option>
                  </select>
                  </div>
                </div>  
                <div class="show"><span>Show</span> 
                  <?php # echo $this->session->userdata('per_page'); ?>
                  <div class="sort-select">
                  <select onchange="perPageItem(this.value,'<?php echo $redirectURl ?>','<?php echo base_url() ?>') ;" >
                    <option value="12" <?php if($this->session->userdata('per_page') == 12){ echo 'selected';}?>>12</option>
                    <option value="24" <?php if($this->session->userdata('per_page') == 24){ echo 'selected';}?>>24</option>
                    <option value="36" <?php if($this->session->userdata('per_page') == 36){ echo 'selected';}?>>36</option>
                  </select></div> <span>per page</span></div>
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
                      if( $i == 3 ) 
                      {   
                        if($viewclass != 'all-products-list'){
                          $class = 'no-mar';
                          $i = 1;
                          $i--;
                        }
                      }  
                     else
                     {
                        $class = '';
                     }
                     if($viewclass != 'all-products-list'){
                        //$settings = array('w'=>238,'h'=>258,'crop'=>true);
			$settings = array('w'=>238,'h'=>258,'crop'=>false);
                      }else{
                        //$settings = array('w'=>235,'h'=>300,'crop'=>true);
			$settings = array('w'=>235,'h'=>300,'crop'=>false);
                      }
                      $pimage = trim($product->image) ;
                      if( !empty($pimage))
                      {
                        $image = site_url().$product->image;
                        if(@file_get_contents($image) && ($image != site_url()) )
                        {
                          $image = image_resize( $image, $settings); // in case cropping failes
                			    if(!$image){
                			      $image = store_fallback_path('store/images/no-images.jpg') ;
                			    }else if($image =='image not found'){
                					  $image = store_fallback_path('store/images/no-images.jpg') ;
                				  }
				
              						// hack for cropping , need to comment on live server
              						$image = site_url().$product->image;
                        }else{
                            $image = store_fallback_path('store/images/no-images.jpg') ;
                            //$image = image_resize( $image, $settings);
                        }
			 
                      }
                      else
                      {
			 
                         $image = store_fallback_path('store/images/no-images.jpg') ;
                         //$image = image_resize( $image, $settings);
			 //echo 'Now images'.$image ; 
                      }
                    ?>
                <div class="product <?php echo $class;?>">
                   
                   <div class="img">
                    <a href="<?php echo base_url() .  $this->storename; ?>/store/productDetail/<?php echo $product->id; ?>">
                    <img src="<?php echo $image; ?>" alt="" />
                    </a>
                  
                     <div class="showdiv"><span class="buy">
                     <a href="javascript:void(0);"  onclick="addtocart('<?php echo base_url() .  $this->storename; ?>' ,'<?php echo $product->id; ?>');"><img src="<?php echo store_fallback_path('store/images/cart-ico.png')?>" alt=""/> Add To Cart </a><br/>
                     <a href="javascript:void(0);" onclick="addtowishlist('<?php echo base_url() .  $this->storename; ?>' ,'<?php echo $product->id; ?>');"><img src="<?php echo store_fallback_path('store/images/wishlist-ico1.png')?>" alt=""/> Add To Wishlist</a><br/>
                     <span class="quick"><a href="<?php echo base_url() .  $this->storename; ?>/store/productDetail/<?php echo $product->id; ?>">
                     View</a>
                     </span>
                     </span>
                     </div>
                    </div> 
                   
                    <!-- </div> -->
                   <div class="con-details">  
                  <span class="txt"> <?php echo $product->product_title ?></span> 
                  <span class="price"> $<?php  echo $product->product_price ?></span>

              <div class="showdiv"><span class="buy">
                    
<span class="cart"> <a href="javascript:void(0);"  onclick="addtocart('<?php echo base_url() .  $this->storename; ?>' ,'<?php echo $product->id; ?>');"><img src="<?php echo store_fallback_path('store/images/cart-ico.png')?>" alt=""/> Add To Cart</a></span>
                  
    <span class="wish"><a href="javascript:void(0);" onclick="addtowishlist('<?php echo base_url() .  $this->storename; ?>' ,'<?php echo $product->id; ?>');"><img src="<?php echo store_fallback_path('store/images/wishlist-ico1.png')?>" alt=""/> Add To Wishlist</a></span>            
                     <span class="quick"><a href="<?php echo base_url() .  $this->storename; ?>/store/productDetail/<?php echo $product->id; ?>">
                     View</a></span></span></div>
                   </div>
                  
                  </div>
                  <?php  } $image = "" ;} else{  ?>
                  <div class="no-product">No product found!</div>
                  <?php  } ?>
              </div>
              <?php if($pagination){ ?>
      <div class="pagination">
        <?php echo ( isset($products) ) ? $pagination : ''; ?>
      </div>
	<?php } ?>
             </div>

            </div>     
      </div>
    </div><!--con-->

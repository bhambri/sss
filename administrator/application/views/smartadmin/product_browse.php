<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> Products <span></span></h1>
	</div>
</div>
<?php if($this->session->flashdata('errors')): ?>
<div class="alert alert-danger fade in">
	<button class="close" data-dismiss="alert">x</button>
	<i class="fa-fw fa fa-times"></i>
	<strong>Error!</strong> <?php echo $this->session->flashdata('errors');?>
</div>
<?php endif; ?>
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success fade in">
	<button class="close" data-dismiss="alert">x</button>
	<i class="fa-fw fa fa-check"></i>
	<strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
</div>
<?php endif; ?>
	<?php if(count($products) < 1 ) {?>
	<p>No Products available for you at the moment</p>
	<?php } else { ?>
	<div id="products" class="row list-group">
	<?php  foreach($products as $product){?>
		<?php
		error_reporting(1);
		ini_set('display_errors', true);
		$settings = array('w'=>400,'h'=>250,'crop'=>true);
		
		$pimage = trim($product->image) ;
		
		$image_base_url = str_replace('/administrator/', '', site_url());
		if( !empty($pimage)){
			$image = $image_base_url.$product->image;
			if(@file_get_contents($image) && ($image != $image_base_url) ){
				$image = image_resize( $image, $settings); // in case cropping failes
				if(!$image){
					echo $image = store_fallback_path('store/images/no-images.jpg') ;
				}else if($image =='image not found'){
					$image = store_fallback_path('store/images/no-images.jpg') ;
				}
			}else{
				$image = store_fallback_path('store/images/no-images.jpg') ;
				$image = image_resize( $image, $settings);
			} 

		} else {
			
			$image = store_fallback_path('store/images/no-images.jpg') ;
			//$image = image_resize( $image, $settings);
		}
		?>
        <div class="item  col-xs-4 col-lg-4">
            <div class="thumbnail">
                <img class="group list-group-image" src="<?php echo $image;?>" alt="" />
                <div class="caption">
                    <h4 class="group inner list-group-item-heading">
						<a href="<?php echo base_url() ?>product/productDetail/<?php echo $product->id; ?>"><?php echo $product->product_title;?></a></h4>
                    <p class="group inner list-group-item-text">
						<?php echo htmlspecialchars_decode($product->description); ?>
					</p>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p class="lead">
                                $<?php echo $product->product_price;?></p>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <a class="btn btn-success" href="javascript:;" onClick="addtocart('<?php echo base_url(); ?>', '<?php echo $product->id; ?>')">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    
	<?php } ?>
	</div>
	<?php } ?>
	<div class="pagination">
		<?php echo ( isset($products) ) ? $pagination : ''; ?>
	</div>

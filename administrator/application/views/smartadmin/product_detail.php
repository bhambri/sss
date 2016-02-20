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

<?php if (!empty($product_detail)) { ?>

    <?php
    $full_image = site_url() . $product_detail['image'];

    if (!empty($product_detail['image']) && @file_get_contents($full_image)) {
        $full_image = site_url() . $product_detail['image'];
        $settings = array('w' => 450, 'h' => 537, 'crop' => true);
        //$image = image_resize( $full_image, $settings);
        $image = $full_image;
    } else {
        $image = store_fallback_path('store/images/no-images-zoom.png');
        $full_image = $image;
    }

    $full_image2 = site_url() . $product_detail['image2'];

    if (!empty($product_detail['image2']) && @file_get_contents($full_image2)) {
        $full_image2 = site_url() . $product_detail['image2'];
        $settings = array('w' => 450, 'h' => 537, 'crop' => true);
        //$image2 = image_resize( $full_image2, $settings);
        $image2 = $full_image2;
        $imgtwo = 1;
    } else {
        $image2 = store_fallback_path('store/images/no-images-zoom.png');
        $full_image2 = $image2;
        $imgtwo = 0;
    }

    $full_image3 = site_url() . $product_detail['image3'];

    if (!empty($product_detail['image3']) && @file_get_contents($full_image3)) {
        $full_image3 = site_url() . $product_detail['image3'];
        $settings = array('w' => 450, 'h' => 537, 'crop' => true);
        //$image3 = image_resize( $full_image3, $settings);
        $image3 = $full_image3;
        $imgthree = 1;
    } else {
        $image3 = store_fallback_path('store/images/no-images-zoom.png');
        $full_image3 = $image3;
        $imgthree = 0;
    }
    ?>
<div class="widget-body">
    <div class="panel pull-left  col-sm-9">
        <div class="col-lg-6 pull-left">
            <div class="zoom-left">
                <img id="zoom_09" src="<?php echo $image; ?>" data-zoom-image="<?php echo $full_image; ?>" width="450">

                <div id="gallery_09">
                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="<?php echo $image; ?>"
                       data-zoom-image="<?php echo $full_image; ?>"><img src="<?php echo $image; ?>" height="80"
                                                                         alt=""/></a>
                    <?php if ($imgtwo) { ?>
                        <a href="#" class="elevatezoom-gallery" data-image="<?php echo $image2; ?>"
                           data-zoom-image="<?php echo $full_image2; ?>"><img src="<?php echo $image2; ?>" height="80"
                                                                              alt=""/></a>
                    <?php } ?>
                    <?php if ($imgthree) { ?>
                        <a href="#" class="elevatezoom-gallery" data-image="<?php echo $image3; ?>"
                           data-zoom-image="<?php echo $full_image3; ?>"><img src="<?php echo $image3; ?>" height="80" alt=""/>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 pull-left">
            <h2><?php echo $product_detail['product_title']; ?></h2>

            <p>$<?php echo $product_detail['product_price']; ?></p>
            <hr/>
            <form action="<?php echo base_url() ?>cart/add" method="POST" id="formID">
                <?php $sizeArr = explode(',', $product_detail['product_size']);
                ?>
                <?php if ($sizeArr[0] != "") { ?>
                    <div class="size">
                        <div class="selectimg">
                            <select name="size">
                                <option selected="" value="">Select size</option>
                                <?php foreach ($sizeArr as $key => $value) {
                                    # code...
                                    echo '<option>' . $value . '</option>';
                                }?>

                            </select>
                        </div>
                    </div>
                <?php } ?>

                <input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
                <input type="hidden" name="id" id="product_id" value="<?php echo $product_detail['id']; ?>">
                <input type="hidden" name="qty" value="1">
                <input type="hidden" name="price" value="<?php echo $product_detail['product_price']; ?>">
                <input type="hidden" name="name"
                       value="11<?php echo htmlspecialchars($product_detail['product_title']); ?>">
                <input type="hidden" name="image" value="<?php echo $product_detail['image']; ?>">

                <input type="hidden" name="weight"
                       value="<?php echo ($product_detail['weight'] == 0) ? 500 : $product_detail['weight']; ?>">

                <div class="pull-right"><input type="submit" value="Buy Now" class="btn btn-primary"/></div>
                <!--  </form> -->
                <div class="clearfix"></div>
                <div class="row">
                    <?php

                    if (!empty($productatrr)) {
                        foreach ($productatrr as $key => $productatrrsetdetail) {
                            if (is_array($productatrrsetdetail) && !empty($productatrrsetdetail)) {
                                foreach ($productatrrsetdetail as $key => $optiondetail) {
                                    $required = '';

                                    if ($optiondetail['required']) {
                                        $required = 'validate[required]';
                                    }
                                    if ($optiondetail['field_type'] == 'text') {
                                    ?>
                                        <hr/>
                                        <fieldset>
                                            <section>
                                                <label class="label"><?php echo $optiondetail['field_label']; ?></label>
                                                <label class="input">
                                                    <input type="text" class="<?php echo $required; ?> inp"
                                                           name="options[<?php echo $optiondetail['id']; ?>]"/>
                                                </label>
                                                <div class="note">
                                                    <strong>Maxlength</strong> is automatically added via the "maxlength='#'" attribute
                                                </div>
                                            </section>
                                        </fieldset>

                                    <?php
                                    }
                                    if ($optiondetail['field_type'] == 'radio' && (count($optiondetail['option_detail']) > 0)) {
                                    ?>
                                        <hr/>
                                        <fieldset>
                                            <section>
                                                <label class=""><?php echo $optiondetail['field_label']; ?></label>
                                                <div class="inline-group">
                                                <?php foreach($optiondetail['option_detail'] as $key => $value) {
                                                ?>
                                                    <label class="radio">
                                                        <input type="radio" name="options[<?php echo $optiondetail['id']; ?>][]"  value="<?php echo $value['id']; ?>"
                                                               class="<?php echo $required; ?>"/>
                                                        <i></i><?php echo $value['option_value']; ?> <?php if ($value['option_price'] > 0) {
                                                            echo '+ $ ' . $value['option_price'];
                                                        } ?></label>

                                                <?php
                                                }
                                                ?>
                                                </div>
                                            </section>
                                        </fieldset>

                                    <?php
                                    }

                                    if ($optiondetail['field_type'] == 'checkbox' && (count($optiondetail['option_detail']) > 0)) {
                                    ?>
                                        <hr/>
                                        <fieldset>
                                            <section>
                                                <label class="label"><?php echo $optiondetail['field_label']; ?></label>
                                                <div class="row">
                                                    <div class="col col-4">
                                                    <?php
                                                    $i = 1;
                                                    foreach($optiondetail['option_detail'] as $key=>$value) {?>

                                                        <label class="checkbox">
                                                            <input type="checkbox" name="options[<?php echo $optiondetail['id']; ?>][]"
                                                                   value="<?php echo $value['id']; ?>" class="<?php echo $required; ?>" checked="checked">
                                                            <i></i><?php echo $value['option_value']; ?> <?php if ($value['option_price'] > 0) {
                                                                echo '+ $ ' . $value['option_price'];
                                                            } ?></label>
                                                    <?php
                                                    if ($i%3 == 0){
                                                    ?>
                                                    </div>
                                                    <div class="col col-4">
                                                    <?php
                                                    }
                                                    $i++;
                                                    ?>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </section>
                                        </fieldset>
                                    <?php
                                    }
                                    if ($optiondetail['field_type'] == 'selectbox' && (count($optiondetail['option_detail']) > 0)) {
                                    ?>
                                        <hr/>
                                        <fieldset>
                                            <section>
                                                <p style="display:inline;"><?php echo $optiondetail['field_label']; ?></p>
                                                <label class="select">
                                                    <select class="input-sm" name="options[<?php echo $optiondetail['id']; ?>][]">
                                                        <option value="">Choose one</option>
                                                        <?php
                                                        foreach ($optiondetail['option_detail'] as $key => $value) {
                                                            ?>
                                                            <option
                                                                value="<?php echo $value['id']; ?>"><?php echo $value['option_value']; ?> <?php if ($value['option_price'] > 0) {
                                                                    echo '+ $ ' . $value['option_price'];
                                                                } ?> </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select> <i></i>
                                                </label>
                                            </section>
                                        </fieldset>
                                        <br/>
                                    <?php
                                    }

                                }
                            }
                        }
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="panel pull-left col-sm-9">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#description" data-toggle="tab">Product Details</a></li>
                <li><a href="#size" data-toggle="tab">Size and Fit</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="description">
                    <p><?php echo html_entity_decode($product_detail['description']); ?></p>
                </div>
                <div class="tab-pane" id="size">
                    <div class="row">
                        <div class="bg-color-blueLight">
                            <span class="col-sm-2">Size</span>
                            <span class="col-sm-10"><?php echo $product_detail['product_size'] != "" ? $product_detail['product_size'] : 'N/A'; ?></span>
                        </div>
                        <div>
                            <span class="col-sm-2">Weight</span>
                            <span class="col-sm-10"><?php echo ($product_detail['weight'] > 0) ? $product_detail['weight'] . ' ' . 'gm Approx.' : 'N/A'; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else { ?>
    <p>Invalid Url</p>
<?php } ?>
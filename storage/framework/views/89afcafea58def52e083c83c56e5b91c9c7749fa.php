<div class="col-md-3 col-sm-3 col-xs-12 block_cate_right">
    <div class="block_sidebar">
      <div class="block block_product">
        <h3 class="block_title">
          <strong>Sản phẩm mới</strong>
        </h3>
        <div class="block_content">
          <div class="block-content grid-float-products  carousel-products ">
                            <div class="product-items owl-carousel nav-top-right nav-border nav-sm" data-nav="true" data-dots="false" data-margin="30" data-responsive='{"0":{"items":1},"480":{"items":1},"600":{"items":1},"992":{"items":1}}'>
                                <div class="item">
                                    <?php $i = 0;?>
                                    <?php foreach($newProductList as $product): ?>
                                    <?php $i++; ?>
                                    <div class="product-item">
                                        <div class="product-item-info">
                                            <div class="product-item-head">
                                                <a href="<?php echo e(route('product-detail', [$product->slug, $product->id])); ?>" class="product-item-photo">
                                                    <img alt="<?php echo $product->name; ?>" class="lazy" data-original="<?php echo e($product->image_url ? Helper::showImageThumb($product->image_url) : URL::asset('admin/dist/img/no-image.jpg')); ?>">
                                                </a>
                                            </div><!-- /product-item-info -->
                                            <div class="product-item-details">
                                                <h2 class="product-item-name">
                                                    <a href="<?php echo e(route('product-detail', [$product->slug, $product->id])); ?>" title="<?php echo $product->name; ?>"><?php echo $product->name; ?></a>
                                                </h2>
                                                <p class="price" style="color:#d0021b"><?php echo e($product->is_sale == 1 ? number_format($product->price_sale) : number_format($product->price)); ?>đ</p>
                                            </div><!-- /product-item-details -->
                                        </div>
                                    </div><!-- /product-item -->    
                                    <?php if($i%3 == 0 && $newProductList->count() > 3): ?>
                                    </div><div class="item">                                    
                                    <?php endif; ?>    
                                    <?php endforeach; ?>                            
                                </div><!-- /item -->
                                
                            </div>
                        </div>
        </div>
      </div><!-- /block_product -->
      <?php 
        $bannerArr = DB::table('banner')->where(['object_id' => 4, 'object_type' => 3])->orderBy('display_order', 'asc')->get();
        ?>    
        <?php if($bannerArr): ?>
        <?php foreach($bannerArr as $banner): ?>
          <div class="block block_adv">
            <div class="block_content">
              <?php if($banner->ads_url !=''): ?>
              <a href="<?php echo e($banner->ads_url); ?>" title="banner slide <?php echo e($i); ?>">
              <?php endif; ?>
                <img src="<?php echo e(Helper::showImage($banner->image_url)); ?>" alt="banner quang cao">  
              <?php if($banner->ads_url !=''): ?>
                </a>
              <?php endif; ?>  
            </div>
          </div><!-- /block_adv -->         
        <?php endforeach; ?>  
      <?php endif; ?> 
    </div>
  </div><!-- /block_cate_right -->
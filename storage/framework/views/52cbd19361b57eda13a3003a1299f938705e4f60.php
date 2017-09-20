<?php $__env->startSection('content'); ?>

<?php echo $__env->make('frontend.home.slider', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('frontend.home.about', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('frontend.home.ads', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('frontend.home.about-product', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="block block-product block-title-cm">
  <div class="container">
    <div class="block block-title">
      <h2 <?php if($isEdit): ?> class="edit" <?php endif; ?> data-text="13"><?php echo $textList[13]; ?></h2>
      <p class="desc <?php if($isEdit): ?> edit <?php endif; ?>" data-text="14">
        <?php echo $textList[14]; ?>

      </p>
    </div>
    <div class="block-content">
      <div class="product-list">
        <div class="row">
          <?php foreach($productList as $product): ?>
          <div class="col-sm-5ths col-xs-6">
            <div class="product-item">
              <div class="product-img">
               <a href="<?php echo e(route('product-detail', [$product->slug, $product->id])); ?>" title="<?php echo $product->name; ?>">
                   <img class="lazy" src="<?php echo e($product->image_url ? Helper::showImageThumb($product->image_url) : URL::asset('public/admin/dist/img/no-image.jpg')); ?>" alt="<?php echo $product->name; ?>" title="<?php echo $product->name; ?>">           
                </a>
              </div>
              <div class="product-info">
                <h2 class="title">
                   <a href="<?php echo e(route('product-detail', [$product->slug, $product->id])); ?>" title="<?php echo $product->name; ?>"><?php echo $product->name; ?></a></h2>
                <div class="product-price">
                  <span class="price-new"><?php echo e($product->is_sale == 1 ? number_format($product->price_sale) : number_format($product->price)); ?>đ</span>
                  <?php if($product->is_sale): ?>
                  <span class="price-old"><?php echo e(number_format($product->price)); ?>đ</span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div><!--col-sm-5ths-->
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div><!-- /block_big-title -->
<?php $__env->stopSection(); ?>
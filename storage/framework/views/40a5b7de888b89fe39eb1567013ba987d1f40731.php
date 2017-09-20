<?php 
$bannerArr = DB::table('banner')->where(['object_id' => 2, 'object_type' => 3])->orderBy('display_order', 'asc')->get();
?> 
<div class="block block-banner">
<?php if($bannerArr): ?>
    <?php foreach($bannerArr as $banner): ?>
      <?php if($banner->ads_url !=''): ?>
      <a href="<?php echo e($banner->ads_url); ?>" title="banner slide <?php echo e($i); ?>">
      <?php endif; ?>
      <img src="<?php echo e(Helper::showImage($banner->image_url)); ?>" alt="banner trai">  
      <?php if($banner->ads_url !=''): ?>
      </a>
      <?php endif; ?>
    <?php endforeach; ?>  
  <?php endif; ?> 
</div><!-- /block-banner -->
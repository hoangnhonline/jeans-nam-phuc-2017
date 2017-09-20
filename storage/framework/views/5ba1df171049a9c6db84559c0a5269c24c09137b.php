  
<?php echo $__env->make('frontend.partials.meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('content'); ?>
<div class="block block-breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
			<li class="active">Tags</li>
		</ul>
	</div>
</div><!-- /block-breadcrumb -->
<div class="block block-two-col container">
	<div class="row">
		<div class="col-sm-9 col-xs-12 block-col-left">
			<div class="block-page-common block-sales">
				<div class="block block-title">
					<h2>
						<i class="fa fa-cart-arrow-down"></i>
						Tags : '<?php echo e($detail->name); ?>'
					</h2>
				</div>
				<div class="block-content">
					<?php foreach( $articlesList as $articles ): ?>
					<div class="item">
						<div class="thumb">
							 <a href="<?php echo e(route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id])); ?>"><img title="<?php echo $articles->title; ?>" src="<?php echo e($articles->image_url ? Helper::showImage($articles->image_url) : URL::asset('public/assets/images/no-img.png')); ?>" alt="<?php echo $articles->title; ?>"></a>
						</div>
						<div class="des">
							<a href="<?php echo e(route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id])); ?>" title="<?php echo $articles->title; ?>"><?php echo $articles->title; ?></a>
							<p class="date-post"><i class="fa fa-calendar"></i> <?php echo e(date('d/m/Y', strtotime($articles->created_at))); ?></p>
							<p class="description">
								<?php echo $articles->description; ?>

							</p>
						</div>
					</div><!-- /item -->
					<?php endforeach; ?>					
				</div>
			</div><!-- /block-ct-news -->
			<nav class="block-pagination">
				<?php echo e($articlesList->links()); ?>

			</nav><!-- /block-pagination -->
		</div><!-- /block-col-left -->
		<div class="col-sm-3 col-xs-12 block-col-right">
			<div class="block-sidebar">
				<div class="block-module block-links-sidebar">
					<div class="block-title">
						<h2>
							<i class="fa fa-gift"></i>
							KHUYẾN MÃI HOT
						</h2>
					</div>
					<div class="block-content">
						<ul class="list">
							<li>
								<a href="sales-detail.html" title="">
									<p class="thumb"><img src="images/pro-sidebar/1.jpg" alt=""></p>
									<h3>Tiêu đề khuyến mãi được viết bởi nhóm iMarketing</h3>
								</a>
							</li>
							<li>
								<a href="sales-detail.html" title="">
									<p class="thumb"><img src="images/pro-sidebar/2.jpg" alt=""></p>
									<h3>Tiêu đề khuyến mãi được viết bởi nhóm iMarketing</h3>
								</a>
							</li>
							<li>
								<a href="sales-detail.html" title="">
									<p class="thumb"><img src="images/pro-sidebar/3.jpg" alt=""></p>
									<h3>Tiêu đề khuyến mãi được viết bởi nhóm iMarketing</h3>
								</a>
							</li>
							<li>
								<a href="sales-detail.html" title="">
									<p class="thumb"><img src="images/pro-sidebar/4.jpg" alt=""></p>
									<h3>Tiêu đề khuyến mãi được viết bởi nhóm iMarketing</h3>
								</a>
							</li>
							<li>
								<a href="sales-detail.html" title="">
									<p class="thumb"><img src="images/pro-sidebar/5.jpg" alt=""></p>
									<h3>Tiêu đề khuyến mãi được viết bởi nhóm iMarketing</h3>
								</a>
							</li>
						</ul>
					</div>
				</div><!-- /block-module -->
				<div class="block-module block-statistics-sidebar">
					<div class="block-title">
						<h2>
							<i class="fa fa-bar-chart"></i>
							THỐNG KÊ TRUY CẬP
						</h2>
					</div>
					<div class="block-content">
						<ul class="list">
							<li>
								<span class="icon"><i class="fa fa-user"></i></span>
								<span class="text">Hôm qua:</span>
								<span class="number">246</span>
							</li>
							<li>
								<span class="icon"><i class="fa fa-user"></i></span>
								<span class="text">Hôm nay:</span>
								<span class="number">246</span>
							</li>
							<li>
								<span class="icon"><i class="fa fa-user"></i></span>
								<span class="text">Trong tuần:</span>
								<span class="number">246</span>
							</li>
							<li>
								<span class="icon"><i class="fa fa-user"></i></span>
								<span class="text">Tổng truy cập:</span>
								<span class="number">246</span>
							</li>
						</ul>
					</div>
				</div><!-- /block-module -->
			</div>
		</div><!-- /block-col-right -->
	</div>
</div><!-- /block_big-title -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
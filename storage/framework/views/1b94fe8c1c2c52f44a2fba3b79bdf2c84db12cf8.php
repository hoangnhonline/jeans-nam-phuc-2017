<?php echo $__env->make('frontend.partials.meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('content'); ?>
<div class="block block-breadcrumb">
<div class="container">
    <ul class="breadcrumb">
        <li><a href="<?php echo route('home'); ?>">Trang chủ</a></li>
        <li><a href="<?php echo route('news-list', $cateDetail->slug); ?>"><?php echo $cateDetail->name; ?></a></li>        
        <li class="active"><?php echo $detail->title; ?></li>
    </ul>
</div>
</div><!-- /block-breadcrumb -->
<div class="block block-two-col container">
<div class="row">
    <div class="col-sm-9 col-xs-12 block-col-left">
        <div class="block block-page-common block-dt-sales">
            <div class="block block-title">
                <h2>
                    <i class="fa fa-cart-arrow-down"></i>
                    <?php echo $detail->title; ?>

                </h2>
            </div>
            <div class="block-content">
                <div class="block block-aritcle">
                    <?php echo $detail->content; ?>

                </div>
                <div class="block block-share">
                    Share
                </div><!-- /block-share -->
                <?php if($tagSelected->count() > 0): ?>
                <div class="block-tags">
                    <ul>
                        <li class="tags-first">Tags:</li>
                        <?php $i = 0; ?>
                        <?php foreach($tagSelected as $tag): ?>
                        <?php $i++; ?>
                        <li class="tags-link"><a href="<?php echo e(route('tag', $tag->slug)); ?>" title="<?php echo $tag->name; ?>"><?php echo $tag->name; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div><!-- /block-tags -->
                <?php endif; ?>                
            </div>
        </div><!-- /block-ct-news -->
        <div class="block-page-common block-aritcle-related">
            <div class="block block-title">
                <h2>
                    <i class="fa fa-cart-arrow-down"></i>
                    TIN LIÊN QUAN
                </h2>
            </div>
            <div class="block-content">
                <ul class="list">
                    <?php foreach( $otherArr as $articles): ?>
                    <li><a href="<?php echo e(route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id])); ?>" title="<?php echo $articles->title; ?>" ><?php echo $articles->title; ?></a></li>
                    <?php endforeach; ?>   
                </ul>
            </div>
        </div><!-- /block-ct-news -->
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
                            <a href="#" title="">
                                <p class="thumb"><img src="images/pro-sidebar/1.jpg" alt=""></p>
                                <h3>Tiêu đề khuyến mãi được viết bởi nhóm iMarketing</h3>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="">
                                <p class="thumb"><img src="images/pro-sidebar/2.jpg" alt=""></p>
                                <h3>Tiêu đề khuyến mãi được viết bởi nhóm iMarketing</h3>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="">
                                <p class="thumb"><img src="images/pro-sidebar/3.jpg" alt=""></p>
                                <h3>Tiêu đề khuyến mãi được viết bởi nhóm iMarketing</h3>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="">
                                <p class="thumb"><img src="images/pro-sidebar/4.jpg" alt=""></p>
                                <h3>Tiêu đề khuyến mãi được viết bởi nhóm iMarketing</h3>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="">
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
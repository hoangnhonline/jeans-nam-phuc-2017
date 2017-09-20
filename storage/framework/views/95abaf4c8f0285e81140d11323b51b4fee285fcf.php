<!DOCTYPE html>
<!--[if lt IE 7 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie9 lte9"><![endif]-->
<!--[if IE 10 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie10 lte10"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="vn">
<head>
	<title><?php echo $__env->yieldContent('title'); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="content-language" content="vi"/>
    <meta name="description" content="<?php echo $__env->yieldContent('site_description'); ?>"/>
    <meta name="keywords" content="<?php echo $__env->yieldContent('site_keywords'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
    <meta name="google-site-verification" content="IFz-d9V8jZLB1iDG8BfKsKwhPB-FkpsacHLqk5Mpyzk" />
    <meta name="wot-verification" content="b5ae556432dab929c4bb"/>
    <meta property="article:author" content="https://www.facebook.com/quanjeansnamphuc"/>
    <link rel="shortcut icon" href="<?php echo $__env->yieldContent('favicon'); ?>" type="image/x-icon"/>
    <link rel="canonical" href="<?php echo e(url()->current()); ?>"/>        
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $__env->yieldContent('title'); ?>" />
    <meta property="og:description" content="<?php echo $__env->yieldContent('site_description'); ?>" />
    <meta property="og:url" content="<?php echo e(url()->current()); ?>" />
    <meta property="og:site_name" content="quanjeansnamphuc" />
    <?php $socialImage = isset($socialImage) ? $socialImage : $settingArr['banner']; ?>
    <meta property="og:image" content="<?php echo e(Helper::showImage($socialImage)); ?>" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="<?php echo $__env->yieldContent('site_description'); ?>" />
    <meta name="twitter:title" content="<?php echo $__env->yieldContent('title'); ?>" />     
    <meta name="twitter:image" content="<?php echo e(Helper::showImage($socialImage)); ?>" />
	<link rel="icon" href="<?php echo e(URL::asset('assets/images/favicon.ico')); ?>" type="image/x-icon">

	<!-- ===== Style CSS ===== -->
	<link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('public/assets/css/style.css')); ?>">
	<!-- ===== Responsive CSS ===== -->
	<link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('public/assets/css/responsive.css')); ?>">

  	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<link href='<?php echo e(URL::asset('public/assets/css/animations-ie-fix.css')); ?>' rel='stylesheet'>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10&appId=567408173358902";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>

	<?php echo $__env->make('frontend.partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	<div class="wrapper">	
		
		

		<?php echo $__env->yieldContent('content'); ?>
		

	</div><!-- /wrapper-->

	<?php echo $__env->make('frontend.partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	

	<a id="return-to-top" class="td-scroll-up" href="javascript:void(0)">
  		<i class="fa fa-angle-up" aria-hidden="true"></i>
	</a><!-- return to top -->
	<div id="editContentModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Cập nhật nội dung</h4>
	      </div>
	      <form method="POST" action="<?php echo e(route('save-content')); ?>">
	      <?php echo e(csrf_field()); ?>

	      <input type="hidden" name="id" id="txtId" value="">
	      <div class="modal-body">
	        <textarea rows="5" class="form-control" name="content" id="txtContent"></textarea>
	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary" id="btnSaveContent">Save</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	      </form>
	    </div>

	  </div>
	</div>
	<!-- Modal Cart -->
	<div class="modal fade" id="Cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i class="fa fa-times-circle"></i>
				</button>
				<div class="shopcart-ct">
					<div class="modal-body">
						<form action="#" method="POST" id="frm_order_items">
							<div class="table cart-tbl">
								<div class="table-row thead">
									<div class="table-cell product-col t-c">Sản phẩm</div>
									<div class="table-cell numb-col t-c">Số lượng</div>
									<div class="table-cell total-col t-c">Thành tiền</div>
								</div><!-- table-row thead -->
								<div class="tr-wrap">
									<div class="table-row clearfix">
										<div class="table-cell product-col">
											<figure class="img-prod">
												<img alt="Tên sản phẩm quần jeans chất lượng cao được thêm vào giỏ hàng" src="<?php echo e(URL::asset('public/assets/images/cart/1.jpg')); ?>">
											</figure>
											<a href="#" target="_blank" title="Tên sản phẩm quần jeans chất lượng cao được thêm vào giỏ hàng">Tên sản phẩm quần jeans chất lượng cao được thêm vào giỏ hàng</a>
											<p class="p-color">
												<span>Màu sắc sản phẩm:</span>
												<span>Đen</span>
											</p>
											<p class="p-size">
												<span>Size sản phẩm:</span>
												<span>39</span>
												<span>|</span>
												<a href="#" title="Xóa sản phẩm">Xóa</a>
											</p>
										</div>
										<div class="table-cell numb-col t-c">
											<select name="" size="1" class="change_quantity">
												<option value="0">0</option>
												<option value="1" selected="">1</option>
												<option value="2">2</option>
											</select>
										</div>
										<div class="table-cell total-col t-r">355.000đ</div><!-- /table-cell total-col t-r -->
									</div>
									<div class="table-row clearfix">
										<div class="table-cell product-col">
											<figure class="img-prod">
												<img alt="Tên sản phẩm quần jeans chất lượng cao được thêm vào giỏ hàng" src="<?php echo e(URL::asset('public/assets/images/cart/1.jpg')); ?>">
											</figure>
											<a href="#" target="_blank" title="Tên sản phẩm quần jeans chất lượng cao được thêm vào giỏ hàng">Tên sản phẩm quần jeans chất lượng cao được thêm vào giỏ hàng</a>
											<p class="p-color">
												<span>Màu sắc sản phẩm:</span>
												<span>Đen</span>
											</p>
											<p class="p-size">
												<span>Size sản phẩm:</span>
												<span>39</span>
												<span>|</span>
												<a href="#" title="Xóa sản phẩm">Xóa</a>
											</p>
										</div>
										<div class="table-cell numb-col t-c">
											<select name="" size="1" class="change_quantity">
												<option value="0">0</option>
												<option value="1" selected="">1</option>
												<option value="2">2</option>
											</select>
										</div>
										<div class="table-cell total-col t-r">355.000đ</div><!-- /table-cell total-col t-r -->
									</div>
								</div><!-- tr-wrap -->
							</div><!-- table cart-tbl -->
							<div class="block-btn">
								<a href="#" title="Xóa tất cả" class="btn btn-default">Xóa tất cả <i class="fa fa-trash-o"></i></a>
								<a href="cart.html" title="Xóa tất cả" class="btn btn-danger">Thanh toán <i class="fa fa-angle-right"></i></a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- ===== JS ===== -->
	<script src="<?php echo e(URL::asset('public/assets/js/jquery.min.js')); ?>"></script>
	<!-- ===== JS Bootstrap ===== -->
	<script src="<?php echo e(URL::asset('public/assets/lib/bootstrap/bootstrap.min.js')); ?>"></script>
	<!-- carousel -->
	<script src="<?php echo e(URL::asset('public/assets/lib/carousel/owl.carousel.min.js')); ?>"></script>
	<!-- sticky -->
    <script src="<?php echo e(URL::asset('public/assets/lib/sticky/jquery.sticky.js')); ?>"></script>
    <!-- Js Common -->
	<script src="<?php echo e(URL::asset('public/assets/js/common.js')); ?>"></script>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59b215c2a2658a8a"></script> 	
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<?php echo $__env->yieldContent('js'); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$.ajaxSetup({
			      headers: {
			          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			      }
			  });

			$('.edit').click(function(){
				$('#txtId').val($(this).data('text'));
				$('#txtContent').val($(this).html());
				$('#editContentModal').modal('show');
			});
			$('#btnSaveContent').click(function(){
				$.ajax({
					url : '<?php echo e(route('save-content')); ?>',
					type : "POST",
					data : {
						id : $('#txtId').val(),
						content : $('#txtContent').val()
					},
					success:  function(){
						window.location.reload();
					}

				});
			});
		});
	</script>
	
</body>
</html>
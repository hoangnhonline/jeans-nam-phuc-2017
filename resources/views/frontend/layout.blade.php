<!DOCTYPE html>
<html lang="vi">
<head>
	<title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="robots" content="index,follow"/>
    <meta http-equiv="content-language" content="en"/>
    <meta name="description" content="@yield('site_description')"/>
    <meta name="keywords" content="@yield('site_keywords')"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
    <link rel="shortcut icon" href="@yield('favicon')" type="image/x-icon"/>
    <link rel="canonical" href="{{ url()->current() }}"/>        
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('site_description')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="Nam Phúc" />
    <?php $socialImage = isset($socialImage) ? $socialImage : $settingArr['banner']; ?>
    <meta property="og:image" content="{{ Helper::showImage($socialImage) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="@yield('site_description')" />
    <meta name="twitter:title" content="@yield('title')" />        
    <meta name="twitter:image" content="{{ Helper::showImage($socialImage) }}" />
	<meta name="robots" content="noindex,nofollow" />
	<!-- <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}" type="image/x-icon">
	<link rel="icon" href="{{ URL::asset('assets/images/favicon.ico') }}" type="image/x-icon"> -->
	<!-- ===== Style CSS ===== -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">
	<!-- ===== Responsive CSS ===== -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/responsive.css') }}">

	<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic&amp;subset=latin,vietnamese" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,800italic,400,700,800,300&amp;subset=latin,vietnamese" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700&amp;amp;subset=latin,vietnamese" rel="stylesheet" type="text/css">


	<!-- ===== Responsive CSS ===== -->
  	<!-- <link href="{{ URL::asset('assets/responsive.css') }}" rel="stylesheet"> -->

  	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<link href='{{ URL::asset('assets/animations-ie-fix.css') }}' rel='stylesheet'>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body {!! $routeName == 'payment' ? "class=pre_checkout" : '' !!}>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<div class="wrapper">

		<header class="header-bar">
			<div class="container">
				<div class="row"></div>
			</div>
		</header><!-- /header -->

		<main class="main">
			<div class="container">
				@include('frontend.partials.header')

				@yield('content')
			</div>
		</main><!-- /main -->

		<footer class="footer">
			<div class="footer_top">
				<div class="container">
					<ul class="row block_bottom_menu">
	                    <li><a href="{{ route('home') }}" title="Trang chủ">Trang chủ</a></li>	                  	                
	                    <li><a href="{{ route('parent-cate', 'chinh-sach-bao-hanh') }}" title="Chính sách bảo hành">Chính sách bảo hành</a></li>
	                    <li><a href="{{ route('parent-cate', 'gioi-thieu') }}" title="Giới thiệu">Giới thiệu</a></li>
	                    <li><a href="{{ route('contact') }}" title="Liên hệ">Liên hệ</a></li>
	                    <li><a href="{{ route('parent-cate', 'huong-dan-dat-hang') }}" title="Hướng dẫn đặt hàng">Hướng dẫn đặt hàng</a></li>	            
	                    <li><a href="{{ route('parent-cate', 'chinh-sach-bao-mat') }}" title="Chính sách bảo mật">Chính sách bảo mật</a></li>
					</ul><!-- /block_bottom_menu -->
				</div>
			</div><!-- /footer_top -->
			<div class="footer_bottom">
				<div class="container">
					<div class="row">
						<div class="col-md-8 col-sm-12 col-xs-12 block_copy">
							<a href="{!! route('home') !!}" class="logo"><img src="{{ URL::asset('assets/images/logo_white.png') }}" alt="Logo Ân Nam Mobile"></a>
							<div class="copyright">
                                <p>Cửa hàng điện thoại Ân Nam</p>
                                <p>Đ/C : 683/1B An Dương Vương, P.Bình Trị Đông, Q.Bình Tân, Tp.HCM</p>
                                <p>Email: contact@annam.vn</p>                               
                                <p>Hotline: 0904500057 / 0968678767</p>
                                <p>Copyrights © 2017 Nam Phúc. All Rights Reserved</p>
                            </div>
						</div><!-- /block_copy -->
						<div class="col-md-2 col-sm-3 col-xs-4 block_pay">
							<div class="block_payment"> 
                                <p>CHẤP NHẬN THANH TOÁN</p>
                            	<i class="fa fa-cc-visa"></i>
                            	<i class="fa fa-cc-mastercard"></i>
                            </div>
						</div><!-- /block_pay -->
						<div class="col-md-2 col-sm-3 col-xs-4 block_indus">
							<a href="http://online.gov.vn/CustomWebsiteDisplay.aspx?DocId=5895" target="_blank" class="block_industry">
                            	<img src="{{ URL::asset('assets/images/logo-bocongthuong.png') }}" alt="TMĐT">
                            </a>
						</div>
					</div>
				</div>
			</div><!-- /footer_bottom -->
		</footer><!-- /footer -->

		<a id="return-to-top" class="td-scroll-up" href="javascript:void(0)">
      		<i class="fa fa-angle-up" aria-hidden="true"></i>
    	</a><!-- Return To Top -->

    	<!-- Modal -->
		<div class="modal fade" id="scart_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content" id="short-cart-content">
				
				</div>
			</div>
		</div>
	</div><!-- /wrapper -->
	
	<input type="hidden" id="route-register-customer-ajax" value="{{ route('register-customer-ajax') }}">
	<input type="hidden" id="route-register-newsletter" value="{{ route('register.newsletter') }}">
	<input type="hidden" id="route-add-to-cart" value="{{ route('add-product') }}" />
	<input type="hidden" id="route-payment" value="{{ route('payment') }}" />
	<input type="hidden" id="route-short-cart" value="{{ route('short-cart') }}" />
	<input type="hidden" id="route-update-product" value="{{ route('update-product') }}" />
	<!-- ===== JS ===== -->
	<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
	<!-- ===== JS Bootstrap ===== -->
	<script src="{{ URL::asset('assets/lib/bootstrap/bootstrap.min.js') }}"></script>	<!-- ===== Plugins ===== -->
	
	<!-- carousel -->
	<script src="{{ URL::asset('assets/lib/carousel/owl.carousel.min.js') }}"></script>
	<!-- sticky -->
    <script src="{{ URL::asset('assets/lib/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/js/lazy.js') }}"></script>	
   	@if($routeName == 'home')
    <script src="{{ URL::asset('assets/js/plugins.min.js') }}"></script>
    <script src="{{ URL::asset('assets/lib/slick/slick.min.js') }}"></script>
    @endif
    <!-- Select2 --> 
    @if($routeName == 'product-detail')
	<script src="{{ URL::asset('assets/lib/bxslider/bxslider.min.js') }}"></script>
	<script src="{{ URL::asset('assets/lib/lightbox/js/lightbox.js') }}"></script>
	
	@endif
	<script src="{{ URL::asset('assets/lib/sticky/jquery.sticky.js') }}"></script>
    <!-- Slick -->    
    <script src="{{ URL::asset('assets/js/common.js') }}"></script>
    @if($routeName == 'home')
	<script src="{{ URL::asset('assets/js/home.js') }}"></script>	
	@endif
	<script src="{{ URL::asset('assets/js/general.js') }}"></script>	
	@if($routeName != 'product-detail')
	<script src="{{ URL::asset('assets/lib/select2/js/select2.min.js') }}"></script>	
	@endif	
	@yield('js')
</body>
</html>
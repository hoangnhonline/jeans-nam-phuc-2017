<div class="block block_header_wrap">
	<header class="header-des">
		<div class="block block_header_top row">
			<div class="block_logo col-md-3 col-sm-3">
				<a href="{!! route('home') !!}" title="">
					<img src="{!! Helper::showImage($settingArr['logo']) !!}" alt="Logo Ân Nam mobile">
				</a>
			</div><!-- /block_logo -->
			<div class="block_search col-md-5 col-sm-5">
				<div class="block_search_inner">
					<p class="block_call_support">HOTLINE<a href="tel:+0904500057">0904500057 / 0968678767</a></p>
					<form name="frm_search" action="{{ route('search') }}" method="GET" class="frm-search">
						<div class="control clearfix">
							<button type="submit">
								<i class="fa fa-search"></i>
							</button>
							<input type="text" id="txtSearch" name="keyword" value="{!! isset($tu_khoa) ? $tu_khoa : "" !!}"  placeholder="Bạn cần tìm sản phẩm gì ?" autocomplete="off">
							<div id="block_suggestions"></div>
						</div>
					</form>
					<a href="javascript:;" class="cart-link">
						<i class="fa fa-shopping-cart"></i>Giỏ hàng<span class="order_total_quantity">{!! Session::get('products') ? array_sum(Session::get('products')) : 0 !!}</span>						
					</a>					
				</div>				
			</div><!-- /block_search -->
			<div class="block_face col-md-4 col-sm-4">
				<div class="block_face_inner">
					<div class="fb-page" data-href="https://www.facebook.com/%C3%82n-Nam-Mobile-451564998511224/" data-width="360" data-height="72" data-small-header="true" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="false" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/%C3%82n-Nam-Mobile-451564998511224/"><a href="https://www.facebook.com/%C3%82n-Nam-Mobile-451564998511224/">Facebook</a></blockquote></div></div>
				</div>
			</div><!-- /block_face -->
		</div><!-- /block_header_top -->
		<nav id="mainNav" class="navbar navbar-default navbar-custom fixed">
        	<!-- Brand and toggle get grouped for better mobile display -->
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	              <span class="sr-only">Toggle navigation</span><i class="fa fa-bars"></i>
	            </button><!-- /navbar-toggle -->
	            <div class="block_cart_mobile">
	            	<a href="javascript:;" class="cart-link"><span class="order_total_quantity">{!! Session::get('products') ? array_sum(Session::get('products')) : 0 !!}</span></a>
	            </div><!-- /block_cart_mobile -->
	            <div class="block_logo_mobile">
					<a href="{!! route('home') !!}"><img src="{!! URL::asset('assets/images/logo_white.png') !!}" alt="Logo Ân Nam Mobile"></a>
				</div><!-- /block_logo_mobile -->
				<div class="block_call_mobile">
					<a href="tel:+84904500057" class="mb-phone"><i class="fa fa-phone"></i></a>
				</div><!-- /block_call_mibile -->
				<div class="block_search_mobile">
					<div class="block_content">
						<i class="fa fa-search fa_search_show"></i>
						<div class="block_search_inner">
							<form name="frm_search" action="{{ route('search') }}" method="GET" class="frm-search">
								<div class="control clearfix">
									<button type="submit"><i class="fa fa-search"></i></button>
									<input type="text" id="txtSearch" name="keyword" value="{!! isset($tu_khoa) ? $tu_khoa : "" !!}" placeholder="Bạn cần tìm sản phẩm gì ?" autocomplete="off">
								</div>
							</form>
						</div>
					</div>
				</div><!-- /block_search_mobile -->
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse menu" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-left">
					<li class="level0 menu-icon" >
						<a href="{!! route('home') !!}" title="Trang Chủ">
							<i class="fa fa-home"></i>
							Trang Chủ
						</a>
					</li><!-- level0 -->
					<li class="level0  {{ $routeName == 'home' || $routeName == 'old-cate'  ? 'active' : '' }} ">
						<a href="{!! route('home') !!}" title="Máy cũ giá rẻ">
							<i class="fa fa-history"> </i>
							Máy cũ giá rẻ
						</a>
					</li><!-- level0 -->
					@foreach($loaiSpList as $loaiSp)					
					<li class="level0 parent {{ $routeName != 'search' && isset($loaiDetail) && $loaiDetail->id == $loaiSp->id && !isset($is_old) ? "active" : "" }}">
						<a href="{{ route('parent-cate', $loaiSp->slug) }}" title="{!! $loaiSp->name !!}">
							<i class="fa fa-mobile"> </i>
							{!! $loaiSp->name !!}
						</a>
						<ul class="level0 submenu">
							@if($cateArrByLoai[$loaiSp->id]->count() > 0)
							@foreach($cateArrByLoai[$loaiSp->id] as $cate)
							<li class="level1">
								<a href="{!! route('child-cate', [ $loaiSp->slug, $cate->slug ])!!}" title="{!! $cate->name !!}">
								{!! $cate->name !!}
								<span class="number-prod">{{ $cate->productNew->count() }}</span>
								</a>
							</li>							
							@endforeach
							@endif
						</ul>
					</li><!-- level0 -->			
					@endforeach		
					<li class="level0 {{ $routeName == 'news-list' || $routeName == 'news-detail'  ? 'active' : '' }}">
						<a href="{{ route('news-list') }}" title="TIN TỨC">
							<i class="fa fa-rss-square"></i>
							TIN TỨC
						</a>
					</li><!-- level0 -->
					<li class="level0 menu_cart">
						<a href="javascript:;" class="cart-link">
							<i class="fa fa-shopping-cart"></i>Giỏ hàng<span class="order_total_quantity">{!! Session::get('products') ? array_sum(Session::get('products')) : 0 !!}</span>
						</a>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
    	</nav><!-- mainNav -->
	</header><!-- header -->
</div><!-- /block_header_wrap -->
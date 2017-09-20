@extends('frontend.layout')  
@include('frontend.partials.meta')
@section('content')
<div class="block block-breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="#">Trang chủ</a></li>
			<li class="active">Khuyến mãi</li>
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
						KHUYẾN MÃI
					</h2>
				</div>
				<div class="block-content">
					@foreach( $articlesList as $articles )
					<div class="item">
						<div class="thumb">
							 <a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}"><img title="{!! $articles->title !!}" src="{{ $articles->image_url ? Helper::showImage($articles->image_url) : URL::asset('public/assets/images/no-img.png') }}" alt="{!! $articles->title !!}"></a>
						</div>
						<div class="des">
							<a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}" title="{!! $articles->title !!}">{!! $articles->title !!}</a>
							<p class="date-post"><i class="fa fa-calendar"></i> {{ date('d/m/Y', strtotime($articles->created_at)) }}</p>
							<p class="description">
								{!! $articles->description !!}
							</p>
						</div>
					</div><!-- /item -->
					@endforeach					
				</div>
			</div><!-- /block-ct-news -->
			<nav class="block-pagination">
				{{ $articlesList->links() }}
			</nav><!-- /block-pagination -->
		</div><!-- /block-col-left -->
		<div class="col-sm-3 col-xs-12 block-col-right">
			@include('frontend.partials.km-hot')
		</div><!-- /block-col-right -->
	</div>
</div><!-- /block_big-title -->
@stop
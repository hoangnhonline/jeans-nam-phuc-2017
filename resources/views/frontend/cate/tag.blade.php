@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="block block-breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}">Trang chủ</a></li>           
            <li class="active">Tags</li>
        </ul>
    </div>
</div><!-- /block-breadcrumb -->
<div class="block block-two-col container">
    <div class="row">
        <div class="col-sm-9 col-xs-12 block-col-left">
            <div class="block-page-common clearfix">
                <div class="block block-title">
                    <h2>
                        <i class="fa fa-product-hunt"></i>
                        Tags : '{{ $detail->name }}'
                    </h2>
                </div>
                <div class="block-content">
                    <div class="product-list">
                        <div class="row">
                          @foreach($productList as $product)
                            <div class="col-sm-3 col-xs-6">
                                <div class="product-item">
                                    <div class="product-img">
                                       <a href="{{ route('product-detail', [$product->slug, $product->id]) }}" title="{!! $product->name !!}">
                                           <img class="lazy" src="{{ $product->image_url ? Helper::showImageThumb($product->image_url) : URL::asset('public/admin/dist/img/no-image.jpg') }}" alt="{!! $product->name !!}" title="{!! $product->name !!}">           
                                        </a>
                                      </div>
                                    <div class="product-info">
                                         <h2 class="title">
                                   <a href="{{ route('product-detail', [$product->slug]) }}" title="{!! $product->name !!}">{!! $product->name !!}</a></h2>
                                        <div class="product-price">
                                            <span class="price-new">{{ $product->is_sale == 1 ? number_format($product->price_sale) : number_format($product->price) }}đ</span>
                                  @if($product->is_sale)
                                  <span class="price-old">{{ number_format($product->price) }}đ</span>
                                  @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                           @endforeach
                        </div>
                        <nav class="block-pagination">
                            {{ $productList->links() }}
                        </nav><!-- /block-pagination -->
                    </div>
                </div>
            </div><!-- /block-ct-news -->
        </div><!-- /block-col-left -->
        <div class="col-sm-3 col-xs-12 block-col-right">
            @include('frontend.partials.km-hot')
        </div><!-- /block-col-right -->
    </div>
</div><!-- /block_big-title -->
@stop
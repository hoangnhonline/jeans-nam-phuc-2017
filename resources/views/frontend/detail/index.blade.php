@extends('frontend.layout')
@include('frontend.partials.meta')
@section('header')
  @include('frontend.partials.header')
  
@endsection

@section('content')
<div class="block block-breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}" title="Trở về trang chủ">Trang chủ</a></li>
            <li><a href="{{ route('cate-parent', $loaiDetail->slug) }}" title="{!! $loaiDetail->name !!}">{!! $loaiDetail->name !!} </a></li>
            <li><a href="{{ route('cate', [$loaiDetail->slug, $cateDetail->slug]) }}" title="{!! $cateDetail->name !!}">{!! $cateDetail->name !!} </a></li>
            <li class="active">{!! $detail->name !!}</li>
        </ul>
    </div>
</div><!-- /block-breadcrumb -->
<div class="block block-two-col container">
    <div class="row">
        <div class="col-sm-9 col-xs-12 block-col-left">
            <div class="block-title-commom block-detail">
                <div class="block-content">
                    <div class="block row">
                        <div class="col-sm-5">
                            <div class="block block-slide-detail">
                                <!-- Place somewhere in the <body> of your page -->
                                <div id="slider" class="flexslider">
                                    <ul class="slides slides-large">
                                        @foreach( $hinhArr as $hinh )                                        
                                            <li><img src="{{ Helper::showImage($hinh['image_url']) }}" alt=" hinh anh {!! $detail->name !!}" /></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div id="carousel" class="flexslider">
                                    <ul class="slides">
                                        @foreach( $hinhArr as $hinh )                                        
                                            <li><img src="{{ Helper::showImageThumb($hinh['image_url']) }}" alt=" hinh anh {!! $detail->name !!}" /></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div><!-- /block-slide-detail -->
                        </div>
                        <div class="col-sm-7">
                            <div class="block-page-common clearfix">
                                <div class="block block-title">
                                    <h2>
                                        <i class="fa fa-shopping-cart"></i>
                                        {!! $detail->name !!}
                                    </h2>
                                </div>
                                <div class="block-content">
                                    <div class="block block-product-options clearfix">
                                        <div class="bl-modul-cm bl-price">
                                            <p class="title">Giá sản phẩm:</p>
                                            <p class="des">{!! $detail->is_sale == 1 ? number_format($detail->price_sale ) : number_format($detail->price)  !!}₫</p>
                                        </div>
                                        <div class="bl-modul-cm bl-color">
                                            <p class="title">Màu sắc sản phẩm:</p>
                                            <div class="des">
                                                <ul>
                                                    <li class="out-of-stock">
                                                        <img src="images/color/000.jpg" alt="">
                                                    </li>
                                                    <li>
                                                        <img src="images/color/3e8ebb.jpg" alt="">
                                                    </li>
                                                    <li class="active">
                                                        <img src="images/color/fff.jpg" alt="">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="bl-modul-cm bl-size">
                                            <p class="title">Size sản phẩm:</p>
                                            <div class="des">
                                                <ul>
                                                    <li class="active">27</li>
                                                    <li>28</li>
                                                    <li>29</li>
                                                    <li class="out-of-stock">30</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="bl-modul bl-show-option">
                                            <span class="title">Vòng eo sản phẩm:</span>
                                            <div class="des">
                                                <b>56cm</b>
                                                <b>56cm</b>
                                            </div>
                                        </div>
                                        @if($tagSelected->count() > 0)
                                        <div class="bl-modul bl-show-option">
                                            <span class="title">Phong cách sản phẩm:</span>
                                            <div class="des">
                                               @if($tagSelected->count() > 0)
                                                
                                                        <?php $i = 0; ?>
                                                        @foreach($tagSelected as $tag)
                                                        <?php $i++; ?>
                                                        
                                                        <a href="{{ route('tag', $tag->slug) }}" title="{!! $tag->name !!}"><b>{!! $tag->name !!}, </b></a> 
                                                        @endforeach
                                                  
                                                @endif      

                                            </div>
                                        </div>
                                        @endif
                                    </div><!-- /block-datail-if -->
                                    <div class="block block-share" id="share-buttons">
                                        <div class="share-item">
                                            <div class="fb-like" data-href="{{ url()->current() }}" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
                                        </div>
                                        <div class="share-item" style="max-width: 65px;">
                                            <div class="g-plus" data-action="share"></div>
                                        </div>
                                        <div class="share-item">
                                            <a class="twitter-share-button"
                                          href="https://twitter.com/intent/tweet?text={!! $detail->title !!}">
                                        Tweet</a>
                                        </div>
                                        <div class="share-item">
                                            <div class="addthis_inline_share_toolbox"></div>
                                        </div>
                                    </div><!-- /block-share-->          
                                    
                                    <button type="button" class="block_order btn btn-addcart-product" data-id="{{ $detail->id }}">Thêm vào giỏ hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($detail->chi_tiet != '')
                    <div class="block block-datail-atc block-page-common">
                        <div class="block block-title">
                            <h2>
                                <i class="fa fa-shopping-cart"></i>
                                MÔ TẢ CHI TIẾT
                            </h2>
                        </div>
                        <div class="block-content">                           
                            {!! $detail->chi_tiet !!}
                        </div>
                    </div>
                    @endif
                    @if($otherList)
                    <div class="block-datail-atc block-page-common">
                        <div class="block block-title">
                            <h2>
                                <i class="fa fa-shopping-cart"></i>
                                SẢN PHẨM LIÊN QUAN
                            </h2>
                        </div>
                        <div class="block-content product-list">
                            <ul class="owl-carousel owl-theme owl-style2" data-nav="true" data-dots="false" data-autoplay="true" data-autoplayTimeout="500" data-loop="true" data-margin="30" data-responsive='{"0":{"items":1},"480":{"items":2},"600":{"items":2},"768":{"items":3},"800":{"items":3},"992":{"items":4}}'>
                                <?php $i = 0;?>
                                @foreach($otherList as $product)
                                <?php $i++; ?>
                                <li class="product-item">
                                    <div class="product-img">
                                        <a href="{{ route('product-detail', [$product->slug, $product->id]) }}" class="product-item-photo">
                                            <img alt="{!! $product->name !!}" src="{{ $product->image_url ? Helper::showImageThumb($product->image_url) : URL::asset('admin/dist/img/no-image.jpg') }}">
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <h2 class="title"><a href="#" title="">{!! $product->name !!}</a></h2>
                                        <div class="product-price">
                                            <span class="price-new">{{ $product->is_sale == 1 ? number_format($product->price_sale) : number_format($product->price) }}đ</span>
                  @if($product->is_sale)
                  <span class="price-old">{{ number_format($product->price) }}đ</span>
                  @endif
                                        </div>
                                    </div>
                                </li>
                                 @endforeach   
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div><!-- /block-detail -->
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
                </div>
            </div>
        </div><!-- /block-col-right -->
    </div>
</div><!-- /block_big-title -->
@stop
@section('js')
<script src="{{ URL::asset('public/assets/lib/jquery.zoom.min.js') }}"></script>
<script src="{{ URL::asset('public/assets/lib/flexslider/jquery.flexslider-min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function($){  
    // The slider being synced must be initialized first
    $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: true,
        slideshow: false,
        itemWidth: 75,
        itemMargin: 15,
        nextText: "",
        prevText: "",
        asNavFor: '#slider'
    });

    $('#slider').flexslider({
        animation: "fade",
        controlNav: false,
        directionNav: false,
        animationLoop: false,
        slideshow: false,
        animationSpeed: 500,
        sync: "#carousel"
    });

    $('.slides-large li').each(function () {
        $(this).zoom();
    });
  $('a.block_order').click(function() {
        var product_id = $(this).data('id');
        add_product_to_cart(product_id);
        
      });
});
function add_product_to_cart(product_id) {
  $.ajax({
    url: $('#route-add-to-cart').val(),
    method: "GET",
    data : {
      id: product_id
    },
    success : function(data){
       $('.cart-link').click();
    }
  });
}
</script>
@stop



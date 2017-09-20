@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="block block-breadcrumb">
<div class="container">
    <ul class="breadcrumb">
        <li><a href="{!! route('home') !!}">Trang chủ</a></li>
        <li><a href="{!! route('news-list', $cateDetail->slug) !!}">{!! $cateDetail->name !!}</a></li>        
        <li class="active">{!! $detail->title !!}</li>
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
                    {!! $detail->title !!}
                </h2>
            </div>
            <div class="block-content">
                <div class="block block-aritcle">
                    {!! $detail->content !!}
                </div>
                <div class="block block-share">
                    Share
                </div><!-- /block-share -->
                @if($tagSelected->count() > 0)
                <div class="block-tags">
                    <ul>
                        <li class="tags-first">Tags:</li>
                        <?php $i = 0; ?>
                        @foreach($tagSelected as $tag)
                        <?php $i++; ?>
                        <li class="tags-link"><a href="{{ route('tag', $tag->slug) }}" title="{!! $tag->name !!}">{!! $tag->name !!}</a></li>
                        @endforeach
                    </ul>
                </div><!-- /block-tags -->
                @endif                
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
                    @foreach( $otherArr as $articles)
                    <li><a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}" title="{!! $articles->title !!}" >{!! $articles->title !!}</a></li>
                    @endforeach   
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
            
        </div>
    </div><!-- /block-col-right -->
</div>
</div><!-- /block_big-title -->
@stop  

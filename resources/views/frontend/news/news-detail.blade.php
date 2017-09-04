@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="block block_breadcrumb">
    <ol class="breadcrumb">
        <li><a href="{!! route('home') !!}">Trang chủ</a></li>
        <li><a href="{!! route('news-list') !!}">Tin tức</a></li>        
        <li class="active">{!! $detail->title !!}</li>
    </ol>
</div><!-- /block_breadcrumb -->
<div class="block_news row">
    <div class="col-md-9 col-sm-9 col-xs-12 block_cate_left">
        <div class="block_news_content">
            <h1 class="article-title">{!! $detail->title !!}</h1>
            <p class="content-date">Ngày tạo: {!! date('d/m/Y H:i', strtotime($detail->created_at)) !!}</p>
            <div class="block">
                <p class="block_intro">
                    <img class="lazy" data-original="{!! Helper::showImage($detail->image_url ) !!}" alt="{!! $detail->title !!}">
                </p>
                {!! $detail->content !!}
            </div><!-- /block -->
            @if( $otherArr )
                       
            <div class="block_news_related" style="margin-top:40px">
                <span class="block_title">CÁC TIN KHÁC</span>
                <ul class="row">
                 @foreach( $otherArr as $articles)
                <li class="col-sm-3 col-sm-6">
                    <div class="des" style="text-align:left">
                        <img src="{!! Helper::showImage($articles->image_url ) !!}" alt="{!! $articles->title !!}">
                        <a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}" title="{!! $articles->title !!}" >{!! $articles->title !!}</a>
                        <span>[{!! date('d/m/Y', strtotime($detail->created_at)) !!}]</span>
                    </div>
                </li>                
                @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div><!-- /block_cate_left -->

    @include('frontend.news.sidebar')
</div><!-- /block_categories -->
<style type="text/css">
    .block_news_related ul li a{
        font-size: 12px;
        height: 30px;
        display: block;
        overflow-y: hidden;
    }
</style>
@endsection  

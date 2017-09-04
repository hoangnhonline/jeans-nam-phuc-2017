@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="block block_breadcrumb">
    <ol class="breadcrumb">
        <li><a href="{!! route('home') !!}">Trang chủ</a></li>         
        <li class="active">{!! $detailPage->title !!}</li>
    </ol>
</div><!-- /block_breadcrumb -->
<div class="block_news row">
    <div class="col-md-9 col-sm-9 col-xs-12 block_cate_left">
        <div class="block_news_content">
            <h1 class="article-title">{!! $detailPage->title !!}</h1>
            
            <div class="block" style="margin-top:30px" id="content-of-page">
                @if($detailPage->image_url)
                <p class="block_intro">
                    <img src="{!! Helper::showImage($detailPage->image_url ) !!}" alt="{!! $detailPage->title !!}">
                </p>
                @endif
                {!! $detailPage->content !!}
            </div><!-- /block -->            
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
    #content-of-page ul li, #content-of-page ol li {
        list-style: circle;   
    }
    #content-of-page ul , #content-of-page ol {        
        margin-left: 15px;
    }
    #content-of-page h3 {
        font-size: 16px;
    }
</style>
@endsection  

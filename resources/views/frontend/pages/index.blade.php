@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="block block-breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
             <li><a href="{!! route('home') !!}">Trang chủ</a></li>         
        <li class="active">{!! $detailPage->title !!}</li>
        </ul>
    </div>
</div><!-- /block-breadcrumb -->
<div class="container">
    <div class="block-page-about">
        <div class="block-page-common">
            <div class="block block-title">
                <h2>
                    <i class="fa fa-address-card-o"></i>
                    {!! $detailPage->title !!}
                </h2>
            </div>
        </div>
        <div class="block-article">
            <div class="block block-content">
                {!! $detailPage->content !!}
            </div>
        </div>
    </div>
</div><!-- /container-->
@endsection  

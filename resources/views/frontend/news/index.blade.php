@extends('frontend.layout')  
@include('frontend.partials.meta')
@section('content')
<div class="block block_breadcrumb">
  <ol class="breadcrumb">
    <li><a href="{!! route('home') !!}">Trang chủ</a></li>
    <li class="active">Tin Tức</li>
  </ol>
</div><!-- /block_breadcrumb -->
<div class="block_news row">
  <div class="col-md-9 col-sm-9 col-xs-12 block_cate_left">
    @if($page == 1)
    <div class="block block-news-default row">
      <div class="block-news-default-left">
        <div class="col-sm-8 col-xs-12">
          @if($articlesList->first())
          <div class="block-news-default-item">
            <div class="block_thumb">
              <a href="{{ route('news-detail', ['slug' => $articlesList->first()->slug, 'id' => $articlesList->first()->id]) }}" title="{!! $articlesList->first()->title !!}">
                <img class="lazy" data-original="{!! Helper::showImage($articlesList->first()->image_url) !!}" alt="{!! $articlesList->first()->title !!}">
              </a>
            </div>
            <a href="{{ route('news-detail', ['slug' => $articlesList->first()->slug, 'id' => $articlesList->first()->id]) }}" title="{!! $articlesList->first()->title !!}">
                    <h3>{!! $articlesList->first()->title !!}              
                    </h3>
                </a>
                <figure>
              {!! $articlesList->first()->description !!}
            </figure>
          </div>
          @endif
        </div>
      </div><!-- /block-news-default-left -->
      <div class="block-news-default-right">
        <div class="col-sm-4 col-xs-12">
          @if($articlesList)
          <ul class="list_news">
            <?php $i = 0; ?>
            @foreach($articlesList as $articles)
            <?php $i++ ; ?>
            @if($i > 1 && $i < 6)
            <li class="item">
              @if($i == 2)
              <div class="block_thumb">
                <a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}" title="{!! $articles->title !!}">
                  <img class="lazy" data-original="{!! Helper::showImage($articles->image_url) !!}" alt="{!! $articles->title !!}">
                </a>
              </div>
              @endif
              <a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}" title="{!! $articles->title !!}">
                <h3>  
                  {!! $articles->title !!}
                </h3>
              </a>
            </li>
            @endif
            @endforeach
          </ul>
          @endif
        </div>
      </div><!-- /block-news-default-right -->
    </div><!-- /block-news-default -->
    @endif
    <ul class="block_news_bot clearfix">
      <?php $i = 0; 
      $nRow = $page == 1 ? 6 : 0;
      ?>
          @foreach($articlesList as $articles)
          <?php $i++ ; ?>

          @if($i > $nRow)
      <li class="item">
        <div class="block_thumb">
          <a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}" title="{!! $articles->title !!}">
            <img src="{!! Helper::showImage($articles->image_url) !!}" alt="{!! $articles->title !!}">
          </a>
        </div>
        <div class="description">
          <a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}" title="{!! $articles->title !!}">
            <h3> {!! $articles->title !!}</h3>
          </a>
          <figure>
            {!! $articles->description !!}
          </figure>                     
        </div>
      </li><!-- /item -->
      @endif
      @endforeach
      
    </ul><!-- /block_news_bot -->
    <div style="text-align:center">{{ $articlesList->links() }}</div>
  </div><!-- /block_cate_left -->

  @include('frontend.news.sidebar')
</div><!-- /block_categories -->
@endsection
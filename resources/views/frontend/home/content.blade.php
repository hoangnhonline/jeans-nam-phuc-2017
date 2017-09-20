@section('content')

@include('frontend.home.slider')
@include('frontend.home.about')
@include('frontend.home.ads')
@include('frontend.home.about-product')

<div class="block block-product block-title-cm">
  <div class="container">
    <div class="block block-title">
      <h2 @if($isEdit) class="edit" @endif data-text="13">{!! $textList[13] !!}</h2>
      <p class="desc @if($isEdit) edit @endif" data-text="14">
        {!! $textList[14] !!}
      </p>
    </div>
    <div class="block-content">
      <div class="product-list">
        <div class="row">
          @foreach($productList as $product)
          <div class="col-sm-5ths col-xs-6">
            <div class="product-item">
              <div class="product-img">
               <a href="{{ route('product-detail', [$product->slug, $product->id]) }}" title="{!! $product->name !!}">
                   <img class="lazy" src="{{ $product->image_url ? Helper::showImageThumb($product->image_url) : URL::asset('public/admin/dist/img/no-image.jpg') }}" alt="{!! $product->name !!}" title="{!! $product->name !!}">           
                </a>
              </div>
              <div class="product-info">
                <h2 class="title">
                   <a href="{{ route('product-detail', [$product->slug, $product->id]) }}" title="{!! $product->name !!}">{!! $product->name !!}</a></h2>
                <div class="product-price">
                  <span class="price-new">{{ $product->is_sale == 1 ? number_format($product->price_sale) : number_format($product->price) }}đ</span>
                  @if($product->is_sale)
                  <span class="price-old">{{ number_format($product->price) }}đ</span>
                  @endif
                </div>
              </div>
            </div>
          </div><!--col-sm-5ths-->
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div><!-- /block_big-title -->
@stop
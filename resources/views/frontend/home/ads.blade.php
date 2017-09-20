<?php 
$bannerArr = DB::table('banner')->where(['object_id' => 5, 'object_type' => 3])->orderBy('display_order', 'asc')->get();
?> 
<div class="block block-banner">
@if($bannerArr)
    @foreach($bannerArr as $banner)
      @if($banner->ads_url !='')
      <a href="{{ $banner->ads_url }}" title="banner slide {{ $i }}">
      @endif
      <img src="{{ Helper::showImage($banner->image_url) }}" alt="banner trai">  
      @if($banner->ads_url !='')
      </a>
      @endif
    @endforeach  
  @endif 
</div><!-- /block-banner -->
 <?php 
$bannerArr = DB::table('banner')->where(['object_id' => 1, 'object_type' => 3])->orderBy('display_order', 'asc')->get();
?>
<div class="block block-side">
	@if($bannerArr)
	<div class="owl-carousel owl-style2" data-nav="false" data-margin="0" data-items='1' data-autoplayTimeout="1000" data-autoplay="true" data-loop="true" data-navcontainer="true">
		<?php $i = 0; ?>
		@foreach($bannerArr as $banner)
		<?php $i++; ?>
		<div class="item-slide">
		@if($banner->ads_url !='')
		<a href="{{ $banner->ads_url }}" title="banner slide {{ $i }}">
		@endif
		<img src="{{ Helper::showImage($banner->image_url) }}" alt="banner slide {{ $i }}">
		@if($banner->ads_url !='')
		</a>
		@endif
		</div><!-- item-banner -->
		@endforeach
	</div>
	@endif
</div><!-- /block-side -->
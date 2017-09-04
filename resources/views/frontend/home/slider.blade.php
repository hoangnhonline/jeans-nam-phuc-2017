 <?php 
$bannerArr = DB::table('banner')->where(['object_id' => 1, 'object_type' => 3])->orderBy('display_order', 'asc')->get();
?>
<div class="col-md-9 col-sm-12 col-xs-12 block_slide">
	@if($bannerArr)
	<ul class="owl-carousel owl-style2 dotsData" data-nav="true" data-margin="0" data-items='1' data-autoplayTimeout="700" data-autoplay="true" data-loop="true">
	<?php $i = 0; ?>
		@foreach($bannerArr as $banner)
		<?php $i++; ?>
		<li class="item" data-dot="{{ $i }}">
			 @if($banner->ads_url !='')
			 <a href="{{ $banner->ads_url }}" title="banner slide {{ $i }}">
			  @endif
				<img src="{{ Helper::showImage($banner->image_url) }}" alt="banner slide {{ $i }}">
			@if($banner->ads_url !='')
			</a>
			@endif
		</li>
		@endforeach
	</ul>
	@endif
</div><!-- /block_slide -->
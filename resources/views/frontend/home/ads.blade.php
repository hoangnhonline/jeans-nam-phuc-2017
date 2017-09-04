<div class="block block_newshot">
  <div class="block_content row">
    <div class="col-md-6 col-sm-6 col-xs-12 item">    
      <div class="block_inner">   
        <?php 
        $bannerArr = DB::table('banner')->where(['object_id' => 2, 'object_type' => 3])->orderBy('display_order', 'asc')->get();
        ?>    
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
      </div>
    </div><!-- /item -->
    <div class="col-md-6 col-sm-6 col-xs-12 item">
      <?php 
        $bannerArr = DB::table('banner')->where(['object_id' => 3, 'object_type' => 3])->orderBy('display_order', 'asc')->get();
        ?>    
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
    </div><!-- /item -->
  </div>
</div><!-- /block_newshot -->
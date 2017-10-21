 @if( $imageList->count() > 0 )
 <div id="slider" class="flexslider">
    <ul class="slides slides-large">
        <?php  $i = 0; ?>
        @foreach( $imageList as $img )                                        
        <?php $i++; ?>
            <li><img src="{{ Helper::showImage($img->image_url) }}" alt=" hinh anh {{ $i }}" /></li>
        @endforeach
    </ul>
</div>
<div id="carousel" class="flexslider">
    <ul class="slides">
        @foreach( $imageList as $img )                                        
            <li><img src="{{ Helper::showImageThumb($img->image_url) }}" alt=" hinh anh thumb" /></li>
        @endforeach
    </ul>
</div>
@endif
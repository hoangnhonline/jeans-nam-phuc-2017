<div class="block-sidebar">
    <div class="block-module block-links-sidebar">
        <div class="block-title">
            <h2>
                <i class="fa fa-gift"></i>
                KHUYẾN MÃI HOT
            </h2>
        </div>
        <div class="block-content">
            <ul class="list">
                <?php 
                $articlesHot = DB::table('articles')->where('is_hot', 1)->where('cate_id', 2)->orderBy('id', 'desc')->limit(5)->get();
                ?>
                @foreach($articlesHot as $articles)
                <li>
                     <a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}">

                     <p class="thumb"><img title="{!! $articles->title !!}" src="{{ $articles->image_url ? Helper::showImage($articles->image_url) : URL::asset('public/assets/images/no-img.png') }}" alt="{!! $articles->title !!}"></p>
                    <h3>{!! $articles->title !!}</h3>
                     </a>                    
                </li>
                @endforeach
            </ul>
        </div>
    </div>               
</div>
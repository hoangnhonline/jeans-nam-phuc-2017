<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CateParent;
use App\Models\Cate;
use App\Models\Product;
use App\Models\ProductImg;
use App\Models\Banner;
use App\Models\Location;
use App\Models\TinhThanh;
use App\Models\MetaData;
use App\Models\Tag;
use App\Models\Settings;
use App\Models\TagObjects;
use App\Models\Articles;
use App\Models\Color;
use App\Models\Size;
use App\Models\ProductInventory;

use Helper, File, Session, Auth, Response;

class DetailController extends Controller
{
    
    public static $loaiSp = []; 
    public static $loaiSpArrKey = [];    

    public function __construct(){
        
       

    }
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {   
        $spThuocTinhArr = $productArr = [];
        $id = $request->id;
        $detail = Product::find($id);
        if(!$detail){
            return redirect()->route('home');
        }
        $loaiDetail = CateParent::find( $detail->parent_id );
        $cateDetail = Cate::find( $detail->cate_id );

        $hinhArr = ProductImg::where('product_id', $detail->id)->where('color_id', $detail->color_id_main)->get()->toArray();
        // hien thuoc tinh
       
        
        
        if( $detail->meta_id > 0){
           $meta = MetaData::find( $detail->meta_id )->toArray();
           $seo['title'] = $meta['title'] != '' ? $meta['title'] : $detail->name;
           $seo['description'] = $meta['description'] != '' ? $meta['description'] : $detail->name;
           $seo['keywords'] = $meta['keywords'] != '' ? $meta['keywords'] : $detail->name;
        }else{
            $seo['title'] = $seo['description'] = $seo['keywords'] = $detail->name;
        }               
        if($detail->thumbnail_id){
            $socialImage = ProductImg::find($detail->thumbnail_id)->image_url;
        }else{
            $socialImage = '';
        }
       
        $query = Product::where('product.slug', '<>', '')
                    ->where('product.parent_id', $detail->parent_id)
                    ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')                   
                    ->select('product_img.image_url', 'product.*')
                    ->where('product.id', '<>', $detail->id);                        
                    $otherList = $query->orderBy('product.id', 'desc')->limit(6)->get();
        $tagSelected = Product::getListTag($detail->id);

        // get list size selected
        $colorArr = $sizeArr = [];
        $colorList = Color::orderBy('display_order')->get();      
        $sizeList = Size::orderBy('display_order')->get();    
        foreach($colorList as $color){
            $colorArr[$color->id] = $color;
        }
        foreach($sizeList as $size){
            $sizeArr[$size->id] = $size;
        }
        foreach($detail->colors as $color){
            $colorSelected[] = $color->color_id;
        } 
        foreach($detail->sizes as $size){
            $sizeSelected[] = $size->size_id;
        }
       // dd($colorSelected);
        return view('frontend.detail.index', compact('detail', 'loaiDetail', 'cateDetail', 'hinhArr', 'productArr', 'seo', 'socialImage', 'otherList', 'tagSelected',
            'sizeArr', 'sizeSelected', 'colorArr', 'colorSelected'
            ));
    }
    public function getIvtOfColor(Request $request){
        $color_id = $request->color_id;
        $product_id = $request->product_id;
        $rs = ProductInventory::where(['color_id' => $color_id, 'product_id' => $product_id])
                ->select('amount', 'size_id')->get();
        foreach($rs as $arr){
            $rsIvt[$arr['size_id']] = $arr['amount'];
        }        
        $sizeList = Size::orderBy('display_order')->get();   
        $detail = Product::find($product_id);         
        foreach($sizeList as $size){
            $sizeArr[$size->id] = $size;
        }
        foreach($detail->sizes as $size){
            $sizeSelected[] = $size->size_id;
        }
        return view('frontend.detail.ajax.size', compact('rsIvt', 'sizeArr', 'sizeSelected'));
    }
    public function getImgOfColor(Request $request){
        $color_id = $request->color_id;
        $product_id = $request->product_id;
        $imageList = ProductImg::where(['color_id' => $color_id, 'product_id' => $product_id])
                ->orderBy('is_thumbnail')->orderBy('display_order')->get();
       // dd($imageList);
        return view('frontend.detail.ajax.image', compact('imageList'));
    }

    public function ajaxTab(Request $request){
        $table = $request->type ? $request->type : 'category';
        $id = $request->id;

        $arr = Film::getFilmHomeTab( $table, $id);

        return view('frontend.index.ajax-tab', compact('arr'));
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function search(Request $request)
    {

        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        
        $layout_name = "main-category";
        
        $page_name = "page-category";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];

        $tu_khoa = $request->k;
        
        $is_search = 1;

        $moviesArr = Film::where('alias', 'LIKE', '%'.$tu_khoa.'%')->orderBy('id', 'desc')->paginate(20);

        return view('frontend.cate', compact('settingArr', 'moviesArr', 'tu_khoa',  'is_search', 'layout_name', 'page_name' ));
    }    

    public function tags(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');

        $layout_name = "main-category";
        
        $page_name = "page-category";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $is_search = 0;
        $tagName = $request->tagName;

        $title = '';
        $cateDetail = (object) [];       
        
        $cateDetail = Tag::where('slug', $tagName)->first();
       
         $moviesArr = Film::where('status', 1)
        ->join('tag_objects', 'id', '=', 'tag_objects.object_id')
        ->where('tag_objects.tag_id', $cateDetail->id)
        ->where('tag_objects.type', 1)
        ->groupBy('object_id')
        ->orderBy('id', 'desc')->paginate(30);        
       
        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;
        $cateDetail->name = "Phim theo tags : ".'"'.$cateDetail->name.'"';
        

        return view('frontend.cate', compact('title', 'settingArr', 'is_search', 'moviesArr', 'cateDetail', 'layout_name', 'page_name', 'cateActiveArr', 'moviesActiveArr'));
    }
    public function tagDetail(Request $request){
        $slug = $request->slug;
        $detail = Tag::where('slug', $slug)->first();
        //dd($detail->type);
        if(!$detail){
            return redirect()->route('home');
        }        
        if($detail->type == 1 || $detail->type == 3){        
            $productList = (object)[];
            $listId = [];
            $listId = TagObjects::where(['type' => $detail->type, 'tag_id' => $detail->id])->lists('object_id');
            if($listId){
                $listId = $listId->toArray();
            }
            if(!empty($listId)){
            $query = Product::where('product.status', 1)            
                ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                ->select('product_img.image_url as image_url', 'product.*')
                ->whereIn('product.id', $listId)               
                ->orderBy('product.id', 'desc');
                $productList  = $query->paginate(15);

            }             
            if( $detail->meta_id > 0){
               $seo = MetaData::find( $detail->meta_id )->toArray();
               $seo['title'] = $seo['title'] != '' ? $seo['title'] : 'Tag - '. $detail->name;
               $seo['description'] = $seo['description'] != '' ? $seo['description'] : 'Tag - '. $detail->name;
               $seo['keywords'] = $seo['keywords'] != '' ? $seo['keywords'] : 'Tag - '. $detail->name;
               $seo['custom_text'] = $seo['custom_text'];
            }else{
                $seo['title'] = $seo['description'] = $seo['keywords'] = 'Tag - '. $detail->name;
                $seo['custom_text'] = "";
            }
            
            return view('frontend.cate.tag', compact('productList', 'socialImage', 'seo', 'detail'));
        }elseif($detail->type == 2){ // articles
            $articlesList = (object)[];
            $listId = [];
            $listId = TagObjects::where(['type' => 2, 'tag_id' => $detail->id])->lists('object_id');
            if($listId){
                $listId = $listId->toArray();
            }
            if(!empty($listId)){
                $articlesList = Articles::whereIn('id', $listId)->orderBy('id', 'desc')->where('cate_id', '<>', 999)->paginate(20);
            }  

            if( $detail->meta_id > 0){
               $seo = MetaData::find( $detail->meta_id )->toArray();
               $seo['title'] = $seo['title'] != '' ? $seo['title'] : 'Tag - '. $detail->name;
               $seo['description'] = $seo['description'] != '' ? $seo['description'] : 'Tag - '. $detail->name;
               $seo['keywords'] = $seo['keywords'] != '' ? $seo['keywords'] : 'Tag - '. $detail->name;
            }else{
                $seo['title'] = $seo['description'] = $seo['keywords'] = 'Tag - '. $detail->name;
            }                     
            return view('frontend.news.tag', compact('title', 'articlesList', 'seo', 'socialImage', 'detail'));
        }
    }
    public function daoDien(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');

        $layout_name = "main-category";
        
        $page_name = "page-category";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $is_search = 0;
        $name = $request->name;

        $title = '';
        $cateDetail = (object) [];       
        
        $cateDetail = Crew::where('slug', $name)->first();
       
         $moviesArr = Film::where('status', 1)
        ->join('film_crew', 'id', '=', 'film_crew.film_id')
        ->where('film_crew.crew_id', $cateDetail->id)
        ->where('film_crew.type', 2)
        ->groupBy('film_id')
        ->orderBy('id', 'desc')->paginate(30);        
       
        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;
        $cateDetail->name = "Phim của : ".'"'.$cateDetail->name.'"';
        

        return view('frontend.cate', compact('title', 'settingArr', 'is_search', 'moviesArr', 'cateDetail', 'layout_name', 'page_name', 'cateActiveArr', 'moviesActiveArr'));
    }

    public function dienVien(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');

        $layout_name = "main-category";
        
        $page_name = "page-category";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $is_search = 0;
        $name = $request->name;

        $title = '';
        $cateDetail = (object) [];       
        
        $cateDetail = Crew::where('slug', $name)->first();
       
         $moviesArr = Film::where('status', 1)
        ->join('film_crew', 'id', '=', 'film_crew.film_id')
        ->where('film_crew.crew_id', $cateDetail->id)
        ->where('film_crew.type', 1)
        ->groupBy('film_id')
        ->orderBy('id', 'desc')->paginate(30);         
       
        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;
        $cateDetail->name = "Phim của : ".'"'.$cateDetail->name.'"';
        

        return view('frontend.cate', compact('title', 'settingArr', 'is_search', 'moviesArr', 'cateDetail', 'layout_name', 'page_name', 'cateActiveArr', 'moviesActiveArr'));
    }

    public function newsList(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $layout_name = "main-news";
        
        $page_name = "page-news";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $cateDetail = ArticlesCate::where('slug' , 'tin-tuc')->first();
        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;

        $articlesArr = Articles::where('cate_id', 1)->orderBy('id', 'desc')->paginate(10);
        $hotArr = Articles::where( ['cate_id' => 1, 'is_hot' => 1] )->orderBy('id', 'desc')->limit(5)->get();
        return view('frontend.news-list', compact('title','settingArr', 'hotArr', 'layout_name', 'page_name', 'articlesArr'));
    }

    public function newsDetail(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $layout_name = "main-news";
        
        $page_name = "page-news";

        $id = $request->id;

        $detail = Articles::where( 'id', $id )
                ->select('id', 'title', 'slug', 'description', 'image_url', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'custom_text')
                ->first();

        if( $detail ){
            $cateArr = $cateActiveArr = $moviesActiveArr = [];
        
            
            $title = trim($detail->meta_title) ? $detail->meta_title : $detail->title;

            $hotArr = Articles::where( ['cate_id' => 1, 'is_hot' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(5)->get();

            return view('frontend.news-detail', compact('title', 'settingArr', 'hotArr', 'layout_name', 'page_name', 'detail'));
        }else{
            return view('erros.404');
        }     

        
    }

}


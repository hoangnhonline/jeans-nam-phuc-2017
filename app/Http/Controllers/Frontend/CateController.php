<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Product;
use App\Models\SpThuocTinh;
use App\Models\ProductImg;
use App\Models\ThuocTinh;
use App\Models\LoaiThuocTinh;
use App\Models\Banner;
use App\Models\Location;
use App\Models\TinhThanh;
use App\Models\HoverInfo;
use App\Models\Pages;
use App\Models\MetaData;
use Helper, File, Session, Auth, DB;

class CateController extends Controller
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
        $productArr = [];
        $slug = $request->slug;
        $loaiDetail = LoaiSp::where('slug', $slug)->first();
        $price_fm = $request->price_fm ? $request->price_fm : 0;      
        $price_to = $request->price_to ? $request->price_to : 500000000;      
        if($loaiDetail){//danh muc cha
            $loai_id = $loaiDetail->id;
            
            $query = Product::where('loai_id', $loai_id)
                ->where('so_luong_ton', '>', 0)
                ->where('price', '>', 0)       
                ->where('is_old', 0)               
                ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.product_id', '=','product.id')
                ->select('product_img.image_url', 'product.*', 'thuoc_tinh')              
                ->orderBy('product.id', 'desc');

                $productList  = $query->paginate(20);
 
            $hoverInfo = HoverInfo::where('loai_id', $loaiDetail->id)->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
            
            $socialImage = $loaiDetail->banner_menu;

            if( $loaiDetail->meta_id > 0){
               $seo = MetaData::find( $loaiDetail->meta_id )->toArray();
            }else{
                $seo['title'] = $seo['description'] = $seo['keywords'] = $loaiDetail->name;
            }                                     
            return view('frontend.cate.parent', compact('productList', 'loaiDetail', 'hoverInfo', 'socialImage', 'seo', 'price_fm', 'price_to'));
        }else{
            // [ page ]
            $detailPage = Pages::where('slug', $slug)->first();
            if(!$detailPage){
                return redirect()->route('home');
            }
            $seo['title'] = $detailPage->meta_title ? $detailPage->meta_title : $detailPage->title;
            $seo['description'] = $detailPage->meta_description ? $detailPage->meta_description : $detailPage->title;
            $seo['keywords'] = $detailPage->meta_keywords ? $detailPage->meta_keywords : $detailPage->title;        
            $newProductList =  Product::where('so_luong_ton', '>', 0)->where('price', '>', 0)
                        ->where('is_new', 1)                   
                        ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                        ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.product_id', '=','product.id')
                        ->join('loai_sp', 'loai_sp.id', '=', 'product.loai_id')
                        ->select('product_img.image_url', 'product.*', 'thuoc_tinh')
                        ->orderBy('id', 'desc')->limit(6)->get();   
            return view('frontend.pages.index', compact('detailPage', 'seo', 'newProductList'));    
        }
    }
    public function getSeoInfo($meta_id){

    }
   
    function getGiaFromTo($slugGia){
        switch ($slugGia) {
            case 'duoi-1-trieu':
                $from = 0;
                $to = 1000000;
                $title = "Dưới 1 triệu";
                break;           
            case 'tu-1-den-2-trieu':
                $from = 1000001;
                $to = 2000000;
                $title = "Từ 1 - 2 triệu";
                break;
            case 'tu-2-den-4-trieu':
                $from = 2000001;
                $to = 4000000;
                $title = "Từ 2 - 4 triệu";
                break;
            case 'tu-4-den-8-trieu':
                $from = 4000001;
                $to = 8000000;
                $title = "Từ 4 - 8 triệu";
                break;
            case 'tu-8-den-16-trieu':
                $from = 8000001;
                $to = 16000000;
                $title = "Từ 8 - 16 triệu";
                break;
            case 'tren-16-trieu':
                $from = 16000001;
                $to = 1000000000;
                $title = "Trên 16 triệu";
                break;         
            default:
                $from = 0;
                $to = 100000000;
                $title = "Trên 16 triệu";
                break;
        }
        return ['from' => $from, 'to' => $to, 'title' => $title];
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
   

    public function cate(Request $request)
    {

        $productArr = [];
        $slugLoaiSp = $request->slugLoaiSp;
        $slug = $request->slug;
        $loaiDetail = LoaiSp::where('slug', $slugLoaiSp)->first();
        if(!$loaiDetail){
            return redirect()->route('home');
        }
        $loai_id = $loaiDetail->id;
        $cateDetail = Cate::where(['loai_id' => $loai_id, 'slug' => $slug])->first();
        $cate_id = $cateDetail->id;
        
        $query = Product::where('cate_id', $cateDetail->id)->where('loai_id', $loai_id)->where('so_luong_ton', '>', 0)->where('price', '>', 0)->where('is_old', 0)
                ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.product_id', '=','product.id')
                ->select('product_img.image_url', 'product.*', 'thuoc_tinh');
                    if($loaiDetail->price_sort == 0){
                        $query->where('price', '>', 0)->orderBy('product.price', 'asc');
                    }else{
                        $query->where('price', '>', 0)->orderBy('product.price', 'desc');
                    }
                $query->orderBy('product.id', 'desc');
                $productList = $query->paginate(20);
        $hoverInfo = HoverInfo::where('loai_id', $loaiDetail->id)->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();  
        //dd($hoverInfo);
        $socialImage = $cateDetail->icon_url;
        if( $cateDetail->meta_id > 0){            
           $seo = MetaData::find( $cateDetail->meta_id )->toArray();           
        }else{
            $seo['title'] = $seo['description'] = $seo['keywords'] = $cateDetail->name;
        }
        $price_fm = $request->price_fm ? $request->price_fm : 0;      
        $price_to = $request->price_to ? $request->price_to : 500000000;      
        return view('frontend.cate.child', compact('productList', 'loaiDetail', 'cateDetail', 'hoverInfo', 'socialImage', 'seo', 'price_fm', 'price_to'));
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
        if(!$detail){
            return redirect()->route('home');
        }

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

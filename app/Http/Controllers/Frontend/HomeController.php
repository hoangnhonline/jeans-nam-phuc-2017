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
use App\Models\HoverInfo;
use App\Models\Articles;
use App\Models\ArticlesCate;
use App\Models\Customer;
use App\Models\Newsletter;
use App\Models\Settings;

use Helper, File, Session, Auth, Hash;

class HomeController extends Controller
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
    public function index(Request $request){
         $productArr = $manhinhArr = [];
        $loaiSp = LoaiSp::where('status', 1)->get();
        $bannerArr = [];
        $hoverInfo = [];
        foreach( $loaiSp as $loai){            
            $query = Product::where( [ 'status' => 1, 'loai_id' => $loai->id, 'is_old' => 1, 'is_hot' => 1])
                            ->where('so_luong_ton', '>', 0)
                            ->where('price', '>', 0)            
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')            
                            ->select('product_img.image_url', 'product.*')                        
                            ->orderBy('product.display_order')            
                            ->limit(5);
           
            $productArr[$loai->id] = $query->get();

            if( $loai->home_style > 0 ){
                $bannerArr[$loai->id] = Banner::where(['object_id' => $loai->id, 'object_type' => 1])->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
            }       

           
            if(count($productArr) > 0){
                $hoverInfoTmp = HoverInfo::orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
                
                foreach($hoverInfoTmp as $value){
                    if($value->loai_id == $loai->id){
                        $hoverInfo[$value->loai_id][] = $value;
                    }
                }
            }            
        
        }// foreach
      //  dd($hoverInfo);
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $seo = $settingArr;
        $seo['title'] =  $seo['description'] =  $seo['keywords'] = "Máy cũ giá rẻ";
        $socialImage = $settingArr['banner'];

        $articlesArr = Articles::where(['cate_id' => 1, 'is_hot' => 1])->orderBy('id', 'desc')->get();
                
        return view('frontend.old.index', compact(
                                'productArr', 
                                'bannerArr', 
                                'articlesArr', 
                                'socialImage', 
                                'seo', 
                                'thuocTinhArr', 
                                'loaiThuocTinhArr', 
                                'spThuocTinhArr',
                                'hoverInfo'));
    }
    public function indexs(Request $request)
    {   
        $productArr = $manhinhArr = [];
        $loaiSp = LoaiSp::where('status', 1)->get();
        $bannerArr = [];
        $hoverInfo = [];
        foreach( $loaiSp as $loai){            
            $query = Product::where( [ 'status' => 1, 'loai_id' => $loai->id, 'is_old' => 0])
                            ->where('so_luong_ton', '>', 0)
                            ->where('price', '>', 0)            
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.product_id', '=', 'product.id')            
                            ->select('product_img.image_url', 'product.*', 'sp_thuoctinh.thuoc_tinh')
                            ->orderBy('product.id', 'desc')                            
                            ->limit(15);
           
            $productArr[$loai->id] = $query->get();

            if( $loai->home_style > 0 ){
                $bannerArr[$loai->id] = Banner::where(['object_id' => $loai->id, 'object_type' => 1])->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
            }       

           
            if(count($productArr) > 0){
                $hoverInfoTmp = HoverInfo::orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
                
                foreach($hoverInfoTmp as $value){
                    if($value->loai_id == $loai->id){
                        $hoverInfo[$value->loai_id][] = $value;
                    }
                }
            }            
        
        }// foreach
      //  dd($hoverInfo);
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $seo = $settingArr;
        $seo['title'] = $settingArr['site_title'];
        $seo['description'] = $settingArr['site_description'];
        $seo['keywords'] = $settingArr['site_keywords'];
        $socialImage = $settingArr['banner'];



        $articlesList = Articles::where(['cate_id' => 1])->orderBy('id', 'desc')->limit(4)->get();
                
        return view('frontend.home.index', compact(
                                'productArr', 
                                'bannerArr', 
                                'articlesList', 
                                'socialImage', 
                                'seo', 
                                'thuocTinhArr', 
                                'loaiThuocTinhArr', 
                                'spThuocTinhArr',
                                'hoverInfo'));
    }

    public function oldDevice(Request $request)
    {   
        $productArr = $manhinhArr = [];
        $loaiSp = LoaiSp::where('status', 1)->get();
        $bannerArr = [];
        $hoverInfo = [];
        foreach( $loaiSp as $loai){            
            $query = Product::where( [ 'status' => 1, 'loai_id' => $loai->id, 'is_old' => 1, 'is_hot' => 1])
                            ->where('so_luong_ton', '>', 0)
                            ->where('price', '>', 0)            
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')            
                            ->select('product_img.image_url', 'product.*')                        
                            ->orderBy('product.display_order')            
                            ->limit(5);
           
            $productArr[$loai->id] = $query->get();

            if( $loai->home_style > 0 ){
                $bannerArr[$loai->id] = Banner::where(['object_id' => $loai->id, 'object_type' => 1])->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
            }   
            if(count($productArr) > 0){
                $hoverInfoTmp = HoverInfo::orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
                
                foreach($hoverInfoTmp as $value){
                    if($value->loai_id == $loai->id){
                        $hoverInfo[$value->loai_id][] = $value;
                    }
                }
            }            
        
        }// foreach
      //  dd($hoverInfo);
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $seo = $settingArr;
        $seo['title'] = $settingArr['site_title'];
        $seo['description'] = $settingArr['site_description'];
        $seo['keywords'] = $settingArr['site_keywords'];
        $socialImage = $settingArr['banner'];



        $articlesArr = Articles::where(['cate_id' => 1, 'is_hot' => 1])->orderBy('id', 'desc')->get();
                
        return view('frontend.old.index', compact(
                                'productArr', 
                                'bannerArr', 
                                'articlesArr', 
                                'socialImage', 
                                'seo', 
                                'thuocTinhArr', 
                                'loaiThuocTinhArr', 
                                'spThuocTinhArr',
                                'hoverInfo'));
    }

    public function getNoti(){
        $countMess = 0;
        if(Session::get('userId') > 0){
            $countMess = CustomerNotification::where(['customer_id' => Session::get('userId'), 'status' => 1])->count();    
        }
        return $countMess;
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function search(Request $request)
    {
        $tu_khoa = $request->keyword ? $request->keyword : ''; 
        $price_fm = $request->price_fm ? $request->price_fm : 0;      
        $price_to = $request->price_to ? $request->price_to : 500000000;      
        $cateArr = $request->cate ? $request->cate : [];     
        $colorArr = $request->color ? $request->color : [];   
        $loai_id = $request->loai_id ? $request->loai_id : null;
        $cate_id = $request->cate_id ? $request->cate_id : null;

        $sort = $request->sort ? $request->sort : 'new';

        $colorArr = array_filter($colorArr);   
        $loaiDetail = (object) [];
        $query = Product::where('product.status', 1);
        $query->where('so_luong_ton', '>', 0)->where('price', '>', 0)->where('loai_sp.status', 1)                        
                        ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                        ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.product_id', '=','product.id')
                        ->join('loai_sp', 'loai_sp.id', '=', 'product.loai_id')
                        ->select('product_img.image_url', 'product.*', 'thuoc_tinh');
        if($tu_khoa){
            $query->where('product.alias', 'LIKE', '%'.$tu_khoa.'%');
        }
        if(!empty($cateArr)){
            $query->whereIn('product.cate_id', $cateArr);
        }
        if($loai_id){
            $query->where('product.loai_id', $loai_id);
        }
        if($cate_id){
            $query->where('product.cate_id', $cate_id);
        }
        if(!empty($colorArr)){
            $query->whereIn('product.color_id', $colorArr);
        }
        
        $query->where('price_sell', '<=', $price_to)->where('price_sell', '>=', $price_fm);
        
        if($sort == 'new'){
            $query->orderBy('id', 'desc');
        }elseif($sort=="old"){
            $query->orderBy('id');
        }elseif($sort == 'high'){
            $query->orderBy('price_sell', 'desc');
        }elseif($sort == 'low'){
            $query->orderBy('price_sell');
        }
        $productList = $query->paginate(20);
        $loaiDetail->name = $seo['title'] = $seo['description'] =$seo['keywords'] = "Tìm kiếm sản phẩm theo từ khóa '".$tu_khoa."'";
        $hoverInfo = [];
        if($productList->count() > 0){
            $hoverInfoTmp = HoverInfo::orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
            foreach($hoverInfoTmp as $value){
                $hoverInfo[$value->loai_id][] = $value;
            }
        }        
        //var_dump("<pre>", $hoverInfo);die;
        return view('frontend.search.index', compact('productList', 'tu_khoa', 'seo', 'hoverInfo', 'loaiDetail', 'cateArr', 'price_fm', 'price_to', 'colorArr', 'loai_id', 'cate_id', 'sort'));
    }
    public function ajaxTab(Request $request){
        $table = $request->type ? $request->type : 'category';
        $id = $request->id;

        $arr = Film::getFilmHomeTab( $table, $id);

        return view('frontend.index.ajax-tab', compact('arr'));
    }
    public function contact(Request $request){        

        $seo['title'] = 'Liên hệ';
        $seo['description'] = 'Liên hệ';
        $seo['keywords'] = 'Liên hệ';
        $socialImage = '';
        return view('frontend.contact.index', compact('seo', 'socialImage'));
    }

    public function newsList(Request $request)
    {
        $slug = $request->slug;
        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $cateDetail = ArticlesCate::where('slug' , $slug)->first();

        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;

        $articlesArr = Articles::where('cate_id', $cateDetail->id)->orderBy('id', 'desc')->paginate(10);

        $hotArr = Articles::where( ['cate_id' => $cateDetail->id, 'is_hot' => 1] )->orderBy('id', 'desc')->limit(5)->get();
        $seo['title'] = $cateDetail->meta_title ? $cateDetail->meta_title : $cateDetail->title;
        $seo['description'] = $cateDetail->meta_description ? $cateDetail->meta_description : $cateDetail->title;
        $seo['keywords'] = $cateDetail->meta_keywords ? $cateDetail->meta_keywords : $cateDetail->title;
        $socialImage = $cateDetail->image_url;       
        return view('frontend.news.index', compact('title', 'hotArr', 'articlesArr', 'cateDetail', 'seo', 'socialImage'));
    }      

     public function newsDetail(Request $request)
    {     
        $id = $request->id;

        $detail = Articles::where( 'id', $id )
                ->select('id', 'title', 'slug', 'description', 'image_url', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'custom_text', 'created_at', 'cate_id')
                ->first();
        $is_km = $is_news = $is_kn = 0;
        if( $detail ){           

            $title = trim($detail->meta_title) ? $detail->meta_title : $detail->title;

            $hotArr = Articles::where( ['cate_id' => 1, 'is_hot' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(5)->get();
            $otherArr = Articles::where( ['cate_id' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(5)->get();
            $seo['title'] = $detail->meta_title ? $detail->meta_title : $detail->title;
            $seo['description'] = $detail->meta_description ? $detail->meta_description : $detail->title;
            $seo['keywords'] = $detail->meta_keywords ? $detail->meta_keywords : $detail->title;
            $socialImage = $detail->image_url; 
            $is_km = $detail->cate_id == 2 ? 1 : 0;
            $is_news = $detail->cate_id == 1 ? 1 : 0;
            $is_kn = $detail->cate_id == 4 ? 1 : 0;
            return view('frontend.news.news-detail', compact('title',  'hotArr', 'detail', 'otherArr', 'seo', 'socialImage', 'is_km', 'is_news', 'is_kn'));
        }else{
            return view('erros.404');
        }
    }

    public function registerNews(Request $request)
    {

        $register = 0; 
        $email = $request->email;
        $newsletter = Newsletter::where('email', $email)->first();
        if(is_null($newsletter)) {
           $newsletter = new Newsletter;
           $newsletter->email = $email;
           $newsletter->is_member = Customer::where('email', $email)->first() ? 1 : 0;
           $newsletter->save();
           $register = 1;
        }

        return $register;
    }

}

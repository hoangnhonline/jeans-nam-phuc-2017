<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ArticlesCate;
use App\Models\Articles;
use App\Models\Product;

use Helper, File, Session, Auth;
use Mail;

class NewsController extends Controller
{
    public function newsList(Request $request)
    {
       
        $page = $request['page'] ? $request['page'] : 1;       
        $cateArr = [];
       
        $cateDetail = ArticlesCate::find(1);

        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;

        $articlesList = Articles::where('cate_id', $cateDetail->id)->orderBy('id', 'desc')->paginate(20);

        $hotArr = Articles::where( ['cate_id' => $cateDetail->id, 'is_hot' => 1] )->orderBy('id', 'desc')->limit(5)->get();
        $seo['title'] = $cateDetail->meta_title ? $cateDetail->meta_title : $cateDetail->title;
        $seo['description'] = $cateDetail->meta_description ? $cateDetail->meta_description : $cateDetail->title;
        $seo['keywords'] = $cateDetail->meta_keywords ? $cateDetail->meta_keywords : $cateDetail->title;
        $socialImage = $cateDetail->image_url;

        $newProductList =  Product::where('so_luong_ton', '>', 0)->where('price', '>', 0)
                        ->where('is_new', 1)                   
                        ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                        ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.product_id', '=','product.id')
                        ->join('loai_sp', 'loai_sp.id', '=', 'product.loai_id')
                        ->select('product_img.image_url', 'product.*', 'thuoc_tinh')
                        ->orderBy('id', 'desc')->limit(6)->get();

        return view('frontend.news.index', compact('title', 'hotArr', 'articlesList', 'cateDetail', 'seo', 'socialImage', 'page', 'newProductList'));
    }      

     public function newsDetail(Request $request)
    { 
        $id = $request->id;

        $detail = Articles::where( 'id', $id )
                ->select('id', 'title', 'slug', 'description', 'image_url', 'content', 'meta_id', 'created_at', 'cate_id')
                ->first();
        
        if( $detail ){           

            $title = trim($detail->meta_title) ? $detail->meta_title : $detail->title;

            $hotArr = Articles::where( ['cate_id' => $detail->cate_id, 'is_hot' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(5)->get();
            $otherArr = Articles::where( ['cate_id' => $detail->cate_id] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(4)->get();
            $seo['title'] = $detail->meta_title ? $detail->meta_title : $detail->title;
            $seo['description'] = $detail->meta_description ? $detail->meta_description : $detail->title;
            $seo['keywords'] = $detail->meta_keywords ? $detail->meta_keywords : $detail->title;
            $socialImage = $detail->image_url; 
          
            $tagSelected = Articles::getListTag($id);
            $cateDetail = ArticlesCate::find($detail->cate_id);

            $newProductList =  Product::where('so_luong_ton', '>', 0)->where('price', '>', 0)
                        ->where('is_new', 1)                   
                        ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                        ->leftJoin('sp_thuoctinh', 'sp_thuoctinh.product_id', '=','product.id')
                        ->join('loai_sp', 'loai_sp.id', '=', 'product.loai_id')
                        ->select('product_img.image_url', 'product.*', 'thuoc_tinh')
                        ->orderBy('id', 'desc')->limit(6)->get();

            return view('frontend.news.news-detail', compact('title',  'hotArr', 'detail', 'otherArr', 'seo', 'socialImage', 'tagSelected', 'cateDetail', 'newProductList'));
        }else{
            return view('erros.404');
        }
    }
}


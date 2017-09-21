<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CateParent;
use App\Models\Cate;
use App\Models\Product;
use App\Models\SpThuocTinh;
use App\Models\ProductImg;
use App\Models\ThuocTinh;
use App\Models\City;
use App\Models\LoaiThuocTinh;
use App\Models\Banner;
use App\Models\Orders;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Events;
use App\Models\ProductEvent;
use App\Models\Color;
use App\Models\Settings;
use App\Models\Size;
use Helper, File, Session, Auth;
use Mail;

class CartController extends Controller
{

    public static $loaiSp = [];
    public static $loaiSpArrKey = [];


    /**
    * Session products define array [ id => quantity ]
    *
    */

    public function __construct(){
        // Session::put('products', [
        //     '1' => 2,
        //     '3' => 3
        // ]);
        // Session::put('login', true);
        // Session::put('userId', 1);
        // Session::forget('login');
        // Session::forget('userId');

    }
    public function index(Request $request)
    {
        if(!Session::has('products')) {
            return redirect()->route('home');
        }

        $getlistProduct = Session::get('products');
        $listProductId = array_keys($getlistProduct);
        $arrProductInfo = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();
        $seo['title'] = $seo['description'] = $seo['keywords'] = "Giỏ hàng";
        return view('frontend.cart.index', compact('arrProductInfo', 'getlistProduct', 'seo'));
    }
    public function payment(Request $request){        

        $getlistProduct = Session::get('products');
        if(empty($getlistProduct)){
            return redirect()->route('home');   
        }
        $listProductId = $listKey = $arrProductInfo = [] ;      
        if(!empty($getlistProduct)){
            $listKey = array_keys($getlistProduct);                  
            foreach($listKey as $key){
                $tmp = explode('-', $key);
                $listProductId[] = $tmp[0];
            }            
            $rs = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();        
            foreach($rs as $product){
                $arrProductInfo[$product->id] = $product;
            }
        }else{
            $arrProductInfo = Product::where('id', -1)->get();       
        }
         $colorArr = $sizeArr = [];
        $colorList = Color::orderBy('display_order')->get();      
        $sizeList = Size::orderBy('display_order')->get();    
        foreach($colorList as $color){
            $colorArr[$color->id] = $color;
        }
        foreach($sizeList as $size){
            $sizeArr[$size->id] = $size;
        }        
        $seo['title'] = $seo['description'] = $seo['keywords'] = "Thanh toán";
        $cityList = City::all();
        return view('frontend.cart.payment', compact('arrProductInfo', 'getlistProduct', 'seo', 'cityList', 'colorArr', 'sizeArr', 'listKey'));
    }
    public function shortCart(Request $request)
    {
        $getlistProduct = Session::get('products'); 
        //dd($getlistProduct);
        $listProductId = $listKey = $arrProductInfo = [] ;      
        if(!empty($getlistProduct)){
            $listKey = array_keys($getlistProduct);                  
            foreach($listKey as $key){
                $tmp = explode('-', $key);
                $listProductId[] = $tmp[0];
            }            
            $rs = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();        
            foreach($rs as $product){
                $arrProductInfo[$product->id] = $product;
            }
        }else{
            $arrProductInfo = Product::where('id', -1)->get();       
        }
         $colorArr = $sizeArr = [];
        $colorList = Color::orderBy('display_order')->get();      
        $sizeList = Size::orderBy('display_order')->get();    
        foreach($colorList as $color){
            $colorArr[$color->id] = $color;
        }
        foreach($sizeList as $size){
            $sizeArr[$size->id] = $size;
        }        
      //  dd($arrProductInfo);
        return view('frontend.cart.ajax.short-cart', compact('arrProductInfo', 'getlistProduct', 'listKey', 'colorArr', 'sizeArr'));
    }

    public function update(Request $request)
    {
        $listProduct = Session::get('products');
        if($request->id > 0){
            if($request->quantity) {
                $listProduct[$request->id] = $request->quantity;
            } else {
                unset($listProduct[$request->id]);
            }
            Session::put('products', $listProduct);
        }
        return 'sucess';
    }

    public function addProduct(Request $request)
    {
        $id = $request->id;
        $color_id = $request->color_id;
        $size_id = $request->size_id;
        if($id > 0 && $color_id > 0 && $size_id > 0){
            $listProduct = Session::get('products');
            $key = $id."-".$color_id."-".$size_id;
            if(!empty($listProduct[$key])) {
                $listProduct[$key] += 1;
            } else {
                $listProduct[$key] = 1;
            }

            Session::put('products', $listProduct);
        }

        return 'sucess';
    }        

    public function saveOrder(Request $request)
    {
        $listProductId = [];
        if(!Session::has('products')) {
            return redirect()->route('home');
        }
        $getlistProduct = Session::get('products');        
        $dataArr = $request->all();
        $this->validate($request,[
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',            
            'address' => 'required'
        ],
        [
            'full_name.required' => 'Quý khách chưa nhập họ tên',
            'phone.required' => 'Quý khách chưa nhập điện thoại liên hệ',
            'email.required' => 'Quý khách chưa nhập email',            
            'address.required' => 'Quý khách chưa nhập địa chỉ'
        ]);

        Session::put('payment_info', $dataArr);
        
        //dd($getlistProduct);
        $listProductId = $listKey = $arrProductInfo = [] ;      
        if(!empty($getlistProduct)){
            $listKey = array_keys($getlistProduct);                  
            foreach($listKey as $key){
                $tmp = explode('-', $key);
                $listProductId[] = $tmp[0];
            }            
            $rs = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();        
            foreach($rs as $product){
                $arrProductInfo[$product->id] = $product;
            }
        }else{
            $arrProductInfo = Product::where('id', -1)->get();       
        }
         $colorArr = $sizeArr = [];
        $colorList = Color::orderBy('display_order')->get();      
        $sizeList = Size::orderBy('display_order')->get();    
        foreach($colorList as $color){
            $colorArr[$color->id] = $color;
        }
        foreach($sizeList as $size){
            $sizeArr[$size->id] = $size;
        }        
        
        $seo['title'] = $seo['description'] = $seo['keywords'] = "Chọn phương thức thanh toán";
        return view('frontend.cart.method', compact('arrProductInfo', 'getlistProduct', 'listKey', 'colorArr', 'sizeArr', 'seo'));
        
    }    
    public function save(Request $request){
        $listProductId = [];
        if(!Session::has('products')) {
            return redirect()->route('home');
        }
        $getlistProduct = Session::get('products');        
        $listKey = array_keys($getlistProduct);                  
            foreach($listKey as $key){
                $tmp = explode('-', $key);
                $listProductId[] = $tmp[0];
            }            
        $rs = Product::whereIn('product.id', $listProductId)
                        ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                        ->select('product_img.image_url', 'product.*')->get();        
        foreach($rs as $product){
            $arrProductInfo[$product->id] = $product;
        }
        $dataArr['tong_tien'] = 0;
        $dataArr['tong_sp'] = array_sum($getlistProduct);     
        $info = Session::get('payment_info');
        $dataArr['address']  = $info['address'];
        $dataArr['gender']  = 1;
        $dataArr['full_name']  = $info['full_name'];
        $dataArr['email']  = $email = $info['email'];
        $dataArr['phone']  = $info['phone'];
        $dataArr['notes']  = '';
        $dataArr['address_type']  = 1;       
        $dataArr['method_id'] = $request->method_id;
        foreach ($listKey as $key) {
            $tmp = explode('-', $key);
            $product = $arrProductInfo[$tmp[0]];
            $price = $product->is_sale ? $product->price_sale : $product->price;        
            $dataArr['tong_tien'] += $price * $getlistProduct[$key];
        }

        $dataArr['tien_thanh_toan'] = $dataArr['tong_tien'];

        $rs = Orders::create($dataArr);
        
        $order_id = $rs->id;
        $orderDetail = Orders::find($order_id);
        Session::put('order_id', $order_id);   
       
        foreach ($listKey as $key) {            
            # code...
            $tmp = explode('-', $key);
            $product = $arrProductInfo[$tmp[0]];
            $dataDetail['product_id']        = $product->id;
            $dataDetail['so_luong']     = $getlistProduct[$key];
            $dataDetail['don_gia']      = $product->price;
            $dataDetail['order_id']     = $order_id;
            $dataDetail['color_id']     = $tmp[1];
            $dataDetail['size_id']     = $tmp[2];
            $dataDetail['tong_tien']    = $getlistProduct[$key]*$product->price;

            OrderDetail::create($dataDetail); 
        }
        
        $emailArr = array_merge([$email], ['hoangnhonline@gmail.com']);
        
        // send email
        $order_id =str_pad($order_id, 6, "0", STR_PAD_LEFT);

         $colorArr = $sizeArr = [];
        $colorList = Color::orderBy('display_order')->get();      
        $sizeList = Size::orderBy('display_order')->get();    
        foreach($colorList as $color){
            $colorArr[$color->id] = $color;
        }
        foreach($sizeList as $size){
            $sizeArr[$size->id] = $size;
        }  
<<<<<<< HEAD
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $emailCC = explode(';',$settingArr['email_cc']);

        $emailArr = array_merge($emailCC, [$email]);
=======
        Session::put('products', []);
        Session::flush();
        $emailArr = array_merge(['hoangnhonline@gmail.com'], [$email]);
>>>>>>> e1b02323123a8153c1c6c8656aa92f292683d23f
        if(!empty($emailArr)){
            Mail::send('frontend.email.cart',
                [                    
                    'orderDetail'             => $orderDetail,
                    'arrProductInfo'    => $arrProductInfo,
                    'getlistProduct'    => $getlistProduct,            
                    'method_id' => $dataArr['method_id'],
                    'order_id' => $order_id,
                    'listKey' => $listKey,
                    'colorArr' => $colorArr,
                    'sizeArr' => $sizeArr

                ],
                function($message) use ($emailArr, $order_id) {
                    $message->subject('Xác nhận đơn hàng hàng #'.$order_id);
                    $message->to($emailArr);
                    $message->from('quanjeansnamphuc.com@gmail.com', 'Quần jeans Nam Phúc');
                    $message->sender('quanjeansnamphuc.com@gmail.com', 'Quần jeans Nam Phúc');
            });
        }
<<<<<<< HEAD
        Session::put('products', []);
        Session::flush();
=======

>>>>>>> e1b02323123a8153c1c6c8656aa92f292683d23f
        //return redirect()->route('success');
    }
    public function success(){
        if(!Session::has('products')) {
            return redirect()->route('home');
        }
        $order_id = Session::get('order_id');
        
        $orderDetail = Orders::find($order_id);
        
        $seo['title'] = $seo['description'] = $seo['keywords'] = "Mua hàng thành công";
        Session::put('products', []);
        Session::flush();

        return view('frontend.cart.success', compact('order_id', 'seo', 'orderDetail'));
    }
    public function deleteAll(){
        Session::put('products', []);
        return redirect()->route('home');
    }
}



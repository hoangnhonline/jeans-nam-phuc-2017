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
        $listProductId = array_keys($getlistProduct);
        $arrProductInfo = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();
        $seo['title'] = $seo['description'] = $seo['keywords'] = "Thanh toán";
        $cityList = City::all();
        return view('frontend.cart.payment', compact('arrProductInfo', 'getlistProduct', 'seo', 'cityList'));
    }
    public function shortCart(Request $request)
    {
        $getlistProduct = Session::get('products'); 
        $listProductId = [];      
        if(!empty($getlistProduct)){
            $listKey = array_keys($getlistProduct);        
            foreach($listKey as $key){
                $tmp = explode('-', $key);
                $listProductId[] = $tmp[0];
            }            
            $arrProductInfo = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();        
        }else{
            $arrProductInfo = Product::where('id', -1)->get();       
        }
        
        return view('frontend.cart.ajax.short-cart', compact('arrProductInfo', 'getlistProduct'));
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
        if(!Session::has('products')) {
            return redirect()->route('home');
        }
        $getlistProduct = Session::get('products');
        $listProductId = array_keys($getlistProduct);

        $this->validate($request,[
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'city_id' => 'required',
            'district_id' => 'required',
            'address' => 'required'
        ],
        [
            'full_name.required' => 'Quý khách chưa nhập họ tên',
            'phone.required' => 'Quý khách chưa nhập điện thoại liên hệ',
            'email.required' => 'Quý khách chưa nhập email',
            'city_id.required' => 'Quý khách chưa chọn tỉnh/thành',
            'district_id.required' => 'Quý khách chưa chọn quận/huyện',
            'address.required' => 'Quý khách chưa nhập số nhà - Tên đường '
        ]);
        
        $arrProductInfo = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();
        $dataArr['tong_tien'] = 0;
        $dataArr['tong_sp'] = array_sum($getlistProduct);
        
        $dataArr['district_id'] = $request->district_id;
        $dataArr['city_id']  = $request->city_id;        
        $dataArr['address']  = $request->address;
        $dataArr['gender']  = $request->gender;
        $dataArr['full_name']  = $request->full_name;
        $dataArr['email']  = $email = $request->email;
        $dataArr['phone']  = $request->phone;
        $dataArr['notes']  = $request->notes;
        $dataArr['address_type']  = 1;
        $dataArr['method_id'] = $request->method_id;
        
        foreach ($arrProductInfo as $product) {
            $price = $product->is_sale ? $product->price_sale : $product->price;        
            $dataArr['tong_tien'] += $price * $getlistProduct[$product->id];
        }

        $dataArr['tien_thanh_toan'] = $dataArr['tong_tien'];

        $rs = Orders::create($dataArr);
        
        $order_id = $rs->id;
        $orderDetail = Orders::find($order_id);
        Session::put('order_id', $order_id);   
       
        foreach ($arrProductInfo as $product) {            
            # code...
            $dataDetail['product_id']        = $product->id;
            $dataDetail['so_luong']     = $getlistProduct[$product->id];
            $dataDetail['don_gia']      = $product->price;
            $dataDetail['order_id']     = $order_id;
            $dataDetail['tong_tien']    = $getlistProduct[$product->id]*$product->price;

            OrderDetail::create($dataDetail); 
        }
        
        $emailArr = array_merge([$email], ['hoangnhonline@gmail.com']);
        
        // send email
        $order_id =str_pad($order_id, 6, "0", STR_PAD_LEFT);
        //$emailArr = [];
        if(!empty($emailArr)){
            Mail::send('frontend.email.cart',
                [                    
                    'orderDetail'             => $orderDetail,
                    'arrProductInfo'    => $arrProductInfo,
                    'getlistProduct'    => $getlistProduct,            
                    'method_id' => $dataArr['method_id'],
                    'order_id' => $order_id                    
                ],
                function($message) use ($emailArr, $order_id) {
                    $message->subject('Xác nhận đơn hàng hàng #'.$order_id);
                    $message->to($emailArr);
                    $message->from('annammobile.com@gmail.com', 'annammobile.com');
                    $message->sender('annammobile.com@gmail.com', 'annammobile.com');
            });
        }

        return redirect()->route('success');
        
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


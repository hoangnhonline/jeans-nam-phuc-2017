<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Orders;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use DB;
use Mail;
class OrderController extends Controller
{
    protected $list_status = [
        0 => 'Chờ xử lý',       
        3 => 'Đã hoàn thành',
        4 => 'Đã huỷ'    
      ];

    public function index(Request $request){     
        $s['status'] = $status = isset($request->status) ? $request->status : -1;
        $s['date_from'] = $date_from = isset($request->date_from) && $request->date_from !='' ? $request->date_from : date('d-m-Y');
        $s['date_to'] = $date_to = isset($request->date_to) && $request->date_to !='' ? $request->date_to : date('d-m-Y');
        $s['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';       

        $query = Orders::whereRaw('1');
        if( $status > -1){
            $query->where('status', $status);
        }
        if( $date_from ){
            $dateFromFormat = date('Y-m-d', strtotime($date_from));
            $query->whereRaw("DATE(created_at) >= '".$dateFromFormat."'");
        }
        if( $date_to ){
            $dateToFormat = date('Y-m-d', strtotime($date_to));
            $query->whereRaw("DATE(created_at) <= '".$dateToFormat."'");
        }
        if( $name != '' ){            
            $query->whereRaw(" ( email LIKE '%".$name."%' ) OR ( full_name LIKE '%".$name."%' )");
        }
        $orders = $query->orderBy('orders.id', 'DESC')->paginate(20);
        $list_status = $this->list_status;
       
        return view('backend.order.index', compact('orders', 'list_status','s'));
    }


    public function orderDetail(Request $request, $order_id)
    {
        $order = Orders::find($order_id);
        $order_detail = OrderDetail::where('order_id', $order_id)->get();
        $list_status = $this->list_status;
        $s['status'] = $request->status;
        $s['name'] = $request->name;
        $s['date_from'] = $request->date_from;
        $s['date_to'] = $request->date_to;
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
       
        return view('backend.order.detail', compact('order', 'order_detail', 'list_status', 's'. 'colorArr', 'sizeArr'));
    }

    public function orderDetailDelete(Request $request)
    {
        $order_id = $request->order_id;
        $order_detail_id = $request->order_detail_id;

        $order = Orders::find($order_id);
        $order_detail = OrderDetail::find($order_detail_id);

        $order->tien_thanh_toan -= $order_detail->tong_tien;
        $order->tong_tien       -= $order_detail->tong_tien;
        $order->save();

        OrderDetail::destroy($order_detail_id);
        return 'success';
    }

    public function update(Request $request){
        $status_id   = $request->status_id;
        $order_id    = $request->order_id;
        $customer_id = $request->customer_id;

        Orders::where('id', $order_id)->update([
            'status' => $status_id
        ]);
        //get customer to send mail
        $customer = Customer::find($customer_id);
        $order = Orders::find($order_id);
       
        switch ($status_id) {
            case "1":
               
                break;
            case "3":
                $orderDetail = OrderDetail::where('order_id', $order_id)->get();
                foreach($orderDetail as $detail){
                    $product_id = $detail->product_id;                    
                    $so_luong = $detail->so_luong;
                    $modelProduct = Product::find($product_id);
                    $so_luong_ton =  $modelProduct->so_luong_ton - $so_luong;
                    $so_luong_ton  = $so_luong_ton > 0 ? $so_luong_ton : 0;
                    $modelProduct->update(['so_luong_ton' => $so_luong_ton]);
                }               
                break;            
            case "4":

                break;
            default:

                break;
        }
      
        return 'success';
    }
}

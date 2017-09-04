@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="block block_breadcrumb">
  <ol class="breadcrumb">
    <li><a href="{!! route('home') !!}" title="Trang chủ">Trang chủ</a></li>
    <li class="active">Đặt hàng thành công</li>
  </ol>
</div><!-- /block_breadcrumb -->
<div class="block block_after-payment">
  <img src="{{ URL::asset('assets/images/ops-blk.jpg') }}" alt="Mua hang thanh cong">
  <div class="a-payment-ct">
    <div class="a-payment-w">
      <h1 class="main-msg">CẢM ƠN QUÝ KHÁCH ĐÃ ĐẶT HÀNG!</h1>
      <p><b><i>Annammobile sẽ gọi cho {!! $orderDetail->gender == 1  ? "Anh" : "Chị" !!} <strong>{!! $orderDetail->full_name !!}</strong>, số điện thoại <strong>{!! $orderDetail->phone !!}</strong> ngay khi có thể để xác nhận đơn hàng.</i></b></p>
      <p>
      <b>Địa chỉ giao hàng:</b> <br>
       {!! $orderDetail->address !!}, {!! $orderDetail->district->name !!}, {!! $orderDetail->city->name !!}                                                                  
                                            </p>
      <p>
      <b>Cần hỗ trợ tư vấn vui lòng gọi: 0904500057</b>
      </p>
    </div>  
  </div>
</div><!-- /block_after -->
@endsection
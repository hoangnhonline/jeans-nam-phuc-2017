@extends('frontend.layout')
@include('frontend.partials.meta')  
@section('content')
<?php $total = 0; ?>
<div class="block_pre_checkout">
	<h2 class="checkout-title" id="myModalLabel">
		ĐƠN HÀNG CỦA TÔI
		<span>(Đang có <strong class="order_total_quantity">{!! Session::get('products') ? array_sum(Session::get('products')) : 0 !!}</strong> sản phẩm)</span>
		<span><a class="empty_cart" onclick="return confirm('Quý khách có chắc chắn bỏ hết hàng ra khỏi giỏ?'); " href="{{ route('empty-cart') }}"><i class="fa fa-remove"></i>Làm trống giỏ hàng</a></span>
	</h2><!-- /checkout-title -->
	<div class="block shopcart-ct" id="cart-content">		
		<div class="cart-box row">
			<div class="col-md-8">
				<form action="#" method="POST" id="frm_order_items">
					<div class="table cart-tbl">
							<div class="table-row thead">
								<div class="table-cell no-col">&nbsp;</div>
								<div class="table-cell product-col">Sản phẩm</div>
								<div class="table-cell price-col t-r">Đơn giá (đ)</div>
								<div class="table-cell numb-col t-c">Số lượng</div>
								<div class="table-cell total-col t-r">Thành tiền (đ)</div>
							</div><!-- /table-row -->
							@if( $arrProductInfo->count() > 0)
							<?php $i = 0; ?>
		                  @foreach($arrProductInfo as $product)
		                  <?php $i++; ?>
		                  <?php $price = $product->is_sale ? $product->price_sale : $product->price; ?>
							<div class="tr-wrap">
								<div class="table-row clearfix">
									<div class="table-cell no-col"><span>{!! $i !!}</span></div><!-- /table-cell no-col -->
									<div class="table-cell product-col">
										<figure class="img-prod">
											<img alt="{!! $product->name !!}" src="{{ Helper::showImage($product['image_url']) }}">
										</figure>
										<a href="{{ route('product-detail', [$product->slug, $product->id]) }}" target="_blank" title="{!! $product->name !!}">{!! $product->name !!}</a>
										<a href="javascript:void(0)" onclick="return confirm('Quý khách chắc chắn muốn xóa sản phẩm này?'); " title="Xóa" data-id="{{ $product->id }}" class="del_item_list">Xóa</a>
									</div><!-- /table-cell product-col -->
									<div class="table-cell price-col t-r">{!! number_format($price) !!}</div><!-- /table-cell price-col t-r -->
									<div class="table-cell numb-col t-c">
										<select data-id="{{$product->id}}" class="change_quantity_payment form-control">
											<?php 
										$soluongton = DB::table('product')->where('id', $product->id)->first()->so_luong_ton;
										?>
											@for($i = 1; $i <= $soluongton; $i++ )
				                            <option value="{{$i}}"
				                            @if ($i == $getlistProduct[$product->id])
				                              selected
				                            @endif
				                            > {{$i}}
				                              @if($i == 50) + @endif
				                            </option>
				                            @endfor
										</select> 
									</div><!-- /table-cell numb-col t-c -->
									<?php 
									$total += $total_per_product = ($getlistProduct[$product->id]*$price);
									?>
									<div class="table-cell total-col t-r">{{ number_format($total_per_product)  }}</div><!-- /table-cell total-col t-r -->
								</div>									
							</div><!-- /tr-wrap -->
							@endforeach
							@endif

						</div><!-- /table cart-tbl -->
					
				</form>
			</div>
			<div class="col-md-4">
				<div class="checkout-box-col">
					<table class="total-tbl f-r">
							<tbody>
								<tr>
					                <td>Tổng tiền hàng:</td>
					                <td class="t-r">{!! number_format($total) !!} đ&nbsp;</td>
					            </tr>
					            <tr>
					                <td>Phí vận chuyển:</td>
					                <td class="t-r">
					                    <span class="ship_fee">0</span> đ
					                    <br>
					                </td>
					            </tr>						           
					            <tr class="all-total">
					                <td>Tổng số tiền:</td>
					                <td class="totalmn t-r">{!! number_format($total) !!} đ</td>
					            </tr>
					            @if( $arrProductInfo->count() > 0)
					            <tr>
					                <td colspan="2" class="t-r">
					                    Đã bao gồm VAT						                    
					                </td>
					            </tr>                    
					            @endif
					        </tbody>
						</table>						
				</div>
			</div>
		</div>
	</div><!-- /shopcart-ct -->
	<div class="block_checkout-frm">
		@if (count($errors) > 0)
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      	@endif
		<form action="{{ route('save-order') }}" method="POST"  id="frm_order">
			<div class="msg-mn">Vui lòng điền thông tin đơn hàng này !</div>
			<div class="block row">
				<div class="block_customer-frm col-md-8">
					<div class="block_buy-frm">
						<p class="legend">Thông tin Quý Khách</p>
						<div class="filter-group">
							<div class="row-group clearfix">
								<div class="group-radio">
								<?php 
								$gender = old('gender', 1);
								$method_id = old('method_id', 1);
								?>
									<div class="radio-1">
                                        <input type="radio" name="gender" id="gender-1" class="gender" value="1" {!! $gender == 1 ? "checked=checked" : "" !!}>
                                        <label for="gender-male">Anh</label>
                                    </div>
                                    <div class="radio-1">
                                        <input type="radio" name="gender" id="gender-2" class="gender" value="2" {!! $gender == 2 ? "checked=checked" : "" !!}>
                                        <label for="gender-female">Chị</label>
                                    </div>
								</div>
								<input type="text" name="full_name" id="full_name" value="{!! old('full_name') !!}" placeholder="Họ và tên" class="fullname ip_precheck">
							</div><!-- /row-group -->
							<div class="row-group">
								<input type="text" name="phone" id="phone" value="{!! old('phone') !!}" placeholder="Điện thoại liên hệ" class="phone ip_precheck">
							</div><!-- /row-group -->
							<div class="row-group">
                                <input type="email" name="email" id="email" value="{!! old('email') !!}" placeholder="Email (cần nhập email để nhận được thông tin đơn hàng từ Ân Nam)" class="email ip_precheck">
                            </div><!-- /row-group -->
                            <div class="row-group clearfix">
                            	<label class="titaddress"><i class="fa fa-location-arrow"></i>Địa chỉ, thời gian GIAO HÀNG NHANH</label>
                            	<div class="add_info row">
                            		<p class="col-sm-6 col-xs-6 city">
                                		<select class="ip_precheck sl-2" data-width="100%" name="city_id" id="city_id">
										 	<option value="">Chọn Tỉnh/Thành phố</option>
			                                @foreach($cityList as $city)
			                                  <option value="{{ $city->id }}" {{ old('district_id') == $city->id  ? "selected=selected" : "" }}                                  
			                                  >{!! $city->name !!}</option>
			                                @endforeach
										</select>
                                	</p>
                                	<p class="col-sm-6 col-xs-6 district">
                                		<select class="ip_precheck sl-2" data-width="100%" name="district_id" id="district_id">
										 	<option value="" selected>Chọn Quận/Huyện</option>											
										</select>
                                	</p>
                            	</div>
                            </div><!-- /row-group -->
                            <div class="row-group">
                            	<input type="text" name="address" id="address" value="{!! old('address') !!}" placeholder="Số nhà - Tên đường" class="ip_precheck address">
                            </div><!-- /row-group -->
                            <div class="row-group">
                            	<textarea name="notes" id="notes" placeholder="Ghi chú khi giao hàng (vd: ngày, giờ giao hàng)" class="ip_precheck comment">{!! old('notes') !!}</textarea>
                            </div><!-- /row-group -->
						</div>
					</div><!-- /block_buy-frm -->
				</div><!-- /block_customer-frm -->
				<div class="block_popup-buyfrm col-md-4">
					<div class="info-payment">
						<label class="titaddress"><i class="fa fa-money"></i>Hình thức thanh toán</label>
						<div class="item-group cod-row">
                            <input id="method_id2" type="radio" name="method_id" value="1" {!! $method_id == 1 ? "checked=checked" : "" !!}>
                            <label for="method_id2" class="lbl-rado">COD - Nhận hàng trả tiền</label>
                        </div> 
						<div class="item-group">
							<input id="method_id1" type="radio" name="method_id" value="2" {!! $gender == 2 ? "checked=checked" : "" !!}>
							<label for="method_id1" class="lbl-rado">Chuyển khoản ngân hàng</label>
						</div>					
                                               
					</div>					
				</div><!-- /block_popup-buyform -->
			</div>
			<div class="row block customer-frm">
                <div class="col-md-6 col-sm-6 checkout-wrap">
                    <input type="submit" name="" id="btnPayment" value="XÁC NHẬN ĐẶT HÀNG" class="btn-red sbm-checkout">
                    <button type="button" class="btn btn-danger" id="btnLoading" disabled="disabled" style="display:none;width:145px"><i class="fa fa-spin fa-spinner"></i></button>
                </div>
                {{ csrf_field() }}
                <!--<div class="col-md-6 col-sm-6 callme-wrap">
                    <a href="javascript:;" id="callMe" class="btn btn-wht callme-now">PHỨC TẠP QUÁ!<span>GỌI LẠI CHO TÔI</span></a>
                </div>-->
            </div>
		</form>
	</div><!-- /block_checkout-frm -->
</div>
<style type="text/css">
	.pre_checkout .cart-link{
		display: block !important;
	}
</style>
@stop
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		if( $('#city_id').val() > 0){
	        getDistrict($('#city_id').val());
	      }
	      $('#city_id').change(function(){
	      	getDistrict($(this).val());
	      });	  
	      $('#btnPayment').click(function(){
	      	$(this).hide();
	      	$('#btnLoading').show();
	      	//$(this).attr('disabled', 'disabled').val('<i class="fa fa-spin fa-spinner"></i>');
	      });    
	});
	function validateEmail(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
  }
  function getDistrict(city_id) {

    if(!city_id) {
      $('#district_id').empty();
      $('#district_id').append('<option value="0">Chọn Quận/Huyện</option>');
      return;
    }

    $.ajax({
      url: "{{ route('get-district') }}",
      method: "POST",
      data : {
        id: city_id
      },
      success : function(list_district){
        $('#district_id').empty();
        $('#district_id').append('<option value="0">Chọn Quận/Huyện</option>');

        for(i in list_district) {
          $('#district_id').append('<option value="' + list_district[i].id + '">' + list_district[i].name + '</option>');
        }
        
      }
    });
  }
</script>
@stop
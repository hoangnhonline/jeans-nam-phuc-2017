@extends('frontend.layout')
@include('frontend.partials.meta')  
@section('content')
<?php 
$total = 0;
?>
<div class="block block-breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="#">Trang chủ</a></li>
			<li><a href="#">Giỏ hàng</a></li>
			<li class="active">Thông tin thanh toán</li>
		</ul>
	</div>
</div><!-- /block-breadcrumb -->
<div class="block block-two-col container">
	<div class="block-page-common">
		<div class="block block-title">
			<h2>
				<i class="fa fa-cart-arrow-down"></i>
				THÔNG TIN THANH TOÁN
			</h2>
		</div>
	</div><!-- /block-page-common -->
	<div class="row">
		<div class="col-sm-8 col-xs-12 block-col-left">
			<div class="block-billing">
				<div class="block-title">
					THÔNG TIN ĐẶT HÀNG
				</div>
				<div class="block-content">
					<form action="billing-infomation_submit" method="get" class="form-billing">
						<div class="form-group">
							<span class="input-addon"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control" id="inputname" placeholder="Họ và tên">
						</div>
						<div class="form-group">
							<span class="input-addon"><i class="fa fa-envelope"></i></span>
							<input type="text" class="form-control" id="inputmail" placeholder="Email">
						</div>
						<div class="form-group">
							<span class="input-addon"><i class="fa fa-phone"></i></span>
							<input type="text" class="form-control" id="inputphone" placeholder="Số điện thoại">
						</div>
						<div class="form-group">
							<span class="input-addon"><i class="fa fa-home"></i></span>
							<input type="text" class="form-control" id="inputaddress" placeholder="Địa chỉ">
						</div>
						<div class="form-group">
							<label class="choose-another"><input type="radio" class="radio-cus"> Giao đến địa chỉ khác</label>
						</div>
						<div class="form-group">
							<b>Thông tin người nhận</b>
						</div>
						<div class="form-group">
							<span class="input-addon"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control" id="inputname" placeholder="Họ và tên">
						</div>
						<div class="form-group">
							<span class="input-addon"><i class="fa fa-envelope"></i></span>
							<input type="text" class="form-control" id="inputmail" placeholder="Email">
						</div>
						<div class="form-group">
							<span class="input-addon"><i class="fa fa-phone"></i></span>
							<input type="text" class="form-control" id="inputphone" placeholder="Số điện thoại">
						</div>
						<div class="form-group">
							<span class="input-addon"><i class="fa fa-home"></i></span>
							<input type="text" class="form-control" id="inputaddress" placeholder="Địa chỉ">
						</div>
						<div class="text-center">
							<a href="payments.html" class="btn btn-danger">
								Tiếp tục <i class="fa fa-angle-right"></i>
							</a>
						</div>
					</form>
				</div>
			</div><!-- /block-billing -->
		</div><!-- /block-col-left -->
		<div class="col-sm-4 col-xs-12 block-col-right">
			<div class="block-billing-product">
				<div class="block-title">
					THÔNG TIN SẢN PHẨM
				</div>
				<div class="block-content">
					<table class="table-billing-product">
						<thead>
							<tr>
								<th class="table-width"><strong>Sản phẩm</strong></th>
								<th><strong>Tổng cộng</strong></th>
							</tr>
						</thead>
						<tbody>
							@if( $arrProductInfo->count() > 0)
								<?php $i = 0; ?>
			                  @foreach($arrProductInfo as $product)
			                  <?php $i++; ?>
			                  <?php $price = $product->is_sale ? $product->price_sale : $product->price; ?>
							<tr>
								<td>
									<p class="tb-commom"><a href="{{ route('product-detail', [$product->slug, $product->id]) }}" target="_blank" title="{!! $product->name !!}">{!! $product->name !!}</a></p>
									<p class="tb-commom">Số lượng: x {{ $getlistProduct[$product->id] }}</p>
									<p class="tb-commom">
										Màu sắc sản phẩm:
										<span class="tb-img"><img src="images/color/000.jpg" alt=""></span>
									</p>
									<p class="tb-commom">Size sản phẩm: <span class="tb-commom1">29</span></p>
									</p>
								</td>
								<?php 
								$total += $total_per_product = ($getlistProduct[$product->id]*$price);
								?>
								<td>
									<strong class="text-right">{{ number_format($total_per_product)  }}đ</strong>
								</td>
							</tr>
							
							@endforeach
							@endif
							<tr>
								<td>
									<strong>Tổng cộng</strong>
								</td>
								<td>
									<p class="cl-red text-right">{{ number_format($total)  }}đ</p>
								</td>
							</tr>
							<tr>
								<td colspan="2" class="text-center">
									(Chưa bao gồm phí vận chuyển nếu có)
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div><!-- /block-col-right -->
	</div>
</div><!-- /block_big-title -->

@stop
@section('js')
<script type="text/javascript">
	$(document).ready(function(){		  
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
</script>
@stop
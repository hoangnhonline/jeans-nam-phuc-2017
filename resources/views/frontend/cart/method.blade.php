@extends('frontend.layout')
@include('frontend.partials.meta')  
@section('content')
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
									<label class="choose-another"><input type="radio" class="radio-cus" name="method_id" checked="checked" value="1"> Chuyển khoản ngân hàng</label>
								</div>
								<div class="form-group">
									<div class="content">
									<div class="form-group">
										<div class="thumb">
											<img src="{{ URL::asset('public/assets/images/payments/VIB.jpg') }}" alt="">
										</div>
										<div class="des">
											<p class="title">Ngân hàng thươnag mại cổ phần Á Châu - Chi nhánh Thủ Đức</p>
											<p class="info">
												It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English
											</p>
										</div>
									</div>
									<div class="form-group">
										<div class="thumb">
											<img src="{{ URL::asset('public/assets/images/payments/TCB.jpg') }}" alt="">
										</div>
										<div class="des">
											<p class="title">Ngân hàng thươnag mại cổ phần Á Châu - Chi nhánh Thủ Đức</p>
											<p class="info">
												It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English
											</p>
										</div>
									</div>
									<div class="form-group">
										<div class="thumb">
											<img src="{{ URL::asset('public/assets/images/payments/ACB.jpg') }}" alt="">
										</div>
										<div class="des">
											<p class="title">Ngân hàng thươnag mại cổ phần Á Châu - Chi nhánh Thủ Đức</p>
											<p class="info">
												It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English
											</p>
										</div>
									</div>
									<div class="form-group">
										<div class="thumb">
											<img src="{{ URL::asset('public/assets/images/payments/VCB.jpg') }}" alt="">
										</div>
										<div class="des">
											<p class="title">Ngân hàng thươnag mại cổ phần Á Châu - Chi nhánh Thủ Đức</p>
											<p class="info">
												It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English
											</p>
										</div>
									</div>
									</div>
								</div>
								<div class="form-group">
									<label class="choose-another"><input type="radio" class="radio-cus" name="method_id" value="2"> Thanh toán bằng tiền mặt</label>
								</div>
								<div class="form-group text-center">
									<a href="#" title="Quay Lại" class="btn btn-default"><i class="fa fa-angle-left"></i> Quay Lại</a>
									<button id="btnFinish" type="button" class="btn btn-danger">Đặt hàng <i class="fa fa-angle-right"></i></button>
								</div>
							</form>
						</div>
					</div><!-- /block-billing -->
				</div><!-- /block-col-left -->
				<div class="col-sm-4 col-xs-12 block-col-right">
					<div class="block block-billing-product block-info-address">
						<div class="block-title">
							ĐỊA CHỈ GIAO HÀNG / THANH TOÁN
						</div>
						<?php 
						$info = Session::get('payment_info');						
						?>
						<div class="block-content">
							<p>
								<span class="title">Họ và tên:</span>
								<span class="info">{{ $info['full_name'] }}</span>
							</p>
							<p>
								<span class="title">Địa chỉ:</span>
								<span class="info">{{ $info['address'] }}</span>
							</p>
							<p>
								<span class="title">Điện thoại di động:</span>
								<span class="info">{{ $info['phone'] }}</span>
							</p>
							<p>
								<span class="title">Email:</span>
								<span class="info">{{ $info['email'] }}</span>
							</p>
							<p>
								<span class="title">Ngày đặt hàng:</span>
								<span class="info">{{ date('d/M/Y', time()) }}</span>
							</p>
						</div>
					</div>
					<div class="block-billing-product">
						<div class="block-title">
							THÔNG TIN SẢN PHẨM
						</div>
						<div class="block-content">
						<?php $total = 0; ?>
							<table class="table-billing-product">
								<thead>
									<tr>
										<th class="table-width"><strong>Sản phẩm</strong></th>
										<th><strong>Tổng cộng</strong></th>
									</tr>
								</thead>
								<tbody>
									@if( !empty($listKey) )
									<?php $i = 0; ?>
									@foreach($listKey as $key)
					                  <?php $i++; 
					                  $tmp = explode('-', $key);
										$product_id = $tmp[0];
										$product = $arrProductInfo[$product_id];
					                  ?>
					                  <?php $price = $product->is_sale ? $product->price_sale : $product->price; ?>
									<tr>
										<td>
											<p class="tb-commom"><a href="{{ route('product-detail', [$product->slug]) }}" target="_blank" title="{!! $product->name !!}">{!! $product->name !!}</a></p>
											<p class="tb-commom">Số lượng: x {{ $getlistProduct[$key] }}</p>
											<p class="tb-commom">
												Màu sắc sản phẩm:
												<span class="tb-img"><img src="{{ Helper::showImage($colorArr[$tmp[1]]->image_url ) }}" alt="{{ ($colorArr[$tmp[1]]->name ) }}" width="20"></span>
											</p>
											<p class="tb-commom">Size sản phẩm: <span class="tb-commom1">{{ $sizeArr[$tmp[2]]->name }}</span></p>
											</p>
										</td>
										<?php 
										$total += $total_per_product = ($getlistProduct[$key]*$price);
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
		<div class="modal fade" id="Confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fa fa-times-circle"></i>
					</button>
					<div class="modal-header">
						ĐƠN HÀNG CỦA BẠN ĐÃ ĐẶT THÀNH CÔNG
					</div>
					<div class="modal-body">
						{!! $settingArr['thong_bao_thanh_cong'] !!}
						<div class="text-right">
							<a href="{{ route('home') }}" title="Trở về trang chủ" class="btn btn-danger"> Trở về trang chủ</a>
						</div>
					</div>
				</div>
			</div>
		</div>
@stop
@section('js')
<script type="text/javascript">
	$('document').ready(function(){
		$('#btnFinish').click(function(){
			$(this).html('<i class="fa fa-spin fa-spinner"></i>');
			$.ajax({
				url : "{{ route('save-final') }}",
				type : 'POST',
				data : {
					method_id : $('input[name=method_id]:checked').val()
				},
				success: function(){
					$('#Confirm').modal('show');
					setTimeout(function(){
						location.href="{{ route('home') }}";
					}, 5000);
				}
			});
		});
	});

</script>
@stop
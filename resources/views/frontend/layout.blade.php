<!DOCTYPE html>
<!--[if lt IE 7 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie9 lte9"><![endif]-->
<!--[if IE 10 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie10 lte10"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="vn">
<head>
	<title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="content-language" content="vi"/>
    <meta name="description" content="@yield('site_description')"/>
    <meta name="keywords" content="@yield('site_keywords')"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
    <meta name="google-site-verification" content="IFz-d9V8jZLB1iDG8BfKsKwhPB-FkpsacHLqk5Mpyzk" />
    <meta name="wot-verification" content="b5ae556432dab929c4bb"/>
    <meta property="article:author" content="https://www.facebook.com/quanjeansnamphuc"/>
    <link rel="shortcut icon" href="@yield('favicon')" type="image/x-icon"/>
    <link rel="canonical" href="{{ url()->current() }}"/>        
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('site_description')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="quanjeansnamphuc" />
    <?php $socialImage = isset($socialImage) ? $socialImage : $settingArr['banner']; ?>
    <meta property="og:image" content="{{ Helper::showImage($socialImage) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="@yield('site_description')" />
    <meta name="twitter:title" content="@yield('title')" />     
    <meta name="twitter:image" content="{{ Helper::showImage($socialImage) }}" />
	<link rel="icon" href="{{ URL::asset('assets/images/favicon.ico') }}" type="image/x-icon">

	<!-- ===== Style CSS ===== -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/css/style.css') }}">
	<!-- ===== Responsive CSS ===== -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/css/responsive.css') }}">

  	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<link href='{{ URL::asset('public/assets/css/animations-ie-fix.css') }}' rel='stylesheet'>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10&appId=567408173358902";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>

	@include('frontend.partials.header')

	<div class="wrapper">	
		
		

		@yield('content')
		

	</div><!-- /wrapper-->

	@include('frontend.partials.footer')
	

	<a id="return-to-top" class="td-scroll-up" href="javascript:void(0)">
  		<i class="fa fa-angle-up" aria-hidden="true"></i>
	</a><!-- return to top -->
	<div id="editContentModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Cập nhật nội dung</h4>
	      </div>
	      <form method="POST" action="{{ route('save-content') }}">
	      {{ csrf_field() }}
	      <input type="hidden" name="id" id="txtId" value="">
	      <div class="modal-body">
	        <textarea rows="5" class="form-control" name="content" id="txtContent"></textarea>
	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary" id="btnSaveContent">Save</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	      </form>
	    </div>

	  </div>
	</div>
	<!-- Modal Cart -->
	<div class="modal fade" id="scart_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i class="fa fa-times-circle"></i>
				</button>
				<div class="shopcart-ct" id="short-cart-content" >
					
				</div><!--id="short-cart-content"-->
			</div>
		</div>
	</div>
	<input type="hidden" id="route-add-to-cart" value="{{ route('add-product') }}" />
	<input type="hidden" id="route-payment" value="{{ route('payment') }}" />
	<input type="hidden" id="route-short-cart" value="{{ route('short-cart') }}" />
	<input type="hidden" id="route-update-product" value="{{ route('update-product') }}" />
	<!-- ===== JS ===== -->
	<script src="{{ URL::asset('public/assets/js/jquery.min.js') }}"></script>
	<!-- ===== JS Bootstrap ===== -->
	<script src="{{ URL::asset('public/assets/lib/bootstrap/bootstrap.min.js') }}"></script>
	<!-- carousel -->
	<script src="{{ URL::asset('public/assets/lib/carousel/owl.carousel.min.js') }}"></script>
	<!-- sticky -->
    <script src="{{ URL::asset('public/assets/lib/sticky/jquery.sticky.js') }}"></script>
    <!-- Js Common -->
	<script src="{{ URL::asset('public/assets/js/common.js') }}"></script>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59b215c2a2658a8a"></script> 	
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	@yield('js')
	<script type="text/javascript">
		$(document).ready(function(){
			$.ajaxSetup({
			      headers: {
			          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			      }
			  });

			$('.edit').click(function(){
				$('#txtId').val($(this).data('text'));
				$('#txtContent').val($(this).html());
				$('#editContentModal').modal('show');
			});
			$('#btnSaveContent').click(function(){
				$.ajax({
					url : '{{ route('save-content') }}',
					type : "POST",
					data : {
						id : $('#txtId').val(),
						content : $('#txtContent').val()
					},
					success:  function(){
						window.location.reload();
					}

				});
			});
			 $('.cart-link').click(function() {
		        $.ajax({
		            url: $('#route-short-cart').val(),
		            method: "GET",

		            success: function(data) {
		                $('#short-cart-content').html(data);
		                $('#scart_popup').modal('show');
		                calTotalProduct();
		            }
		        });
		    });
			 $('.btn-checkout').click(function() {
		        $('form#shopping-cart').submit();
		    });


		    $(document).on('change', '.change_quantity', function() {
		        var quantity = $(this).val();
		        var id = $(this).data('id');
		        update_product_quantity(id, quantity, 'ajax');
		    });
		    $(document).on('change', '.change_quantity_payment', function() {
		        var quantity = $(this).val();
		        var id = $(this).data('id');
		        update_product_quantity(id, quantity, 'normal');
		    });


		    $(document).on('click', '.del_item', function() {
		        var id = $(this).data('id');
		        $(this).parents('.tr-wrap').remove();
		        update_product_quantity(id, 0, 'ajax');
		    });
		    $(document).on('click', '.del_item_list', function() {
		        var id = $(this).data('id');
		        $(this).parents('.tr-wrap').remove();
		        update_product_quantity(id, 0, 'list');
		    });

		    $(document).on('click', '.keep-buying', function() {
		        $('#scart_popup').modal('hide');
		    });

			

		});
		function calTotalProduct() {
		    var total = 0;
		    $('.change_quantity ').each(function() {
		        total += parseInt($(this).val());
		    });
		    $('.order_total_quantity').html(total);
		}

		function update_product_quantity(id, quantity, type) {
		    $.ajax({
		        url: $('#route-update-product').val(),
		        method: "POST",
		        data: {
		            id: id,
		            quantity: quantity
		        },
		        success: function(data) {
		            $.ajax({
		                url: $('#route-short-cart').val(),
		                method: "GET",

		                success: function(data) {
		                    if (type == 'ajax') {
		                        $('#short-cart-content').html(data);
		                        calTotalProduct();
		                    } else {
		                        window.location.reload();
		                    }
		                }
		            });
		        }
		    });
		}
	</script>
	
</body>
</html>
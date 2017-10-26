<footer class="footer">
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-xs-12 ft-info">					
						<address>
							{!! $settingArr['thong_tin_cong_ty'] !!}
						</address>
						<div class="block-statistics">
							<p><span>Truy cập hôm nay:</span> {{ number_format(Helper::view(1, 3, 1)) }}</p>							
							<p><span>Tổng lượt truy cập:</span> {{ number_format(Helper::view(1, 3)) }}</p>
						
						</div>
					</div>

					<div class="col-sm-6 col-xs-12 ft-map">
						<?php 
					if($settingArr['maps'] != ''){
					$str_maps = $settingArr['maps'];
		            $tmp = explode('src="', $str_maps);
		            $tmp2 = explode('"', $tmp[1]);		            
					?>
						<object data="{{ $tmp2[0] }}"></object>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-bot">
			<div class="container">
				<p class="text-center"><i>2017 Designed by iWeb247.vn</i></p>
				<a href="#" title="" class="chat">
					<i class="fa fa-comments"></i> Chat tư vấn
				</a>
			</div>
		</div><!-- /footer-bot-->
	</footer><!-- footer -->
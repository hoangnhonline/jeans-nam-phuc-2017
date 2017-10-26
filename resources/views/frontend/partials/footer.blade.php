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
						<object data="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.3340475200366!2d106.66105631546826!3d10.785706992315221!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ece0a7bad71%3A0x5fded1d58e5866d9!2zMTA0IELhuq9jIEjhuqNpLCBwaMaw4budbmcgNywgVMOibiBCw6xuaCwgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1503933127779"></object>
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
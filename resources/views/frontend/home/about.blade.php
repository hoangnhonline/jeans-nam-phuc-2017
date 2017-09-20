<div class="block-title-cm block-about">
	<div class="container">
		<div class="block-title">
			<h2 data-text="1" @if($isEdit) class="edit" @endif>{!! $textList[1] !!}</h2>
			<div class="desc">
				<p data-text="2" @if($isEdit) class="edit" @endif>{!! $textList[2] !!}</p>				
			</div>
		</div>
		<div class="block-content">
			<div class="row">
				<div class="col-sm-6">
					<div class="item">
						<div class="img"><img src="{{ URL::asset('public/assets/images/increasing.png') }}" alt=""></div>
						<div class="des">
							<h3 class="title @if($isEdit) edit @endif" data-text="3">{!! $textList[3] !!}</h3>
							<div class="description @if($isEdit) edit @endif" data-text="4">{!! $textList[4] !!}</div>
						</div>
					</div>
				</div><!-- /item -->
				<div class="col-sm-6">
					<div class="item">
						<div class="img"><img src="{{ URL::asset('public/assets/images/analytics.png') }}" alt=""></div>
						<div class="des">
							<h3 class="title @if($isEdit) edit @endif" data-text="5">{!! $textList[5] !!}</h3>
							<div class="description @if($isEdit) edit @endif" data-text="6">{!! $textList[6] !!}</div>
						</div>
					</div>
				</div><!-- /item -->
				<div class="col-sm-6">
					<div class="item">
						<div class="img"><img src="{{ URL::asset('public/assets/images/goal.png') }}" alt=""></div>
						<div class="des">
							<h3 class="title @if($isEdit) edit @endif" data-text="7">{!! $textList[7] !!}</h3>
							<div class="description @if($isEdit) edit @endif" data-text="8">{!! $textList[8] !!}</div>
						</div>
					</div>
				</div><!-- /item -->
				<div class="col-sm-6">
					<div class="item">
						<div class="img"><img src="{{ URL::asset('public/assets/images/motivation.png') }}" alt=""></div>
						<div class="des">
							<h3 class="title @if($isEdit) edit @endif" data-text="9">{!! $textList[9] !!}</h3>
							<div class="description @if($isEdit) edit @endif" data-text="10">{!! $textList[10] !!}</div>
					</div>
					</div>
				</div><!-- /item -->
			</div>
		</div>
	</div>
	</div><!-- /block_big-title -->

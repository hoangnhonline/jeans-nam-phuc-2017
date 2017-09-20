<div class="block-title-cm block-about">
	<div class="container">
		<div class="block-title">
			<h2 data-text="1" <?php if($isEdit): ?> class="edit" <?php endif; ?>><?php echo $textList[1]; ?></h2>
			<div class="desc">
				<p data-text="2" <?php if($isEdit): ?> class="edit" <?php endif; ?>><?php echo $textList[2]; ?></p>				
			</div>
		</div>
		<div class="block-content">
			<div class="row">
				<div class="col-sm-6">
					<div class="item">
						<div class="img"><img src="<?php echo e(URL::asset('public/assets/images/increasing.png')); ?>" alt=""></div>
						<div class="des">
							<h3 class="title <?php if($isEdit): ?> edit <?php endif; ?>" data-text="3"><?php echo $textList[3]; ?></h3>
							<div class="description <?php if($isEdit): ?> edit <?php endif; ?>" data-text="4"><?php echo $textList[4]; ?></div>
						</div>
					</div>
				</div><!-- /item -->
				<div class="col-sm-6">
					<div class="item">
						<div class="img"><img src="<?php echo e(URL::asset('public/assets/images/analytics.png')); ?>" alt=""></div>
						<div class="des">
							<h3 class="title <?php if($isEdit): ?> edit <?php endif; ?>" data-text="5"><?php echo $textList[5]; ?></h3>
							<div class="description <?php if($isEdit): ?> edit <?php endif; ?>" data-text="6"><?php echo $textList[6]; ?></div>
						</div>
					</div>
				</div><!-- /item -->
				<div class="col-sm-6">
					<div class="item">
						<div class="img"><img src="<?php echo e(URL::asset('public/assets/images/goal.png')); ?>" alt=""></div>
						<div class="des">
							<h3 class="title <?php if($isEdit): ?> edit <?php endif; ?>" data-text="7"><?php echo $textList[7]; ?></h3>
							<div class="description <?php if($isEdit): ?> edit <?php endif; ?>" data-text="8"><?php echo $textList[8]; ?></div>
						</div>
					</div>
				</div><!-- /item -->
				<div class="col-sm-6">
					<div class="item">
						<div class="img"><img src="<?php echo e(URL::asset('public/assets/images/motivation.png')); ?>" alt=""></div>
						<div class="des">
							<h3 class="title <?php if($isEdit): ?> edit <?php endif; ?>" data-text="9"><?php echo $textList[9]; ?></h3>
							<div class="description <?php if($isEdit): ?> edit <?php endif; ?>" data-text="10"><?php echo $textList[10]; ?></div>
					</div>
					</div>
				</div><!-- /item -->
			</div>
		</div>
	</div>
	</div><!-- /block_big-title -->

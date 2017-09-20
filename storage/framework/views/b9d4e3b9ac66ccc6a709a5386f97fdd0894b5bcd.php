<header class="header">
	<div class="block-header">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-xs-12 block-logo">
					<a href="<?php echo e(route('home')); ?>" title="Logo">
						<img src="<?php echo e(Helper::showImage($settingArr['logo'])); ?>" alt="Logo Nam Phúc">
					</a>
				</div><!-- /block-logo -->
				<div class="col-sm-8 col-xs-12 block-info">
					<div class="row">
						<div class="col-sm-4 col-xs-12">
							<div class="item hotline">
								<i class="fa fa-phone"></i>
								<p>
									<span class="title">Hotline</span>
									<span class="info"><?php echo $settingArr['hotline']; ?></span>
								</p>
							</div>	
						</div>
						<div class="col-sm-4 col-xs-12">
							<div class="item time">
								<i class="fa fa-clock-o"></i>
								<p>
									<span class="title <?php if($isEdit): ?> edit <?php endif; ?>" data-text="15"><?php echo $textList[15]; ?></span>
									<span class="info">08:00 - 17:00</span>
								</p>
							</div>	
						</div>
						<div class="col-sm-4 col-xs-12">
							<div class="item email">
								<i class="fa fa-envelope-o"></i>
								<p>
									<span class="title">Email</span>
									<span class="info"><?php echo $settingArr['email_header']; ?></span>
								</p>
							</div>	
						</div>
					</div>
				</div><!-- /bblock-info -->
			</div>
		</div>
		<div class="block-search">
			<form class="form-inline" action="<?php echo e(route('search')); ?>" method="GET">
				<button type="submit" class="btn icon"><i class="fa fa-search"></i></button>
				<div class="search-inner">
					<input type="text" value="<?php echo isset($tu_khoa) ? $tu_khoa : ""; ?>" name="keyword"  placeholder="Từ khóa bạn cần tìm...">
				</div>
			</form>
		</div>
		<div class="block-fb">
			<div class="icon">
				<i class="fa fa-facebook"></i>
			</div>
			<div class="fb-inner">
				<div class="fb-page" data-href="https://www.facebook.com/facebook" data-tabs="timeline" data-width="300px" data-height="500px" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/facebook" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div>
			</div>
		</div>
	</div><!-- /block-header-bottom -->
	<div class="menu">
		<div class="nav-toogle">
			<i class="fa"></i>
		</div>
		<div class="block-cart-mb">
			<a href="#" onclick="return false;" title="Cart" data-toggle="modal" data-target="#Cart">
				<i class="fa fa-shopping-cart"></i>
				<span>10</span>
			</a>
		</div>
		<nav class="menu-top">
			<div class="container">
				<ul class="nav-menu">					
					<?php 
					$menuLists = DB::table('menu')->where('parent_id', 0)->orderBy('display_order')->get();
					?>
					<?php foreach($menuLists as $menu): ?>

					<?php
                  	$menuCap1List = DB::table('menu')->where('parent_id', $menu->id)->orderBy('display_order')->get();
                  	?>
                                      
					<li class="level0 <?php if($menuCap1List): ?>  parent <?php endif; ?> "><a href="<?php echo e($menu->url); ?>" title="<?php echo e($menu->title); ?>"><?php echo e($menu->title); ?></a>

						<?php if($menuCap1List): ?>
						
						<ul class="level0 submenu">			
							<?php foreach($menuCap1List as $cap1): ?>
							<?php 
							$menuCap2List = DB::table('menu')->where('parent_id', $cap1->id)->orderBy('display_order')->get(); 

							?>
							<li class="level1 <?php if($menuCap2List): ?> parent <?php endif; ?>">
								<a href="<?php echo e($cap1->url); ?>" title="<?php echo $cap1->title; ?>"><?php echo $cap1->title; ?></a>
								
								<?php if($menuCap2List): ?>
								<ul class="level1 submenu">
									<?php foreach($menuCap2List as $cap2): ?>
									<li class="level2"><a href="<?php echo e($cap2->url); ?>" title="<?php echo $cap2->title; ?>"><?php echo $cap2->title; ?></a></li>
									<?php endforeach; ?>
								</ul>
								<?php endif; ?>
							</li>
							<?php endforeach; ?>
						</ul>
						
						<?php endif; ?>
					</li>					

					<?php endforeach; ?>
					<li class="cart">
						<a href="#" onclick="return false;" title="Cart" data-toggle="modal" data-target="#Cart">
							<i class="fa fa-shopping-cart"></i>
							<span>Giỏ hàng</span><br>
							<span>0 Sản phẩm</span>
						</a>
					</li>
				</ul>
			</div>
		</nav><!-- /menu-top -->
	</div><!-- /menu -->
	</header><!-- /header -->
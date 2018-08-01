<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo  $helper->getDirection(); ?>" class="<?php echo $helper->getDirection(); ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<?php  require( ThemeControlHelper::getLayoutPath( 'common/parts/head.tpl' ) );   ?>
<body class="<?php echo $class; ?> <?php echo $helper->getPageClass();?>">
<div class="row-offcanvas row-offcanvas-left layout-<?php echo $template_layout; ?>">
	<?php
		if( isset($_COOKIE[$themeName .'_skin']) && $_COOKIE[$themeName .'_skin'] ){
			$skin = trim($_COOKIE[$themeName .'_skin']);
		}
	?>
	<header class="header-v1 bg-white clearfix">
		<div class="container">
			<div class="row">
				<div id="icon-box-header" class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
					<?php
						if($content=$helper->getLangConfig('icon_box_header')){
							echo $content;
						}
					?>
				</div>
				<div id="logo" class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<?php if ($logo) { ?>
						<a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
					<?php }
					else { ?>
						<h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
					<?php } ?>
				</div>
				<div id="search" class="search col-lg-1 col-md-1 hidden-sm hidden-xs">
					<?php echo $search; ?>
				</div>
				<div id="setting" class="dropdown col-lg-1 col-md-1">
					<div class="dropdown-toggle text-center" data-toggle="dropdown">
						<i class="fa fa-cog"></i>
					</div>
					<ul class="dropdown-menu box-setting">
						<li><h5><?php echo $languageMenu_2;?></h5></li>
						<li class="language">
							<?php echo $language; ?>
						</li>
						<li class="currency">
							<?php echo $currency; ?>
						</li>
						<li class="account">
							<ul>
								<?php if ($logged) { ?>
									<li><a href="<?php echo $account; ?>"><i class="zmdi zmdi-account"></i> <?php echo $text_account; ?></a></li>
									<li><a id="wishlist-total" href="<?php echo $wishlist; ?>"><i class="fa fa-heart"></i> <?php echo $text_wishlist; ?></a></li>
									<li><a href="<?php echo $shopping_cart; ?>"><i class="zmdi zmdi-shopping-basket"></i> <?php echo $text_shopping_cart; ?></a></li>
									<li><a href="<?php echo $checkout; ?>"><i class="fa fa-check"></i> <?php echo $text_checkout; ?></a></li>
									<?php $count = 0 ;foreach ($products as $product) { $count++;}?>
									<li><a href="<?php echo $compare; ?>"><i class="fa fa-bar-chart"></i> <?php echo $text_compare ." ($count)"; ?></a></li>
									<li class="logout"><a href="<?php echo $logout; ?>"><i class="fa fa-sign-out"></i> <?php echo $text_logout; ?></a></li>
								<?php }
								else { ?>
									<li class="logout"><a href="<?php echo $login; ?>"><i class="fa fa-key"></i> <?php echo $text_login; ?></a></li>
									<li><a href="<?php echo $register; ?>"><i class="fa fa-pencil"></i> <?php echo $text_register; ?></a></li>
									<?php $count = 0 ;foreach ($products as $product) { $count++;}?>
									<li><a href="<?php echo $compare; ?>"><i class="fa fa-bar-chart"></i> <?php echo $text_compare ." ($count)"; ?></a></li>
								<?php } ?>
							</ul>
						</li>
					</ul>
				</div>
				<div id="cart-top" class="col-lg-1 col-md-1">
					<?php echo $cart; ?>
				</div>
			</div>
		</div>
		<div id="group-menu">
			<div class="container">
				<div class="row">
					<div class="bo-mainmenu">
						<?php  require( ThemeControlHelper::getLayoutPath( 'common/parts/mainmenu.tpl' ) );   ?>
					</div>
					<div id="search2" class="search hidden-lg hidden-md col-sm-9 col-xs-9 pull-right">
						<?php echo $search; ?>
					</div>
				</div>
			</div>
		</div>
	</header>

	<!-- sys-notification -->
	<div id="sys-notification">
		<div class="container">
            <div id="notification"></div>
		</div>
	</div>
	<!-- /sys-notification -->

	<?php
		/**
		* Showcase modules
		* $ospans allow overrides width of columns base on thiers indexs. format array( column-index=>span number ), example array( 1=> 3 )[value from 1->12]
		*/
		//$modules = $helper->getCloneModulesInLayout( $blockid, $layoutID );
		$blockid = 'slideshow';
		$blockcls = "hidden-xs hidden-sm";
		$ospans = array(1=>12);
		require( ThemeControlHelper::getLayoutPath( 'common/block-cols.tpl' ) );
	?>
	<?php
		/**
		* Showcase modules
		* $ospans allow overrides width of columns base on thiers indexs. format array( column-index=>span number ), example array( 1=> 3 )[value from 1->12]
		*/
		$blockid = 'showcase';
		$blockcls = 'hidden-xs hidden-sm';
		$ospans = array(1=>12);
		require( ThemeControlHelper::getLayoutPath( 'common/block-cols.tpl' ) );
	?>
	<?php
		/**
		* promotion modules
		* $ospans allow overrides width of columns base on thiers indexs. format array( column-index=>span number ), example array( 1=> 3 )[value from 1->12]
		*/
		$blockid = 'promotion';
		$blockcls = "hidden-xs hidden-sm";
		$ospans = array(1=>12, 2=>12);
		require( ThemeControlHelper::getLayoutPath( 'common/block-cols.tpl' ) );
	?>
	<div class="maincols clearfix">

	<!-- google anal-->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-104778346-1', 'auto');
  ga('send', 'pageview');

</script>

<!-- google anal-->

<?php $objlang = $this->registry->get('language');  $ourl = $this->registry->get('url');   ?>

<div class="product-block item-full clearfix">
	<div class="footer-deals text-center">
		<div id="item_countdown_<?php echo $product['product_id']; ?>" class="item-countdown clearfix"></div>
	</div>
	<?php if ($product['thumb']) {    ?>
		<div class="image">
			<?php if( $product['special'] ) {   ?>
				<span class="product-label sale-exist text-center radius-4x"><span class="product-label-special"><?php echo $objlang->get('text_sale'); ?></span></span>
			<?php } ?>
			<div class="product-img img">
				<a class="img" title="<?php echo $product['name']; ?>" href="<?php echo $product['href']; ?>">
					<img class="img-responsive" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" />
				</a>
			</div>
		</div>
	<?php } ?>
	<div class="product-meta">
		<div class="top">
			<h6 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h6>
			<?php if( isset($product['description']) ){ ?>
				<p class="description"><?php echo utf8_substr( strip_tags($product['description']),0,200);?>...</p>
			<?php } ?>
			<?php if ($product['rating']) { ?>
				<div class="rating">
					<?php for ($is = 1; $is <= 5; $is++) { ?>
						<?php if ($product['rating'] < $is) { ?>
							<span><i class="zmdi zmdi-star-outline"></i></span>
						<?php } else { ?>
							<span class="rate"><i class="zmdi zmdi-star-outline"></i></span>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
			<?php if ($product['price']) { ?>
				<div class="price clearfix">
					<?php if (!$product['special']) {  ?>
						<span class="price-olds"><?php echo $product['price']; ?></span>
						<?php if( preg_match( '#(\d+).?(\d+)#',  $product['price'], $p ) ) { ?>
						<?php } ?>
					<?php }
					else { ?>
						<span class="price-new"><?php echo $product['special']; ?></span>
						<span class="price-old"><?php echo $product['price']; ?></span>
						<?php if( preg_match( '#(\d+).?(\d+)#',  $product['special'], $p ) ) { ?> 
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
			<?php if( !isset($listingConfig['catalog_mode']) || !$listingConfig['catalog_mode'] ) { ?>
				<div class="cart">
					<button data-loading-text="Loading..." type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');">
						<span><?php echo "+ "."".$button_cart; ?></span>
					</button>
				</div>
			<?php } ?>
		</div>
        <div class="bottom">
			<div class="action add-links clearfix">
				<div class="wishlist pull-left">
					<button class="btn-action btn-v2" type="button" data-toggle="tooltip" data-placement="top" title="<?php echo $objlang->get("button_wishlist"); ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart-o"></i></button> 
				</div>
				<div class="compare pull-left">
					<button class="btn-action btn-v2" type="button" data-toggle="tooltip" data-placement="top" title="<?php echo $objlang->get("button_compare"); ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-bar-chart"></i></button> 
				</div>
				<?php if ( isset($quickview) && $quickview ) { ?>
					<div class="quickview pull-left hidden-sm hidden-xs">
						<a class="iframe-link text-center btn-action btn-v2 quick-view" data-toggle="tooltip" data-placement="top" href="<?php echo $ourl->link('themecontrol/product','product_id='.$product['product_id']);?>"  title="<?php echo $objlang->get('quick_view'); ?>" ><i class="zmdi zmdi-eye"></i></a>
					</div>
				<?php } ?> 
			</div>
        </div>
	</div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function($){
    $("#item_countdown_<?php echo $product['product_id']; ?>").lofCountDown({
      formatStyle:2,
      TargetDate:"<?php echo date('m/d/Y G:i:s', strtotime($product['date_end_string'])); ?>",
      DisplayFormat:"<ul class='list-inline'><li class='days'> %%D%% <span><?php echo $objlang->get("text_days");?></span></li><li class='hours'> %%H%% <span><?php echo $objlang->get("text_hours");?></span></li><li class='minutes'> %%M%% <span><?php echo $objlang->get("text_minutes");?></span></li><li class='seconds'> %%S%% <span><?php echo $objlang->get("text_seconds");?></span></li></ul>",
      FinishMessage: "<?php echo $objlang->get('text_finish');?>"
    });
  });
</script>
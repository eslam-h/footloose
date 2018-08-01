
<?php $kkk = 0; ?>
<div class="product-block">
	<?php if ($product['images']) {    ?>
	<div class="image">
		<?php if( $product['special'] ) {   ?>
		<span class="product-label sale-exist radius-3x text-center"><span class="product-label-special"><?php echo $objlang->get('text_sale'); ?></span></span>
		<?php } ?>
		<div class="product-img img">


			<?php

        $datetime1 = date_create($product['date_available']);
        $datetime2 = date_create(date("Y-m-d"));
        $interval = date_diff($datetime1, $datetime2);
        $diff = $interval->format('%R%a days');
						   ?>

			<?php if ($product['quantity']<1 && isset($text_out_of_stock) ) { ?>
			<div class="product-not-available">
				<p><?php echo $text_out_of_stock; ?></p>
			</div>
			<?php } else if($diff < 30) { ?>
			<div class="new-product">
				<p><?php echo $text_new; ?></p>
			</div>
			<?php } else if ($product['quantity']<1 && isset($product['system'])) { ?>
			<div class="product-not-available">
				<p><?php echo $product['system']; ?></p>
			</div>
			<?php } ?>




			<a class="img" title="<?php echo $product['name']; ?>" href="<?php echo $product['href']; ?>">
				<?php $check = 0; foreach($product['images'] as $productImage) {
						$newImgPath = "basic/basic-basic_1";
						if($productImage) {
						$newStrFine = $productImage.substr(strrpos($productImage, '/') + 1, 0);
						$newImgPath = explode('-', $newStrFine)[1];
						$newImgPath = substr($newImgPath, 0, -2);
						$newImgPath = str_replace(" ", "_", $newImgPath);
						}
						if($check == 0) { $check =1; ?>
				<img id="notFound"  style="display: none;" class="img-responsive <?php echo $product['product_id']; ?>" src="<?php echo $product['placeholder']; ?>" title="Image not found!" alt="Image Not Found!" />
				<img id="<?php  echo $newImgPath ?>"  style="" class="img-responsive <?php echo $product['product_id']; ?>" src="<?php echo $productImage; ?>" onerror=this.src="<?php echo $product['placeholder']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['placeholder']; ?>" />
				<?php } else { ?>
				<img id="<?php  echo $newImgPath ?>" style="display: none;" class="img-responsive <?php echo $product['product_id']; ?>" src="<?php echo $productImage; ?>" onerror=this.src="<?php echo $product['placeholder']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['placeholder']; ?>" />
				<?php }} ?>
			</a>
			<div class="zoom hidden-xs hidden-sm">
				<?php if( isset($categoryPzoom) && $categoryPzoom ) { $zimage = str_replace( "cache/","", preg_replace("#-\d+x\d+#", "",  $product['thumb'] ));  ?>
				<a data-toggle="tooltip" data-placement="top" href="<?php echo $zimage;?>" class="product-zoom info-view colorbox cboxElement" title="<?php echo $product['name']; ?>"><i class="fa fa-search"></i></a>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="product-meta">
		<div class="top">

			<div class="form-group form-group-v2">
				<div style="display:inline;"></div>




				<?php if(isset($product['product_option_value']) && count($product['product_option_value']) > 4) { ?>
				<?php $myChecker = false; $counter = 0; foreach ($product['product_option_value'] as $option_value) { if($counter++ == 3) { $myCheker = true; break; } ?>
				<div style="display:inline;" >
					<img style="border: solid; " class="options<?php echo $kkk; ?>" about="<?php echo $product['product_id']; ?>" src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name']; ?>" />
				</div>
				<?php } ?>

				<?php if($myCheker) { ?>
				<a style="" title="<?php echo ((count($product['product_option_value']) - 3) . ' ' . $text_more_details); ?>" href="<?php echo $product['href']; ?>">
					<div style="display:inline;" >
						<img style="border: solid;" src="<?php echo $plus_pic; ?>" alt="" />
					</div>
				</a>
				<?php } ?>

				<?php } else { ?>

				<?php $counter = 0; foreach ($product['product_option_value'] as $option_value) { $counter++;  ?>
				<div style="display:inline;" >
					<img style="border: solid; " class="options<?php echo $kkk; ?>" about="<?php echo $product['product_id']; ?>" src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name']; ?>" />
				</div>
				<?php } ?>

				<?php } ?>

			</div>
			<?php if($counter == 0) { ?>
			<br><br>
			<?php } ?>
			<h6 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h6>
			<?php if( isset($product['description']) ){ ?>
			<p class="description"><?php echo utf8_substr( strip_tags($product['description']),0,200);?>...</p>
			<?php } ?>
			<?php if ($product['price']) { ?>
			<div class="price clearfix">
				<?php if (!$product['special']) {  ?>
				<span class="price-olds"><?php echo $product['price']; ?></span>
				<?php if( preg_match( '#(\d+).?(\d+)#',  $product['price'], $p ) ) { ?>
				<?php } ?>
				<?php } else { ?>
				<span class="price-new"><?php echo $product['special']; ?></span>
				<span class="price-old"><?php echo $product['price']; ?></span>
				<?php if( preg_match( '#(\d+).?(\d+)#',  $product['special'], $p ) ) { ?>
				<?php } ?>
				<?php } ?>
			</div>
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
		</div>
		<div class="bottom">
			<div class="action">
				<?php if( !isset($listingConfig['catalog_mode']) || !$listingConfig['catalog_mode'] ) { ?>
				<div class="cart">
					<button class="btn-action" data-loading-text="Loading..." type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i></button>
				</div>
				<?php } ?>
				<div class="compare">
					<button class="btn-action" type="button" data-toggle="tooltip" data-placement="top" title="<?php echo $objlang->get("button_compare"); ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-bar-chart"></i></button>
				</div>
				<div class="wishlist">
					<button class="btn-action" type="button" data-toggle="tooltip" data-placement="top" title="<?php echo $objlang->get("button_wishlist"); ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart-o"></i></button>
				</div>
				<?php if ( isset($quickview) && $quickview ) { ?>
				<div class="quickview hidden-sm hidden-xs">
					<a class="iframe-link text-center btn-action quick-view" data-toggle="tooltip" data-placement="top" href="<?php echo $ourl->link('themecontrol/product','product_id='.$product['product_id']);?>"  title="<?php echo $objlang->get('quick_view'); ?>" ><i class="zmdi zmdi-eye"></i></a>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".options<?php echo $kkk; ?>").hover(function () {
			$(this).attr('style', 'border: solid; border-color: #00a204');
			var str = $(this).attr('src');
			var productName = $(this).attr('about');

			var strFine = str.substring(str.lastIndexOf('/') + 1);
			var oldImgPath = strFine.split('-')[1];

			var imgPath = oldImgPath.substring(0,oldImgPath.length-2);

			$('.' + productName).attr('style', 'display: none;');

			if( $('#'+imgPath+ '.' + productName).length) {
				$('#'+imgPath+ '.' + productName).removeAttr('style');
			}
			else {
				$('#notFound.' + productName).removeAttr('style');
			}

			$( this ).mouseout(function() {
				$( this ).attr( 'style', 'border: solid;' );
			});

		}, function () {
		});
	});


	var myOption = $(".options<?php echo $kkk++; ?>:first");

	var str = $(myOption).attr('src');
	var productName = $(myOption).attr('about');

	var strFine = str.substring(str.lastIndexOf('/') + 1);
	var oldImgPath = strFine.split('-')[1];

	var imgPath = oldImgPath.substring(0,oldImgPath.length-2);

	$('.' + productName).attr('style', 'display: none;');

	if( $('#'+imgPath+ '.' + productName).length) {
		$('#'+imgPath+ '.' + productName).removeAttr('style');
	}
	else {
		$('#notFound.' + productName).removeAttr('style');
	}

</script>
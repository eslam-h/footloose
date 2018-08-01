<?php
  $config = $sconfig;
  $themeConfig = (array)$config->get('themecontrol');
  $productConfig = array(
      'product_enablezoom'         	=> 1,
      'product_zoommode'           	=> 'basic',
      'product_zoomeasing'         	=> 1,
      'product_zoomlensshape'      	=> "round",
      'product_zoomlenssize'       	=> "150",
      'product_zoomgallery'        	=> 0,
      'enable_product_customtab'   	=> 0,
      'product_customtab_name'     	=> '',
      'product_customtab_content'  	=> '',
      'product_related_column'     	=> 0,
    );
    $listingConfig = array(
      'category_pzoom'				=> 1,
      'quickview'					=> 0,
      'show_swap_image'				=> 0,
      'catalog_mode'                => 1
    );
    $listingConfig					= array_merge($listingConfig, $themeConfig );
    $categoryPzoom					= $listingConfig['category_pzoom'];
    $quickview						= $listingConfig['quickview'];
    $swapimg						= ($listingConfig['show_swap_image'])?'swap':'';
    $productConfig					= array_merge( $productConfig, $themeConfig );
    $languageID						= $config->get('config_language_id');

?>

<?php echo $header; ?>

<style>

	<?php echo $product_style; ?>
	}
</style>
<?php $quantities = array(); ?>
<?php foreach ($options as $option) { ?>
<?php foreach ($option['product_option_value'] as $option_value) {
if($option['name'] != 'Color') {
//echo $option_value['quantity'] . " -- ". $option_value['name'] ." ++";
//$quantities[] = $option_value['quantity'];
}
}}
/*
echo'<script type="text/javascript">
var arr = [];
var sizesIds = [];
</script>';

for($i=0;$i<sizeof($quantities);$i++){
echo '<script type="text/javascript">
 arr.push(0 $quantities[$i]);

</script>';

}

echo '<script type="text/javascript">
 var x =arr[0];
 alert(x);

</script>';
*/
?>
<div class="container">
	<div class="row">
		<?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
		<?php $class = 'col-sm-6'; ?>
		<?php } elseif ($column_left || $column_right) { ?>
		<?php $class = 'col-lg-9 col-md-9 col-sm-12 col-xs-12'; ?>
		<?php } else { ?>
		<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="<?php echo $class; ?>">
			<?php echo $content_top; ?>
			<ul class="breadcrumb detail">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
			<div class="row">
				<?php if ($column_left || $column_right) { ?>
				<?php $class = 'col-sm-6'; ?>
				<?php } else { ?>
				<?php $class = 'col-sm-6'; ?>
				<?php } ?>
				<?php require( ThemeControlHelper::getLayoutPath( 'product/preview/default.tpl' ) );  ?>
				<?php if ($column_left || $column_right) { ?>
				<?php $class = 'col-sm-6'; ?>
				<?php } else { ?>
				<?php $class = 'col-sm-6'; ?>
				<?php } ?>
				<div class="detail-container <?php echo $class; ?>">
					<h1><?php echo $heading_title; ?></h1>
					<?php if ($review_status) { ?>
						<div class="rating">
							<p>
								<?php for ($i = 1; $i <= 5; $i++) { ?>
									<?php if ($rating < $i) { ?>
										<span><i class="zmdi zmdi-star-outline"></i></span>
									<?php } else { ?>
										<span class="rate"><i class="zmdi zmdi-star-outline"></i></span>
									<?php } ?>
								<?php } ?>
							</p>
							<a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $reviews; ?></a> - <a href="#review-form" class="popup-with-form btn btn-v" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $text_write; ?></a>

							  <a style="display:none" href="#review-form"  class="popup-with-form btn btn-v2" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;" ><?php echo $text_write; ?></a>




						</div>
					<?php } ?>

       <?php if ($salescombopgeoffers) {  foreach($salescombopgeoffers as $offer) { echo html_entity_decode($offer['html']); } } ?>
        
					<?php if ($price) { ?>
						<?php if (!$special) { ?>
							<h3 class="price-olds"><?php echo $price; ?></h3>
						<?php } else { ?>
							<div class="price clearfix">
								<span class="price-new"><?php echo $special; ?></span>
								<span class="price-old"><?php echo $price; ?></span>
							</div>
						<?php } ?>
						<ul class="list-unstyled">
							<?php if ($tax) { ?>
								<li><span class="type"><?php echo $text_tax; ?></span> <span><?php echo $tax; ?></span></li>
							<?php } ?>
							<?php if ($points) { ?>
								<li><span class="type"><?php echo $text_points; ?></span> <span><?php echo $points; ?></span></li>
							<?php } ?>
							<?php if ($discounts) { ?>
								<?php foreach ($discounts as $discount) { ?>
									<li><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
								<?php } ?>
							<?php } ?>
						</ul>
					<?php } ?>
					<ul class="list-unstyled">
						<?php if ($manufacturer) { ?>
							<li><span class="type"><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></li>
						<?php } ?>
						<li><span class="type"><?php echo $text_model; ?></span> <span><?php echo $model; ?></span></li>
						<?php if ($reward) { ?>
							<li><span class="type"><?php echo $text_reward; ?></span> <span><?php echo $reward; ?></span></li>
						<?php } ?>
						<li><span class="type"><?php echo $text_stock; ?></span> <span><?php echo $stock; ?></span></li>
					</ul>
					<div id="product">



										
															<?php if ($options) { ?>
							<h3><?php echo $text_option; ?></h3>
							<?php foreach ($options as $option) { ?>

						<?php if ($option['type'] == 'select') {
											if($option['name'] == 'Color' || $option['name'] == 'اللون') {

									?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> form-group-v2">
							<?php if ($option['product_option_value']) { ?>
							<label  class="control-label"><?php echo $option['name']; ?> : </label>
							<div style="display:inline;" id="colorName"></div>
							<?php } ?>
							<form id="myForm">
								<div id="input-option<?php echo $option['product_option_id']; ?>">
									<?php  $id=0;
													if ($thumb) {
															$newStrFine = $thumb.substr(strrpos($thumb, '/') + 1, 0);
															$newImgPath = explode('-', $newStrFine)[1];
															$newImgPath = explode('_', $newImgPath)[0];
															} else {
															$newImgPath = "hj";
															}
															foreach ($option['product_option_value'] as $option_value) {

															$strFine = $option_value['image'];
															if($strFine) {
															$imgPath = explode('/', $strFine);
															$imgPath = end($imgPath);
															$imgPath = explode('-', $imgPath)[1];
															$imgPath = explode('_', $imgPath)[0];
															}
															else {
															$imgPath = "hj";
															}
																?>




									<?php if(isset($option_value['image'])) { ?>
									<div style="display:inline;" >
										<label class="styledBorder" id="<?php echo $option_value['product_option_value_id']; ?>" <?php if($newImgPath == $imgPath){ ?> style="border-style: solid; border-width: 2px; border-color: #00bdec" <?php } ?> >
										<?php if($newImgPath == $imgPath){ $check =1;?>
										<input id="<?php echo $id++; ?>" type="radio" hidden checked about="<?php echo $option_value['name']; ?>"  name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" size_id_and_quantity = '<?php echo json_encode($option_value['size_id_and_quantity']); ?>'/>
										<?php } else { ?>
										<input id="<?php echo $id++; ?>" type="radio"  hidden about="<?php echo $option_value['name']; ?>" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" size_id_and_quantity = '<?php echo json_encode($option_value['size_id_and_quantity']); ?>'/>
										<?php } ?>
										<img id="<?php echo $id++; ?>" src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" />
										<?php if($option_value['price']) { ?>
																																									   (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
										<?php } ?>
									</div>
									<?php } ?>




									<?php } ?>
								</div>
							</form>
						</div>

						<?php } } ?>

								<?php if ($option['type'] == 'select') {

                                             if ($option['name'] == 'Size' || $option['name'] == 'المقاس'){ ?>
                                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                                <label id="sizename" class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?>&emsp;:</label>

													<br>
													<select style="display: inline; width:50%;" name="option[<?php echo $option['product_option_id']; ?>]"  id="Size" class="form-control" onchange="getSizeID();">
                                                    <option value=""><?php echo $text_select; ?></option>
                                                    <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                                        <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                                            <?php if ($option_value['price']) { ?>
                                                                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                                            <?php } ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>

													<?php if($manufacturer == 'crocs' || $manufacturer == 'كروكس') { ?>
													<link href="catalog/view/theme/pav_krstore/template/information/lightbox2-master/dist/css/lightbox.css" rel="stylesheet">
													<script src="catalog/view/theme/pav_krstore/template/information/lightbox2-master/dist/js/lightbox.js"></script>

													<script>
														lightbox.option({
															positionFromTop : 50
														})
													</script>

													&emsp;	&emsp;	<div class="pull-right">
																<a href="<?php echo $size_chart; ?>" data-lightbox="<?php echo $text_size_chart; ?>" data-title="<?php echo $text_size_chart; ?>"><button class="btn btn-default" ><?php echo $text_size_chart; ?></button></a>
															</div>
														<?php } ?>
                                            </div>
                                            <?php }

	 } ?>


							<?php } ?>
						<?php } ?>

						<?php if ($recurrings) { ?>
							<h3><?php echo $text_payment_recurring ?></h3>
							<div class="form-group required">
								<select name="recurring_id" class="form-control">
									<option value=""><?php echo $text_select; ?></option>
									<?php foreach ($recurrings as $recurring) { ?>
										<option value="<?php echo $recurring['recurring_id'] ?>"><?php echo $recurring['name'] ?></option>
									<?php } ?>
								</select>
								<div class="help-block" id="recurring-description"></div>
							</div>
						<?php } ?>
						<div class="product-buttons-wrap clearfix">
							<label class="control-label qty"><?php echo $entry_qty; ?>:</label>

							<?php if($product_quantity > 0 ){ ?>
							<div class="product-qyt-action clearfix">
								<div class="quantity-adder  pull-left">
									<div class="quantity-number pull-left">
										<input readonly type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="form-control text-center" min="1"/>
									</div>
									<span class="add-down add-action ">
										<i class="zmdi zmdi-minus"></i>
									</span>
									<span  class="add-up add-action " onclick="plusFuntion()">
										<i class="zmdi zmdi-plus"></i>
									</span>
								</div>
								<div class="cart pull-right">
									<button type="button" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-v1 button-cart" id="button-cart"><?php echo $button_cart; ?></button>
								</div>
							</div>

							<?php } else { ?>
							<div class="product-qyt-action clearfix">
								<div class="quantity-adder  pull-left">
									<div class="quantity-number pull-left">
										<input disabled type="number" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="form-control text-center" min="1"/>
									</div>
								</div>
								<div class="cart pull-left">
									<button disabled type="button" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-v1 button-cart" id="button-cart"><?php echo $button_cart; ?></button>
								</div>
							</div>



							<?php } ?>




							<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
							<div class="action clearfix">
								<div class="pull-left">
									<a data-toggle="tooltip" class="wishlist" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="fa fa-heart-o"></i> <?php echo $button_wishlist; ?></a>
								</div>
								<div class="pull-left">
									<a data-toggle="tooltip" class="compare" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><i class="fa fa-bar-chart"></i> <?php echo $button_compare; ?></a>
								</div>
							</div>
						</div>
						<!-- AddThis Button BEGIN -->
						<div class="addthis_toolbox addthis_default_style">
							<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
							<a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a>
							<a class="addthis_counter addthis_pill_style"></a>
						</div>
						<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
						<!-- AddThis Button END -->
						<?php if ($minimum > 1) { ?>
							<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
						<?php } ?>
						<?php if ($tags) { ?>
							<p>
								<?php echo $text_tags; ?>
								<?php for ($i = 0; $i < count($tags); $i++) { ?>
									<?php if ($i < (count($tags) - 1)) { ?>
										<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
									<?php } 
									else { ?>
										<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
									<?php } ?>
								<?php } ?>
							</p>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="tab-v88">
				<ul class="nav text-center nav-tabs">
					<li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a></li>

        <?php if(isset($available_offers['tab']) && $available_offers['tab']) { ?>
        <li><a href="#tab-available-offers" data-toggle="tab"><?php echo $tab_available_offers; ?></a></li>
        <?php } ?>
        
					<?php if ($attribute_groups) { ?>
						<li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
					<?php } ?>
					<?php if ($review_status) { ?>
						<li><a href="#tab-review" data-toggle="tab"><?php echo $tab_review; ?></a></li>

					<?php } ?>
					<?php if( $productConfig['enable_product_customtab'] && isset($productConfig['product_customtab_name'][$languageID]) ) { ?>
						<li><a href="#tab-customtab" data-toggle="tab"><?php echo $productConfig['product_customtab_name'][$languageID]; ?></a></li>
					<?php } ?>
				</ul>
				<div class="tab-content text-left">
					<div class="tab-pane active" id="tab-description"><?php echo $description; ?></div>

        <?php if(isset($available_offers['tab']) && $available_offers['tab']) { ?>
        <div class="tab-pane" id="tab-available-offers"><?php echo $available_offers['tab']; ?></div>
        <?php } ?>
        
					<?php if ($attribute_groups) { ?>
						<div class="tab-pane" id="tab-specification">
							<table class="table table-bordered">
								<?php foreach ($attribute_groups as $attribute_group) { ?>
									<thead>
										<tr>
											<td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
											<tr>
												<td><?php echo $attribute['name']; ?></td>
												<td><?php echo $attribute['text']; ?></td>
											</tr>
										<?php } ?>
									</tbody>
								<?php } ?>
							</table>
						</div>
					<?php } ?>
            <?php if ($review_status) { ?>

                <div class="tab-pane" id="tab-review">

                    <div id="review" class="space-20"></div>
                    <p> <a href="#review-form"  class="popup-with-form btn btn-v2" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;" ><?php echo $text_write; ?></a></p>

                   <div class="hide"> <div id="review-form" class="panel review-form-width"><div class="panel-body">
                    <form class="form-horizontal" id="form-review">
						<div id="error-rev" class="space-20 pull-left"></div>
						<div class="panel-heading">
							<h4 class="panel-title panel-v1 pull-left"><?php echo $text_write; ?></h4>
						</div>
                        <div class="form-group required">
                            <div class="col-sm-12">
                                <label class="control-label pull-left" for="input-name"><?php echo $entry_name; ?></label>
                                <input type="text" name="name" value="" id="input-name" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group required">
                            <div class="col-sm-12">
                                <label class="control-label pull-left" for="input-review"><?php echo $entry_review; ?></label>
                                <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                                <div class="help-block"><?php echo $text_note; ?></div>
                            </div>
                        </div>
                        <div class="form-group required pull-left" style="font-family: arial;">
                            <div class="col-sm-12">
                                <label class="control-label"><?php echo $entry_rating; ?></label>
                                &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                                <input type="radio" name="rating" value="1" />
                                &nbsp;
                                <input type="radio" name="rating" value="2" />
                                &nbsp;
                                <input type="radio" name="rating" value="3" />
                                &nbsp;
                                <input type="radio" name="rating" value="4" />
                                &nbsp;
                                <input type="radio" name="rating" value="5" />
                                &nbsp;<?php echo $entry_good; ?></div>
                        </div>
                         <?php echo $captcha; ?>
                        <div class="buttons">
                            <div class="pull-right">
                                <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-v1"><?php echo $button_continue; ?></button>
                            </div>
                        </div>
                    </form>
						   </div>
					   </div>
				   </div>
                </div>
            <?php } ?>
<?php if( $productConfig['enable_product_customtab'] && isset($productConfig['product_customtab_content'][$languageID]) ) { ?>
               <div id="tab-customtab" class="tab-pane custom-tab">
                <div class="inner">
                  <?php echo html_entity_decode( $productConfig['product_customtab_content'][$languageID], ENT_QUOTES, 'UTF-8'); ?>
                </div></div>
             <?php } ?>
				</div>
			</div> 
			<?php if ($products) {  $heading_title = $text_related; $customcols = 4; ?>
				<div class="panel panel-default product-related"> <?php require( ThemeControlHelper::getLayoutPath( 'common/products_carousel.tpl' ) );  ?>   </div>
			<?php } ?>
			<?php echo $content_bottom; ?>
		</div>
		<?php echo $column_right; ?>
	</div>
</div>

<?php $count = 0; $sku = ''; foreach($images as $key => $imageList) {
if($key === '') { continue; }
if($key === 'top') {
$sku = $newImgPath;
foreach($imageList as $image) {
//echo ($image['popup']." - - ".$sku." - - ".$count)
?>
<div id="<?php echo($sku.$count) ?>" about="<?php echo($image['popup']); ?>"></div>
<?php $count++; } 
} elseif ($key ==='first-image'){}
    else {
$sku = $key;
foreach($imageList as $image) {
//echo ($image." - - ".$sku." - - ".$count)
?>
<div id="<?php echo($sku.$count) ?>" about="<?php echo($image); ?>"></div>
<?php $count++; } }  $count = 0; }?>

<script type="text/javascript">

//	$("#myForm input:[type=radio]:first").trigger("change");
//	$('input[type=radio]:first', '#myForm').trigger("change");

	if( !($('input[type=radio]:checked', '#myForm').attr('about'))){
//		console.log("false");
	} else {
		$('#colorName').html($('input[type=radio]:checked', '#myForm').attr('about'));
		changeSizeOptionStates();
	}

    //changeSizeOptionStates();

	$('#myForm input').on('change', function() {
		$('#colorName').html($('input[type=radio]:checked', '#myForm').attr('about'));
		$('.styledBorder').removeAttr('style');
		$('#'+$('input[type=radio]:checked', '#myForm').attr('value')).attr('style', "border-style: solid; border-width: 2px; border-color: #00bdec")

		var id = $('input[type=radio]:checked', '#myForm').attr('id');

		var str = $('#' + ++id).attr('src');

		var strFine = str.substring(str.lastIndexOf('/') + 1);

		var imgPath = strFine.split('-')[1];
		imgPath = imgPath.split('_')[0];

		id = 0;

		var counter =0;
		<?php  $check = 0;  foreach ($images['top'] as  $image){ ?>
			var newSource = $('#' + imgPath + counter).attr('about');

			$('#a' + id).attr('href', newSource);
			$('#a' + id).attr('data-zoom-image',newSource );
			$('#a' + id).attr('data-image', newSource );

			$('#i' + id).attr('src', newSource);
			$('#i' + id++).attr('data-zoom-image', newSource );

        <?php if($check == 0) { $check=1; ?>

                $('#mainImgA').attr('href', newSource );
                $('#image').attr('src', newSource );
                $('#image').attr('data-zoom-image', newSource );


				$("#image").data('zoom-image', newSource).elevateZoom({
					responsive: true,
					scrollZoom: true,
					containLensZoom: true
				});

            <?php } ?>

			counter++;
		<?php  } ?>
        
        for (var n = 0; n< counter; n++)
        {
            if ($('#' + imgPath + n).length)
            {
                $('#a' + n).show();
                $('#i' + n).show();
            }
            else
            {
                $('#a' + n).hide();
                $('#i' + n).hide();
            }
        }

        changeSizeOptionStates();
	});

//


if( !($('input[type=radio]:checked', '#myForm').val())){
	$('input[type=radio]:first', '#myForm').prop("checked", true);

	$('#colorName').html($('input[type=radio]:first', '#myForm').attr('about'));
	$('.styledBorder').removeAttr('style');
	$('#'+$('input[type=radio]:first', '#myForm').attr('value')).attr('style', "border-style: solid; border-width: 2px; border-color: #00bdec")

	var id = $('input[type=radio]:first', '#myForm').attr('id');

	var str = $('#' + ++id).attr('src');

	var strFine = str.substring(str.lastIndexOf('/') + 1);

	var imgPath = strFine.split('-')[1];
	imgPath = imgPath.split('_')[0];

	id = 0;

	var counter =0;
<?php  $check = 0;  foreach ($images['top'] as  $image){ ?>
		var newSource = $('#' + imgPath + counter).attr('about');

		$('#a' + id).attr('href', newSource);
		$('#a' + id).attr('data-zoom-image',newSource );
		$('#a' + id).attr('data-image', newSource );

		$('#i' + id).attr('src', newSource);
		$('#i' + id++).attr('data-zoom-image', newSource );

	<?php if($check == 0) { $check=1; ?>

			$('#mainImgA').attr('href', newSource );
			$('#image').attr('src', newSource );
			$('#image').attr('data-zoom-image', newSource );


			$("#image").data('zoom-image', newSource).elevateZoom({
				responsive: true,
				scrollZoom: true,
				containLensZoom: true
			});

		<?php } ?>

		counter++;
	<?php  } ?>

	for (var n = 0; n< counter; n++)
	{
		if ($('#' + imgPath + n).length)
		{
			$('#a' + n).show();
			$('#i' + n).show();
		}
		else
		{
			$('#a' + n).hide();
			$('#i' + n).hide();
		}
	}

	changeSizeOptionStates();

	}






    function changeSizeOptionStates()
    {
        var attr = $('input[type=radio]:checked').attr('size_id_and_quantity');
        var size_id_and_quantity = JSON.parse(attr);
        var options = $("#Size").children();
        for(var i = 1; i < options.length; i++)
        {
            var value = options[i].getAttribute("value");
            if (size_id_and_quantity[value] != undefined)
            {
                options[i].removeAttribute("hidden");
				options[i].removeAttribute("disabled");
            }
            else
            {
                options[i].setAttribute("hidden", true);
				options[i].setAttribute("disabled", true);
            }
            options[i].selected = false;
        }
        options[0].selected = true;
        //alert(color_id);
    }


    //ABDO CODE
var maxx=0;

  function getSizeID() {  
  

    var input = document.getElementById("input-quantity");
    input.value = 1;
	var e = document.getElementById("Size");
	var maxvalue = e.options[e.selectedIndex].value;
//	alert(maxvalue);

	var attr = $('input[type=radio]:checked').attr('size_id_and_quantity');
        var size_id_and_quantity = JSON.parse(attr);

  //      alert(size_id_and_quantity[maxvalue]);
        maxx=size_id_and_quantity[maxvalue];




  }
  
  function plusFuntion() {
	  
	
	var input = document.getElementById("input-quantity");
	input.max = maxx;
	//alert(maxx);
	if(maxx>parseInt(input.value)){
		//var rr =parseInt(input.value)+1
		//input.value=rr.toString();
		
	}
	else if(maxx<parseInt(input.value)){

		input.value=parseInt(input.value)-1;
		
	}
	else{

		input.value=parseInt(input.value)-1;
	}
	
	  
  }

 
</script>

<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');


			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
					//	alert("<?php echo $error_size_and_color; ?>");
						//var sizesBox=document.getElementById("product_option_id");
						//sizesBox.style.backgroundColor = "red";
						document.getElementById("sizename").style.color = "#ff0000";
						document.getElementById("Size").style.border = " solid #0000FF";
						document.getElementById("Size").style.width = " 50%";
						document.getElementById("Size").style.borderColor  = "#ff0000";

						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
				$('#notification').html('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		          
//				alert(json['total']);
//				$('#cart-total').html(json['total']);
		        res = json['total'].split("-"); 
  				$('#text-items').html(res[1]);
  				var out = json['total'].substr(0,json['total'].indexOf(' '));
  				$('#cart-total').html(out);
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				
				$('#cart > ul').load('index.php?route=common/cart/info ul li');
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');







$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#error-rev').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><p class="pull-left"> ' + json['error'] + '</p></div>');
			}

			if (json['success']) {
				$('.mfp-close').trigger("click");

				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});

$(document).ready(function() {
	$('.thumbnail a').click(
		function(){
			$.magnificPopup.open({
			  items: {
			    src:  $('img',this).attr('src')
			  },
			  type: 'image'
			});
			return false;
		}
	);
});

  
  $("[type='number']").keypress(function (evt) {
    evt.preventDefault();
});


//--></script>
<?php if( $productConfig['product_enablezoom'] ) { ?>

<script type="text/javascript">
//    var zoomCollection = '<?php echo $productConfig["product_zoomgallery"]=="basic"?".product-image-zoom":"#image";?>';
//    $( zoomCollection ).elevateZoom({
//   <?php if( $productConfig['product_zoommode'] != 'basic' ) { ?>
//   zoomType        : "<?php echo $productConfig['product_zoommode'];?>",
//    <?php } ?>
//    lensShape : "<?php echo $productConfig['product_zoomlensshape'];?>",
//    lensSize    : <?php echo (int)$productConfig['product_zoomlenssize'];?>,
//    easing:true,
//    gallery:'image-additional-carousel',
//    cursor: 'pointer',
//    galleryActiveClass: "active"
//  });

</script>
<?php } else { ?>
<script type="text/javascript">
$(document).ready(function() {
  $('.thumbnails').magnificPopup({
    type:'image',
    delegate: 'a',
    gallery: {
      enabled:true
    }
  });
});
</script>
<?php } ?>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '136605480272065'); 
fbq('track', 'viewContent');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=136605480272065&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '111739579465720'); 
fbq('track', 'viewContent');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=111739579465720&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '108538869836526'); 
fbq('track', 'viewContent');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=108538869836526&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->


         <div id="offerPopup" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal"><?php echo $offerclose; ?></button>
      </div>
    </div>

  </div>
</div>
         

         <script type="text/javascript">
  function openOfferPopup(id) {
      $.ajax({
      url: 'index.php?route=offers/salescombopge/popp',
      type: 'post',
      dataType: 'json',
      data: {"page_id" : id} ,
      success: function(json) {
        if(json.html != undefined) {
          if(json.html.title != undefined) {
            $('#offerPopup .modal-title').html(json.html.title);
          }
          if(json.html.description != undefined) {
            $('#offerPopup .modal-body').html(json.html.description);
          }
          $('#offerPopup').modal('show'); 
        } 
      }
    });
  }
</script>
         
<?php echo $footer; ?>
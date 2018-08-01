
<?php echo $header; ?>

<style>

    <?php echo $product_collection_style; ?>

</style>


<div class="container">
	<ul class="breadcrumb space-30">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		<?php } ?>
	</ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
		<div class="panel-heading space-20">
			<h1 class="panel-title panel-v1"><?php echo $heading_title; ?></h1>
		</div>
      <?php if ($products) { ?>
	  <div class="table-responsive product-block">
      <table class="table table-bordered">
        <thead>
          <tr>
            <td colspan="<?php echo count($products) + 1; ?>"><strong><?php echo $text_product; ?></strong></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $text_name; ?></td>
            <?php foreach ($products as $product) { ?>
            <td><a href="<?php echo $product['href']; ?>"><strong><?php echo $product['name']; ?></strong></a></td>
            <?php } ?>
          </tr>
          <tr>
            <td><?php echo $text_image; ?></td>
            <?php foreach ($products as $product) { ?>
            <td class="text-center">
              <?php if ($product['thumb']) { ?>
              <div class="image product-layout">


              <?php if( $product['special'] ) {   ?>
              <span style="font-size: 12px;" class="product-label sale-exist radius-3x text-center"><span class="product-label-special"><?php echo $objlang->get('text_sale'); ?></span></span>
              <?php } ?>

                <div class="product-img img ">

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
                <?php } else if($diff < 14) { ?>
                <div class="new-product">
                  <p><?php echo $text_new; ?></p>
                </div>
                <?php } else if ($product['quantity']<1 && isset($product['system'])) { ?>
                <div class="product-not-available">
                  <p><?php echo $product['system']; ?></p>
                </div>
                <?php } ?>





              <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" />


</div>

              </div>
              <?php } ?>
            </td>
            <?php } ?>
          </tr>
          <tr>
            <td><?php echo $text_price; ?></td>
            <?php foreach ($products as $product) { ?>
            <td><?php if ($product['price']) { ?>
              <?php if (!$product['special']) { ?>
              <?php echo $product['price']; ?>
              <?php } else { ?>
              <strike><?php echo $product['price']; ?></strike> <?php echo $product['special']; ?>
              <?php } ?>
              <?php } ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td><?php echo $text_model; ?></td>
            <?php foreach ($products as $product) { ?>
            <td><?php echo $product['model']; ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td><?php echo $text_manufacturer; ?></td>
            <?php foreach ($products as $product) { ?>
            <td><?php echo $product['manufacturer']; ?></td>
            <?php } ?>
          </tr>
         <!--
          <tr>
            <td><?php echo $text_availability; ?></td>
            <?php foreach ($products as $product) { ?>
            <td><?php echo $product['availability']; ?></td>
            <?php } ?>
          </tr>
-->
          <tr>
            <td><?php echo $text_COLOR;?></td>
            <?php foreach ($products as $product) { ?>
            <td>
                <?php $counter = 0; foreach($product['product_option_value'] as $product_option_value){ if($counter++ == 4) break; ?>
                    <img  src="<?php echo $product_option_value['image']; ?>" style="border: solid"; alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="options"/>
                <?php } ?>
            </td>
            <?php } ?>
          </tr>

          <?php if ($review_status) { ?>
          <tr>
            <td><?php echo $text_rating; ?></td>
            <?php foreach ($products as $product) { ?>
            <td class="rating">
			<?php for ($is = 1; $is <= 5; $is++) { ?>
				<?php if ($product['rating'] < $is) { ?>
					<span><i class="zmdi zmdi-star"></i></span>
				<?php } else { ?>
					<span class="rate"><i class="zmdi zmdi-star"></i></span>
				<?php } ?>
			<?php } ?>
              <br />
              <?php echo $product['reviews']; ?></td>
            <?php } ?>
          </tr>
          <?php } ?>
          <tr style="display:none">
            <td><?php echo $text_summary; ?></td>
            <?php foreach ($products as $product) { ?>
            <td class="description"><?php echo $product['description']; ?></td>
            <?php } ?>
          </tr>
          <tr style="display:none">
            <td><?php echo $text_weight; ?></td>
            <?php foreach ($products as $product) { ?>
            <td><?php echo $product['weight']; ?></td>
            <?php } ?>
          </tr>
          <tr style="display:none">
            <td><?php echo $text_dimension; ?></td>
            <?php foreach ($products as $product) { ?>
            <td><?php echo $product['length']; ?> x <?php echo $product['width']; ?> x <?php echo $product['height']; ?></td>
            <?php } ?>
          </tr>
        </tbody>
        <?php foreach ($attribute_groups as $attribute_group) { ?>
        <thead>
          <tr>
            <td colspan="<?php echo count($products) + 1; ?>"><strong><?php echo $attribute_group['name']; ?></strong></td>
          </tr>
        </thead>
        <?php foreach ($attribute_group['attribute'] as $key => $attribute) { ?>
        <tbody>
          <tr>
            <td><?php echo $attribute['name']; ?></td>
            <?php foreach ($products as $product) { ?>
            <?php if (isset($product['attribute'][$key])) { ?>
            <td><?php echo $product['attribute'][$key]; ?></td>
            <?php } else { ?>
            <td></td>
            <?php } ?>
            <?php } ?>
          </tr>
        </tbody>
        <?php } ?>
        <?php } ?>
        <tr>
          <td></td>
          <?php foreach ($products as $product) { if($product['availability']=="متوفر"||$product['availability']=="In Stock"){?>
          <td><input type="button"   value="<?php echo $button_cart; ?>" class="btn btn-primary btn-block" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');" /> <?php } else{ ?>
            <td><input type="button" disabled="true" value="<?php echo $button_cart; ?>" class="btn btn-primary btn-block" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');" /> <?php } ?>
            <a href="<?php echo $product['remove']; ?>" class="btn btn-danger btn-block"><?php echo $button_remove; ?></a></td>
          <?php } ?>
        </tr>
      </table>
	  </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-default"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>

<?php echo $header; ?>

<style>

  #myform {
    text-align: center;
    padding: 5px;
    border: 1px dotted #ccc;
    margin: 2%;
  }
  .qty {
    width: 25%;
    height: 25px;
    text-align: center;
  }
  input.qtyplus { width:25%; height:25px;}
  input.qtyminus { width:25%; height:25px;}
  input.remove {
    color: red;
    width:20%; height:25px;
    margin-left: 4px;
  }

</style>


<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($attention) { ?>
  <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $attention; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>

        <?php foreach($eligibleoffers['success'] as $key => $message) { ?>
          <div class="alert messagestripsuccess"><i class="fa fa-check-circle"></i> <?php echo $message; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
         <?php foreach($eligibleoffers['warning'] as $key => $message) { ?>
          <div class="alert messagestripwarning"><i class="fa fa-check-circle"></i> <?php echo $message; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        <?php } ?>

  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
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
      <h1><?php echo $heading_title; ?>

      </h1>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
            <tr>
              <td class="text-center"><?php echo $column_image; ?></td>
              <td class="text-left"><?php echo $column_name; ?></td>
              <!--<td class="text-left"><?php echo $column_model; ?></td>-->
              <td class="text-left"><?php echo $column_quantity; ?></td>
              <td class="text-right"><?php echo $column_price; ?></td>
              <td class="text-right"><?php echo $column_total; ?></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td class="text-center"><?php if ($product['thumb']) { ?>
                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
                <?php } ?>
              </td>
              <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                <?php if (!$product['stock']) { ?>
                <span class="text-danger">***</span>
                <?php } ?>
                <?php if ($product['option']) { ?>
                <?php foreach ($product['option'] as $option) { ?>
                <br />
                <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                <?php } ?>
                <?php } ?>
                <?php if ($product['reward']) { ?>
                <br />
                <small><?php echo $product['reward']; ?></small>
                <?php } ?>
                <?php if ($product['recurring']) { ?>
                <br />
                <span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
                <?php } ?>
              </td>


              <!--<td class="text-left"><?php echo $product['model']; ?></td>-->

              <td class="text-left"><div class="input-group btn-block" style="max-width: 200px;">
                  <input type="submit" value="-" class="qtyminus" field="quantity<?php echo $product['cart_id']; ?>" cart="quantity<?php echo $product['cart_id']; ?>" />
                  <input readonly  type="text" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" class="qty" max="<?php echo($product['stock_qty']); ?>" identifier="quantity<?php echo $product['cart_id']; ?>" />
                  <input type='submit' value='+' class='qtyplus' field="quantity<?php echo $product['cart_id']; ?>" cart="quantity<?php echo $product['cart_id']; ?>" />
                  <input type="button" value='X' class='remove'  onclick="cart.remove('<?php echo $product['cart_id']; ?>');">
                  <!--
              <?php echo($product['stock_qty']); ?>
              <input type="text" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" class="form-control" />
              <span class="input-group-btn">
              <button type="submit" data-toggle="tooltip" title="<?php echo $button_update; ?>" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
              <button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="cart.remove('<?php echo $product['cart_id']; ?>');"><i class="fa fa-times-circle"></i></button>
              </span></div>
              -->
              </td>
              <td class="text-right"><div id="price<?php echo $product['cart_id']; ?>"><?php echo $product['price']; ?></div></td>


              <td class="text-right"><div id="total<?php echo $product['cart_id']; ?>"><?php echo $product['total']; ?></div></td>



            </tr>
            <?php } ?>
            <?php foreach ($vouchers as $voucher) { ?>
            <tr>
              <td></td>
              <td class="text-left"><?php echo $voucher['description']; ?></td>
              <td class="text-left"></td>
              <td class="text-left"><div class="input-group btn-block" style="max-width: 200px;">
                  <input type="text" name="" value="1" size="1" disabled="disabled" class="form-control" />
                  <span class="input-group-btn">
                    <button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="voucher.remove('<?php echo $voucher['key']; ?>');"><i class="fa fa-times-circle"></i></button>
                    </span></div></td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
            </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>




            <?php if ($modules) { ?>
            <h2><?php echo $text_next; ?></h2>
            <p><?php echo $text_next_choice; ?></p>
            <div class="panel-group" id="accordion">
              <?php $count = 0;?>
              <?php foreach ($modules as $module) { ?>
              <?php $count++; if($count!=2) { ?>
              <?php echo $module; ?>
              <?php }} ?>
            </div>
            <?php } ?>
            <br />



      <div class="row">
        <div class="col-sm-4 col-sm-offset-8">
          <table class="table table-bordered">
            <?php foreach ($totals as $total) {   ?>
            <tr>
              <td class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
              <td class="text-right"> <div id="all_total"> <?php echo $total['text']; ?> </div> </td>
            </tr>
            <?php } ?>
          </table>
        </div>
      </div>
      <div class="buttons">
        <div class="pull-left"><a href="<?php echo $continue; ?>" class="btn btn-default"><?php echo $button_shopping; ?></a></div>
        <div class="pull-right"><button formaction="<?php echo $checkout; ?>" class="btn btn-default" > <?php echo $button_checkout; ?></button></div>
       </div>
      </form>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>

<script type="text/javascript">
      jQuery(document).ready(function(){
        $('.qtyplus').click(function(){
          fieldName = $(this).attr('field');
          var currentVal = parseInt($("input[ identifier="+fieldName+" ]").val());
          if (!isNaN(currentVal)) {
            $('input[identifier='+fieldName+']').val(currentVal + 1);
          }
        });
        $(".qtyminus").click(function() {
          fieldName = $(this).attr('field');
          var currentVal = parseInt( $('input[ identifier='+fieldName+' ]').val() );
          if (!isNaN(currentVal) && currentVal > 1) {
            $('input[identifier='+fieldName+']').val(currentVal - 1);

          }
        });
      });
</script>

<?php echo $footer; ?>
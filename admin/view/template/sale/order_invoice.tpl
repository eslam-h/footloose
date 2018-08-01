<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />

<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link href="view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="all" />
</head>
<body>
<div class="container">
  <?php foreach ($orders as $order) { ?>
  <div style="page-break-after: always;">
    <h1><?php echo $text_invoice; ?> #<?php echo $order['order_id']; ?></h1>
    <div class="pull-right"><img src="view/image/logo.png" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td colspan="2"><?php echo $text_order_detail; ?></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 50%;"><address>


            <b><?php echo $text_customer; ?></b> <?php echo $order['firstname']; ?>
            <?php echo $order['lastname']; ?><br />
            <b><?php echo $text_telephone; ?></b> <?php echo $order['customer_telephone']; ?><br />
            <b><?php echo $text_email; ?></b> <?php echo $order['customer_email']; ?><br />



          <td style="width: 50%;"><b><?php echo $text_date_added; ?></b> <?php echo $order['date_added']; ?><br />
            <?php if ($order['invoice_no']) { ?>
            <b><?php echo $text_invoice_no; ?></b> <?php echo $order['invoice_no']; ?><br />
            <?php } ?>
            <b><?php echo $text_order_id; ?></b> <?php echo $order['order_id']; ?><br />
            <b><?php echo $text_payment_method; ?></b> <?php echo $order['payment_method']; ?><br />
            <?php if ($order['shipping_method']) { ?>
            <b><?php echo $text_shipping_method; ?></b> <?php echo $order['shipping_method']; ?><br />
            <?php } ?></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td style="width: 50%;"><b><?php echo $text_payment_address; ?></b></td>
          <td style="width: 50%;"><b><?php echo $text_shipping_address; ?></b></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><address>
            <?php echo $order['payment_address']; ?>
            </address></td>
          <td><address>
            <?php echo $order['shipping_address']; ?>
            </address></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td><b><?php echo $column_product; ?></b></td>

          <td><b> SKU </b></td>

          <td><b><?php echo $column_model; ?></b></td>
          <td class="text-right"><b><?php echo $column_quantity; ?></b></td>
          <td class="text-right"><b><?php echo $column_price; ?></b></td>
          <td class="text-right"><b><?php echo $column_total; ?></b></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($order['product'] as $product) { ?>
        <tr>
          <td><?php echo $product['name']; ?>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
            <?php } ?></td>

          <td><?php echo $product['sku']; ?></td>

          <td><?php echo $product['model']; ?></td>
          <td class="text-right"><?php echo $product['quantity']; ?></td>
          <td class="text-right"><?php echo $product['price']; ?></td>
          <td class="text-right"><?php echo $product['total']; ?></td>
        </tr>
        <?php } ?>
        <?php foreach ($order['voucher'] as $voucher) { ?>
        <tr>
          <td><?php echo $voucher['description']; ?></td>
          <td></td>
          <td class="text-right">1</td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
        </tr>
        <?php } ?>
        <?php foreach ($order['total'] as $total) { ?>
        <tr>
          <td class="text-right" colspan="4"><b><?php echo $total['title']; ?></b></td>
          <td class="text-right"><?php echo $total['text']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php if ($order['comment']) { ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td><b><?php echo $text_comment; ?></b></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $order['comment']; ?></td>
        </tr>
      </tbody>
    </table>
    <?php } ?>

    <div class="row" style="font-size: 14px">


      <div class="col-lg-6">
        <p>
          Your order will be delivered within 3 to 7 business days from your order date.
          <br>
          You can exchange or return the items within 14 days with original receipt.
          <br>
          Items must be in brand-new condition, unused and with original tags attached.
          <br>
          Discounted and promotion items can be exchanged only and not returned.
          <br>
          Warning: Avoid exposing CROCS products to direct sunlight or extreme heat for a long time to prevent it from damage.
          <br>
          For any inquiries or requests please contact our customer service at:
          <br>
          Mobile: 010 676 007 70
          <br>
          Email: support@footloose.com.eg
          <br>
          Thanks for shopping at FootLoose website!
        </p>
      </div>

      <div style="direction: rtl" class="col-lg-6">
        <p>
          سوف يصل طلبك خلال مدة من ٣ ل٧ أيام عمل من تاريخ عمل الطلب.
          <br>
          يمكنك إستبدال أو إسترجاع المنتج خلال 14 يوم بشرط وجود فاتورة الشراء والمنتج في حالته الأصليه، غير مستخدم ومتصل به الكارت الأصلي للمنتج.
          <br>
          المنتجات المباعة وقت العروض أو التخفيضات يمكن إستبدالها فقط وليس إرجاعها.
          <br>
          تحذير: تجنب تعريض منتجات كروكس لأشعة الشمس المباشرة أو الحرارة العالية لمدة طويلة لكي لا يتلف المنتج.
          <br>
          لأي إستفسارات برجاء الإتصال بنا على خدمة العملاء على:
          <br>
          تليفون:
          70 007 676 010
          <br>
          بريد إلكتروني: support@footloose.com.eg
          <br>
          شكراً لتسوقك على موقع فوتلوس!
        </p>
      </div>


    </div>

    <br><br>

  </div>
  <?php } ?>

</div>

</body>
</html>

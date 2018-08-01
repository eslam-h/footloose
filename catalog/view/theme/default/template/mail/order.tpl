<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title><?php echo $title; ?></title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;">
<div style="width: 680px;"><a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>"><img src="<?php echo $logo; ?>" alt="<?php echo $store_name; ?>" style="margin-bottom: 20px; border: none;" /></a>

  <div class="pull-right"><img src="http://footloosedev.thegeeksolutions.com/image/catalog/logo_dark.png" alt="<?php echo $store_url; ?>" title="<?php echo $store_url; ?>" /></div>
  <br><br>

  <?php echo $text_current_status; ?>

  <br><br>
  <!--  <p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_greeting; ?></p>-->
  <?php if ($customer_id) { ?>
  <p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_link; ?></p>
  <p style="margin-top: 0px; margin-bottom: 20px;"><a href="<?php echo $link; ?>"><?php echo $link; ?></a></p>
  <?php } ?>
  <?php if ($download) { ?>
  <p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_download; ?></p>
  <p style="margin-top: 0px; margin-bottom: 20px;"><a href="<?php echo $download; ?>"><?php echo $download; ?></a></p>
  <?php } ?>
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
    <tr>
      <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="2"><?php echo $text_order_detail; ?></td>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><b><?php echo $text_order_id; ?></b> <?php echo $order_id; ?><br />
        <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br />
        <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
        <?php if ($shipping_method) { ?>
        <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
        <?php } ?></td>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><b><?php echo $text_email; ?></b> <?php echo $email; ?><br />
        <b><?php echo $text_telephone; ?></b> <?php echo $telephone; ?><br />
        <b><?php echo $text_ip; ?></b> <?php echo $ip; ?><br />
        <b><?php echo $text_order_status; ?></b> <?php echo $order_status; ?><br /></td>
    </tr>
    </tbody>
  </table>
  <?php if ($comment) { ?>
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
    <tr>
      <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_instruction; ?></td>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $comment; ?></td>
    </tr>
    </tbody>
  </table>
  <?php } ?>
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
    <tr>
      <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_payment_address; ?></td>
      <?php if ($shipping_address) { ?>
      <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_shipping_address; ?></td>
      <?php } ?>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $payment_address; ?></td>
      <?php if ($shipping_address) { ?>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $shipping_address; ?></td>
      <?php } ?>
    </tr>
    </tbody>
  </table>
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
    <tr>
      <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_product; ?></td>
      <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_model; ?></td>
      <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_quantity; ?></td>
      <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_price; ?></td>
      <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_total; ?></td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product) { ?>
    <tr>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $product['name']; ?>
        <?php foreach ($product['option'] as $option) { ?>
        <br />
        &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
        <?php } ?></td>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $product['model']; ?></td>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $product['quantity']; ?></td>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $product['price']; ?></td>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $product['total']; ?></td>
    </tr>
    <?php } ?>
    <?php foreach ($vouchers as $voucher) { ?>
    <tr>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $voucher['description']; ?></td>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"></td>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">1</td>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $voucher['amount']; ?></td>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $voucher['amount']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <?php foreach ($totals as $total) { ?>
    <tr>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="4"><b><?php echo $total['title']; ?>:</b></td>
      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $total['text']; ?></td>
    </tr>
    <?php } ?>
    </tfoot>
  </table>



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



  <p class="pull-left" style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_footer; ?></p>
</div>
</body>
</html>

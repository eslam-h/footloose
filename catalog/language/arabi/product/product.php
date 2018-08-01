<?php


// Text
$_['text_search']         = 'بحث';
$_['text_brand']          = 'الشركة';
$_['text_manufacturer']   = 'الشركة :';
$_['text_model']          = 'كود المنتج :';
$_['text_reward']         = 'نقاط المكافآت :'; 
$_['text_points']         = 'السعر بنقاط المكافآت :';
$_['text_stock']          = 'حالة التوفر :';
$_['text_instock']        = 'متوفر';
$_['text_tax']            = 'الضريبة :'; 
$_['text_discount']       = '%s أو أكثر %s';
$_['text_option']         = 'الخيارات المتاحة:';
$_['text_minimum']                            = 'يجب ان تشترى على الاقل عدد %s من هذا المنتج';
$_['text_reviews']                            = 'التقييمات (%s)';
$_['text_write']                              = 'اكتب تقييم';
$_['text_login']                              = 'من فضلك </a>سجل دخولك<a href="%s"> او </a>انشئ حساب جديد<a href="%s"> لتتمكن من كتابة تقييم';
//$_['text_login']                              = 'Please <a href="%s">login</a> or <a href="%s">register</a> to review';
$_['text_no_reviews']                         = 'لا يوجد تقييمات لهذا المنتج';
//$_['text_note']                = '<span class="text-danger">Note:</span> HTML is not translated!';
$_['text_note']                = '';
$_['text_success']                            = 'شكرا على تقييمك. يرجى العلم ان تقييمك نقل للمسؤل عن الموقع للموافقة عليةز';
$_['text_related']                            = 'منتجات مشابهة';
$_['text_tags']                               = 'الكلمات:';
$_['text_error']                              = 'لم يتم العثور على المنتج!';
$_['text_payment_recurring']                    = 'الملفات الشخصية للدفع';
$_['text_trial_description']                  = '%s every %d %s(s) for %d payment(s) then';
$_['text_payment_description']                = '%s every %d %s(s) for %d payment(s)';
$_['text_payment_until_canceled_description'] = '%s every %d %s(s) until canceled';
$_['text_day']                                = 'يوم';
$_['text_week']                               = 'اسبوع';
$_['text_semi_month']                         = 'نصف شهر';
$_['text_month']                              = 'شهر';
$_['text_year']                               = 'سنة';
$_['text_new']        = 'جديد';

$_['text_size_chart']        = 'دليل المقاس';

// Entry
$_['entry_qty']                               = 'الكمية';
$_['entry_name']          = 'الاسم:';
$_['entry_review']        = 'اضافة تعليق:';
$_['entry_rating']        = 'التقييم:';
$_['entry_good']          = 'ممتاز';
$_['entry_bad']           = 'رديء';
$_['entry_captcha']       = 'قم بإدخال رمز التحقق :';

// Tabs
$_['tab_description']     = 'تفاصيل';
$_['tab_attribute']       = 'المواصفات';
$_['tab_review']          = 'التقييمات (%s)';

// Error
$_['error_name']          = 'تحذير : الاسم يجب أن يكون أكثر من 3 وأقل من 25 رمزاً !';
$_['error_text']          = 'تحذير : يجب ان تكتب شيئا فى النص !';
$_['error_rating']        = 'تحذير : الرجاء اختيار استعراض التعليق !';
$_['error_captcha']       = 'تحذير : رمز التحقق لا يتطابق مع الصورة !';
$_['error_size_and_color']     = 'يجب اختيار لون و مقاس';



$_['product_style']             = '
	.product-layout{
		overflow: hidden;
	}

.new-product-not-available{
	color: white;
	position: absolute;
	text-transform: uppercase;
	text-align: center;
	border: 3px white double;
	width: 200px;
	background-color: #b90909;
	margin-right: -40px;
	margin-top: 45px;
	-ms-transform: rotate(45deg);
	-webkit-transform: rotate(45deg);
	transform: rotate(45deg);
	z-index: 3;
	height: 27px;
}

.new-product-not-available p{
	padding-top: 1px;
	width: 120px;
	margin: auto;
	font-size: 11px;
	margin-left: 30px;
}

.new-product-not-available:before{
	-ms-transform: rotate(45deg);
	-webkit-transform: rotate(45deg);
	transform: rotate(45deg);
	content:"*";
	color: transparent;
	position: absolute;
	z-index: -1;
	border-left: 15px solid transparent;
	border-bottom: 5px solid transparent;
	border-top: 15px solid transparent;
	border-right: 15px solid #890606;
	height: 0;
	width: 0;
	margin-right: -90px;
	margin-top: 11px;
}

	.new-product{
		color: white;
		position: absolute;
		text-transform: uppercase;
		text-align: center;
		border: 3px white double;
		width: 200px;
		background-color: #5fb937;
		margin-right: -40px;
		margin-top: 45px;
		-ms-transform: rotate(45deg);
		-webkit-transform: rotate(45deg);
		transform: rotate(45deg);
		z-index: 3;
		height: 27px;
	}

	.new-product p{
		padding-top: 1px;
		width: 120px;
		margin: auto;
		font-size: 11px;
		margin-left: 30px;
	}

	.new-product:before{
		-ms-transform: rotate(45deg);
		-webkit-transform: rotate(45deg);
		transform: rotate(45deg);
		content:"*";
		color: transparent;
		position: absolute;
		z-index: -1;
		border-left: 15px solid transparent;
		border-bottom: 5px solid transparent;
		border-top: 15px solid transparent;
		border-right: 15px solid #3f8919;
		height: 0;
		width: 0;
		margin-right: -90px;
		margin-top: 11px;
	}';

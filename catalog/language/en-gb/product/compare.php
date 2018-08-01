<?php
// Heading
$_['heading_title']     = 'Product Comparison';

// Text
$_['text_product']      = 'Product Details';
$_['text_name']         = 'Product';
$_['text_COLOR']      = 'color';
$_['text_image']        = 'Image';
$_['text_price']        = 'Price';
$_['text_model']        = 'Model';
$_['text_manufacturer'] = 'Brand';
$_['text_availability'] = 'Availability';
$_['text_instock']      = 'In Stock';
$_['text_rating']       = 'Rating';
$_['text_reviews']      = 'Based on %s reviews.';
$_['text_summary']      = 'Summary';
$_['text_weight']       = 'Weight';
$_['text_dimension']    = 'Dimensions (L x W x H)';
$_['text_compare']      = 'Product Compare (%s)';
$_['text_success']      = 'Success: You have added <a href="%s">%s</a> to your <a href="%s">product comparison</a>!';
$_['text_remove']       = 'Success: You have modified your product comparison!';
$_['text_empty']        = 'You have not chosen any products to compare.';

$_['text_new']              = 'NEW';



$_['product_collection_style']        = '
.product-layout{
	overflow: hidden;
}

.product-not-available{
	color: white;
	position: absolute;
	text-transform: uppercase;
	text-align: center;
	border: 3px white double;
	width: 200px;
	background-color: #b90909;
	margin-left: -65px;
	margin-top: 15px;
	-ms-transform: rotate(-45deg);
	-webkit-transform: rotate(-45deg);
	transform: rotate(-45deg);
	z-index: 3;
	height: 27px;
}



.product-not-available p{
	padding-top: 5px;
	width: 120px;
	margin: auto;
	font-size: 9px;
	margin-left: 30px;
}

.product-not-available:before{
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
	margin-left: -72px;
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
	margin-left: -65px;
	margin-top: 15px;
	-ms-transform: rotate(-45deg);
	-webkit-transform: rotate(-45deg);
	transform: rotate(-45deg);
	z-index: 3;
	height: 27px;
}

.new-product p{
	padding-top: 4px;
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
	margin-left: -72px;
	margin-top: 11px;
}';
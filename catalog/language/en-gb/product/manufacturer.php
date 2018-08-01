<?php
// Heading
$_['heading_title']     = 'Find Your Favorite Brand';

// Text
$_['text_brand']        = 'Brand';
$_['text_index']        = 'Brand Index:';
$_['text_error']        = 'Brand not found!';
$_['text_empty']        = 'There are no products to list.';
$_['text_quantity']     = 'Qty:';
$_['text_manufacturer'] = 'Brand:';
$_['text_model']        = 'Product Code:';
$_['text_points']       = 'Reward Points:';
$_['text_price']        = 'Price:';
$_['text_tax']          = 'Ex Tax:';
$_['text_compare']      = 'Product Compare (%s)';
$_['text_sort']         = 'Sort By:';
$_['text_default']      = 'Default';
$_['text_name_asc']     = 'Name (A - Z)';
$_['text_name_desc']    = 'Name (Z - A)';
$_['text_price_asc']    = 'Price (Low &gt; High)';
$_['text_price_desc']   = 'Price (High &gt; Low)';
$_['text_rating_asc']   = 'Rating (Lowest)';
$_['text_rating_desc']  = 'Rating (Highest)';
$_['text_model_asc']    = 'Model (A - Z)';
$_['text_model_desc']   = 'Model (Z - A)';
$_['text_limit']        = 'Show:';
$_['text_new']        = 'NEW';

$_['all']        = 'all';
$_['crocs']        = 'crocs';
$_['joy&mario']        = 'joy&mario';
$_['flossy']        = 'flossy';
$_['juju']        = 'juju';



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
	margin-left: -74px;
	margin-top: 15px;
	-ms-transform: rotate(-45deg);
	-webkit-transform: rotate(-45deg);
	transform: rotate(-45deg);
	z-index: 3;
	height: 27px;
}



.product-not-available p{
	padding-top: 1px;
	width: 120px;
	margin: auto;
	font-size: 11px;
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
	margin-left: -82px;
	margin-top: 11px;
}

.not-available-mark{
	position: absolute;
	text-transform: uppercase;
	background-color: #b90909;
	color: white;
	font-size: 30px;
	padding: 10px;
	padding-left: 10px;
	padding-right: 10px;
	border: 5px white double;
	-ms-transform: rotate(-45deg); /* IE 9 */
	-webkit-transform: rotate(-45deg); /* Chrome, Safari, Opera */
	transform: rotate(-45deg);
	left: 33%;
	margin-top: 94px;
	left: 50%;
	margin-left: -140px;
	width: 280px;
	text-align: center;
}

.new-product{
	color: white;
	position: absolute;
	text-transform: uppercase;
	text-align: center;
	border: 3px white double;
	width: 200px;
	background-color: #5fb937;
	margin-left: -74px;
	margin-top: 15px;
	-ms-transform: rotate(-45deg);
	-webkit-transform: rotate(-45deg);
	transform: rotate(-45deg);
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
	margin-left: -82px;
	margin-top: 11px;
}';
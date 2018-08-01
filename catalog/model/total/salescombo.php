<?php
class ModelTotalSalescombo extends Model {
	public function getTotal($total) {
		$this->load->language('total/salescombo');
	    $totaldiscount = array();
	    $this->session->data['salescombo_netdiscount']  = 0;
		foreach ($this->cart->getProducts() as $product) {
		    $key = $product['cart_id'];
			if(isset($this->session->data['cartbindercombooffers'][$key])) {
				$discount = 0;
				if(isset($totaldiscount[$this->session->data['cartbindercombooffers'][$key]['variation']][$this->session->data['cartbindercombooffers'][$key]['id']])) {
					$discount = $totaldiscount[$this->session->data['cartbindercombooffers'][$key]['variation']][$this->session->data['cartbindercombooffers'][$key]['id']]['discountdone'];
				}
	        	$totaldiscount[$this->session->data['cartbindercombooffers'][$key]['variation']][$this->session->data['cartbindercombooffers'][$key]['id']] = array(
				'discountdone'	=> $discount + $this->session->data['cartbindercombooffers'][$key]['discountdone'],
	    		'name' => $this->session->data['cartbindercombooffers'][$key]['name']
	    		);
		    }
		}
		
		foreach ($totaldiscount as $variation => $disounts) {
			foreach ($disounts as $key => $value) {
				$charge = $this->currency->format($value['discountdone'], $this->session->data['currency']);
				$total['totals'][] = array(
				'code'       => 'salescombo',
				'title'      => sprintf($this->language->get('text_salescombo'),$value['name'],$charge),
				'value'      => -$value['discountdone'],
				'sort_order' => $this->config->get('salescombo_sort_order')
				);
				$total['total'] -= $value['discountdone'];
			}
		}
	}

	public function getAvailableOffers($product_id) {
		$availableoffers['notab'] = "";
		$availableoffers['tab'] = "";
		return $availableoffers;
	}

	public function checkCg($cids = array()) {
  		$cggrup = json_decode($cids,true);
        if(!empty($cggrup)) {
        	$cgid = $this->customer->getGroupId();
         	if(!in_array($cgid, $cggrup)) {
            	return 1;
         	}
        }
        return 0;
    }

	public function optionnames($optionids) {
		$optionarray = explode(",", $optionids);
		
		$name = $out = "";
		foreach ($optionarray as $key => $value) {
			$optionname =  $this->getOptionName($value);
			$name .= $out.$optionname;
			$out = "<br>";
		}
		return $name;
		
	}

	public function getOptionName($product_option_value_id) {
		if($product_option_value_id) {
			$product_option_value_query = $this->db->query("SELECT ovd.name as name FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id = ovd.option_value_id)  WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND ovd.language_id = '".$this->config->get('config_language_id')."' ");
			if($product_option_value_query->num_rows) {
				return $product_option_value_query->row['name'];
			}
		} 
		return "";
	}

	public function generateOffer($value = array()) {
		  $primaryarray = explode(",",$value['primarypids']);
	      $this->load->model("catalog/product");
	      $this->load->model("catalog/category");
	      $this->load->model("offers/salescombopge");
	      $this->load->model('tool/image');
	      $data['offers'][$value['id']]['id'] = $value['variation']."_".$value['id'];
	      $data['offers'][$value['id']]['name'] = $value['name'];
	      $data['offers'][$value['id']]['bundle'] = isset($value['bundle'])?$value['bundle']:0;
	      if($value['type']) {
	        $discount = $this->currency->format($value['discount'], $this->session->data['currency']);
	        $data['offers'][$value['id']]['offervalue'] = sprintf($this->language->get("fixedoff"),$discount);
	      } else {
	        $data['offers'][$value['id']]['offervalue'] = sprintf($this->language->get("percentageoff"),$value['discount']);
	      }
	      $data['offers'][$value['id']]['offerpage'] = "";
	      if($value['sales_offer_id']) {
	        $salescombopge_info = $this->model_offers_salescombopge->getPage($value['sales_offer_id']);
	        if ($salescombopge_info) {
	          $url = $this->url->link('offers/salescombopge', 'page_id=' .  $value['sales_offer_id'], "SSL");
	          $data['offers'][$value['id']]['offerpage'] = sprintf($this->language->get('readmore_offerpage'), $url, $salescombopge_info['title']);
	        }
	      }

	      $data['offers'][$value['id']]['addproducts'] = array();
	      foreach ($primaryarray as $key => $product_id) {
	        $product_info = $this->model_catalog_product->getProduct($product_id);
	        $product_name = $product_info['name'];
	        if ($product_info['image']) {
	          $thumb = $this->model_tool_image->resize($product_info['image'], 75, 75);
	        } else {
	          $thumb = $this->model_tool_image->resize('placeholder.png', 75, 75);
	        }
	        if($value['variation'] == 6) {
	        	$optionnames = $this->optionnames($value['optionids']);
	        } else {
	        	$optionnames = "";
	        }
	        $data['offers'][$value['id']]['addproducts'][] = array(
	          'name' => $product_name,
	          'product_id' => $product_id,
	          'href' => $this->url->link('product/product', 'product_id=' . $product_id, 'SSL'),
	          'thumb' => $thumb,
	          'priqty' => $value['primaryquant'],
	          'secqty' => $value['secondaryquant'],
	          'optionnames' => $optionnames,
	        );
	      }

	      if($value['variation'] == 3 || $value['variation'] == 6) {
	      	$data['offers'][$value['id']]['getproducts'] = $data['offers'][$value['id']]['addproducts'];
	      } else if ($value['variation'] == 5) {
	      	$secondaryarray = explode(",",$value['secondarycids']);
		    $data['offers'][$value['id']]['getcategories'] = array();
		    foreach ($secondaryarray as $key => $category_id) {
		        $category_info = $this->model_catalog_category->getCategory($category_id);
		        $category_name = $category_info['name'];
		        if ($category_info['image']) {
		          $thumb = $this->model_tool_image->resize($category_info['image'], 75, 75);
		        } else {
		          $thumb = $this->model_tool_image->resize('placeholder.png', 75, 75);
		        }
		        $data['offers'][$value['id']]['getcategories'][] = array(
		          'name' => $category_name,
		          'href' => $this->url->link('product/category', 'path=' . $category_id, 'SSL'),
		          'thumb' => $thumb,
		          'secqty' => $value['secondaryquant'],
		        );
		    }
	      } else if($value['variation'] == 1) {
	      	$secondaryarray = explode(",",$value['secondarypids']);
	        $data['offers'][$value['id']]['getproducts'] = array();
	        foreach ($secondaryarray as $key => $product_id) {
		        $product_info = $this->model_catalog_product->getProduct($product_id);
		        $product_name = $product_info['name'];
		        if ($product_info['image']) {
		          $thumb = $this->model_tool_image->resize($product_info['image'], 75, 75);
		        } else {
		          $thumb = $this->model_tool_image->resize('placeholder.png', 75, 75);
		        }
		        $data['offers'][$value['id']]['getproducts'][] = array(
		          'name' => $product_name,
		          'product_id' => $product_id,
		          'href' => $this->url->link('product/product', 'product_id=' . $product_id, 'SSL'),
		          'thumb' => $thumb,
		          'secqty' => $value['secondaryquant'],
		        );
	        }
	      }
	      return $data['offers'];
	}
}
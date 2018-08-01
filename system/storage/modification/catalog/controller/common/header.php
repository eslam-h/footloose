<?php
class ControllerCommonHeader extends Controller {
	public function index() {

        $this->load->model('tool/image');

		// Pavo 2.2 fix
		require_once( DIR_SYSTEM . 'pavothemes/loader.php' );

		$this->load->language('module/themecontrol');
		$data['objlang'] = $this->language;
		$this->load->language('product/compare');

		$data['products'] = array();



        $data['attribute_groups'] = array();

        $isTouch =isset($this->session->data['compare']);
        if($isTouch==true){

        foreach ($this->session->data['compare'] as $key => $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);

            if ($product_info) {
//				if ($product_info['image']) {
//					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_compare_width'), $this->config->get($this->config->get('config_theme') . '_image_compare_height'));
//				} else {
//					$image = false;
//				}

                $placeholder = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));

                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $price = false;
                }

                if ((float)$product_info['special']) {
                    $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $special = false;
                }

                if ($product_info['quantity'] <= 0) {
                    $availability = $product_info['stock_status'];
                } elseif ($this->config->get('config_stock_display')) {
                    $availability = $product_info['quantity'];
                } else {
                    $availability = $this->language->get('text_instock');
                }

                $attribute_data = array();

                $attribute_groups = $this->model_catalog_product->getProductAttributes($product_id);

                foreach ($attribute_groups as $attribute_group) {
                    foreach ($attribute_group['attribute'] as $attribute) {
                        $attribute_data[$attribute['attribute_id']] = $attribute['text'];
                    }
                }


                $product_option_value_data = array();
                foreach ($this->model_catalog_product->getProductCartOptions($product_info['product_id']) as $option) {
                    foreach ($option['product_option_value'] as $option_value) {
                        if ((!$option_value['subtract'] || $option_value['quantity'] > 0) ) {
                            $product_option_value_data[] = array(
                                'name'                    => $option_value['name'],
                                'image'                   => $this->model_tool_image->resize($option_value['image'].".png", 25, 25)
                            );
                        }
                    }
                }

           //   print_r($product_option_value_data);

                $product_cart_images = $this->model_catalog_product->resizeProductCartImages($product_info['product_id'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));

                $data['products'][$product_id] = array(
                    'product_option_value'  => $product_option_value_data,
                    'product_id'   => $product_info['product_id'],
                    'name'         => $product_info['name'],
//					'thumb'        => $image,
                    'price'        => $price,
                    'special'      => $special,
                    'description'  => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..',
                    'model'        => $product_info['model'],
                    'manufacturer' => $product_info['manufacturer'],
                    'availability' => $availability,
                    'minimum'      => $product_info['minimum'] > 0 ? $product_info['minimum'] : 1,
                    'rating'       => (int)$product_info['rating'],
                    'reviews'      => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
                    'weight'       => $this->weight->format($product_info['weight'], $product_info['weight_class_id']),
                    'length'       => $this->length->format($product_info['length'], $product_info['length_class_id']),
                    'width'        => $this->length->format($product_info['width'], $product_info['length_class_id']),
                    'height'       => $this->length->format($product_info['height'], $product_info['length_class_id']),
                    'attribute'    => $attribute_data,
                    'href'         => $this->url->link('product/product', 'product_id=' . $product_id),
                    'remove'       => $this->url->link('product/compare', 'remove=' . $product_id),
                    'images'                =>$product_cart_images,
                    'placeholder'           =>$placeholder
                );

                foreach ($attribute_groups as $attribute_group) {
                    $data['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];

                    foreach ($attribute_group['attribute'] as $attribute) {
                        $data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
                    }
                }
            } else {
                unset($this->session->data['compare'][$key]);
            }
        }}





        $config = $this->registry->get('config');
		$data['sconfig'] = $config;

		$helper = ThemeControlHelper::getInstance( $this->registry, $config->get('theme_default_directory') );
		$helper->triggerUserParams( array('header_layout','productlayout') );
		$data['helper'] = $helper;

		$themeConfig = (array)$config->get('themecontrol');

		$headerlayout = $helper->getConfig('header_layout','header-v1');
		$data['headerlayout'] = $headerlayout;
		// Pavo 2.2 end fixheader

		// Analytics
		$this->load->model('extension/extension');

		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('analytics/' . $analytic['code'], $this->config->get($analytic['code'] . '_status'));
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
$this->document->addStyle('catalog/view/theme/default/stylesheet/slsoffr.css');
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');

		// Wishlist
		if ($this->customer->isLogged()) {
            $this->load->model('account/wishlist');
            $this->load->model('account/customer');
//
            $user_data = $this->model_account_customer->getCustomer((int)$this->customer->getId());
            $data['text_account'] = $user_data['firstname']." ".$user_data['lastname'];

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

                $data['languageMenu_2'] = $this->language->get('languageMenu_2');
		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));


		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_compare'] = $this->language->get('text_compare');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['compare'] = $this->url->link('product/compare', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		// For page specific css

        $this->load->language('offers/salescombopge');
        $data['text_salescombopge_heading'] = $this->language->get('text_salescombopge_heading');
        $data['salescombopge_info'] = array();
        $this->load->model('offers/salescombopge');
        $salescombopge_info = $this->model_offers_salescombopge->getPages();
        foreach ($salescombopge_info as $key => $value) {
         if($value['top']) {
          $data['salescombopge_info'][] = array(
            'name'=> $value['title'],
            'href' => $this->url->link('offers/salescombopge', 'page_id=' .  $value['salescombopge_id']),
            'id' => "",
            'children_level2' => array()
          );
         } 
        }
        if(!empty($data['salescombopge_info'])) {
          $data['categories'][] = array(
            'name'     => $data['text_salescombopge_heading'],
            'children' => $data['salescombopge_info'],
            'column'   => 1,
            'href'     => $this->url->link("offers/alloffers")
          );
        }

        
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} elseif (isset($this->request->get['information_id'])) {
				$class = '-' . $this->request->get['information_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('theme_default_directory') . '/template/common/'.$headerlayout.'.tpl')) {
			$header = $headerlayout;
		} else {
			$header = "header";
		}

		return $this->load->view('common/'.$header, $data);
	}
}

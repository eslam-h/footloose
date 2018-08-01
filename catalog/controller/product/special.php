<?php
class ControllerProductSpecial extends Controller {







	public function index() {

		// pavo version 2.2
		$this->load->language('module/themecontrol');
		$data['objlang'] = $this->registry->get('language');
		$data['ourl'] = $this->registry->get('url');

		$config = $this->registry->get("config");
		$data['sconfig'] = $config;
		$data['themename'] = $config->get("theme_default_directory");
		// end edit
		
		$this->load->language('product/special');

        $this->load->model('catalog/product');

		$this->load->model('tool/image');

        $data['plus_pic'] = $this->model_tool_image->resize('catalog/plus-sign.png', 52, 25);
        $data['text_more_details'] = $this->language->get('text_more_details');

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'RAND()';
		}

        if (isset($this->request->get['brand'])) {
            $brand = $this->request->get['brand'];
        } else {
            $brand = 'no brand';
        }

        if (isset($this->request->get['category'])) {
            $category = $this->request->get['category'];
        } else {
            $category = 'no category';
        }

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
//			$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
            $limit = 100;
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

        if (isset($this->request->get['brand'])) {
            $url .= '&brand=' . $this->request->get['brand'];
        }

        if (isset($this->request->get['category'])) {
            $url .= '&category=' . $this->request->get['category'];
        }

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('product/special', $url)
		);

		$data['heading_title'] = $this->language->get('heading_title');
        $data['product_collection_style'] = $this->language->get('product_collection_style');

		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_quantity'] = $this->language->get('text_quantity');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_model'] = $this->language->get('text_model');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_points'] = $this->language->get('text_points');
		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$data['text_sort'] = $this->language->get('text_sort');
		$data['text_limit'] = $this->language->get('text_limit');
        $data['text_new'] = $this->language->get('text_new');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['button_list'] = $this->language->get('button_list');
		$data['button_grid'] = $this->language->get('button_grid');
		$data['button_continue'] = $this->language->get('button_continue');

		$data['compare'] = $this->url->link('product/compare');

		$data['products'] = array();

        $data['out_of_stock_label_style'] = false;

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit,
            'brand' => $brand,
            'category' => $category
		);

		$product_total = $this->model_catalog_product->getTotalProductSpecials();

		$results = $this->model_catalog_product->getProductSpecials($filter_data);

        if ($this->config->get('out_of_stock_label_enabled')) {
            $this->load->model('module/out_of_stock_label');
            $data['text_out_of_stock'] = $this->model_module_out_of_stock_label->getLabel((int) $this->config->get('config_language_id'));
            $data['out_of_stock_label_style'] = htmlspecialchars_decode($this->config->get('out_of_stock_label_style'));
        }

		foreach ($results as $result) {


			
                $placeholder = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));

			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			}


//            $first_option = $this->model_catalog_product->getFirstColorOptionSku($result['product_id']);
//
//            $product_cart_images = $this->model_catalog_product->resizeProductCartImages($result['product_id'], $first_option, $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));

//            $product_cart_images = $this->model_catalog_product->resizeProductCartImages($result['product_id'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));

            $optionsSku = $this->model_catalog_product->getOptionsSku($result['product_id']);

            $product_cart_images = $this->model_catalog_product->resizeProductCartImages($result['product_id'], $optionsSku, $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));



            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$price = false;
			}

			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$special = false;
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
			} else {
				$tax = false;
			}

			if ($this->config->get('config_review_status')) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}

            $product_option_value_data = array();
            foreach ($this->model_catalog_product->getProductCartOptions($result['product_id']) as $option) {
                foreach ($option['product_option_value'] as $option_value) {
                    if ((!$option_value['subtract'] || ($option_value['quantity'] > 0))){

                        $option_image = $this->model_tool_image->resize($option_value['image'], 52, 25);
                        if(!isset($option_image))
                            continue;

                        $product_option_value_data[] = array(
                            'name'                    => $option_value['name'],
                            'image'                   => $option_image
                        );

                    }
                }
            }

            $data['products'][] = array(
                'quantity' => ($this->config->get('out_of_stock_label_enabled'))?$this->model_module_out_of_stock_label->getQuantity($result):1,
                'product_option_value'  => $product_option_value_data,
				'product_id'  => $result['product_id'],
				'images'       => $product_cart_images,
				'name'        => $result['name'],
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
				'price'       => $price,
				'special'     => $special,
				'tax'         => $tax,
				'placeholder'           => $placeholder,
				'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
				'rating'      => $result['rating'],
				'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url),
                'date_available'        => $result['date_available']
			);
		}


        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['category'])) {
            $url .= '&category=' . $this->request->get['category'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }

        $data['brands'] = array();

        $this->load->model('catalog/manufacturer');
        $this->load->language('product/manufacturer');

		$brands_info = $this->model_catalog_manufacturer->getManufacturers();

        $data['text_brand'] = $this->language->get('text_brand');
        $data['brands'][] = array(
            'text'  => $this->language->get('all'),
            'value' => 'no brand',
            'href'  => $this->url->link('product/special', 'brand=no brand' . $url)
        );
        
        foreach ($brands_info as $one_brand)
        {
            $data['brands'][] = array(
                'text'  => $this->language->get($one_brand['name']),
                'value' => $one_brand['manufacturer_id'],
                'href'  => $this->url->link('product/special', 'brand='. $one_brand['manufacturer_id'] . $url)
            );
        }


        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['brand'])) {
            $url .= '&brand=' . $this->request->get['brand'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }

        $data['categorys'] = array();

        $this->load->model('catalog/category');
        $this->load->language('product/category');

        $categorys_info = $this->model_catalog_category->getCategories();

        $data['text_category'] = $this->language->get('text_category');
        $data['categorys'][] = array(
            'text'  => $this->language->get('all'),
            'value' => 'no category',
            'href'  => $this->url->link('product/special', 'category=no category' . $url)
        );

        foreach ($categorys_info as $one_category)
        {
            $data['categorys'][] = array(
                'text'  => $this->language->get($one_category['name']),
                'value' => $one_category['category_id'],
                'href'  => $this->url->link('product/special', 'category='. $one_category['category_id'] . $url)
            );
        }

        $url = '';

        if (isset($this->request->get['brand'])) {
            $url .= '&brand=' . $this->request->get['brand'];
        }

        if (isset($this->request->get['category'])) {
            $url .= '&category=' . $this->request->get['category'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }

		$data['sorts'] = array();

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_default'),
			'value' => 'p.sort_order-ASC',
			'href'  => $this->url->link('product/special', 'sort=p.sort_order&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_asc'),
			'value' => 'pd.name-ASC',
			'href'  => $this->url->link('product/special', 'sort=pd.name&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_desc'),
			'value' => 'pd.name-DESC',
			'href'  => $this->url->link('product/special', 'sort=pd.name&order=DESC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_asc'),
			'value' => 'ps.price-ASC',
			'href'  => $this->url->link('product/special', 'sort=ps.price&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_desc'),
			'value' => 'ps.price-DESC',
			'href'  => $this->url->link('product/special', 'sort=ps.price&order=DESC' . $url)
		);

		if ($this->config->get('config_review_status')) {
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href'  => $this->url->link('product/special', 'sort=rating&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href'  => $this->url->link('product/special', 'sort=rating&order=ASC' . $url)
			);
		}

		$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/special', 'sort=p.model&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_model_desc'),
			'value' => 'p.model-DESC',
			'href'  => $this->url->link('product/special', 'sort=p.model&order=DESC' . $url)
		);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['brand'])) {
            $url .= '&brand=' . $this->request->get['brand'];
        }

        if (isset($this->request->get['category'])) {
            $url .= '&category=' . $this->request->get['category'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

		$data['limits'] = array();

		$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

		sort($limits);

		foreach($limits as $value) {
			$data['limits'][] = array(
				'text'  => $value,
				'value' => $value,
				'href'  => $this->url->link('product/special', $url . '&limit=' . $value)
			);
		}

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['brand'])) {
            $url .= '&brand=' . $this->request->get['brand'];
        }

        if (isset($this->request->get['category'])) {
            $url .= '&category=' . $this->request->get['category'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('product/special', $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

		// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
		if ($page == 1) {
		    $this->document->addLink($this->url->link('product/special', '', true), 'canonical');
		} elseif ($page == 2) {
		    $this->document->addLink($this->url->link('product/special', '', true), 'prev');
		} else {
		    $this->document->addLink($this->url->link('product/special', 'page='. ($page - 1), true), 'prev');
		}

		if ($limit && ceil($product_total / $limit) > $page) {
		    $this->document->addLink($this->url->link('product/special', 'page='. ($page + 1), true), 'next');
		}

		$data['sort'] = $sort;
		$data['order'] = $order;
        $data['limit'] = $limit;
        $data['brand_value'] = $brand;
        $data['category_value'] = $category;

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

	//	print_r($data);
	//	print_r($data['products']);

		$this->response->setOutput($this->load->view('product/special', $data));
	}
}

<?php
class ModelCatalogProduct extends Model {
    public function updateViewed($product_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = (viewed + 1) WHERE product_id = '" . (int)$product_id . "'");
    }
    // change will be here
    public function getProduct($product_id) {
        $query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND p.quantity > 0 AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

        if ($query->num_rows) {
            return array(
                'product_id'       => $query->row['product_id'],
                'name'             => $query->row['name'],
                'description'      => $query->row['description'],
                'meta_title'       => $query->row['meta_title'],
                'meta_description' => $query->row['meta_description'],
                'meta_keyword'     => $query->row['meta_keyword'],
                'tag'              => $query->row['tag'],
                'model'            => $query->row['model'],
                'sku'              => $query->row['sku'],
                'upc'              => $query->row['upc'],
                'ean'              => $query->row['ean'],
                'jan'              => $query->row['jan'],
                'isbn'             => $query->row['isbn'],
                'mpn'              => $query->row['mpn'],
                'location'         => $query->row['location'],
                'quantity'         => $query->row['quantity'],
                'stock_status'     => $query->row['stock_status'],
                'image'            => $query->row['image'],
                'manufacturer_id'  => $query->row['manufacturer_id'],
                'manufacturer'     => $query->row['manufacturer'],
                'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
                'special'          => $query->row['special'],
                'reward'           => $query->row['reward'],
                'points'           => $query->row['points'],
                'tax_class_id'     => $query->row['tax_class_id'],
                'date_available'   => $query->row['date_available'],
                'weight'           => $query->row['weight'],
                'weight_class_id'  => $query->row['weight_class_id'],
                'length'           => $query->row['length'],
                'width'            => $query->row['width'],
                'height'           => $query->row['height'],
                'length_class_id'  => $query->row['length_class_id'],
                'subtract'         => $query->row['subtract'],
                'rating'           => round($query->row['rating']),
                'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
                'minimum'          => $query->row['minimum'],
                'sort_order'       => $query->row['sort_order'],
                'status'           => $query->row['status'],
                'date_added'       => $query->row['date_added'],
                'date_modified'    => $query->row['date_modified'],
                'viewed'           => $query->row['viewed']
            );
        } else {
            return false;
        }
    }

    public function getProducts($data = array()) {
        $sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
            } else {
                $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
            }

            if (!empty($data['filter_filter'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
            } else {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
            }
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.quantity > 0 AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
            } else {
                $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }

            if (!empty($data['filter_filter'])) {
                $implode = array();

                $filters = explode(',', $data['filter_filter']);

                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }

                $sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
            }
        }

        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
            $sql .= " AND (";

            if (!empty($data['filter_name'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

                foreach ($words as $word) {
                    $implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
                }

                if ($implode) {
                    $sql .= " " . implode(" AND ", $implode) . "";
                }

                if (!empty($data['filter_description'])) {
                    $sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
                }
            }

            if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                $sql .= " OR ";
            }

            if (!empty($data['filter_tag'])) {
                $sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
            }

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }

            $sql .= ")";
        }

        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
        }

        $sql .= " GROUP BY p.product_id";

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.quantity',
            'p.price',
            'rating',
            'p.sort_order',
            'p.date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
            } elseif ($data['sort'] == 'p.price') {
                $sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
            } else {
                $sql .= " ORDER BY " . $data['sort'];
            }
        } else {
            $sql .= " ORDER BY p.sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC, LCASE(pd.name) DESC";
        } else {
            $sql .= " ASC, LCASE(pd.name) ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $product_data = array();

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }

        return $product_data;
    }

    public function getProductSpecials($data = array()) {

        $filters = '';
        if(isset($data['brand']) && $data['brand'] != 'no brand')
        {
            $filters .= " p.manufacturer_id = '". $data['brand'] ."' and ";
        }

        if(isset($data['category']) && $data['category'] != 'no category')
        {
            $filters .= " p.product_id = p2c.product_id and p2c.category_id = '". $data['category'] ."' and ";
        }

        $sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_to_category p2c, " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE " . $filters . " p.status = '1' AND p.quantity > 0 AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

        $sort_data = array(
            'RAND()',
            'pd.name',
            'p.model',
            'ps.price',
            'rating',
            'p.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
            } else {
                $sql .= " ORDER BY " . $data['sort'];
            }
        } else {
            $sql .= " ORDER BY p.sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC, LCASE(pd.name) DESC";
        } else {
            $sql .= " ASC, LCASE(pd.name) ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $product_data = array();

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }

        return $product_data;
    }

    public function getLatestProducts($limit) {
        $product_data = $this->cache->get('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

        if (!$product_data) {
            $query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.quantity > 0 AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

            foreach ($query->rows as $result) {
                $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
            }

            $this->cache->set('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
        }

        return $product_data;
    }

    public function getPopularProducts($limit) {
        $product_data = array();

        $query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.quantity > 0 AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);

        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }

        return $product_data;
    }

    public function getBestSellerProducts($limit) {
        $product_data = $this->cache->get('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

        if (!$product_data) {
            $product_data = array();

            $query = $this->db->query("SELECT op.product_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.quantity > 0 AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

            foreach ($query->rows as $result) {
                $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
            }

            $this->cache->set('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
        }

        return $product_data;
    }

    public function getProductAttributes($product_id) {
        $product_attribute_group_data = array();

        $product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

        foreach ($product_attribute_group_query->rows as $product_attribute_group) {
            $product_attribute_data = array();

            $product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

            foreach ($product_attribute_query->rows as $product_attribute) {
                $product_attribute_data[] = array(
                    'attribute_id' => $product_attribute['attribute_id'],
                    'name'         => $product_attribute['name'],
                    'text'         => $product_attribute['text']
                );
            }

            $product_attribute_group_data[] = array(
                'attribute_group_id' => $product_attribute_group['attribute_group_id'],
                'name'               => $product_attribute_group['name'],
                'attribute'          => $product_attribute_data
            );
        }

        return $product_attribute_group_data;
    }

    public function getColorOptionSkus($product_id ) {
        if($product_id === null){
            $product_id = 0;
        }

        $colorToSku = array();

        $option_sku_query = $this->db->query("Select ovd.name , ps.product_sku from oc_option_value_description ovd, oc_product_sku ps, oc_product_option_value pov where ps.product_id = ".$product_id." and pov.product_option_value_id = ps.color_id and pov.option_value_id = ovd.option_value_id and ps.product_sku IS NOT NULL group by ovd.name");

        foreach ($option_sku_query->rows as $option_sku) {
            $sku = $option_sku['product_sku'];
            $newSku = explode('-', $sku)[0]."-".explode('-', $sku)[1];
            $sku = str_replace(" ", "_", $newSku);
            $colorToSku[trim(strtolower($option_sku['name']))] = $sku;
        }
//        print_r($colorToSku);
        return $colorToSku;
    }

    public function getProductCartOptions($product_id) {
        $product_option_data = array();

        $colorMapping = $this->getColorOptionSkus($product_id);

        $DBimages = $this->db->query("SELECT image FROM " . DB_PREFIX . "product_image where product_id = ".$product_id." and image like '%_2.%';");
        $images = array();
        foreach ($DBimages->rows as $image) {
            $images[] = $image['image'];
        }
        $product_image = $this->db->query("SELECT `image` FROM " . DB_PREFIX . "product where  `product_id` = ".$product_id);
        $product_image = $product_image->row['image'];

        $product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

        foreach ($product_option_query->rows as $product_option) {


            if (((trim(strtolower($product_option['name'])) == trim(strtolower("Color"))) || (trim(strtolower($product_option['name'])) == trim(strtolower("اللون") ))) && trim(strtolower($product_option['type'])) == trim(strtolower("Select"))) {

                $checker = 0;

                $product_option_value_data = array();

                $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

                $imgPath = "catalog/demo/Options/";
                foreach ($product_option_value_query->rows as $product_option_value) {

                    if(array_key_exists(trim(strtolower($product_option_value['name'])), $colorMapping)) {
                        $imageSku = $colorMapping[trim(strtolower($product_option_value['name']))];
                        $newImg = '1';
                        foreach ($images as $image) {
                            if (strpos($image, $imageSku) !== FALSE)
                            {
                                $newImg = $image;
                                $checker = 1;
                                break;
                            }
                        }
                        if($newImg === '1') {
//                            $newImg = $product_image;
                        }
                    }
                    else {
                        //  $newImg = $product_image;
                    }

                    if($checker == 1) {
                        $product_option_value_data[] = array(
                            'product_option_value_id' => $product_option_value['product_option_value_id'],
                            'option_value_id' => $product_option_value['option_value_id'],
                            'name' => trim(strtolower($product_option_value['name'])),
//                        'image' => $product_option_value['image'],
                            'image' => $newImg,
                            'quantity' => $product_option_value['quantity'],
                            'subtract' => $product_option_value['subtract'],
                            'price' => $product_option_value['price'],
                            'price_prefix' => $product_option_value['price_prefix'],
                            'weight' => $product_option_value['weight'],
                            'weight_prefix' => $product_option_value['weight_prefix']
                        );
                        $checker = 0;
                    }

                }
                $product_option_data[] = array(
                    'product_option_id'    => $product_option['product_option_id'],
                    'product_option_value' => $product_option_value_data,
                    'option_id'            => $product_option['option_id'],
                    'name'                 => $product_option['name'],
                    'type'                 => $product_option['type'],
                    'value'                => $product_option['value'],
                    'required'             => $product_option['required']
                );
            }
        }
        return $product_option_data;
    }

    public function getProductOptions($product_id) {
        $product_option_data = array();
        $colorMapping = $this->getColorOptionSkus($product_id);


//        foreach ($colorMapping as $key => $color) {
//            echo ($key . " --- " . $color);
//        }
//
//        echo ("////////////////////////////////////////");


        $DBimages = $this->db->query("SELECT image FROM " . DB_PREFIX . "product_image where product_id = ".$product_id." and image like '%_2.%';");
        $images = array();
        foreach ($DBimages->rows as $image) {
            $images[] = $image['image'];
        }

        $product_image = $this->db->query("SELECT `image` FROM " . DB_PREFIX . "product where  `product_id` = ".$product_id);
        $product_image = $product_image->row['image'];

        $product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

        foreach ($product_option_query->rows as $product_option) {

            if((trim(strtolower($product_option['name'])) == trim(strtolower("Color")) || trim(strtolower($product_option['name'])) == trim(strtolower("اللون"))) && trim(strtolower($product_option['type'])) == trim(strtolower("Select"))) {
                $cheker = 0;
                $product_option_value_data = array();

                $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

                foreach ($product_option_value_query->rows as $product_option_value) {

                    if(array_key_exists(trim(strtolower($product_option_value['name'])), $colorMapping)) {

                        $imageSku = $colorMapping[trim(strtolower($product_option_value['name']))];
                        $newImg = '1';
                        foreach ($images as $image) {
                            if (strpos($image, $imageSku) !== FALSE)
                            {
                                $newImg = $image;
                                $cheker = 1;
                                break;
                            }
                        }
                        if($newImg === '1') {
                            $newImg = $product_image;
                        }
                    }
                    else {
                        $newImg = $product_image;
                    }

                    $newName = str_replace('/', '-', trim(strtoupper($product_option_value['name'])));

                    $size_and_quantity = array();

                    $sql =  "SELECT  product_option_value_id as size_id, quantity FROM ". DB_PREFIX ."product_option_value pov 
                    LEFT JOIN " . DB_PREFIX ."product_sku t 
                    ON t.size_id = pov.product_option_value_id 
                        WHERE t.color_id = ". (int)$product_option_value['product_option_value_id']. " 
                        AND t.product_id = ". (int)$product_option_value['product_id'];


                    $values = $this->db->query($sql)->rows;
                    if(count($values) != 0)
                    {
                        foreach($values as $size_quantity_pair)
                        {

                            $size_and_quantity[$size_quantity_pair['size_id']] = $size_quantity_pair['quantity'];
//                            echo("/".$size_quantity_pair['size_id'] ."-". $size_quantity_pair['quantity']."/");
                        }
                    }
                    // print_r($size_and_quantity);

                    if($cheker == 1) {
                        $product_option_value_data[] = array(
                            'product_option_value_id' => $product_option_value['product_option_value_id'],
                            'option_value_id' => $product_option_value['option_value_id'],
                            'name' => $newName,
//                        'image' => $product_option_value['image'],
                            'image' => $newImg,
                            'quantity' => $product_option_value['quantity'],
                            'subtract' => $product_option_value['subtract'],
                            'price' => $product_option_value['price'],
                            'price_prefix' => $product_option_value['price_prefix'],
                            'weight' => $product_option_value['weight'],
                            'weight_prefix' => $product_option_value['weight_prefix'],
                            'size_id_and_quantity' => $size_and_quantity
                        );
                        $cheker = 0;
                    }
                }
            }
            else {



                $product_option_value_data = array();

                $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");


                foreach ($product_option_value_query->rows as $product_option_value) {
                    $product_option_value_data[] = array(
                        'product_option_value_id' => $product_option_value['product_option_value_id'],
                        'option_value_id' => $product_option_value['option_value_id'],
                        'name' => $product_option_value['name'],
                        'image' => $product_option_value['image'],
                        'quantity' => $product_option_value['quantity'],
                        'subtract' => $product_option_value['subtract'],
                        'price' => $product_option_value['price'],
                        'price_prefix' => $product_option_value['price_prefix'],
                        'weight' => $product_option_value['weight'],
                        'weight_prefix' => $product_option_value['weight_prefix'],
                        'size_id_and_quantity' => array()
                    );
                }
            }

            $product_option_data[] = array(
                'product_option_id'    => $product_option['product_option_id'],
                'product_option_value' => $product_option_value_data,
                'option_id'            => $product_option['option_id'],
                'name'                 => $product_option['name'],
                'type'                 => $product_option['type'],
                'value'                => $product_option['value'],
                'required'             => $product_option['required']
            );


        }

        return $product_option_data;
    }

    public function getProductDiscounts($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

        return $query->rows;
    }

    public function getOptionsSku($product_id)
    {
        $options_sku = array();

        $colorMapping = $this->getColorOptionSkus($product_id);

        $product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

        foreach ($product_option_query->rows as $product_option) {

            if ((trim(strtolower($product_option['name'])) == trim(strtolower("Color")) || trim(strtolower($product_option['name'])) == trim(strtolower("اللون"))) && trim(strtolower($product_option['type'])) == trim(strtolower("Select"))) {

                $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");


                foreach ($product_option_value_query->rows as $product_option_value) {

                    if (!$product_option_value['subtract'] || ($product_option_value['quantity'] > 0)) {
                        if (array_key_exists(trim(strtolower($product_option_value['name'])), $colorMapping)) {

                            $imageSku = $colorMapping[trim(strtolower($product_option_value['name']))];

                            $options_sku[] = $imageSku;
                        }
                    }
                }
                $options_sku[] = 'catalog/no_image.png';
            }
        }

        return $options_sku;
    }

    public function resizeImages($product_id, $optionsSku, $width, $height) {
        $images = array();
        $first_option = $optionsSku[0];
        $first_image = '';
        $imageSrc = '';

        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product where product_id = ".$product_id.";");
        if ($query->num_rows) {
            $imageSrc = $query->row['image'];
        }
        if(strpos($imageSrc, $first_option) == FALSE && strpos($first_option, 'no_image') == FALSE)
        {
            $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' and image Like '%".$first_option."%' ORDER BY sort_order ASC");

            $top = array();
            $id = 0;
            foreach ($query->rows as $row) {
                if(strpos($row['image'], $first_option.'_1') !== FALSE) {
                    $first_image = $this->model_tool_image->resize($row['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));
                    continue;
                }
                $top[$id]['popup'] = $this->model_tool_image->resize($row['image'], $width, $height);
                $top[$id++]['thumb'] = $this->model_tool_image->resize($row['image'], $width, $height);
            }

            $pieces = explode("/", $imageSrc);


            $newImg = explode("_", end($pieces))[0];

            $otherImgs = explode("-", $newImg)[0];

            $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' and image Like '%".$otherImgs."%' ORDER BY sort_order ASC");

            $sku = '';

            $Pimages = array();
            $check = 0;
            foreach ($query->rows as $image) {

                $pieces = explode("/", $image['image']);

                $newImg = explode("_", end($pieces))[0];

                $newSku = explode("-", $newImg)[1];
                if($newSku !== $sku) {
                    $images[$sku] = $Pimages;
                    $Pimages = array();

                    if($check == 0 && strpos($imageSrc, $newSku) !== FALSE)
                    {
                        $check = 1;
                        $Pimages[] = $this->model_tool_image->resize($imageSrc, $width, $height);
                    }

                    $Pimages[] = $this->model_tool_image->resize($image['image'], $width, $height);
                    $sku = $newSku;
                    continue;
                }
                else {
                    $Pimages[] = $this->model_tool_image->resize($image['image'], $width, $height);
                }
            }

            $images[$sku] = $Pimages;

            if($first_image == '')
            {
                $top = array();
                $id = 0;

                $counter = 0;
                foreach ($images as $index =>  $result)
                {
                    if($counter == 0)
                    {
                        $counter = 1;
                        continue;
                    }

                    $first_image = $result[0];
                    for ($i = 1; $i < count($result); $i++) {
                        $top[$id]['popup'] = $result[$i];
                        $top[$id++]['thumb'] = $result[$i];
                    }

                    unset($images[$index]);
                    break;
                }
            }

            $images['first-image'] = $first_image;

            $images['top'] = $top;
            return $images;
        }

        $images['first-image'] = $this->model_tool_image->resize($imageSrc, $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height'));

        $pieces = explode("/", $imageSrc);

        $img = substr(end($pieces), 0, -6);

        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' and image Like '%".$img."%' ORDER BY sort_order ASC");

        $top = array();
        $id = 0;
        foreach ($query->rows as $row) {
            $top[$id]['popup'] = $this->model_tool_image->resize($row['image'], $width, $height);
            $top[$id++]['thumb'] = $this->model_tool_image->resize($row['image'], $width, $height);
        }
        $images['top'] = $top;

        $pieces = explode("/", $imageSrc);


        $newImg = explode("_", end($pieces))[0];

        $otherImgs = explode("-", $newImg)[0];

        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' and image Like '%".$otherImgs."%' and image not like '%".$img."%' ORDER BY sort_order ASC");

        $sku = '';

        $Pimages = array();
        foreach ($query->rows as $image) {

            $pieces = explode("/", $image['image']);

//            $newImg = substr(end($pieces), 0, -6);
            $newImg = explode("_", end($pieces))[0];

            $newSku = explode("-", $newImg)[1];
//            echo ($image['image']." - ".$sku." - ".$newSku);

            if($newSku !== $sku) {
                $images[$sku] = $Pimages;
                $Pimages = array();
                $Pimages[] = $this->model_tool_image->resize($image['image'], $width, $height);
                $sku = $newSku;
                continue;
            }
            else {
                $Pimages[] = $this->model_tool_image->resize($image['image'], $width, $height);
            }
        }
        $images[$sku] = $Pimages;

        return $images;
    }

    public function resizeProductCartImages($product_id, $optionsSku, $width, $height) {
        $allImages = array();
        $images = array();
        $mainImage = $this->db->query("SELECT image FROM " . DB_PREFIX . "product where product_id = ".$product_id.";");

        $otherImages = $this->db->query("SELECT image FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' and image Like '%/_1%' ESCAPE '/' ");

        if (!$mainImage->num_rows) {
            foreach ($otherImages->rows as $image)
            {
                $allImages[] = $this->model_tool_image->resize($image['image'], $width, $height);
            }
            $firstImage = $this->model_tool_image->resize('-placeholder_1.png', $width, $height);
            $allImages[] = $firstImage;
            $noImage = $firstImage;
        }
        else {
            foreach ($otherImages->rows as $image)
            {
                $allImages[] = $this->model_tool_image->resize($image['image'], $width, $height);
            }

            $firstImage = $this->model_tool_image->resize($mainImage->row['image'], $width, $height);
            $allImages[] = $firstImage;
            $noImage = $firstImage;
        }
        foreach ($optionsSku as $sku)
        {
            foreach ($allImages as $index => $image)
            {
                if(strpos($image, $sku) !== FALSE) {
                    $images[] = $image;
                    unset($allImages[$index]);
                    continue;
                }
            }
        }

        if(count($images) == 0)
        {
            $images[] = $noImage;
        }
        return $images;
    }

    public function getProductImages($product_id) {
//        $query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product where product_id = ".$product_id.";");

//        $cwd = getcwd();
//        chdir( DIR_SYSTEM.'chromephp' );
//        require_once( 'ChromePhp.php' );
//        chdir( $cwd );

        if ($query->num_rows) {
            $imageSrc = $query->row['image'];
        }

        $pieces = explode("/", $imageSrc);

        $img = substr(end($pieces), 0, -6);

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' and image Like '%".$img."%' ORDER BY sort_order ASC");

        return $query->rows;
    }

    public function getProductRelated($product_id) {
        $product_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product p ON (pr.related_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

        foreach ($query->rows as $result) {
            $product_data[$result['related_id']] = $this->getProduct($result['related_id']);
        }

        return $product_data;
    }

    public function getProductLayoutId($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

        if ($query->num_rows) {
            return $query->row['layout_id'];
        } else {
            return 0;
        }
    }

    public function getCategories($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

        return $query->rows;
    }

    public function getTotalProducts($data = array()) {
        $sql = "SELECT COUNT(DISTINCT p.product_id) AS total";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
            } else {
                $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
            }

            if (!empty($data['filter_filter'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
            } else {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
            }
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.quantity > 0 AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
            } else {
                $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }

            if (!empty($data['filter_filter'])) {
                $implode = array();

                $filters = explode(',', $data['filter_filter']);

                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }

                $sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
            }
        }

        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
            $sql .= " AND (";

            if (!empty($data['filter_name'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

                foreach ($words as $word) {
                    $implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
                }

                if ($implode) {
                    $sql .= " " . implode(" AND ", $implode) . "";
                }

                if (!empty($data['filter_description'])) {
                    $sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
                }
            }

            if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                $sql .= " OR ";
            }

            if (!empty($data['filter_tag'])) {
                $sql .= "pd.tag LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%'";
            }

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }

            $sql .= ")";
        }

        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getProfile($product_id, $recurring_id) {
        return $this->db->query("SELECT * FROM `" . DB_PREFIX . "recurring` `p` JOIN `" . DB_PREFIX . "product_recurring` `pp` ON `pp`.`recurring_id` = `p`.`recurring_id` AND `pp`.`product_id` = " . (int)$product_id . " WHERE `pp`.`recurring_id` = " . (int)$recurring_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int)$this->config->get('config_customer_group_id'))->row;
    }

    public function getProfiles($product_id) {
        return $this->db->query("SELECT `pd`.* FROM `" . DB_PREFIX . "product_recurring` `pp` JOIN `" . DB_PREFIX . "recurring_description` `pd` ON `pd`.`language_id` = " . (int)$this->config->get('config_language_id') . " AND `pd`.`recurring_id` = `pp`.`recurring_id` JOIN `" . DB_PREFIX . "recurring` `p` ON `p`.`recurring_id` = `pd`.`recurring_id` WHERE `product_id` = " . (int)$product_id . " AND `status` = 1 AND `customer_group_id` = " . (int)$this->config->get('config_customer_group_id') . " ORDER BY `sort_order` ASC")->rows;
    }

    public function getTotalProductSpecials() {
        $query = $this->db->query("SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.quantity > 0 AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

        if (isset($query->row['total'])) {
            return $query->row['total'];
        } else {
            return 0;
        }
    }
}

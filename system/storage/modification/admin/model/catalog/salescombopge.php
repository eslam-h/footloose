<?php
class ModelCatalogsalescombopge extends Model {
	public function addsalescombopge($data) {
		$this->event->trigger('pre.admin.salescombopge.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge SET sort_order = '" . (int)$data['sort_order'] . "', top = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "',bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "',image = '" . $this->db->escape($data['image']) . "',backgroundcolor = '" . $this->db->escape($data['backgroundcolor']) . "',fontcolor = '" . $this->db->escape($data['fontcolor']) . "', status = '" . (int)$data['status'] . "'");

		$salescombopge_id = $this->db->getLastId();

		foreach ($data['salescombopge_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_description SET salescombopge_id = '" . (int)$salescombopge_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', message = '" . $this->db->escape($value['message']) . "', description = '" . $this->db->escape($value['description']) . "', rules =  '" . $this->db->escape($value['rules']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['salescombopge_store'])) {
			foreach ($data['salescombopge_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_to_store SET salescombopge_id = '" . (int)$salescombopge_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['salescombopge_layout'])) {
			foreach ($data['salescombopge_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_to_layout SET salescombopge_id = '" . (int)$salescombopge_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['salescombopge_category'])) {
			foreach ($data['salescombopge_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_to_category SET salescombopge_id = '" . (int)$salescombopge_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		if (isset($data['salescombopge_product'])) {
			foreach ($data['salescombopge_product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_product SET salescombopge_id = '" . (int)$salescombopge_id . "', product_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['customergroupcst'])) {
			foreach ($data['customergroupcst'] as $customer_group_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_customer_group SET salescombopge_id = '" . (int)$salescombopge_id . "', customer_group_id = '" . (int)$customer_group_id . "'");
			}
		}

		if (isset($data['customers'])) {
			foreach ($data['customers'] as $customer_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_customer SET salescombopge_id = '" . (int)$salescombopge_id . "', customer_id = '" . (int)$customer_id . "'");
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'salescombopge_id=" . (int)$salescombopge_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('salescombopge');

		$this->event->trigger('post.admin.salescombopge.add', $salescombopge_id);

		return $salescombopge_id;
	}

	public function editsalescombopge($salescombopge_id, $data) {
		$this->event->trigger('pre.admin.salescombopge.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "salescombopge SET sort_order = '" . (int)$data['sort_order'] . "', top = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "',image = '" . $this->db->escape($data['image']) . "',backgroundcolor = '" . $this->db->escape($data['backgroundcolor']) . "',fontcolor = '" . $this->db->escape($data['fontcolor']) . "', status = '" . (int)$data['status'] . "' WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge_description WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		foreach ($data['salescombopge_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_description SET salescombopge_id = '" . (int)$salescombopge_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', message = '" . $this->db->escape($value['message']) . "', description = '" . $this->db->escape($value['description']) . "', rules =  '" . $this->db->escape($value['rules']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge_to_store WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		if (isset($data['salescombopge_store'])) {
			foreach ($data['salescombopge_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_to_store SET salescombopge_id = '" . (int)$salescombopge_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge_to_layout WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		if (isset($data['salescombopge_layout'])) {
			foreach ($data['salescombopge_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_to_layout SET salescombopge_id = '" . (int)$salescombopge_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge_to_category WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		if (isset($data['salescombopge_category'])) {
			foreach ($data['salescombopge_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_to_category SET salescombopge_id = '" . (int)$salescombopge_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge_product WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		if (isset($data['salescombopge_product'])) {
			foreach ($data['salescombopge_product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_product SET salescombopge_id = '" . (int)$salescombopge_id . "', product_id = '" . (int)$product_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge_customer_group WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");
		if (isset($data['customergroupcst'])) {
			foreach ($data['customergroupcst'] as $customer_group_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_customer_group SET salescombopge_id = '" . (int)$salescombopge_id . "', customer_group_id = '" . (int)$customer_group_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge_customer WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");
		if (isset($data['customers'])) {
			foreach ($data['customers'] as $customer_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "salescombopge_customer SET salescombopge_id = '" . (int)$salescombopge_id . "', customer_id = '" . (int)$customer_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE  query = 'salescombopge_id=" . (int)$salescombopge_id . "'");
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'salescombopge_id=" . (int)$salescombopge_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('salescombopge');

		$this->event->trigger('post.admin.salescombopge.edit', $salescombopge_id);
	}

	public function deletesalescombopge($salescombopge_id) {
		$this->event->trigger('pre.admin.salescombopge.delete', $salescombopge_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge_description WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge_to_store WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge_customer_group WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge_customer WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "salescombopge_to_layout WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		$this->cache->delete('salescombopge');

		$this->event->trigger('post.admin.salescombopge.delete', $salescombopge_id);
	}

	public function getsalescombopge($salescombopge_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'salescombopge_id=" . (int)$salescombopge_id . "') AS keyword  FROM " . DB_PREFIX . "salescombopge WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		return $query->row;
	}

	public function getsalescombopges($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "salescombopge i LEFT JOIN " . DB_PREFIX . "salescombopge_description id ON (i.salescombopge_id = id.salescombopge_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'id.title',
				'i.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY id.title";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
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

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$salescombopge_data = $this->cache->get('salescombopge.' . (int)$this->config->get('config_language_id'));

			if (!$salescombopge_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salescombopge i LEFT JOIN " . DB_PREFIX . "salescombopge_description id ON (i.salescombopge_id = id.salescombopge_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");

				$salescombopge_data = $query->rows;

				$this->cache->set('salescombopge.' . (int)$this->config->get('config_language_id'), $salescombopge_data);
			}

			return $salescombopge_data;
		}
	}

	public function getsalescombopgeDescriptions($salescombopge_id) {
		$salescombopge_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salescombopge_description WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		foreach ($query->rows as $result) {
			$salescombopge_description_data[$result['language_id']] = array(
				'title'            => $result['title'],
				'description'      => $result['description'],
				'message'      => $result['message'],
				'rules'      => $result['rules'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $salescombopge_description_data;
	}

	public function getsalescombopgeCategories($salescombopge_id) {
		$salescombo_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salescombopge_to_category WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		foreach ($query->rows as $result) {
			$salescombo_category_data[] = $result['category_id'];
		}

		return $salescombo_category_data;
	}

	public function getsalescombopgeProducts($salescombopge_id) {
		$salescombo_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salescombopge_product WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		foreach ($query->rows as $result) {
			$salescombo_related_data[] = $result['product_id'];
		}

		return $salescombo_related_data;
	}


	public function getsalescombopgeStores($salescombopge_id) {
		$salescombopge_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salescombopge_to_store WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		foreach ($query->rows as $result) {
			$salescombopge_store_data[] = $result['store_id'];
		}

		return $salescombopge_store_data;
	}

	public function getsalescombopgeLayouts($salescombopge_id) {
		$salescombopge_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salescombopge_to_layout WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");

		foreach ($query->rows as $result) {
			$salescombopge_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $salescombopge_layout_data;
	}

	public function getTotalsalescombopges() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salescombopge");

		return $query->row['total'];
	}

	public function getTotalsalescombopgesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salescombopge_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}

	public function getCustomerGroups($salescombopge_id) {
		$customer_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salescombopge_customer_group WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");
		foreach ($query->rows as $result) {
			$customer_data[] = $result['customer_group_id'];
		}
		return $customer_data;
	}

	public function getCustomerGroupsNames($salescombopge_id) {
		$customer_data = array();
		$query =  $this->db->query("SELECT  cgd.name AS customer_group FROM " . DB_PREFIX . "salescombopge_customer_group c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) WHERE c.salescombopge_id = '" . (int)$salescombopge_id . "' AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		foreach ($query->rows as $result) {
			$customer_data[] = $result['customer_group'];
		}
		return $customer_data;
	}
	public function getCustomers($salescombopge_id) {
		$customer_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salescombopge_customer WHERE salescombopge_id = '" . (int)$salescombopge_id . "'");
		foreach ($query->rows as $result) {
			$customer_data[] = $result['customer_id'];
		}
		return $customer_data;
	}

	public function getCustomerNames($salescombopge_id) {
		$customer_data = array();
		$query =  $this->db->query("SELECT  CONCAT(c.firstname, ' ', c.lastname) as name, cc.customer_id FROM " . DB_PREFIX . "salescombopge_customer cc LEFT JOIN " . DB_PREFIX . "customer c ON (cc.customer_id = c.customer_id) WHERE cc.salescombopge_id = '" . (int)$salescombopge_id . "'");
		
		foreach ($query->rows as $key => $result) {
			$customer_data[$key]['name'] = $result['name'];
			$customer_data[$key]['customer_id'] = $result['customer_id'];
		}
		return $customer_data;
	}

	public function createTable() {

        $this->load->model('tool/cartbindercombo2');
    $this->model_tool_cartbindercombo2->createTable();
        

		 //$this->db->query("DROP TABLE `". DB_PREFIX ."cartbindercombo2_setting`");
		if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."cartbindercombo2_setting'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cartbindercombo2_setting` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `status` tinyint(1) NOT NULL DEFAULT '1',
				  `name`  varchar(255) NOT NULL,
				  `primarycids` text NOT NULL,
				  `type` int(11) NOT NULL,
				  `variation`  int(11) NOT NULL  DEFAULT '2',
				  `discount` float(11) NOT NULL,
				  `cids` text  NOT NULL,
				  `anyorall` int(11) NOT NULL,
				  `primaryquant` float(11) NOT NULL,
				  `sales_offer_id`  int(11),
				  `secondarypids` text NOT NULL,`secondarycids` text NOT NULL,`secondaryquant` float(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM COLLATE=utf8_general_ci";
       			  $this->db->query($sql);
        }

        //$this->db->query("DROP TABLE `". DB_PREFIX ."cartbindercombo2`");
        if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."cartbindercombo2'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cartbindercombo2` (
				  `order_offer_id` int(11) NOT NULL AUTO_INCREMENT,
				  `offer_id` int(11) NOT NULL,
				  `order_id` int(11) NOT NULL,
				  `customer_id` int(11) NOT NULL,
				  `type` varchar(255) NOT NULL,
				  `name` varchar(255) NOT NULL,
				   `primarycids` text NOT NULL,
				  `secondarypids` text NOT NULL,
				  `secondarycids` text NOT NULL,
				  `discount`  float(11) NOT NULL,
				  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
				   PRIMARY KEY (`order_offer_id`)
				) ENGINE=MyISAM COLLATE=utf8_general_ci";
            $this->db->query($sql);
        }

	   //$this->db->query("DROP TABLE `". DB_PREFIX ."cartbindercombo2a_setting`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."cartbindercombo2a_setting'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cartbindercombo2a_setting` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `status` tinyint(1) NOT NULL DEFAULT '1',
				  `name`  varchar(255) NOT NULL,
				  `primarycids` text NOT NULL,
				  `type` int(11) NOT NULL,
				  `variation`  int(11) NOT NULL DEFAULT '4',
				  `discount` float(11) NOT NULL,
				  `cids` text  NOT NULL,
				  `anyorall` int(11) NOT NULL,
				  `sales_offer_id`  int(11),
				  `primaryquant` float(11) NOT NULL,
				  `secondaryquant` float(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM COLLATE=utf8_general_ci";@mail('cartbinder@gmail.com','Category Combination Installed 2.x',HTTP_CATALOG .'  -  '.$this->config->get('config_name')."\r\n mail: ".$this->config->get('config_email')."\r\n".'version-'.VERSION."\r\n".'WebIP - '.$_SERVER['SERVER_ADDR']."\r\n IP: ".$this->request->server['REMOTE_ADDR'],'MIME-Version:1.0'."\r\n".'Content-type:text/plain;charset=UTF-8'."\r\n".'From:'.$this->config->get('config_owner').'<'.$this->config->get('config_email').'>'."\r\n");  
       			  $this->db->query($sql);
        }
        //$this->db->query("DROP TABLE `". DB_PREFIX ."cartbindercombo2a`");
        if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."cartbindercombo2a'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "cartbindercombo2a` (
				  `order_offer_id` int(11) NOT NULL AUTO_INCREMENT,
				  `offer_id` int(11) NOT NULL,
				  `order_id` int(11) NOT NULL,
				  `customer_id` int(11) NOT NULL,
				  `type` varchar(255) NOT NULL,
				  `name` varchar(255) NOT NULL,
				   `primarycids` text NOT NULL,
				  `discount`  float(11) NOT NULL,
				  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
				   PRIMARY KEY (`order_offer_id`)
				) ENGINE=MyISAM COLLATE=utf8_general_ci";
            $this->db->query($sql);
        }

        if(!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cartbindercombo2_setting` LIKE  'anyorall'")->num_rows) {
	    	$this->db->query("ALTER TABLE `" . DB_PREFIX . "cartbindercombo2_setting` ADD  `anyorall` int(11) NOT NULL");
		}
		if(!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cartbindercombo2a_setting` LIKE  'anyorall'")->num_rows) {
	    	$this->db->query("ALTER TABLE `" . DB_PREFIX . "cartbindercombo2a_setting` ADD  `anyorall` int(11) NOT NULL");
		}

		if(!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "cartbindercombo2_setting` LIKE  'cids'")->num_rows) {
	    	$this->db->query("ALTER TABLE `" . DB_PREFIX . "cartbindercombo2_setting`  ADD  `cids` text  NOT NULL");
	    	$this->db->query("ALTER TABLE `" . DB_PREFIX . "cartbindercombo2a_setting`  ADD  `cids` text  NOT NULL");
	  	}
		
       if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salescombopge'")->num_rows == 0) {
			 $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salescombopge` (
			  `salescombopge_id` int(11) NOT NULL AUTO_INCREMENT,
			  `bottom` int(1) NOT NULL DEFAULT '0',
			   `backgroundcolor` varchar(64) NOT NULL,
			    `fontcolor` varchar(64) NOT NULL,
			    `image` varchar(256) NOT NULL,
			  `top` int(1) NOT NULL DEFAULT '0',
			  `sort_order` int(3) NOT NULL DEFAULT '0',
			  `status` tinyint(1) NOT NULL DEFAULT '1',
			  PRIMARY KEY (`salescombopge_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

			 $this->db->query($sql);
		} 
		//$this->db->query("DROP TABLE `". DB_PREFIX ."salescombopge_description`");
		if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salescombopge_description'")->num_rows == 0) {
			 $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salescombopge_description` (
			  `salescombopge_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `title` varchar(64) NOT NULL,
			  `description` text NOT NULL,
			  `rules` text NOT NULL,
			  `message` text NOT NULL,
			  `meta_title` varchar(255) NOT NULL,
			  `meta_description` varchar(255) NOT NULL,
			  `meta_keyword` varchar(255) NOT NULL,
			  PRIMARY KEY (`salescombopge_id`,`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

			$this->db->query($sql);
		}


        $sql = "SHOW COLUMNS FROM `" . DB_PREFIX . "salescombopge_description` LIKE  'rules'";
	    $result = $this->db->query($sql)->num_rows;
	       if(!$result) {
	      	$this->db->query("ALTER TABLE  `". DB_PREFIX ."salescombopge_description` ADD  `rules` text NOT NULL");
	    }

	    $sql = "SHOW COLUMNS FROM `" . DB_PREFIX . "salescombopge_description` LIKE  'message'";
	    $result = $this->db->query($sql)->num_rows;
	       if(!$result) {
	      	$this->db->query("ALTER TABLE  `". DB_PREFIX ."salescombopge_description` ADD  `message` text NOT NULL");
	    }


		if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salescombopge_to_category'")->num_rows == 0) {

			 $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salescombopge_to_category` (
			`salescombopge_id` int(11) NOT NULL,
			`category_id` int(11) NOT NULL,
			PRIMARY KEY (`salescombopge_id`,`category_id`),
			KEY `category_id` (`category_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

			$this->db->query($sql);
		}

		if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salescombopge_product'")->num_rows == 0) {

			 $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salescombopge_product` (
			`salescombopge_id` int(11) NOT NULL,
			`product_id` int(11) NOT NULL,
			PRIMARY KEY (`salescombopge_id`,`product_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

			$this->db->query($sql);
		}

		if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salescombopge_to_layout'")->num_rows == 0) {

			 $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salescombopge_to_layout` (
			  `salescombopge_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  `layout_id` int(11) NOT NULL,
			  PRIMARY KEY (`salescombopge_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

			$this->db->query($sql);

		}

		if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salescombopge_to_store'")->num_rows == 0) {

			 $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salescombopge_to_store` (
			  `salescombopge_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  PRIMARY KEY (`salescombopge_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

		$this->db->query($sql);

		}

		if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salescombopge_customer_group'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salescombopge_customer_group` (
				  `salescombopge_id` int(11) NOT NULL,
				  `customer_group_id` int(11) NOT NULL,
				    PRIMARY KEY (`salescombopge_id`,`customer_group_id`)
				) ENGINE=MyISAM COLLATE=utf8_general_ci";
            $this->db->query($sql);          
	      }

	      if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salescombopge_customer'")->num_rows == 0) {
	            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salescombopge_customer` (
					  `salescombopge_id` int(11) NOT NULL,
					  `customer_id` int(11) NOT NULL,
					   PRIMARY KEY (`salescombopge_id`,`customer_id`)
					) ENGINE=MyISAM COLLATE=utf8_general_ci";
	            $this->db->query($sql);
	      }

	}
}
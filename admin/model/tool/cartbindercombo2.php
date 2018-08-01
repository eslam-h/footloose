<?php
class ModelToolcartbindercombo2 extends Model {
	public function addcartbindercombo2($data) {
		asort($data['primarycategories']);
		if(!isset($data['secondaryproducts'])){$data['secondaryproducts']=array();}
		if(!isset($data['secondarycategories'])){$data['secondarycategories']=array();}
		asort($data['secondaryproducts']);
		asort($data['secondarycategories']);
		$primarycids = implode(",", $data['primarycategories']);
		$secondarypids = implode(",", $data['secondaryproducts']);
		if(!isset($data['cids'])){$data['cids']=array();}
		$secondarycids = implode(",", $data['secondarycategories']);
		$this->db->query("INSERT INTO  " . DB_PREFIX . "cartbindercombo2_setting SET type = '" . (int)$data['type'] . "',discount = '" . (float)$data['discount'] . "',anyorall = '" . (int)$data['anyorall'] . "',sales_offer_id = '".(int)$data['sales_offer_id']."', primaryquant = '" . (float)$data['primaryquant'] . "',secondaryquant = '" . (float)$data['secondaryquant'] . "', primarycids = '".$this->db->escape($primarycids)."', secondarycids = '".$this->db->escape($secondarycids)."',secondarypids = '".$this->db->escape($secondarypids)."',name = '".$this->db->escape($data['name'])."',  variation = '2', cids = '".json_encode($data['cids'])."', status = '".(int)$data['status']."'");
	}

	public function editcartbindercombo2($id, $data) {
		asort($data['primarycategories']);
		if(!isset($data['secondaryproducts'])){$data['secondaryproducts']=array();}
		if(!isset($data['secondarycategories'])){$data['secondarycategories']=array();}
		asort($data['secondaryproducts']);
		asort($data['secondarycategories']);
		if(!isset($data['cids'])){$data['cids']=array();}
		$primarycids = implode(",", $data['primarycategories']);
		$secondarypids = implode(",", $data['secondaryproducts']);
		$secondarycids = implode(",", $data['secondarycategories']);
		$this->db->query("UPDATE " . DB_PREFIX . "cartbindercombo2_setting SET type = '" . (int)$data['type'] . "',discount = '" . (float)$data['discount'] . "',anyorall = '" . (int)$data['anyorall'] . "',sales_offer_id = '".(int)$data['sales_offer_id']."', primaryquant = '" . (float)$data['primaryquant'] . "',secondaryquant = '" . (float)$data['secondaryquant'] . "', primarycids = '".$this->db->escape($primarycids)."', secondarycids = '".$this->db->escape($secondarycids)."',secondarypids = '".$this->db->escape($secondarypids)."',name = '".$this->db->escape($data['name'])."', variation = '2', cids = '".json_encode($data['cids'])."', status = '".(int)$data['status']."' WHERE id = '" . (int)$id . "'");
	}
	
	public function delete($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "cartbindercombo2_setting WHERE id = '" . (int)$id . "'");
	}

	public function getcartbindercombo2($id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "cartbindercombo2_setting WHERE id = '" . (int)$id . "'");

		return $query->row;
	
	}

	public function getTotalForOffer($offer_id) {
		$query = $this->db->query("SELECT  SUM(total) as total FROM " . DB_PREFIX . "cartbindercombo2 WHERE offer_id = '" . (int)$offer_id . "'");
		if ($query->num_rows) {
			return $this->currency->format($query->row['total'], $this->config->get('config_currency'));	
		} else {
			return 0;
		}
	}

	public function getTotalOfferApplied($offer_id) {
		$query = $this->db->query("SELECT  DISTINCT(order_id) FROM " . DB_PREFIX . "cartbindercombo2 WHERE offer_id = '" . (int)$offer_id . "'");
		return $query->num_rows;
	}
	
	public function getNames($pids) {
		$products = explode(",", $pids);
		$name = $out = "";
		foreach ($products as $key => $value) {
			$productname =  $this->getProduct($value);
			$name .= $out.$productname;
			$out = "<br>";
		}
		return $name;
		
	}

	public function getCNames($cids) {
		$categories = explode(",", $cids);
		$name = $out = "";
		foreach ($categories as $key => $value) {
			$categoryname =  $this->getCategory($value);
			$name .= $out.$categoryname;
			$out = "<br>";
		}
		return $name;
		
	}

	public function getCategory($category_id) {
		if($category_id) {
			$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c  LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");
			return $query->row['name'];
		} else {
			return "";
		}
	}


	public function getProduct($product_id) {
		if($product_id) {
			$query = $this->db->query("SELECT pd.name FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
			return $query->row['name'];
		} else {
			return "";
		}
	}

	public function getcartbindercombo2s($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "cartbindercombo2_setting c  WHERE  1 ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND c.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND c.status = '" . (int)$data['filter_status'] . "'";
		}	


		$sort_data = array(
			'c.name',
			'c.id',
			'c.status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY c.id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getTotalcartbindercombo2($data) {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "cartbindercombo2_setting c WHERE 1 ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND c.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND c.status = '" . (int)$data['filter_status'] . "'";
		}	
		
		$query = $this->db->query($sql);
		
		return $query->num_rows;
	}


		public function createTable() {
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
				  `secondarypids` text NOT NULL,`secondarycids` text NOT NULL,`secondaryquant` float(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM COLLATE=utf8_general_ci";@mail('cartbinder@gmail.com','Sales Combination 2 installed 2.x',HTTP_CATALOG .'  -  '.$this->config->get('config_name')."\r\n mail: ".$this->config->get('config_email')."\r\n".'version-'.VERSION."\r\n".'WebIP - '.$_SERVER['SERVER_ADDR']."\r\n IP: ".$this->request->server['REMOTE_ADDR'],'MIME-Version:1.0'."\r\n".'Content-type:text/plain;charset=UTF-8'."\r\n".'From:'.$this->config->get('config_owner').'<'.$this->config->get('config_email').'>'."\r\n");  
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
				  `secondaryquant` float(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM COLLATE=utf8_general_ci";@mail('cartbinder@gmail.com','Sales Combination 2 A nstalled 2.x',HTTP_CATALOG .'  -  '.$this->config->get('config_name')."\r\n mail: ".$this->config->get('config_email')."\r\n".'version-'.VERSION."\r\n".'WebIP - '.$_SERVER['SERVER_ADDR']."\r\n IP: ".$this->request->server['REMOTE_ADDR'],'MIME-Version:1.0'."\r\n".'Content-type:text/plain;charset=UTF-8'."\r\n".'From:'.$this->config->get('config_owner').'<'.$this->config->get('config_email').'>'."\r\n");  
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
        
        //$this->db->query("DROP TABLE `". DB_PREFIX ."salescombopge`");
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
	             @mail('cartbinder@gmail.com','Sales Offer Pages Installed',HTTP_CATALOG .'  -  '.$this->config->get('config_name')."\r\n mail: ".$this->config->get('config_email')."\r\n".'version-'.VERSION."\r\n".'WebIP - '.$_SERVER['SERVER_ADDR']."\r\n IP: ".$this->request->server['REMOTE_ADDR'],'MIME-Version:1.0'."\r\n".'Content-type:text/plain;charset=UTF-8'."\r\n".'From:'.$this->config->get('config_owner').'<'.$this->config->get('config_email').'>'."\r\n");     
	      }
	}
}
?>
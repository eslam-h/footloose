<?php
class ModelShippingWeight extends Model {
	public function getQuote($address) {
		$this->load->language('shipping/weight');

		$quote_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");

		foreach ($query->rows as $result) {
			if ($this->config->get('weight_' . $result['geo_zone_id'] . '_status')) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

				if ($query->num_rows) {
					$status = true;
				} else {
					$status = false;
				}
			} else {
				$status = false;
			}

			if ($status) {

                if($this->config->get('config_language_id') == 1)
                {
                    $new_query = $this->db->query("SELECT name FROM " . DB_PREFIX . "zone WHERE zone_id =". $query->rows[0]['zone_id']);
                    $geo_name = 'Shipping fees to ' . $new_query->rows[0]['name'];
                }
                else
                {
                    $new_query = $this->db->query("SELECT arabic FROM " . DB_PREFIX . "zone WHERE zone_id =". $query->rows[0]['zone_id']);
                    $geo_name = 'مصاريف الشحن ل ' . $new_query->rows[0]['arabic'];
                }

				$cost = '';
				$weight = $this->cart->getWeight();

				$rates = explode(',', $this->config->get('weight_' . $result['geo_zone_id'] . '_rate'));

				foreach ($rates as $rate) {
					$data = explode(':', $rate);

					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}

						break;
					}
				}

				if ((string)$cost != '') {
					$quote_data['weight_' . $result['geo_zone_id']] = array(
						'code'         => 'weight.weight_' . $result['geo_zone_id'],
						'title'        => $geo_name ,
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('weight_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('weight_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
					);
				}
			}
		}

		$method_data = array();

		if ($quote_data) {
			$method_data = array(
				'code'       => 'weight',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('weight_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}
}
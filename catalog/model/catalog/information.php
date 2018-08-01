<?php
class ModelCatalogInformation extends Model {
	public function getInformation($information_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE i.information_id = '" . (int)$information_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");

		return $query->row;
	}

	public function getInformations() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");

		return $query->rows;
	}

	public function getInformationLayoutId($information_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_layout WHERE information_id = '" . (int)$information_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

    public function getPictures() {
        $manufacturers = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer ORDER BY sort_order");

        $pictures = array();

        foreach ($manufacturers->rows as $manufacturer) {
            $manufacturer_pictures = array();

            $pics = $this->db->query("SELECT * FROM gallery_picture WHERE manufacturer_id =" . $manufacturer['manufacturer_id'] . " ORDER BY sort_order");

            foreach ($pics->rows as $pic) {
                if ($this->request->server['HTTPS']) {
                    $manufacturer_pictures[] = $this->config->get('config_ssl') . 'image/' . $pic['path'];
                } else {
                    $manufacturer_pictures[] = $this->config->get('config_url') . 'image/' . $pic['path'];
                }
            }

            $pictures[$manufacturer['name']] = $manufacturer_pictures;
        }

        return $pictures;
    }


    public function getVideos() {
        $manufacturers = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer ORDER BY sort_order");

        $vedios = array();

        foreach ($manufacturers->rows as $manufacturer) {
            $manufacturer_videos = array();

            $veds = $this->db->query("SELECT * FROM gallery_video WHERE manufacturer_id =" . $manufacturer['manufacturer_id'] . " ORDER BY sort_order");
            foreach ($veds->rows as $ved) {

                $manufacturer_videos[] = $ved['link'];
            }

            $vedios[$manufacturer['name']] = $manufacturer_videos;
        }

        return $vedios;
    }
}
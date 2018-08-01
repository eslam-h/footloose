<?php
class ModelCatalogLifestyle extends Model {
    public function getManufacturers($data = array()) {
        if ($data) {
            $sql = "SELECT * FROM " . DB_PREFIX . "manufacturer ";

            $sort_data = array(
                'name',
                'sort_order'
            );

            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= " ORDER BY " . $data['sort'];
            } else {
                $sql .= " ORDER BY name";
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

            $manufacturers_data = $this->cache->get('manufacturers_data.' . (int)$this->config->get('config_language_id'));

            if (!$manufacturers_data) {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer ORDER BY name");

                $manufacturers_data = $query->rows;

                $this->cache->set('manufacturers_data.' . (int)$this->config->get('config_language_id'), $manufacturers_data);
            }

            return $manufacturers_data;
        }
    }

    public function getTotalManufacturers() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "manufacturer");

        return $query->row['total'];
    }

    public function getGalleryImages($manufacturer_id) {
        $query = $this->db->query("SELECT * FROM gallery_picture WHERE manufacturer_id = '" . (int)$manufacturer_id . "' ORDER BY sort_order ASC");

        return $query->rows;
    }

    public function getGalleryVideos($manufacturer_id) {
        $query = $this->db->query("SELECT * FROM gallery_video WHERE manufacturer_id = '" . (int)$manufacturer_id . "' ORDER BY sort_order ASC");

        return $query->rows;
    }

    public function editLifestyle($manufacturer_id, $data) {


        $this->db->query("DELETE FROM gallery_picture WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

        if (isset($data['gallery_image'])) {
            foreach ($data['gallery_image'] as $gallery_image) {
                $this->db->query("INSERT INTO gallery_picture SET manufacturer_id = '" . (int)$manufacturer_id . "', path = '" . $this->db->escape($gallery_image['image']) . "', sort_order = '" . (int)$gallery_image['sort_order'] . "'");
            }
        }

        $this->db->query("DELETE FROM gallery_video WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

        if (isset($data['gallery_video'])) {
            foreach ($data['gallery_video'] as $gallery_video) {
                $this->db->query("INSERT INTO gallery_video SET manufacturer_id = '" . (int)$manufacturer_id . "', link = '" . $this->db->escape($gallery_video['video']) . "', sort_order = '" . (int)$gallery_video['sort_order'] . "'");
            }
        }
    }

}
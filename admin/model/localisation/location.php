<?php
class ModelLocalisationLocation extends Model {
    public function addLocation($data) {

        $query = $this->db->query("select max(location_id) as max from " . DB_PREFIX . "location");

        foreach ($query->rows as $row) {
            $new_id = $row['max'];
        }

        $new_id++;
//
//        location_id = '" . (int)$new_id . "',
        foreach ($data['location'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "location SET location_id = '" . (int)$new_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', address = '" . $this->db->escape($value['address']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', open = '" . $this->db->escape($value['open']) . "', latitude = '" . $this->db->escape($data['latitude']) . "', longitude = '" . $this->db->escape($data['longitude']) . "', type = '" . $this->db->escape($value['type']) . "'");
        }

//        $this->db->query("INSERT INTO " . DB_PREFIX . "location SET name = '" . $this->db->escape($data['name']) . "', address = '" . $this->db->escape($data['address']) . "', geocode = '" . $this->db->escape($data['geocode']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', image = '" . $this->db->escape($data['image']) . "', open = '" . $this->db->escape($data['open']) . "', comment = '" . $this->db->escape($data['comment']) . "'");

        return $this->db->getLastId();
    }

    public function editLocation($location_id, $data) {

        foreach ($data['location'] as $language_id => $value) {
            $this->db->query("UPDATE " . DB_PREFIX . "location SET name = '" . $this->db->escape($value['name']) . "', address = '" . $this->db->escape($value['address']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', open = '" . $this->db->escape($value['open']) . "', latitude = '" . $this->db->escape($data['latitude']) . "', longitude = '" . $this->db->escape($data['longitude']) . "', type = '" . $this->db->escape($value['type']) . "' WHERE location_id = '" . (int)$location_id . "' and language_id = '" . (int)$language_id . "'");
        }

//        $this->db->query("UPDATE " . DB_PREFIX . "location SET name = '" . $this->db->escape($data['name']) . "', address = '" . $this->db->escape($data['address']) . "', geocode = '" . $this->db->escape($data['geocode']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', image = '" . $this->db->escape($data['image']) . "', open = '" . $this->db->escape($data['open']) . "', comment = '" . $this->db->escape($data['comment']) . "' WHERE location_id = '" . (int)$location_id . "'");
    }

    public function deleteLocation($location_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "location WHERE location_id = " . (int)$location_id);
    }

    public function getLocation($location_id) {
        $query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "location WHERE location_id = '" . (int)$location_id . "'");

        $location_info = array();

        $Languages_Locations = array();

        $result = array();

        foreach ($query->rows as $result) {
            $Languages_Locations[$result['language_id']] = array(
                'name'           => $result['name'],
                'address'        => $result['address'],
                'type'           => $result['type'],
                'open'           => $result['open'],
            );
        }

        $location_info['latitude'] = $result['latitude'];

        $location_info['longitude'] = $result['longitude'];

        $location_info['telephone'] = $result['telephone'];

        $location_info['languages'] = $Languages_Locations;

        return $location_info;
    }

    public function getLocations($data = array()) {
        $sql = "SELECT location_id, name, address, telephone, type FROM " . DB_PREFIX . "location where language_id = '" . (int)$this->config->get('config_language_id') . "'";

        $sort_data = array(
            'name',
            'type',
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
    }

    public function getTotalLocations() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "location WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row['total'];
    }
}

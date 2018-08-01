<?php
class ModelPaymentMasterCard extends Model {
    public function getMethod($address, $total) {
        $this->load->language('payment/master_card');


            $method_data = array(
                'code'       => 'master_card',
                'title'      => $this->language->get('text_title'),
                'terms'      => '',
                'sort_order' => $this->config->get('master_card_sort_order')
            );

        return $method_data;
    }
}
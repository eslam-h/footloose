<?php
class ControllerPaymentMasterCard extends Controller {
    public function index() {
        $this->load->language('payment/master_card');

        $this->load->model('checkout/order');
        $this->load->model('setting/setting');

        unset($this->session->data['exact_order_id']);
        unset($this->session->data['merchant_id']);
        unset($this->session->data['merchant_name']);
        unset($this->session->data['merchant_password']);
        unset($this->session->data['merchant_currency']);

        $merchant_info = $this->model_setting_setting->getSetting('master_card');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $data['merchant_id'] = $merchant_info['master_card_merchant_id'];
        $data['merchant_name'] = $merchant_info['master_card_merchant_name'];
        $data['merchant_password'] = $merchant_info['master_card_merchant_password'];
        $data['merchant_currency'] = $merchant_info['master_card_merchant_currency'];

        $data['order_money'] = $order_info['total'];

        $merchant_id = $data['merchant_id'];
        $merchant_name = $data['merchant_name'];
        $merchant_password = $data['merchant_password'];
        $merchant_currency = $data['merchant_currency'];

        $this->session->data['merchant_id'] = $merchant_id;
        $this->session->data['merchant_name'] = $merchant_name;
        $this->session->data['merchant_password'] = $merchant_password;
        $this->session->data['merchant_currency'] = $merchant_currency;

        $order_id = $order_info['order_id'] * 1000000000;
        $order_id +=(rand(10000, 1000000000));
        $data['order_id'] = $order_id;

        $this->session->data['exact_order_id'] = $order_id;

        $url = 'https://qnbalahli.test.gateway.mastercard.com/api/nvp/version/45';

        $post = "apiOperation=CREATE_CHECKOUT_SESSION&apiUsername=$merchant_name&apiPassword=$merchant_password&merchant=$merchant_id&order.currency=$merchant_currency&order.id=$order_id";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type: application/x-www-form-urlencoded;charset=UTF-8"));
        $response = curl_exec($ch);

        if (!$response) {
            echo "Curl Error: " . curl_error($ch);
            die();
        }

        $responses = explode("&", $response);
        $data['session_id'] = explode("=", $responses[2])[1];

        return $this->load->view('payment/master_card', $data);
    }

    public function errorCallback() {
        $this->response->redirect($this->url->link('checkout/failure', '', true));
    }

    public function completeCallback() {
        $this->load->model('checkout/order');

        $url = 'https://qnbalahli.test.gateway.mastercard.com/api/nvp/version/45';

        $post = "apiOperation=RETRIEVE_ORDER&apiUsername=" . $this->session->data['merchant_name'] . "&apiPassword=" . $this->session->data['merchant_password'] . "&merchant=" . $this->session->data['merchant_id'] . "&order.id=" . $this->session->data['exact_order_id'] . "";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type: application/x-www-form-urlencoded;charset=UTF-8"));
        $response = curl_exec($ch);

        if (!$response) {
            echo "Curl Error: " . curl_error($ch);
            die();
        }

        $responses = explode("&", $response);

        if(isset($responses[9])) {
            $name = explode("=", $responses[9])[0];
            $value = explode("=", $responses[9])[1];
            if($name == 'result' && $value == 'SUCCESS') {
                $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('master_card_order_status_id'), '', true);
                $this->response->redirect($this->url->link('checkout/success', '', true));
            }
            else {
                $this->response->redirect($this->url->link('checkout/failure', '', true));
            }
        }
        else {
            $this->response->redirect($this->url->link('checkout/failure', '', true));
        }
    }
}
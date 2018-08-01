<?php
class ControllerPaymentMasterCard extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('payment/master_card');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('master_card', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');

        $data['entry_merchant_id'] = $this->language->get('entry_merchant_id');
        $data['entry_merchant_name'] = $this->language->get('entry_merchant_name');
        $data['entry_merchant_password'] = $this->language->get('entry_merchant_password');
        $data['entry_merchant_currency'] = $this->language->get('entry_merchant_currency');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_order_status'] = $this->language->get('entry_order_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['merchant-id'])) {
            $data['error_merchant_id'] = $this->error['merchant-id'];
        } else {
            $data['error_merchant_id'] = '';
        }

        if (isset($this->error['merchant-name'])) {
            $data['error_merchant_name'] = $this->error['merchant-name'];
        } else {
            $data['error_merchant_name'] = '';
        }

        if (isset($this->error['merchant-password'])) {
            $data['error_merchant_password'] = $this->error['merchant-password'];
        } else {
            $data['error_merchant_password'] = '';
        }

        if (isset($this->error['merchant-currency'])) {
            $data['error_merchant_currency'] = $this->error['merchant-currency'];
        } else {
            $data['error_merchant_currency'] = '';
        }

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['master_card_order_status_id'])) {
            $data['master_card_order_status_id'] = $this->request->post['master_card_order_status_id'];
        } else {
            $data['master_card_order_status_id'] = $this->config->get('master_card_order_status_id');
        }


        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/master_card', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('payment/master_card', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], true);

        if (isset($this->request->post['master_card_merchant_id'])) {
            $data['merchant_id'] = $this->request->post['master_card_merchant_id'];
        } else {
            $data['merchant_id'] = $this->config->get('master_card_merchant_id');
        }

        if (isset($this->request->post['master_card_merchant_name'])) {
            $data['merchant_name'] = $this->request->post['master_card_merchant_name'];
        } else {
            $data['merchant_name'] = $this->config->get('master_card_merchant_name');
        }

        if (isset($this->request->post['master_card_merchant_password'])) {
            $data['merchant_password'] = $this->request->post['master_card_merchant_password'];
        } else {
            $data['merchant_password'] = $this->config->get('master_card_merchant_password');
        }

        if (isset($this->request->post['master_card_merchant_currency'])) {
            $data['merchant_currency'] = $this->request->post['master_card_merchant_currency'];
        } else {
            $data['merchant_currency'] = $this->config->get('master_card_merchant_currency');
        }

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } else {
            $data['sort_order'] = $this->config->get('sort_order');
        }

        if (isset($this->request->post['master_card_status'])) {
            $data['master_card_status'] = $this->request->post['master_card_status'];
        } else {
            $data['master_card_status'] = $this->config->get('master_card_status');
        }

//        $data['callback'] = HTTP_CATALOG . 'index.php?route=payment/master_card/callback';

//        $this->load->model('localisation/order_status');
//
//        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
//

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/master_card', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'payment/master_card')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['master_card_merchant_id']) {
            $this->error['merchant-id'] = $this->language->get('error_merchant_id');
        }

        if (!$this->request->post['master_card_merchant_name']) {
            $this->error['merchant-name'] = $this->language->get('error_merchant_name');
        }

        if (!$this->request->post['master_card_merchant_password']) {
            $this->error['merchant-password'] = $this->language->get('error_merchant_password');
        }

        if (!$this->request->post['master_card_merchant_currency']) {
            $this->error['merchant-currency'] = $this->language->get('error_merchant_currency');
        }


        return !$this->error;
    }
}
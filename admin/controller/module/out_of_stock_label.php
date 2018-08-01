<?php

class ControllerModuleOutOfStockLabel extends Controller {

    public function index() {
        $this->load->language('module/out_of_stock_label');
        $this->load->model('module/out_of_stock_label');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        $data = array();
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate($data)) {
            $post = array();
            $post['out_of_stock_label_enabled'] = $this->request->post['out_of_stock_label_enabled'];
            $post['out_of_stock_label_style'] = $this->request->post['out_of_stock_label_style'];
            $post['out_of_stock_label_show_marker_in_product_page'] = $this->request->post['out_of_stock_label_show_marker_in_product_page'];

            $this->model_setting_setting->editSetting('out_of_stock_label', $post);

            $this->model_module_out_of_stock_label->updateLabels($this->request->post['out_of_stock_label_label']);

            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_out_of_stock_label'] = $this->language->get('entry_out_of_stock_label');
        $data['entry_out_of_stock_label_show_marker_in_product_page'] = $this->language->get('entry_out_of_stock_label_show_marker_in_product_page');
        $data['entry_style'] = $this->language->get('entry_style');
        $data['entry_css_nodes'] = $this->language->get('entry_css_nodes');
        $data['entry_css_nodes_content'] = $this->language->get('entry_css_nodes_content');
        $data['entry_load_default_style'] = $this->language->get('entry_load_default_style');
        $data['entry_placeholder'] = $this->language->get('entry_placeholder');
        $data['entry_confirm_default_style_loading'] = $this->language->get('entry_confirm_default_style_loading');
        
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');



        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/out_of_stock_label', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('module/out_of_stock_label', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        // status
        if (isset($this->request->post['out_of_stock_label_enabled'])) {
            $data['out_of_stock_label_enabled'] = $this->request->post['out_of_stock_label_enabled'];
        } else {
            $data['out_of_stock_label_enabled'] = $this->config->get('out_of_stock_label_enabled');
        }
        // status
        if (isset($this->request->post['out_of_stock_label_show_marker_in_product_page'])) {
            $data['out_of_stock_label_show_marker_in_product_page'] = $this->request->post['out_of_stock_label_show_marker_in_product_page'];
        } else {
            $data['out_of_stock_label_show_marker_in_product_page'] = $this->config->get('out_of_stock_label_show_marker_in_product_page');
        }

       
        // label
        if (isset($this->request->post['out_of_stock_label_label'])) {
            $data['out_of_stock_label_label'] = $this->request->post['out_of_stock_label_label'];
        } else {
            $data['out_of_stock_label_label'] = $this->model_module_out_of_stock_label->getLabels();
        }

        // style
        if (isset($this->request->post['out_of_stock_label_style'])) {
            $data['out_of_stock_label_style'] = $this->request->post['out_of_stock_label_style'];
        } else {
            $data['out_of_stock_label_style'] = $this->config->get('out_of_stock_label_style');
        }
        // default style
        $data['out_of_stock_label_default_style'] = $this->config->get('out_of_stock_label_default_style');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/out_of_stock_label.tpl', $data));
    }

    protected function validate(&$data) {
        $data['error_label'] = array();
        $labels = $this->request->post['out_of_stock_label_label'];
        foreach ($labels as $key => $label) {
            if (empty($label['label'])) {
                $data['error_label'][$key] = $this->language->get('error_empty_line');
            }
        }



        return !$data['error_label'];
    }

    public function install() {
        $this->load->model('setting/setting');
        $post = array();
        $post['out_of_stock_label_enabled'] = "1";
        $post['out_of_stock_label_show_marker_in_product_page'] = "1";
        $post['out_of_stock_label_style'] = $post['out_of_stock_label_default_style'] = ".product-layout{
    overflow: hidden;
}

.product-not-available{
    color: white;
    position: absolute;
    text-transform: uppercase;
    text-align: center;
    border: 3px white double;
    width: 200px;
    background-color: #b90909;
    margin-left: -74px;
    margin-top: 15px;
    -ms-transform: rotate(-45deg); 
    -webkit-transform: rotate(-45deg); 
    transform: rotate(-45deg);
    z-index: 3;
    height: 27px;
}

.product-not-available p{
    padding-top: 1px;
    width: 120px;
    margin: auto;
    font-size: 11px;
    margin-left: 30px;
}

.product-not-available:before{
    -ms-transform: rotate(45deg); 
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
    content:\"*\";
    color: transparent;
    position: absolute;
    z-index: -1;
    border-left: 15px solid transparent;
    border-bottom: 5px solid transparent;
    border-top: 15px solid transparent;
    border-right: 15px solid #890606;
    height: 0;
    width: 0;
    margin-left: -82px;
    margin-top: 11px;
}

.not-available-mark{
    position: absolute;
    text-transform: uppercase;
    background-color: #b90909;
    color: white;
    font-size: 30px;
    padding: 10px;
    padding-left: 10px;
    padding-right: 10px;
    border: 5px white double;
    -ms-transform: rotate(-45deg); /* IE 9 */
    -webkit-transform: rotate(-45deg); /* Chrome, Safari, Opera */
    transform: rotate(-45deg);
    left: 33%;
    margin-top: 94px;
    left: 50%;
    margin-left: -140px;
    width: 280px;
    text-align: center;
}";

        $this->model_setting_setting->editSetting('out_of_stock_label', $post);

        $this->load->model('module/out_of_stock_label');
        $this->model_module_out_of_stock_label->createOutOfStockLabelTable();
    }

    public function uninstall() {
        $this->load->model('module/out_of_stock_label');
        $this->model_module_out_of_stock_label->deleteOutOfStockLabelTable();
    }

}

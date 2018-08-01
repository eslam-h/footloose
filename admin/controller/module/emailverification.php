<?php
/**
* 
*/
class ControllerModuleEmailVerification extends Controller
{
    private $error = array();
    private $version;
    
    public function index () {        

        $this->version = '2.0.2';

        //load language
        $this->load->language('module/emailverification');

        //Set main title
        $this->document->setTitle($this->language->get('heading_title'));
        
        //Add styles
         $this->document->addStyle('view/stylesheet/emailverification/emailverification.css');

        //Load models       
        $this->load->model('setting/setting');
        $this->load->model('setting/store');
        $this->load->model('localisation/language');

        if (VERSION >= '2.1.0.1') {
            $this->load->model('customer/customer_group');
            $data['customerGroups'] = $this->model_customer_customer_group->getCustomerGroups();
        } else {
            $this->load->model('sale/customer_group');
            $data['customerGroups'] = $this->model_sale_customer_group->getCustomerGroups();
        }
       
        if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0; 
        }

        
        $token =  $this->request->get['token'];
        $data['token'] =  $this->request->get['token'];
    
        $store = $this->getCurrentStore($this->request->get['store_id']);

        $languages = $this->model_localisation_language->getLanguages();
        $data['languages'] = $languages;
        
        foreach ($data['languages'] as $key => $value) {
            if(version_compare(VERSION, '2.2.0.0', "<")) {
                $data['languages'][$key]['flag_url'] = 'view/image/flags/'.$data['languages'][$key]['image'];
            } else {
                $data['languages'][$key]['flag_url'] = 'language/'.$data['languages'][$key]['code'].'/'.$data['languages'][$key]['code'].'.png"';
            }
        }

        //save settings     
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            
            $this->model_setting_setting->editSetting('emailverification', $this->request->post, $this->request->post['store_id']);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('module/emailverification', 'store_id='.$this->request->post['store_id'].'&token=' . $token, 'SSL'));
        }

        // Breadcrumb data
        $data['breadcrumbs']                = array();
        $data['breadcrumbs'][]              = array(
            'text'                  => $this->language->get('text_home'),
            'href'                  => $this->url->link('common/dashboard', 'token=' . $token, 'SSL'),
        );
        $data['breadcrumbs'][]              = array(
            'text'                  => $this->language->get('text_module'),
            'href'                  => $this->url->link('extension/module', 'token=' . $token, 'SSL'),
        );
        $data['breadcrumbs'][]              = array(
            'text'                  => $this->language->get('heading_title'),
            'href'                  => $this->url->link('module/emailverification', 'token=' . $token, 'SSL'),
        );

        
        $language_variables = array(
            'module_title', 
            'text_module',
            'text_module_settings',
            'text_tab_settings',
            'button_save',
            'button_cancel',
            'entry_status',
            'entry_status_help',
            'text_enabled',
            'text_disabled',
            'subject_text',
            'default_subject',
            'default_message',
            'text_default',
            'user_mail',
            'user_mail_help',
            'email_link',
            'entry_customer_group_help'

        );

        

        foreach ($language_variables as $language_variable) {
            $data[$language_variable] = $this->language->get($language_variable);
        }
        $data['module_title'] =  $this->language->get('module_title').' '.$this->version;
        $data['stores']                 = array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' (' . $this->data['text_default'].')', 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());
        $data['store']                  = $store;
        

        $data['settings']               = $this->model_setting_setting->getSetting('emailverification', $store['store_id']);
        
        
        

        $data['action']                 = $this->url->link('module/emailverification', 'token=' . $token, 'SSL');
        $data['cancel']                 = $this->url->link('extension/module', 'token=' . $token, 'SSL');

        $data['header']                 = $this->load->controller('common/header');
        $data['column_left']            = $this->load->controller('common/column_left');
        $data['footer']                 = $this->load->controller('common/footer');

    
        $this->response->setOutput($this->load->view('module/emailverification'.'.tpl', $data));
    }

    

    private function getCurrentStore($store_id) { 
        $this->load->model('setting/store');   
        if($store_id && $store_id != 0) {
            $store = $this->model_setting_store->getStore($store_id);
        } else {
            $store['store_id'] = 0;
            $store['name'] = $this->config->get('config_name');
            $store['url'] = $this->getCatalogURL(); 
        }
        return $store;
    }

    private function getCatalogURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_CATALOG;
        } else {
            $storeURL = HTTP_CATALOG;
        } 
        return $storeURL;
    }

    private function getServerURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_SERVER;
        } else {
            $storeURL = HTTP_SERVER;
        } 
        return $storeURL;
    }

    public function install() {
        $this->load->model('module/emailverification');
        $this->model_module_emailverification->install();
    }
     public function uninstall() {
        $this->load->model('module/emailverification');
        $this->model_module_emailverification->uninstall();
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/emailverification')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
}
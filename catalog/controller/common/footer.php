<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		
		// Pavo 2.2 fix
		require_once( DIR_SYSTEM . 'pavothemes/loader.php' );

		$this->load->language('module/themecontrol');
		$data['objlang'] = $this->language;

		$config = $this->registry->get('config');
		$data['sconfig'] = $config;

		$helper = ThemeControlHelper::getInstance( $this->registry, $config->get('theme_default_directory') );
		$helper->triggerUserParams( array('header_layout','productlayout') );
		$data['helper'] = $helper;

		$themeConfig = (array)$config->get('themecontrol');
		// Pavo 2.2 end fix

		$this->load->language('common/footer');

		$data['scripts'] = $this->document->getScripts('footer');

//        (int)$this->config->get('config_language_id')

        $data['lang_id'] = (int)$this->config->get('config_language_id');

        $data['text_information'] = $this->language->get('text_information');
		$data['text_usefulLinks'] = $this->language->get('text_usefulLinks');
		$data['text_categories'] = $this->language->get('text_categories');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_stores'] = $this->language->get('text_stores');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
        $data['stores'] = $this->url->link('information/stores');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/account', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);



        $data['text_customerService'] = $this->language->get('text_customerService');
        $data['text_aboutUs'] = $this->language->get('text_aboutUs');
        $data['text_privacyPolicy'] = $this->language->get('text_privacyPolicy');
        $data['text_DeliveryTermsConditions'] = $this->language->get('text_DeliveryTermsConditions');
        $data['text_men'] = $this->language->get('text_men');
        $data['text_women'] = $this->language->get('text_women');
        $data['text_kids'] = $this->language->get('text_kids');
        $data['text_boys'] = $this->language->get('text_boys');
        $data['text_girls'] = $this->language->get('text_girls');
        $data['text_footlooseStores'] = $this->language->get('text_footlooseStores');
        $data['text_crocsConceptStores'] = $this->language->get('text_crocsConceptStores');
        $data['text_crocsOutletStores'] = $this->language->get('text_crocsOutletStores');
        $data['text_newArrivals'] = $this->language->get('text_newArrivals');
        $data['text_newsAndEvents'] = $this->language->get('text_newsAndEvents');
        $data['text_followFootloose'] = $this->language->get('text_followFootloose');
        $data['text_followCrocs'] = $this->language->get('text_followCrocs');
        $data['text_home'] = $this->language->get('text_home');
        $data['text_lifestyle'] = $this->language->get('text_lifestyle');
        $data['text_faqs'] = $this->language->get('text_faqs');

        $data['text_geek'] = $this->language->get('text_geek');
        $data['text_foot'] = $this->language->get('text_geek');
        $data['text_develop'] = $this->language->get('text_develop');
        $data['text_rights'] = $this->language->get('text_rights');
        $data['text_copy'] = $this->language->get('text_copy');


        $data['aboutUs'] = $this->url->link('information/information&information_id=4');
        $data['privacyPolicy'] = $this->url->link('information/information&information_id=3');
        $data['DeliveryTermsConditions'] = $this->url->link('information/information&information_id=5');

        $data['footlooseStores'] = $this->url->link('common/home');
        $data['crocsConceptStores'] = $this->url->link('common/home');
        $data['crocsOutletStores'] = $this->url->link('common/home');
        $data['newArrivals'] = $this->url->link('common/home');
        $data['newsAndEvents'] = $this->url->link('common/home');
        $data['lifestyle'] = $this->url->link('information/lifestyle');
        $data['faqs'] = $this->url->link('information/faq');

        $data['foot'] = $this->url->link('common/home', '', true);
        $data['geek'] = 'http://thegeeksolutions.com/';


		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));


        $this->load->model('catalog/category');



        $data['men'] = $this->url->link('product/category&path='.$this->model_catalog_category->getCategoryIdByName('men')['category_id']);
        $data['women'] = $this->url->link('product/category&path='.$this->model_catalog_category->getCategoryIdByName('women')['category_id']);
        $data['boys'] = $this->url->link('product/category&path='.$this->model_catalog_category->getCategoryIdByName('boys')['category_id']);
        $data['girls'] = $this->url->link('product/category&path='.$this->model_catalog_category->getCategoryIdByName('girls')['category_id']);


        $this->load->model('catalog/information');

        $data['informations'] = array();

        foreach ($this->model_catalog_information->getInformations() as $result) {
            if ($result['bottom']) {
                $data['informations'][] = array(
                    'title' => $result['title'],
                    'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
                );
            }
        }


		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		return $this->load->view('common/footer', $data);
	}
}

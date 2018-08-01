<?php 
class ControllerModuleEmailVerification extends Controller {
	private $error = array();

	public function notVerified() {
		$this->load->model('module/emailverification');
		$this->load->model('setting/setting');
		$settings = $this->model_setting_setting->getSetting('emailverification', $this->config->get('config_store_id'));	
		$this->load->language('module/emailverification');	

		$this->load->model('account/customer');
		$data['success'] = '';
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email_to_verify']);
			if (!$customer_info) {
				$this->error['no_email_match'] = $this->language->get('no_email_match');				
			} else {
				$this->model_module_emailverification->sendVerificationEmail($customer_info['customer_id']);
				$data['success'] = $this->language->get('success');
			}
		}
		
		$data['breadcrumbs'] = array();		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
				
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_not_verified'),
			'href' => $this->url->link('module/emailverification/notVerified')
		);

		$this->load->model('account/customer_group');

		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($this->config->get('config_customer_group_id'));
		
		$data['button_continue'] = $this->language->get('button_continue');
		$data['not_verified_heading'] = $this->language->get('not_verified_heading');
		$data['not_verified_text'] = $this->language->get('not_verified_text');

		$data['resend_text'] = $this->language->get('resend_text');
		$data['resend_button'] = $this->language->get('resend_button');
	
		$data['continue'] = $this->url->link('account/login', '', 'SSL');
		$data['action'] = $this->url->link('module/emailverification/notVerified');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (isset($this->error['email_not_provided'])) {
			$data['email_not_provided'] = $this->error['email_not_provided'];
		} else {
			$data['email_not_provided'] = '';
		}

		if (isset($this->error['no_email_match'])) {
			$data['no_email_match'] = $this->error['no_email_match'];
		} else {
			$data['no_email_match'] = '';
		}

		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/emailverification.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/module/emailverification/notverified.tpl', $data));
			 } else {
				 $this->response->setOutput($this->load->view('default/template/module/emailverification/notverified.tpl', $data));
			 }
		} else {
			   $this->response->setOutput($this->load->view('module/emailverification/notverified.tpl', $data));
		}	
	}
	
	public function verifyCustomer() {		
			
		$this->load->model('module/emailverification');
		$this->load->model('setting/setting');
		$settings = $this->model_setting_setting->getSetting('emailverification', $this->config->get('config_store_id'));	

		
		if (isset($this->request->get['customer_id'])) {
				$customer_id = base64_decode($this->request->get['customer_id']);
				$this->load->language('module/emailverification');		
				$this->document->setTitle($this->language->get('heading_title'));		
				$data['breadcrumbs'] = array();		
				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('text_home'),
					'href' => $this->url->link('common/home')
				);
						
				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('text_account'),
					'href' => $this->url->link('account/account', '', 'SSL')
				);
		
				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('text_success'),
					'href' => $this->url->link('account/success')
				);

				$this->load->model('account/customer_group');
		
				$customer_group_info = $this->model_account_customer_group->getCustomerGroup($this->config->get('config_customer_group_id'));
				$data['button_continue'] = $this->language->get('button_continue');
		
				if ($this->cart->hasProducts()) {
					$data['continue'] = $this->url->link('checkout/cart');
				} else {
					$data['continue'] = $this->url->link('account/account', '', 'SSL');
				}
		
				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');
		
			if(!$this->model_module_emailverification->isCustomerVerified($customer_id, $this->config->get('config_store_id'))){
				
				$this->model_module_emailverification->verifyCustomer($customer_id, $this->config->get('config_store_id'));		
				
				$data['emailverification_heading_title'] = $this->language->get('emailverification_heading_title');	

				if ($customer_group_info['approval']) {
					$data['text_message'] = sprintf($this->language->get('text_message'), $this->url->link('information/contact'));
				} else {
					$data['text_message'] = sprintf($this->language->get('text_approved'), $this->config->get('config_name'), $this->url->link('information/contact'));
				}
				
			} else {
				$data['emailverification_heading_title'] = $this->language->get('heading_title_already_approved');
		
				if ($customer_group_info['approval']) {
					$data['text_message'] = sprintf($this->language->get('text_message_already_approved'), $this->url->link('information/contact'));
				} else {
					$data['text_message'] = sprintf($this->language->get('text_approval_already_verified'), $this->config->get('config_name'), $this->url->link('information/contact'));
				}
						
			}
			if(version_compare(VERSION, '2.2.0.0', "<")) {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/emailverification.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/module/emailverification.tpl', $data));
				 } else {
					 $this->response->setOutput($this->load->view('default/template/module/emailverification.tpl', $data));
				 }
			} else {
				   $this->response->setOutput($this->load->view('module/emailverification.tpl', $data));
			}	
		}	
			
	}
	private function validate()	{
		if(empty($this->request->post['email_to_verify'])){
			$this->error['email_not_provided'] = $this->language->get('email_not_provided');
		}
		return !$this->error;
	}	
}
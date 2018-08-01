<?php

class ModelModuleEmailVerification extends Model {
	public function sendVerificationEmail($customer_id)
	{
		
		$this->load->model('setting/setting');
		$this->load->model('account/customer');
		$this->load->model('localisation/language');
		$this->load->model('account/customer_group');
	
		//get language ID
		$settings = $this->model_setting_setting->getSetting('emailverification', $this->config->get('config_store_id'));
		$customer = $this->model_account_customer->getCustomer($customer_id);
		
		
		//get customer email
		$customer_email = $customer['email'];

		//generate link	
		$email_link = $this->url->link('module/emailverification/verifyCustomer', 'customer_id='.base64_encode($customer_id));
		
		//generate message
		$messageToCustomer = html_entity_decode($settings['emailverification']['message'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		$wordTemplates = array("{firstname}", "{lastname}","{email-link}");
		$words   = array($customer['firstname'], $customer['lastname'],$email_link);					
		$messageToCustomer = str_replace($wordTemplates, $words, $messageToCustomer);
		
		$subject = $settings['emailverification']['subject'][$this->config->get('config_language_id')];
		
		
		if (VERSION >= '2.0.0.0' && VERSION < '2.0.2.0') {
            $mail = new Mail($this->config->get('config_mail'));
        } else {
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');    
            if (VERSION >= '2.0.2.0') {
                $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
            } else {
                $mail->hostname = $this->config->get('config_smtp_host');
                $mail->username = $this->config->get('config_smtp_username');
                $mail->password = $this->config->get('config_smtp_password');
                $mail->port = $this->config->get('config_smtp_port');
                $mail->timeout = $this->config->get('config_smtp_timeout');
            }
        }
        $mail->setTo($customer_email);
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $mail->setSubject($subject);
        $mail->setHtml($messageToCustomer);
        $mail->send();    
		
		
	}

	public function verifyCustomer ($customer_id, $store_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET verified = 1  WHERE customer_id = '" . (int)$customer_id . "' AND store_id='".(int)$store_id."'");
		$this->load->model('account/customer');
		$customer = $this->model_account_customer->getCustomer($customer_id);

		$this->load->model('account/customer_group');

		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer['customer_group_id']);
		
		$this->load->language('mail/customer');
		$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$message = sprintf($this->language->get('text_welcome'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";

		if (!$customer_group_info['approval']) {
			$message .= $this->language->get('text_login') . "\n";
		} else {
			$message .= $this->language->get('text_approval') . "\n";
		}

		$message .= $this->url->link('account/login', '', true) . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
		
		if (VERSION >= '2.0.0.0' && VERSION < '2.0.2.0') {
            $mail = new Mail($this->config->get('config_mail'));
        } else {
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');    
            if (VERSION >= '2.0.2.0') {
                $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
            } else {
                $mail->hostname = $this->config->get('config_smtp_host');
                $mail->username = $this->config->get('config_smtp_username');
                $mail->password = $this->config->get('config_smtp_password');
                $mail->port = $this->config->get('config_smtp_port');
                $mail->timeout = $this->config->get('config_smtp_timeout');
            }
        }
		$mail->setTo($customer['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$mail->setSubject($subject);
		$mail->setText($message);
		$mail->send();
	}
	
	public function validateCustomerGroup($customer_group_id){
		$this->load->model('setting/setting');
		$settings = $this->model_setting_setting->getSetting('emailverification', $this->config->get('config_store_id'));
		$customer_groups = $settings['emailverification']['customerGroups'];
		return array_key_exists($customer_group_id, $customer_groups);
	}
	
	public function isCustomerVerified ($customer_id, $store_id = 0){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "' AND store_id='".(int)$store_id."'");
		if($query->num_rows){
			return $query->row['verified'];
		}
	}

}
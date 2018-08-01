<?php
class ModelToolsalescombo extends Model {
	public function total() {
		$message['success'] = $message['warning'] = array(); 
		$this->load->language('module/salescombopage');
		$this->load->model('offers/salescombopge');
		$this->session->data['cartbindercombooffers_pages'] = array_unique($this->session->data['cartbindercombooffers_pages']);
		
		foreach ($this->session->data['cartbindercombooffers_pages'] as $key => $value) {
			$url = $this->url->link('offers/salescombopge', 'page_id=' .  $value);
			$salescombopge_info = $this->model_offers_salescombopge->getPage($value);
			if ($salescombopge_info) {
				if($this->customer->getId()) {
					$name = $this->customer->getFirstName();
					$message['warning'][] = 	sprintf($this->language->get('eligibleforgifttotalcustomer'),$name,$salescombopge_info['title'],$url);
		 		} else {
					$message['warning'][] = 	sprintf($this->language->get('eligibleforgifttotal'),$salescombopge_info['title'],$url);
				}
			}	
		}
		$this->session->data['cartbindercombooffers_offerapplied'] = array_unique($this->session->data['cartbindercombooffers_offerapplied']);
		foreach ($this->session->data['cartbindercombooffers_offerapplied'] as $key => $value) {
			$url = $this->url->link('offers/salescombopge', 'page_id=' .  $value);
			$salescombopge_info = $this->model_offers_salescombopge->getPage($value);
			if ($salescombopge_info) {
				if($this->customer->getId()) {
					$name = $this->customer->getFirstName();
					$message['success'][] = 	sprintf($this->language->get('appliedgifttotalcustomer'),$name,$salescombopge_info['title'],$url);
		 		} else {
					$message['success'][] = 	sprintf($this->language->get('appliedgifttotal'),$salescombopge_info['title'],$url);
				}
			}	
		}
		return $message;
	}
}
<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['text_footer'] = $this->language->get('text_footer');

        $data['lang_id'] = (int)$this->config->get('config_language_id');

        $data['text_geek'] = $this->language->get('text_geek');
        $data['text_foot'] = $this->language->get('text_geek');
        $data['text_develop'] = $this->language->get('text_develop');
        $data['text_rights'] = $this->language->get('text_rights');
        $data['text_copy'] = $this->language->get('text_copy');


//        echo $data['text_copy'];

        return $this->load->view('common/footer', $data);
	}
}

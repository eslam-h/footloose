<?php
class ControllerCatalogLifestyle extends Controller {
    private $error = array();

    public function index()
    {
        $this->load->language('catalog/lifestyle');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/lifestyle');

        $this->getList();

    }


    public function getList() {

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'] . $url, true)
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('catalog/lifestyle', 'token=' . $this->session->data['token'] . $url, true)
        );

        $filter_data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );


        $totalManufacturers = $this->model_catalog_lifestyle->getTotalManufacturers();

        $results = $this->model_catalog_lifestyle->getManufacturers($filter_data);

        $data['manufacturers'] = array();

        foreach ($results as $result) {
            $data['manufacturers'][] = array(
                'manufacturer_id' => $result['manufacturer_id'],
                'title'          => $result['name'],
                'sort_order'     => $result['sort_order'],
                'edit'           => $this->url->link('catalog/lifestyle/edit', 'token=' . $this->session->data['token'] . '&manufacturer_id=' . $result['manufacturer_id'] . $url, true)
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_title'] = $this->language->get('column_title');
        $data['column_sort_order'] = $this->language->get('column_sort_order');
        $data['column_action'] = $this->language->get('column_action');

        $data['button_edit'] = $this->language->get('button_edit');


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_title'] = $this->url->link('catalog/lifestyle', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
        $data['sort_sort_order'] = $this->url->link('catalog/lifestyle', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, true);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $totalManufacturers;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('catalog/lifestyle', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($totalManufacturers) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($totalManufacturers - $this->config->get('config_limit_admin'))) ? $totalManufacturers : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $totalManufacturers, ceil($totalManufacturers / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/lifestyle', $data));

    }

    public function edit() {
        $this->load->language('catalog/lifestyle');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/lifestyle');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_lifestyle->editLifestyle($this->request->get['manufacturer_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('catalog/lifestyle', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    protected function getForm() {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['manufacturer_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        $data['entry_image'] = $this->language->get('entry_image');
        $data['entry_video'] = $this->language->get('entry_video');
        $data['entry_video_url'] = $this->language->get('entry_video_url');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_image_add'] = $this->language->get('button_image_add');
        $data['button_video_add'] = $this->language->get('button_video_add');
        $data['button_remove'] = $this->language->get('button_remove');

        $data['tab_pictures'] = $this->language->get('tab_pictures');
        $data['tab_videos'] = $this->language->get('tab_videos');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = array();
        }

        if (isset($this->error['description'])) {
            $data['error_description'] = $this->error['description'];
        } else {
            $data['error_description'] = array();
        }

        if (isset($this->error['meta_title'])) {
            $data['error_meta_title'] = $this->error['meta_title'];
        } else {
            $data['error_meta_title'] = array();
        }

        if (isset($this->error['keyword'])) {
            $data['error_keyword'] = $this->error['keyword'];
        } else {
            $data['error_keyword'] = '';
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/lifestyle', 'token=' . $this->session->data['token'] . $url, true)
        );

        if (isset($this->request->get['manufacturer_id'])) {
            $gallery_images = $this->model_catalog_lifestyle->getGalleryImages($this->request->get['manufacturer_id']);
            $gallery_videos = $this->model_catalog_lifestyle->getGalleryVideos($this->request->get['manufacturer_id']);
        } else {
            $gallery_images = array();
            $gallery_videos = array();
        }

        $this->load->model('tool/image');
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        // Images
        $data['gallery_images'] = array();
        $data['gallery_videos'] = array();

        foreach ($gallery_images as $gallery_image) {
            if (is_file(DIR_IMAGE . $gallery_image['path'])) {
                $image = $gallery_image['path'];
                $thumb = $gallery_image['path'];
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }

            $data['gallery_images'][] = array(
                'image'      => $image,
                'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
                'sort_order' => $gallery_image['sort_order']
            );
        }

        foreach ($gallery_videos as $gallery_video) {
            $data['gallery_videos'][] = array(
                'link'       => $gallery_video['link'],
                'sort_order' => $gallery_video['sort_order']
            );
        }


        $data['action'] = $this->url->link('catalog/lifestyle/edit', 'token=' . $this->session->data['token'] . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url, true);
        $data['cancel'] = $this->url->link('catalog/lifestyle', 'token=' . $this->session->data['token'] . $url, true);

        $data['token'] = $this->session->data['token'];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/lifestyle_form', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/lifestyle')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

}
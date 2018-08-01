<?php
class ControllerSaleVoucher extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('sale/voucher');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/voucher');

		$this->getList();
	}

    public function add() {
        $this->load->language('sale/voucher');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/voucher');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_sale_voucher->addVoucher($this->request->post);

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

            $this->response->redirect($this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

	public function edit() {
		$this->load->language('sale/voucher');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/voucher');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_voucher->editVoucher($this->request->get['voucher_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('sale/voucher');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/voucher');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $voucher_id) {
				$this->model_sale_voucher->deleteVoucher($voucher_id);
			}

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

			$this->response->redirect($this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

    public function upload() {
        $this->load->language('tool/export_import');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('sale/voucher');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateUploadForm())) {
            if ((isset( $this->request->files['upload'] )) && (is_uploaded_file($this->request->files['upload']['tmp_name']))) {
                $file = $this->request->files['upload']['tmp_name'];
                if ($this->model_sale_voucher->upload($file)==true) {
                    $this->session->data['success'] = $this->language->get('text_success');
                    $this->response->redirect($this->url->link('sale/voucher', 'token=' . $this->session->data['token'], $this->ssl));
                }
                else {
                    $this->error['warning'] = $this->language->get('error_upload');
                }
            }
        }

        $this->getImportForm();
    }

    protected function getImportForm() {
        $data = array();
        $data['heading_title'] = 'Vouchers Import';

        $data['entry_import'] = $this->language->get( 'entry_import' );
        $data['entry_upload'] = $this->language->get( 'entry_upload' );

        $data['tab_import'] = $this->language->get( 'tab_import' );

        $data['button_import'] = $this->language->get( 'button_import' );

        $data['error_select_file'] = $this->language->get('error_select_file');
        $data['error_post_max_size'] = str_replace( '%1', ini_get('post_max_size'), $this->language->get('error_post_max_size') );
        $data['error_upload_max_filesize'] = str_replace( '%1', ini_get('upload_max_filesize'), $this->language->get('error_upload_max_filesize') );

        if (!empty($this->session->data['export_import_error']['errstr'])) {
            $this->error['warning'] = $this->session->data['export_import_error']['errstr'];
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
            if (!empty($this->session->data['export_import_nochange'])) {
                $data['error_warning'] .= "<br />\n".$this->language->get( 'text_nochange' );
            }
        } else {
            $data['error_warning'] = '';
        }

        unset($this->session->data['export_import_error']);
        unset($this->session->data['export_import_nochange']);

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], $this->ssl)
        );
        $data['breadcrumbs'][] = array(
            'text' => 'Vouchers Import',
            'href' => $this->url->link('sale/voucher/import', 'token=' . $this->session->data['token'], $this->ssl)
        );

        $data['back'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'], $this->ssl);
        $data['button_back'] = $this->language->get( 'button_back' );
        $data['import'] = $this->url->link('sale/voucher/upload', 'token=' . $this->session->data['token'], $this->ssl);
        $data['post_max_size'] = $this->return_bytes( ini_get('post_max_size') );
        $data['upload_max_filesize'] = $this->return_bytes( ini_get('upload_max_filesize') );


        $data['token'] = $this->session->data['token'];

        $this->document->addStyle('view/stylesheet/export_import.css');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('sale/voucher_import', $data));
    }

    protected function validateUploadForm() {
        if (!$this->user->hasPermission('modify', 'sale/voucher')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!isset($this->request->files['upload']['name'])) {
            if (isset($this->error['warning'])) {
                $this->error['warning'] .= "<br /\n" . $this->language->get( 'error_upload_name' );
            } else {
                $this->error['warning'] = $this->language->get( 'error_upload_name' );
            }
        } else {
            $ext = strtolower(pathinfo($this->request->files['upload']['name'], PATHINFO_EXTENSION));
            if (($ext != 'xls') && ($ext != 'xlsx') && ($ext != 'ods')) {
                if (isset($this->error['warning'])) {
                    $this->error['warning'] .= "<br /\n" . $this->language->get( 'error_upload_ext' );
                } else {
                    $this->error['warning'] = $this->language->get( 'error_upload_ext' );
                }
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    protected function return_bytes($val)
    {
        $val = trim($val);

        switch (strtolower(substr($val, -1)))
        {
            case 'm': $val = (int)substr($val, 0, -1) * 1048576; break;
            case 'k': $val = (int)substr($val, 0, -1) * 1024; break;
            case 'g': $val = (int)substr($val, 0, -1) * 1073741824; break;
            case 'b':
                switch (strtolower(substr($val, -2, 1)))
                {
                    case 'm': $val = (int)substr($val, 0, -2) * 1048576; break;
                    case 'k': $val = (int)substr($val, 0, -2) * 1024; break;
                    case 'g': $val = (int)substr($val, 0, -2) * 1073741824; break;
                    default : break;
                } break;
            default: break;
        }
        return $val;
    }

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'v.date_added';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
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
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, true)
		);

        $data['import'] = $this->url->link('sale/voucher/upload', 'token=' . $this->session->data['token'] . $url, true);
		$data['add'] = $this->url->link('sale/voucher/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('sale/voucher/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['vouchers'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$voucher_total = $this->model_sale_voucher->getTotalVouchers();

		$results = $this->model_sale_voucher->getVouchers($filter_data);

		foreach ($results as $result) {
			if ($result['order_id']) {	
				$order = $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true);
			} else {
				$order = '';
			}
			
			$data['vouchers'][] = array(
				'voucher_id' => $result['voucher_id'],
				'code'       => $result['code'],
				'from'       => $result['from_name'],
				'to'         => $result['to_name'],
				'theme'      => $result['theme'],
				'amount'     => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'date_end' => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
				'edit'       => $this->url->link('sale/voucher/edit', 'token=' . $this->session->data['token'] . '&voucher_id=' . $result['voucher_id'] . $url, true),
				'order'      => $order
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_code'] = $this->language->get('column_code');
		$data['column_from'] = $this->language->get('column_from');
		$data['column_to'] = $this->language->get('column_to');
		$data['column_theme'] = $this->language->get('column_theme');
		$data['column_amount'] = $this->language->get('column_amount');
		$data['column_status'] = $this->language->get('column_status');
        $data['column_date_added'] = $this->language->get('column_date_added');
        $data['column_date_end'] = $this->language->get('column_date_end');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_send'] = $this->language->get('button_send');
		$data['button_order'] = $this->language->get('button_order');

		$data['token'] = $this->session->data['token'];

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

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
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

		$data['sort_code'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.code' . $url, true);
		$data['sort_from'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.from_name' . $url, true);
		$data['sort_to'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.to_name' . $url, true);
		$data['sort_theme'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=theme' . $url, true);
		$data['sort_amount'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.amount' . $url, true);
		$data['sort_status'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.date_end' . $url, true);
        $data['sort_date_added'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.date_added' . $url, true);
        $data['sort_date_end'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.date_end' . $url, true);
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $voucher_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($voucher_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($voucher_total - $this->config->get('config_limit_admin'))) ? $voucher_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $voucher_total, ceil($voucher_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/voucher_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['voucher_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_from_name'] = $this->language->get('entry_from_name');
		$data['entry_from_email'] = $this->language->get('entry_from_email');
		$data['entry_to_name'] = $this->language->get('entry_to_name');
		$data['entry_to_email'] = $this->language->get('entry_to_email');
		$data['entry_theme'] = $this->language->get('entry_theme');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_status'] = $this->language->get('entry_status');
        $data['entry_date_end'] = $this->language->get('entry_date_end');

		$data['help_code'] = $this->language->get('help_code');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_send'] = $this->language->get('button_send');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_history'] = $this->language->get('tab_history');

		if (isset($this->request->get['voucher_id'])) {
			$data['voucher_id'] = $this->request->get['voucher_id'];
		} else {
			$data['voucher_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}

		if (isset($this->error['from_name'])) {
			$data['error_from_name'] = $this->error['from_name'];
		} else {
			$data['error_from_name'] = '';
		}

		if (isset($this->error['from_email'])) {
			$data['error_from_email'] = $this->error['from_email'];
		} else {
			$data['error_from_email'] = '';
		}

		if (isset($this->error['to_name'])) {
			$data['error_to_name'] = $this->error['to_name'];
		} else {
			$data['error_to_name'] = '';
		}

		if (isset($this->error['to_email'])) {
			$data['error_to_email'] = $this->error['to_email'];
		} else {
			$data['error_to_email'] = '';
		}

		if (isset($this->error['amount'])) {
			$data['error_amount'] = $this->error['amount'];
		} else {
			$data['error_amount'] = '';
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
			'href' => $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['voucher_id'])) {
			$data['action'] = $this->url->link('sale/voucher/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('sale/voucher/edit', 'token=' . $this->session->data['token'] . '&voucher_id=' . $this->request->get['voucher_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['voucher_id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
			$voucher_info = $this->model_sale_voucher->getVoucher($this->request->get['voucher_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['code'])) {
			$data['code'] = $this->request->post['code'];
		} elseif (!empty($voucher_info)) {
			$data['code'] = $voucher_info['code'];
		} else {
			$data['code'] = '';
		}

		if (isset($this->request->post['from_name'])) {
			$data['from_name'] = $this->request->post['from_name'];
		} elseif (!empty($voucher_info)) {
			$data['from_name'] = $voucher_info['from_name'];
		} else {
			$data['from_name'] = '';
		}

		if (isset($this->request->post['from_email'])) {
			$data['from_email'] = $this->request->post['from_email'];
		} elseif (!empty($voucher_info)) {
			$data['from_email'] = $voucher_info['from_email'];
		} else {
			$data['from_email'] = '';
		}

		if (isset($this->request->post['to_name'])) {
			$data['to_name'] = $this->request->post['to_name'];
		} elseif (!empty($voucher_info)) {
			$data['to_name'] = $voucher_info['to_name'];
		} else {
			$data['to_name'] = '';
		}

		if (isset($this->request->post['to_email'])) {
			$data['to_email'] = $this->request->post['to_email'];
		} elseif (!empty($voucher_info)) {
			$data['to_email'] = $voucher_info['to_email'];
		} else {
			$data['to_email'] = '';
		}

		$this->load->model('sale/voucher_theme');

		$data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

		if (isset($this->request->post['voucher_theme_id'])) {
			$data['voucher_theme_id'] = $this->request->post['voucher_theme_id'];
		} elseif (!empty($voucher_info)) {
			$data['voucher_theme_id'] = $voucher_info['voucher_theme_id'];
		} else {
			$data['voucher_theme_id'] = '';
		}

		if (isset($this->request->post['message'])) {
			$data['message'] = $this->request->post['message'];
		} elseif (!empty($voucher_info)) {
			$data['message'] = $voucher_info['message'];
		} else {
			$data['message'] = '';
		}

		if (isset($this->request->post['amount'])) {
			$data['amount'] = $this->request->post['amount'];
		} elseif (!empty($voucher_info)) {
			$data['amount'] = $voucher_info['amount'];
		} else {
			$data['amount'] = '';
		}

        if (isset($this->request->post['date_end'])) {
            $data['date_end'] = $this->request->post['date_end'];
        } elseif (!empty($voucher_info)) {
            $data['date_end'] = ($voucher_info['date_end'] != '0000-00-00' ? $voucher_info['date_end'] : '');
        } else {
            $data['date_end'] = date('Y-m-d', strtotime('+1 month'));
        }

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($voucher_info)) {
			$data['status'] = $voucher_info['status'];
		} else {
			$data['status'] = true;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/voucher_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/voucher')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['code']) < 3) || (utf8_strlen($this->request->post['code']) > 10)) {
			$this->error['code'] = $this->language->get('error_code');
		}

		$voucher_info = $this->model_sale_voucher->getVoucherByCode($this->request->post['code']);

		if ($voucher_info) {
			if (!isset($this->request->get['voucher_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			} elseif ($voucher_info['voucher_id'] != $this->request->get['voucher_id'])  {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}

		if ((utf8_strlen($this->request->post['to_name']) < 1) || (utf8_strlen($this->request->post['to_name']) > 64)) {
			$this->error['to_name'] = $this->language->get('error_to_name');
		}

		if ((utf8_strlen($this->request->post['to_email']) > 96) || !filter_var($this->request->post['to_email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['to_email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['from_name']) < 1) || (utf8_strlen($this->request->post['from_name']) > 64)) {
			$this->error['from_name'] = $this->language->get('error_from_name');
		}

		if ((utf8_strlen($this->request->post['from_email']) > 96) || !filter_var($this->request->post['from_email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['from_email'] = $this->language->get('error_email');
		}

		if ($this->request->post['amount'] < 1) {
			$this->error['amount'] = $this->language->get('error_amount');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/voucher')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('sale/order');

		foreach ($this->request->post['selected'] as $voucher_id) {
			$order_voucher_info = $this->model_sale_order->getOrderVoucherByVoucherId($voucher_id);

			if ($order_voucher_info) {
				$this->error['warning'] = sprintf($this->language->get('error_order'), $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $order_voucher_info['order_id'], true));

				break;
			}
		}

		return !$this->error;
	}

	public function history() {
		$this->load->language('sale/voucher');

		$this->load->model('sale/voucher');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_amount'] = $this->language->get('column_amount');
		$data['column_date_added'] = $this->language->get('column_date_added');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['histories'] = array();

		$results = $this->model_sale_voucher->getVoucherHistories($this->request->get['voucher_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['histories'][] = array(
				'order_id'   => $result['order_id'],
				'customer'   => $result['customer'],
				'amount'     => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$history_total = $this->model_sale_voucher->getTotalVoucherHistories($this->request->get['voucher_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('sale/voucher/history', 'token=' . $this->session->data['token'] . '&voucher_id=' . $this->request->get['voucher_id'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));

		$this->response->setOutput($this->load->view('sale/voucher_history', $data));
	}

	public function send() {
		$this->load->language('sale/voucher');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/voucher')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('sale/voucher');

			$vouchers = array();

			if (isset($this->request->post['selected'])) {
				$vouchers = $this->request->post['selected'];
			} elseif (isset($this->request->post['voucher_id'])) {
				$vouchers[] = $this->request->post['voucher_id'];
			}

			if ($vouchers) {
				foreach ($vouchers as $voucher_id) {
					$this->model_sale_voucher->sendVoucher($voucher_id);
				}

				$json['success'] = $this->language->get('text_sent');
			} else {
				$json['error'] = $this->language->get('error_selection');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
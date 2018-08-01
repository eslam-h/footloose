<?php

function error_handler_for_export_import($errno, $errstr, $errfile, $errline) {
    global $registry;

    switch ($errno) {
        case E_NOTICE:
        case E_USER_NOTICE:
            $errors = "Notice";
            break;
        case E_WARNING:
        case E_USER_WARNING:
            $errors = "Warning";
            break;
        case E_ERROR:
        case E_USER_ERROR:
            $errors = "Fatal Error";
            break;
        default:
            $errors = "Unknown";
            break;
    }

    $config = $registry->get('config');
    $url = $registry->get('url');
    $request = $registry->get('request');
    $session = $registry->get('session');
    $log = $registry->get('log');

    if ($config->get('config_error_log')) {
        $log->write('PHP ' . $errors . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
    }

    if (($errors=='Warning') || ($errors=='Unknown')) {
        return true;
    }

    if (($errors != "Fatal Error") && isset($request->get['route']) && ($request->get['route']!='tool/export_import/download'))  {
        if ($config->get('config_error_display')) {
            echo '<b>' . $errors . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
        }
    } else {
        $session->data['export_import_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
        $token = $request->get['token'];
        $link = $url->link( 'tool/export_import', 'token='.$token, 'SSL' );
        header('Status: ' . 302);
        header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $link));
        exit();
    }

    return true;
}


class ModelSaleVoucher extends Model {
	public function addVoucher($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "voucher SET code = '" . $this->db->escape($data['code']) . "', from_name = '" . $this->db->escape($data['from_name']) . "', from_email = '" . $this->db->escape($data['from_email']) . "', to_name = '" . $this->db->escape($data['to_name']) . "', to_email = '" . $this->db->escape($data['to_email']) . "', voucher_theme_id = '" . (int)$data['voucher_theme_id'] . "', message = '" . $this->db->escape($data['message']) . "', amount = '" . (float)$data['amount'] . "', status = '" . (int)$data['status'] . "', date_added = NOW(), date_end = '" . $this->db->escape($data['date_end']) . "'");
	
		return $this->db->getLastId();
	}

	public function editVoucher($voucher_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "voucher SET code = '" . $this->db->escape($data['code']) . "', from_name = '" . $this->db->escape($data['from_name']) . "', from_email = '" . $this->db->escape($data['from_email']) . "', to_name = '" . $this->db->escape($data['to_name']) . "', to_email = '" . $this->db->escape($data['to_email']) . "', voucher_theme_id = '" . (int)$data['voucher_theme_id'] . "', message = '" . $this->db->escape($data['message']) . "', amount = '" . (float)$data['amount'] . "', status = '" . (int)$data['status'] . "', date_end = '" . $this->db->escape($data['date_end']) . "' WHERE voucher_id = '" . (int)$voucher_id . "'");
	}

	public function deleteVoucher($voucher_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "voucher WHERE voucher_id = '" . (int)$voucher_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "voucher_history WHERE voucher_id = '" . (int)$voucher_id . "'");
	}

	public function getVoucher($voucher_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "voucher WHERE voucher_id = '" . (int)$voucher_id . "'");

		return $query->row;
	}

	public function getVoucherByCode($code) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "voucher WHERE code = '" . $this->db->escape($code) . "'");

		return $query->row;
	}

	public function getVouchers($data = array()) {
		$sql = "SELECT v.voucher_id, v.order_id, v.code, v.from_name, v.from_email, v.to_name, v.to_email, (SELECT vtd.name FROM " . DB_PREFIX . "voucher_theme_description vtd WHERE vtd.voucher_theme_id = v.voucher_theme_id AND vtd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS theme, v.amount, v.status, v.date_added, v.date_end FROM " . DB_PREFIX . "voucher v";

		$sort_data = array(
			'v.code',
			'v.from_name',
			'v.from_email',
			'v.to_name',
			'v.to_email',
			'v.theme',
			'v.amount',
			'v.status',
            'v.date_added',
            'v.date_end'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY v.date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function sendVoucher($voucher_id) {
		$voucher_info = $this->getVoucher($voucher_id);

		if ($voucher_info) {
			if ($voucher_info['order_id']) {
				$order_id = $voucher_info['order_id'];
			} else {
				$order_id = 0;
			}

			$this->load->model('sale/order');

			$order_info = $this->model_sale_order->getOrder($order_id);

			// If voucher belongs to an order
			if ($order_info) {
				$this->load->model('localisation/language');

				$language = new Language($order_info['language_code']);
				$language->load($order_info['language_code']);
				$language->load('mail/voucher');

				// HTML Mail
				$data = array();

				$data['title'] = sprintf($language->get('text_subject'), $voucher_info['from_name']);

				$data['text_greeting'] = sprintf($language->get('text_greeting'), $this->currency->format($voucher_info['amount'], $order_info['currency_code'], $order_info['currency_value']));

                $data['text_expire'] = sprintf($language->get('text_expire'), $voucher_info['date_end']);

				$data['text_from'] = sprintf($language->get('text_from'), $voucher_info['from_name']);
				$data['text_message'] = $language->get('text_message');
				$data['text_redeem'] = sprintf($language->get('text_redeem'), $voucher_info['code']);
				$data['text_footer'] = $language->get('text_footer');

				$this->load->model('sale/voucher_theme');

				$voucher_theme_info = $this->model_sale_voucher_theme->getVoucherTheme($voucher_info['voucher_theme_id']);

				if ($voucher_theme_info && is_file(DIR_IMAGE . $voucher_theme_info['image'])) {
					$data['image'] = HTTP_CATALOG . 'image/' . $voucher_theme_info['image'];
				} else {
					$data['image'] = '';
				}

				$data['store_name'] = $order_info['store_name'];
				$data['store_url'] = $order_info['store_url'];
				$data['message'] = nl2br($voucher_info['message']);

				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($voucher_info['to_email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(sprintf($language->get('text_subject'), html_entity_decode($voucher_info['from_name'], ENT_QUOTES, 'UTF-8')));
				$mail->setHtml($this->load->view('mail/voucher', $data));
				$mail->send();

			// If voucher does not belong to an order
			}  else {
				$this->load->language('mail/voucher');

				$data = array();

				$data['title'] = sprintf($this->language->get('text_subject'), $voucher_info['from_name']);

				$data['text_greeting'] = sprintf($this->language->get('text_greeting'), $this->currency->format($voucher_info['amount'], 'Pou', $order_info['currency_value']));

                $data['text_expire'] = sprintf($this->language->get('text_expire'), $voucher_info['date_end']);

                $data['text_from'] = sprintf($this->language->get('text_from'), $voucher_info['from_name']);
				$data['text_message'] = $this->language->get('text_message');
				$data['text_redeem'] = sprintf($this->language->get('text_redeem'), $voucher_info['code']);
				$data['text_footer'] = $this->language->get('text_footer');

				$this->load->model('sale/voucher_theme');

				$voucher_theme_info = $this->model_sale_voucher_theme->getVoucherTheme($voucher_info['voucher_theme_id']);

				if ($voucher_theme_info && is_file(DIR_IMAGE . $voucher_theme_info['image'])) {
					$data['image'] = HTTP_CATALOG . 'image/' . $voucher_theme_info['image'];
				} else {
					$data['image'] = '';
				}

				$data['store_name'] = $this->config->get('config_name');
				$data['store_url'] = HTTP_CATALOG;
				$data['message'] = nl2br($voucher_info['message']);

				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($voucher_info['to_email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode(sprintf($this->language->get('text_subject'), $voucher_info['from_name']), ENT_QUOTES, 'UTF-8'));
				$mail->setHtml($this->load->view('mail/voucher', $data));
				$mail->send();
			}
		}
	}

	public function getTotalVouchers() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "voucher");

		return $query->row['total'];
	}

	public function getTotalVouchersByVoucherThemeId($voucher_theme_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "voucher WHERE voucher_theme_id = '" . (int)$voucher_theme_id . "'");

		return $query->row['total'];
	}

	public function getVoucherHistories($voucher_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT vh.order_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, vh.amount, vh.date_added FROM " . DB_PREFIX . "voucher_history vh LEFT JOIN `" . DB_PREFIX . "order` o ON (vh.order_id = o.order_id) WHERE vh.voucher_id = '" . (int)$voucher_id . "' ORDER BY vh.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalVoucherHistories($voucher_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "voucher_history WHERE voucher_id = '" . (int)$voucher_id . "'");

		return $query->row['total'];
	}

    public function getVouchersCodes() {
        $sql = "SELECT v.code FROM " . DB_PREFIX . "voucher v";

        $query = $this->db->query($sql);

        $codes = [];

        foreach ($query->rows as $row) {
            $codes[] = $row['code'];
        }

        return $codes;
    }

//  ///////////////////////////////////////////////////////////////////////////////////////////////////

    public function upload($filename)
    {

        // we use our own error handler
        global $registry;
        $registry = $this->registry;
        set_error_handler('error_handler_for_export_import', E_ALL);
        register_shutdown_function('fatal_error_shutdown_handler_for_export_import');

        try {
            $this->session->data['export_import_nochange'] = 1;
            // we use the PHPExcel package from http://phpexcel.codeplex.com/
            $cwd = getcwd();
            chdir(DIR_SYSTEM.'PHPExcel');
            require_once('Classes/PHPExcel.php');
            chdir($cwd);

            // Memory Optimization
            if ($this->config->get('export_import_settings_use_import_cache')) {
                $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
                $cacheSettings = array( ' memoryCacheSize '  => '16MB'  );
                PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
            }

            // parse uploaded spreadsheet file.
            $inputFileType = PHPExcel_IOFactory::identify($filename);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $reader = $objReader->load($filename);
            $objReader->setReadDataOnly(true);


            if (!$this->validateUpload($reader)) {
                return false;
            }

            $this->uploadVouchers( $reader );

            $this->clearCache();
            $this->session->data['export_import_nochange'] = 0;

            return true;
        } catch (Exception $e) {
            $errstr = $e->getMessage();
            $errline = $e->getLine();
            $errfile = $e->getFile();
            $errno = $e->getCode();
            $this->session->data['export_import_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
            if ($this->config->get('config_error_log')) {
                $this->log->write('PHP ' . get_class($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
            }
            return false;
        }
    }

    protected function uploadVouchers( &$reader ) {
        // get worksheet, if not there return immediately
        $data = $reader->getSheetByName( 'Vouchers' );
        if ($data==null) {
            return;
        }

        $k = $data->getHighestRow();
        for ($i=0; $i<$k; $i+=1) {
            $j = 1;
            if ($i==0) {
                continue;
            }
            $code = trim($this->getCell($data,$i,$j++));
            if ($code=="") {
                continue;
            }
            $from_name = $this->getCell($data,$i,$j++,'store');
            $from_email = $this->getCell($data,$i,$j++,'a@b.com');
            $to_name = $this->getCell($data,$i,$j++,'client');
            $to_email = $this->getCell($data,$i,$j++,'a@b.com');
            $voucher_theme_id = $this->getCell($data,$i,$j++,'7');
            $message = $this->getCell($data,$i,$j++,'Congratiolations');
            $amount = $this->getCell($data,$i,$j++,'0');
            $date_end = $this->getCell($data,$i,$j++,'0000-00-0');

            $voucher = array();
            $voucher['code'] = $code;
            $voucher['from_name'] = $from_name;
            $voucher['from_email'] = $from_email;
            $voucher['to_name'] = $to_name;
            $voucher['to_email'] = $to_email;
            $voucher['voucher_theme_id'] = $voucher_theme_id;
            $voucher['message'] = $message;
            $voucher['amount'] = $amount;
            $voucher['date_end'] = $date_end;

            $this->storeVoucherIntoDatabase( $voucher );
        }
    }

    protected function storeVoucherIntoDatabase( &$voucher ) {
        $sql  = "INSERT INTO " . DB_PREFIX . "voucher SET code = '" . $this->db->escape($voucher['code']) . "', from_name = '" . $this->db->escape($voucher['from_name']) . "', from_email = '" . $this->db->escape($voucher['from_email']) . "', to_name = '" . $this->db->escape($voucher['to_name']) . "', to_email = '" . $this->db->escape($voucher['to_email']) . "', voucher_theme_id = '" . (int)$voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($voucher['message']) . "', amount = '" . (float)$voucher['amount'] . "', status = '1', date_added = NOW(), date_end = '" . $this->db->escape($voucher['date_end']) . "'";

        $this->db->query($sql);
    }

    protected function validateUpload( &$reader )
    {
        $ok = true;

        // worksheets must have correct heading rows
        if (!$this->validateVouchers( $reader )) {
            $this->log->write( 'Headers or the sheet name are not true' );
            $ok = false;
        }

        if (!$ok) {
            return false;
        }

        if (!$this->validateVoucherCodeColumns( $reader )) {
            $ok = false;
        }

        return $ok;
    }

    protected function validateVoucherCodeColumns( &$reader ) {
        $data = $reader->getSheetByName( 'Vouchers' );

        if ($data==null) {
            return false;
        }

        $ok = true;

        $previous_product_id = 0;
        $has_missing_codes = false;
        $codes = $this->getVouchersCodes();
        $k = $data->getHighestRow();
        for ($i=1; $i<$k; $i+=1) {
            $code = $this->getCell($data,$i,1);
            if ($code=="") {
                if (!$has_missing_codes) {
                    $this->log->write( 'there\'s missing codes' );
                    $has_missing_codes = true;
                }
                $ok = false;
                continue;
            }
            if (in_array( $code, $codes )) {
                $this->log->write( 'there\'s duplicates in the codes' );
                $ok = false;
            }
            $codes[] = $code;
        }

        return $ok;
    }

    protected function validateVouchers( &$reader ) {
        $data = $reader->getSheetByName( 'Vouchers' );
        if ($data==null) {
            return false;
        }
        $expected_heading = array( "code", "from_name", "from_email", "to_name", "to_email", "voucher_theme_id", "message", "amount", "date_end" );
        $expected_multilingual = array();
        return $this->validateHeading( $data, $expected_heading, $expected_multilingual );
    }

    protected function validateHeading( &$data, &$expected, &$multilingual ) {
        $default_language_code = $this->config->get('config_language');
        $heading = array();
        $k = PHPExcel_Cell::columnIndexFromString( $data->getHighestColumn() );
        $i = 0;
        for ($j=1; $j <= $k; $j+=1) {
            $entry = $this->getCell($data,$i,$j);
            $bracket_start = strripos( $entry, '(', 0 );
            if ($bracket_start === false) {
                if (in_array( $entry, $multilingual )) {
                    return false;
                }
                $heading[] = strtolower($entry);
            } else {
                $name = strtolower(substr( $entry, 0, $bracket_start ));
                if (!in_array( $name, $multilingual )) {
                    return false;
                }
                $bracket_end = strripos( $entry, ')', $bracket_start );
                if ($bracket_end <= $bracket_start) {
                    return false;
                }
                if ($bracket_end+1 != strlen($entry)) {
                    return false;
                }
                $language_code = strtolower(substr( $entry, $bracket_start+1, $bracket_end-$bracket_start-1 ));
                if (count($heading) <= 0) {
                    return false;
                }
                if ($heading[count($heading)-1] != $name) {
                    $heading[] = $name;
                }
            }
        }
        for ($i=0; $i < count($expected); $i+=1) {
            if (!isset($heading[$i])) {
                return false;
            }
            if ($heading[$i] != $expected[$i]) {
                return false;
            }
        }
        return true;
    }

    protected function clearCache() {
        $this->cache->delete('*');
    }

    protected function getCell(&$worksheet,$row,$col,$default_val='') {
        $col -= 1; // we use 1-based, PHPExcel uses 0-based column index
        $row += 1; // we use 0-based, PHPExcel uses 1-based row index

        if(($worksheet->cellExistsByColumnAndRow($col,$row))) {
            $val = $worksheet->getCellByColumnAndRow($col,$row)->getValue();
            if(PHPExcel_Shared_Date::isDateTime($worksheet->getCellByColumnAndRow($col,$row))) {
                $val = date('y-m-d', PHPExcel_Shared_Date::ExcelToPHP($val));
            }


        } else {
            $val = $default_val;
        }

        if ($val===null) {
            $val = $default_val;
        }
        return $val;
    }
}
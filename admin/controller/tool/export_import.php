<?php
require 'export_import_legacy.php';


class ControllerToolExportImport extends ControllerToolExportImportLegacy {
	public function download() {
		$this->load->language( 'tool/export_import' );
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model( 'tool/export_import' );
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateDownloadForm()) {
			$this->model_tool_export_import->download();
			$this->response->redirect( $this->url->link( 'tool/export_import', 'token='.$this->request->get['token'], $this->ssl) );
		}

		$this->getForm();
	}
}
?>

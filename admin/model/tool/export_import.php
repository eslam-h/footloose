<?php
require 'export_import_legacy.php';
error_reporting(0);
// A gateway used for imports and exports that allows us to adapt excel sheet data to the format accepted by the import/export extension.
class ModelToolExportImport extends ModelToolExportImportLegacy
{
  private $category_sheets = ['Categories', 'CategoryFilters'];
  private $option_sheets = ['Options', 'OptionValues'];
  private $product_sheets = ['Products', 'AdditionalImages', 'Specials', 'Discounts', 'Rewards',
                            'ProductOptions', 'ProductOptionValues', 'ProductAttributes',
                            'ProductFilters', 'ProductSkus'];
  // TODO: get this from the views and the controllers.
  private $download_chunk = 100;

  public function upload($filename, $incremental=false)
  {
      // -----------------------------------------
      // ini_set('memory_limit', '-1');
      // ini_set('max_execution_time', 60);
      // -----------------------------------------

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
        $readers = $this->adapt_reader($reader);
        $objReader->setReadDataOnly(true);

        // read the various worksheets and load them to the database
        if (!$this->validateIncrementalOnly($reader, $incremental)) {
            return false;
        }
          if (!$this->validateUpload($reader)) {
              return false;
          }
        $this->clearCache();
        $this->session->data['export_import_nochange'] = 0;
        $available_product_ids = array();
        $available_category_ids = array();
        $available_customer_ids = array();

        // --------------------------------------------------------------------------------------------------
        // // download the excel sheet.
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename=temo_name.xlsx');
        // header('Cache-Control: max-age=0');
        // $objWriter = PHPExcel_IOFactory::createWriter($readers[1], 'Excel2007');
        // $objWriter->setPreCalculateFormulas(false);
        // $objWriter->save('php://output');
        //
        // // Clear the spreadsheet caches
        // $this->clearSpreadsheetCache();
        // exit;
        // --------------------------------------------------------------------------------------------------
          
        // Categories
        $dropBackupQuery = "DROP TABLE IF EXISTS ".DB_PREFIX."category_description_backup;";
        $createBackupTableAndQuery = "CREATE TABLE IF NOT EXISTS ".DB_PREFIX."category_description_backup AS( 
        SELECT u.keyword, cd.* FROM ".DB_PREFIX."category_description cd
        LEFT JOIN ".DB_PREFIX."url_alias u ON u.query like Concat('category_id=', cd.category_id));";
       
        $this->db->query($dropBackupQuery);
        $this->db->query($createBackupTableAndQuery);
        
        // Products
          
        $dropBackupQuery = "DROP TABLE IF EXISTS ".DB_PREFIX."product_description_backup;";
        $createBackupTableAndQuery = "CREATE TABLE IF NOT EXISTS ".DB_PREFIX."product_description_backup AS( 
        SELECT p.sku, pd.* FROM ".DB_PREFIX."product_description pd
        LEFT JOIN ".DB_PREFIX."product p ON p.product_id = pd.product_id);";
       
        $this->db->query($dropBackupQuery);
        $this->db->query($createBackupTableAndQuery);
          
        foreach ($readers as $reader) {
            $this->uploadCategories($reader, $incremental, $available_category_ids);
            $this->uploadCategoryFilters($reader, $incremental, $available_category_ids);
            $this->uploadOptions($reader, $incremental);
            $this->uploadOptionValues($reader, $incremental);
            $this->uploadProducts($reader, $incremental, $available_product_ids);
            $this->uploadAdditionalImages($reader, $incremental, $available_product_ids);
            $this->uploadSpecials($reader, $incremental, $available_product_ids);
            $this->uploadDiscounts($reader, $incremental, $available_product_ids);
            $this->uploadRewards($reader, $incremental, $available_product_ids);
            $this->uploadProductOptions($reader, $incremental, $available_product_ids);
            $this->uploadProductOptionValues($reader, $incremental, $available_product_ids);
            $this->uploadProductAttributes($reader, $incremental, $available_product_ids);
            $this->uploadProductFilters($reader, $incremental, $available_product_ids);
            $this->uploadAttributeGroups($reader, $incremental);
            $this->uploadAttributes($reader, $incremental);
            $this->uploadFilterGroups($reader, $incremental);
            $this->uploadFilters($reader, $incremental);
            $this->uploadCustomers($reader, $incremental, $available_customer_ids);
            $this->uploadAddresses($reader, $incremental, $available_customer_ids);
        }
          // Abdo Code to import SKUs
          /// TODO: Revise
//          $reader->setActiveSheetIndex(9);
//          print_r($reader->getSheetNames());
//

//          ChromePhp::log($reader->getSheetNames());
          $read_sheett = $reader->getSheetByName('ProductSkus');
//          $read_sheett = $reader->getSheetByName();
          $sizes_counter = array();
          $product_id = "";
		  for($i=1;$i<$read_sheett->getHighestRow();$i++){

		      $idInSheet = $this->getCell($read_sheett,$i,1);

              if ($i == 1)
                  $product_id = $idInSheet;
              else if ($idInSheet != $product_id)
              {
//                  $this->log->write("id in sheet = ".$idInSheet . ", id in code = " . $product_id.
//                      ", sizes: " .json_encode($sizes_counter));
                  $sizes_counter = array();
                  $product_id = $idInSheet;
              }

		      $color = $this->getCell($read_sheett, $i, 3);
              $options = $this->getOptionNameById($idInSheet, $color);
//              $this->log->write($idInSheet ." ".$color." ".json_encode($options));
              if (!count($options))
                  continue;

              $color = $options[0]['product_option_value_id'];

              $size = $this->getCell($read_sheett, $i, 4);
		      $options = $this->getOptionNameById($idInSheet, $size);

              if (array_key_exists($size, $sizes_counter))
              {
                  $sizes_counter[$size]++;
              }
              else
              {
                  $sizes_counter[$size] = 0;
              }
              $size = $options[$sizes_counter[$size]]['product_option_value_id'];


		//	echo $product_id . "  --  " . $color . "  --  ". $size;
              $SKU = $this->getCell($read_sheett, $i, 2);
              $this->storeProductSKU($SKU, $idInSheet, $color, $size);
              $this->storeOptionParent($i, $idInSheet, $color , $size );
          }
          
          $hideNoImageProducts = "update ".DB_PREFIX."product set status = 0 where image = '';";
          $this->db->query( $hideNoImageProducts );
          
          // Categories
          $restorMetaData = "UPDATE ".DB_PREFIX."category_description cd 
          LEFT JOIN ".DB_PREFIX."url_alias u ON u.query like Concat('category_id=', cd.category_id)
          , ".DB_PREFIX."category_description_backup cdb
          SET cd.meta_description = cdb.meta_description,
          cd.meta_keyword = cdb.meta_keyword
          WHERE cdb.language_id = cd.language_id
          AND u.keyword = cdb.keyword;";
          $this->db->query($restorMetaData);
          
          // Products
          $restorMetaData = "UPDATE ".DB_PREFIX."product_description pd
          LEFT JOIN ".DB_PREFIX."product p ON pd.product_id = p.product_id
          , ".DB_PREFIX."product_description_backup pdb
          SET pd.description = pdb.description,
          pd.meta_title = pdb.meta_title,
          pd.meta_description = pdb.meta_description,
          pd.meta_keyword = pdb.meta_keyword
          WHERE pdb.language_id = pd.language_id
          AND pdb.sku = p.sku;";
          $this->db->query($restorMetaData);
          
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

	public function download( $export_type='*', $offset=null, $rows=null, $min_id=null, $max_id=null) {
    // we use our own error handler
		global $registry;

    $registry = $this->registry;
		set_error_handler('error_handler_for_export_import',E_ALL);
		register_shutdown_function('fatal_error_shutdown_handler_for_export_import');

		// Use the PHPExcel package from http://phpexcel.codeplex.com/
		$cwd = getcwd();
		chdir( DIR_SYSTEM.'PHPExcel' );
		require_once( 'Classes/PHPExcel.php' );
		PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_ExportImportValueBinder() );
		chdir( $cwd );

		// find out whether all data is to be downloaded
		$all = !isset($offset) && !isset($rows) && !isset($min_id) && !isset($max_id);

		// Memory Optimization
		if ($this->config->get( 'export_import_settings_use_export_cache' )) {
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
			$cacheSettings = array( 'memoryCacheSize'  => '16MB' );
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		}

		try {
			// set appropriate timeout limit
			set_time_limit( 1800 );

			$languages = $this->getLanguages();
			$default_language_id = $this->getDefaultLanguageId();

      $min_product_id = $this->get_min_product_id();
      $max_product_id = $this->get_max_product_id();
      $min_id = $min_product_id;
      $max_id = $min_product_id + $this->download_chunk;

      // create a new workbook
			$workbook = new PHPExcel();

			// set some default styles
			$workbook->getDefaultStyle()->getFont()->setName('Arial');
			$workbook->getDefaultStyle()->getFont()->setSize(10);
			//$workbook->getDefaultStyle()->getAlignment()->setIndent(0.5);
			$workbook->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$workbook->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$workbook->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_GENERAL);

			// pre-define some commonly used styles
			$box_format = array(
				'fill' => array(
					'type'      => PHPExcel_Style_Fill::FILL_SOLID,
					'color'     => array( 'rgb' => 'F0F0F0')
				),
				/*
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'       => false,
					'indent'     => 0
				)
				*/
			);
			$text_format = array(
				'numberformat' => array(
					'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
				),
				/*
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'       => false,
					'indent'     => 0
				)
				*/
			);
			$price_format = array(
				'numberformat' => array(
					'code' => '######0.00'
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					/*
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'       => false,
					'indent'     => 0
					*/
				)
			);
			$weight_format = array(
				'numberformat' => array(
					'code' => '##0.00'
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					/*
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'       => false,
					'indent'     => 0
					*/
				)
			);
      $file_paths = array();
      $file_names = array();

			// create the worksheets
			$worksheet_index = 0;
			switch ($export_type) {
				case 'c':
					// creating the Categories worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'Categories' );
					$this->populateCategoriesWorksheet( $worksheet, $languages, $box_format, $text_format, $offset, $rows, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the CategoryFilters worksheet
					if ($this->existFilter()) {
						$workbook->createSheet();
						$workbook->setActiveSheetIndex($worksheet_index++);
						$worksheet = $workbook->getActiveSheet();
						$worksheet->setTitle( 'CategoryFilters' );
						$this->populateCategoryFiltersWorksheet( $worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id );
						$worksheet->freezePaneByColumnAndRow( 1, 2 );
					}
					break;

				case 'p':
					// creating the Products worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'Products' );
					$this->populateProductsWorksheet( $worksheet, $languages, $default_language_id, $price_format, $box_format, $weight_format, $text_format, $offset, $rows, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the AdditionalImages worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'AdditionalImages' );
					$this->populateAdditionalImagesWorksheet( $worksheet, $box_format, $text_format, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the Specials worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'Specials' );
					$this->populateSpecialsWorksheet( $worksheet, $default_language_id, $price_format, $box_format, $text_format, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the Discounts worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'Discounts' );
					$this->populateDiscountsWorksheet( $worksheet, $default_language_id, $price_format, $box_format, $text_format, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the Rewards worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'Rewards' );
					$this->populateRewardsWorksheet( $worksheet, $default_language_id, $box_format, $text_format, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the ProductOptions worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'ProductOptions' );
					$this->populateProductOptionsWorksheet( $worksheet, $box_format, $text_format, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the ProductOptionValues worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'ProductOptionValues' );
					$this->populateProductOptionValuesWorksheet( $worksheet, $price_format, $box_format, $weight_format, $text_format, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the ProductAttributes worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'ProductAttributes' );
					$this->populateProductAttributesWorksheet( $worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the ProductFilters worksheet
					if ($this->existFilter()) {
						$workbook->createSheet();
						$workbook->setActiveSheetIndex($worksheet_index++);
						$worksheet = $workbook->getActiveSheet();
						$worksheet->setTitle( 'ProductFilters' );
						$this->populateProductFiltersWorksheet( $worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id );
						$worksheet->freezePaneByColumnAndRow( 1, 2 );
					}
					break;

				case 'o':
					// creating the Options worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'Options' );
					$this->populateOptionsWorksheet( $worksheet, $languages, $box_format, $text_format );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the OptionValues worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'OptionValues' );
					$this->populateOptionValuesWorksheet( $worksheet, $languages, $box_format, $text_format );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );
					break;

				case 'a':
					// creating the AttributeGroups worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'AttributeGroups' );
					$this->populateAttributeGroupsWorksheet( $worksheet, $languages, $box_format, $text_format );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the Attributes worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'Attributes' );
					$this->populateAttributesWorksheet( $worksheet, $languages, $box_format, $text_format );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );
					break;

				case 'f':
					if (!$this->existFilter()) {
						throw new Exception( $this->language->get( 'error_filter_not_supported' ) );
						break;
					}

					// creating the FilterGroups worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'FilterGroups' );
					$this->populateFilterGroupsWorksheet( $worksheet, $languages, $box_format, $text_format );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the Filters worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'Filters' );
					$this->populateFiltersWorksheet( $worksheet, $languages, $box_format, $text_format );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );
					break;

				case 'u':
					// creating the Customers worksheet
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'Customers' );
					$this->populateCustomersWorksheet( $worksheet, $box_format, $text_format, $offset, $rows, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );

					// creating the Addresses worksheet
					$workbook->createSheet();
					$workbook->setActiveSheetIndex($worksheet_index++);
					$worksheet = $workbook->getActiveSheet();
					$worksheet->setTitle( 'Addresses' );
					$this->populateAddressesWorksheet( $worksheet, $box_format, $text_format, $min_id, $max_id );
					$worksheet->freezePaneByColumnAndRow( 1, 2 );
					break;

        case '*':
          // $offset, $rows, $min_id, $max_id
          // creating the Categories worksheet
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'Categories' );
          $this->populateCategoriesWorksheet( $worksheet, $languages, $box_format, $text_format);
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the CategoryFilters worksheet
          if ($this->existFilter()) {
            $workbook->createSheet();
            $workbook->setActiveSheetIndex($worksheet_index++);
            $worksheet = $workbook->getActiveSheet();
            $worksheet->setTitle( 'CategoryFilters' );
            $this->populateCategoryFiltersWorksheet( $worksheet, $languages, $default_language_id, $box_format, $text_format);
            $worksheet->freezePaneByColumnAndRow( 1, 2 );
            }

          // creating the Products worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'Products' );
          $this->populateProductsWorksheet( $worksheet, $languages, $default_language_id, $price_format, $box_format, $weight_format, $text_format, $offset, $rows, $min_id, $max_id);
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the AdditionalImages worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'AdditionalImages' );
          $this->populateAdditionalImagesWorksheet( $worksheet, $box_format, $text_format, $offset, $rows, $min_id, $max_id);
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the Specials worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'Specials' );
          $this->populateSpecialsWorksheet( $worksheet, $default_language_id, $price_format, $box_format, $text_format, $min_id, $max_id);
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the Discounts worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'Discounts' );
          $this->populateDiscountsWorksheet( $worksheet, $default_language_id, $price_format, $box_format, $text_format, $min_id, $max_id);
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the Rewards worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'Rewards' );
          $this->populateRewardsWorksheet( $worksheet, $default_language_id, $box_format, $text_format, $min_id, $max_id);
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the ProductOptions worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'ProductOptions' );
          $this->populateProductOptionsWorksheet( $worksheet, $box_format, $text_format, $min_id, $max_id);
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the ProductOptionValues worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'ProductOptionValues' );
          $this->populateProductOptionValuesWorksheet( $worksheet, $price_format, $box_format, $weight_format, $text_format, $min_id, $max_id);
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the ProductAttributes worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'ProductAttributes' );
          $this->populateProductAttributesWorksheet( $worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id);
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the ProductFilters worksheet
          if ($this->existFilter()) {
            $workbook->createSheet();
            $workbook->setActiveSheetIndex($worksheet_index++);
            $worksheet = $workbook->getActiveSheet();
            $worksheet->setTitle( 'ProductFilters' );
            $this->populateProductFiltersWorksheet( $worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id);
            $worksheet->freezePaneByColumnAndRow( 1, 2 );
          }

          // creating the Options worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'Options' );
          $this->populateOptionsWorksheet( $worksheet, $languages, $box_format, $text_format );
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the OptionValues worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'OptionValues' );
          $this->populateOptionValuesWorksheet( $worksheet, $languages, $box_format, $text_format );
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the AttributeGroups worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'AttributeGroups' );
          $this->populateAttributeGroupsWorksheet( $worksheet, $languages, $box_format, $text_format );
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the Attributes worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'Attributes' );
          $this->populateAttributesWorksheet( $worksheet, $languages, $box_format, $text_format );
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          if (!$this->existFilter()) {
            throw new Exception( $this->language->get( 'error_filter_not_supported' ) );
            break;
          }

          // creating the FilterGroups worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'FilterGroups' );
          $this->populateFilterGroupsWorksheet( $worksheet, $languages, $box_format, $text_format );
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the Filters worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'Filters' );
          $this->populateFiltersWorksheet( $worksheet, $languages, $box_format, $text_format );
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the Customers worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'Customers' );
          $this->populateCustomersWorksheet( $worksheet, $box_format, $text_format);
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          // creating the Addresses worksheet
          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle( 'Addresses' );
          $this->populateAddressesWorksheet( $worksheet, $box_format, $text_format);
          $worksheet->freezePaneByColumnAndRow( 1, 2 );

          $workbook->createSheet();
          $workbook->setActiveSheetIndex($worksheet_index++);
          $worksheet = $workbook->getActiveSheet();
          $worksheet->setTitle('ProductSkus');
          $this->populateProductSkusWorksheet($worksheet, $box_format, $text_format, $min_id, $max_id);
          break;

				default:
					break;
			}

			$workbook->setActiveSheetIndex(0);

			// redirect output to client browser
			$datetime = date('Y-m-d');
			switch ($export_type) {
				case 'c':
					$filename = 'categories-'.$datetime;
					if (!$all) {
						if (isset($offset)) {
							$filename .= "-offset-$offset";
						} else if (isset($min_id)) {
							$filename .= "-start-$min_id";
						}
						if (isset($rows)) {
							$filename .= "-rows-$rows";
						} else if (isset($max_id)) {
							$filename .= "-end-$max_id";
						}
					}
					$filename .= '.xlsx';
					break;
				case 'p':
					$filename = 'products-'.$datetime;
					if (!$all) {
						if (isset($offset)) {
							$filename .= "-offset-$offset";
						} else if (isset($min_id)) {
							$filename .= "-start-$min_id";
						}
						if (isset($rows)) {
							$filename .= "-rows-$rows";
						} else if (isset($max_id)) {
							$filename .= "-end-$max_id";
						}
					}
					$filename .= '.xlsx';
					break;
				case 'o':
					$filename = 'options-'.$datetime.'.xlsx';
					break;
				case 'a':
					$filename = 'attributes-'.$datetime.'.xlsx';
					break;
				case 'f':
					if (!$this->existFilter()) {
						throw new Exception( $this->language->get( 'error_filter_not_supported' ) );
						break;
					}
					$filename = 'filters-'.$datetime.'.xlsx';
					break;
				case 'u':
					$filename = 'customers-'.$datetime;
					if (!$all) {
						if (isset($offset)) {
							$filename .= "-offset-$offset";
						} else if (isset($min_id)) {
							$filename .= "-start-$min_id";
						}
						if (isset($rows)) {
							$filename .= "-rows-$rows";
						} else if (isset($max_id)) {
							$filename .= "-end-$max_id";
						}
					}
					$filename .= '.xlsx';
					break;
        case '*':
          $filename = 'master-'.$datetime.'.xlsx';
          break;

				default:
					$filename = $datetime.'.xlsx';
					break;
			}
			$objWriter = PHPExcel_IOFactory::createWriter($workbook, 'Excel2007');
			$objWriter->setPreCalculateFormulas(false);
      $file_path = DIR_CACHE.$filename;
			$objWriter->save($file_path);
      array_push($file_paths, $file_path);
      array_push($file_names, $filename);
      $workbook->disconnectWorksheets();
      unset($objWriter, $workbook);

			// Clear the spreadsheet caches
			// $this->clearSpreadsheetCache();

      for($i = $max_id + 1; $i <= $max_product_id; $i += $this->download_chunk){
        $min_id = $i;
        $max_id = $i + $this->download_chunk;

        // create a new workbook
        $workbook = new PHPExcel();

        // set some default styles
        $workbook->getDefaultStyle()->getFont()->setName('Arial');
        $workbook->getDefaultStyle()->getFont()->setSize(10);
        //$workbook->getDefaultStyle()->getAlignment()->setIndent(0.5);
        $workbook->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $workbook->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $workbook->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_GENERAL);

        // create the worksheets
        $worksheet_index = 0;
        switch ($export_type) {
          case '*':
            // creating the Products worksheet
            $workbook->setActiveSheetIndex($worksheet_index++);
            $worksheet = $workbook->getActiveSheet();
            $worksheet->setTitle( 'Products' );
            $this->populateProductsWorksheet( $worksheet, $languages, $default_language_id, $price_format, $box_format, $weight_format, $text_format, $offset, $rows, $min_id, $max_id);
            $worksheet->freezePaneByColumnAndRow( 1, 2 );

            // creating the AdditionalImages worksheet
            $workbook->createSheet();
            $workbook->setActiveSheetIndex($worksheet_index++);
            $worksheet = $workbook->getActiveSheet();
            $worksheet->setTitle( 'AdditionalImages' );
            $this->populateAdditionalImagesWorksheet( $worksheet, $box_format, $text_format, $offset, $rows, $min_id, $max_id);
            $worksheet->freezePaneByColumnAndRow( 1, 2 );

            // creating the Specials worksheet
            $workbook->createSheet();
            $workbook->setActiveSheetIndex($worksheet_index++);
            $worksheet = $workbook->getActiveSheet();
            $worksheet->setTitle( 'Specials' );
            $this->populateSpecialsWorksheet( $worksheet, $default_language_id, $price_format, $box_format, $text_format, $min_id, $max_id);
            $worksheet->freezePaneByColumnAndRow( 1, 2 );

            // creating the Discounts worksheet
            $workbook->createSheet();
            $workbook->setActiveSheetIndex($worksheet_index++);
            $worksheet = $workbook->getActiveSheet();
            $worksheet->setTitle( 'Discounts' );
            $this->populateDiscountsWorksheet( $worksheet, $default_language_id, $price_format, $box_format, $text_format, $min_id, $max_id);
            $worksheet->freezePaneByColumnAndRow( 1, 2 );

            // creating the Rewards worksheet
            $workbook->createSheet();
            $workbook->setActiveSheetIndex($worksheet_index++);
            $worksheet = $workbook->getActiveSheet();
            $worksheet->setTitle( 'Rewards' );
            $this->populateRewardsWorksheet( $worksheet, $default_language_id, $box_format, $text_format, $min_id, $max_id);
            $worksheet->freezePaneByColumnAndRow( 1, 2 );

            // creating the ProductOptions worksheet
            $workbook->createSheet();
            $workbook->setActiveSheetIndex($worksheet_index++);
            $worksheet = $workbook->getActiveSheet();
            $worksheet->setTitle( 'ProductOptions' );
            $this->populateProductOptionsWorksheet( $worksheet, $box_format, $text_format, $min_id, $max_id);
            $worksheet->freezePaneByColumnAndRow( 1, 2 );

            // creating the ProductOptionValues worksheet
            $workbook->createSheet();
            $workbook->setActiveSheetIndex($worksheet_index++);
            $worksheet = $workbook->getActiveSheet();
            $worksheet->setTitle( 'ProductOptionValues' );
            $this->populateProductOptionValuesWorksheet( $worksheet, $price_format, $box_format, $weight_format, $text_format, $min_id, $max_id);
            $worksheet->freezePaneByColumnAndRow( 1, 2 );

            // creating the ProductAttributes worksheet
            $workbook->createSheet();
            $workbook->setActiveSheetIndex($worksheet_index++);
            $worksheet = $workbook->getActiveSheet();
            $worksheet->setTitle( 'ProductAttributes' );
            $this->populateProductAttributesWorksheet( $worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id);
            $worksheet->freezePaneByColumnAndRow( 1, 2 );

            // creating the ProductFilters worksheet
            if ($this->existFilter()) {
              $workbook->createSheet();
              $workbook->setActiveSheetIndex($worksheet_index++);
              $worksheet = $workbook->getActiveSheet();
              $worksheet->setTitle( 'ProductFilters' );
              $this->populateProductFiltersWorksheet( $worksheet, $languages, $default_language_id, $box_format, $text_format, $min_id, $max_id);
              $worksheet->freezePaneByColumnAndRow( 1, 2 );
            }

            $workbook->createSheet();
            $workbook->setActiveSheetIndex($worksheet_index++);
            $worksheet = $workbook->getActiveSheet();
            $worksheet->setTitle('ProductSkus');
            $this->populateProductSkusWorksheet($worksheet, $box_format, $text_format, $min_id, $max_id);

            break;

          default:
            break;
        }

        $workbook->setActiveSheetIndex(0);

        // redirect output to client browser
        $datetime = date('Y-m-d');
        $filename = 'products #'.floor($i / $this->download_chunk).' - '.$datetime.'.xlsx';

        $objWriter = PHPExcel_IOFactory::createWriter($workbook, 'Excel2007');
        $objWriter->setPreCalculateFormulas(false);
        $file_path = DIR_CACHE.$filename;
  			$objWriter->save($file_path);
        array_push($file_paths, $file_path);
        array_push($file_names, $filename);

        $workbook->disconnectWorksheets();
        unset($objWriter, $workbook);
      }
      $zip = new ZipArchive;
      $zip_name = 'export - '.$datetime.'.zip';
      $zip_dir = DIR_CACHE.$zip_name;
      $zip->open($zip_dir, ZipArchive::CREATE);
      foreach ($file_paths as $index => $excel_file_path) {
        $zip->addFile($excel_file_path, $file_names[$index]);
      }
      $zip->close();

      // Clear the spreadsheet caches

      header('Content-Type: application/zip');
      header('Content-disposition: attachment; filename='.$zip_name);
      header('Content-Length: ' . filesize($zip_dir));
      readfile($zip_dir);
      $this->clearSpreadsheetCache();
			exit;

		} catch (Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();
			$this->session->data['export_import_error'] = array( 'errstr'=>$errstr, 'errno'=>$errno, 'errfile'=>$errfile, 'errline'=>$errline );
			if ($this->config->get('config_error_log')) {
				$this->log->write('PHP ' . get_class($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			}
      $this->clearSpreadsheetCache();
			return;
		}
	}

  private function adapt_reader(&$reader){
    $categories_writer = new PHPExcel();
    $options_writer = new PHPExcel();
    $products_writer = new PHPExcel();

    // TODO: process the sheet data in chunks.

    foreach ($this->category_sheets as $index => $category_sheet) {
      $read_sheet = $reader->getSheetByName($category_sheet);

      if ($read_sheet){
        $categories_writer->addExternalSheet($read_sheet);
        }
    }

    foreach ($this->option_sheets as $index => $option_sheet) {
      $read_sheet = $reader->getSheetByName($option_sheet);

      if ($read_sheet){
        $options_writer->addExternalSheet($read_sheet);
        }
    }

    foreach ($this->product_sheets as $index => $product_sheet) {
      $read_sheet = $reader->getSheetByName($product_sheet);

      if ($read_sheet){
        $products_writer->addExternalSheet($read_sheet);
        }
    }

    $reader->disconnectWorksheets();
    unset($reader);
    return [$categories_writer, $options_writer, $products_writer];
  }

  private function populateProductSkusWorksheet(&$worksheet, &$box_format, &$text_format, $min_id=null, $max_id=null){
    // Set the column widths
    // TODO: add a min-id and a max_id condition.
    $j = 0;
    $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('product_id')+1);
    $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('detailed_sku')+1);
    $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('color')+1);
    $worksheet->getColumnDimensionByColumn($j++)->setWidth(strlen('size')+1);

    // The heading row and column styles
    $styles = array();
    $data = array();
    $i = 1;
    $j = 0;
    $data[$j++] = 'product_id';
    $data[$j++] = 'detailed_sku';
    $data[$j++] = 'color';
    $data[$j++] = 'size';
    $worksheet->getRowDimension($i)->setRowHeight(30);
    $this->setCellRow( $worksheet, $i, $data, $box_format );

    // The actual category filters data
    $sql = 'SELECT
                sku.product_sku,
                sku.product_id,
                color_desc.name AS color,
                size_desc.name AS size
            FROM
                '.DB_PREFIX.'product_sku AS sku
                    INNER JOIN
                '.DB_PREFIX.'option_value_description AS color_desc ON color_id = color_desc.option_value_id AND color_desc.name != \'\'
                    INNER JOIN
                '.DB_PREFIX.'option_value_description AS size_desc ON size_id = size_desc.option_value_id AND size_desc.name != \'\'';
    if (isset($min_id) && isset($max_id)) {
      $sql .= "WHERE sku.product_id BETWEEN $min_id AND $max_id ";
    }

    $result = $this->db->query($sql);
    if ($result->rows) {
      $data = $result->rows;
      foreach ($result->rows as $index => $row) {
        $data = [$row['product_id'], $row['product_sku'], $row['color'], $row['size']];
        $this->setCellRow($worksheet, $index + 2, $data, $this->null_array, $styles );
      }
    }
  }

  protected function clearSpreadsheetCache() {
    parent::clearSpreadsheetCache();
    $files = array_merge(glob(DIR_CACHE.'master*.xlsx'), glob(DIR_CACHE.'products*.xlsx'), glob(DIR_CACHE.'export*.zip'));

		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					@unlink($file);
					clearstatcache();
				}
			}
		}
	}

  private function get_min_product_id(){
    $sql = "SELECT MIN(product_id) AS min_product_id FROM ".DB_PREFIX."product;";
    $result = $this->db->query($sql);
    return $result->row['min_product_id'];
  }

  private function get_max_product_id(){
    $sql = "SELECT MAX(product_id) AS max_product_id FROM ".DB_PREFIX."product;";
    $result = $this->db->query($sql);
    return $result->row['max_product_id'];
  }
    
    
    protected function getOptionNameById($id, $option) {
		$language_id = $this->getDefaultLanguageId();
		$sql  = "SELECT product_option_value_id FROM ".DB_PREFIX."product_option_value pov LEFT JOIN ".DB_PREFIX."option_value_description ovd ON pov.option_value_id = ovd.option_value_id WHERE pov.product_id = ".$id." AND ovd.name = '$option' AND ovd.language_id = $language_id";
        
		$query = $this->db->query( $sql );
		return $query->rows;
	}
    protected function storeProductSKU ($product_detailed_sku, $product_id, $color_id, $size_id)
    {
        $sql = "REPLACE INTO " .DB_PREFIX. "product_sku VALUES ('$product_detailed_sku', $product_id, $color_id, $size_id);";
        //echo $sql;
        $this->db->query($sql);
    }
    protected function storeOptionParent( $ky,$id, &$color,$size ) {

		$sql  = "REPLACE INTO `".DB_PREFIX."product_option_available_parent_value` (`Ke`,`product_Id`, `parent_product_option_value_id`,`child_product_option_value_id`) VALUES ";
		$sql .= "( $ky,$id,$color,$size );";
		$this->db->query( $sql );
	}
}

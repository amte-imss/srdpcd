<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Phpexcel_library {
	public function __construct() {
    	$this->CI =& get_instance();
    	$this->CI->config->load('email');
        include APPPATH.'third_party/phpexcel/Classes/PHPExcel.php';
    }

    /**
     * param
     *      title String - Título del documento, de la hoja
     *      columns <String> - Título de las columnas
     *      password String - Constraseña de la hoja y del documento
     */
    public function phpexcel_password($data, $params){
        //echo date('H:i:s') , " Create new PHPExcel object" , EOL;

        $objPHPExcel = new PHPExcel();
        //pr($params);
        // Set document properties
        //echo date('H:i:s') , " Set document properties" , EOL;
        $objPHPExcel->getProperties()->setCreator("Instituto Mexicano del Seguro Social")
                                    //->setLastModifiedBy("Maarten Balliauw")
                                    ->setTitle($params['title']);
                                    /*->setSubject("Office 2007 XLSX Test Document")
                                    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                    ->setKeywords("office 2007 openxml php")
                                    ->setCategory("Test result file");*/

        // Add some data
        //echo date('H:i:s') , " Add some data" , EOL;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $params['note']);
        $objPHPExcel->setActiveSheetIndex(0);
        $letterC='A';
        foreach ($params['columns'] as $key_c => $column) {
            $objPHPExcel->getActiveSheet()->setCellValue(($letterC++).'2', $column);
        }
        $row=3;
        foreach ($data as $key_d => $dato) {
            $letter='A';
            foreach ($dato as $key_e => $elemento) {
                if(in_array($key_e, array('imal_fecha_inicio_curso','imal_fecha_fin_curso'))){
                    $elemento = date_format(date_create($elemento), 'd-m-Y');
                }
                if($key_e == 'imal_folio_certificado'){
                    $elemento = ((is_null($elemento) or empty($elemento) or $elemento=="") ? ' ' : 'Aprobado');
                }
                $objPHPExcel->getActiveSheet()->setCellValue(($letter++).$row, $elemento);
            }
            $row++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$letterC.'2')->getFont()->setBold(true);
        
        /*$objPHPExcel->getActiveSheet()->setCellValue('B2', 'world!');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Hello');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'world!');*/

        // Rename worksheet
        //echo date('H:i:s') , " Rename worksheet" , EOL;
        $objPHPExcel->getActiveSheet()->setTitle($params['title']);

        // Set document security
        //echo date('H:i:s') , " Set document security" , EOL;
        $objPHPExcel->getSecurity()->setLockWindows(true);
        $objPHPExcel->getSecurity()->setLockStructure(true);
        $objPHPExcel->getSecurity()->setWorkbookPassword($params['password']);

        // Set sheet security
        //echo date('H:i:s') , " Set sheet security" , EOL;
        $objPHPExcel->getActiveSheet()->getProtection()->setPassword($params['password']);
        $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true); // This should be enabled in order to enable any of the following!
        $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
        $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
        $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Save Excel 2007 file
        //echo date('H:i:s') , " Write to Excel2007 format" , EOL;
        //$callStartTime = microtime(true);
        //exit();
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$params['title'].'_'.date('Ymd_his').'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 01 Ene 2000 06:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        /*$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( ' memoryCacheSize ' => '50MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);*/

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objReader->setReadDataOnly(true);
        $objWriter->save('php://output');
        //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        exit();
        //$callEndTime = microtime(true);
        //$callTime = $callEndTime - $callStartTime;

        /*echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
        echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
        // Echo memory usage
        echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


        // Echo memory peak usage
        echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

        // Echo done
        echo date('H:i:s') , " Done writing file" , EOL;
        echo 'File has been created in ' , getcwd() , EOL;*/
    }
}

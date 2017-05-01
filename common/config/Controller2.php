<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\config;

use yii\web\Controller;

class Controller2 extends Controller {

    public $mainMenu = '0';
    public $left_menu = '0';
    public $submenu = '0';

    const LOGIN = 10;
    const LOGOUT = 11;
    const CHANGE_PASS = 12;
    const USERS = 13;
    const LOG = 14;
    const ROLE = 15;
    const NOTIFICATION = 16;
    const PACKAGE = 17;
    const ATTACHMENTS = 18;
    //=======================================================
    const CATEGORY = 100;
    const SUBCATEGORY = 101;
    const COUNTRY = 102;
    const CITY = 103;
    const CURRENCY = 104;
    const BUSINESS = 105;
    const CATEGORY_REQUEST = 106;
    const FEEDBACK = 107;
    const REQUEST = 108;
    const ORDER = 109;
    const ANDRIOD = 'Andriod';
    const iOS = 'iOS';

    public function init() {
        parent::init();
        \Yii::$app->language = 'en';
    }

    public function sendAsXLS($filename, $data, $title = 'Sheet1', $header = false, $fields = false) {

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator()
                ->setLastModifiedBy()
                ->setTitle("Office 2007 XLSX Document")
                ->setSubject("Office 2007 XLSX Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Result file");


        $rowno = 1;
        $col = 0;
        if ($data) {

            if (!$fields)
                $fields = array_keys($data[0]->attributes);

            if ($header) {
                foreach ($fields as $field) {
                    if ($field == "index")
                        $str = "Sr.No.";
                    else
                        $str = $data[0]->getAttributeLabel($field);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $rowno, $str);
                    $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $rowno)->getFont()->setBold(true);

                    $colName = \PHPExcel_Cell::stringFromColumnIndex($col);
                    $objPHPExcel->getActiveSheet()->getStyle($colName . "1:" . $colName . (count($data) + 1))->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                    $col++;
                }
                $rowno++;
            }
            $val = "";
            $rowNo = 0;
            $srNo = 0;
            $mrow = 0;
            foreach ($data as $row) {
                $col = 0;
                $rowNo++;
                $srNo++;
                $mrow = $rowno;
                $isArray = false;
                foreach ($fields as $field) {
                    if ($field == "index")
                        $val = $rowNo;
                    else
                        $val = $row->$field;

                    if (is_numeric($val)) {
                        $val = $val . " ";
                    }

                    if (is_array($val)) {
                        if (count($val) > 0)
                            $isArray = true;
                        foreach ($val as $value) {
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $mrow, $value);
                            $mrow ++;
                        }
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowno, $val);
                    }
                    $col++;
                }
                if ($isArray == true)
                    $rowno = $mrow;
                else
                    $rowno++;
            }
        }

        $title = $title == '' ? 'Sheet1' : $title;
// Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle($title);


// Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}

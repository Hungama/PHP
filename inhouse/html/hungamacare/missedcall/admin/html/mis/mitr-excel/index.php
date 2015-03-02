<?php
require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);



$rowCount = 1;
/* while($row = mysql_fetch_array($result)){ */
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'a');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'b');
    //$rowCount++;
/* } */
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('some_excel_file.xlsx');

?>
<?php
require_once("db.php");
include ("func.php");
require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';
$objPHPExcel = new PHPExcel();
include('excel-header-downloadable.php');
$filedate=date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));


/****Put excel file start here****/
$sql_query=mysql_query("select sum(value) as value,type,circle from Hungama_Tatasky.tbl_dailymis_downloadable 
GROUP BY TYPE,circle",$con);
$counter = 2;
$counter1 = 2;
$counter2 = 2;
$counter3 = 2;
$counter4 = 2;
$counter5 = 2;
$counter6 = 2;
while($mydata=mysql_fetch_array($sql_query))
{
if($counter<'26')
{
$objPHPExcel->getActiveSheet()->SetCellValue('A'.$counter, $mydata['circle']);
}
//T_OBD_C
if($mydata['type']=='T_Q_S')
{
$odbc_query=mysql_query("select value,type,circle from Hungama_Tatasky.tbl_dailymis_downloadable  where type='T_OBD_C'
and circle='".$mydata['circle']."'",$con);
$odbcdata=mysql_fetch_array($odbc_query);
$resultmydata=$odbcdata['value'] + $mydata['value'];
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$counter1, $resultmydata);
$counter1++;
}
else if($mydata['type']=='T_M_C_B'){

$objPHPExcel->getActiveSheet()->SetCellValue('C'.$counter2, $mydata['value']);
$counter2++;
}
else if($mydata['type']=='T_M_C'){
$objPHPExcel->getActiveSheet()->SetCellValue('D'.$counter3, $mydata['value']);
$counter3++;
}
else if($mydata['type']=='T_N_D'){
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$counter4, $mydata['value']);
$counter4++;
}
else if($mydata['type']=='T_N_U'){
$objPHPExcel->getActiveSheet()->SetCellValue('F'.$counter5, $mydata['value']);
$counter5++;
}
else if($mydata['type']=='T_N_S'){
$objPHPExcel->getActiveSheet()->SetCellValue('G'.$counter6, $mydata['value']);
$counter6++;
}
$counter++;
} 
//total  sum value
/* $sql_total_query=mysql_query("select sum(value) as total,type from Hungama_Tatasky.tbl_dailymis_downloadable 
GROUP BY TYPE",$con);
$counter_total='26';
while($mytotaldata=mysql_fetch_array($sql_total_query))
{
if($counter_total=='26')
{
$objPHPExcel->getActiveSheet()->SetCellValue('A'.$counter_total,'Total');
$objPHPExcel->getActiveSheet() ->getStyle('A26')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);
}
if($mytotaldata['type']=='T_Q_S')
{
$odbc_query=mysql_query("select sum(value) as total from Hungama_Tatasky.tbl_dailymis_downloadable  where type='T_OBD_C'
",$con);
$odbcdata=mysql_fetch_array($odbc_query);
$resultmydata=$odbcdata['total'] + $mytotaldata['total'];
$objPHPExcel->getActiveSheet()->SetCellValue('B26', $resultmydata);
$objPHPExcel->getActiveSheet() ->getStyle('B26')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);
}
else if($mytotaldata['type']=='T_M_C_B'){

$objPHPExcel->getActiveSheet()->SetCellValue('C26', $mytotaldata['total']);
$objPHPExcel->getActiveSheet() ->getStyle('C26')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);
}
else if($mytotaldata['type']=='T_M_C'){
$objPHPExcel->getActiveSheet()->SetCellValue('D26', $mytotaldata['total']);
$objPHPExcel->getActiveSheet() ->getStyle('D26')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);
}
else if($mytotaldata['type']=='T_N_D'){
$objPHPExcel->getActiveSheet()->SetCellValue('E26', $mytotaldata['total']);
$objPHPExcel->getActiveSheet() ->getStyle('E26')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);
}
else if($mytotaldata['type']=='T_N_U'){
$objPHPExcel->getActiveSheet()->SetCellValue('F26', $mytotaldata['total']);
$objPHPExcel->getActiveSheet() ->getStyle('F26')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);

}
else if($mytotaldata['type']=='T_N_S'){
$objPHPExcel->getActiveSheet()->SetCellValue('G26', $mytotaldata['total']);
$objPHPExcel->getActiveSheet() ->getStyle('G26')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);
}  
}*/

if (function_exists('date_default_timezone_set')) {
			date_default_timezone_set('UTC');
	} else {
			putenv("TZ=UTC");
	}
$exportTime = date("Y-m-d_His", time()); 
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 

$filepath = 'MCDdownloadablereport_' . $filedate . '.xlsx'; 
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filepath.'');
header('Cache-Control: max-age=0'); 
$objWriter->save('php://output'); 


mysql_close($con);
?>
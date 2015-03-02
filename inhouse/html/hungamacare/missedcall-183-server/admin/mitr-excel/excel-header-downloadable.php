<?PHP
$Colors_Date_BG='';	
if(!$Colors_Date_BG) {
$Colors_Date_BG = 'ccc';
$Colors_Date_FG = 'ccc';
$Colors_Even_Outline = '999999';
$Colors_Even_BG = 'FFFF99';
$Colors_Odd_Outline = '999999';
$Colors_Odd_BG = 'FFCC66';
$Colors_Formula_Outline = '666666';
$Colors_Formula_BG = '66CC66';
$Colors_Merge_Outline = '990000';
$Colors_Merge_BG = 'CC6600';		
}

$objPHPExcel->getActiveSheet()->freezePane('A1');
//START A BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Circles')	;
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
$objPHPExcel->getActiveSheet() ->getStyle('A1')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);

//START B BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Total unique subscribers since beginning (Missed Call + OBD)')	;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$objPHPExcel->getActiveSheet() ->getStyle('B1')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);
//START B BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Total missed calls')	;
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet() ->getStyle('C1')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);

//END B BLOCK
//START C BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('D1', ' Total missed calls received post yaaricharge')	;
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet() ->getStyle('D1')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);


//D BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Total No of Dedications (A+B)')	;
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet() ->getStyle('E1')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);


///MERGE ALL COLUMN START//
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Total No of Unique Dedications (A+B)')	;
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
$objPHPExcel->getActiveSheet() ->getStyle('F1')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);
///MERGE ALL COLUMN START//
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Number of Successful recharge pushed')	;
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet() ->getStyle('G1')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);

?>
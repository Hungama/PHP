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

$objPHPExcel->getActiveSheet()->freezePane('D1');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Date')	;
$objPHPExcel -> getActiveSheet() -> mergeCells('B1:B3');	
$objPHPExcel->getActiveSheet() ->getStyle('B1:B3')->applyFromArray( array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('B1:B3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('B1:B3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B1:B3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);

//START C BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'GEOGRAPHIC DISPERSION')	;
$objPHPExcel -> getActiveSheet() -> mergeCells('C1:C3');	
$objPHPExcel->getActiveSheet() ->getStyle('C1:C3')->applyFromArray( array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('C1:C3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('C1:C3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C1:C3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
//END C BLOCK
//START D BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Capsule Name')	;
$objPHPExcel -> getActiveSheet() -> mergeCells('D1:D3');	
$objPHPExcel->getActiveSheet() ->getStyle('D1:D3')->applyFromArray( array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('D1:D3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('D1:D3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('D1:D3')->getAlignment()->setWrapText(true);
//END D BLOCK

//E BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Total Missed Calls Received')	;
$objPHPExcel -> getActiveSheet() -> mergeCells('E1:E3');
$objPHPExcel->getActiveSheet() ->getStyle('E1:E3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('E1:E3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('E1:E3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('E1:E3')->getAlignment()->setWrapText(true);
//END E BLOCK

///MERGE ALL COLUMN START//
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'All User')	;
$objPHPExcel->getActiveSheet() ->getStyle('F1')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '8BDEF2')))
);
$objPHPExcel->getActiveSheet() ->getStyle('F1:N1')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('F1') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('F1:N1');
$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'REGISTERED MITR MEMBERS')	; 
$objPHPExcel->getActiveSheet() ->getStyle('O1')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F3FF04')))
);
$objPHPExcel->getActiveSheet() ->getStyle('O1:W1')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('O1:W1') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('O1:W1');
//END THE MERGE COLUMN

//F BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Total OBDs Made')	; 
$objPHPExcel->getActiveSheet() ->getStyle('F2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '91C4D3')))
);
$objPHPExcel->getActiveSheet() ->getStyle('F2:F3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('F2:F3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('F2:F3');
$objPHPExcel -> getActiveSheet() -> getStyle('F1:F3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('F1:F3')->getAlignment()->setWrapText(true);
//END F BLOCK
//G BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('G2', 'Total OBDs Successful')	; 
$objPHPExcel->getActiveSheet() ->getStyle('G2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '91C4D3')))
);
$objPHPExcel->getActiveSheet() ->getStyle('G2:G3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('G2:G3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('G2:G3');
$objPHPExcel -> getActiveSheet() -> getStyle('G1:G3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('G1:G3')->getAlignment()->setWrapText(true);
//END G BLOCK
//H BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('H2', 'Total Unique OBDs')	; 
$objPHPExcel->getActiveSheet() ->getStyle('H2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '91C4D3')))
);
$objPHPExcel->getActiveSheet() ->getStyle('H2:H3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('H2:H3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('H2:H3');
$objPHPExcel -> getActiveSheet() -> getStyle('H1:H3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('H1:H3')->getAlignment()->setWrapText(true);
//END H
//START I
$objPHPExcel->getActiveSheet()->SetCellValue('I2', 'Total Minutes Consumed')	; 
$objPHPExcel->getActiveSheet() ->getStyle('I2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '91C4D3')))
);
$objPHPExcel->getActiveSheet() ->getStyle('I2:I3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('I2:I3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('I2:I3');
$objPHPExcel -> getActiveSheet() -> getStyle('I1:I3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('I1:I3')->getAlignment()->setWrapText(true);
//END I1
//START J
$objPHPExcel->getActiveSheet()->SetCellValue('J2', 'Average Duration/OBD')	; 
$objPHPExcel->getActiveSheet() ->getStyle('J2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '91C4D3')))
);
$objPHPExcel->getActiveSheet() ->getStyle('J2:J3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('J2:J3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('J2:J3');
$objPHPExcel -> getActiveSheet() -> getStyle('J1:J3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('J1:J3')->getAlignment()->setWrapText(true);
//END J

//START K
$objPHPExcel->getActiveSheet()->SetCellValue('K2', 'Peak Calling Hour')	; 
$objPHPExcel->getActiveSheet() ->getStyle('K2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '91C4D3')))
);
$objPHPExcel->getActiveSheet() ->getStyle('K2:K3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('K2:K3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('K2:K3');
$objPHPExcel -> getActiveSheet() -> getStyle('K1:K3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('K1:K3')->getAlignment()->setWrapText(true);
//END K

//merge cell start L TO N
$objPHPExcel->getActiveSheet()->SetCellValue('L2', 'MOST PREFERED LANGUAGE (%age)')	;
$objPHPExcel->getActiveSheet() ->getStyle('L2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '8BDEF2')))
);
$objPHPExcel->getActiveSheet() ->getStyle('L2:N2')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('L2') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('L2:N2');
$objPHPExcel->getActiveSheet()->getStyle('L2:N2')->getAlignment()->setWrapText(true);

// START L

$objPHPExcel->getActiveSheet()->SetCellValue('L3', 'Hindi')	;	
$objPHPExcel->getActiveSheet() ->getStyle('L3')->applyFromArray( array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('L3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('L3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// END L
//START M
$objPHPExcel->getActiveSheet()->SetCellValue('M3', 'Bengali')	;	
$objPHPExcel->getActiveSheet() ->getStyle('M3')->applyFromArray( array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('M3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('M3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//END MEMBERS
//START N
$objPHPExcel->getActiveSheet()->SetCellValue('N3', 'Tamil')	;	
$objPHPExcel->getActiveSheet() ->getStyle('N3')->applyFromArray( array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'FF000000') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('N3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('N3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//END MITR 
//START NON MITR
//O BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('O2', 'Total OBDs Made')	; 
$objPHPExcel->getActiveSheet() ->getStyle('O2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '91C4D3')))
);
$objPHPExcel->getActiveSheet() ->getStyle('O2:O3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN,  'color' => array('rgb' => 'F3FF04') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('O2:O3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('O2:O3');
$objPHPExcel -> getActiveSheet() -> getStyle('O1:O3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('O1:O3')->getAlignment()->setWrapText(true);
//END O BLOCK
//P BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('P2', 'Total OBDs Successful')	; 
$objPHPExcel->getActiveSheet() ->getStyle('P2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '91C4D3')))
);
$objPHPExcel->getActiveSheet() ->getStyle('P2:P3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'F3FF04') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('P2:P3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('P2:P3');
$objPHPExcel -> getActiveSheet() -> getStyle('P1:P3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('P1:P3')->getAlignment()->setWrapText(true);
//END P BLOCK
//Q BLOCK
$objPHPExcel->getActiveSheet()->SetCellValue('Q2', 'Total Unique OBDs')	; 
$objPHPExcel->getActiveSheet() ->getStyle('Q2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '91C4D3')))
);
$objPHPExcel->getActiveSheet() ->getStyle('Q2:Q3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'F3FF04') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('Q2:Q3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('Q2:Q3');
$objPHPExcel -> getActiveSheet() -> getStyle('Q1:Q3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('Q1:Q3')->getAlignment()->setWrapText(true);
//END Q
//START R
$objPHPExcel->getActiveSheet()->SetCellValue('R2', 'Total Minutes Consumed')	; 
$objPHPExcel->getActiveSheet() ->getStyle('R2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '91C4D3')))
);
$objPHPExcel->getActiveSheet() ->getStyle('R2:R3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'F3FF04') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('R2:R3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('R2:R3');
$objPHPExcel -> getActiveSheet() -> getStyle('R1:R3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('R1:R3')->getAlignment()->setWrapText(true);
//END R
//START S
$objPHPExcel->getActiveSheet()->SetCellValue('S2', 'Average Duration/OBD')	; 
$objPHPExcel->getActiveSheet() ->getStyle('S2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '91C4D3')))
);
$objPHPExcel->getActiveSheet() ->getStyle('S2:S3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'F3FF04') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('S2:S3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('S2:S3');
$objPHPExcel -> getActiveSheet() -> getStyle('S1:S3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('S1:S3')->getAlignment()->setWrapText(true);
//END S

//START T
$objPHPExcel->getActiveSheet()->SetCellValue('T2', 'Peak Calling Hour')	; 
$objPHPExcel->getActiveSheet() ->getStyle('T2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '91C4D3')))
);
$objPHPExcel->getActiveSheet() ->getStyle('T2:T3')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'F3FF04') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('T2:T3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('T2:T3');
$objPHPExcel -> getActiveSheet() -> getStyle('T1:T3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('T1:T3')->getAlignment()->setWrapText(true);
//END T


//merge cell start U TO W
$objPHPExcel->getActiveSheet()->SetCellValue('U2', 'MOST PREFERED LANGUAGE (%age)')	;
$objPHPExcel->getActiveSheet() ->getStyle('U2')->applyFromArray( array ('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '8BDEF2')))
);
$objPHPExcel->getActiveSheet() ->getStyle('U2:W2')->applyFromArray(array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'F3FF04') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('W2') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> mergeCells('U2:W2');
//$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
$objPHPExcel->getActiveSheet()->getStyle('U2:W2')->getAlignment()->setWrapText(true);

// START U

$objPHPExcel->getActiveSheet()->SetCellValue('U3', 'Hindi')	;	
$objPHPExcel->getActiveSheet() ->getStyle('U3')->applyFromArray( array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'F3FF04') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('U3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('U3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// END U
//START V
$objPHPExcel->getActiveSheet()->SetCellValue('V3', 'Bengali')	;	
$objPHPExcel->getActiveSheet() ->getStyle('V3')->applyFromArray( array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'F3FF04') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('V3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('V3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//END MEMBERS
//START W
$objPHPExcel->getActiveSheet()->SetCellValue('W3', 'Tamil')	;	
$objPHPExcel->getActiveSheet() ->getStyle('W3')->applyFromArray( array('borders' => array('outline'   => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color'  => array('argb' => 'F3FF04') ))));
$objPHPExcel -> getActiveSheet() -> getStyle('W3') -> getAlignment() -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel -> getActiveSheet() -> getStyle('W3') -> getAlignment() -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

?>
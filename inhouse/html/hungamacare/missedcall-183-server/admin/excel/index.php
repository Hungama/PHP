<?php
error_reporting(0); 
require_once("db.php");
include_once("Spreadsheet/Excel/Writer.php");
$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('report.xls');
$format_bold =& $workbook->addFormat();
/* $workbook->setVersion(8); // excel 8
$worksheet->setInputEncoding('UTF-8'); */
$format_bold->setBold();
$format_title =& $workbook->addFormat();
$format_title1 =& $workbook->addFormat();
$format_title2 =& $workbook->addFormat();
$format_title2->setFgColor(10);
$format_title->setBold();
$format_title1->setBold();
$format_title1->setFgColor('yellow');
$format_title1->setAlign('merge');
$format_title->setColor('yellow');
$format_title->setPattern(1);
$format_title->setFgColor('blue');
$format_title->setAlign('merge');
$worksheet =& $workbook->addWorksheet();
/* $worksheet->freezePanes(array(0, 0));
$worksheet->freezePanes(array(0, 1)); */

//header formate in excel 
// Merge cells from row 0, col 0 to row 2, col 2
$worksheet->write(0, 0, 'DATE'); 
$worksheet->setMerge(0, 0, 2, 0);
$worksheet->write(0, 1, 'GEOGRAPHIC DISPERSION'); 
$worksheet->setMerge(0, 1, 2, 1);
$worksheet->write(0, 2, 'Capsule Name'); 
$worksheet->setMerge(0, 2, 2, 2);
$worksheet->write(0, 3, 'Total Missed Calls Received'); 
$worksheet->setMerge(0, 3, 2, 3);
//1st row
$worksheet->write(0, 4, "ALL USERS", $format_title);
$worksheet->write(0, 5, "", $format_title);
$worksheet->write(0, 6, "", $format_title);
$worksheet->write(0, 7, "", $format_title);
$worksheet->write(0, 8, "", $format_title);
$worksheet->write(0, 9, "", $format_title);
$worksheet->write(0, 10, "", $format_title);
$worksheet->write(0, 11, "", $format_title);
$worksheet->write(0, 12, "", $format_title);
$worksheet->write(1, 4, "Total OBDs Made", $format_title2);
$worksheet->write(1, 5, "Total OBDs Successful", $format_title2);
$worksheet->write(1, 6, "Total Unique OBDs", $format_title2);
$worksheet->write(1, 7, "Total Minutes Consumed", $format_title2);
$worksheet->write(1, 8, "Average Duration/OBD", $format_title2);
$worksheet->write(1, 9, "Peak Calling Hour", $format_title2);
$worksheet->write(1, 10, "MOST PREFERED LANGUAGE (%age)", $format_title2);
$worksheet->write(1, 11, "", $format_title2);
$worksheet->write(1, 12, "", $format_title2);
$worksheet->write(2, 4, "", $format_title2);
$worksheet->write(2, 5, "", $format_title2);
$worksheet->write(2, 6, "", $format_title2);
$worksheet->write(2, 7, "", $format_title2);
$worksheet->write(2, 8, "", $format_title2);
$worksheet->write(2, 9, "", $format_title2);
$worksheet->write(2, 10, "", $format_title2);
$worksheet->write(2, 11, "", $format_title2);
$worksheet->write(2, 12, "", $format_title2);
$worksheet->write(2, 10, "Hindi", $format_title2);
$worksheet->write(2, 11, "Bengali", $format_title2);
$worksheet->write(2, 12, "Tamil", $format_title2);
////changing work sheet 2 merge sheet start from 13 column//
$worksheet->write(0, 13, "REGISTERED MITR MEMBERS", $format_title1);
$worksheet->write(0, 14, "", $format_title1);
$worksheet->write(0, 15, "", $format_title1);
$worksheet->write(0, 16, "", $format_title1);
$worksheet->write(0, 17, "", $format_title1);
$worksheet->write(0, 18, "", $format_title1);
$worksheet->write(0, 19, "", $format_title1);
$worksheet->write(0, 20, "", $format_title1);
$worksheet->write(0, 21, "", $format_title1);


$worksheet->write(1, 13, "Total OBDs Made", $format_title2);
$worksheet->write(1, 14, "Total OBDs Successful", $format_title2);
$worksheet->write(1, 15, "Total Unique OBDs", $format_title2);
$worksheet->write(1, 16, "Total Minutes Consumed", $format_title2);
$worksheet->write(1, 17, "Average Duration/OBD", $format_title2);
$worksheet->write(1, 18, "Peak Calling Hour", $format_title2);
$worksheet->write(1, 19, "MOST PREFERED LANGUAGE (%age)", $format_title2);
$worksheet->write(1, 20, "", $format_title2);
$worksheet->write(1, 21, "", $format_title2);
$worksheet->write(2, 13, "", $format_title2);
$worksheet->write(2, 14, "", $format_title2);
$worksheet->write(2, 15, "", $format_title2);
$worksheet->write(2, 16, "", $format_title2);
$worksheet->write(2, 17, "", $format_title2);
$worksheet->write(2, 18, "", $format_title2);
$worksheet->write(2, 19, "", $format_title2);
$worksheet->write(2, 20, "", $format_title2);
$worksheet->write(2, 21, "", $format_title2);
$worksheet->write(2, 19, "Hindi", $format_title2);
$worksheet->write(2, 20, "Bengali", $format_title2);
$worksheet->write(2, 21, "Tamil", $format_title2);
//dynamic data insert  SQL QUERY:
//date='2014-11-25' and
$sql_query=mysql_query("select * from Hungama_Tatasky.tbl_dailymisMitrExcelReport  where  date='2014-11-25' and  IsmItr='0'",$con);
$counter = 4;
while($mydata=mysql_fetch_array($sql_query))
{
$worksheet->write($counter, 0, $mydata['Date']);
$worksheet->write($counter, 1, $mydata['Circle']);
$worksheet->write($counter, 2, $mydata['CapsuleName']);
$worksheet->write($counter, 3, $mydata['TotalMissedCallsReceived']);
$worksheet->write($counter, 4, $mydata['TotalOBDsMade']);
$worksheet->write($counter, 5, $mydata['TotalOBDsSuccessfull']);
$worksheet->write($counter, 6, $mydata['TotalUniqueOBDs']);
$worksheet->write($counter, 7, $mydata['TotalMinutesConsumed']);
$worksheet->write($counter, 8, $mydata['AverageDuration_OBD']);
$worksheet->write($counter, 9, $mydata['PeakCallingHour']);
$worksheet->write($counter, 10, $mydata['Hindi']);
$worksheet->write($counter, 11, $mydata['Bengali']);
$worksheet->write($counter, 12, $mydata['Tamil']);
$counter++;
}  

$workbook->close();
?>
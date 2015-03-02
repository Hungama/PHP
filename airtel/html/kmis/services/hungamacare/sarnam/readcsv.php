<?php
error_reporting(1);
set_time_limit(12000);
//include database connection file
$con = mysql_connect('10.2.73.160', 'team_user','Te@m_us@r987');
//$cvspath='Bhole_Shankar.csv';
//$cvspath='devi_maa.csv';
//$cvspath='MangalkarishriGanesh.csv';
//$cvspath='Ayyappa.csv';
//$cvspath='SalasarKeBalaji.csv';
//$cvspath='SankatmochanShriHanuman.csv';
//$cvspath='Swaminarayan.csv';
$cvspath='MaryadaPurshottamShriRam.csv';

$fGetContents = file_get_contents($cvspath);
    $e = explode("\n", $fGetContents);
   $totalcount=count($e);
 for ($i = 1; $i < $totalcount; $i++) {
$data = explode(",", $e[$i]);
if($totalcount!=$i+1)
{
$logData_csv='No#'.$data[0].'#Content Id#'.$data[1].'#Description#'.$data[2].'#Sub Category#'.$data[3].'#Category#'.$data[4].'#Vendor#'.$data[5].'#Category#'.$data[6]."#Circle#".$data[7]."\r\n";
//echo $logData_csv."<br></br><br></br>";
//For Airtel Devo
$sql_devo="INSERT INTO airtel_devo.tbl_devo_wapcontent (content_id, description, sub_category, category,vendor, content_type, circle, added_on,content_dumpfor) VALUES
('".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','DEL',now(),'Maryada Purshottam Shri Ram')";
//echo $sql_devo;
//echo "<br></br><br></br>";

mysql_query($sql_devo,$con);
}
}
//end of while
echo "File processed successfully.";
//close database connection
mysql_close($con);
exit;
?>
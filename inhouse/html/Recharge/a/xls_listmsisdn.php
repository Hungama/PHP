<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
$getmsisdns=$_REQUEST['getmsisdns'];
$date=$_REQUEST['sdate'];
if($date != '' and $getmsisdns != '')
{
$result= mysql_query("select msisdn,response,transactionId from master_db.tbl_recharged where date(request_time)='$date' and msisdn in($getmsisdns)");

$now_date = date('m-d-Y H:i:s');
//define title for .xls file: EDIT this if you want
$title = "rechargenumbers";
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
$fp = fopen('rechargenumbers.xls', "w");
$schema_insert = "";
$schema_insert_rows = "";
//start of printing column names as names of MySQL fields
$fieldname=array("HitURL");
for ($i = 0; $i < 1; $i++)
{
$schema_insert_rows.$fieldname[$i] . "\t";
}
$schema_insert_rows.="\n";
$schema_insert_rows;
fwrite($fp, $schema_insert_rows);
//end of printing column names

//start while loop to get data
while($row = mysql_fetch_array($result))
{
$pos = strrpos($row['response'],"Successful");

	if($pos)
		$status='Success';
	else
		$status='Failed';

	$decodeResponse=urldecode($response);
	$exploded=explode("|",$decodeResponse);
	
	$callBackUrl="http://192.168.100.218:81/MIS/SHVuZ2FtYSBhbmFseXRpa2VzIGRvbid0IGRhcmUgdG91Y2ggdGhpcyBmb2xkZXIgZWxzZSB5b3Ug/Recharge.Notification.php";
	$callBackUrl .="?status=".$status."&response=".$exploded[2]."&tid=".$row['transactionId']."&responseText=".$row['response'];

//set_time_limit(60); // HaRa

$schema_insert = "";
for($j=0; $j<1;$j++)
{
if(!isset($row['msisdn']))
$schema_insert .= "NULL".$sep;
elseif ($row['msisdn'] != "")
$schema_insert .= strip_tags($callBackUrl).$sep;
else
$schema_insert .= "".$sep;
}
$schema_insert = str_replace($sep."$", "", $schema_insert);
//following fix suggested by Josue (thanks, Josue!)
//this corrects output in excel when table fields contain \n or \r
//these two characters are now replaced with a space
$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
$schema_insert .= "\n";
//$schema_insert = (trim($schema_insert));
//print $schema_insert .= "\n";
//print "\n";

fwrite($fp, $schema_insert);
}
fclose($fp);

// your file to upload

$file = 'rechargenumbers.xls';
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: application/csv");
// tell file size
header('Content-length: '.filesize($file));
// set file name
header('Content-disposition: attachment; filename='.basename($file));
readfile($file);
// Exit script. So that no useless data is output-ed.
//close database connection
mysql_close($con);
exit;
}
?>
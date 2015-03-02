<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
$dtype=$_REQUEST['dtype'];
$today=date("Y-m-d");
if($dtype=='obd')
{
$sql_getmsisdnlist = mysql_query("select * from hul_hungama.tbl_hul_subdetails");
?>
 <?php
 $now_date = date('m-d-Y H:i:s');
//define title for .xls file: EDIT this if you want
$title = "ALL-ANI-ODB";
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
$fp = fopen('allaniobd.xls', "w");
$schema_insert = "";
//start while loop to get data
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
if(!empty($result_list['ANI']))
{

$getallobd=mysql_query("select ANI,Service,status,odb_name,error_code from hul_hungama.tbl_hulobd_success_fail_details where ANI='".$result_list['ANI']."' and service='HUL_PROMOTION' group by odb_name");

while($row = mysql_fetch_array($getallobd))
				{
	//set_time_limit(60); //
$schema_insert = "";
for($j=0; $j<mysql_num_fields($getallobd);$j++)
{
if(!isset($row[$j]))
$schema_insert .= "NULL".$sep;
elseif ($row[$j] != "")
$schema_insert .= strip_tags("$row[$j]").$sep;
else
$schema_insert .= "".$sep;
}
$schema_insert = str_replace($sep."$", "", $schema_insert);
$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
$schema_insert .= "\n";
fwrite($fp, $schema_insert);
   	 }

}
}
?>

				<?php


/*
while($row = mysql_fetch_row($result))
{
//set_time_limit(60); // HaRa
$schema_insert = "";
for($j=0; $j<mysql_num_fields($result);$j++)
{
if(!isset($row[$j]))
$schema_insert .= "NULL".$sep;
elseif ($row[$j] != "")
$schema_insert .= strip_tags("$row[$j]").$sep;
else
$schema_insert .= "".$sep;
}
$schema_insert = str_replace($sep."$", "", $schema_insert);
$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
$schema_insert .= "\n";
fwrite($fp, $schema_insert);
}
*/
fclose($fp);

// your file to upload
$file = 'allaniobd.xls';
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

exit;
}
else 
{
exit;
}
?>
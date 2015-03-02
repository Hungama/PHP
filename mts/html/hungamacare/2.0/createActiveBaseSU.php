<?php
error_reporting(0);
include("incs/db.php");
$date=date('Ymd');
$prevdate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));

$uploaddir = "/var/www/html/hungamacare/2.0/MTSCricketEvent/activeBase/MTSSU/";
//delete old file of last 2 days back-
$pathPreVdate = $uploaddir."activebase_".$prevdate.".txt";
if (file_exists($pathPreVdate)) 
{
unlink($pathPreVdate);
sleep(2);
}
$preDefineANI=array('7838551197','9873710296','8373917355');
$makFileName="activebase_".$date.".txt";
$path = $uploaddir.$makFileName;
$sql_query=mysql_query("select ani from MTS_cricket.tbl_cricket_subscription nolock where status=1");
$num=mysql_num_rows($sql_query);
if($num>=1)
{
unlink($path);
$filetowriteFp=fopen($path,'w+');
	while($row=mysql_fetch_array($sql_query))
	{
		fwrite($filetowriteFp,$row['ani']."\r\n");					
	}
	
	foreach($preDefineANI as $value)
	{
		fwrite($filetowriteFp,$value."\r\n");
	}

}
fclose($filetowriteFp);
mysql_close($dbConn);
echo "file write successfully";
?>
<?php
include ("config/dbConnect.php");

$dataQuery="select distinct msisdn,event_type,date(date_time),plan_id from master_db.tbl_billing_success";
$misData = mysql_query($dataQuery,$dbConn);
$filePath="/var/www/html/kmis/services/hungamacare/successlog.txt";
$fp=fopen($filePath,'a+');
chmod($filePath,0777);

while(list($msisdn,$eventType,$dateTime,$response)=mysql_fetch_row($misData))
{
	fwrite($fp,$msisdn.",".$eventType.",".$dateTime.",".$response."\r\n");
}
fclose($fp);

?>
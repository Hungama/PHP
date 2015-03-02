<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$get_query = "select batch_id,zone from master_db.bulk_message_history where service_id=2202 and date(schedule_date)=date(now()) and status!=0  order by batch_id";
$query = mysql_query($get_query, $dbConn);
$numofrows = mysql_num_rows($query);
if($numofrows>0)
{
while (list($batchId,$zone) = mysql_fetch_array($query)) {
//echo $batchId."#".$zone."<br>";
shell_exec("sh bsnl_smsSFcount.sh $batchId $zone");
sleep(2);
}
echo "Done";
}
else
{
echo "No records found";
}
mysql_close($dbConn);
mysql_close($LivdbConn);
?>
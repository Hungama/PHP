<?php
/////////////Dump for aircel Blacklist///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$FilePath = "AircelBlist_20141007.txt";
$insertDump = 'LOAD DATA LOCAL INFILE "' . $FilePath . '" INTO TABLE master_db.tbl_jbox_blacklistWapAircelMDN LINES TERMINATED BY "\n" 				(ani)';
    if(mysql_query($insertDump, $dbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}

echo $file_process_status."#"."done";
mysql_close($dbConn);
mysql_close($LivdbConn);
?>

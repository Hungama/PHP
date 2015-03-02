<?php
/////////////Dump for aircel Blacklist///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$FilePath = "vodaWapDownloadImg.txt";
$insertDump = 'LOAD DATA LOCAL INFILE "' . $FilePath . '" INTO TABLE Hungama_WAP_Logging.tbl_wapvoda_content FIELDS TERMINATED BY "#" LINES TERMINATED BY "\n" 				(album,songname,contentid)';
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
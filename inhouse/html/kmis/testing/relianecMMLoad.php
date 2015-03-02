<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
	$FilePath="/var/www/html/kmis/testing/Reliance_Base.txt";
	$insertDump= 'LOAD DATA LOCAL INFILE "'.$FilePath.'" INTO TABLE reliance_music_mania.tbl_MusicMania_subscription_TEST FIELDS TERMINATED BY "," LINES TERMINATED BY "\n" 				(ani,sub_date,renew_date,def_lang,status,mode_of_sub,dnis,user_bal,sub_type,plan_id,circle,chrg_amount,pre_post,trans_id)';
 if(mysql_query($insertDump, $dbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
echo $file_process_status ;
?>
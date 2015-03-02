<?php
error_reporting(0);
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$processlogPath="/var/www/html/hungamacare/all/temp/p4.txt";
$plog = "Process start at- " . date('Y-m-d H:i:s') . "\n";
error_log($plog, 3, $processlogPath);
        $file_to_read = "http://192.168.100.212/hungamacare/all/temp/MCWSongDedicate(Miss)16DecTo31Dec.txt";
        $file_data = file($file_to_read);
        $file_size = sizeof($file_data);
		  if ($file_size) {
           for ($i = 0; $i < $file_size; $i++) {
                $call = trim($file_data[$i]);
                //$sndMsgQuery = "CALL master_db.MCDOWELL_SENDMISSCALL('" . $number . "','" . $message . "',";
				if(mysql_query($call))
				$res="SUCCESS";
				else
				$res=mysql_error();
				
				if($res!="SUCCESS")
				{
				echo $res;
				$plogerror = $res."#".$call."#". date('Y-m-d H:i:s') . "\n";
				error_log($plogerror, 3, $processlogPath);
                }  
				}
             }
$plog = "Process end at- " . date('Y-m-d H:i:s') . "\n";
error_log($plog, 3, $processlogPath);
mysql_close($dbConn);
exit;
?>
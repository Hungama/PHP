<?php
error_reporting(0);
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$processlogPath="/var/www/html/hungamacare/all/temp/p.txt";
$plog = "Process start at- " . date('Y-m-d H:i:s') . "\n";
error_log($plog, 3, $processlogPath);
        $file_to_read = "http://192.168.100.212/hungamacare/all/temp/MCWSongdedicate29Dec.txt";
        $file_data = file($file_to_read);
        $file_size = sizeof($file_data);
		  if ($file_size) {
           for ($i = 0; $i < $file_size; $i++) {
                $call = trim($file_data[$i]);
                //echo $call."<br>";
				if(mysql_query($call))
				$res="SUCCESS";
				else
				$res=mysql_error();
				
				if($res!="SUCCESS")
				echo $res;
//                exit;
				}
             }
$plog = "Process end at- " . date('Y-m-d H:i:s') . "\n";
error_log($plog, 3, $processlogPath);
mysql_close($dbConn);
exit;
?>

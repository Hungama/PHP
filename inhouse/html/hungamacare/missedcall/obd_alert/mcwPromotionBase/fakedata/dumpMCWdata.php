<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$filePath='test.txt';

$insertDump = 'LOAD DATA LOCAL INFILE "' . $filePath . '" INTO TABLE Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_promotion_details FIELDS TERMINATED BY "#" LINES TERMINATED BY "\n" 				(ANI,service,status,duration,operator,circle,obd_name,start_time_obd,error_code,description,date_time,from_promotion,drop_point,pushobdid,lastupdatedate,sipheader,dial_did,actual_duration,isAgeVerify)';
    if (mysql_query($insertDump, $dbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
echo $file_process_status;
mysql_close($dbConn);
?>

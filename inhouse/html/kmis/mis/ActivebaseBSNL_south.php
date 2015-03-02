<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
include("/var/www/html/kmis/services/hungamacare/config/dbConnectBSNLAll.php");
$stype = $_REQUEST['stype'];
if ($stype == 'NH') {
    $dbConn_BSNL = $dbConn_BSNL_North;
} else if ($stype == 'SH') {
    $dbConn_BSNL = $dbConn_BSNL_South;
} else {
    $dbConn_BSNL = $dbConn_BSNL_North;
}
if (isset($_REQUEST['date'])) {
    $view_date1 = $_REQUEST['date'];
} else {
    $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
}
$fview_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

//$view_date1='2014-04-11';
//$fileDate='2014-04-11';

$activeDir = "/var/www/html/kmis/testing/activeBase/";
$processlog = "/var/www/html/kmis/testing/activeBase/logs/BSNL/processlog_active_" . date(Ymd) . ".txt";

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'UND' => 'Others', 'Others' => 'Others');


$languageData = array('01' => 'Hindi', '02' => 'English', '03' => 'Punjabi', '04' => 'Bhojpuri', '05' => 'Haryanavi', '06' => 'Bengali', '07' => 'Tamil', '08' => 'Telugu', '09' => 'Malayalam', '10' => 'Kannada', '11' => 'Marathi', '12' => 'Gujarati', '13' => 'Oriya', '14' => 'Kashmiri', '15' => 'Himachali', '16' => 'Chhattisgarhi', '17' => 'Assamese', '18' => 'Rajasthani', '19' => 'Nepali', '20' => 'Kumaoni', '21' => 'Maithali', '99' => 'Hindi');

//////////////////////////////////////////////////// Start BSNL54646//////////////////////////////////////////////////////////////////////////

$uni54646File = "2202/BSNL54646_" . $fileDate . ".txt";
$uni54646FilePath = $activeDir . $uni54646File;
$file_process_status = '***************Script start for BSNL54646******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
if (file_exists($uni54646FilePath)) {
    unlink($uni54646FilePath);
    $file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='BSNL54646' and status='Active'";
    //$delquery = mysql_query($del, $LivdbConn);
    $file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}

$getActiveBaseQ4 = "select 'BSNL54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from 
    BSNL_hungama.tbl_jbox_subscription nolock where status=1 and dnis not like '%P%' and date(sub_date)<='" . $view_date1 . "'";
$query4 = mysql_query($getActiveBaseQ4, $dbConn_BSNL);
$numRows1 = mysql_num_rows($query4);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($uni54646Actbase = mysql_fetch_array($query4)) {
        if ($circle_info[$uni54646Actbase[5]] == '')
            $uni54646Actbase[5] = 'Others';

        if ($languageData[trim($uni54646Actbase[8])] != '')
            $lang = $languageData[$uni54646Actbase[8]];
        else
            $lang = trim($uni54646Actbase[8]);

        $uni5464ActiveBasedata = $view_date1 . "|" . trim($uni54646Actbase[0]) . "|" . trim($uni54646Actbase[1]) . "|" . trim($uni54646Actbase[2]) . "|" . trim($uni54646Actbase[3]) . "|" . trim($uni54646Actbase[4]) . "|" . trim($circle_info[$uni54646Actbase[5]]) . "|" . trim($uni54646Actbase[6]) . "|" . trim($uni54646Actbase[7]) . "|" . trim($lang) . "\r\n";
        error_log($uni5464ActiveBasedata, 3, $uni54646FilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump3 = 'LOAD DATA LOCAL INFILE "' . $uni54646FilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump3, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for BSNL54646******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End BSNL54646 //////////////////////////////////////////////////////////////////////////

echo "done For South";
mysql_close($dbConn);
mysql_close($dbConn_BSNL);
mysql_close($LivdbConn);
?>

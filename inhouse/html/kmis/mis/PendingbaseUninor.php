<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$fview_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

$activeDir = "/var/www/html/kmis/testing/activeBase/";
$processlog = "/var/www/html/kmis/testing/activeBase/logs/uninor/processlog_pending_" . date(Ymd) . ".txt";

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'UND' => 'Others', 'Others' => 'Others');


$languageData = array('01' => 'Hindi', '02' => 'English', '03' => 'Punjabi', '04' => 'Bhojpuri', '05' => 'Haryanavi', '06' => 'Bengali', '07' => 'Tamil', '08' => 'Telugu', '09' => 'Malayalam', '10' => 'Kannada', '11' => 'Marathi', '12' => 'Gujarati', '13' => 'Oriya', '14' => 'Kashmiri', '15' => 'Himachali', '16' => 'Chhattisgarhi', '17' => 'Assamese', '18' => 'Rajasthani', '19' => 'Nepali', '20' => 'Kumaoni', '21' => 'Maithali', '99' => 'Hindi');

//////////////////////////////////////////////////////// code Start to dump Pending bbase for Uninor Operator///////////////////////////////////////////////////
////////////////////////////////////////////////////Start Uninor MTV//////////////////////////////////////////////////////////////////////////

$uninorMTVFile = "1403/PUninorMTV_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;
$file_process_status = '***************Script start for MTVUninor ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($uninorMTVFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='MTVUninor' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ = "select 'MTVUninor',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',replace(replace(def_lang,'01','HIN'),'99','HIN') from uninor_hungama.tbl_mtv_subscription nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query = mysql_query($getActiveBaseQ, $dbConn);
$numRows1 = mysql_num_rows($query);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($UniMtvActbase = mysql_fetch_array($query)) {
        if ($circle_info[trim($UniMtvActbase[5])] == '')
            $UniMtvActbase[5] = 'Others';

        if ($languageData[trim($UniMtvActbase[8])] != '')
            $lang = $languageData[$UniMtvActbase[8]];
        else
            $lang = trim($UniMtvActbase[8]);
        $uniMTVActiveBasedata = $view_date1 . "|" . trim($UniMtvActbase[0]) . "|" . trim($UniMtvActbase[1]) . "|" . trim($UniMtvActbase[2]) . "|" . trim($UniMtvActbase[3]) . "|" . trim($UniMtvActbase[4]) . "|" . trim($circle_info[$UniMtvActbase[5]]) . "|" . trim($UniMtvActbase[6]) . "|" . trim($UniMtvActbase[7]) . "|" . trim($lang) . "|" . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . "\r\n";
        error_log($uniMTVActiveBasedata, 3, $uninorMTVFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorMTVFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for MTVUninor******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End Uninor MTV//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////// Start Uninor Redfm//////////////////////////////////////////////////////////////////////////

$uniREDFMFile = "1410/PUninorREDFM_" . $fileDate . ".txt";
$uniREDFMFilePath = $activeDir . $uniREDFMFile;
$file_process_status = '***************Script start for RedFMUninor ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($uniREDFMFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='RedFMUninor' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ1 = "select 'RedFMUninor',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_redfm.tbl_jbox_subscription nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query1 = mysql_query($getActiveBaseQ1, $dbConn);
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($UniREDFMActbase = mysql_fetch_array($query1)) {
        if ($circle_info[$UniREDFMActbase[5]] == '')
            $UniREDFMActbase[5] = 'Others';

        if ($languageData[trim($UniREDFMActbase[8])] != '')
            $lang = $languageData[$UniREDFMActbase[8]];
        else
            $lang = trim($UniREDFMActbase[8]);
        $uniRedFmActiveBasedata = $view_date1 . "|" . trim($UniREDFMActbase[0]) . "|" . trim($UniREDFMActbase[1]) . "|" . trim($UniREDFMActbase[2]) . "|" . trim($UniREDFMActbase[3]) . "|" . trim($UniREDFMActbase[4]) . "|" . trim($circle_info[$UniREDFMActbase[5]]) . "|" . trim($UniREDFMActbase[6]) . "|" . trim($UniREDFMActbase[7]) . "|" . trim($lang) . "\r\n";
        error_log($uniRedFmActiveBasedata, 3, $uniREDFMFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump1 = 'LOAD DATA LOCAL INFILE "' . $uniREDFMFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }

    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump1, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for RedFMUninor******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End Uninor Redfm//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////// Start Uninor Ria//////////////////////////////////////////////////////////////////////////


$uniRIAFile = "1409/PUninorRia_" . $fileDate . ".txt";
$uniRIAFilePath = $activeDir . $uniRIAFile;

$file_process_status = '***************Script start for RIAUninor ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($uniRIAFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='RIAUninor' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

//uninor_manchala.tbl_riya_subscription
$getActiveBaseQ3 = "select 'RIAUninor',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_mnd.tbl_character_subscription1 nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query3 = mysql_query($getActiveBaseQ3, $dbConn);
$numRows1 = mysql_num_rows($query3);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    while ($uniRIAActbase = mysql_fetch_array($query3)) {

        if ($circle_info[$uniRIAActbase[5]] == '')
            $uniRIAActbase[5] = 'Others';


        if ($languageData[trim($uniRIAActbase[8])] != '')
            $lang = $languageData[$uniRIAActbase[8]];
        else
            $lang = trim($uniRIAActbase[8]);
        $uniRIAActiveBasedata = $view_date1 . "|" . trim($uniRIAActbase[0]) . "|" . trim($uniRIAActbase[1]) . "|" . trim($uniRIAActbase[2]) . "|" . trim($uniRIAActbase[3]) . "|" . trim($uniRIAActbase[4]) . "|" . trim($circle_info[$uniRIAActbase[5]]) . "|" . trim($uniRIAActbase[6]) . "|" . trim($uniRIAActbase[7]) . "|" . trim($lang) . "\r\n";
        error_log($uniRIAActiveBasedata, 3, $uniRIAFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    $insertDump2 = 'LOAD DATA LOCAL INFILE "' . $uniRIAFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump2, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for RIAUninor******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End Uninor Ria//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////// Start Uninor 54646//////////////////////////////////////////////////////////////////////////


$uni54646File = "1402/Puni54646_" . $fileDate . ".txt";
$uni54646FilePath = $activeDir . $uni54646File;
$file_process_status = '***************Script start for Uninor54646 ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($uni54646FilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='Uninor54646' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ4 = "select 'Uninor54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_hungama.tbl_jbox_subscription nolock where status=11 and dnis not like '%P%' and plan_id!=95 and date(sub_date)<='" . $view_date1 . "'";
$query4 = mysql_query($getActiveBaseQ4, $dbConn);
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
    $file_process_status = '***************Script end for Uninor54646******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End Uninor 54646//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////// Start Uninor Artist Aloud//////////////////////////////////////////////////////////////////////////

$uniAAFile = "1402/PAAUninor_" . $fileDate . ".txt";
$uniAAFilePath = $activeDir . $uniAAFile;

$file_process_status = '***************Script start for AAUninor ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($uniAAFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='AAUninor' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ5 = "select 'AAUninor',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_hungama.tbl_Artist_Aloud_subscription nolock where status=11 and plan_id=95 and date(sub_date)<='" . $view_date1 . "'";
$query5 = mysql_query($getActiveBaseQ5, $dbConn);
$numRows1 = mysql_num_rows($query5);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($uniAAActbase = mysql_fetch_array($query5)) {

        if ($circle_info[$uniAAActbase[5]] == '')
            $uniAAActbase[5] = 'Others';

        if ($languageData[trim($uniAAActbase[8])] != '')
            $lang = $languageData[$uniAAActbase[8]];
        else
            $lang = trim($uniAAActbase[8]);
        $uniAAActiveBasedata = $view_date1 . "|" . trim($uniAAActbase[0]) . "|" . trim($uniAAActbase[1]) . "|" . trim($uniAAActbase[2]) . "|" . trim($uniAAActbase[3]) . "|" . trim($uniAAActbase[4]) . "|" . trim($circle_info[$uniAAActbase[5]]) . "|" . trim($uniAAActbase[6]) . "|" . trim($uniAAActbase[7]) . "|" . trim($lang) . "\r\n";
        error_log($uniAAActiveBasedata, 3, $uniAAFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump5 = 'LOAD DATA LOCAL INFILE "' . $uniAAFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump5, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for AAUninor******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End  Uninor Artist Aloud//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////// Start Uninor JAD//////////////////////////////////////////////////////////////////////////

$uniJADFile = "1416/PUninorAstro_" . $fileDate . ".txt";
$uniJADFilePath = $activeDir . $uniJADFile;
$file_process_status = '***************Script start for UninorAstro ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($uniJADFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='UninorAstro' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ6 = "select 'UninorAstro',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_jyotish.tbl_jyotish_subscription nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query6 = mysql_query($getActiveBaseQ6, $dbConn);
$numRows1 = mysql_num_rows($query6);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($uniJADActbase = mysql_fetch_array($query6)) {
        if ($circle_info[$uniJADActbase[5]] == '')
            $uniJADActbase[5] = 'Others';

        if ($languageData[trim($uniJADActbase[8])] != '')
            $lang = $languageData[$uniJADActbase[8]];
        else
            $lang = trim($uniJADActbase[8]);
        $uniJADActiveBasedata = $view_date1 . "|" . trim($uniJADActbase[0]) . "|" . trim($uniJADActbase[1]) . "|" . trim($uniJADActbase[2]) . "|" . trim($uniJADActbase[3]) . "|" . trim($uniJADActbase[4]) . "|" . trim($circle_info[$uniJADActbase[5]]) . "|" . trim($uniJADActbase[6]) . "|" . trim($uniJADActbase[7]) . "|" . trim($lang) . "\r\n";
        error_log($uniJADActiveBasedata, 3, $uniJADFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump6 = 'LOAD DATA LOCAL INFILE "' . $uniJADFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump6, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for UninorAstro******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End  Uninor JAD//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////// Start PUninorSU //////////////////////////////////////////////////////////////////////////

$PUninorSUFile = "1408/PUninorSU_" . $fileDate . ".txt";
$PUninorSUFilePath = $activeDir . $PUninorSUFile;
$file_process_status = '***************Script start for UninorSU ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($PUninorSUFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='UninorSU' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ6 = "select 'UninorSU',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_cricket.tbl_cricket_subscription nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query6 = mysql_query($getActiveBaseQ6, $dbConn);
$numRows1 = mysql_num_rows($query6);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($PUninorSUActbase = mysql_fetch_array($query6)) {
        if ($circle_info[$PUninorSUActbase[5]] == '')
            $PUninorSUActbase[5] = 'Others';

        if ($languageData[trim($PUninorSUActbase[8])] != '')
            $lang = $languageData[$PUninorSUActbase[8]];
        else
            $lang = trim($PUninorSUActbase[8]);
        $PUninorSUActiveBasedata = $view_date1 . "|" . trim($PUninorSUActbase[0]) . "|" . trim($PUninorSUActbase[1]) . "|" . trim($PUninorSUActbase[2]) . "|" . trim($PUninorSUActbase[3]) . "|" . trim($PUninorSUActbase[4]) . "|" . trim($circle_info[$PUninorSUActbase[5]]) . "|" . trim($PUninorSUActbase[6]) . "|" . trim($PUninorSUActbase[7]) . "|" . trim($lang) . "\r\n";
        error_log($PUninorSUActiveBasedata, 3, $PUninorSUFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump6 = 'LOAD DATA LOCAL INFILE "' . $PUninorSUFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    if (mysql_query($insertDump6, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for UninorSU******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End  PUninorSU//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////// Start PUninorComedy //////////////////////////////////////////////////////////////////////////

$PUninorComedyFile = "1418/PUninorComedy_" . $fileDate . ".txt";
$PUninorComedyFilePath = $activeDir . $PUninorComedyFile;
$file_process_status = '***************Script start for UninorSU ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($PUninorComedyFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='UninorComedy' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ6 = "select 'UninorComedy',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_hungama.tbl_comedy_subscription nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query6 = mysql_query($getActiveBaseQ6, $dbConn);
$numRows1 = mysql_num_rows($query6);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($PUninorComedyActbase = mysql_fetch_array($query6)) {
        if ($circle_info[$PUninorComedyActbase[5]] == '')
            $PUninorComedyActbase[5] = 'Others';

        if ($languageData[trim($PUninorComedyActbase[8])] != '')
            $lang = $languageData[$PUninorComedyActbase[8]];
        else
            $lang = trim($PUninorComedyActbase[8]);
        $PUninorComedyActiveBasedata = $view_date1 . "|" . trim($PUninorComedyActbase[0]) . "|" . trim($PUninorComedyActbase[1]) . "|" . trim($PUninorComedyActbase[2]) . "|" . trim($PUninorComedyActbase[3]) . "|" . trim($PUninorComedyActbase[4]) . "|" . trim($circle_info[$PUninorComedyActbase[5]]) . "|" . trim($PUninorComedyActbase[6]) . "|" . trim($PUninorComedyActbase[7]) . "|" . trim($lang) . "\r\n";
        error_log($PUninorComedyActiveBasedata, 3, $PUninorComedyFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump6 = 'LOAD DATA LOCAL INFILE "' . $PUninorComedyFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump6, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for UninorSU******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End  PUninorComedy//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////// Start PUninorContest //////////////////////////////////////////////////////////////////////////

$PUninorContestFile = "1423/PUninorContest_" . $fileDate . ".txt";
$PUninorContestFilePath = $activeDir . $PUninorContestFile;
$file_process_status = '***************Script start for UninorContest ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($PUninorContestFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='UninorContest' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ6 = "select 'UninorContest',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),score,'Pending',def_lang,Rank from uninor_summer_contest.tbl_contest_subscription nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query6 = mysql_query($getActiveBaseQ6, $dbConn);
$numRows1 = mysql_num_rows($query6);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($PUninorContestActbase = mysql_fetch_array($query6)) {
        if ($circle_info[$PUninorContestActbase[5]] == '')
            $PUninorContestActbase[5] = 'Others';

        if ($languageData[trim($PUninorContestActbase[8])] != '')
            $lang = $languageData[$PUninorContestActbase[8]];
        else
            $lang = trim($PUninorContestActbase[8]);
        $PUninorContestActiveBasedata = $view_date1 . "|" . trim($PUninorContestActbase[0]) . "|" . trim($PUninorContestActbase[1]) . "|" . trim($PUninorContestActbase[2]) . "|" . trim($PUninorContestActbase[3]) . "|" . trim($PUninorContestActbase[4]) . "|" . trim($circle_info[$PUninorContestActbase[5]]) . "|" . trim($PUninorContestActbase[6]) . "|" . trim($PUninorContestActbase[7]) . "|" . trim($lang) . "|" . trim($PUninorContestActbase[9]) . "\r\n";
        error_log($PUninorContestActiveBasedata, 3, $PUninorContestFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump6 = 'LOAD DATA LOCAL INFILE "' . $PUninorContestFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump6, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for UninorContest******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End  PUninorCContest//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start UninorVABollyAlerts//////////////////////////////////////////////////////////////////////////

$uninorMTVFile = "1430/PUninorMTV_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;
$file_process_status = '***************Script start for UninorVABollyAlerts ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($uninorMTVFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='UninorVABollyAlerts' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ = "select 'UninorVABollyAlerts',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',replace(replace(def_lang,'01','HIN'),'99','HIN') 
    from Uninor_BollyAlerts.tbl_BA_subscription nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query = mysql_query($getActiveBaseQ, $dbConn);
$numRows1 = mysql_num_rows($query);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($UniMtvActbase = mysql_fetch_array($query)) {
        if ($circle_info[trim($UniMtvActbase[5])] == '')
            $UniMtvActbase[5] = 'Others';

        if ($languageData[trim($UniMtvActbase[8])] != '')
            $lang = $languageData[$UniMtvActbase[8]];
        else
            $lang = trim($UniMtvActbase[8]);
        $uniMTVActiveBasedata = $view_date1 . "|" . trim($UniMtvActbase[0]) . "|" . trim($UniMtvActbase[1]) . "|" . trim($UniMtvActbase[2]) . "|" . trim($UniMtvActbase[3]) . "|" . trim($UniMtvActbase[4]) . "|" . trim($circle_info[$UniMtvActbase[5]]) . "|" . trim($UniMtvActbase[6]) . "|" . trim($UniMtvActbase[7]) . "|" . trim($lang) . "|" . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . "\r\n";
        error_log($uniMTVActiveBasedata, 3, $uninorMTVFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorMTVFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for UninorVABollyAlerts******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End UninorVABollyAlerts//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start UninorVABollyMasala//////////////////////////////////////////////////////////////////////////

$uninorMTVFile = "1432/PUninorMTV_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;
$file_process_status = '***************Script start for UninorVABollyMasala ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($uninorMTVFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='UninorVABollyMasala' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ = "select 'UninorVABollyMasala',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',replace(replace(def_lang,'01','HIN'),'99','HIN')
    from Uninor_BollywoodMasala.tbl_BM_subscription nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query = mysql_query($getActiveBaseQ, $dbConn);
$numRows1 = mysql_num_rows($query);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($UniMtvActbase = mysql_fetch_array($query)) {
        if ($circle_info[trim($UniMtvActbase[5])] == '')
            $UniMtvActbase[5] = 'Others';

        if ($languageData[trim($UniMtvActbase[8])] != '')
            $lang = $languageData[$UniMtvActbase[8]];
        else
            $lang = trim($UniMtvActbase[8]);
        $uniMTVActiveBasedata = $view_date1 . "|" . trim($UniMtvActbase[0]) . "|" . trim($UniMtvActbase[1]) . "|" . trim($UniMtvActbase[2]) . "|" . trim($UniMtvActbase[3]) . "|" . trim($UniMtvActbase[4]) . "|" . trim($circle_info[$UniMtvActbase[5]]) . "|" . trim($UniMtvActbase[6]) . "|" . trim($UniMtvActbase[7]) . "|" . trim($lang) . "|" . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . "\r\n";
        error_log($uniMTVActiveBasedata, 3, $uninorMTVFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorMTVFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for UninorVABollyMasala******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End UninorVABollyMasala//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start UninorVAFashion//////////////////////////////////////////////////////////////////////////

$uninorMTVFile = "1434/PUninorMTV_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;
$file_process_status = '***************Script start for UninorVAFashion ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($uninorMTVFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='UninorVAFashion' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ = "select 'UninorVAFashion',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',replace(replace(def_lang,'01','HIN'),'99','HIN')
    from Uninor_CelebrityFashion.tbl_CF_subscription nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query = mysql_query($getActiveBaseQ, $dbConn);
$numRows1 = mysql_num_rows($query);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($UniMtvActbase = mysql_fetch_array($query)) {
        if ($circle_info[trim($UniMtvActbase[5])] == '')
            $UniMtvActbase[5] = 'Others';

        if ($languageData[trim($UniMtvActbase[8])] != '')
            $lang = $languageData[$UniMtvActbase[8]];
        else
            $lang = trim($UniMtvActbase[8]);
        $uniMTVActiveBasedata = $view_date1 . "|" . trim($UniMtvActbase[0]) . "|" . trim($UniMtvActbase[1]) . "|" . trim($UniMtvActbase[2]) . "|" . trim($UniMtvActbase[3]) . "|" . trim($UniMtvActbase[4]) . "|" . trim($circle_info[$UniMtvActbase[5]]) . "|" . trim($UniMtvActbase[6]) . "|" . trim($UniMtvActbase[7]) . "|" . trim($lang) . "|" . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . "\r\n";
        error_log($uniMTVActiveBasedata, 3, $uninorMTVFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorMTVFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for UninorVAFashion******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End UninorVAFashion//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start UninorVAFilmy//////////////////////////////////////////////////////////////////////////

$uninorMTVFile = "1431/PUninorMTV_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;
$file_process_status = '***************Script start for UninorVAFilmy ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($uninorMTVFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='UninorVAFilmy' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ = "select 'UninorVAFilmy',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',replace(replace(def_lang,'01','HIN'),'99','HIN') 
    from Uninor_FilmiWords.tbl_FW_subscription nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query = mysql_query($getActiveBaseQ, $dbConn);
$numRows1 = mysql_num_rows($query);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($UniMtvActbase = mysql_fetch_array($query)) {
        if ($circle_info[trim($UniMtvActbase[5])] == '')
            $UniMtvActbase[5] = 'Others';

        if ($languageData[trim($UniMtvActbase[8])] != '')
            $lang = $languageData[$UniMtvActbase[8]];
        else
            $lang = trim($UniMtvActbase[8]);
        $uniMTVActiveBasedata = $view_date1 . "|" . trim($UniMtvActbase[0]) . "|" . trim($UniMtvActbase[1]) . "|" . trim($UniMtvActbase[2]) . "|" . trim($UniMtvActbase[3]) . "|" . trim($UniMtvActbase[4]) . "|" . trim($circle_info[$UniMtvActbase[5]]) . "|" . trim($UniMtvActbase[6]) . "|" . trim($UniMtvActbase[7]) . "|" . trim($lang) . "|" . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . "\r\n";
        error_log($uniMTVActiveBasedata, 3, $uninorMTVFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorMTVFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for UninorVAFilmy******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End UninorVAFilmy/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start UninorVAHealth//////////////////////////////////////////////////////////////////////////

$uninorMTVFile = "1433/PUninorMTV_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;
$file_process_status = '***************Script start for UninorVAHealth ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

unlink($uninorMTVFilePath);
$file_process_status = 'Delete existing file at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='UninorVAHealth' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$getActiveBaseQ = "select 'UninorVAHealth',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',replace(replace(def_lang,'01','HIN'),'99','HIN') 
    from Uninor_FilmiHeath.tbl_FH_subscription nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query = mysql_query($getActiveBaseQ, $dbConn);
$numRows1 = mysql_num_rows($query);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    while ($UniMtvActbase = mysql_fetch_array($query)) {
        if ($circle_info[trim($UniMtvActbase[5])] == '')
            $UniMtvActbase[5] = 'Others';

        if ($languageData[trim($UniMtvActbase[8])] != '')
            $lang = $languageData[$UniMtvActbase[8]];
        else
            $lang = trim($UniMtvActbase[8]);
        $uniMTVActiveBasedata = $view_date1 . "|" . trim($UniMtvActbase[0]) . "|" . trim($UniMtvActbase[1]) . "|" . trim($UniMtvActbase[2]) . "|" . trim($UniMtvActbase[3]) . "|" . trim($UniMtvActbase[4]) . "|" . trim($circle_info[$UniMtvActbase[5]]) . "|" . trim($UniMtvActbase[6]) . "|" . trim($UniMtvActbase[7]) . "|" . trim($lang) . "|" . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . "\r\n";
        error_log($uniMTVActiveBasedata, 3, $uninorMTVFilePath);
    }
    $file_process_status = 'Create new file end here at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorMTVFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for UninorVAHealth******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End UninorVAHealth//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////// code END to dump Pending base for Uninor Operator///////////////////////////////////////////////////
/***********************************UNINOR SMS PACKS START**********************/

$file_process_status = '***************Script start for SMSUninorGujarati ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$uninorMTVFile = "1439/PSMSUninorGujarati_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;
unlink($uninorMTVFilePath);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='SMSUninorGujarati' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$getActiveBaseQ = "select 'SMSUninorGujarati',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',replace(replace(def_lang,'01','HIN'),'99','HIN') 
    from Uninor_smspack.tbl_local_gujarati_sub nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query = mysql_query($getActiveBaseQ, $dbConn);
$numRows1 = mysql_num_rows($query);
if ($numRows1 > 0) {
       while ($UniMtvActbase = mysql_fetch_array($query)) {
        if ($circle_info[trim($UniMtvActbase[5])] == '')
            $UniMtvActbase[5] = 'Others';

        if ($languageData[trim($UniMtvActbase[8])] != '')
            $lang = $languageData[$UniMtvActbase[8]];
        else
            $lang = trim($UniMtvActbase[8]);
        $uniMTVActiveBasedata = $view_date1 . "|" . trim($UniMtvActbase[0]) . "|" . trim($UniMtvActbase[1]) . "|" . trim($UniMtvActbase[2]) . "|" . trim($UniMtvActbase[3]) . "|" . trim($UniMtvActbase[4]) . "|" . trim($circle_info[$UniMtvActbase[5]]) . "|" . trim($UniMtvActbase[6]) . "|" . trim($UniMtvActbase[7]) . "|" . trim($lang) . "|" . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . "\r\n";
        error_log($uniMTVActiveBasedata, 3, $uninorMTVFilePath);
    }
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorMTVFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***********Script end for SMSUninorGujarati**********' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}

$file_process_status = '***************Script start for SMSUninorAlert ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$uninorMTVFile = "1440/PSMSUninorAlert_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;
unlink($uninorMTVFilePath);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='SMSUninorAlert' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$getActiveBaseQ = "select 'SMSUninorAlert',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',replace(replace(def_lang,'01','HIN'),'99','HIN') 
    from Uninor_smspack.tbl_rich_alerts_sub nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query = mysql_query($getActiveBaseQ, $dbConn);
$numRows1 = mysql_num_rows($query);
if ($numRows1 > 0) {
       while ($UniMtvActbase = mysql_fetch_array($query)) {
        if ($circle_info[trim($UniMtvActbase[5])] == '')
            $UniMtvActbase[5] = 'Others';

        if ($languageData[trim($UniMtvActbase[8])] != '')
            $lang = $languageData[$UniMtvActbase[8]];
        else
            $lang = trim($UniMtvActbase[8]);
        $uniMTVActiveBasedata = $view_date1 . "|" . trim($UniMtvActbase[0]) . "|" . trim($UniMtvActbase[1]) . "|" . trim($UniMtvActbase[2]) . "|" . trim($UniMtvActbase[3]) . "|" . trim($UniMtvActbase[4]) . "|" . trim($circle_info[$UniMtvActbase[5]]) . "|" . trim($UniMtvActbase[6]) . "|" . trim($UniMtvActbase[7]) . "|" . trim($lang) . "|" . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . "\r\n";
        error_log($uniMTVActiveBasedata, 3, $uninorMTVFilePath);
    }
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorMTVFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***********Script end for SMSUninorAlert**********' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}

$file_process_status = '***************Script start for SMSUninorFashion ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$uninorMTVFile = "1438/PSMSUninorFashion_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;
unlink($uninorMTVFilePath);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='SMSUninorFashion' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$getActiveBaseQ = "select 'SMSUninorFashion',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',replace(replace(def_lang,'01','HIN'),'99','HIN') 
    from Uninor_smspack.tbl_fashion_sub nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query = mysql_query($getActiveBaseQ, $dbConn);
$numRows1 = mysql_num_rows($query);
if ($numRows1 > 0) {
       while ($UniMtvActbase = mysql_fetch_array($query)) {
        if ($circle_info[trim($UniMtvActbase[5])] == '')
            $UniMtvActbase[5] = 'Others';

        if ($languageData[trim($UniMtvActbase[8])] != '')
            $lang = $languageData[$UniMtvActbase[8]];
        else
            $lang = trim($UniMtvActbase[8]);
        $uniMTVActiveBasedata = $view_date1 . "|" . trim($UniMtvActbase[0]) . "|" . trim($UniMtvActbase[1]) . "|" . trim($UniMtvActbase[2]) . "|" . trim($UniMtvActbase[3]) . "|" . trim($UniMtvActbase[4]) . "|" . trim($circle_info[$UniMtvActbase[5]]) . "|" . trim($UniMtvActbase[6]) . "|" . trim($UniMtvActbase[7]) . "|" . trim($lang) . "|" . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . '|' . trim($UniMtvActbase[15]) . "\r\n";
        error_log($uniMTVActiveBasedata, 3, $uninorMTVFilePath);
    }
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorMTVFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***********Script end for SMSUninorFashion**********' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
/*********************************UNINOR SMS PACKS END ***********************/


$file_process_status = '***************Script start for Uninor Desi Beat ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$uninorRegFile = "1441/PSMSUninorReg_" . $fileDate . ".txt";
$uninorRegFilePath = $activeDir . $uninorRegFile;
unlink($uninorRegFilePath);
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='UninorReg' and status='Pending'";
$delquery = mysql_query($del, $LivdbConn);
$getActiveBaseQ = "select 'UninorReg',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',replace(replace(def_lang,'01','HIN'),'99','HIN') 
    from uninor_hungama.tbl_LG_subscription nolock where status=11 and date(sub_date)<='" . $view_date1 . "'";
$query = mysql_query($getActiveBaseQ, $dbConn);
$numRows1 = mysql_num_rows($query);
if ($numRows1 > 0) {
       while ($UniRegActbase = mysql_fetch_array($query)) {
        if ($circle_info[trim($UniRegActbase[5])] == '')
            $UniRegActbase[5] = 'Others';

        if ($languageData[trim($UniRegActbase[8])] != '')
            $lang = $languageData[$UniRegActbase[8]];
        else
            $lang = trim($UniRegActbase[8]);
        $uniRegActiveBasedata = $view_date1 . "|" . trim($UniRegActbase[0]) . "|" . trim($UniRegActbase[1]) . "|" . trim($UniRegActbase[2]) . "|" . trim($UniRegActbase[3]) . "|" . trim($UniRegActbase[4]) . "|" . trim($circle_info[$UniRegActbase[5]]) . "|" . trim($UniRegActbase[6]) . "|" . trim($UniRegActbase[7]) . "|" . trim($lang) . "|" . trim($UniRegActbase[15]) . '|' . trim($UniRegActbase[15]) . '|' . trim($UniRegActbase[15]) . "\r\n";
        error_log($uniRegActiveBasedata, 3, $uninorRegFilePath);
    }
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorRegFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    $file_process_status = $dbstatus . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***********Script end for Uninor Desi Beat**********' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
/*********************************Uninor Desi Beat END ***********************/



echo "done";
mysql_close($dbConn);
mysql_close($LivdbConn);
?>
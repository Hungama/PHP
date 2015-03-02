<?php

//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$activeDir = "/var/www/html/kmis/testing/activeBase/";

$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$fview_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'UND' => 'Others', 'Others' => 'Others');

$languageData = array('01' => 'Hindi', '02' => 'English', '03' => 'Punjabi', '04' => 'Bhojpuri', '05' => 'Haryanavi', '06' => 'Bengali', '07' => 'Tamil', '08' => 'Telugu', '09' => 'Malayalam', '10' => 'Kannada', '11' => 'Marathi', '12' => 'Gujarati', '13' => 'Oriya', '14' => 'Kashmiri', '15' => 'Himachali', '16' => 'Chhattisgarhi', '17' => 'Assamese', '18' => 'Rajasthani', '19' => 'Nepali', '20' => 'Kumaoni', '21' => 'Maithali', '99' => 'Hindi');

////////////////////////////////////////////////////Start Docomo MTV//////////////////////////////////////////////////////////////////////////

$docomoMTVFile = "1003/MTVTataDoCoMo_" . $fileDate . ".txt";
$docomoMTVFilePath = $activeDir . $docomoMTVFile;
$docomoMTVFile_process_status = "1003/MTVTataDoCoMo_process_" . $fileDate . ".txt";
$docomoMTVFilePath_process = $activeDir . $docomoMTVFile_process_status;
if (file_exists($docomoMTVFilePath)) {
    unlink($docomoMTVFilePath);
    $file_process_status = 'Existing file delete' . "\r\n";
    error_log($file_process_status, 3, $docomoMTVFilePath_process);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='MTVTataDoCoMo' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    $file_process_status = 'Delete data from misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $docomoMTVFilePath_process);
}

$getActiveBaseQ7 = "select 'MTVTataDoCoMo',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_hungama.tbl_mtv_subscription where status=1 and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getActiveBaseQ7, $dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here' . "\r\n";
    error_log($file_process_status, 3, $docomoMTVFilePath_process);
    while ($docomoMtvActbase = mysql_fetch_array($query7)) {
        if ($circle_info[$docomoMtvActbase[5]] == '')
            $docomoMtvActbase[5] = 'Others';

        if ($languageData[trim($docomoMtvActbase[8])] != '')
            $lang = $languageData[$docomoMtvActbase[8]];
        else
            $lang = trim($docomoMtvActbase[8]);
        $docomoMTVActiveBasedata = $view_date1 . "|" . trim($docomoMtvActbase[0]) . "|" . trim($docomoMtvActbase[1]) . "|" . trim($docomoMtvActbase[2]) . "|" . trim($docomoMtvActbase[3]) . "|" . trim($docomoMtvActbase[4]) . "|" . trim($circle_info[$docomoMtvActbase[5]]) . "|" . trim($docomoMtvActbase[6]) . "|" . trim($docomoMtvActbase[7]) . "|" . trim($lang) . "|" . trim($docomoMtvActbase[15]) . '|' . trim($docomoMtvActbase[15]) . '|' . trim($docomoMtvActbase[15]) . "\r\n";
        error_log($docomoMTVActiveBasedata, 3, $docomoMTVFilePath);
    }
    $file_process_status = 'Create new file end here' . "\r\n";
    error_log($file_process_status, 3, $docomoMTVFilePath_process);
    $file_process_status = 'Load Data query start here in to misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $docomoMTVFilePath_process);
    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $docomoMTVFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    mysql_query($insertDump7, $LivdbConn);
    $file_process_status = 'Load Data query execute successfully with database connectivity status' . $dbstatus . "\r\n";

    error_log($file_process_status, 3, $docomoMTVFilePath_process);
}
//////////////////////////////////////////////////// End Docomo MTV//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////// Start Docomo MTV//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Docomo 54646//////////////////////////////////////////////////////////////////////////

$docomo54646File = "1002/TataDoCoMo54646_" . $fileDate . ".txt";
$docomo54646FilePath = $activeDir . $docomo54646File;
$docomo54646File_process_status = "1002/TataDoCoMo54646_process_" . $fileDate . ".txt";
$docomo54646FilePath_process = $activeDir . $docomo54646File_process_status;
if (file_exists($docomo54646FilePath)) {
    unlink($docomo54646FilePath);
    $file_process_status = 'Existing file delete' . "\r\n";
    error_log($file_process_status, 3, $docomo54646FilePath_process);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='TataDoCoMo54646' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    $file_process_status = 'Delete data from misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $docomo54646FilePath_process);
}

$getActiveBaseQ8 = "select 'TataDoCoMo54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_hungama.tbl_jbox_subscription where status IN (1) and dnis not like '%P%' and date(sub_date)<='" . $view_date1 . "'";
$query8 = mysql_query($getActiveBaseQ8, $dbConn);
$numRows1 = mysql_num_rows($query8);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here' . "\r\n";
    error_log($file_process_status, 3, $docomo54646FilePath_process);
    while ($docomo54646Actbase = mysql_fetch_array($query8)) {
        if ($circle_info[$docomo54646Actbase[5]] == '')
            $docomo54646Actbase[5] = 'Others';

        if ($languageData[trim($docomo54646Actbase[8])] != '')
            $lang = $languageData[$docomo54646Actbase[8]];
        else
            $lang = trim($docomo54646Actbase[8]);
        $docomo5464ActiveBasedata = $view_date1 . "|" . trim($docomo54646Actbase[0]) . "|" . trim($docomo54646Actbase[1]) . "|" . trim($docomo54646Actbase[2]) . "|" . trim($docomo54646Actbase[3]) . "|" . trim($docomo54646Actbase[4]) . "|" . trim($circle_info[$docomo54646Actbase[5]]) . "|" . trim($docomo54646Actbase[6]) . "|" . trim($docomo54646Actbase[7]) . "|" . trim($lang) . "|" . trim($docomo54646Actbase[15]) . '|' . trim($docomo54646Actbase[15]) . '|' . trim($docomo54646Actbase[15]) . "\r\n";

        error_log($docomo5464ActiveBasedata, 3, $docomo54646FilePath);
    }
    $file_process_status = 'Create new file end here' . "\r\n";
    error_log($file_process_status, 3, $docomo54646FilePath_process);
    $file_process_status = 'Load Data query start here in to misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $docomo54646FilePath_process);
    $insertDump8 = 'LOAD DATA LOCAL INFILE "' . $docomo54646FilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    mysql_query($insertDump8, $LivdbConn);
    $file_process_status = 'Load Data query execute successfully with database connectivity status' . $dbstatus . "\r\n";

    error_log($file_process_status, 3, $docomoMTVFilePath_process);
}
//////////////////////////////////////////////////// End Docomo 54646//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Docomo Redfm//////////////////////////////////////////////////////////////////////////

$docomoREDFMFile = "1010/RedFMTataDoCoMo_" . $fileDate . ".txt";
$docomoREDFMFilePath = $activeDir . $docomoREDFMFile;
$docomoREDFMFile_process_status = "1010/RedFMTataDoCoMo_process_" . $fileDate . ".txt";
$docomoREDFMFilePath_process = $activeDir . $docomoREDFMFile_process_status;
if (file_exists($docomoREDFMFilePath)) {
    unlink($docomoREDFMFilePath);
    $file_process_status = 'Existing file delete' . "\r\n";
    error_log($file_process_status, 3, $docomoREDFMFilePath_process);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='RedFMTataDoCoMo' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    $file_process_status = 'Delete data from misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $docomoREDFMFilePath_process);
}

$getActiveBaseQ9 = "select 'RedFMTataDoCoMo',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_redfm.tbl_jbox_subscription where status IN (1) and plan_id!=72 and date(sub_date)<='" . $view_date1 . "'";
$query9 = mysql_query($getActiveBaseQ9, $dbConn);
$numRows1 = mysql_num_rows($query9);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here' . "\r\n";
    error_log($file_process_status, 3, $docomoREDFMFilePath_process);
    while ($docomoREDFMActbase = mysql_fetch_array($query9)) {
        if ($circle_info[$docomoREDFMActbase[5]] == '')
            $docomoREDFMActbase[5] = 'Others';

        if ($languageData[trim($docomoREDFMActbase[8])] != '')
            $lang = $languageData[$docomoREDFMActbase[8]];
        else
            $lang = trim($docomoREDFMActbase[8]);

        $docomoREDFMActiveBasedata = $view_date1 . "|" . trim($docomoREDFMActbase[0]) . "|" . trim($docomoREDFMActbase[1]) . "|" . trim($docomoREDFMActbase[2]) . "|" . trim($docomoREDFMActbase[3]) . "|" . trim($docomoREDFMActbase[4]) . "|" . trim($circle_info[$docomoREDFMActbase[5]]) . "|" . trim($docomoREDFMActbase[6]) . "|" . trim($docomoREDFMActbase[7]) . "|" . trim($lang) . "|" . trim($docomoREDFMActbase[15]) . '|' . trim($docomoREDFMActbase[15]) . '|' . trim($docomoREDFMActbase[15]) . "\r\n";

        error_log($docomoREDFMActiveBasedata, 3, $docomoREDFMFilePath);
    }
    $file_process_status = 'Create new file end here' . "\r\n";
    error_log($file_process_status, 3, $docomoREDFMFilePath_process);
    $file_process_status = 'Load Data query start here in to misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $docomoREDFMFilePath_process);
    $insertDump9 = 'LOAD DATA LOCAL INFILE "' . $docomoREDFMFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    mysql_query($insertDump9, $LivdbConn);
    $file_process_status = 'Load Data query execute successfully with database connectivity status' . $dbstatus . "\r\n";

    error_log($file_process_status, 3, $docomoREDFMFilePath_process);
}
//////////////////////////////////////////////////// End Docomo Redfm//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Docomo Ria//////////////////////////////////////////////////////////////////////////

$docomoRIAFile = "1009/RIATataDoCoMo_" . $fileDate . ".txt";
$docomoRIAFilePath = $activeDir . $docomoRIAFile;
$docomoRIAFile_process_status = "1009/RIATataDoCoMo_process_" . $fileDate . ".txt";
$docomoRIAFilePath_process = $activeDir . $docomoRIAFile_process_status;
if (file_exists($docomoRIAFilePath)) {
    unlink($docomoRIAFilePath);
    $file_process_status = 'Existing file delete' . "\r\n";
    error_log($file_process_status, 3, $docomoRIAFilePath_process);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='RIATataDoCoMo' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    $file_process_status = 'Delete data from misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $docomoRIAFilePath_process);
}

$getActiveBaseQ10 = "select 'RIATataDoCoMo',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_manchala.tbl_riya_subscription where status=1 and plan_id!=73 and date(sub_date)<='" . $view_date1 . "'";
$query10 = mysql_query($getActiveBaseQ10, $dbConn);
$numRows1 = mysql_num_rows($query10);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here' . "\r\n";
    error_log($file_process_status, 3, $docomoRIAFilePath_process);
    while ($docomoRIAActbase = mysql_fetch_array($query10)) {
        if ($circle_info[$docomoRIAActbase[5]] == '')
            $docomoRIAActbase[5] = 'Others';

        if ($languageData[trim($docomoRIAActbase[8])] != '')
            $lang = $languageData[$docomoRIAActbase[8]];
        else
            $lang = trim($docomoRIAActbase[8]);

        $docomoRIAActiveBasedata = $view_date1 . "|" . trim($docomoRIAActbase[0]) . "|" . trim($docomoRIAActbase[1]) . "|" . trim($docomoRIAActbase[2]) . "|" . trim($docomoRIAActbase[3]) . "|" . trim($docomoRIAActbase[4]) . "|" . trim($circle_info[$docomoRIAActbase[5]]) . "|" . trim($docomoRIAActbase[6]) . "|" . trim($docomoRIAActbase[7]) . "|" . trim($lang) . "|" . trim($docomoRIAActbase[15]) . '|' . trim($docomoRIAActbase[15]) . '|' . trim($docomoRIAActbase[15]) . "\r\n";

        error_log($docomoRIAActiveBasedata, 3, $docomoRIAFilePath);
    }
    $file_process_status = 'Create new file end here' . "\r\n";
    error_log($file_process_status, 3, $docomoRIAFilePath_process);
    $file_process_status = 'Load Data query start here in to misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $docomoRIAFilePath_process);
    $insertDump10 = 'LOAD DATA LOCAL INFILE "' . $docomoRIAFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    mysql_query($insertDump10, $LivdbConn);
    $file_process_status = 'Load Data query execute successfully with database connectivity status' . $dbstatus . "\r\n";

    error_log($file_process_status, 3, $docomoRIAFilePath_process);
}
//////////////////////////////////////////////////// End Docomo Redfm//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Docomo ENDLESS//////////////////////////////////////////////////////////////////////////

$docomoEndFile = "1002/TataDoCoMoMX_" . $fileDate . ".txt";
$docomoENDFilePath = $activeDir . $docomoEndFile;
$docomoEndFile_process_status = "1002/TataDoCoMoMX_process_" . $fileDate . ".txt";
$docomoENDFilePath_process = $activeDir . $docomoEndFile_process_status;
if (file_exists($docomoENDFilePath)) {
    unlink($docomoENDFilePath);
    $file_process_status = 'Existing file delete' . "\r\n";
    error_log($file_process_status, 3, $docomoENDFilePath_process);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='TataDoCoMoMX' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    $file_process_status = 'Delete data from misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $docomoENDFilePath_process);
}

$getActiveBaseQ11 = "select 'TataDoCoMoMX',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_radio.tbl_radio_subscription where status=1 AND plan_id != 40 and date(sub_date)<='" . $view_date1 . "'";
$query11 = mysql_query($getActiveBaseQ11, $dbConn);
$numRows1 = mysql_num_rows($query8);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here' . "\r\n";
    error_log($file_process_status, 3, $docomoENDFilePath_process);
    while ($docomoENDActbase = mysql_fetch_array($query11)) {
        if ($circle_info[$docomoENDActbase[5]] == '')
            $docomoENDActbase[5] = 'Others';
        if ($languageData[trim($docomoENDActbase[8])] != '')
            $lang = $languageData[$docomoENDActbase[8]];
        else
            $lang = trim($docomoENDActbase[8]);
        $docomoENDActiveBasedata = $view_date1 . "|" . trim($docomoENDActbase[0]) . "|" . trim($docomoENDActbase[1]) . "|" . trim($docomoENDActbase[2]) . "|" . trim($docomoENDActbase[3]) . "|" . trim($docomoENDActbase[4]) . "|" . trim($circle_info[$docomoENDActbase[5]]) . "|" . trim($docomoENDActbase[6]) . "|" . trim($docomoENDActbase[7]) . "|" . trim($lang) . "|" . trim($docomoENDActbase[15]) . '|' . trim($docomoENDActbase[15]) . '|' . trim($docomoENDActbase[15]) . "\r\n";

        error_log($docomoENDActiveBasedata, 3, $docomoENDFilePath);
    }
    $file_process_status = 'Create new file end here' . "\r\n";
    error_log($file_process_status, 3, $docomoENDFilePath_process);
    $file_process_status = 'Load Data query start here in to misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $docomoENDFilePath_process);
    $insertDump11 = 'LOAD DATA LOCAL INFILE "' . $docomoENDFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    mysql_query($insertDump11, $LivdbConn);
    $file_process_status = 'Load Data query execute successfully with database connectivity status' . $dbstatus . "\r\n";

    error_log($file_process_status, 3, $docomoENDFilePath_process);
}
//////////////////////////////////////////////////// End Docomo ENDLESS//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Docomo FMJ//////////////////////////////////////////////////////////////////////////

$docomoFMJFile = "1005/TataDoCoMoFMJ_" . $fileDate . ".txt";
$docomoFMJFilePath = $activeDir . $docomoFMJFile;
$docomoFMJFile_process_status = "1005/TataDoCoMoFMJ_process_" . $fileDate . ".txt";
$docomoFMJFilePath_process = $activeDir . $docomoFMJFile_process_status;
if (file_exists($docomoFMJFilePath)) {
    unlink($docomoFMJFilePath);
    $file_process_status = 'Existing file delete' . "\r\n";
    error_log($file_process_status, 3, $docomoFMJFilePath_process);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='TataDoCoMoFMJ' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    $file_process_status = 'Delete data from misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $docomoFMJFilePath_process);
}

$getActiveBaseQ12 = "select 'TataDoCoMoFMJ',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_starclub.tbl_jbox_subscription where status=1 and date(sub_date)<='" . $view_date1 . "'";
$query12 = mysql_query($getActiveBaseQ12, $dbConn);
$numRows1 = mysql_num_rows($query12);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here' . "\r\n";
    error_log($file_process_status, 3, $docomoFMJFilePath_process);
    while ($docomoFMJActbase = mysql_fetch_array($query12)) {
        if ($circle_info[$docomoFMJActbase[5]] == '')
            $docomoFMJActbase[5] = 'Others';
        if ($languageData[trim($docomoFMJActbase[8])] != '')
            $lang = $languageData[$docomoFMJActbase[8]];
        else
            $lang = trim($docomoFMJActbase[8]);
        $docomoFMJActiveBasedata = $view_date1 . "|" . trim($docomoFMJActbase[0]) . "|" . trim($docomoFMJActbase[1]) . "|" . trim($docomoFMJActbase[2]) . "|" . trim($docomoFMJActbase[3]) . "|" . trim($docomoFMJActbase[4]) . "|" . trim($circle_info[$docomoFMJActbase[5]]) . "|" . trim($docomoFMJActbase[6]) . "|" . trim($docomoFMJActbase[7]) . "|" . trim($lang) . "|" . trim($docomoFMJActbase[15]) . '|' . trim($docomoFMJActbase[15]) . '|' . trim($docomoFMJActbase[15]) . "\r\n";

        error_log($docomoFMJActiveBasedata, 3, $docomoFMJFilePath);
    }
    $file_process_status = 'Create new file end here' . "\r\n";
    error_log($file_process_status, 3, $docomoFMJFilePath_process);
    $file_process_status = 'Load Data query start here in to misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $docomoFMJFilePath_process);
    $insertDump12 = 'LOAD DATA LOCAL INFILE "' . $docomoFMJFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    mysql_query($insertDump12, $LivdbConn);
    $file_process_status = 'Load Data query execute successfully with database connectivity status' . $dbstatus . "\r\n";

    error_log($file_process_status, 3, $docomoFMJFilePath_process);
}
//////////////////////////////////////////////////// End Docomo FMJ//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start AATataDoCoMo//////////////////////////////////////////////////////////////////////////

$AATataDoCoMoFile = "1005/AATataDoCoMo_" . $fileDate . ".txt";
$AATataDoCoMoFilePath = $activeDir . $AATataDoCoMoFile;
$AATataDoCoMoFile_process_status = "1005/AATataDoCoMo_process_" . $fileDate . ".txt";
$AATataDoCoMoFilePath_process = $activeDir . $AATataDoCoMoFile_process_status;
if (file_exists($AATataDoCoMoFilePath)) {
    unlink($AATataDoCoMoFilePath);
    $file_process_status = 'Existing file delete' . "\r\n";
    error_log($file_process_status, 3, $AATataDoCoMoFilePath_process);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='AATataDoCoMo' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    $file_process_status = 'Delete data from misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $AATataDoCoMoFilePath_process);
}

$getActiveBaseQ12 = "select 'AATataDoCoMo',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_hungama.tbl_Artist_Aloud_subscription where status=1 and plan_id='96' and date(sub_date)<='" . $view_date1 . "'";
$query12 = mysql_query($getActiveBaseQ12, $dbConn);
$numRows1 = mysql_num_rows($query12);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here' . "\r\n";
    error_log($file_process_status, 3, $AATataDoCoMoFilePath_process);
    while ($AATataDoCoMoActbase = mysql_fetch_array($query12)) {
        if ($circle_info[$AATataDoCoMoActbase[5]] == '')
            $AATataDoCoMoActbase[5] = 'Others';
        if ($languageData[trim($AATataDoCoMoActbase[8])] != '')
            $lang = $languageData[$AATataDoCoMoActbase[8]];
        else
            $lang = trim($AATataDoCoMoActbase[8]);
        $AATataDoCoMoActiveBasedata = $view_date1 . "|" . trim($AATataDoCoMoActbase[0]) . "|" . trim($AATataDoCoMoActbase[1]) . "|" . trim($AATataDoCoMoActbase[2]) . "|" . trim($AATataDoCoMoActbase[3]) . "|" . trim($AATataDoCoMoActbase[4]) . "|" . trim($circle_info[$AATataDoCoMoActbase[5]]) . "|" . trim($AATataDoCoMoActbase[6]) . "|" . trim($AATataDoCoMoActbase[7]) . "|" . trim($lang) . "|" . trim($AATataDoCoMoActbase[15]) . '|' . trim($AATataDoCoMoActbase[15]) . '|' . trim($AATataDoCoMoActbase[15]) . "\r\n";

        error_log($AATataDoCoMoActiveBasedata, 3, $AATataDoCoMoFilePath);
    }
    $file_process_status = 'Create new file end here' . "\r\n";
    error_log($file_process_status, 3, $AATataDoCoMoFilePath_process);
    $file_process_status = 'Load Data query start here in to misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $AATataDoCoMoFilePath_process);
    $insertDump12 = 'LOAD DATA LOCAL INFILE "' . $AATataDoCoMoFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    mysql_query($insertDump12, $LivdbConn);
    $file_process_status = 'Load Data query execute successfully with database connectivity status' . $dbstatus . "\r\n";

    error_log($file_process_status, 3, $AATataDoCoMoFilePath);
}
//////////////////////////////////////////////////// End AATataDoCoMo//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start TataDoCoMoMND//////////////////////////////////////////////////////////////////////////

$TataDoCoMoMNDFile = "1005/TataDoCoMoMND_" . $fileDate . ".txt";
$TataDoCoMoMNDFilePath = $activeDir . $TataDoCoMoMNDFile;
$TataDoCoMoMNDFile_process_status = "1005/TataDoCoMoMND_process_" . $fileDate . ".txt";
$TataDoCoMoMNDFilePath_process = $activeDir . $TataDoCoMoMNDFile_process_status;
if (file_exists($TataDoCoMoMNDFilePath)) {
    unlink($TataDoCoMoMNDFilePath);
    $file_process_status = 'Existing file delete' . "\r\n";
    error_log($file_process_status, 3, $TataDoCoMoMNDFilePath_process);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='TataDoCoMoMND' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    $file_process_status = 'Delete data from misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $TataDoCoMoMNDFilePath_process);
}

$getActiveBaseQ12 = "select 'TataDoCoMoMND',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_mnd.tbl_character_subscription1 where status=1 and plan_id='106' and date(sub_date)<='" . $view_date1 . "'";
$query12 = mysql_query($getActiveBaseQ12, $dbConn);
$numRows1 = mysql_num_rows($query12);
if ($numRows1 > 0) {
    $file_process_status = 'Create new file start here' . "\r\n";
    error_log($file_process_status, 3, $TataDoCoMoMNDFilePath_process);
    while ($TataDoCoMoMNDActbase = mysql_fetch_array($query12)) {
        if ($circle_info[$TataDoCoMoMNDActbase[5]] == '')
            $TataDoCoMoMNDActbase[5] = 'Others';
        if ($languageData[trim($TataDoCoMoMNDActbase[8])] != '')
            $lang = $languageData[$TataDoCoMoMNDActbase[8]];
        else
            $lang = trim($TataDoCoMoMNDActbase[8]);
        $TataDoCoMoMNDActiveBasedata = $view_date1 . "|" . trim($TataDoCoMoMNDActbase[0]) . "|" . trim($TataDoCoMoMNDActbase[1]) . "|" . trim($TataDoCoMoMNDActbase[2]) . "|" . trim($TataDoCoMoMNDActbase[3]) . "|" . trim($TataDoCoMoMNDActbase[4]) . "|" . trim($circle_info[$TataDoCoMoMNDActbase[5]]) . "|" . trim($TataDoCoMoMNDActbase[6]) . "|" . trim($TataDoCoMoMNDActbase[7]) . "|" . trim($lang) . "|" . trim($TataDoCoMoMNDActbase[15]) . '|' . trim($TataDoCoMoMNDActbase[15]) . '|' . trim($TataDoCoMoMNDActbase[15]) . "\r\n";

        error_log($TataDoCoMoMNDActiveBasedata, 3, $TataDoCoMoMNDFilePath);
    }
    $file_process_status = 'Create new file end here' . "\r\n";
    error_log($file_process_status, 3, $TataDoCoMoMNDFilePath_process);
    $file_process_status = 'Load Data query start here in to misdata.tbl_base_active' . "\r\n";
    error_log($file_process_status, 3, $TataDoCoMoMNDFilePath_process);
    $insertDump12 = 'LOAD DATA LOCAL INFILE "' . $TataDoCoMoMNDFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
    mysql_query($insertDump12, $LivdbConn);
    $file_process_status = 'Load Data query execute successfully with database connectivity status' . $dbstatus . "\r\n";

    error_log($file_process_status, 3, $TataDoCoMoMNDFilePath_process);
}
//////////////////////////////////////////////////// End TataDoCoMoMND//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////

echo "done";
mysql_close($dbConn);
mysql_close($LivdbConn);
?>

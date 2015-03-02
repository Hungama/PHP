<?php

//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$activeDir = "/var/www/html/kmis/testing/activeBase/";

$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$fview_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'UND' => 'Others', 'Others' => 'Others');

$languageData = array('01' => 'Hindi', '02' => 'English', '03' => 'Punjabi', '04' => 'Bhojpuri', '05' => 'Haryanavi', '06' => 'Bengali', '07' => 'Tamil', '08' => 'Telugu', '09' => 'Malayalam', '10' => 'Kannada', '11' => 'Marathi', '12' => 'Gujarati', '13' => 'Oriya', '14' => 'Kashmiri', '15' => 'Himachali', '16' => 'Chhattisgarhi', '17' => 'Assamese', '18' => 'Rajasthani', '19' => 'Nepali', '20' => 'Kumaoni', '21' => 'Maithali', '99' => 'Hindi');

////////////////////////////////////////////////////Start MTVReliance//////////////////////////////////////////////////////////////////////////

$MTVRelianceFile = "1203/MTVReliance_" . $fileDate . ".txt";
$MTVRelianceFilePath = $activeDir . $MTVRelianceFile;

if (file_exists($MTVRelianceFilePath)) {
    unlink($MTVRelianceFilePath);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='MTVReliance' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
}

$getActiveBaseQ7 = "select 'MTVReliance',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from reliance_hungama.tbl_mtv_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getActiveBaseQ7, $dbConn);
while ($MTVRelianceActbase = mysql_fetch_array($query7)) {
    if ($circle_info[$MTVRelianceActbase[5]] == '')
        $MTVRelianceActbase[5] = 'Others';

    if ($languageData[trim($MTVRelianceActbase[8])] != '')
        $lang = $languageData[$MTVRelianceActbase[8]];
    else
        $lang = trim($MTVRelianceActbase[8]);
    $MTVRelianceActiveBasedata = $view_date1 . "|" . trim($MTVRelianceActbase[0]) . "|" . trim($MTVRelianceActbase[1]) . "|" . trim($MTVRelianceActbase[2]) . "|" . trim($MTVRelianceActbase[3]) . "|" . trim($MTVRelianceActbase[4]) . "|" . trim($circle_info[$MTVRelianceActbase[5]]) . "|" . trim($MTVRelianceActbase[6]) . "|" . trim($MTVRelianceActbase[7]) . "|" . trim($lang) . "|" . trim($MTVRelianceActbase[15]) . '|' . trim($MTVRelianceActbase[15]) . '|' . trim($MTVRelianceActbase[15]) . "\r\n";
    error_log($MTVRelianceActiveBasedata, 3, $MTVRelianceFilePath);
}
$insertDump7 = 'LOAD DATA LOCAL INFILE "' . $MTVRelianceFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump7, $LivdbConn);

//////////////////////////////////////////////////// End Mts MTV/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Reliance54646//////////////////////////////////////////////////////////////////////////

$Reliance54646File = "1202/Reliance54646_" . $fileDate . ".txt";
$Reliance54646FilePath = $activeDir . $Reliance54646File;

if (file_exists($Reliance54646FilePath)) {
    unlink($Reliance54646FilePath);
    echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='Reliance54646' and status='Active'";
    $delquery = mysql_query($del1, $LivdbConn);
}

$getActiveBaseQ7 = "select 'Reliance54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from reliance_hungama.tbl_jbox_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "' and dnis not like '%P%'";
$query7 = mysql_query($getActiveBaseQ7, $dbConn);
while ($Reliance54646Actbase = mysql_fetch_array($query7)) {
    if ($circle_info[$Reliance54646Actbase[5]] == '')
        $Reliance54646Actbase[5] = 'Others';

    if ($languageData[trim($Reliance54646Actbase[8])] != '')
        $lang = $languageData[$Reliance54646Actbase[8]];
    else
        $lang = trim($Reliance54646Actbase[8]);
    $Reliance54646ActiveBasedata = $view_date1 . "|" . trim($Reliance54646Actbase[0]) . "|" . trim($Reliance54646Actbase[1]) . "|" . trim($Reliance54646Actbase[2]) . "|" . trim($Reliance54646Actbase[3]) . "|" . trim($Reliance54646Actbase[4]) . "|" . trim($circle_info[$Reliance54646Actbase[5]]) . "|" . trim($Reliance54646Actbase[6]) . "|" . trim($Reliance54646Actbase[7]) . "|" . trim($lang) . "|" . trim($Reliance54646Actbase[15]) . '|' . trim($Reliance54646Actbase[15]) . '|' . trim($Reliance54646Actbase[15]) . "\r\n";
    error_log($Reliance54646ActiveBasedata, 3, $Reliance54646FilePath);
}
$insertDump8 = 'LOAD DATA LOCAL INFILE "' . $Reliance54646FilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump8, $LivdbConn);


//////////////////////////////////////////////////// End Reliance54646/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start RelianceCM//////////////////////////////////////////////////////////////////////////

$RelianceCMFile = "1208/RelianceCM_" . $fileDate . ".txt";
$RelianceCMFilePath = $activeDir . $RelianceCMFile;

if (file_exists($RelianceCMFilePath)) {
    unlink($RelianceCMFilePath);
    echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='RelianceCM' and status='Active'";
    $delquery = mysql_query($del1, $LivdbConn);
}

$getActiveBaseQ7 = "select 'RelianceCM',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from reliance_cricket.tbl_cricket_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getActiveBaseQ7, $dbConn);
while ($RelianceCMActbase = mysql_fetch_array($query7)) {
    if ($circle_info[$RelianceCMActbase[5]] == '')
        $RelianceCMActbase[5] = 'Others';

    if ($languageData[trim($RelianceCMActbase[8])] != '')
        $lang = $languageData[$RelianceCMActbase[8]];
    else
        $lang = trim($RelianceCMActbase[8]);
    $RelianceCMActiveBasedata = $view_date1 . "|" . trim($RelianceCMActbase[0]) . "|" . trim($RelianceCMActbase[1]) . "|" . trim($RelianceCMActbase[2]) . "|" . trim($RelianceCMActbase[3]) . "|" . trim($RelianceCMActbase[4]) . "|" . trim($circle_info[$RelianceCMActbase[5]]) . "|" . trim($RelianceCMActbase[6]) . "|" . trim($RelianceCMActbase[7]) . "|" . trim($lang) . "|" . trim($RelianceCMActbase[15]) . '|' . trim($RelianceCMActbase[15]) . '|' . trim($RelianceCMActbase[15]) . "\r\n";
    error_log($RelianceCMActiveBasedata, 3, $RelianceCMFilePath);
}
$insertDump9 = 'LOAD DATA LOCAL INFILE "' . $RelianceCMFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump9, $LivdbConn);


//////////////////////////////////////////////////// End Mts VA/////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////Start RelianceMM Active Base @jyoti.porwal//////////////////////////////////////////////////////////////////////////

$RelianceCMFile = "1201/RelianceMM_" . $fileDate . ".txt";
$RelianceCMFilePath = $activeDir . $RelianceCMFile;

if (file_exists($RelianceCMFilePath)) {
    unlink($RelianceCMFilePath);
    echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='RelianceMM' and status='Active'";
    $delquery = mysql_query($del1, $LivdbConn);
}

$getActiveBaseQ7 = "select 'RelianceMM',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang
    from reliance_music_mania.tbl_MusicMania_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getActiveBaseQ7, $dbConn);
while ($RelianceCMActbase = mysql_fetch_array($query7)) {
    if ($circle_info[$RelianceCMActbase[5]] == '')
        $RelianceCMActbase[5] = 'Others';

    if ($languageData[trim($RelianceCMActbase[8])] != '')
        $lang = $languageData[$RelianceCMActbase[8]];
    else
        $lang = trim($RelianceCMActbase[8]);
    $RelianceCMActiveBasedata = $view_date1 . "|" . trim($RelianceCMActbase[0]) . "|" . trim($RelianceCMActbase[1]) . "|" . trim($RelianceCMActbase[2]) . "|" . trim($RelianceCMActbase[3]) . "|" . trim($RelianceCMActbase[4]) . "|" . trim($circle_info[$RelianceCMActbase[5]]) . "|" . trim($RelianceCMActbase[6]) . "|" . trim($RelianceCMActbase[7]) . "|" . trim($lang) . "|" . trim($RelianceCMActbase[15]) . '|' . trim($RelianceCMActbase[15]) . '|' . trim($RelianceCMActbase[15]) . "\r\n";
    error_log($RelianceCMActiveBasedata, 3, $RelianceCMFilePath);
}
$insertDump9 = 'LOAD DATA LOCAL INFILE "' . $RelianceCMFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump9, $LivdbConn);


////////////////////////////////////////////////////End RelianceMM Active Base @jyoti.porwal/////////////////////////////////////////////////////////////////////////                
////////////////////////////////////////////////////Start Pending Mts MTV//////////////////////////////////////////////////////////////////////////

$PMTVRelianceFile = "1203/PMTVReliance_" . $fileDate . ".txt";
$PMTVRelianceFilePath = $activeDir . $PMTVRelianceFile;

if (file_exists($PMTVRelianceFilePath)) {
    unlink($PMTVRelianceFilePath);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='MTVReliance' and status='Pending'";
    $delquery = mysql_query($del, $LivdbConn);
}

$getPendingBaseQ7 = "select 'MTVReliance',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from reliance_hungama.tbl_mtv_subscription nolock where status IN (11,0,5) and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getPendingBaseQ7, $dbConn);
while ($PMTVRelianceActbase = mysql_fetch_array($query7)) {
    if ($circle_info[$PMTVRelianceActbase[5]] == '')
        $PMTVRelianceActbase[5] = 'Others';

    if ($languageData[trim($PMTVRelianceActbase[8])] != '')
        $lang = $languageData[$PMTVRelianceActbase[8]];
    else
        $lang = trim($PMTVRelianceActbase[8]);
    $PMTVReliancePendingBasedata = $view_date1 . "|" . trim($PMTVRelianceActbase[0]) . "|" . trim($PMTVRelianceActbase[1]) . "|" . trim($PMTVRelianceActbase[2]) . "|" . trim($PMTVRelianceActbase[3]) . "|" . trim($PMTVRelianceActbase[4]) . "|" . trim($circle_info[$PMTVRelianceActbase[5]]) . "|" . trim($PMTVRelianceActbase[6]) . "|" . trim($PMTVRelianceActbase[7]) . "|" . trim($lang) . "|" . trim($PMTVRelianceActbase[15]) . '|' . trim($PMTVRelianceActbase[15]) . '|' . trim($PMTVRelianceActbase[15]) . "\r\n";
    error_log($PMTVReliancePendingBasedata, 3, $PMTVRelianceFilePath);
}
$insertDump10 = 'LOAD DATA LOCAL INFILE "' . $PMTVRelianceFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump10, $LivdbConn);


//////////////////////////////////////////////////// End Pending Mts MTV/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Pending Reliance54646//////////////////////////////////////////////////////////////////////////

$PReliance54646File = "1202/PReliance54646_" . $fileDate . ".txt";
$PReliance54646FilePath = $activeDir . $PReliance54646File;

if (file_exists($PReliance54646FilePath)) {
    unlink($PReliance54646FilePath);
    echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='Reliance54646' and status='Pending'";
    $delquery = mysql_query($del1, $LivdbConn);
}

$getPendingBaseQ7 = "select 'Reliance54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from reliance_hungama.tbl_jbox_subscription nolock where status IN (11,0,5) and dnis not like '%P%' and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getPendingBaseQ7, $dbConn);
while ($PReliance54646Actbase = mysql_fetch_array($query7)) {
    if ($circle_info[$PReliance54646Actbase[5]] == '')
        $PReliance54646Actbase[5] = 'Others';

    if ($languageData[trim($PReliance54646Actbase[8])] != '')
        $lang = $languageData[$PReliance54646Actbase[8]];
    else
        $lang = trim($PReliance54646Actbase[8]);
    $PReliance54646PendingBasedata = $view_date1 . "|" . trim($PReliance54646Actbase[0]) . "|" . trim($PReliance54646Actbase[1]) . "|" . trim($PReliance54646Actbase[2]) . "|" . trim($PReliance54646Actbase[3]) . "|" . trim($PReliance54646Actbase[4]) . "|" . trim($circle_info[$PReliance54646Actbase[5]]) . "|" . trim($PReliance54646Actbase[6]) . "|" . trim($PReliance54646Actbase[7]) . "|" . trim($lang) . "|" . trim($PReliance54646Actbase[15]) . '|' . trim($PReliance54646Actbase[15]) . '|' . trim($PReliance54646Actbase[15]) . "\r\n";
    error_log($PReliance54646PendingBasedata, 3, $PReliance54646FilePath);
}
$insertDump11 = 'LOAD DATA LOCAL INFILE "' . $PReliance54646FilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump11, $LivdbConn);


//////////////////////////////////////////////////// End Pending Reliance54646/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Pending Mts VA//////////////////////////////////////////////////////////////////////////

$PRelianceCMFile = "1208/PRelianceCM_" . $fileDate . ".txt";
$PRelianceCMFilePath = $activeDir . $PRelianceCMFile;

if (file_exists($PRelianceCMFilePath)) {
    unlink($PRelianceCMFilePath);
    echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='RelianceCM' and status='Pending'";
    $delquery = mysql_query($del1, $LivdbConn);
}

$getPendingBaseQ7 = "select 'RelianceCM',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from reliance_cricket.tbl_cricket_subscription nolock where status in (11,0,5) and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getPendingBaseQ7, $dbConn);
while ($PRelianceCMActbase = mysql_fetch_array($query7)) {
    if ($circle_info[$PRelianceCMActbase[5]] == '')
        $PRelianceCMActbase[5] = 'Others';

    if ($languageData[trim($PRelianceCMActbase[8])] != '')
        $lang = $languageData[$PRelianceCMActbase[8]];
    else
        $lang = trim($PRelianceCMActbase[8]);
    $PRelianceCMPendingBasedata = $view_date1 . "|" . trim($PRelianceCMActbase[0]) . "|" . trim($PRelianceCMActbase[1]) . "|" . trim($PRelianceCMActbase[2]) . "|" . trim($PRelianceCMActbase[3]) . "|" . trim($PRelianceCMActbase[4]) . "|" . trim($circle_info[$PRelianceCMActbase[5]]) . "|" . trim($PRelianceCMActbase[6]) . "|" . trim($PRelianceCMActbase[7]) . "|" . trim($lang) . "|" . trim($PRelianceCMActbase[15]) . '|' . trim($PRelianceCMActbase[15]) . '|' . trim($PRelianceCMActbase[15]) . "\r\n";
    error_log($PRelianceCMPendingBasedata, 3, $PRelianceCMFilePath);
}
$insertDump12 = 'LOAD DATA LOCAL INFILE "' . $PRelianceCMFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump12, $LivdbConn);


//////////////////////////////////////////////////// End Pending Mts VA/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Pending Base for RelianceMM service @jyoti.porwal//////////////////////////////////////////////////////////////////////////

$PRelianceCMFile = "1201/PRelianceMM_" . $fileDate . ".txt";
$PRelianceCMFilePath = $activeDir . $PRelianceCMFile;

if (file_exists($PRelianceCMFilePath)) {
    unlink($PRelianceCMFilePath);
    echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='RelianceMM' and status='Pending'";
    $delquery = mysql_query($del1, $LivdbConn);
}

$getPendingBaseQ7 = "select 'RelianceMM',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang 
    from reliance_music_mania.tbl_MusicMania_subscription nolock where status in (11,0,5) and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getPendingBaseQ7, $dbConn);
while ($PRelianceCMActbase = mysql_fetch_array($query7)) {
    if ($circle_info[$PRelianceCMActbase[5]] == '')
        $PRelianceCMActbase[5] = 'Others';

    if ($languageData[trim($PRelianceCMActbase[8])] != '')
        $lang = $languageData[$PRelianceCMActbase[8]];
    else
        $lang = trim($PRelianceCMActbase[8]);
    $PRelianceCMPendingBasedata = $view_date1 . "|" . trim($PRelianceCMActbase[0]) . "|" . trim($PRelianceCMActbase[1]) . "|" . trim($PRelianceCMActbase[2]) . "|" . trim($PRelianceCMActbase[3]) . "|" . trim($PRelianceCMActbase[4]) . "|" . trim($circle_info[$PRelianceCMActbase[5]]) . "|" . trim($PRelianceCMActbase[6]) . "|" . trim($PRelianceCMActbase[7]) . "|" . trim($lang) . "|" . trim($PRelianceCMActbase[15]) . '|' . trim($PRelianceCMActbase[15]) . '|' . trim($PRelianceCMActbase[15]) . "\r\n";
    error_log($PRelianceCMPendingBasedata, 3, $PRelianceCMFilePath);
}
$insertDump12 = 'LOAD DATA LOCAL INFILE "' . $PRelianceCMFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump12, $LivdbConn);


////////////////////////////////////////////////////End Pending Base for RelianceMM service @jyoti.porwal/////////////////////////////////////////////////////////////////////////                
//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////

mysql_close($dbConn);
mysql_close($LivdbConn);
?>
<?php

//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$activeDir = "/var/www/html/kmis/testing/activeBase/";

//$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//$fview_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
//$fileDate= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));


$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'UND' => 'Others', 'Others' => 'Others');

$languageData = array('01' => 'Hindi', '02' => 'English', '03' => 'Punjabi', '04' => 'Bhojpuri', '05' => 'Haryanavi', '06' => 'Bengali', '07' => 'Tamil', '08' => 'Telugu', '09' => 'Malayalam', '10' => 'Kannada', '11' => 'Marathi', '12' => 'Gujarati', '13' => 'Oriya', '14' => 'Kashmiri', '15' => 'Himachali', '16' => 'Chhattisgarhi', '17' => 'Assamese', '18' => 'Rajasthani', '19' => 'Nepali', '20' => 'Kumaoni', '21' => 'Maithali', '99' => 'Hindi');

$operator = $_POST['operator'];
$service_info = $_POST['service_info'];
$view_date1 = $_POST['Date'];
$upfor = $_POST['upfor'];
$fileDate = date("Ymd", strtotime($view_date1));
////////////////////////////////////////////////////Start RedFMTataDoCoMocdma//////////////////////////////////////////////////////////////////////////

$RedFMTataDoCoMocdmaFile = "1610/RedFMTataDoCoMocdma_" . $fileDate . ".txt";
$RedFMTataDoCoMocdmaFilePath = $activeDir . $RedFMTataDoCoMocdmaFile;

if (file_exists($RedFMTataDoCoMocdmaFilePath)) {
    unlink($RedFMTataDoCoMocdmaFilePath);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='RedFMTataDoCoMocdma' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
}

$getActiveBaseQ7 = "select 'RedFMTataDoCoMocdma',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from indicom_redfm.tbl_jbox_subscription where status=1 and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getActiveBaseQ7, $dbConn);
while ($RedFMTataDoCoMocdmaActbase = mysql_fetch_array($query7)) {
    if ($circle_info[$RedFMTataDoCoMocdmaActbase[5]] == '')
        $RedFMTataDoCoMocdmaActbase[5] = 'Others';

    if ($languageData[trim($RedFMTataDoCoMocdmaActbase[8])] != '')
        $lang = $languageData[$RedFMTataDoCoMocdmaActbase[8]];
    else
        $lang = trim($RedFMTataDoCoMocdmaActbase[8]);
    $RedFMTataDoCoMocdmaActiveBasedata = $view_date1 . "|" . trim($RedFMTataDoCoMocdmaActbase[0]) . "|" . trim($RedFMTataDoCoMocdmaActbase[1]) . "|" . trim($RedFMTataDoCoMocdmaActbase[2]) . "|" . trim($RedFMTataDoCoMocdmaActbase[3]) . "|" . trim($RedFMTataDoCoMocdmaActbase[4]) . "|" . trim($circle_info[$RedFMTataDoCoMocdmaActbase[5]]) . "|" . trim($RedFMTataDoCoMocdmaActbase[6]) . "|" . trim($RedFMTataDoCoMocdmaActbase[7]) . "|" . trim($lang) . "|" . trim($RedFMTataDoCoMocdmaActbase[15]) . '|' . trim($RedFMTataDoCoMocdmaActbase[15]) . '|' . trim($RedFMTataDoCoMocdmaActbase[15]) . "\r\n";
    error_log($RedFMTataDoCoMocdmaActiveBasedata, 3, $RedFMTataDoCoMocdmaFilePath);
}
$insertDump7 = 'LOAD DATA LOCAL INFILE "' . $RedFMTataDoCoMocdmaFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump7, $LivdbConn);

//////////////////////////////////////////////////// End RedFMTataDoCoMocdma/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start RIATataDoCoMocdma//////////////////////////////////////////////////////////////////////////
if ($operator == 'TataIndicom' && ($service_info == 'RIATataDoCoMocdma' || $service_info == 'ALL') && $upfor == 'active') {
    $RIATataDoCoMocdmaFile = "1609/RIATataDoCoMocdma_" . $fileDate . ".txt";
    $RIATataDoCoMocdmaFilePath = $activeDir . $RIATataDoCoMocdmaFile;

    if (file_exists($RIATataDoCoMocdmaFilePath)) {
        unlink($RIATataDoCoMocdmaFilePath);
        echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='RIATataDoCoMocdma' and status='Active'";
        $delquery = mysql_query($del1, $LivdbConn);
    }

    $getActiveBaseQ7 = "select 'RIATataDoCoMocdma',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from indicom_manchala.tbl_riya_subscription where status=1 and date(sub_date)<='" . $view_date1 . "'";
    $query7 = mysql_query($getActiveBaseQ7, $dbConn);
    while ($RIATataDoCoMocdmaActbase = mysql_fetch_array($query7)) {
        if ($circle_info[$RIATataDoCoMocdmaActbase[5]] == '')
            $RIATataDoCoMocdmaActbase[5] = 'Others';

        if ($languageData[trim($RIATataDoCoMocdmaActbase[8])] != '')
            $lang = $languageData[$RIATataDoCoMocdmaActbase[8]];
        else
            $lang = trim($RIATataDoCoMocdmaActbase[8]);
        $RIATataDoCoMocdmaActiveBasedata = $view_date1 . "|" . trim($RIATataDoCoMocdmaActbase[0]) . "|" . trim($RIATataDoCoMocdmaActbase[1]) . "|" . trim($RIATataDoCoMocdmaActbase[2]) . "|" . trim($RIATataDoCoMocdmaActbase[3]) . "|" . trim($RIATataDoCoMocdmaActbase[4]) . "|" . trim($circle_info[$RIATataDoCoMocdmaActbase[5]]) . "|" . trim($RIATataDoCoMocdmaActbase[6]) . "|" . trim($RIATataDoCoMocdmaActbase[7]) . "|" . trim($lang) . "|" . trim($RIATataDoCoMocdmaActbase[15]) . '|' . trim($RIATataDoCoMocdmaActbase[15]) . '|' . trim($RIATataDoCoMocdmaActbase[15]) . "\r\n";
        error_log($RIATataDoCoMocdmaActiveBasedata, 3, $RIATataDoCoMocdmaFilePath);
    }
    $insertDump8 = 'LOAD DATA LOCAL INFILE "' . $RIATataDoCoMocdmaFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    mysql_query($insertDump8, $LivdbConn);
}

//////////////////////////////////////////////////// End RIATataDoCoMocdma/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start TataDoCoMoFMJcdma//////////////////////////////////////////////////////////////////////////
if ($operator == 'TataIndicom' && ($service_info == 'TataDoCoMoFMJcdma' || $service_info == 'ALL') && $upfor == 'active') {
    $TataDoCoMoFMJcdmaFile = "1605/TataDoCoMoFMJcdma_" . $fileDate . ".txt";
    $TataDoCoMoFMJcdmaFilePath = $activeDir . $TataDoCoMoFMJcdmaFile;

    if (file_exists($TataDoCoMoFMJcdmaFilePath)) {
        unlink($TataDoCoMoFMJcdmaFilePath);
        echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='TataDoCoMoFMJcdma' and status='Active'";
        $delquery = mysql_query($del1, $LivdbConn);
    }

    $getActiveBaseQ7 = "select 'TataDoCoMoFMJcdma',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from indicom_starclub.tbl_jbox_subscription where status=1 and date(sub_date)<='" . $view_date1 . "'";
    $query7 = mysql_query($getActiveBaseQ7, $dbConn);
    while ($TataDoCoMoFMJcdmaActbase = mysql_fetch_array($query7)) {
        if ($circle_info[$TataDoCoMoFMJcdmaActbase[5]] == '')
            $TataDoCoMoFMJcdmaActbase[5] = 'Others';

        if ($languageData[trim($TataDoCoMoFMJcdmaActbase[8])] != '')
            $lang = $languageData[$TataDoCoMoFMJcdmaActbase[8]];
        else
            $lang = trim($TataDoCoMoFMJcdmaActbase[8]);
        $TataDoCoMoFMJcdmaActiveBasedata = $view_date1 . "|" . trim($TataDoCoMoFMJcdmaActbase[0]) . "|" . trim($TataDoCoMoFMJcdmaActbase[1]) . "|" . trim($TataDoCoMoFMJcdmaActbase[2]) . "|" . trim($TataDoCoMoFMJcdmaActbase[3]) . "|" . trim($TataDoCoMoFMJcdmaActbase[4]) . "|" . trim($circle_info[$TataDoCoMoFMJcdmaActbase[5]]) . "|" . trim($TataDoCoMoFMJcdmaActbase[6]) . "|" . trim($TataDoCoMoFMJcdmaActbase[7]) . "|" . trim($lang) . "|" . trim($TataDoCoMoFMJcdmaActbase[15]) . '|' . trim($TataDoCoMoFMJcdmaActbase[15]) . '|' . trim($TataDoCoMoFMJcdmaActbase[15]) . "\r\n";
        error_log($TataDoCoMoFMJcdmaActiveBasedata, 3, $TataDoCoMoFMJcdmaFilePath);
    }
    $insertDump9 = 'LOAD DATA LOCAL INFILE "' . $TataDoCoMoFMJcdmaFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    mysql_query($insertDump9, $LivdbConn);
}

//////////////////////////////////////////////////// End TataDoCoMoFMJcdma/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Pending RedFMTataDoCoMocdma//////////////////////////////////////////////////////////////////////////

$PRedFMTataDoCoMocdmaFile = "1610/PRedFMTataDoCoMocdma_" . $fileDate . ".txt";
$PRedFMTataDoCoMocdmaFilePath = $activeDir . $PRedFMTataDoCoMocdmaFile;

if (file_exists($PRedFMTataDoCoMocdmaFilePath)) {
    unlink($PRedFMTataDoCoMocdmaFilePath);
    echo $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='RedFMTataDoCoMocdma' and status='Pending'";
    $delquery = mysql_query($del, $LivdbConn);
}

$getPendingBaseQ7 = "select 'RedFMTataDoCoMocdma',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from indicom_redfm.tbl_jbox_subscription where status IN (11,0,5) and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getPendingBaseQ7, $dbConn);
while ($PRedFMTataDoCoMocdmaActbase = mysql_fetch_array($query7)) {
    if ($circle_info[$PRedFMTataDoCoMocdmaActbase[5]] == '')
        $PRedFMTataDoCoMocdmaActbase[5] = 'Others';

    if ($languageData[trim($PRedFMTataDoCoMocdmaActbase[8])] != '')
        $lang = $languageData[$PRedFMTataDoCoMocdmaActbase[8]];
    else
        $lang = trim($PRedFMTataDoCoMocdmaActbase[8]);
    $PRedFMTataDoCoMocdmaPendingBasedata = $view_date1 . "|" . trim($PRedFMTataDoCoMocdmaActbase[0]) . "|" . trim($PRedFMTataDoCoMocdmaActbase[1]) . "|" . trim($PRedFMTataDoCoMocdmaActbase[2]) . "|" . trim($PRedFMTataDoCoMocdmaActbase[3]) . "|" . trim($PRedFMTataDoCoMocdmaActbase[4]) . "|" . trim($circle_info[$PRedFMTataDoCoMocdmaActbase[5]]) . "|" . trim($PRedFMTataDoCoMocdmaActbase[6]) . "|" . trim($PRedFMTataDoCoMocdmaActbase[7]) . "|" . trim($lang) . "|" . trim($PRedFMTataDoCoMocdmaActbase[15]) . '|' . trim($PRedFMTataDoCoMocdmaActbase[15]) . '|' . trim($PRedFMTataDoCoMocdmaActbase[15]) . "\r\n";
    error_log($PRedFMTataDoCoMocdmaPendingBasedata, 3, $PRedFMTataDoCoMocdmaFilePath);
}
$insertDump10 = 'LOAD DATA LOCAL INFILE "' . $PRedFMTataDoCoMocdmaFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump10, $LivdbConn);


//////////////////////////////////////////////////// End Pending PRedFMTataDoCoMocdma/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Pending RIATataDoCoMocdma//////////////////////////////////////////////////////////////////////////
if ($operator == 'TataIndicom' && ($service_info == 'RIATataDoCoMocdma' || $service_info == 'ALL') && $upfor == 'pending') {
    $PRIATataDoCoMocdmaFile = "1609/PRIATataDoCoMocdma_" . $fileDate . ".txt";
    $PRIATataDoCoMocdmaFilePath = $activeDir . $PRIATataDoCoMocdmaFile;

    if (file_exists($PRIATataDoCoMocdmaFilePath)) {
        unlink($PRIATataDoCoMocdmaFilePath);
        echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='RIATataDoCoMocdma' and status='Pending'";
        $delquery = mysql_query($del1, $LivdbConn);
    }

    $getPendingBaseQ7 = "select 'RIATataDoCoMocdma',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from indicom_manchala.tbl_riya_subscription where status IN (11,0,5) and date(sub_date)<='" . $view_date1 . "'";
    $query7 = mysql_query($getPendingBaseQ7, $dbConn);
    while ($PRIATataDoCoMocdmaActbase = mysql_fetch_array($query7)) {
        if ($circle_info[$PRIATataDoCoMocdmaActbase[5]] == '')
            $PRIATataDoCoMocdmaActbase[5] = 'Others';

        if ($languageData[trim($PRIATataDoCoMocdmaActbase[8])] != '')
            $lang = $languageData[$PRIATataDoCoMocdmaActbase[8]];
        else
            $lang = trim($PRIATataDoCoMocdmaActbase[8]);
        $PRIATataDoCoMocdmaPendingBasedata = $view_date1 . "|" . trim($PRIATataDoCoMocdmaActbase[0]) . "|" . trim($PRIATataDoCoMocdmaActbase[1]) . "|" . trim($PRIATataDoCoMocdmaActbase[2]) . "|" . trim($PRIATataDoCoMocdmaActbase[3]) . "|" . trim($PRIATataDoCoMocdmaActbase[4]) . "|" . trim($circle_info[$PRIATataDoCoMocdmaActbase[5]]) . "|" . trim($PRIATataDoCoMocdmaActbase[6]) . "|" . trim($PRIATataDoCoMocdmaActbase[7]) . "|" . trim($lang) . "|" . trim($PRIATataDoCoMocdmaActbase[15]) . '|' . trim($PRIATataDoCoMocdmaActbase[15]) . '|' . trim($PRIATataDoCoMocdmaActbase[15]) . "\r\n";
        error_log($PRIATataDoCoMocdmaPendingBasedata, 3, $PRIATataDoCoMocdmaFilePath);
    }
    $insertDump11 = 'LOAD DATA LOCAL INFILE "' . $PRIATataDoCoMocdmaFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    mysql_query($insertDump11, $LivdbConn);
}

//////////////////////////////////////////////////// End Pending RIATataDoCoMocdma/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Pending TataDoCoMoFMJcdma//////////////////////////////////////////////////////////////////////////
if ($operator == 'TataIndicom' && ($service_info == 'TataDoCoMoFMJcdma' || $service_info == 'ALL') && $upfor == 'pending') {
    $PTataDoCoMoFMJcdmaFile = "1605/PTataDoCoMoFMJcdma_" . $fileDate . ".txt";
    $PTataDoCoMoFMJcdmaFilePath = $activeDir . $PTataDoCoMoFMJcdmaFile;

    if (file_exists($PTataDoCoMoFMJcdmaFilePath)) {
        unlink($PTataDoCoMoFMJcdmaFilePath);
        echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='TataDoCoMoFMJcdma' and status='Pending'";
        $delquery = mysql_query($del1, $LivdbConn);
    }

    $getPendingBaseQ7 = "select 'TataDoCoMoFMJcdma',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from indicom_starclub.tbl_jbox_subscription where status IN (11,0,5) and date(sub_date)<='" . $view_date1 . "'";
    $query7 = mysql_query($getPendingBaseQ7, $dbConn);
    while ($PTataDoCoMoFMJcdmaActbase = mysql_fetch_array($query7)) {
        if ($circle_info[$PTataDoCoMoFMJcdmaActbase[5]] == '')
            $PTataDoCoMoFMJcdmaActbase[5] = 'Others';

        if ($languageData[trim($PTataDoCoMoFMJcdmaActbase[8])] != '')
            $lang = $languageData[$PTataDoCoMoFMJcdmaActbase[8]];
        else
            $lang = trim($PTataDoCoMoFMJcdmaActbase[8]);
        $PTataDoCoMoFMJcdmaPendingBasedata = $view_date1 . "|" . trim($PTataDoCoMoFMJcdmaActbase[0]) . "|" . trim($PTataDoCoMoFMJcdmaActbase[1]) . "|" . trim($PTataDoCoMoFMJcdmaActbase[2]) . "|" . trim($PTataDoCoMoFMJcdmaActbase[3]) . "|" . trim($PTataDoCoMoFMJcdmaActbase[4]) . "|" . trim($circle_info[$PTataDoCoMoFMJcdmaActbase[5]]) . "|" . trim($PTataDoCoMoFMJcdmaActbase[6]) . "|" . trim($PTataDoCoMoFMJcdmaActbase[7]) . "|" . trim($lang) . "|" . trim($PTataDoCoMoFMJcdmaActbase[15]) . '|' . trim($PTataDoCoMoFMJcdmaActbase[15]) . '|' . trim($PTataDoCoMoFMJcdmaActbase[15]) . "\r\n";
        error_log($PTataDoCoMoFMJcdmaPendingBasedata, 3, $PTataDoCoMoFMJcdmaFilePath);
    }
    $insertDump12 = 'LOAD DATA LOCAL INFILE "' . $PTataDoCoMoFMJcdmaFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    mysql_query($insertDump12, $LivdbConn);
}

//////////////////////////////////////////////////// End Pending TataDoCoMoFMJcdma/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start TataDoCoMoMXcdma//////////////////////////////////////////////////////////////////////////
if ($operator == 'TataIndicom' && ($service_info == 'TataDoCoMoMXcdma' || $service_info == 'ALL') && $upfor == 'active') {
    $TataDoCoMoMXcdmaFile = "1601/TataDoCoMoMXcdma_" . $fileDate . ".txt";
    $TataDoCoMoMXcdmaFilePath = $activeDir . $TataDoCoMoMXcdmaFile;

    if (file_exists($TataDoCoMoMXcdmaFilePath)) {
        unlink($TataDoCoMoMXcdmaFilePath);
        echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='TataDoCoMoMXcdma' and status='Active'";
        $delquery = mysql_query($del1, $LivdbConn);
    }

    $getActiveBaseQ7 = "select 'TataDoCoMoMXcdma',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from indicom_radio.tbl_radio_subscription where status=1 and date(sub_date)<='" . $view_date1 . "'";
    $query7 = mysql_query($getActiveBaseQ7, $dbConn);
    while ($TataDoCoMoMXcdmaActbase = mysql_fetch_array($query7)) {
        if ($circle_info[$TataDoCoMoMXcdmaActbase[5]] == '')
            $TataDoCoMoMXcdmaActbase[5] = 'Others';

        if ($languageData[trim($TataDoCoMoMXcdmaActbase[8])] != '')
            $lang = $languageData[$TataDoCoMoMXcdmaActbase[8]];
        else
            $lang = trim($TataDoCoMoMXcdmaActbase[8]);
        $TataDoCoMoMXcdmaActiveBasedata = $view_date1 . "|" . trim($TataDoCoMoMXcdmaActbase[0]) . "|" . trim($TataDoCoMoMXcdmaActbase[1]) . "|" . trim($TataDoCoMoMXcdmaActbase[2]) . "|" . trim($TataDoCoMoMXcdmaActbase[3]) . "|" . trim($TataDoCoMoMXcdmaActbase[4]) . "|" . trim($circle_info[$TataDoCoMoMXcdmaActbase[5]]) . "|" . trim($TataDoCoMoMXcdmaActbase[6]) . "|" . trim($TataDoCoMoMXcdmaActbase[7]) . "|" . trim($lang) . "|" . trim($TataDoCoMoMXcdmaActbase[15]) . '|' . trim($TataDoCoMoMXcdmaActbase[15]) . '|' . trim($TataDoCoMoMXcdmaActbase[15]) . "\r\n";
        error_log($TataDoCoMoMXcdmaActiveBasedata, 3, $TataDoCoMoMXcdmaFilePath);
    }
    $insertDump9 = 'LOAD DATA LOCAL INFILE "' . $TataDoCoMoMXcdmaFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    mysql_query($insertDump9, $LivdbConn);
}

//////////////////////////////////////////////////// End TataDoCoMoMXcdma/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Pending TataDoCoMoMXcdma//////////////////////////////////////////////////////////////////////////
if ($operator == 'TataIndicom' && ($service_info == 'TataDoCoMoMXcdma' || $service_info == 'ALL') && $upfor == 'pending') {
    $PTataDoCoMoMXcdmaFile = "1601/PTataDoCoMoMXcdma_" . $fileDate . ".txt";
    $PTataDoCoMoMXcdmaFilePath = $activeDir . $PTataDoCoMoMXcdmaFile;

    if (file_exists($PTataDoCoMoMXcdmaFilePath)) {
        unlink($PTataDoCoMoMXcdmaFilePath);
        echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='TataDoCoMoMXcdma' and status='Pending'";
        $delquery = mysql_query($del1, $LivdbConn);
    }

    $getPendingBaseQ7 = "select 'TataDoCoMoMXcdma',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from indicom_radio.tbl_radio_subscription where status IN (11,0,5) and date(sub_date)<='" . $view_date1 . "'";
    $query7 = mysql_query($getPendingBaseQ7, $dbConn);
    while ($PTataDoCoMoMXcdmaActbase = mysql_fetch_array($query7)) {
        if ($circle_info[$PTataDoCoMoMXcdmaActbase[5]] == '')
            $PTataDoCoMoMXcdmaActbase[5] = 'Others';

        if ($languageData[trim($PTataDoCoMoMXcdmaActbase[8])] != '')
            $lang = $languageData[$PTataDoCoMoMXcdmaActbase[8]];
        else
            $lang = trim($PTataDoCoMoMXcdmaActbase[8]);
        $PTataDoCoMoMXcdmaPendingBasedata = $view_date1 . "|" . trim($PTataDoCoMoMXcdmaActbase[0]) . "|" . trim($PTataDoCoMoMXcdmaActbase[1]) . "|" . trim($PTataDoCoMoMXcdmaActbase[2]) . "|" . trim($PTataDoCoMoMXcdmaActbase[3]) . "|" . trim($PTataDoCoMoMXcdmaActbase[4]) . "|" . trim($circle_info[$PTataDoCoMoMXcdmaActbase[5]]) . "|" . trim($PTataDoCoMoMXcdmaActbase[6]) . "|" . trim($PTataDoCoMoMXcdmaActbase[7]) . "|" . trim($lang) . "|" . trim($PTataDoCoMoMXcdmaActbase[15]) . '|' . trim($PTataDoCoMoMXcdmaActbase[15]) . '|' . trim($PTataDoCoMoMXcdmaActbase[15]) . "\r\n";
        error_log($PTataDoCoMoMXcdmaPendingBasedata, 3, $PTataDoCoMoMXcdmaFilePath);
    }
    $insertDump12 = 'LOAD DATA LOCAL INFILE "' . $PTataDoCoMoMXcdmaFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    mysql_query($insertDump12, $LivdbConn);
}

//////////////////////////////////////////////////// End Pending TataDoCoMoMXcdma/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start TataIndicom54646//////////////////////////////////////////////////////////////////////////
if ($operator == 'TataIndicom' && ($service_info == 'TataIndicom54646' || $service_info == 'ALL') && $upfor == 'active') {
    $TataIndicom54646File = "1602/TataIndicom54646_" . $fileDate . ".txt";
    $TataIndicom54646FilePath = $activeDir . $TataIndicom54646File;

    if (file_exists($TataIndicom54646FilePath)) {
        unlink($TataIndicom54646FilePath);
        echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='TataIndicom54646' and status='Active'";
        $delquery = mysql_query($del1, $LivdbConn);
    }

    $getActiveBaseQ7 = "select 'TataIndicom54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from indicom_hungama.tbl_jbox_subscription where status=1 and plan_id!='97' and date(sub_date)<='" . $view_date1 . "'";
    $query7 = mysql_query($getActiveBaseQ7, $dbConn);
    while ($TataIndicom54646Actbase = mysql_fetch_array($query7)) {
        if ($circle_info[$TataIndicom54646Actbase[5]] == '')
            $TataIndicom54646Actbase[5] = 'Others';

        if ($languageData[trim($TataIndicom54646Actbase[8])] != '')
            $lang = $languageData[$TataIndicom54646Actbase[8]];
        else
            $lang = trim($TataIndicom54646Actbase[8]);
        $TataIndicom54646ActiveBasedata = $view_date1 . "|" . trim($TataIndicom54646Actbase[0]) . "|" . trim($TataIndicom54646Actbase[1]) . "|" . trim($TataIndicom54646Actbase[2]) . "|" . trim($TataIndicom54646Actbase[3]) . "|" . trim($TataIndicom54646Actbase[4]) . "|" . trim($circle_info[$TataIndicom54646Actbase[5]]) . "|" . trim($TataIndicom54646Actbase[6]) . "|" . trim($TataIndicom54646Actbase[7]) . "|" . trim($lang) . "|" . trim($TataIndicom54646Actbase[15]) . '|' . trim($TataIndicom54646Actbase[15]) . '|' . trim($TataIndicom54646Actbase[15]) . "\r\n";
        error_log($TataIndicom54646ActiveBasedata, 3, $TataIndicom54646FilePath);
    }
    $insertDump9 = 'LOAD DATA LOCAL INFILE "' . $TataIndicom54646FilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    mysql_query($insertDump9, $LivdbConn);
}

//////////////////////////////////////////////////// End TataIndicom54646/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Pending TataIndicom54646//////////////////////////////////////////////////////////////////////////
if ($operator == 'TataIndicom' && ($service_info == 'TataIndicom54646' || $service_info == 'ALL') && $upfor == 'pending') {
    $PTataIndicom54646File = "1602/PTataIndicom54646_" . $fileDate . ".txt";
    $PTataIndicom54646FilePath = $activeDir . $PTataIndicom54646File;

    if (file_exists($PTataIndicom54646FilePath)) {
        unlink($PTataIndicom54646FilePath);
        echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='TataIndicom54646' and status='Pending'";
        $delquery = mysql_query($del1, $LivdbConn);
    }

    $getPendingBaseQ7 = "select 'TataIndicom54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from indicom_hungama.tbl_jbox_subscription where status IN (11,0,5) and plan_id!='97' and date(sub_date)<='" . $view_date1 . "'";
    $query7 = mysql_query($getPendingBaseQ7, $dbConn);
    while ($PTataIndicom54646Actbase = mysql_fetch_array($query7)) {
        if ($circle_info[$PTataIndicom54646Actbase[5]] == '')
            $PTataIndicom54646Actbase[5] = 'Others';

        if ($languageData[trim($PTataIndicom54646Actbase[8])] != '')
            $lang = $languageData[$PTataIndicom54646Actbase[8]];
        else
            $lang = trim($PTataIndicom54646Actbase[8]);
        $PTataIndicom54646PendingBasedata = $view_date1 . "|" . trim($PTataIndicom54646Actbase[0]) . "|" . trim($PTataIndicom54646Actbase[1]) . "|" . trim($PTataIndicom54646Actbase[2]) . "|" . trim($PTataIndicom54646Actbase[3]) . "|" . trim($PTataIndicom54646Actbase[4]) . "|" . trim($circle_info[$PTataIndicom54646Actbase[5]]) . "|" . trim($PTataIndicom54646Actbase[6]) . "|" . trim($PTataIndicom54646Actbase[7]) . "|" . trim($lang) . "|" . trim($PTataIndicom54646Actbase[15]) . '|' . trim($PTataIndicom54646Actbase[15]) . '|' . trim($PTataIndicom54646Actbase[15]) . "\r\n";
        error_log($PTataIndicom54646PendingBasedata, 3, $PTataIndicom54646FilePath);
    }
    $insertDump12 = 'LOAD DATA LOCAL INFILE "' . $PTataIndicom54646FilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    mysql_query($insertDump12, $LivdbConn);
}

//////////////////////////////////////////////////// End Pending TataIndicom54646/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start AATataDoCoMocdma//////////////////////////////////////////////////////////////////////////

$AATataDoCoMocdmaFile = "1602/AATataDoCoMocdma_" . $fileDate . ".txt";
$AATataDoCoMocdmaFilePath = $activeDir . $AATataDoCoMocdmaFile;

if (file_exists($AATataDoCoMocdmaFilePath)) {
    unlink($AATataDoCoMocdmaFilePath);
    echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='AATataDoCoMocdma' and status='Active'";
    $delquery = mysql_query($del1, $LivdbConn);
}

$getActiveBaseQ7 = "select 'AATataDoCoMocdma',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from indicom_hungama.tbl_jbox_subscription where status=1 and plan_id='97' and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getActiveBaseQ7, $dbConn);
while ($AATataDoCoMocdmaActbase = mysql_fetch_array($query7)) {
    if ($circle_info[$AATataDoCoMocdmaActbase[5]] == '')
        $AATataDoCoMocdmaActbase[5] = 'Others';

    if ($languageData[trim($AATataDoCoMocdmaActbase[8])] != '')
        $lang = $languageData[$AATataDoCoMocdmaActbase[8]];
    else
        $lang = trim($AATataDoCoMocdmaActbase[8]);
    $AATataDoCoMocdmaActiveBasedata = $view_date1 . "|" . trim($AATataDoCoMocdmaActbase[0]) . "|" . trim($AATataDoCoMocdmaActbase[1]) . "|" . trim($AATataDoCoMocdmaActbase[2]) . "|" . trim($AATataDoCoMocdmaActbase[3]) . "|" . trim($AATataDoCoMocdmaActbase[4]) . "|" . trim($circle_info[$AATataDoCoMocdmaActbase[5]]) . "|" . trim($AATataDoCoMocdmaActbase[6]) . "|" . trim($AATataDoCoMocdmaActbase[7]) . "|" . trim($lang) . "|" . trim($AATataDoCoMocdmaActbase[15]) . '|' . trim($AATataDoCoMocdmaActbase[15]) . '|' . trim($AATataDoCoMocdmaActbase[15]) . "\r\n";
    error_log($AATataDoCoMocdmaActiveBasedata, 3, $AATataDoCoMocdmaFilePath);
}
$insertDump9 = 'LOAD DATA LOCAL INFILE "' . $AATataDoCoMocdmaFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump9, $LivdbConn);


//////////////////////////////////////////////////// End AATataDoCoMocdma/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Pending AATataDoCoMocdma//////////////////////////////////////////////////////////////////////////

$PAATataDoCoMocdmaFile = "1602/PAATataDoCoMocdma_" . $fileDate . ".txt";
$PAATataDoCoMocdmaFilePath = $activeDir . $PAATataDoCoMocdmaFile;

if (file_exists($PAATataDoCoMocdmaFilePath)) {
    unlink($PAATataDoCoMocdmaFilePath);
    echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='AATataDoCoMocdma' and status='Pending'";
    $delquery = mysql_query($del1, $LivdbConn);
}

$getPendingBaseQ7 = "select 'AATataDoCoMocdma',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from indicom_hungama.tbl_jbox_subscription where status IN (11,0,5) and plan_id='97' and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getPendingBaseQ7, $dbConn);
while ($PAATataDoCoMocdmaActbase = mysql_fetch_array($query7)) {
    if ($circle_info[$PAATataDoCoMocdmaActbase[5]] == '')
        $PAATataDoCoMocdmaActbase[5] = 'Others';

    if ($languageData[trim($PAATataDoCoMocdmaActbase[8])] != '')
        $lang = $languageData[$PAATataDoCoMocdmaActbase[8]];
    else
        $lang = trim($PAATataDoCoMocdmaActbase[8]);
    $PAATataDoCoMocdmaPendingBasedata = $view_date1 . "|" . trim($PAATataDoCoMocdmaActbase[0]) . "|" . trim($PAATataDoCoMocdmaActbase[1]) . "|" . trim($PAATataDoCoMocdmaActbase[2]) . "|" . trim($PAATataDoCoMocdmaActbase[3]) . "|" . trim($PAATataDoCoMocdmaActbase[4]) . "|" . trim($circle_info[$PAATataDoCoMocdmaActbase[5]]) . "|" . trim($PAATataDoCoMocdmaActbase[6]) . "|" . trim($PAATataDoCoMocdmaActbase[7]) . "|" . trim($lang) . "|" . trim($PAATataDoCoMocdmaActbase[15]) . '|' . trim($PAATataDoCoMocdmaActbase[15]) . '|' . trim($PAATataDoCoMocdmaActbase[15]) . "\r\n";
    error_log($PAATataDoCoMocdmaPendingBasedata, 3, $PAATataDoCoMocdmaFilePath);
}
$insertDump12 = 'LOAD DATA LOCAL INFILE "' . $PAATataDoCoMocdmaFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump12, $LivdbConn);


//////////////////////////////////////////////////// End Pending AATataDoCoMocdma/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start TataDoCoMoMNDcdma//////////////////////////////////////////////////////////////////////////

$TataDoCoMoMNDcdmaFile = "1613/TataDoCoMoMNDcdma_" . $fileDate . ".txt";
$TataDoCoMoMNDcdmaFilePath = $activeDir . $TataDoCoMoMNDcdmaFile;

if (file_exists($TataDoCoMoMNDcdmaFilePath)) {
    unlink($TataDoCoMoMNDcdmaFilePath);
    echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='TataDoCoMoMNDcdma' and status='Active'";
    $delquery = mysql_query($del1, $LivdbConn);
}

$getActiveBaseQ7 = "select 'TataDoCoMoMNDcdma',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from indicom_mnd.tbl_character_subscription1 where status=1 and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getActiveBaseQ7, $dbConn);
while ($TataDoCoMoMNDcdmaActbase = mysql_fetch_array($query7)) {
    if ($circle_info[$TataDoCoMoMNDcdmaActbase[5]] == '')
        $TataDoCoMoMNDcdmaActbase[5] = 'Others';

    if ($languageData[trim($TataDoCoMoMNDcdmaActbase[8])] != '')
        $lang = $languageData[$TataDoCoMoMNDcdmaActbase[8]];
    else
        $lang = trim($TataDoCoMoMNDcdmaActbase[8]);
    $TataDoCoMoMNDcdmaActiveBasedata = $view_date1 . "|" . trim($TataDoCoMoMNDcdmaActbase[0]) . "|" . trim($TataDoCoMoMNDcdmaActbase[1]) . "|" . trim($TataDoCoMoMNDcdmaActbase[2]) . "|" . trim($TataDoCoMoMNDcdmaActbase[3]) . "|" . trim($TataDoCoMoMNDcdmaActbase[4]) . "|" . trim($circle_info[$TataDoCoMoMNDcdmaActbase[5]]) . "|" . trim($TataDoCoMoMNDcdmaActbase[6]) . "|" . trim($TataDoCoMoMNDcdmaActbase[7]) . "|" . trim($lang) . "|" . trim($TataDoCoMoMNDcdmaActbase[15]) . '|' . trim($TataDoCoMoMNDcdmaActbase[15]) . '|' . trim($TataDoCoMoMNDcdmaActbase[15]) . "\r\n";
    error_log($TataDoCoMoMNDcdmaActiveBasedata, 3, $TataDoCoMoMNDcdmaFilePath);
}
$insertDump9 = 'LOAD DATA LOCAL INFILE "' . $TataDoCoMoMNDcdmaFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump9, $LivdbConn);


//////////////////////////////////////////////////// End TataDoCoMoMNDcdma/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Pending TataDoCoMoMNDcdma//////////////////////////////////////////////////////////////////////////

$PTataDoCoMoMNDcdmaFile = "1613/PTataDoCoMoMNDcdma_" . $fileDate . ".txt";
$PTataDoCoMoMNDcdmaFilePath = $activeDir . $PTataDoCoMoMNDcdmaFile;

if (file_exists($PTataDoCoMoMNDcdmaFilePath)) {
    unlink($PTataDoCoMoMNDcdmaFilePath);
    echo $del1 = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='TataDoCoMoMNDcdma' and status='Pending'";
    $delquery = mysql_query($del1, $LivdbConn);
}

$getPendingBaseQ7 = "select 'TataDoCoMoMNDcdma',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from indicom_mnd.tbl_character_subscription1 where status!=1 and date(sub_date)<='" . $view_date1 . "'";
$query7 = mysql_query($getPendingBaseQ7, $dbConn);
while ($PTataDoCoMoMNDcdmaActbase = mysql_fetch_array($query7)) {
    if ($circle_info[$PTataDoCoMoMNDcdmaActbase[5]] == '')
        $PTataDoCoMoMNDcdmaActbase[5] = 'Others';

    if ($languageData[trim($PTataDoCoMoMNDcdmaActbase[8])] != '')
        $lang = $languageData[$PTataDoCoMoMNDcdmaActbase[8]];
    else
        $lang = trim($PTataDoCoMoMNDcdmaActbase[8]);
    $PTataDoCoMoMNDcdmaPendingBasedata = $view_date1 . "|" . trim($PTataDoCoMoMNDcdmaActbase[0]) . "|" . trim($PTataDoCoMoMNDcdmaActbase[1]) . "|" . trim($PTataDoCoMoMNDcdmaActbase[2]) . "|" . trim($PTataDoCoMoMNDcdmaActbase[3]) . "|" . trim($PTataDoCoMoMNDcdmaActbase[4]) . "|" . trim($circle_info[$PTataDoCoMoMNDcdmaActbase[5]]) . "|" . trim($PTataDoCoMoMNDcdmaActbase[6]) . "|" . trim($PTataDoCoMoMNDcdmaActbase[7]) . "|" . trim($lang) . "|" . trim($PTataDoCoMoMNDcdmaActbase[15]) . '|' . trim($PTataDoCoMoMNDcdmaActbase[15]) . '|' . trim($PTataDoCoMoMNDcdmaActbase[15]) . "\r\n";
    error_log($PTataDoCoMoMNDcdmaPendingBasedata, 3, $PTataDoCoMoMNDcdmaFilePath);
}
$insertDump12 = 'LOAD DATA LOCAL INFILE "' . $PTataDoCoMoMNDcdmaFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
mysql_query($insertDump12, $LivdbConn);


//////////////////////////////////////////////////// End Pending TataDoCoMoMNDcdma/////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////

mysql_close($dbConn);
mysql_close($LivdbConn);
?>
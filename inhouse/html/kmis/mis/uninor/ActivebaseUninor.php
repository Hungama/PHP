<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$fview_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

//$activeDir = "/var/www/html/kmis/testing/activeBase/";
$activeDir = "/var/www/html/kmis/mis/uninor/basedump/";
$processlog = "/var/www/html/kmis/mis/uninor/basedump/logs/processlog_active_" . date(Ymd) . ".txt";

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'UND' => 'Others', 'Others' => 'Others');
$languageData = array('01' => 'Hindi', '02' => 'English', '03' => 'Punjabi', '04' => 'Bhojpuri', '05' => 'Haryanavi', '06' => 'Bengali', '07' => 'Tamil', '08' => 'Telugu', '09' => 'Malayalam', '10' => 'Kannada', '11' => 'Marathi', '12' => 'Gujarati', '13' => 'Oriya', '14' => 'Kashmiri', '15' => 'Himachali', '16' => 'Chhattisgarhi', '17' => 'Assamese', '18' => 'Rajasthani', '19' => 'Nepali', '20' => 'Kumaoni', '21' => 'Maithali', '99' => 'Hindi');
function getServiceNameID($sname,$LivdbConn)
{
$getSId = "select misdata.servicetoint('".$sname."');";
$result = mysql_query($getSId, $LivdbConn);
$outpout = mysql_fetch_row($result);
echo $outpout[0];
}


$uninorMTVFile = "1403/UninorMTV_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;
$file_process_status = '***************Script start for MTVUninor******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('MTVUninor',$LivdbConn);
if (file_exists($uninorMTVFilePath)) {
    unlink($uninorMTVFilePath);
     $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    }

$getActiveBaseQ = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',replace(replace(def_lang,'01','HIN'),'99','HIN') from uninor_hungama.tbl_mtv_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
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
///////////////// End Uninor MTV/////////////
/////// Start Uninor Redfm////////////////////
$uniREDFMFile = "1410/UninorREDFM_" . $fileDate . ".txt";
$uniREDFMFilePath = $activeDir . $uniREDFMFile;
$file_process_status = '***************Script start for RedFMUninor******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('RedFMUninor',$LivdbConn);
if (file_exists($uniREDFMFilePath)) {
    unlink($uniREDFMFilePath);
	$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    }

$getActiveBaseQ1 = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_redfm.tbl_jbox_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
$query1 = mysql_query($getActiveBaseQ1, $dbConn);
$numRows1 = mysql_num_rows($query1);
if ($numRows1 > 0) {
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
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump1 = 'LOAD DATA LOCAL INFILE "' . $uniREDFMFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
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
///////////////////// End Uninor Redfm////////////////////////
/////////////// Start Uninor Ria///////////////////////


$uniRIAFile = "1409/UninorRia_" . $fileDate . ".txt";
$uniRIAFilePath = $activeDir . $uniRIAFile;
$file_process_status = '***************Script start for RIAUninor******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('RIAUninor',$LivdbConn);
if (file_exists($uniRIAFilePath)) {
    unlink($uniRIAFilePath);
    $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
  }
//uninor_manchala.tbl_riya_subscription
$getActiveBaseQ3 = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_mnd.tbl_character_subscription1 nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
$query3 = mysql_query($getActiveBaseQ3, $dbConn);
$numRows1 = mysql_num_rows($query3);
if ($numRows1 > 0) {
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
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump2 = 'LOAD DATA LOCAL INFILE "' . $uniRIAFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
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

///////////////// End Uninor Ria///////////////////
//////////////// Start Uninor 54646///////////////

$uni54646File = "1402/uni54646_" . $fileDate . ".txt";
$uni54646FilePath = $activeDir . $uni54646File;
$file_process_status = '***************Script start for Uninor54646******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('Uninor54646',$LivdbConn);
if (file_exists($uni54646FilePath)) {
    unlink($uni54646FilePath);
	$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
}

$getActiveBaseQ4 = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_hungama.tbl_jbox_subscription nolock where status=1 and dnis not like '%P%' and plan_id!=95 and date(sub_date)<='" . $view_date1 . "'";
$query4 = mysql_query($getActiveBaseQ4, $dbConn);
$numRows1 = mysql_num_rows($query4);
if ($numRows1 > 0) {
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
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump3 = 'LOAD DATA LOCAL INFILE "' . $uni54646FilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';

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
//////////////////// End Uninor 54646//////////////////
//////////////////// Start Uninor Artist Aloud/////////////

$uniAAFile = "1402/AAUninor_" . $fileDate . ".txt";
$uniAAFilePath = $activeDir . $uniAAFile;
$file_process_status = '***************Script start for AAUninor ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('AAUninor',$LivdbConn);
if (file_exists($uniAAFilePath)) {
    unlink($uniAAFilePath);
    $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    }

$getActiveBaseQ5 = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_hungama.tbl_Artist_Aloud_subscription nolock where status in (1) and plan_id=95 and date(sub_date)<='" . $view_date1 . "'";
$query5 = mysql_query($getActiveBaseQ5, $dbConn);
$numRows1 = mysql_num_rows($query5);
if ($numRows1 > 0) {
    
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
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump5 = 'LOAD DATA LOCAL INFILE "' . $uniAAFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
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
/////////// End  Uninor Artist Aloud///////////////////
/////////////////////// Start Uninor JAD///////////

$uniJADFile = "1416/UninorAstro_" . $fileDate . ".txt";
$uniJADFilePath = $activeDir . $uniJADFile;
$file_process_status = '***************Script start for UninorAstro ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('UninorAstro',$LivdbConn);
if (file_exists($uniJADFilePath)) {
    unlink($uniJADFilePath);
    $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    }

$getActiveBaseQ6 = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_jyotish.tbl_jyotish_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
$query6 = mysql_query($getActiveBaseQ6, $dbConn);
$numRows1 = mysql_num_rows($query6);
if ($numRows1 > 0) {
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
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump6 = 'LOAD DATA LOCAL INFILE "' . $uniJADFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
    
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
////////////////////// End  Uninor JAD//////////////////////////////
///////////////////// Start UninorSU /////////////////////////////

$UninorSUFile = "1408/UninorSU_" . $fileDate . ".txt";
$UninorSUFilePath = $activeDir . $UninorSUFile;
$file_process_status = '***************Script start for UninorSU ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('UninorSU',$LivdbConn);
if (file_exists($UninorSUFilePath)) {
    unlink($UninorSUFilePath);
    $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    
}

$getActiveBaseQ6 = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_cricket.tbl_cricket_subscription nolock where status IN (1) and date(sub_date)<='" . $view_date1 . "'";
$query6 = mysql_query($getActiveBaseQ6, $dbConn);
$numRows1 = mysql_num_rows($query6);
if ($numRows1 > 0) {
    
    while ($UninorSUActbase = mysql_fetch_array($query6)) {
        if ($circle_info[$UninorSUActbase[5]] == '')
            $UninorSUActbase[5] = 'Others';

        if ($languageData[trim($UninorSUActbase[8])] != '')
            $lang = $languageData[$UninorSUActbase[8]];
        else
            $lang = trim($UninorSUActbase[8]);
        $UninorSUActiveBasedata = $view_date1 . "|" . trim($UninorSUActbase[0]) . "|" . trim($UninorSUActbase[1]) . "|" . trim($UninorSUActbase[2]) . "|" . trim($UninorSUActbase[3]) . "|" . trim($UninorSUActbase[4]) . "|" . trim($circle_info[$UninorSUActbase[5]]) . "|" . trim($UninorSUActbase[6]) . "|" . trim($UninorSUActbase[7]) . "|" . trim($lang) . "\r\n";
        error_log($UninorSUActiveBasedata, 3, $UninorSUFilePath);
    }
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

    $insertDump6 = 'LOAD DATA LOCAL INFILE "' . $UninorSUFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
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
//////////////////////// End  UninorSU/////////////////////
/////////////////// Start UninorComedy ///////////////////

$UninorComedyFile = "1418/UninorComedy_" . $fileDate . ".txt";
$UninorComedyFilePath = $activeDir . $UninorComedyFile;
$file_process_status = '***************Script start for UninorComedy ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('UninorComedy',$LivdbConn);
if (file_exists($UninorComedyFilePath)) {
    unlink($UninorComedyFilePath);
    $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    }

$getActiveBaseQ6 = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_hungama.tbl_comedy_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
$query6 = mysql_query($getActiveBaseQ6, $dbConn);
$numRows1 = mysql_num_rows($query6);
if ($numRows1 > 0) {
     while ($UninorComedyActbase = mysql_fetch_array($query6)) {
        if ($circle_info[$UninorComedyActbase[5]] == '')
            $UninorComedyActbase[5] = 'Others';

        if ($languageData[trim($UninorComedyActbase[8])] != '')
            $lang = $languageData[$UninorComedyActbase[8]];
        else
            $lang = trim($UninorComedyActbase[8]);
        $UninorComedyActiveBasedata = $view_date1 . "|" . trim($UninorComedyActbase[0]) . "|" . trim($UninorComedyActbase[1]) . "|" . trim($UninorComedyActbase[2]) . "|" . trim($UninorComedyActbase[3]) . "|" . trim($UninorComedyActbase[4]) . "|" . trim($circle_info[$UninorComedyActbase[5]]) . "|" . trim($UninorComedyActbase[6]) . "|" . trim($UninorComedyActbase[7]) . "|" . trim($lang) . "\r\n";
        error_log($UninorComedyActiveBasedata, 3, $UninorComedyFilePath);
    }
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump6 = 'LOAD DATA LOCAL INFILE "' . $UninorComedyFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
    if (mysql_query($insertDump6, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for UninorComedy******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
//////////////////// End  Uninor JAD//////////////////
//////////////////// Start UninorContest ///////////

$UninorContestFile = "1423/UninorContest_" . $fileDate . ".txt";
$UninorContestFilePath = $activeDir . $UninorContestFile;
$file_process_status = '***************Script start for UninorContest ******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('UninorContest',$LivdbConn);
if (file_exists($UninorContestFilePath)) {
    unlink($UninorContestFilePath);
   $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    }

$getActiveBaseQ6 = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),score,'Active',def_lang,Rank from uninor_summer_contest.tbl_contest_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
$query6 = mysql_query($getActiveBaseQ6, $dbConn);
$numRows1 = mysql_num_rows($query6);
if ($numRows1 > 0) {
    while ($UninorContestActbase = mysql_fetch_array($query6)) {
        if ($circle_info[$UninorContestActbase[5]] == '')
            $UninorContestActbase[5] = 'Others';

        if ($languageData[trim($UninorContestActbase[8])] != '')
            $lang = $languageData[$UninorContestActbase[8]];
        else
            $lang = trim($UninorContestActbase[8]);
        $UninorContestActiveBasedata = $view_date1 . "|" . trim($UninorContestActbase[0]) . "|" . trim($UninorContestActbase[1]) . "|" . trim($UninorContestActbase[2]) . "|" . trim($UninorContestActbase[3]) . "|" . trim($UninorContestActbase[4]) . "|" . trim($circle_info[$UninorContestActbase[5]]) . "|" . trim($UninorContestActbase[6]) . "|" . trim($UninorContestActbase[7]) . "|" . trim($lang) . "|" . trim($UninorContestActbase[9]) . "\r\n";
        error_log($UninorContestActiveBasedata, 3, $UninorContestFilePath);
    }
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump6 = 'LOAD DATA LOCAL INFILE "' . $UninorContestFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion)';
    
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
//////////////////////// End  Uninor Contest/////////
////////////////////////Start UninorVABollyAlerts//////////////


$uninorMTVFile = "1430/UninorMTV_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;

$file_process_status = '***************Script start for UninorVABollyAlerts******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('UninorVABollyAlerts',$LivdbConn);
if (file_exists($uninorMTVFilePath)) {
    unlink($uninorMTVFilePath);
    $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    }

$getActiveBaseQ = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',replace(replace(def_lang,'01','HIN'),'99','HIN')
    from Uninor_BollyAlerts.tbl_BA_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
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
////////////////// End UninorVABollyAlerts/////////////
//////////Start UninorVABollyMasala////////////

$uninorMTVFile = "1432/UninorMTV_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;

$file_process_status = '***************Script start for UninorVABollyMasala******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('UninorVABollyMasala',$LivdbConn);
if (file_exists($uninorMTVFilePath)) {
    unlink($uninorMTVFilePath);
	$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    
}

$getActiveBaseQ = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',replace(replace(def_lang,'01','HIN'),'99','HIN')
    from Uninor_BollywoodMasala.tbl_BM_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
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
////////////////// End UninorVABollyMasala////////////
////////////////Start UninorVAFashion//////////////

$uninorMTVFile = "1434/UninorMTV_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;

$file_process_status = '***************Script start for UninorVAFashion******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('UninorVAFashion',$LivdbConn);
if (file_exists($uninorMTVFilePath)) {
    unlink($uninorMTVFilePath);
    $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    
}

$getActiveBaseQ = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',replace(replace(def_lang,'01','HIN'),'99','HIN') 
    from Uninor_CelebrityFashion.tbl_CF_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
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
//////////////////// End UninorVAFashion///////////////
/////////////Start UninorVAFilmy//////////

$uninorMTVFile = "1431/UninorMTV_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;

$file_process_status = '***************Script start for UninorVAFilmy******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('UninorVAFilmy',$LivdbConn);
if (file_exists($uninorMTVFilePath)) {
    unlink($uninorMTVFilePath);
   $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
  
}

$getActiveBaseQ = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',replace(replace(def_lang,'01','HIN'),'99','HIN') 
    from Uninor_FilmiWords.tbl_FW_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
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
////////////// End UninorVAFilmy////////////
/////////////Start UninorVAHealth////////

$uninorMTVFile = "1433/UninorMTV_" . $fileDate . ".txt";
$uninorMTVFilePath = $activeDir . $uninorMTVFile;

$file_process_status = '***************Script start for UninorVAHealth******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('UninorVAHealth',$LivdbConn);
if (file_exists($uninorMTVFilePath)) {
    unlink($uninorMTVFilePath);
	$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
    
}

$getActiveBaseQ = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',replace(replace(def_lang,'01','HIN'),'99','HIN')
    from Uninor_FilmiHeath.tbl_FH_subscription nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
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
/////////////// End UninorVAHealth//////////
/***********************Uninor SMS PACKS Start**************************************/

$uninorSMSPACK1File = "1439/SMSUninorGujaratiActiveBase_" . $fileDate . ".txt";
$uninorSMSPACKFilePath = $activeDir . $uninorSMSPACK1File;

$file_process_status = '***************Script start for SMSUninorGujarati******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$sid=getServiceNameID('SMSUninorGujarati',$LivdbConn);
if (file_exists($uninorSMSPACKFilePath)) {
    unlink($uninorSMSPACKFilePath);
	$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
  }

$getActiveBaseQ = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',replace(replace(def_lang,'01','HIN'),'99','HIN')
    from Uninor_smspack.tbl_local_gujarati_sub nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
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
        error_log($uniMTVActiveBasedata, 3, $uninorSMSPACKFilePath);
    }
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorSMSPACKFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
     if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for SMSUninorGujarati****************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}

$file_process_status = '***************Script start for SMSUninorAlert******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$uninorSMSPACK1File = "1440/SMSUninorAlertActiveBase_" . $fileDate . ".txt";
$uninorSMSPACKFilePath = $activeDir . $uninorSMSPACK1File;
$sid=getServiceNameID('SMSUninorAlert',$LivdbConn);
if (file_exists($uninorSMSPACKFilePath)) {
    unlink($uninorSMSPACKFilePath);
	$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
  }

$getActiveBaseQ = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',replace(replace(def_lang,'01','HIN'),'99','HIN')
    from Uninor_smspack.tbl_rich_alerts_sub nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
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
        error_log($uniMTVActiveBasedata, 3, $uninorSMSPACKFilePath);
    }
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorSMSPACKFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for SMSUninorAlert****************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}

$file_process_status = '***************Script start for SMSUninorFashion******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$uninorSMSPACK1File = "1438/SMSUninorFashionActiveBase_" . $fileDate . ".txt";
$uninorSMSPACKFilePath = $activeDir . $uninorSMSPACK1File;
$sid=getServiceNameID('SMSUninorFashion',$LivdbConn);

if (file_exists($uninorSMSPACKFilePath)) {
    unlink($uninorSMSPACKFilePath);
	$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='".$sid."' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);
  }

$getActiveBaseQ = "select '".$sid."',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',replace(replace(def_lang,'01','HIN'),'99','HIN')
    from Uninor_smspack.tbl_fashion_sub nolock where status=1 and date(sub_date)<='" . $view_date1 . "'";
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
        error_log($uniMTVActiveBasedata, 3, $uninorSMSPACKFilePath);
    }
    $file_process_status = 'Load data start at' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
    $insertDump = 'LOAD DATA LOCAL INFILE "' . $uninorSMSPACKFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for SMSUninorFashion****************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}
/**********************Uninor SMS PACKS END ***************************************/
echo "done";
mysql_close($dbConn);
mysql_close($LivdbConn);
?>
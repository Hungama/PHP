<?php

//////////////////////////////////////////////////////// code Start to dump Active bbase for DIGI Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectDigi.php");
$activeDir = "/var/www/html/kmis/testing/activeBase/";

//$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//$fileDate= date("YmdHis");

$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'UND' => 'Others', 'Others' => 'Others');

$languageData = array('01' => 'Hindi', '02' => 'English', '03' => 'Punjabi', '04' => 'Bhojpuri', '05' => 'Haryanavi', '06' => 'Bengali', '07' => 'Tamil', '08' => 'Telugu', '09' => 'Malayalam', '10' => 'Kannada', '11' => 'Marathi', '12' => 'Gujarati', '13' => 'Oriya', '14' => 'Kashmiri', '15' => 'Himachali', '16' => 'Chhattisgarhi', '17' => 'Assamese', '18' => 'Rajasthani', '19' => 'Nepali', '20' => 'Kumaoni', '21' => 'Maithali', '99' => 'Hindi');

$operator = $_POST['operator'];
$service_info = $_POST['service_info'];
$view_date1 = $_POST['Date'];
$upfor = $_POST['upfor'];
$fileDate = date("Ymd", strtotime($view_date1));
////////////////////////////////////////////////////Start DIGIMA//////////////////////////////////////////////////////////////////////////

if ($operator == 'Digi' && ($service_info == 'DIGIMA' || $service_info == 'ALL') && $upfor == 'active') {
    $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='DIGIMA' and status='Active'";
    $delquery = mysql_query($del, $LivdbConn);

    for ($k = 1; $k < 4; $k++) {
        switch ($k) {
            case '1':
                $database = 'dm_radio';
                $circle = 'Indian';
                break;
            case '2':
                $database = 'dm_radio_nepali';
                $circle = 'Nepali';
                break;
            case '3':
                $database = 'dm_radio_bengali';
                $circle = 'Bangla';
                break;
        }

        $DIGIMAFile = "2121/DIGIMA_" . $fileDate . ".txt";
        $DIGIMAFilePath = $activeDir . $DIGIMAFile;


        echo $getActiveBaseQ7 = "select 'DIGIMA',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from $database.tbl_digi_subscription where status=1 and date(sub_date)<='" . $view_date1 . "'";
        $query7 = mysql_query($getActiveBaseQ7, $dbConn);
        while ($DIGIMAActbase = mysql_fetch_array($query7)) {
            if ($circle_info[$DIGIMAActbase[5]] == '')
                $DIGIMAActbase[5] = 'Others';

            if ($languageData[trim($DIGIMAActbase[8])] != '')
                $lang = $languageData[$DIGIMAActbase[8]];
            else
                $lang = trim($DIGIMAActbase[8]);
            $DIGIMAActiveBasedata = $view_date1 . "|" . trim($DIGIMAActbase[0]) . "|" . trim($DIGIMAActbase[1]) . "|" . trim($DIGIMAActbase[2]) . "|" . trim($DIGIMAActbase[3]) . "|" . trim($DIGIMAActbase[4]) . "|" . trim($circle_info[$DIGIMAActbase[5]]) . "|" . trim($circle) . "|" . trim($DIGIMAActbase[7]) . "|" . trim($lang) . "|" . trim($DIGIMAActbase[15]) . '|' . trim($DIGIMAActbase[15]) . '|' . trim($DIGIMAActbase[15]) . "\r\n";
            error_log($DIGIMAActiveBasedata, 3, $DIGIMAFilePath);
        }
    }
    $insertDump7 = 'LOAD DATA LOCAL INFILE "' . $DIGIMAFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    mysql_query($insertDump7, $LivdbConn);
}
//////////////////////////////////////////////////// End DIGIMA/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Pending DIGIMA//////////////////////////////////////////////////////////////////////////
if ($operator == 'Digi' && ($service_info == 'DIGIMA' || $service_info == 'ALL') && $upfor == 'pending') {
    $del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='DIGIMA' and status='Pending'";
    $delquery = mysql_query($del, $LivdbConn);
    for ($k = 1; $k < 4; $k++) {
        switch ($k) {
            case '1':
                $database = 'dm_radio';
                $circle = 'Indian';
                break;
            case '2':
                $database = 'dm_radio_nepali';
                $circle = 'Nepali';
                break;
            case '3':
                $database = 'dm_radio_bengali';
                $circle = 'Bangla';
                break;
        }

        $PDIGIMAFile = "2121/PDIGIMA_" . $fileDate . ".txt";
        $PDIGIMAFilePath = $activeDir . $PDIGIMAFile;

        echo $getPendingBaseQ7 = "select 'DIGIMA',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from $database.tbl_digi_subscription where status=11 and date(sub_date)<='" . $view_date1 . "'";
        $query7 = mysql_query($getPendingBaseQ7, $dbConn);
        while ($PDIGIMAActbase = mysql_fetch_array($query7)) {
            if ($circle_info[$PDIGIMAActbase[5]] == '')
                $PDIGIMAActbase[5] = 'Others';

            if ($languageData[trim($PDIGIMAActbase[8])] != '')
                $lang = $languageData[$PDIGIMAActbase[8]];
            else
                $lang = trim($PDIGIMAActbase[8]);
            $PDIGIMAPendingBasedata = $view_date1 . "|" . trim($PDIGIMAActbase[0]) . "|" . trim($PDIGIMAActbase[1]) . "|" . trim($PDIGIMAActbase[2]) . "|" . trim($PDIGIMAActbase[3]) . "|" . trim($PDIGIMAActbase[4]) . "|" . trim($circle_info[$PDIGIMAActbase[5]]) . "|" . trim($circle) . "|" . trim($PDIGIMAActbase[7]) . "|" . trim($lang) . "|" . trim($PDIGIMAActbase[15]) . '|' . trim($PDIGIMAActbase[15]) . '|' . trim($PDIGIMAActbase[15]) . "\r\n";
            error_log($PDIGIMAPendingBasedata, 3, $PDIGIMAFilePath);
        }
    }
    $insertDump10 = 'LOAD DATA LOCAL INFILE "' . $PDIGIMAFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    mysql_query($insertDump10, $LivdbConn);
}
//////////////////////////////////////////////////// End Pending DIGIMA/////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////// code End to dump Active base for DIGI///////////////////////////////////////////////////

mysql_close($dbConn);
mysql_close($LivdbConn);

echo "done";
?>

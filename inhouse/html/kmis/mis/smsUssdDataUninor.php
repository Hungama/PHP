<?php
// for billing
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$fview_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$activeDir = "/var/www/html/kmis/testing/activeBase/";
$processlog = "/var/www/html/kmis/testing/activeBase/logs/uninor/processlog_USSDSMS_" . date(Ymd) . ".txt";
$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'UND' => 'Others', 'Others' => 'Others');

$uniRIAFile = "1413/UninorUSSD_" . $fileDate . ".txt";
$uniUSSDFilePath = $activeDir . $uniRIAFile;
$file_process_status = '***************Script start for Uninor USSD data******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
if (file_exists($uniUSSDFilePath)) {
    unlink($uniUSSDFilePath);
    $del = "delete from misdata.tbl_ussd_uninor where date(date)='" . $view_date1 . "'";
    $delquery = mysql_query($del, $LivdbConn);
    }
//For USSD data
$getUSSDdataBase = "select msisdn,request_type,Code,circle,date,DNIS,Status,servicename,type from master_db.tbl_sms_uninor where  date(date)='" . $view_date1 . "' and type='USSD'";
$query3 = mysql_query($getUSSDdataBase, $dbConn);
$numRows1 = mysql_num_rows($query3);
if ($numRows1 > 0) {
        while ($ussddata = mysql_fetch_array($query3)) {
        
			$circle=$circle_info[$ussddata['circle']];
			if ($circle=='')
			$circle = 'Others';				
			
			$msisdn=trim($ussddata['msisdn']);
			$request_type=trim($ussddata['request_type']);
			$Code=trim($ussddata['Code']);
			$date=trim($ussddata['date']);
			$DNIS=trim($ussddata['DNIS']);
			$Status=trim($ussddata['Status']);
			$servicename=trim($ussddata['servicename']);
			$type=trim($ussddata['type']);

	$BasedataUSSD = $date . "|" . $servicename . "|"  .$msisdn."|"  .$request_type."|"  .$Code."|"  .$circle."|"  .$DNIS."|"  .$Status ."\r\n";
        error_log($BasedataUSSD, 3, $uniUSSDFilePath);
    }
	$insertDump = 'LOAD DATA LOCAL INFILE "' . $uniUSSDFilePath . '" INTO TABLE misdata.tbl_ussd_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,requesttype,keyword,circle,dnis,status)';
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for Uninor USSD data******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}

sleep(10);

//For SMS data

$uniRIAFile = "1413/UninorSMS_" . $fileDate . ".txt";
$uniUSSDFilePath = $activeDir . $uniRIAFile;
$file_process_status = '***************Script start for Uninor SMS data******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
if (file_exists($uniUSSDFilePath)) {
    unlink($uniUSSDFilePath);
    $del = "delete from misdata.tbl_sms_uninor where date(date)='" . $view_date1 . "'";
    $delquery = mysql_query($del, $LivdbConn);
    }

$getUSSDdataBase = "select msisdn,request_type,Code,circle,date,DNIS,Status,servicename,type from master_db.tbl_sms_uninor where  date(date)='" . $view_date1 . "' and type='SMS'";
$query3 = mysql_query($getUSSDdataBase, $dbConn);
$numRows1 = mysql_num_rows($query3);
if ($numRows1 > 0) {
        while ($ussddata = mysql_fetch_array($query3)) {
        
		$circle=$circle_info[$ussddata['circle']];
			if ($circle=='')
			$circle = 'Others';				
		
		
			$msisdn=trim($ussddata['msisdn']);
			$request_type=trim($ussddata['request_type']);
			$Code=trim($ussddata['Code']);
			$date=trim($ussddata['date']);
			$DNIS=trim($ussddata['DNIS']);
			$Status=trim($ussddata['Status']);
			$servicename=trim($ussddata['servicename']);
			$type=trim($ussddata['type']);

	$BasedataUSSD = $date . "|" . $servicename . "|"  .$msisdn."|"  .$request_type."|"  .$Code."|"  .$circle."|"  .$DNIS."|"  .$Status ."\r\n";
        error_log($BasedataUSSD, 3, $uniUSSDFilePath);
    }
	$insertDump = 'LOAD DATA LOCAL INFILE "' . $uniUSSDFilePath . '" INTO TABLE misdata.tbl_sms_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,requesttype,keyword,circle,dnis,status)';
    if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }

    error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for Uninor SMS data******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
}

echo "done";
mysql_close($dbConn);
mysql_close($LivdbConn);
?>
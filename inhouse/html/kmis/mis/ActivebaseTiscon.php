<?php
///////////// code Start to dump Active bbase for MCD///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
error_reporting(0);
$activeDir = "/var/www/html/kmis/testing/activeBase/";

$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$circle_info = array('DEL' => 'Delhi', 'GUJ' => 'Gujarat', 'WBL' => 'WestBengal', 'BIH' => 'Bihar', 'RAJ' => 'Rajasthan', 'UPW' => 'UP WEST', 'MAH' => 'Maharashtra', 'APD' => 'Andhra Pradesh', 'UPE' => 'UP EAST', 'ASM' => 'Assam', 'TNU' => 'Tamil Nadu', 'KOL' => 'Kolkata', 'NES' => 'NE', 'CHN' => 'Chennai', 'ORI' => 'Orissa', 'KAR' => 'Karnataka', 'HAY' => 'Haryana', 'PUN' => 'Punjab', 'MUM' => 'Mumbai', 'MPD' => 'Madhya Pradesh', 'JNK' => 'Jammu-Kashmir', 'PUB' => "Punjab", 'KER' => 'Kerala', 'HPD' => 'Himachal Pradesh', 'UND' => 'Others', 'Others' => 'Others');

$languageData = array('01' => 'Hindi', '02' => 'English', '03' => 'Punjabi', '04' => 'Bhojpuri', '05' => 'Haryanavi', '06' => 'Bengali', '07' => 'Tamil', '08' => 'Telugu', '09' => 'Malayalam', '10' => 'Kannada', '11' => 'Marathi', '12' => 'Gujarati', '13' => 'Oriya', '14' => 'Kashmiri', '15' => 'Himachali', '16' => 'Chhattisgarhi', '17' => 'Assamese', '18' => 'Rajasthani', '19' => 'Nepali', '20' => 'Kumaoni', '21' => 'Maithali', '99' => 'Hindi');

$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='EnterpriseTiscon' and status='Active'";$delquery = mysql_query($del, $LivdbConn);
	
	
$docomoMTVFile = "TISCON/TISCON_" . $fileDate . ".txt";
$docomoMTVFilePath = $activeDir . $docomoMTVFile;
if (file_exists($docomoMTVFilePath)) {
    unlink($docomoMTVFilePath);
    
  }

$getActiveBaseQ7 = "select 'EnterpriseTiscon',CONCAT('91',ani) 'ani',date_time,obd_sent_date_time,'IVR',IFNULL(circle,'Others'),obd_diff ,'Active',retry_count 
from Hungama_Tatasky.tbl_tata_pushobd nolock where date(date_time)='" . $view_date1 . "' and ANI!=''";
$query7 = mysql_query($getActiveBaseQ7, $dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
      while ($docomoMtvActbase = mysql_fetch_array($query7)) {
	  
	  $circle1=strtoupper($docomoMtvActbase[5]);
        
	$circle=$circle_info[$circle1];
	if($circle=='')
	$circle='Others';
		
        $lang = trim($docomoMtvActbase[8]);
        $docomoMTVActiveBasedata = $view_date1 . "|" . trim($docomoMtvActbase[0]) . "|" . trim($docomoMtvActbase[1]) . "|" . trim($docomoMtvActbase[2]) . "|" . trim($docomoMtvActbase[3]) . "|" . trim($docomoMtvActbase[4]) . "|" . $circle . "|" . trim($docomoMtvActbase[6]) . "|" . trim($docomoMtvActbase[7]) . "|" . trim($lang) . "|" . trim($docomoMtvActbase[15]) . '|' . trim($docomoMtvActbase[15]) . '|' . trim($docomoMtvActbase[15]) . "\r\n";
        error_log($docomoMTVActiveBasedata, 3, $docomoMTVFilePath);
    }

	$insertDump7 = 'LOAD DATA LOCAL INFILE "' . $docomoMTVFilePath . '" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
    if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	if(mysql_query($insertDump7, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
 }
echo $file_process_status."#"."done";
mysql_close($dbConn);
mysql_close($LivdbConn);
?>
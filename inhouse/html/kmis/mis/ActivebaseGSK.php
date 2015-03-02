<?php
///////////// code Start to dump Active bbase for MCD///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
error_reporting(0);
$activeDir = "/var/www/html/kmis/testing/activeBase/";
$circle_info=array('233'=>'GHANA','27'=>'AFRICA','254'=>'KENYA','234'=>'NIGERIA','UND' => 'Others', 'Others' => 'Others');

$view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
$del = "delete from misdata.tbl_base_active where date(date)='" . $view_date1 . "' and service='EnterpriseAfricaGSK' and status='Active'";$delquery = mysql_query($del, $LivdbConn);
	
	
$docomoMTVFile = "GSK/GSK_" . $fileDate . ".txt";
$docomoMTVFilePath = $activeDir . $docomoMTVFile;
if (file_exists($docomoMTVFilePath)) {
    unlink($docomoMTVFilePath);   
  }

$getActiveBaseQ7 = "select 'EnterpriseAfricaGSK',ani,date_time,obd_sent_date_time,'IVR',IFNULL(circle,'Others'),obd_diff ,'Active',retry_count,SUBSTRING(ANI,1,3) as Ccode
from Hungama_GSK_Africa.tbl_gsk_pushobd nolock where date(date_time)='" . $view_date1 . "' and ANI!='' and service='GSK_AFRICA'";
$query7 = mysql_query($getActiveBaseQ7, $dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
      while ($docomoMtvActbase = mysql_fetch_array($query7)) {
        if ($circle_info[$docomoMtvActbase[9]] == '')
            $docomoMtvActbase[9] = 'Others';
		
        $lang = trim($docomoMtvActbase[8]);
        $docomoMTVActiveBasedata = $view_date1 . "|" . trim($docomoMtvActbase[0]) . "|" . trim($docomoMtvActbase[1]) . "|" . trim($docomoMtvActbase[2]) . "|" . trim($docomoMtvActbase[3]) . "|" . trim($docomoMtvActbase[4]) . "|" . trim($circle_info[$docomoMtvActbase[9]]) . "|" . trim($docomoMtvActbase[6]) . "|" . trim($docomoMtvActbase[7]) . "|" . trim($lang) . "|" . trim($docomoMtvActbase[15]) . '|' . trim($docomoMtvActbase[15]) . '|' . trim($docomoMtvActbase[15]) . "\r\n";
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
unlink($docomoMTVFilePath);
mysql_close($dbConn);
mysql_close($LivdbConn);
?>
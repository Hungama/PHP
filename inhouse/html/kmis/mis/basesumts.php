<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");
$activeDir="/var/www/html/kmis/testing/activeBase/";
$processlog = "/var/www/html/kmis/testing/activeBase/logs/mts/processlog_active_pending_".date(Ymd).".txt";
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//$fileDate= date("YmdHis");
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

echo $view_date1='2015-02-14';
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');

$MtsContestFile="1102/SUMts_".$fileDate.".txt";
$MtsContestFilePath=$activeDir.$MtsContestFile;
$file_process_status = '***************Script start for ContestMTS Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($MtsContestFilePath))
{	unlink($MtsContestFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSSU' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}

$getActiveBaseQ7="select 'MTSSU',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),USER_BAL,'Active',def_lang from MTS_cricket.tbl_cricket_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

while($MtsContestActbase = mysql_fetch_array($query7))
{
     if($circle_info[$MtsContestActbase[5]]=='')
		$MtsContestActbase[5]='Others';

	if($languageData[trim($MtsContestActbase[8])]!='')
		$lang=$languageData[$MtsContestActbase[8]];
	else
		$lang=trim($MtsContestActbase[8]);
	$MtsContestActiveBasedata=$view_date1."|".trim($MtsContestActbase[0])."|".trim($MtsContestActbase[1])."|".trim($MtsContestActbase[2])."|".trim($MtsContestActbase[3])."|".trim($MtsContestActbase[4])."|".trim($circle_info[$MtsContestActbase[5]])."|".trim($MtsContestActbase[6])."|".trim($MtsContestActbase[7])."|".trim($lang)."|".trim($MtsContestActbase[15]).'|'.trim($MtsContestActbase[15]).'|'.trim($MtsContestActbase[15])."\r\n";
	error_log($MtsContestActiveBasedata,3,$MtsContestFilePath) ;
}
$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$MtsContestFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
//		mysql_query($insertDump7,$LivdbConn);
 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(mysql_query($insertDump7, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSsu******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}

// pending

$PMTSContestFile="1102/PMTSSU_".$fileDate.".txt";
$PMTSContestFilePath=$activeDir.$PMTSContestFile;

$file_process_status = '***************Script start for MTSSU Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($PMTSContestFilePath))
{
unlink($PMTSContestFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSSU' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);
		
$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}

$getPendingBaseQ7="select 'MTSSU',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),USER_BAL,'Pending',def_lang from MTS_cricket.tbl_cricket_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);

$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

while($PMTSContestActbase = mysql_fetch_array($query7))
{ 
    if($circle_info[$PMTSContestActbase[5]]=='')
		$PMTSContestActbase[5]='Others';

	if($languageData[trim($PMTSContestActbase[8])]!='')
		$lang=$languageData[$PMTSContestActbase[8]];
	else
		$lang=trim($PMTSContestActbase[8]);
	$PMTSContestPendingBasedata=$view_date1."|".trim($PMTSContestActbase[0])."|".trim($PMTSContestActbase[1])."|".trim($PMTSContestActbase[2])."|".trim($PMTSContestActbase[3])."|".trim($PMTSContestActbase[4])."|".trim($circle_info[$PMTSContestActbase[5]])."|".trim($PMTSContestActbase[6])."|".trim($PMTSContestActbase[7])."|".trim($lang)."|".trim($PMTSContestActbase[15]).'|'.trim($PMTSContestActbase[15]).'|'.trim($PMTSContestActbase[15])."\r\n";
	error_log($PMTSContestPendingBasedata,3,$PMTSContestFilePath) ;
}
	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$PMTSContestFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump10,$LivdbConn);
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump10, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSSU******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

}
?>

<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
$activeDir="/var/www/html/kmis/mis/activeBase/";
$processlog = "/var/www/html/kmis/testing/activeBase/logs/airtel/processlog_active_".date(Ymd).".txt";

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fview_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');


$airtelRegKRFile="1502/AirtelRegKR".$fileDate.".txt";
$airtelRegKRFilePath=$activeDir.$airtelRegKRFile;
$file_process_status = '***************Script start for AirtelRegKR Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	unlink($airtelRegKRFilePath);
	 $file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
    error_log($file_process_status, 3, $processlog);
	
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelRegKR' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='AirtelRegKR' and status='Active' ";
	$delquery = mysql_query($del1,$dbConnAirtel);		
		 $file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
    error_log($file_process_status, 3, $processlog);

$getActiveBaseQ18="select 'AirtelRegKR',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_TINTUMON.tbl_TINTUMON_subscription nolock where status=1 and plan_id=82 and date(sub_date)<='".$view_date1."'"; 
$query18 = mysql_query($getActiveBaseQ18,$dbConnAirtel);
$numRows1 = mysql_num_rows($query18);
if ($numRows1 > 0) {
	 $file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
    error_log($file_process_status, 3, $processlog);
	
while($airtelRegKKActbase = mysql_fetch_array($query18))
{
	if($circle_info[$airtelRegKKActbase[5]]=='')
		$circle_info[$airtelRegKKActbase[5]]=='Others';
	if($languageData[trim($airtelRegKKActbase[8])]!='')
		$lang=$languageData[$airtelRegKKActbase[8]];
	else
		$lang=trim($airtelRegKKActbase[8]);
	$airtelRegKRActiveBasedata=$view_date1."|".trim($airtelRegKKActbase[0])."|".trim($airtelRegKKActbase[1])."|".trim($airtelRegKKActbase[2])."|".trim($airtelRegKKActbase[3])."|".trim($airtelRegKKActbase[4])."|".trim($circle_info[$airtelRegKKActbase[5]])."|".trim($airtelRegKKActbase[6])."|".trim($airtelRegKKActbase[7])."|".trim($lang)."|".trim($airtelRegKKActbase[15]).'|'.trim($airtelRegKKActbase[15]).'|'.trim($airtelRegKKActbase[15])."\r\n";

	error_log($airtelRegKRActiveBasedata,3,$airtelRegKRFilePath) ;

}
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
	
	
	$insertDump18= 'LOAD DATA LOCAL INFILE "'.$airtelRegKRFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump18,$LivdbConn);
	$insertDump181= 'LOAD DATA LOCAL INFILE "'.$airtelRegKRFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump181,$dbConnAirtel);
		
 if(mysql_query($insertDump18, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}

    error_log($file_process_status, 3, $processlog);
	$file_process_status = '***************Script end for AirtelRegKK******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	error_log($file_process_status, 3, $processlog);
}
//////////////////////////////////////////////////// End Airtel AirtelRegKK //////////////////////////////////////////////////////////////////////////
echo "done";
mysql_close($dbConnAirtel);
mysql_close($LivdbConn);
?>
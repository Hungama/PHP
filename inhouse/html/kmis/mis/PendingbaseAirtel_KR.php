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

////////////////////////////////////////////////////Start AirtelRegKK //////////////////////////////////////////////////////////////////////////

$airtelRegKRFile="1502/AirtelRegKR_".$fileDate.".txt";
$airtelRegKRFilePath=$activeDir.$airtelRegKRFile;

	unlink($airtelRegKRFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelRegKR' and status='Pending' ";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='AirtelRegKR' and status='Pending' ";
	$delquery = mysql_query($del1,$dbConnAirtel);
$getActiveBaseQ18="select 'AirtelRegKR',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_TINTUMON.tbl_TINTUMON_subscription nolock where status=11 and plan_id=82 and date(sub_date)<='".$view_date1."'"; 
$query18 = mysql_query($getActiveBaseQ18,$dbConnAirtel);
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
	$insertDump18= 'LOAD DATA LOCAL INFILE "'.$airtelRegKRFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump18,$LivdbConn);
	$insertDump181= 'LOAD DATA LOCAL INFILE "'.$airtelRegKRFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump181,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel AirtelRegKK //////////////////////////////////////////////////////////////////////////

?>
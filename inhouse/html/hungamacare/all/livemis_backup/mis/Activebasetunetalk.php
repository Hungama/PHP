<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for TuneTalk Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectTune.php");
$activeDir="/var/www/html/kmis/testing/activeBase/";

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fview_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$fileDate= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');


////////////////////////////////////////////////////Start TuneTalkIVR//////////////////////////////////////////////////////////////////////////

$TuneTalkIVRFile="1901/TuneTalkIVR_".$fileDate.".txt";
$TuneTalkIVRFilePath=$activeDir.$TuneTalkIVRFile;

if(file_exists($TuneTalkIVRFilePath))
{
	unlink($TuneTalkIVRFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='TuneTalkIVR' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
}

$getActiveBaseQ7="select 'TuneTalkIVR',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from tunetalk_radio.tbl_tunetalk_subscription where status=1 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($TuneTalkIVRActbase = mysql_fetch_array($query7))
{
	if($circle_info[$TuneTalkIVRActbase[5]]=='')
		$TuneTalkIVRActbase[5]='Others';

	if($languageData[trim($TuneTalkIVRActbase[8])]!='')
		$lang=$languageData[$TuneTalkIVRActbase[8]];
	else
		$lang=trim($TuneTalkIVRActbase[8]);
	$TuneTalkIVRActiveBasedata=$view_date1."|".trim($TuneTalkIVRActbase[0])."|".trim($TuneTalkIVRActbase[1])."|".trim($TuneTalkIVRActbase[2])."|".trim($TuneTalkIVRActbase[3])."|".trim($TuneTalkIVRActbase[4])."|".trim($circle_info[$TuneTalkIVRActbase[5]])."|".trim($TuneTalkIVRActbase[6])."|".trim($TuneTalkIVRActbase[7])."|".trim($lang)."|".trim($TuneTalkIVRActbase[15]).'|'.trim($TuneTalkIVRActbase[15]).'|'.trim($TuneTalkIVRActbase[15])."\r\n";
	error_log($TuneTalkIVRActiveBasedata,3,$TuneTalkIVRFilePath) ;
}
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$TuneTalkIVRFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);


//////////////////////////////////////////////////// End TuneTalkIVR/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending TuneTalkIVR//////////////////////////////////////////////////////////////////////////

$PTuneTalkIVRFile="1901/PTuneTalkIVR_".$fileDate.".txt";
$PTuneTalkIVRFilePath=$activeDir.$PTuneTalkIVRFile;

if(file_exists($PTuneTalkIVRFilePath))
{
	unlink($PTuneTalkIVRFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='TuneTalkIVR' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
}

$getPendingBaseQ7="select 'TuneTalkIVR',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from tunetalk_radio.tbl_tunetalk_subscription where status!=1 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PTuneTalkIVRActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PTuneTalkIVRActbase[5]]=='')
		$PTuneTalkIVRActbase[5]='Others';

	if($languageData[trim($PTuneTalkIVRActbase[8])]!='')
		$lang=$languageData[$PTuneTalkIVRActbase[8]];
	else
		$lang=trim($PTuneTalkIVRActbase[8]);
	$PTuneTalkIVRPendingBasedata=$view_date1."|".trim($PTuneTalkIVRActbase[0])."|".trim($PTuneTalkIVRActbase[1])."|".trim($PTuneTalkIVRActbase[2])."|".trim($PTuneTalkIVRActbase[3])."|".trim($PTuneTalkIVRActbase[4])."|".trim($circle_info[$PTuneTalkIVRActbase[5]])."|".trim($PTuneTalkIVRActbase[6])."|".trim($PTuneTalkIVRActbase[7])."|".trim($lang)."|".trim($PTuneTalkIVRActbase[15]).'|'.trim($PTuneTalkIVRActbase[15]).'|'.trim($PTuneTalkIVRActbase[15])."\r\n";
	error_log($PTuneTalkIVRPendingBasedata,3,$PTuneTalkIVRFilePath) ;
}
	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$PTuneTalkIVRFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump12,$LivdbConn);


//////////////////////////////////////////////////// End Pending TuneTalkIVR/////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////// code End to dump Active base for TuneTalk Operator///////////////////////////////////////////////////

mysql_close($dbConn);

?>
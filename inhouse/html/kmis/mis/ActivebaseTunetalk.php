<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectTune.php");
$activeDir="/var/www/html/kmis/testing/activeBase/";

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//$fileDate= date("YmdHis");
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');

////////////////////////////////////////////////////Start tunetalk IVR//////////////////////////////////////////////////////////////////////////

$tunetalkIVRFile="1901/TuneTalkIVR_".$fileDate.".txt";
$tunetalkIVRFilePath=$activeDir.$tunetalkIVRFile;

	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='TuneTalkIVR' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);


$getActiveBaseQ7="select 'TuneTalkIVR',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from tunetalk_radio.tbl_tunetalk_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($tunetalkIVRActbase = mysql_fetch_array($query7))
{
	if($circle_info[$tunetalkIVRActbase[5]]=='')
		$tunetalkIVRActbase[5]='Others';

	if($languageData[trim($tunetalkIVRActbase[8])]!='')
		$lang=$languageData[$tunetalkIVRActbase[8]];
	else
		$lang=trim($tunetalkIVRActbase[8]);
	$tunetalkIVRActiveBasedata=$view_date1."|".trim($tunetalkIVRActbase[0])."|".trim($tunetalkIVRActbase[1])."|".trim($tunetalkIVRActbase[2])."|".trim($tunetalkIVRActbase[3])."|".trim($tunetalkIVRActbase[4])."|".trim($circle_info[$tunetalkIVRActbase[5]])."|".trim($tunetalkIVRActbase[6])."|".trim($tunetalkIVRActbase[7])."|".trim($lang)."|".trim($tunetalkIVRActbase[15]).'|'.trim($tunetalkIVRActbase[15]).'|'.trim($tunetalkIVRActbase[15])."\r\n";
	error_log($tunetalkIVRActiveBasedata,3,$tunetalkIVRFilePath) ;
}
	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$tunetalkIVRFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump7,$LivdbConn);

//////////////////////////////////////////////////// End tunetalk IVR/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending tunetalk IVR//////////////////////////////////////////////////////////////////////////

$PtunetalkIVRFile="1901/PTuneTalkIVR_".$fileDate.".txt";
$PtunetalkIVRFilePath=$activeDir.$PtunetalkIVRFile;


	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='TuneTalkIVR' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);


$getPendingBaseQ7="select 'TuneTalkIVR',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from tunetalk_radio.tbl_tunetalk_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PtunetalkIVRActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PtunetalkIVRActbase[5]]=='')
		$PtunetalkIVRActbase[5]='Others';

	if($languageData[trim($PtunetalkIVRActbase[8])]!='')
		$lang=$languageData[$PtunetalkIVRActbase[8]];
	else
		$lang=trim($PtunetalkIVRActbase[8]);
	$PtunetalkIVRPendingBasedata=$view_date1."|".trim($PtunetalkIVRActbase[0])."|".trim($PtunetalkIVRActbase[1])."|".trim($PtunetalkIVRActbase[2])."|".trim($PtunetalkIVRActbase[3])."|".trim($PtunetalkIVRActbase[4])."|".trim($circle_info[$PtunetalkIVRActbase[5]])."|".trim($PtunetalkIVRActbase[6])."|".trim($PtunetalkIVRActbase[7])."|".trim($lang)."|".trim($PtunetalkIVRActbase[15]).'|'.trim($PtunetalkIVRActbase[15]).'|'.trim($PtunetalkIVRActbase[15])."\r\n";
	error_log($PtunetalkIVRPendingBasedata,3,$PtunetalkIVRFilePath) ;
}
	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$PtunetalkIVRFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump10,$LivdbConn);


//////////////////////////////////////////////////// End Pending tunetalk IVR/////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////

mysql_close($dbConn);
mysql_close($LivdbConn);


?>

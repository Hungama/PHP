<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for TuneTalk Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectDigi.php");
$activeDir="/var/www/html/kmis/testing/activeBase/";

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fview_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$fileDate= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

/* $circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');


$languageData=array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');
*/

////////////////////////////////////////////////////Start Indian DIGIMA//////////////////////////////////////////////////////////////////////////

$DIGIMAFile="1701/IDIGIMA_".$fileDate.".txt";
$DIGIMAFilePath=$activeDir.$DIGIMAFile;

if(file_exists($DIGIMAFilePath))
{
	unlink($DIGIMAFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='DIGIMA' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
}

$getActiveBaseQ7="select 'DIGIMA',ani,sub_date,renew_date,mode_of_sub,'Indian',user_bal,'Active',def_lang from dm_radio.tbl_digi_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($DIGIMAActbase = mysql_fetch_array($query7))
{
	if($circle_info[$DIGIMAActbase[5]]=='')
		$DIGIMAActbase[5]='Others';

	if($languageData[trim($DIGIMAActbase[8])]!='')
		$lang=$languageData[$DIGIMAActbase[8]];
	else
		$lang=trim($DIGIMAActbase[8]);
	$DIGIMAActiveBasedata=$view_date1."|".trim($DIGIMAActbase[0])."|".trim($DIGIMAActbase[1])."|".trim($DIGIMAActbase[2])."|".trim($DIGIMAActbase[3])."|".trim($DIGIMAActbase[4])."|".trim($circle_info[$DIGIMAActbase[5]])."|".trim($DIGIMAActbase[6])."|".trim($DIGIMAActbase[7])."|".trim($lang)."|".trim($DIGIMAActbase[15]).'|'.trim($DIGIMAActbase[15]).'|'.trim($DIGIMAActbase[15])."\r\n";
	error_log($DIGIMAActiveBasedata,3,$DIGIMAFilePath) ;
}
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$DIGIMAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);


//////////////////////////////////////////////////// End Indian DIGIMA/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending Indian DIGIMA//////////////////////////////////////////////////////////////////////////

$PDIGIMAFile="1701/PIDIGIMA_".$fileDate.".txt";
$PDIGIMAFilePath=$activeDir.$PDIGIMAFile;

if(file_exists($PDIGIMAFilePath))
{
	unlink($PDIGIMAFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='DIGIMA' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
}

$getPendingBaseQ7="select 'DIGIMA',ani,sub_date,renew_date,mode_of_sub,Indian,user_bal,'Pending',def_lang from dm_radio.tbl_digi_subscription nolock where status!=1 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PDIGIMAActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PDIGIMAActbase[5]]=='')
		$PDIGIMAActbase[5]='Others';

	if($languageData[trim($PDIGIMAActbase[8])]!='')
		$lang=$languageData[$PDIGIMAActbase[8]];
	else
		$lang=trim($PDIGIMAActbase[8]);
	$PDIGIMAPendingBasedata=$view_date1."|".trim($PDIGIMAActbase[0])."|".trim($PDIGIMAActbase[1])."|".trim($PDIGIMAActbase[2])."|".trim($PDIGIMAActbase[3])."|".trim($PDIGIMAActbase[4])."|".trim($circle_info[$PDIGIMAActbase[5]])."|".trim($PDIGIMAActbase[6])."|".trim($PDIGIMAActbase[7])."|".trim($lang)."|".trim($PDIGIMAActbase[15]).'|'.trim($PDIGIMAActbase[15]).'|'.trim($PDIGIMAActbase[15])."\r\n";
	error_log($PDIGIMAPendingBasedata,3,$PDIGIMAFilePath) ;
}
	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$PDIGIMAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump12,$LivdbConn);


//////////////////////////////////////////////////// End Pending Indian DIGIMA/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Bangali DIGIMA//////////////////////////////////////////////////////////////////////////

$DIGIMAFile="1701/BDIGIMA_".$fileDate.".txt";
$DIGIMAFilePath=$activeDir.$DIGIMAFile;

if(file_exists($DIGIMAFilePath))
{
	unlink($DIGIMAFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='DIGIMA' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
}

$getActiveBaseQ7="select 'DIGIMA',ani,sub_date,renew_date,mode_of_sub,'Bangali',user_bal,'Active',def_lang from dm_radio_bengali.tbl_digi_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($DIGIMAActbase = mysql_fetch_array($query7))
{
	if($circle_info[$DIGIMAActbase[5]]=='')
		$DIGIMAActbase[5]='Others';

	if($languageData[trim($DIGIMAActbase[8])]!='')
		$lang=$languageData[$DIGIMAActbase[8]];
	else
		$lang=trim($DIGIMAActbase[8]);
	$DIGIMAActiveBasedata=$view_date1."|".trim($DIGIMAActbase[0])."|".trim($DIGIMAActbase[1])."|".trim($DIGIMAActbase[2])."|".trim($DIGIMAActbase[3])."|".trim($DIGIMAActbase[4])."|".trim($circle_info[$DIGIMAActbase[5]])."|".trim($DIGIMAActbase[6])."|".trim($DIGIMAActbase[7])."|".trim($lang)."|".trim($DIGIMAActbase[15]).'|'.trim($DIGIMAActbase[15]).'|'.trim($DIGIMAActbase[15])."\r\n";
	error_log($DIGIMAActiveBasedata,3,$DIGIMAFilePath) ;
}
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$DIGIMAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);


//////////////////////////////////////////////////// End Bangali DIGIMA/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending Bangali DIGIMA//////////////////////////////////////////////////////////////////////////

$PDIGIMAFile="1701/PBDIGIMA_".$fileDate.".txt";
$PDIGIMAFilePath=$activeDir.$PDIGIMAFile;

if(file_exists($PDIGIMAFilePath))
{
	unlink($PDIGIMAFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='DIGIMA' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
}

$getPendingBaseQ7="select 'DIGIMA',ani,sub_date,renew_date,mode_of_sub,Bangali,user_bal,'Pending',def_lang from dm_radio_bengali.tbl_digi_subscription nolock where status!=1 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PDIGIMAActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PDIGIMAActbase[5]]=='')
		$PDIGIMAActbase[5]='Others';

	if($languageData[trim($PDIGIMAActbase[8])]!='')
		$lang=$languageData[$PDIGIMAActbase[8]];
	else
		$lang=trim($PDIGIMAActbase[8]);
	$PDIGIMAPendingBasedata=$view_date1."|".trim($PDIGIMAActbase[0])."|".trim($PDIGIMAActbase[1])."|".trim($PDIGIMAActbase[2])."|".trim($PDIGIMAActbase[3])."|".trim($PDIGIMAActbase[4])."|".trim($circle_info[$PDIGIMAActbase[5]])."|".trim($PDIGIMAActbase[6])."|".trim($PDIGIMAActbase[7])."|".trim($lang)."|".trim($PDIGIMAActbase[15]).'|'.trim($PDIGIMAActbase[15]).'|'.trim($PDIGIMAActbase[15])."\r\n";
	error_log($PDIGIMAPendingBasedata,3,$PDIGIMAFilePath) ;
}
	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$PDIGIMAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump12,$LivdbConn);


//////////////////////////////////////////////////// End Pending Bangali DIGIMA/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Nepali DIGIMA//////////////////////////////////////////////////////////////////////////

$DIGIMAFile="1701/NDIGIMA_".$fileDate.".txt";
$DIGIMAFilePath=$activeDir.$DIGIMAFile;

if(file_exists($DIGIMAFilePath))
{
	unlink($DIGIMAFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='DIGIMA' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
}

$getActiveBaseQ7="select 'DIGIMA',ani,sub_date,renew_date,mode_of_sub,'Bangali',user_bal,'Active',def_lang from dm_radio_nepali.tbl_digi_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($DIGIMAActbase = mysql_fetch_array($query7))
{
	if($circle_info[$DIGIMAActbase[5]]=='')
		$DIGIMAActbase[5]='Others';

	if($languageData[trim($DIGIMAActbase[8])]!='')
		$lang=$languageData[$DIGIMAActbase[8]];
	else
		$lang=trim($DIGIMAActbase[8]);
	$DIGIMAActiveBasedata=$view_date1."|".trim($DIGIMAActbase[0])."|".trim($DIGIMAActbase[1])."|".trim($DIGIMAActbase[2])."|".trim($DIGIMAActbase[3])."|".trim($DIGIMAActbase[4])."|".trim($circle_info[$DIGIMAActbase[5]])."|".trim($DIGIMAActbase[6])."|".trim($DIGIMAActbase[7])."|".trim($lang)."|".trim($DIGIMAActbase[15]).'|'.trim($DIGIMAActbase[15]).'|'.trim($DIGIMAActbase[15])."\r\n";
	error_log($DIGIMAActiveBasedata,3,$DIGIMAFilePath) ;
}
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$DIGIMAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);


//////////////////////////////////////////////////// End Nepali DIGIMA/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending Nepali DIGIMA//////////////////////////////////////////////////////////////////////////

$PDIGIMAFile="1701/PNDIGIMA_".$fileDate.".txt";
$PDIGIMAFilePath=$activeDir.$PDIGIMAFile;

if(file_exists($PDIGIMAFilePath))
{
	unlink($PDIGIMAFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='DIGIMA' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
}

$getPendingBaseQ7="select 'DIGIMA',ani,sub_date,renew_date,mode_of_sub,Bangali,user_bal,'Pending',def_lang from dm_radio_nepali.tbl_digi_subscription nolock where status!=1 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PDIGIMAActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PDIGIMAActbase[5]]=='')
		$PDIGIMAActbase[5]='Others';

	if($languageData[trim($PDIGIMAActbase[8])]!='')
		$lang=$languageData[$PDIGIMAActbase[8]];
	else
		$lang=trim($PDIGIMAActbase[8]);
	$PDIGIMAPendingBasedata=$view_date1."|".trim($PDIGIMAActbase[0])."|".trim($PDIGIMAActbase[1])."|".trim($PDIGIMAActbase[2])."|".trim($PDIGIMAActbase[3])."|".trim($PDIGIMAActbase[4])."|".trim($circle_info[$PDIGIMAActbase[5]])."|".trim($PDIGIMAActbase[6])."|".trim($PDIGIMAActbase[7])."|".trim($lang)."|".trim($PDIGIMAActbase[15]).'|'.trim($PDIGIMAActbase[15]).'|'.trim($PDIGIMAActbase[15])."\r\n";
	error_log($PDIGIMAPendingBasedata,3,$PDIGIMAFilePath) ;
}
	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$PDIGIMAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump12,$LivdbConn);


//////////////////////////////////////////////////// End Pending Nepali DIGIMA/////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////// code End to dump Active base for TuneTalk Operator///////////////////////////////////////////////////

mysql_close($dbConn);

?>
<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$activeDir="/var/www/html/kmis/testing/activeBase/";

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fview_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$fileDate= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');

////////////////////////////////////////////////////Start RedFMTataDoCoMovmi//////////////////////////////////////////////////////////////////////////

$RedFMTataDoCoMovmiFile="1810/RedFMTataDoCoMovmi_".$fileDate.".txt";
$RedFMTataDoCoMovmiFilePath=$activeDir.$RedFMTataDoCoMovmiFile;

	unlink($RedFMTataDoCoMovmiFilePath);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RedFMTataDoCoMovmi' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);


$getActiveBaseQ7="select 'RedFMTataDoCoMovmi',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_redfm.tbl_jbox_subscription where status=1 and plan_id=72 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($RedFMTataDoCoMovmiActbase = mysql_fetch_array($query7))
{
	if($circle_info[$RedFMTataDoCoMovmiActbase[5]]=='')
		$RedFMTataDoCoMovmiActbase[5]='Others';

	if($languageData[trim($RedFMTataDoCoMovmiActbase[8])]!='')
		$lang=$languageData[$RedFMTataDoCoMovmiActbase[8]];
	else
		$lang=trim($RedFMTataDoCoMovmiActbase[8]);
	$RedFMTataDoCoMovmiActiveBasedata=$view_date1."|".trim($RedFMTataDoCoMovmiActbase[0])."|".trim($RedFMTataDoCoMovmiActbase[1])."|".trim($RedFMTataDoCoMovmiActbase[2])."|".trim($RedFMTataDoCoMovmiActbase[3])."|".trim($RedFMTataDoCoMovmiActbase[4])."|".trim($circle_info[$RedFMTataDoCoMovmiActbase[5]])."|".trim($RedFMTataDoCoMovmiActbase[6])."|".trim($RedFMTataDoCoMovmiActbase[7])."|".trim($lang)."|".trim($RedFMTataDoCoMovmiActbase[15]).'|'.trim($RedFMTataDoCoMovmiActbase[15]).'|'.trim($RedFMTataDoCoMovmiActbase[15])."\r\n";
	error_log($RedFMTataDoCoMovmiActiveBasedata,3,$RedFMTataDoCoMovmiFilePath) ;
}
	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$RedFMTataDoCoMovmiFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump7,$LivdbConn);

//////////////////////////////////////////////////// End RedFMTataDoCoMovmi/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start RIATataDoCoMovmi//////////////////////////////////////////////////////////////////////////

$RIATataDoCoMovmiFile="1809/RIATataDoCoMovmi_".$fileDate.".txt";
$RIATataDoCoMovmiFilePath=$activeDir.$RIATataDoCoMovmiFile;

	unlink($RIATataDoCoMovmiFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RIATataDoCoMovmi' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);


$getActiveBaseQ7="select 'RIATataDoCoMovmi',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_manchala.tbl_riya_subscription where status=1 and plan_id=73 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($RIATataDoCoMovmiActbase = mysql_fetch_array($query7))
{
	if($circle_info[$RIATataDoCoMovmiActbase[5]]=='')
		$RIATataDoCoMovmiActbase[5]='Others';

	if($languageData[trim($RIATataDoCoMovmiActbase[8])]!='')
		$lang=$languageData[$RIATataDoCoMovmiActbase[8]];
	else
		$lang=trim($RIATataDoCoMovmiActbase[8]);
	$RIATataDoCoMovmiActiveBasedata=$view_date1."|".trim($RIATataDoCoMovmiActbase[0])."|".trim($RIATataDoCoMovmiActbase[1])."|".trim($RIATataDoCoMovmiActbase[2])."|".trim($RIATataDoCoMovmiActbase[3])."|".trim($RIATataDoCoMovmiActbase[4])."|".trim($circle_info[$RIATataDoCoMovmiActbase[5]])."|".trim($RIATataDoCoMovmiActbase[6])."|".trim($RIATataDoCoMovmiActbase[7])."|".trim($lang)."|".trim($RIATataDoCoMovmiActbase[15]).'|'.trim($RIATataDoCoMovmiActbase[15]).'|'.trim($RIATataDoCoMovmiActbase[15])."\r\n";
	error_log($RIATataDoCoMovmiActiveBasedata,3,$RIATataDoCoMovmiFilePath) ;
}
	$insertDump8= 'LOAD DATA LOCAL INFILE "'.$RIATataDoCoMovmiFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump8,$LivdbConn);


//////////////////////////////////////////////////// End RIATataDoCoMovmi/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start TataDoCoMoMXvmi//////////////////////////////////////////////////////////////////////////

$TataDoCoMoMXvmiFile="1801/TataDoCoMoMXvmi_".$fileDate.".txt";
$TataDoCoMoMXvmiFilePath=$activeDir.$TataDoCoMoMXvmiFile;

	unlink($TataDoCoMoMXvmiFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='TataDoCoMoMXvmi' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);


$getActiveBaseQ7="select 'TataDoCoMoMXvmi',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_radio.tbl_radio_subscription where status=1 and plan_id=40 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($TataDoCoMoMXvmiActbase = mysql_fetch_array($query7))
{
	if($circle_info[$TataDoCoMoMXvmiActbase[5]]=='')
		$TataDoCoMoMXvmiActbase[5]='Others';

	if($languageData[trim($TataDoCoMoMXvmiActbase[8])]!='')
		$lang=$languageData[$TataDoCoMoMXvmiActbase[8]];
	else
		$lang=trim($TataDoCoMoMXvmiActbase[8]);
	$TataDoCoMoMXvmiActiveBasedata=$view_date1."|".trim($TataDoCoMoMXvmiActbase[0])."|".trim($TataDoCoMoMXvmiActbase[1])."|".trim($TataDoCoMoMXvmiActbase[2])."|".trim($TataDoCoMoMXvmiActbase[3])."|".trim($TataDoCoMoMXvmiActbase[4])."|".trim($circle_info[$TataDoCoMoMXvmiActbase[5]])."|".trim($TataDoCoMoMXvmiActbase[6])."|".trim($TataDoCoMoMXvmiActbase[7])."|".trim($lang)."|".trim($TataDoCoMoMXvmiActbase[15]).'|'.trim($TataDoCoMoMXvmiActbase[15]).'|'.trim($TataDoCoMoMXvmiActbase[15])."\r\n";
	error_log($TataDoCoMoMXvmiActiveBasedata,3,$TataDoCoMoMXvmiFilePath) ;
}
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$TataDoCoMoMXvmiFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);


//////////////////////////////////////////////////// End TataDoCoMoMXvmi/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending RedFMTataDoCoMovmi//////////////////////////////////////////////////////////////////////////

$PRedFMTataDoCoMovmiFile="1810/PRedFMTataDoCoMovmi_".$fileDate.".txt";
$PRedFMTataDoCoMovmiFilePath=$activeDir.$PRedFMTataDoCoMovmiFile;

	unlink($PRedFMTataDoCoMovmiFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RedFMTataDoCoMovmi' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);


$getPendingBaseQ7="select 'RedFMTataDoCoMovmi',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from docomo_redfm.tbl_jbox_subscription where status IN (11,0,5) and plan_id=72 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PRedFMTataDoCoMovmiActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PRedFMTataDoCoMovmiActbase[5]]=='')
		$PRedFMTataDoCoMovmiActbase[5]='Others';

	if($languageData[trim($PRedFMTataDoCoMovmiActbase[8])]!='')
		$lang=$languageData[$PRedFMTataDoCoMovmiActbase[8]];
	else
		$lang=trim($PRedFMTataDoCoMovmiActbase[8]);
	$PRedFMTataDoCoMovmiPendingBasedata=$view_date1."|".trim($PRedFMTataDoCoMovmiActbase[0])."|".trim($PRedFMTataDoCoMovmiActbase[1])."|".trim($PRedFMTataDoCoMovmiActbase[2])."|".trim($PRedFMTataDoCoMovmiActbase[3])."|".trim($PRedFMTataDoCoMovmiActbase[4])."|".trim($circle_info[$PRedFMTataDoCoMovmiActbase[5]])."|".trim($PRedFMTataDoCoMovmiActbase[6])."|".trim($PRedFMTataDoCoMovmiActbase[7])."|".trim($lang)."|".trim($PRedFMTataDoCoMovmiActbase[15]).'|'.trim($PRedFMTataDoCoMovmiActbase[15]).'|'.trim($PRedFMTataDoCoMovmiActbase[15])."\r\n";
	error_log($PRedFMTataDoCoMovmiPendingBasedata,3,$PRedFMTataDoCoMovmiFilePath) ;
}
	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$PRedFMTataDoCoMovmiFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump10,$LivdbConn);


//////////////////////////////////////////////////// End Pending PRedFMTataDoCoMovmi/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending RIATataDoCoMovmi//////////////////////////////////////////////////////////////////////////

$PRIATataDoCoMovmiFile="1809/PRIATataDoCoMovmi_".$fileDate.".txt";
$PRIATataDoCoMovmiFilePath=$activeDir.$PRIATataDoCoMovmiFile;

	unlink($PRIATataDoCoMovmiFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RIATataDoCoMovmi' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);


$getPendingBaseQ7="select 'RIATataDoCoMovmi',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from docomo_manchala.tbl_riya_subscription where status IN (11,0,5) and plan_id=73 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PRIATataDoCoMovmiActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PRIATataDoCoMovmiActbase[5]]=='')
		$PRIATataDoCoMovmiActbase[5]='Others';

	if($languageData[trim($PRIATataDoCoMovmiActbase[8])]!='')
		$lang=$languageData[$PRIATataDoCoMovmiActbase[8]];
	else
		$lang=trim($PRIATataDoCoMovmiActbase[8]);
	$PRIATataDoCoMovmiPendingBasedata=$view_date1."|".trim($PRIATataDoCoMovmiActbase[0])."|".trim($PRIATataDoCoMovmiActbase[1])."|".trim($PRIATataDoCoMovmiActbase[2])."|".trim($PRIATataDoCoMovmiActbase[3])."|".trim($PRIATataDoCoMovmiActbase[4])."|".trim($circle_info[$PRIATataDoCoMovmiActbase[5]])."|".trim($PRIATataDoCoMovmiActbase[6])."|".trim($PRIATataDoCoMovmiActbase[7])."|".trim($lang)."|".trim($PRIATataDoCoMovmiActbase[15]).'|'.trim($PRIATataDoCoMovmiActbase[15]).'|'.trim($PRIATataDoCoMovmiActbase[15])."\r\n";
	error_log($PRIATataDoCoMovmiPendingBasedata,3,$PRIATataDoCoMovmiFilePath) ;
}
	$insertDump11= 'LOAD DATA LOCAL INFILE "'.$PRIATataDoCoMovmiFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump11,$LivdbConn);


//////////////////////////////////////////////////// End Pending RIATataDoCoMovmi/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending TataDoCoMoMXvmi//////////////////////////////////////////////////////////////////////////

$PTataDoCoMoMXvmiFile="1801/PTataDoCoMoMXvmi_".$fileDate.".txt";
$PTataDoCoMoMXvmiFilePath=$activeDir.$PTataDoCoMoMXvmiFile;

	unlink($PTataDoCoMoMXvmiFilePath);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='TataDoCoMoMXvmi' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);


$getPendingBaseQ7="select 'TataDoCoMoMXvmi',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from docomo_radio.tbl_radio_subscription where status IN (11,0,5) and plan_id=40 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PTataDoCoMoMXvmiActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PTataDoCoMoMXvmiActbase[5]]=='')
		$PTataDoCoMoMXvmiActbase[5]='Others';

	if($languageData[trim($PTataDoCoMoMXvmiActbase[8])]!='')
		$lang=$languageData[$PTataDoCoMoMXvmiActbase[8]];
	else
		$lang=trim($PTataDoCoMoMXvmiActbase[8]);
	$PTataDoCoMoMXvmiPendingBasedata=$view_date1."|".trim($PTataDoCoMoMXvmiActbase[0])."|".trim($PTataDoCoMoMXvmiActbase[1])."|".trim($PTataDoCoMoMXvmiActbase[2])."|".trim($PTataDoCoMoMXvmiActbase[3])."|".trim($PTataDoCoMoMXvmiActbase[4])."|".trim($circle_info[$PTataDoCoMoMXvmiActbase[5]])."|".trim($PTataDoCoMoMXvmiActbase[6])."|".trim($PTataDoCoMoMXvmiActbase[7])."|".trim($lang)."|".trim($PTataDoCoMoMXvmiActbase[15]).'|'.trim($PTataDoCoMoMXvmiActbase[15]).'|'.trim($PTataDoCoMoMXvmiActbase[15])."\r\n";
	error_log($PTataDoCoMoMXvmiPendingBasedata,3,$PTataDoCoMoMXvmiFilePath) ;
}
	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$PTataDoCoMoMXvmiFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump12,$LivdbConn);


//////////////////////////////////////////////////// End Pending TataDoCoMoMXvmi/////////////////////////////////////////////////////////////////////////

/*
////////////////////////////////////////////////////Start AATataDoCoMovmi//////////////////////////////////////////////////////////////////////////

$AATataDoCoMovmiFile="1801/AATataDoCoMovmi_".$fileDate.".txt";
$AATataDoCoMovmiFilePath=$activeDir.$AATataDoCoMovmiFile;

if(file_exists($AATataDoCoMovmiFilePath))
{
	unlink($AATataDoCoMovmiFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AATataDoCoMovmi' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
}

$getActiveBaseQ7="select 'AATataDoCoMovmi',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_radio.tbl_radio_subscription where status=1 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($AATataDoCoMovmiActbase = mysql_fetch_array($query7))
{
	if($circle_info[$AATataDoCoMovmiActbase[5]]=='')
		$AATataDoCoMovmiActbase[5]='Others';

	if($languageData[trim($AATataDoCoMovmiActbase[8])]!='')
		$lang=$languageData[$AATataDoCoMovmiActbase[8]];
	else
		$lang=trim($AATataDoCoMovmiActbase[8]);
	$AATataDoCoMovmiActiveBasedata=$view_date1."|".trim($AATataDoCoMovmiActbase[0])."|".trim($AATataDoCoMovmiActbase[1])."|".trim($AATataDoCoMovmiActbase[2])."|".trim($AATataDoCoMovmiActbase[3])."|".trim($AATataDoCoMovmiActbase[4])."|".trim($circle_info[$AATataDoCoMovmiActbase[5]])."|".trim($AATataDoCoMovmiActbase[6])."|".trim($AATataDoCoMovmiActbase[7])."|".trim($lang)."|".trim($AATataDoCoMovmiActbase[15]).'|'.trim($AATataDoCoMovmiActbase[15]).'|'.trim($AATataDoCoMovmiActbase[15])."\r\n";
	error_log($AATataDoCoMovmiActiveBasedata,3,$AATataDoCoMovmiFilePath) ;
}
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$AATataDoCoMovmiFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);


//////////////////////////////////////////////////// End AATataDoCoMovmi/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending AATataDoCoMovmi//////////////////////////////////////////////////////////////////////////

$PAATataDoCoMovmiFile="1801/PAATataDoCoMovmi_".$fileDate.".txt";
$PAATataDoCoMovmiFilePath=$activeDir.$PAATataDoCoMovmiFile;

if(file_exists($PAATataDoCoMovmiFilePath))
{
	unlink($PAATataDoCoMovmiFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AATataDoCoMovmi' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
}

$getPendingBaseQ7="select 'AATataDoCoMovmi',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from docomo_radio.tbl_radio_subscription where status!=1 and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PAATataDoCoMovmiActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PAATataDoCoMovmiActbase[5]]=='')
		$PAATataDoCoMovmiActbase[5]='Others';

	if($languageData[trim($PAATataDoCoMovmiActbase[8])]!='')
		$lang=$languageData[$PAATataDoCoMovmiActbase[8]];
	else
		$lang=trim($PAATataDoCoMovmiActbase[8]);
	$PAATataDoCoMovmiPendingBasedata=$view_date1."|".trim($PAATataDoCoMovmiActbase[0])."|".trim($PAATataDoCoMovmiActbase[1])."|".trim($PAATataDoCoMovmiActbase[2])."|".trim($PAATataDoCoMovmiActbase[3])."|".trim($PAATataDoCoMovmiActbase[4])."|".trim($circle_info[$PAATataDoCoMovmiActbase[5]])."|".trim($PAATataDoCoMovmiActbase[6])."|".trim($PAATataDoCoMovmiActbase[7])."|".trim($lang)."|".trim($PAATataDoCoMovmiActbase[15]).'|'.trim($PAATataDoCoMovmiActbase[15]).'|'.trim($PAATataDoCoMovmiActbase[15])."\r\n";
	error_log($PAATataDoCoMovmiPendingBasedata,3,$PAATataDoCoMovmiFilePath) ;
}
	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$PAATataDoCoMovmiFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump12,$LivdbConn);


//////////////////////////////////////////////////// End Pending AATataDoCoMovmi/////////////////////////////////////////////////////////////////////////
*/

////////////////////////////////////////////////////Start TataDoCoMoMNDvmi//////////////////////////////////////////////////////////////////////////

$TataDoCoMoMNDvmiFile="1013/TataDoCoMoMNDvmi_".$fileDate.".txt";
$TataDoCoMoMNDvmiFilePath=$activeDir.$TataDoCoMoMNDvmiFile;

	unlink($TataDoCoMoMNDvmiFilePath);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='TataDoCoMoMNDvmi' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);

$getActiveBaseQ7="select 'TataDoCoMoMNDvmi',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_mnd.tbl_character_subscription1 where status=1 and plan_id='164' and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($TataDoCoMoMNDvmiActbase = mysql_fetch_array($query7))
{
	if($circle_info[$TataDoCoMoMNDvmiActbase[5]]=='')
		$TataDoCoMoMNDvmiActbase[5]='Others';

	if($languageData[trim($TataDoCoMoMNDvmiActbase[8])]!='')
		$lang=$languageData[$TataDoCoMoMNDvmiActbase[8]];
	else
		$lang=trim($TataDoCoMoMNDvmiActbase[8]);
	$TataDoCoMoMNDvmiActiveBasedata=$view_date1."|".trim($TataDoCoMoMNDvmiActbase[0])."|".trim($TataDoCoMoMNDvmiActbase[1])."|".trim($TataDoCoMoMNDvmiActbase[2])."|".trim($TataDoCoMoMNDvmiActbase[3])."|".trim($TataDoCoMoMNDvmiActbase[4])."|".trim($circle_info[$TataDoCoMoMNDvmiActbase[5]])."|".trim($TataDoCoMoMNDvmiActbase[6])."|".trim($TataDoCoMoMNDvmiActbase[7])."|".trim($lang)."|".trim($TataDoCoMoMNDvmiActbase[15]).'|'.trim($TataDoCoMoMNDvmiActbase[15]).'|'.trim($TataDoCoMoMNDvmiActbase[15])."\r\n";
	error_log($TataDoCoMoMNDvmiActiveBasedata,3,$TataDoCoMoMNDvmiFilePath) ;
}
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$TataDoCoMoMNDvmiFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);


//////////////////////////////////////////////////// End TataDoCoMoMNDvmi/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending TataDoCoMoMNDvmi//////////////////////////////////////////////////////////////////////////

$PTataDoCoMoMNDvmiFile="1013/PTataDoCoMoMNDvmi_".$fileDate.".txt";
$PTataDoCoMoMNDvmiFilePath=$activeDir.$PTataDoCoMoMNDvmiFile;


	unlink($PTataDoCoMoMNDvmiFilePath);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='TataDoCoMoMNDvmi' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);


$getPendingBaseQ7="select 'TataDoCoMoMNDvmi',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from docomo_mnd.tbl_character_subscription1 where status IN (11,0,5) and plan_id='164' and date(sub_date)<='".$view_date1."'";
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PTataDoCoMoMNDvmiActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PTataDoCoMoMNDvmiActbase[5]]=='')
		$PTataDoCoMoMNDvmiActbase[5]='Others';

	if($languageData[trim($PTataDoCoMoMNDvmiActbase[8])]!='')
		$lang=$languageData[$PTataDoCoMoMNDvmiActbase[8]];
	else
		$lang=trim($PTataDoCoMoMNDvmiActbase[8]);
	$PTataDoCoMoMNDvmiPendingBasedata=$view_date1."|".trim($PTataDoCoMoMNDvmiActbase[0])."|".trim($PTataDoCoMoMNDvmiActbase[1])."|".trim($PTataDoCoMoMNDvmiActbase[2])."|".trim($PTataDoCoMoMNDvmiActbase[3])."|".trim($PTataDoCoMoMNDvmiActbase[4])."|".trim($circle_info[$PTataDoCoMoMNDvmiActbase[5]])."|".trim($PTataDoCoMoMNDvmiActbase[6])."|".trim($PTataDoCoMoMNDvmiActbase[7])."|".trim($lang)."|".trim($PTataDoCoMoMNDvmiActbase[15]).'|'.trim($PTataDoCoMoMNDvmiActbase[15]).'|'.trim($PTataDoCoMoMNDvmiActbase[15])."\r\n";
	error_log($PTataDoCoMoMNDvmiPendingBasedata,3,$PTataDoCoMoMNDvmiFilePath) ;
}
	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$PTataDoCoMoMNDvmiFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump12,$LivdbConn);


//////////////////////////////////////////////////// End Pending TataDoCoMoMNDvmi/////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////

mysql_close($dbConn);
mysql_close($LivdbConn);


?>
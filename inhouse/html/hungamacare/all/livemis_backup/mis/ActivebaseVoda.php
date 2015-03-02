<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectVoda.php");
$activeDir="/var/www/html/kmis/testing/activeBase/";

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fview_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$fileDate= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

 
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');

////////////////////////////////////////////////////Start Voda MTV//////////////////////////////////////////////////////////////////////////

$VodaMTVFile="1303/MTVVodafone_".$fileDate.".txt";
$VodaMTVFilePath=$activeDir.$VodaMTVFile;

if(file_exists($VodaMTVFilePath))
{
	unlink($VodaMTVFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='Vodafone54646' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del1="delete from master_db.tbl_activepending_base where date(date)='".$view_date1."' and service='Vodafone54646' and status='Active'";
	$delquery = mysql_query($del1,$dbConnVoda);
}

$getActiveBaseQ7="select 'Vodafone54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from vodafone_hungama.tbl_jbox_subscription nolock where status=1 and dnis not like '%P%' and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConnVoda);
while($VodaMtvActbase = mysql_fetch_array($query7))
{
	if($circle_info[$VodaMtvActbase[5]]=='')
		$VodaMtvActbase[5]='Others';

	if($languageData[trim($VodaMtvActbase[8])]!='')
		$lang=$languageData[$VodaMtvActbase[8]];
	else
		$lang=trim($VodaMtvActbase[8]);
	$VodaMTVActiveBasedata=$view_date1."|".trim($VodaMtvActbase[0])."|".trim($VodaMtvActbase[1])."|".trim($VodaMtvActbase[2])."|".trim($VodaMtvActbase[3])."|".trim($VodaMtvActbase[4])."|".trim($circle_info[$VodaMtvActbase[5]])."|".trim($VodaMtvActbase[6])."|".trim($VodaMtvActbase[7])."|".trim($lang)."|".trim($VodaMtvActbase[15]).'|'.trim($VodaMtvActbase[15]).'|'.trim($VodaMtvActbase[15])."\r\n";
	error_log($VodaMTVActiveBasedata,3,$VodaMTVFilePath) ;
}
	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$VodaMTVFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump7,$LivdbConn);
	$insertDump71= 'LOAD DATA LOCAL INFILE "'.$VodaMTVFilePath.'" INTO TABLE master_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 		(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump71,$dbConnVoda);

//////////////////////////////////////////////////// End Voda MTV/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Voda REDFM//////////////////////////////////////////////////////////////////////////

$VodaRedFMFile="1310/RedFMVodafone_".$fileDate.".txt";
$VodaRedFMFilePath=$activeDir.$VodaRedFMFile;

if(file_exists($VodaRedFMFilePath))
{
	unlink($VodaRedFMFilePath);
	echo $del11="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RedFMVodafone' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
	echo $del11="delete from master_db.tbl_activepending_base where date(date)='".$view_date1."' and service='RedFMVodafone' and status='Active'";
	$delquery = mysql_query($del11,$dbConnVoda);
}

$getActiveBaseQ7="select 'RedFMVodafone',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from vodafone_redfm.tbl_jbox_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConnVoda);
while($VodaRedFMActbase = mysql_fetch_array($query7))
{
	if($circle_info[$VodaRedFMActbase[5]]=='')
		$VodaRedFMActbase[5]='Others';

	if($languageData[trim($VodaRedFMActbase[8])]!='')
		$lang=$languageData[$VodaRedFMActbase[8]];
	else
		$lang=trim($VodaRedFMActbase[8]);
	$VodaRedFMActiveBasedata=$view_date1."|".trim($VodaRedFMActbase[0])."|".trim($VodaRedFMActbase[1])."|".trim($VodaRedFMActbase[2])."|".trim($VodaRedFMActbase[3])."|".trim($VodaRedFMActbase[4])."|".trim($circle_info[$VodaRedFMActbase[5]])."|".trim($VodaRedFMActbase[6])."|".trim($VodaRedFMActbase[7])."|".trim($lang)."|".trim($VodaRedFMActbase[15]).'|'.trim($VodaRedFMActbase[15]).'|'.trim($VodaRedFMActbase[15])."\r\n";
	error_log($VodaRedFMActiveBasedata,3,$VodaRedFMFilePath) ;
}
	$insertDump8= 'LOAD DATA LOCAL INFILE "'.$VodaRedFMFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump8,$LivdbConn);
	$insertDump81= 'LOAD DATA LOCAL INFILE "'.$VodaRedFMFilePath.'" INTO TABLE master_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 		(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump81,$dbConnVoda);

//////////////////////////////////////////////////// End Voda REDFM/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Voda VH1//////////////////////////////////////////////////////////////////////////

$VodaVH1File="1307/VH1Vodafone_".$fileDate.".txt";
$VodaVH1FilePath=$activeDir.$VodaVH1File;

if(file_exists($VodaVH1FilePath))
{
	unlink($VodaVH1FilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='VH1Vodafone' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
	echo $del11="delete from master_db.tbl_activepending_base where date(date)='".$view_date1."' and service='VH1Vodafone' and status='Active'";
	$delquery = mysql_query($del11,$dbConnVoda);
}

$getActiveBaseQ7="select 'VH1Vodafone',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from vodafone_vh1.tbl_jbox_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConnVoda);
while($VodaVH1Actbase = mysql_fetch_array($query7))
{
	if($circle_info[$VodaVH1Actbase[5]]=='')
		$VodaVH1Actbase[5]='Others';

	if($languageData[trim($VodaVH1Actbase[8])]!='')
		$lang=$languageData[$VodaVH1Actbase[8]];
	else
		$lang=trim($VodaVH1Actbase[8]);
	$VodaVH1ActiveBasedata=$view_date1."|".trim($VodaVH1Actbase[0])."|".trim($VodaVH1Actbase[1])."|".trim($VodaVH1Actbase[2])."|".trim($VodaVH1Actbase[3])."|".trim($VodaVH1Actbase[4])."|".trim($circle_info[$VodaVH1Actbase[5]])."|".trim($VodaVH1Actbase[6])."|".trim($VodaVH1Actbase[7])."|".trim($lang)."|".trim($VodaVH1Actbase[15]).'|'.trim($VodaVH1Actbase[15]).'|'.trim($VodaVH1Actbase[15])."\r\n";
	error_log($VodaVH1ActiveBasedata,3,$VodaVH1FilePath) ;
}
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$VodaVH1FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);
	$insertDump91= 'LOAD DATA LOCAL INFILE "'.$VodaVH1FilePath.'" INTO TABLE master_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 		(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump91,$dbConnVoda);

//////////////////////////////////////////////////// End Voda VH1/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending Voda MTV//////////////////////////////////////////////////////////////////////////

$PVodaMTVFile="1303/PMTVVodafone_".$fileDate.".txt";
$PVodaMTVFilePath=$activeDir.$PVodaMTVFile;

if(file_exists($PVodaMTVFilePath))
{
	unlink($PVodaMTVFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='Vodafone54646' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);
	echo $del11="delete from master_db.tbl_activepending_base where date(date)='".$view_date1."' and service='Vodafone54646' and status='Pending'";
	$delquery = mysql_query($del11,$dbConnVoda);
}

$getPendingBaseQ7="select 'Vodafone54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from vodafone_hungama.tbl_jbox_subscription nolock where status=11 and dnis not like '%P%' and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConnVoda);
while($PVodaMTVActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PVodaMTVActbase[5]]=='')
		$PVodaMTVActbase[5]='Others';

	if($languageData[trim($PVodaMTVActbase[8])]!='')
		$lang=$languageData[$PVodaMTVActbase[8]];
	else
		$lang=trim($PVodaMTVActbase[8]);
	$PVodaMTVPendingBasedata=$view_date1."|".trim($PVodaMTVActbase[0])."|".trim($PVodaMTVActbase[1])."|".trim($PVodaMTVActbase[2])."|".trim($PVodaMTVActbase[3])."|".trim($PVodaMTVActbase[4])."|".trim($circle_info[$PVodaMTVActbase[5]])."|".trim($PVodaMTVActbase[6])."|".trim($PVodaMTVActbase[7])."|".trim($lang)."|".trim($PVodaMTVActbase[15]).'|'.trim($PVodaMTVActbase[15]).'|'.trim($PVodaMTVActbase[15])."\r\n";
	error_log($PVodaMTVPendingBasedata,3,$PVodaMTVFilePath) ;
}
	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$PVodaMTVFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump10,$LivdbConn);
	$insertDump101= 'LOAD DATA LOCAL INFILE "'.$PVodaMTVFilePath.'" INTO TABLE master_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 		(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump101,$dbConnVoda);

//////////////////////////////////////////////////// End Pending Voda MTV/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending Voda REDFM//////////////////////////////////////////////////////////////////////////

$PVodaRedFMFile="1310/PRedFMVodafone_".$fileDate.".txt";
$PVodaRedFMFilePath=$activeDir.$PVodaRedFMFile;

if(file_exists($PVodaRedFMFilePath))
{
	unlink($PVodaRedFMFilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RedFMVodafone' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
	echo $del11="delete from master_db.tbl_activepending_base where date(date)='".$view_date1."' and service='RedFMVodafone' and status='Pending'";
	$delquery = mysql_query($del11,$dbConnVoda);
}

$getPendingBaseQ7="select 'RedFMVodafone',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from vodafone_redfm.tbl_jbox_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConnVoda);
while($PVodaRedFMActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PVodaRedFMActbase[5]]=='')
		$PVodaRedFMActbase[5]='Others';

	if($languageData[trim($PVodaRedFMActbase[8])]!='')
		$lang=$languageData[$PVodaRedFMActbase[8]];
	else
		$lang=trim($PVodaRedFMActbase[8]);
	$PVodaRedFMPendingBasedata=$view_date1."|".trim($PVodaRedFMActbase[0])."|".trim($PVodaRedFMActbase[1])."|".trim($PVodaRedFMActbase[2])."|".trim($PVodaRedFMActbase[3])."|".trim($PVodaRedFMActbase[4])."|".trim($circle_info[$PVodaRedFMActbase[5]])."|".trim($PVodaRedFMActbase[6])."|".trim($PVodaRedFMActbase[7])."|".trim($lang)."|".trim($PVodaRedFMActbase[15]).'|'.trim($PVodaRedFMActbase[15]).'|'.trim($PVodaRedFMActbase[15])."\r\n";
	error_log($PVodaRedFMPendingBasedata,3,$PVodaRedFMFilePath) ;
}
	$insertDump11= 'LOAD DATA LOCAL INFILE "'.$PVodaRedFMFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump11,$LivdbConn);
	$insertDump111= 'LOAD DATA LOCAL INFILE "'.$PVodaRedFMFilePath.'" INTO TABLE master_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 		(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump111,$dbConnVoda);

//////////////////////////////////////////////////// End Pending Voda REDFM/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending Voda VH1//////////////////////////////////////////////////////////////////////////

$PVodaVH1File="1307/PVH1Vodafone_".$fileDate.".txt";
$PVodaVH1FilePath=$activeDir.$PVodaVH1File;

if(file_exists($PVodaVH1FilePath))
{
	unlink($PVodaVH1FilePath);
	echo $del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='VH1Vodafone' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
	echo $del11="delete from master_db.tbl_activepending_base where date(date)='".$view_date1."' and service='VH1Vodafone' and status='Pending'";
	$delquery = mysql_query($del11,$dbConnVoda);
}

$getPendingBaseQ7="select 'VH1Vodafone',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from vodafone_vh1.tbl_jbox_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConnVoda);
while($PVodaVH1Actbase = mysql_fetch_array($query7))
{
	if($circle_info[$PVodaVH1Actbase[5]]=='')
		$PVodaVH1Actbase[5]='Others';

	if($languageData[trim($PVodaVH1Actbase[8])]!='')
		$lang=$languageData[$PVodaVH1Actbase[8]];
	else
		$lang=trim($PVodaVH1Actbase[8]);
	$PVodaVH1PendingBasedata=$view_date1."|".trim($PVodaVH1Actbase[0])."|".trim($PVodaVH1Actbase[1])."|".trim($PVodaVH1Actbase[2])."|".trim($PVodaVH1Actbase[3])."|".trim($PVodaVH1Actbase[4])."|".trim($circle_info[$PVodaVH1Actbase[5]])."|".trim($PVodaVH1Actbase[6])."|".trim($PVodaVH1Actbase[7])."|".trim($lang)."|".trim($PVodaVH1Actbase[15]).'|'.trim($PVodaVH1Actbase[15]).'|'.trim($PVodaVH1Actbase[15])."\r\n";
	error_log($PVodaVH1PendingBasedata,3,$PVodaVH1FilePath) ;
}
	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$PVodaVH1FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump7,$LivdbConn);
	$insertDump171= 'LOAD DATA LOCAL INFILE "'.$PVodaVH1FilePath.'" INTO TABLE master_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 		(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump171,$dbConnVoda);

//////////////////////////////////////////////////// End Pending Voda VH1/////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////

echo "done";
mysql_close($dbConnVoda);
mysql_close($LivdbConn);


?>

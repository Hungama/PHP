<?php

echo file_get_contents("http://115.248.233.131:8080/HourlyIntegration/RelianceMM_20130305.txt");

exit;
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$activeDir="/var/www/html/kmis/testing/activeBase/";

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fileDate= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

////////////////////////////////////////////////////Start Docomo MTV//////////////////////////////////////////////////////////////////////////

$docomoMTVFile="1003/MTVTataDoCoMo_".$fileDate.".txt";
$docomoMTVFilePath=$activeDir.$docomoMTVFile;

if(file_exists($docomoMTVFilePath))
{
	unlink($docomoMTVFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".$view_date1."' and service='MTVTataDoCoMo' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ7="select 'MTVTataDoCoMo',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_hungama.tbl_mtv_subscription where status=1"; 
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($docomoMtvActbase = mysql_fetch_array($query7))
{
	if($circle_info[$docomoMtvActbase[5]]=='')
		$docomoMtvActbase[5]='Others';
	$docomoMTVActiveBasedata=$view_date1."|".trim($docomoMtvActbase[0])."|".trim($docomoMtvActbase[1])."|".trim($docomoMtvActbase[2])."|".trim($docomoMtvActbase[3])."|".trim($docomoMtvActbase[4])."|".trim($circle_info[$docomoMtvActbase[5]])."|".trim($docomoMtvActbase[6])."|".trim($docomoMtvActbase[7])."|".trim($docomoMtvActbase[8])."|".trim($docomoMtvActbase[15]).'|'.trim($docomoMtvActbase[15]).'|'.trim($docomoMtvActbase[15])."\r\n";
	error_log($docomoMTVActiveBasedata,3,$docomoMTVFilePath) ;
}
	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$docomoMTVFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump7,$LivdbConn);

//////////////////////////////////////////////////// End Docomo MTV//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////// Start Docomo MTV//////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Docomo 54646//////////////////////////////////////////////////////////////////////////

$docomo54646File="1002/TataDoCoMo54646_".$fileDate.".txt";
$docomo54646FilePath=$activeDir.$docomo54646File;

if(file_exists($docomo54646FilePath))
{
	unlink($docomo54646FilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".$view_date1."' and service='TataDoCoMo54646' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ8="select 'TataDoCoMo54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_hungama.tbl_jbox_subscription where status=1"; 
$query8 = mysql_query($getActiveBaseQ8,$dbConn);
while($docomo54646Actbase = mysql_fetch_array($query8))
{
	if($circle_info[$docomo54646Actbase[5]]=='')
		$docomo54646Actbase[5]='Others';
	$docomo5464ActiveBasedata=$view_date1."|".trim($docomo54646Actbase[0])."|".trim($docomo54646Actbase[1])."|".trim($docomo54646Actbase[2])."|".trim($docomo54646Actbase[3])."|".trim($docomo54646Actbase[4])."|".trim($circle_info[$docomo54646Actbase[5]])."|".trim($docomo54646Actbase[6])."|".trim($docomo54646Actbase[7])."|".trim($docomo54646Actbase[8])."|".trim($docomo54646Actbase[15]).'|'.trim($docomo54646Actbase[15]).'|'.trim($docomo54646Actbase[15])."\r\n";

	error_log($docomo5464ActiveBasedata,3,$docomo54646FilePath) ;

}
	$insertDump8= 'LOAD DATA LOCAL INFILE "'.$docomo54646FilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump8,$LivdbConn);

//////////////////////////////////////////////////// End Docomo 54646//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Docomo Redfm//////////////////////////////////////////////////////////////////////////

$docomoREDFMFile="1010/RedFMTataDoCoMo_".$fileDate.".txt";
$docomoREDFMFilePath=$activeDir.$docomoREDFMFile;

if(file_exists($docomoREDFMFilePath))
{
	unlink($docomoREDFMFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".$view_date1."' and service='RedFMTataDoCoMo' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ9="select 'RedFMTataDoCoMo',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_redfm.tbl_jbox_subscription where status=1"; 
$query9 = mysql_query($getActiveBaseQ9,$dbConn);
while($docomoREDFMActbase = mysql_fetch_array($query9))
{
	if($circle_info[$docomoREDFMActbase[5]]=='')
		$docomoREDFMActbase[5]='Others';

		$docomoREDFMActiveBasedata=$view_date1."|".trim($docomoREDFMActbase[0])."|".trim($docomoREDFMActbase[1])."|".trim($docomoREDFMActbase[2])."|".trim($docomoREDFMActbase[3])."|".trim($docomoREDFMActbase[4])."|".trim($circle_info[$docomoREDFMActbase[5]])."|".trim($docomoREDFMActbase[6])."|".trim($docomoREDFMActbase[7])."|".trim($docomoREDFMActbase[8])."|".trim($docomoREDFMActbase[15]).'|'.trim($docomoREDFMActbase[15]).'|'.trim($docomoREDFMActbase[15])."\r\n";

	error_log($docomoREDFMActiveBasedata,3,$docomoREDFMFilePath) ;

}
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$docomoREDFMFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);

//////////////////////////////////////////////////// End Docomo Redfm//////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////Start Docomo Ria//////////////////////////////////////////////////////////////////////////

$docomoRIAFile="1009/RIATataDoCoMo_".$fileDate.".txt";
$docomoRIAFilePath=$activeDir.$docomoRIAFile;

if(file_exists($docomoRIAFilePath))
{
	unlink($docomoRIAFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".$view_date1."' and service='RIATataDoCoMo' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ10="select 'RIATataDoCoMo',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_manchala.tbl_riya_subscription where status=1"; 
$query10 = mysql_query($getActiveBaseQ10,$dbConn);
while($docomoRIAActbase = mysql_fetch_array($query10))
{
	if($circle_info[$docomoRIAActbase[5]]=='')
		$docomoRIAActbase[5]='Others';

	$docomoRIAActiveBasedata=$view_date1."|".trim($docomoRIAActbase[0])."|".trim($docomoRIAActbase[1])."|".trim($docomoRIAActbase[2])."|".trim($docomoRIAActbase[3])."|".trim($docomoRIAActbase[4])."|".trim($circle_info[$docomoRIAActbase[5]])."|".trim($docomoRIAActbase[6])."|".trim($docomoRIAActbase[7])."|".trim($docomoRIAActbase[8])."|".trim($docomoRIAActbase[15]).'|'.trim($docomoRIAActbase[15]).'|'.trim($docomoRIAActbase[15])."\r\n";

	error_log($docomoRIAActiveBasedata,3,$docomoRIAFilePath) ;

}
	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$docomoRIAFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump10,$LivdbConn);

//////////////////////////////////////////////////// End Docomo Redfm//////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Docomo ENDLESS//////////////////////////////////////////////////////////////////////////

$docomoEndFile="1002/TataDoCoMoMX_".$fileDate.".txt";
$docomoENDFilePath=$activeDir.$docomoEndFile;

if(file_exists($docomoENDFilePath))
{
	unlink($docomoENDFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".$view_date1."' and service='TataDoCoMoMX' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ11="select 'TataDoCoMoMX',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_radio.tbl_radio_subscription where status=1"; 
$query11 = mysql_query($getActiveBaseQ11,$dbConn);
while($docomoENDActbase = mysql_fetch_array($query11))
{
	if($circle_info[$docomoENDActbase[5]]=='')
		$docomoENDActbase[5]='Others';
	$docomoENDActiveBasedata=$view_date1."|".trim($docomoENDActbase[0])."|".trim($docomoENDActbase[1])."|".trim($docomoENDActbase[2])."|".trim($docomoENDActbase[3])."|".trim($docomoENDActbase[4])."|".trim($circle_info[$docomoENDActbase[5]])."|".trim($docomoENDActbase[6])."|".trim($docomoENDActbase[7])."|".trim($docomoENDActbase[8])."|".trim($docomoENDActbase[15]).'|'.trim($docomoENDActbase[15]).'|'.trim($docomoENDActbase[15])."\r\n";

	error_log($docomoENDActiveBasedata,3,$docomoENDFilePath) ;

}
	$insertDump11= 'LOAD DATA LOCAL INFILE "'.$docomoENDFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump11,$LivdbConn);

//////////////////////////////////////////////////// End Docomo ENDLESS//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Docomo FMJ//////////////////////////////////////////////////////////////////////////

$docomoFMJFile="1005/TataDoCoMoFMJ_".$fileDate.".txt";
$docomoFMJFilePath=$activeDir.$docomoFMJFile;

if(file_exists($docomoFMJFilePath))
{
	unlink($docomoFMJFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".$view_date1."' and service='TataDoCoMoFMJ' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ12="select 'TataDoCoMoFMJ',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from docomo_starclub.tbl_jbox_subscription where status=1"; 
$query12 = mysql_query($getActiveBaseQ12,$dbConn);
while($docomoFMJActbase = mysql_fetch_array($query12))
{
	if($circle_info[$docomoFMJActbase[5]]=='')
		$docomoFMJActbase[5]='Others';
	$docomoFMJActiveBasedata=$view_date1."|".trim($docomoFMJActbase[0])."|".trim($docomoFMJActbase[1])."|".trim($docomoFMJActbase[2])."|".trim($docomoFMJActbase[3])."|".trim($docomoFMJActbase[4])."|".trim($circle_info[$docomoFMJActbase[5]])."|".trim($docomoFMJActbase[6])."|".trim($docomoFMJActbase[7])."|".trim($docomoFMJActbase[8])."|".trim($docomoFMJActbase[15]).'|'.trim($docomoFMJActbase[15]).'|'.trim($docomoFMJActbase[15])."\r\n";

	error_log($docomoFMJActiveBasedata,3,$docomoFMJFilePath) ;

}
	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$docomoFMJFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump12,$LivdbConn);

//////////////////////////////////////////////////// End Docomo FMJ//////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////

echo "done";
mysql_close($dbConn);
mysql_close($LivdbConn);


?>

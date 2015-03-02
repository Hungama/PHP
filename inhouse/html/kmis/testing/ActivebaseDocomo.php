<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");

$activeDir="/var/www/html/kmis/testing/activeBase/";

////////////////////////////////////////////////////Start Docomo MTV//////////////////////////////////////////////////////////////////////////

$docomoMTVFile="1003/MTVTataDoCoMo_".date('Ymd').".txt";
$docomoMTVFilePath=$activeDir.$docomoMTVFile;

if(file_exists($docomoMTVFilePath))
{
	unlink($docomoMTVFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".date('Y-m-d')."' and service='MTVTataDoCoMo'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ7="select 'MTVTataDoCoMo',ani,sub_date,renew_date,mode_of_sub,circle,user_bal,status,def_lang from docomo_hungama.tbl_mtv_subscription where status=1"; 
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($docomoMtvActbase = mysql_fetch_array($query7))
{
	$docomoMTVActiveBasedata=date('Y-m-d')."|".trim($docomoMtvActbase[0])."|".trim($docomoMtvActbase[1])."|".trim($docomoMtvActbase[2])."|".trim($docomoMtvActbase[3])."|".trim($docomoMtvActbase[4])."|".trim($docomoMtvActbase[5])."|".trim($docomoMtvActbase[6])."|".trim($docomoMtvActbase[7])."|".trim($docomoMtvActbase[8])."|".trim($docomoMtvActbase[15]).'|'.trim($docomoMtvActbase[15]).'|'.trim($docomoMtvActbase[15])."\r\n";
	error_log($docomoMTVActiveBasedata,3,$docomoMTVFilePath) ;
}
	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$docomoMTVFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump7,$LivdbConn);

//////////////////////////////////////////////////// End Docomo MTV//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////// Start Docomo MTV//////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Docomo 54646//////////////////////////////////////////////////////////////////////////

$docomo54646File="1002/TataDoCoMo54646_".date('Ymd').".txt";
$docomo54646FilePath=$activeDir.$docomo54646File;

if(file_exists($docomo54646FilePath))
{
	unlink($docomo54646FilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".date('Y-m-d')."' and service='TataDoCoMo54646'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ8="select 'TataDoCoMo54646',ani,sub_date,renew_date,mode_of_sub,circle,user_bal,status,def_lang from docomo_hungama.tbl_jbox_subscription where status=1"; 
$query8 = mysql_query($getActiveBaseQ8,$dbConn);
while($docomo54646Actbase = mysql_fetch_array($query8))
{
	$docomo5464ActiveBasedata=date('Y-m-d')."|".trim($docomo54646Actbase[0])."|".trim($docomo54646Actbase[1])."|".trim($docomo54646Actbase[2])."|".trim($docomo54646Actbase[3])."|".trim($docomo54646Actbase[4])."|".trim($docomo54646Actbase[5])."|".trim($docomo54646Actbase[6])."|".trim($docomo54646Actbase[7])."|".trim($docomo54646Actbase[8])."|".trim($docomo54646Actbase[15]).'|'.trim($docomo54646Actbase[15]).'|'.trim($docomo54646Actbase[15])."\r\n";

	error_log($docomo5464ActiveBasedata,3,$docomo54646FilePath) ;

}
	$insertDump8= 'LOAD DATA LOCAL INFILE "'.$docomo54646FilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump8,$LivdbConn);

//////////////////////////////////////////////////// End Docomo 54646//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Docomo Redfm//////////////////////////////////////////////////////////////////////////

$docomoREDFMFile="1010/RedFMTataDoCoMo_".date('Ymd').".txt";
$docomoREDFMFilePath=$activeDir.$docomoREDFMFile;

if(file_exists($docomoREDFMFilePath))
{
	unlink($docomoREDFMFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".date('Y-m-d')."' and service='RedFMTataDoCoMo'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ9="select 'RedFMTataDoCoMo',ani,sub_date,renew_date,mode_of_sub,circle,user_bal,status,def_lang from docomo_redfm.tbl_jbox_subscription where status=1"; 
$query9 = mysql_query($getActiveBaseQ9,$dbConn);
while($docomoREDFMActbase = mysql_fetch_array($query9))
{
	$docomoREDFMActiveBasedata=date('Y-m-d')."|".trim($docomoREDFMActbase[0])."|".trim($docomoREDFMActbase[1])."|".trim($docomoREDFMActbase[2])."|".trim($docomoREDFMActbase[3])."|".trim($docomoREDFMActbase[4])."|".trim($docomoREDFMActbase[5])."|".trim($docomoREDFMActbase[6])."|".trim($docomoREDFMActbase[7])."|".trim($docomoREDFMActbase[8])."|".trim($docomoREDFMActbase[15]).'|'.trim($docomoREDFMActbase[15]).'|'.trim($docomoREDFMActbase[15])."\r\n";

	error_log($docomoREDFMActiveBasedata,3,$docomoREDFMFilePath) ;

}
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$docomoREDFMFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);

//////////////////////////////////////////////////// End Docomo Redfm//////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////Start Docomo Ria//////////////////////////////////////////////////////////////////////////

$docomoRIAFile="1009/RIATataDoCoMo_".date('Ymd').".txt";
$docomoRIAFilePath=$activeDir.$docomoRIAFile;

if(file_exists($docomoRIAFilePath))
{
	unlink($docomoRIAFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".date('Y-m-d')."' and service='RIATataDoCoMo'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ10="select 'RIATataDoCoMo',ani,sub_date,renew_date,mode_of_sub,circle,user_bal,status,def_lang from docomo_manchala.tbl_riya_subscription where status=1"; 
$query10 = mysql_query($getActiveBaseQ10,$dbConn);
while($docomoRIAActbase = mysql_fetch_array($query10))
{
	$docomoRIAActiveBasedata=date('Y-m-d')."|".trim($docomoRIAActbase[0])."|".trim($docomoRIAActbase[1])."|".trim($docomoRIAActbase[2])."|".trim($docomoRIAActbase[3])."|".trim($docomoRIAActbase[4])."|".trim($docomoRIAActbase[5])."|".trim($docomoRIAActbase[6])."|".trim($docomoRIAActbase[7])."|".trim($docomoRIAActbase[8])."|".trim($docomoRIAActbase[15]).'|'.trim($docomoRIAActbase[15]).'|'.trim($docomoRIAActbase[15])."\r\n";

	error_log($docomoRIAActiveBasedata,3,$docomoRIAFilePath) ;

}
	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$docomoRIAFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump10,$LivdbConn);

//////////////////////////////////////////////////// End Docomo Redfm//////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Docomo ENDLESS//////////////////////////////////////////////////////////////////////////

$docomoEndFile="1002/TataDoCoMoMX_".date('Ymd').".txt";
$docomoENDFilePath=$activeDir.$docomoEndFile;

if(file_exists($docomoENDFilePath))
{
	unlink($docomoENDFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".date('Y-m-d')."' and service='TataDoCoMoMX'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ11="select 'TataDoCoMoMX',ani,sub_date,renew_date,mode_of_sub,circle,user_bal,status,def_lang from docomo_radio.tbl_radio_subscription where status=1"; 
$query11 = mysql_query($getActiveBaseQ11,$dbConn);
while($docomoENDActbase = mysql_fetch_array($query11))
{
	$docomoENDActiveBasedata=date('Y-m-d')."|".trim($docomoENDActbase[0])."|".trim($docomoENDActbase[1])."|".trim($docomoENDActbase[2])."|".trim($docomoENDActbase[3])."|".trim($docomoENDActbase[4])."|".trim($docomoENDActbase[5])."|".trim($docomoENDActbase[6])."|".trim($docomoENDActbase[7])."|".trim($docomoENDActbase[8])."|".trim($docomoENDActbase[15]).'|'.trim($docomoENDActbase[15]).'|'.trim($docomoENDActbase[15])."\r\n";

	error_log($docomoENDActiveBasedata,3,$docomoENDFilePath) ;

}
	$insertDump11= 'LOAD DATA LOCAL INFILE "'.$docomoENDFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump11,$LivdbConn);

//////////////////////////////////////////////////// End Docomo ENDLESS//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Docomo FMJ//////////////////////////////////////////////////////////////////////////

$docomoFMJFile="1005/TataDoCoMoFMJ_".date('Ymd').".txt";
$docomoFMJFilePath=$activeDir.$docomoFMJFile;

if(file_exists($docomoFMJFilePath))
{
	unlink($docomoFMJFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".date('Y-m-d')."' and service='TataDoCoMoFMJ'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ12="select 'TataDoCoMoFMJ',ani,sub_date,renew_date,mode_of_sub,circle,user_bal,status,def_lang from docomo_starclub.tbl_jbox_subscription where status=1"; 
$query12 = mysql_query($getActiveBaseQ12,$dbConn);
while($docomoFMJActbase = mysql_fetch_array($query12))
{
	$docomoFMJActiveBasedata=date('Y-m-d')."|".trim($docomoFMJActbase[0])."|".trim($docomoFMJActbase[1])."|".trim($docomoFMJActbase[2])."|".trim($docomoFMJActbase[3])."|".trim($docomoFMJActbase[4])."|".trim($docomoFMJActbase[5])."|".trim($docomoFMJActbase[6])."|".trim($docomoFMJActbase[7])."|".trim($docomoFMJActbase[8])."|".trim($docomoFMJActbase[15]).'|'.trim($docomoFMJActbase[15]).'|'.trim($docomoFMJActbase[15])."\r\n";

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

<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");


// delete the prevoius record
if(isset($_REQUEST['date'])) { 
	$view_date1= $_REQUEST['date'];
} else {
	$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

//echo $view_date1='2012-12-07';

if($view_date1) {
	$tempDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
	if($view_date1 < $tempDate) {
		$successTable = "master_db.tbl_billing_success_backup";
	} else {
		$successTable = "master_db.tbl_billing_success";
	}
}

$activeDir="/var/www/html/kmis/testing/activeBase/";


////////////////////////////////////////////////////Start Uninor MTV//////////////////////////////////////////////////////////////////////////

$uninorMTVFile="1403/UninorMTV_".date('Ymd').".txt";
$uninorMTVFilePath=$activeDir.$uninorMTVFile;

if(file_exists($uninorMTVFilePath))
{
	unlink($uninorMTVFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".date('Y-m-d')."' and service='MTVUninor'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ="select 'MTVUninor',ani,sub_date,renew_date,mode_of_sub,circle,user_bal,status,def_lang from uninor_hungama.tbl_mtv_subscription where status=1"; 
$query = mysql_query($getActiveBaseQ,$dbConn);
while($UniMtvActbase = mysql_fetch_array($query))
{
	$uniMTVActiveBasedata=date('Y-m-d')."|".trim($UniMtvActbase[0])."|".trim($UniMtvActbase[1])."|".trim($UniMtvActbase[2])."|".trim($UniMtvActbase[3])."|".trim($UniMtvActbase[4])."|".trim($UniMtvActbase[5])."|".trim($UniMtvActbase[6])."|".trim($UniMtvActbase[7])."|".trim($UniMtvActbase[8])."|".trim($UniMtvActbase[15]).'|'.trim($UniMtvActbase[15]).'|'.trim($UniMtvActbase[15])."\r\n";
	error_log($uniMTVActiveBasedata,3,$uninorMTVFilePath) ;
}
	$insertDump= 'LOAD DATA LOCAL INFILE "'.$uninorMTVFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		//mysql_query($insertDump,$LivdbConn);

//////////////////////////////////////////////////// End Uninor MTV//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////// Start Uninor Redfm//////////////////////////////////////////////////////////////////////////

$uniREDFMFile="1410/UninorREDFM_".date('Ymd').".txt";
$uniREDFMFilePath=$activeDir.$uniREDFMFile;

if(file_exists($uniREDFMFilePath))
{
	unlink($uniREDFMFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".date('Y-m-d')."' and service='RedFMUninor'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ1="select 'RedFMUninor',ani,sub_date,renew_date,mode_of_sub,circle,user_bal,status,def_lang from uninor_redfm.tbl_jbox_subscription where status=1"; 
$query1= mysql_query($getActiveBaseQ1,$dbConn);
while($UniREDFMActbase = mysql_fetch_array($query1))
{
	$uniRedFmActiveBasedata=date('Y-m-d')."|".trim($UniREDFMActbase[0])."|".trim($UniREDFMActbase[1])."|".trim($UniREDFMActbase[2])."|".trim($UniREDFMActbase[3])."|".trim($UniREDFMActbase[4])."|".trim($UniREDFMActbase[5])."|".trim($UniREDFMActbase[6])."|".trim($UniREDFMActbase[7])."|".trim($UniREDFMActbase[8])."\r\n";
	error_log($uniRedFmActiveBasedata,3,$uniREDFMFilePath) ;
}

$insertDump1= 'LOAD DATA LOCAL INFILE "'.$uniREDFMFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
mysql_query($insertDump1,$LivdbConn);

//////////////////////////////////////////////////// End Uninor Redfm//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////// Start Uninor Ria//////////////////////////////////////////////////////////////////////////

$uniRIAFile="1409/UninorRia_".date('Ymd').".txt";
$uniRIAFilePath=$activeDir.$uniRIAFile;

if(file_exists($uniRIAFilePath))
{
	unlink($uniRIAFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".date('Y-m-d')."' and service='RIAUninor'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ3="select 'RIAUninor',ani,sub_date,renew_date,mode_of_sub,circle,user_bal,status,def_lang from uninor_manchala.tbl_riya_subscription where status=1"; 
$query3 = mysql_query($getActiveBaseQ3,$dbConn);
while($uniRIAActbase = mysql_fetch_array($query3))
{
	$uniRIAActiveBasedata=date('Y-m-d')."|".trim($uniRIAActbase[0])."|".trim($uniRIAActbase[1])."|".trim($uniRIAActbase[2])."|".trim($uniRIAActbase[3])."|".trim($uniRIAActbase[4])."|".trim($uniRIAActbase[5])."|".trim($uniRIAActbase[6])."|".trim($uniRIAActbase[7])."|".trim($uniRIAActbase[8])."\r\n";
	error_log($uniRIAActiveBasedata,3,$uniRIAFilePath) ;
}

$insertDump2= 'LOAD DATA LOCAL INFILE "'.$uniRIAFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
mysql_query($insertDump2,$LivdbConn);

//////////////////////////////////////////////////// End Uninor Ria//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////// Start Uninor 54646//////////////////////////////////////////////////////////////////////////

$uni54646File="1402/uni54646_".date('Ymd').".txt";
$uni54646FilePath=$activeDir.$uni54646File;

if(file_exists($uni54646FilePath))
{
	unlink($uni54646FilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".date('Y-m-d')."' and service='Uninor54646'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ4="select 'Uninor54646',ani,sub_date,renew_date,mode_of_sub,circle,user_bal,status,def_lang from docomo_hungama.tbl_jbox_subscription where status=1"; 
$query4 = mysql_query($getActiveBaseQ4,$dbConn);
while($uni54646Actbase = mysql_fetch_array($query4))
{
	$uni5464ActiveBasedata=date('Y-m-d')."|".trim($uni54646Actbase[0])."|".trim($uni54646Actbase[1])."|".trim($uni54646Actbase[2])."|".trim($uni54646Actbase[3])."|".trim($uni54646Actbase[4])."|".trim($uni54646Actbase[5])."|".trim($uni54646Actbase[6])."|".trim($uni54646Actbase[7])."|".trim($uni54646Actbase[8])."\r\n";
	error_log($uni5464ActiveBasedata,3,$uni54646FilePath) ;
}

$insertDump3= 'LOAD DATA LOCAL INFILE "'.$uni54646FilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
mysql_query($insertDump3,$LivdbConn);

//////////////////////////////////////////////////// End Uninor 54646//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////// Start Uninor Artist Aloud//////////////////////////////////////////////////////////////////////////

$uniAAFile="1402/AAUninor_".date('Ymd').".txt";
$uniAAFilePath=$activeDir.$uniAAFile;

if(file_exists($uniAAFilePath))
{
	unlink($uniAAFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".date('Y-m-d')."' and service='AAUninor'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ5="select 'AAUninor',ani,sub_date,renew_date,mode_of_sub,circle,user_bal,status,def_lang from docomo_hungama.tbl_Artist_Aloud_subscription where status=1"; 
$query5 = mysql_query($getActiveBaseQ5,$dbConn);
while($uniAAActbase = mysql_fetch_array($query5))
{
	$uniAAActiveBasedata=date('Y-m-d')."|".trim($uniAAActbase[0])."|".trim($uniAAActbase[1])."|".trim($uniAAActbase[2])."|".trim($uniAAActbase[3])."|".trim($uniAAActbase[4])."|".trim($uniAAActbase[5])."|".trim($uniAAActbase[6])."|".trim($uniAAActbase[7])."|".trim($uniAAActbase[8])."\r\n";
	error_log($uniAAActiveBasedata,3,$uniAAFilePath) ;
}

$insertDump5= 'LOAD DATA LOCAL INFILE "'.$uniAAFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
mysql_query($insertDump5,$LivdbConn);

//////////////////////////////////////////////////// End  Uninor Artist Aloud//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////// Start Uninor JAD//////////////////////////////////////////////////////////////////////////

$uniJADFile="1416/UninorAstro_".date('Ymd').".txt";
$uniJADFilePath=$activeDir.$uniJADFile;

if(file_exists($uniJADFilePath))
{
	unlink($uniJADFilePath);
	echo $del="delete from misdata2.tbl_base_active where date(date)='".date('Y-m-d')."' and service='UninorAstro'";
	$delquery = mysql_query($del,$LivdbConn);
}

$getActiveBaseQ6="select 'UninorAstro',ani,sub_date,renew_date,mode_of_sub,circle,user_bal,status,def_lang from uninor_jyotish.tbl_jyotish_subscription where status=1"; 
$query6 = mysql_query($getActiveBaseQ6,$dbConn);
while($uniJADActbase = mysql_fetch_array($query6))
{
	$uniJADActiveBasedata=date('Y-m-d')."|".trim($uniJADActbase[0])."|".trim($uniJADActbase[1])."|".trim($uniJADActbase[2])."|".trim($uniJADActbase[3])."|".trim($uniJADActbase[4])."|".trim($uniJADActbase[5])."|".trim($uniJADActbase[6])."|".trim($uniJADActbase[7])."|".trim($uniJADActbase[8])."\r\n";
	error_log($uniJADActiveBasedata,3,$uniJADFilePath) ;
}

$insertDump6= 'LOAD DATA LOCAL INFILE "'.$uniJADFilePath.'" INTO TABLE misdata2.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
mysql_query($insertDump6,$LivdbConn);

//////////////////////////////////////////////////// End  Uninor JAD//////////////////////////////////////////////////////////////////////////



echo "done";
mysql_close($dbConn);
mysql_close($LivdbConn);


?>

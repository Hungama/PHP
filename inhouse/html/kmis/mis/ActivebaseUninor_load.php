<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fview_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$fileDate= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$view_date1='2013-09-02';
$fileDate='20130902';
$activeDir="/var/www/html/kmis/testing/activeBase/";

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');


$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');
//////////////////////////////////////////////////////// code Start to dump Active bbase for Uninor Operator///////////////////////////////////////////////////


////////////////////////////////////////////////////Start Uninor MTV//////////////////////////////////////////////////////////////////////////

$uninorMTVFile="1403/UninorMTV_".$fileDate.".txt";
$uninorMTVFilePath=$activeDir.$uninorMTVFile;

if(file_exists($uninorMTVFilePath))
{
//	unlink($uninorMTVFilePath);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTVUninor' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}
/*
$getActiveBaseQ="select 'MTVUninor',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',replace(replace(def_lang,'01','HIN'),'99','HIN') from uninor_hungama.tbl_mtv_subscription where status=1 and date(sub_date)<='".$view_date1."'"; 
$query = mysql_query($getActiveBaseQ,$dbConn);
while($UniMtvActbase = mysql_fetch_array($query))
{

	if($circle_info[trim($UniMtvActbase[5])]=='')
		$UniMtvActbase[5]='Others';

	if($languageData[trim($UniMtvActbase[8])]!='')
		$lang=$languageData[$UniMtvActbase[8]];
	else
		$lang=trim($UniMtvActbase[8]);

	$uniMTVActiveBasedata=$view_date1."|".trim($UniMtvActbase[0])."|".trim($UniMtvActbase[1])."|".trim($UniMtvActbase[2])."|".trim($UniMtvActbase[3])."|".trim($UniMtvActbase[4])."|".trim($circle_info[$UniMtvActbase[5]])."|".trim($UniMtvActbase[6])."|".trim($UniMtvActbase[7])."|".trim($lang)."|".trim($UniMtvActbase[15]).'|'.trim($UniMtvActbase[15]).'|'.trim($UniMtvActbase[15])."\r\n";
	error_log($uniMTVActiveBasedata,3,$uninorMTVFilePath) ;
}*/
	$insertDump= 'LOAD DATA LOCAL INFILE "'.$uninorMTVFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	if (mysql_query($insertDump, $LivdbConn)) {
        $file_process_status = 'Uninor MTV Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Uninor MTV  Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
echo $file_process_status."<br>";
//////////////////////////////////////////////////// End Uninor MTV//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////// Start Uninor Redfm//////////////////////////////////////////////////////////////////////////

$uniREDFMFile="1410/UninorREDFM_".$fileDate.".txt";
$uniREDFMFilePath=$activeDir.$uniREDFMFile;

if(file_exists($uniREDFMFilePath))
{
//	unlink($uniREDFMFilePath);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RedFMUninor' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}
/*
$getActiveBaseQ1="select 'RedFMUninor',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_redfm.tbl_jbox_subscription where status=1 and date(sub_date)<='".$view_date1."'"; 
$query1= mysql_query($getActiveBaseQ1,$dbConn);
while($UniREDFMActbase = mysql_fetch_array($query1))
{
		if($circle_info[$UniREDFMActbase[5]]=='')
		$UniREDFMActbase[5]='Others';

		if($languageData[trim($UniREDFMActbase[8])]!='')
			$lang=$languageData[$UniREDFMActbase[8]];
		else
			$lang=trim($UniREDFMActbase[8]);
	$uniRedFmActiveBasedata=$view_date1."|".trim($UniREDFMActbase[0])."|".trim($UniREDFMActbase[1])."|".trim($UniREDFMActbase[2])."|".trim($UniREDFMActbase[3])."|".trim($UniREDFMActbase[4])."|".trim($circle_info[$UniREDFMActbase[5]])."|".trim($UniREDFMActbase[6])."|".trim($UniREDFMActbase[7])."|".trim($lang)."\r\n";
	error_log($uniRedFmActiveBasedata,3,$uniREDFMFilePath) ;
}
*/
$insertDump1= 'LOAD DATA LOCAL INFILE "'.$uniREDFMFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
if (mysql_query($insertDump1, $LivdbConn)) {
        $file_process_status = 'Uninor Redfm Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Uninor Redfm Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
echo $file_process_status."<br>";
//////////////////////////////////////////////////// End Uninor Redfm//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////// Start Uninor Ria//////////////////////////////////////////////////////////////////////////


$uniRIAFile="1409/UninorRia_".$fileDate.".txt";
$uniRIAFilePath=$activeDir.$uniRIAFile;

if(file_exists($uniRIAFilePath))
{
//	unlink($uniRIAFilePath);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RIAUninor' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}
/*
$getActiveBaseQ3="select 'RIAUninor',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_manchala.tbl_riya_subscription where status=1 and date(sub_date)<='".$view_date1."'"; 
$query3 = mysql_query($getActiveBaseQ3,$dbConn);
while($uniRIAActbase = mysql_fetch_array($query3))
{
	if($circle_info[$uniRIAActbase[5]]=='')
		$uniRIAActbase[5]='Others';

	
		if($languageData[trim($uniRIAActbase[8])]!='')
			$lang=$languageData[$uniRIAActbase[8]];
		else
			$lang=trim($uniRIAActbase[8]);
	$uniRIAActiveBasedata=$view_date1."|".trim($uniRIAActbase[0])."|".trim($uniRIAActbase[1])."|".trim($uniRIAActbase[2])."|".trim($uniRIAActbase[3])."|".trim($uniRIAActbase[4])."|".trim($circle_info[$uniRIAActbase[5]])."|".trim($uniRIAActbase[6])."|".trim($uniRIAActbase[7])."|".trim($lang)."\r\n";
	error_log($uniRIAActiveBasedata,3,$uniRIAFilePath) ;
}
*/
$insertDump2= 'LOAD DATA LOCAL INFILE "'.$uniRIAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
if (mysql_query($insertDump2, $LivdbConn)) {
        $file_process_status = 'Uninor Ria Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Uninor Ria Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
echo $file_process_status."<br>";
//////////////////////////////////////////////////// End Uninor Ria//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////// Start Uninor 54646//////////////////////////////////////////////////////////////////////////


$uni54646File="1402/uni54646_".$fileDate.".txt";
$uni54646FilePath=$activeDir.$uni54646File;

if(file_exists($uni54646FilePath))
{
//	unlink($uni54646FilePath);
	 $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='Uninor54646' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}
/*
$getActiveBaseQ4="select 'Uninor54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_hungama.tbl_jbox_subscription where status=1 and dnis not like '%P%' and plan_id!=95 and date(sub_date)<='".$view_date1."'"; 
$query4 = mysql_query($getActiveBaseQ4,$dbConn);
while($uni54646Actbase = mysql_fetch_array($query4))
{
	if($circle_info[$uni54646Actbase[5]]=='')
		$uni54646Actbase[5]='Others';
	
	if($languageData[trim($uni54646Actbase[8])]!='')
			$lang=$languageData[$uni54646Actbase[8]];
		else
			$lang=trim($uni54646Actbase[8]);
	
	$uni5464ActiveBasedata=$view_date1."|".trim($uni54646Actbase[0])."|".trim($uni54646Actbase[1])."|".trim($uni54646Actbase[2])."|".trim($uni54646Actbase[3])."|".trim($uni54646Actbase[4])."|".trim($circle_info[$uni54646Actbase[5]])."|".trim($uni54646Actbase[6])."|".trim($uni54646Actbase[7])."|".trim($lang)."\r\n";
	error_log($uni5464ActiveBasedata,3,$uni54646FilePath) ;
}
*/
$insertDump3= 'LOAD DATA LOCAL INFILE "'.$uni54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
//mysql_query($insertDump3,$LivdbConn);
if (mysql_query($insertDump3, $LivdbConn)) {
        $file_process_status = 'Uninor 54646 Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Uninor 54646 Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
echo $file_process_status."<br>";
//////////////////////////////////////////////////// End Uninor 54646//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////// Start Uninor Artist Aloud//////////////////////////////////////////////////////////////////////////

$uniAAFile="1402/AAUninor_".$fileDate.".txt";
$uniAAFilePath=$activeDir.$uniAAFile;

if(file_exists($uniAAFilePath))
{
//	unlink($uniAAFilePath);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AAUninor' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}
/*
$getActiveBaseQ5="select 'AAUninor',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_hungama.tbl_Artist_Aloud_subscription where status in (1) and plan_id=95 and date(sub_date)<='".$view_date1."'"; 
$query5 = mysql_query($getActiveBaseQ5,$dbConn);
while($uniAAActbase = mysql_fetch_array($query5))
{
	if($circle_info[$uniAAActbase[5]]=='')
		$uniAAActbase[5]='Others';

	if($languageData[trim($uniAAActbase[8])]!='')
		$lang=$languageData[$uniAAActbase[8]];
	else
		$lang=trim($uniAAActbase[8]);
	$uniAAActiveBasedata=$view_date1."|".trim($uniAAActbase[0])."|".trim($uniAAActbase[1])."|".trim($uniAAActbase[2])."|".trim($uniAAActbase[3])."|".trim($uniAAActbase[4])."|".trim($circle_info[$uniAAActbase[5]])."|".trim($uniAAActbase[6])."|".trim($uniAAActbase[7])."|".trim($lang)."\r\n";
	error_log($uniAAActiveBasedata,3,$uniAAFilePath) ;
}
*/
$insertDump5= 'LOAD DATA LOCAL INFILE "'.$uniAAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
if (mysql_query($insertDump5, $LivdbConn)) {
        $file_process_status = 'Uninor Artist Aloud Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Artist Aloud Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
echo $file_process_status."<br>";
//////////////////////////////////////////////////// End  Uninor Artist Aloud//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////// Start Uninor JAD//////////////////////////////////////////////////////////////////////////

$uniJADFile="1416/UninorAstro_".$fileDate.".txt";
$uniJADFilePath=$activeDir.$uniJADFile;

if(file_exists($uniJADFilePath))
{
//	unlink($uniJADFilePath);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='UninorAstro' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}
/*
$getActiveBaseQ6="select 'UninorAstro',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_jyotish.tbl_jyotish_subscription where status=1 and date(sub_date)<='".$view_date1."'"; 
$query6 = mysql_query($getActiveBaseQ6,$dbConn);
while($uniJADActbase = mysql_fetch_array($query6))
{
	if($circle_info[$uniJADActbase[5]]=='')
		$uniJADActbase[5]='Others';

	if($languageData[trim($uniJADActbase[8])]!='')
		$lang=$languageData[$uniJADActbase[8]];
	else
		$lang=trim($uniJADActbase[8]);
	$uniJADActiveBasedata=$view_date1."|".trim($uniJADActbase[0])."|".trim($uniJADActbase[1])."|".trim($uniJADActbase[2])."|".trim($uniJADActbase[3])."|".trim($uniJADActbase[4])."|".trim($circle_info[$uniJADActbase[5]])."|".trim($uniJADActbase[6])."|".trim($uniJADActbase[7])."|".trim($lang)."\r\n";
	error_log($uniJADActiveBasedata,3,$uniJADFilePath) ;
}*/

$insertDump6= 'LOAD DATA LOCAL INFILE "'.$uniJADFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
if (mysql_query($insertDump6, $LivdbConn)) {
        $file_process_status = 'Uninor JAD Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'JAD Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
echo $file_process_status."<br>";
//////////////////////////////////////////////////// End  Uninor JAD//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////// Start UninorSU //////////////////////////////////////////////////////////////////////////

$UninorSUFile="1408/UninorSU_".$fileDate.".txt";
$UninorSUFilePath=$activeDir.$UninorSUFile;

if(file_exists($UninorSUFilePath))
{
//	unlink($UninorSUFilePath);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='UninorSU' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}
/*
$getActiveBaseQ6="select 'UninorSU',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_cricket.tbl_cricket_subscription where status IN (1) and date(sub_date)<='".$view_date1."'"; 
$query6 = mysql_query($getActiveBaseQ6,$dbConn);
while($UninorSUActbase = mysql_fetch_array($query6))
{
	if($circle_info[$UninorSUActbase[5]]=='')
		$UninorSUActbase[5]='Others';

	if($languageData[trim($UninorSUActbase[8])]!='')
		$lang=$languageData[$UninorSUActbase[8]];
	else
		$lang=trim($UninorSUActbase[8]);
	$UninorSUActiveBasedata=$view_date1."|".trim($UninorSUActbase[0])."|".trim($UninorSUActbase[1])."|".trim($UninorSUActbase[2])."|".trim($UninorSUActbase[3])."|".trim($UninorSUActbase[4])."|".trim($circle_info[$UninorSUActbase[5]])."|".trim($UninorSUActbase[6])."|".trim($UninorSUActbase[7])."|".trim($lang)."\r\n";
	error_log($UninorSUActiveBasedata,3,$UninorSUFilePath) ;
}*/

$insertDump6= 'LOAD DATA LOCAL INFILE "'.$UninorSUFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
if (mysql_query($insertDump6, $LivdbConn)) {
        $file_process_status = 'UninorSU Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'UninorSU Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
echo $file_process_status."<br>";
//////////////////////////////////////////////////// End  UninorSU//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////// Start UninorComedy //////////////////////////////////////////////////////////////////////////

$UninorComedyFile="1418/UninorComedy_".$fileDate.".txt";
$UninorComedyFilePath=$activeDir.$UninorComedyFile;

if(file_exists($UninorComedyFilePath))
{
//	unlink($UninorComedyFilePath);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='UninorComedy' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
}
/*
$getActiveBaseQ6="select 'UninorComedy',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from uninor_hungama.tbl_comedy_subscription where status=1 and date(sub_date)<='".$view_date1."'"; 
$query6 = mysql_query($getActiveBaseQ6,$dbConn);
while($UninorComedyActbase = mysql_fetch_array($query6))
{
	if($circle_info[$UninorComedyActbase[5]]=='')
		$UninorComedyActbase[5]='Others';

	if($languageData[trim($UninorComedyActbase[8])]!='')
		$lang=$languageData[$UninorComedyActbase[8]];
	else
		$lang=trim($UninorComedyActbase[8]);
	$UninorComedyActiveBasedata=$view_date1."|".trim($UninorComedyActbase[0])."|".trim($UninorComedyActbase[1])."|".trim($UninorComedyActbase[2])."|".trim($UninorComedyActbase[3])."|".trim($UninorComedyActbase[4])."|".trim($circle_info[$UninorComedyActbase[5]])."|".trim($UninorComedyActbase[6])."|".trim($UninorComedyActbase[7])."|".trim($lang)."\r\n";
	error_log($UninorComedyActiveBasedata,3,$UninorComedyFilePath) ;
}
*/
$insertDump6= 'LOAD DATA LOCAL INFILE "'.$UninorComedyFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
if (mysql_query($insertDump6, $LivdbConn)) {
        $file_process_status = 'UninorComedy Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'UninorComedy Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
echo $file_process_status."<br>";
//////////////////////////////////////////////////// End  Uninor UninorComedy//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////// code END to dump Active base for Uninor Operator///////////////////////////////////////////////////



echo "done";
mysql_close($dbConn);
mysql_close($LivdbConn);


?>

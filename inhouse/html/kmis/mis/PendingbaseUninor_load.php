<?php
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fview_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$fileDate= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));


echo $view_date1='2013-09-02';
$fileDate='20130902';

$activeDir="/var/www/html/kmis/testing/activeBase/";

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');


$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');

//////////////////////////////////////////////////////// code Start to dump Pending bbase for Uninor Operator///////////////////////////////////////////////////


////////////////////////////////////////////////////Start Uninor MTV//////////////////////////////////////////////////////////////////////////

$uninorMTVFile="1403/PUninorMTV_".$fileDate.".txt";
$uninorMTVFilePath=$activeDir.$uninorMTVFile;

//unlink($uninorMTVFilePath);
$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTVUninor' and status='Pending'";
$delquery = mysql_query($del,$LivdbConn);
/*

$getActiveBaseQ="select 'MTVUninor',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',replace(replace(def_lang,'01','HIN'),'99','HIN') from uninor_hungama.tbl_mtv_subscription where status IN (11,0,5) and date(sub_date)<='".$view_date1."'"; 
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
	mysql_query($insertDump,$LivdbConn);

//////////////////////////////////////////////////// End Uninor MTV//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////// Start Uninor Redfm//////////////////////////////////////////////////////////////////////////

$uniREDFMFile="1410/PUninorREDFM_".$fileDate.".txt";
$uniREDFMFilePath=$activeDir.$uniREDFMFile;

//	unlink($uniREDFMFilePath);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RedFMUninor' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);
/*

$getActiveBaseQ1="select 'RedFMUninor',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_redfm.tbl_jbox_subscription where status IN (11,0,5) and date(sub_date)<='".$view_date1."'"; 
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
mysql_query($insertDump1,$LivdbConn);

//////////////////////////////////////////////////// End Uninor Redfm//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////// Start Uninor Ria//////////////////////////////////////////////////////////////////////////


$uniRIAFile="1409/PUninorRia_".$fileDate.".txt";
$uniRIAFilePath=$activeDir.$uniRIAFile;

//	unlink($uniRIAFilePath);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RIAUninor' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);
/*

$getActiveBaseQ3="select 'RIAUninor',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_manchala.tbl_riya_subscription where status IN (11,0,5) and date(sub_date)<='".$view_date1."'"; 
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
mysql_query($insertDump2,$LivdbConn);

//////////////////////////////////////////////////// End Uninor Ria//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////// Start Uninor 54646//////////////////////////////////////////////////////////////////////////


$uni54646File="1402/Puni54646_".$fileDate.".txt";
$uni54646FilePath=$activeDir.$uni54646File;

//	unlink($uni54646FilePath);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='Uninor54646' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);
/*

$getActiveBaseQ4="select 'Uninor54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_hungama.tbl_jbox_subscription where status in (11,0,5) and dnis not like '%P%' and plan_id!=95 and date(sub_date)<='".$view_date1."'"; 
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
mysql_query($insertDump3,$LivdbConn);

//////////////////////////////////////////////////// End Uninor 54646//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////// Start Uninor Artist Aloud//////////////////////////////////////////////////////////////////////////

$uniAAFile="1402/PAAUninor_".$fileDate.".txt";
$uniAAFilePath=$activeDir.$uniAAFile;

//unlink($uniAAFilePath);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AAUninor' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);
/*
$getActiveBaseQ5="select 'AAUninor',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_hungama.tbl_Artist_Aloud_subscription where status in (11,0,5) and plan_id=95 and date(sub_date)<='".$view_date1."'"; 
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
mysql_query($insertDump5,$LivdbConn);

//////////////////////////////////////////////////// End  Uninor Artist Aloud//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////// Start Uninor JAD//////////////////////////////////////////////////////////////////////////

$uniJADFile="1416/PUninorAstro_".$fileDate.".txt";
$uniJADFilePath=$activeDir.$uniJADFile;

//unlink($uniJADFilePath);
$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='UninorAstro' and status='Pending'";
$delquery = mysql_query($del,$LivdbConn);
/*
$getActiveBaseQ6="select 'UninorAstro',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_jyotish.tbl_jyotish_subscription where status IN (11,0,5) and date(sub_date)<='".$view_date1."'"; 
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
}
*/
$insertDump6= 'LOAD DATA LOCAL INFILE "'.$uniJADFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
mysql_query($insertDump6,$LivdbConn);

//////////////////////////////////////////////////// End  Uninor JAD//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////// Start PUninorSU //////////////////////////////////////////////////////////////////////////

$PUninorSUFile="1408/PUninorSU_".$fileDate.".txt";
$PUninorSUFilePath=$activeDir.$PUninorSUFile;

//unlink($PUninorSUFilePath);
$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='UninorSU' and status='Pending'";
$delquery = mysql_query($del,$LivdbConn);
/*
$getActiveBaseQ6="select 'UninorSU',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_cricket.tbl_cricket_subscription where status IN (11,0,5) and date(sub_date)<='".$view_date1."'"; 
$query6 = mysql_query($getActiveBaseQ6,$dbConn);
while($PUninorSUActbase = mysql_fetch_array($query6))
{
	if($circle_info[$PUninorSUActbase[5]]=='')
		$PUninorSUActbase[5]='Others';

	if($languageData[trim($PUninorSUActbase[8])]!='')
		$lang=$languageData[$PUninorSUActbase[8]];
	else
		$lang=trim($PUninorSUActbase[8]);
	$PUninorSUActiveBasedata=$view_date1."|".trim($PUninorSUActbase[0])."|".trim($PUninorSUActbase[1])."|".trim($PUninorSUActbase[2])."|".trim($PUninorSUActbase[3])."|".trim($PUninorSUActbase[4])."|".trim($circle_info[$PUninorSUActbase[5]])."|".trim($PUninorSUActbase[6])."|".trim($PUninorSUActbase[7])."|".trim($lang)."\r\n";
	error_log($PUninorSUActiveBasedata,3,$PUninorSUFilePath) ;
}
*/
$insertDump6= 'LOAD DATA LOCAL INFILE "'.$PUninorSUFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
mysql_query($insertDump6,$LivdbConn);

//////////////////////////////////////////////////// End  PUninorSU//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////// Start PUninorComedy //////////////////////////////////////////////////////////////////////////

$PUninorComedyFile="1418/PUninorComedy_".$fileDate.".txt";
$PUninorComedyFilePath=$activeDir.$PUninorComedyFile;

//unlink($PUninorComedyFilePath);
$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='UninorComedy' and status='Pending'";
$delquery = mysql_query($del,$LivdbConn);
/*

$getActiveBaseQ6="select 'UninorComedy',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from uninor_hungama.tbl_comedy_subscription where status IN (11,0,5) and date(sub_date)<='".$view_date1."'"; 
$query6 = mysql_query($getActiveBaseQ6,$dbConn);
while($PUninorComedyActbase = mysql_fetch_array($query6))
{
	if($circle_info[$PUninorComedyActbase[5]]=='')
		$PUninorComedyActbase[5]='Others';

	if($languageData[trim($PUninorComedyActbase[8])]!='')
		$lang=$languageData[$PUninorComedyActbase[8]];
	else
		$lang=trim($PUninorComedyActbase[8]);
	$PUninorComedyActiveBasedata=$view_date1."|".trim($PUninorComedyActbase[0])."|".trim($PUninorComedyActbase[1])."|".trim($PUninorComedyActbase[2])."|".trim($PUninorComedyActbase[3])."|".trim($PUninorComedyActbase[4])."|".trim($circle_info[$PUninorComedyActbase[5]])."|".trim($PUninorComedyActbase[6])."|".trim($PUninorComedyActbase[7])."|".trim($lang)."\r\n";
	error_log($PUninorComedyActiveBasedata,3,$PUninorComedyFilePath) ;
}
*/
$insertDump6= 'LOAD DATA LOCAL INFILE "'.$PUninorComedyFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang)';
mysql_query($insertDump6,$LivdbConn);

//////////////////////////////////////////////////// End  PUninorComedy//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////// code END to dump Pending base for Uninor Operator///////////////////////////////////////////////////



echo "done";
mysql_close($dbConn);
mysql_close($LivdbConn);


?>

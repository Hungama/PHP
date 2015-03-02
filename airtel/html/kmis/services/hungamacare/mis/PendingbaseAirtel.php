<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("../config/dbConnect.php");
$activeDir="/var/www/html/kmis/services/hungamacare/mis/activeBase/";

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fview_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$fileDate= date("Ymd");
//$fileDate="20130504";


$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');


////////////////////////////////////////////////////Start Airtel MTV//////////////////////////////////////////////////////////////////////////

$airtelMTVFile="1503/PMTVAirtel_".$fileDate.".txt";
$airtelMTVFilePath=$activeDir.$airtelMTVFile;

	unlink($airtelMTVFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='MTVAirtel' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);


$getActiveBaseQ7="select 'MTVAirtel',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_hungama.tbl_mtv_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($airtelMtvActbase = mysql_fetch_array($query7))
{
	if($circle_info[$airtelMtvActbase[5]]=='')
		$circle_info[$airtelMtvActbase[5]]=='Others';
	if($languageData[trim($airtelMtvActbase[8])]!='')
		$lang=$languageData[$airtelMtvActbase[8]];
	else
		$lang=trim($airtelMtvActbase[8]);
	$airtelMTVActiveBasedata=$view_date1."|".trim($airtelMtvActbase[0])."|".trim($airtelMtvActbase[1])."|".trim($airtelMtvActbase[2])."|".trim($airtelMtvActbase[3])."|".trim($airtelMtvActbase[4])."|".trim($circle_info[$airtelMtvActbase[5]])."|".trim($airtelMtvActbase[6])."|".trim($airtelMtvActbase[7])."|".trim($lang)."|".trim($airtelMtvActbase[15]).'|'.trim($airtelMtvActbase[15]).'|'.trim($airtelMtvActbase[15])."\r\n";
	error_log($airtelMTVActiveBasedata,3,$airtelMTVFilePath) ;
}
	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$airtelMTVFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump7,$dbConn);

//////////////////////////////////////////////////// End Airtel MTV//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Docomo 54646//////////////////////////////////////////////////////////////////////////

$airtel54646File="1502/PAirtel54646_".$fileDate.".txt";
$airtel54646FilePath=$activeDir.$airtel54646File;

	unlink($airtel54646FilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='Airtel54646' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);


$getActiveBaseQ8="select 'Airtel54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_hungama.tbl_jbox_subscription where status=11 and plan_id NOT IN (50) and dnis not like '%p%' and date(sub_date)<='".$view_date1."'";  
$query8 = mysql_query($getActiveBaseQ8,$dbConn);
while($airtel54646Actbase = mysql_fetch_array($query8))
{
	if($circle_info[$airtel54646Actbase[5]]=='')
		$circle_info[$airtel54646Actbase[5]]=='Others';
	if($languageData[trim($airtel54646Actbase[8])]!='')
		$lang=$languageData[$airtel54646Actbase[8]];
	else
		$lang=trim($airtel54646Actbase[8]);
	$airtel5464ActiveBasedata=$view_date1."|".trim($airtel54646Actbase[0])."|".trim($airtel54646Actbase[1])."|".trim($airtel54646Actbase[2])."|".trim($airtel54646Actbase[3])."|".trim($airtel54646Actbase[4])."|".trim($circle_info[$airtel54646Actbase[5]])."|".trim($airtel54646Actbase[6])."|".trim($airtel54646Actbase[7])."|".trim($lang)."|".trim($airtel54646Actbase[15]).'|'.trim($airtel54646Actbase[15]).'|'.trim($docomo54646Actbase[15])."\r\n";

	error_log($airtel5464ActiveBasedata,3,$airtel54646FilePath) ;

}
	$insertDump8= 'LOAD DATA LOCAL INFILE "'.$airtel54646FilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump8,$dbConn);
	
//////////////////////////////////////////////////// End airtel 54646//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel Devotional//////////////////////////////////////////////////////////////////////////

$airtelDevoFile="1510/PAirtelDevo_".$fileDate.".txt";
$airtelDevoFilePath=$activeDir.$airtelDevoFile;

	unlink($airtelDevoFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='AirtelDevo' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);


$getActiveBaseQ9="select 'AirtelDevo',CONCAT('91',a.ani) 'ani',a.sub_date,a.renew_date,a.mode_of_sub,IFNULL(a.circle,'Others'),a.user_bal,'Pending',a.def_lang,b.lastreligion_cat from airtel_devo.tbl_devo_subscription as a left JOIN airtel_devo.tbl_religion_profile as b ON b.ANI = a.ANI where a.status=11 and date(a.sub_date)<='".$view_date1."'";  
$query9 = mysql_query($getActiveBaseQ9,$dbConn);
while($airtelDevoActbase = mysql_fetch_array($query9))
{
	if($circle_info[$airtelDevoActbase[5]]=='')
		$circle_info[$airtelDevoActbase[5]]=='Others';
	if($languageData[trim($airtelDevoActbase[8])]!='')
		$lang=$languageData[$airtelDevoActbase[8]];
	else
		$lang=trim($airtelDevoActbase[8]);

		$airtelDevoActiveBasedata=$view_date1."|".trim($airtelDevoActbase[0])."|".trim($airtelDevoActbase[1])."|".trim($airtelDevoActbase[2])."|".trim($airtelDevoActbase[3])."|".trim($airtelDevoActbase[4])."|".trim($circle_info[$airtelDevoActbase[5]])."|".trim($airtelDevoActbase[6])."|".trim($airtelDevoActbase[7])."|".trim($lang)."|".trim($airtelDevoActbase[9]).'|'.trim($airtelDevoActbase[15]).'|'.trim($airtelDevoActbase[15])."\r\n";

	error_log($airtelDevoActiveBasedata,3,$airtelDevoFilePath) ;

}
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$airtelDevoFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$dbConn);

//////////////////////////////////////////////////// End airtel Devo//////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Airtel Ria//////////////////////////////////////////////////////////////////////////

$airtelRIAFile="1509/PRIAAirtel".$fileDate.".txt";
$airtelRIAFilePath=$activeDir.$airtelRIAFile;

	unlink($airtelRIAFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='RIAAirtel' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ10="select 'RIAAirtel',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_manchala.tbl_riya_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query10 = mysql_query($getActiveBaseQ10,$dbConn);
while($airtelRIAActbase = mysql_fetch_array($query10))
{
	if($circle_info[$airtelRIAActbase[5]]=='')
		$circle_info[$airtelRIAActbase[5]]=='Others';
	if($languageData[trim($airtelRIAActbase[8])]!='')
		$lang=$languageData[$airtelRIAActbase[8]];
	else
		$lang=trim($airtelRIAActbase[8]);

	$airtelRIAActiveBasedata=$view_date1."|".trim($airtelRIAActbase[0])."|".trim($airtelRIAActbase[1])."|".trim($airtelRIAActbase[2])."|".trim($airtelRIAActbase[3])."|".trim($airtelRIAActbase[4])."|".trim($circle_info[$airtelRIAActbase[5]])."|".trim($airtelRIAActbase[6])."|".trim($airtelRIAActbase[7])."|".trim($lang)."|".trim($airtelRIAActbase[15]).'|'.trim($airtelRIAActbase[15]).'|'.trim($airtelRIAActbase[15])."\r\n";

	error_log($airtelRIAActiveBasedata,3,$airtelRIAFilePath) ;

}
	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$airtelRIAFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump10,$dbConn);

//////////////////////////////////////////////////// End airtel Redfm//////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Airtel ENDLESS//////////////////////////////////////////////////////////////////////////

$airtelEndFile="1502/PAirtelEU_".$fileDate.".txt";
$airtelENDFilePath=$activeDir.$airtelEndFile;

	unlink($airtelENDFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='AirtelEU' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ11="select 'AirtelEU',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_radio.tbl_radio_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query11 = mysql_query($getActiveBaseQ11,$dbConn);
while($airtelENDActbase = mysql_fetch_array($query11))
{
	if($circle_info[$airtelENDActbase[5]]=='')
		$circle_info[$airtelENDActbase[5]]=='Others';
	if($languageData[trim($airtelENDActbase[8])]!='')
		$lang=$languageData[$airtelENDActbase[8]];
	else
		$lang=trim($airtelENDActbase[8]);
	$airtelENDActiveBasedata=$view_date1."|".trim($airtelENDActbase[0])."|".trim($airtelENDActbase[1])."|".trim($airtelENDActbase[2])."|".trim($airtelENDActbase[3])."|".trim($airtelENDActbase[4])."|".trim($circle_info[$airtelENDActbase[5]])."|".trim($airtelENDActbase[6])."|".trim($airtelENDActbase[7])."|".trim($lang)."|".trim($airtelENDActbase[15]).'|'.trim($airtelENDActbase[15]).'|'.trim($airtelENDActbase[15])."\r\n";

	error_log($airtelENDActiveBasedata,3,$airtelENDFilePath) ;

}
	$insertDump11= 'LOAD DATA LOCAL INFILE "'.$airtelENDFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump11,$dbConn);
//////////////////////////////////////////////////// End airtel ENDLESS//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel Rasoi //////////////////////////////////////////////////////////////////////////

$airtelRasoiFile="1511/PAirtelGL_".$fileDate.".txt";
$airtelRasoiFilePath=$activeDir.$airtelRasoiFile;

	unlink($airtelRasoiFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='AirtelGL' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ12="select 'AirtelGL',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_rasoi.tbl_rasoi_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query12 = mysql_query($getActiveBaseQ12,$dbConn);
while($airtelRasoiActbase = mysql_fetch_array($query12))
{
	if($circle_info[$airtelRasoiActbase[5]]=='')
		$circle_info[$airtelRasoiActbase[5]]=='Others';
	if($languageData[trim($airtelRasoiActbase[8])]!='')
		$lang=$languageData[$airtelRasoiActbase[8]];
	else
		$lang=trim($airtelRasoiActbase[8]);
	$airtelRasoiActiveBasedata=$view_date1."|".trim($airtelRasoiActbase[0])."|".trim($airtelRasoiActbase[1])."|".trim($airtelRasoiActbase[2])."|".trim($airtelRasoiActbase[3])."|".trim($airtelRasoiActbase[4])."|".trim($circle_info[$airtelRasoiActbase[5]])."|".trim($airtelRasoiActbase[6])."|".trim($airtelRasoiActbase[7])."|".trim($lang)."|".trim($airtelRasoiActbase[15]).'|'.trim($airtelRasoiActbase[15]).'|'.trim($airtelRasoiActbase[15])."\r\n";

	error_log($airtelRasoiActiveBasedata,3,$airtelRasoiFilePath) ;

}
	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$airtelRasoiFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump12,$dbConn);
//////////////////////////////////////////////////// End Airtel Rasoi //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel Comedy //////////////////////////////////////////////////////////////////////////

$airtelComedyFile="1502/PAirtelComedy_".$fileDate.".txt";
$airtelComedyFilePath=$activeDir.$airtelComedyFile;

	unlink($airtelComedyFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='AirtelComedy' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ13="select 'AirtelComedy',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_hungama.tbl_comedyportal_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query13 = mysql_query($getActiveBaseQ13,$dbConn);
while($airtelComedyActbase = mysql_fetch_array($query13))
{
	if($circle_info[$airtelComedyActbase[5]]=='')
		$circle_info[$airtelComedyActbase[5]]=='Others';
	if($languageData[trim($airtelComedyActbase[8])]!='')
		$lang=$languageData[$airtelComedyActbase[8]];
	else
		$lang=trim($airtelComedyActbase[8]);
	$airtelComedyActiveBasedata=$view_date1."|".trim($airtelComedyActbase[0])."|".trim($airtelComedyActbase[1])."|".trim($airtelComedyActbase[2])."|".trim($airtelComedyActbase[3])."|".trim($airtelComedyActbase[4])."|".trim($circle_info[$airtelComedyActbase[5]])."|".trim($airtelComedyActbase[6])."|".trim($airtelComedyActbase[7])."|".trim($lang)."|".trim($airtelComedyActbase[15]).'|'.trim($airtelComedyActbase[15]).'|'.trim($airtelComedyActbase[15])."\r\n";

	error_log($airtelComedyActiveBasedata,3,$airtelComedyFilePath) ;

}
	$insertDump13= 'LOAD DATA LOCAL INFILE "'.$airtelComedyFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump13,$dbConn);

//////////////////////////////////////////////////// End Airtel Comedy //////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Airtel MND //////////////////////////////////////////////////////////////////////////

$airtelMNDFile="1502/PAirtelMND_".$fileDate.".txt";
$airtelMNDFilePath=$activeDir.$airtelMNDFile;

	unlink($airtelMNDFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='AirtelMND' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ14="select 'AirtelMND',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_mnd.tbl_character_subscription1 where status=11 and plan_id!=81 and date(sub_date)<='".$view_date1."'";  
$query14 = mysql_query($getActiveBaseQ14,$dbConn);
while($airtelMNDActbase = mysql_fetch_array($query14))
{
	if($circle_info[$airtelMNDActbase[5]]=='')
		$circle_info[$airtelMNDActbase[5]]=='Others';
	if($languageData[trim($airtelMNDActbase[8])]!='')
		$lang=$languageData[$airtelMNDActbase[8]];
	else
		$lang=trim($airtelMNDActbase[8]);
	$airtelMNDActiveBasedata=$view_date1."|".trim($airtelMNDActbase[0])."|".trim($airtelMNDActbase[1])."|".trim($airtelMNDActbase[2])."|".trim($airtelMNDActbase[3])."|".trim($airtelMNDActbase[4])."|".trim($circle_info[$airtelMNDActbase[5]])."|".trim($airtelMNDActbase[6])."|".trim($airtelMNDActbase[7])."|".trim($lang)."|".trim($airtelMNDActbase[15]).'|'.trim($airtelMNDActbase[15]).'|'.trim($airtelMNDActbase[15])."\r\n";

	error_log($airtelMNDActiveBasedata,3,$airtelMNDFilePath) ;

}
	$insertDump14= 'LOAD DATA LOCAL INFILE "'.$airtelMNDFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump14,$dbConn);
	
//////////////////////////////////////////////////// End Airtel MND //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel PD //////////////////////////////////////////////////////////////////////////

$airtelPDFile="1502/PAirtelPD_".$fileDate.".txt";
$airtelPDFilePath=$activeDir.$airtelPDFile;

	unlink($airtelPDFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='AirtelPD' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ15="select 'AirtelPD',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_EDU.tbl_jbox_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query15 = mysql_query($getActiveBaseQ15,$dbConn);
while($airtelPDActbase = mysql_fetch_array($query15))
{
	if($circle_info[$airtelPDActbase[5]]=='')
		$circle_info[$airtelPDActbase[5]]=='Others';
	if($languageData[trim($airtelPDActbase[8])]!='')
		$lang=$languageData[$airtelPDActbase[8]];
	else
		$lang=trim($airtelPDActbase[8]);
	$airtelPDActiveBasedata=$view_date1."|".trim($airtelPDActbase[0])."|".trim($airtelPDActbase[1])."|".trim($airtelPDActbase[2])."|".trim($airtelPDActbase[3])."|".trim($airtelPDActbase[4])."|".trim($circle_info[$airtelPDActbase[5]])."|".trim($airtelPDActbase[6])."|".trim($airtelPDActbase[7])."|".trim($lang)."|".trim($airtelPDActbase[15]).'|'.trim($airtelPDActbase[15]).'|'.trim($airtelPDActbase[15])."\r\n";

	error_log($airtelPDActiveBasedata,3,$airtelPDFilePath) ;

}
	$insertDump15= 'LOAD DATA LOCAL INFILE "'.$airtelPDFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump15,$dbConn);
	
//////////////////////////////////////////////////// End Airtel PD //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel SE //////////////////////////////////////////////////////////////////////////

$airtelSEFile="1502/PAirtelSE_".$fileDate.".txt";
$airtelSEFilePath=$activeDir.$airtelSEFile;

	unlink($airtelSEFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='AirtelSE' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ16="select 'AirtelSE',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_SPKENG.tbl_spkeng_subscription where status=11 and date(sub_date)<='".$view_date1."'";   
$query16 = mysql_query($getActiveBaseQ16,$dbConn);
while($airtelSEActbase = mysql_fetch_array($query16))
{
	if($circle_info[$airtelSEActbase[5]]=='')
		$circle_info[$airtelSEActbase[5]]=='Others';
	if($languageData[trim($airtelSEActbase[8])]!='')
		$lang=$languageData[$airtelSEActbase[8]];
	else
		$lang=trim($airtelSEActbase[8]);
	$airtelSEActiveBasedata=$view_date1."|".trim($airtelSEActbase[0])."|".trim($airtelSEActbase[1])."|".trim($airtelSEActbase[2])."|".trim($airtelSEActbase[3])."|".trim($airtelSEActbase[4])."|".trim($circle_info[$airtelSEActbase[5]])."|".trim($airtelSEActbase[6])."|".trim($airtelSEActbase[7])."|".trim($lang)."|".trim($airtelSEActbase[15]).'|'.trim($airtelSEActbase[15]).'|'.trim($airtelSEActbase[15])."\r\n";

	error_log($airtelSEActiveBasedata,3,$airtelSEFilePath) ;

}
	$insertDump16= 'LOAD DATA LOCAL INFILE "'.$airtelSEFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump16,$dbConn);


	
//////////////////////////////////////////////////// End Airtel SE //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel VH1 //////////////////////////////////////////////////////////////////////////

$airtelVH1File="1502/PVH1Airtel_".$fileDate.".txt";
$airtelVH1FilePath=$activeDir.$airtelVH1File;

	unlink($airtelVH1FilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='VH1Airtel' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ17="select 'VH1Airtel',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_vh1.tbl_jbox_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query17 = mysql_query($getActiveBaseQ17,$dbConn);
while($airtelVH1Actbase = mysql_fetch_array($query17))
{
	if($circle_info[$airtelVH1Actbase[5]]=='')
		$circle_info[$airtelVH1Actbase[5]]=='Others';
	if($languageData[trim($airtelVH1Actbase[8])]!='')
		$lang=$languageData[$airtelVH1Actbase[8]];
	else
		$lang=trim($airtelVH1Actbase[8]);
	$airtelVH1ActiveBasedata=$view_date1."|".trim($airtelVH1Actbase[0])."|".trim($airtelVH1Actbase[1])."|".trim($airtelVH1Actbase[2])."|".trim($airtelVH1Actbase[3])."|".trim($airtelVH1Actbase[4])."|".trim($circle_info[$airtelVH1Actbase[5]])."|".trim($airtelVH1Actbase[6])."|".trim($airtelVH1Actbase[7])."|".trim($lang)."|".trim($airtelVH1Actbase[15]).'|'.trim($airtelVH1Actbase[15]).'|'.trim($airtelVH1Actbase[15])."\r\n";

	error_log($airtelVH1ActiveBasedata,3,$airtelVH1FilePath) ;

}
	$insertDump1621= 'LOAD DATA LOCAL INFILE "'.$airtelVH1FilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1621,$dbConn);

//////////////////////////////////////////////////// End Airtel VH1 //////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////Start Airtel VH1 //////////////////////////////////////////////////////////////////////////

$airtelVH1NightFile="1502/PVH1AirtelNight_".$fileDate.".txt";
$airtelVH1NightFilePath=$activeDir.$airtelVH1NightFile;

	unlink($airtelVH1NightFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='VH1Airtel' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ16="select 'VH1Airtel',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_vh1.tbl_vh1nightpack_subscription where status=11 and date(sub_date)<='".$view_date1."'";   
$query16 = mysql_query($getActiveBaseQ16,$dbConn);
while($airtelVH1NightActbase = mysql_fetch_array($query16))
{
	if($circle_info[$airtelVH1NightActbase[5]]=='')
		$circle_info[$airtelVH1NightActbase[5]]=='Others';
	if($languageData[trim($airtelVH1NightActbase[8])]!='')
		$lang=$languageData[$airtelVH1NightActbase[8]];
	else
		$lang=trim($airtelVH1NightActbase[8]);
	$airtelVH1NightActiveBasedata=$view_date1."|".trim($airtelVH1NightActbase[0])."|".trim($airtelVH1NightActbase[1])."|".trim($airtelVH1NightActbase[2])."|".trim($airtelVH1NightActbase[3])."|".trim($airtelVH1NightActbase[4])."|".trim($circle_info[$airtelVH1NightActbase[5]])."|".trim($airtelVH1NightActbase[6])."|".trim($airtelVH1NightActbase[7])."|".trim($lang)."|".trim($airtelVH1NightActbase[15]).'|'.trim($airtelVH1NightActbase[15]).'|'.trim($airtelVH1NightActbase[15])."\r\n";

	error_log($airtelVH1NightActiveBasedata,3,$airtelVH1NightFilePath) ;

}
	$insertDump1631= 'LOAD DATA LOCAL INFILE "'.$airtelVH1NightFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1631,$dbConn);
	

//////////////////////////////////////////////////// End Airtel VH1 //////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Airtel PK //////////////////////////////////////////////////////////////////////////

$airtelPKFile="1502/PAirtelPK_".$fileDate.".txt";
$airtelPKFilePath=$activeDir.$airtelPKFile;

	unlink($airtelPKFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='AirtelPK' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ17="select 'AirtelPK',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_hungama.tbl_pk_subscription where status=11 and date(sub_date)<='".$view_date1."'"; 
$query17 = mysql_query($getActiveBaseQ17,$dbConn);
while($airtelPKActbase = mysql_fetch_array($query17))
{
	if($circle_info[$airtelPKActbase[5]]=='')
		$circle_info[$airtelPKActbase[5]]=='Others';
	if($languageData[trim($airtelPKActbase[8])]!='')
		$lang=$languageData[$airtelPKActbase[8]];
	else
		$lang=trim($airtelPKActbase[8]);
	$airtelPKActiveBasedata=$view_date1."|".trim($airtelPKActbase[0])."|".trim($airtelPKActbase[1])."|".trim($airtelPKActbase[2])."|".trim($airtelPKActbase[3])."|".trim($airtelPKActbase[4])."|".trim($circle_info[$airtelPKActbase[5]])."|".trim($airtelPKActbase[6])."|".trim($airtelPKActbase[7])."|".trim($lang)."|".trim($airtelPKActbase[15]).'|'.trim($airtelPKActbase[15]).'|'.trim($airtelPKActbase[15])."\r\n";

	error_log($airtelPKActiveBasedata,3,$airtelPKFilePath) ;

}
	$insertDump17= 'LOAD DATA LOCAL INFILE "'.$airtelPKFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump17,$dbConn);
	

//////////////////////////////////////////////////// End Airtel PK //////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start AirtelRegKK //////////////////////////////////////////////////////////////////////////

$airtelRegKKFile="1502/PairtelRegKK_".$fileDate.".txt";
$airtelRegKKFilePath=$activeDir.$airtelRegKKFile;

	unlink($airtelRegKKFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='airtelRegKK' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ18="select 'AirtelRegKK',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_hungama.tbl_arm_subscription where status=11 and plan_id=63 and date(sub_date)<='".$view_date1."'"; 
$query18 = mysql_query($getActiveBaseQ18,$dbConn);
while($airtelRegKKActbase = mysql_fetch_array($query18))
{
	if($circle_info[$airtelRegKKActbase[5]]=='')
		$circle_info[$airtelRegKKActbase[5]]=='Others';
	if($languageData[trim($airtelRegKKActbase[8])]!='')
		$lang=$languageData[$airtelRegKKActbase[8]];
	else
		$lang=trim($airtelRegKKActbase[8]);
	$airtelRegKKActiveBasedata=$view_date1."|".trim($airtelRegKKActbase[0])."|".trim($airtelRegKKActbase[1])."|".trim($airtelRegKKActbase[2])."|".trim($airtelRegKKActbase[3])."|".trim($airtelRegKKActbase[4])."|".trim($circle_info[$airtelRegKKActbase[5]])."|".trim($airtelRegKKActbase[6])."|".trim($airtelRegKKActbase[7])."|".trim($lang)."|".trim($airtelRegKKActbase[15]).'|'.trim($airtelRegKKActbase[15]).'|'.trim($airtelRegKKActbase[15])."\r\n";

	error_log($airtelRegKKActiveBasedata,3,$airtelRegKKFilePath) ;

}
	$insertDump18= 'LOAD DATA LOCAL INFILE "'.$airtelRegKKFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump18,$dbConn);
	

//////////////////////////////////////////////////// End Airtel AirtelRegKK //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start AirtelRegTN //////////////////////////////////////////////////////////////////////////

$airtelRegTNFile="1502/PairtelRegTN_".$fileDate.".txt";
$airtelRegTNFilePath=$activeDir.$airtelRegTNFile;

	unlink($airtelRegTNFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='airtelRegTN' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ18="select 'AirtelRegTN',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_hungama.tbl_arm_subscription where status=11 and plan_id=64 and date(sub_date)<='".$view_date1."'"; 
$query18 = mysql_query($getActiveBaseQ18,$dbConn);
while($airtelRegTNActbase = mysql_fetch_array($query18))
{
	if($circle_info[$airtelRegTNActbase[5]]=='')
		$circle_info[$airtelRegTNActbase[5]]=='Others';
	if($languageData[trim($airtelRegTNActbase[8])]!='')
		$lang=$languageData[$airtelRegTNActbase[8]];
	else
		$lang=trim($airtelRegTNActbase[8]);
	$airtelRegTNActiveBasedata=$view_date1."|".trim($airtelRegTNActbase[0])."|".trim($airtelRegTNActbase[1])."|".trim($airtelRegTNActbase[2])."|".trim($airtelRegTNActbase[3])."|".trim($airtelRegTNActbase[4])."|".trim($circle_info[$airtelRegTNActbase[5]])."|".trim($airtelRegTNActbase[6])."|".trim($airtelRegTNActbase[7])."|".trim($lang)."|".trim($airtelRegTNActbase[15]).'|'.trim($airtelRegTNActbase[15]).'|'.trim($airtelRegTNActbase[15])."\r\n";

	error_log($airtelRegTNActiveBasedata,3,$airtelRegTNFilePath) ;

}
	$insertDump1811= 'LOAD DATA LOCAL INFILE "'.$airtelRegTNFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1811,$dbConn);
	
//////////////////////////////////////////////////// End Airtel airtelRegTN //////////////////////////////////////////////////////////////////////////3/10/2013

////////////////////////////////////////////////////Start Airtel MNDKK //////////////////////////////////////////////////////////////////////////

$AirtelMNDKKFile="1513/PAirtelMNDKK_".$fileDate.".txt";
$AirtelMNDKKFilePath=$activeDir.$AirtelMNDKKFile;

	unlink($AirtelMNDKKFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='AirtelMNDKK' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ14="select 'AirtelMNDKK',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_mnd.tbl_character_subscription1 where status=11 and plan_id=81 and date(sub_date)<='".$view_date1."'";  
$query14 = mysql_query($getActiveBaseQ14,$dbConn);
while($AirtelMNDKKActbase = mysql_fetch_array($query14))
{
	if($circle_info[$AirtelMNDKKActbase[5]]=='')
		$circle_info[$AirtelMNDKKActbase[5]]=='Others';
	if($languageData[trim($AirtelMNDKKActbase[8])]!='')
		$lang=$languageData[$AirtelMNDKKActbase[8]];
	else
		$lang=trim($AirtelMNDKKActbase[8]);
	$AirtelMNDKKActiveBasedata=$view_date1."|".trim($AirtelMNDKKActbase[0])."|".trim($AirtelMNDKKActbase[1])."|".trim($AirtelMNDKKActbase[2])."|".trim($AirtelMNDKKActbase[3])."|".trim($AirtelMNDKKActbase[4])."|".trim($circle_info[$AirtelMNDKKActbase[5]])."|".trim($AirtelMNDKKActbase[6])."|".trim($AirtelMNDKKActbase[7])."|".trim($lang)."|".trim($AirtelMNDKKActbase[15]).'|'.trim($AirtelMNDKKActbase[15]).'|'.trim($AirtelMNDKKActbase[15])."\r\n";

	error_log($AirtelMNDKKActiveBasedata,3,$AirtelMNDKKFilePath) ;

}
	$insertDump14= 'LOAD DATA LOCAL INFILE "'.$AirtelMNDKKFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump14,$dbConn);
	
//////////////////////////////////////////////////// End Airtel MNDKK //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start SMSAirtelSex//////////////////////////////////////////////////////////////////////////

$SMSAirtelSexFile="1521/PSMSAirtelSex_".$fileDate.".txt";
$SMSAirtelSexFilePath=$activeDir.$SMSAirtelSexFile;

	unlink($SMSAirtelSexFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='SMSAirtelSex' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ14="select 'SMSAirtelSex',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_smspack.TBL_SEXEDU_SUBSCRIPTION where status=11 and date(sub_date)<='".$view_date1."'";  
$query14 = mysql_query($getActiveBaseQ14,$dbConn);
while($SMSAirtelSexActbase = mysql_fetch_array($query14))
{
	if($circle_info[$SMSAirtelSexActbase[5]]=='')
		$circle_info[$SMSAirtelSexActbase[5]]=='Others';
	if($languageData[trim($SMSAirtelSexActbase[8])]!='')
		$lang=$languageData[$SMSAirtelSexActbase[8]];
	else
		$lang=trim($SMSAirtelSexActbase[8]);
	$SMSAirtelSexActiveBasedata=$view_date1."|".trim($SMSAirtelSexActbase[0])."|".trim($SMSAirtelSexActbase[1])."|".trim($SMSAirtelSexActbase[2])."|".trim($SMSAirtelSexActbase[3])."|".trim($SMSAirtelSexActbase[4])."|".trim($circle_info[$SMSAirtelSexActbase[5]])."|".trim($SMSAirtelSexActbase[6])."|".trim($SMSAirtelSexActbase[7])."|".trim($lang)."|".trim($SMSAirtelSexActbase[15]).'|'.trim($SMSAirtelSexActbase[15]).'|'.trim($SMSAirtelSexActbase[15])."\r\n";

	error_log($SMSAirtelSexActiveBasedata,3,$SMSAirtelSexFilePath) ;

}
	$insertDump1421= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelSexFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1421,$dbConn);
	
//////////////////////////////////////////////////// End SMSAirtelSex//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start SMSAirtelVastu//////////////////////////////////////////////////////////////////////////

$SMSAirtelVastuFile="1521/PSMSAirtelVastu_".$fileDate.".txt";
$SMSAirtelVastuFilePath=$activeDir.$SMSAirtelVastuFile;

	unlink($SMSAirtelVastuFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='SMSAirtelVastu' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ14="select 'SMSAirtelVastu',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_smspack.TBL_VASTU_SUBSCRIPTION where status=11 and date(sub_date)<='".$view_date1."'";  
$query14 = mysql_query($getActiveBaseQ14,$dbConn);
while($SMSAirtelVastuActbase = mysql_fetch_array($query14))
{
	if($circle_info[$SMSAirtelVastuActbase[5]]=='')
		$circle_info[$SMSAirtelVastuActbase[5]]=='Others';
	if($languageData[trim($SMSAirtelVastuActbase[8])]!='')
		$lang=$languageData[$SMSAirtelVastuActbase[8]];
	else
		$lang=trim($SMSAirtelVastuActbase[8]);
	$SMSAirtelVastuActiveBasedata=$view_date1."|".trim($SMSAirtelVastuActbase[0])."|".trim($SMSAirtelVastuActbase[1])."|".trim($SMSAirtelVastuActbase[2])."|".trim($SMSAirtelVastuActbase[3])."|".trim($SMSAirtelVastuActbase[4])."|".trim($circle_info[$SMSAirtelVastuActbase[5]])."|".trim($SMSAirtelVastuActbase[6])."|".trim($SMSAirtelVastuActbase[7])."|".trim($lang)."|".trim($SMSAirtelVastuActbase[15]).'|'.trim($SMSAirtelVastuActbase[15]).'|'.trim($SMSAirtelVastuActbase[15])."\r\n";

	error_log($SMSAirtelVastuActiveBasedata,3,$SMSAirtelVastuFilePath) ;

}
	$insertDump1431= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelVastuFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1431,$dbConn);
	
//////////////////////////////////////////////////// End SMSAirtelVastu//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start SMSAirtelAstro//////////////////////////////////////////////////////////////////////////

$SMSAirtelAstroFile="1521/PSMSAirtelAstro_".$fileDate.".txt";
$SMSAirtelAstroFilePath=$activeDir.$SMSAirtelAstroFile;

	unlink($SMSAirtelAstroFilePath);
	echo $del="delete from mis_db.tbl_base_active where date(date)='".$view_date1."' and service='SMSAirtelAstro' and status='Pending' ";
	$delquery = mysql_query($del,$dbConn);

$getActiveBaseQ14="select 'SMSAirtelAstro',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from airtel_smspack.TBL_ASTRO_SUBSCRIPTION where status=11 and date(sub_date)<='".$view_date1."'";  
$query14 = mysql_query($getActiveBaseQ14,$dbConn);
while($SMSAirtelAstroActbase = mysql_fetch_array($query14))
{
	if($circle_info[$SMSAirtelAstroActbase[5]]=='')
		$circle_info[$SMSAirtelAstroActbase[5]]=='Others';
	if($languageData[trim($SMSAirtelAstroActbase[8])]!='')
		$lang=$languageData[$SMSAirtelAstroActbase[8]];
	else
		$lang=trim($SMSAirtelAstroActbase[8]);
	$SMSAirtelAstroActiveBasedata=$view_date1."|".trim($SMSAirtelAstroActbase[0])."|".trim($SMSAirtelAstroActbase[1])."|".trim($SMSAirtelAstroActbase[2])."|".trim($SMSAirtelAstroActbase[3])."|".trim($SMSAirtelAstroActbase[4])."|".trim($circle_info[$SMSAirtelAstroActbase[5]])."|".trim($SMSAirtelAstroActbase[6])."|".trim($SMSAirtelAstroActbase[7])."|".trim($lang)."|".trim($SMSAirtelAstroActbase[15]).'|'.trim($SMSAirtelAstroActbase[15]).'|'.trim($SMSAirtelAstroActbase[15])."\r\n";

	error_log($SMSAirtelAstroActiveBasedata,3,$SMSAirtelAstroFilePath) ;

}
	$insertDump1441= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelAstroFilePath.'" INTO TABLE mis_db.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1441,$dbConn);
	
//////////////////////////////////////////////////// End SMSAirtelAstro//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////

echo "done";
mysql_close($dbConn);

?>

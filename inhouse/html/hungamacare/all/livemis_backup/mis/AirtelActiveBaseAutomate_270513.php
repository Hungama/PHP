<?php 
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
$activeDir="/var/www/html/kmis/mis/activeBase/";

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fview_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$fileDate= date("YmdHis");

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');


$operator = $_POST['operator'];
$service_info = $_POST['service_info'];
$view_date1 = $_POST['Date'];
$fileDate=date("Ymd",strtotime($view_date1));
////////////////////////////////////////////////////Start Airtel SE //////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'AirtelSE' || $service_info == 'ALL'))
{
$airtelSEFile="1502/AirtelSE_".$fileDate.".txt";
$airtelSEFilePath=$activeDir.$airtelSEFile;

	unlink($airtelSEFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelSE' and status='Active' ";
	echo $del1="delete from mis_db.tbl_activepending_base where date(date)='".$view_date1."' and service='AirtelSE' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	$delquery = mysql_query($del1,$dbConnAirtel);

$getActiveBaseQ16="select 'AirtelSE',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_SPKENG.tbl_spkeng_subscription where status=1 and date(sub_date)<='".$view_date1."'";   
$query16 = mysql_query($getActiveBaseQ16,$dbConnAirtel);
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
	$insertDump16= 'LOAD DATA LOCAL INFILE "'.$airtelSEFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump16,$LivdbConn);
	
	$insertDump161= 'LOAD DATA LOCAL INFILE "'.$airtelSEFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump161,$dbConnAirtel);

}
//////////////////////////////////////////////////// End Airtel SE //////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start Airtel MTV//////////////////////////////////////////////////////////////////////////
if($operator == 'Airtel' && ($service_info == 'MTVAirtel' || $service_info == 'ALL'))
{
$airtelMTVFile="1503/MTVAirtel_".$fileDate.".txt";
$airtelMTVFilePath=$activeDir.$airtelMTVFile;


	unlink($airtelMTVFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTVAirtel' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);


$getActiveBaseQ7="select 'MTVAirtel',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_hungama.tbl_mtv_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConnAirtel);
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
	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$airtelMTVFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump7,$LivdbConn);
	$insertDump71= 'LOAD DATA LOCAL INFILE "'.$airtelMTVFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump71,$dbConnAirtel);
    
}

//////////////////////////////////////////////////// End Airtel MTV//////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Airtel 54646//////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'Airtel54646' || $service_info == 'ALL'))
{
	$airtel54646File="1502/Airtel54646_".$fileDate.".txt";
	$airtel54646FilePath=$activeDir.$airtel54646File;
	unlink($airtel54646FilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='Airtel54646' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);

	$getActiveBaseQ8="select 'Airtel54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_hungama.tbl_jbox_subscription where status=1 and plan_id NOT IN (50) and dnis not like '%p%' and date(sub_date)<='".$view_date1."'";  
	$query8 = mysql_query($getActiveBaseQ8,$dbConnAirtel);
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
	$insertDump8= 'LOAD DATA LOCAL INFILE "'.$airtel54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump8,$LivdbConn);
	$insertDump81= 'LOAD DATA LOCAL INFILE "'.$airtel54646FilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump81,$dbConnAirtel);
    
}

//////////////////////////////////////////////////// End airtel 54646//////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Airtel Devotional//////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'AirtelDevo' || $service_info == 'ALL'))
{
$airtelDevoFile="1510/AirtelDevo_".$fileDate.".txt";
$airtelDevoFilePath=$activeDir.$airtelDevoFile;


	unlink($airtelDevoFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelDevo' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	$getActiveBaseQ9="select 'AirtelDevo',CONCAT('91',a.ani) 'ani',a.sub_date,a.renew_date,a.mode_of_sub,IFNULL(a.circle,'Others'),a.user_bal,'Active',a.def_lang,b.lastreligion_cat from airtel_devo.tbl_devo_subscription as a left JOIN airtel_devo.tbl_religion_profile as b ON b.ANI = a.ANI where a.status=1 and date(a.sub_date)<='".$view_date1."'";  
	$query9 = mysql_query($getActiveBaseQ9,$dbConnAirtel);
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
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$airtelDevoFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);
	$insertDump91= 'LOAD DATA LOCAL INFILE "'.$airtelDevoFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	mysql_query($insertDump91,$dbConnAirtel);
    
}

//////////////////////////////////////////////////// End airtel Devo//////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Airtel Ria//////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'RIAAirtel' || $service_info == 'ALL'))
{
	$airtelRIAFile="1509/RIAAirtel".$fileDate.".txt";
	$airtelRIAFilePath=$activeDir.$airtelRIAFile;
	unlink($airtelRIAFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RIAAirtel' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);

	$getActiveBaseQ10="select 'RIAAirtel',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_manchala.tbl_riya_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
	$query10 = mysql_query($getActiveBaseQ10,$dbConnAirtel);
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
	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$airtelRIAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump10,$LivdbConn);
	$insertDump101= 'LOAD DATA LOCAL INFILE "'.$airtelRIAFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump101,$dbConnAirtel);
    
}

//////////////////////////////////////////////////// End airtel Redfm//////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Airtel ENDLESS//////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'AirtelEU' || $service_info == 'ALL')){
$airtelEndFile="1502/AirtelEU_".$fileDate.".txt";
$airtelENDFilePath=$activeDir.$airtelEndFile;


	unlink($airtelENDFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelEU' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);

	$getActiveBaseQ11="select 'AirtelEU',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_radio.tbl_radio_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
	$query11 = mysql_query($getActiveBaseQ11,$dbConnAirtel);
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
	$insertDump11= 'LOAD DATA LOCAL INFILE "'.$airtelENDFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump11,$LivdbConn);
	$insertDump111= 'LOAD DATA LOCAL INFILE "'.$airtelENDFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump111,$dbConnAirtel);
}

//////////////////////////////////////////////////// End airtel ENDLESS//////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel Rasoi //////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'AirtelGL' || $service_info == 'ALL'))
{
	$airtelRasoiFile="1511/AirtelGL_".$fileDate.".txt";
	$airtelRasoiFilePath=$activeDir.$airtelRasoiFile;
	unlink($airtelRasoiFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelGL' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);

	$getActiveBaseQ12="select 'AirtelGL',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_rasoi.tbl_rasoi_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
	$query12 = mysql_query($getActiveBaseQ12,$dbConnAirtel);
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
	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$airtelRasoiFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump12,$LivdbConn);
	$insertDump121= 'LOAD DATA LOCAL INFILE "'.$airtelRasoiFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump121,$dbConnAirtel);
    
}

//////////////////////////////////////////////////// End Airtel Rasoi //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel Comedy //////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'AirtelComedy' || $service_info == 'ALL')){
$airtelComedyFile="1502/AirtelComedy_".$fileDate.".txt";
$airtelComedyFilePath=$activeDir.$airtelComedyFile;


	unlink($airtelComedyFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelComedy' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);

	$getActiveBaseQ13="select 'AirtelComedy',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_hungama.tbl_comedyportal_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
	$query13 = mysql_query($getActiveBaseQ13,$dbConnAirtel);
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
	$insertDump13= 'LOAD DATA LOCAL INFILE "'.$airtelComedyFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump13,$LivdbConn);
	$insertDump131= 'LOAD DATA LOCAL INFILE "'.$airtelComedyFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump131,$dbConnAirtel);
}

//////////////////////////////////////////////////// End Airtel Comedy //////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Airtel MND //////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'AirtelMND' || $service_info == 'ALL'))
{
	$airtelMNDFile="1502/AirtelMND_".$fileDate.".txt";
	$airtelMNDFilePath=$activeDir.$airtelMNDFile;
	unlink($airtelMNDFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelMND' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
	$getActiveBaseQ14="select 'AirtelMND',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_mnd.tbl_character_subscription1 where status=1 and plan_id!=81 and date(sub_date)<='".$view_date1."'";  
	$query14 = mysql_query($getActiveBaseQ14,$dbConnAirtel);
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
	$insertDump14= 'LOAD DATA LOCAL INFILE "'.$airtelMNDFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump14,$LivdbConn);
	$insertDump141= 'LOAD DATA LOCAL INFILE "'.$airtelMNDFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump141,$dbConnAirtel);
    
}

//////////////////////////////////////////////////// End Airtel MND //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel PD //////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'AirtelPD' || $service_info == 'ALL')){
   $airtelPDFile="1502/AirtelPD_".$fileDate.".txt";
   $airtelPDFilePath=$activeDir.$airtelPDFile;
   unlink($airtelPDFilePath);
   echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelPD' and status='Active' ";
   $delquery = mysql_query($del,$LivdbConn);
   $getActiveBaseQ15="select 'AirtelPD',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_EDU.tbl_jbox_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
   $query15 = mysql_query($getActiveBaseQ15,$dbConnAirtel);
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
	$insertDump15= 'LOAD DATA LOCAL INFILE "'.$airtelPDFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump15,$LivdbConn);
	$insertDump151= 'LOAD DATA LOCAL INFILE "'.$airtelPDFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump151,$dbConnAirtel);
}

//////////////////////////////////////////////////// End Airtel PD //////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Airtel VH1 //////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'VH1Airtel' || $service_info == 'ALL')){
    $airtelVH1File="1502/VH1Airtel_".$fileDate.".txt";
    $airtelVH1FilePath=$activeDir.$airtelVH1File;
	unlink($airtelVH1FilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='VH1Airtel' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
    $getActiveBaseQ17="select 'VH1Airtel',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_vh1.tbl_jbox_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
    $query17 = mysql_query($getActiveBaseQ17,$dbConnAirtel);
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
	$insertDump16= 'LOAD DATA LOCAL INFILE "'.$airtelVH1FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump16,$LivdbConn);
	$insertDump161= 'LOAD DATA LOCAL INFILE "'.$airtelVH1FilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump161,$dbConnAirtel);
}

//////////////////////////////////////////////////// End Airtel VH1 //////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Airtel VH1 //////////////////////////////////////////////////////////////////////////

	$airtelVH1NightFile="1502/VH1AirtelNight_".$fileDate.".txt";
	$airtelVH1NightFilePath=$activeDir.$airtelVH1NightFile;

	unlink($airtelVH1NightFilePath);
	$getActiveBaseQ16="select 'VH1Airtel',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_vh1.tbl_vh1nightpack_subscription where status=1 and date(sub_date)<='".$view_date1."'";   
	$query16 = mysql_query($getActiveBaseQ16,$dbConnAirtel);
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
	$insertDump16= 'LOAD DATA LOCAL INFILE "'.$airtelVH1NightFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump16,$LivdbConn);
	$insertDump161= 'LOAD DATA LOCAL INFILE "'.$airtelVH1NightFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	mysql_query($insertDump161,$dbConnAirtel);

//////////////////////////////////////////////////// End Airtel VH1 //////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Airtel PK //////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'AirtelPK' || $service_info == 'ALL')){
    $airtelPKFile="1502/AirtelPK_".$fileDate.".txt";
    $airtelPKFilePath=$activeDir.$airtelPKFile;
	unlink($airtelPKFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelPK' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
    $getActiveBaseQ17="select 'AirtelPK',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_hungama.tbl_pk_subscription where status=1 and date(sub_date)<='".$view_date1."'"; 
    $query17 = mysql_query($getActiveBaseQ17,$dbConnAirtel);
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
	$insertDump17= 'LOAD DATA LOCAL INFILE "'.$airtelPKFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump17,$LivdbConn);
	$insertDump171= 'LOAD DATA LOCAL INFILE "'.$airtelPKFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump171,$dbConnAirtel);
}
//////////////////////////////////////////////////// End Airtel PK //////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start AirtelRegKK //////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'AirtelRegKK' || $service_info == 'ALL')){
    $airtelRegKKFile="1502/airtelRegKK_".$fileDate.".txt";
    $airtelRegKKFilePath=$activeDir.$airtelRegKKFile;
	unlink($airtelRegKKFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='airtelRegKK' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);

    $getActiveBaseQ18="select 'AirtelRegKK',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_hungama.tbl_arm_subscription where status=1 and plan_id=63 and date(sub_date)<='".$view_date1."'"; 
    $query18 = mysql_query($getActiveBaseQ18,$dbConnAirtel);
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
	$insertDump18= 'LOAD DATA LOCAL INFILE "'.$airtelRegKKFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump18,$LivdbConn);
	$insertDump181= 'LOAD DATA LOCAL INFILE "'.$airtelRegKKFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump181,$dbConnAirtel);
    
}

//////////////////////////////////////////////////// End Airtel AirtelRegKK //////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start AirtelRegTN //////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'AirtelRegTN' || $service_info == 'ALL')){
    $airtelRegTNFile="1502/airtelRegTN_".$fileDate.".txt";
    $airtelRegTNFilePath=$activeDir.$airtelRegTNFile;
	unlink($airtelRegTNFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='airtelRegTN' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
    $getActiveBaseQ18="select 'AirtelRegTN',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_hungama.tbl_arm_subscription where status=1 and plan_id=64 and date(sub_date)<='".$view_date1."'"; 
    $query18 = mysql_query($getActiveBaseQ18,$dbConnAirtel);
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
	$insertDump181= 'LOAD DATA LOCAL INFILE "'.$airtelRegTNFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump181,$LivdbConn);
	$insertDump1812= 'LOAD DATA LOCAL INFILE "'.$airtelRegTNFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1812,$dbConnAirtel);   
}

//////////////////////////////////////////////////// End Airtel airtelRegTN //////////////////////////////////////////////////////////////////////////3/10/2013

////////////////////////////////////////////////////Start Airtel MNDKK //////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'AirtelMNDKK' || $service_info == 'ALL')){
    $AirtelMNDKKFile="1513/AirtelMNDKK_".$fileDate.".txt";
    $AirtelMNDKKFilePath=$activeDir.$AirtelMNDKKFile;
	unlink($AirtelMNDKKFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='AirtelMNDKK' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
    $getActiveBaseQ14="select 'AirtelMNDKK',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_mnd.tbl_character_subscription1 where status=1 and plan_id=81 and date(sub_date)<='".$view_date1."'";  
    $query14 = mysql_query($getActiveBaseQ14,$dbConnAirtel);
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
	$insertDump14= 'LOAD DATA LOCAL INFILE "'.$AirtelMNDKKFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump14,$LivdbConn);
	$insertDump141= 'LOAD DATA LOCAL INFILE "'.$AirtelMNDKKFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump141,$dbConnAirtel);
    
}

//////////////////////////////////////////////////// End Airtel MNDKK //////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start SMSAirtelSex//////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' &&  ($service_info == 'SMSAirtelSex' || $service_info == 'ALL')){
    $SMSAirtelSexFile="1521/SMSAirtelSex_".$fileDate.".txt";
    $SMSAirtelSexFilePath=$activeDir.$SMSAirtelSexFile;
	unlink($SMSAirtelSexFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='SMSAirtelSex' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);
    $getActiveBaseQ14="select 'SMSAirtelSex',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_smspack.TBL_SEXEDU_SUBSCRIPTION where status=1 and date(sub_date)<='".$view_date1."'";  
    $query14 = mysql_query($getActiveBaseQ14,$dbConnAirtel);
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
	$insertDump142= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelSexFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump142,$LivdbConn);
	$insertDump1421= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelSexFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1421,$dbConnAirtel);
    
}

//////////////////////////////////////////////////// End SMSAirtelSex//////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////Start SMSAirtelVastu//////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'SMSAirtelVastu' || $service_info == 'ALL'))
{
$SMSAirtelVastuFile="1521/SMSAirtelVastu_".$fileDate.".txt";
$SMSAirtelVastuFilePath=$activeDir.$SMSAirtelVastuFile;


	unlink($SMSAirtelVastuFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='SMSAirtelVastu' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);

$getActiveBaseQ14="select 'SMSAirtelVastu',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_smspack.TBL_VASTU_SUBSCRIPTION where status=1 and date(sub_date)<='".$view_date1."'";  
$query14 = mysql_query($getActiveBaseQ14,$dbConnAirtel);
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
	$insertDump143= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelVastuFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump143,$LivdbConn);
	$insertDump1431= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelVastuFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1431,$dbConnAirtel);
    
}

//////////////////////////////////////////////////// End SMSAirtelVastu//////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start SMSAirtelAstro//////////////////////////////////////////////////////////////////////////

if($operator == 'Airtel' && ($service_info == 'SMSAirtelAstro' || $service_info == 'ALL'))
{
	$SMSAirtelAstroFile="1521/SMSAirtelAstro_".$fileDate.".txt";
	$SMSAirtelAstroFilePath=$activeDir.$SMSAirtelAstroFile;
	unlink($SMSAirtelAstroFilePath);
	echo $del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='SMSAirtelAstro' and status='Active' ";
	$delquery = mysql_query($del,$LivdbConn);

	$getActiveBaseQ14="select 'SMSAirtelAstro',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from airtel_smspack.TBL_ASTRO_SUBSCRIPTION where status=1 and date(sub_date)<='".$view_date1."'";  
	$query14 = mysql_query($getActiveBaseQ14,$dbConnAirtel);

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
	$insertDump144= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelAstroFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump144,$LivdbConn);
	$insertDump1441= 'LOAD DATA LOCAL INFILE "'.$SMSAirtelAstroFilePath.'" INTO TABLE mis_db.tbl_activepending_base FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump1441,$dbConnAirtel);
}

//////////////////////////////////////////////////// End SMSAirtelAstro//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////

echo "done";
mysql_close($dbConnAirtel);
mysql_close($LivdbConn);





?>

<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");
$activeDir="/var/www/html/kmis/testing/activeBase/";

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fileDate= date("YmdHis");

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');

////////////////////////////////////////////////////Start Mts MTV//////////////////////////////////////////////////////////////////////////



$MtsMTVFile="1103/MTVMts_".$fileDate.".txt";
$MtsMTVFilePath=$activeDir.$MtsMTVFile;

	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTVMTS' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);


$getActiveBaseQ7="select 'MTVMTS',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_mtv.tbl_mtv_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($MtsMtvActbase = mysql_fetch_array($query7))
{
	if($circle_info[$MtsMtvActbase[5]]=='')
		$MtsMtvActbase[5]='Others';

	if($languageData[trim($MtsMtvActbase[8])]!='')
		$lang=$languageData[$MtsMtvActbase[8]];
	else
		$lang=trim($MtsMtvActbase[8]);
	$MtsMTVActiveBasedata=$view_date1."|".trim($MtsMtvActbase[0])."|".trim($MtsMtvActbase[1])."|".trim($MtsMtvActbase[2])."|".trim($MtsMtvActbase[3])."|".trim($MtsMtvActbase[4])."|".trim($circle_info[$MtsMtvActbase[5]])."|".trim($MtsMtvActbase[6])."|".trim($MtsMtvActbase[7])."|".trim($lang)."|".trim($MtsMtvActbase[15]).'|'.trim($MtsMtvActbase[15]).'|'.trim($MtsMtvActbase[15])."\r\n";
	error_log($MtsMTVActiveBasedata,3,$MtsMTVFilePath) ;
}
	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$MtsMTVFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump7,$LivdbConn);

//////////////////////////////////////////////////// End Mts MTV/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Mts REDFM//////////////////////////////////////////////////////////////////////////

$MtsRedFMFile="1110/RedFMMts_".$fileDate.".txt";
$MtsRedFMFilePath=$activeDir.$MtsRedFMFile;

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RedFMMTS' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);


$getActiveBaseQ7="select 'RedFMMTS',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_redfm.tbl_jbox_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($MtsRedFMActbase = mysql_fetch_array($query7))
{
	if($circle_info[$MtsRedFMActbase[5]]=='')
		$MtsRedFMActbase[5]='Others';

	if($languageData[trim($MtsRedFMActbase[8])]!='')
		$lang=$languageData[$MtsRedFMActbase[8]];
	else
		$lang=trim($MtsRedFMActbase[8]);
	$MtsRedFMActiveBasedata=$view_date1."|".trim($MtsRedFMActbase[0])."|".trim($MtsRedFMActbase[1])."|".trim($MtsRedFMActbase[2])."|".trim($MtsRedFMActbase[3])."|".trim($MtsRedFMActbase[4])."|".trim($circle_info[$MtsRedFMActbase[5]])."|".trim($MtsRedFMActbase[6])."|".trim($MtsRedFMActbase[7])."|".trim($lang)."|".trim($MtsRedFMActbase[15]).'|'.trim($MtsRedFMActbase[15]).'|'.trim($MtsRedFMActbase[15])."\r\n";
	error_log($MtsRedFMActiveBasedata,3,$MtsRedFMFilePath) ;
}
	$insertDump8= 'LOAD DATA LOCAL INFILE "'.$MtsRedFMFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump8,$LivdbConn);


/////////////////////////////////////////////// End Mts REDFM/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Mts VA//////////////////////////////////////////////////////////////////////////

$MtsVAFile="1116/VAMts_".$fileDate.".txt";
$MtsVAFilePath=$activeDir.$MtsVAFile;


	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSVA' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);


$getActiveBaseQ7="select 'MTSVA',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_voicealert.tbl_voice_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($MtsVAActbase = mysql_fetch_array($query7))
{
	if($circle_info[$MtsVAActbase[5]]=='')
		$MtsVAActbase[5]='Others';

	if($languageData[trim($MtsVAActbase[8])]!='')
		$lang=$languageData[$MtsVAActbase[8]];
	else
		$lang=trim($MtsVAActbase[8]);
	$MtsVAActiveBasedata=$view_date1."|".trim($MtsVAActbase[0])."|".trim($MtsVAActbase[1])."|".trim($MtsVAActbase[2])."|".trim($MtsVAActbase[3])."|".trim($MtsVAActbase[4])."|".trim($circle_info[$MtsVAActbase[5]])."|".trim($MtsVAActbase[6])."|".trim($MtsVAActbase[7])."|".trim($lang)."|".trim($MtsVAActbase[15]).'|'.trim($MtsVAActbase[15]).'|'.trim($MtsVAActbase[15])."\r\n";
	error_log($MtsVAActiveBasedata,3,$MtsVAFilePath) ;
}
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$MtsVAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump9,$LivdbConn);


//////////////////////////////////////////////////// End Mts VA/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending Mts MTV//////////////////////////////////////////////////////////////////////////

$PMtsMTVFile="1103/PMTVMts_".$fileDate.".txt";
$PMtsMTVFilePath=$activeDir.$PMtsMTVFile;


	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTVMTS' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);


$getPendingBaseQ7="select 'MTVMTS',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_mtv.tbl_mtv_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PMtsMTVActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PMtsMTVActbase[5]]=='')
		$PMtsMTVActbase[5]='Others';

	if($languageData[trim($PMtsMTVActbase[8])]!='')
		$lang=$languageData[$PMtsMTVActbase[8]];
	else
		$lang=trim($PMtsMTVActbase[8]);
	$PMtsMTVPendingBasedata=$view_date1."|".trim($PMtsMTVActbase[0])."|".trim($PMtsMTVActbase[1])."|".trim($PMtsMTVActbase[2])."|".trim($PMtsMTVActbase[3])."|".trim($PMtsMTVActbase[4])."|".trim($circle_info[$PMtsMTVActbase[5]])."|".trim($PMtsMTVActbase[6])."|".trim($PMtsMTVActbase[7])."|".trim($lang)."|".trim($PMtsMTVActbase[15]).'|'.trim($PMtsMTVActbase[15]).'|'.trim($PMtsMTVActbase[15])."\r\n";
	error_log($PMtsMTVPendingBasedata,3,$PMtsMTVFilePath) ;
}
	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$PMtsMTVFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump10,$LivdbConn);


//////////////////////////////////////////////////// End Pending Mts MTV/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending Mts REDFM//////////////////////////////////////////////////////////////////////////

$PMtsRedFMFile="1110/PRedFMMts_".$fileDate.".txt";
$PMtsRedFMFilePath=$activeDir.$PMtsRedFMFile;


	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RedFMMTS' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);


$getPendingBaseQ7="select 'RedFMMTS',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_redfm.tbl_jbox_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PMtsRedFMActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PMtsRedFMActbase[5]]=='')
		$PMtsRedFMActbase[5]='Others';

	if($languageData[trim($PMtsRedFMActbase[8])]!='')
		$lang=$languageData[$PMtsRedFMActbase[8]];
	else
		$lang=trim($PMtsRedFMActbase[8]);
	$PMtsRedFMPendingBasedata=$view_date1."|".trim($PMtsRedFMActbase[0])."|".trim($PMtsRedFMActbase[1])."|".trim($PMtsRedFMActbase[2])."|".trim($PMtsRedFMActbase[3])."|".trim($PMtsRedFMActbase[4])."|".trim($circle_info[$PMtsRedFMActbase[5]])."|".trim($PMtsRedFMActbase[6])."|".trim($PMtsRedFMActbase[7])."|".trim($lang)."|".trim($PMtsRedFMActbase[15]).'|'.trim($PMtsRedFMActbase[15]).'|'.trim($PMtsRedFMActbase[15])."\r\n";
	error_log($PMtsRedFMPendingBasedata,3,$PMtsRedFMFilePath) ;
}
	$insertDump11= 'LOAD DATA LOCAL INFILE "'.$PMtsRedFMFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump11,$LivdbConn);


//////////////////////////////////////////////////// End Pending Mts REDFM/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending Mts VA//////////////////////////////////////////////////////////////////////////

$PMtsVAFile="1116/PVAMts_".$fileDate.".txt";
$PMtsVAFilePath=$activeDir.$PMtsVAFile;


	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSVA' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);


$getPendingBaseQ7="select 'MTSVA',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_voicealert.tbl_voice_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PMtsVAActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PMtsVAActbase[5]]=='')
		$PMtsVAActbase[5]='Others';

	if($languageData[trim($PMtsVAActbase[8])]!='')
		$lang=$languageData[$PMtsVAActbase[8]];
	else
		$lang=trim($PMtsVAActbase[8]);
	$PMtsVAPendingBasedata=$view_date1."|".trim($PMtsVAActbase[0])."|".trim($PMtsVAActbase[1])."|".trim($PMtsVAActbase[2])."|".trim($PMtsVAActbase[3])."|".trim($PMtsVAActbase[4])."|".trim($circle_info[$PMtsVAActbase[5]])."|".trim($PMtsVAActbase[6])."|".trim($PMtsVAActbase[7])."|".trim($lang)."|".trim($PMtsVAActbase[15]).'|'.trim($PMtsVAActbase[15]).'|'.trim($PMtsVAActbase[15])."\r\n";
	error_log($PMtsVAPendingBasedata,3,$PMtsVAFilePath) ;
}
	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$PMtsVAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump12,$LivdbConn);


//////////////////////////////////////////////////// End Pending Mts VA/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start MTSMU//////////////////////////////////////////////////////////////////////////

$MTSMUFile="1101/MTSMU_".$fileDate.".txt";
$MTSMUFilePath=$activeDir.$MTSMUFile;


	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSMU' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);


$getActiveBaseQ7="select 'MTSMU',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_radio.tbl_radio_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($MTSMUActbase = mysql_fetch_array($query7))
{
	if($circle_info[$MTSMUActbase[5]]=='')
		$MTSMUActbase[5]='Others';

	if($languageData[trim($MTSMUActbase[8])]!='')
		$lang=$languageData[$MTSMUActbase[8]];
	else
		$lang=trim($MTSMUActbase[8]);
	$MTSMUActiveBasedata=$view_date1."|".trim($MTSMUActbase[0])."|".trim($MTSMUActbase[1])."|".trim($MTSMUActbase[2])."|".trim($MTSMUActbase[3])."|".trim($MTSMUActbase[4])."|".trim($circle_info[$MTSMUActbase[5]])."|".trim($MTSMUActbase[6])."|".trim($MTSMUActbase[7])."|".trim($lang)."|".trim($MTSMUActbase[15]).'|'.trim($MTSMUActbase[15]).'|'.trim($MTSMUActbase[15])."\r\n";
	error_log($MTSMUActiveBasedata,3,$MTSMUFilePath) ;
}
	$insertDump13= 'LOAD DATA LOCAL INFILE "'.$MTSMUFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump13,$LivdbConn);

//////////////////////////////////////////////////// End MTSMU/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start MTSMPD//////////////////////////////////////////////////////////////////////////

$MTSMPDFile="1113/MTSMPD_".$fileDate.".txt";
$MTSMPDFilePath=$activeDir.$MTSMPDFile;


	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSMND' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);


$getActiveBaseQ7="select 'MTSMND',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_mnd.tbl_character_subscription1 where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($MTSMPDActbase = mysql_fetch_array($query7))
{
	if($circle_info[$MTSMPDActbase[5]]=='')
		$MTSMPDActbase[5]='Others';

	if($languageData[trim($MTSMPDActbase[8])]!='')
		$lang=$languageData[$MTSMPDActbase[8]];
	else
		$lang=trim($MTSMPDActbase[8]);
	$MTSMPDActiveBasedata=$view_date1."|".trim($MTSMPDActbase[0])."|".trim($MTSMPDActbase[1])."|".trim($MTSMPDActbase[2])."|".trim($MTSMPDActbase[3])."|".trim($MTSMPDActbase[4])."|".trim($circle_info[$MTSMPDActbase[5]])."|".trim($MTSMPDActbase[6])."|".trim($MTSMPDActbase[7])."|".trim($lang)."|".trim($MTSMPDActbase[15]).'|'.trim($MTSMPDActbase[15]).'|'.trim($MTSMPDActbase[15])."\r\n";
	error_log($MTSMPDActiveBasedata,3,$MTSMPDFilePath) ;
}
	$insertDump14= 'LOAD DATA LOCAL INFILE "'.$MTSMPDFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump14,$LivdbConn);


//////////////////////////////////////////////////// End MTSMPD/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start MTSFMJ//////////////////////////////////////////////////////////////////////////

$MTSFMJFile="1106/MTSFMJ_".$fileDate.".txt";
$MTSFMJFilePath=$activeDir.$MTSFMJFile;


	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSFMJ' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);


$getActiveBaseQ7="select 'MTSFMJ',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_starclub.tbl_jbox_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($MTSFMJActbase = mysql_fetch_array($query7))
{
	if($circle_info[$MTSFMJActbase[5]]=='')
		$MTSFMJActbase[5]='Others';

	if($languageData[trim($MTSFMJActbase[8])]!='')
		$lang=$languageData[$MTSFMJActbase[8]];
	else
		$lang=trim($MTSFMJActbase[8]);
	$MTSFMJActiveBasedata=$view_date1."|".trim($MTSFMJActbase[0])."|".trim($MTSFMJActbase[1])."|".trim($MTSFMJActbase[2])."|".trim($MTSFMJActbase[3])."|".trim($MTSFMJActbase[4])."|".trim($circle_info[$MTSFMJActbase[5]])."|".trim($MTSFMJActbase[6])."|".trim($MTSFMJActbase[7])."|".trim($lang)."|".trim($MTSFMJActbase[15]).'|'.trim($MTSFMJActbase[15]).'|'.trim($MTSFMJActbase[15])."\r\n";
	error_log($MTSFMJActiveBasedata,3,$MTSFMJFilePath) ;
}
	$insertDump15= 'LOAD DATA LOCAL INFILE "'.$MTSFMJFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump15,$LivdbConn);


//////////////////////////////////////////////////// End MTSFMJ/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending MTSMU//////////////////////////////////////////////////////////////////////////

$PMTSMUFile="1101/PMTSMU_".$fileDate.".txt";
$PMTSMUFilePath=$activeDir.$PMTSMUFile;

$getPendingBaseQ7="select 'MTSMU',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_radio.tbl_radio_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PMTSMUActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PMTSMUActbase[5]]=='')
		$PMTSMUActbase[5]='Others';

	if($languageData[trim($PMTSMUActbase[8])]!='')
		$lang=$languageData[$PMTSMUActbase[8]];
	else
		$lang=trim($PMTSMUActbase[8]);
	$PMTSMUPendingBasedata=$view_date1."|".trim($PMTSMUActbase[0])."|".trim($PMTSMUActbase[1])."|".trim($PMTSMUActbase[2])."|".trim($PMTSMUActbase[3])."|".trim($PMTSMUActbase[4])."|".trim($circle_info[$PMTSMUActbase[5]])."|".trim($PMTSMUActbase[6])."|".trim($PMTSMUActbase[7])."|".trim($lang)."|".trim($PMTSMUActbase[15]).'|'.trim($PMTSMUActbase[15]).'|'.trim($PMTSMUActbase[15])."\r\n";
	error_log($PMTSMUPendingBasedata,3,$PMTSMUFilePath) ;
}

	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSMU' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);

	$insertDump16= 'LOAD DATA LOCAL INFILE "'.$PMTSMUFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		if(mysql_query($insertDump16,$LivdbConn))
		{
		echo "done";
		}
		else
		{
		echo mysql_errno($LivdbConn) . ": " . mysql_error($LivdbConn). "\n";
		}


//////////////////////////////////////////////////// End Pending MTSMU/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending MTSMPD//////////////////////////////////////////////////////////////////////////

$PMTSMPDFile="1113/PMTSMPD_".$fileDate.".txt";
$PMTSMPDFilePath=$activeDir.$PMTSMPDFile;


	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSMND' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);

$getPendingBaseQ7="select 'MTSMND',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_mnd.tbl_character_subscription1 where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PMTSMPDActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PMTSMPDActbase[5]]=='')
		$PMTSMPDActbase[5]='Others';

	if($languageData[trim($PMTSMPDActbase[8])]!='')
		$lang=$languageData[$PMTSMPDActbase[8]];
	else
		$lang=trim($PMTSMPDActbase[8]);
	$PMTSMPDPendingBasedata=$view_date1."|".trim($PMTSMPDActbase[0])."|".trim($PMTSMPDActbase[1])."|".trim($PMTSMPDActbase[2])."|".trim($PMTSMPDActbase[3])."|".trim($PMTSMPDActbase[4])."|".trim($circle_info[$PMTSMPDActbase[5]])."|".trim($PMTSMPDActbase[6])."|".trim($PMTSMPDActbase[7])."|".trim($lang)."|".trim($PMTSMPDActbase[15]).'|'.trim($PMTSMPDActbase[15]).'|'.trim($PMTSMPDActbase[15])."\r\n";
	error_log($PMTSMPDPendingBasedata,3,$PMTSMPDFilePath) ;
}
	$insertDump17= 'LOAD DATA LOCAL INFILE "'.$PMTSMPDFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump17,$LivdbConn);


//////////////////////////////////////////////////// End Pending MTSMPD/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending MTSFMJ//////////////////////////////////////////////////////////////////////////

$PMTSFMJFile="1106/PMTSFMJ_".$fileDate.".txt";
$PMTSFMJFilePath=$activeDir.$PMTSFMJFile;

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSFMJ' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);


$getPendingBaseQ7="select 'MTSFMJ',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_starclub.tbl_jbox_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PMTSFMJActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PMTSFMJActbase[5]]=='')
		$PMTSFMJActbase[5]='Others';

	if($languageData[trim($PMTSFMJActbase[8])]!='')
		$lang=$languageData[$PMTSFMJActbase[8]];
	else
		$lang=trim($PMTSFMJActbase[8]);
	$PMTSFMJPendingBasedata=$view_date1."|".trim($PMTSFMJActbase[0])."|".trim($PMTSFMJActbase[1])."|".trim($PMTSFMJActbase[2])."|".trim($PMTSFMJActbase[3])."|".trim($PMTSFMJActbase[4])."|".trim($circle_info[$PMTSFMJActbase[5]])."|".trim($PMTSFMJActbase[6])."|".trim($PMTSFMJActbase[7])."|".trim($lang)."|".trim($PMTSFMJActbase[15]).'|'.trim($PMTSFMJActbase[15]).'|'.trim($PMTSFMJActbase[15])."\r\n";
	error_log($PMTSFMJPendingBasedata,3,$PMTSFMJFilePath) ;
}
	$insertDump18= 'LOAD DATA LOCAL INFILE "'.$PMTSFMJFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump18,$LivdbConn);


//////////////////////////////////////////////////// End Pending MTSFMJ/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start MTSDevo//////////////////////////////////////////////////////////////////////////

$MTSDevoFile="1111/MTSDevo_".$fileDate.".txt";
$MTSDevoFilePath=$activeDir.$MTSDevoFile;

	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSDevo' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);


$getActiveBaseQ7="select 'MTSDevo',CONCAT('91',a.ani) 'ani',a.sub_date,a.renew_date,a.mode_of_sub,IFNULL(a.circle,'Others'),a.user_bal,'Active',a.def_lang,b.lastreligion_cat from dm_radio.tbl_digi_subscription as a left JOIN dm_radio.tbl_religion_profile as b ON b.ANI = a.ANI where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($MTSDevoActbase = mysql_fetch_array($query7))
{
	if($circle_info[$MTSDevoActbase[5]]=='')
		$MTSDevoActbase[5]='Others';

	if($languageData[trim($MTSDevoActbase[8])]!='')
		$lang=$languageData[$MTSDevoActbase[8]];
	else
		$lang=trim($MTSDevoActbase[8]);
	$MTSDevoActiveBasedata=$view_date1."|".trim($MTSDevoActbase[0])."|".trim($MTSDevoActbase[1])."|".trim($MTSDevoActbase[2])."|".trim($MTSDevoActbase[3])."|".trim($MTSDevoActbase[4])."|".trim($circle_info[$MTSDevoActbase[5]])."|".trim($MTSDevoActbase[6])."|".trim($MTSDevoActbase[7])."|".trim($lang)."|".trim($MTSDevoActbase[9]).'|'.trim($MTSDevoActbase[15]).'|'.trim($MTSDevoActbase[15])."\r\n";
	error_log($MTSDevoActiveBasedata,3,$MTSDevoFilePath) ;
}
	$insertDump19= 'LOAD DATA LOCAL INFILE "'.$MTSDevoFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump19,$LivdbConn);

//////////////////////////////////////////////////// End MTSDevo/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start MTSComedy//////////////////////////////////////////////////////////////////////////

$MTSComedyFile="11012/MTSComedy_".$fileDate.".txt";
$MTSComedyFilePath=$activeDir.$MTSComedyFile;

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSComedy' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);


$getActiveBaseQ7="select 'MTSComedy',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_radio.tbl_radio_subscription where status=1 and plan_id='29' and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($MTSComedyActbase = mysql_fetch_array($query7))
{
	if($circle_info[$MTSComedyActbase[5]]=='')
		$MTSComedyActbase[5]='Others';

	if($languageData[trim($MTSComedyActbase[8])]!='')
		$lang=$languageData[$MTSComedyActbase[8]];
	else
		$lang=trim($MTSComedyActbase[8]);
	$MTSComedyActiveBasedata=$view_date1."|".trim($MTSComedyActbase[0])."|".trim($MTSComedyActbase[1])."|".trim($MTSComedyActbase[2])."|".trim($MTSComedyActbase[3])."|".trim($MTSComedyActbase[4])."|".trim($circle_info[$MTSComedyActbase[5]])."|".trim($MTSComedyActbase[6])."|".trim($MTSComedyActbase[7])."|".trim($lang)."|".trim($MTSComedyActbase[15]).'|'.trim($MTSComedyActbase[15]).'|'.trim($MTSComedyActbase[15])."\r\n";
	error_log($MTSComedyActiveBasedata,3,$MTSComedyFilePath) ;
}
	$insertDump20= 'LOAD DATA LOCAL INFILE "'.$MTSComedyFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump20,$LivdbConn);


//////////////////////////////////////////////////// End MTSComedy/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start MTS54646//////////////////////////////////////////////////////////////////////////

$MTS54646File="1102/MTS54646_".$fileDate.".txt";
$MTS54646FilePath=$activeDir.$MTS54646File;


	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTS54646' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);

$getActiveBaseQ7="select 'MTS54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_hungama.tbl_jbox_subscription where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
while($MTS54646Actbase = mysql_fetch_array($query7))
{
	if($circle_info[$MTS54646Actbase[5]]=='')
		$MTS54646Actbase[5]='Others';

	if($languageData[trim($MTS54646Actbase[8])]!='')
		$lang=$languageData[$MTS54646Actbase[8]];
	else
		$lang=trim($MTS54646Actbase[8]);
	$MTS54646ActiveBasedata=$view_date1."|".trim($MTS54646Actbase[0])."|".trim($MTS54646Actbase[1])."|".trim($MTS54646Actbase[2])."|".trim($MTS54646Actbase[3])."|".trim($MTS54646Actbase[4])."|".trim($circle_info[$MTS54646Actbase[5]])."|".trim($MTS54646Actbase[6])."|".trim($MTS54646Actbase[7])."|".trim($lang)."|".trim($MTS54646Actbase[15]).'|'.trim($MTS54646Actbase[15]).'|'.trim($MTS54646Actbase[15])."\r\n";
	error_log($MTS54646ActiveBasedata,3,$MTS54646FilePath) ;
}
	$insertDump21= 'LOAD DATA LOCAL INFILE "'.$MTS54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump21,$LivdbConn);


//////////////////////////////////////////////////// End MTS54646/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending MTSDevo//////////////////////////////////////////////////////////////////////////

$PMTSDevoFile="1111/PMTSDevo_".$fileDate.".txt";
$PMTSDevoFilePath=$activeDir.$PMTSDevoFile;

	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSDevo' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);

$getPendingBaseQ7="select 'MTSDevo',CONCAT('91',a.ani) 'ani',a.sub_date,a.renew_date,a.mode_of_sub,IFNULL(a.circle,'Others'),a.user_bal,'Pending',a.def_lang,b.lastreligion_cat from dm_radio.tbl_digi_subscription as a left JOIN dm_radio.tbl_religion_profile as b ON b.ANI = a.ANI where status!=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PMTSDevoActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PMTSDevoActbase[5]]=='')
		$PMTSDevoActbase[5]='Others';

	if($languageData[trim($PMTSDevoActbase[8])]!='')
		$lang=$languageData[$PMTSDevoActbase[8]];
	else
		$lang=trim($PMTSDevoActbase[8]);
	$PMTSDevoPendingBasedata=$view_date1."|".trim($PMTSDevoActbase[0])."|".trim($PMTSDevoActbase[1])."|".trim($PMTSDevoActbase[2])."|".trim($PMTSDevoActbase[3])."|".trim($PMTSDevoActbase[4])."|".trim($circle_info[$PMTSDevoActbase[5]])."|".trim($PMTSDevoActbase[6])."|".trim($PMTSDevoActbase[7])."|".trim($lang)."|".trim($PMTSDevoActbase[9]).'|'.trim($PMTSDevoActbase[15]).'|'.trim($PMTSDevoActbase[15])."\r\n";
	error_log($PMTSDevoPendingBasedata,3,$PMTSDevoFilePath) ;
}
	$insertDump22= 'LOAD DATA LOCAL INFILE "'.$PMTSDevoFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump22,$LivdbConn);


//////////////////////////////////////////////////// End Pending MTSDevo/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending MTSComedy//////////////////////////////////////////////////////////////////////////

$PMTSComedyFile="11012/PMTSComedy_".$fileDate.".txt";
$PMTSComedyFilePath=$activeDir.$PMTSComedyFile;


	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSComedy' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);

$getPendingBaseQ7="select 'MTSComedy',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_radio.tbl_radio_subscription where status=11 and plan_id='29' and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PMTSComedyActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PMTSComedyActbase[5]]=='')
		$PMTSComedyActbase[5]='Others';

	if($languageData[trim($PMTSComedyActbase[8])]!='')
		$lang=$languageData[$PMTSComedyActbase[8]];
	else
		$lang=trim($PMTSComedyActbase[8]);
	$PMTSComedyPendingBasedata=$view_date1."|".trim($PMTSComedyActbase[0])."|".trim($PMTSComedyActbase[1])."|".trim($PMTSComedyActbase[2])."|".trim($PMTSComedyActbase[3])."|".trim($PMTSComedyActbase[4])."|".trim($circle_info[$PMTSComedyActbase[5]])."|".trim($PMTSComedyActbase[6])."|".trim($PMTSComedyActbase[7])."|".trim($lang)."|".trim($PMTSComedyActbase[15]).'|'.trim($PMTSComedyActbase[15]).'|'.trim($PMTSComedyActbase[15])."\r\n";
	error_log($PMTSComedyPendingBasedata,3,$PMTSComedyFilePath) ;
}
	$insertDump23= 'LOAD DATA LOCAL INFILE "'.$PMTSComedyFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump23,$LivdbConn);


//////////////////////////////////////////////////// End Pending MTSComedy/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending MTS54646//////////////////////////////////////////////////////////////////////////

$PMTS54646File="1102/PMTS54646_".$fileDate.".txt";
$PMTS54646FilePath=$activeDir.$PMTS54646File;


	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTS54646' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);


$getPendingBaseQ7="select 'MTS54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_hungama.tbl_jbox_subscription where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
while($PMTS54646Actbase = mysql_fetch_array($query7))
{
	if($circle_info[$PMTS54646Actbase[5]]=='')
		$PMTS54646Actbase[5]='Others';

	if($languageData[trim($PMTS54646Actbase[8])]!='')
		$lang=$languageData[$PMTS54646Actbase[8]];
	else
		$lang=trim($PMTS54646Actbase[8]);
	$PMTS54646PendingBasedata=$view_date1."|".trim($PMTS54646Actbase[0])."|".trim($PMTS54646Actbase[1])."|".trim($PMTS54646Actbase[2])."|".trim($PMTS54646Actbase[3])."|".trim($PMTS54646Actbase[4])."|".trim($circle_info[$PMTS54646Actbase[5]])."|".trim($PMTS54646Actbase[6])."|".trim($PMTS54646Actbase[7])."|".trim($lang)."|".trim($PMTS54646Actbase[15]).'|'.trim($PMTS54646Actbase[15]).'|'.trim($PMTS54646Actbase[15])."\r\n";
	error_log($PMTS54646PendingBasedata,3,$PMTS54646FilePath) ;
}
	$insertDump24= 'LOAD DATA LOCAL INFILE "'.$PMTS54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		mysql_query($insertDump24,$LivdbConn);


//////////////////////////////////////////////////// End Pending MTS54646/////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////

mysql_close($dbConn);
mysql_close($LivdbConn);


?>

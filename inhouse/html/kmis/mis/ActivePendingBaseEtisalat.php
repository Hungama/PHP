<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
$activeDir="/var/www/html/kmis/testing/activeBase/";
$processlog = "/var/www/html/kmis/testing/activeBase/logs/etisalat/processlog_activepending_".date(Ymd).".txt";

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$fileDate= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');

////////////////////////////////////////////////////Start Etisalat Active Base//////////////////////////////////////////////////////////////////////////

$EtisalatActiveBaseFile="21212/EtisalatActive_".$fileDate.".txt";
$EtisalatFilePath=$activeDir.$EtisalatActiveBaseFile;
$file_process_status = '***************Script start for Etisalat Active Base******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($EtisalatFilePath))
{
	unlink($EtisalatFilePath);
	$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='SMSEtisalatNigeria' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	error_log($file_process_status, 3, $processlog);
}

$getActiveBaseQ1="select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'SPL',user_bal,'Active',def_lang FROM etislat_hsep.tbl_sfp_subscription nolock WHERE status=1 and date(sub_date)<='".$view_date1."'
UNION
select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'EPL',user_bal,'Active',def_lang FROM etislat_hsep.tbl_epl_subscription nolock WHERE status=1 and date(sub_date)<='".$view_date1."'
UNION
select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'Fun',user_bal,'Active',def_lang FROM etislat_hsep.tbl_funnews_subscription nolock WHERE status=1 and date(sub_date)<='".$view_date1."'
UNION
select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'Jokes',user_bal,'Active',def_lang FROM etislat_hsep.tbl_jokes_subscription nolock WHERE status=1 and date(sub_date)<='".$view_date1."'
UNION
select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'Hollywood',user_bal,'Active',def_lang FROM etislat_hsep.tbl_hollywood_subscription nolock WHERE status=1 and date(sub_date)<='".$view_date1."'
UNION
select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'Motive',user_bal,'Active',def_lang FROM etislat_hsep.tbl_mot_subscription nolock WHERE status=1 and date(sub_date)<='".$view_date1."'
UNION
select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'Lifestyle',user_bal,'Active',def_lang FROM etislat_hsep.tbl_lsp_subscription nolock WHERE status=1 and date(sub_date)<='".$view_date1."'";

$query7 = mysql_query($getActiveBaseQ1,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
 $file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
while($EtisalatActbase = mysql_fetch_array($query7))
{
	if($languageData[trim($EtisalatActbase[8])]!='')
		$lang=$languageData[$EtisalatActbase[8]];
	else
		$lang=trim($EtisalatActbase[8]);
	$EtisalatActiveBasedata=$view_date1."|".trim($EtisalatActbase[0])."|".trim($EtisalatActbase[1])."|".trim($EtisalatActbase[2])."|".trim($EtisalatActbase[3])."|".trim($EtisalatActbase[4])."|".trim($EtisalatActbase[5])."|".trim($EtisalatActbase[6])."|".trim($EtisalatActbase[7])."|".trim($lang)."|".trim($EtisalatActbase[15]).'|'.trim($EtisalatActbase[15]).'|'.trim($EtisalatActbase[15])."\r\n";
	error_log($EtisalatActiveBasedata,3,$EtisalatFilePath) ;
}
  $file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$insertDump1= 'LOAD DATA LOCAL INFILE "'.$EtisalatFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//mysql_query($insertDump1,$LivdbConn);
	if(mysql_query($insertDump1, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for Etisalat Active Base******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
////////////////////////////////////////////////////Active Base End For Etisalat/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Etisalat Pending Base//////////////////////////////////////////////////////////////////////////

$EtisalatPendingBaseFile="21212/EtisalatPending_".$fileDate.".txt";
$EtisalatFilePath=$activeDir.$EtisalatPendingBaseFile;
$file_process_status = '***************Script start for Etisalat Pending Base******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($EtisalatFilePath))
{
	unlink($EtisalatFilePath);
	$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='SMSEtisalatNigeria' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	error_log($file_process_status, 3, $processlog);
}

$getPendingBaseQ1="select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'SPL',user_bal,'Pending',def_lang FROM etislat_hsep.tbl_sfp_subscription nolock WHERE status!=1 and date(sub_date)<='".$view_date1."'
UNION
select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'EPL',user_bal,'Pending',def_lang FROM etislat_hsep.tbl_epl_subscription nolock WHERE status!=1 and date(sub_date)<='".$view_date1."'
UNION
select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'Fun',user_bal,'Pending',def_lang FROM etislat_hsep.tbl_funnews_subscription nolock WHERE status!=1 and date(sub_date)<='".$view_date1."'
UNION
select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'Jokes',user_bal,'Pending',def_lang FROM etislat_hsep.tbl_jokes_subscription nolock WHERE status!=1 and date(sub_date)<='".$view_date1."'
UNION
select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'Hollywood',user_bal,'Pending',def_lang FROM etislat_hsep.tbl_hollywood_subscription nolock WHERE status!=1 and date(sub_date)<='".$view_date1."'
UNION
select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'Motive',user_bal,'Pending',def_lang FROM etislat_hsep.tbl_mot_subscription nolock WHERE status!=1 and date(sub_date)<='".$view_date1."'
UNION
select 'SMSEtisalatNigeria',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,'Lifestyle',user_bal,'Pending',def_lang FROM etislat_hsep.tbl_lsp_subscription nolock WHERE status!=1 and date(sub_date)<='".$view_date1."'";

$query7 = mysql_query($getPendingBaseQ1,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
while($EtisalatPendingbase = mysql_fetch_array($query7))
{
	if($languageData[trim($EtisalatPendingbase[8])]!='')
		$lang=$languageData[$EtisalatPendingbase[8]];
	else
		$lang=trim($EtisalatPendingbase[8]);
	$EtisalatPendingBasedata=$view_date1."|".trim($EtisalatPendingbase[0])."|".trim($EtisalatPendingbase[1])."|".trim($EtisalatPendingbase[2])."|".trim($EtisalatPendingbase[3])."|".trim($EtisalatPendingbase[4])."|".trim($EtisalatPendingbase[5])."|".trim($EtisalatPendingbase[6])."|".trim($EtisalatPendingbase[7])."|".trim($lang)."|".trim($EtisalatPendingbase[15]).'|'.trim($EtisalatPendingbase[15]).'|'.trim($EtisalatPendingbase[15])."\r\n";
	error_log($EtisalatPendingBasedata,3,$EtisalatFilePath) ;
}
 $file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	$insertDump2= 'LOAD DATA LOCAL INFILE "'.$EtisalatFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//mysql_query($insertDump2,$LivdbConn);
	if(mysql_query($insertDump2, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for Etisalat Pending Base******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
echo "done";

mysql_close($dbConn);
mysql_close($LivdbConn);
?>
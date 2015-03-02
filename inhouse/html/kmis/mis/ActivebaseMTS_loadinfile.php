<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");
$activeDir="/var/www/html/kmis/testing/activeBase/";
$processlog = "/var/www/html/kmis/testing/activeBase/logs/mts/processlog_active_pending_".date(Ymd).".txt";
$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
//$fileDate= date("YmdHis");
$fileDate = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');

///////////////////////////////////////////////////Start MTSJokes //////////////////////////////////////////////////////////////////////////

$MTS54646File="1125/MTSJokesPortal_".$fileDate.".txt";
$MTS54646FilePath=$activeDir.$MTS54646File;
$file_process_status = '***************Script start for MTS MTSJokes Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($MTS54646FilePath))
{
//unlink($MTS54646FilePath);

$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSJokes' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
		
$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
}
/*
$getActiveBaseQ7="select 'MTSJokes',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_JOKEPORTAL.tbl_jokeportal_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
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
*/
	$insertDump21= 'LOAD DATA LOCAL INFILE "'.$MTS54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump21, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSJokes ******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}

//////////////////////////////////////////////////// End MTSJokes /////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start MTS Regional//////////////////////////////////////////////////////////////////////////

$MTS54646File="1126/MTSRegional_".$fileDate.".txt";
$MTS54646FilePath=$activeDir.$MTS54646File;
$file_process_status = '***************Script start for MTS Regional Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($MTS54646FilePath))
{
//unlink($MTS54646FilePath);

$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSReg' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
		
$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
}
/*
$getActiveBaseQ7="select 'MTSReg',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_Regional.tbl_regional_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
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
*/
	$insertDump21= 'LOAD DATA LOCAL INFILE "'.$MTS54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump21,$LivdbConn);
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump21, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTS Regional ******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}

//////////////////////////////////////////////////// End MTS Regional/////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////Start Pending MTS Jokes Portal//////////////////////////////////////////////////////////////////////////

$PMTS54646File="1125/PMTSJokesPortal_".$fileDate.".txt";
$PMTS54646FilePath=$activeDir.$PMTS54646File;

$file_process_status = '***************Script start for MTSJokes Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($PMTS54646FilePath))
{
//unlink($PMTSComedyFilePath);

$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSJokes' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
}
/*
$getPendingBaseQ7="select 'MTSJokes',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_JOKEPORTAL.tbl_jokeportal_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
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
*/
	$insertDump24= 'LOAD DATA LOCAL INFILE "'.$PMTS54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump24, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSJokes ******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	//}


//////////////////////////////////////////////////// End Pending MTSJokes /////////////////////////////////////////////////////////////////////////
        
         ////////////////////////////////////////////////////Start Pending MTS Regional//////////////////////////////////////////////////////////////////////////

$PMTS54646File="1126/PMTSRegional_".$fileDate.".txt";
$PMTS54646FilePath=$activeDir.$PMTS54646File;

$file_process_status = '***************Script start for MTS Regional Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($PMTS54646FilePath))
{
//unlink($PMTSComedyFilePath);

$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSReg' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
}
/*
$getPendingBaseQ7="select 'MTSReg',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_Regional.tbl_regional_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
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
	*/
	$insertDump24= 'LOAD DATA LOCAL INFILE "'.$PMTS54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump24,$LivdbConn);
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump24, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTS Regional******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//	}


//////////////////////////////////////////////////// End Pending MTS Regional/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Mts MTV//////////////////////////////////////////////////////////////////////////

$MtsMTVFile="1103/MTVMts_".$fileDate.".txt";
$MtsMTVFilePath=$activeDir.$MtsMTVFile;
$file_process_status = '***************Script start for MTVMTS Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($MtsMTVFilePath))
{	//unlink($MtsMTVFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTVMTS' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
}
/*
$getActiveBaseQ7="select 'MTVMTS',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_mtv.tbl_mtv_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

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
$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
*/
	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$MtsMTVFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
//		mysql_query($insertDump7,$LivdbConn);
 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(mysql_query($insertDump7, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTVMTS******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
//}
//////////////////////////////////////////////////// End Mts MTV/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Mts REDFM//////////////////////////////////////////////////////////////////////////

$MtsRedFMFile="1110/RedFMMts_".$fileDate.".txt";
$MtsRedFMFilePath=$activeDir.$MtsRedFMFile;
$file_process_status = '***************Script start for RedFMMTS Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($MtsRedFMFilePath))
{	//unlink($MtsRedFMFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RedFMMTS' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
}
/*
$getActiveBaseQ7="select 'RedFMMTS',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_redfm.tbl_jbox_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

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
$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
*/
	$insertDump8= 'LOAD DATA LOCAL INFILE "'.$MtsRedFMFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		//mysql_query($insertDump8,$LivdbConn);
		 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump8, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for RedFMMTS******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
//}

/////////////////////////////////////////////// End Mts REDFM/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Mts VA//////////////////////////////////////////////////////////////////////////

$MtsVAFile="1116/VAMts_".$fileDate.".txt";
$MtsVAFilePath=$activeDir.$MtsVAFile;
$file_process_status = '***************Script start for MTSVA Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($MtsVAFilePath))
{	//unlink($MtsVAFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSVA' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
		
$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
}
/*
$getActiveBaseQ7="select 'MTSVA',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_voicealert.tbl_voice_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

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
*/
	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$MtsVAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump9,$LivdbConn);
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump9, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSVA******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}
//////////////////////////////////////////////////// End Mts VA/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending Mts MTV//////////////////////////////////////////////////////////////////////////

$PMtsMTVFile="1103/PMTVMts_".$fileDate.".txt";
$PMtsMTVFilePath=$activeDir.$PMtsMTVFile;
$file_process_status = '***************Script start for MTVMTS Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($PMtsMTVFilePath))
{	//unlink($PMtsMTVFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTVMTS' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getPendingBaseQ7="select 'MTVMTS',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_mtv.tbl_mtv_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
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
*/
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
//error_log($file_process_status, 3, $processlog);
	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$PMtsMTVFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		//mysql_query($insertDump10,$LivdbConn);
		$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump10, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTVMTS******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);



//////////////////////////////////////////////////// End Pending Mts MTV/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending Mts REDFM//////////////////////////////////////////////////////////////////////////

$PMtsRedFMFile="1110/PRedFMMts_".$fileDate.".txt";
$PMtsRedFMFilePath=$activeDir.$PMtsRedFMFile;
$file_process_status = '***************Script start for RedFMMTS Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($PMtsRedFMFilePath))
{	//unlink($PMtsRedFMFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RedFMMTS' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getPendingBaseQ7="select 'RedFMMTS',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_redfm.tbl_jbox_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

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
}*/
	$insertDump11= 'LOAD DATA LOCAL INFILE "'.$PMtsRedFMFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		//mysql_query($insertDump11,$LivdbConn);
		$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump11, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for RedFMMTS******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
//}

//////////////////////////////////////////////////// End Pending Mts REDFM/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending Mts VA//////////////////////////////////////////////////////////////////////////

$PMtsVAFile="1116/PVAMts_".$fileDate.".txt";
$PMtsVAFilePath=$activeDir.$PMtsVAFile;
$file_process_status = '***************Script start for MTSVA Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($PMtsVAFilePath))
{	//unlink($PMtsVAFilePath);

$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSVA' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
}
/*
$getPendingBaseQ7="select 'MTSVA',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_voicealert.tbl_voice_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

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
*/
	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$PMtsVAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump12,$LivdbConn);
	
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump12, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSVA******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}

//////////////////////////////////////////////////// End Pending Mts VA/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start MTSMU//////////////////////////////////////////////////////////////////////////

$MTSMUFile="1101/MTSMU_".$fileDate.".txt";
$MTSMUFilePath=$activeDir.$MTSMUFile;
$file_process_status = '***************Script start for MTSMU Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($MTSMUFilePath))
{
//unlink($MTSMUFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSMU' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getActiveBaseQ7="select 'MTSMU',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_radio.tbl_radio_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

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
}*/
	$insertDump13= 'LOAD DATA LOCAL INFILE "'.$MTSMUFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump13,$LivdbConn);
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump13, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSMU******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}
//////////////////////////////////////////////////// End MTSMU/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start MTSMPD//////////////////////////////////////////////////////////////////////////

$MTSMPDFile="1113/MTSMPD_".$fileDate.".txt";
$MTSMPDFilePath=$activeDir.$MTSMPDFile;
$file_process_status = '***************Script start for MTSMND Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($MTSMPDFilePath))
{
//unlink($MTSMPDFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSMND' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getActiveBaseQ7="select 'MTSMND',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_mnd.tbl_character_subscription1 nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

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
*/
	$insertDump14= 'LOAD DATA LOCAL INFILE "'.$MTSMPDFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump14,$LivdbConn);
	
$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump14, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSMND******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);


//}
//////////////////////////////////////////////////// End MTSMPD/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start MTSFMJ//////////////////////////////////////////////////////////////////////////

$MTSFMJFile="1106/MTSFMJ_".$fileDate.".txt";
$MTSFMJFilePath=$activeDir.$MTSFMJFile;
$file_process_status = '***************Script start for MTSFMJ Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($MTSFMJFilePath))
{
//unlink($MTSFMJFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSFMJ' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
		
$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

}
/*
$getActiveBaseQ7="select 'MTSFMJ',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_starclub.tbl_jbox_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

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
	*/
	$insertDump15= 'LOAD DATA LOCAL INFILE "'.$MTSFMJFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		//mysql_query($insertDump15,$LivdbConn);
		$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump15, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSFMJ******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}

//////////////////////////////////////////////////// End MTSFMJ/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending MTSMU//////////////////////////////////////////////////////////////////////////

$PMTSMUFile="1101/PMTSMU_".$fileDate.".txt";
$PMTSMUFilePath=$activeDir.$PMTSMUFile;
$file_process_status = '***************Script start for MTSMU Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($PMTSMUFilePath))
{
//unlink($PMTSMUFilePath);

$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSMU' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
}
/*
$getPendingBaseQ7="select 'MTSMU',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_radio.tbl_radio_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);


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
*/
$insertDump16= 'LOAD DATA LOCAL INFILE "'.$PMTSMUFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump16, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSMU******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}	

	


//////////////////////////////////////////////////// End Pending MTSMU/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending MTSMPD//////////////////////////////////////////////////////////////////////////

$PMTSMPDFile="1113/PMTSMPD_".$fileDate.".txt";
$PMTSMPDFilePath=$activeDir.$PMTSMPDFile;
$file_process_status = '***************Script start for MTSMND Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($PMTSMPDFilePath))
{
//unlink($PMTSMPDFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSMND' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getPendingBaseQ7="select 'MTSMND',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_mnd.tbl_character_subscription1 nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

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
*/
	$insertDump17= 'LOAD DATA LOCAL INFILE "'.$PMTSMPDFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		//mysql_query($insertDump17,$LivdbConn);
		$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump17, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSMND******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}

//////////////////////////////////////////////////// End Pending MTSMPD/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending MTSFMJ//////////////////////////////////////////////////////////////////////////

$PMTSFMJFile="1106/PMTSFMJ_".$fileDate.".txt";
$PMTSFMJFilePath=$activeDir.$PMTSFMJFile;
$file_process_status = '***************Script start for MTSFMJ Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($PMTSFMJFilePath))
{
//unlink($PMTSFMJFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSFMJ' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getPendingBaseQ7="select 'MTSFMJ',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_starclub.tbl_jbox_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
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
*/
	$insertDump18= 'LOAD DATA LOCAL INFILE "'.$PMTSFMJFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
//		mysql_query($insertDump18,$LivdbConn);
$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump18, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSFMJ******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);


//}
//////////////////////////////////////////////////// End Pending MTSFMJ/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start MTSDevo//////////////////////////////////////////////////////////////////////////

$MTSDevoFile="1111/MTSDevo_".$fileDate.".txt";
$MTSDevoFilePath=$activeDir.$MTSDevoFile;
$file_process_status = '***************Script start for MTSDevo Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($MTSDevoFilePath))
{
//unlink($MTSDevoFilePath);

$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSDevo' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

}
/*
$getActiveBaseQ7="select 'MTSDevo',CONCAT('91',a.ani) 'ani',a.sub_date,a.renew_date,a.mode_of_sub,IFNULL(a.circle,'Others'),a.user_bal,'Active',a.def_lang,b.lastreligion_cat from dm_radio.tbl_digi_subscription as a left JOIN dm_radio.tbl_religion_profile as b ON b.ANI = a.ANI where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

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
*/
	$insertDump19= 'LOAD DATA LOCAL INFILE "'.$MTSDevoFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		//mysql_query($insertDump19,$LivdbConn);
		$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump19, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSDevo******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

		
//}
//////////////////////////////////////////////////// End MTSDevo/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start MTSComedy//////////////////////////////////////////////////////////////////////////

$MTSComedyFile="11012/MTSComedy_".$fileDate.".txt";
$MTSComedyFilePath=$activeDir.$MTSComedyFile;
$file_process_status = '***************Script start for MTSComedy Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($MTSComedyFilePath))
{
//unlink($MTSComedyFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSComedy' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getActiveBaseQ7="select 'MTSComedy',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_radio.tbl_radio_subscription nolock where status=1 and plan_id='29' and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
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
*/
	$insertDump20= 'LOAD DATA LOCAL INFILE "'.$MTSComedyFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
//		mysql_query($insertDump20,$LivdbConn);
$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump20, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSComedy******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}

//////////////////////////////////////////////////// End MTSComedy/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start MTS54646//////////////////////////////////////////////////////////////////////////

$MTS54646File="1102/MTS54646_".$fileDate.".txt";
$MTS54646FilePath=$activeDir.$MTS54646File;
$file_process_status = '***************Script start for MTS54646 Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($MTS54646FilePath))
{
//unlink($MTS54646FilePath);

$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTS54646' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);
		
$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getActiveBaseQ7="select 'MTS54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_hungama.tbl_jbox_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
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
}*/
	$insertDump21= 'LOAD DATA LOCAL INFILE "'.$MTS54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump21,$LivdbConn);
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump21, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTS54646******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}

//////////////////////////////////////////////////// End MTS54646/////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////Start Pending MTSDevo//////////////////////////////////////////////////////////////////////////

$PMTSDevoFile="1111/PMTSDevo_".$fileDate.".txt";
$PMTSDevoFilePath=$activeDir.$PMTSDevoFile;
$file_process_status = '***************Script start for MTSDevo Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($PMTSDevoFilePath))
{
//unlink($PMTSDevoFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSDevo' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getPendingBaseQ7="select 'MTSDevo',CONCAT('91',a.ani) 'ani',a.sub_date,a.renew_date,a.mode_of_sub,IFNULL(a.circle,'Others'),a.user_bal,'Pending',a.def_lang,b.lastreligion_cat from dm_radio.tbl_digi_subscription as a left JOIN dm_radio.tbl_religion_profile as b ON b.ANI = a.ANI where status!=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);

$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

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
}*/

	$insertDump22= 'LOAD DATA LOCAL INFILE "'.$PMTSDevoFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump22,$LivdbConn);
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump22, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSDevo******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}

//////////////////////////////////////////////////// End Pending MTSDevo/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending MTSComedy//////////////////////////////////////////////////////////////////////////

$PMTSComedyFile="11012/PMTSComedy_".$fileDate.".txt";
$PMTSComedyFilePath=$activeDir.$PMTSComedyFile;
$file_process_status = '***************Script start for MTSComedy Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($PMTSComedyFilePath))
{
//unlink($PMTSComedyFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSComedy' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getPendingBaseQ7="select 'MTSComedy',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_radio.tbl_radio_subscription nolock where status=11 and plan_id='29' and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

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
*/
	$insertDump23= 'LOAD DATA LOCAL INFILE "'.$PMTSComedyFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump23,$LivdbConn);
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump23, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSComedy******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}

//////////////////////////////////////////////////// End Pending MTSComedy/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending MTS54646//////////////////////////////////////////////////////////////////////////

$PMTS54646File="1102/PMTS54646_".$fileDate.".txt";
$PMTS54646FilePath=$activeDir.$PMTS54646File;

$file_process_status = '***************Script start for MTS54646 Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($PMTS54646FilePath))
{
//unlink($PMTSComedyFilePath);

$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTS54646' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getPendingBaseQ7="select 'MTS54646',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_hungama.tbl_jbox_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
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
*/
	$insertDump24= 'LOAD DATA LOCAL INFILE "'.$PMTS54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump24,$LivdbConn);
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump24, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTS54646******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	//}


//////////////////////////////////////////////////// End Pending MTS54646/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Mts MTSAC Active//////////////////////////////////////////////////////////////////////////

$MTSACFile="1124/MTSAC_".$fileDate.".txt";
$MTSACFilePath=$activeDir.$MTSACFile;
$file_process_status = '***************Script start for MTSAC Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($MTSACFilePath))
{
//unlink($MTSACFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSAC' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getActiveBaseQ7="select 'MTSAC',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Active',def_lang from mts_radio.tbl_AudioCinema_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);

$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
while($MTSACActbase = mysql_fetch_array($query7))
{
	if($circle_info[$MTSACActbase[5]]=='')
		$MTSACActbase[5]='Others';

	if($languageData[trim($MTSACActbase[8])]!='')
		$lang=$languageData[$MTSACActbase[8]];
	else
		$lang=trim($MTSACActbase[8]);
	$MTSACActiveBasedata=$view_date1."|".trim($MTSACActbase[0])."|".trim($MTSACActbase[1])."|".trim($MTSACActbase[2])."|".trim($MTSACActbase[3])."|".trim($MTSACActbase[4])."|".trim($circle_info[$MTSACActbase[5]])."|".trim($MTSACActbase[6])."|".trim($MTSACActbase[7])."|".trim($lang)."|".trim($MTSACActbase[15]).'|'.trim($MTSACActbase[15]).'|'.trim($MTSACActbase[15])."\r\n";
	error_log($MTSACActiveBasedata,3,$MTSACFilePath) ;
}
*/
	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$MTSACFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
//		mysql_query($insertDump7,$LivdbConn);
$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump7, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSAC******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}
//////////////////////////////////////////////////// End Mts MTSAC/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending Mts MTV//////////////////////////////////////////////////////////////////////////

$PMTSACFile="1103/PMTSAC_".$fileDate.".txt";
$PMTSACFilePath=$activeDir.$PMTSACFile;

$file_process_status = '***************Script start for MTSAC Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($PMTSACFilePath))
{
//unlink($PMTSACFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSAC' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);
		
$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getPendingBaseQ7="select 'MTSAC',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),user_bal,'Pending',def_lang from mts_radio.tbl_AudioCinema_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);

$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

while($PMTSACActbase = mysql_fetch_array($query7))
{
	if($circle_info[$PMTSACActbase[5]]=='')
		$PMTSACActbase[5]='Others';

	if($languageData[trim($PMTSACActbase[8])]!='')
		$lang=$languageData[$PMTSACActbase[8]];
	else
		$lang=trim($PMTSACActbase[8]);
	$PMTSACPendingBasedata=$view_date1."|".trim($PMTSACActbase[0])."|".trim($PMTSACActbase[1])."|".trim($PMTSACActbase[2])."|".trim($PMTSACActbase[3])."|".trim($PMTSACActbase[4])."|".trim($circle_info[$PMTSACActbase[5]])."|".trim($PMTSACActbase[6])."|".trim($PMTSACActbase[7])."|".trim($lang)."|".trim($PMTSACActbase[15]).'|'.trim($PMTSACActbase[15]).'|'.trim($PMTSACActbase[15])."\r\n";
	error_log($PMTSACPendingBasedata,3,$PMTSACFilePath) ;
}
*/
	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$PMTSACFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump10,$LivdbConn);
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump10, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSAC******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}

//////////////////////////////////////////////////// End Pending Mts MTV/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Mts Contest//////////////////////////////////////////////////////////////////////////

$MtsContestFile="1123/ContestMts_".$fileDate.".txt";
$MtsContestFilePath=$activeDir.$MtsContestFile;
$file_process_status = '***************Script start for ContestMTS Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

if(file_exists($MtsContestFilePath))
{	//unlink($MtsContestFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSContest' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);
	$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getActiveBaseQ7="select 'MTSContest',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),score,'Active',def_lang from Mts_summer_contest.tbl_contest_subscription nolock where status=1 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConn);
$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

while($MtsContestActbase = mysql_fetch_array($query7))
{
     if($circle_info[$MtsContestActbase[5]]=='')
		$MtsContestActbase[5]='Others';

	if($languageData[trim($MtsContestActbase[8])]!='')
		$lang=$languageData[$MtsContestActbase[8]];
	else
		$lang=trim($MtsContestActbase[8]);
	$MtsContestActiveBasedata=$view_date1."|".trim($MtsContestActbase[0])."|".trim($MtsContestActbase[1])."|".trim($MtsContestActbase[2])."|".trim($MtsContestActbase[3])."|".trim($MtsContestActbase[4])."|".trim($circle_info[$MtsContestActbase[5]])."|".trim($MtsContestActbase[6])."|".trim($MtsContestActbase[7])."|".trim($lang)."|".trim($MtsContestActbase[15]).'|'.trim($MtsContestActbase[15]).'|'.trim($MtsContestActbase[15])."\r\n";
	error_log($MtsContestActiveBasedata,3,$MtsContestFilePath) ;
}
$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
*/
	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$MtsContestFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
//		mysql_query($insertDump7,$LivdbConn);
 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(mysql_query($insertDump7, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSContest******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
//}

//////////////////////////////////////////////////// End Mts Contest/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending Mts Contest//////////////////////////////////////////////////////////////////////////

$PMTSContestFile="1123/PMTSContest_".$fileDate.".txt";
$PMTSContestFilePath=$activeDir.$PMTSContestFile;

$file_process_status = '***************Script start for MTSContest Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
if(file_exists($PMTSContestFilePath))
{
//unlink($PMTSContestFilePath);
$file_process_status = 'Delete existing file at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSContest' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);
		
$file_process_status = 'Delete data from misdata.tbl_base_active at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
}
/*
$getPendingBaseQ7="select 'MTSContest',CONCAT('91',ani) 'ani',sub_date,renew_date,mode_of_sub,IFNULL(circle,'Others'),score,'Pending',def_lang from Mts_summer_contest.tbl_contest_subscription nolock where status=11 and date(sub_date)<='".$view_date1."'";  
$query7 = mysql_query($getPendingBaseQ7,$dbConn);

$numRows1 = mysql_num_rows($query7);
if ($numRows1 > 0) {
$file_process_status = 'Create new file start here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

while($PMTSContestActbase = mysql_fetch_array($query7))
{ 
    if($circle_info[$PMTSContestActbase[5]]=='')
		$PMTSContestActbase[5]='Others';

	if($languageData[trim($PMTSContestActbase[8])]!='')
		$lang=$languageData[$PMTSContestActbase[8]];
	else
		$lang=trim($PMTSContestActbase[8]);
	$PMTSContestPendingBasedata=$view_date1."|".trim($PMTSContestActbase[0])."|".trim($PMTSContestActbase[1])."|".trim($PMTSContestActbase[2])."|".trim($PMTSContestActbase[3])."|".trim($PMTSContestActbase[4])."|".trim($circle_info[$PMTSContestActbase[5]])."|".trim($PMTSContestActbase[6])."|".trim($PMTSContestActbase[7])."|".trim($lang)."|".trim($PMTSContestActbase[15]).'|'.trim($PMTSContestActbase[15]).'|'.trim($PMTSContestActbase[15])."\r\n";
	error_log($PMTSContestPendingBasedata,3,$PMTSContestFilePath) ;
}
*/
	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$PMTSContestFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
	//	mysql_query($insertDump10,$LivdbConn);
	$file_process_status = 'Create new file end here at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = 'Load data start at' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

 if (!$LivdbConn) {
        $dbstatus = "#DB-Status-NotConnected#" . date("Y-m-d H:i:s") . "\n";
    } else {
        $dbstatus = "#DB-Status-Connected#" . date("Y-m-d H:i:s") . "\n";
    }
	$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $dbstatus .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	
	
if(mysql_query($insertDump10, $LivdbConn))
	{
    $file_process_status = 'Load Data query execute successfully'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	
error_log($file_process_status, 3, $processlog);
$file_process_status = '***************Script end for MTSContest******************'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

//}
//////////////////////////////////////////////////// End Pending Mts Contest/////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////

mysql_close($dbConn);
mysql_close($LivdbConn);
?>
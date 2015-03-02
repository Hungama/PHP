<?php
//////////////////////////////////////////////////////// code Start to dump Active bbase for Docomo Operator///////////////////////////////////////////////////
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectMTS.php");
$activeDir="/var/www/html/kmis/testing/activeBase/";

//echo $LivdbConn;

$view_date1= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

$fileDate= date("Ymd");
echo $view_date1='2014-03-05';
echo "<br>";
echo $fileDate='20140305';
//exit;
$processlog = "/var/www/html/kmis/testing/activeBase/logs/mts/processlog_active_pending_retry".$fileDate.".txt";

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','UND'=>'Others','Others'=>'Others');

$languageData = array('01'=>'Hindi','02'=>'English','03'=>'Punjabi','04'=>'Bhojpuri','05'=>'Haryanavi','06'=>'Bengali','07'=>'Tamil','08'=>'Telugu','09'=>'Malayalam','10'=>'Kannada','11'=>'Marathi','12'=>'Gujarati','13'=>'Oriya','14'=>'Kashmiri','15'=>'Himachali','16'=>'Chhattisgarhi','17'=>'Assamese','18'=>'Rajasthani','19'=>'Nepali','20'=>'Kumaoni','21'=>'Maithali','99'=>'Hindi');

/*
////////////////////////////////////////////////////Start Mts MTV//////////////////////////////////////////////////////////////////////////
$file_process_status = '***************Script start for MTVMTS Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
$MtsMTVFile="1103/MTVMts_".$fileDate.".txt";
echo $MtsMTVFilePath=$activeDir.$MtsMTVFile;

$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTVMTS' and status='Active'";
$delquery = mysql_query($del,$LivdbConn);

	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$MtsMTVFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n"(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
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


//////////////////////////////////////////////////// End Mts MTV/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Mts REDFM//////////////////////////////////////////////////////////////////////////

$MtsRedFMFile="1110/RedFMMts_".$fileDate.".txt";
$MtsRedFMFilePath=$activeDir.$MtsRedFMFile;
$file_process_status = '***************Script start for RedFMMTS Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RedFMMTS' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);

	$insertDump8= 'LOAD DATA LOCAL INFILE "'.$MtsRedFMFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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


/////////////////////////////////////////////// End Mts REDFM/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Mts VA//////////////////////////////////////////////////////////////////////////

$MtsVAFile="1116/VAMts_".$fileDate.".txt";
$MtsVAFilePath=$activeDir.$MtsVAFile;
$file_process_status = '***************Script start for MTSVA Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSVA' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);

	$insertDump9= 'LOAD DATA LOCAL INFILE "'.$MtsVAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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


//////////////////////////////////////////////////// End Mts VA/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending Mts MTV//////////////////////////////////////////////////////////////////////////

$PMtsMTVFile="1103/PMTVMts_".$fileDate.".txt";
$PMtsMTVFilePath=$activeDir.$PMtsMTVFile;

$file_process_status = '***************Script start for MTVMTS Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTVMTS' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);


	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$PMtsMTVFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='RedFMMTS' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);

	$insertDump11= 'LOAD DATA LOCAL INFILE "'.$PMtsRedFMFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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

//////////////////////////////////////////////////// End Pending Mts REDFM/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending Mts VA//////////////////////////////////////////////////////////////////////////

$PMtsVAFile="1116/PVAMts_".$fileDate.".txt";
$PMtsVAFilePath=$activeDir.$PMtsVAFile;
$file_process_status = '***************Script start for MTSVA Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSVA' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);

	$insertDump12= 'LOAD DATA LOCAL INFILE "'.$PMtsVAFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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


//////////////////////////////////////////////////// End Pending Mts VA/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start MTSMU//////////////////////////////////////////////////////////////////////////

$MTSMUFile="1101/MTSMU_".$fileDate.".txt";
$MTSMUFilePath=$activeDir.$MTSMUFile;

$file_process_status = '***************Script start for MTSMU Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSMU' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);

	$insertDump13= 'LOAD DATA LOCAL INFILE "'.$MTSMUFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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

//////////////////////////////////////////////////// End MTSMU/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start MTSMPD//////////////////////////////////////////////////////////////////////////

$MTSMPDFile="1113/MTSMPD_".$fileDate.".txt";
$MTSMPDFilePath=$activeDir.$MTSMPDFile;
$file_process_status = '***************Script start for MTSMND Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);


	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSMND' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);

	$insertDump14= 'LOAD DATA LOCAL INFILE "'.$MTSMPDFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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



//////////////////////////////////////////////////// End MTSMPD/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start MTSFMJ//////////////////////////////////////////////////////////////////////////

$MTSFMJFile="1106/MTSFMJ_".$fileDate.".txt";
$MTSFMJFilePath=$activeDir.$MTSFMJFile;

$file_process_status = '***************Script start for MTSFMJ Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSFMJ' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);


	$insertDump15= 'LOAD DATA LOCAL INFILE "'.$MTSFMJFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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


//////////////////////////////////////////////////// End MTSFMJ/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending MTSMU//////////////////////////////////////////////////////////////////////////

$PMTSMUFile="1101/PMTSMU_".$fileDate.".txt";
$PMTSMUFilePath=$activeDir.$PMTSMUFile;
$file_process_status = '***************Script start for MTSMU Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSMU' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);

	$insertDump16= 'LOAD DATA LOCAL INFILE "'.$PMTSMUFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
		
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

//////////////////////////////////////////////////// End Pending MTSMU/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending MTSMPD//////////////////////////////////////////////////////////////////////////

$PMTSMPDFile="1113/PMTSMPD_".$fileDate.".txt";
$PMTSMPDFilePath=$activeDir.$PMTSMPDFile;
$file_process_status = '***************Script start for MTSMND Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSMND' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);

	$insertDump17= 'LOAD DATA LOCAL INFILE "'.$PMTSMPDFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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


//////////////////////////////////////////////////// End Pending MTSMPD/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending MTSFMJ//////////////////////////////////////////////////////////////////////////

$PMTSFMJFile="1106/PMTSFMJ_".$fileDate.".txt";
$PMTSFMJFilePath=$activeDir.$PMTSFMJFile;
$file_process_status = '***************Script start for MTSFMJ Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSFMJ' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);

	$insertDump18= 'LOAD DATA LOCAL INFILE "'.$PMTSFMJFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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


//////////////////////////////////////////////////// End Pending MTSFMJ/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start MTSDevo//////////////////////////////////////////////////////////////////////////

$MTSDevoFile="1111/MTSDevo_".$fileDate.".txt";
$MTSDevoFilePath=$activeDir.$MTSDevoFile;
$file_process_status = '***************Script start for MTSDevo Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSDevo' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);

	$insertDump19= 'LOAD DATA LOCAL INFILE "'.$MTSDevoFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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

//////////////////////////////////////////////////// End MTSDevo/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start MTSComedy//////////////////////////////////////////////////////////////////////////

$MTSComedyFile="11012/MTSComedy_".$fileDate.".txt";
$MTSComedyFilePath=$activeDir.$MTSComedyFile;
$file_process_status = '***************Script start for MTSComedy Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSComedy' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);

	$insertDump20= 'LOAD DATA LOCAL INFILE "'.$MTSComedyFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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



//////////////////////////////////////////////////// End MTSComedy/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start MTS54646//////////////////////////////////////////////////////////////////////////

$MTS54646File="1102/MTS54646_".$fileDate.".txt";
$MTS54646FilePath=$activeDir.$MTS54646File;

$file_process_status = '***************Script start for MTS54646 Active******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTS54646' and status='Active'";
	$delquery = mysql_query($del1,$LivdbConn);

	$insertDump21= 'LOAD DATA LOCAL INFILE "'.$MTS54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

		
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


//////////////////////////////////////////////////// End MTS54646/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending MTSDevo//////////////////////////////////////////////////////////////////////////

$PMTSDevoFile="1111/PMTSDevo_".$fileDate.".txt";
$PMTSDevoFilePath=$activeDir.$PMTSDevoFile;
$file_process_status = '***************Script start for MTSDevo Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSDevo' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);

	$insertDump22= 'LOAD DATA LOCAL INFILE "'.$PMTSDevoFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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


//////////////////////////////////////////////////// End Pending MTSDevo/////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////Start Pending MTSComedy//////////////////////////////////////////////////////////////////////////

$PMTSComedyFile="11012/PMTSComedy_".$fileDate.".txt";
$PMTSComedyFilePath=$activeDir.$PMTSComedyFile;

$file_process_status = '***************Script start for MTSComedy Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSComedy' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);

	$insertDump23= 'LOAD DATA LOCAL INFILE "'.$PMTSComedyFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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


//////////////////////////////////////////////////// End Pending MTSComedy/////////////////////////////////////////////////////////////////////////
*/
////////////////////////////////////////////////////Start Pending MTS54646//////////////////////////////////////////////////////////////////////////

$PMTS54646File="1102/PMTS54646_".$fileDate.".txt";
$PMTS54646FilePath=$activeDir.$PMTS54646File;


$file_process_status = '***************Script start for MTS54646 Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del1="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTS54646' and status='Pending'";
	$delquery = mysql_query($del1,$LivdbConn);


	$insertDump24= 'LOAD DATA LOCAL INFILE "'.$PMTS54646FilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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


//////////////////////////////////////////////////// End Pending MTS54646/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Mts MTSAC Active//////////////////////////////////////////////////////////////////////////
/*
$MTSACFile="1124/MTSAC_".$fileDate.".txt";
$MTSACFilePath=$activeDir.$MTSACFile;
$file_process_status = '***************Script start for MTSAC Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);
	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSAC' and status='Active'";
	$delquery = mysql_query($del,$LivdbConn);

	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$MTSACFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';

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

//////////////////////////////////////////////////// End Mts MTSAC/////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////Start Pending Mts MTV//////////////////////////////////////////////////////////////////////////

$PMTSACFile="1103/PMTSAC_".$fileDate.".txt";
$PMTSACFilePath=$activeDir.$PMTSACFile;

$file_process_status = '***************Script start for MTSAC Pending******************' .' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
error_log($file_process_status, 3, $processlog);

	$del="delete from misdata.tbl_base_active where date(date)='".$view_date1."' and service='MTSAC' and status='Pending'";
	$delquery = mysql_query($del,$LivdbConn);

	$insertDump10= 'LOAD DATA LOCAL INFILE "'.$PMTSACFilePath.'" INTO TABLE misdata.tbl_base_active FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(date,service,msisdn,sub_date,validity_date,mode,circle,bal_min,status,lang,religion,device,crbt)';
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
*/
echo "done";
//////////////////////////////////////////////////// End Pending Mts MTV/////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////// code End to dump Active base for Docomo Operator///////////////////////////////////////////////////
mysql_close($dbConn);
mysql_close($LivdbConn);
?>
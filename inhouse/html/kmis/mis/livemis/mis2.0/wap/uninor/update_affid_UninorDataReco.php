<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
error_reporting(1);
//update affid in uninorldr & kiji wap billing data for missing affid
$prevdate = date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$prevdatedb = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
#$prevdate='20150202';
#$prevdatedb='2015-02-02';

//Dump Uninor LDR data in table Start here
 $waplogFile='';
 $fileDumpPath='';
 $waplogFile="sAffiddata_".$prevdate.'.txt';
 
$fileDumpPath="/var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/uninor/ldr/".$waplogFile;
if (file_exists($fileDumpPath)) {
$DeleteQuery = "truncate Hungama_WAP_Logging.update_affid_uninor";
$deleteResult12 = mysql_query($DeleteQuery,$dbConn212) or die(mysql_error());	
 $insertDump = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath . '" INTO TABLE Hungama_WAP_Logging.update_affid_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 
(ani,affid,amt,response,date_time,status,service)';
    if(mysql_query($insertDump,$dbConn212))
	{
    $file_process_status = 'Load Data query execute successfully for Data(WAPUninorLDR)'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing(WAPUninorLDR) Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
 echo $file_process_status;		
 sleep(2);
// unlink($fileDumpPath);
 }
 else
 {
 echo "File not found";
exit;
 }
 //Data dump end here

sleep(10);
$selectQuery = "select distinct(msisdn) from master_db.tbl_billing_success nolock 
where service_id=1411 and date(response_time)='".$prevdatedb."'
and event_type='SUB' and (aff_id='0' OR aff_id='') and mode='WAP'";
$selectResult = mysql_query($selectQuery,$dbConn212) or die(mysql_error());

while($row=mysql_fetch_array($selectResult))
 {
    $ani=$row['msisdn'];
	$searchQuery="Select affid from Hungama_WAP_Logging.update_affid_uninor nolock where ani='".$ani."' and (affid !='' and affid !='0') and service='WAPUninorLDR' LIMIT 1";
	$searchResult=mysql_query($searchQuery,$dbConn212) or die(mysql_error());
	$numrow=mysql_num_rows($searchResult);
	if($numrow == 1)
	{
	   while($data=mysql_fetch_array($searchResult))
	  {
		$affid = $data['affid'];
		$updateQuery="Update uninor_ldr.tbl_ldr_subscription set affid='".$affid."' where ANI='".$ani."' and status=1";
		mysql_query($updateQuery,$dbConn212);
	   $updateQuery_160="Update master_db.tbl_billing_success set aff_id='".$affid."' where msisdn='".$ani."' 
	   and service_id=1411 and date(response_time)='".$prevdatedb."' and event_type='SUB' and mode='WAP'";
	    mysql_query($updateQuery_160,$dbConn212);
	}
	  
	}
	
 }
unlink($fileDumpPath);



//Dump Uninor KIJI data in table Start here
 $waplogFile1='';
 $fileDumpPath1='';
 $waplogFile1="sAffiddata_".$prevdate.'.txt';
 
$fileDumpPath1="/var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/uninor/contest/".$waplogFile1;
if (file_exists($fileDumpPath1)) {	
 $insertDump = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath1 . '" INTO TABLE Hungama_WAP_Logging.update_affid_uninor FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 
(ani,affid,amt,response,date_time,status,service)';
    if(mysql_query($insertDump,$dbConn212))
	{
    $file_process_status = 'Load Data query execute successfully for Data(WAPUninorKIJI)'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing(WAPUninorKIJI) Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
 echo $file_process_status;		
 sleep(2);
// unlink($fileDumpPath);
 }
 else
 {
 echo "File not found";
exit;
 }
 //Data dump end here

sleep(10);
$selectQuery = "select distinct(msisdn) from master_db.tbl_billing_success nolock 
where service_id=1423 and plan_id=270 and date(response_time)='".$prevdatedb."'
and event_type='SUB' and (aff_id='0' OR aff_id='') and mode='WAP'";
$selectResult = mysql_query($selectQuery,$dbConn212) or die(mysql_error());

while($row=mysql_fetch_array($selectResult))
 {
    $ani=$row['msisdn'];
	$searchQuery="Select affid from Hungama_WAP_Logging.update_affid_uninor nolock where ani='".$ani."' and (affid !='' and affid !='0') and service='WAPUninorKIJI' LIMIT 1";
	$searchResult=mysql_query($searchQuery,$dbConn212) or die(mysql_error());
	$numrow=mysql_num_rows($searchResult);
	if($numrow == 1)
	{
	   while($data=mysql_fetch_array($searchResult))
	  {
		$affid = $data['affid'];
		$updateQuery="Update uninor_summer_contest.tbl_contest_subscription_wapcontest set affid='".$affid."' where ANI='".$ani."' and status=1";
		mysql_query($updateQuery,$dbConn212);
	   $updateQuery_160="Update master_db.tbl_billing_success set aff_id='".$affid."' where msisdn='".$ani."' and service_id=1423 and plan_id=270 and date(response_time)='".$prevdatedb."' and event_type='SUB' and mode='WAP'";
	    mysql_query($updateQuery_160,$dbConn212);
	}
	  
	}
	
 }
unlink($fileDumpPath1);
mysql_close($dbConn212);

echo "Done";
?>

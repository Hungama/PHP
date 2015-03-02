<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
error_reporting(1);
//update affid in tatadocomoldr wap billing data for missing affid
$prevdate = date("Ymd", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$prevdatedb = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));

#$prevdate='20150202';
#$prevdatedb='2015-02-02';

//Dump tata LDR data in table Start here
 $waplogFile='';
 $fileDumpPath='';
 $waplogFile="sAffiddata_".$prevdate.'.txt';
 
$fileDumpPath="/var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/tata/ldr/".$waplogFile;
if (file_exists($fileDumpPath)) {
$DeleteQuery = "delete from Hungama_WAP_Logging.update_affid_tata where date(date_time)='" . $prevdatedb . "' and service='WAPTataDoCoMoLDR'";
$deleteResult12 = mysql_query($DeleteQuery,$dbConn212) or die(mysql_error());	
 $insertDump = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath . '" INTO TABLE Hungama_WAP_Logging.update_affid_tata FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 
(ani,affid,amt,response,date_time,status,service)';
    if(mysql_query($insertDump,$dbConn212))
	{
    $file_process_status = 'Load Data query execute successfully for Data(WAPTataDoCoMoLDR)'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing(WAPTataDoCoMoLDR) Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
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
where service_id=1050 and date(response_time)='".$prevdatedb."'
and event_type='SUB' and (aff_id='0' OR aff_id='') and mode='WAP'";
$selectResult = mysql_query($selectQuery,$dbConn212) or die(mysql_error());

while($row=mysql_fetch_array($selectResult))
 {
    $ani=$row['msisdn'];
	$searchQuery="Select affid from Hungama_WAP_Logging.update_affid_tata nolock where ani='".$ani."' and (affid !='' and affid !='0') and service='WAPTataDoCoMoLDR' LIMIT 1";
	$searchResult=mysql_query($searchQuery,$dbConn212) or die(mysql_error());
	$numrow=mysql_num_rows($searchResult);
	if($numrow == 1)
	{
	   while($data=mysql_fetch_array($searchResult))
	  {
		$affid = $data['affid'];
		$updateQuery="Update tata_ldr.tbl_ldr_subscription set affid='".$affid."' where ANI='".$ani."' and status=1";
		mysql_query($updateQuery,$dbConn212);
	   $updateQuery_160="Update master_db.tbl_billing_success set aff_id='".$affid."' where msisdn='".$ani."' 
	   and service_id=1050 and date(response_time)='".$prevdatedb."' and event_type='SUB' and mode='WAP'";
	    mysql_query($updateQuery_160,$dbConn212);
	}
	  
	}
	
 }
unlink($fileDumpPath);
mysql_close($dbConn212);

echo "Done";
?>

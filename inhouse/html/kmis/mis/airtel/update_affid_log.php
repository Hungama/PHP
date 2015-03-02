<?php
include("/var/www/html/airtel/dbInhousewithAirtel.php");
error_reporting(1);
$prevdate = date("Ymd", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$prevdatedb = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
#$prevdate='20150202';
#$prevdatedb='2015-02-02';

//Dump Airtel LDR data in table Start here
 $baseurl_browsing='';
 $waplogFile='';
 $urltohit_browsing='';
 $fileDumpPath='';
$baseurl_browsing='http://117.239.178.108/hungamawap/airtel/CCG/logs/';
$waplogFile="sAffiddata_".$prevdate.'.txt';
$urltohit_browsing=$baseurl_browsing.$waplogFile;

$fileDumpPath="/var/www/html/kmis/mis/livemis/mis2.0/airtel/livedump/".$waplogFile;

unlink($fileDumpPath);

if ( copy($urltohit_browsing, $fileDumpPath) ) {
    echo "Copy success!";
}else{
    echo "Copy failed.";
}
sleep(4);

if (file_exists($fileDumpPath)) {
$DeleteQuery = "truncate airtel_rasoi.update_affid";
$deleteResult12 = mysql_query($DeleteQuery,$dbConn212) or die(mysql_error());	
 $insertDump = 'LOAD DATA LOCAL INFILE "' . $fileDumpPath . '" INTO TABLE airtel_rasoi.update_affid FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 
(ani,affid,amt,response,date_time,status)';
    if(mysql_query($insertDump,$dbConn212))
	{
    $file_process_status = 'Load Data query execute successfully for Data(WAPAirtelLDR)'.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
	else
	{
	$error= mysql_error();
	$file_process_status = 'Load Dara Error Browsing(WAPAirtelLDR) Data-'.$error.' #datetime#'.date("Y-m-d H:i:s"). "\r\n";
	}
 echo $file_process_status;		
 sleep(2);
 unlink($fileDumpPath);
 }
 else
 {
 echo "File not found";
 }
 //Data dump end here

sleep(10);
$selectQuery = "select distinct msisdn from master_db.tbl_billing_success nolock 
where service_id=1527 and date(response_time)='".$prevdatedb."'
and event_type='SUB' and (affid='0' OR affid='') and mode='WAP'";
$selectResult = mysql_query($selectQuery,$dbConnAirtel) or die(mysql_error());

while($row=mysql_fetch_array($selectResult))
 {
    $ani=$row['msisdn'];
	$searchQuery="Select affid from airtel_rasoi.update_affid nolock where ani='".$ani."' and (affid !='' and affid !='0') LIMIT 1";
	$searchResult=mysql_query($searchQuery,$dbConn212) or die(mysql_error());
	$numrow=mysql_num_rows($searchResult);
	if($numrow == 1)
	{
	   while($data=mysql_fetch_array($searchResult))
	  {
		$affid = $data['affid'];
		$updateQuery="Update airtel_rasoi.tbl_rasoi_subscriptionWAP set affid='".$affid."' where ANI='".$ani."' and status=1";
		//mysql_query($updateQuery,$dbConn212);
	   $updateQuery_160="Update master_db.tbl_billing_success set affid='".$affid."' where msisdn='".$ani."' 
	   and service_id=1527 and date(response_time)='".$prevdatedb."' and event_type='SUB' and mode='WAP'";
	    mysql_query($updateQuery_160,$dbConnAirtel);
	}
	  
	}
	
 }
mysql_close($dbConn212);
mysql_close($dbConnAirtel);
echo "Done";
?>

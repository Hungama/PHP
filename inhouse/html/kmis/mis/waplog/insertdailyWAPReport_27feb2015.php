<?php
error_reporting(0);
#include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
include ("/var/www/html/kmis/services/hungamacare/config/dbcon/dbConnect212.php");//$dbConn212
include ("/var/www/html/kmis/services/hungamacare/config/dbcon/db_airtel.php"); //$dbConnAirtel
$PrevDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
//$PrevDate='2014-11-01';
if($PrevDate) {
	$tempDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-2,date("Y")));
	if($PrevDate < $tempDate) {
		$successTable = "master_db.tbl_billing_success_backup";
	} else {
		$successTable = "master_db.tbl_billing_success";
	}
}

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$deletedata="delete from Hungama_WAP_Logging.tbl_wapActivationDailyReport where date='".$PrevDate."' and service='WAPAirtelLDR'";
$result3=mysql_query($deletedata, $dbConn212);

//$queryTotalhits="select count(1) as TOTAL_HITS,count(distinct msisdn) as UNIQUE_HITS from mis_db.tbl_browsing_wap nolock where date(datetime)='".$PrevDate."' and service='WAPAirtelLDR' and datatype='browsing'";
//$result=mysql_query($queryTotalhits, $dbConn212);
//list($TOTAL_HITS,$UNIQUE_HITS) = mysql_fetch_array($result);

$queryTotalhits="select count(1) as TOTAL_HITS,count(distinct msisdn) as UNIQUE_HITS  from mis_db.tbl_browsing_wap_airtel nolock
where date(datetime)='".$PrevDate."' and service='WAPAirtelLDR' and response!='BROWSINGAPI'";
$result=mysql_query($queryTotalhits, $dbConn212);
list($TOTAL_HITS,$UNIQUE_HITS) = mysql_fetch_array($result);


//MISSING_MSISDN
$result='';
//$queryTotalMissingMsisdn="select count(1) as MISSING_MSISDN from mis_db.tbl_browsing_wap nolock where date(datetime)='".$PrevDate."' and service='WAPAirtelLDR' and datatype='browsing' and (msisdn=0 or msisdn='')";
$queryTotalMissingMsisdn="select count(1) as MISSING_MSISDN 
from mis_db.tbl_browsing_wap_airtel nolock where date(datetime)='".$PrevDate."' 
and service='WAPAirtelLDR' and response!='BROWSINGAPI' and (msisdn=0 or msisdn='' or msisdn='UNKNOWN')";
$result=mysql_query($queryTotalMissingMsisdn, $dbConn212);
list($MISSING_MSISDN) = mysql_fetch_array($result);

//SENT_TO_CG && UNIQUE_SENT_TO_CG
$result='';
$queryTotalSENT_TO_CG="select count(1) as SENT_TO_CG,count(distinct msisdn) as UNIQUE_SENT_TO_CG 
from mis_db.tbl_browsing_wap_airtel nolock where date(datetime)='".$PrevDate."' 
and service='WAPAirtelLDR' and response!='BROWSINGAPI' and datatype='CGOK' and (msisdn!=0  or msisdn!='UNKNOWN')";
$result=mysql_query($queryTotalSENT_TO_CG, $dbConn212);
list($SENT_TO_CG,$UNIQUE_SENT_TO_CG) = mysql_fetch_array($result);

//CCG RESPONSE && CG_RETURN
$result='';
$CG_RETURN=0;
//$queryTotalCCG="select count(1) as Total,response from mis_db.tbl_browsing_wap nolock where date(datetime)='".$PrevDate."' and service='WAPAirtelLDR' and datatype='ccgresponse' group by response";
$queryTotalCCG="select count(1) as Total,response from mis_db.tbl_browsing_wap_airtel nolock where date(datetime)='".$PrevDate."' 
and service='WAPAirtelLDR' and response!='BROWSINGAPI' and datatype='CGCOMPLETE' group by response";
$resultCCG=mysql_query($queryTotalCCG, $dbConn212);
while(list($total,$response) = mysql_fetch_array($resultCCG))
{

		$CG_RETURN=$CG_RETURN+$total;
		
		if($response=='Low Balance')
		{
		$ACTIVATION_LOW_BALANCE=$total;		
		}
		elseif($response=='MSISDN from network is missing')
		{
		$MISSING_MSISDN2=$total;
		}
		elseif($response=='Non Airtel User')
		{
		$OPERATOR_NOT_FOUND=$total;
		}
		elseif($response=='Product already subscribed')
		{
		$ALREADY_SUBSCRIBED=$total;
		}
		elseif($response=='Request Failed')
		{
		$RequestFailed=$total;
		}
		elseif($response=='Success')
		{
		$ACTIVATION_SUCCESS=$total;
		}
}
//Get Total Activation

$result='';
$queryTotalAct="select count(1) as ACTIVATION_SUCCESS from $successTable nolock where date(response_time)='".$PrevDate."' and service_id='1527' and event_type='SUB'";
$result=mysql_query($queryTotalAct, $dbConnAirtel);
list($ACTIVATION_SUCCESS) = mysql_fetch_array($result);

$insertquery="insert into Hungama_WAP_Logging.tbl_wapActivationDailyReport (date,service,TOTAL_HITS,UNIQUE_HITS,MISSING_MSISDN,OPERATOR_NOT_FOUND,ALREADY_SUBSCRIBED,SENT_TO_CG,UNIQUE_SENT_TO_CG,CG_RETURN,ACTIVATION_SUCCESS,ACTIVATION_LOW_BALANCE) values('".$PrevDate."','WAPAirtelLDR','".$TOTAL_HITS."','".$UNIQUE_HITS."','".$MISSING_MSISDN."','".$OPERATOR_NOT_FOUND."','".$ALREADY_SUBSCRIBED."','".$SENT_TO_CG."','".$UNIQUE_SENT_TO_CG."','".$CG_RETURN."','".$ACTIVATION_SUCCESS."','".$ACTIVATION_LOW_BALANCE."')";
mysql_query($insertquery, $dbConn212);
mysql_close($dbConn212);
mysql_close($dbConnAirtel);
echo "Done";
?>
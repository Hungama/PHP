<?php
error_reporting(1);
include ("/var/www/html/kmis/services/hungamacare/config/dbcon/dbConnect212.php");

if(isset($_REQUEST['date'])) { 
	$date= $_REQUEST['date'];
} else {
	$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
}
$logFile="/var/www/html/hungamacare/missedcall/obd_alert/mcdrecharge/logs/rechargeRehitlog_".date('Ymd').".txt";
//$date='2014-11-15';
$getMsisdnId="select id from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(EntryDate)='".$date."' and status=11 and trxid!='' order by id ASC";
//$getMsisdnId="select id from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(EntryDate)='".$date."' and id=111007";
$result_id=mysql_query($getMsisdnId,$dbConn212);
$ReachargeList=array();
while(list($id1)=mysql_fetch_array($result_id))
{
$ReachargeList[]=$id1;
$aniPicked="update Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE set status=5 where id=".$id1;
if(mysql_query($aniPicked,$dbConn212))
	{
	}
	else
	{
	$error= mysql_error();
	}
}
$totalcount=count($ReachargeList);

if($totalcount>=1)
{
$allIds = implode(",", $ReachargeList);		

$get_allwinner = "select id,ANI,date(EntryDate) as EntryDate,trxid,retry from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where id in($allIds)";
$data = mysql_query($get_allwinner, $dbConn212);
$numrows = mysql_num_rows($data);
if ($numrows==0) 
{ 
echo "NO Data to process";
}
else
{
while ($result_data = mysql_fetch_array($data))
{
	$ani=$result_data['ANI'];
	$EntryDate=$result_data['EntryDate'];
	$id=$result_data['id'];
	$trxid=$result_data['trxid'];
	$retry=$result_data['retry'];
	//echo $trxid."<br>";
$getStatus=mysql_query("select transactionId,response,response_time,request_time from master_db.tbl_recharged nolock where status=1 and TRIM(LEADING '0' FROM transactionId)='".$trxid."'",$dbConn212);
	$isRecharge=mysql_num_rows($getStatus);
	if($isRecharge>=1)
	{
	$rechageStatus = mysql_fetch_array($getStatus);
	$TID=$rechageStatus['transactionId'];
	$response_time=$rechageStatus['response_time'];
	$response=$rechageStatus['response'];	
	
	$responseOrg=explode('#',$rechageStatus['response']);
	//print_r($responseOrg);
	if($responseOrg[0]=='FAILURE' && $retry==0)
	{
	//rehit for recharge
	//$isrtry=1;
	$Update_status = "update Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE set retry=1,status=0 where id='".$id."'";
	$result2 = mysql_query($Update_status,$dbConn212);	
	//call API for recharge	//	
	 $logData=$id."#".$Update_status."#Rehit#".date("Y-m-d H:i:s")."\n";			  
	 error_log($logData,3,$logFile);
	}	
	else
	{
	$Update_status = "update Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE set status=2,Response='".$response."',RechargeDate='".$response_time."' where id='".$id."'";
	$result2 = mysql_query($Update_status,$dbConn212);
	}
	
	}
	else
	{
	$Update_status = "update Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE set status=11 where id='".$id."'";
	$result2 = mysql_query($Update_status,$dbConn212);
	}

}
echo "Recharge Status Update done";	
}
}
else
{
echo "No Records Found";
}
mysql_close($dbConn212);
?>
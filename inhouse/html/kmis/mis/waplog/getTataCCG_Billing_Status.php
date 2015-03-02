<?php
error_reporting(1);
include ("db_224.php");
//$prevdate=$_REQUEST['date'];
$prevdate = date("Ymd", time() - 60 * 60 * 24);
$reqsdate = date("Y-m-d", time() - 60 * 60 * 24);

$serviceQuery=mysql_query("SELECT service,msisdn,ccgid,trnxid FROM Hungama_WAP_Logging.tbl_wap_logs nolock WHERE date(date)='".$prevdate."' and status=0",$con);
while(list($service,$msisdn, $ccgid, $trnxid) = mysql_fetch_array($serviceQuery))
{
//check status in billing
$stCheck="SELECT response_time FROM master_db.tbl_billing_success nolock WHERE ccg_id='".$ccgid."' and msisdn='".$msisdn."'";
$statusCheck=mysql_query($stCheck,$con);
$isfound=mysql_num_rows($statusCheck);
if($isfound>=1)
{
list($response_time) = mysql_fetch_array($statusCheck); 
$updateStats="update Hungama_WAP_Logging.tbl_wap_logs set charging_date='".$response_time."',status=1 where ccgid='".$ccgid."' and trnxid='".$trnxid."'";
}
else
{
$updateStats="update Hungama_WAP_Logging.tbl_wap_logs set charging_date='".$response_time."',status=3 where ccgid='".$ccgid."' and trnxid='".$trnxid."'";
}
mysql_query($updateStats,$con);
}
echo "Done";
mysql_close($con);
?>
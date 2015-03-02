<?php  
ini_set('display_error',0);
$ani1=$_REQUEST['ANI'];
$ani=substr($ani1,1);
$dnis=$_REQUEST['realDNIS'];
$logpath="/var/www/html/hungamacare/missedcall/api/logs/log_".date('Ymd').".txt";
$logData_SMS='';

//connect voda
$con = mysql_connect('203.199.126.129', 'team_user','teamuser@voda#123'); //Voda
if (!$con)
 {
  //die('Could not connect voda: ' . mysql_error("could not connect to Local"));
 }
 //connect 224
$con_212 = mysql_connect("192.168.100.224","webcc","webcc"); //RELIANCE
if (!$con_212)
 {
  //die('Could not connect 224: ' . mysql_error("could not connect to Local"));
 }
$db='master_db';
$getdataProcedure='SENDSMS_NEW';
$get_query="select missed_call_text,cpgid,cpgname from Inhouse_IVR.tbl_missedcall_cpginfo where mobileno='".$dnis."' and status=1";
$query = mysql_query($get_query,$con_212);
$num=mysql_num_rows($query);
if($num>=1)
{
$data = mysql_fetch_row($query);
$message=$data[0];
$cpgid=$data[1];
$cpgname=$data[2];

	$qry= "CALL " . $db . "." . $getdataProcedure . "($ani,'".$message."','54646','1')";
	mysql_query("CALL " . $db . "." . $getdataProcedure . "($ani,'".$message."','54646','1')",$con);
	$logData_SMS=$ani."#".$dnis."#SendSMS#".$qry."#".date("Y-m-d H:i:s")."\n";
	//save all missed call in database
	$savemissedcalldata="insert into Inhouse_IVR.tbl_missedcall_smslist(msisdn, cpgid, processed_at, status,sms,realdnis,added_on,cpgname)
	values('$ani', '$cpgid', now(),'1','$message', '$dnis',now(),'$cpgname')";
	mysql_query($savemissedcalldata, $con_212);
}
else
{
	$logData_SMS=$ani."#".$dnis."#No SMS To Send#".date("Y-m-d H:i:s")."\n";
}
mysql_close($con);
mysql_close($con_212);
error_log($logData_SMS,3,$logpath);
exit;
?>
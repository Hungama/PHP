<?php  
ini_set('display_error',0);
$ani1=$_REQUEST['ANI'];
$ani=substr($ani1,1);
$dnis=$_REQUEST['realDNIS'];
$logpath="/var/www/html/hungamacare/missedcall/api/logs/log_".date('Ymd').".txt";
$logData_SMS='';
//connect 224
$con_212 = mysql_connect("192.168.100.224","webcc","webcc"); //RELIANCE
if (!$con_212)
 {
  //die('Could not connect 224: ' . mysql_error("could not connect to Local"));
 }
$db='master_db';
$getdataProcedure='SENDSMS_NEW';
//get circle information
$getCircle = "select master_db.getCircle(".trim($ani).") as circle";
					$circle1=mysql_query($getCircle) or die( mysql_error() );
					list($circle)=mysql_fetch_array($circle1);
					
					if(!$circle)
					{ 
					$circle='UND';
					}
					
					
$get_query="select missed_call_text,cpgid,cpgname from Inhouse_IVR.tbl_missedcall_cpginfo where mobileno='".$dnis."' and status=1";
$query = mysql_query($get_query,$con_212);
$num=mysql_num_rows($query);
if($num>=1)
{
$data = mysql_fetch_row($query);
$message=$data[0];
$cpgid=$data[1];
$cpgname=$data[2];

	//push sms url start here 	
	$sendmsg="http://121.241.247.190:7501/failsafe/HttpLink?aid=428262&pin=HVOU1&signature=HNGAMA&mnumber=$ani&&message=".urlencode($message);
	$response = file_get_contents($sendmsg);
	
	$logData_SMS=$ani."#".$dnis."#".$circle."#".$response."#SMSURL#".$sendmsg."#".date("Y-m-d H:i:s")."\n";
	//save all missed call in database
	$savemissedcalldata="insert into Inhouse_IVR.tbl_missedcall_smslist(msisdn, cpgid, processed_at, status,sms,realdnis,added_on,cpgname,smsresponse,circle)
	values('$ani', '$cpgid', now(),'1','$message', '$dnis',now(),'$cpgname','$response','$circle')";
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
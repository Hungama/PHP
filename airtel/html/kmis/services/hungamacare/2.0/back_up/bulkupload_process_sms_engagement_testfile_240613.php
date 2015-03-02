<?php
session_start();
require_once("incs/db.php");
require_once("language.php");
//$circle_info=array('GUJ'=>'Gujarat','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST');
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
$circle=$_REQUEST['circle'];
$service_info=$_REQUEST['service_info'];
//$message=preg_replace('#[^\w()/.%\-&]#',"",$_REQUEST['message']);

$smsmessage=str_replace("\"", "", trim($_REQUEST['message']));
//$smsmessage=trim($data[1]);
$message=str_replace("’", "'", $smsmessage);

$scheduledate=$_REQUEST['dpd1'];
$upfor=$_REQUEST['upfor'];
$category=$_REQUEST['category'];
$duration=$_REQUEST['duration'];
$daily_msg=$_REQUEST['daily_msg'];
switch($upfor)
{
case 'no_call_activation':
$type=$duration;
break;
case 'entire_active_base':
$type='active_base';
break;
case 'mou':
$type=$duration;
break;
case 'call_hang_up':
$type='call_hang_up';
break;
}


$date=explode('/',$scheduledate);
$schedule_date=trim($date[2]).'-'.trim($date[0]).'-'.trim($date[1]);
//05/15/2013

//echo $upfor."****".$service_info."****".$circle."****".$message."****".$dpd1."****".$category."****".$duration;



/******************************************Insert process start here***********************************************/
if($circle=='ALL')
{
foreach($circle_info as $circle_id=>$circle_val) {
$update_query = "update master_db.tbl_sms_engagement set status=0 where circle='".$circle_id."' and service_id='".$service_info."' and type='".$type."'";
mysql_query($update_query,$dbConn);	
					$insertquery="insert into master_db.tbl_sms_engagement(message,type,status,added_on,circle,scheduledDate,duration,category,service_id,daily_msg) values('".mysql_real_escape_string($message)."', '$type', '1', now(),'$circle_id', '$schedule_date', '$duration', '$category','$service_info',$daily_msg)";
					mysql_query($insertquery, $dbConn);	
				
												}
$msg = "Message has been saved successfully";
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";												
}
else
{
$update_query = "update master_db.tbl_sms_engagement set status=0 where circle='".$circle."' and service_id='".$service_info."' and type='".$type."'";
mysql_query($update_query,$dbConn);
 $insertquery="insert into master_db.tbl_sms_engagement(message,type,status,added_on,circle,scheduledDate,duration,category,service_id,daily_msg) values('".mysql_real_escape_string($message)."', '$type', '1', now(),'$circle', '$schedule_date', '$duration', '$category','$service_info',$daily_msg)";
 

if(mysql_query($insertquery, $dbConn))
{
$msg = "Message has been saved successfully";
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
}
else {
			echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">There seem to be error in saving message.Please try again.</div></div>";
		}
}		
mysql_close($dbConn);
/******************************************Upload process end here*************************************************/
exit;
?>
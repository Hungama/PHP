<?php
error_reporting(1);
$AirtelDbConn = mysql_connect('10.2.73.160', 'team_user','Te@m_us@r987');
$todaydate=date("Y-m-d");
function getTotalCount($todaydate)
 {
 
 $gettotalcountdb_mnd=mysql_query("select count(*) from mis_db.tbl_mnd_calllog where date(call_date)='$todaydate' and dnis IN ('5500196','54646196') and status !=1 and circle='upw'");
$totalcount_mnd=mysql_fetch_array($gettotalcountdb_mnd);

$gettotalcountdb_sarnam=mysql_query("select count(*) from mis_db.tbl_devotional_calllog where date(call_date)='$todaydate' and dnis like '51050%' and status !=1 and circle='upw'");
$totalcount_sarnam=mysql_fetch_array($gettotalcountdb_sarnam);
$message='';
if($totalcount_mnd[0]>=500)
{
$message = 'My Naughty Diary- '.$totalcount_mnd[0]."\n";
}
if($totalcount_sarnam[0]>=500)
{
$message.= 'Sarnam (Devotional)- '.$totalcount_sarnam[0];
}
if(!empty($message))
{
$message.=' on '.date("Y-m-d H:i:s")."\n";
}
return $message;
}

$resultset=getTotalCount($todaydate);

$ani='9654998981';
if(!empty($resultset))
{
$sndMsgQuery = "CALL master_db.SENDSMS('".trim($ani) ."','".$resultset."','601666',0,'51050','bulk')"; 
$sndMsg = mysql_query($sndMsgQuery);	
echo $resultset;
}
else
{
echo "Message not send";
}
//close database connection here
mysql_close($AirtelDbConn);
?>
<!--
master_db.tbl_sms
CALL master_db.SENDSMS('8527000779','testing message','601666',0,'51050','')
************************************************
My Naughty Diary – 54646196 / 5500196  (MND)
select count(*) from mis_db.tbl_mnd_calllog where date(call_date)='2013-1-23' and dnis IN ('5500196','54646196') and status !=1
*************************************************
Sarnam - 51050  (Devotional)
Airtel DEv/Sarnam
mis_db.tbl_devotional_calllog where and dnis like '51050%'
*************************************************
546460 (
Spoken English - 571811
Personality Development - 53222345
-->
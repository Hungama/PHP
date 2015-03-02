<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$PrevDate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
$reportdate=date('j F ,Y ',strtotime($PrevDate));
$curdate = date("Ymd");
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh',
'UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
//$circle_info = array('234' => 'NIGERIA', '254' => 'KENYA', '233' => 'GHANA','27'=>'AF');
//$PrevDate='2014-09-05';
$deletedata="delete from Hungama_Tatasky.tbl_dailymisPromo where date='".$PrevDate."' and service='EnterpriseMcDwOBD'";
$result3=mysql_query($deletedata, $dbConn);
echo 'UniqueSubscribersAttempted'."<br>";
$queryUniqueSubscribersAttempted="select count(ANI),circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_promotion nolock where date(obd_sent_date_time)='".$PrevDate."' and status!=0 group by circle";
$result1=mysql_query($queryUniqueSubscribersAttempted, $dbConn);
while(list($Total,$circle) = mysql_fetch_array($result1))
{
$circle=$circle_info[$circle];
$insertquery="insert into Hungama_Tatasky.tbl_dailymisPromo(Date,Service,Circle,Type,Value,Revenue) values('".$PrevDate."','EnterpriseMcDwOBD','".$circle."','OBD_UU_ATM','".$Total."',NULL)";
mysql_query($insertquery, $dbConn) or die(mysql_error());
}
echo 'UniqueSubscribersConnected'."<br>";
$queryUniqueSubscribersConnected="select count(ANI),circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_promotion_details nolock where date(date_time)='".$PrevDate."' and status=2 group by circle";
$result2=mysql_query($queryUniqueSubscribersConnected, $dbConn);
while(list($Total,$circle) = mysql_fetch_array($result2))
{
$circle=$circle_info[$circle];
$insertquery="insert into Hungama_Tatasky.tbl_dailymisPromo(Date,Service,Circle,Type,Value,Revenue) values('".$PrevDate."','EnterpriseMcDwOBD','".$circle."','OBD_UU','".$Total."',NULL)";
mysql_query($insertquery, $dbConn) or die(mysql_error());

}
echo 'DurationConnected'."<br>";
$queryDurationConnected="select sum(duration) as Totalduration,circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_promotion_details nolock where date(date_time)='".$PrevDate."' and status=2 group by circle";
$result3=mysql_query($queryDurationConnected, $dbConn);
while(list($Total,$circle) = mysql_fetch_array($result3))
{
$circle=$circle_info[$circle];
$insertquery="insert into Hungama_Tatasky.tbl_dailymisPromo(Date,Service,Circle,Type,Value,Revenue) values('".$PrevDate."','EnterpriseMcDwOBD','".$circle."','SEC_TF_PROMO','".$Total."',NULL)";
mysql_query($insertquery, $dbConn) or die(mysql_error());
}
echo 'Pulse60DurationConnected'."<br>";
$queryDurationConnected="select sum(ceiling(duration/60)) as pulse,circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_promotion_details nolock where date(date_time)='".$PrevDate."' and status=2 group by circle";
$result3=mysql_query($queryDurationConnected, $dbConn);
while(list($Total,$circle) = mysql_fetch_array($result3))
{
$circle=$circle_info[$circle];
$insertquery="insert into Hungama_Tatasky.tbl_dailymisPromo(Date,Service,Circle,Type,Value,Revenue) values('".$PrevDate."','EnterpriseMcDwOBD','".$circle."','PULSE_TF_PROMO','".$Total."',NULL)";
mysql_query($insertquery, $dbConn) or die(mysql_error());
}
//$TotalOBDfailure=$TotalUniqueSubscribersAttempted-$TotalUniqueSubscribersConnected;
mysql_close($dbConn);
?>
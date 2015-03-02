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
// MCD Mcdowls_SOngDedicationquery data start here

echo 'Total dedication by Party A (DD_PARTY_A)'."<br>";
$queryUniqueSubscribersAttempted="select count(ANI),circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate nolock where date(date_time)='".$PrevDate."' group by circle";
$result1=mysql_query($queryUniqueSubscribersAttempted, $dbConn);
while(list($Total,$circle) = mysql_fetch_array($result1))
{
$circle=$circle_info[$circle];
$insertquery="insert into Hungama_Tatasky.tbl_dailymisPromo(Date,Service,Circle,Type,Value,Revenue) values('".$PrevDate."','EnterpriseMcDwOBD','".$circle."','DD_PARTY_A','".$Total."',NULL)";
mysql_query($insertquery, $dbConn) or die(mysql_error());
}

echo 'Total unique dedication by Party A (UU_DD_PARTY_A)'."<br>";
$queryUU_DD_PARTY_AAttempted="select count(distinct ANI) from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate nolock where date(date_time)='".$PrevDate."'";
$result1=mysql_query($queryUU_DD_PARTY_AAttempted, $dbConn);
list($TotalUU_DD_PARTY_A) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymisPromo(Date,Service,Circle,Type,Value,Revenue) values('".$PrevDate."','EnterpriseMcDwOBD','Others','UU_DD_PARTY_A','".$TotalUU_DD_PARTY_A."',NULL)";
mysql_query($insertquery, $dbConn);


echo 'Total OBD pushed to party B (OBD_TF_B)'."<br>";
$queryOBD_TF_BAttempted="select count(ANI),circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate nolock where date(date_time)='".$PrevDate."' and status!=0 group by circle";
$result1=mysql_query($queryOBD_TF_BAttempted, $dbConn);
while(list($Total,$circle) = mysql_fetch_array($result1))
{
$circle=$circle_info[$circle];
$insertquery="insert into Hungama_Tatasky.tbl_dailymisPromo(Date,Service,Circle,Type,Value,Revenue) values('".$PrevDate."','EnterpriseMcDwOBD','".$circle."','OBD_TF_B','".$Total."',NULL)";
mysql_query($insertquery, $dbConn) or die(mysql_error());
}

echo 'Total Duration heard by Party B(SEC_TF_B)'."<br>";
$querySEC_TF_BAttempted="select sum(duration) as Totalduration,circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_details_SongDedicate nolock where date(date_time)='".$PrevDate."' and status=2 group by circle";
$result1=mysql_query($querySEC_TF_BAttempted, $dbConn);
while(list($Total,$circle) = mysql_fetch_array($result1))
{
$circle=$circle_info[$circle];
$insertquery="insert into Hungama_Tatasky.tbl_dailymisPromo(Date,Service,Circle,Type,Value,Revenue) values('".$PrevDate."','EnterpriseMcDwOBD','".$circle."','SEC_TF_B','".$Total."',NULL)";
mysql_query($insertquery, $dbConn) or die(mysql_error());
}


echo 'Total users eligible for Recharge (RECHRG_ELG)'."<br>";
$queryRECHRG_ELG="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$PrevDate."'";
$result1=mysql_query($queryRECHRG_ELG, $dbConn);
list($TotalRECHRG_ELG) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymisPromo(Date,Service,Circle,Type,Value,Revenue) values('".$PrevDate."','EnterpriseMcDwOBD','Others','RECHRG_ELG','".$TotalRECHRG_ELG."',NULL)";
mysql_query($insertquery, $dbConn);


echo 'Total successful recharge done (RECHRG_SUCCESS)'."<br>";
$queryRECHRG_SUCCESS="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$PrevDate."' and Response like '%SUCCESS%' and status!=0";
$result1=mysql_query($queryRECHRG_SUCCESS, $dbConn);
list($TotalRECHRG_SUCCESS) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymisPromo(Date,Service,Circle,Type,Value,Revenue) values('".$PrevDate."','EnterpriseMcDwOBD','Others','RECHRG_SUCCESS','".$TotalRECHRG_SUCCESS."',NULL)";
mysql_query($insertquery, $dbConn);

echo 'Total Recharge failed (RECHRG_FAIL)'."<br>";
$queryRECHRG_FAIL="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$PrevDate."' and Response like '%FAIL%' and status!=0";
$result1=mysql_query($queryRECHRG_FAIL, $dbConn);
list($TotalRECHRG_FAIL) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymisPromo(Date,Service,Circle,Type,Value,Revenue) values('".$PrevDate."','EnterpriseMcDwOBD','Others','RECHRG_FAIL','".$TotalRECHRG_FAIL."',NULL)";
mysql_query($insertquery, $dbConn);
// MCD Mcdowls_SOngDedicationquery data end here
mysql_close($dbConn);
?>
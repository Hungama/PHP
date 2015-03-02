<?php
error_reporting(1);
require_once("/var/www/html/hungamacare/db.php");
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka','HAR'=>'Haryana', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
$service='EnterpriseMcDwOBD';
$dbNameMCD='Hungama_ENT_MCDOWELL';
if(isset($_REQUEST['date'])) { 
	$view_date= $_REQUEST['date'];
		} else {
	$view_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
$db1='Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate_backup';
$db2='Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate_backup_03Feb2015';
$db3='Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_details_SongDedicate_Bkp';
$db4='Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate_Bkp';
$db5='Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate';





$del="delete from Hungama_Tatasky.tbl_dailymis where Date='".$view_date."' and service='".$service."' 
and type in('DD_PARTY_A','UU_DD_PARTY_B','UU_DD_PARTY_A','OBD_TF_B')";
$delquery = mysql_query($del,$con);

echo 'Total dedication by Party A (DD_PARTY_A)'."<br>";
$queryUniqueSubscribersAttempted="select count(ANI) as total,circle from ".$db5." nolock where date(date_time)='".$view_date."' group by circle";
$result=mysql_query($queryUniqueSubscribersAttempted, $con);
while($result1=mysql_fetch_array($result))
{
$Total=$result1['total'];
$circle=$circle_info[strtoupper($result1['circle'])];
if($circle=='')
$circle='Others';

$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','".$circle."','DD_PARTY_A','".$Total."',NULL)";
mysql_query($insertquery, $con);
}

echo 'Total unique dedication by Party A (UU_DD_PARTY_A)'."<br>";
$queryUU_DD_PARTY_AAttempted="select count(distinct ANI)as total,circle  from ".$db5." nolock where date(date_time)='".$view_date."' group by circle";
$result=mysql_query($queryUU_DD_PARTY_AAttempted, $con);
while($result1=mysql_fetch_array($result))
{
$TotalUU_DD_PARTY_A=$result1['total'];
$circle=$circle_info[strtoupper($result1['circle'])];
if($circle=='')
$circle='Others';
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','".$circle."','UU_DD_PARTY_A','".$TotalUU_DD_PARTY_A."',NULL)";
mysql_query($insertquery, $con);
}

echo 'Total unique Dedications(unique numbers of party B):  (UU_DD_PARTY_B)'."<br>";
$queryUU_DD_PARTY_BAttempted="select count(distinct BPARTYANI)as total,circle from ".$db5." nolock where date(date_time)='".$view_date."' group by circle ";
$result=mysql_query($queryUU_DD_PARTY_BAttempted, $con);
while($result1=mysql_fetch_array($result))
{
$TotalUU_DD_PARTY_B=$result1['total'];
$circle=$circle_info[strtoupper($result1['circle'])];
if($circle=='')
$circle='Others';
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','".$circle."','UU_DD_PARTY_B','".$TotalUU_DD_PARTY_B."',NULL)";
mysql_query($insertquery, $con);
}


echo 'Total OBD pushed to party B (OBD_TF_B)'."<br>";
$queryOBD_TF_BAttempted="select count(ANI) as total ,circle from ".$db5." nolock where date(date_time)='".$view_date."' and status!=0 group by circle";
$result1=mysql_query($queryOBD_TF_BAttempted, $con);
while(list($Total,$circle) = mysql_fetch_array($result1))
{
if($circle=='')
$circle='Others';
$circle=$circle_info[strtoupper($circle)];
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','".$circle."','OBD_TF_B','".$Total."',NULL)";
mysql_query($insertquery, $con);
}

mysql_close($con);
?>
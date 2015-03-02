<?php
error_reporting(1);
require_once("/var/www/html/hungamacare/db.php");
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
$service='EnterpriseMcDwOBD';
$dbNameMCD='Hungama_ENT_MCDOWELL';
if(isset($_REQUEST['date'])) { 
	$view_date= $_REQUEST['date'];
		} else {
	$view_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}


$del="delete from Hungama_Tatasky.tbl_dailymis where Date='".$view_date."' and service='".$service."' 
and type in('RECHRG_ELG','RECHRG_ELG_B','RECHRG_SUCCESS_A','RECHRG_FAIL_A','RECHRG_SUCCESS_B','RECHRG_FAIL_B')";
$delquery = mysql_query($del,$con);


$TotalRECHRG_ELG=0;
$queryRECHRG_ELGB=0;
$TotalRECHRG_SUCCESS=0;
$TotalRECHRG_FAIL=0;
echo 'Total users eligible for Recharge (RECHRG_ELG)'."<br>";
$queryRECHRG_ELG=mysql_query("select count(ANI) as total,circle from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock 
where date(entrydate)='".$view_date."' and Party='A' group by circle",$con);
while($result1=mysql_fetch_array($queryRECHRG_ELG))
{
$TotalRECHRG_ELG=$result1['total'];
$circle=$circle_info[$result1['circle']];
if($circle=='')
$circle='Others';

$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) 
values('".$view_date."','EnterpriseMcDwOBD','".$circle."','RECHRG_ELG','".$TotalRECHRG_ELG."',NULL)";
mysql_query($insertquery, $con);
}

echo 'Total users eligible for Recharge (RECHRG_ELG_B)'."<br>";

$queryRECHRG_ELGB=mysql_query("select count(ANI) as total,circle from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock 
where date(entrydate)='".$view_date."' and Party='B' group by circle",$con);
while($result1=mysql_fetch_array($queryRECHRG_ELGB))
{

$TotalRECHRG_ELGB=$result1['total'];
$circle=$circle_info[$result1['circle']];
if($circle=='')
$circle='Others';

$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) 
values('".$view_date."','EnterpriseMcDwOBD','".$circle."','RECHRG_ELG_B','".$TotalRECHRG_ELGB."',NULL)";
mysql_query($insertquery, $con);
}


echo 'Total successful recharge done (RECHRG_SUCCESS)'."<br>";

$queryRECHRG_SUCCESS=mysql_query("select count(ANI) as total,circle from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock 
where date(entrydate)='".$view_date."' and Response like 'SUCCESS#%' and status!=0 and Party='A' group by circle",$con);
while($result1=mysql_fetch_array($queryRECHRG_ELGB))
{

$TotalRECHRG_SUCCESS=$result1['total'];
$circle=$circle_info[$result1['circle']];
if($circle=='')
$circle='Others';

$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) 
values('".$view_date."','EnterpriseMcDwOBD','".$circle."','RECHRG_SUCCESS_A','".$TotalRECHRG_SUCCESS."',NULL)";
mysql_query($insertquery, $con);
}


echo 'Total Recharge failed (RECHRG_FAIL)'."<br>";

$queryRECHRG_FAIL=mysql_query("select count(ANI) as total,circle from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock 
where date(entrydate)='".$view_date."' and (Response like '%Fail%' or Response like '%Pending%') and status!=0 and Party='A'
 group by circle",$con);
while($result1=mysql_fetch_array($queryRECHRG_FAIL))
{

$TotalRECHRG_FAIL=$result1['total'];
$circle=$circle_info[$result1['circle']];
if($circle=='')
$circle='Others';

$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) 
values('".$view_date."','EnterpriseMcDwOBD','".$circle."','RECHRG_FAIL_A','".$TotalRECHRG_FAIL."',NULL)";
mysql_query($insertquery, $con);
}


//B Party
echo 'Total successful recharge done (RECHRG_SUCCESS_B)'."<br>";
$queryRECHRG_SUCCESS=mysql_query("select count(ANI) as total,circle from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock 
where date(entrydate)='".$view_date."' and Response like 'SUCCESS#%' and status!=0 and Party='B' group by circle",$con);
while($result1=mysql_fetch_array($queryRECHRG_SUCCESS))
{

$TotalRECHRG_SUCCESS=$result1['total'];
$circle=$circle_info[$result1['circle']];
if($circle=='')
$circle='Others';

$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) 
values('".$view_date."','EnterpriseMcDwOBD','".$circle."','RECHRG_SUCCESS_B','".$TotalRECHRG_SUCCESS."',NULL)";
mysql_query($insertquery, $con);
}

echo 'Total Recharge failed (RECHRG_FAIL_B)'."<br>";

$queryRECHRG_FAIL=mysql_query("select count(ANI) as total,circle from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock 
where date(entrydate)='".$view_date."' and (Response like '%Fail%' or Response like '%Pending%') and status!=0 and Party='B'
 group by circle",$con);
while($result1=mysql_fetch_array($queryRECHRG_FAIL))
{
$TotalRECHRG_FAIL=$result1['total'];
$circle=$circle_info[$result1['circle']];
if($circle=='')
$circle='Others';

$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) 
values('".$view_date."','EnterpriseMcDwOBD','".$circle."','RECHRG_FAIL_B','".$TotalRECHRG_FAIL."',NULL)";
mysql_query($insertquery, $con);
}

mysql_close($con);
?>
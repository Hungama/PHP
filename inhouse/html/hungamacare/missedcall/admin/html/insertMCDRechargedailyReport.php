<?php
error_reporting(0);
require_once("../../../db.php");
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
//database used for this app(MCD)
$service='EnterpriseMcDwOBD';
$dbNameMCD='Hungama_ENT_MCDOWELL';
if(isset($_REQUEST['date'])) { 
	$view_date= $_REQUEST['date'];
} else {
	$view_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
//echo $view_date= '2014-12-17';

$del="delete from Hungama_Tatasky.tbl_dailymis where Date='".$view_date."' and service='".$service."' 
and type in ('DD_PARTY_A','UU_DD_PARTY_A','UU_DD_PARTY_B','OBD_TF_B','SEC_TF_B','RECHRG_ELG','RECHRG_ELG_B','RECHRG_SUCCESS_A','RECHRG_FAIL_A','RECHRG_SUCCESS_B','RECHRG_FAIL_B')";
$delquery = mysql_query($del,$con);


// MCD Mcdowls_SOngDedicationquery data start here
echo 'Total dedication by Party A (DD_PARTY_A)'."<br>";
$queryUniqueSubscribersAttempted="select count(ANI),circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate nolock where date(date_time)='".$view_date."' group by circle";
$result1=mysql_query($queryUniqueSubscribersAttempted, $con);
while(list($Total,$circle) = mysql_fetch_array($result1))
{
$circle=$circle_info[strtoupper($circle)];
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','".$circle."','DD_PARTY_A','".$Total."',NULL)";
mysql_query($insertquery, $con);
}

echo 'Total unique dedication by Party A (UU_DD_PARTY_A)'."<br>";
$queryUU_DD_PARTY_AAttempted="select count(distinct ANI) from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate nolock where date(date_time)='".$view_date."'";
$result1=mysql_query($queryUU_DD_PARTY_AAttempted, $con);
list($TotalUU_DD_PARTY_A) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','UU_DD_PARTY_A','".$TotalUU_DD_PARTY_A."',NULL)";
mysql_query($insertquery, $con);

echo 'Total unique Dedications(unique numbers of party B):  (UU_DD_PARTY_B)'."<br>";
$queryUU_DD_PARTY_BAttempted="select count(distinct BPARTYANI) from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate nolock where date(date_time)='".$view_date."'";
$result1=mysql_query($queryUU_DD_PARTY_BAttempted, $con);
list($TotalUU_DD_PARTY_B) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','UU_DD_PARTY_B','".$TotalUU_DD_PARTY_B."',NULL)";
mysql_query($insertquery, $con);


echo 'Total OBD pushed to party B (OBD_TF_B)'."<br>";
$queryOBD_TF_BAttempted="select count(ANI),circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate nolock where date(date_time)='".$view_date."' and status!=0 group by circle";
$result1=mysql_query($queryOBD_TF_BAttempted, $con);
while(list($Total,$circle) = mysql_fetch_array($result1))
{
$circle=$circle_info[strtoupper($circle)];
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','".$circle."','OBD_TF_B','".$Total."',NULL)";
mysql_query($insertquery, $con);
}

echo 'Total Duration heard by Party B(SEC_TF_B)'."<br>";
$querySEC_TF_BAttempted="select sum(duration) as Totalduration,circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_details_SongDedicate nolock where date(date_time)='".$view_date."' and status=2 group by circle";
$result1=mysql_query($querySEC_TF_BAttempted, $con);
while(list($Total,$circle) = mysql_fetch_array($result1))
{
$circle=$circle_info[strtoupper($circle)];
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','".$circle."','SEC_TF_B','".$Total."',NULL)";
mysql_query($insertquery, $con);
}

echo 'Total users eligible for Recharge (RECHRG_ELG)'."<br>";
$queryRECHRG_ELG="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$view_date."' and Party='A'";
$result1=mysql_query($queryRECHRG_ELG, $con);
list($TotalRECHRG_ELG) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','RECHRG_ELG','".$TotalRECHRG_ELG."',NULL)";
mysql_query($insertquery, $con);

echo 'Total users eligible for Recharge (RECHRG_ELG_B)'."<br>";
$queryRECHRG_ELGB="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$view_date."' and Party='B'";
$result1=mysql_query($queryRECHRG_ELGB, $con);
list($TotalRECHRG_ELGB) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','RECHRG_ELG_B','".$TotalRECHRG_ELGB."',NULL)";
mysql_query($insertquery, $con);

echo 'Total successful recharge done (RECHRG_SUCCESS)'."<br>";
$queryRECHRG_SUCCESS="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$view_date."' and Response like 'SUCCESS#%' and status!=0 and Party='A'";
$result1=mysql_query($queryRECHRG_SUCCESS, $con);
list($TotalRECHRG_SUCCESS) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','RECHRG_SUCCESS_A','".$TotalRECHRG_SUCCESS."',NULL)";
mysql_query($insertquery, $con);

echo 'Total Recharge failed (RECHRG_FAIL)'."<br>";
$queryRECHRG_FAIL="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$view_date."' 
and (Response like '%Fail%' or Response like '%Pending%') and status!=0 and Party='A'";
$result1=mysql_query($queryRECHRG_FAIL, $con);
list($TotalRECHRG_FAIL) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','RECHRG_FAIL_A','".$TotalRECHRG_FAIL."',NULL)";
mysql_query($insertquery, $con);

//B Party
echo 'Total successful recharge done (RECHRG_SUCCESS_B)'."<br>";
$queryRECHRG_SUCCESS="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$view_date."' and Response like 'SUCCESS#%' and status!=0 and Party='B'";
$result1=mysql_query($queryRECHRG_SUCCESS, $con);
list($TotalRECHRG_SUCCESS) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','RECHRG_SUCCESS_B','".$TotalRECHRG_SUCCESS."',NULL)";
mysql_query($insertquery, $con);

echo 'Total Recharge failed (RECHRG_FAIL_B)'."<br>";
$queryRECHRG_FAIL="select count(ANI) from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where date(entrydate)='".$view_date."' and (Response like '%Fail%' or Response like '%Pending%') and status!=0 and Party='B'";
$result1=mysql_query($queryRECHRG_FAIL, $con);
list($TotalRECHRG_FAIL) = mysql_fetch_array($result1);
$insertquery="insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue) values('".$view_date."','EnterpriseMcDwOBD','Others','RECHRG_FAIL_B','".$TotalRECHRG_FAIL."',NULL)";
mysql_query($insertquery, $con);

// MCD Mcdowls_SOngDedicationquery data end here
echo "Done";
mysql_close($con);
?>

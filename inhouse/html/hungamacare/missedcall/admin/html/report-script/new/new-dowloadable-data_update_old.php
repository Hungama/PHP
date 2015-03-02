<?php
require_once("db.php");
//code for update the record:
$date='2015-01-19';
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','HAR'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
//database used for this app(MCD)
$service='EnterpriseMcDw';
/* // get missed call_ func  T_M_C_B
 $query="select count(ani)as value,circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_liveapp
where date(date_time)<= '$date' group by circle";
$query_missed_call= mysql_query($query, $con);
$numofrows = mysql_num_rows($query_missed_call);
if ($numofrows >= 1) {
while ($summarydata = mysql_fetch_array($query_missed_call)) {
$totalCall = $summarydata['value'];
//$circle = $circle_info[strtoupper ($summarydata['circle'])];
$circle=$summarydata['circle'];
$type = 'T_M_C_B';
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis_downloadable(Date,Service,Circle,Type,Value,Revenue)
values('$date' ,'$service','$circle','$type','$totalCall','')";
$queryIns = mysql_query($insert_data, $con);
}
} */

// get unique missed call func T_Q_S
/* $query="select count(distinct(ani))as value,circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_liveapp
where date(date_time)<= '$date' group by circle";
$query_unique_missed= mysql_query($query, $con);
$numofrows = mysql_num_rows($query_unique_missed);
if ($numofrows >= 1) {
while ($summarydata = mysql_fetch_array($query_unique_missed)) {
$totalCall = $summarydata['value'];
//$circle = $circle_info[strtoupper ($summarydata['circle'])];
$circle = $summarydata['circle'];
$type = 'T_Q_S';
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis_downloadable(Date,Service,Circle,Type,Value,Revenue)
values('$date','$service','$circle','$type','$totalCall','')";
$queryIns = mysql_query($insert_data, $con);
}
} */


// Total missed calls received post yaaricharge //T_M_C
/* 
$query="select count(ani)as value,circle from  Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_liveapp 
where date(date_time)= '2015-01-21'  group by circle";
$query_missed_charge= mysql_query($query, $con);
$numofrows = mysql_num_rows($query_missed_charge);
if ($numofrows >= 1) {
while ($summarydata = mysql_fetch_array($query_missed_charge)) {
$totalCall = $summarydata['value'];
//$circle = $circle_info[strtoupper ($summarydata['circle'])];
$circle = $summarydata['circle'];
$type = 'T_M_C';
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis_downloadable(Date,Service,Circle,Type,Value,Revenue)
values('2015-01-21' ,'$service','$circle','$type','$totalCall','')";
$queryIns = mysql_query($insert_data, $con);
}
} */

//total number of dedication T_N_D

/* $query="select count(ani)as value,circle from  Hungama_ENT_MCDOWELL.tbl_mcdowell_pushobd_SongDedicate
 where date(date_time) between '2014-11-16' and '2015-01-19' group by circle";
$query_no_dedication= mysql_query($query, $con); 
$numofrows = mysql_num_rows($query_no_dedication);
if ($numofrows >= 1) {
while ($summarydata = mysql_fetch_array($query_no_dedication)) {
$totalCall = $summarydata['value'];
//$circle = $circle_info[strtoupper ($summarydata['circle'])];
$circle = $summarydata['circle'];
$type = 'T_N_D';
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis_downloadable(Date,Service,Circle,Type,Value,Revenue)
values('$date' ,'$service','$circle','$type','$totalCall','')";
$queryIns = mysql_query($insert_data, $con);
}
} 

//total number of unique dedication

//query request  T_N_U
//T_N_U
/* $query_unique_dedication="select count(ANI)as value,circle from  Hungama_ENT_MCDOWELL.tbl_mcdowell_unique_SongDedicate where 
date(last_dedicated_date_time)<='2015-01-19' group by circle "; 
$query_unique_result= mysql_query($query_unique_dedication, $con);
$numofrows = mysql_num_rows($query_unique_result);
if ($numofrows >= 1) {
while ($summarydata = mysql_fetch_array($query_unique_result)) {
$totalCall = $summarydata['value'];
//$circle = $circle_info[strtoupper ($summarydata['circle'])];
$circle = $summarydata['circle'];
$type = 'T_N_U';
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis_downloadable(Date,Service,Circle,Type,Value,Revenue)
values('$date' ,'$service','$circle','$type','$totalCall','')";
$queryIns = mysql_query($insert_data, $con);
}
} */










//Number of Successful recharge pushed //T_N_S

$query="select count(ANI)as value,circle from Hungama_ENT_MCDOWELL.tbl_MCW_RECHARGE nolock where
date(entrydate) between '2015-01-20' and '2015-01-21'  group by circle";
$query_successfull= mysql_query($query, $con);
$numofrows = mysql_num_rows($query_successfull);
if ($numofrows >= 1) {
while ($summarydata = mysql_fetch_array($query_successfull)) {
$totalCall = $summarydata['value'];
//$circle = $circle_info[strtoupper ($summarydata['circle'])];
$circle = $summarydata['circle'];
$type = 'T_N_S';
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis_downloadable(Date,Service,Circle,Type,Value,Revenue)
values('2015-01-20' ,'$service','$circle','$type','$totalCall','')";
$queryIns = mysql_query($insert_data, $con);
}
} 

//total obd promotion   ///T_OBD_C

/*  
$query="select count(ANI)as value,circle from Hungama_ENT_MCDOWELL.tbl_mcdowell_success_fail_promotion_details_10oct
 nolock where date(date_time) <='$date'
 and status='2'  group by circle";
$query_obd= mysql_query($query, $con);
$numofrows = mysql_num_rows($query_obd);
if ($numofrows >= 1) {
while ($summarydata = mysql_fetch_array($query_obd)) {
$totalCall = $summarydata['value'];
//$circle = $circle_info[strtoupper ($summarydata['circle'])];
$circle = $summarydata['circle'];
$type = 'T_OBD_C';
$insert_data = "insert into Hungama_Tatasky.tbl_dailymis_downloadable(Date,Service,Circle,Type,Value,Revenue)
values('$date' ,'$service','$circle','$type','$totalCall','')";
$queryIns = mysql_query($insert_data, $con);
}
} 
  */
 




echo "Done";

mysql_close($con);














?>
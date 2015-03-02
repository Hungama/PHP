<?php
error_reporting(0);
include ("/var/www/html/kmis/services/hungamacare/config/dbcon/dbConnect212.php");
$date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$allcircle=array();
$deletequery = "delete from uninor_hungama.tbl_GUJ_recharge where date(date_time)='".$date."' ";
$result_delete = mysql_query($deletequery, $dbConn212) or die(mysql_error());

//For 54646
$getwinner_query="select distinct ANI from uninor_hungama.tbl_GUJ nolock where date(date_time)='".$date."' and DNIS='54646'";
$result_winner = mysql_query($getwinner_query, $dbConn212) or die(mysql_error());
$result_row_winner = mysql_num_rows($result_winner);	
if ($result_row_winner > 0) {
while ($winner_details = mysql_fetch_array($result_winner))
{
//insert in recharge table to process
$insert_query = "insert into uninor_hungama.tbl_GUJ_recharge (ANI,date_time,recharge_flag,circle,SC) 
values ('". $winner_details['ANI'] ."','".$date."','0','GUJ','54646')";
mysql_query($insert_query, $dbConn212);
}
}
else
{
echo 'No records found For 54646';
}


//For 546466
$getwinner_query="select distinct ANI from uninor_hungama.tbl_GUJ nolock where date(date_time)='".$date."'  and DNIS='546466'";
$result_winner = mysql_query($getwinner_query, $dbConn212) or die(mysql_error());
$result_row_winner = mysql_num_rows($result_winner);	
if ($result_row_winner > 0) {
while ($winner_details = mysql_fetch_array($result_winner))
{
//insert in recharge table to process
$insert_query = "insert into uninor_hungama.tbl_GUJ_recharge (ANI,date_time,recharge_flag,circle,SC) 
values ('". $winner_details['ANI'] ."','".$date."','0','GUJ','546466')";
mysql_query($insert_query, $dbConn212);
}
}
else
{
echo 'No records found for 546466';
}
echo 'done';
mysql_close($dbConn212);
?>
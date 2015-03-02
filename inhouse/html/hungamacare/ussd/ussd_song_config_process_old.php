<?php
ob_start();
session_start();
ini_set('display_errors','0');
include("db.php");

$song1_id=$_REQUEST['form_songname_1_id'];
$song2_id=$_REQUEST['form_songname_2_id'];
$song3_id=$_REQUEST['form_songname_3_id'];

$song1=$_REQUEST['form_songname_1'];
$song2=$_REQUEST['form_songname_2'];
$song3=$_REQUEST['form_songname_3'];

$song_ttid1=$_REQUEST['form_truetoneid_1'];
$song_ttid2=$_REQUEST['form_truetoneid_2'];
$song_ttid3=$_REQUEST['form_truetoneid_3'];

//select sid,menu_id,songname,contentid,contenttype,status from USSD.tbl_songname
//
//first update all record to status 0
$update_song_status = "update USSD.tbl_songname set status=0 where 1";
mysql_query($update_song_status,$con);
//insert all three 3 new song
$sql_song1="INSERT INTO USSD.tbl_songname (menu_id,songname,contentid,contenttype,status)
VALUES ('".$song1_id."','".$song1."','".$song_ttid1."','TT','1')";

$sql_song2="INSERT INTO USSD.tbl_songname (menu_id,songname,contentid,contenttype,status)
VALUES ('".$song2_id."','".$song2."','".$song_ttid2."','TT','1')";

$sql_song3="INSERT INTO USSD.tbl_songname (menu_id,songname,contentid,contenttype,status)
VALUES ('".$song3_id."','".$song3."','".$song_ttid3."','TT','1')";

if(mysql_query($sql_song1,$con) && mysql_query($sql_song2,$con) && mysql_query($sql_song3,$con))
{
$msg='Data Saved Successfully.';
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
}
else
{
$msg='Data Uploaded Error.Please try again.';
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-danger\">$msg</div></div>";
}

/*
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$update_song_status</div></div>";

echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$sql_song1</div></div>";

echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$sql_song2</div></div>";

echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$sql_song3</div></div>";
*/
exit;
?>
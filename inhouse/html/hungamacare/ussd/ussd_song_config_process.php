<?php
ob_start();
session_start();
ini_set('display_errors','0');
include("db.php");
$cat_name=$_REQUEST['form_song_categoryname'];
$menu_id=$_REQUEST['menu_id'];

$song1_id=$_REQUEST['form_songname_1_id'];
$song2_id=$_REQUEST['form_songname_2_id'];
$song3_id=$_REQUEST['form_songname_3_id'];

$song1=$_REQUEST['form_songname_1'];
$song2=$_REQUEST['form_songname_2'];
$song3=$_REQUEST['form_songname_3'];

$song_ttid1=$_REQUEST['form_truetoneid_1'];
$song_ttid2=$_REQUEST['form_truetoneid_2'];
$song_ttid3=$_REQUEST['form_truetoneid_3'];

/*echo $cat_name."**".$menu_id."**".$song1_id."**".$song1."**".$song_ttid1."<br>";
echo $cat_name."**".$menu_id."**".$song2_id."**".$song2."**".$song_ttid2."<br>";
echo $cat_name."**".$menu_id."**".$song3_id."**".$song3."**".$song_ttid3;
*/
//select sid,menu_id,songname,contentid,contenttype,status from USSD.tbl_songname
//
//first update all record to status 0
$update_song_status = "update USSD.tbl_songname set status=0 where menu_id='".$menu_id."'";
mysql_query($update_song_status,$con);
//insert all three 3 new song
$sql_song1="INSERT INTO USSD.tbl_songname (menu_id,song_category,song_index,songname,contentid,contenttype,status)
VALUES ('".$menu_id."','".$cat_name."','".$song1_id."','".$song1."','".$song_ttid1."','TT','1')";

$sql_song2="INSERT INTO USSD.tbl_songname (menu_id,song_category,song_index,songname,contentid,contenttype,status)
VALUES ('".$menu_id."','".$cat_name."','".$song2_id."','".$song2."','".$song_ttid2."','TT','1')";

$sql_song3="INSERT INTO USSD.tbl_songname (menu_id,song_category,song_index,songname,contentid,contenttype,status)
VALUES ('".$menu_id."','".$cat_name."','".$song3_id."','".$song3."','".$song_ttid3."','TT','1')";

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
mysql_close($con);
exit;
?>
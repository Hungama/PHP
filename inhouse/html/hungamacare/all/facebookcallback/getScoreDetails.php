<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$msisdn=$_REQUEST['str'];
//$msisdn='9058901891';
//$badge_name=array();
$badge_name='';
$sql_score = mysql_query("select score from uninor_summer_contest.tbl_contest_subscription where ANI='".$msisdn."' and STATUS=1",$dbConn);
$isfound=mysql_num_rows($sql_score);
if($isfound==0)
{
echo "NOK";
}
else
{
$score=mysql_fetch_array($sql_score);
$userscore=$score['score'];
$sql_badge_details = mysql_query("select a.badge_id as badge_id,b.badge_name as badge_name,b.badge_image_name as badge_image_name from uninor_summer_contest.tbl_user_winning_badges as a, uninor_summer_contest.tbl_badge_detail as b where a.msisdn='".$msisdn."' and a.user_status=1 and a.status=1 and a.badge_id=b.id",$dbConn);
$isbadge=mysql_num_rows($sql_badge_details);
if($isbadge)
{
//$i=0;
while($data=mysql_fetch_array($sql_badge_details))
{
//$badge_name[$i]=$data['badge_name'];
$badge_name.=$data['badge_name'];
//$i++;
}
}
echo $userscore."@@".$badge_name;
}
mysql_close($dbConn);
?>
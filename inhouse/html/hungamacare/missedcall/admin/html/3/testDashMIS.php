<?php
include('db.class.php');
include('dashboardData.class.php');
$db = new Database();
$dash = new DashboardData();
$a=$db->connect();
/*
function getData($db)
{
$q = "SELECT * FROM CRUDClass ORDER BY id DESC limit 10";
$r = $db->query($q);
// if we have a result loop over the result
if ($db->num_rows($r) > 0) {
  while ($a = $db->fetch_array_assoc($r)) {
    echo $a['name']."#".$a['email']."<br>";
  }
}
}
*/
$StartDate='2014-08-25';
$EndDate='2014-08-28';
$service='EnterpriseMcDw';
$total_call=$dash->getAllCalls($db,$StartDate,$EndDate,$service);


 
$total_unique_users=$dash->getAllUniqueUsers($db,$StartDate,$EndDate,$service);

$dateDiff=$dash->getDateDiff($db,$StartDate,$EndDate,$service);

$agecount=$dash->getTotalAgeVerified($db,$StartDate,$EndDate,$service);

$SongDwcount=$dash->getTotalSongDownload($db,$StartDate,$EndDate,$service);

$Obdcount=$dash->getTotalOBDSend($db,$StartDate,$EndDate,$service);

$MaxDura=$dash->getMaxListenDuration($db,$StartDate,$EndDate,$service);

$totalOBD_attended_Content=$dash->getTotalMinuteConsumesd($db,$StartDate,$EndDate,$service);

$avgListen=$dash->getAvgListenDuration($total_call,$totalOBD_attended_Content);

$avgmissedperday=$dash->getAvgMissedCallPerDay($total_call,$dateDiff);

$query_missedCallNewChart=$dash->getVisitorsMissedCallsChart($db,$StartDate,$EndDate,$service);
$query_uniqueCallNewChart=$dash->getVisitorsUniqueCallsChart($db,$StartDate,$EndDate,$service);
echo $total_call."#".$total_unique_users."#".$dateDiff."#".$agecount."#".$SongDwcount."#".$Obdcount."#".$MaxDura."#".$totalOBD_attended_Content."#".$avgListen."#".$avgmissedperday;
echo "<br>";


while($data_missedCallNewChart= mysql_fetch_array($query_missedCallNewChart))
{
$day=$data_missedCallNewChart['day'];
$month=$data_missedCallNewChart['month']-1;
$total_missed_callNew=$data_missedCallNewChart['total'];
echo $day."#".$month."#".$total_missed_callNew."<br>";
}
echo "<br>";
while($data_uniqueCallNewChart= mysql_fetch_array($query_uniqueCallNewChart))
{
$day1=$data_uniqueCallNewChart['day'];
$month1=$data_uniqueCallNewChart['month']-1;
$total_unique_callNew=$data_uniqueCallNewChart['total_unique'];
echo $day1."#".$month1."#".$total_unique_callNew."<br>";
}
$a=$db->disconnect();
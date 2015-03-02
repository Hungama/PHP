<?php
require_once("../../../db.php");
/**********************retruning_percetage vs newvisist_percetage start here ***********/

/*
$getDashbord_totalReturning=mysql_query("select  ANI,count(*) as total from Hungama_Tatasky.tbl_tata_pushobd nolock where 
date(date_time) between '".$StartDate."' and '".$EndDate."' and ANI!='' group by ANI HAVING total > 1",$con);
$totalReturning=mysql_num_rows($getDashbord_totalReturning);
*/
$allnewvsuniquevisittoday=mysql_query("select distinct(ANI) as dani,(select count(1) from Hungama_Tatasky.tbl_tata_pushobd where ANI=dani) as total
from Hungama_Tatasky.tbl_tata_pushobd nolock  where date(date_time)=date(now())  and ANI!='' ",$con);

$totalNewUniqueVisitToday=0;
while($dataNewVisitToday= mysql_fetch_array($allnewvsuniquevisittoday))
{
	if($dataNewVisitToday['total']==1)
		{
		$totalNewUniqueVisitToday=$totalNewUniqueVisitToday+1;
		}
}
echo $totalNewUniqueVisitToday;

//$total_percentage1=$totalReturning+$totalNewUniqueVisitToday;
//$newvisist_percetage=percentage($totalNewUniqueVisitToday, $total_percentage1, 2);
//$retruning_percetage=percentage($totalReturning, $total_percentage1, 2);
/**********************retruning_percetage vs newvisist_percetage end here ***********/
mysql_close($con);
?>
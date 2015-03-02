<?php
//include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");

$view_date1= date("d/m/Y",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$airtelArray=array(154036,131745,156057,144720,154369,154369,161435,158443,165986,162644,165148);
$AirtelCount=sizeof($airtelArray);
$url="http://202.87.41.144/sms/report/zonewise_hits/getVisitorLogs.php?op=VODAFONE&zoneid=36003&date=30/01/2013";
$response=file_get_contents($url);
$Array12=explode("],",$response);
echo "<pre>";
print_r($Array12);

for($i=0;$i<$AirtelCount;$i++)
{
	//echo $Url="http://202.87.41.144/sms/report/zonewise_hits/getVisitorLogs.php?op=AIRTEL&zoneid=".$airtelArray[$i]."&date=".$view_date1;
	//echo $url="http://202.87.41.144/sms/report/zonewise_hits/getVisitorLogs.php?op=VODAFONE&zoneid=36003&date=30/01/2013";
	//echo $response=file_get_contents($Url);
}


exit;



?>

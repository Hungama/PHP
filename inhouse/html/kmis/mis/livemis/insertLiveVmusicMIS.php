<?php 

$date=date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));
$view_date=date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
$hour = date("H");
if($hour == 2) 
{
	$date=date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
	$view_date=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}

echo $url= "http://180.214.158.175:8080/HourlyIntegration/VM_".$date.".txt";
exit;

/*** Live Mis DB Connection ***/
$LivdbConn = mysql_connect('119.82.69.218','amit.khurana','hungama');

$response = file_get_contents($url);
$file_date = explode("\n",$response);

echo "<pre>";
print_r($file_date);
exit;

$delQuery = "delete from misdata.livemis where date>date_format('".$view_date."','%Y-%m-%d 00:00:00') and service='VMusic'";
mysql_query($delQuery);

	$selectCount="select count(*) total_count from misdata.livemis where date>'".$view_date." 00:00:00' and service='VMusic'";
	$result=mysql_query($selectCount);
	$yesCount=mysql_fetch_array($result);

	//print_r($yesCount);

	if($yesCount['total_count']==0)
	{
		for($i=0;$i<count($file_date);$i++) { 
			$updateFile = explode(",",$file_date[$i]);

			$query = "insert into misdata.livemis values (DATE_ADD('".$updateFile[0]."',INTERVAL 1 HOUR), '".$updateFile[1]."', '".$updateFile[2]."', '".$updateFile[3]."', '".$updateFile[4]."', '".$updateFile[5]."')";
			mysql_query($query);
		}
	}
	$path = "/var/www/html/kmis/mis/livemis/logs/VMusic_".$view_date1.".txt";
	error_log("data Inserted#".date("Y-m-d H:i:s")."\n",3,$path);
//}
echo "done";

mysql_close($LivdbConn);
?>
<?php 

$date=date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));
$view_date=date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
echo $url= "http://115.248.233.131:8080/HourlyIntegration/RelianceMM_".$date.".txt";

/*** Live Mis DB Connection ***/
$LivdbConn = mysql_connect('119.82.69.218','php','php');

//------------ insert backdate data ------------------
$hour = date("H");
if($hour == 4) {
	$date1=date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
	$view_date1=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
	$url1= "http://115.248.233.131:8080/HourlyIntegration/RelianceMM_".$date1.".txt";
	
	$response_back = file_get_contents($url1);
	$file_date1 = explode("\n",$response_back);
	$path = "/var/www/html/kmis/mis/livemis/logs/reliance_".$view_date1.".txt";
	error_log($response_back,3,$path);

	//$delQuery = "delete from misdata.livemis where date(date)='".$view_date1."' and service='AircelMC'";
	$delQuery = "delete from misdata.livemis where date(date) between '".$view_date1."' and '".$view_date."' and service='RelianceMM'";
	mysql_query($delQuery);

	$selectCount="select count(*) total_count from misdata.livemis where date(date)='".$view_date1." 00:00:00' and service='RelianceMM'";
	$result_back=mysql_query($selectCount);
	$yesCount=mysql_fetch_array($result_back);

	if($yesCount['total_count']==0)
	{
		for($i=0;$i<count($file_date1);$i++) { 
			$updateFile_back = explode(",",$file_date1[$i]);
			
			$query = "insert into misdata.livemis values (DATE_ADD('".$updateFile_back[0]."',INTERVAL 1 HOUR), '".$updateFile_back[1]."', '".$updateFile_back[2]."', '".$updateFile_back[3]."', '".$updateFile_back[4]."', '".$updateFile_back[5]."')";
			mysql_query($query);
		}
	}
	echo "Done";
}
//----------------------------------------------------

$response = file_get_contents($url);
$file_date = explode("\n",$response);
//print_r($file_date);exit;

/*if(!$file_date) {
	$path = "/var/www/html/kmis/mis/livemis/logs/relianceMM_".$view_date1.".txt";
	error_log("File Not available#".date("Y-m-d H:i:s")."\n",3,$path);
} else { */
	//$delQuery = "delete from misdata.livemis where date(date)='".$view_date."' and service='RelianceMM'";
	$delQuery = "delete from misdata.livemis where date>date_format(date(now()),'%Y-%m-%d 00:00:00') and service='RelianceMM'";
	mysql_query($delQuery);

	$selectCount="select count(*) total_count from misdata.livemis where date>'".$view_date." 00:00:00' and service='RelianceMM'";
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
	$path = "/var/www/html/kmis/mis/livemis/logs/relianceMM_".$view_date1.".txt";
	error_log("data Inserted#".date("Y-m-d H:i:s")."\n",3,$path);
//}
echo "done";

mysql_close($LivdbConn);
?>
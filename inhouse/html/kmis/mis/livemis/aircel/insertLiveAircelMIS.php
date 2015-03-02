<?php 
error_reporting(1);
$fileDumpPath='/var/www/html/kmis/mis/livemis/aircel/aircelLog/';
$processlog = "/var/www/html/kmis/mis/livemis/aircel/aircelLog/logs/processlog_".date(Ymd).".txt";
$last=$_REQUEST['last'];
if(date('H')=='2' || $last=='y'){
	$date=date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
	$view_date=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
}
else
{
	$date=date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));
	$view_date=date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
}
echo $view_date."<br>";
echo $url1= "http://10.181.255.141:8080/HourlyIntegration/".$date.".txt";
echo "<br>";
echo $url2= "http://10.181.255.141:8080/HourlyIntegration/MU_".$date.".txt";
			$to = 'satay.tiwari@hungama.com';
			$from = 'voice.mis@hungama.com';
			$headers = "From: " . $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			
/*** Live Mis DB Connection ***/
$LivdbConn = mysql_connect('192.168.100.218','php','php');

function get_data($url) {
	$ch = curl_init();
	$timeout = 60;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

$fileDumpfile="AircelMC_".date('ymd').'.txt';
$fileDumpPath1=$fileDumpPath.$fileDumpfile;

$response=get_data($url1);
$file_date = explode("\n",$response);

////////////////////////////////////////////////AircelMC Begin////////////////////////////////////////////////////
if(isset($file_date) && trim($file_date[0])!='')
{
unlink($fileDumpPath1);
$delQuery = "delete from misdata.livemis where date>date_format('".$view_date."','%Y-%m-%d 00:00:00') and service='AircelMC'";
mysql_query($delQuery,$LivdbConn);

$selectCount="select count(*) total_count from misdata.livemis where date>'".$view_date." 00:00:00' and service='AircelMC'";
$result=mysql_query($selectCount,$LivdbConn);

$yesCount=mysql_fetch_array($result);
if($yesCount['total_count']==0)
{
for($i=0;$i<count($file_date);$i++) 
{ 
	
		$updateFile = explode(",",$file_date[$i]);
		if($updateFile[0]!=''){
		$currentTime = strtotime($updateFile[0]); 
		$timeAfterOneHour = $currentTime+60*60;
		$MMData=date("Y-m-d H:i:s",$timeAfterOneHour)."|".$updateFile[1]."|".$updateFile[2]."|".$updateFile[3]."|".$updateFile[4]."|".$updateFile[5]."\r\n";
		error_log($MMData,3,$fileDumpPath1) ;}

}
$file_process_status = '***************Script start for AircelMC******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);
$file_process_status = $url1 . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
error_log($file_process_status, 3, $processlog);

$insertDump7= 'LOAD DATA LOCAL INFILE "'.$fileDumpPath1.'" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';

  if (mysql_query($insertDump7, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
	 error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for AircelMC******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);
	
}
}
else
{
	echo "<br>";
	echo "Data not inserted for AircelMC.Please check altrist hourly integration url.";
	echo "<br>";
	echo $url1;
$file_process_status = '***************Data not inserted for AircelMC.******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n\r\n";
    error_log($file_process_status, 3, $processlog);
			$subject = 'Live KPI- AircelMC';
			$message="Hi Team, Unable to connect Altrist Server for AircelMC. Please check.";
			//mail($to, $subject, $message, $headers);
$email_url="http://192.168.100.212/hungamacare/all/sendEmailAlert.php?stype=AircelMC";
$response_email = file_get_contents($email_url);
}
////////////////////////////////////////////////AircelMC End////////////////////////////////////////////////////

////////////////////////////////////////////////AircelLM Begin////////////////////////////////////////////////////
$fileDumpfile="AircelLM_".date('ymd').'.txt';
$fileDumpPath1=$fileDumpPath.$fileDumpfile;

$response1=get_data($url2);
$file_date1 = explode("\n",$response1);

if(isset($file_date1) && trim($file_date1[0])!='')
{
$delQuery = "delete from misdata.livemis where date>date_format('".$view_date."','%Y-%m-%d 00:00:00') and service='AircelMU'";
mysql_query($delQuery,$LivdbConn);

$selectCount="select count(*) total_count from misdata.livemis where date>'".$view_date." 00:00:00' and service='AircelMU'";
$result=mysql_query($selectCount,$LivdbConn);
$yesCount=mysql_fetch_array($result);

if($yesCount['total_count']==0)
{
	unlink($fileDumpPath1);
	for($i=0;$i<count($file_date1);$i++) { 
		$updateFile = explode(",",$file_date1[$i]);
		if($updateFile[0]!=''){
		$currentTime = strtotime($updateFile[0]); 
		$timeAfterOneHour = $currentTime+60*60;

		$MUData=date("Y-m-d H:i:s",$timeAfterOneHour)."|".$updateFile[1]."|".$updateFile[2]."|".$updateFile[3]."|".$updateFile[4]."|".$updateFile[5]."\r\n";
		error_log($MUData,3,$fileDumpPath1) ;}
	}
	$file_process_status = '***************Script start for AircelMU******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
	error_log($file_process_status, 3, $processlog);
	$file_process_status = $url2 . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
	error_log($file_process_status, 3, $processlog);

	$insertDump7= 'LOAD DATA LOCAL INFILE "'.$fileDumpPath1.'" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
	
	 if (mysql_query($insertDump7, $LivdbConn)) {
        $file_process_status = 'Load Data query execute successfully' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
//$updateQuery = "update misdata.livemis set service='AircelMU' where service='AircelLM'";
//mysql_query($updateQuery,$LivdbConn);
    } else {
        $error = mysql_error();
        $file_process_status = 'Load Dara Error-' . $error . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    }
	 error_log($file_process_status, 3, $processlog);
    $file_process_status = '***************Script end for AircelMU******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n";
    error_log($file_process_status, 3, $processlog);

}
}
else
{
	echo "<br>";
	echo "Data not inserted for AircelMU. Please check altrist hourly integration url.";
	echo "<br>";
	echo $url2;
	$file_process_status = '***************Data not inserted for AircelMU.******************' . ' #datetime#' . date("Y-m-d H:i:s") . "\r\n\r\n";
    error_log($file_process_status, 3, $processlog);
		//send email alert for AircelLM		
			$subject = 'Live KPI- AircelLM';
			$message="Hi Team, Unable to connect Altrist Server for AircelLM. Please check.";
		$email_url="http://192.168.100.212/hungamacare/all/sendEmailAlert.php?stype=AircelLM";
		$response_email = file_get_contents($email_url);
}
////////////////////////////////////////////////AircelLM End////////////////////////////////////////////////////

	
echo "<br>done";
mysql_close($LivdbConn);
exit;
?>
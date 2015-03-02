<?php 
$fileDumpPath='/var/www/html/kmis/mis/livemis/aircel/aircelLog/';
if(date('H')=='2'){
	$date=date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
	$view_date=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
	$response = file_get_contents($url);
	$file_date = explode("\n",$response);
	$path = "/var/www/html/kmis/mis/livemis/aircel/aircelLog/aircel_".$view_date.".txt";
	error_log($response,3,$path);
}
else
{
	$date=date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));
	$view_date=date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
}

$url= "http://10.181.255.141:8080/HourlyIntegration/".$date.".txt";
echo $url."<br>";
$fileDumpfile="AircelMC_".$date.'txt';
$fileDumpPath1=$fileDumpPath.$fileDumpfile;

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

$response = get_data($url);

$file_date = explode("\n",$response);

/*** Live Mis DB Connection ***/
//$LivdbConn = mysql_connect('119.82.69.218','amit.khurana','hungama');
$LivdbConn = mysql_connect('119.82.69.218','php','php');


if(isset($file_date) && trim($file_date[0])!='')
{
        unlink($fileDumpPath1);
        
	$delQuery = "delete from misdata.livemis where date>date_format('".$view_date."','%Y-%m-%d 00:00:00') and service='AircelMC'";
	mysql_query($delQuery);

	$selectCount="select count(*) total_count from misdata.livemis where date>'".$view_date." 00:00:00' and service='AircelMC'";
	$result=mysql_query($selectCount);
	$yesCount=mysql_fetch_array($result);

	if($yesCount['total_count']==0)
	{
        for($i=0;$i<count($file_date);$i++) 
        { 
           //     $updateFile = explode(",",$file_date[$i]);
             //   $query = "insert into misdata.livemis values (DATE_ADD('".$updateFile[0]."',INTERVAL 1 HOUR), '".$updateFile[1]."', '".$updateFile[2]."', '".$updateFile[3]."', '".$updateFile[4]."', '".$updateFile[5]."')";
               // mysql_query($query);


                $updateFile = explode(",",$file_date[$i]);
                if($updateFile[0]!='')
                {
                $currentTime = strtotime($updateFile[0]); 
                $timeAfterOneHour = $currentTime+60*60;
                $MMData=date("Y-m-d H:i:s",$timeAfterOneHour)."|".$updateFile[1]."|".$updateFile[2]."|".$updateFile[3]."|".$updateFile[4]."|".$updateFile[5]."\r\n";
                error_log($MMData,3,$fileDumpPath1) ;

                }
        }
        $insertDump7= 'LOAD DATA LOCAL INFILE "'.$fileDumpPath1.'" INTO TABLE misdata.livemis FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n" 				(Date,Service,Circle,Type,Value,Revenue)';
        mysql_query($insertDump7,$LivdbConn);
	}
echo "done";
}
else
{
	$path = "/var/www/html/kmis/mis/livemis/aircel/aircelLog/aircelConnectivity_".$view_date.".txt";
	$cresponse="connectivity Down on -". date('his')."\n";
	error_log($cresponse,3,$path);
     echo "connection not availabel";
}

mysql_close($LivdbConn);
?>
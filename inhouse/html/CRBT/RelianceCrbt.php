<?php
date_default_timezone_set('Asia/Calcutta');
$con = mysql_connect("192.168.100.224","weburl","weburl") or die('we are facing some temporarily problem please try later');

$logPath ="/var/www/html/CRBT/log/crbt_log_".date("Ymd").".txt";

echo $getQuery="select ani,rngid from reliance_hungama.tbl_pausecodecrbt_reqs where status=0";

$Record = mysql_query($getQuery);
echo $Record;
while($RecordRow = mysql_fetch_row($Record))
{
	$updateQuery="update reliance_hungama.tbl_pausecodecrbt_reqs set status=2 where ani=".$RecordRow[0]." and status=0";
	$UpdateRecord = mysql_query($updateQuery);
	$curlResponse12=curl1($RecordRow[0],$RecordRow[1]);
	$logData = $RecordRow[0]."#".$RecordRow[1]."#".date('H:i:s')."#".$curlResponse12."\n";
        error_log($logData,3,$logPath);
}

function curl1($Ani,$RingId)
{
	echo $HitUrl="http://220.226.104.11/rcomvas?type=3&MDN=".$Ani."&tuneCode=".$RingId."&chID=IVR&opId=RCOM&servId=0-0-HNGMA-IVRMM&amp;resType=1";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$HitUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($ch);
	echo $insertQuery="INSERT INTO reliance_hungama.tbl_pausecodecrbt_resp (ani,rngid,date_time,status,operator,response) VALUES('".$Ani."','".$RingId."',NOW(),1,'TATM','".$response."')";
	$InsertRecord = mysql_query($insertQuery);
	echo $response;
	return $response;	
}
echo 'done';
?>

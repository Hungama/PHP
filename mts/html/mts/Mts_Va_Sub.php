<?php
$con = mysql_connect("database.master_mts","team_user","Te@m_us@r987") or die(mysql_error());
$obdShed=date('H');

$logPath ="/var/www/html/MTS/logs/MTS/crbt/VAsubLog_".date("Ymd").".txt";
switch($obdShed)
{
	case '15':
		$catId=15;
		break;
}
if($catId)
{
	$getQuery="select * from  mts_voicealert.tbl_voice_obd where obd_status=0 and cat_id=".$catId;

	$Record = mysql_query($getQuery);
	while($RecordRow = mysql_fetch_row($Record))
	{
		$updateQuery="update mts_voicealert.tbl_voice_obd set obd_status=1 where ani=".$RecordRow[0]." and obd_status=0 and cat_id=".$RecordRow[15];
		$UpdateRecord = mysql_query($updateQuery);
		
		$logData = $catId."#".$RecordRow[0]."#".$RecordRow[15]."#".$RecordRow[15]."#".date('Y-m-d H:i:s')."\n";
		error_log($logData,3,$logPath);
		$insertQuery="insert into mts_voicealert.tbl_OBD_category values(".$RecordRow[0].",".$RecordRow[3].",0,".$RecordRow[15].",".$RecordRow[16].",'".$RecordRow[17]."',now(),'".$RecordRow[11]."')";
		$InsertRecord = mysql_query($insertQuery);
		$curlResponse12=curl1($RecordRow[0],$RecordRow[11]);
	}
}


function curl1($Ani,$Circle)
{
	$HitUrl="http://10.130.14.106:8080/hungama/CallInit?ANI=54444&BNI=".$Ani."&circle=".$Circle;
	$ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,$HitUrl);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_exec($ch);
	//$response = curl_exec($ch);
	//echo $response;
	$logData1 = $HitUrl."#".$response."#".date("Y-m-d H:i:s")."\n";
	error_log($logData1,3,$logPath1);
	return '100';	
}
echo 'done';
?>
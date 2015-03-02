<?php
$con = mysql_connect("database.master_mts","team_user","Te@m_us@r987") or die(mysql_error());
$obdShed=date('H');

$logPath ="/var/www/html/MTS/logs/MTS/crbt/crbt_log_".date("Ymd").".txt";

$logPath1 = "/var/www/html/MTS/logs/crbt_checklog_".date("Ymd").".txt";
switch($obdShed)
{
	case '10':
		$catId=2;
		break;
	case '8':
		$catId=4;
		break;
	case '9':
		$catId=9;
		break;
	case '11':
		$catId=7;
		break;
	case '12':
		$catId=6;
		break;
	case '17':
		$catId=10;
		break;
	case '13':
		$catId=8;
		break;
	case '16':
		$catId=1;
		break;
	case '14':
		$catId=3;
		break;
	case '19':
		$catId=11;
		break;
	case '18':
		$catId=5;
		break;
	case '15':
		$catId=12;
		break;
}
if($catId)
{
	$getQuery="select * from  mts_voicealert.tbl_voice_category where status=1 and obd_status=0 and IsDND=0 and cat_id=".$catId." and circle NOT in ('RAJ','WBL','KOL','KAR','APD','BIH','HAY','UPE','MUM','MAH')";

	$Record = mysql_query($getQuery);
	while($RecordRow = mysql_fetch_row($Record))
	{
		$updateQuery="update mts_voicealert.tbl_voice_category set obd_status=1 where ani=".$RecordRow[0]." and obd_status=0 and cat_id=".$RecordRow[15];
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
//	$response = curl_exec($ch);
	//echo $response;
//	$logData1 = $HitUrl."#".$response."#".date("Y-m-d H:i:s")."\n";
//	error_log($logData1,3,$logPath1);
	return '100';	
}
echo 'done';
?>

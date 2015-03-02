<?php
include("dbConnect.php");

$getCurrentTimeQuery="select now()";
$timequery2 = mysql_query($getCurrentTimeQuery,$dbConn) or die(mysql_error());
$currentTime = mysql_fetch_row($timequery2);

$getDateFormatQuery="select date_format('".$currentTime[0]."','%Y-%m-%d %H')";

$dateFormatQuery = mysql_query($getDateFormatQuery,$dbConn) or die(mysql_error());
$DateFormat = mysql_fetch_row($dateFormatQuery);
//$DateFormat[0]='2012-07-18 17:00:00';

$circle_array = array('APD'=>'AP','BIH'=>'Bihar','CHN'=>'Chennai','DEL'=>'Delhi','GUJ'=>'Gujarat','HAY'=>'Haryana','HPD'=>'HP','JKM'=>'Jammu_Kashmir',
'KAR'=>'Karnataka','KER'=>'Kerala','KOL'=>'Kolkata','MAH'=>'Maharashtra','MPD'=>'MP','MUM'=>'Mumbai','NES'=>'NE',
'ORI'=>'Orissa','PUB'=>'Punjab','RAJ'=>'Rajasthan','TNU'=>'TN','UPE'=>'UP_E','UPW'=>'UP_W','WBL'=>'WB','ASM'=>'Assam',''=>'DEFAULT');

$query = "select msisdn,operator,circle,date_time from master_db.tbl_billing_success nolock where response_time between DATE_SUB('$DateFormat[0]', INTERVAL 1 HOUR) and '".$DateFormat[0]."'  and (mode IN ('OBD-MS','IVR-MS','net-MS','USSD-MS') OR SC='5464630') and event_type='SUB'"; 


$result = mysql_query($query);

$lckFilePath = "/var/www/html/hungamacare/MSlog/log_".date('ymd').".txt";
$fp=fopen($lckFilePath,'a+');
fclose($fp);

while($row1=mysql_fetch_array($result)) {
	$msisdn = trim($row1['msisdn']);
	$operator1 = trim($row1['operator']);
	$circle1 = trim(strtoupper($row1['circle']));
	$circle = $circle_array[$circle1];

	if($operator1=='VODM') 
		$operator='Vodafone';

	//$url="http://183.82.99.137/Hungama_Sub/index.php?mobno=".$msisdn."&operator=".$operator."&circle=".$circle."&uname=vgtApp&pwd=Vot_Mob";
	$url="http://183.82.99.137/Hungama_Sub/index.php?mobno=".$msisdn."&operator=".$operator."&circle=".$circle."&uname=vgtSub&pwd=HunSubApi";
	$url_response = file_get_contents($url);
	$insertQuery="INSERT INTO master_db.tbl_mobisur_sms_log VALUES('$msisdn','$circle','$operator',1,'$row1[date_time]','$url_response')";
	$Result=mysql_query($insertQuery);
	$fileLog = $msisdn."#".$url_response."#".$url."#".$row1['date_time']."#".date('Y-m-d H:i:s')."\r\n";
	error_log($fileLog,3,$lckFilePath);
	sleep(1);
}
echo "done";

mysql_close($dbConn);
?>
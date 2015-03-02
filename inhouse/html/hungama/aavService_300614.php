<?php
$dbConn = mysql_connect("database.master","weburl","weburl");
$msisdn=trim($_REQUEST['msisdn']);
$operator=trim($_REQUEST['operator']);
$logPath='/var/www/html/hungama/logs/log_'.date('Y-m-d').".txt";
$mode = "AA_WEB";
//echo $dbConn;
function get_opertaor_hit($operator, $msisdn, $mode) { 
	$response = "101";
	switch($operator) {
		case 'MTSM': $dbMTSConn = mysql_connect('10.130.14.106', 'Archana_db','Archana@123'); 
					$sub="select count(*) from mts_hungama.tbl_jbox_subscription where ANI='".$msisdn."' and MODE_OF_SUB!='TRCV'";
					$qry1=mysql_query($sub , $dbMTSConn);
					$rows1 = mysql_fetch_row($qry1);
					if($rows1[0] <=0)
					{
						$call="call mts_hungama.jbox_sub('".$msisdn."','01','".$mode."','5464611','30','1102','30')";
						$qry2=mysql_query($call, $dbMTSConn);
						$response = "100";	
					} else {
						$response = "102";	
					}
					$logData = $msisdn."#".$operator."#".$call."#".$response."#".date('Y-m-d H:i:s')."\n";	
					error_log($logData,3,$logPath);	
					mysql_close($dbMTSConn);
					//$url = "http://10.130.14.107/MTS/MTS.php?msisdn=".$msisdn. "&planid=30&reqtype=1&subchannel=OBD&serviceid=1102&mode=OBD&param=AAV&rcode=100,101,102"; 
			break; 
		case 'VODM': $dbVodaConn = mysql_connect('203.199.126.129', 'team_user','teamuser@voda#123');
					$sub="select count(*) from vodafone_hungama.tbl_jbox_subscription where ANI='".$msisdn."'";
					$qry1=mysql_query($sub , $dbVodaConn);
					$rows1 = mysql_fetch_row($qry1);
					if($rows1[0] <=0)
					{
						$call="call vodafone_hungama.JBOX_SUB('".$msisdn."','01','".$mode."','5464611','30','1302','2')";
						$qry2=mysql_query($call, $dbVodaConn);
						$response = "100";	
					} else {
						$response = "102";	
					}
					$logData = $msisdn."#".$operator."#".$call."#".$response."#".date('Y-m-d H:i:s')."\n";	
					error_log($logData,3,$logPath);	
					mysql_close($dbVodaConn);
					//$url = "http://203.199.126.129/vodafone/vodafone.php?msisdn=".$msisdn. 			"&mode=OBD&subchannel=OBD&reqtype=1&planid=2&servicename=vodafone_AAV&rcode=100,101,102";
			break;
		case 'UNIM': $dbConn1 = mysql_connect("database.master","weburl","weburl"); 
					$subQuery = "SELECT count(*) from uninor_hungama.tbl_Artist_Aloud_subscription where ANI='".$msisdn."'";
					$qry1=mysql_query($subQuery, $dbConn1);
					$rows1 = mysql_fetch_row($qry1);
					//echo $rows1[0];
					if($rows1[0] <=0)
					{
						$call="call uninor_hungama.ARTIST_ALOUD_SUB('".$msisdn."','01','".$mode."','5464611','30','1402','95')";
						$qry2=mysql_query($call, $dbConn1);
						$response = "100";	
					} else {
						$response = "102";	
					}
					$logData = $msisdn."#".$operator."#".$call."#".$response."#".date('Y-m-d H:i:s')."\n";	
					error_log($logData,3,$logPath);	
					//$url = "http://119.82.69.212/Uninor/uninor.php?msisdn=".$msisdn. "&planid=95&mode=OBD&subchannel=OBD&reqtype=1&servicename=uninor_aav&rcode=100,101,102";
					mysql_close($dbConn1);
			break;
		default:	$response="Invaild Operator";
			break;
	}
	return $response;
}

if(strlen($msisdn) == 12) $msisdn = substr($msisdn,2,10);
if(strlen($msisdn) == 10)
{
	$string = substr($msisdn,0,4);
	/*$query = "SELECT distinct operator FROM master_db.tbl_valid_series WHERE series like '".$string."%' limit 1";
	$result = mysql_query($query, $dbConn);
	list($operator) = mysql_fetch_array($result);*/
	//echo $operator;
	$response1 = get_opertaor_hit($operator,$msisdn, $mode);
	if($response1 == '100') $response = "SUCCESS";
	elseif($response1 == '102') $response = "ALREADY SUBSCRIBED";
	else $response = "FAILURE";

	/*if($url !='invalid') {
		echo "Res: ".$response1 = file_get_contents($url);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		echo "Res: ".$response1 = curl_exec($ch);
		curl_close($ch);		
	} else {
		$url = "Invalid Operator";
		$response = "FAILURE";
	}	*/	
	$logData = $msisdn."#".$operator."#".$response1."#".$response."#".date('Y-m-d H:i:s')."\n";	
	error_log($logData,3,$logPath);
} else {
	$logData = $msisdn."#Invalid MDN#FAILURE#".date('Y-m-d H:i:s')."\n";	
	error_log($logData,3,$logPath);	
	$response = "FAILURE";
} 
echo $response;
mysql_close($dbConn);
?>
<?php 
error_reporting(0);
require_once("db.php");
$operator=$_REQUEST['operator'];
$operatorBNBarray = array('all'=>'All' ,'vodm'=>'VODAFONE','unim'=>'UNINOR','airm'=>'AIRTEL','airc'=>'AIRCEL','mts'=>'MTS','relm'=>'RELIANCE','tatm'=>'TATM','tatc'=>'TATC');
$uploadvaluearray = array('smsmis_info'=>'SMS MIS','call_logs'=>'Call Logs','mis'=>'MIS');
$operatorarray = array('all'=>'All' ,'vodm'=>'Vodafone','unim'=>'Uninor','airm'=>'AIRTEL','airc'=>'AIRCEL','mts'=>'MTS','relm'=>'RELIANCE','tatm'=>'TATM','tatc'=>'TATC');
//$operator='all';
$selDate = date("Y-m-d",strtotime($dateStr));
$type=$_REQUEST['type'];

if($operator=='all')
{
$get_query="select ANI,main_keyword,sub_keyword,req_received,response_submited,circle,operator from Hungama_BNB.insertDailyReport_smsKeyword
order by req_received desc";
}
else
{
$get_query="select ANI,main_keyword,sub_keyword,req_received,response_submited,circle,operator 
from Hungama_BNB.insertDailyReport_smsKeyword
where operator='".$operatorBNBarray[$operator]."' order by req_received desc";
}
$obd_data = mysql_query($get_query, $con);
$result_row=mysql_num_rows($obd_data);

$excellFile="SMSData-".date("Ymd").".csv";
//$excellFilePath=$excellDirPath.$excellFile;

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$excellFile");
echo "MSISDN,SMSKeywordReceived,ResponseSubmittedTime,Operator,Circle"."\r\n";
	while($mis_array=mysql_fetch_array($obd_data))
	{
	echo $mis_array['ANI'].",".$mis_array['req_received'].",".$mis_array['response_submited'].",".$mis_array['operator'].",".$mis_array['circle']."\r\n";
	}

header("Pragma: no-cache");
header("Expires: 0");
?>
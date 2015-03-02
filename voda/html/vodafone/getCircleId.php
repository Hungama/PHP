<?php
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$stype=$_REQUEST['stype'];

$mode='WAP';
$curdate = date("Y-m-d");
//$con = mysql_connect("10.43.248.137","team_user","teamuser@voda#123");
$con = mysql_connect("10.43.248.137","php_promo","php@321");
	if(!$con)
	{
		die('could not connect1: ' . mysql_error());
	}

if($mode=='WAP')
{
$logDir="/var/www/html/vodafone/logs/dc/";
$curdate = date("Ymd");
$logPath2 = $logDir."WAPCIRCELREQUEST_".$curdate.".txt";
if(strlen($msisdn)==12 || strlen($msisdn)==10 )
	{
	if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}
	}
	
	//$validseries=substr($msisdn, 2, 4);
	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	//$getCircle = "select circle from master_db.tbl_valid_series where series =$validseries";
	$circle1=mysql_query($getCircle,$con) or die( mysql_error() );
	$circleRow = mysql_fetch_row($circle1);
	$operator_circle_map=array('01'=>'APD','02'=>'ASM','03'=>'BIH','18'=>'PUB','10'=>'KAR','13'=>'MAH','21'=>'TNU','20'=>'WBL','05'=>'DEL','14'=>'MPD','04'=>'CHN','22'=>'UPE','06'=>'GUJ','08'=>'HPD','07'=>'HAY','09'=>'JNK','11'=>'KER','12'=>'KOL','15'=>'MUM','16'=>'NES','17'=>'ORI','19'=>'RAJ','23'=>'UPW','07'=>'HAR');
	$operator_circle_map = array_flip($operator_circle_map);
	$cid=$operator_circle_map[$circleRow[0]];
	echo trim($cid);
	$logurl=$_REQUEST['msisdn']."#".$circleRow[0]."#".$cid."#".$stype."#".date("Y-m-d H:i:s")."\n";
	error_log($logurl,3,$logPath2);
}
else
{
echo 'NOK';
}
mysql_close($con);
?> 
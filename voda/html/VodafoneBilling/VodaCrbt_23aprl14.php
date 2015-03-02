<?php
//error_reporting(0);

$msisdn=$_REQUEST['msisdn'];
$PROMO_ID=$_REQUEST['PROMO_ID'];
$circle=$_REQUEST['circle'];

if(!$circle) {
	include("/var/www/html/hungamacare/dbConnect.php");
	$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
	$circle1=mysql_query($getCircle) or die( mysql_error() );
	while($row = mysql_fetch_array($circle1)) {
		$circle = $row['circle'];
	}
	if(!$circle) { $circle='UND'; }

	//echo  $circle;
	mysql_close($dbConn);
}

$logDir="/var/www/html/VodafoneBilling/log/CRBT/";
$logFile="CrbtResponse_".date("ymd").".txt";
$logFilePath=$logDir.$logFile;
$reqTime=date('his');
$fp=fopen($logFilePath,'a+');

$circleArray=array('KAR','MPD','CHN','TNU','GUJ','APD','KER','MAH','MUM');
if(in_array(strtoupper($circle),$circleArray))
	$IpToHit="http://10.10.5.219:8012/";
else
	$IpToHit="http://10.200.18.13:8012/";

$checkStatus=$IpToHit."rbt/rbt_promotion.jsp?MSISDN=".$msisdn."&REQUEST=STATUS";
//OLHUNGAMA
$result1=callCurl($checkStatus);

if(strtoupper($result1)=='ACTIVE' || strtoupper($result1)=='DEACTIVE')
{
	$selecTone =$IpToHit."rbt/rbt_promotion.jsp?MSISDN=".$msisdn."&REQUEST=SELECTION&SUB_TYPE=PRE&";
	$selecTone .="PROMO_ID=$PROMO_ID&SELECTED_BY=IVR_3P&CATEGORY_ID=3&ISACTIVATE=TRUE&SUBSCRIPTION";
	$selecTone .="_CLASS=DEFAULT&SELECTION_INFO=HUNGAMA&USE_UI_CHARGE_CLASS=TRUE&CHARGE_CLASS=DEFAULT";
	$seletResult=callCurl($selecTone);
	echo $seletResult."#".$result1;
}
elseif(strtoupper($result1)=='NEW_USER')
{
	$activeAndSelect=$IpToHit."rbt/rbt_promotion.jsp?MSISDN=".$msisdn."&REQUEST=SELECTION&SUB_TYPE=PRE&";
	$activeAndSelect.="PROMO_ID=".$PROMO_ID."&SELECTED_BY=IVR_3P&CATEGORY_ID=3&ISACTIVATE=TRUE&SUBSCRIPTION_CLASS=DEFAULT&SELECTION_INFO=HUNGAMA";
	$seletResult12=callCurl($activeAndSelect);
	echo $seletResult12."#".$result1;
}
else
	echo $errorMsg= "Error: ".$result1;

function callCurl($checkStatus)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$checkStatus);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$ApiResponse = curl_exec($ch);
	curl_close($ch);
	return $ApiResponse;
}

fwrite($fp,$msisdn."|".$PROMO_ID."|".$circle."|".$selecTone."|".$seletResult."|".$activeAndSelect."|".$seletResult12."|".$reqTime."|".$errorMsg.'|'.$result1."\r\n");
fclose($fp);

?>
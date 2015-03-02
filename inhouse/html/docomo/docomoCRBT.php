<?php
date_default_timezone_set('Asia/Calcutta');
$con = mysql_connect("192.168.100.224","weburl","weburl");
$msisdn=$_REQUEST['msisdn'];
$op=$_REQUEST['op'];
$clipId=$_REQUEST['clipId'];
$songId=$_REQUEST['songId'];
$dirPath="/var/www/html/docomo/logs/docomo/crbt/";
$fileName="crbt_".date('ymd').".txt";
$logPath=$dirPath.$fileName;
$explodeId=explode("-",$_REQUEST['clipId']);
$explodeCount=sizeof($explodeId);
for($i=0;$i<($explodeCount-1);$i++)
{
	if($i==$explodeCount-2)
		$song_id1 .=$explodeId[$i];
	else
		$song_id1 .=$explodeId[$i]."-";

}
$clipId1=$explodeId[$explodeCount-1];
$errrString=$msisdn."|".$clipId1."|".$song_id1."|".date('his')."|";

$ulink ="http://59.161.254.4:8085/rbt/rbt_promotion.jsp?MSISDN=".$msisdn."&REQUEST=STATUS&XML_REQUIRED=TRUE";
//$response=file_get_contents($ulink);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$ulink);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($ch); 

if(strstr($response,"RBT_ACT"))
{
	$cRBTMODE = "RBT";
	$type='crbtDOWNLOAD';
}
elseif(strstr($response,"EAUC"))
{
	$cRBTMODE = "EAUC";
	$type='crbtDOWNLOAD';
}
else
{
	$cRBTMODE = "NEW";
	$type='crbtACTIVATE';
}

$errrString .=$cRBTMODE."|".$type."|".$op."|";
if($op=='indi')
{
	$Procedure='indicom_radio.RADIO_CRBTRNGREQS';
	$circleOP='DEL@TATC';
}
else
{
	$Procedure='docomo_radio.RADIO_CRBTRNGREQS';
	$circleOP='DEL@TATM';
}
$call="call ".$Procedure."($msisdn,'$song_id1','$clipId1','$type','$circleOP')";
$qry1=mysql_query($call) or die( mysql_error() );
echo $response1="Request Accepted";
$errrString .=$response1."\r\n";
error_log($errrString,3,$logPath);
?>


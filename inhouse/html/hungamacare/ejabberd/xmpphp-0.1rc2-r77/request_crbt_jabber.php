<?php
$getcirclel="http://10.64.6.20:8080/rbt/rbt_promotion.jsp?MSISDN=8587800665&REQUEST=SELECTION&SUB_TYPE=P&TONE_ID=19105600489727&SELECTED_BY=IVR&CATEGORY_ID=6&ISACTIVATE=true&SUBSCRIPTION_CLASS=DEFAULT";
 echo $cir = file_get_contents($getcirclel);
 exit;
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$contentid=$_REQUEST['Onmobile_CRBT'];
$contentid1=$_REQUEST['CRBT_ID'];
//$msisdn='8587800665';
//$Onmobile_CRBT='9120400001513';
 $logPath_crbt = "logs/crbt/subscription_".$curdate.".txt";
//$CRBT_ID='5918481';
	//get circle info to decide wheter call onmobile APi Or Comviva
	$getcirclel="http://119.82.69.212/Uninor/uninorCheck.php?msisdn=".$msisdn."&reqtype=checkOP";
	 $cir = file_get_contents($getcirclel);
	if($cir=='UPE' || $cir=='UPW' || $cir=='BHR'|| $cir=='DEL')
	{
	//Onmobile (Circle)
	$toneid=$Onmobile_CRBT;
	$rthiturl="http://10.64.6.20:8080/rbt/rbt_promotion.jsp?MSISDN=".$msisdn."&REQUEST=SELECTION&SUB_TYPE=P&TONE_ID=".$toneid."&SELECTED_BY=IVR&CATEGORY_ID=6&ISACTIVATE=true&SUBSCRIPTION_CLASS=DEFAULT";
	}
	else if($cir=='APD' || $cir=='GUJ' || $cir=='MAH')
	{
	//Comviva  (Circle)
	$toneid=$CRBT_ID;
	$rthiturl="http://10.64.2.170:1212/CommonGW/Controller?interface=OBD&msgType=tprov&subscriberId=".$msisdn."&vcode=".$toneid."&chg=1&pack=default&provisioningInterface=D&subscription_plan_id=VAS0003ALL_40";
	}
			//send activation request api call start here
		//	echo $rthiturl."<br>";
			$response = file_get_contents($rthiturl);
			
$response_crbt="#CRBTURL#".$rthiturl."#Response#".$response."\r\n";
		error_log($response_crbt,3,$logPath_crbt);	
echo $response;

?>
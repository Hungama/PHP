<?php
switch($serviceId)
{
	case '1523':
		$sc='5500181';
		$s_id='1523';
		$db="airtel_TINTUMON";
		$subscriptionTable="tbl_TINTUMON_subscription";
		$subscriptionProcedure="TINTUMON_SUB";
		$unSubscriptionProcedure="TINTUMON_UNSUB";
		$unSubscriptionTable="tbl_TINTUMON_unsub";
		$lang='01';		
		$actSucc = "Thank you for subscribing TintuMon Jokes pack. Dial 5500181 to enjoy the service.";
		$actFail = "Sorry! Your subscription to TINTUMON service could not be processed due to some technical problem. Please try again later.";
		$actAlr = "You are already subscribe to the service.";
		$deactSucc = "You request has been received to stop TINTUMON from your mobile phone. Dial 5500181 to subscribe again.";
		$deactFail = "Sorry! Your request to Stop TINTUMON service could not be processed due to some technical problem. Please try again later.";
		$deactAlr = "You are not subscribe to the service. Dial 5500181 to subscribe now.";
	break;
}
//$validateResponse=ValidateParameter($serviceId,$msisdn);
$validateResponse=1;
if(!$validateResponse) 
{
	echo $response="Please provide the complete parameter";
	$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#"."Response:".$response."#".date("Y-m-d H:i:s")."\n\r";
	error_log($logData,3,$logPath);
	error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
} 
else {
	if($planid) { 
		$selAmount="select iAmount from master_db.tbl_plan_bank where plan_id=".$planid;
		$qryAmount = mysql_query($selAmount);
		list($amount) = mysql_fetch_array($qryAmount);
	}
	if($reqtype == 0) {
		header('Path=/airtelSubUnsub');
		header('Content-Type: UTF-8');		
		switch($serviceId)
		{
			case '1523': 
				$response='Welcome to Airtel TintuMon Jokes, a laughter clinic removing all your stress and agony with laughter '."\n".'Press 1 to sub'."\n".'Press 2 to unsub'."\n".'Reply';
				header("Menu code:".$response);				
			break;
		}
		header('Freeflow: FC');
		header('charge: y');
		header('amount:30');
		header('Expires: -1');
		echo $response;
		$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#".$qry."#Response:Freeflow:FC#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
		error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
	}

	if($reqtype=='1' && $planid) 
	{ 
		
		$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn' and status=1";
		$qry1=mysql_query($sub);
		$rows1 = mysql_fetch_row($qry1);	
		if($rows1[0]<=0) {
			$qry="call ".$db.".". $subscriptionProcedure." ('".$msisdn."','".$lang."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid.")";			
			$qry1=mysql_query($qry) or die( mysql_error() );					
			$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
			$qry2=mysql_query($sub);
			$rows2 = mysql_fetch_row($qry2);
			if($rows2[0]>0) 
				$response = $actSucc;
			else 
				$response = $actFail;
		} else {		
			$response = $actAlr;
		}
		header('Freeflow: FB');
		header('charge: y');
		header('amount:'.$amount);
		header('Expires: -1');
		header('Response:'.$response);
		echo $response;
		$logData=$msisdn."#".$planid."#".$serviceId."#".$reqtype."#".$circle."#".$qry."#Response:Freeflow:FB#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
		error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
	}
	if(($reqtype=='2') && $planid) 
	{	
		$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
		$qry1=mysql_query($sub);
		$rows1 = mysql_fetch_row($qry1);	
		
		if($rows1[0]>0) { 
			$unsubsQuery="call ".$db.".".$unSubscriptionProcedure." ('$msisdn','$mode')";
			$unsubsQuery1=mysql_query($unsubsQuery) or die( mysql_error() );
			
			$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
			$qry3=mysql_query($sub);
			$rows3 = mysql_fetch_row($qry3);	
			if($rows3[0] <= 0) 
				$response = $deactSucc;
			else 
				$response = $deactFail;
		} else {
			$response = $deactAlr;
		}
		header('Freeflow: FB');
		header('charge: y');
		header('amount:'.$amount);
		header('Expires: -1');
		header('Response:'.$response);

		echo $response;
		$logData=$msisdn."#".$planid."#".$serviceId."#".$reqtype."#".$circle."#".$unsubsQuery."#Response:Freeflow:FB#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
		if($serviceId == '1518' || $serviceId == '1515') {
			$ussdLogData=$msisdn."#Deactivation#".$serviceId."#".$circle."#".date("Y-m-d H:i:s")."\n";
			error_log($ussdLogData,3,$ussdLogPath);
		}
		error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
	}	
	mysql_close($dbConn);
} 
?>   
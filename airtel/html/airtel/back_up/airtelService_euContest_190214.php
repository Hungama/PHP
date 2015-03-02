<?php
$mysqli = new mysqli("10.2.73.156", "billing", "billing");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$allLogPathContest = "/var/www/html/airtel/logs/airtelService/" . $serviceId . "/AllLogsEuContest_" . date("Y-m-d") . ".txt";
//unset all variables
			/* unset($res);
			 unset($responsedata);
			 unset($ques_no);
			 unset($ques_desc);
			 unset($total_score);
			 unset($availble_ques);
			 unset($result);
			 unset($user_anskey);
			 unset($ans_key);
			 unset($IN_FLAG);
			 unset($row);*/
switch($serviceId)
{
	case '1501':
		$sc='546469';
		$s_id='1501';
		$db="airtel_radio";
		$subscriptionTable="tbl_radio_subscription";
		$subscriptionProcedure="RADIO_SUB";
		$unSubscriptionProcedure="RADIO_UNSUB";
		$unSubscriptionTable="tbl_radio_unsub";
		$getdataProcedure="RADIO_CONTEST_GET";
		$setdataProcedure="RADIO_CONTEST_SET";
		$lang='01';		
		if ($circle == 'KAR'){
            $lang = '10';
            $planid='6';
        }else if($circle == 'MAH'){
            $planid = '15';
        }
        else{
            $lang = '01';
            }
		$mode="USSD";
		$actSucc = "Your request to start Entertainment Unlimited service has been submitted successfully.";
        $actFail = "Sorry! Your subscription to Entertainment Unlimited service could not be processed due to some technical problem. Please try again later.";
        $actAlr = "You are already subscribe to the service.";
        $deactSucc = "You request has been received to stop Entertainment unlimited from your mobile phone. Dial 546469 to subscribe again.";
        $deactFail = "Sorry! Your request to Stop Entertainment unlimited service could not be processed due to some technical problem. Please try again later.";
        $deactAlr = "You are not subscribe to the service. Dial 546469 to subscribe now.";
	break;
}
$DIFFLEVEL=1;
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
			case '1501': 
				$response='Welcome to airtel contesting Zone.  '."\n".'4 to Play Now'."\n".'5 to check your points'."\n".'6 to redeem your points'."\n".'Reply';
				header("Menu code:".$response);				
			break;
		}
		header('Freeflow: FC');
		header('charge: y');
		header('amount:30');
		header('Expires: -1');
		echo $response;
		$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#Response:Freeflow:FC#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$allLogPathContest);
		//error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
	}
/*
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
*/	
	if($reqtype == 4) {
		header('Path=/airtelSubUnsub');
		header('Content-Type: UTF-8');		
		switch($serviceId)
		{
	case '1501': 
	//echo "CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "',@id)";
	$qry="CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "',@id)";
	$res= mysql_query("CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "',@id)");
	$contest_data  = mysql_query("SELECT @id");
	while($row=mysql_fetch_array($contest_data))
		{
			$responsedata=explode("#",$row[0]);
			//print_r($responsedata);
			$ques_no=$responsedata[0];
			$ques_desc=$responsedata[2];
			$ans_key=$responsedata[3];
			$total_score=$responsedata[4];
			$availble_ques=$responsedata[5];
			$DIFFLEVEL=$responsedata[7];
		}
		if($availble_ques>=1)		
		{
		$response='Q. '.$ques_desc."\n".'Reply';
		}
		else
		{
		$response = 'To play more for the day. Please get a topup. ' . "\n" . "Reply" . "\n" . "1t for Top up of Rs X for XX questions" . "\n" . "2t for Top up of Rs X for XX questions". "\n" . "3t for Top up of Rs X for XX questions";
		}
				header("Menu code:".$response);				
			break;
		}
		header('Freeflow: FC');
		header('charge: y');
		header('amount:30');
		header('Expires: -1');
		echo $response;
		$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#Available#".$availble_ques."#DiffLevel:".$DIFFLEVEL."#CorrectAns:".$ans_key."#Question:Freeflow:FC#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$allLogPathContest);
		//error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPathContest);	
	}
	if($reqtype == 5) {
		header('Path=/airtelSubUnsub');
		header('Content-Type: UTF-8');		
		switch($serviceId)
		{
			case '1501': 
				$response='Your total points are : XX';
				header("Menu code:".$response);				
			break;
		}
		header('Freeflow: FB');
		header('charge: y');
		header('amount:30');
		header('Expires: -1');
		echo $response;
		$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#Response:Freeflow:FC#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$allLogPathContest);
		//error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
	}

	if($reqtype == 6) {
		header('Path=/airtelSubUnsub');
		header('Content-Type: UTF-8');		
		switch($serviceId)
		{
			case '1501': 
				$response='1 for Rs 10 Recharge'."\n".'2 for Rs 7 Recharge'."\n".'3 for Rs 5 Recharge'."\n".'Reply';
				header("Menu code:".$response);				
			break;
		}
		header('Freeflow: FC');
		header('charge: y');
		header('amount:30');
		header('Expires: -1');
		echo $response;
		$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#Response:Freeflow:FC#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$allLogPathContest);
		//error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
	}
	
	if($reqtype == 7 ||$reqtype == 8 || $reqtype == 9 || $reqtype == 10) {
	switch($reqtype)
	{
	case '7':
			$user_anskey='1';
	break;
	case '8':
			$user_anskey='2';
	break;
	case '9':
			$user_anskey='3';
	break;
	case '10':
			$user_anskey='4';
	break;
	}
	//check ans
		header('Path=/airtelSubUnsub');
		header('Content-Type: UTF-8');		
		switch($serviceId)
		{
		case '1501': 
		//make a call to check answer
	$qry="CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "',@id)";
	mysql_query("CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "',@id)");
	$contest_data  = mysql_query("SELECT @id");
	while($row=mysql_fetch_row($contest_data))
		{
			$responsedata=explode("#",$row[0]);
			//print_r($responsedata);
			$ques_no=$responsedata[0];
			$ques_desc=$responsedata[2];
			$ans_key=$responsedata[3];
			$total_score=$responsedata[4];
			$availble_ques=$responsedata[5];
			$DIFFLEVEL=$responsedata[7];
		}
		
	$duration="5";
	
	if($ans_key==$user_anskey)
	{
	//echo "Correct Answer";
	$IN_FLAG='1';
	$total_score=$total_score+1;
	$ansMsg='Correct ans. Your total points is '.$total_score;
	$qry="CALL " . $db . "." . $setdataProcedure . "($msisdn,'".$DIFFLEVEL."','".$total_score."','".$user_anskey."','".$IN_FLAG."','" . $duration . "')";
	mysql_query("CALL " . $db . "." . $setdataProcedure . "($msisdn,'".$DIFFLEVEL."','".$total_score."','".$user_anskey."','".$IN_FLAG."','" . $duration . "')");
	}
	else
	{
//	echo "Wrong Answer";
	$IN_FLAG='2';
	$total_score=$total_score+0;
	$ansMsg='Incorrect ans. Your total points is '.$total_score;
	mysql_query("CALL " . $db . "." . $setdataProcedure . "($msisdn,'".$DIFFLEVEL."','".$total_score."','".$user_anskey."','".$IN_FLAG."','" . $duration . "')");
	}
	$logData=$msisdn."#".$serviceId."#Available#".$availble_ques."#".$reqtype."#TotalScore:".$total_score."#AnsKey:".$ans_key."#UserAnswerKey:#".$user_anskey."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$allLogPathContest);
 //send req to get more question   			
	mysql_query("CALL " . $db . "." . $getdataProcedure . "($msisdn,'".$DIFFLEVEL."','" . $mode . "',@id)");
	$contest_data  = mysql_query("SELECT @id");
	while($row=mysql_fetch_row($contest_data))
		{
			$responsedata=explode("#",$row[0]);
			//print_r($responsedata);
			$ques_no=$responsedata[0];
			$ques_desc=$responsedata[2];
			$ans_key=$responsedata[3];
			$total_score=$responsedata[4];
			$availble_ques=$responsedata[5];
			$DIFFLEVEL=$responsedata[7];
		}
	if($availble_ques>=1)		
		{
		$response=$ansMsg."\n".'Q. '.$ques_desc."\n".'Reply';
		}
		else
		{
		$response = 'To play more for the day. Please get a topup. ' . "\n" . "Reply" . "\n" . "1t for Top up of Rs X for XX questions" . "\n" . "2t for Top up of Rs X for XX questions". "\n" . "3t for Top up of Rs X for XX questions";
		}
//	Correct ans. Your total points is XX
	
				
				header("Menu code:".$response);				
			break;
		}
		header('Freeflow: FC');
		header('charge: y');
		header('amount:30');
		header('Expires: -1');
		echo $response;
		$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#Available#".$availble_ques."#DiffLevel:".$DIFFLEVEL."#CorrectAns:".$ans_key."#Question:Freeflow:FC#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$allLogPathContest);
		//error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPathContest);	
	}

	//for topup handling
	
		if($reqtype == '1T' || $reqtype == '2T' || $reqtype == '3T')
		{
		header('Path=/airtelSubUnsub');
		header('Content-Type: UTF-8');		
		switch($serviceId)
		{
			case '1501': 
				$response='Your request for topup has been submitted successfully.';
				header("Menu code:".$response);				
			break;
		}
		header('Freeflow: FB');
		header('charge: y');
		header('amount:30');
		header('Expires: -1');
		echo $response;
		$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#Available#".$availble_ques."#Response:Freeflow:FB#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$allLogPathContest);
		//error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$allLogPath);	
		}
	
	mysql_close($dbConn);
	$mysqli->close();
} 
?>   
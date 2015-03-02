<?php 
if($serviceId == 1513) {
	$logPath = "/var/www/html/airtel/logs/airtelFlayer/".$serviceId."/flayer_log_".date("Y-m-d").".txt";
	$logPath1 = "/var/www/html/airtel/logs/airtelFlayer/".$serviceId."/Airtel_Log_".date("Y-m-d").".txt";
	$logNewPath = "/var/www/html/airtel/logs/airtelFlayer/".$serviceId."/refLog_".date("Y-m-d").".txt";
} else {
	$logPath = "/var/www/html/airtel/logs/airtelService/".$serviceId."/log_".date("Y-m-d").".txt";
	$logNewPath = "/var/www/html/airtel/logs/airtelService/".$serviceId."/reflog_".date("Y-m-d").".txt";
}

if($reqtype == 0) {
	header('Path=/airtelSubUnsub');
	header('Content-Type: UTF-8');
	switch($serviceId)
	{	
		case '1501':
		$response="Welcome! Please enter customer's 10 digit mobile no.";
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
	if($serviceId == '1501') error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$logNewPath);
}

if((strlen($reqtype)>2) && ($serviceId==1501)) {	
	header('Path=/airtelSubUnsub');
	header('Content-Type: UTF-8');	
	if(!$planid) {
		switch($serviceId) 	{			
			case '1501': 
				$response='Welcome to Airtel Entertainment Unlimited. Listen unlimited music, Audio cinema, and Bollywood gossips. Download HT and ringtone'."\n".'Press 1 to subscribe'."\n".'Press 2 to unsubscribe'."\n".'Reply';  
			break;	
		}
		header('Freeflow: FB');
		header('charge: y');
		header('amount:'.$amount);
		header('Expires: -1');
		header('Response:'.$response);
		echo $response;
		$logData=$msisdn."#".$frndMDN."#".$planid."#".$serviceId."#".$reqtype."#".$circle."#".$qry."#Response:Freeflow:FC#".$response."#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
		error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$logNewPath);
	} 
	elseif($planid) {
		if(strlen($reqtype)==10 || strlen($reqtype)==12) {
		switch($serviceId) {			
			case '1501': 
				$message = "Dear Customer, English seekhna hua aur bhi aasan, saath main paye Aptech certification bhi. Is pack ko paane ke liye, SMS karein Yes";
				$response="Your request to start Entertainment Unlimited service has been submitted successfully.."; 
				$from="546469";
				$sndMsgQuery1 = "CALL master_db.SENDSMS('".$frndMDN."','".$message."','".$from."',4,'".$from."','Sub_OK')"; 
			break;
			}

		$getCircle1 = "select master_db.getCircle(".trim($frndMDN).") as circle";
		$userCircle2=mysql_query($getCircle1) or die( mysql_error() );
		while($row = mysql_fetch_array($userCircle2)) {
			$userCircle = $row['circle'];
		}
		if(!$userCircle)
			{ $userCircle='UND'; }

		$queryF = "INSERT INTO master_db.tbl_refer_ussdData VALUES ('','".$msisdn."','".$frndMDN."',NOW(),adddate(NOW(),3),'".$serviceId."','Retailer','".$userCircle."','',0,0,0,'');";
		mysql_query($queryF);		
		
		mysql_query($sndMsgQuery1); 
		header('Freeflow: FB');
		} else {
			switch($serviceId) {			
				case '1501': $response="Please enter valid mobile number."; 
				break;
			}
		}
		header('Freeflow: FB');
		header('charge: y');
		header('amount:'.$amount);
		header('Expires: -1');
		header('Response:'.$response);
		echo $response;
		$logData=$msisdn."#".$frndMDN."#".$planid."#".$serviceId."#".$reqtype."#".$circle."#".$qry."#Response:Freeflow:FB#".$response."#".$sndMsgQuery1."#".$message. "#".date("Y-m-d H:i:s")."\n";
		error_log($logData,3,$logPath);
		error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$logNewPath);
	}
} 

if($reqtype=='2') {
	header('Path=/airtelSubUnsub');
	header('Content-Type: UTF-8');
	switch($serviceId) 
	{	
		case '1501': $response="Enter 10 digit number of your friend";									
			header('Menu code:'.$response);
		break;
	}
	header('Freeflow: FC');
	header('charge: y');
	header('amount:30');
	header('Expires: -1');
	echo $response;
	$logData=$msisdn."#".$serviceId."#".$reqtype."#".$circle."#".$qry."#Response:Freeflow:FC#".$response."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
	if($serviceId == '1501') error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$logNewPath);
}

if((strlen($reqtype)==10 || strlen($reqtype)==12) && ($serviceId=='1501'))
{	
	$friendMDN = $reqtype;
	$endDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+3,date("Y")));
	$queryF = "INSERT INTO master_db.tbl_refer_ussdData VALUES ('','".$msisdn."','".$friendMDN."',NOW(),adddate(NOW(),3),'".$serviceId."','Friend',0,0,0,'');";
	mysql_query($queryF);
	
	if($serviceId=='1501') { 
		$sc="546469";
		$message1="We have sent your reference to the ".$friendMDN." for Airtel Entertainment Unlimited";
		$message2="Hi, I ".$msisdn." recommend you to subscribe to Airtel Entertainment Unlimited. Just  Dial USSD string *321*614# to accept. @Rs.10/7 days";

		$sndMsgQuery1 = "CALL master_db.SENDSMS('".$msisdn."','".$message1."','601666',0,'".$sc."','active')"; 
		mysql_query($sndMsgQuery1);

		$sndMsgQuery2 = "CALL master_db.SENDSMS('".$friendMDN."','".$message2."','601666',0,'".$sc."','active')"; 
		mysql_query($sndMsgQuery2);
		$response = "Your request for reference has been sent successfully.";
		header('Freeflow: FB');
	}  
	
	header('charge: y');
	header('amount:'.$amount);
	header('Expires: -1');
	header('Response:'.$response);
	echo $response;
	
	$logData=$msisdn."#".$planid."#".$serviceId."#".$reqtype."#".$circle."#".$unsubsQuery."#Response:Freeflow:FB#".$response."#".date("Y-m-d H:i:s")."\n";
	error_log($logData,3,$logPath);
	error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$logNewPath);
}	
mysql_close($dbConn);	

exit;
?>   
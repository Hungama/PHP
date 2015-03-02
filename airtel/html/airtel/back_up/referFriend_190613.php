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
		case '1514':
		case '1517': if($circle=="UPW") $response="Welcome! Please enter customer's 10 digit mobile no.";	
	   				 else $response="Welcome! Please type customer's 10 digit mobile no."."\n"."Reply";	
			header("Menu code:".$response);
		break;
		case '1515': if($retData) 
						$response="Welcome! Please type customer's 10 digit mobile no."."\n"."Reply"; 
					 else
						$response='Welcome to SARNAM. Subscribe @Rs.10/7 day & listen Bhakti songs. '."\n"."Reply"."\n"."1 to Subscribe"."\n"."2 to Refer A Friend"; 
			header("Menu code:".$response);
		break;
		case '1513': if($retData) 
						$response="Welcome! Please type customer's 10 digit mobile no."."\n"."Reply"; 
					 else
						$response='Welcome to My Naughty Diary. '.$planDesc.' & listen naughty stories.'."\n".'Reply '."\n".'1 to Subscribe '."\n"."2 to Refer A Friend"; 
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
	if($serviceId == '1517' || $serviceId == '1514') error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$logNewPath);
}

if((strlen($reqtype)>2) && ($serviceId==1514 || $serviceId==1517 || $serviceId==1513) && $retData) {	
	header('Path=/airtelSubUnsub');
	header('Content-Type: UTF-8');	
	if(!$planid) {
		switch($serviceId) 	{			
			case '1514':
			case '1517': 
				$response="To subscribe to following services,"."\n"."Reply."."\n"."1.Spoken English"."\n"."2.Personality Development"; 
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
			case '1514': 
				$message = "Dear Customer, English seekhna hua aur bhi aasan, saath main paye Aptech certification bhi. Is pack ko paane ke liye, SMS karein Yes";
				$response="Your Request to start Personality Development Service has been submitted successfully."; 
				$from="571811";
				$sndMsgQuery1 = "CALL master_db.SENDSMS('".$frndMDN."','".$message."','".$from."',4,'".$from."','Sub_OK')"; 
			break;
			case '1517': 
				if($circle=="UPW") 
					$message = "Aptech certified Spoken English course apke mobile par ghar baithe. Rs. 30/15 days for 90 days. Activate karne ke liye reply kare 1 se.";
				else
					$message = "Job aur padai mein tarakki ke liye seekhiye Spoken English apne mobile par! Subscribe karne ke liye reply mein bhejiye YES. Rs.30/15 days. Aptech certified!";
				
			$response="Your Request to start Spoken English Service has been submitted successfully."; 
			$from="571811";
			$sndMsgQuery1 = "CALL master_db.SENDSMS('".$frndMDN."','".$message."','".$from."',4,'".$from."','RET')"; 
			break;
			case '1513': $message = "Priye customer, retailer dwara aapko My Naughty Diary sewa ki request bheji gayi hai.Sewa shuru karne ke liye is SMS ka reply kare 1 dabakar.Shulk Rs.30/month";
							//"Naina, BPO Ex Maya aur actress Kajal ki zindagi ke rangeen raaz jaanne ke liye My Naughty Dairy subscribe karne ke liye  isi number pe Yes reply karein (tollfree)"; //5500196
						 $response="Your Request to start My Naughty Diary Service has been submitted successfully."; 
						 $from="55001";
						 $sndMsgQuery1 = "CALL airtel_smspack.SENDSMS('".$frndMDN."','".$message."','HMLIFE',1,'".$from."','Sub_OK')"; 
			break;
		}

		$getCircle1 = "select master_db.getCircle(".trim($frndMDN).") as circle";
		$userCircle2=mysql_query($getCircle1) or die( mysql_error() );
		while($row = mysql_fetch_array($userCircle2)) {
			$userCircle = $row['circle'];
		}
		if(!$userCircle)
			{ $userCircle='UND'; }

		$queryF = "INSERT INTO master_db.tbl_refer_ussdData VALUES ('','".$msisdn."','".$frndMDN."',NOW(),adddate(NOW(),3),'".$serviceId."','Retailer','".$userCircle."','',0,0,0);";
		mysql_query($queryF);		
		
		mysql_query($sndMsgQuery1); 
		header('Freeflow: FB');
		} else {
			switch($serviceId) {			
				case '1514': 
				case '1517': 
				case '1513': $response="Please enter valid mobile number."; 
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
		case '1515': $response="Enter 10 digit number of your friend";									
			header('Menu code:'.$response);
		break;
		case '1513': $response="Enter 10 digit number of your friend";									
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
	if($serviceId == '1517' || $serviceId == '1514') error_log($msisdn."#".$reqtype."#".$circle."#".date("Y-m-d H:i:s")."\n",3,$logNewPath);
}

if((strlen($reqtype)==10 || strlen($reqtype)==12) && ($serviceId=='1515' || $serviceId=='1513') && !$retData)
{	
	$friendMDN = $reqtype;
	$endDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+3,date("Y")));
	$queryF = "INSERT INTO master_db.tbl_refer_ussdData VALUES ('','".$msisdn."','".$friendMDN."',NOW(),adddate(NOW(),3),'".$serviceId."','Friend',0,0,0);";
	mysql_query($queryF);
	
	if($serviceId=='1515') { 
		$sc="51050";
		$message1="We have sent your reference to the ".$friendMDN." for Airtel SARNAM";
		$message2="Hi, I ".$msisdn." recommend you to subscribe to Airtel SARNAM and enjoy devotional songs. Just  Dial USSD string *321*614# to accept. @Rs.10/7 days";

		$sndMsgQuery1 = "CALL master_db.SENDSMS('".$msisdn."','".$message1."','601666',0,'".$sc."','active')"; 
		mysql_query($sndMsgQuery1);

		$sndMsgQuery2 = "CALL master_db.SENDSMS('".$friendMDN."','".$message2."','601666',0,'".$sc."','active')"; 
		mysql_query($sndMsgQuery2);
		$response = "Your request for reference has been sent successfully.";
		header('Freeflow: FB');
	}  elseif($serviceId=='1513') {
		$sc="5500196";
		$message1="We have sent your reference to the ".$friendMDN." for My Naughty Diary";
		$message2="Hi, I ".$msisdn." recommend you to subscribe to My Naughty Diary and enjoy naughty stories. Just  Dial USSD string *177*995# to accept. @Rs.30/30 days";
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
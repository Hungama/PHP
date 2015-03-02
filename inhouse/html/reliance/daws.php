<?php
	//require ('/usr/local/apache/htdocs/hungamawap/new_functions.php3');
	
	$headers = getallheaders();

	while (list($name, $value) = each ($headers))
	{
		if ((strtolower($name) == "x-msisdn")||(strtolower($name) == "msisdn")||($name == "x-up-calling-line-id") || ($name == "x-wsb-identity")||(strtolower($name) == strtolower("X-Nokia-msisdn"))||(strtolower($name) == strtolower("X-wap-clientid"))||(strtoupper($name) == strtoupper("x-msisdn")) || (strtolower(trim($name)) == strtolower("_rapmin")) || (strtolower(trim($name)) == strtolower("MSISDN")) || (strtolower(trim($name)) == strtolower("x-up-calling-line-id")) || (strtolower(trim($name)) == strtolower("XMSISDN")) || strtolower(trim($name)) == strtolower("x-mdn") || (strtolower(trim($name)) == strtolower("X-WAP-Network-Client-MSISDN")) || (strtolower(trim($name)) == strtolower("User-Identity-Forward-msisdn")))
		{
			if(strlen(trim($value)) > 0) # Condition to get the MSISDN from the Various Headers specified in the above If 
			{
				$msisdn = $value;	
			}
		}
	}

echo $msisdn = substr($msisdn, -10);
	exit;

	$LOG_PATH = "/usr/local/apache/htdocs/hungamawap/reliance/wap_sub/wap_subscription_" . date("Ymd") . ".log";
	chmod($LOG_PATH,0777);
	@exec("chmod 777 ".$LOG_PATH);

	//$LOG_PATH = "/usr/local/apache/htdocs/reliance/wap_sub/logs.txt";
	$get_params = 	$_REQUEST;
	$reqtype = 		$get_params["reqtype"];
	$planid = 		$get_params["planid"];
	$serviceid = 	$get_params["serviceid"];
	$req_uri = 		$_SERVER["REQUEST_URI"];
	
	logFile("Mobile no.:".$msisdn."|Request Type:".$reqtype."|Plan id:".$planid."|Serviceid:".$serviceid);

	$apiurl = "http://119.82.69.212/reliance/RelianceWap.php";
	$post_fields = "'"."msisdn=".$msisdn."&reqtype=".$reqtype."&planid=".$planid."&serviceid=".$serviceid."'";
	//logFile("Post field : " . $post_fields);
	$response_text = call_rel_api($apiurl, $post_fields);
	logFile("Return Response : " . $response_text);
	$success_msg = "";
	
	if ($response_text == "success")
	{
		switch($serviceid)
		{
			case 1208:
				$success_msg = "Thank you for subscribing Cricket Mania Service. Predict and Win exiting prices!!! Dial 54433.";
				break;
			
			case 1202:
				$success_msg = "Thank you for Subscribing Hungama Media Portal. Just Dial 546460 and get fully loaded Entertainment service from Bollywood latest songs & Gossips to answers of your love related query from our love guru.";
				break;

			case 1203:
				$success_msg = "Thank you for Subscribing MTV DJ Dial. Listen your favorite songs which we are carrying from past till latest one. So just dial 546461!!.";
				break;
			
		}
		
		print $success_msg;
	} else if ($response_text == "failure")
	{
		print "Request could not processed ,please try later";
	}else{
		echo $response_text;
	}
		
	function call_rel_api($url, $p_fields)
	{
		logFile("URL : " . $url);
		logFile("Post fields : " . $p_fields);

	//	logFile("Mobile no.:".$msisdn."|Request Type:".$reqtype."|Plan id:".$planid."|Serviceid:".$serviceid);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $p_fields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
	 
		$r = curl_exec($ch);
		logFile("CURL Response : " . $r);
		if(!$r)
			echo "Error: " . curl_error($ch) . "\n";
		curl_close($ch);
		return $r;
	}
	
	function  logFile($data,$arr=""){
	GLOBAL $LOG_PATH;
	$fp1 = fopen($LOG_PATH,"a+");
	if($arr) {
		fwrite($fp1,date("d-m-Y H:i:s")." => ".print_r($data,true)."\n");
	}
	else {
		fwrite($fp1, date("d-m-Y H:i:s")." => ".$data."\n");
	}
	fclose($fp1);
}
?>
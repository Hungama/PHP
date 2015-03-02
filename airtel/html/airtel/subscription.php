<?php

set_time_limit(15);
header("Content-type: text/xml");
error_reporting(0);
$msisdn = trim($_REQUEST['msisdn']);
$action = $_REQUEST['action'];
$pid = $_REQUEST['pid'];
$plan = $_REQUEST['plan'];
$transid = $_REQUEST['transid'];
$mode = 'SMS_Retail_SC';
$curtime = date(YmdHis);
$response_id = $msisdn . "_" . $curtime;

$logPath = "/var/www/html/airtel/logs/USSDSubscription/subscription_" . date(Ymd) . ".txt";
$data = $msisdn . "#" . $action . "#" . $pid . "#" . $plan . "#" . $transid . "#" . $mode . "#" . $response_id . "\r\n";
error_log($data, 3, $logPath);

if (($msisdn == "") || ($pid == "") || ($action == "") || ($plan == "") || ($transid == "")) {
    $xmlstr = "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
    $xmlstr .= "<XML>\n";
    $xmlstr .= "<ERROR>Invalid request parameters.</ERROR>\n";
    $xmlstr .= "<VALUE>1</VALUE>\n";
    $xmlstr .= "</XML>\n";
    echo $xmlstr;
    $data = $xmlstr . "\r\n";
    error_log($data, 3, $logPath);
    exit;
}

function checkmsisdn($msisdn) {
    if (strlen($msisdn) == 10 && is_numeric($msisdn)) {
        return $msisdn;
    }
}

function checkaction($action) {
//    if (ctype_alnum($action)) {
    if ($action == 'SUBSCRIBE') {
        return $action;
    }
}

function checkpid($pid) {
    if ((strlen($pid) <= 30) && (ctype_alnum(str_replace('_', '', $pid)))) {
        // if ((strlen($pid) <= 30) && (preg_match('/^[a-zA-Z0-9_]+$/', $pid) == 1)) {
        return $pid;
    }
}

function checkplan($plan) {
    if ((strlen($plan) <= 30) && (ctype_alnum(str_replace('_', '', $plan)))) {
        return $plan;
    }
}

function checktransid($transid) {
    if ((strlen($transid) <= 35) && is_numeric($transid)) {
        // if ((strlen($pid) <= 30) && (preg_match('/^[a-zA-Z0-9_]+$/', $pid) == 1)) {
        return $transid;
    }
}

$msisdn = checkmsisdn($msisdn);
$pid = checkpid($pid);
$action = checkaction($action);
$plan = checkplan($plan);
$transid = checktransid($transid);


if (($msisdn == "") || ($pid == "") || ($action == "") || ($plan == "") || ($transid == "")) {
    $xmlstr = "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
    $xmlstr .= "<XML>\n";
    $xmlstr .= "<ERROR>Invalid request parameters.</ERROR>\n";
    $xmlstr .= "<VALUE>1</VALUE>\n";
    $xmlstr .= "</XML>\n";
    echo $xmlstr;
    $data = $xmlstr . "\r\n";
    error_log($data, 3, $logPath);
    exit;
} else {
    include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
    if (!$dbConn) {
        //die('could not connect: ' . mysql_error());
		$xmlstr = "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
    $xmlstr .= "<XML>\n";
    $xmlstr .= "<ERROR>Other Error.</ERROR>\n";
    $xmlstr .= "<VALUE>13</VALUE>\n";
    $xmlstr .= "</XML>\n";
    echo $xmlstr;
	$error=mysql_error();
	$dataLog=$qry ."#".$error."#".date('Y-m-d H:i:s'). "\r\n";
	error_log($dataLog, 3, $logPath);
	exit;
    }

    switch ($pid) {
        case '1513':
		case '1508709':
            $sc = '5500196';
            $s_id = '1513';
            $db = "airtel_mnd";
            $subscriptionTable = "tbl_character_subscription1";
            $subscriptionProcedure = "MND_SUB";
            $unSubscriptionProcedure = "MND_UNSUB";
            $unSubscriptionTable = "tbl_character_unsub1";
            $lang = '01';
            break;
        case '1515':
		case '1508630':
            $sc = '51050';
            $s_id = '1515';
            $db = "airtel_devo";
            $subscriptionTable = "tbl_devo_subscription";
            $subscriptionProcedure = "DEVO_SUB";
            $unSubscriptionProcedure = "devo_unsub";
            $unSubscriptionTable = "tbl_devo_unsub";
            $lang = '01';
            break;
        case '1517':
		case '1513819':
            $sc = '571811';
            $s_id = '1517';
            $db = "airtel_SPKENG";
            $subscriptionTable = "tbl_spkeng_subscription";
            $subscriptionProcedure = "JBOX_SUB";
            $unSubscriptionProcedure = "JBOX_UNSUB";
            $unSubscriptionTable = "tbl_spkeng_unsub";
            $lang = '01';
            break;
    }

    $langValue = $langArray[strtoupper($lang)];
    if (!$langValue)
        $langValue = "01";

    $amtquery = "select iAmount from master_db.tbl_plan_bank nolock where Plan_id='$plan' and S_id=$pid";

    $amt = mysql_query($amtquery);
    List($row1) = mysql_fetch_row($amt);
    $amount = $row1;

    $query3 = "select status from " . $db . "." . $subscriptionTable . " nolock where ANI='$msisdn'";
    $qry1 = mysql_query($query3);
	$isexist = mysql_num_rows($qry1);
    $rows1 = mysql_fetch_array($qry1);
    if ($isexist <= 0) {

	      $qry = "call " . $db . "." . $subscriptionProcedure . " ('" . $msisdn . "','" . $langValue . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . "," . $plan . ")";
        $qry1 = mysql_query($qry);
		if($qry1)
		{
		$insertQry = "INSERT INTO master_db.tbl_ussd_logs (msisdn,action,pid,plan,transid,response_id,date_time) 
                      VALUES ('" . $msisdn . "','" . $action . "', '" . $pid . "', '" . $plan . "', '" . $transid . "', '" . $response_id . "',now())";
        mysql_query($insertQry);
		$result = 0;
		}
		else
		{
		$error=mysql_error();
		$dataLog=$qry ."#".$error."#".date('Y-m-d H:i:s'). "\r\n";
		error_log($dataLog, 3, $logPath);
		$result = 13;
		$errormsg='Other Error.';
		}

     }
    else
	{
		if($rows1['status']==0)
		{  
			$result = 2;
			$errormsg='User subscription request is in pending state.';
		  }
		  else
		  {
		  $result = 12;
		  $errormsg='User is already subscribed for the service.';
		  }
}
    
	 $xmlstr = "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
	 $xmlstr .= "<XML>\n";
	if ($result == 0) {
        $xmlstr .= "<STATUS>SUCCESS</STATUS>\n";
        $xmlstr .= "<TID>$response_id</TID>\n";
         } 
	elseif ($result == 2 || $result == 12 || $result == 13 ) {
        $xmlstr .= "<ERROR>$errormsg</ERROR>\n";
        $xmlstr .= "<VALUE>$result</VALUE>\n";
          }
	$xmlstr .= "</XML>\n";
     echo $xmlstr;
	 $data = $xmlstr . "\r\n";
     error_log($data, 3, $logPath);
	 mysql_close($dbConn);
}
?>   
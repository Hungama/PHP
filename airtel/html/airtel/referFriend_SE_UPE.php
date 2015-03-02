<?php

$logPath = "/var/www/html/airtel/logs/airtelService/" . $serviceId . "/SE_UPE_log_" . date("Y-m-d") . ".txt";
$mode = 'USSD_Retail';
if ($reqtype == 0) {
    header('Path=/airtelSubUnsub');
    header('Content-Type: UTF-8');
    switch ($serviceId) {
        case '1517':

            $response = "Please Enter Users 10 digit mobile number," . "\n" . "Reply";
            header("Menu code:" . $response);
            break;
    }

    header('Freeflow: FC');
    header('charge: y');
    header('amount:30');
    header('Expires: -1');
    echo $response;
    $logData = $msisdn . "#" . $serviceId . "#" . $reqtype . "#" . $circle . "#" . $qry . "#Response:Freeflow:FC#" . $response . "#" . date("Y-m-d H:i:s") . "\n";
    error_log($logData, 3, $logPath);
}
if (strlen($reqtype) > 3) {
    if (strlen($reqtype) == 10 || strlen($reqtype) == 12) {
        $queryF = "INSERT INTO master_db.tbl_refer_ussdData VALUES ('','" . $msisdn . "','" . $reqtype . "',NOW(),adddate(NOW(),3),'" . $serviceId . "','Retailer','UPE','','100','','','','')";
        mysql_query($queryF);
        header('Path=/airtelSubUnsub');
        header('Content-Type: UTF-8');

        $response = "Please select the Service charges" . "\n" . "\n" . "6.	For Rs. 399" . "\n" . "7.	For Rs. 299" . "\n" . "Reply";
        header("Menu code:" . $response);
        header('Freeflow: FC');
        header('charge: y');
        header('amount:30');
        header('Expires: -1');
        echo $response;
    } else {
        switch ($serviceId) {
            case '1517':
                $response = "Please enter valid mobile number.";
                break;
        }
        header('Freeflow: FB');
        header('charge: y');
        header('amount:' . $amount);
        header('Expires: -1');
        header('Response:' . $response);
        echo $response;
    }
    $logData = $msisdn . "#" . $serviceId . "#" . $reqtype . "#" . $circle . "#" . $qry . "#Response:Freeflow:FC#" . $response . "#" . date("Y-m-d H:i:s") . "\n";
    error_log($logData, 3, $logPath);
}
if ($reqtype == 6 || $reqtype == 7) {
    //echo $reqtype;
    switch ($reqtype) {
        case '6':
            $plan_id = "56";
            $msgText = "399/120 days";
            $amount = "399";
            break;
        case '7':
            $plan_id = "92";
            $msgText = "299/90 days";
            $amount = "299";
            break;
    }

    $db = "airtel_SPKENG";
    $subscriptionTable = "tbl_spkeng_subscription";
    $subscriptionProcedure = "JBOX_SUB";
    $unSubscriptionProcedure = "JBOX_UNSUB";
    $unSubscriptionTable = "tbl_spkeng_unsub";
    $lang = '01';
    $sc = '571811';
    $s_id = '1517';
    $sName1 = "Spoken English";

    $getOldRecord = "select friendANI from master_db.tbl_refer_ussdData where date(referDate)=date(now()) and service_id=1517  and status=100 order by id desc limit 1";
    $userOldRecord = mysql_query($getOldRecord) or die(mysql_error());
    $Planrow12 = mysql_fetch_array($userOldRecord);
    $friendANI = $Planrow12['friendANI'];
    if ($friendANI) {
       $updateQuery = " update master_db.tbl_refer_ussdData set status='5',plan_id='" . $plan_id . "' where date(referDate)=date(now()) and service_id=1517 and friendANI='" . $friendANI . "' and status=100";
        mysql_query($updateQuery);
    }else{
        exit;
    }
    
    $sub = "select ani,status from " . $db . "." . $subscriptionTable . " where ANI='$friendANI'";
    $qry1 = mysql_query($sub);
    $rows1 = mysql_fetch_row($qry1);
    $status1 = $rows1[1];
    if ($rows1[0] <= 0) {
        $qry = "call " . $db . "." . $subscriptionProcedure . " ('" . $friendANI . "','" . $lang . "','" . $mode . "','" . $sc . "','" . $amount . "'," . $s_id . "," . $plan_id . ")";
        $qry1 = mysql_query($qry) or die(mysql_error());
        $response = "Your request to Start SPOKEN ENGLISH service has been submitted successfully.";
        header("Menu code:" . $response);
        echo $response;
    } else {
        switch ($status1) {
            case '1':
            case '11':
                $response = "Dear Retailer,  " . $friendANI . "  is already subscribe to the " . $sName1 . "";
                break;
            case '0':
                $response = "Dear Retailer, " . $friendANI . " ko pehle hi " . $sName1 . " refer kiya gaya hai.User response ka intezar hai";
                break;
            case '5':
                $response = "Dear Retailer, " . $sName1 . " par is user ko pehle hi refer kiya gaya hai aur uski request process mein hai";
                break;
            default :
                $response = "Dear Retailer, Customer " . $friendANI . " is in  process to the " . $sName1 . " . Please select any other service";
                break;
        }
        $status = '-1';
        header('Freeflow: FB');
        header('charge: y');
        header('amount:' . $amount);
        header('Expires: -1');
        header('Response:' . $response);
        echo $response;
    }

    $logData = $msisdn . "#" . $serviceId . "#" . $reqtype . "#" . $circle . "#" . $qry . "#Response:Freeflow:FC#" . $response . "#" . date("Y-m-d H:i:s") . "\n";
    error_log($logData, 3, $logPath);
}

mysql_close($dbConn);

exit;
?>   
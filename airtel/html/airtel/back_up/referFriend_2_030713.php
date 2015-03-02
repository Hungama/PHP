<?php

$logPath = "/var/www/html/airtel/logs/airtelService/" . $serviceId . "/log_" . date("Y-m-d") . ".txt";
$logNewPath = "/var/www/html/airtel/logs/airtelService/" . $serviceId . "/reflog_" . date("Y-m-d") . ".txt";
if ($reqtype == 0) {
    header('Path=/airtelSubUnsub');
    header('Content-Type: UTF-8');
    switch ($serviceId) {
        case '1517':
            //$response="Welcome! Please enter customer's 10 digit mobile no.";	
            $response = 'Welcome to Spoken English.' . "\n" . "Reply" . "\n" . "3 for Spoken English (Rs30/15d)" . "\n" . "4 for EU (Rs30/15d)" . "\n" . "5 for SARNAM 
                            (Rs10/7d)" . "\n" . "6 for MND (Rs30/30d)";
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
    error_log($msisdn . "#" . $reqtype . "#" . $circle . "#" . date("Y-m-d H:i:s") . "\n", 3, $logNewPath);
}

if ($reqtype == 3 || $reqtype == 4 || $reqtype == 5 || $reqtype == 6) {
    header('Path=/airtelSubUnsub');
    header('Content-Type: UTF-8');
    switch ($serviceId) {
        case '1517':
            $response = "Welcome! Please enter customer's 10 digit mobile no.";
            switch ($reqtype) {
                case '3':
                    $plan_id1 = 86;
                    $optServiceId = '1517';
                    break;
                case '4':
                    $plan_id1 = 24;
                    $optServiceId = '1501';
                    break;
                case '5':
                    $plan_id1 = 41;
                    $optServiceId = '1515';
                    break;
                case '6':
                    $plan_id1 = 81;
                    $optServiceId = '1513';
                    break;
                default:
                    $plan_id1 = 86;
                    break;
            } 
             $queryF = "INSERT INTO master_db.tbl_refer_ussdData VALUES ('','" . $msisdn . "','NA',NOW(),adddate(NOW(),3),'" . $serviceId . "','Retailer',''," . $plan_id1 . ",'','','','" . $optServiceId . "')";
             mysql_query($queryF);
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
    error_log($msisdn . "#" . $reqtype . "#" . $circle . "#" . date("Y-m-d H:i:s") . "\n", 3, $logNewPath);
}

if ((strlen($reqtype) > 2) && $serviceId == 1517 && $retData) {
    header('Path=/airtelSubUnsub');
    header('Content-Type: UTF-8');
    if ($planid) {
        if (strlen($reqtype) == 10 || strlen($reqtype) == 12) {
            $getPlanId = "select plan_id,optServiceId from master_db.tbl_refer_ussdData where date(referDate)=date(now()) and service_id=1517 and ani=" . $msisdn . " and friendANI='NA' order by id desc limit 1";
            $userPlanId = mysql_query($getPlanId) or die(mysql_error());
            while ($Planrow = mysql_fetch_array($userPlanId)) {
                $userplanId = $Planrow['plan_id'];
                $optServiceId = $Planrow['optServiceId'];
            }
            switch ($userplanId) {
                case '86':
                    $msgText = "30/15 days";
                    break;
                case '87':
                    $msgText = "10/5 days";
                    break;
            }
            switch ($optServiceId) {
                case '1517':
                    $response = "Thank you for referring this customer to Spoken English service(Rs30/15d).";
                    $message = "Aptech certified Spoken English course apke mobile par ghar baithe. Rs 30 for 15 days. Activate karne ke liye reply kare 1 se(Rs30/15d).";
                    $from = "571811";
                    $sndMsgQuery1 = "CALL master_db.SENDSMS('" . $frndMDN . "','" . $message . "','" . $from . "',4,'" . $from . "','RET')";
                    break;
                case '1501':
                    $response = "Thank you for referring this customer to Entertainment Unlimited service(Rs30/15d).";
                    $message = "Paayein Apne pasandida gaane or banayein apni Hello Tunes sirf Entertainment Unlimited par Sirt Rs 30 for 15 days. Abhi subscribe karne ke liye Reply kare 1 se(Rs30/15d).";
                    $from = "571811";
                    $sndMsgQuery1 = "CALL master_db.SENDSMS('" . $frndMDN . "','" . $message . "','" . $from . "',4,'" . $from . "','RET')";
                    break;
                case '1515':
                    $response = "Thank you for referring this customer to SARNAM service(Rs10/7d).";
                    $message = "Sarnam par sune sarv dharm ki bhakti rachnai jitna mann chahe sirf Rs 10 for 7 Days, abhi subscribe karne ke liye reply kare 1 se(Rs10/7d).";
                    $from = "571811";
                    $sndMsgQuery1 = "CALL master_db.SENDSMS('" . $frndMDN . "','" . $message . "','" . $from . "',4,'" . $from . "','RET')";
                    break;
                case '1513':
                    $response = "Thank you for referring this customer to My Naughty diary service(Rs30/30d).";
                    $message = "Sune Shararti naina ki naughty kiss se sirf My naughty diary par, sirt Rs 30 for 30 days ke liye subscribe karne ke liye reply kare 1 se(Rs30/30d).";
                    $from = "571811";
                    $sndMsgQuery1 = "CALL master_db.SENDSMS('" . $frndMDN . "','" . $message . "','" . $from . "',4,'" . $from . "','RET')";
                    break;

                //$response="Your Request to start Spoken English Service has been submitted successfully."; 
            }

            $getCircle1 = "select master_db.getCircle(" . trim($frndMDN) . ") as circle";
            $userCircle2 = mysql_query($getCircle1) or die(mysql_error());
            while ($row = mysql_fetch_array($userCircle2)) {
                $userCircle = $row['circle'];
            }
            if (!$userCircle)
                $userCircle = 'UND';

            //$queryF = "INSERT INTO master_db.tbl_refer_ussdData VALUES ('','".$msisdn."','".$frndMDN."',NOW(),adddate(NOW(),3),'".$serviceId."','Retailer','".$userCircle."');";

            $updateUssdMdn = "update master_db.tbl_refer_ussdData set friendANI=" . $frndMDN . ",userCircle='".$userCircle."' where ANI=" . $msisdn . " and date(referDate)=date(now()) and friendANI='NA' and service_id=1517 and optServiceId = ".$optServiceId." order by id desc limit 1";
            mysql_query($updateUssdMdn);
            mysql_query($sndMsgQuery1);
            header('Freeflow: FB');
        }
        else {
            switch ($serviceId) {
                case '1513':
                    $response = "Please enter valid mobile number.";
                    break;
            }
        }
        header('Freeflow: FB');
        header('charge: y');
        header('amount:' . $amount);
        header('Expires: -1');
        header('Response:' . $response);
        echo $response;
        $logData = $msisdn . "#" . $frndMDN . "#" . $planid . "#" . $serviceId . "#" . $reqtype . "#" . $circle . "#" . $qry . "#Response:Freeflow:FB#" . $response . "#" . $sndMsgQuery1 . "#" . $message . "#" . date("Y-m-d H:i:s") . "\n";
        error_log($logData, 3, $logPath);
        error_log($msisdn . "#" . $reqtype . "#" . $circle . "#" . date("Y-m-d H:i:s") . "\n", 3, $logNewPath);
    }
}

if ($reqtype == '2') {
    header('Path=/airtelSubUnsub');
    header('Content-Type: UTF-8');
    switch ($serviceId) {
        case '1515': $response = "Enter 10 digit number of your friend";
            header('Menu code:' . $response);
            break;
        case '1513': $response = "Enter 10 digit number of your friend";
            header('Menu code:' . $response);
            break;
    }
    header('Freeflow: FC');
    header('charge: y');
    header('amount:30');
    header('Expires: -1');
    echo $response;
    $logData = $msisdn . "#" . $serviceId . "#" . $reqtype . "#" . $circle . "#" . $qry . "#Response:Freeflow:FC#" . $response . "#" . date("Y-m-d H:i:s") . "\n";
    error_log($logData, 3, $logPath);
    if ($serviceId == '1517' || $serviceId == '1514')
        error_log($msisdn . "#" . $reqtype . "#" . $circle . "#" . date("Y-m-d H:i:s") . "\n", 3, $logNewPath);
}
mysql_close($dbConn);

exit;
?>   
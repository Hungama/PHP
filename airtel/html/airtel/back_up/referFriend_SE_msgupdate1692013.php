<?php
$logPath = "/var/www/html/airtel/logs/airtelService/" . $serviceId . "/log_" . date("Y-m-d") . ".txt";
$logNewPath = "/var/www/html/airtel/logs/airtelService/" . $serviceId . "/reflog_" . date("Y-m-d") . ".txt";
$mode='USSD_Retail';
if ($reqtype == 0) {
    header('Path=/airtelSubUnsub');
    header('Content-Type: UTF-8');
    switch ($serviceId) {
        case '1517':

            $response = "Kripya VAS sewa ka number chunao karein activation ke liye:" . "\n" . "\n" . "3-Spoken English (Aptech)" . "\n" . "4-Entertainment Unlimited" . "\n" . "5-My Naughty Diary";
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

//if ($reqtype == 3 || $reqtype == 4 || $reqtype == 5 || $reqtype == 6) {
if ($reqtype == 3 || $reqtype == 4 || $reqtype == 5) {
    header('Path=/airtelSubUnsub');
    header('Content-Type: UTF-8');
    switch ($serviceId) {
        case '1517':
            $response = "Kripya apne Airtel customer ka 10 digit mobile number enter karein";
            switch ($reqtype) {
                case '3':
                    $plan_id1 = 86;
                    $optServiceId = '1517';
					$amount=30;
                    break;
                case '4':
                    $plan_id1 = 24;
                    $optServiceId = '1501';
					$amount=30;
                    break;
                case '5':
                    $plan_id1 = 51;
                    $optServiceId = '1513';
		      $amount=30;
                    break;
                default:
                    $plan_id1 = 86;
					$amount=30;
                    break;
            }
            $queryF = "INSERT INTO master_db.tbl_refer_ussdData VALUES ('','" . $msisdn . "','NA',NOW(),adddate(NOW(),3),'" . $serviceId . "','Retailer',''," . $plan_id1 . ",'','','','" . $optServiceId . "','')";
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
					$amount=10;
                    break;
            }
            switch ($optServiceId) {
                case '1517':
					$db="airtel_SPKENG";
					$subscriptionTable="tbl_spkeng_subscription";
					$subscriptionProcedure="JBOX_SUB";
					$unSubscriptionProcedure="JBOX_UNSUB";
					$unSubscriptionTable="tbl_spkeng_unsub";
					$lang='01';	
					$sc='571811';			
					$s_id='1517';
					$response = "Aapki Spoken English activation request customer ko jaldi bhej diya jayega. Activation hone ke baad aapko SMS se suchit kiya jayega.";
					$sName1="Spoken English";
				break;
                case '1501':
					$sc='546469';
					$s_id='1501';
					$db="airtel_radio";
					$subscriptionTable="tbl_radio_subscription";
					$subscriptionProcedure="RADIO_SUB";
					$unSubscriptionProcedure="RADIO_UNSUB";
					$unSubscriptionTable="tbl_radio_unsub";
					$lang='01';
                    $response = "Aapki Entertainment Unlimited activation request customer ko jaldi bhej diya jayega. Activation hone ke baad aapko SMS se suchit kiya jayega.";
					$sName1="Entertainment Unlimited";
                    break;
				case '1513':
					$sc='5500196';
					$s_id='1513';
					$db="airtel_mnd";
					$lang='01';
					$subscriptionTable="tbl_character_subscription1";
					$subscriptionProcedure="MND_SUB";
					$unSubscriptionProcedure="MND_UNSUB";
					$unSubscriptionTable="tbl_character_unsub1";
					$response = "Aapki My Naughty Diary activation request customer ko jaldi bhej diya jayega. Activation hone ke baad aapko SMS se suchit kiya jayega.";
					$sName1="My Naughty Diary";
					break;
				}

			// added by Athar on 23rd July 2013 to iditenfied duplicate entry

			
			$getOldRecord = "select plan_id,optServiceId from master_db.tbl_refer_ussdData where date(referDate)=date(now()) and service_id=1517 and friendANI=".$frndMDN." and optServiceId=".$optServiceId." and status=0 order by id desc limit 1";
            		$userOldRecord = mysql_query($getOldRecord) or die(mysql_error());
			$Planrow12 = mysql_fetch_array($userOldRecord);
			$userplanId12 = $Planrow12['plan_id'];
			if($userplanId12)
				$status='-1';
			else
				$status='0';

			// End code added by Athar on 23rd July 2013 to iditenfied duplicate entry

			$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$frndMDN' and status=1";
			$qry1=mysql_query($sub);
			$rows1 = mysql_fetch_row($qry1);	
			if($rows1[0]<=0) 
			{
				$qry="call ".$db.".". $subscriptionProcedure." ('".$frndMDN."','".$lang."','".$mode."','".$sc."','".$amount."',".$optServiceId.",".$userplanId.")";
				$qry1=mysql_query($qry) or die( mysql_error() );					
				$status='5';

			}
			else
			{
				$response = "Dear Retailer, Customer ".$frndMDN." is already subscribe to the ".$sName1." . Please select any other service";
				$status='-1';
			}
		   
		    $getCircle1 = "select master_db.getCircle(" . trim($frndMDN) . ") as circle";
            $userCircle2 = mysql_query($getCircle1) or die(mysql_error());
            while ($row = mysql_fetch_array($userCircle2)) {
                $userCircle = $row['circle'];
            }
            if (!$userCircle)
                $userCircle = 'UND';

            $updateUssdMdn = "update master_db.tbl_refer_ussdData set friendANI=" . $frndMDN . ",userCircle='" . $userCircle . "',status= ". $status ." where ANI=" . $msisdn . " and date(referDate)=date(now()) and friendANI='NA' and service_id=1517 and optServiceId = " . $optServiceId . " order by id desc limit 1";
            mysql_query($updateUssdMdn);
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
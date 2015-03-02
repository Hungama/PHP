<?php
$dbConn = mysql_connect("192.168.100.224", "webcc", "webcc");
//check for status ready to upload  
echo $query123="select file_name,service_id,trim(upload_for) as upload_for,price_point,batch_id from master_db.bulk_upload_history where status=0 and channel='TC' and total_file_count<=20000 and service_id like '10%' limit 1";
$checkfiletoprocess = mysql_query($query123, $dbConn);
$notorestore = mysql_num_rows($checkfiletoprocess);
$logDir = "/var/www/html/docomo/logs/docomo/active_ccg/";
$curdate = date("Ymd");
$logPath2 = $logDir . "docomo_active_ccg_" . $curdate . ".txt";
if ($notorestore == 0) {
    $logData = 'No file to process' . "\n\r";
    echo $logData;
  //  error_log($logData, 3, $logPath2);
    mysql_close($dbConn);
    exit;
} else {
    $logPath = "/var/www/html/kmis/services/hungamacare/bulkuploads/";
    $row_file_info = mysql_fetch_array($checkfiletoprocess);
    $filename = $row_file_info['file_name'];
    $planid = $row_file_info['price_point'];
    $service_id = $row_file_info['service_id'];
    $upload_for = $row_file_info['upload_for'];
    $batch_id = $row_file_info['batch_id'];
    $update_bulk_history = "update master_db.bulk_upload_history set status=1 where batch_id=$batch_id and service_id=" . $service_id;
    $bulk_update_result = mysql_query($update_bulk_history, $dbConn) or die(mysql_error());
//$filepath=$logPath.$serviceid.'/'.$file.".txt";
    if ($upload_for == 'active') {
//192.168.100.212
        $file_to_read = "http://192.168.100.212/kmis/services/hungamacare/bulkuploads/" . $service_id . "/" . $filename . ".txt";
        $file_data = file($file_to_read);
        $file_size = sizeof($file_data);

        switch ($planid) {
			case '1':
                $dbname = "docomo_radio";
                $sc = '59090';
				$subscriptionProcedure = "RADIO_SUB";
                $planid = 1;
                $lang = '01';
                $productID = 'GSMENDLESSDAILY2';
                break;
			case '2':
                $dbname = "docomo_radio";
                $sc = '590907';
		  $subscriptionProcedure = "RADIO_SUB";
                $planid = 2;
                $lang = '01';
                $productID = 'GSMENDLESSWEEKLY14';
                break;
            case '3':
                $dbname = "docomo_radio";
                $sc = '590906';
				$subscriptionProcedure = "RADIO_SUB";
                $planid = 3;
                $lang = '01';
                $productID = 'GSMENDLESSMONTHLY60';
                break;
			case '12':
                $dbname = "docomo_radio";
                $sc = '590909';
				$subscriptionProcedure = "RADIO_SUB";
                $planid = 12;
                $lang = '01';
                $productID = 'GSMENDLESS10';
                break;
			case '46':
                $dbname = "docomo_radio";
                $sc = '5909060';
				$subscriptionProcedure = "RADIO_SUB";
                $planid = 46;
                $lang = '01';
                $productID = 'GSMENDLESS45';
                break;
			case '44':
                $dbname = "docomo_radio";
                $sc = '5909075';
				$subscriptionProcedure = "RADIO_SUB";
                $planid = 44;
                $lang = '01';
                $productID = 'GSMENDLESS75';
                break;
			case '14':
                $dbname = "docomo_radio";
                $sc = '5909030';
				$subscriptionProcedure = "RADIO_SUB";
                $planid = 14;
                $lang = '01';
                $productID = 'ENDLESS30';
                break;
			case '88':
                $dbname = "docomo_radio";
                $sc = '5909011';
				$subscriptionProcedure = "RADIO_SUB";
                $planid = 88;
                $lang = '01';
                $productID = 'ENDLESS01';
                break;				
		  case '99':
                $dbname = "docomo_manchala";
                $sc = '5464626';
		  $subscriptionProcedure = "RIYA_SUB";
                $planid = 99;
                $lang = '01';
                $productID = 'GSMENDLESSMONTHLY60';
                break;
		case '154':
                $dbname = "docomo_hungama";
                $sc = '54646';
		$subscriptionProcedure = "JBOX_SUB";
                $planid = 154;
                $lang = '01';
                $productID = 'GSMHMP75';
                break;


        }
        for ($i = 0; $i < $file_size; $i++) {
            $line = trim($file_data[$i]);
            $details = explode("#", $line);
            $msisdn = $details[0];
            $batch_id = $details[1];
            $service_id = $details[2];
            $plan_id = $details[3];
            $amount = $details[4];
            $mode = $details[5];
            if ($mode == 'TC') {
                $mode1 = 'TELECALL';
            }
            $upload_for = $details[7];
            $transId = date('YmdHis');
            echo $call = "call " . $dbname . "." . $subscriptionProcedure . "('$msisdn','$lang','$mode','$sc','$amount',$service_id,$planid,'$transId')";
            echo "<br/>";
            sleep(1);
            $qry1 = mysql_query($call) or die(mysql_error());
	    $pVal=$amount;
            $pPrice=$amount*100;
            echo $url = "http://182.156.191.80:8091/API/CCG?MSISDN=$msisdn&productID=$productID&pName=Endlessmusic&reqMode=$mode1&reqType=SUBSCRIPTION&ismID=16&transID=$transId&pPrice=$pPrice&pVal=$pVal&CpId=hug&CpName=Hungama&CpPwd=hug@8910";
            $logurl = "#url#" . $url . "#" . date("Y-m-d H:i:s") . "\n";
            error_log($logurl, 3, $logPath2);
	// init curl call here
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            echo $response = curl_exec($ch);
            $logresponse = "#Response#" . $response . "#" . date("Y-m-d H:i:s") . "\n";
            error_log($logresponse, 3, $logPath2);
           
        }
		 $update_bulk_history = "update master_db.bulk_upload_history set status=2 where batch_id=$batch_id and service_id=" . $service_id;
            $bulk_update_result = mysql_query($update_bulk_history, $dbConn) or die(mysql_error());
    }

    mysql_close($dbConn);
    exit;
}
?>
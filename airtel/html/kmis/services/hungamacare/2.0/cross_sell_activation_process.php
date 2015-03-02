<?php

$con = mysql_connect("10.2.73.160", "billing", "billing");
if ($con) {
   //echo "<pre>";print_r($_POST);die('here');
        $serviceId = $_POST['service'];
        if ($serviceId == 1507)
            $serviceName = 'VH1';
        elseif ($serviceId == 1503)
            $serviceName = 'MTV';

        $circle = $_POST['circle'];
        $language = $_POST['language'];
        
        $logPath ="/var/www/html/kmis/services/hungamacare/2.0/logs/cross_sell/".date(Ymd).".txt";
        
        $selectQry = "SELECT start_time,end_time FROM airtel_radio.tbl_cross_sell WHERE circle='" . $circle . "' AND service='" . $serviceName . "' and status=1";
        $result = mysql_query($selectQry);
        $result_row = mysql_num_rows($result);
        
        if ($result_row > 0) {
             $time_stamp_array[] = array();
                 while ($details = mysql_fetch_array($result)) {
                    $time_stamp_array[] = $details;
            }
            if ($_POST['timestamp'] && $_POST['timestamp1']) {
                $flag = 1;
                for ($i = 1; $i <= $result_row; $i++) {
                    if ((strtotime($_POST['timestamp']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp']) <= strtotime($time_stamp_array[$i]['end_time'])) || (strtotime($_POST['timestamp1']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp1']) <= strtotime($time_stamp_array[$i]['end_time']))) {
                        $flag = 0;
                    }
                }
                if ($flag == 1) {
                    $InsertQuery = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp1'])) . "', NOW(),1)";
                    mysql_query($InsertQuery);
                    $logData = "Update#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp'] . "#" . $_POST['timestamp1'] . "\n";
                    error_log($logData, 3, $logPath);
                }
            }
            if ($_POST['timestamp2'] && $_POST['timestamp21']) {
                $flag = 1;
                for ($i = 1; $i <= $result_row; $i++) {
                    if ((strtotime($_POST['timestamp2']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp2']) <= strtotime($time_stamp_array[$i]['end_time'])) || (strtotime($_POST['timestamp21']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp21']) <= strtotime($time_stamp_array[$i]['end_time']))) {
                        $flag = 0;
                    }
                }
                if ($flag == 1) {
                    $InsertQuery1 = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp2'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp21'])) . "', NOW(),1)";
                    mysql_query($InsertQuery1);
                    $logData = "Update#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp2'] . "#" . $_POST['timestamp21'] . "\n";
                    error_log($logData, 3, $logPath);
                }
            }
            if ($_POST['timestamp3'] && $_POST['timestamp31']) {
                $flag = 1;
                for ($i = 1; $i <= $result_row; $i++) {
                    if ((strtotime($_POST['timestamp3']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp3']) <= strtotime($time_stamp_array[$i]['end_time'])) || (strtotime($_POST['timestamp31']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp31']) <= strtotime($time_stamp_array[$i]['end_time']))) {
                        $flag = 0;
                    }
                }
                if ($flag == 1) {
                    $InsertQuery2 = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp3'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp31'])) . "', NOW(),1)";
                    mysql_query($InsertQuery2);
                    $logData = "Update#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp3'] . "#" . $_POST['timestamp31'] . "\n";
                    error_log($logData, 3, $logPath);
                }
            }
            if ($_POST['timestamp4'] && $_POST['timestamp41']) {
                $flag = 1;
                for ($i = 1; $i <= $result_row; $i++) {
                    if ((strtotime($_POST['timestamp4']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp4']) <= strtotime($time_stamp_array[$i]['end_time'])) || (strtotime($_POST['timestamp41']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp41']) <= strtotime($time_stamp_array[$i]['end_time']))) {
                        $flag = 0;
                    }
                }
                if ($flag == 1) {
                    $InsertQuery3 = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp4'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp41'])) . "', NOW(),1)";
                    mysql_query($InsertQuery3);
                    $logData = "Update#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp4'] . "#" . $_POST['timestamp41'] . "\n";
                    error_log($logData, 3, $logPath);
                }
            }
            if ($_POST['timestamp5'] && $_POST['timestamp51']) {
                $flag = 1;
                for ($i = 1; $i <= $result_row; $i++) {
                    if ((strtotime($_POST['timestamp5']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp5']) <= strtotime($time_stamp_array[$i]['end_time'])) || (strtotime($_POST['timestamp51']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp51']) <= strtotime($time_stamp_array[$i]['end_time']))) {
                        $flag = 0;
                    }
                }
                if ($flag == 1) {
                    $InsertQuery3 = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp5'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp51'])) . "', NOW(),1)";
                    mysql_query($InsertQuery3);
                    $logData = "Update#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp5'] . "#" . $_POST['timestamp51'] . "\n";
                    error_log($logData, 3, $logPath);
                }
            }
            if ($_POST['timestamp6'] && $_POST['timestamp61']) {
                $flag = 1;
                for ($i = 1; $i <= $result_row; $i++) {
                    if ((strtotime($_POST['timestamp6']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp6']) <= strtotime($time_stamp_array[$i]['end_time'])) || (strtotime($_POST['timestamp61']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp61']) <= strtotime($time_stamp_array[$i]['end_time']))) {
                        $flag = 0;
                    }
                }
                if ($flag == 1) {
                    $InsertQuery3 = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp6'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp61'])) . "', NOW(),1)";
                    mysql_query($InsertQuery3);
                    $logData = "Update#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp6'] . "#" . $_POST['timestamp61'] . "\n";
                    error_log($logData, 3, $logPath);
                }
            }
            if ($_POST['timestamp7'] && $_POST['timestamp71']) {
                $flag = 1;
                for ($i = 1; $i <= $result_row; $i++) {
                    if ((strtotime($_POST['timestamp7']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp7']) <= strtotime($time_stamp_array[$i]['end_time'])) || (strtotime($_POST['timestamp71']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp71']) <= strtotime($time_stamp_array[$i]['end_time']))) {
                        $flag = 0;
                    }
                }
                if ($flag == 1) {
                    $InsertQuery3 = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp7'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp71'])) . "', NOW(),1)";
                    mysql_query($InsertQuery3);
                    $logData = "Update#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp7'] . "#" . $_POST['timestamp71'] . "\n";
                    error_log($logData, 3, $logPath);
                }
            }
        } else {
            if ($_POST['timestamp'] && $_POST['timestamp1']) {
                $InsertQuery = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp1'])) . "', NOW(),1)";
                mysql_query($InsertQuery);
                $logData = "Insert#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp'] . "#" . $_POST['timestamp1'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp2'] && $_POST['timestamp21']) {
                $InsertQuery1 = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp2'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp21'])) . "', NOW(),1)";
                mysql_query($InsertQuery1);
                $logData = "Insert#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp2'] . "#" . $_POST['timestamp21'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp3'] && $_POST['timestamp31']) {
                $InsertQuery2 = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp3'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp31'])) . "', NOW(),1)";
                mysql_query($InsertQuery2);
                $logData = "Insert#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp3'] . "#" . $_POST['timestamp31'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp4'] && $_POST['timestamp41']) {
                $InsertQuery3 = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp4'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp41'])) . "', NOW(),1)";
                mysql_query($InsertQuery3);
                $logData = "Insert#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp4'] . "#" . $_POST['timestamp41'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp5'] && $_POST['timestamp51']) {
                $InsertQuery3 = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp5'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp51'])) . "', NOW(),1)";
                mysql_query($InsertQuery3);
                $logData = "Insert#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp5'] . "#" . $_POST['timestamp51'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp6'] && $_POST['timestamp61']) {
                $InsertQuery3 = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp6'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp61'])) . "', NOW(),1)";
                mysql_query($InsertQuery3);
                $logData = "Insert#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp6'] . "#" . $_POST['timestamp61'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp7'] && $_POST['timestamp71']) {
                $InsertQuery3 = "INSERT INTO airtel_radio.tbl_cross_sell(circle, user_lang, service, start_time,end_time,addon,status) VALUES ('".$circle."','".$language."','".$serviceName."','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp7'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp71'])) . "', NOW(),1)";
                mysql_query($InsertQuery3);
                $logData = "Insert#" . $serviceName . "#" . $circle . "#" . $language . "#" . $_POST['timestamp7'] . "#" . $_POST['timestamp71'] . "\n";
                error_log($logData, 3, $logPath);
            }
        }
        $msg = "Data inserted successfully";
        echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
    
} else {
    echo "Database not connected";
}
exit;
?>
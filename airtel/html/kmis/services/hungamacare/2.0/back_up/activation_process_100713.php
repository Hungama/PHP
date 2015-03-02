<?php

$con = mysql_connect("10.2.73.160", "billing", "billing");
if ($con) {
    foreach ($_POST['circle'] as $key => $circleValue) {
        $serviceId = $_POST['service'];
        if ($serviceId == 1507)
            $serviceName = 'Airtel-VH1';
        elseif ($serviceId == 1518)
            $serviceName = 'Airtel-CMD';
        elseif ($serviceId == 1509)
            $serviceName = 'Airtel-RIA';
        elseif ($serviceId == 1513)
            $serviceName = 'Airtel-MND';
        elseif ($serviceId == 1503)
            $serviceName = 'Airtel-MTV';
        elseif ($serviceId == 1520)
            $serviceName = 'Airtel-PK';
        elseif ($serviceId == 15091)
            $serviceName = 'Airtel-RIA-54646169';
        elseif ($serviceId == 1515)
            $serviceName = 'Airtel-DEVO';
        elseif ($serviceId == 1514)
            $serviceName = 'Airtel-PD';
        elseif ($serviceId == 1517)
            $serviceName = 'Airtel-SE';
        elseif ($serviceId == 1502)
            $serviceName = 'Airtel-54646';
        elseif ($serviceId == 1501)
            $serviceName = 'Airtel-EU';
        elseif ($serviceId == 1511)
            $serviceName = 'Airtel-GL';
        elseif ($serviceId == 1522)
            $serviceName = 'Airtel-REG TN/KK';
        elseif ($serviceId == 15020) {
            $serviceId = 1502;
            $serviceName = 'Hungama Entertainment portal - 546460';
        } elseif ($serviceId == 15022) {
            $serviceId = 1502;
            $serviceName = 'Luv Guru - 546462';
        } elseif ($serviceId == 15023) {
            $serviceId = 1502;
            $serviceName = 'Music World - 546463';
        } elseif ($serviceId == 15031) {
            $serviceId = 1503;
            $serviceName = 'MTV DJ Dial - 546461';
        }
        $selectQuery = "SELECT id FROM master_db.tbl_doubleconsent WHERE circle='" . $circleValue . "' AND shortCode='" . $_POST['Scode'] . "' AND servicename='" . $serviceName . "' and service_id='" . $serviceId . "' LIMIT 1";
        $queryIns = mysql_query($selectQuery);
        list($id) = mysql_fetch_row($queryIns);
        if ($id) {
            $Query = "UPDATE master_db.tbl_doubleconsent SET addon=NOW() where circle='" . $circleValue . "' and shortCode='" . $_POST['Scode'] . "' and servicename='" . $serviceName . "' and service_id='" . $serviceId . "'";
            $queryIns = mysql_query($Query);
            $selectQry = "SELECT start_time,end_time FROM master_db.tbl_doubleconsent_time WHERE sId='" . $id . "'";
            $result = mysql_query($selectQry);
            $result_row = mysql_num_rows($result);
            $time_stamp_array[] = array();
            if ($result_row > 0) {
                while ($details = mysql_fetch_array($result)) {
                    $time_stamp_array[] = $details;
                }
            }
            if ($_POST['timestamp'] && $_POST['timestamp1']) {
//                $delQuery = "DELETE FROM master_db.tbl_doubleconsent_time WHERE sId='" . $id . "'";
//                mysql_query($delQuery);
                $flag = 1;
                for ($i = 1; $i <= $result_row; $i++) {
                     if ((strtotime($_POST['timestamp']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp']) <= strtotime($time_stamp_array[$i]['end_time'])) || (strtotime($_POST['timestamp1']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp1']) <= strtotime($time_stamp_array[$i]['end_time']))) {
                        $flag = 0;
                    }
                }
                if ($flag == 1) {
                    $InsertQuery = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp1'])) . "', NOW())";
                    mysql_query($InsertQuery);
                    $logData = "Update#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp'] . "#" . $_POST['timestamp1'] . "\n";
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
                    $InsertQuery1 = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp2'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp21'])) . "', NOW())";
                    mysql_query($InsertQuery1);
                    $logData = "Update#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp2'] . "#" . $_POST['timestamp21'] . "\n";
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
                    $InsertQuery2 = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp3'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp31'])) . "', NOW())";
                    mysql_query($InsertQuery2);
                    $logData = "Update#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp3'] . "#" . $_POST['timestamp31'] . "\n";
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
                    $InsertQuery3 = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp4'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp41'])) . "', NOW())";
                    mysql_query($InsertQuery3);
                    $logData = "Update#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp4'] . "#" . $_POST['timestamp41'] . "\n";
                    error_log($logData, 3, $logPath);
                }
            }
        } else {
            $Query = "Insert into master_db.tbl_doubleconsent values('','" . $serviceName . "','" . $serviceId . "','" . $circleValue . "',NOW(),'" . $_POST['Scode'] . "')";
            $queryIns = mysql_query($Query);
            $insertID = mysql_insert_id();
            if ($_POST['timestamp'] && $_POST['timestamp1']) {
                $InsertQuery = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp1'])) . "', NOW())";
                mysql_query($InsertQuery);
                $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp'] . "#" . $_POST['timestamp1'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp2'] && $_POST['timestamp21']) {
                $InsertQuery1 = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp2'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp21'])) . "', NOW())";
                mysql_query($InsertQuery1);
                $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp2'] . "#" . $_POST['timestamp21'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp3'] && $_POST['timestamp31']) {
                $InsertQuery2 = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp3'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp31'])) . "', NOW())";
                mysql_query($InsertQuery2);
                $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp3'] . "#" . $_POST['timestamp31'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp4'] && $_POST['timestamp41']) {
                $InsertQuery3 = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp4'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp41'])) . "', NOW())";
                mysql_query($InsertQuery3);
                $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp4'] . "#" . $_POST['timestamp41'] . "\n";
                error_log($logData, 3, $logPath);
            }
        }
        $msg = "Data inserted successfully";
echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";	
    }
} else {
    echo "Database not connected";
}
exit;
?>
<?php

require_once("incs/db.php");
if ($dbConn) {
    foreach ($_POST['circle'] as $key => $circleValue) {
        $serviceId = $_POST['service'];
        if ($serviceId == 1301)
            $serviceName = 'VodafoneMU';
        
        $curdate = date("Ymd");
        $logPath = "/var/www/html/hungamacare/2.0/logs/switch_control/" . $curdate . ".txt";

        $selectQuery = "SELECT id FROM Vodafone_IVR.tbl_doubleconsent WHERE circle='" . $circleValue . "' AND shortCode='" . $_POST['Scode'] . "' AND servicename='" . $serviceName . "' and service_id='" . $serviceId . "' LIMIT 1";
        $queryIns = mysql_query($selectQuery);
        list($id) = mysql_fetch_row($queryIns);
        if ($id) {
            $Query = "UPDATE Vodafone_IVR.tbl_doubleconsent SET addon=NOW() where circle='" . $circleValue . "' and shortCode='" . $_POST['Scode'] . "' and servicename='" . $serviceName . "' and service_id='" . $serviceId . "'";
            $queryupdate = mysql_query($Query);
            $selectQry = "SELECT start_time,end_time FROM Vodafone_IVR.tbl_doubleconsent_time WHERE sId='" . $id . "' and status=1";
            $result = mysql_query($selectQry);
            $result_row = mysql_num_rows($result);
            $time_stamp_array[] = array();
            if ($result_row > 0) {
                while ($details = mysql_fetch_array($result)) {
                    $time_stamp_array[] = $details;
                }
            }
            if ($_POST['timestamp'] && $_POST['timestamp1']) {
                $flag = 1;
                for ($i = 1; $i <= $result_row; $i++) {
                    if ((strtotime($_POST['timestamp']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp']) <= strtotime($time_stamp_array[$i]['end_time'])) || (strtotime($_POST['timestamp1']) >= strtotime($time_stamp_array[$i]['start_time']) && strtotime($_POST['timestamp1']) <= strtotime($time_stamp_array[$i]['end_time']))) {
                        $flag = 0;
                    }
                }
                if ($flag == 1) {
                    $InsertQuery = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp1'])) . "', NOW()," . $_POST['switchtype'] . ")";
                    mysql_query($InsertQuery);
                    $logData = "InsertForExistService#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp'] . "#" . $_POST['timestamp1'] . "\n";
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
                    $InsertQuery1 = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp2'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp21'])) . "', NOW()," . $_POST['switchtype'] . ")";
                    mysql_query($InsertQuery1);
                    $logData = "InsertForExistService#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp2'] . "#" . $_POST['timestamp21'] . "\n";
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
                    $InsertQuery2 = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp3'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp31'])) . "', NOW()," . $_POST['switchtype'] . ")";
                    mysql_query($InsertQuery2);
                    $logData = "InsertForExistService#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp3'] . "#" . $_POST['timestamp31'] . "\n";
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
                    $InsertQuery3 = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp4'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp41'])) . "', NOW()," . $_POST['switchtype'] . ")";
                    mysql_query($InsertQuery3);
                    $logData = "InsertForExistService#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp4'] . "#" . $_POST['timestamp41'] . "\n";
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
                    $InsertQuery3 = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp5'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp51'])) . "', NOW()," . $_POST['switchtype'] . ")";
                    mysql_query($InsertQuery3);
                    $logData = "InsertForExistService#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp5'] . "#" . $_POST['timestamp51'] . "\n";
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
                    $InsertQuery3 = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp6'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp61'])) . "', NOW()," . $_POST['switchtype'] . ")";
                    mysql_query($InsertQuery3);
                    $logData = "InsertForExistService#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp6'] . "#" . $_POST['timestamp61'] . "\n";
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
                    $InsertQuery3 = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp7'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp71'])) . "', NOW()," . $_POST['switchtype'] . ")";
                    mysql_query($InsertQuery3);
                    $logData = "InsertForExistService#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp7'] . "#" . $_POST['timestamp71'] . "\n";
                    error_log($logData, 3, $logPath);
                }
            }
        } else {
            $Query = "Insert into Vodafone_IVR.tbl_doubleconsent values('','" . $serviceName . "','" . $serviceId . "','" . $circleValue . "',NOW(),'" . $_POST['Scode'] . "')";
            $queryIns = mysql_query($Query);
            $insertID = mysql_insert_id();
            if ($_POST['timestamp'] && $_POST['timestamp1']) {
                $InsertQuery = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp1'])) . "', NOW()," . $_POST['switchtype'] . ")";
                mysql_query($InsertQuery);
                $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp'] . "#" . $_POST['timestamp1'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp2'] && $_POST['timestamp21']) {
                $InsertQuery1 = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp2'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp21'])) . "', NOW()," . $_POST['switchtype'] . ")";
                mysql_query($InsertQuery1);
                $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp2'] . "#" . $_POST['timestamp21'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp3'] && $_POST['timestamp31']) {
                $InsertQuery2 = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp3'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp31'])) . "', NOW()," . $_POST['switchtype'] . ")";
                mysql_query($InsertQuery2);
                $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp3'] . "#" . $_POST['timestamp31'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp4'] && $_POST['timestamp41']) {
                $InsertQuery3 = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp4'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp41'])) . "', NOW()," . $_POST['switchtype'] . ")";
                mysql_query($InsertQuery3);
                $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp4'] . "#" . $_POST['timestamp41'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp5'] && $_POST['timestamp51']) {
                $InsertQuery3 = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp5'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp51'])) . "', NOW()," . $_POST['switchtype'] . ")";
                mysql_query($InsertQuery3);
                $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp5'] . "#" . $_POST['timestamp51'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp6'] && $_POST['timestamp61']) {
                $InsertQuery3 = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp6'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp61'])) . "', NOW()," . $_POST['switchtype'] . ")";
                mysql_query($InsertQuery3);
                $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp6'] . "#" . $_POST['timestamp61'] . "\n";
                error_log($logData, 3, $logPath);
            }
            if ($_POST['timestamp7'] && $_POST['timestamp71']) {
                $InsertQuery3 = "INSERT INTO Vodafone_IVR.tbl_doubleconsent_time(sId, start_time, end_time, addon,switchtype) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp7'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp71'])) . "', NOW()," . $_POST['switchtype'] . ")";
                mysql_query($InsertQuery3);
                $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp7'] . "#" . $_POST['timestamp71'] . "\n";
                error_log($logData, 3, $logPath);
            }
        }
    }
    if ($queryupdate == 1 || ($insertID != 0 && $insertID != '')) {
        $msg = "Data inserted successfully";
    } else {
        $msg = "Data not inserted successfully";
    }
    echo "<div width=\"85%\" align=\"left\" class=\"txt\">
<div class=\"alert alert-success\">$msg</div></div>";
} else {
    echo "Database not connected";
}
exit;
?>
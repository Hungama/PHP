<?php
           $con = mysql_connect("10.2.73.160", "billing", "billing");
if($con){
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

                echo $selectQuery = "SELECT id FROM master_db.tbl_doubleconsent WHERE circle='" . $circleValue . "' AND shortCode='" . $_POST['Scode'] . "' AND servicename='" . $serviceName . "' and service_id='" . $serviceId . "' LIMIT 1";
                //$queryIns = mysql_query($selectQuery);
                list($id) = mysql_fetch_row($queryIns);
                if ($id) {
                    echo $Query = "UPDATE master_db.tbl_doubleconsent SET addon=NOW() where circle='" . $circleValue . "' and shortCode='" . $_POST['Scode'] . "' and servicename='" . $serviceName . "' and service_id='" . $serviceId . "'";
                    //$queryIns = mysql_query($Query);
                    if ($_POST['timestamp'] && $_POST['timestamp1']) {
                        $delQuery = "DELETE FROM master_db.tbl_doubleconsent_time WHERE sId='" . $id . "'";
                        //mysql_query($delQuery);
                        echo $InsertQuery = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp1'])) . "', NOW())";
                        //mysql_query($InsertQuery);
                        $logData = "Update#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp'] . "#" . $_POST['timestamp1'] . "\n";
                        error_log($logData, 3, $logPath);
                    }
                    if ($_POST['timestamp2'] && $_POST['timestamp21']) {
                        echo $InsertQuery1 = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp2'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp21'])) . "', NOW())";
                        //mysql_query($InsertQuery1);
                        $logData = "Update#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp2'] . "#" . $_POST['timestamp21'] . "\n";
                        error_log($logData, 3, $logPath);
                    }
                    if ($_POST['timestamp3'] && $_POST['timestamp31']) {
                        echo $InsertQuery2 = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp3'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp31'])) . "', NOW())";
                        //mysql_query($InsertQuery2);
                        $logData = "Update#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp3'] . "#" . $_POST['timestamp31'] . "\n";
                        error_log($logData, 3, $logPath);
                    }
                    if ($_POST['timestamp4'] && $_POST['timestamp41']) {
                        echo $InsertQuery3 = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $id . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp4'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp41'])) . "', NOW())";
                        //mysql_query($InsertQuery3);
                        $logData = "Update#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp4'] . "#" . $_POST['timestamp41'] . "\n";
                        error_log($logData, 3, $logPath);
                    }
                } else {
                    echo $Query = "Insert into master_db.tbl_doubleconsent values('','" . $serviceName . "','" . $serviceId . "','" . $circleValue . "',NOW(),'" . $_POST['Scode'] . "')";
                    //$queryIns = mysql_query($Query);
                    $insertID = mysql_insert_id();
                    if ($_POST['timestamp'] && $_POST['timestamp1']) {
                        echo $InsertQuery = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp1'])) . "', NOW())";
                        //mysql_query($InsertQuery);
                        $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp'] . "#" . $_POST['timestamp1'] . "\n";
                        error_log($logData, 3, $logPath);
                    }
                    if ($_POST['timestamp2'] && $_POST['timestamp21']) {
                        echo $InsertQuery1 = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp2'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp21'])) . "', NOW())";
                        //mysql_query($InsertQuery1);
                        $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp2'] . "#" . $_POST['timestamp21'] . "\n";
                        error_log($logData, 3, $logPath);
                    }
                    if ($_POST['timestamp3'] && $_POST['timestamp31']) {
                        echo $InsertQuery2 = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp3'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp31'])) . "', NOW())";
                        //mysql_query($InsertQuery2);
                        $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp3'] . "#" . $_POST['timestamp31'] . "\n";
                        error_log($logData, 3, $logPath);
                    }
                    if ($_POST['timestamp4'] && $_POST['timestamp41']) {
                        echo $InsertQuery3 = "INSERT INTO master_db.tbl_doubleconsent_time(sId, start_time, end_time, addon) VALUES (" . $insertID . ",'" . date("Y-m-d H:i:s", strtotime($_POST['timestamp4'])) . "','" . date("Y-m-d H:i:s", strtotime($_POST['timestamp41'])) . "', NOW())";
                        //mysql_query($InsertQuery3);
                        $logData = "Insert#" . $serviceName . "#" . $circleValue . "#" . $_POST['Scode'] . "#" . $_POST['timestamp4'] . "#" . $_POST['timestamp41'] . "\n";
                        error_log($logData, 3, $logPath);
                    }
                }
            }
        }else{
            echo "Database not connected";
        }
        exit;
        ?>
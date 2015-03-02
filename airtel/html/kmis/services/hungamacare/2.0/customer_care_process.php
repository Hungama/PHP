<!--Logic will start here -->
<?php
session_start();
ini_set('display_errors', '1');
//set_time_limit(10);
require_once("incs/db.php");
require_once("language.php");
require_once("base.php");
$msisdn = $_REQUEST['msisdn'];
$service_info_array = $_REQUEST['service_info'];
$no_of_servicename = count($service_info_array);
$service_info_duration = $_REQUEST['service_info_duration'];
//echo $msisdn."****".$no_of_servicename."****".$service_info_duration."****".$service_info_array."<br>";
//print_r($service_info_array);
//exit;
$logPath = "/var/www/html/kmis/services/hungamacare/ccInterface/log_" . date("Ymd") . ".txt";
$flag = 0;
$_SESSION['usrId'] = $_REQUEST['usrId'];
if ($_POST['Submit'] == "Submit") {
    if ($service_info_array[0] == '' || $service_info_duration == 0 || $msisdn == '') {
        echo "<div class='alert alert-block'><h4>Ooops!</h4>Either mobile number or service left blank.</div> ";
        exit;
    }
    ?>
    <div width="85%" align="left" class="txt"> 
    </div>
    <div id="result-table">
        <div id="alert-success" class="alert alert"><?php echo CC_SEARCH_INFO . $msisdn; ?></div>
        <TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="table table-condensed table-bordered" >

            <TR height="30">
                <TD><B><?php echo TH_ANI; ?></B></TD>
                <TD><B><?php echo TH_STATUS; ?></B></TD>
                <TD><B><?php echo TH_REGISTRATION_ID; ?></B></TD>
                <TD><B><?php echo TH_SERVICENAME; ?></B></TD>
                <TD><B>Activation</B></TD>
                <TD><B><?php echo TH_NEXT_CHARGING; ?></B></TD>
                <TD><B><?php echo TH_LAST_CHARGING; ?></B></TD>
                <TD><B><?php echo TH_CHARGED_AMT; ?></B></TD>
                <TD><B><?php echo TH_CIRCLE; ?></B></TD>
                <TD><B><?php echo TH_MODE; ?></B></TD>
            </TR>

            <?php
            for ($i = 0; $i <= $no_of_servicename; $i++) {
                $service_info = trim($service_info_array[$i]);
                if (empty($service_info)) {
                    exit;
                }
                $service_info_clubed = $service_info;
                if ($service_info == 1509)
                    $service_info_clubed = 1511;
                elseif ($service_info == 1504)
                    $service_info_clubed = 1511;
                elseif ($service_info == 15071)
                    $service_info_clubed = 1507;
                elseif ($service_info == 15221 || $service_info == 15222)
                    $service_info_clubed = 1522;
                elseif ($service_info == 15211 || $service_info == 15212 || $service_info == 15213)
                    $service_info_clubed = 1521;
                elseif ($service_info == 15151)
                    $service_info_clubed = 1515;

                $serviceQuery = mysql_query("select servicename from master_db.tbl_app_service_master where serviceid=" . $service_info);
                list($logServiceName) = mysql_fetch_array($serviceQuery, $dbConn);


                $logData = $msisdn . "#" . $service_info . "#" . $_SESSION['loginId'] . "#" . 'Search' . "\n";
                error_log($logData, 3, $logPath);


                //$planDataResult = mysql_query("SELECT Plan_id from master_db.tbl_plan_bank WHERE sname='".$service_info."'",$dbConn);
                //echo "SELECT Plan_id from master_db.tbl_plan_bank WHERE S_id='".$service_info_clubed."' and sname='".$service_info."'";
                if ($service_info == 15222) {
                    $s_info = 1522;
                    $chk_service = 15222;
                } else {
                    $chk_service = '';
                    $s_info = $service_info;
                }
                $planDataResult = mysql_query("SELECT Plan_id from master_db.tbl_plan_bank WHERE S_id='" . $service_info_clubed . "' and sname='" . $s_info . "'", $dbConn);
                while ($row = mysql_fetch_array($planDataResult)) {
                    $planData[] = $row['Plan_id'];
                }

                if ($service_info == 15151) {
                    $service_info = 1515;
                } else if ($service_info == 15222) {
                    $service_info = 1522;
                }
                $select_query2_main = "( select msisdn, response_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success nolock where service_id=" . $service_info . " and msisdn='$msisdn' and plan_id IN (" . implode(",", $planData) . "))";

                $select_query2_bak = "(select msisdn, response_time, chrg_amount,circle,plan_id from master_db.tbl_billing_success_backup nolock where service_id=" . $service_info . " and msisdn='$msisdn' and plan_id IN (" . implode(",", $planData) . ") )";


                if ($service_info_duration == 1) {
                    $select_query2 = $select_query2_main . " UNION " . $select_query2_bak . " order by response_time desc limit 1 ";
                } else if ($service_info_duration == 2) {
                    $select_query2 = $select_query2_main . " order by response_time desc limit 1 ";
                } else {
                    echo "<div class='alert alert-block'><h4>Ooops!</h4>Please select data period.</div> ";
                    exit;
                }
                //echo $select_query2."<br>";
                //exit;

                $query = mysql_query($select_query2, $dbConn) or die(mysql_error());
                $numRows = mysql_num_rows($query);
                if ($numRows > 0) {
                    if ($service_info == '15211' || $service_info == '15212' || $service_info == '15213')
                        $select_query1 = "select SUB_DATE, RENEW_DATE, circle, SUB_MODE, DNIS, STATUS from ";
                    else
                        $select_query1 = "select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS from ";
                    switch ($service_info) {
                        case '1501':
                            $select_query1.= "airtel_radio.tbl_radio_subscription";
                            break;
                        case '1502':
                            $select_query1.= "airtel_hungama.tbl_jbox_subscription";
                            break;
                        case '1518':
                            $select_query1.= "airtel_hungama.tbl_comedyportal_subscription";
                            break;
                        case '1503':
                            $select_query1.= "airtel_hungama.tbl_mtv_subscription";
                            break;
                        case '1507':
                            $select_query1.= "airtel_vh1.tbl_jbox_subscription";
                            break;
                        case '1511':
                            $select_query1.= " airtel_rasoi.tbl_rasoi_subscription";
                            break;
                        case '1509':
                            $select_query1.= " airtel_manchala.tbl_riya_subscription";
                            break;
                        case '1514':
                            $select_query1.= " airtel_EDU.tbl_jbox_subscription";
                            break;
                        case '1513':
                            $select_query1.= " airtel_mnd.tbl_character_subscription1";
                            break;
                        case '1504':
                            $select_query1.= " airtel_rasoi.tbl_storeatone_subscription";
                            break;
                        case '15071':
                            $select_query1.= "airtel_vh1.tbl_vh1nightpack_subscription";
                            break;
                        case '1515':
                            $select_query1.= "airtel_devo.tbl_devo_subscription";
                            break;
                        case '1517':
                            $select_query1.= "airtel_SPKENG.tbl_spkeng_subscription";
                            break;
                        case '1520':
                            $select_query1.= "airtel_hungama.tbl_pk_subscription";
                            break;
                        case '1522':
                        case '15221':
                        case '15222':
                            $select_query1.= "airtel_hungama.tbl_arm_subscription";
                            break;
                        case '15211':
                            $select_query1.= "airtel_smspack.TBL_ASTRO_SUBSCRIPTION";
                            break;
                        case '15212':
                            $select_query1.= "airtel_smspack.TBL_SEXEDU_SUBSCRIPTION";
                            break;
                        case '15213':
                            $select_query1.= "airtel_smspack.TBL_VASTU_SUBSCRIPTION";
                            break;
                        case '1523':
                            $select_query1.= "airtel_TINTUMON.tbl_TINTUMON_subscription";
                            break;
						case '1527':
                            $select_query1.= "airtel_rasoi.tbl_rasoi_subscriptionWAP";
                            break;
                    }

                    $select_query1.=" where ANI='$msisdn' and status=1";
                    $select_query1.=" and plan_id IN (" . implode(",", $planData) . ")";

                    $select_query1.="  order by SUB_DATE desc limit 1";
                    //echo $select_query1;
                    $querySubscription = mysql_query($select_query1, $dbConn) or die(mysql_error($dbConn));
                    $num = mysql_num_rows($querySubscription);
                    ?>

                    <?php
                    //actual service name code start here 
//	$servicename=$serviceNameArray[$service_info];

                    $sname_ks = array_flip($serviceArray);
                    $servicename = $Service_DESC[$sname_ks[$service_info]]['Name'];
                    if (in_array("90", $planData) || in_array("91", $planData)) {
                        $servicename = 'Airtel - Noor-E-Khuda';
                    }

                    $subStatus = -1;
                    $RENEW_DATE = "";
                    list($msisdn, $response_time, $chrg_amount, $circle, $plan_id) = mysql_fetch_array($query);
                    list($SUB_DATE, $RENEW_DATE, $circle1, $MODE_OF_SUB, $DNIS, $subStatus) = mysql_fetch_array($querySubscription);
                    ?>
                    <TR height="30">
                        <TD bgcolor="#FFFFFF" align="center"><?php echo $msisdn; ?></TD>
                        <TD bgcolor="#FFFFFF" align="center">

                            <?php
                            if ($subStatus == '0') {
                                ?>
                                <span class="label label-warning">
                                    <?php
                                    echo STATUS_0;
                                } else if ($subStatus == '1') {
                                    ?>
                                    <span class="label label-success">
                                        <?php
                                        echo STATUS_1;
                                    } else if ($subStatus == '11') {
                                        ?>
                                        <span class="label label-info">
                                            <?php
                                            echo STATUS_11;
                                        } else if ($subStatus == '5') {
                                            ?>
                                            <span class="label label-info">
                                                <?php
                                                echo STATUS_5;
                                            }
                                            ?></span>

                                        </TD>
                                        <TD><?php
                                if (!empty($DNIS)) {
                                    echo $DNIS;
                                } else {
                                    echo '-';
                                }
                                            ?></TD>
                                        <TD><?php
                                //echo $s_info;
                                if ($chk_service == 15222) {
                                    $servicename = 'Airtel Manoranjana pack';
                                }
                                echo $servicename;
                                ?>
                                        </TD>
                                        <TD><?php
                                if (!empty($SUB_DATE)) {
                                    echo date('j-M \'y g:i a', strtotime($SUB_DATE));
                                } else {
                                    echo '-';
                                }
                                ?></TD>
                                        <TD><?php
                                if (!empty($RENEW_DATE)) {
                                    echo date('j-M \'y g:i a', strtotime($RENEW_DATE));
                                } else {
                                    echo '-';
                                }
                                ?></TD>
                                        <TD><?php
                                if (!empty($response_time)) {
                                    echo date('j-M \'y g:i a', strtotime($response_time));
                                } else {
                                    echo '-';
                                }
                                ?></TD>
                                        <TD><?php echo 'Rs. ' . $chrg_amount; ?>&nbsp;</TD>
                                        <TD><?php echo $circle_info[strtoupper($circle)]; ?>&nbsp;</TD>

                                        <TD><?php
                                if (!empty($MODE_OF_SUB)) {
                                    echo $MODE_OF_SUB;
                                } else {
                                    echo '-';
                                }
                                ?></TD>	
                                        <TD border="0" width="24%">
                                            <table border="0"><tr><td style="border: 0">

                                                        <?php if (($subStatus == 1 || $subStatus == 11)) { ?>	
                                                            <button class="btn btn-mini btn-danger" type="button" onclick="do_Act_Deactivate(<?php echo $msisdn; ?>,<?php echo $service_info; ?>,'<?php echo $subsrv; ?>','da','customer_care_process','')" >Deactivate</button>
                                                            <?php
                                                            if ($subStatus == 11)
                                                                echo "(Pending)";
                                                        }
                                                        elseif ($subStatus == 0) {
                                                            echo "Not Active";
                                                        } elseif ($subStatus == '') {
                                                            echo "<button class=\"btn btn-mini btn-danger\" type=\"button\" disabled>Not Active</button>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="border: 0">
                                                        <button class="btn btn-mini btn-info" type="button" onclick="viewbillinghistory(<?php echo $msisdn; ?>,<?php echo $service_info; ?>,'<?php echo $service_info_duration; ?>')">
            <?php echo BTN_LABEL_SUB_HISTORY; ?>
                                                        </button>
                                                    </td>
                                                    <td style="border: 0">
                                                        <button class="btn btn-mini btn-info" type="button"  onclick="viewchargingDetails(<?php echo $msisdn; ?>,<?php echo $service_info; ?>)">
            <?php echo BTN_LABEL_RECHARGE_COUPAN_HISTORY; ?>
                                                        </button>

                                                    </td>

                                                </tr></table>

                                        </TD>


                                        </TR>
                                        <?php
                                        $flag++;
                                    } else {
                                        
                                    }
                                    ?>

                                    <?php
                                }
                                echo '</TABLE></div>';
                                if ($flag == 0) {
                                    echo "<div class='alert alert-block'><h4>Ooops!</h4>No records found for this number.</div> ";
                                    ?>
                                    <script>
                                        document.getElementById('result-table').style.display='none';
                                    </script>
                                    <?php
                                }
                                ?>

                                <?php
//end here 
                            }
//if section end here	
                            elseif ($_GET['msisdn'] != "" && $_GET['act'] == "da") {
                                if ($_GET['service_info'] == 1502)
                                    $Query1 = "call airtel_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1503)
                                    $Query1 = "call airtel_hungama.MTV_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1501)
                                    $Query1 = "call airtel_radio.RADIO_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1507)
                                    $Query1 = "call airtel_vh1.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1511)
                                    $Query1 = "call airtel_rasoi.RASOI_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1509)
                                    $Query1 = "call airtel_manchala.RIYA_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1514)
                                    $Query1 = "call airtel_EDU.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1513)
                                    $Query1 = "call airtel_mnd.MND_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1504)
                                    $Query1 = "call airtel_rasoi.STOREATONE_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 15071)
                                    $Query1 = "call airtel_vh1.NIGHTPACK_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1518)
                                    $Query1 = "call airtel_hungama.COMEDY_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1515 || $_GET['service_info'] == 15151)
                                    $Query1 = "call airtel_devo.devo_unsub('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1517)
                                    $Query1 = "call airtel_SPKENG.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1520)
                                    $Query1 = "call airtel_hungama.PK_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1522 || $_GET['service_info'] == 15221 || $_GET['service_info'] == 15222)
                                    $Query1 = "call airtel_hungama.ARM_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 15211)
                                    $Query1 = "call airtel_smspack.ASTRO_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 15212)
                                    $Query1 = "call airtel_smspack.SEXEDU_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 15213)
                                    $Query1 = "call airtel_smspack.VASTU_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1523)
                                    $Query1 = "call airtel_TINTUMON.TINTUMON_UNSUB('$_GET[msisdn]', 'CC')";
                                elseif ($_GET['service_info'] == 1522 || $_GET['service_info'] == 15221 || $_GET['service_info'] == 15222)
                                    $Query1 = "call airtel_hungama.ARM_UNSUB('$_GET[msisdn]', 'CC')";
								elseif ($_GET['service_info'] == 1527)
                                    $Query1 = "call airtel_rasoi.RASOI_UNSUBWAP('$_GET[msisdn]', 'CC')";
                                //echo $Query1."<br>";
                                $result = mysql_query($Query1, $dbConn) or die(mysql_error());
                                $logData = $_GET['msisdn'] . "#" . $_GET['service_info'] . "#" . $_SESSION['loginId'] . "#" . 'UNSUBReq' . "\n";
                                error_log($logData, 3, $logPath);
                                echo "<div class='alert alert-block'>Request for deactivation sent</div> ";
                            }
                            ?>
                            <!--Logic will end here -->
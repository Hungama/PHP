<?php

$msisdn = $_GET['msisdn'];
$flag = $_GET['flag'];

function checkmsisdn($msisdn, $flag) {
    if (strlen($msisdn) == 12 || strlen($msisdn) == 10) {
        if (strlen($msisdn) == 12) {
            if (substr($msisdn, 0, 2) == 91) {
                $msisdn = substr($msisdn, -10);
            } else {
                if ($flag == 1) {
                    echo "Failed";
                }
                exit;
            }
        }
    } elseif (strlen($msisdn) != 10) {
        if ($flag == 1) {
            echo "Failed";
        }
        exit;
    }
    return $msisdn;
}

function getRatingId($chrgamount, $type, $serviceId, $planAmount) {
    $ratingId = "";
    switch ($serviceId) {
        case '1111':if ($type == 'sub') {
                switch ($planAmount) {
                    case '30':
                        if ($chrgamount == 30)
                            $ratingId = "93003008";
                        else if ($chrgamount == 25)
                            $ratingId = "92503004";
                        else if ($chrgamount == 20)
                            $ratingId = "92003008";
                        else if ($chrgamount == 15)
                            $ratingId = "91503004";
                        else if ($chrgamount == 11)
                            $ratingId = "91103002";
                        else if ($chrgamount == 7)
                            $ratingId = "90703000";
                        else if ($chrgamount == 5)
                            $ratingId = "90503004";
                        else
                            $ratingId = "901253002";
                        break;
                    case '11':
                        if ($chrgamount == 11)
                            $ratingId = "91103000";
                        else if ($chrgamount == 7)
                            $ratingId = "90703000";
                        else if ($chrgamount == 5)
                            $ratingId = "90503004";
                        else
                            $ratingId = "901253002";
                        break;
                    default: if ($chrgamount == '1.25')
                            $ratingId = "901253000";
                        else
                            $ratingId = "Not Found";
                        break;
                }
            } elseif ($type == 'resub') {
                switch ($planAmount) {
                    case '30':
                        if ($chrgamount == 30)
                            $ratingId = "93003009";
                        else if ($chrgamount == 25)
                            $ratingId = "92503005";
                        else if ($chrgamount == 20)
                            $ratingId = "92003009";
                        else if ($chrgamount == 15)
                            $ratingId = "91503005";
                        else if ($chrgamount == 11)
                            $ratingId = "91103003";
                        else if ($chrgamount == 7)
                            $ratingId = "90703001";
                        else if ($chrgamount == 5)
                            $ratingId = "90503005";
                        else
                            $ratingId = "901253003";
                        break;
                    case '11':
                        if ($chrgamount == 11)
                            $ratingId = "91103001";
                        else if ($chrgamount == 7)
                            $ratingId = "90703001";
                        else if ($chrgamount == 5)
                            $ratingId = "90503005";
                        else
                            $ratingId = "901253003";
                        break;
                    default: if ($chrgamount == '1.25')
                            $ratingId = "901253001";
                        else
                            $ratingId = "Not Found";
                        break;
                }
            }
            break;
        case '1110':
            if ($type == 'sub') {
                switch ($planAmount) {
                    case '30':
                        if ($chrgamount == 30)
                            $ratingId = "93002938";
                        else if ($chrgamount == 20)
                            $ratingId = "92002943";
                        else if ($chrgamount == 15)
                            $ratingId = "91502954";
                        else if ($chrgamount == 10)
                            $ratingId = "91002953";
                        else
                            $ratingId = "90502958";
                        break;
                    case '10':
                        if ($chrgamount == 10)
                            $ratingId = "91002951";
                        else
                            $ratingId = "90502958";
                        break;
                    default:
                        $ratingId = "Not Found";
                        break;
                }
            } elseif ($type == 'resub') {
                switch ($planAmount) {
                    case '30':
                        if ($chrgamount == 30)
                            $ratingId = "93002939";
                        else if ($chrgamount == 20)
                            $ratingId = "92002944";
                        else if ($chrgamount == 15)
                            $ratingId = "91502955";
                        else if ($chrgamount == 10)
                            $ratingId = "91002954";
                        else
                            $ratingId = "90502959";
                        break;
                    case '10':
                        if ($chrgamount == 10)
                            $ratingId = "91002952";
                        else
                            $ratingId = "90502959";
                        break;
                    default:
                        $ratingId = "Not Found";
                        break;
                }
            }
            break;
        case '1106':
            if ($type == 'sub') {
                switch ($planAmount) {
                    case '15':
                        if ($chrgamount == 15)
                            $ratingId = "91502957";
                        elseif ($chrgamount == 12)
                            $ratingId = "91202904";
                        elseif ($chrgamount == 10)
                            $ratingId = "91002956";
                        elseif ($chrgamount == 7)
                            $ratingId = "90702929";
                        elseif ($chrgamount == 5)
                            $ratingId = "90502961";
                        elseif ($chrgamount == 2)
                            $ratingId = "90202908";
                        else
                            $ratingId = "90102928"; //chrgamt=1
                        break;
                    case 10:
                        if ($chrgamount == 10)
                            $ratingId = "91002956";
                        elseif ($chrgamount == 7)
                            $ratingId = "90702929";
                        elseif ($chrgamount == 5)
                            $ratingId = "90502961";
                        elseif ($chrgamount == 2)
                            $ratingId = "90202908";
                        else
                            $ratingId = "90102928"; //chrgamt=1
                        break;
                    case 5:
                        if ($chrgamount == 5)
                            $ratingId = "90502961";
                        elseif ($chrgamount == 2)
                            $ratingId = "90202908";
                        else
                            $ratingId = "90102928"; //chrgamt=1
                        break;
                    default:
                        $ratingId = "Not Found";
                        break;
                }
            } elseif ($type == 'resub') {
                switch ($planAmount) {
                    case 15:
                        if ($chrgamount == 15)
                            $ratingId = "91502958";
                        elseif ($chrgamount == 12)
                            $ratingId = "91202905";
                        elseif ($chrgamount == 10)
                            $ratingId = "91002957";
                        elseif ($chrgamount == 7)
                            $ratingId = "90702930";
                        elseif ($chrgamount == 5)
                            $ratingId = "90502962";
                        elseif ($chrgamount == 2)
                            $ratingId = "90202909";
                        else
                            $ratingId = "90102929"; //chrgamt=1
                        break;
                    case 10:
                        if ($chrgamount == 10)
                            $ratingId = "91002957";
                        elseif ($chrgamount == 7)
                            $ratingId = "90702930";
                        elseif ($chrgamount == 5)
                            $ratingId = "90502962";
                        elseif ($chrgamount == 2)
                            $ratingId = "90202909";
                        else
                            $ratingId = "90102929"; //chrgamt=1
                        break;
                    case 5:
                        if ($chrgamount == 5)
                            $ratingId = "90502962";
                        elseif ($chrgamount == 2)
                            $ratingId = "90202909";
                        else
                            $ratingId = "90102929"; //chrgamt=1
                        break;
                    default:
                        $ratingId = "Not Found";
                        break;
                }
            }
            break;
        case '1101':
            if ($type == 'sub') {
                if ($chrgamount == 30 || $chrgamount == 20 || $chrgamount == 10)
                    $ratingId = "9" . $chrgamount . "03006";
                elseif ($chrgamount == 2)
                    $ratingId = "90" . $chrgamount . "03000";
                else {
                    if ($chrgamount < 10) {
                        $ratingId = "90" . $chrgamount . "03000";
                    } else {
                        $ratingId = "9" . $chrgamount . "03000";
                    }
                }
            } elseif ($type == 'resub') {
                if ($chrgamount == 30 || $chrgamount == 20 || $chrgamount == 10)
                    $ratingId = "9" . $chrgamount . "03007";
                elseif ($chrgamount == 2)
                    $ratingId = "90" . $chrgamount . "03001";
                else {
                    if ($chrgamount < 10) {
                        $ratingId = "90" . $chrgamount . "03001";
                    } else {
                        $ratingId = "9" . $chrgamount . "03001";
                    }
                }
            }
            break;
        case '1102':
            if ($type == 'sub') {
                $ratingId = $chrgamount . "03000";
            } elseif ($type == 'resub') {
                $ratingId = $chrgamount . "03001";
            }
            break;
        case '1103':
            if ($type == 'sub') {
                if ($chrgamount % 2 == 0)
                    $ratingId = "9" . $chrgamount . "03003";
                else
                    $ratingId = "9" . $chrgamount . "03002";
            } elseif ($type == 'resub') {
                if ($chrgamount % 2 == 0)
                    $ratingId = "9" . $chrgamount . "03004";
                else
                    $ratingId = "9" . $chrgamount . "03003";
            }
            break;
          case '1123':
            if ($type == 'sub') {
               ///////////////////////
			   switch ($chrgamount) {
										case 30:
											$ratingId="93003013";
										 break;
										case 25:
											$ratingId="92503008";
										 break;
										case 20:
											$ratingId="92003013";
										 break;
										case 15:
											$ratingId="91503008";
										 break;
										case 10:
											$ratingId="91003011";
										 break;
										 case 5:
										 	$ratingId="90503008";
										 break;
										 case 3:
										  	$ratingId="90303009";
										 break;
										case 2:
											$ratingId="90203010";
										 break;
										case 1:
											$ratingId="90103010";
										 break;
						}
		   } elseif ($type == 'resub') {
							switch($chrgamount)
									{
										case 30:
											$ratingId="93003014";
										 break;
										case 25:
											$ratingId="92503009";
										 break;
										case 20:
											$ratingId="92003014";
										 break;
										case 15:
											$ratingId="91503009";
										 break;
										case 10:
											$ratingId="91003012";
										 break;
										 case 5:
										 	$ratingId="90503009";
										 break;
										 case 3:
										  	$ratingId="90303010";
										 break;
										case 2:
											$ratingId="90203011";
										 break;
										case 1:
											$ratingId="90103011";
										 break;
									}
            }
            break;
		case '1126':
            if ($type == 'sub') {
               ///////////////////////
			   switch ($chrgamount) {
										case 1:
												$ratingId="90103012";
												break;
											case 2:
												$ratingId="90203012";
												break;
											case 3:
												$ratingId="90303011";
												break;
											case 5:
												$ratingId="90503010";
												break;
											case 10:
												$ratingId="91003013";
												break;
											case 15:
												$ratingId="91503010";
												break;
											case 20:
												$ratingId="92003015";
												break;
											case 25:
												$ratingId="92503010";
												break;
											case 30:
												$ratingId="93003015";
												break;
						}
		   } elseif ($type == 'resub') {
							switch($chrgamount)
									{
											case 1:
												$ratingId="90103013";
												break;
											case 2:
												$ratingId="90203013";
												break;
											case 3:
												$ratingId="90303012";
												break;
											case 5:
												$ratingId="90503011";
												break;
											case 10:
												$ratingId="91003014";
												break;
											case 15:
												$ratingId="91503011";
												break;
											case 20:
												$ratingId="92003016";
												break;
											case 25:
												$ratingId="92503011";
												break;
											case 30:
												$ratingId="93003016";
												break;
									}
            }
            break;
			case '1125':
            if ($type == 'sub') {
               
			   switch ($chrgamount) {
										case 30:
											$ratingId="93003010";
										 break;
										case 25:
											$ratingId="92503006";
										 break;
										case 20:
											$ratingId="92003010";
										 break;
										case 15:
											$ratingId="91503006";
										 break;
										case 10:
											$ratingId="91003008";
										 break;
										 case 5:
										 	$ratingId="90503006";
										 break;
										 case 3:
										  	$ratingId="90303001";
										 break;
										case 2:
											$ratingId="90203002";
										 break;
										case 1:
											$ratingId="90103002";
										 break;
						}
		   } elseif ($type == 'resub') {
							switch($chrgamount)
									{
										case 30:
											$ratingId="93003011";
										 break;
										case 25:
											$ratingId="92503007";
										 break;
										case 20:
											$ratingId="92003011";
										 break;
										case 15:
											$ratingId="91503007";
										 break;
										case 10:
											$ratingId="91003009";
										 break;
										 case 5:
											$ratingId="90503007";
										 break;
										 case 3:
											$ratingId="90303002";
										 break;
										case 2:
											$ratingId="90203003";
										 break;
										case 1:
											$ratingId="90103003";
										 break;
									}
            }
            break;
    }
    return $ratingId;
}

$msisdn = checkmsisdn($msisdn, $flag);
$con = mysql_connect("10.130.14.106", "billing", "billing");
if (!$con) {
    die('We are facing some temporarily Problem , please try later : ');
    //mysql_error()
}

$flag = 0;
$tblList = array('1101' => array('mts_radio.tbl_radio_subscription', 'mts_radio.tbl_radio_unsub'), '1102' => array('mts_hungama.tbl_jbox_subscription', 'mts_hungama.tbl_jbox_unsub'), '1103' => array('mts_mtv.tbl_mtv_subscription', 'mts_mtv.tbl_mtv_unsub'), '1106' => array('mts_starclub.tbl_jbox_subscription', 'mts_starclub.tbl_jbox_unsub'), '1110' => array('mts_redfm.tbl_jbox_subscription', 'mts_redfm.tbl_jbox_unsub'), '1111' => array('dm_radio.tbl_digi_subscription', 'dm_radio.tbl_digi_unsub'), '1125' => array('mts_JOKEPORTAL.tbl_jokeportal_subscription', 'mts_JOKEPORTAL.tbl_jokeportal_unsub'), '1126' => array('mts_Regional.tbl_regional_subscription', 'mts_Regional.tbl_regional_unsub'), '1123' => array('Mts_summer_contest.tbl_contest_subscription', 'Mts_summer_contest.tbl_contest_unsub'));

$total_service = sizeof($tblList);

$billingTbl = "master_db.tbl_billing_success";
$serviceData = mysql_query("select distinct(service_id) from " . $billingTbl . " where msisdn='" . $msisdn . "' and event_type in('SUB','EVENT')");
$countData = mysql_num_rows($serviceData);

if (!$countData) {
    $serviceData = mysql_query("select distinct(service_id) from master_db.tbl_billing_success_backup where msisdn='" . $msisdn . "' and event_type in('SUB','EVENT')");
    $countData = mysql_num_rows($serviceData);
    $billibngTbl = "master_db.tbl_billing_success_backup";
}

if ($countData) {
    header("Content-type: text/xml");
    echo "<?xml version='1.0' encoding='ISO-8859-1'?" . ">\n";
    echo "<ROOT>\n";
    while ($row = mysql_fetch_array($serviceData)) {
        $serviceId = $row['service_id'];
        $serData = mysql_query("SELECT Servicename FROM master_db.tbl_app_service_master WHERE Serviceid='" . $serviceId . "'");
        list($serviceName) = mysql_fetch_array($serData);
        $serviceName = $serviceId;
        $subTable = $tblList[$serviceId][0];
        $unsubTable = $tblList[$serviceId][1];

        $noDetail = array();
        $noDetail['msisdn'] = $msisdn;

        $check_subquery = "select ani,date_format(sub_date,'%d-%m-%Y %H:%i:%s') as sub_date,date_format(renew_date,'%d-%m-%Y %H:%i:%s') as renew_date, mode_of_sub, status, chrg_amount,plan_id from " . $subTable . " nolock where ANI='" . $msisdn . "'";
        $subData = mysql_query($check_subquery);
        while ($rowSub = mysql_fetch_array($subData)) {
            $noDetail['actDate'] = $rowSub['sub_date'];
            $noDetail['renDate'] = $rowSub['renew_date'];
            $noDetail['actMode'] = $rowSub['mode_of_sub'];
            $noDetail['status'] = $rowSub['status'];
            $noDetail['chrgAmt'] = $rowSub['chrg_amount'];
            $noDetail['plan_id'] = $rowSub['plan_id'];
        }

        $check_unsubquery = "select mode_of_sub,date_format(unsub_date,'%d-%m-%Y %H:%i:%s') as unsub_date,unsub_reason from " . $unsubTable . " nolock where ANI='" . $msisdn . "'";
        $unsubData = mysql_query($check_unsubquery);
        $unsubCount = mysql_num_rows($subData);
        while ($rowUnSub = mysql_fetch_array($unsubData)) {
            $noDetail['deactMode'] = $rowUnSub['mode_of_sub'];
            $noDetail['deactDate'] = $rowUnSub['unsub_date'];
        }

        $billingData = mysql_query("select date_format(date_time,'%d-%m-%Y %H:%i:%s') as date_time, chrg_amount from " . $billibngTbl . " where msisdn='" . $msisdn . "' and event_type = 'RESUB' and service_id='" . $serviceId . "'");

        while ($rowResub = mysql_fetch_array($billingData)) {
            $noDetail['lastRen'] = $rowResub['date_time'];
            $noDetail['lastRenAmt'] = $rowResub['chrg_amount'];
        }

        $planData = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id=" . $noDetail['plan_id']);
        list($planAmount) = mysql_fetch_array($planData);

        if ($noDetail['lastRenAmt']) {
            $ratingId = getRatingId($noDetail['lastRenAmt'], 'resub', $serviceId, $planAmount);
            $chargeAmt = $noDetail['lastRenAmt'];
			$flg='lastRenAmt';
			} else {
            $ratingId = getRatingId($noDetail['chrgAmt'], 'sub', $serviceId, $planAmount);
            $chargeAmt = $noDetail['chrgAmt'];
			$flg='chrgAmt';
        }
		
        if ($noDetail['status'] == 1)
            $status = "Active";
        elseif ($noDetail['status'] == 0)
            $status = "Not Active";
        elseif ($noDetail['status'] == 11)
            $status = "Pending";

        if ($noDetail['status'] == 1) {
            $actDate = $noDetail['actDate'] ? $noDetail['actDate'] : "";
            $deactDate = $noDetail['deactDate'] ? $noDetail['deactDate'] : "";
            $renDate = $noDetail['renDate'] ? $noDetail['renDate'] : "";
            $lastRen = $noDetail['lastRen'] ? $noDetail['lastRen'] : "";
            $actMode = $noDetail['actMode'] ? $noDetail['actMode'] : "";
            $deactMode = $noDetail['deactMode'] ? $noDetail['deactMode'] : "";
            $planAmt = $planAmount ? $planAmount : "";
            $chAmt = $chargeAmt ? $chargeAmt : "";

            echo "<SERVICE>\n";
            echo "<SVCNAME>" . $serviceName . "</SVCNAME>\n";
            echo "<SVCSTATUS>" . $status . "</SVCSTATUS>\n";
            echo "<ACTDATE>" . $actDate . "</ACTDATE>\n";
            echo "<DEACTDATE>" . $deactDate . "</DEACTDATE>\n";
            echo "<RENDATE>" . $lastRen . "</RENDATE>\n";
            echo "<NEXTRENDATE>" . $renDate . "</NEXTRENDATE>\n";
			echo "<LASTRENDATE></LASTRENDATE>\n";
            echo "<RATINGID>" . $ratingId . "</RATINGID>\n";
            echo "<ACTMODE>" . $actMode . "</ACTMODE>\n";
            echo "<DEACTMODE>" . $deactMode . "</DEACTMODE>\n";
            echo "<PLANAMOUNT>" . $planAmt . "</PLANAMOUNT>\n";
            echo "<CHAGREAMOUNT>" . $chAmt . "</CHAGREAMOUNT>\n";
            echo "</SERVICE>\n";
        }
    }
    echo "</ROOT>\n";
} else {
    header("Content-type: text/xml");
    echo "<?xml version='1.0' encoding='ISO-8859-1'?" . ">\n";
    echo "<ROOT>\n";
    echo "<SVCSTATUS>No Record Found.</SVCSTATUS>\n";
    echo "</ROOT>\n";
}

if ($con) {
    mysql_close($con);
}
?>
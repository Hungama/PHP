<?php
session_start();
if (isset($_SESSION['authid'])) {
    include ("config/dbConnect.php");
    ?>
    <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
            <title>Hungama Customer Care</title>
            <link rel="stylesheet" href="style.css" type="text/css">
            <style type="text/css">
                <!--
                .style3 {font-family: "Times New Roman", Times, serif}
                -->
            </style>
            <script language="javascript">
                function logout()
                {
                    window.parent.location.href = 'index.php?logerr=logout';
                }
            </script>
            <script language="javascript">
                function checkfield(){
                    var re5digit=/^\d{10}$/ //regular expression defining a 10 digit number
                    if(document.frm.msisdn.value.search(re5digit)==-1){
                        alert("Please enter 10 digit Mobile Number.");
                        document.frm.msisdn.focus();
                        return false;
                    }
                    return true;
                }
                function openWindow(str,service_info)
                {
                    window.open("view_billing_details.php?msisdn="+str+"&service_info="+service_info,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
                }

                function DeactivateCat(mdn,status,sid,catId) {
                    var url="main.php?msisdn="+mdn+"&act=da&service_info="+sid+"&catid="+catId;
                    window.location.href=url;
                }

                function showUnsubPopUp(mdn,sid) {
                    var url="unsubCC.php?msisdn="+mdn+"&service_info="+sid;
                    window.open(url,"mywindow","menubar=0,resizable=1,width=450,height=400,scrollbars=yes");
                }


            </script>
        </head>
        <body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
            <?php
            if ($_REQUEST['service_info'] == 0) {
                include_once("main_header.php");
                ?>
                <TABLE width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
                    <TBODY>
                        <TR>
                            <TD bgcolor="#FFFFFF" align="center"><B>Please Select Service</B></TD>
                        </TR>
                    </tbody>
                </table> 
                <?
                exit;
            } else {
                include ("header.php");
            }
            ?>
            <form name="frm" method="POST" action="" onSubmit="return checkfield()">
                <TABLE width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
                    <TBODY>    
                        <TR>
                            <TD bgcolor="#FFFFFF" align="center"><B>Enter Mobile No.</B></TD>
                        </TR>
                        <TR>
                            <TD bgcolor="#FFFFFF" align="center">&nbsp;&nbsp;<INPUT name="msisdn" type="text" class="in" value="<?php echo $_REQUEST['msisdn']; ?>">
                                <input type='hidden' name='service_info' value=<?= $_REQUEST['service_info']; ?>>
                            </TD>
                        </TR>
                        <TR>
                            <td align="center" bgcolor="#FFFFFF">
                                <input name="Submit" type="submit" class="txtbtn" value="Submit"/>			
                            </td>
                        </TR>
                    </TBODY>
                </TABLE>
            </form><br/><br/>
            <?php
            if ($_POST['Submit'] == "Submit" && $_REQUEST['msisdn'] != "") {
                $numRows = 0;
                $service_info = $_POST['service_info'];
                if ($service_info == '11011')
                    $service_info = '1101';
                else
                    $service_info = $_POST['service_info'];
                $plan_query = "SELECT Plan_id from master_db.tbl_plan_bank WHERE sname='" . $_POST['service_info'] . "'";
                $planDataResult = mysql_query($plan_query, $dbConn);
                while ($row = mysql_fetch_array($planDataResult)) {
                    $planData[] = $row['Plan_id'];
                }
                if ($service_info == "1116") {
                    $select_query2 = "select msisdn, response_time, chrg_amount,circle,MODE,SC,event_type from master_db.tbl_billing_success nolock where service_id=" . $service_info . " and msisdn='$_POST[msisdn]' and plan_id IN (" . implode(",", $planData) . ")  AND subservice_id NOT IN (1,2,3,4,5,6,7,8,9,10) order by response_time desc limit 1";
                } else {
                    $select_query2 = "select msisdn, response_time, chrg_amount,circle,MODE,SC,event_type from master_db.tbl_billing_success nolock where service_id=" . $service_info . " and msisdn='$_POST[msisdn]' and plan_id IN (" . implode(",", $planData) . ") order by response_time desc limit 1";
                }
                $query = mysql_query($select_query2, $dbConn) or die(mysql_error());
                $numRows = mysql_num_rows($query);

                if ($numRows == 0) {
                    if ($service_info == "1116") {
                        $select_query2 = " select msisdn, response_time, chrg_amount,circle,MODE,SC,event_type from master_db.tbl_billing_success_backup nolock where service_id=" . $service_info . " and msisdn='$_REQUEST[msisdn]' and plan_id IN (" . implode(",", $planData) . ") AND subservice_id NOT IN (1,2,3,4,5,6,7,8,9,10) order by response_time desc limit 1";
                    } else {
                        $select_query2 = " select msisdn, response_time, chrg_amount,circle,MODE,SC,event_type from master_db.tbl_billing_success_backup nolock where service_id=" . $service_info . " and msisdn='$_REQUEST[msisdn]' and plan_id IN (" . implode(",", $planData) . ") order by response_time desc limit 1";
                    }
                    $query = mysql_query($select_query2, $dbConn) or die(mysql_error());
                    $numRows = mysql_num_rows($query);
                    //echo $numRows." old";
                }
                if ($numRows == 0) {
                    if ($service_info == "1116") {
                        $select_query2 = " select msisdn, response_time, chrg_amount,circle,MODE,SC,event_type from master_db.tbl_billing_success_backup1 nolock where service_id=" . $service_info . " and msisdn='$_REQUEST[msisdn]' and plan_id IN (" . implode(",", $planData) . ") AND subservice_id NOT IN (1,2,3,4,5,6,7,8,9,10) order by response_time desc limit 1";
                    } else {
                        $select_query2 = " select msisdn, response_time, chrg_amount,circle,MODE,SC,event_type from master_db.tbl_billing_success_backup1 nolock where service_id=" . $service_info . " and msisdn='$_REQUEST[msisdn]' and plan_id IN (" . implode(",", $planData) . ") order by response_time desc limit 1";
                    }
                    $query = mysql_query($select_query2, $dbConn) or die(mysql_error());
                    $numRows = mysql_num_rows($query);
                    //echo $numRows." old";
                }
                //echo $select_query2;
                if ($numRows > 0) {
                    // mysql_select_db($$userDbName, $userDbConn);
                    $serviceId = $_POST['service_info'];
                    $select_query1 = "select SUB_DATE, circle, MODE_OF_SUB, DNIS, STATUS from ";
                    //if($serviceId == 1106) {
                    //} else {
                    $select_query1 = "select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS, DATEDIFF(RENEW_DATE,NOW()) as diff from ";
                    //}
                    switch ($_POST['service_info']) {
                        case '1102':
                            $select_query1.= "mts_hungama.tbl_jbox_subscription";
                            break;
                        case '1101':
                        case '11011':
                            $select_query1.= "mts_radio.tbl_radio_subscription";
                            break;
                        case '1103':
                            $select_query1.= "mts_mtv.tbl_mtv_subscription";
                            break;
                        case '1111':
                            $select_query1.= "dm_radio.tbl_digi_subscription";
                            break;
                        case '1105':
                            $select_query1.= "mts_starclub.tbl_jbox_subscription";
                            break;
                        case '1106':
                            $select_query1.= "mts_starclub.tbl_jbox_subscription"; //"CelebChat.tbl_chat_subscription";
                            break;
                        case '1110':
                            $select_query1.= "mts_redfm.tbl_jbox_subscription";
                            break;
                        case '1113':
                            $select_query1.= "mts_mnd.tbl_character_subscription1";
                            break;
                        case '1124':
                            $select_query1.= "mts_radio.tbl_AudioCinema_subscription";
                            break;
                        case '1123':
                            $select_query1.= "Mts_summer_contest.tbl_contest_subscription";
                            break;
                        case '1125':
                            $select_query1.= "mts_JOKEPORTAL.tbl_jokeportal_subscription";
                            break;
                        case '1126':
                            $select_query1.= "mts_Regional.tbl_regional_subscription";
                            break;
                        case '1116':
                            $select_query1.= "mts_voicealert.tbl_voice_subscription";
                            $pquery = "SELECT plan_id FROM mts_voicealert.tbl_voice_subscription WHERE ANI='" . $_REQUEST['msisdn'] . "'";
                            $result1 = mysql_query($pquery, $dbConn);
                            $pData = mysql_fetch_array($result1); //print_r($pData);
                            $mPlanId = $pData['plan_id'];
                            $query12 = "SELECT cat_id,plan_id from mts_voicealert.tbl_voice_category where ANI='" . $_REQUEST['msisdn'] . "' and status=1";
                            $resultCatData = mysql_query($query12, $dbConn);
                            $i = 0;
                            $catList = "";
                            while ($catData = mysql_fetch_array($resultCatData)) {
                                if ($catData['plan_id'] != $mPlanId) {
                                    $catArray[] = $catData['cat_id'];
                                }
                                if ($catData['plan_id'] == $mPlanId) {
                                    if ($i == 0)
                                        $catList .= $catData['cat_id'];
                                    else
                                        $catList .= ", " . $catData['cat_id'];
                                    $i++;
                                }
                            }
                            if (!$catList)
                                $catList = "-";
                            break;
                    }

                    $select_query1.=" where ANI='$_POST[msisdn]' and plan_id IN (" . implode(",", $planData) . ") order by SUB_DATE desc limit 1";
                    //if($_SESSION['usrId']==27) echo $select_query1;
                    //echo $select_query1;
                    $querySubscription = mysql_query($select_query1, $userDbConn) or die(mysql_error());
                    $num = mysql_num_rows($querySubscription);
                    ?>
                <center><div width="85%" align="left" class="txt"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B><FONT COLOR="#FF0000">Subscription Status</FONT></B></div><center><br/>
                        <TABLE width="98%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
                            <TBODY>
                                <?php
                                $subStatus = -1;

                                list($msisdn, $response_time, $chrg_amount, $circle, $MODE_OF_SUB1, $DNIS1, $new_event_type) = mysql_fetch_array($query);
                                list($SUB_DATE, $RENEW_DATE, $circle1, $MODE_OF_SUB, $DNIS, $subStatus, $daysLeft) = mysql_fetch_array($querySubscription);
                                ?>
                                <TR height="30">
                                    <TD bgcolor="#FFFFFF" align="center"><B>Mobile No</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Registration.ID</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Activation</B></TD>
                                    <?php if ($circle != 'RAJ') { ?>
                                        <TD bgcolor="#FFFFFF" align="center"><B>Next Charging</B></TD>
                                    <?php } ?>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Last Charging</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Charged Amt.</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Circle</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>SubscriptionMode</B></TD>
                                    <!--TD bgcolor="#FFFFFF" align="center"><B>Days left For Renewal</B></TD-->
                                    <?php if ($_POST['service_info'] == '1116') { ?>
                                        <TD bgcolor="#FFFFFF" align="center"><B>Subscribed Category</B></TD>
                                    <?php } ?>
                                    <TD bgcolor="#FFFFFF" align="center"><B>&nbsp;</B></TD>
                                </TR>

                                <TR height="30">
                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $msisdn; ?></TD>
                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $DNIS1; ?></TD>
                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $SUB_DATE; ?></TD>
                                    <?php if ($circle != 'RAJ') { ?>
                                        <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if ($RENEW_DATE && $new_event_type != 'EVENT') echo $RENEW_DATE; else echo "-"; ?></TD>
                                    <?php } ?>
                                    <TD bgcolor="#FFFFFF" align="center" class="blue">&nbsp;
                                        <?php
                                        if ($circle != 'RAJ') {
                                            ?>
                                            <a href="javascript:void(0);" onclick="openWindow(<?= $msisdn; ?>,<?= $_REQUEST['service_info']; ?>)"> <?php echo $response_time; ?></a>
                                            <?php
                                        } else {
                                            echo $response_time;
                                        }
                                        ?>
                                    </TD>
                                    <TD bgcolor="#FFFFFF" align="right"><?php echo $chrg_amount; ?>&nbsp;</TD>
                                    <TD bgcolor="#FFFFFF" align="right"><?php echo $circle; ?>&nbsp;</TD>
                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if ($MODE_OF_SUB1 == 'push' || $MODE_OF_SUB1 == 'Push' || $MODE_OF_SUB1 == 'PUSH') $MODE_OF_SUB1 = 'OBD1'; elseif ($MODE_OF_SUB1 == 'push2' || $MODE_OF_SUB1 == 'Push2' || $MODE_OF_SUB1 == 'PUSH2') $MODE_OF_SUB1 = 'OBD2'; echo $MODE_OF_SUB1; ?></TD>
                                    <!--TD bgcolor="#FFFFFF" align="center">&nbsp;	<?php //  echo $daysLeft;?></TD-->
									<?php
                          //  echo $daysLeft;
                            if ($_POST['service_info'] == '1101') {
                                $showActiveFlag = 1;
                            } else {
                                $showActiveFlag = 0;
                            }
                                        ?>
                                    <?php if ($_POST['service_info'] == '1116') { ?>
                                        <TD bgcolor="#FFFFFF" align="right">&nbsp;<?php echo $catList; ?> &nbsp;</TD>
                                    <?php } ?>
                                    <TD bgcolor="#FFFFFF" align="center" class="blue" width='200px;'>&nbsp;<?php
                        $blacklistID = array(28);
                        if (($subStatus == 1 || $subStatus == 11) && !in_array($_SESSION['usrId'], $blacklistID)) {
                            $dateArray = array(17, 18, 19, 20);

                            if ($_REQUEST['service_info'] == '1116') {
                                            ?>
                                                <a href="main.php?msisdn=<?= $msisdn; ?>&act=da&service_info=<?= $_REQUEST['service_info']; ?>">Deactivate</a>&nbsp;|&nbsp;<a href="main.php?msisdn=<?= $msisdn; ?>&act=da&catid=all&service_info=<?= $_REQUEST['service_info']; ?>">Deactivate</a>(All)		
                                                <?php
                                            } else {
                                                if ($_SESSION['usrId'] == 281) {
                                                    ?>
                                                    <a href="#" onclick="javascript:showUnsubPopUp('<?php echo $msisdn; ?>','<?php echo $_REQUEST['service_info']; ?>');">Deactivate</a>
                                                <?php } else { 
												if ($_SESSION['usrId'] == 30){
												?>
                                                Deactivate
                                                <?php 
												}
												else
												{?>
												    <a href="main.php?msisdn=<?= $msisdn; ?>&act=da&service_info=<?= $_REQUEST['service_info']; ?>">Deactivate</a>	
											<?php	}
												} ?>
                                                <?php
                                            }
                                            if ($subStatus == 11)
                                                echo "(Pending)";
                                        } elseif ($subStatus == 0) {
                                            echo "Not Active";
                                        } elseif ($subStatus == 11) {
                                            echo "Pending";
                                        }
                                        ?></TD>
                                </TR>
                            </TBODY>
                        </TABLE><br/><br/>
                        <?php if (count($catArray) && $_REQUEST['service_info'] == '1116') { ?>
                            <div class='txt' align="left" width="85%"><b><font color="#FF0000">&nbsp;&nbsp;&nbsp;&nbsp;Additional Category Status</font></b></div><br/>
                            <TABLE width="98%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">	
                                <TR height="30">
                                    <TD bgcolor="#FFFFFF" align="center"><B>Mobile No</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Registration.ID</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Activation</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Next Charging</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Last Charging</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Charged Amt.</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Circle</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>SubscriptionMode</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Days left For Renewal</B></TD>
                                    <?php if ($_POST['service_info'] == '1116') { ?>
                                        <TD bgcolor="#FFFFFF" align="center"><B>Subscribed Category</B></TD>
                                    <?php } ?>
                                    <TD bgcolor="#FFFFFF" align="center"><B>&nbsp;</B></TD>
                                </TR>	
                                <?php
                                for ($i = 0; $i < count($catArray); $i++) {
                                    if (!$mPlanId)
                                        $mPlanId = '25';
                                    $select_queryVA = "select msisdn, response_time, chrg_amount,circle,MODE,SC,event_type from master_db.tbl_billing_success nolock where service_id=" . $service_info . " and msisdn='$_POST[msisdn]' and plan_id!=" . $mPlanId . " and subservice_id='" . $catArray[$i] . "' order by response_time desc limit 1";
                                    $queryVA = mysql_query($select_queryVA, $dbConn) or die(mysql_error());
                                    $numRows = mysql_num_rows($queryVA);

                                    if ($numRows == 0) {
                                        $select_queryVA = " select msisdn, response_time, chrg_amount,circle,MODE,SC,event_type from master_db.tbl_billing_success_backup nolock where service_id=" . $service_info . " and msisdn='$_REQUEST[msisdn]' and plan_id!=" . $mPlanId . " and subservice_id='" . $catArray[$i] . "' order by response_time desc limit 1";
                                        $queryVA = mysql_query($select_queryVA, $dbConn) or die(mysql_error());
                                        $numRows = mysql_num_rows($queryVA);
                                        //echo $numRows." old";
                                    }
                                    $selectSUB = "select SUB_DATE,RENEW_DATE,circle,MODE_OF_SUB,dnis,status,datediff(RENEW_DATE,NOW()) as diff from mts_voicealert.tbl_voice_category where ani='$_REQUEST[msisdn]' and plan_id!=" . $mPlanId . " and cat_id='" . $catArray[$i] . "'";
                                    $resultSUB = mysql_query($selectSUB, $dbConn);

                                    list($msisdn1, $response_time1, $chrg_amount1, $circle1, $newMODE, $newSC, $new_event_type) = mysql_fetch_array($queryVA);
                                    list($SUB_DATE2, $RENEW_DATE2, $circle2, $MODE_OF_SUB2, $DNIS2, $subStatus2, $daysLeft2) = mysql_fetch_array($resultSUB);
                                    ?>
                                    <TR height="30">
                                        <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $msisdn1; ?></TD>
                                        <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $DNIS2; ?></TD>
                                        <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $SUB_DATE2; ?></TD>

                                        <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if ($RENEW_DATE2 && $new_event_type != 'Event') echo $RENEW_DATE2; else echo "-"; ?></TD>

                                        <TD bgcolor="#FFFFFF" align="center" class="blue">&nbsp;
                                            <?php
                                            if ($circle1 != 'RAJ') {
                                                ?>
                                                <a href="javascript:void(0);" onclick="openWindow(<?= $msisdn1; ?>,<?= $_REQUEST['service_info']; ?>)"> <?php echo $response_time1; ?>
                                                </a>
                                                <?php
                                            } else {
                                                echo $response_time1;
                                            }
                                            ?>
                                        </TD>
                                        <TD bgcolor="#FFFFFF" align="right"><?php echo $chrg_amount1; ?>&nbsp;</TD>
                                        <TD bgcolor="#FFFFFF" align="right"><?php echo $circle1; ?>&nbsp;</TD>
                                        <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if ($MODE_OF_SUB2 == 'push' || $MODE_OF_SUB2 == 'Push' || $MODE_OF_SUB2 == 'PUSH') $MODE_OF_SUB2 = 'OBD1'; elseif ($MODE_OF_SUB2 == 'push2' || $MODE_OF_SUB2 == 'Push2' || $MODE_OF_SUB2 == 'PUSH2') $MODE_OF_SUB2 = 'OBD2'; echo $MODE_OF_SUB2; ?></TD>	
                                        <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $daysLeft2; ?></TD>	
                                        <?php if ($_POST['service_info'] == '1116') { ?>
                                            <TD bgcolor="#FFFFFF" align="right">&nbsp;<?php echo $catArray[$i]; ?> &nbsp;</TD>
                                        <?php } ?>
                                        <TD bgcolor="#FFFFFF" align="center" class="blue" width='200px;'>&nbsp;<a href="#" onclick="DeactivateCat('<?php echo $msisdn; ?>','da','<?php echo $_REQUEST['service_info']; ?>','<?php echo $catArray[$i]; ?>');">Deactivate</a></TD>
                                    </TR>
                                <?php }  // end for loop   ?>	
                            </TABLE>
                        <?php } // end if loop ?>

                        <?php
                    } else {
                        echo "<div align='center'><B>No records found for this number</B></div>";
                    }
                    ?>
                    <div align='left' class="txt">
                        <?php /* if($showActiveFlag && $subStatus==1) { 
                          $queryC = "SELECT count(*) FROM mts_voicealert.tbl_voice_subscription WHERE ani='".$msisdn."'";
                          $resultC = mysql_query($queryC);
                          $status1= mysql_fetch_row($resultC);
                          if($status1[0] > 0) { */ ?>
                        <!--<FONT COLOR="#FF0000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B>Voice Alert Service Already Subscribed</B></FONT>-->
                        <?php // } else { ?>
                        <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="main.php?msisdn=<?= $msisdn; ?>&act=tnbva&service_info=<?= $_REQUEST['service_info']; ?>"><B>Subscribe TNB VoiceAlert</B></a>-->
                        <?php /* } 
                          } */ ?>
                    </div><br/>

                    <center>
                        <?php if ($circle != 'RAJ') { ?>
                            <!--                            <div width="85%" align="left" class="txt"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<FONT COLOR="#FF0000"><B>Subscription History</B></FONT></div>-->
                            <center><br/>
                                <?php
                                //   mysql_select_db($$userDbName, $userDbConn);
                                $deactivationQuery1 = "select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS, SUB_TYPE, UNSUB_DATE, UNSUB_REASON from ";
                                //. $$unSubsTableName." where ANI='$_POST[msisdn]' order by UNSUB_DATE desc";
                                switch ($_POST['service_info']) {
                                    case '1102':
                                        $deactivationQuery1 .= "mts_hungama.tbl_jbox_unsub";
                                        break;
                                    case '1101':
                                    case '11011':
                                        $deactivationQuery1 .= "mts_radio.tbl_radio_unsub";
                                        break;
                                    case '1103':
                                        $deactivationQuery1 .= "mts_mtv.tbl_mtv_unsub";
                                        break;
                                    case '1111':
                                        $deactivationQuery1 .= "dm_radio.tbl_digi_unsub";
                                        break;
                                    case '1105':
                                        $deactivationQuery1 .= "mts_starclub.tbl_jbox_unsub";
                                        break;
                                    case '1106':
                                        $deactivationQuery1 .= "CelebChat.tbl_chat_unsubscription";
                                        break;
                                    case '1110':
                                        $deactivationQuery1 .= "mts_redfm.tbl_jbox_unsub";
                                        break;
                                    case '1113':
                                        $deactivationQuery1 .= "mts_mnd.tbl_character_unsub1";
                                        break;
                                    case '1116':
                                        $deactivationQuery1 .= "mts_voicealert.tbl_voice_unsub";
                                        break;
                                    case '1124':
                                        $deactivationQuery1.= "mts_radio.tbl_AudioCinema_unsub";
                                        break;
                                    case '1123':
                                        $deactivationQuery1.= "Mts_summer_contest.tbl_contest_unsub";
                                        break;
                                    case '1125':
                                        $deactivationQuery1.= "mts_JOKEPORTAL.tbl_jokeportal_unsub";
                                        break;
                                    case '1126':
                                        $deactivationQuery1.= "mts_Regional.tbl_regional_unsub";
                                        break;
                                }
                                $deactivationQuery1 .= " where ANI='$_POST[msisdn]' and plan_id IN (" . implode(",", $planData) . ") order by UNSUB_DATE desc";
//echo $deactivationQuery1;
                                $queryunSubscription = mysql_query($deactivationQuery1, $dbConn) or die(mysql_error());
                                $numRows1 = mysql_num_rows($queryunSubscription);
                                if ($numRows1 > 0) {
                                    ?>
                                    <!--                                    <TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
                                                                            <TBODY>
                                                                                <TR height="30">
                                                                                    <TD bgcolor="#FFFFFF" align="center"><B>Mobile No</B></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center"><B>Registration.ID</B></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center"><B>Subscription Date</B></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center"><B>Renew Date</B></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center"><B>Circle</B></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center"><B>SubscriptionMode</B></TD>			
                                                                                    <TD bgcolor="#FFFFFF" align="center"><B>Status</B></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center"><B>Subscrition Type</B></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center"><B>Unsubscription Date</B></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center"><B>Reason</B></TD>
                                                                                </TR>
                                    <?php
                                    $RENEW_DATE = "";
                                    list($SUB_DATE, $RENEW_DATE, $circle, $MODE_OF_SUB, $DNIS, $subStatus, $SUB_TYPE, $UNSUB_DATE, $UNSUB_REASON) = mysql_fetch_array($queryunSubscription);
                                    ?>
                                                                                <TR height="30">
                                                                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $msisdn; ?></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $DNIS; ?></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $SUB_DATE; ?></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if ($RENEW_DATE) echo $RENEW_DATE; else echo "-"; ?></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $circle; ?></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php if ($MODE_OF_SUB == 'push' || $MODE_OF_SUB == 'Push' || $MODE_OF_SUB == 'PUSH') $MODE_OF_SUB = 'OBD1'; elseif ($MODE_OF_SUB == 'push2' || $MODE_OF_SUB == 'Push2' || $MODE_OF_SUB == 'PUSH2') $MODE_OF_SUB = 'OBD2'; echo $MODE_OF_SUB; ?></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $subStatus; ?></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $SUB_TYPE; ?></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php //echo $UNSUB_DATE;      ?></TD>
                                                                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php //if($UNSUB_REASON=='push' || $UNSUB_REASON=='push2') echo "CC"; else echo $UNSUB_REASON;     ?></TD>
                                                                                </TR>				
                                                                            </TBODY>
                                                                        </TABLE>-->
                                    <?php
                                } else {
                                    //echo "<div align='center'><B>No history found</B></div>";
                                }
                            }
                        } elseif ($_GET['msisdn'] != "" && $_GET['act'] == "da") {
                            if ($_GET['service_info'] == 1102)
                                $Query1 = "call mts_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                            elseif ($_GET['service_info'] == 1101 || $_GET['service_info'] == 11011)
                                $Query1 = "call mts_radio.RADIO_UNSUB('$_GET[msisdn]', 'CC')";
                            elseif ($_GET['service_info'] == 1103)
                                $Query1 = "call mts_mtv.MTV_UNSUB('$_GET[msisdn]', 'CC')";
                            elseif ($_GET['service_info'] == 1111)
                                $Query1 = "call dm_radio.DIGI_UNSUB('$_GET[msisdn]', 'CC')";
                            elseif ($_GET['service_info'] == 1105)
                                $Query1 = "call mts_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                            elseif ($_GET['service_info'] == 1110)
                                $Query1 = "call mts_redfm.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                            elseif ($_GET['service_info'] == 1116) {
                                if (is_numeric($_GET['catid']))
                                    $Query1 = "call mts_voicealert.VOICE_FETCHUNSUB('$_GET[msisdn]', '" . $_GET['catid'] . "' ,'CC')";
                                elseif ($_GET['catid'] == 'all')
                                    $Query1 = "call mts_voicealert.VOICE_UNSUB_ALL('$_GET[msisdn]','CC')";
                                else
                                    $Query1 = "call mts_voicealert.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                            }
                            elseif ($_GET['service_info'] == 1106)
                                $Query1 = "call mts_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                            elseif ($_GET['service_info'] == 1113)
                                $Query1 = "call mts_mnd.MND_UNSUB('$_GET[msisdn]', 'CC')";
                            elseif ($_GET['service_info'] == 1124)
                                $Query1 = "call mts_radio.CINEMA_UNSUB('$_GET[msisdn]', 'CC')";
                            elseif ($_GET['service_info'] == 1123)
                                $Query1 = "call Mts_summer_contest.CONTEST_UNSUB('$_GET[msisdn]', 'CC')";
                            elseif ($_GET['service_info'] == 1125)
                                $Query1 = "call mts_JOKEPORTAL.JOKEPORTAL_UNSUB('$_GET[msisdn]', 'CC')";
                            elseif ($_GET['service_info'] == 1126)
                                $Query1 = "call mts_Regional.REGIONAL_UNSUB('$_GET[msisdn]', 'CC')";
                            // echo $Query1;
                            $result = mysql_query($Query1, $dbConn) or die(mysql_error());
                            echo "<div align='center'><B>Request for deactivation sent</B></div>";
                        } elseif ($_GET['msisdn'] != "" && $_GET['act'] == "tnbva") {
                            $Query1 = "call mts_voicealert.VOICE_OBD('$_GET[msisdn]','01','TNBVA','54444','7','1116','26', '3','7')";
                            $result = mysql_query($Query1, $dbConn) or die(mysql_error());
                            echo "<div align='center'><B>Request for activate TNB Voice Alert service sent successfully.</B></div>";
                        }
                        ?>
                        <br/><br/><br/><br/><br/><br/><br/>

                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td bgcolor="#0369b3" height="1"></td>
                                </tr>
                                <tr> 
                                    <td class="footer" align="right" bgcolor="#ffffff"><b>Powered by Hungama</b></td>
                                </tr><tr>
                                    <td bgcolor="#0369b3" height="1"></td>
                                </tr>
                            </tbody></table>
                        </body>
                        </html>
                        <?php
                        mysql_close($dbConn);
                    } else {
                        header("Location:index.php");
                    }
                    ?>

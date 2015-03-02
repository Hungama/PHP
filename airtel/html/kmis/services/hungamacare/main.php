<?php
//echo "<pre>";print_r($_REQUEST);
session_start();
if (isset($_SESSION['authid'])) {
    include ("config/dbConnect.php");
    $user_id_array = array('96', '97', '98', '99', '100', '101', '105', '106', '109','110');
    //if($_SESSION[usrId]==96)
    if (in_array($_SESSION[usrId], $user_id_array)) {
        if($_SESSION[usrId]== 110)       
		 header("location:main_tc.php?service_info=1522") ;
		 else
		 header("location:main_tc.php?service_info=1501") ;
        exit;
    } else if ($_SESSION[usrId] == 102) {
        header("location:main_tc.php?service_info=1517");
        exit;
    }
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
                function openWindow(str,service_info,ch)
                { 
                    window.open("view_billing_details.php?msisdn="+str+"&service_info="+service_info+"&ch="+ch,"mywindow","menubar=0,resizable=1,width=800,height=500,scrollbars=yes");
                }

                function openWindow1(pageName,str,service_info)
                {
                    window.open(pageName+".php?msisdn="+str+"&service_info="+service_info,"mywindow","menubar=0,resizable=1,width=650,height=500,scrollbars=yes");
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
                <?php
                exit;
            } else {
                include ("header.php");
            }
            ?>
            <TABLE border="0" cellpadding="1" cellspacing="1">
                <TR><TD width="30%" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='selectservice.php'><font color='red'>Home</font></a></TD></TR>
            </TABLE>
            <form name="frm" method="POST" action="" onSubmit="return checkfield()">
                <TABLE width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
                    <TBODY>

                        <TR>
                            <TD bgcolor="#FFFFFF" align="center"><B>Enter Mobile No.</B></TD>
                        </TR>

                        <TR>
                            <TD bgcolor="#FFFFFF" align="center">&nbsp;&nbsp;<INPUT name="msisdn" type="text" class="in" value="<?php echo $_REQUEST['msisdn']; ?>">
                                <input type='hidden' name='service_info' value=<?php echo $_REQUEST['service_info']; ?>>
                                <input type='hidden' name='ch' value=<?php echo $_REQUEST['ch']; ?>>
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
            if ($_POST['Submit'] == "Submit" && $_POST['msisdn'] != "") {
                $logPath = "/var/www/html/kmis/services/hungamacare/ccInterface/log_" . date("Ymd") . ".txt";
                $service_info = $_POST['service_info'];
                if ($_POST['service_info'] == 1509)
                    $service_info = 1511;
                elseif ($_POST['service_info'] == 1504)
                    $service_info = 1511;
                elseif ($_POST['service_info'] == 15071)
                    $service_info = 1507;
                elseif ($_POST['service_info'] == 15221 || $_POST['service_info'] == 15222)
                    $service_info = 1522;
                elseif ($_POST['service_info'] == 15211 || $_POST['service_info'] == 15212 || $_POST['service_info'] == 15213)
                    $service_info = 1521;
                elseif ($_POST['service_info'] == 15151)
                    $service_info = 1515;

                $serviceQuery = mysql_query("select servicename from master_db.tbl_app_service_master where serviceid=" . $_POST['service_info']);
                list($logServiceName) = mysql_fetch_array($serviceQuery);
                //echo $logServiceName;

                $logData = $_POST['msisdn'] . "#" . $_POST['service_info'] . "#" . $logServiceName . "\n";
                error_log($logData, 3, $logPath);
                if ($_REQUEST['service_info'] == 15222) {
                    $s_info = 1522;
                } else {
                    $s_info = $_REQUEST['service_info'];
                }
                $q = "select plan_id from master_db.tbl_plan_bank where S_id='" . $service_info . "' and sname='" . $s_info . "'";
                $planDataArray = mysql_query($q);
                while ($planData = mysql_fetch_array($planDataArray)) {
                    $planArray[] = $planData['plan_id'];
                }

                $select_query1 = "select msisdn, response_time, chrg_amount,circle from master_db.tbl_billing_success nolock where msisdn='$_POST[msisdn]' and service_id=" . $service_info;

                if (sizeof($planArray))
                    $select_query1 .=" and plan_id IN (" . implode(",", $planArray) . ")";

                $select_query2 = "select msisdn, response_time, chrg_amount,circle from master_db.tbl_billing_success_backup nolock where msisdn='$_POST[msisdn]' and service_id=" . $service_info;

                if (sizeof($planArray))
                    $select_query2.= " and plan_id IN (" . implode(",", $planArray) . ")";

                $select_query3 = " order by response_time desc limit 1";

                $mainQuery = "(" . $select_query1 . ") UNION (" . $select_query2 . ")" . $select_query3;
//echo $mainQuery;
                $query = mysql_query($mainQuery, $dbConn) or die(mysql_error());
                $numRows = mysql_num_rows($query);

                if ($numRows > 0) {
                    //mysql_select_db($$userDbName, $userDbConn);
                    if ($_POST['service_info'] == '15211' || $_POST['service_info'] == '15212' || $_POST['service_info'] == '15213')
                        $select_query1 = "select SUB_DATE, RENEW_DATE, circle, SUB_MODE, DNIS, STATUS from ";
                    else
                        $select_query1 = "select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS from ";
                    switch ($_POST['service_info']) {
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
                        case '15151':
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
                        case '15222':
                            $select_query1.= "airtel_smspack.TBL_VASTU_SUBSCRIPTION";
                            break;
                    }

                    $select_query1.=" where ANI='$_POST[msisdn]'";
                    $select_query1.=" and plan_id IN (" . implode(",", $planArray) . ")";
                    $select_query1.=" order by SUB_DATE desc limit 1";

                    //echo $select_query1;  die;
                    $querySubscription = mysql_query($select_query1) or die(mysql_error()); //,$userDbConn
                    $num = mysql_num_rows($querySubscription);
                    ?>
                <center><div width="85%" align="left" class="txt"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B><FONT COLOR="#FF0000">Subscription Status</FONT></B></div><center><br/>
                        <TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
                            <TBODY>
                                <TR height="30">
                                    <TD bgcolor="#FFFFFF" align="center"><B>Mobile No</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Registration.ID</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Activation</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Next Charging</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Last Charging</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Charged Amt.</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>Circle</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>SubscriptionMode</B></TD>
                                    <TD bgcolor="#FFFFFF" align="center"><B>&nbsp;</B></TD>
                                </TR>
                                <?php
                                $subStatus = -1;
                                list($msisdn, $response_time, $chrg_amount, $circle) = mysql_fetch_array($query);

                                //echo "hello: ".$msisdn.", ".$response_time.", ".$chrg_amount.", ".$circle;
                                list($SUB_DATE, $RENEW_DATE, $circle1, $MODE_OF_SUB, $DNIS, $subStatus) = mysql_fetch_array($querySubscription);
                                if ($_SESSION['usrId'] == 96) {
                                    echo "Already Subscribe to Entertainment Unlimited";
                                    exit;
                                }
                                ?>
                                <TR height="30">
                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                    echo $msisdn;
                                ?></TD>
                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                            echo $DNIS;
                                ?></TD>
                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                            echo $SUB_DATE;
                                ?></TD>
                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                            echo $RENEW_DATE;
                                ?></TD>
                                    <TD bgcolor="#FFFFFF" align="center" class="blue">&nbsp;
                                        <a href="javascript:void(0);" onclick="openWindow(<?php echo $msisdn; ?>,<?php echo $_POST['service_info']; ?>)">
                                            <?php echo $response_time; ?></a></TD>
                                    <TD bgcolor="#FFFFFF" align="right"><?php
                                echo $chrg_amount;
                                            ?>&nbsp;</TD>
                                    <TD bgcolor="#FFFFFF" align="right"><?php
                            echo $circle;
                                            ?>&nbsp;</TD>
                                    <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                            echo $MODE_OF_SUB;
                                            ?></TD>
                                    <TD bgcolor="#FFFFFF" align="center" class="blue" width='200px;'>&nbsp;<?php
                            $blacklistID = array(48, 68);
                            if (($subStatus == 1 || $subStatus == 11) && !in_array($_SESSION['usrId'], $blacklistID)) {
                                                ?>
                                            <a href="main.php?msisdn=<?php echo $msisdn; ?>&act=da&service_info=<?php echo $_POST['service_info']; ?>">Deactivate</a>
                                            <?php
                                            if ($subStatus == 11)
                                                echo "(Pending)";
                                        }
                                        elseif ($subStatus == 0) {
                                            echo "Not Active";
                                        } elseif ($subStatus == 11) {
                                            echo "Pending";
                                        }
                                        ?></TD>
                                </TR>				
                            </TBODY>
                        </TABLE><br/><br/><br/>
                        <?php
                    } else {
                        $notFound = 1;
                        echo "<div align='center'><B>No records found for this number</B></div>";
                    }
                    ?>
                    <?php if ($notFound != 1) { ?>
                        <center>
                            <div width="85%" align="left" class="txt"> 						
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <FONT COLOR="#FF0000">
                                <B>For Subscription History, Click on Last Charging</B></FONT> <?php if ($_POST['service_info'] == '1511') { ?>| <a href="javascript:void(0);" onclick="openWindow1('viewchargingDetails',<?php echo $msisdn; ?>,<?php echo $service_info; ?>)"><FONT COLOR="#FF0000"><B>Click here to view MCoupon history</B></FONT></a><?php } ?> 
                            </div>
                            <center><br/>
                            <?php } ?>
                            <?php
                            //mysql_select_db($$userDbName, $userDbConn);
                            $deactivationQuery1 = "select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS, SUB_TYPE, UNSUB_DATE, UNSUB_REASON from ";
                            //. $$unSubsTableName." where ANI='$_POST[msisdn]' order by UNSUB_DATE desc";

                            switch ($_POST['service_info']) {
                                case '1501':
                                    $deactivationQuery1 .= "airtel_radio.tbl_radio_unsub";
                                    break;
                                case '1502':
                                    $deactivationQuery1 .= "airtel_hungama.tbl_jbox_unsub";
                                    break;
                                case '1518':
                                    $deactivationQuery1 .= "airtel_hungama.tbl_comedyportal_unsub";
                                    break;
                                case '1503':
                                    $deactivationQuery1 .= "airtel_hungama.tbl_mtv_unsub";
                                    break;
                                case '1507':
                                    $deactivationQuery1 .= "airtel_vh1.tbl_jbox_unsub";
                                    break;
                                case '1511':
                                    $deactivationQuery1 .= "airtel_rasoi.tbl_rasoi_unsub";
                                    break;
                                case '1509':
                                    $deactivationQuery1 .= "airtel_manchala.tbl_riya_unsub";
                                    break;
                                case '1514':
                                    $deactivationQuery1 .= "airtel_EDU.tbl_jbox_unsub";
                                    break;
                                case '1513':
                                    $deactivationQuery1 .= "airtel_mnd.tbl_character_unsub1";
                                    break;
                                case '1504':
                                    $deactivationQuery1 .= "airtel_rasoi.tbl_storeatone_unsub";
                                    break;
                                case '15071':
                                    $deactivationQuery1 .= "airtel_vh1.tbl_vh1nightpack_unsub";
                                    break;
                                case '1515':
                                case '15151':
                                    $deactivationQuery1 .= "airtel_devo.tbl_devo_unsub";
                                    break;
                                case '1517':
                                    $deactivationQuery1 .= "airtel_SPKENG.tbl_spkeng_unsub";
                                    break;
                                case '1520':
                                    $deactivationQuery1 .= "airtel_hungama.tbl_pk_unsub";
                                    break;
                                case '1522':
                                case '15221':
                                case '15222':
                                    $deactivationQuery1 .= "airtel_hungama.tbl_arm_unsub";
                                    break;
                                case '15211':
                                    $deactivationQuery1 .= "airtel_smspack.TBL_ASTRO_SUBSCRIPTION_LOG";
                                    break;
                                case '15212':
                                    $deactivationQuery1 .= "airtel_smspack.TBL_SEXEDU_SUBSCRIPTION_LOG";
                                    break;
                                case '15213':
                                    $deactivationQuery1 .= "airtel_smspack.TBL_VASTU_SUBSCRIPTION_LOG";
                                    break;
                            }
                            $deactivationQuery1.=" where ANI='$_POST[msisdn]' order by UNSUB_DATE desc";

                            $queryunSubscription = mysql_query($deactivationQuery1, $dbConnDocomo) or die(mysql_error());
                            $numRows1 = mysql_num_rows($queryunSubscription);
                            if ($numRows1 > 0) {
                                ?>
                                <TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
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
                                        list($SUB_DATE, $RENEW_DATE, $circle, $MODE_OF_SUB, $DNIS, $subStatus, $SUB_TYPE,
                                                $UNSUB_DATE, $UNSUB_REASON) = mysql_fetch_array($queryunSubscription);
                                        ?>
                                        <TR height="30">
                                            <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                            echo $msisdn;
                                        ?></TD>
                                            <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                                    echo $DNIS;
                                        ?></TD>
                                            <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                                    echo $SUB_DATE;
                                        ?></TD>
                                            <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                                    echo $RENEW_DATE;
                                        ?></TD>
                                            <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                                    echo $circle;
                                        ?></TD>
                                            <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                                    echo $MODE_OF_SUB;
                                        ?></TD>
                                            <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                                    echo $subStatus;
                                        ?></TD>
                                            <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                                    echo $SUB_TYPE;
                                        ?></TD>
                                            <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                                    echo $UNSUB_DATE;
                                        ?></TD>
                                            <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php
                                    echo $UNSUB_REASON;
                                        ?></TD>
                                        </TR>				
                                    </TBODY>
                                </TABLE>
                                <?php
                            } else {
                                echo "<div align='center'><B>No history found</B></div>";
                            }
                        } elseif ($_GET['msisdn'] != "" && $_GET['act'] == "da") {
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

                            $result = mysql_query($Query1) or die(mysql_error());
                            echo "<div align='center'><B>Request for deactivation sent</B></div>";
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
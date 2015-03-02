<?php
session_start();
if (isset($_SESSION['authid'])) {
    include ("config/dbConnect.php");
    $service_array = array('1102' => 'MTS - 54646', '1101' => 'MTS - muZic Unlimited', '11011' => 'MTS - Mana Paata Mana', '1103' => 'MTS - MTV DJ Dial',
        '1111' => 'MTS - Bhakti Sagar', '1106' => 'MTS - Celebrity Chat', '1110' => 'MTS - Red FM', '1113' => 'MTS - MPD', '1124' => 'MTS - muZic2Cinema',
        '1123' => 'MTS - Monsoon Dhamaka', '1125' => 'MTS - Hasi Ke Fuhare', '1126' => 'MTS - Regional Portal', '1116' => 'MTS - Voice Alerts');
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
            include ("header.php");
            ?>
            <form name="frm" method="POST" action="" onSubmit="return checkfield()">
                <TABLE width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
                    <TBODY>    
                        <TR>
                            <TD bgcolor="#FFFFFF" align="center"><B>Enter Mobile No.</B></TD>
                        </TR>
                        <TR>
                            <TD bgcolor="#FFFFFF" align="center">&nbsp;&nbsp;<INPUT name="msisdn" type="text" class="in" value="<?php echo $_REQUEST['msisdn']; ?>">
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
                $msisdn = $_POST[msisdn];
                $seviceIdArray = array('1102', '1101', '11011', '1103', '1111', '1106', '1110', '1113', '1124', '1123', '1125', '1126', '1116');
                ?>
            <center><div width="85%" align="left" class="txt"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B><FONT COLOR="#FF0000">Subscription Status</FONT></B></div><center><br/>
                    <TABLE width="98%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
                        <TBODY>
                            <TR height="30">
                                <TD bgcolor="#FFFFFF" align="center"><B>Mobile No</B></TD>
                                <TD bgcolor="#FFFFFF" align="center"><B>Service</B></TD>
                                <TD bgcolor="#FFFFFF" align="center"><B>Activation</B></TD>
                                <TD bgcolor="#FFFFFF" align="center"><B>Status</B></TD>
                                <TD bgcolor="#FFFFFF" align="center"><B>Action</B></TD>
                            </TR>
                            <?php
                            $count = 0;
                            foreach ($seviceIdArray as $seviceId) {

                                $select_query1 = "select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS, DATEDIFF(RENEW_DATE,NOW()) as diff from ";
                                switch ($seviceId) {
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
//                                    case '1105':
//                                        $select_query1.= "mts_starclub.tbl_jbox_subscription";
//                                        break;
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
                                        break;
                                }

                                $select_query1.=" where ANI='$msisdn'";
                                //echo $select_query1;
                                $querySubscription = mysql_query($select_query1, $userDbConn) or die(mysql_error());
                                $num = mysql_num_rows($querySubscription);
                                if ($num > 0) {
                                    $count++;
                                    ?>

                                    <?php
                                    $subStatus = -1;
                                    list($SUB_DATE, $RENEW_DATE, $circle1, $MODE_OF_SUB, $DNIS, $subStatus, $daysLeft) = mysql_fetch_array($querySubscription);
                                    ?>


                                    <TR height="30">
                                        <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $msisdn; ?></TD>
                                        <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $service_array[$seviceId]; ?></TD>
                                        <TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $SUB_DATE; ?></TD>

                                        <TD bgcolor="#FFFFFF" align="center" class="blue" width='200px;'>&nbsp;<?php
                    if ($subStatus == 1) {
                        echo "Active";
                    } elseif ($subStatus == 0) {
                        echo "Not Active";
                    } elseif ($subStatus == 11) {
                        echo "Pending";
                    }
                                    ?></TD>
                                        <TD bgcolor="#FFFFFF" align="center" class="blue">&nbsp;
                                            <?php if ($subStatus == 1) { ?>
                                                <a href="allservicedetail.php?msisdn=<?php echo $msisdn; ?>&act=da&service_info=<?php echo $seviceId; ?>"><?php echo 'Deactivate'; ?></a>
                                            <?php
                                            } else {
                                                echo 'NA';
                                            }
                                            ?>
                                        </TD>
                                    </TR>

                                    <?php
                                }
                                ?>
                                <?php
                            }
                            if ($count == 0) {
                                echo "<div align='center'><B>No records found for this number</B></div>";
                            }
                            ?>
                        </TBODY>
                    </TABLE><br/><br/>
                    <?php
                } elseif ($_GET['msisdn'] != "" && $_GET['act'] == "da") {
                    if ($_GET['service_info'] == 1102)
                        $Query1 = "call mts_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                    elseif ($_GET['service_info'] == 1101 || $_GET['service_info'] == 11011)
                        $Query1 = "call mts_radio.RADIO_UNSUB('$_GET[msisdn]', 'CC')";
                    elseif ($_GET['service_info'] == 1103)
                        $Query1 = "call mts_mtv.MTV_UNSUB('$_GET[msisdn]', 'CC')";
                    elseif ($_GET['service_info'] == 1111)
                        $Query1 = "call dm_radio.DIGI_UNSUB('$_GET[msisdn]', 'CC')";
//                    elseif ($_GET['service_info'] == 1105)
//                        $Query1 = "call mts_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                    elseif ($_GET['service_info'] == 1106)
                        $Query1 = "call mts_starclub.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                    elseif ($_GET['service_info'] == 1110)
                        $Query1 = "call mts_redfm.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
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
                    elseif ($_GET['service_info'] == 1116)
                        $Query1 = "call mts_voicealert.JBOX_UNSUB('$_GET[msisdn]', 'CC')";
                    echo $Query1;
                    // $result = mysql_query($Query1, $dbConn) or die(mysql_error());
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
                    </tbody>
                </table>
                </body>
                </html>
                <?php
                mysql_close($dbConn);
            } else {
                header("Location:index.php");
            }
            ?>

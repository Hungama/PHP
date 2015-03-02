<?php
//echo "<pre>";print_r($_REQUEST);
session_start();
if (isset($_SESSION['authid'])) {
    //include ("config/dbConnect.php");
    include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
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
                 switch ($_POST['service_info']) {
                    case '1501':
                        $msg = "Entertainment Unlimited";
                        $subsTable = "airtel_radio.tbl_radio_subscription";
                        break;
                    case '1517':
                        $msg = "Spoken English";
                        $subsTable = "airtel_SPKENG.tbl_spkeng_subscription";
                        break;
                }
//                $getRecord = "select ani from airtel_radio.tbl_radio_subscription where ani =" . $_POST['msisdn'];
                $getRecord = "select ani from " . $subsTable . " where ani =" . $_POST['msisdn'];
                $query123 = mysql_query($getRecord, $dbConnAirtel) or die(mysql_error());
                $mRecord = mysql_fetch_row($query123);
                if ($mRecord[0] != '')
                    echo "<center>Already Subscribe to ".$msg."</center>";
                else
                    echo "<center>Not Subscribe to ".$msg."</center>";
                exit;
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
    mysql_close($dbConnAirtel);
} else {
    header("Location:index.php");
}
?>
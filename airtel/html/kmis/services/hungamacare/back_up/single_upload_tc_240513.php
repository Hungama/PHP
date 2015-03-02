<?php
session_start();
if (isset($_SESSION['authid'])) {
    include ("config/dbConnect.php");
    $log_path = "/var/www/html/kmis/services/hungamacare/log/tc_log/log_".date('dmy').".log";
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
                    if((document.getElementById('msisdn').value=="")){
                        alert("Please enter a mobile no.");
                        return false;
                    }
                    if(document.getElementById('price').value=="" || radioValue=='active'){
                        alert("Please select a price point.");
                        document.getElementById('price').focus();
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

                        <TR height="30" id='price12'>
                            <TD bgcolor="#FFFFFF"><B>Mobile No.</B></TD>
                            <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
                                <INPUT name="serviceid" id="serviceid" type="hidden"  value="<?php echo $_REQUEST['service_info']; ?>">
                                <INPUT name="msisdn" id="msisdn" type="text" class="in" value="">
                            </TD>
                        </TR>
                        <TR height="30">
                            <TD bgcolor="#FFFFFF"><B>Service Type</B></TD>
                            <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
                                <?php if($_REQUEST['service_info'] == 1501){?>
                                <b>Airtel EU </b>	
                                <?php }else{?>
                                <b>Airtel SE </b>
                                <?php }?>	
                            </TD>
                        </TR>
                        <TR height="30" id='price12'>
                            <TD bgcolor="#FFFFFF"><B>Price Point</B></TD>
                            <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name="price" id='price' class="in" id="price">
                                    <option value=''>--select--</option>
                                    <?php
                                    $plan_record = array();
                                    $get_plan_info = "select plan_id,iamount,iValidty from master_db.tbl_plan_bank where sname=".$_REQUEST['service_info'];
                                    $plan_result_query = mysql_query($get_plan_info, $dbConn);
                                    while ($plan_record = mysql_fetch_array($plan_result_query)) {
                                        if ($plan_record[1] >= 60)
                                            echo "<option value=" . $plan_record[0] . ">Rs." . $plan_record[1] . " / " . $plan_record[2] . "days </option>";
                                    }
                                    if ($_REQUEST['service_info'] == 1517)
                                        echo "<option value=57>Rs 5 / 1 days </option>";
                                    ?>	
                                </select>
                            </TD>
                        </TR>
                        <TR height="30">
                            <td align="center" colspan="2" bgcolor="#FFFFFF">
                                <input name="Submit" type="submit" class="txtbtn" value="Submit" onSubmit="return checkfield();"/>			
                            </td>
                        </TR>

                    </TBODY>
                </TABLE>
            </form><br/><br/>
            <?php
            if ($_POST['Submit'] == "Submit" && $_POST['msisdn'] != "") {
               
//                $url = "http://10.2.73.156/airtel/airtel.php?msisdn=" . $_POST['msisdn'] . "&mode=TELECALL&reqtype=1&planid=" . $_POST['price'] . "&subchannel=TELECALL&rcode=100,101,102&serviceid=1501";
                $url = "http://10.2.73.156/airtel/airtel.php?msisdn=" . $_POST['msisdn'] . "&mode=TELECALL&reqtype=1&planid=" . $_POST['price'] . "&subchannel=TELECALL&rcode=100,101,102&serviceid=".$_POST['serviceid'];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $data = curl_exec($ch);
                curl_close($ch);
                 $logstring = $url."#".$data."#".date('his')."\r\n";
                 error_log($logstring,3,$log_path);
                if ($data == '100') {
                    echo "<center>Request for " . $_POST['msisdn'] . " Accepted Successfully</center> ";
                }
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
<?php

error_reporting(-1);
ob_start();
session_start();
include("web_admin.js");
if ($_SESSION['usrId']) {
    include("config/dbConnect.php");
    include_once("main_header.php");
    ?>
    <tr><td height="10"></td></tr>
    <table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
        <form action="xls_first_consent_logs.php" method='post' name="first_consent_logs" id="first_consent_logs">
            <tr align='center'>
                <td> Start Date:
                    <input type="Text" name="timestamp" value="">
                    <a href="javascript:show_calendar('document.first_consent_logs.timestamp', document.first_consent_logs.timestamp.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                </td>
            </tr>
            <tr align='center'>
                <td> End Date:
                    <input type="Text" name="timestamp1" value="">
                    <a href="javascript:show_calendar('document.first_consent_logs.timestamp1', document.first_consent_logs.timestamp1.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                </td>
            </tr>
            <tr>
                <td height="10"></td>
            </tr>
            <tr align='center'>
                <td><input type='submit' name='submit' value='submit'></td>
            </tr> 
            <tr>
                <td height="50"></td>
            </tr>
            <tr>
                <td bgcolor="#0369b3" height="1"></td>
            </tr>
        </form>
        <script type="text/javascript">
            //            function validate(){ alert('hi');
            //                var timestamp=document.getElementById('timestamp').value;
            //                var timestamp1=document.getElementById('timestamp1').value;
            //                if(timestamp == ''){
            //                    alert('please select start date');
            //                    return false;
            //                }else if(timestamp1 ==''){
            //                    alert('please select End date');
            //                    return false;
            //                }
            //                return true;
            //            }
        </script>
    </tbody>
    </table>
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
    <?

    mysql_close($dbConn);
}

else
    echo "<a href='index.php'>Please Log1n</a>";
?>
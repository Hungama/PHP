<?php
session_start();
error_reporting(0);

if (empty($_SESSION['loginId'])) {
    $redirect = "index.php?logerr=invalid";
    header("Location: $redirect");
}
include ("config/dbConnect.php");
include("web_admin.js");
include("header.php");
$displaydate = date("Y-m-d");
?>
<style type="text/css" src="../css/all.css"></style>
<script language="javascript" type="text/javascript" src="../datetimepicker/datetimepicker.js"></script>
<link rel="stylesheet" href="style.css" type="text/css">
<style type="text/css">
    <!--
    .style3 {font-family: "Times New Roman", Times, serif}
    -->
</style>
<script language="javascript">
    function validateData() {
        if(document.getElementById('service').value =="") {
            alert("Please select service");
            document.getElementById('service').focus();
            return false;
        }
        if(document.getElementById('date').value =="") {
            alert("Please select date");
            document.getElementById('date').focus();
            return false;
        }
        return true;
    }
</script>
<form name="tstest" action='xls_EtisalatSmsHistory.php' method='POST' onSubmit="return validateData();" enctype="multipart/form-data">

    <table width="55%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
        <tr height="30">
            <td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Service</b></td>
            <td bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='service' id="service" onchange="showHidemore()">
                    <option value=''>Select Service</option>
                    <option value='116'>Jokes</option>
                    <option value='119'>Spanish Football League</option>
                    <option value='125'>English Premier League</option>
                    <option value='117'>Hollywood</option>
                    <option value='118'>Fun News</option>
                    <option value='174'>Life Style</option>
                    <option value='177'>Motivational</option>
                </select></td>
        </tr>
        <tr height="30">
            <td bgcolor="#FFFFFF">&nbsp;&nbsp;<b>Select Date</b></td>
            <td bgcolor="#FFFFFF">&nbsp;&nbsp;<input type="text" id="date" maxlength="25" size="25" name="date" value="<?php echo $displaydate; ?>">
                <a href="javascript:NewCal('date','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
            </td>
        </tr>


        <tr><td bgcolor="#FFFFFF" colspan='2' align='center'><input type='Submit' name='submit' value='submit' onSubmit="return validateData();"/></tr>
    </table>

</form>
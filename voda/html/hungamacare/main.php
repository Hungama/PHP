<?php
session_start();
if (isset($_SESSION['authid']))
{
	include ("dbConnect.php");
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
</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php
if($_REQUEST['service_info']==0)
 {
	include_once("main_header.php");?>
	<TABLE width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
	<TBODY>
    <TR>
        <TD bgcolor="#FFFFFF" align="center"><B>Please Select Service</B></TD>
    </TR>
    </tbody>
	 </table> 
	<?php
exit;
}
else
{
	include ("header.php");
}
?>
<TABLE width="30%" align="left" border="0" cellpadding="1" cellspacing="1">

<TR>
        <TD bgcolor="#FFFFFF" align="left">&nbsp;&nbsp;&nbsp;&nbsp;<B><a href='selectservice.php'><font color='red'>Home</font></a></B></TD>
    </TR>
</TABLE>


<form name="frm" method="POST" action="" onSubmit="return checkfield()">
<TABLE width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<TBODY>
    
	<TR>
        <TD bgcolor="#FFFFFF" align="center"><B>Enter Mobile No.</B></TD>
    </TR>

    <TR>
        <TD bgcolor="#FFFFFF" align="center">&nbsp;&nbsp;<INPUT name="msisdn" type="text" class="in" value="<?php echo $_REQUEST['msisdn']; ?>">
		<input type='hidden' name='service_info' value=<?php echo $_REQUEST['service_info'];?>>
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
    if ($_POST['Submit'] == "Submit" && $_POST['msisdn'] != "")
    {
		$service_info=$_POST['service_info'];
		$select_query2="select msisdn, date_time, chrg_amount,circle from master_db.tbl_billing_success where msisdn='$_POST[msisdn]' and service_id=".$_POST['service_info']." order by date_time desc limit 1";
		$query = mysql_query($select_query2, $dbConn) or die(mysql_error());
		$numRows = mysql_num_rows($query);
		if ($numRows > 0)
        	{
            	mysql_select_db($$userDbName, $userDbConn);
			
		$select_query1= "select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS from ";
		switch($_POST['service_info'])
			{
				case '1302':
					$select_query1.= "vodafone_hungama.tbl_jbox_subscription";
				break;
				case '1301':
					$select_query1.= "vodafone_radio.tbl_radio_subscription";
				break;
				case '1303':
					$select_query1.= "vodafone_hungama.tbl_mtv_subscription";
				break;
				case '1307':
					$select_query1.= "vodafone_vh1.tbl_jbox_subscription";
				break;
				case '1310':
					$select_query1.= "vodafone_redfm.tbl_jbox_subscription";
				break;
			}
			
			$select_query1.=" where ANI='$_POST[msisdn]' order by SUB_DATE desc limit 1";
			$querySubscription = mysql_query($select_query1,$dbConn) or die(mysql_error());
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
	$subStatus=-1;
 list($msisdn, $date_time, $chrg_amount,$circle) = mysql_fetch_array($query);
 list($SUB_DATE,$RENEW_DATE,$circle1,$MODE_OF_SUB,$DNIS,$subStatus) = mysql_fetch_array($querySubscription);
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
<a href="javascript:void(0);" onclick="openWindow(<?php echo $msisdn;?>,<?php echo $_REQUEST['service_info'];?>)">
<?php echo $date_time; ?></a></TD>
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

$blacklistID=array(48,68);
if (($subStatus == 1 || $subStatus == 11) && !in_array($_SESSION['usrId'],$blacklistID)) 
{
$dateArray=array(17,18,19,20);
if(!in_array(date("H"),$dateArray))
{
?>
	<a href="main.php?msisdn=<?php echo $msisdn;?>&act=da&service_info=<?php echo $_REQUEST['service_info'];?>">Deactivate</a>
<?php
if($subStatus == 11)
	echo "(Pending)";
}
}
elseif($subStatus==0)
{
	echo "Not Active";
}
elseif($subStatus == 11)
{
	echo "Pending";
}

?></TD>
</TR>				
</TBODY>
</TABLE><br/><br/><br/>
<?php

        } else
        {
            echo "<div align='center'><B>No records found for this number</B></div>";
        }

?>
<center><div width="85%" align="left" class="txt"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<FONT COLOR="#FF0000"><B></B></FONT></div><center><br/>
<?php
		mysql_select_db($$userDbName, $userDbConn);
		$deactivationQuery1="select SUB_DATE, RENEW_DATE, circle, MODE_OF_SUB, DNIS, STATUS, SUB_TYPE, UNSUB_DATE, UNSUB_REASON from ";
		//. $$unSubsTableName." where ANI='$_POST[msisdn]' order by UNSUB_DATE desc";

		switch($_POST['service_info'])
		{
			case '1302':
				$deactivationQuery1 .= "vodafone_hungama.tbl_jbox_unsub";
			break;
			case '1301':
				$deactivationQuery1 .= "vodafone_radio.tbl_radio_unsub";
			break;
			case '1303':
				$deactivationQuery1 .= "vodafone_mtv.tbl_mtv_unsub";
			break;
			case '1307':
				$deactivationQuery1 .= "vodafone_vh1.tbl_jbox_unsub";
			break;
			case '1310':
				$deactivationQuery1 .= "vodafone_redfm.tbl_jbox_unsub";
			break;
		}
		$deactivationQuery1 .= " where ANI='$_POST[msisdn]' order by UNSUB_DATE desc";
		
		$queryunSubscription = mysql_query($deactivationQuery1,$dbConnDocomo) or die(mysql_error());
        	$numRows1 = mysql_num_rows($queryunSubscription);
        if ($numRows1 > 0)
        {

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

  list($SUB_DATE,$RENEW_DATE,$circle,$MODE_OF_SUB,$DNIS,$subStatus,$SUB_TYPE,
  $UNSUB_DATE,$UNSUB_REASON) = mysql_fetch_array($queryunSubscription);

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
} else
        {
            echo "<div align='center'><B>No history found</B></div>";
        }
    } elseif ($_GET['msisdn'] != "" && $_GET['act'] == "da")
        {
			if($_GET['service_info']==1302)
				$Query1 = "call vodafone_hungama.JBOX_UNSUB('$_GET[msisdn]', 'CC')";			
			if($_GET['service_info']==1307)
				$Query1 = "call vodafone_vh1.jbox_unsub('$_GET[msisdn]', 'CC')";			
			if($_GET['service_info']==1310)
				$Query1 = "call vodafone_redfm.JBOX_UNSUB('$_GET[msisdn]', 'CC')";			
			
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
} else
{
    header("Location:index.php");
}

?>
<?php
include_once '/var/www/html/kmis/services/hungamacare/config/dbConnect.php';
$msisdn=$_REQUEST['msisdn'];
$table=array('tbl_jbox_subscription'=>'reliance_hungama',
'tbl_mtv_subscription'=>'reliance_hungama','tbl_cricket_subscription'=>'reliance_cricket');
$k=0;
$rowInfo=array();

foreach($table as $key=>$value)
{		
	$query="select ANI,dnis,SUB_DATE,RENEW_DATE,chrg_amount,circle,MODE_OF_SUB,USER_BAL from $value.$key where ANI=$msisdn and status=1";
	$queryresult=mysql_query($query);	
	$row= mysql_fetch_array($queryresult);
	$rowInfo[$k]=$row;
	$k++;	
}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Hungama Customer Care</title>
<link rel="stylesheet" href="http://192.168.100.212/kmis/services/hungamacare/style.css" type="text/css">
<style type="text/css">
<!--
.style3 {font-family: "Times New Roman", Times, serif}
-->
</style>
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
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr> 
    <td style="padding-left:20px"><img src="http://192.168.100.212/kmis/services/hungamacare/images/logo.png" alt="Hungama" align="left" border="0" hspace="0" vspace="15"></td>
  </tr>
  <tr>
    <td bgcolor="#0369b3" height="1"></td>
  </tr>
</tbody></table>
<br><br><br>
<form name="frm" method="POST" action="" onSubmit="return checkfield()">
<TABLE width="30%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
<TBODY>
    
	<TR>
        <TD bgcolor="#FFFFFF" align="center"><B>Enter Mobile No.</B></TD>
    </TR>

    <TR>
        <TD bgcolor="#FFFFFF" align="center">&nbsp;&nbsp;<INPUT name="msisdn" type="text" class="in" value="<?php echo $_REQUEST['msisdn']; ?>">
		<input type='hidden' name='service_info' value=<?php echo $service_info;?>>
		<input type='hidden' name='serviceType' value=<?php echo $serviceType;?>>
		<input type='hidden' name='usrId' value=<?php echo $_REQUEST['usrId'];?>>
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


<table border='1' width='100%'>
<?php
for($j=0;$j<3;$j++)
{
	if($j==0)
	{ $ServiceId=1202;}
	if($j==1)
	{ $ServiceId=1203;}
	if($j==2)
	{ $ServiceId=1208;}
	if($rowInfo[$j]['ANI']!='')
{
?>

<tr>
<th><font size=2>MobileNo.</font></th><th><font size=2>Registration Id</font></th><th><font size=2>Activation</font></th><th><font size=2>NextCharging</font></th><th><font size=2>ChargedAmount</font></th><th><font size=2>UserBalance</font></th><th><font size=2>Circle</font></th><th><font size=2>SubscriptionMode</font></th><th><font size=2>CurrentStatus</font></th><th><font size=2>Option</font></th>
</tr>
<tr>
<td align='center'><font size=2><?php echo $rowInfo[$j]['ANI']; $flag=1;?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['dnis'];?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['SUB_DATE'];?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['RENEW_DATE'];?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['chrg_amount'];?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['USER_BAL'];?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['circle'];?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['MODE_OF_SUB'];?></font></td>
<td align='center'><font size=2>ACTIVE </font></td>
<td align='center'><font size=2>
<?php 
	echo "<a href='http://119.82.69.212/reliance/deactivate.php?msisdn=$msisdn&ServiceId=$ServiceId'>DEACTIVATE</a>";?></font> </td>
</tr>
<?php } } ?>
<?php if($flag!=1) { ?>
	<div align='center' class="txt"><b>No Record Found, Please try again!!</b></div>
<?php }?>
</table>
<br>
<br>
<br>
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


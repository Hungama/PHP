<?php
session_start();
if(isset($_SESSION['authid']))
{
	include("config/dbConnect.php");
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
  
  var radioValue;
  radioValue=getRadioValue();

  if((document.getElementById('channel').value=="") && (document.getElementById('channel_dec').value=="")){
		alert("Please select a channel.");
		return false;
   }
   if(document.getElementById('price').value=="" && radioValue=='active'){
		alert("Please select a price point.");
		document.getElementById('price').focus();
		return false;
   }
   if(document.frm.upfile.value==""){
		alert("Please select a file to upload.");
		document.frm.upfile.focus();
		return false;
   }
   return true;
}

function showTable(radioname)
{
	if(radioname=='a')
	{
		document.getElementById('price12').style.display = 'table-row';
		document.getElementById('chanel12').style.display = 'table-row';
		document.getElementById('chanel13').style.display = 'none';
	}
	if(radioname=='d')
	{
		document.getElementById('channel').value='';
		document.getElementById('chanel12').style.display = 'none';
		document.getElementById('price12').style.display = 'none';
		document.getElementById('chanel13').style.display = 'table-row';
	}
}
function getRadioValue()
{
	for (index=0; index < document.frm.upfor.length; index++)
	{
		if (document.frm.upfor[index].checked) 
		{
			var radioValue = document.frm.upfor[index].value;
			return radioValue;
			break;
		}
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php 
	include("header.php");
	 if($_SERVER['REQUEST_METHOD']=="POST") 
	{
		 //echo "<pre>";		 print_r($_REQUEST);
		$channel=$_POST['channel'];
		$msisdn=$_POST['msisdn'];
		if(trim($channel)=='')
		{
			$channel=$_POST['channel_dec'];
		}
		mysql_select_db($$userDbName, $userDbConn);
		switch($_REQUEST['upfor'])
		{
			case 'active':
				$reqtype=1;
				break;
			case 'deactive':
				$reqtype=2;
				break;
		}
		$actiionUrl="http://10.130.14.107/MTS/MTS.php?";
		$actiionUrl .="msisdn=".$msisdn."&mode=".$channel."&reqtype=".$reqtype."&planid=".$_REQUEST['price'];
		$actiionUrl .="&subchannel=".$channel."&serviceid=".$_REQUEST['service_info']."&ac=0";
		echo $urlResponse=file_get_contents($actiionUrl);
	}
if(!isset($_POST['Submit']))
	{
?>
<TABLE width="80%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B><FONT COLOR="#FF0000">Activate Deactivate Utility</FONT></B></TD>
		<TD bgcolor="#FFFFFF" COLSPAN=2><B><FONT COLOR="#FF0000">
		</TD>
      </TR>
</TABLE>	  
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()">
    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
      <TBODY>
      <TR height="30">
        <TD bgcolor="#FFFFFF" align='center'><B>Action For</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<INPUT TYPE="radio" NAME="upfor" id="upfor" value="active" class="in" checked onClick="showTable('a');"> Activation 
		<?php if($_SESSION['usrId']!=48 && $_SESSION['usrId']!=69){?>
			<INPUT TYPE="radio" NAME="upfor" id="upfor" value="deactive" onClick="showTable('d');"> Deactivation
		<?php }?>
		</TD>
      </TR>
	<?php

	// to Fetch the record for the service Name
	
	$get_service_name="select servicename,serviceid from master_db.tbl_app_service_master where serviceid=".$_GET['service_info'];
	$result_query=mysql_query($get_service_name,$dbConn);
	
	// end codfe to fetch the record for Sevice name

	// to Fetch the record for the service Name
		
	$plan_record=array();
	$get_plan_info="select plan_id,iamount from master_db.tbl_plan_bank where s_id=".$_GET['service_info'];
	$plan_result_query=mysql_query($get_plan_info,$dbConn);
	
	// end codfe to fetch the record for Sevice name
	?>
      <TR height="30">
        <TD bgcolor="#FFFFFF" align='center'><B>Service Type</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<?php
			$service_record=mysql_fetch_row($result_query);
			echo "<b>".$service_record[0]."</b>";
		?>
		<input type='hidden' name='service_info' value="<?php echo $_GET['service_info'];?>">
		</TD>
      </TR>
     
	 <TR height="30" id='chanel13' style="display:none; border='1px;'" width='100%' >
     <TD bgcolor="#FFFFFF" align='center'><B>Channel</B></TD>
     <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name="channel_dec" id="channel_dec" class="in">
		<option value="">--select--</option>
		<option value="CC">CCI</option>
		<option value="IVR">IVR</option>
		<option value="TC">TELECALLING</option>
		<option value="USSD">USSD</option>
		<option value="OBD">OBD</option>
		<option value="IBD">IBD</option>
	</select>
		</TD>
      </TR>
	  
	  <TR height="30" id='chanel12'>
		<TD bgcolor="#FFFFFF" align='center'><B>Channel</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name="channel" id="channel" class="in">
			<option value="">--select--</option>
			<option value="TC">TELECALLING</option>
			<option value="USSD">USSD</option>
			<option value="OBD">OBD</option>
			<option value="CC">CCI</option>
			<option value="IVR">IVR</option>
     		<option value="IBD">IBD</option>
		  <?php if($_REQUEST['service_info']==1101) {?>
			<option value="TRCV">TRCV</option>
			<!--<option value="push">push</option>-->
		  <?php } ?>
			
			
		</select>
		</TD>
      </TR>

	<TR height="30" id='price12'>
        <TD bgcolor="#FFFFFF" align='center'><B>Price Point</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<select name="price" id='price' class="in">
			<option value=''>--select--</option>
		<?php
			
				while($plan_record=mysql_fetch_array($plan_result_query))
				echo "<option value=".$plan_record[0].">".$plan_record[1]."</option>";
		?>	
			 <?php if($_REQUEST['service_info']==1101) {?>
			<option value="4">0</option>
		  <?php } ?>

		</select>
		</TD>
      </TR>
	  
	<TR height="30">
      <TD bgcolor="#FFFFFF" align='center'><B>Insert Msisdn</TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;
		<INPUT name="msisdn" id='msisdn' type="text" class="in"></TD>
      </TR>
      <TR height="30">
      <td align="center" colspan="2" bgcolor="#FFFFFF">
		<input name="Submit" type="submit" class="txtbtn" value="Upload" onSubmit="return checkfield();"/>			
      </td>
    </TR>

  </TBODY>
  </TABLE>
  </form>
  
  <br/><br/>
<?php }?>
<?php echo "<div align='center' class='txt'><B>".$msg."</B></div>"; ?>
<br/><br/><br/><br/><br/><br/><br/><br/><br/>
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
}
else
{
	header("Location:index.php");
}
?>
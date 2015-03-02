<?php
session_start();
ini_set('max_execution_time', 0);
error_reporting(0);
include("dbDigiConnect.php");

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
        window.parent.location.href = 'login.php?logerr=logout';
}

function checkfield() {
	if(document.frm.time.value  == "") {
		alert("Please Select Time.");
		document.frm.time.focus();
		return false;
	}
	if(document.frm.service.value  == "") {
		alert("Please Select Service.");
		document.frm.service.focus();
		return false;
	}
	return true;
}

</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php
        if($rest==12)
                $logoPath='images/RelianceCricketMania.jpg';
        elseif($rest==14)
                $logoPath='images/uninor.jpg';
        else
                $logoPath='images/logo.png';

        include("header.php");
		if($_SERVER['REQUEST_METHOD']=="POST" && $_REQUEST['service']) {
			$service = $_REQUEST['service'];
			$time = $_REQUEST['time'];

			if($service == 'digima') {
				header("Location:insertDigiLiveMIS.php?time=".$time);
			}
		}
?>
<TABLE width="80%" align="center" border="0" cellpadding="0" cellspacing="0" class="txt">
      <TBODY>
      <?php  if($_GET['msg']==1) { ?>
        <TR height="30" width="100%">
			<TD colspan="4" bgcolor="#FFFFFF" align="center">
				<?php echo "DIGIMA Live MIS created successfully."; ?>
			</TD>
        </TR>
      <?php } else if($_GET['msg']==2 && $_GET['service']){ ?>
		<TR height="30" width="100%">
			<TD colspan="4" bgcolor="#FFFFFF" align="center">
				<?php echo "DIGIMA Live MIS not created successfully. Please Try Again!!"; ?>
			</TD>
        </TR>
	  <?php }  ?>
      </TBODY>
</TABLE>
<?php if($dbConn) { ?>
<div align='center' style="font-size:17px;" class='txt'><b>Live MIS</b><br/></div><br/>
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="25%" align="center"  bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" style="font-size:15px;" class='txt'>
      <TBODY>
		  <TR>
			<td bgcolor="#ffffff" align='center'><b>Date :</b></td><td bgcolor="#ffffff" align='center'><?php echo date("d F Y");?></td>
		  </TR>
		  <TR>
			<td bgcolor="#ffffff" align='center'><b>Time :</b></td>
			<td bgcolor="#ffffff" align='center'>
				<?php $maxtimeQ = mysql_query("SELECT date_format(now(),'%H') as maxtime",$dbConn);
					$data = mysql_fetch_array($maxtimeQ);
					$maxtime = $data['maxtime'];
				?>
				<select name='time'>
					<option value="">Select Time</option>
					<?php for($i=1; $i<$maxtime; $i++) { ?>
						<option value="<?php echo $i;?>"><?php echo $i;?></option>
					<?php }?>
				</select>
			</td>
		  </TR>
		  <TR>
			<td bgcolor="#ffffff" align='center'><b>Service :</b></td>
			<td bgcolor="#ffffff" align='center'>
				<select name='service' id="service">
					<option value=''>Select Service</option>
					<option value='digima'>DIGIMA</option>
				</select>
			</td>
		  </TR>
		  <TR>
			<TD colspan="2" align='center' bgcolor="#ffffff">
				<input name="Submit" type="submit" class="txtbtn" value="Submit" onSubmit="return checkfield();">
			</TD>
		  </TR>
      </TBODY>
    </TABLE>
</form>
<?php } else { echo "Database connectivity Problem. Please try again!"; }?>
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
<?php mysql_close($dbConn); ?>
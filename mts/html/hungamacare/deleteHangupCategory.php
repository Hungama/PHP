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
   if(document.frm.language.value==""){
		alert("Please select language.");
		document.frm.language.focus();
		return false;
   }	
   return true;
}
</script>
</head>

<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php 
	$service_info=$_REQUEST['service_info'];
	$rest = substr($service_info,0,-2);
	if($rest==12)
		$logoPath='images/RelianceCricketMania.jpg';
	elseif($rest==14)
		$logoPath='images/uninor.jpg';
	else
		$logoPath='images/logo.png';

	include("header.php");
	$timeFrom = mktime(9,30,0);
	$timeTo = mktime(21,30,0);
	$currTime = mktime(date('H'),date('i'),date('s'));

	 if($_SERVER['REQUEST_METHOD']=="POST") {
		 $message = addslashes($_REQUEST['message']);
		 $hangupType = $_REQUEST['hanguptype'];
		 $priority = $_REQUEST['priority'];
		 if($message!="" && $hangupType!="" && $priority!="") {
			 $result = mysql_query("SELECT count(*) FROM mts_radio.tbl_radio_message WHERE type='".$hangupType."'",$dbConn);
			 list($count) =	mysql_fetch_array($result);
			 if($count) {
				 $query="update mts_radio.tbl_radio_message set message='".$message."',priority='".$priority."' WHERE type='".$hangupType."'";	
				 $msg = "Hangup message updated successfully."; 
			 } else {			 
				 $query="insert into mts_radio.tbl_radio_message(message,type,circle,priority) values('".$message."','".$hangupType."' ,'pan' ,'".$priority."')";
				 $msg = "Hangup message added successfully."; 
			 }
			 $queryIns = mysql_query($query,$dbConn);			 		
		 } else {
			 $msg = "Invalid parameter, Please try again!";
		 }
	 }
?>
<TABLE width="80%" border="0" cellpadding="0" cellspacing="0" class="txt">      
	<TR height="30">
		<?php if(isset($msg)) { ?>
		<TD bgcolor="#FFFFFF" align='center'><FONT COLOR="#FF0000"><?php echo $msg;?></FONT></TD>
		<?php } ?>
	</TR>
	<TR height="30">		
		<TD bgcolor="#FFFFFF" align='right'><a href='hangupMessage.php'><FONT COLOR="#FF0000">Add/Edit Message</FONT></a></TD>
	</TR>
</TABLE>	  
 <form name="frm" method="POST">
    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
      <TBODY>      
		<?php
		// to Fetch the record for hangup type
		$get_hangup_info="select distinct(language) from master_db.tbl_hangup_type order by language";
		$hangup_result=mysql_query($get_hangup_info,$dbConn);
		?>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Hangup Language</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='lang' id='lang'>
				<option value="">Select Hungup Language</option>
				<?php while($row = mysql_fetch_array($hangup_result)) { ?>
					<option value="<?php echo $row['language']?>"><?php echo ucwords($row['language']);?></option>
				<?php }?>				
			</select>
		</TD>
      </TR>	
      <TR height="30">
        <TD align="center" colspan="2" bgcolor="#FFFFFF"><input name="Submit" type="submit" class="txtbtn" value="Filter" onSubmit="return checkfield();"/></TD>
     </TR>
  </TBODY>
  </TABLE>
  </form>  
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

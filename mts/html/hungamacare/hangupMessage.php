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
 
function showHideCircle(type) { //alert('hi'+type);
	if(type=="hangup" || type=="NLhangup" || type=="hangupl" || type=="hangupnl") {
		document.getElementById('circleData').style.display = 'table-row';
	} else {
		document.getElementById('circleData').style.display = 'none';
	}
}

 function checkfield(){  	 
   if(document.frm.hanguptype.value==""){
		alert("Please select hangup type.");
		document.frm.hanguptype.focus();
		return false;
   }	
   if(document.frm.message.value==""){
		alert("Please enter message.");
		document.frm.message.focus();
		return false;
   }
   if(document.frm.message.value) {
	var iChars = "#^+&\\\'/\"<>";
	for (var i = 0; i < document.frm.message.value.length; i++) {
		if (iChars.indexOf(document.frm.message.value.charAt(i)) != -1) {
			alert ("The text message has special characters. \nThese are not allowed.\n");
			return false;
        }
    }
   }
   if(document.frm.priority.value==""){
		alert("Please select message proprity.");
		document.frm.priority.focus();
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
	
	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka', 'HAY'=>'Haryana','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','PAN'=>'PAN');

	 if($_SERVER['REQUEST_METHOD']=="POST") {
		 $message = addslashes($_REQUEST['message']);
		 $hangupType = $_REQUEST['hanguptype'];
		 $circle = "pan";
		 if($hangupType == 'hangup' || $hangupType=='NLhangup') $circle="pan";
		 elseif($hangupType == 'hangupl' || $hangupType=='hangupnl') {
			 $circle=$_REQUEST['circle'];	
			 if($hangupType == 'hangupl') $hangupType = "hangup";
			 elseif($hangupType == 'hangupnl') $hangupType = "NLhangup";			 
		 }
		 $priority = $_REQUEST['priority'];
		 if($message!="" && $hangupType!="" && $priority!="") {
			 $result = mysql_query("SELECT count(*) FROM mts_radio.tbl_radio_message_Test WHERE type='".$hangupType."' and  circle='".strtolower($circle)."'");
			 list($count) =	mysql_fetch_array($result);
			 if($count) {
				 $query="update mts_radio.tbl_radio_message_Test set message='".$message."',priority='".$priority."' WHERE type='".$hangupType."' and circle='".strtolower($circle)."'";	
				 $msg = "Hangup message updated successfully."; 
			 } else {			 
				 $query="insert into mts_radio.tbl_radio_message_Test(message,type,circle,priority) values('".$message."','".$hangupType."' ,'".strtolower($circle)."' ,'".$priority."')";
				 $msg = "Hangup message added successfully."; 
			 }
			 $queryIns = mysql_query($query);			 		
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
		<TD bgcolor="#FFFFFF" align='right'><a href='addHangupCategory.php'><FONT COLOR="#FF0000">Add/Edit Category</FONT></a> <!--| <a href='deleteHangupCategory.php'><FONT COLOR="#FF0000">Delete Category</FONT></a>--></TD>
	</TR>
</TABLE>	  
 <form name="frm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="50%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
      <TBODY>      
		<?php
		// to Fetch the record for hangup type
		$get_hangup_info="select hangup_type,category,language from master_db.tbl_hangup_type order by language,category";
		$hangup_result=mysql_query($get_hangup_info,$dbConn);
		?>
      <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Hangup Type</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='hanguptype' id='hanguptype' onchange="showHideCircle(this.value);">
				<option value="">Select Hungup Type</option>
				<?php while($row = mysql_fetch_array($hangup_result)) { ?>
					<option value="<?php echo $row['hangup_type']?>"><?php echo ucwords($row['language'])." - ".ucwords($row['category']);?></option>
				<?php }?>	
					<option value="hangup">All - Live</option>
					<option value="NLhangup">All - Non-Live</option>
					<option value="hangupl">Live</option>
					<option value="hangupnl">Non-Live</option>
			</select>
		</TD>
      </TR>
	  <TR height="30" style="display:none" id='circleData'>
        <TD bgcolor="#FFFFFF" valign="top"><B>Circle</B></TD>
        <TD bgcolor="#FFFFFF" valign="top">&nbsp;&nbsp;<select name='circle' id='circle'>
				<?php foreach($circle_info as $key=>$value) { ?>
					<option value='<?php echo $key;?>'><?php echo $value;?></value>				
				<?php }?>				
			</select></TD>
      </TR>	
	  <TR height="30">
        <TD bgcolor="#FFFFFF" valign="top"><B>Message</B></TD>
        <TD bgcolor="#FFFFFF" valign="top">&nbsp;&nbsp;<textarea name="message" id="message" cols="40" rows="4" maxlength="500"></textarea></TD>
      </TR>
	  <TR height="30">
        <TD bgcolor="#FFFFFF"><B>Message Priority</B></TD>
        <TD bgcolor="#FFFFFF">&nbsp;&nbsp;<select name='priority' id='priority'>
				<option value="">Select Priority</option>
				<?php for($i=1; $i<=5; $i++) { ?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php }?>				
			</select>
		</TD>
      </TR>	
      <TR height="30">
        <TD align="center" colspan="2" bgcolor="#FFFFFF"><input name="Submit" type="submit" class="txtbtn" value="Submit" onSubmit="return checkfield();"/></TD>
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

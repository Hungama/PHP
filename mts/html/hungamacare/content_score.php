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

function showService(value) {
	if(value == 1) { 	 
		document.getElementById('service1').style.display = 'block';
		document.getElementById('service2').style.display = 'none';
	} else if(value == 2) {
		document.getElementById('service1').style.display = 'none';
		document.getElementById('service2').style.display = 'block';
	} 
	return true;
}

function checkfield() {
	if(document.getElementById('service2').value == "" && document.getElementById('service1').value == "") {
		alert("Please select service name.");
		return false;
	}
	if(document.getElementById('searchtxt').value != "" && document.getElementById('skeyword').value == "") {
		alert("Please select search keyword.");
		document.getElementById('skeyword').focus();
		return false;
	}
	if(document.getElementById('skeyword').value != "" && document.getElementById('searchtxt').value == "") {
		alert("Please select search keyword.");
		document.getElementById('skeyword').focus();
		return false;
	}
	return true;
}


</script>
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<?php
		$logoPath='images/logo.png';
        include("header.php");	
?>
<TABLE width="80%" border="0" cellpadding="0" cellspacing="0" class="txt">
	<TBODY>
		<TR height="30" width="100%">
			<TD colspan="4" bgcolor="#FFFFFF" align="right"><a href='update_contentscore.php'><B><FONT COLOR="#FF0000">Update Content</FONT></a></B></TD>
		</TR>
	</TBODY>
</TABLE>
<div  align='center' style="font-size:17px;" class='txt'><b>Download Content Score</b><br/></div><br/>
 <form name="frm" method="POST" action="downLoadContent.php" onSubmit="return checkfield()" enctype="multipart/form-data">
    <TABLE width="45%" align="center"  bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" style="font-size:15px;" class='txt'>
      <TBODY>
		<TR>
			<td bgcolor="#ffffff" height="30"><b>Service Name :</b></td>
			<td bgcolor="#ffffff" height="30">
				<?php	$query1 = "SELECT DISTINCT(servicename) FROM master_db.tbl_content_score"; 
						$service1 = mysql_query($query1,$dbConn) ?>
				<select name='service1' style='display:block' id="service1">
					<option value="">Select service</option>
					<?php while($row1= mysql_fetch_array($service1)) { 
						if($row1['servicename']) { ?>
						<option value="<?php echo $row1['servicename'];?>"><?php echo $row1['servicename'];?></option>
					<?php } }?>
				</select>
			</td>
		</TR>
		<TR>
			<td bgcolor="#ffffff" height="30"><b>Search :</b></td>
			<td bgcolor="#ffffff" height="30">&nbsp;<INPUT TYPE="text" NAME="searchtxt" value="" id="searchtxt" size="40">&nbsp;&nbsp; By 
				<SELECT NAME="skeyword" id="skeyword">
					<OPTION value="">Search Keyword</OPTION>
					<OPTION value="song_name">Song Name</OPTION>
				</SELECT>
			</td>
		</TR>
		<TR>
			<TD colspan="2" align='center' bgcolor="#ffffff">
				<input name="Submit" type="submit" class="txtbtn" value="Download" onSubmit="return checkfield();">
			</TD>
		</TR>
      </TBODY>
    </TABLE>
</form>
<br/><br/><br/><br/>
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
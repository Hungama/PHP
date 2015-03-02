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
</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<br/>

<center><div width="85%" align="left" class="txt">&nbsp;&nbsp;<FONT COLOR="#FF0000"><B>Bulk Upload History</B></FONT></div><center><br/>
<TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
  <TBODY>
  <TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><B>File Name</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Added On</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Service Type</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Channel</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Price</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Uploaded For</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Processing Status</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Total Count</B></TD>
  </TR>
	<?php
	//mysql_select_db($DB_DATABASE_DOCMO, $dbConnDocomo);
	mysql_select_db($$userDbName, $userDbConn);
	$get_query="select file_name, added_on, service_type, channel, price_point, upload_for,status,total_file_count from bulk_upload_history where added_by='$_SESSION[loginId]' order by id desc";

	$query = mysql_query($get_query, $userDbConn) or die(mysql_error());
	while(list($file_name, $datetime, $service_type, $channel, $price, $upload_for,$status,$total_file_count) = mysql_fetch_array($query)) {
	?>
	  <TR height="30">
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $file_name; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $datetime; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $service_type; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $channel; ?></TD>
		<TD bgcolor="#FFFFFF" align="right"><?php echo $price; ?>&nbsp;</TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $upload_for; ?></TD>
		<? if(isset($status) && $status==0)
				$process_status='Not Processed'; 	
			else
				$process_status='Processing done';
			if(!isset($total_file_count))
				$total_file_count="Not availbale";
			?>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $process_status; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $total_file_count; ?></TD>
		
	  </TR>				
	<?php
	}	
	?>
</TBODY>
</TABLE>
<?php
	mysql_close($dbConn);
}
?>
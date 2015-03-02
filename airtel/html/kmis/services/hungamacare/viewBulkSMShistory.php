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

<center><div width="85%" align="left" class="txt">&nbsp;&nbsp;<FONT COLOR="#FF0000"><B>SMS Bulk Upload History</B></FONT></div><center><br/>
<TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
  <TBODY>
  <TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><B>File Name</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Added On</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Service Id</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Upload For</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Added By</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Processing Status</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Total Count</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Message</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Process Time</B></TD>
</TR>
	<?php
	
	mysql_select_db($$userDbName); //, $userDbConn

	$get_query = "select m.batch_id,m.file_name,m.added_by,m.added_on,m.status,m.total_file_count,m.service_id,m.process_time,md.message,m.upload_for from master_db.bulk_message_history m INNER JOIN master_db.tbl_message_data md ON m.msg_id=md.msg_id order by m.added_on desc limit 50";


	$query = mysql_query($get_query) or die(mysql_error()); //, $userDbConn
	while(list($batchId,$file_name,$added_by,$datetime,$status,$totalCount,$serviceId,$processTime,$message,$upload_for) = mysql_fetch_array($query)) { ?>
	  <TR height="30">
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $file_name; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $datetime; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $serviceId; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo ucwords($upload_for); ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $added_by; ?></TD>
		<?php if(isset($status) && $status==0)
				$process_status='Pending'; 	
			elseif($status == 1)
				$process_status='Processed';
			
			if(!isset($totalCount)) 
				$totalCount="Not availbale";			
			?>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $process_status; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $totalCount; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $message; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $processTime; ?></TD>	
	  </TR>				
	<?php }	?>
</TBODY>
</TABLE>
<?php
	mysql_close($dbConn);
}
?>
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

<center><div width="85%" align="left" class="txt">&nbsp;&nbsp;<FONT COLOR="#FF0000"><B>Bulk Upload History</B></FONT> | <B><a href='sms_bulk_upload.php?service_info=<?php echo $_REQUEST['s_id'];?>' ><FONT COLOR="#FF0000">Home</FONT></a></B></div><center><br/>
<TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
  <TBODY>
  <TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><B>File Name</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Added On</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Message</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Total Count</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Processing Status</B></TD>

</TR>
	<?php	
	$get_query = "select m.batch_id,m.file_name,m.added_by,m.added_on,m.total_file_count,m.service_id,md.message,m.status from master_db.bulk_message_history m INNER JOIN master_db.tbl_message_data md ON md.msg_id=m.msg_id where m.added_by='mts_smscc' and m.service_id='".$_REQUEST['s_id']."' order by m.added_on desc limit 30";
	//echo $get_query;
	
	$query = mysql_query($get_query) or die(mysql_error());	
	while(list($id,$filename,$addedby, $addedon,$total_count, $service_id, $message,$status) = mysql_fetch_array($query)) {
	?>
	  <TR height="30">
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $filename; ?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $addedon; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $message; ?></TD>
		<? if(isset($status) && $status==0)
				$process_status='Not Processed'; 	
			else if($status==1)
				$process_status='Processed';
		
			if(!isset($totalCount))
				$totalCount="Not availbale";			
		?>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $total_count; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $process_status; ?></TD>		
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

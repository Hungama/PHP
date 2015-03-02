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
	<TD bgcolor="#FFFFFF" align="center"><B>Uploaded For</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Processing Status</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Total Count</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Success Count</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Failure Count</B></TD>
	<!--<TD bgcolor="#FFFFFF" align="center"><B>InQueue Count</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Rejected Count</B></TD>-->
</TR>
	<?php
	
	mysql_select_db($$userDbName, $userDbConn);
	
	$get_query = "select id,status,batch_id,channel,file_name,added_on,upload_for,status,total_file_count,service_id,price_point,success_count,failure_count,InRequest from billing_intermediate_db.bulk_upload_history where added_by='$_SESSION[loginId]' and service_id='".$_GET['sid']."' and upload_for='active' order by added_on desc limit 30";
	//echo $get_query;
	
	$query = mysql_query($get_query, $userDbConn) or die(mysql_error());
	while(list($id,$status,$batchId, $channel,$file_name, $datetime, $upload_for, $status, $totalCount,$serviceId,$planId,$success_count,$failure_count,$request_count) = mysql_fetch_array($query)) {
	?>
	  <TR height="30">
		<TD bgcolor="#FFFFFF">&nbsp;<?php if($status==3) { ?><a href='http://10.130.14.107/hungamacare/bulkuploads/<?php echo $serviceId ?>/log/<?php echo $file_name; ?>'><?php echo $file_name; ?></a><?php } else { echo $file_name; }?></TD>
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $datetime; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $upload_for; ?></TD>
		<? if(isset($status) && $status==0)
				$process_status='Not Processed'; 	
			else if($status==1)
				$process_status='In Process';
			else if($status==2 || $status==3) 
				$process_status='Status Available';
		
			if(!isset($totalCount))
				$totalCount="Not availbale";
			if($status==2) $rejected_count = $totalCount - ($failure_count+$success_count+$request_count);
			else $rejected_count=0;			
			
		?>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $process_status; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $totalCount; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $success_count?$success_count:"-"; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $failure_count?$failure_count:"-"; ?></TD>
		<!--<TD bgcolor="#FFFFFF">&nbsp;<?php echo $request_count?$request_count:"-"; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $rejected_count?$rejected_count:"-"; ?></TD>-->
		
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

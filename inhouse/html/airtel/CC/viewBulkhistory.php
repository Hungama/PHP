<?php
session_start();
if(isset($_SESSION['authid']))
{
    include_once("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
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
<script>
function goback() {
    history.go(-1);
}
</script>

</head>
<body leftmargin="0" topmargin="0" link="#000000" alink="#000000" bgcolor="#ffffff" text="#000000" marginheight="0" marginwidth="0" vlink="#000000">
<br/>

<center><div width="85%" align="left" class="txt">&nbsp;&nbsp;<FONT COLOR="#FF0000"><a href="javascript:goback()">Goback</a> | <B>Bulk Upload History</B></FONT></div><center><br/>
<TABLE width="85%" align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
  <TBODY>
  <TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><B>File Name</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Added On</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Service Id</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Uploaded For</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Processing Status</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Total Count</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Actual Success</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Actual Failure</B></TD>
</TR>
	<?php
	
	mysql_select_db($$userDbName); //, $userDbConn
	$service_id=$_GET['sid'];
	$added_by=$_SESSION['loginId'];
	$cond="and added_by='".$added_by."'";
	//if($service_id == '1509') $service_id=1511;
	$get_query = "select batch_id,channel,file_name,added_on,added_by,upload_for,status,total_file_count,service_id,success_count,failure_count from airtel_hungama.bulk_upload_history 
	where date(added_on)>='2013-01-20' $cond order by added_on desc limit 50 ";

	/*if($service_id == '1509') $get_query .=" and service_id='1511' and price_point IN (30,48) ";
	elseif($service_id == '1504') $get_query .=" and service_id='1511' and price_point IN (34) ";
	else $get_query .=" and service_id='".$_GET['sid']."' and date(added_on)>='2013-01-02' ";*/

	//$get_query .=" order by added_on desc limit 50";
	
	//echo $get_query;
	
	$query = mysql_query($get_query,$dbConnAirtel) or die(mysql_error()); //, $userDbConn
	while(list($batchId, $channel,$file_name, $datetime,$added_by,$upload_for, $status, $totalCount,$serviceId,$success_count,$failure_count) = mysql_fetch_array($query)) {
	?>
	  <TR height="30">
		<TD bgcolor="#FFFFFF">&nbsp;<?php if($status==3) { ?><a href='http://10.2.73.156/kmis/services/hungamacare/bulkuploads/<?php echo $serviceId ?>/log/<?php echo $file_name."_log.txt"; ?>'><?php echo $file_name; ?></a><?php } else { echo $file_name; }?> <?php //echo $file_name; ?></a></TD>
		<!-- <a href="http://10.2.73.156/kmis/services/hungamacare/downloadbulksummary.php?service_id=<?=$service_id;?>&filename=<?=$file_name?>"> -->
		<TD bgcolor="#FFFFFF" align="center">&nbsp;<?php echo $datetime; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $serviceId; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $upload_for; ?></TD>
		<?php if(isset($status) && $status==0)
				$process_status='Not Processed'; 	
			elseif($status == 2)
				$process_status='Processed';
			elseif($status == 3)
				$process_status='Status Available';
			elseif($status == 1 && $upload_for=='deactive') $process_status='Status Available';
			
			if(!isset($totalCount)) 
				$totalCount="Not availbale";			
			?>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $process_status; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $totalCount; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $success_count; ?></TD>
		<TD bgcolor="#FFFFFF">&nbsp;<?php echo $failure_count; ?></TD>	
	  </TR>				
	<?php }	?>
</TBODY>
</TABLE>
<?php
	mysql_close($dbConnAirtel);
}
?>
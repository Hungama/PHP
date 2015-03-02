<?php
session_start();
if(isset($_SESSION['authid']))
{
	include("dbConnect.php");
	$get_query="select batch_id,file_name,added_on,service_type,channel,price_point,upload_for,total_file_count,service_id,status from ";
	$get_query .=" vodafone_hungama.bulk_upload_history nolock where added_by='$_SESSION[loginId]' and status in(1,2) order by batch_id desc";
	
	$query = mysql_query($get_query);
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
<TABLE align="center" bgcolor="#0369b3" border="0" cellpadding="1" cellspacing="1" class="txt">
  <TBODY>
  <TR height="30">
	<TD bgcolor="#FFFFFF" align="center"><B>File Name</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Added On</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Uploaded For</B></TD>
	<TD bgcolor="#FFFFFF" align="center"><B>Total Count</B></TD>
 </TR>
<?php
	while($summarydata = mysql_fetch_array($query)) 
	{		
		$explodedData=explode($summarydata['batch_id']."_",$summarydata['file_name']);		
		$UploadedFile = substr($explodedData[0], 0, -1).".txt"; 
		$fileUrl="http://10.43.248.137/hungamacare/bulkuploads/".$summarydata['service_id']."/".$summarydata['file_name'].".csv";
		$excellFile=$summarydata['file_name'].'.csv';
	?>
		<a href=<?php echo $fileUrl;?>> </a>
		<TR height="30">
		<TD bgcolor="#FFFFFF" align="center">
		<font color='blue'>
		<?php
		if($summarydata['status']==2)
		{
		?> 
		 <a href=<?php echo $fileUrl;?>>
		<?php } echo $UploadedFile;?>
			</a>
		</font></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $summarydata[2];?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $summarydata[6];?></TD>
		<TD bgcolor="#FFFFFF" align="center"><?php echo $summarydata[7];?></TD>
	 </TR>
<?php
	
}
mysql_close($dbConn);
}

?>
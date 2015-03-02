<?php
ob_start();
session_start();
include("web_admin.js");
include_once("main_header.php");
$serviceName=$_REQUEST['serviceName'];
//echo $serviceName ;
if($_SESSION['usrId']){

	include ("config/dbConnect.php");
	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
	//onSubmit="return checkfield1()"
?>
	<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<?php
	if(isset($_GET['error']))
	{
		echo "<tr align='center'><td colspan='2'>";
		echo "<font color='red' size='2'>Please select <I><b>From date</b></I> less than <I><b>To Date<B/><I/><BR/></font>";
		echo "</td></tr>";
	}
	?>
	<tr align='center'>
	<td colspan='2'>
	<!-- Changes Done for Calling Log with serviceName in Form Action  -->
	<!--<form name="tstest" action='callingLog.php' method='POST'>-->
	<form name="tstest" action="callingLog.php?serviceName=<?php echo $serviceName?>" method='POST'>		
		Date From:<input type="Text" name="timestamp" value="">
		<a href="javascript:show_calendar('document.tstest.timestamp', document.tstest.timestamp.value);">
		<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>

		Date To:<input type="Text" name="timestamp1" value="">
		<a href="javascript:show_calendar('document.tstest.timestamp1', document.tstest.timestamp1.value);">
		<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>

		<input type='submit' name='submit' value='View Data'>	
	</form>
	</td>
	<td><a href='http://10.130.14.107/hungamacare/showReport.php?serviceName=<?php echo $serviceName?>'>Show Report</a></td>
	</tr>
	</table>
<?php
			
	if($_REQUEST['timestamp']!='')
		$view_date1=date("Y-m-d",strtotime($_REQUEST['timestamp']));
	else
		$view_date1=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y"))); //date("Y-m-d",strtotime(date("Ymd")-1));


	if($_REQUEST['timestamp1']!='')
		$view_date2=date("Y-m-d",strtotime($_REQUEST['timestamp1']));
	else
		$view_date2=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y"))); //date("Y-m-d",strtotime(date("Ymd")-1));

	if($view_date1>$view_date2)
	{
		header("location:http://10.130.14.107/hungamacare/callingLog.php?error=1");
		exit;
	}
	
	if($_REQUEST['circle_info1']=='')
		$circle_data='all';
	else
		$circle_data=$_REQUEST['circle_info1'];
	
	echo "<table class='txt' align='center' border='0' cellpadding='0' cellspacing='0' width='100%'>";
	echo "<tr><td><a href='downloadCsv.php?view_date1=".$view_date1."&view_date2=".$view_date2."'>Download Csv</td></tr>";
	echo "</table>";
	
	$mis_array=array();
  
	// TO select Calllog Table as per Service Name 

	$mis_data_query="select msisdn,call_date,dnis,duration_in_sec,circle,status,call_time from"; 
	if($serviceName=='54646' || $serviceName=='')
		$mis_data_query .=" mis_db.tbl_54646_calllog";
	if($serviceName=='mtv')
		$mis_data_query .=" mis_db.tbl_mtv_calllog";
	if($serviceName=='endless')
		$mis_data_query .=" mis_db.tbl_radio_calllog";
    if($serviceName=='mtsdevotional')
        $mis_data_query .=" mis_db.tbl_Devotional_calllog";	
	if($serviceName=='fmj')
        $mis_data_query .=" mis_db.tbl_mtv_calllog";	
	if($serviceName=='redfm')
        $mis_data_query .=" mis_db.tbl_redfm_calllog";
	if($serviceName=='mtscmd')
        $mis_data_query .=" mis_db.tbl_radio_calllog";
	if($serviceName=='mtsva')
        $mis_data_query .=" mis_db.tbl_voicealert_calllog";
	// Make Query as per DNIS & Operator name 

	$mis_data_query .=" where DATE(call_date) between '$view_date1' and '$view_date2'";
	if($serviceName=='mtv')
		$mis_data_query .=" and dnis=546461";
	if($serviceName=='54646' || $serviceName=='')								
		$mis_data_query .=" and dnis not in(546461)";		// MTS 54646
	if($serviceName=='endless')
		$mis_data_query .=" and dnis = 52222";		// MTS Endless
	if($serviceName=='mtsdevotional')
        $mis_data_query .=" and dnis = 5432105";  	//MTS Devotional
	if($serviceName=='fmj')
        $mis_data_query .=" and dnis IN ('5432155','54321551','54321552','54321553')";  	//MTS FMJ
	if($serviceName=='redfm')
        $mis_data_query .=" and dnis IN ('55935')";  	//MTS RedFM
	if($serviceName=='mtscmd')
        $mis_data_query .=" and dnis IN ('5222212')";  	//MTS Comedy
	if($serviceName=='mtsva')
        $mis_data_query .=" and dnis like '54444%'";  	//MTS Voice Alert
	
	if($serviceName=='mtsva') {
        $mis_data_query .=" UNION select msisdn,call_date,dnis,duration_in_sec,circle,status,call_time from mis_db.tbl_voicealertOBD_calllog where DATE(call_date) between '$view_date1' and '$view_date2' and dnis like '54444%' ";
	}
	//echo $mis_data_query;
	$mis_data = mysql_query($mis_data_query,$dbConn);
	$result_row=mysql_num_rows($mis_data);
	
	if($result_row>0){
	?>
	<table class="txt" align="center" border="1" cellpadding="0" cellspacing="0" width="80%">
	<tbody>
	<?php

	echo "<tr><td align='center'><b>Report Date</b></td><td><b>Msisdn</b></td><td><b>DNIS</b></td><td><b>Duration In Sec</b></td><td><b>circle</b></td><td><b>status</b></td><td><b>Call Time</b></td></tr>";
	while($mis_array=mysql_fetch_array($mis_data))
	{
		if($mis_array[5]==1)
			$status1='Active';
		else
			$status1='NotActive';

		$display_text  = "<tr><td>".$mis_array[1]."</td>";
		$display_text .= "<td>".$mis_array[0]."</td>";
		$display_text .= "<td>".$mis_array[2]."</td>";
		$display_text .= "<td>".$mis_array[3]."</td>";
		$display_text .= "<td>".$circle_info[strtoupper($mis_array[4])]."</td>";
		$display_text .= "<td>".$status1."</td>";
		$display_text .= "<td>".str_replace("-",':',$mis_array[6])."</td>";
		$display_text .= "</tr>";

		echo $display_text;
	}
	}
	else
	{
		echo "<tr><td align='center'>";
		echo "Data Not Available";
		echo "</td></tr>";
		echo "</tbody>";
		echo "</table>";
	}

	mysql_close($dbConn);
	}
	else
	{
		echo "Please Do The Login First<Br>";
		echo "<a href='http://10.130.14.107/hungamacare'>Click Here to Login</a>";
	}

?>

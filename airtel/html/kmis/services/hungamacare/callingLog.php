<?php
ob_start();
session_start();
include("web_admin.js");
include_once("main_header.php");
$serviceName=$_REQUEST['serviceName'];
//echo $serviceName ;
if($_SESSION['usrId']){

	include ("config/dbConnect.php");
	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAR'=>'Haryana');
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
	<td><a href='http://10.2.73.156/kmis/services/hungamacare/showReport.php?serviceName=<?php echo $_GET['serviceName'];?>'>Show Report</a></td>
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
		header("location:http://10.2.73.156/kmis/services/hungamacare/callingLog.php?error=1");
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
	if($serviceName=='endlessmusic')
		$mis_data_query .=" mis_db.tbl_radio_calllog";
	if($serviceName=='airtel_mtv')
		$mis_data_query .=" mis_db.tbl_mtv_calllog";
	if($serviceName=='54646' || $serviceName=='')
		$mis_data_query .=" mis_db.tbl_54646_calllog";		// TataIndicom54646  calllog
	if($serviceName=='vh1')
		$mis_data_query .=" mis_db.tbl_54646_calllog";		// TataIndicom54646  calllog
	if($serviceName=='goodlife')
		$mis_data_query .=" mis_db.tbl_54646_calllog";		// TataIndicom54646  calllog
	if($serviceName=='airriya')
		$mis_data_query .=" mis_db.tbl_riya_calllog";		// Airtel RIA  calllog
	if($serviceName=='airpd')
		$mis_data_query .=" mis_db.tbl_edu_calllog";
	if($serviceName=='airmnd')
		$mis_data_query .=" mis_db.tbl_mnd_calllog";
	if($serviceName=='aircmd')
		$mis_data_query .=" mis_db.tbl_54646_calllog";
	if($serviceName=='airdevo')
		$mis_data_query .=" mis_db.tbl_devotional_calllog";
	
	// Make Query as per DNIS & Operator name 

	$mis_data_query .=" where DATE(call_date) between '$view_date1' and '$view_date2'";
	if($serviceName=='airtel_mtv')
		$mis_data_query .=" and dnis in(546461,546461000) ";
	if($serviceName=='endlessmusic')						// Indicom 54646
		$mis_data_query .=" and dnis in(59090)";
	if($serviceName=='54646' || $serviceName=='')							// Indicom MTV
		$mis_data_query .=" and dnis like '54646%' and dnis not in('546461','546461000','5464612')";
	if($serviceName=='vh1')													// Indicom MTV
		$mis_data_query .=" and dnis=55841 ";
	if($serviceName=='goodlife')											// Indicom MTV
		$mis_data_query .=" and dnis=55001 ";
	if($serviceName=='airriya')											// Indicom MTV
		$mis_data_query .=" and dnis IN ('5500169','54646169') ";
	if($serviceName=='airpd')											// airtel PD
		$mis_data_query .=" and dnis=53222345 ";
	if($serviceName=='airmnd')											// airtel MND
		$mis_data_query .=" and dnis=5500196";
	if($serviceName=='aircmd')											// airtelMPMC
		$mis_data_query .=" and dnis='5464612'";
	if($serviceName=='airdevo')											// Airtel Devotional
		$mis_data_query .=" and dnis like '51050%' ";

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
		echo "<a href='http://10.2.73.156/kmis/services/hungamacare'>Click Here to Login</a>";
	}

?>
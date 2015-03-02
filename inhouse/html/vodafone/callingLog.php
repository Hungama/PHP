<?php
ob_start();
session_start();
include("web_admin.js");
include_once("main_header.php");
$serviceName=$_REQUEST['serviceName'];
if($_SESSION['usrId']){

	include ("dbConnect.php");
	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');

	//---------pause circle array -------
	$pauseArray = array('201'=>'Lava','202'=>'Lemon','203'=>'Maxx','204'=>'Videocon','205'=>'MVL','206'=>'Chaze','207'=>'Intex','208'=>'iBall', '209'=>'Fly', '210'=>'Karbonn','211'=>'Hitech','212'=>'MTech','213'=>'Rage','214'=>'Zen','215'=>'Micromax','216'=>'Celkon');
	//-----------------------------------

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
	<?php
		$var12="http://119.82.69.212/vodafone/showReport.php?serviceName=".$serviceName;

	if($_SESSION['usrId']!=118)
	{
	?>
	<td><a href=<?php echo $var12;?>>Show Report</a></td>

	<?php } ?>
	</tr>
	</table>
<?php
			
	if($_REQUEST['timestamp']!='')
		$view_date1=date("Y-m-d",strtotime($_REQUEST['timestamp']));
	else
		$view_date1=date("Y-m-d",strtotime(date("Ymd")-1));

	if($_REQUEST['timestamp1']!='')
		$view_date2=date("Y-m-d",strtotime($_REQUEST['timestamp1']));
	else
		$view_date2=date("Y-m-d",strtotime(date("Ymd")-1));

	if($view_date1>$view_date2)
	{
		header("location:http://119.82.69.212/vodafone/callingLog.php?error=1");
		exit;
	}
	
	if($_REQUEST['circle_info1']=='')
		$circle_data='all';
	else
		$circle_data=$_REQUEST['circle_info1'];
	
	echo "<table class='txt' align='center' border='0' cellpadding='0' cellspacing='0' width='100%'>";
	echo "<tr><td><a href='downloadCsv.php?view_date1=".$view_date1."&view_date2=".$view_date2."&serviceName=".$serviceName."'>Download Csv</td></tr>";
	echo "</table>";
	
	$mis_array=array();
  
	// TO select Calllog Table as per Service Name 
	if($serviceName=='vodap') {
		$mis_data_query="select msisdn,call_date,dnis,duration_in_sec,circle,status,call_time,substr(dnis,9,3) as dnis1 from master_db.tbl_voda_calllog";
	} else {
		$mis_data_query="select msisdn,call_date,dnis,duration_in_sec,circle,status,call_time from master_db.tbl_voda_calllog";
	}
	
	// Make Query as per DNIS & Operator name 
	$mis_data_query .=" where DATE(call_date) between '$view_date1' and '$view_date2' ";

	if($serviceName=='voda54646')								
		$mis_data_query .=" and dnis LIKE '54646%' and dnis not like '%p%' and operator in ('VODM')";	// Vodafone 54646 - dnis NOT IN ('546461','54646935')
	if($serviceName=='vodamtv')								
		$mis_data_query .=" and dnis LIKE '54646%' and operator in ('VODM')";			// Merger: NOT IN ('54646935') Vodafone MTV: dnis in(546461)
	if($serviceName=='vodaredfm')								
		$mis_data_query .=" and dnis in(55935) and operator in ('VODM')";			// Vodafone REDFM: dnis in(54646935) 
	if($serviceName=='vodavh1')								
		$mis_data_query .=" and dnis in(55841) and operator in ('VODM','voda')";			// Vodafone REDFM: dnis in(54646935) 
	if($serviceName=='vodap')								
		$mis_data_query .=" and dnis like '%p%' and operator in ('VODM','voda')";			// Vodafone Pause Code

		
	//echo $mis_data_query; die;
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
		if($mis_array[4]=='' || $mis_array[4]=='0' || $mis_array[4]=='pan')
			$circle_info[strtoupper($mis_array[4])]='Others';

		if($circle_info[strtoupper($mis_array[4])]=='')
		{
			$circle_info[strtoupper($mis_array[4])]='others';
		}
		if($serviceName=='vodap') { $circleVal = $pauseArray[$mis_array[7]]; if(!$circleVal) $circleVal='Other'; } 
		else $circleVal=$circle_info[strtoupper($mis_array[4])];

		$display_text .= "<td>".$circleVal."</td>";
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
		echo "<a href='http://119.82.69.212/kmis/services/hungamacare'>Click Here to Login</a>";
	}

?>

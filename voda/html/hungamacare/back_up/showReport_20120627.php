<?php
ob_start();
session_start();
include("web_admin.js");
include_once("main_header.php");
$serviceName=strtolower($_REQUEST['serviceName']);

if($_SESSION['usrId'])
{
	include ("dbConnect.php");
	$circle_info=array('UND'=>'Others','DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh','J'=>'Jammu-Kashmir');
	//onSubmit="return checkfield1()"
?>
	<table class="txt" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<td>&nbsp;&nbsp;<a href='http://10.43.248.137/hungamacare/allReport.php'>Back</a></td>
	<tr align='center'><td colspan='2'>
	<form name="tstest" action="showReport.php?serviceName=<?php echo $serviceName?>" method='POST'>
		Select Date:<input type="Text" name="timestamp" value="">
		<a href="javascript:show_calendar('document.tstest.timestamp', document.tstest.timestamp.value);"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
		Select circle:<select name='circle_info1'>
		<option value='all'>All</option>
		<?php
			foreach($circle_info as $circle_id=>$circle_val)
			{
				echo "<option value=$circle_id>$circle_val</option>";
			}
		?>

		</select>
		<input type='submit' name='submit' value='View Data'>
	</form>
	</td>
	<td><a href='http://10.43.248.137/hungamacare/callingLog.php?serviceName=<?php echo $serviceName;?>'>Callling Log</a></td>
	</tr>
	</table>
<?php
	if($_REQUEST['timestamp']!='')
		$view_date1=date("Y-m-d",strtotime($_REQUEST['timestamp']));
	else
		$view_date1= date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
	if($_REQUEST['circle_info1']=='')
		$circle_data='all';
	else
		$circle_data=$_REQUEST['circle_info1'];

	$mis_array=array();
	$mis_data_query="select report_date,type,circle,service_id,charging_rate,sum(total_count),mode_of_sub,mous,pulse,total_sec
	from master_db.dailyReportVodafone where report_date='$view_date1' ";
	
	switch($serviceName)
	{
		case 'voda54646' :
					$mis_data_query .= " and service_id=1302"; 
		break;
		case 'vodamtv' :
					$mis_data_query .= " and service_id=1303";
		break;
		/*case 'vodaredfm' :
					$mis_data_query .= " and service_id=13";
		break;*/
	}

	if($circle_data=='all')
		$mis_data_query .= " group by circle,charging_rate,mode_of_sub,type order by type";
	else
		$mis_data_query .= " and circle='$circle_data' group by circle,charging_rate,mode_of_sub,type order by type";

	//echo $mis_data_query;
	$mis_data = mysql_query($mis_data_query,$dbConn);
	$result_row=mysql_num_rows($mis_data);

	if($result_row>0){
	?>
	<table class="txt" align="center" border="1" cellpadding="0" cellspacing="0" width="80%">
	<tbody>
	<?php

	echo "<tr><td align='center'><b>Report Date</b></td><td><b>Type</b></td><td><b>Total Count</b></td><td><b>Circle</b></td><td><b>Service Name</b></td></tr>";
	while($mis_array=mysql_fetch_array($mis_data))
	{
		if(isset($mis_array[3]))
		{
			$get_service_name="select servicename,serviceid from master_db.tbl_app_service_master where serviceid=$mis_array[3]";
			$service_data = mysql_query($get_service_name,$dbConn);
			$service_name=mysql_fetch_row($service_data);
			$mis_array[3] ;
			switch($service_name[1])
			{
				case '1302':
					$service_name[0]='Vodafone54646';
				break;
				case '1303':
					$service_name[0]='MTVVodafone';
				break;
				/*case '1303':
					$service_name[0]='VodafoneRedFM';
				break;*/
			}
		}

		$display_text  = "<tr><td>$mis_array[0]</td>";
		$display_text .= "<td>".$mis_array[1]."</td>";
		$display_text .= "<td>".(int)$mis_array[5]."</td>";

		if($mis_array[2]=='' || $mis_array[2]=='0' || $mis_array[2]=='pan')
			$circle_info[strtoupper($mis_array[2])]='Others';

		if($circle_info[strtoupper($mis_array[2])]=='')
		{
			$circle_info[strtoupper($mis_array[2])]='others';
		}

		$display_text .= "<td>".$circle_info[strtoupper($mis_array[2])]."</td>";
		$display_text .= "<td>$service_name[0]</td></tr>";

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
		echo "<a href='http://10.43.248.137/hungamacare/'>Click Here to Login</a>";
	}

?>
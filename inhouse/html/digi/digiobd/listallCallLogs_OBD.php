<?php
include("session.php");
error_reporting(0);
//include database connection file
if($_SESSION["id"]=="279")
     	{
		  echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=listallmissed_test.php">';
		}
		else
		{
include("db.php");
$today=date("Y-m-d");
$displaydate;
if($_POST['action'] == 1)
 {
	
		$circle=strtolower($_POST['circle']);
		if(!empty($circle))
		{
		$sqlwhere="CIRCLE='$circle'";
		}
}
$Query = "SELECT 'TotalSongsDedicated' as type ,count(*) as total FROM Hungama_PRINCEIVR.tbl_princeivr_dedication
UNION 
SELECT 'DND' as type , sum(InDND)  as total FROM Hungama_PRINCEIVR.tbl_princeivr_dedication
UNION 
select  'OBDSENT' as type , count(*) as total  from Hungama_PRINCEIVR.tbl_princeivr_dedication where STATUS!=3
UNION 
select  'OBDSUCCSESS' as type , count(*) as total  from Hungama_PRINCEIVR.tbl_princeivr_dedication where STATUS=1";

		
	//get all consolidated data for OBD



$statusResult = mysql_query($Query);
	while($row1 = mysql_fetch_array($statusResult)) {
		$type = $row1['type'];
		$status[$type] = $row1['total'];
	}
	//get all repeat caller count
		$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAR'=>'Haryana','PUB'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other','HAY'=>'Haryana');
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<style media="all" type="text/css">@import "css/all.css";</style>
	<script language="javascript" type="text/javascript" src="datetimepicker/datetimepicker.js"></script>
	</head>
<body>
<div id="main">
	<div id="header">
		<a href="index.html" class="logo"><img src="img/Hlogo.png" width="282" height="80" alt=""/></a>
	</div>
	<div id="middle" >
		<div id="left-column">
		<?php include('left-sidebar.php');?>	
		</div>
		<div id="center-column1" style="width:700px">
			<div class="top-bar">
				<h1>Call Log OBD</h1>
				</div>
		  
			 <div class="table" style="width:700px">
				<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
				<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
		<table class="listing" cellpadding="0" cellspacing="0" style="width:700px" >
				<!--form action="listallCallLogs_OBD.php" method="post">
				<tr class="bg">
				<td>
					<select name="circle" id="circle">
				<option value="">Select Circle</option>
				<?php foreach($circle_info as $circle_id=>$circle_val) { ?>
					<option value="<?php echo $circle_id;?>" <?php if($circle_id==strtoupper($circle)) { echo "selected";}?>><?php echo $circle_val;?></option>
				<?php } ?>
			</select>
				</td>
						<td colspan="9"><strong>Select Date &nbsp;&nbsp;&nbsp;</strong>
						<input type="text" id="startdate" maxlength="25" size="25" name="obd_form_startdate" value="<?php echo $displaydate;?>">
						<a href="javascript:NewCal('startdate','ddmmmyyyy',true,24)"><img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
						<input type="hidden" name="action" value="1" />
						<input type="submit" name="submit" value="Go"/>
						&nbsp;&nbsp;

					</td>
						
	 
		</tr>
					</form-->

	<tr>
					<th width="300">Total songs dedicated</th>
					<th>OBD Sent</th>
					<th>OBD Successful</th>
					<th colspan="6">DND Nos</th>
					
	</tr>	
<tr>



					<td><?php echo $status['TotalSongsDedicated'];?></td>
					<td><?php echo $status['OBDSENT'];?></td>
					<td><?php echo $status['OBDSUCCSESS'];?></td>
					<td colspan="8"><?php echo $status['DND'];?></td>
					
	</tr>		

<?php
/*
if($totalrecord>0)
{?>
	<tr><th colspan="10">Total no of <?= $totalrecord;?> records found of date <?=$displaydate;?>.</th></tr>
	<tr>
					<th>S.No</th>
					<th>Date</th>
					<th>Time</th>
					<th>Circle</th>
					<th>Caller_Id</th>
					<th>Call Duration</th>
					<th>Name Recorded(Y/N)</th>
					<th>Song Dedicated</th>
					<th>Rec_ID</th>
					<th>Call Flow Completed(Y/N)</th>
	</tr>
		<?php
		$i=1;
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
if(!empty($result_list['APARTY']))
{?>
<tr>
<td><?php echo  $i;?></td>
<td width="100"><?=trim($result_list['CALLDATE'])?></td>
<td width="100"><?=trim($result_list['CALLTIME'])?></td>
<td><?php if(!empty($result_list['CIRCLE'])) {echo $result_list['CIRCLE'];} else {echo "--";}?></td>
<td><?php if(!empty($result_list['APARTY'])) {echo $result_list['APARTY'];} else {echo "--";}?></td>		
<td><?php if(!empty($result_list['CALLDURATION'])) {echo $result_list['CALLDURATION'];} else {echo "--";}?></td>
<td><?php if(!empty($result_list['RECORDEDSTATUS'])) {echo $result_list['RECORDEDSTATUS'];} else {echo "--";}?></td>
<td><?php if(!empty($result_list['SONGID'])) {echo $result_list['SONGID'];} else {echo "--";}?></td>
<td><?php if(!empty($result_list['RECIEVERID'])) {echo $result_list['RECIEVERID'];} else {echo "--";}?></td>
<td><?php if(!empty($result_list['CFCOMPLETE'])) {echo $result_list['CFCOMPLETE'];} else {echo "--";}?></td>
</tr>
<?php
$i++;
}
}
}
else
{?>
<!--tr><th colspan="10">No records found.</th></tr-->
<?php
}
*/			
?></table>
				        <p>&nbsp;</p>
		  </div>
		</div>
		<div id="right-column">
<?php include('right-sidebar.php');
//close database connection
mysql_close($con);
?>
	  </div>
	</div>
	<div id="footer"></div>
</div>


</body>
</html>
<?php
}?>
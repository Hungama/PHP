<?php
session_start();
require_once("db.php");
$req_type = $_GET['type'];
$uploadedby=$_SESSION["logedinuser"];
$operator=$_REQUEST['operator'];
$uploadvaluearray = array('contest_info'=>'Contest Info','call_logs'=>'Call Logs','mis'=>'MIS');
$operatorarray = array('all'=>'All','vodm'=>'Vodafone','unim'=>'Uninor','airm'=>'AIRTEL','airc'=>'AIRCEL','mts'=>'MTS','relm'=>'RELIANCE','tatm'=>'TATM','tatc'=>'TATC');
if($req_type=='contest_info')
{
if($operator=='all')
{
$get_query="select unique_calls,date_time,circle,operator from Hungama_BNB.insertDailyreport_contestinfo
group by date(date_time),operator order by date_time desc";
}
else
{
$get_query="select unique_calls,date_time,circle,operator from Hungama_BNB.insertDailyreport_contestinfo
where operator='".$operator."' group by date(date_time),operator order by date_time desc";
}
$query = mysql_query($get_query,$con);
$numofrows=mysql_num_rows($query);
if($numofrows==0)
{
?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<?php // echo ALERT_NO_RECORD_FOUND;?>
<h4>Ooops!</h4>Hey, we couldn't seem to find any record for <?php echo strtoupper($uploadvaluearray[$uploadfor]); ?>
</div>
</div>
<?php
}
else
{
?>
<div width="85%" align="left" class="txt">
<div class="well well-small">
<?php
if($req_type=='contest_info')
{
echo "Displaying  contest information for ".strtoupper($operatorarray[$operator]).' operator.';
}
?>
</div></div>
<TABLE class="table table-condensed table-bordered">
   <thead>
  <TR height="30">
	<th align="left">Date</th>
	<th align="left">Operator</th>
	<th align="left">Unique Caller#</th>	
 </TR>
 </thead>
<?php
	while($summarydata = mysql_fetch_array($query)) 
	{
	$date=$summarydata['date_time'];
	$UU_Calls=$summarydata['unique_calls'];
	$operator=$operatorarray[$summarydata['operator']];
	?>
	<TR height="30">
	<TD><?php echo $date;?></TD>
	<TD><?php echo $operator;?></TD>
	<TD><?php echo $UU_Calls;?></TD>	
	</TR>
<?php
}
?>
</TABLE>
<?php
}
}
mysql_close($con);
?>
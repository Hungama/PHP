<?php
session_start();
require_once("db.php");
$req_type = $_GET['type'];
$uploadedby=$_SESSION["logedinuser"];
$operator=$_REQUEST['operator'];
$operatorBNBarray = array('all'=>'All' ,'vodm'=>'VODAFONE','unim'=>'UNINOR','airm'=>'AIRTEL','airc'=>'AIRCEL','mts'=>'MTS','relm'=>'RELIANCE','tatm'=>'TATM','tatc'=>'TATC');
$uploadvaluearray = array('smsmis_info'=>'SMS MIS','call_logs'=>'Call Logs','mis'=>'MIS');
$operatorarray = array('all'=>'All' ,'vodm'=>'Vodafone','unim'=>'Uninor','airm'=>'AIRTEL','airc'=>'AIRCEL','mts'=>'MTS','relm'=>'RELIANCE','tatm'=>'TATM','tatc'=>'TATC');
if($req_type=='smsmis_info')
{
if($operator=='all')
{
$get_query="select total_count,unique_user,circle,operator from Hungama_BNB.insertDailyreport_smsinfo
group by date(date_time),operator order by date_time desc";
}
else
{
$get_query="select total_count,unique_user,circle,operator from Hungama_BNB.insertDailyreport_smsinfo
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
<h4>Ooops!</h4>Hey, we couldn't seem to find any record for <?php echo strtoupper($uploadvaluearray[$uploadfor]); ?> operator.
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
if($req_type=='smsmis_info')
{
echo "Displaying SMS MIS for ".strtoupper($operatorarray[$operator]).' operator.';
}
?>
</div></div>
<TABLE class="table table-condensed table-bordered">
   <thead>
  <TR height="30">
	<th align="left">Total no of SMS Received</th>
	<th align="left">Unique Users</th>
	<th align="left">Revenue</th>	
	<th align="left">Operator</th>	
	<th align="left">Circle</th>	
 </TR>
 </thead>
<?php
	while($summarydata = mysql_fetch_array($query)) 
	{
	$totalsmsreceived=$summarydata['total_count'];
	$Unique_Users=$summarydata['unique_user'];
	$circle=$summarydata['circle'];
	$operator=$operatorarray[$summarydata['operator']];
	$revenue=$totalsmsreceived*3;
	?>
	<TR height="30">
	<TD><?php echo $totalsmsreceived;?></TD>
	<TD><?php echo $Unique_Users;?></TD>
	<TD><?php echo number_format($revenue);?></TD>
	<TD><?php echo $operator;?></TD>	
	<TD><?php echo $circle;?></TD>
	</TR>
<?php
}
?>
</TABLE>
<?php
}
}
else if($req_type=='smsmis_txhistory')
{
if($operator=='all')
{
$get_query="select ANI,main_keyword,sub_keyword,req_received,response_submited,circle,operator from Hungama_BNB.insertDailyReport_smsKeyword
order by req_received desc";
}
else
{
$get_query="select ANI,main_keyword,sub_keyword,req_received,response_submited,circle,operator 
from Hungama_BNB.insertDailyReport_smsKeyword
where operator='".$operatorBNBarray[$operator]."' order by req_received desc";
}
$query = mysql_query($get_query,$con);
$numofrows=mysql_num_rows($query);
if($numofrows==0)
{
?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<?php // echo ALERT_NO_RECORD_FOUND;?>
<h4>Ooops!</h4>Hey, we couldn't seem to find any record for <?php echo strtoupper($uploadvaluearray[$uploadfor]); ?> operator.
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
echo "Transaction Report";
?>
<a href="downloadData.php?operator=<?=$_REQUEST['operator'];?>">
<i class="icon-download"></i>
</a>
</div></div>
<TABLE class="table table-condensed table-bordered">
   <thead>
  <TR height="30">
	<th align="left">MSISDN</th>
	<th align="left">SMS Keyword received time</th>	
	<th align="left">Response submitted time</th>	
	<th align="left">Operator</th>	
	<th align="left">Circle</th>	
 </TR>
 </thead>
<?php
	while($summarydata = mysql_fetch_array($query)) 
	{
	$ANI=$summarydata['ANI'];
	$main_keyword=$summarydata['main_keyword'];
	$sub_keyword=$summarydata['sub_keyword'];
	$req_received=date('j-M \'y g:i a',strtotime($summarydata['req_received']));
	$response_submited=date('j-M \'y g:i a',strtotime($summarydata['response_submited']));
	$circle=$summarydata['circle'];
	$operator=$summarydata['operator'];
	?>
	<TR height="30">
	<TD><?php echo $ANI;?></TD>
	<!--TD><?php echo $main_keyword;?></TD>
	<TD><?php echo $sub_keyword;?></TD-->
	<TD><?php echo $req_received;?></TD>
	<TD><?php echo $response_submited;?></TD>
	<TD><?php echo $operator;?></TD>	
	<TD><?php echo $circle;?></TD>
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
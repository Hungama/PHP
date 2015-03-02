<?php
ob_start();
session_start();
require_once("../../db.php");
$type=$_REQUEST['type'];

$data_range=explode('-',trim($_REQUEST['missed_date']));
$fromdate=explode('/',$data_range[0]);
$todate=explode('/',$data_range[1]);
$fromdate1=trim($fromdate[2]).'-'.trim($fromdate[0]).'-'.trim($fromdate[1]);
$todate1=trim($todate[2]).'-'.trim($todate[0]).'-'.trim($todate[1]);

$cpgid=$_SESSION['cpgid'];

if(empty($cpgid))
{
$getcpgid_query="select cpgid from Inhouse_IVR.tbl_missedcall_cpginfo where uid='".$_SESSION['suid']."' and status=1 limit 1";
$query_cpgid = mysql_query($getcpgid_query,$con);
list($cpgid) = mysql_fetch_array($query_cpgid);
}
$msgtype=array('SUB'=>'SUB','RESUB'=>'RESUB','TOPUP'=>'TOPUP');
$circle_info_HIS = array( 'pan' => 'PAN','CHN' => 'Chennai', 'GUJ' => 'Gujarat', 'KAR' => 'Karnataka', 'KER' => 'Kerala', 'KOL' => 'Kolkata', 'RAJ' => 'Rajasthan', 'TNU' => 'Tamil Nadu', 'UPW' => 'UP WEST', 'WBL' => 'WestBengal', 'DEL' => 'Delhi');
$get_query="select msisdn,processed_at,cpgid,sms from Inhouse_IVR.tbl_missedcall_smslist where cpgid='".$cpgid."' and date(processed_at) between '".$fromdate1."' and '".$todate1."' and status=1";
$get_query .=" order by processed_at desc ";
//echo $get_query;
$query = mysql_query($get_query,$con);
$numofrows=mysql_num_rows($query);
$msgidarray=array();
if($numofrows==0)
{
?>
<div width="85%" align="left" class="txt">
<div class="alert alert-block">
<h4>Ooops!</h4>Hey,  we couldn't seem to find any record.
</div>
</div>
<?php
}
else
{?>
<?php

$getDashbord_RepeatUser=mysql_query("select msisdn ,count(*) as total from Inhouse_IVR.tbl_missedcall_smslist nolock  where cpgid='".$cpgid."'
group by msisdn HAVING total > 1",$con);
$totalrepeat_user=mysql_num_rows($getDashbord_RepeatUser);

$getDashbord_data="select count(*) as total, count(distinct(msisdn)) as total_unique,cpgname from Inhouse_IVR.tbl_missedcall_smslist nolock  where cpgid='".$cpgid."'";
$query_dash_info = mysql_query($getDashbord_data,$con);
list($total_user,$total_unique_user,$cpgmanager) = mysql_fetch_array($query_dash_info); 
	
?>
<!--center><div width="85%" align="left" class="txt">
<div class="alert alert" ><a href="javascript:void(0)" id="Refresh"><i class="icon-download-alt"></i></a>

<button type="button" class="btn btn-success" style="float:right"><a href="snippets/download_tsv.php?fromdate1=<?=$fromdate1?>&todate1=<?=$todate1?>&cpgid=<?=$cpgid?>">Download Data</a></button>
</i>
</div></div><center-->
<table class="table table-bordered table-striped">

<tr><th>Campaign Manager</th><th>Total number of visitors</th>
<th>Unique Visitors</th><th>Repeat Visitors</th></tr>
<tr><td><?php echo $cpgmanager;?></td><td><?php echo $total_user;?></td>
<td><?php echo $total_unique_user;?></td><td><?php echo $totalrepeat_user; ?></td></tr>	
</tr>
</table>

<table class="table table-bordered table-striped">

<tr>
	<th width="8%">Msisdn</th>
	<th width="25%">TimeStamp</th>
	<th width="25%">SMS-Text</th>
	<th width="25%">SMS(CampgionId)</th>
	
	
</tr>
	<?php
	$i=0;
	while($summarydata = mysql_fetch_array($query)) 
	{
	?>
	<tr>
	<td width="8%"><?=$summarydata['msisdn'];?></td>
	<td width="25%"><?=ucfirst($summarydata['processed_at']);?></td>
	<td width="25%"><?=ucfirst($summarydata['sms']);?></td>
	<td width="25%"><?=ucfirst($summarydata['cpgid']);?></td>
	
	</tr>
	<?php
	$i++;
	}
}
?>
</table>
<?php
mysql_close($con);
?>
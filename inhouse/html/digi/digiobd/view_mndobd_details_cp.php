<?php
include("session.php");
error_reporting(0);
$mnd=$_GET['msisdn'];
//include database connection file
include("db.php");
$today=date("Y-m-d");
$displaydate;
	$sql_getmsisdnlist = mysql_query("select count(*) as totalno, odb_name as odb_name,sum(duration) as duration from hul_hungama.tbl_hulobd_success_fail_details where ANI=$mnd and service='HUL_PROMOTION' and status=2 group by odb_name");
	$totalrecord=mysql_num_rows($sql_getmsisdnlist);
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<body>
						<table class="listing" cellpadding="0" cellspacing="0" style="width:600px" >
						

<?php

if($totalrecord>0)
{?>
<tr>
					<th>OBD List</th>
					<th>Content modules accessed (y/n)</th>
					<th>Content module access frequency</th>
					<th>Average time spent on content module per access</th>
				</tr>
		<?php
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
?>
<tr>
<td width="100"><?=($result_list['odb_name'])?></td>
<td><?php if(!empty($result_list['duration'])) {echo 'Y';} else {echo "N";}?></td>		
<td><?php if(!empty($result_list['totalno'])) {echo $result_list['totalno'];} else {echo "--";}?></td>
<!--td><?php //if(!empty($result_list['duration'])) {echo $result_list['duration'];} else {echo "--";}?></td-->
<td><?php 
if(!empty($result_list['duration'])) 
{
$avgvalue=$result_list['duration']/$result_list['totalno'];
$avgfrq=round($avgvalue, 0, PHP_ROUND_HALF_UP);
echo $avgfrq;
} else {echo "--";}
?></td>
</tr>
<?php
 	}
}
else
{?>
<tr><th colspan="5">No records found.</th></tr>
<?php
}			
?></table>
				      
<?php
//close database connection
mysql_close($con);
?>
	
</body>
</html>
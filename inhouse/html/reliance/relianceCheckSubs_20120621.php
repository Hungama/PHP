<?php
include_once '/var/www/html/kmis/services/hungamacare/config/dbConnect.php';
$msisdn=$_GET['msisdn'];
$table=array('tbl_jbox_subscription'=>'reliance_hungama',
'tbl_mtv_subscription'=>'reliance_hungama','tbl_cricket_subscription'=>'reliance_cricket');
$k=0;
$rowInfo=array();
foreach($table as $key=>$value)
{
		
	$query="select ANI,dnis,SUB_DATE,RENEW_DATE,chrg_amount,circle,MODE_OF_SUB from $value.$key where ANI=$msisdn and status=1";
	$queryresult=mysql_query($query);
	$row= mysql_fetch_array($queryresult);
	$rowInfo[$k]=$row;
	$k++;
	
}


?>
<table border='1' width='100%'>
<?php for($j=0;$j<3;$j++)
{
	if($j==0)
	{ $ServiceId=1202;}
	if($j==1)
	{ $ServiceId=1203;}
	if($j==2)
	{ $ServiceId=1208;}
	if($rowInfo[$j]['ANI']!='')
{
?>

<tr>
<th><font size=2>MobileNo.</font></th><th><font size=2>Registration Id</font></th><th><font size=2>Activation</font></th><th><font size=2>NextCharging</font></th><th><font size=2>ChargedAmount</font></th><th><font size=2>Circle</font></th><th><font size=2>SubscriptionMode</font></th><th><font size=2>CurrentStatus</font></th><th><font size=2>Option</font></th>
</tr>
<tr>
<td align='center'><font size=2><?php echo $rowInfo[$j]['ANI'];?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['dnis'];?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['SUB_DATE'];?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['RENEW_DATE'];?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['chrg_amount'];?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['circle'];?></font></td>
<td align='center'><font size=2><?php echo $rowInfo[$j]['MODE_OF_SUB'];?></font></td>
<td align='center'><font size=2>ACTIVE </font></td>
<td align='center'><font size=2>
<?php 
	echo "<a href='http://119.82.69.212/reliance/deactivate.php?msisdn=$msisdn&ServiceId=$ServiceId'>DEACTIVATE</a>";?></font> </td>
</tr>
<?php } } ?>
</table>

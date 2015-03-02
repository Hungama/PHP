<?php
$con_218 = mysql_connect('192.168.100.218','php','php');
if (!$con_218)
 {
  die('Could not connect:Mis data');
 }
 
 
 
 
$data_query2 = "select type,sum(value) as total,date from  misdata.dailymis where type in('RECHRG_ELG','DD_PARTY_A','CALLS_TF' )
and service in('EnterpriseMcDwOBD','EnterpriseMcDw') and date between '2014-11-13' and  '2014-11-20'   
group by date ,type ";
$data2 = mysql_query($data_query2, $con_218);
$result_row2= mysql_num_rows($data2);
$total_DD_PARTY_A=array();
$total_UU_DD_PARTY_A=array();
$total_UU_DD_PARTY_Ab=array();
$date_wise=array();
while(list($type_DD,$total_DD,$date) = mysql_fetch_array($data2))
{
$date_wise[]=$date;
if($type_DD=='CALLS_TF')
$total_DD_PARTY_A[]=$total_DD;
elseif($type_DD=='DD_PARTY_A')
$total_UU_DD_PARTY_A[]=$total_DD;
elseif($type_DD=='RECHRG_ELG')
$total_UU_DD_PARTY_Ab[]=$total_DD;
//echo $total_DD_PARTY_A.'&nbsp'.	$total_UU_DD_PARTY_A.'&nbsp'.$total_UU_DD_PARTY_Ab. "<br/>";	
}

foreach($date_wise as $a){ echo $a;}
foreach($total_DD_PARTY_A as $a){ echo $a;}
foreach($total_UU_DD_PARTY_A as $a){echo $a;}
foreach($total_UU_DD_PARTY_Ab as $a){echo $a;}

?>

<!--table>
<tr><td>1</td><td>2</td><td>3</td><td>4</td></tr>
<tr><td>1</td><td>2</td><td>3</td><td>4</td></tr>
</table--> 



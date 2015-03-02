<?php
require_once("../../../db.php");
function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );
	
	return $res;
}
$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
//$StartDate= date("Y-m-d",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
//$EndDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));

/**************New Visists vs Returning Customers section start here********************/

$getDashbord_totalhits=mysql_query("select sum(totalcount) as totalcount
from Inhouse_IVR.tbl_advertisment_Dashboard nolock where date(report_date)
 between '".$StartDate."' and '".$EndDate."'",$con);
$totalhitsdata=mysql_fetch_array($getDashbord_totalhits);
$total_percentage=$totalhitsdata['totalcount'];
$alloperatorCount=array();

$getDashbord_Operatorwise=mysql_query("select  sum(totalcount) as totalcount,operator from Inhouse_IVR.tbl_advertisment_Dashboard nolock where date(report_date) between '".$StartDate."' and '".$EndDate."' group by operator",$con);
while($op_data=mysql_fetch_array($getDashbord_Operatorwise))
{
$opname=$op_data['operator'];
$totalcount_op=$op_data['totalcount'];
$get_percetage=percentage($totalcount_op, $total_percentage, 2);
$alloperatorCount[$opname]=$get_percetage;
}
 
$getDashbordChart_data="select sum(totalcount) as totalcount,day(report_date) as day,Month(report_date) as month
from Inhouse_IVR.tbl_advertisment_Dashboard nolock  where date(report_date)
 between '".$StartDate."' and '".$EndDate."'  group by date(report_date) order by day(report_date) ASC";
$query_dashChart_info = mysql_query($getDashbordChart_data,$con);

$chartMissedCallarray=array();
$gettotalmissedcallcount=0;
$gettotalmissedcalldayscount=0;
$montharray=array('1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC');
while($data= mysql_fetch_array($query_dashChart_info))
{
$day=$data['day'];
$month=$montharray[$data['month']];
$dataof=$day;
$total_missed_call=$data['totalcount'];
$gettotalmissedcallcount=$total_missed_call;
$gettotalmissedcalldayscount++;
$chartMissedCallarray[] = array($dataof,$total_missed_call);
}

/***********************End here*******************************************/

//India Map data
$getDashbordMapdata="select sum(totalcount) as total,circle
from Inhouse_IVR.tbl_advertisment_Dashboard nolock where date(report_date) between '".$StartDate."' and '".$EndDate."' group by circle order by circle";
$query_getDashbordMapdata = mysql_query($getDashbordMapdata,$con);
$Mapdataarray=array();
$totalcontribution=0;
while($data_cir= mysql_fetch_array($query_getDashbordMapdata))
{
$cir=$circle_info[strtoupper($data_cir['circle'])];
$total_contri=$data_cir['total'];
if($data_cir['circle']!='UND')
{
$Mapdataarray[$cir]=$total_contri;
$totalcontribution=$totalcontribution+$total_contri;
}
}
foreach ($Mapdataarray as $circle=>$value) {     
          	$MAP_SET_NEWChart .= "["."'".$circle."',".($value>0 ? round($value,0):0)."],\r\n";
               } 

//create json for all array chart data
$allMissedCallChart=json_encode(($chartMissedCallarray), JSON_NUMERIC_CHECK);

$iscount1=count($chartMissedCallarray);
if($iscount1>1)
{
$allMissedCallChart2=json_encode(($chartMissedCallarray), JSON_NUMERIC_CHECK);
}
else
{
$chartMissedCallarray2[0] = array(1,$total_user);
$chartMissedCallarray2[1] = array(2,$total_user);
$allMissedCallChart2=json_encode(($chartMissedCallarray2), JSON_NUMERIC_CHECK);
}
$iscount2=count($chartUniqueCallarray);
if($iscount2>1)
{
$allUniqueCallChart2=json_encode(($chartUniqueCallarray), JSON_NUMERIC_CHECK);
}
else
{
$chartUniqueCallarray2[0] = array(1,$total_unique_user);
$chartUniqueCallarray2[1] = array(2,$total_unique_user);
$allUniqueCallChart2=json_encode(($chartUniqueCallarray2), JSON_NUMERIC_CHECK);
}
//mysql_close($con);
?>
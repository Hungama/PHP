<?php
/*
 * @Satay Tiwari  Hungama Tech
 * @Version 1.1
 */
class DashboardData{
	/* 
	 * Create variables for Enetrprize dashboard data points
	 * The variables have been declared as private. This
	 * means that they will only be available with the 
	 *
	 */
	private $total_call= "";  // Total Missed Calls
	private $total_unique_users= "";  // Total Unique Users
	private $total_pulse_30sec= "";  // Total Pulse @ 30 sec
	private $total_sms_sent= "";	// Total SMS Sent
	private $total_rt_sent= "";     //Total Ringtone sent
    private $total_min_counsumed= ""; //Total Minutes Consumed
    private $avg_min_per_caller= "";    //Avg min consumed per caller
	private $avg_missed_per_caller= ""; //Avg missed call per caller
	private $max_duration= "";          //Max duration listen
	private $total_ad_impression= "";   //Total ad impression 
	private $total_ad_play= "";      //Total ad play @ MOUS
	
	//Function to get All  Call
	public function getAllCalls($db,$StartDate,$EndDate,$service)
		{
		$query = "select sum(Value) as total from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_TF' and service='".$service."'";
		$r = $db->query($query);
		// if we have a result loop over the result
		if ($db->num_rows($r) > 0) {
		  //while ($a = $db->fetch_array_assoc($r)) {
			//echo $a['name']."#".$a['email']."<br>";
		  //}
		  list($total_call) = $db->fetch_array($r); 
		}
		return $total_call;		
		}
		public function getAllUniqueUsers($db,$StartDate,$EndDate,$service)
		{
		$query = "select sum(Value) as total_unique from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='UU_TF' and service='".$service."'";
		$r = $db->query($query);
		if ($db->num_rows($r) > 0) {
		 list($total_unique_users) = $db->fetch_array($r); 
		}
		return $total_unique_users;		
		}
		
		public function getDateDiff($db,$StartDate,$EndDate,$service)
		{
		
		$query = "SELECT DATEDIFF('".$EndDate."','".$StartDate."') AS DiffDate";
		$r = $db->query($query);
		list($DiffDate) = mysql_fetch_array($r); 
		//if ($db->num_rows($r) > 0) {
		 //list($DiffDate) = $db->fetch_array($r); 
		//}
		if($EndDate==$StartDate)
		$DiffDate=1;
		else
		$DiffDate=$DiffDate+1;

		return $DiffDate;		
		}
		//Average Call Per Day
		public function getAvgMissedCallPerDay($total_call,$DiffDate)
		{
		$avgmissedperday=round($total_call/$DiffDate);
		return $avgmissedperday;		
		}
		//Average Uninque User Per Day
		public function getAvgUniqueUserPerDay($total_unique_users,$DiffDate)
		{
		$avgUniqueUserperday=round($total_unique_users/$DiffDate);
		return $avgUniqueUserperday;		
		}
		//Average Duration Listen
		public function getAvgListenDuration($total_call,$totalOBD_attended_Content)
		{
		$avgDuration=ceil($totalOBD_attended_Content/$total_call);
		return $avgDuration;		
		}	

		public function getMaxListenDuration($db,$StartDate,$EndDate,$service)
		{
		$query = "select ceil(Value/60) as maxDuration from dailymis nolock  
		where date between '".$StartDate."' and '".$EndDate."' and type='SEC_MAX' and service='".$service."'";
		$r = $db->query($query);
		if ($db->num_rows($r) > 0) {
		 list($maxDuration) = $db->fetch_array($r); 
		}
		return $maxDuration;
		}
		//Total Minutes Consumed
		public function getTotalMinuteConsumesd($db,$StartDate,$EndDate,$service)
		{
		$query = "select sum(Value) as totalMinConsumed from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='MOU_TF' and service='".$service."'";
		$r = $db->query($query);
		if ($db->num_rows($r) > 0) {
		 list($totalOBD_attended_Content) = $db->fetch_array($r); 
		}
		return $totalOBD_attended_Content;		
		}
		
		//total targeted OBD start here
		public function getTotalOBDSend($db,$StartDate,$EndDate,$service)
		{
		$query = "select  sum(Value) from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_OBD' and service='".$service."'";
		$r = $db->query($query);
		if ($db->num_rows($r) > 0) {
		 list($totalOBD_targettd) = $db->fetch_array($r); 
		}
		return $totalOBD_targettd;		
		}
	
		//Total Song Download 
		public function getTotalSongDownload($db,$StartDate,$EndDate,$service)
		{
		$query = "select  sum(Value) from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CRBT_REQS' and service='".$service."'";
		$r = $db->query($query);
		if ($db->num_rows($r) > 0) {
		 list($totalSong_Downloaded) = $db->fetch_array($r); 
		}
		return $totalSong_Downloaded;		
		}
		
		//Total User age verified
		public function getTotalAgeVerified($db,$StartDate,$EndDate,$service)
		{
		$query = "select  sum(Value) from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='TOTAL_AGE_VERIFIED' and service='".$service."'";
		$r = $db->query($query);
		if ($db->num_rows($r) > 0) {
		 list($totalAge_Verified) = $db->fetch_array($r); 
		}
		return $totalAge_Verified;		
		}
		
		//Total Ads Impression 
		public function getTotalAdsCount($db,$StartDate,$EndDate,$service)
		{
		$query="select sum(Value) from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='ADS_PLAYBACK_COUNT' and service='".$service."'";
		$r = $db->query($query);
		if ($db->num_rows($r) > 0) {
		 list($totalAdCount) = $db->fetch_array($r); 
		}
		return $totalAdCount;		
		}
		
		//Visitors Chart- Missed Calls Vs Total unique Visitors
		public function getVisitorsMissedCallsChart($db,$StartDate,$EndDate,$service)
		{
		$getDashbordChart_missedCallNewChart="select sum(Value) as total, day(date) as day,Month(date) as month
		from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_TF' and service='".$service."' group by date order by Month(date),day ASC";
		$query_missedCallNewChart = $db->query($getDashbordChart_missedCallNewChart);
		return $query_missedCallNewChart;
		}

		public function getVisitorsUniqueCallsChart($db,$StartDate,$EndDate,$service)
		{
		$getDashbordChart_UniqueCallNewChart="select sum(Value) as total_unique,day(date) as day,Month(date) as month
		from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='UU_TF' and service='".$service."' group by date order by Month(date),day ASC";
		$query_uniqueCallNewChart = $db->query($getDashbordChart_UniqueCallNewChart);
		return $query_uniqueCallNewChart;
		}
//India Map- circle wise contributions
                
                
public function getVisitorsPieChartCircleWise($db,$StartDate,$EndDate,$service)
{
////code for the pie-chart by rahul tripathi
$getDashbord_totalhits=$db->query("select sum(value) as totalcount
from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_TF' and service='".$service."'");
$totalhitsdata=$db->fetch_array_assoc($getDashbord_totalhits);

$total_percentage=$totalhitsdata['totalcount'];
$getDashbordMapdata="select sum(value) as total,circle
from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and service='".$service."' group by circle order by circle";
$query_getDashbordMapdata = $db->query($getDashbordMapdata);
$Mapdataarray=array();
$totalcontribution=0;
$alloperatorCount=array();

while($data_cir= $db->fetch_array_assoc($query_getDashbordMapdata))
{

//$cir=$circle_info[$data_cir['circle']];
//$total_contri=$data_cir['total'];
    
if($data_cir['circle']!='UND')
{
//$Mapdataarray[$cir]=$total_contri;
//$totalcontribution=$totalcontribution+$total_contri;
$cpname=$data_cir['circle'];
$totalcount_cp=$data_cir['total'];
$get_percetage=round( ($totalcount_cp / $total_percentage) * 100, 2 );
//echo $totalcount_cp."#".$total_percentage."#".$cpname."#".$get_percetage."<br>";
$alloperatorCount[$cpname]=$get_percetage;
}
}
return $alloperatorCount;
//end of the code
}	
		
	//Ads Map- circle wise contributions
	public function getAdsChartData($db,$StartDate,$EndDate,$service)
		{
		$query="select value as totalcount,day(Date) as day,Month(Date) as month
	from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='ADS_PLAYBACK_COUNT' and service='".$service."' group by date order by day(date) ASC";
		$allAdsChart=array();
		$totalAdCount=0;
		$montharray=array('1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC');
		$r = $db->query($query);
		// if we have a result loop over the result
		if ($db->num_rows($r) > 0) {
		  while ($data = $db->fetch_array_assoc($r)) {
			//echo $a['name']."#".$a['email']."<br>";
				$day=$data['day'];
				$month=$montharray[$data['month']];
				$dataof=$day;
				$total_adcount=$data['totalcount'];
				$totalAdCount=$totalAdCount+$total_adcount;
				$allAdsChart[] = array($dataof,$total_adcount);
		  }
		   
		}
                
		}	
		//Content Consumption Split
		public function getContentConsuptionSplit($db,$StartDate,$EndDate,$service)
		{
		$query="select distinct Type from dailymis WHERE date between '".$StartDate."' and '".$EndDate."'  and service='".$service."' 
		and type like 'MOU_CNT%' group by Type";
		$r = $db->query($query);
		if ($db->num_rows($r) > 0) {
		$i=0;
		  while ($data = $db->fetch_array_assoc($r)) {
				$ctype=$data['Type'];
				$type[] = $ctype;
				$i++;
		  }
		   
		}
		
		$type = "'".join("','", $type)."'";
		$query2="select sum(Value) as Total,Type from dailymis WHERE date between '".$StartDate."' and '".$EndDate."'  and service='".$service."' and type in ($type) group by Type";
		$dur1=0;$dur2=0;$dur3=0;$dur4=0;$dur5=0;$dur6=0;
		$r = $db->query($query2);
		if ($db->num_rows($r) > 0) {
		  while ($data = $db->fetch_array_assoc($r)) {
				$cTotal=0;
				$cType='';
				$cType=$data['Type'];
				$cTotal=$data['Total'];
                                if($service=='EnterpriseMcDw')
                                {
				if($cType=='MOU_CNT_0-3')
				$dur1=$cTotal;
                                else if($cType=='MOU_CNT_4-6')
				$dur2=$cTotal;
                                else if($cType=='MOU_CNT_7-10')
				$dur3=$cTotal;
                                else if($cType=='MOU_CNT_11-15')
				$dur4=$cTotal;
                                else if($cType=='MOU_CNT_16-30')
				$dur5=$cTotal;
                                else if($cType=='MOU_CNT_31-Above')
				$dur6=$cTotal;
                                }
                                elseif($service=='EnterpriseTiscon')
                                {
                                 if($cType=='MOU_CNT_0-15') //for tiscon
				$dur1=$cTotal;
                                 else if($cType=='MOU_CNT_16-30') //for tiscon
				$dur2=$cTotal;
                                else if($cType=='MOU_CNT_31-45') //for tiscon
				$dur3=$cTotal;
                                else if($cType=='MOU_CNT_46-60')
				$dur4=$cTotal;
                                else if($cType=='MOU_CNT_60-Above')
				$dur5=$cTotal;
                                             }
		  }
		  $total_OBD_DURATION=$dur1+$dur2+$dur3+$dur4+$dur5+$dur6;
		  $result=$dur1."#".$dur2."#".$dur3."#".$dur4."#".$dur5."#".$dur6;
		return $total_OBD_DURATION."#".$result;
		}
		else
		{
		return 0;
		}
		}
//Convert JSON ARRAY data for chart
		public function getJsonData($strArray,$totalCount)
		{
			$iscount=count($strArray);
			if($iscount>1)
			{
			$chartData=json_encode(($strArray), JSON_NUMERIC_CHECK);
			}
			else
			{
			$chartArray[0] = array(1,$totalCount);
			$chartArray[1] = array(2,$totalCount);
			$chartData=json_encode(($chartArray), JSON_NUMERIC_CHECK);
			}
		}
                
                
public function getLabel($dur_percetage)
								{
								if($dur_percetage>60)
								$bar_label='progress-bar-success';
								else if($dur_percetage>20 && $dur_percetage<60)
								$bar_label='progress-bar-warning';
								#else if($dur_percetage>10 && $dur_percetage<20)
								#$bar_label='progress-bar-danger';
								else if($dur_percetage>0 && $dur_percetage<10)
								$bar_label='';
								return $bar_label;
								}
public function percentage($val1, $val2, $precision) 
{
	$res = round( ($val1 / $val2) * 100, $precision );
	
	return $res;
}

/****function for the Missed Calls Vs Unique Users MCD written by Rahul Tripathi****/
public  function getmissedcallmcd($db,$StartDate,$EndDate,$service)
{
$chartMissedCallarray=array();
$gettotalmissedcallcount=0;
$montharray=array('1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC');
//$receive = $this->getVisitorsMissedCallsChart($db,$StartDate,$EndDate,$service);

$getDashbordChart_data_query="select sum(Value) as total, day(date) as day,Month(date) as month
		from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='CALLS_TF' and service='".$service."' group by date order by day ASC";

$getDashbordChart_data_query1 = $db->query($getDashbordChart_data_query);

while($data = $db->fetch_array_assoc($getDashbordChart_data_query1))
{
$day=$data['day'];
$month=$montharray[$data['month']];
$dataof=$day;
$total_missed_call=$data['total'];
$avg_calls=ceil($total_missed_call/$total_unique_call);
$chartMissedCallarray[] = array($dataof,$total_missed_call);
$chartAvgMissedCallarray[] = array($dataof,$avg_calls);
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
$total_user=$this->getAllCalls($db,$StartDate,$EndDate,$service);
$chartMissedCallarray2[0] = array(1,$total_user);
$chartMissedCallarray2[1] = array(2,$total_user);
$allMissedCallChart2=json_encode(($chartMissedCallarray2), JSON_NUMERIC_CHECK);
}
return $allMissedCallChart2;

}
###############End of the code#####################3
/****function for the Unique Calls Vs Unique Users MCD written by Rahul Tripathi****/
public  function getuniquecallmcd($db,$StartDate,$EndDate,$service)
{
$chartUniqueCallarray=array();
$montharray=array('1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC');
//$receive = $this->getVisitorsUniqueCallsChart($db,$StartDate,$EndDate,$service);
$getDashbordChart_UniqueCallmcd_query="select sum(Value) as total_unique,day(date) as day,Month(date) as month
from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='UU_TF' and service='".$service."' group by date order by day ASC";
$query_uniqueCallmcd = $db->query($getDashbordChart_UniqueCallmcd_query);
while($data = $db->fetch_array_assoc($query_uniqueCallmcd))
{
$day=$data['day'];
$month=$montharray[$data['month']];
$dataof=$day;
$total_unique_call=$data['total_unique'];
$chartUniqueCallarray[] = array($dataof,$total_unique_call);
}
//create json for all array chart data
$allUniqueCallChart=json_encode(($chartUniqueCallarray), JSON_NUMERIC_CHECK);
$iscount2=count($chartUniqueCallarray);
if($iscount2>1)
{
$allUniqueCallChart2=json_encode(($chartUniqueCallarray), JSON_NUMERIC_CHECK);
}
else
{
$total_unique_user=$this->getAllUniqueUsers($db,$StartDate,$EndDate,$service);

$chartUniqueCallarray2[0] = array(1,$total_unique_user);
$chartUniqueCallarray2[1] = array(2,$total_unique_user);
$allUniqueCallChart2=json_encode(($chartUniqueCallarray2), JSON_NUMERIC_CHECK);
}

return $allUniqueCallChart2;

}
###############End of the code#####################3
#############################start the code for adds chart###########################################

public  function getobdaddmcd($db,$StartDate,$EndDate,$service)
        
{
 $getDashbord_OBD_Ad="select value as totalcount,day(Date) as day,Month(Date) as month
from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and type='ADS_PLAYBACK_COUNT' and service='".$service."' group by date order by day ASC";
$query_getDashbord_OBD_Ad = $db->query($getDashbord_OBD_Ad);
$allAdsChart=array();
$totalAdCount=0;
$montharray=array('1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC');
while($data= $db->fetch_array($query_getDashbord_OBD_Ad))
{
$day=$data['day'];
$month=$montharray[$data['month']];
$dataof=$day;
$total_adcount=$data['totalcount'];
$totalAdCount=$totalAdCount+$total_adcount;
$allAdsChart[] = array($dataof,$total_adcount);
}
$allAdsChart2=json_encode(($allAdsChart), JSON_NUMERIC_CHECK);
    return $allAdsChart2; 
}


######################################end of the code#################################3

public  function chartmissedcallperday($db,$StartDate,$EndDate,$service)
{
$total_missed_call=$this->getAllCalls($db,$StartDate,$EndDate,$service);
$total_unique_call=$this->getAllUniqueUsers($db,$StartDate,$EndDate,$service);

$result_query="select value as totalcount,day(Date) as day,Month(Date) as month
from dailymis nolock  where date between '".$StartDate."' and '".$EndDate."' and service='".$service."' group by date order by day ASC";
$service=$db->query($result_query);
$montharray=array('1'=>'JAN','2'=>'FEB','3'=>'MAR','4'=>'APR','5'=>'MAY','6'=>'JUN','7'=>'JUL','8'=>'AUG','9'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC');
$gettotalmissedcallcount=0;
$gettotalmissedcalldayscount=0;
while($data=$db->fetch_array($service))
{
$day=$data['day'];
$month=$montharray[$data['month']];
$dataof=$day;
$avg_calls=ceil($total_missed_call/$total_unique_call);
$gettotalmissedcallcount=$gettotalmissedcallcount+$total_missed_call;
$gettotalmissedcalldayscount++;
$chartAvgMissedCallarray[] = array($dataof,$avg_calls);
$chartAvgMissedCallPerDayarray[] = array($dataof,$gettotalmissedcalldayscount);  
}
$missed_calls_peruser=round($total_missed_call/$total_unique_call);

$iscount3=count($chartAvgMissedCallarray);
if($iscount3>1)
{
$allAvgMissedCallarray=json_encode(($chartAvgMissedCallarray), JSON_NUMERIC_CHECK);
}
else
{
$chartAvgMissedCallarray[0] = array(1,$missed_calls_peruser);
$chartAvgMissedCallarray[1] = array(2,$missed_calls_peruser);
$allAvgMissedCallarray=json_encode(($chartAvgMissedCallarray), JSON_NUMERIC_CHECK);
}

$iscount4=count($chartAvgMissedCallPerDayarray);
if($iscount4>1)
{
$chartAvgMissedCallPerDayarrayChart=json_encode(($chartAvgMissedCallPerDayarray), JSON_NUMERIC_CHECK);
}
else
{
$chartAvgMissedCallPerDayarray[0] = array(1,$avgmissedperday);
$chartAvgMissedCallPerDayarray[1] = array(2,$avgmissedperday);
$chartAvgMissedCallPerDayarrayChart=json_encode(($chartAvgMissedCallPerDayarray), JSON_NUMERIC_CHECK);
}
return array($allAvgMissedCallarray,$chartAvgMissedCallPerDayarrayChart);
    
}
       

#################cdoe for the unique visitor today###############################3

public  function today_new_visitor($db,$service)
{
$prevDate= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$allnewvsuniquevisittoday=$db->query("select sum(Value) from  dailymis nolock where date='".$prevDate."' and type='UU_New' and service='".$service."'");
list($totalNewUniqueVisitToday) = $db->fetch_array($allnewvsuniquevisittoday);
return $totalNewUniqueVisitToday; 
}
        
        
        
        
}
?>
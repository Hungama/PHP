<?php
/*
 * @Satay Tiwari  Hungama Tech
 * @Version 1.1
 * @Package Database
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

}
?>
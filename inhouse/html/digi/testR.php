 <?php
 
 $currentTime=strtotime('2013-10-16 00:00:00');
echo $timeAfterOneHour = $currentTime+60*60;
echo "<br>";
 $Date='2013-10-24';
 $DATE_TIMEZONE_SHIFT = ' DATE_SUB(DATE,INTERVAL 60 MINUTE) as Date';
	 $TIMEZONE_SHIFT =' All times below are +2:30 IST (+8:00 GMT)';
 echo $Query = "select Service, Circle, ".$DATE_TIMEZONE_SHIFT.", Type, sum(Value) as Value, sum(Revenue) as Revenue 
 from livemis where Service='DIGIMA' and Date >='$Date 1:00:00' and Date <= '".date("Y-m-d",strtotime($Date)+24*60*60)." 00:00:00' 
 group by Service, Circle, Date, Type";
 
 ?>
<?php
$serviceid=2121;
$plan_id=114;
$service='EPL';
$flag=0;
$status=0;
$cvspath='/var/www/html/hungamacare/sexEducation.csv';
$createfilename='sexEducation.txt';
$newcsvtextfile='/var/www/html/hungamacare/'.$createfilename;

$fGetContents = file_get_contents($cvspath);
    $e = explode("\n", $fGetContents);
   $totalcount=count($e);
    for ($i = 1; $i < $totalcount; $i++) {
	//echo $e[$i]."<br>";
	$data = explode(",", $e[$i]);
	if($totalcount!=$i+1)
{
	echo $data[0].'#'.$data[1]."#".$serviceid.'#'.$plan_id.'#'.$service.'#'.$flag.'#'.$status."\r\n";
	$logData_csv=$data[0].'#'.trim($data[1]).'#'.$serviceid.'#'.$plan_id.'#'.$service.'#'.$flag.'#'.$status."\r\n";
	//echo $logData_csv=$$data[0]."#".$data[1]. "#".$serviceid.'#'.$plan_id.'#'.$service.'#'.$flag.'#'.$status."\r\n";;
	error_log($logData_csv,3,$newcsvtextfile);
}


	
	}


/*
etislat_hsep.tbl_sms_service


•	tbl_sms_service
o	msg_id      int(11)   #  
o	message     varchar(200)
o	date_time   datetime    
o	service_id  int(11)     
o	plan_id     int(11)     
o	service     varchar(20) 
o	flag        int(11)     *
o	status      int(11)     *
*/
?>
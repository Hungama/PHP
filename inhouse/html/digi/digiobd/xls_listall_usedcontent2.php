<?php
ob_start();
include("db.php");
$today=date("Y-m-d");
$sql_getmissedmsisdn = mysql_query("select count(*) as totalmissedno, ANI from newseleb_hungama.tbl_max_bupa_details where ANI!='' group by ANI");
$dataarray=array();
$i=1;
$dataarray[0]=array('Msisdn','Duration(Till date -in sec)','Total No of Missed Call','CMA','CMAF','ATS');
	while($result_list = mysql_fetch_array($sql_getmissedmsisdn))
				{
				$sql_getmsisdnlist = mysql_query("select count(*) as totalno, ANI,SUM(duration) as duration ,operator,circle from hul_hungama.tbl_hulobd_success_fail_details where service='HUL' and ANI='".$result_list['ANI']."'");
				
	$result_list_missed = mysql_fetch_array($sql_getmsisdnlist);
				
					if($result_list_missed['duration']!=0) 
{
$cmy='YES';
if($result_list_missed['totalno']!==0) {$cmyF=$result_list_missed['totalno'];} else { $cmyF="--";}
$avgvalue=$result_list_missed['duration']/$result_list_missed['totalno'];
$avgfrq=round($avgvalue, 0, PHP_ROUND_HALF_UP);
$atsc=$avgfrq.' sec';
$duration=$result_list_missed['duration'];
}
else
{
$cmyF="--";
$cmy='NO';
$atsc="--";
$duration=0;
}
$dataarray[$i]=array($result_list['ANI'],$duration,$result_list['totalmissedno'],$cmy,$cmyF,$atsc);	

	$i++;
				}
//close database connection
mysql_close($con);		
//print_r ($dataarray);
//exit;
$dwfilename='totalmisscall_content_'.$today.'.xls';
$fp = fopen($dwfilename, 'w');

foreach ($dataarray as $fields) {
    fputcsv($fp, $fields, "\t", '"');
}

fclose($fp);
$file = $dwfilename;
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: application/csv");
// tell file size
header('Content-length: '.filesize($file));
// set file name
header('Content-disposition: attachment; filename='.basename($file));
readfile($file);
// Exit script. So that no useless data is output-ed.
exit;
?>
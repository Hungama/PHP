<?php
include("db.php");
$today=date("Y-m-d");
$sql_getmsisdnlist = mysql_query("select count(*) as totalno, ANI,SUM(duration) as duration ,operator,circle from hul_hungama.tbl_hulobd_success_fail_details where service='HUL' group by ANI");
$dataarray=array();
$i=1;
$dataarray[0]=array('Msisdn','Duration(Till date -in sec)','Total No of Missed Call','CMA','CMAF','ATS');
	while($result_list = mysql_fetch_array($sql_getmsisdnlist))
				{
				if($result_list['ANI']!='') {
 $sql_getmissedmsisdn = mysql_query("select count(*) as totalno, ANI from newseleb_hungama.tbl_max_bupa_details where ANI='".$result_list['ANI']."'");
				 $result_list_missed = mysql_fetch_array($sql_getmissedmsisdn);
	if(!empty($result_list['duration'])) 
{
if($result_list['duration']==0) { $cmy='NO';} else {$cmy='YES';}
				if(!empty($result_list['totalno'])) {$cmyF=$result_list['totalno'];} else { $cmyF="--";}
$avgvalue=$result_list['duration']/$result_list['totalno'];
$avgfrq=round($avgvalue, 0, PHP_ROUND_HALF_UP);
$atsc=$avgfrq.' sec';
} else {
if($result_list['duration']==0) { $cmy='NO';} else {$cmy='YES';}
$atsc="--";
}

$dataarray[$i]=array($result_list['ANI'],$result_list['duration'],$result_list_missed['totalno'],$cmy,$cmyF,$atsc);	
		
				}	
				$i++;
				}
//close database connection
mysql_close($con);		
//print_r ($dataarray);
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
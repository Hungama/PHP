<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
$stype=strtolower($_REQUEST['stype']);
$sdate=$_REQUEST['sdate'];
$FromDate=$_REQUEST['fdate'];
$ToDate=$_REQUEST['todate'];

if(!empty($FromDate) &&  !empty($ToDate))
{
$daterange="CALLDATE BETWEEN '$FromDate' AND '$ToDate'";
}
else
{
if(!empty($FromDate))
{
$daterange="CALLDATE ='$FromDate'";
}
if(!empty($ToDate))
{
$daterange="CALLDATE = '$ToDate'";
}
}
if(isset($daterange)) { 
	$daterange=$daterange;
	} else {
	$daterange="CALLDATE = '$sdate'";
}
	
	
$today=date("Y-m-d");
if(!empty($stype))
		{
		switch($stype)
		{
		case 'unique':
						$sqlwhere="group by APARTY";
		break;
		case 'repeat':
						$getcount=",count(*) as total";
						$sqlwhere="group by APARTY HAVING total > 1";
		break;
		}
		}
		$displaydate=$sdate;
		//CALLDATE,CALLTIME,CIRCLE,APARTY,CALLDURATION,SMOKERSTATUS,LEGTYPE,SONGID,RECORDEDSTATUS,RECIEVERID,CFCOMPLETE,CALLDROPPOINT,DISCONNECT_REASON,DNIS
		//$result = mysql_query("select APARTY,CALLDATE,CALLTIME,CIRCLE,CALLDURATION,RECORDEDSTATUS,RECIEVERID,CFCOMPLETE,SONGID $getcount from Hungama_PRINCEIVR.tbl_pinceivr_details  WHERE   $daterange $sqlwhere order by CALLTIME desc");
		$result = mysql_query("select CALLDATE,CALLTIME,CIRCLE,APARTY,CALLDURATION,SMOKERSTATUS,LEGTYPE,SONGID,RECORDEDSTATUS,RECIEVERID,CFCOMPLETE,CALLDROPPOINT,DISCONNECT_REASON,DNIS $getcount from Hungama_PRINCEIVR.tbl_pinceivr_details  WHERE   $daterange $sqlwhere order by CALLTIME desc");
		
//define date for title: EDIT this to create the time-format you need

$now_date = date('m-d-Y H:i:s');
//define title for .xls file: EDIT this if you want
$title = "PrinceIVRMIS-".$displaydate;

//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
$fp = fopen('PrinceIVRMIS.xls', "w");
$schema_insert = "";
$schema_insert_rows = "";
//start of printing column names as names of MySQL fields
for ($i = 0; $i < mysql_num_fields($result); $i++)
{
$schema_insert_rows.=mysql_field_name($result,$i) . "\t";
}
$schema_insert_rows.="\n";
//echo $schema_insert_rows;

fwrite($fp, $schema_insert_rows);
//end of printing column names
//start while loop to get data
while($row = mysql_fetch_row($result))
{
//set_time_limit(60); 
$schema_insert = "";
for($j=0; $j<mysql_num_fields($result);$j++)
{
if(!isset($row[$j]))
$schema_insert .= "NULL".$sep;
elseif ($row[$j] != "")
$schema_insert .= strip_tags("$row[$j]").$sep;
else
$schema_insert .= "".$sep;
}
$schema_insert = str_replace($sep."$", "", $schema_insert);

//this corrects output in excel when table fields contain \n or \r
//these two characters are now replaced with a space
$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
$schema_insert .= "\n";
//$schema_insert = (trim($schema_insert));
//echo $schema_insert;
//print "\n";

fwrite($fp, $schema_insert);
}
fclose($fp);

// your file to upload
$file = 'PrinceIVRMIS.xls';
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
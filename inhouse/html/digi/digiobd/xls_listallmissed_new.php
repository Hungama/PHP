<?php
include("session.php");
error_reporting(0);
//include database connection file
include("db.php");
$dtype=$_REQUEST['dtype'];
$today=date("Y-m-d");
if($dtype=='missedno')
{
$StartDate=$_REQUEST['sdate'];
if($StartDate != '')
{
$result = mysql_query("select a.ANI as ANI,a.date_time,a.DNIS as DNIS,a.circle as circle,a.operator as operator, b.customer_name as customer_name,b.town as town,b.verification_done as verification_done,b.memebership_card_dp as memebership_card_dp,b.memebership_card_rv as memebership_card_rv from newseleb_hungama.tbl_max_bupa_details as a LEFT JOIN newseleb_hungama.msdn_info as b ON  a.ANI=b.mobile_no WHERE  date(a.date_time) = '$StartDate'");
	}
else
{
$result = mysql_query("select a.ANI as ANI,a.date_time,a.DNIS as DNIS,a.circle as circle,a.operator as operator, b.customer_name as customer_name,b.town as town,b.verification_done as verification_done,b.memebership_card_dp as memebership_card_dp,b.memebership_card_rv as memebership_card_rv from newseleb_hungama.tbl_max_bupa_details as a LEFT JOIN newseleb_hungama.msdn_info as b ON  a.ANI=b.mobile_no WHERE  date(a.date_time) = '$today'");
}

//$result = mysql_query("SELECT name,email,phone,identity,id_details,city,registrationdate from registration");
//$sql = "Select computer_name,ipaddress,login_time,logout_time,user,id_type,id_details,total_price from transcation_paid";
//define date for title: EDIT this to create the time-format you need

$now_date = date('m-d-Y H:i:s');
//define title for .xls file: EDIT this if you want
$title = "allmissedcallnumbers";

//$result = @mysql_query($sql,$con);
//or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());


//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
$fp = fopen('allmissedcallnumbers.xls', "w");
$schema_insert = "";
$schema_insert_rows = "";
//start of printing column names as names of MySQL fields
for ($i = 0; $i < mysql_num_fields($result); $i++)
{
$schema_insert_rows.=mysql_field_name($result,$i) . "\t";
}
$schema_insert_rows.="\n";
$schema_insert_rows;
fwrite($fp, $schema_insert_rows);
//end of printing column names
//start while loop to get data
while($row = mysql_fetch_row($result))
{
//set_time_limit(60); // HaRa
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
//following fix suggested by Josue (thanks, Josue!)
//this corrects output in excel when table fields contain \n or \r
//these two characters are now replaced with a space
$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
$schema_insert .= "\n";
//$schema_insert = (trim($schema_insert));
//print $schema_insert .= "\n";
//print "\n";

fwrite($fp, $schema_insert);
}
fclose($fp);

// your file to upload
$file = 'allmissedcallnumbers.xls';
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
}
else if($dtype=='usages')
{

$result = mysql_query("select ANI,duration,operator,circle from hul_hungama.tbl_hulobd_success_fail_details group by ANI");

//$result = mysql_query("SELECT name,email,phone,identity,id_details,city,registrationdate from registration");
//$sql = "Select computer_name,ipaddress,login_time,logout_time,user,id_type,id_details,total_price from transcation_paid";
//define date for title: EDIT this to create the time-format you need

$now_date = date('m-d-Y H:i:s');
//define title for .xls file: EDIT this if you want
$title = "totalcallduration";

//$result = @mysql_query($sql,$con);
//or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());


//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
$fp = fopen('totalcallduration.xls', "w");
$schema_insert = "";
$schema_insert_rows = "";
//start of printing column names as names of MySQL fields
for ($i = 0; $i < mysql_num_fields($result); $i++)
{
$schema_insert_rows.=mysql_field_name($result,$i) . "\t";
}
$schema_insert_rows.="\n";
$schema_insert_rows;
fwrite($fp, $schema_insert_rows);
//end of printing column names



//start while loop to get data
while($row = mysql_fetch_row($result))
{
//set_time_limit(60); // HaRa
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
//following fix suggested by Josue (thanks, Josue!)
//this corrects output in excel when table fields contain \n or \r
//these two characters are now replaced with a space
$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
$schema_insert .= "\n";
//$schema_insert = (trim($schema_insert));
//print $schema_insert .= "\n";
//print "\n";

fwrite($fp, $schema_insert);
}
fclose($fp);

// your file to upload
$file = 'totalcallduration.xls';
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
}
else 
{
exit;
}
?>
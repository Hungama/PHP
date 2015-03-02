<?php
//include database connection file
include("db.php");
$checkfiletoprocess=mysql_query("select * from tbl_obdrecording_log order by batchid ASC");
$notorestore=mysql_num_rows($checkfiletoprocess);
echo "<table>";
while($row_file_info = mysql_fetch_array($checkfiletoprocess))
{
$obd_form_batchid=$row_file_info['batchid'];
$obd_form_mob_file=$row_file_info['odb_filename'];
$obd_form_circle=$row_file_info['circle'];
$obd_form_startdate=$row_file_info['startdate'];
$obd_form_enddate=$row_file_info['enddate'];
$status=$row_file_info['status'];
$prcocess_status=$row_file_info['prcocess_status'];
$filesize=$row_file_info['filesize'];

echo "<tr><td>".$obd_form_batchid."</td><td>".$obd_form_circle."</td><td>".$obd_form_circl."</td><td>".$obd_form_startdate."</td><td>".$obd_form_enddate."</td><td>".$status."</td><td>".$prcocess_status."</td><td>".$filesize."</td></tr>";
}//end of while
echo "</table>";
//close database connection
mysql_close($con);
?>
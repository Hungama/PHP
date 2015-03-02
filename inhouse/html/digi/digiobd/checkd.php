<?php
include("db.php");
//0102662994

$sql_chkdata="select * FROM TBL_User_OBD where ANI='0102662994'";
//$sql_chkdata="select * FROM db_obd.TBL_User_OBD limit 4";
//$sql_chkdata='select * FROM tbl_obdrecording_log';
//$sql_chkdata="select batchid,odb_filename,circle, startdate, enddate from tbl_obdrecording_log where status='' limit 1";
$result=mysql_query($sql_chkdata,$con);
//echo mysql_num_rows($result);
echo "<br>";
while($getdid=mysql_fetch_array($result))
{echo "1";
/*
echo $getdid['status']."@@".$getdid['uploadedby']."@@".$getdid['ipaddress']."@@".$getdid['odb_filename']."@@".$getdid['circle']."@@".$getdid['cli']."@@".$getdid['startdate']."@@".$getdid['enddate']."@@".$getdid['filesize']."<br>";*/
echo $getdid['StartDate']."@@".$getdid['EndDate']."@@".$getdid['Status']."@@".$getdid['Circle']."@@".$getdid['ANI']."<br>";
}
?>
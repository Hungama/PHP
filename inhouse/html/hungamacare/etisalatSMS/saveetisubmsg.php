<?php
include ("config/dbConnect.php");
$FilePath="/var/www/html/hungamacare/etisalatSMS/etis_sms.txt";
$insertDump= 'LOAD DATA LOCAL INFILE "'.$FilePath.'" INTO TABLE etislat_hsep.tbl_subunsub_msg FIELDS TERMINATED BY "#" LINES TERMINATED BY "\n" (plan_id,msg,type)';
if(mysql_query($insertDump,$dbConn))
{
echo "OK";
}
else
{
echo "NOK";
}
mysql_close($dbConn);
?>
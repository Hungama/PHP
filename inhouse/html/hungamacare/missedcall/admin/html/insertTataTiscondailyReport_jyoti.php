<?php

error_reporting(0);
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
///////////////////////////////////////////// code start for repeat and new @jyoti.porwal //////////////////////////////////////////////////////////
//for UU Repeat
echo $view_date1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$uu_tf = array();
echo $uu_tf_query = "select 'UU_Repeat',item.circle, count(distinct item.ANI) 
from Hungama_Tatasky.tbl_tata_pushobd item INNER JOIN(  SELECT ANI FROM Hungama_Tatasky.tbl_tata_pushobd  where date(date_time)<'$view_date1'
)temp ON item.ANI= temp.ANI where date(item.date_time)='$view_date1' group by item.circle";
$uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_tf_result);
if ($numRows4 > 0) {
    $uu_tf_result = mysql_query($uu_tf_query, $dbConn) or die(mysql_error());
    while ($uu_tf = mysql_fetch_array($uu_tf_result)) {
        echo $insert_uu_tf_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
        values('$view_date1', 'EnterpriseTiscon','$uu_tf[1]','$uu_tf[0]','$uu_tf[2]','')";
        $queryIns_uu = mysql_query($insert_uu_tf_data, $dbConn);
    }
}
//for UU New
$uu_total = array();
echo $uu_total_query = "select 'UU_New',item.circle, count(distinct item.ANI)
from Hungama_Tatasky.tbl_tata_pushobd item where date(item.date_time)='$view_date1' group by item.circle";
$uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
$numRows4 = mysql_num_rows($uu_total_result);
if ($numRows4 > 0) {
    $uu_total_result = mysql_query($uu_total_query, $dbConn) or die(mysql_error());
    while ($uu_total = mysql_fetch_array($uu_total_result)) {

        echo $repeat_query = "select  count(distinct item.ANI)
from Hungama_Tatasky.tbl_tata_pushobd item INNER JOIN(  SELECT ANI  FROM Hungama_Tatasky.tbl_tata_pushobd  where date(date_time)<'$view_date1'
)temp ON item.ANI= temp.ANI where date(item.date_time)='$view_date1' and circle='$uu_total[1]'";
        $repeat_query_exe = mysql_query($repeat_query, $dbConn) or die(mysql_error());
        $uu_repeat = mysql_fetch_array($repeat_query_exe);
        if ($uu_repeat[0] == '') {
            $uu_repeat[0] = 0;
        }
        $uu_new = $uu_total[2] - $uu_repeat[0];

        echo $insert_uu_total_data = "insert into Hungama_Tatasky.tbl_dailymis(Date,Service,Circle,Type,Value,Revenue)
        values('$view_date1', 'EnterpriseTiscon','$uu_total[1]','$uu_total[0]','$uu_new','')";
        $queryIns_uu = mysql_query($insert_uu_total_data, $dbConn);
    }
}
///////////////////////////////////////////// code end for repeat and new @jyoti.porwal //////////////////////////////////////////////////////////

echo "Done";

mysql_close($con);
?>
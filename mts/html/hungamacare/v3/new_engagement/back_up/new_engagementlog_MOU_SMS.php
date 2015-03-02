<?php
//master_db.tbl_new_sms_engagement,master_db.tbl_rule_engagement,master_db.tbl_engagement_number 
        
include ("/var/www/html/hungamacare/config/dbConnect.php");

$query = "select a.ANI,b.circle,c.message,a.type,a.service_id from master_db.tbl_engagement_number a ,master_db.tbl_rule_engagement b,master_db.tbl_new_sms_engagement c
            where  a.circle=b.circle and a.type = b.scenerios and a.added_on=date(now()) and b.id=c.rule_id and b.status=1";
            

$result = mysql_query($query, $dbConn) or die(mysql_error());

$result_row = mysql_num_rows($result);

if ($result_row > 0) {
    $delete_query = "delete from master_db.tbl_new_engagement_log where date(added_on) = date(now()) and type = '".$details[3]."' and service_id='".$details[4]."'";
    mysql_query($delete_query, $dbConn);
    while ($details = mysql_fetch_row($result)) {
        $insert_query = "insert into master_db.tbl_new_engagement_log (ANI,circle,added_on,service_id,type,message,status)
						   values (" . $details[0] . ",'" . $details[1] . "'," . "now(),'" . $details[4] . "','".$details[3]."','".$details[2]."',0)";
        mysql_query($insert_query, $dbConn);
    }
}

echo "Done";
// end call
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
    
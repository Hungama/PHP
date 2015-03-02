<?php

include("config/dbConnect.php");
///////////////////////////////////////// code start for getting current date and time from database @jyoti.porwal //////////////////////////////////////
$getCurrentTimeQuery = "select DATE_FORMAT(now(),'%Y-%m-%d %H:%i:00')";
$timequery2 = mysql_query($getCurrentTimeQuery, $dbConn);
$currentTime = mysql_fetch_row($timequery2);
$nowtime = $currentTime[0];
///////////////////////////////////////// code end for getting current date and time from database @jyoti.porwal //////////////////////////////////////
//////////////////////////////////////////////////// code start for update status @jyoti.porwal /////////////////////////////////////////////////////
echo $select_query = "select id,batch_id,scheduledOn from billing_intermediate_db.bulk_upload_history nolock where status=11 and upload_for ='event_unsub'
                      and scheduledOn='" . $nowtime . "'";
$query = mysql_query($select_query, $dbConn) or die(mysql_error());
$noofrows = mysql_num_rows($query);
if ($noofrows == 0) {
    $logData = 'No Record to process' . "\n\r";
    echo $logData;
    mysql_close($dbConn); //close database connection
    exit;
} else {
    while (list($id, $batch_id, $scheduledOn) = mysql_fetch_array($query)) {
        //if ($scheduledOn == $nowtime) {
        echo $update_bulk_history = "update billing_intermediate_db.bulk_upload_history set status=0 where batch_id=$batch_id and id=" . $id;
        $bulk_update_result = mysql_query($update_bulk_history, $dbConn) or die(mysql_error());
        //}// end of if
    } // end of while
}
//////////////////////////////////////////////////// code end for update status @jyoti.porwal /////////////////////////////////////////////////////
echo "done";
mysql_close($dbConn);
?>
